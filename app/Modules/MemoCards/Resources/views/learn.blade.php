@extends('memocards::layouts.master')

@section('content')
    <learn-component :cards="{{ json_encode($cards) }}"
    ></learn-component>
@endsection
