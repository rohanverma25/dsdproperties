<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use League\Csv\Reader;

class LeadImportController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');

        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // first row = headers

        foreach ($csv as $record) {

            if (
                empty($record['email']) ||
                !filter_var($record['email'], FILTER_VALIDATE_EMAIL)
            ) {
                continue;
            }

            if (Lead::where('email', $record['email'])->exists()) {
                continue;
            }

            Lead::create([
                'name'     => $record['name'] ?? null,
                'email'    => $record['email'],
                'phone'    => $record['phone'] ?? null,
                'comments' => $record['comments'] ?? null,
                'url' => $record['url'] ?? null,
                'company_name'  => $record['company'] ?? null,
                'enquiry_date' => $record['time'] ?? null,
                'segment'  => !empty($record['comments']) ? $this->segment($record['comments']) : ($record['technology'] ?? null),
                'is_valid_email' => true,
            ]);
        }

        return back()->with('success', 'Leads imported successfully');
    }

private function segment(string $text): string
{
    $text = strtolower($text);

    $segments = [
        'web' => [
            'website', 'web site', 'webapp', 'web app',
            'wordpress', 'shopify', 'woocommerce', 'magento',
            'landing page', 'cms', 'wix', 'squarespace',
            'ecommerce', 'e-commerce', 'online store', 'website design'
        ],

        'mobile' => [
            'mobile app', 'app development', 'android', 'ios',
            'iphone', 'ipad', 'flutter', 'react native', 'apk'
        ],

        'crm' => [
            'crm', 'customer management', 'lead management',
            'salesforce', 'client management'
        ],

        'iot' => [
            'iot', 'nfc', 'rfid', 'sensor', 'smart device',
            'embedded', 'hardware integration'
        ],

        'ai' => [
            'ai', 'artificial intelligence', 'machine learning',
            'ml', 'chatbot', 'nlp', 'genai', 'llm'
        ],

        'software' => [
            'software', 'erp', 'saas', 'platform',
            'dashboard', 'management system', 'custom system'
        ],

        'career' => [
            'job', 'career', 'intern', 'internship',
            'training', 'hiring', 'resume'
        ],

        'marketing' => [
            'seo', 'guest post', 'backlink',
            'digital marketing', 'content writing'
        ],
    ];

    foreach ($segments as $segment => $keywords) {
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return $segment;
            }
        }
    }

    return 'general';
}

}
