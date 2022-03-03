<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendEmailAccountRegistration extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;

    public function __construct($getMessage)
    {
        $this->message = $getMessage;
    }


    public function build()
    {
        $companyEmail    = 'info@myjobonthego.com';
        $companyName     = 'myjobonthego.com';
        //
        return $this->from($companyEmail, $companyName)
                    ->subject('Your account has been created')
                    ->markdown('Mails.accountRegistrationTemplate')
                    //->view('message')
                    ->with($this->message);
    }


}//end class
