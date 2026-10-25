<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class RentReceiptController extends Controller
{
    public function generate(Request $request)
    {
        $data = $request->validate([
            'tenant_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'rent_amount' => 'required|numeric|min:1',
            'owner_pan' => 'required|string|max:10',
            'rented_property_address' => 'required|string',
            'owner_address' => 'required|string',
            'receipt_start_date' => 'required|date',
            'receipt_end_date' => 'required|date|after_or_equal:receipt_start_date',
        ]);

        // PDF generation
        $pdf = PDF::loadView('pages.rent-recepints-pdf', compact('data'));
        return $pdf->download('Rent_Receipt.pdf');
    }
}
