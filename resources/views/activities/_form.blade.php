<div>
    <label for="title">Judul</label>
    <input
        id="title"
        name="title"
        value="{{ old('title', $activity->title ?? '') }}"
    >

    @error('title')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="description">Deskripsi</label>
    <textarea id="description" name="description">{{ old('description', $activity->description ?? '') }}</textarea>

    @error('description')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="activity_date">Tanggal</label>
    <input
        type="date"
        id="activity_date"
        name="activity_date"
        value="{{ old('activity_date', isset($activity) ? $activity->activity_date->format('Y-m-d') : '') }}"
    >

    @error('activity_date')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="start_at">Waktu Mulai</label>
    <input
        type="datetime-local"
        id="start_at"
        name="start_at"
        value="{{ old('start_at', isset($activity) && $activity->start_at ? $activity->start_at->format('Y-m-d\TH:i') : '') }}"
    >

    @error('start_at')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="end_at">Waktu Selesai</label>
    <input
        type="datetime-local"
        id="end_at"
        name="end_at"
        value="{{ old('end_at', isset($activity) && $activity->end_at ? $activity->end_at->format('Y-m-d\TH:i') : '') }}"
    >

    @error('end_at')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="location">Lokasi</label>
    <input
        id="location"
        name="location"
        value="{{ old('location', $activity->location ?? '') }}"
    >

    @error('location')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="capacity">Kapasitas</label>
    <input
        type="number"
        id="capacity"
        name="capacity"
        value="{{ old('capacity', $activity->capacity ?? '') }}"
        min="1"
        max="500"
    >

    @error('capacity')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="code">Kode</label>
    <input
        id="code"
        name="code"
        value="{{ old('code', $activity->code ?? '') }}"
    >

    @error('code')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="category_id">Kategori</label>
    <select name="category_id" id="category_id">
        <option value="">-- Pilih Kategori --</option>

        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected((string) old('category_id', $activity->category_id ?? '') === (string) $category->id)
            >
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <p>{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="status">Status</label>
    <select name="status" id="status">
        @foreach (['Planned', 'Ongoing', 'Done'] as $status)
            <option
                value="{{ $status }}"
                @selected(old('status', $activity->status ?? 'Planned') === $status)
            >
                {{ $status }}
            </option>
        @endforeach
    </select>

    @error('status')
        <p>{{ $message }}</p>
    @enderror
</div>