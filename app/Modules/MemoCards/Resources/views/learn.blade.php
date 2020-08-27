@extends('memocards::layouts.master')

@section('content')
    <div class="learn-table">
        <table>
            @foreach($newCards as $card)
                <tr>
                    <td>{{ $card->eng }}</td>
                    <td>{{ $card->rus }}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection

