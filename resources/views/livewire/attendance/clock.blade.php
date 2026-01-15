<div>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>

    <div class=\"min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 sm:py-8 px-3 sm:px-6 lg:px-8\">
        <div class=\"max-w-4xl mx-auto\">
            <!-- Header -->
            <div class=\"text-center mb-6 sm:mb-8\">
                <div class=\"inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 {{ $mode === 'in' ? 'bg-indigo-600' : 'bg-orange-600' }} rounded-2xl mb-3 sm:mb-4 shadow-lg\">
                    <svg class=\"w-6 h-6 sm:w-8 sm:h-8 text-white\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z\"/>
                    </svg>
                </div>
                <h1 class=\"text-2xl sm:text-3xl font-bold text-gray-900 mb-2\">
                    {{ $mode === 'in' ? 'Clock In' : 'Clock Out' }} Attendance
                </h1>

                <div class=\"mt-3 inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200\">
                    <span class=\"w-2 h-2 bg-green-500 rounded-full animate-pulse\"></span>
                    <span class=\"text-xs sm:text-sm font-medium text-gray-700\">{{ now()->format('d M Y, H:i') }} WIB</span>
                </div>

                {{-- Status Hari Ini --}}
                @if($todayAttendance)
                    <div class="mt-4 inline-flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 px-3 sm:px-5 py-2 sm:py-3 bg-blue-50 border-2 border-blue-200 rounded-xl text-left">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <div>
                            <p class="text-xs sm:text-sm font-semibold text-blue-900">Clock In: {{ $todayAttendance->clock_in_at->format('H:i') }}</p>
                            <p class="text-xs text-blue-700">
                                {{ $todayAttendance->clock_out_at ? 'Clock Out: ' . $todayAttendance->clock_out_at->format('H:i') : 'Belum Clock Out' }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Alert Messages -->
            @if($message)
                <div class="mb-6 animate-fadeIn">
                    <div class="max-w-2xl mx-auto p-3 sm:p-4 rounded-xl border-2 {{ $status === 'ok' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }} shadow-md">
                        <div class="flex items-start gap-2 sm:gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                @if($status === 'ok')
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z\"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm sm:text-base font-semibold {{ $status === 'ok' ? 'text-green-900' : 'text-red-900' }}\">
                                    {{ $message }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content Grid - Better for Mobile -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
                <!-- GPS Status Card -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-200 p-4 sm:p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Lokasi GPS</h3>
                                <p class="text-xs text-gray-500">High Accuracy</p>
                            </div>
                        </div>
                        @if($lat)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                Active
                            </span>
                        @endif
                    </div>
                    <div class="space-y-3">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-xs text-gray-600 mb-2">Latitude</p>
                            <p class="font-mono text-lg font-bold text-gray-900">
                                {{ $lat ? number_format($lat, 5) : 'Pending' }}
                            </p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-xs text-gray-600 mb-2">Longitude</p>
                            <p class="font-mono text-lg font-bold text-gray-900">
                                {{ $lng ? number_format($lng, 5) : 'Pending' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Camera Status Card -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-200 p-4 sm:p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0118.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Selfie Photo</h3>
                                <p class="text-xs text-gray-500">640x480px</p>
                            </div>
                        </div>
                        @if($photo)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                Ready
                            </span>
                        @endif
                    </div>
                    <div class="bg-green-50 rounded-lg p-6 text-center">
                        @if($photo)
                            <svg class="w-12 h-12 mx-auto text-green-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <p class="text-sm font-bold text-green-700">Photo Captured</p>
                        @else
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-500">No photo yet</p>
                        @endif
                    </div>
                </div>

                <!-- Time Window Card -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-200 p-4 sm:p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 {{ $mode === 'in' ? 'bg-purple-100' : 'bg-orange-100' }} rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 {{ $mode === 'in' ? 'text-purple-600' : 'text-orange-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Jam Kerja</h3>
                            <p class="text-xs text-gray-500">{{ $mode === 'in' ? 'Clock In Window' : 'Clock Out Window' }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @if($mode === 'in')
                            <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg border border-purple-100">
                                <span class="text-sm text-gray-600 font-medium">Mulai</span>
                                <span class="font-mono text-lg font-bold text-purple-900">06:00</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg border border-purple-100">
                                <span class="text-sm text-gray-600 font-medium">Selesai</span>
                                <span class="font-mono text-lg font-bold text-purple-900">10:00</span>
                            </div>
                        @else
                            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-100">
                                <span class="text-sm text-gray-600 font-medium">Mulai</span>
                                <span class="font-mono text-lg font-bold text-orange-900">16:00</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-100">
                                <span class="text-sm text-gray-600 font-medium">Selesai</span>
                                <span class="font-mono text-lg font-bold text-orange-900">20:00</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-6">
                <button type="button" onclick="getLocation()"
                        class="group relative bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 sm:py-5 px-6 rounded-xl sm:rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 {{ $lat ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $lat ? 'disabled' : '' }}>
                    <div class="flex items-center justify-center gap-3">
                        <svg class="w-6 h-6 {{ $lat ? '' : 'group-hover:scale-110 transition-transform' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-base sm:text-lg">{{ $lat ? '✓ GPS Captured' : 'Get GPS Location' }}</span>
                    </div>
                </button>

                <button type="button" onclick="capturePhoto()"
                        class="group bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-4 sm:py-5 px-6 rounded-xl sm:rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                    <div class="flex items-center justify-center gap-3">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-base sm:text-lg">{{ $photo ? '✓ Photo Captured' : 'Take Selfie' }}</span>
                    </div>
                </button>
            </div>

            <!-- Camera Preview Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div wire:ignore>
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                            Live Camera
                        </h3>
                        <div class="relative rounded-xl overflow-hidden bg-gray-900 shadow-inner" style="aspect-ratio: 4/3;">
                            <video id="video" autoplay playsinline muted class="w-full h-full object-cover"></video>
                        </div>
                    </div>

                    <div wire:ignore>
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/>
                            </svg>
                            Preview Selfie
                        </h3>
                        <div class="relative rounded-xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 shadow-inner flex items-center justify-center" style="aspect-ratio: 4/3;">
                            <img id="preview" class="w-full h-full object-cover hidden" />
                            <div id="previewPlaceholder" class="text-center p-8">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">Foto akan tampil di sini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Livewire Input -->
            <input id="photoInput" type="file" class="hidden" wire:model="photo" accept="image/*" />

            <!-- Clock In/Out Button -->
            @if($mode === 'in')
                <button wire:click="clockIn"
                        class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold py-6 px-8 rounded-2xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300 {{ !$lat || !$photo ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ !$lat || !$photo ? 'disabled' : '' }}>
                    <div class="flex items-center justify-center gap-3">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <span class="text-xl">{{ !$lat || !$photo ? 'Lengkapi GPS & Foto' : 'Clock In Sekarang' }}</span>
                    </div>
                </button>
            @else
                <button wire:click="clockOut"
                        class="w-full bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 hover:from-orange-700 hover:via-red-700 hover:to-pink-700 text-white font-bold py-6 px-8 rounded-2xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300 {{ !$lat || !$photo ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ !$lat || !$photo ? 'disabled' : '' }}>
                    <div class="flex items-center justify-center gap-3">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"/>
                        </svg>
                        <span class="text-xl">{{ !$lat || !$photo ? 'Lengkapi GPS & Foto' : 'Clock Out Sekarang' }}</span>
                    </div>
                </button>
            @endif

            <!-- Validation Errors -->
            <div class="mt-4 space-y-2">
                @error('lat')
                    <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-sm text-red-800 font-medium">{{ $message }}</p>
                    </div>
                @enderror
                @error('lng')
                    <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-sm text-red-800 font-medium">{{ $message }}</p>
                    </div>
                @enderror
                @error('photo')
                    <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-sm text-red-800 font-medium">{{ $message }}</p>
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <script>
        let videoStream = null;

        async function startCamera() {
            try {
                videoStream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
                    audio: false
                });
                document.getElementById('video').srcObject = videoStream;
            } catch (err) {
                console.error('Camera error:', err);
            }
        }

        function getLocation() {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    @this.set('lat', pos.coords.latitude);
                    @this.set('lng', pos.coords.longitude);
                },
                (err) => alert('GPS error: ' + err.message),
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }

        function capturePhoto() {
            const video = document.getElementById('video');
            if (!video.videoWidth) {
                alert('Tunggu kamera siap');
                return;
            }

            const canvas = document.createElement('canvas');
            canvas.width = 640;
            canvas.height = 480;
            canvas.getContext('2d').drawImage(video, 0, 0);

            canvas.toBlob((blob) => {
                const file = new File([blob], 'selfie.png', { type: 'image/png' });
                const dt = new DataTransfer();
                dt.items.add(file);

                const input = document.getElementById('photoInput');
                input.files = dt.files;
                input.dispatchEvent(new Event('change', { bubbles: true }));

                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(blob);
                preview.classList.remove('hidden');
                document.getElementById('previewPlaceholder').classList.add('hidden');
            }, 'image/png', 0.8);
        }

        startCamera();
    </script>
</div>
