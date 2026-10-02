@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1>

    <p>{{ $activity->description }}</p>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kode: {{ $activity->code }}</p>
    <p>Kategori: {{ $activity->category->name }}</p>
    <p>Status: {{ $activity->status }}</p>

    @if ($activity->status === 'draft')
        <form action="{{ route('activities.publish', $activity) }}" method="POST">
            @csrf
            @method('PATCH')

            <button type="submit">Publish</button>
        </form>
    @elseif ($activity->status === 'published')
        <form action="{{ route('activities.complete', $activity) }}" method="POST">
            @csrf
            @method('PATCH')

            <button type="submit">Complete</button>
        </form>
    @endif

    @error('status')
        <p>{{ $message }}</p>
    @enderror

    <a href="{{ route('activities.edit', $activity) }}">Edit</a>
    <a href="{{ route('activities.index') }}">Kembali</a>
@endsection