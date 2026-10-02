@extends('layouts.app')

@section('content')
    <h1>Daftar Kegiatan</h1>

    <a href="{{ route('activities.create') }}">Tambah Kegiatan</a>
    <a href="{{ route('activities.trash') }}">Sampah</a>

    <form action="{{ route('activities.index') }}" method="GET">
        <div>
            <label for="search">Cari</label>
            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari judul atau kode"
            >
        </div>

        <div>
            <label for="category_id">Kategori</label>
            <select name="category_id" id="category_id">
                <option value="">Semua Kategori</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected((string) request('category_id') === (string) $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="">Semua Status</option>

                @foreach (['draft', 'published', 'completed'] as $status)
                    <option
                        value="{{ $status }}"
                        @selected(request('status') === $status)
                    >
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="sort">Urutan</label>
            <select name="sort" id="sort">
                <option value="newest" @selected(request('sort', 'newest') === 'newest')>
                    Terbaru
                </option>

                <option value="oldest" @selected(request('sort') === 'oldest')>
                    Terlama
                </option>
            </select>
        </div>

        <button type="submit">Terapkan</button>
        <a href="{{ route('activities.index') }}">Reset</a>
    </form>

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
        <p>Belum ada kegiatan yang sesuai.</p>
    @endforelse

    {{ $activities->links() }}
@endsection