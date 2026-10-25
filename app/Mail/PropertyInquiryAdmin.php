<?php

namespace App\Mail;

use App\Models\PropertyListing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyInquiryAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
    public PropertyListing $listing;

    public function __construct(array $data, PropertyListing $listing)
    {
        $this->data    = $data;
        $this->listing = $listing;
    }

    public function build()
    {
        return $this->subject('🔥 New Property Inquiry – ' . $this->listing->title)
                    ->view('emails.property_inquiry_admin');
    }
}
