<div class="text-center">
    <a @if (Route::currentRouteName() !== 'home') href="{{ route('home') }}" @endif>Home</a> |
    <a @if (Route::currentRouteName() !== 'work.index') href="{{ route('work.index') }}" @endif>Work</a> |
    <a  @if (Route::currentRouteName() !== 'report.index') href="{{ route('report.index') }}" @endif>Reports</a>
</div>
<div class="text-center">© 2020 Alexandr Dubovis </div>
