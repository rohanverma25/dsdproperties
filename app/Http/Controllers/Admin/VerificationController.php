<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerificationReport;
use App\Models\VerificationFinding;
use App\Models\VerificationEvidence;
use App\Services\VerificationPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    public function __construct(private VerificationPdfService $pdfService) {}

    // ── Auth ──────────────────────────────────────────────────────────────

    public function loginForm()
    {
        if (session('ver_admin_authenticated')) {
            return redirect()->route('ver.admin.index');
        }
        return view('admin.verifications.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required']);

        $correct = config('app.ver_admin_password', env('VER_ADMIN_PASSWORD', 'dsd@admin2026'));

        if ($request->password !== $correct) {
            return back()->withErrors(['password' => 'गलत पासवर्ड।'])->withInput();
        }

        $request->session()->put('ver_admin_authenticated', true);
        return redirect()->route('ver.admin.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('ver_admin_authenticated');
        return redirect()->route('ver.admin.login');
    }

    // ── Index ─────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = VerificationReport::query();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $reports = $query->latest()->paginate(20)->withQueryString();

        return view('admin.verifications.index', compact('reports'));
    }

    // ── Create / Store ────────────────────────────────────────────────────

    public function create()
    {
        return view('admin.verifications.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|digits:10',
            'customer_email'   => 'nullable|email|max:255',
            'property_address' => 'required|string',
            'property_khasra'  => 'nullable|string|max:100',
            'property_gata'    => 'nullable|string|max:100',
            'property_area'    => 'required|string|max:100',
            'property_type'    => 'required|in:plot,flat,house,commercial',
            'seller_name'      => 'required|string|max:255',
            'asking_price'     => 'nullable|integer|min:0',
            'tehsil'           => 'required|in:sadar,bkt,mohanlalganj,malihabad,other',
            'verifier_name'    => 'nullable|string|max:255',
            'verifier_visit_date' => 'nullable|date',
            'notes'            => 'nullable|string',
        ]);

        $report = VerificationReport::create($data);

        // Pre-seed all 9 findings with default text from config
        $checks = config('verification_checks');
        foreach ($checks as $check) {
            VerificationFinding::create([
                'verification_report_id' => $report->id,
                'check_slug'             => $check['slug'],
                'status'                 => 'clear',
                'what_checked_hindi'     => $check['what_checked_default'],
                'where_checked_hindi'    => $check['location_hindi'],
                'findings_hindi'         => '',
                'order'                  => $check['order'],
            ]);
        }

        return redirect()->route('ver.admin.edit', $report)
            ->with('success', 'रिपोर्ट बनाई गई: ' . $report->report_id);
    }

    // ── Edit / Update (basic info) ────────────────────────────────────────

    public function edit(VerificationReport $report)
    {
        $report->load(['findings', 'evidences']);
        $checks     = config('verification_checks');
        $findings   = $report->findings->keyBy('check_slug');
        $fontsReady = $this->pdfService->fontsReady();

        return view('admin.verifications.edit',
            compact('report', 'checks', 'findings', 'fontsReady'));
    }

    public function update(Request $request, VerificationReport $report)
    {
        $data = $request->validate([
            'customer_name'       => 'required|string|max:255',
            'customer_phone'      => 'required|digits:10',
            'customer_email'      => 'nullable|email|max:255',
            'property_address'    => 'required|string',
            'property_khasra'     => 'nullable|string|max:100',
            'property_gata'       => 'nullable|string|max:100',
            'property_area'       => 'required|string|max:100',
            'property_type'       => 'required|in:plot,flat,house,commercial',
            'seller_name'         => 'required|string|max:255',
            'asking_price'        => 'nullable|integer|min:0',
            'tehsil'              => 'required|in:sadar,bkt,mohanlalganj,malihabad,other',
            'verifier_name'       => 'nullable|string|max:255',
            'verifier_visit_date' => 'nullable|date',
            'notes'               => 'nullable|string',
        ]);

        $report->update($data);
        // Update pdf_password if phone changed
        $report->update(['pdf_password' => substr($data['customer_phone'], -4)]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'जानकारी सहेजी गई ✓']);
        }

        return back()->with('success', 'बुनियादी जानकारी अपडेट की गई।');
    }

    // ── Findings ──────────────────────────────────────────────────────────

    public function saveFinding(Request $request, VerificationReport $report, string $slug)
    {
        $data = $request->validate([
            'status'              => 'required|in:clear,note,issue,not_applicable',
            'what_checked_hindi'  => 'nullable|string',
            'where_checked_hindi' => 'nullable|string',
            'visit_date'          => 'nullable|date',
            'visit_time'          => 'nullable|string|max:20',
            'findings_hindi'      => 'nullable|string',
            'red_flags_hindi'     => 'nullable|string',
        ]);

        $finding = VerificationFinding::where('verification_report_id', $report->id)
            ->where('check_slug', $slug)
            ->first();

        if (! $finding) {
            return response()->json(['success' => false, 'message' => 'Finding not found'], 404);
        }

        $finding->update($data);

        // Promote report status to in_progress if still draft
        if ($report->status === 'draft') {
            $report->update(['status' => 'in_progress']);
        }

        return response()->json(['success' => true, 'message' => 'सहेजा गया ✓']);
    }

    // ── Evidence ──────────────────────────────────────────────────────────

    public function uploadEvidence(Request $request, VerificationReport $report)
    {
        $request->validate([
            'file'                 => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'document_type'        => 'required|string|max:255',
            'document_type_hindi'  => 'required|string|max:255',
            'source_office_hindi'  => 'required|string|max:500',
            'extracted_by'         => 'required|string|max:255',
            'extracted_on'         => 'required|date',
            'page_count'           => 'nullable|integer|min:1',
            'notes'                => 'nullable|string',
            'check_slug'           => 'nullable|string',
        ]);

        // Generate next evidence code for this report
        $count = $report->evidences()->count() + 1;
        $code  = sprintf('E-%02d', $count);

        // Store file
        $file      = $request->file('file');
        $safeName  = $code . '_' . \Illuminate\Support\Str::slug($request->document_type) . '.' . $file->getClientOriginalExtension();
        $path      = $file->storeAs("private/evidences/{$report->report_id}", $safeName);

        // Resolve associated finding
        $findingId = null;
        if ($request->check_slug) {
            $finding = VerificationFinding::where('verification_report_id', $report->id)
                ->where('check_slug', $request->check_slug)
                ->first();
            if ($finding) {
                $findingId = $finding->id;
                $finding->update(['evidence_reference' => $code]);
            }
        }

        VerificationEvidence::create([
            'verification_report_id' => $report->id,
            'verification_finding_id'=> $findingId,
            'evidence_code'          => $code,
            'document_type'          => $request->document_type,
            'document_type_hindi'    => $request->document_type_hindi,
            'source_office_hindi'    => $request->source_office_hindi,
            'extracted_by'           => $request->extracted_by,
            'extracted_on'           => $request->extracted_on,
            'file_path'              => $path,
            'file_mime'              => $file->getMimeType(),
            'file_name'              => $file->getClientOriginalName(),
            'file_size'              => $file->getSize(),
            'page_count'             => $request->page_count ?? 1,
            'notes'                  => $request->notes,
            'order'                  => $count,
        ]);

        return response()->json(['success' => true, 'code' => $code, 'message' => 'साक्ष्य अपलोड किया गया: ' . $code]);
    }

    public function deleteEvidence(VerificationReport $report, VerificationEvidence $evidence)
    {
        Storage::disk('local')->delete($evidence->file_path);
        $evidence->delete();

        return response()->json(['success' => true, 'message' => 'साक्ष्य हटाया गया।']);
    }

    public function downloadEvidence(VerificationReport $report, VerificationEvidence $evidence)
    {
        $path = storage_path('app/' . $evidence->file_path);
        abort_unless(file_exists($path), 404);

        return response()->download($path, $evidence->file_name);
    }

    // ── PDF ───────────────────────────────────────────────────────────────

    public function generatePdf(Request $request, VerificationReport $report)
    {
        $request->validate([
            'verdict'               => 'required|in:green,amber,red',
            'verdict_summary_hindi' => 'required|string',
        ]);

        $report->update([
            'verdict'               => $request->verdict,
            'verdict_summary_hindi' => $request->verdict_summary_hindi,
        ]);

        $report->load(['findings', 'evidences']);

        try {
            $path = $this->pdfService->generate($report);
            return response()->json([
                'success' => true,
                'message' => 'PDF सफलतापूर्वक बनाई गई।',
                'status'  => 'ready_to_deliver',
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PDF generation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'PDF निर्माण विफल: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function downloadPdf(VerificationReport $report)
    {
        abort_unless($report->pdf_path, 404, 'PDF अभी तक नहीं बनाई गई।');
        $path = storage_path('app/' . $report->pdf_path);
        abort_unless(file_exists($path), 404, 'PDF फ़ाइल नहीं मिली।');

        return response()->download($path, $report->report_id . '.pdf');
    }

    public function statusCheck(VerificationReport $report)
    {
        return response()->json([
            'status'   => $report->status,
            'pdf_path' => $report->pdf_path ? true : false,
        ]);
    }

    // ── Delivery ──────────────────────────────────────────────────────────

    public function deliver(Request $request, VerificationReport $report)
    {
        $request->validate([
            'delivery_channel' => 'required|in:whatsapp,email,both',
        ]);

        $report->update([
            'status'           => 'delivered',
            'delivered_at'     => now(),
            'delivery_channel' => $request->delivery_channel,
        ]);

        // Generate a 30-day signed download URL
        $signedUrl = URL::temporarySignedRoute(
            'ver.download.signed',
            now()->addDays(30),
            ['report' => $report->report_id]
        );

        $verdictHindi = $report->verdict_label;
        $addressShort = $report->property_address_short;
        $firstName    = $report->customer_first_name;

        $waMessage = urlencode(
            "नमस्ते {$report->customer_name} जी,\n\n" .
            "आपकी संपत्ति सत्यापन रिपोर्ट तैयार है।\n\n" .
            "रिपोर्ट आईडी: {$report->report_id}\n" .
            "संपत्ति: {$addressShort}\n" .
            "निर्णय: {$verdictHindi}\n\n" .
            "रिपोर्ट डाउनलोड करें (30 दिन तक वैध):\n{$signedUrl}\n\n" .
            "पासवर्ड: आपके फ़ोन नंबर के अंतिम 4 अंक ({$report->pdf_password})\n\n" .
            "सत्यापन जांचें: https://dsdproperties.in/verify/{$report->report_id}\n\n" .
            "धन्यवाद,\nDSD Properties\n+91-85950-02933"
        );

        $waLink = "https://wa.me/91{$report->customer_phone}?text={$waMessage}";

        return response()->json([
            'success'    => true,
            'wa_link'    => $waLink,
            'signed_url' => $signedUrl,
            'message'    => 'रिपोर्ट वितरित के रूप में चिह्नित की गई।',
        ]);
    }

    // ── Signed customer download (no auth) ───────────────────────────────

    public function downloadSigned(Request $request, string $reportId)
    {
        abort_unless($request->hasValidSignature(), 403, 'यह लिंक समाप्त हो गया है या अमान्य है।');

        $report = VerificationReport::where('report_id', $reportId)->firstOrFail();
        abort_unless($report->pdf_path, 404, 'रिपोर्ट उपलब्ध नहीं है।');

        $path = storage_path('app/' . $report->pdf_path);
        abort_unless(file_exists($path), 404);

        return response()->download($path, $report->report_id . '.pdf');
    }

    // ── Font Setup ────────────────────────────────────────────────────────

    public function setupFonts()
    {
        $results = $this->pdfService->downloadFonts();
        return response()->json([
            'success' => ! in_array(false, array_map(fn($v) => $v !== 'failed', array_values($results))),
            'results' => $results,
        ]);
    }
}
