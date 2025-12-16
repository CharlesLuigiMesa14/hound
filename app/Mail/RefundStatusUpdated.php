<?php

namespace App\Mail;

use App\Models\ReturnRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $returnRequest;

    public function __construct(ReturnRequest $returnRequest)
    {
        $this->returnRequest = $returnRequest;
    }

    public function build()
    {
        return $this->subject('Your Refund Process is Complete')
                    ->view('emails.refund_status_updated');
    }
}