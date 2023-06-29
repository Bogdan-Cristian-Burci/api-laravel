@extends('email-template.layout')
@section('salutation')
    <h2 style="text-align: center">Salut {{$name}},</h2>
@endsection

@section('content')
    <p style="margin-bottom: 40px;">Bine te-am regăsit!</p>

    <p>Timpul a trecut repede și cele 30 de zile alocate sesiunii de testare din aplicația <b>Întrebări asigurări</b>, pentru urmatoarele teste, au expirat:</p>

    @if(is_array($trainings) && count($trainings)>0 )
        <ul style="list-style-type: circle; text-align: left;">
            @foreach($trainings as $training)
                <li>{{$training["category"]}} - {{$training["type"]}}</li>
            @endforeach
        </ul>
    @endif

    <p>Din acest moment, nu mai ai acces la aceste teste in aplicație. </p>

    <p style="margin-top: 40px;">Vrem să ne bucurăm împreună de succesul tău așa că, dacă vrei să continui sesiunea de testare, te rugăm să achiziționezi o nouă sesiune cu teste nelimitate.</p>
@endsection
