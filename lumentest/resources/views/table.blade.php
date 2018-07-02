@extends('layout')

@section('content')
    <h3>Таблица:</h3>
    <table class="table table-bordered">
        <tr>
            <th>IP</th>
            <th>Browser</th>
            <th>OS</th>
            <th>First url_from</th>
            <th>Last url_to</th>
            <th>Кол-во визитов</th>
        </tr>
        @foreach($data as $row)
            <tr>
                <td>{{ $row->ip }}</td>
                <td>{{ $row->browser }}</td>
                <td>{{ $row->os }}</td>
                <td>{{ $row->url_from }}</td>
                <td>{{ $row->url_to }}</td>
                <td>{{ $row->count }}</td>
            </tr>
        @endforeach
    </table>




@endsection
