@php
    $logs = $getRecord()->logs()->with('teacher')->orderBy('attempt_number')->get();
@endphp

<div class="space-y-3">
    @forelse($logs as $log)
        <div class="p-4 rounded-lg border
            {{ $log->status_at_time === 'approved'
                ? 'bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-700'
                : 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-700' }}">

            <div class="flex items-center justify-between mb-1">
                <span class="text-sm font-semibold
                    {{ $log->status_at_time === 'approved' ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                    Percobaan {{ $log->attempt_number }}:
                    {{ $log->status_at_time === 'approved' ? '✅ Disetujui' : '❌ Ditolak' }}
                </span>
                <span class="text-xs text-gray-500">
                    {{ $log->created_at?->format('d M Y, H:i') }}
                </span>
            </div>

            <p class="text-sm text-gray-700 dark:text-gray-300">
                {{ $log->feedback ?? '-' }}
            </p>

            <p class="text-xs text-gray-500 mt-1">
                oleh: {{ $log->teacher?->name ?? 'Guru' }}
            </p>
        </div>
    @empty
        <p class="text-sm text-gray-500 italic">Belum ada riwayat koreksi.</p>
    @endforelse
</div>