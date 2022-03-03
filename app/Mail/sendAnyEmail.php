<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendAnyEmail extends Mailable
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
        $title           = ($this->message['title'] ? $this->message['title'] : substr($this->message['message'], 0, 50));
        //
        return $this->from($companyEmail, $companyName)
                    ->subject($title)
                    ->markdown('Mails.sendAnyEmailTemplate')
                    ->with($this->message);
    }


}//end class
