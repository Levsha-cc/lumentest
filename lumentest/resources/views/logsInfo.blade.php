@extends('layout')

@section('content')
    <h3>Логи</h3>
    <table class="table table-bordered">
        <tr>
            <th>filename</th>
            <th>size</th>
        </tr>
        @foreach($info as $name => $log)
            <tr>
                <td><a target="_blank" href="/{{ $name }}.log">{{ $name }}.log</a></td>

                <td>
                @if($log['size'])
                    {{ $log['size'] }} b
                @else
                    лог пуст
                @endif
                </td>
            </tr>
        @endforeach
    </table>

    <h4>Сгенерировать логи:</h4>
    <a href="/logs_create?c=25" class="btn btn-info">25 IP</a>
    <a href="/logs_create?c=50" class="btn btn-info">50 IP</a>
    <a href="/logs_create?c=100" class="btn btn-info">100 IP</a>
    <a href="/logs_create?c=200" class="btn btn-primary">200 IP</a>
    <a href="/logs_create?c=500" class="btn btn-info">500 IP</a>

    <hr />
    <a href="/db" class="btn btn-default">База данных</a>


@endsection
