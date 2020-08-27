<div class="text-center">
    <a @if (Route::currentRouteName() !== 'home') href="{{ route('home') }}" @endif>Home</a> |
    @if(session('current_report_id'))
        <a @if (Route::currentRouteName() !== 'work.show') href="{{ route('work.show', session('current_report_id')) }}" @endif>Work</a> |
    @else
        <a @if (Route::currentRouteName() !== 'work.show') href="{{ route('work.start') }}" @endif>Work</a> |
    @endif
    <a  @if (Route::currentRouteName() !== 'cards.learn') href="{{ route('cards.learn') }}" @endif>Learn New</a> |
    <a  @if (Route::currentRouteName() !== 'report.index') href="{{ route('report.index') }}" @endif>Reports</a>
</div>
<div class="text-center">© 2020 Alexandr Dubovis </div>
