<?php

namespace App\Mail;

use App\Models\ReturnRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReturnStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $returnRequest;

    public function __construct(ReturnRequest $returnRequest)
    {
        $this->returnRequest = $returnRequest;
    }

    public function build()
    {
        return $this->subject('Return Request Status Updated')
                    ->view('emails.return_status_updated');
    }
}