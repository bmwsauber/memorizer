@extends('memocards::layouts.master')

@section('content')
    <work-component :cards="{{ json_encode($cards) }}"
    ></work-component>
@endsection
