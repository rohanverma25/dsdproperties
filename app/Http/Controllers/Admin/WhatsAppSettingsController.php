<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaLabel;
use App\Models\WaQuickReply;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Quick replies and labels, editable without a deploy.
 *
 * Deliberately one page of small forms rather than two CRUD resources — there
 * will only ever be a handful of rows in each table.
 */
class WhatsAppSettingsController extends Controller
{
    public function index()
    {
        return view('admin.whatsapp.settings', [
            'replies' => WaQuickReply::orderBy('sort')->orderBy('id')->get(),
            'labels'  => WaLabel::orderBy('sort')->orderBy('id')->get(),
            'colours' => array_keys(WaLabel::COLOURS),
        ]);
    }

    /* ----------------------------------------------------------- quick replies */

    public function storeReply(Request $request)
    {
        $data = $this->validateReply($request);

        WaQuickReply::create($data + ['sort' => (int) WaQuickReply::max('sort') + 1]);

        return back()->with('success', 'Quick reply added.');
    }

    public function updateReply(Request $request, WaQuickReply $reply)
    {
        $reply->update($this->validateReply($request, $reply));

        return back()->with('success', 'Quick reply saved.');
    }

    public function destroyReply(WaQuickReply $reply)
    {
        $reply->delete();

        return back()->with('success', 'Quick reply removed.');
    }

    protected function validateReply(Request $request, ?WaQuickReply $reply = null): array
    {
        // Normalise before validating, so "/Rates" and "rates" collide as they
        // should — the model's mutator would otherwise strip the slash after
        // the unique rule had already passed.
        $request->merge([
            'shortcut' => strtolower(ltrim(trim((string) $request->input('shortcut')), '/')),
        ]);

        $data = $request->validate([
            'shortcut' => [
                'required', 'string', 'max:40', 'regex:/^[a-z0-9_-]+$/',
                Rule::unique('wa_quick_replies', 'shortcut')->ignore($reply?->id),
            ],
            'label'  => ['required', 'string', 'max:60'],
            'body'   => ['required', 'string', 'max:2000'],
            'active' => ['nullable', 'boolean'],
        ], [
            'shortcut.regex' => 'A shortcut may only use letters, numbers, hyphens and underscores.',
        ]);

        $data['active'] = $request->boolean('active');

        return $data;
    }

    /* ----------------------------------------------------------------- labels */

    public function storeLabel(Request $request)
    {
        $data = $this->validateLabel($request);

        WaLabel::create($data + ['sort' => (int) WaLabel::max('sort') + 1]);

        return back()->with('success', 'Label added.');
    }

    public function updateLabel(Request $request, WaLabel $label)
    {
        $label->update($this->validateLabel($request, $label));

        return back()->with('success', 'Label saved.');
    }

    public function destroyLabel(WaLabel $label)
    {
        // The pivot rows go with it, so chats simply lose the tag.
        $label->delete();

        return back()->with('success', 'Label removed from every chat.');
    }

    protected function validateLabel(Request $request, ?WaLabel $label = null): array
    {
        return $request->validate([
            'name'   => ['required', 'string', 'max:60', Rule::unique('wa_labels', 'name')->ignore($label?->id)],
            'colour' => ['required', Rule::in(array_keys(WaLabel::COLOURS))],
        ]);
    }
}
