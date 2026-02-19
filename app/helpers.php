<?php

use App\Models\ActivityLog;

if (!function_exists('activity_log')) {
    function activity_log(string $action, $subject = null, string $desc = null): void {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'description' => $desc,
            'ip_address' => request()->ip()
        ]);
    }
}
