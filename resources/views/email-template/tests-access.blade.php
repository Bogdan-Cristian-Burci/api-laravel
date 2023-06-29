@extends('email-template.layout')
@section('salutation')
    <h2 style="text-align: center">Salut {{$name}},</h2>
@endsection

@section('content')
    <p style="margin-bottom: 40px;">Îți confirmăm înregistrarea Comenzii plasate și încheierea Contractului la Distanță, împreună cu termenii și condițiile prevăzute în aplicația mobilă.</p>

    <p>Din acest moment ai acces la testele din aplicația <b>Întrebări asigurări</b>. Timp de 30 de zile, poți să faci oricâte teste vrei. Cu cât exersezi mai mult, cu atât mai mult îți vei fixa informațiile teoretice și vei avea o imagine clară a nivelului tău de performanță.</p>

    <p style="margin-top: 40px;">Dacă ai nevoie de mai multe informații, verifică rubrica Întrebări frecvente din Contul tău, iar dacă nu ai găsit răspunsul, atunci contactează-ne la <a href="mailto:suportclienti@profiduciaria.ro" style="text-decoration: none">suportclienti@profiduciaria.ro</a>.</p>
@endsection
