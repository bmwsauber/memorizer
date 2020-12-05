@extends('memocards::layouts.master')

@section('content')
    <div class="text-center m-3">
        <h1>Memo Cards</h1>
    </div>
    <main-statistic
        :sorted-cards="{{ json_encode($sortedCards) }}"
        :cards-amount="{{ @count($cards) }}"
        :right-sum="{{ $rightSum }}"
        :wrong-sum="{{ $wrongSum }}"
    ></main-statistic>
    <last-report-data
        :result-data="{{ json_encode($lastReportData['result']) }}"
        :last-report="{{ json_encode($lastReport) }}"
    ></last-report-data>
    <div class="text-center">
        <a class="btn btn-primary px-5 py-2 mb-2" href="{{ route('work.start') }}"><h4>Let's Start!</h4></a>
    </div>
@endsection
