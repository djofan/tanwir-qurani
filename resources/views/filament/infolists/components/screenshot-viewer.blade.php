@use('Illuminate\Support\Facades\Storage')
@php
    $screenshotPath = $getState();
    $url = $screenshotPath ? Storage::disk('public')->url($screenshotPath) : null;
@endphp

<div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
    @if($url)
        <div class="space-y-3">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                📸 Bukti Screenshot Pengerjaan Kuis
            </p>

            <a href="{{ $url }}" target="_blank">
                <img src="{{ $url }}"
                     alt="Screenshot bukti kuis"
                     class="w-full max-h-96 object-contain rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:opacity-90 transition">
            </a>

            <div class="flex gap-3">
                <a href="{{ $url }}"
                   target="_blank"
                   class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                    Buka gambar penuh
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ $url }}"
                   download
                   class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                    Download
                </a>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-500 italic">Tidak ada screenshot yang diunggah.</p>
    @endif
</div>