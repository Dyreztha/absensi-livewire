<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="mb-8">
                <div class="attendify-gradient rounded-3xl shadow-2xl p-8 md:p-12 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 opacity-10">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                                <p class="text-blue-100 text-lg">{{ now()->format('l, d F Y') }} • {{ now()->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        <p class="text-xl text-white/90 max-w-2xl">Ready to manage your attendance? Track your work hours with precision and ease.</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $today = \App\Models\Attendance::where('user_id', Auth::id())
                        ->whereDate('clock_in_at', today())
                        ->first();
                    
                    $thisMonth = \App\Models\Attendance::where('user_id', Auth::id())
                        ->whereMonth('clock_in_at', now()->month)
                        ->whereYear('clock_in_at', now()->year)
                        ->count();
                    
                    $avgDuration = \App\Models\Attendance::where('user_id', Auth::id())
                        ->whereMonth('clock_in_at', now()->month)
                        ->whereYear('clock_in_at', now()->year)
                        ->whereNotNull('clock_out_at')
                        ->get()
                        ->avg(function($attendance) {
                            return $attendance->clock_out_at->diffInHours($attendance->clock_in_at);
                        });
                @endphp

                <!-- Today Status -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                        </div>
                        @if($today)
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">ACTIVE</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">PENDING</span>
                        @endif
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium mb-1">Today's Status</h3>
                    <p class="text-3xl font-extrabold text-gray-900 mb-2">
                        {{ $today ? 'Clocked In' : 'Not Yet' }}
                    </p>
                    @if($today)
                        <p class="text-sm text-gray-600">
                            In: {{ $today->clock_in_at->format('H:i') }} 
                            @if($today->clock_out_at)
                                • Out: {{ $today->clock_out_at->format('H:i') }}
                            @endif
                        </p>
                    @else
                        <p class="text-sm text-gray-600">Start your day with clock in</p>
                    @endif
                </div>

                <!-- This Month -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"/>
                            </svg>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">{{ now()->format('M Y') }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium mb-1">This Month</h3>
                    <p class="text-3xl font-extrabold text-gray-900 mb-2">{{ $thisMonth }} Days</p>
                    <p class="text-sm text-gray-600">Total attendance recorded</p>
                </div>

                <!-- Average Duration -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                            </svg>
                        </div>
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">AVG</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium mb-1">Avg Duration</h3>
                    <p class="text-3xl font-extrabold text-gray-900 mb-2">{{ round($avgDuration ?? 0, 1) }}h</p>
                    <p class="text-sm text-gray-600">Per day this month</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Clock In/Out Card -->
                <a href="{{ route('attendance.clock') }}" class="group bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 hover:border-blue-200">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('images/icon-clock.png') }}" alt="Clock" class="w-12 h-12 object-contain">
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:attendify-text-gradient">Clock In / Out</h3>
                            <p class="text-gray-600 mb-3">Record your attendance with GPS & selfie verification</p>
                            <div class="flex items-center text-blue-600 font-semibold">
                                <span>Go to Clock</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- History Card -->
                <a href="{{ route('attendance.history') }}" class="group bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 hover:border-purple-200">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('images/icon-history.png') }}" alt="History" class="w-12 h-12 object-contain">
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:attendify-text-gradient">View History</h3>
                            <p class="text-gray-600 mb-3">Check your attendance records and detailed reports</p>
                            <div class="flex items-center text-purple-600 font-semibold">
                                <span>View Records</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Activity -->
            @php
                $recentAttendances = \App\Models\Attendance::where('user_id', Auth::id())
                    ->orderBy('clock_in_at', 'desc')
                    ->limit(5)
                    ->get();
            @endphp

            @if($recentAttendances->count() > 0)
                <div class="mt-8 bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Recent Activity</h2>
                        <a href="{{ route('attendance.history') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center gap-1">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @foreach($recentAttendances as $attendance)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="w-12 h-12 attendify-gradient rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ $attendance->clock_in_at->format('d') }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $attendance->clock_in_at->format('l, d M Y') }}</p>
                                    <p class="text-sm text-gray-600">
                                        In: {{ $attendance->clock_in_at->format('H:i') }} 
                                        @if($attendance->clock_out_at)
                                            • Out: {{ $attendance->clock_out_at->format('H:i') }}
                                        @endif
                                    </p>
                                </div>
                                @if($attendance->status === 'ok')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">OK</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">{{ strtoupper($attendance->status) }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
