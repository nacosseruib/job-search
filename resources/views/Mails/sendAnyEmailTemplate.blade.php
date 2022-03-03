@component('mail::message')

Hello <b> {{ $name }} !</b>, <br />
{{ $name_company }}

 <br />

<span class="text-success">
    {!! $message !!}
</span>

<br />
    @component('mail::button', ['url' => 'https://'. $_SERVER["HTTP_HOST"] .'/ticket-status'])
    
    Login To Your Account Now 

    @endcomponent

<br />

 Thanks<br />

 Best Regards,<br />
 AfriDiD

@endcomponent
