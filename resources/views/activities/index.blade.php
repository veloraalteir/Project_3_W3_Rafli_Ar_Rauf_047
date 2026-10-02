@extends('layouts.app')

@section('content')
    <h1>Daftar Kegiatan</h1>

    <a href="{{ route('activities.create') }}">Tambah Kegiatan</a>

    @forelse ($activities as $activity)
        <article>
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }}
                </a>
            </h2>

            <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
            <p>Kode: {{ $activity->code }}</p>
            <p>Kategori: {{ $activity->category->name }}</p>
            <p>Status: {{ $activity->status }}</p>

            <a href="{{ route('activities.edit', $activity) }}">Edit</a>

            <form action="{{ route('activities.destroy', $activity) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse
@endsection