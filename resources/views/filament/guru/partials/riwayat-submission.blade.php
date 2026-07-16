@use('Illuminate\Support\Facades\Storage')
@php
$url = $submission->file_path ? Storage::disk('public')->url($submission->file_path) : null;
$type = $submission->task->type ?? 'voice_note';
$logs = $submission->logs()->with('teacher')->orderBy('attempt_number')->get();
@endphp

<div style="display:flex;flex-direction:column;gap:16px;max-height:65vh;overflow-y:auto;">

    <div style="padding:10px 14px;border-radius:10px;background:rgba(0,0,0,0.03);font-size:13px;">
        <strong>Dikumpulkan:</strong> {{ $submission->created_at?->format('d M Y, H:i') }} WIB
        @if($submission->is_late)
        <span style="color:#d97706;">(Terlambat)</span>
        @endif
    </div>

    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
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
        <video controls class="w-full max-h-96 rounded">
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
        <p style="font-size:13px;font-weight:600;margin-bottom:8px;">Riwayat Koreksi</p>
        <div style="display:flex;flex-direction:column;gap:10px;">
            @forelse($logs as $log)
            <div
                style="padding:12px 14px;border-radius:10px;border:1px solid {{ $log->status_at_time === 'approved' ? 'rgba(34,197,94,0.3)' : 'rgba(239,68,68,0.3)' }};">
                <div style="display:flex;justify-content:space-between;">
                    <span
                        style="font-size:13px;font-weight:600;color:{{ $log->status_at_time === 'approved' ? '#16a34a' : '#dc2626' }};">
                        Percobaan {{ $log->attempt_number }}: {{ $log->status_at_time === 'approved' ? '✅ Disetujui' :
                        '❌ Ditolak' }}
                    </span>
                    <span style="font-size:12px;color:#6b7280;">
                        {{ $log->created_at?->format('d M Y, H:i') }} WIB
                    </span>
                </div>
                <p style="font-size:13px;margin-top:4px;">{{ $log->feedback ?? '-' }}</p>
                <p style="font-size:12px;color:#6b7280;margin-top:2px;">oleh: {{ $log->teacher?->name ?? 'Guru' }}</p>
            </div>
            @empty
            <p style="font-size:13px;color:#6b7280;font-style:italic;">Belum ada riwayat koreksi.</p>
            @endforelse
        </div>
    </div>
</div>