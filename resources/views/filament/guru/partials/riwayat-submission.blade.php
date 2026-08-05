@use('Illuminate\Support\Facades\Storage')
@php
    $url = $submission->file_path ? Storage::disk('public')->url($submission->file_path) : null;
    $type = $submission->task->type ?? 'voice_note';
    $logs = $submission->logs()->with('teacher')->orderBy('attempt_number')->get();
@endphp

<div class="flex flex-col gap-4 max-h-[70vh] overflow-y-auto">

    <div class="px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-sm">
        <strong>Dikumpulkan:</strong> {{ $submission->created_at?->format('d M Y, H:i') }} WIB
        @if($submission->is_late)
            <span class="text-amber-600 dark:text-amber-400">(Terlambat)</span>
        @endif
    </div>

    <div class="p-3 sm:p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
        @if($url && $type === 'voice_note')
            <p class="text-sm font-medium mb-2">🎵 File Audio</p>
            <audio controls class="w-full">
                <source src="{{ $url }}" type="audio/webm">
                <source src="{{ $url }}" type="audio/mpeg">
                <source src="{{ $url }}" type="audio/wav">
                Browser tidak mendukung audio player.
            </audio>
        @elseif($url && $type === 'video')
            <p class="text-sm font-medium mb-2">🎬 File Video</p>
            <video controls class="w-full max-h-[50vh] sm:max-h-96 rounded">
                <source src="{{ $url }}" type="video/webm">
                <source src="{{ $url }}" type="video/mp4">
                Browser tidak mendukung video player.
            </video>
        @else
            <p class="text-sm text-gray-500">Tidak ada file.</p>
        @endif

        @if($url)
            <div class="mt-3">
                <a href="{{ $url }}" target="_blank" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                    Download File
                </a>
            </div>
        @endif
    </div>

    <div>
        <p class="text-sm font-semibold mb-2">Riwayat Koreksi</p>
        <div class="flex flex-col gap-2.5">
            @forelse($logs as $log)
                <div class="p-3 rounded-lg border {{ $log->status_at_time === 'approved' ? 'border-green-500/30' : 'border-red-500/30' }}">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
                        <span class="text-sm font-semibold {{ $log->status_at_time === 'approved' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            Percobaan {{ $log->attempt_number }}: {{ $log->status_at_time === 'approved' ? '✅ Disetujui' : '❌ Ditolak' }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $log->created_at?->format('d M Y, H:i') }} WIB
                        </span>
                    </div>
                    <p class="text-sm mt-1">{{ $log->feedback ?? '-' }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">oleh: {{ $log->teacher?->name ?? 'Guru' }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500 italic">Belum ada riwayat koreksi.</p>
            @endforelse
        </div>
    </div>
</div>
