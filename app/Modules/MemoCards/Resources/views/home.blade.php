@extends('memocards::layouts.master')

@section('content')
    <div class="w-100">
        <a href="{{ route('cards.index') }}">Cards</a>
        <a href="{{ route('report.index') }}">Reports</a>
    </div>
    <div class="w-100">
        <h1 class="text-center">MemoCards</h1>
    </div>
    <div>
        <h3>total cards information</h3>
    </div>
    <ul>
        <li>Regular cards amount: <span class="amount">{{ @count($sortedCards['regular']) }}</span></li>
        <li>Magic cards amount: <span class="amount">{{ @count($sortedCards['magic']) }}</span></li>
        <li>Rare cards amount: <span class="amount">{{ @count($sortedCards['rare']) }}</span></li>
        <li>Unique cards amount: <span class="amount">{{ @count($sortedCards['unique']) }}</span></li>
        <li>Legendary cards amount: <span class="amount">{{ @count($sortedCards['legendary']) }}</span></li>
        <li>total cards amount: <span class="amount">{{ @count($cards) }}</span></li>
    </ul>
    <div class="text-center">
        <a href="{{ route('work.index') }}">Start!</a>
    </div>
@endsection
