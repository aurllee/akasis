@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Tata Tertib</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Poin Pelanggaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tatib as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->jenis_pelanggaran }}</td>
                        <td>{{ $item->poin_pelanggaran }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection