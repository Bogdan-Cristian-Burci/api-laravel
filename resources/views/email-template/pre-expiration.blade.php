@extends('email-template.layout')
@section('salutation')
    <h2 style="text-align: center">Salut {{$name}},</h2>
@endsection

@section('content')
    <p style="margin-bottom: 40px;">Bine te-am regăsit!</p>

    <p>Profită la maxim de timpul pe care îl mai ai până la expirarea sesiunilor de testare prezentate mai jos.În 5 zile poți muta munții din loc!</p>

    @if(is_array($trainings) && count($trainings)>0 )
        <ul style="list-style-type: circle; text-align: left;">
            @foreach($trainings as $training)
                <li>{{$training["category"]}} - {{$training["type"]}}</li>
            @endforeach
        </ul>
    @endif
    <p>  </p>

    <p style="margin-top: 40px;">Intră în aplicația <b>Întrebări Asigurări</b> și evaluează-ți cunoștințele! Cu cât mai mult teste efectuate, cu atât mai multe șanse pentru a-ți crește performanțele.</p>
@endsection
