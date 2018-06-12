@extends('layouts/master')

@section('content')

    @javascript(compact('pusherKey'))

    <div class="dashboard" id="dashboard">
        <newsletter grid="a1:a2" class="draggable"></newsletter>
        <social-media grid="a3" class="draggable"></social-media>
        <google-analytics grid="c2:c3" class="draggable"></google-analytics>
        <google-calendar grid="b1:b2" class="draggable"></google-calendar>
        <pipedrive grid="e2:e3" class="draggable"></pipedrive>
        <google-trends grid="b3" class="draggable"></google-trends>
        <current-time grid="c1" dateformat="ddd DD/MM" class="draggable"></current-time>
        <twitter initial-tweets="{{ json_encode($initialTweets) }}" grid="d1:d3" class="draggable"></twitter>
        <rain-forecast grid="e1" class="draggable"></rain-forecast>
        {{-- <last-fm grid="e1" class="draggable"></last-fm> --}}
    </div>

@endsection
