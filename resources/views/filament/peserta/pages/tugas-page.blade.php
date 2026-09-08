<x-filament-panels::page>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/2.44.0/iconfont/tabler-icons.min.css">

@php
    $myProfile = auth()->user()->profile;
    $myGroup = $myProfile?->group?->name ?? 'Belum ditentukan';
    $myPic = $myProfile?->group?->guru?->name;
@endphp

{{-- Header Kelompok yang Menyatu dengan Tema Filament --}}
<div style="position:relative;background:var(--fi-card-bg, #ffffff);border:1px solid rgba(148,163,184,0.2);border-radius:16px;padding:20px 22px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:20px;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
        <div>
            <p style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 2px;">Kelompok Kamu</p>
            <p style="font-size:18px;font-weight:700;color:#0f172a;margin:0;">{{ $myGroup }}</p>
        </div>
        @if($myPic)
            <div style="width:1px;height:34px;background:rgba(148,163,184,0.2);"></div>
            <div>
                <p style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 2px;">PIC / Guru Pembina</p>
                <p style="font-size:18px;font-weight:600;color:#1e293b;margin:0;">{{ $myPic }}</p>
            </div>
        @endif
    </div>

    @if($myGroup !== 'Belum ditentukan')
        <div style="display:flex;align-items:center;gap:8px;padding:6px 12px;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.25);border-radius:10px;">
            <span style="width:7px;height:7px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
            <span style="font-size:12.5px;color:#15803d;font-weight:600;">Aktif</span>
        </div>
    @else
        <div style="display:flex;align-items:center;gap:8px;padding:6px 12px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);border-radius:10px;">
            <i class="ti ti-alert-triangle" style="font-size:14px;color:#dc2626;"></i>
            <span style="font-size:12.5px;color:#b91c1c;font-weight:600;">Hubungi admin</span>
        </div>
    @endif
</div>

