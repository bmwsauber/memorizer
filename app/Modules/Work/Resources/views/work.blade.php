@extends('layout::layouts.master')

@section('content')
    <work-component
        :cards="{{ json_encode($cards) }}"
        :env-unique="{{ env('UNIQUE_LEVEL') }}"
        :mode="'{{ $mode }}'"
    ></work-component>
@endsection
