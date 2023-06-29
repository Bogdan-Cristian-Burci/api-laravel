@extends('email-template.layout')
@section('salutation')
    <h2 style="text-align: center">Salut {{$name}},</h2>
@endsection

@section('content')
    <p style="margin-bottom: 40px;">Tocmai am primit o cerere de resetarea parolei contului în aplicația Întrebări asigurări, asociat cu această adresă de email.</p>

    <p>Codul tau pentru resetarea parolei este {{$token}}</p>

    <p style="margin-top: 40px;">Te asteptam cu drag sa ne scrii la <a href="mailto:suportclienti@profiduciaria.ro" style="text-decoration: none">suportclienti@profiduciaria.ro</a> , daca ai nevoie de asistenta privind contul tau.</p>
@endsection
