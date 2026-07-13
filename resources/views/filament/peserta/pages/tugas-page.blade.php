<x-filament-panels::page>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/2.44.0/iconfont/tabler-icons.min.css">

@php
    $myGroup = auth()->user()->profile?->group?->name ?? 'Belum ditentukan';
@endphp

<div style="position:relative;background:linear-gradient(145deg,#0f1117,#16181f);border-radius:18px;padding:1px;overflow:hidden;margin-bottom:20px;">
    <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(167,139,250,0.45),transparent 45%,transparent 60%,rgba(167,139,250,0.1));border-radius:18px;"></div>
    <div style="position:relative;background:#0d0f15;border-radius:17px;padding:20px 22px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">

        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:46px;height:46px;border-radius:13px;background:rgba(167,139,250,0.12);border:1px solid rgba(167,139,250,0.25);display:flex;align-items:center;justify-content:center;">
                <i class="ti ti-users-group" style="font-size:22px;color:#a78bfa;"></i>
            </div>
            <div>
                <p style="font-size:11px;font-weight:500;color:#64748b;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 2px;">Kelompok kamu</p>
                <p style="font-size:19px;font-weight:500;color:#f1f5f9;margin:0;">{{ $myGroup }}</p>
            </div>
        </div>

        @if($myGroup !== 'Belum ditentukan')
            <div style="display:flex;align-items:center;gap:10px;padding:8px 14px;background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:12px;">
                <span style="width:7px;height:7px;border-radius:50%;background:#4ade80;display:inline-block;"></span>
                <span style="font-size:12.5px;color:#4ade80;font-weight:500;">Aktif</span>
            </div>
        @else
            <div style="display:flex;align-items:center;gap:10px;padding:8px 14px;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:12px;">
                <i class="ti ti-alert-triangle" style="font-size:14px;color:#f87171;"></i>
                <span style="font-size:12.5px;color:#f87171;font-weight:500;">Hubungi admin</span>
            </div>
        @endif

    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;">
@forelse($this->getTasks() as $task)
    @php $status = $task->submission_status; @endphp

    <div style="display:flex;flex-direction:column;border:1px solid rgba(148,163,184,0.15);border-radius:18px;overflow:hidden;background:rgba(255,255,255,0.02);min-height:280px;">

        <div style="padding:20px;display:flex;flex-direction:column;flex:1;">

            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:16px;">
                @if($task->type === 'voice_note')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(59,130,246,0.15);color:#60a5fa;">🎵 Voice note</span>
                @elseif($task->type === 'video')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(245,158,11,0.15);color:#f59e0b;">🎬 Video</span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(34,197,94,0.15);color:#22c55e;">📝 Kuis</span>
                @endif

                @if($status === 'approved' && $task->type === 'quiz')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(34,197,94,0.18);color:#16a34a;">✓ Nilai: {{ $task->submission_score }}</span>
                @elseif($status === 'approved')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(34,197,94,0.18);color:#16a34a;">✓ Selesai</span>
                @elseif($status === 'pending')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(59,130,246,0.18);color:#3b82f6;">🕐 Menunggu</span>
                @elseif($status === 'rejected')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(239,68,68,0.15);color:#ef4444;">✕ Ditolak</span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(148,163,184,0.15);color:#64748b;">Belum dikerjakan</span>
                @endif

                @if($task->is_late)
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:rgba(249,115,22,0.15);color:#fb923c;">⏰ Terlambat</span>
                @endif
            </div>

            <div style="font-size:19px;font-weight:700;line-height:1.35;margin-bottom:6px;color:#f1f5f9;">
                {{ $task->title }}
            </div>
            <div style="font-size:13px;font-weight:500;color:#22c55e;margin-bottom:12px;">
                oleh {{ $task->teacher?->name ?? '-' }}
            </div>
            <div style="font-size:13.5px;line-height:1.65;color:#94a3b8;margin-bottom:auto;">
                {{ $task->description }}
            </div>

            @if($task->deadline)
                <div style="display:flex;align-items:center;gap:6px;margin-top:14px;font-size:12.5px;font-weight:600;color:{{ $task->is_locked ? '#f87171' : '#94a3b8' }};">
                    {{ $task->is_locked ? '🔒' : '⏳' }}
                    {{ $task->is_locked ? 'Deadline lewat:' : 'Deadline:' }}
                    {{ \Illuminate\Support\Carbon::parse($task->deadline)->translatedFormat('d M Y, H:i') }}
                </div>
            @endif

            @if($task->type === 'quiz' && $task->google_form_url)
                <a href="{{ $task->google_form_url }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;font-size:13px;font-weight:600;color:#3b82f6;text-decoration:none;">
                    🔗 Buka Google Form
                </a>
            @endif
        </div>

        <div style="padding:16px 20px;display:flex;flex-wrap:wrap;gap:10px;align-items:center;border-top:1px solid rgba(148,163,184,0.1);background:rgba(255,255,255,0.015);">

            @if($status === 'belum')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:38px;padding:0 16px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1.5px solid rgba(148,163,184,0.2);color:#e2e8f0;background:rgba(255,255,255,0.03);">
                    Detail
                </a>
                @if($task->is_locked)
                    <span style="height:38px;padding:0 14px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:rgba(239,68,68,0.12);color:#f87171;">
                        🔒 Deadline lewat
                    </span>
                @elseif($task->type === 'quiz')
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kuis', ['task' => $task->id]) }}"
                       style="height:38px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,0.3);">
                        📝 Mulai Kuis
                    </a>
                @else
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kerjakan', ['task' => $task->id]) }}"
                       style="height:38px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;box-shadow:0 4px 12px rgba(245,158,11,0.3);">
                        Kerjakan Tugas →
                    </a>
                @endif

            @elseif($status === 'pending')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:38px;padding:0 16px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1.5px solid rgba(148,163,184,0.2);color:#e2e8f0;background:rgba(255,255,255,0.03);">
                    Detail
                </a>
                <span style="height:38px;padding:0 14px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:rgba(148,163,184,0.1);color:#94a3b8;">
                    {{ $task->type === 'quiz' ? '🕐 Menunggu verifikasi' : '🕐 Menunggu koreksi' }}
                </span>

            @elseif($status === 'rejected')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:38px;padding:0 16px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1.5px solid rgba(148,163,184,0.2);color:#e2e8f0;background:rgba(255,255,255,0.03);">
                    Lihat catatan
                </a>
                @if($task->type === 'quiz')
                    {{-- Kuis native tidak pernah berstatus rejected, cabang ini cuma untuk data lama --}}
                @elseif($task->is_locked)
                    <span style="height:38px;padding:0 14px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:rgba(239,68,68,0.12);color:#f87171;">
                        🔒 Deadline lewat
                    </span>
                @else
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kerjakan', ['task' => $task->id]) }}"
                       style="height:38px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;box-shadow:0 4px 12px rgba(239,68,68,0.3);">
                        Kerjakan ulang →
                    </a>
                @endif

            @elseif($status === 'approved')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:38px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,0.2);">
                    ✓ Lihat detail
                </a>
            @endif
        </div>
    </div>

@empty
    <div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;padding:80px 20px;text-align:center;">
        <div style="font-size:60px;margin-bottom:14px;">📭</div>
        <div style="font-size:16px;font-weight:600;color:#e2e8f0;margin-bottom:6px;">
            Belum ada tugas
        </div>
        <div style="font-size:13px;color:#64748b;">
            Tugas akan muncul di sini setelah guru membuat tugas untuk kelompokmu
        </div>
    </div>
@endforelse
</div>

</x-filament-panels::page>