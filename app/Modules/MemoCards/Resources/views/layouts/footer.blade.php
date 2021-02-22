<div class="text-center pt-7">
    <a @if (Route::currentRouteName() !== 'home') href="{{ route('home') }}" @endif>Home</a> |
    @if(session('current_report_id'))
        <a @if (Route::currentRouteName() !== 'work.repeat') href="{{ route('work.repeat', session('current_report_id')) }}" @endif>Repeat</a> |
        <a @if (Route::currentRouteName() !== 'work.listening') href="{{ route('work.listening', session('current_report_id')) }}" @endif>Listening</a> |
        <a @if (Route::currentRouteName() !== 'work.idioms') href="{{ route('work.idioms', session('current_report_id')) }}" @endif>Idioms</a> |
    @else
        <a @if (Route::currentRouteName() !== 'work.repeat') href="{{ route('work.start', 'repeat') }}" @endif>Repeat</a> |
        <a @if (Route::currentRouteName() !== 'work.listening') href="{{ route('work.start', 'listening') }}" @endif>Listening</a> |
        <a @if (Route::currentRouteName() !== 'work.idioms') href="{{ route('work.start', 'idioms') }}" @endif>Idioms</a> |
    @endif
    <a  @if (Route::currentRouteName() !== 'cards.learn') href="{{ route('cards.learn') }}" @endif>Learn New</a> |
    <a  @if (Route::currentRouteName() !== 'numbers.show') href="{{ route('numbers.show') }}" @endif>Numbers</a> |
    <a  @if (Route::currentRouteName() !== 'report.index') href="{{ route('report.index') }}" @endif>Reports</a>
</div>
<div class="text-center font-medium mt-1 pb-3">© 2021 Alexandr Dubovis </div>
