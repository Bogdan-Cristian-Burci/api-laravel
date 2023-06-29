@component('email::message')
Resetare parola

Buna {{$userName}}

    Codul tau pentru resetarea parolei este {{$token}}

Multumesc,<br>
    {{ config('app.name') }}
@endcomponent
