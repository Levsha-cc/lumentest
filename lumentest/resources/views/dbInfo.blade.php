@extends('layout')

@section('content')
    <h3>Таблицы:</h3>
    <table class="table table-bordered">
        <tr>
            <th>Имя таблицы</th>
            <th>Кол-во записей</th>
        </tr>
        @foreach($info as $name => $count)
            <tr>
                <td>{{ $name }}</td>
                <td>{{ $count }}</td>
            </tr>
        @endforeach
    </table>

    <a href="/db_import" class="btn btn-info">Импорировать логи</a>

@endsection
