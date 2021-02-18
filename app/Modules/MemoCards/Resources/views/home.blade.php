@extends('memocards::layouts.master')

@section('content')
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
    <div class="buttons text-white mt-10 flex justify-center">
        <a href="{{ route('work.start', 'repeat') }}" class="bg-teal-100 hover:bg-teal-200 px-16 py-2 mx-3 rounded">Repeat</a>
        <a href="{{ route('work.start', 'listening') }}" class="bg-teal-100 hover:bg-teal-200 px-16 py-2 mx-3 rounded">Listening</a>
    </div>
@endsection
