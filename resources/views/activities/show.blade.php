@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1>

    <p>{{ $activity->description }}</p>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kode: {{ $activity->code }}</p>
    <p>Kategori: {{ $activity->category->name }}</p>
    <p>Status: {{ $activity->status }}</p>

    <a href="{{ route('activities.edit', $activity) }}">Edit</a>
    <a href="{{ route('activities.index') }}">Kembali</a>
@endsection