{{-- Daftar Tugas --}}
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;">
@forelse($this->getTasks() as $task)
    @php $status = $task->submission_status; @endphp

    <div style="display:flex;flex-direction:column;border:1px solid rgba(148,163,184,0.25);border-radius:16px;overflow:hidden;background:#ffffff;box-shadow:0 1px 3px rgba(0,0,0,0.05);min-height:280px;">

        <div style="padding:20px;display:flex;flex-direction:column;flex:1;">

            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:14px;flex-wrap:wrap;">
                @if($task->type === 'voice_note')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11.5px;font-weight:600;background:rgba(59,130,246,0.12);color:#1d4ed8;">🎵 Voice note</span>
                @elseif($task->type === 'video')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11.5px;font-weight:600;background:rgba(245,158,11,0.12);color:#b45309;">🎬 Video</span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11.5px;font-weight:600;background:rgba(34,197,94,0.12);color:#15803d;">📝 Kuis</span>
                @endif

                @if($status === 'approved' && $task->type === 'quiz')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11.5px;font-weight:600;background:rgba(34,197,94,0.15);color:#15803d;">✓ Nilai: {{ $task->submission_score }}</span>
                @elseif($status === 'approved')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11.5px;font-weight:600;background:rgba(34,197,94,0.15);color:#15803d;">✓ Selesai</span>
                @elseif($status === 'pending')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11.5px;font-weight:600;background:rgba(59,130,246,0.15);color:#1d4ed8;">🕐 Menunggu</span>
                @elseif($status === 'rejected')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11.5px;font-weight:600;background:rgba(239,68,68,0.12);color:#b91c1c;">✕ Ditolak</span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11.5px;font-weight:600;background:rgba(100,116,139,0.1);color:#475569;">Belum dikerjakan</span>
                @endif
            </div>

            {{-- Judul dan Teks dengan Kontras Tinggi --}}
            <div style="font-size:18px;font-weight:700;line-height:1.35;margin-bottom:4px;color:#0f172a;">
                {{ $task->title }}
            </div>
            <div style="font-size:13px;font-weight:600;color:#16a34a;margin-bottom:10px;">
                oleh {{ $task->teacher?->name ?? '-' }}
            </div>
            <div style="font-size:13.5px;line-height:1.6;color:#334155;margin-bottom:auto;">
                {{ $task->description }}
            </div>

            @if($task->deadline)
                <div style="display:flex;align-items:center;gap:6px;margin-top:14px;font-size:12.5px;font-weight:600;color:{{ $task->is_locked ? '#dc2626' : '#475569' }};">
                    {{ $task->is_locked ? '🔒' : '⏳' }}
                    {{ $task->is_locked ? 'Deadline lewat:' : 'Deadline:' }}
                    {{ \Illuminate\Support\Carbon::parse($task->deadline)->translatedFormat('d M Y, H:i') }}
                </div>
            @endif

            @if($task->type === 'quiz' && $task->google_form_url)
                <a href="{{ $task->google_form_url }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:12px;font-size:13px;font-weight:600;color:#2563eb;text-decoration:none;">
                    🔗 Buka Google Form
                </a>
            @endif
        </div>

        {{-- Tombol Aksi Kontras & Jelas --}}
        <div style="padding:14px 20px;display:flex;flex-wrap:wrap;gap:10px;align-items:center;border-top:1px solid rgba(148,163,184,0.15);background:#f8fafc;">

            @if($status === 'belum')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:36px;padding:0 14px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #cbd5e1;color:#334155;background:#ffffff;">
                    Detail
                </a>
                @if($task->is_locked)
                    <span style="height:36px;padding:0 12px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:rgba(239,68,68,0.1);color:#dc2626;">
                        🔒 Deadline lewat
                    </span>
                @elseif($task->type === 'quiz')
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kuis', ['task' => $task->id]) }}"
                       style="height:36px;padding:0 16px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:#16a34a;color:#ffffff;box-shadow:0 2px 4px rgba(22,163,74,0.2);">
                        📝 Mulai Kuis
                    </a>
                @else
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kerjakan', ['task' => $task->id]) }}"
                       style="height:36px;padding:0 16px;border-radius:99px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:#d97706;color:#ffffff;box-shadow:0 2px 4px rgba(217,119,6,0.2);">
                        Kerjakan Tugas →
                    </a>
                @endif

            @elseif($status === 'pending')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:36px;padding:0 14px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #cbd5e1;color:#334155;background:#ffffff;">
                    Detail
                </a>
                <span style="height:36px;padding:0 12px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:rgba(59,130,246,0.1);color:#1d4ed8;">
                    {{ $task->type === 'quiz' ? '🕐 Menunggu verifikasi' : '🕐 Menunggu koreksi' }}
                </span>

            @elseif($status === 'rejected')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:36px;padding:0 14px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #cbd5e1;color:#334155;background:#ffffff;">
                    Lihat catatan
                </a>
                @if($task->is_locked)
                    <span style="height:36px;padding:0 12px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:rgba(239,68,68,0.1);color:#dc2626;">
                        🔒 Deadline lewat
                    </span>
                @else
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kerjakan', ['task' => $task->id]) }}"
                       style="height:36px;padding:0 16px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:#dc2626;color:#ffffff;box-shadow:0 2px 4px rgba(220,38,38,0.2);">
                        Kerjakan ulang →
                    </a>
                @endif

            @elseif($status === 'approved')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:36px;padding:0 16px;border-radius:9px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:#16a34a;color:#ffffff;box-shadow:0 2px 4px rgba(22,163,74,0.2);">
                    ✓ Lihat detail
                </a>
            @endif
        </div>
    </div>

@empty
    <div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;padding:80px 20px;text-align:center;">
        <div style="font-size:60px;margin-bottom:14px;">📭</div>
        <div style="font-size:16px;font-weight:600;color:#334155;margin-bottom:6px;">
            Belum ada tugas
        </div>
        <div style="font-size:13px;color:#64748b;">
            Tugas akan muncul di sini setelah guru membuat tugas untuk kelompokmu
        </div>
    </div>
@endforelse
</div>

</x-filament-panels::page>