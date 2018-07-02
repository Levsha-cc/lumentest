@extends('layout')

@section('content')
    <h3>Логи:</h3>
    <ul>
        @foreach($info as $name => $log)
            <li>
                <a href="/{{ $name }}.log">{{ $name }}.log</a> -
                @if($log['size'])
                    {{ $log['size'] }} b
                @else
                    лог пуст
                @endif
            </li>
        @endforeach
    </ul>

    <a href="/logs_create" class="btn btn-info">Сгенерировать логи</a>


@endsection
