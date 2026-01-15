<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
                    <div class="flex gap-4">
                        <a href="{{ route('attendance.clock') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            📱 Clock In/Out
                        </a>
                        <a href="{{ route('attendance.history') }}" 
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            📋 Riwayat Kehadiran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
