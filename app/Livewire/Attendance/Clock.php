<?php

namespace App\Livewire\Attendance;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\WorkLocation;

class Clock extends Component
{
    use WithFileUploads;

    public ?float $lat = null;
    public ?float $lng = null;
    public $photo;
    
    public string $message = '';
    public string $status = 'ok';
    public ?Attendance $todayAttendance = null;
    public string $mode = 'in'; // 'in' atau 'out'

    public function mount()
    {
        $this->checkTodayAttendance();
    }

    public function checkTodayAttendance()
    {
        $this->todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('clock_in_at', now()->toDateString())
            ->first();

        // Auto switch mode
        if ($this->todayAttendance && !$this->todayAttendance->clock_out_at) {
            $this->mode = 'out';
        } else {
            $this->mode = 'in';
        }
    }

    public function clockIn()
    {
        $this->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'photo' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Validasi sudah clock-in hari ini
        if (Attendance::where('user_id', $user->id)
            ->whereDate('clock_in_at', now()->toDateString())
            ->exists()) {
            $this->status = 'error';
            $this->message = '❌ Sudah clock-in hari ini.';
            return;
        }

        // Batas waktu 06:00-10:00
        $now = now();
        if (! $now->between($now->copy()->setTime(6, 0), $now->copy()->setTime(10, 0))) {
            $this->status = 'error';
            $this->message = '⏰ Clock-in hanya boleh 06:00 - 10:00.';
            return;
        }

        // Cek radius kantor
        $loc = WorkLocation::where('active', true)->first();
        $finalStatus = 'ok';

        if ($loc) {
            $distance = $this->distanceMeters(
                (float) $this->lat,
                (float) $this->lng,
                (float) $loc->lat,
                (float) $loc->lng
            );

            if ($distance > (int) $loc->radius_meters) {
                $finalStatus = 'outside_radius';
            }
        }

        // Simpan foto
        $photoPath = $this->photo->store('attendance', 'public');

        Attendance::create([
            'user_id' => $user->id,
            'clock_in_at' => now(),
            'clock_in_lat' => $this->lat,
            'clock_in_lng' => $this->lng,
            'clock_in_photo_path' => $photoPath,
            'status' => $finalStatus,
        ]);

        $this->status = $finalStatus === 'ok' ? 'ok' : 'error';
        $this->message = "✅ Clock-in berhasil! Status: {$finalStatus}";

        // Reset & reload
        $this->reset(['lat', 'lng', 'photo']);
        $this->checkTodayAttendance();
    }

    public function clockOut()
    {
        $this->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'photo' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Validasi: harus sudah clock-in dulu
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('clock_in_at', now()->toDateString())
            ->first();

        if (!$attendance) {
            $this->status = 'error';
            $this->message = '❌ Belum clock-in hari ini.';
            return;
        }

        if ($attendance->clock_out_at) {
            $this->status = 'error';
            $this->message = '❌ Sudah clock-out hari ini.';
            return;
        }

        // Batas waktu clock-out 16:00-20:00
        $now = now();
        if (! $now->between($now->copy()->setTime(16, 0), $now->copy()->setTime(20, 0))) {
            $this->status = 'error';
            $this->message = '⏰ Clock-out hanya boleh 16:00 - 20:00.';
            return;
        }

        // Cek radius kantor
        $loc = WorkLocation::where('active', true)->first();
        $finalStatus = $attendance->status; // inherit status clock-in

        if ($loc) {
            $distance = $this->distanceMeters(
                (float) $this->lat,
                (float) $this->lng,
                (float) $loc->lat,
                (float) $loc->lng
            );

            if ($distance > (int) $loc->radius_meters) {
                $finalStatus = 'outside_radius';
            }
        }

        // Simpan foto clock-out
        $photoPath = $this->photo->store('attendance', 'public');

        $attendance->update([
            'clock_out_at' => now(),
            'clock_out_lat' => $this->lat,
            'clock_out_lng' => $this->lng,
            'clock_out_photo_path' => $photoPath,
            'status' => $finalStatus,
        ]);

        $this->status = $finalStatus === 'ok' ? 'ok' : 'error';
        $this->message = "✅ Clock-out berhasil! Status: {$finalStatus}";

        // Reset & reload
        $this->reset(['lat', 'lng', 'photo']);
        $this->checkTodayAttendance();
    }

    private function distanceMeters(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earth = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earth * $c;
    }

    public function render()
    {
        return view('livewire.attendance.clock')->layout('layouts.app');
    }
}
