@use('Illuminate\Support\Facades\Storage')
@php
    $filePath = $getState();
    $submission = $getRecord();
    $type = $submission->task->type ?? 'voice_note';
    $url = $filePath ? Storage::disk('public')->url($filePath) : null;
@endphp

<div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
    @if($filePath && $url && $type !== 'quiz')

        @if($type === 'voice_note')
            <div class="space-y-2">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    🎵 File Audio
                </p>
                <audio controls class="w-full">
                    <source src="{{ $url }}" type="audio/webm">
                    <source src="{{ $url }}" type="audio/mpeg">
                    <source src="{{ $url }}" type="audio/wav">
                    Browser tidak mendukung audio player.
                </audio>
            </div>

        @elseif($type === 'video')
            <div class="space-y-2">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    🎬 File Video
                </p>
                <video controls class="w-full max-h-96 rounded">
                    <source src="{{ $url }}" type="video/webm">
                    <source src="{{ $url }}" type="video/mp4">
                    Browser tidak mendukung video player.
                </video>
            </div>
        @endif

        <div class="mt-3">
            <a href="{{ $url }}"
               target="_blank"
               class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                Download File
            </a>
        </div>

    @elseif($type === 'quiz')
        <p class="text-sm text-gray-500 italic">
            Tugas kuis — lihat bukti screenshot di section "Bukti Screenshot" di bawah.
        </p>

    @else
        <p class="text-sm text-gray-500">Tidak ada file.</p>
    @endif
</div>