<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReminderService;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index(ReminderService $reminderService)
    {
        $reminders = [
            'h7' => $reminderService->getDueReminders('h7'),
            'h3' => $reminderService->getDueReminders('h3'),
            'h0' => $reminderService->getDueReminders('h0'),
            'overdue' => $reminderService->getDueReminders('overdue'),
        ];

        return view('admin.reminders.index', compact('reminders', 'reminderService'));
    }

    public function log(Request $request, ReminderService $reminderService)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'type' => 'required|in:h7,h3,h0,overdue'
        ]);

        $tenant = Tenant::findOrFail($request->tenant_id);
        $url = $reminderService->buildWhatsAppUrl($tenant, $request->type);

        $reminderService->logReminder($tenant, $request->type, $url);

        return response()->json(['success' => true, 'message' => 'Log reminder berhasil dicatat.']);
    }
}
