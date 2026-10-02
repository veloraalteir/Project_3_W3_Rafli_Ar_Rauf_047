@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1>

    <p>{{ $activity->description }}</p>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kode: {{ $activity->code }}</p>
    <p>Kategori: {{ $activity->category->name }}</p>
    <p>Status: {{ $activity->status }}</p>
    <form action="{{ route('activities.transition', $activity) }}" method="POST">
    @csrf
    @method('PATCH')

    <label for="status">Ubah Status</label>

    <select name="status" id="status">
        @if ($activity->status === 'Planned')
            <option value="Ongoing">Ongoing</option>
        @elseif ($activity->status === 'Ongoing')
            <option value="Done">Done</option>
        @endif
    </select>

    @error('status')
        <p>{{ $message }}</p>
    @enderror

    @if ($activity->status !== 'Done')
        <button type="submit">Ubah Status</button>
    @endif
    </form>
    <a href="{{ route('activities.edit', $activity) }}">Edit</a>
    <a href="{{ route('activities.index') }}">Kembali</a>
@endsection