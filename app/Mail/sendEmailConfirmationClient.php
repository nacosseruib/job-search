<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendEmailConfirmationClient extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;

    /*public function __construct(Request $request)
    {
        $message = $request;
    }*/

    public function __construct($getMessage)
    {
        $this->message = $getMessage;
    }


    public function build()
    {
        $companyEmail    = 'info@afridid.com';
        $companyName     = 'AfriDiD';
        //
        return $this->from($companyEmail, $companyName)
                    ->subject('Your account has been activated')
                    ->markdown('Mails.accountConfirmationTemplate')
                    ->with($this->message);
    }


}//end class
