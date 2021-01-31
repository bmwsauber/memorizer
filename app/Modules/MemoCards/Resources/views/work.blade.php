@extends('memocards::layouts.master')

@section('content')
    <work-component
        :cards="{{ json_encode($cards) }}"
        :env-unique="{{ env('UNIQUE_LEVEL') }}"
        :listening-mode=true
    ></work-component>
@endsection
