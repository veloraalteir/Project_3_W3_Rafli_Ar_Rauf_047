<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $activities = Activity::query()
            ->with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(
                $request->sort === 'oldest',
                fn ($query) => $query->orderBy('start_at', 'asc')
            )
            ->when(
                $request->sort !== 'oldest',
                fn ($query) => $query->orderBy('start_at', 'desc')
            )
            ->paginate(10)
            ->withQueryString();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('activities.create', compact('categories'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = 'draft';

        $activity = Activity::create($data);

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function show(Activity $activity): View
    {
        $activity->load('category');

        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(
        UpdateActivityRequest $request,
        Activity $activity
    ): RedirectResponse {
        $activity->update($request->validated());

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }
    public function trash(): View
    {
        $activities = Activity::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->get();

        return view('activities.trash', compact('activities'));
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return to_route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function restore(int $activity): RedirectResponse
    {
        $activity = Activity::onlyTrashed()->findOrFail($activity);
        $activity->restore();

        return to_route('activities.trash')     
            ->with('success', 'Kegiatan berhasil dipulihkan.');
    }

    public function publish(
        ActivityStatusService $statusService,
        Activity $activity
    ): RedirectResponse {
        $statusService->publish($activity);

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dipublikasikan.');
    }

    public function complete(
        ActivityStatusService $statusService,
        Activity $activity
    ): RedirectResponse {
        $statusService->complete($activity);

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diselesaikan.');
    }
}