<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Validation\ValidationException;

class ActivityStatusService
{
    public function transition(Activity $activity, string $targetStatus): Activity
    {
        $allowedTransitions = [
            'draft' => ['published'],
            'published' => ['completed'],
            'completed' => [],
        ];

        if (!in_array($targetStatus, $allowedTransitions[$activity->status] ?? [], true)) {
            throw ValidationException::withMessages([
                'status' => "Status {$activity->status} tidak dapat diubah menjadi {$targetStatus}.",
            ]);
        }

        $activity->update([
            'status' => $targetStatus,
        ]);

        return $activity;
    }

    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== 'draft') {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan draft yang dapat dipublikasikan.',
            ]);
        }

        $requiredFields = [
            'category_id',
            'code',
            'title',
            'location',
            'activity_date',
            'start_at',
            'end_at',
            'capacity',
        ];

        foreach ($requiredFields as $field) {
            if (blank($activity->{$field})) {
                throw ValidationException::withMessages([
                    'status' => 'Kegiatan belum lengkap dan tidak dapat dipublikasikan.',
                ]);
            }
        }

        return $this->transition($activity, 'published');
    }

    public function complete(Activity $activity): Activity
    {
        if ($activity->status !== 'published') {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan published yang dapat diselesaikan.',
            ]);
        }

        return $this->transition($activity, 'completed');
    }
}