@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm">

                <h3><a href="/logs">Логи:</a></h3>
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

            </div>
            <div class="col-sm">

                <h3><a href="/db">Таблицы:</a></h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Имя таблицы</th>
                        <th>Кол-во записей</th>
                    </tr>
                    @foreach($dbInfo as $name => $count)
                        <tr>
                            <td>{{ $name }}</td>
                            <td>{{ $count }}</td>
                        </tr>
                    @endforeach
                </table>

                <a href="/db_import" class="btn btn-info">Импорировать логи</a>

            </div>
        </div>
    </div>

@endsection
