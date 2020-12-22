@extends('memocards::layouts.master')

@section('content')
    <work-component
        :cards="{{ json_encode($cards) }}"
        :env-unique="{{ env('UNIQUE_LEVEL') }}"
    ></work-component>
@endsection
