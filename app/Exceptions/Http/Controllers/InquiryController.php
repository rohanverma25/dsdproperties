<?php
namespace App\Http\Controllers;
use App\Models\InquiryForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\EbookFormSubmitted;
use App\Mail\AdminInquiryNotification;

class InquiryController extends Controller
{
public function submit(Request $request)
{
    try {
        $validated = $request->validate([
            'full_name' => 'required|string|min:2|max:255',
            'phone_number' => 'required|string|digits_between:10,20',
            'email' => 'required|email',
            'message' => 'nullable|string|max:1000',
            'page_url' => 'nullable|url'
        ]);

        InquiryForm::create([
            'form_name' => 'Ebook Form',
            'params' => json_encode($validated),
        ]);

                // ✅ Send Email to Client
            Mail::to($validated['email'])
            ->queue(new EbookFormSubmitted($validated));

        Mail::to('dheer725@gmail.com')
            ->queue(new AdminInquiryNotification($validated));

        return response()->json(['success' => true]);

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'success' => false,
            'errors' => $e->validator->errors()
        ], 422);

    } catch (\Exception $e) {

        Log::error('Ebook form submission failed: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

 public function subscribe(Request $request)
    {
        // $validated = $request->validate([
        //     'email' => 'required|email',
        // ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'This email is already subscribed or invalid.'], 422);
        }

        // Save to DB (optional)
        InquiryForm::create([
            'form_name' => 'Newsletter',
            'params' => json_encode($request->only('email'))
        ]);

        return response()->json(['message' => 'Thank you for subscribing!']);
    }

public function ShowContcatUs(){
    return view('pages.contact-us');
}
}
