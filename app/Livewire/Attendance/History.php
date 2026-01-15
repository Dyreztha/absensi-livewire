<?php

namespace App\Livewire\Attendance;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class History extends Component
{
    use WithPagination;

    public string $filterMonth = '';
    public string $filterYear = '';
    public ?int $selectedAttendanceId = null;
    public string $photoType = ''; // 'in' atau 'out'

    public function mount()
    {
        $this->filterMonth = now()->format('m');
        $this->filterYear = now()->format('Y');
    }

    public function updatedFilterMonth()
    {
        $this->resetPage();
    }

    public function updatedFilterYear()
    {
        $this->resetPage();
    }

    public function showPhoto(int $attendanceId, string $type)
    {
        $this->selectedAttendanceId = $attendanceId;
        $this->photoType = $type;
        $this->dispatch('openPhotoModal');
    }

    public function closePhotoModal()
    {
        $this->selectedAttendanceId = null;
        $this->photoType = '';
    }

    public function getSelectedAttendanceProperty()
    {
        if (!$this->selectedAttendanceId) {
            return null;
        }
        return Attendance::find($this->selectedAttendanceId);
    }

    public function render()
    {
        $query = Attendance::where('user_id', Auth::id())
            ->orderBy('clock_in_at', 'desc');

        if ($this->filterYear && $this->filterMonth) {
            $query->whereYear('clock_in_at', $this->filterYear)
                  ->whereMonth('clock_in_at', $this->filterMonth);
        }

        $attendances = $query->paginate(10);

        return view('livewire.attendance.history', [
            'attendances' => $attendances,
            'years' => range(now()->year, now()->year - 2),
            'months' => [
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ],
        ])->layout('layouts.app');
    }
}
