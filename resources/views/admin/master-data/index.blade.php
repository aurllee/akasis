@extends('layouts.app')

@section('title', 'Master Data')

@section('content')

<div class="card">
    <h1>Master Data</h1>
    <p>Kelola data utama sistem akademik sekolah.</p>

    <ul>
        <li><a href="{{ route('jurusan.index') }}">Master Jurusan</a></li>
        <li><a href="{{ route('ruangan.index') }}">Master Ruangan</a></li>
        <li><a href="{{ route('mata_pelajaran.index') }}">Master Mata Pelajaran</a></li>
        <li><a href="{{ route('tahun-ajaran.index') }}">Master Tahun Ajaran</a></li>
        <li><a href="{{ route('siswa.index') }}">Master Siswa</a></li>
        <li><a href="{{ route('guru.index') }}">Master Guru</a></li>
        <li><a href="{{ route('kelas.index') }}">Master Kelas</a></li>
    </ul>
</div>

@endsection