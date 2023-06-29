@extends('email-template.layout')
@section('salutation')
    <h2 style="text-align: center">Salut {{$name}},</h2>
@endsection

@section('content')
    <p style="margin-bottom: 40px;">Vrem sa fim siguri ca vom intra in legatura cu tine, de aceea te rugam sa confirmi ca adresa de email este cea pe care ne-ai indicat-o.</p>

    <a href="{{$url}}" style="padding: 10px 30px; border-radius: 8px;color:#000000;background-color:#F79901; text-decoration: none;font-weight: bold;"> Confirma e-mail</a>

    <p style="margin-top: 40px;">Dacă nu tu ai făcut cerearea de resetare a parolei, ignoră acest mesaj! Fii fără grji, contul tău este în siguranță!</p>
@endsection
