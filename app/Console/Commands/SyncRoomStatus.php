<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;

class SyncRoomStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rooms:sync-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi status semua kamar berdasarkan data penghuni aktif';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi status kamar...');

        $rooms = Room::with('activeTenant')->get();
        $updatedCount = 0;

        foreach ($rooms as $room) {
            $hasActiveTenant = $room->activeTenant !== null;
            $expectedStatus = $hasActiveTenant ? 'occupied' : 'available';

            if ($room->status !== $expectedStatus) {
                $room->update(['status' => $expectedStatus]);
                $updatedCount++;
                $this->line("Status Kamar {$room->room_number} diubah menjadi {$expectedStatus}.");
            }
        }

        $this->info("Sinkronisasi selesai! Total {$updatedCount} kamar diperbarui.");
    }
}
