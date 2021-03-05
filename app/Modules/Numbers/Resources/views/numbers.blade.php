@extends('layout::layouts.master')

@section('content')
    <numbers-component
        :min="1"
        :max="100"
    ></numbers-component>
@endsection
