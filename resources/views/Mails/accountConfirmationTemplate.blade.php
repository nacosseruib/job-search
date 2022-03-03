@component('mail::message')

Hello <b> {{ $clientName }} !</b>, <br />
{{ $clientCompanyName }}

We are happy to tell you that your account has been activated.

 <br />

<span class="text-success">
    You can login to your account with any of these details below: <br />
    Email Address: {{ $clientEmail}} OR <br />
    Username: {{ $clientUsername}} 
     <br />
    @component('mail::button', ['url' => 'https://'. $_SERVER["HTTP_HOST"] .'/account/login'])
    
    Login To Your Account Now 

    @endcomponent
</span>


<br />

 Thanks<br />

 Best Regards,<br />
 AfriDiD

@endcomponent
