@extends('layouts.app')

@section('content')
    <h1>Sampah Kegiatan</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('activities.index') }}">Kembali ke Daftar Kegiatan</a>

    @forelse ($activities as $activity)
        <article>
            <h2>{{ $activity->title }}</h2>

            <p>Kode: {{ $activity->code }}</p>
            <p>Kategori: {{ $activity->category->name }}</p>
            <p>Status: {{ $activity->status }}</p>
            <p>Dihapus pada: {{ $activity->deleted_at->format('d M Y H:i') }}</p>

            <form
                action="{{ route('activities.restore', $activity->id) }}"
                method="POST"
            >
                @csrf
                @method('PATCH')

                <button type="submit">Restore</button>
            </form>
        </article>
    @empty
        <p>Belum ada kegiatan di sampah.</p>
    @endforelse
@endsection