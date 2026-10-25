<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{

    public function index()
    {
        // Fetch latest templates first
        $templates = EmailTemplate::orderBy('created_at', 'desc')->get();

        return view('admin.templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'subject' => 'required',
            'body'    => 'required'
        ]);

        EmailTemplate::create($request->all());
        return back()->with('success', 'Template saved successfully');
    }
}

