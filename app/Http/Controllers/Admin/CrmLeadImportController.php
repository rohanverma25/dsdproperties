<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrmLead;
use Illuminate\Http\Request;
use League\Csv\Reader;

class CrmLeadImportController extends Controller
{
    /** Lead columns an uploaded CSV column can be mapped onto. */
    public const MAPPABLE = [
        'name'            => 'Name',
        'phone'           => 'Phone',
        'alt_phone'       => 'Alt phone',
        'source_page'     => 'Source page',
        'source_channel'  => 'Source channel',
        'intent'          => 'Intent',
        'scheme_interest' => 'Scheme',
        'area'            => 'Area',
        'budget_min'      => 'Budget min',
        'budget_max'      => 'Budget max',
        'notes'           => 'Notes',
    ];

    public function form()
    {
        return view('admin.crm.leads.import', [
            'headers'  => session('crm_import_headers'),
            'mappable' => self::MAPPABLE,
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file'             => ['required', 'file', 'mimes:csv,txt'],
            'map'              => ['required', 'array'],
            'map.phone'        => ['required', 'string'],
            'next_followup_at' => ['required', 'date'],
        ], [
            'map.phone.required'        => 'You must map the phone column.',
            'next_followup_at.required' => 'A follow-up date is required for imported leads.',
        ]);

        $csv = Reader::createFromPath($request->file('file')->getRealPath(), 'r');
        $csv->setHeaderOffset(0);

        // Only the columns the user actually mapped.
        $map = array_filter($request->input('map'), fn ($col) => filled($col));

        $imported = 0;
        $skipped  = 0;

        foreach ($csv->getRecords() as $record) {
            $row   = [];
            foreach ($map as $field => $column) {
                $row[$field] = isset($record[$column]) && $record[$column] !== '' ? trim($record[$column]) : null;
            }

            $phone = CrmLead::normalisePhone($row['phone'] ?? null);

            if (strlen($phone) < 10 || CrmLead::withTrashed()->where('phone', $phone)->exists()) {
                $skipped++;
                continue;
            }

            $row['phone'] = $phone;
            $row['name']  = $row['name'] ?: 'Unnamed';

            if (! empty($row['alt_phone'])) {
                $row['alt_phone'] = CrmLead::normalisePhone($row['alt_phone']);
            }

            foreach (['source_channel' => CrmLead::CHANNELS, 'intent' => CrmLead::INTENTS] as $field => $allowed) {
                if (! empty($row[$field]) && ! in_array($row[$field], $allowed, true)) {
                    $row[$field] = null;
                }
            }

            $row['stage']            = 'new';
            $row['next_followup_at'] = $request->input('next_followup_at');

            CrmLead::create($row);
            $imported++;
        }

        return redirect()
            ->route('admin.crm.leads.import.form')
            ->with('success', "Imported {$imported} leads, skipped {$skipped} (duplicate or invalid number).");
    }

    /** Step 1 — read just the header row so the user can map columns. */
    public function headers(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt']]);

        $csv = Reader::createFromPath($request->file('file')->getRealPath(), 'r');
        $csv->setHeaderOffset(0);

        return back()->with('crm_import_headers', $csv->getHeader());
    }
}
