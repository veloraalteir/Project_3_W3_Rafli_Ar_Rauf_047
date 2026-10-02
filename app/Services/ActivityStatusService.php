<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Validation\ValidationException;

class ActivityStatusService
{
    public function transition(Activity $activity, string $targetStatus): Activity
    {
        $allowedTransitions = [
            'Planned' => ['Ongoing'],
            'Ongoing' => ['Done'],
            'Done' => [],
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
}