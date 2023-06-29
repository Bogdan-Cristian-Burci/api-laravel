@extends('email-template.layout')
@section('salutation')
    <h2 style="text-align: center">Salut {{$name}},</h2>
@endsection

@section('content')
    <p style="margin-bottom: 40px;">Felicitari! Ti-ai creat cu succes contul in aplicatia mobila <b>Intrebari asigurari!</b> Din acest moment, din sectiunea Contul tau, vei putea:</p>

    <ul style="list-style-type: circle;text-align: left;">
        <li>sa vizualizezi statistici specifice activitatii tale;</li>
        <li>sa accesezi rubrica intrebari si raspunsuri frecvente;</li>
        <li>sa iti administrezi contul si adresa de mail;</li>
        <li>sa gestionezi abonarile tale;</li>
    </ul>

    <p style="margin-top: 40px;">Te asteptam cu drag sa ne scrii la <a href="mailto:suportclienti@profiduciaria.ro" style="text-decoration: none">suportclienti@profiduciaria.ro</a> , daca ai nevoie de asistenta privind contul tau.</p>
@endsection
