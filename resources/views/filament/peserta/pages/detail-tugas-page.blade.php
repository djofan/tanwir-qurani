<x-filament-panels::page>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/2.44.0/iconfont/tabler-icons.min.css">

<div class="detail-page max-w-2xl mx-auto" style="display: flex; flex-direction: column; gap: 20px;">

    {{-- Hero Card Tugas --}}
    <div style="background: var(--fi-card-bg, #ffffff); border: 1px solid rgba(148,163,184,0.25); border-radius: 20px; padding: 28px 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
        <div style="position: relative; z-index: 1;">
            @if($this->task->type === 'voice_note')
                <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(59,130,246,0.1); color: #1d4ed8; border: 1px solid rgba(59,130,246,0.2); padding: 5px 14px; border-radius: 999px; font-size: 12px; font-weight: 600;">🎵 Voice Note</span>
            @elseif($this->task->type === 'quiz')
                <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(34,197,94,0.1); color: #15803d; border: 1px solid rgba(34,197,94,0.2); padding: 5px 14px; border-radius: 999px; font-size: 12px; font-weight: 600;">📝 Kuis</span>
            @else
                <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(245,158,11,0.1); color: #b45309; border: 1px solid rgba(245,158,11,0.2); padding: 5px 14px; border-radius: 999px; font-size: 12px; font-weight: 600;">🎬 Video</span>
            @endif

            <p style="font-size: 22px; font-weight: 700; color: #0f172a; line-height: 1.3; margin: 14px 0 4px;">{{ $this->task->title }}</p>
            <p style="font-size: 13px; color: #64748b; font-weight: 500;">Diberikan oleh <span style="font-weight: 600; color: #334155;">{{ $this->task->teacher?->name }}</span></p>

            <div style="margin-top: 20px; padding: 16px 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                <p style="font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #475569; margin-bottom: 6px;">Perintah Tugas</p>
                <p style="font-size: 14px; color: #334155; line-height: 1.65;">{{ $this->task->description }}</p>
            </div>
        </div>
    </div>

    {{-- Nilai Kuis (Jika ada) --}}
    @if($this->task->type === 'quiz' && $this->submission)
        <div style="background: var(--fi-card-bg, #ffffff); border: 1px solid rgba(148,163,184,0.25); border-radius: 18px; padding: 22px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); text-align: center;">
            <p style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Nilai Kuis Kamu</p>
            <p style="font-size: 40px; font-weight: 800; color: #16a34a; margin: 0;">{{ $this->submission->score }}</p>
            <p style="font-size: 12.5px; color: #64748b; margin-top: 6px;">
                {{ $this->submission->quizAnswers->where('is_correct', true)->count() }} benar dari {{ $this->submission->quizAnswers->count() }} soal
            </p>
        </div>

        {{-- Pembahasan Jawaban --}}
        <div style="background: var(--fi-card-bg, #ffffff); border: 1px solid rgba(148,163,184,0.25); border-radius: 18px; padding: 22px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <p style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 14px;">Pembahasan Jawaban</p>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @foreach($this->submission->quizAnswers as $index => $answer)
                    @php $q = $answer->question; @endphp
                    <div style="padding: 14px 16px; border-radius: 12px; background: #f8fafc; border: 1.5px solid {{ $answer->is_correct ? '#bbf7d0' : '#fecdd3' }};">
                        <p style="font-size: 13.5px; font-weight: 600; color: #0f172a; margin-bottom: 8px;">
                            {{ $index + 1 }}. {{ $q?->question }}
                            <span style="float: right; font-size: 12px;">{{ $answer->is_correct ? '✅' : '❌' }}</span>
                        </p>
                        <p style="font-size: 12.5px; color: {{ $answer->is_correct ? '#15803d' : '#b91c1c' }}; margin-bottom: 2px;">
                            Jawaban kamu: <strong>{{ strtoupper($answer->selected_option) }}.</strong> {{ $q?->{'option_' . $answer->selected_option} }}
                        </p>
                        @if(!$answer->is_correct)
                            <p style="font-size: 12.5px; color: #15803d; margin-top: 4px;">
                                Jawaban benar: <strong>{{ strtoupper($q?->correct_option) }}.</strong> {{ $q?->{'option_' . $q?->correct_option} }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Riwayat Koreksi (Jika ada) --}}
    @if($this->submission && $this->submission->logs->count() > 0)
        <div style="background: var(--fi-card-bg, #ffffff); border: 1px solid rgba(148,163,184,0.25); border-radius: 18px; padding: 22px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <p style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 0;">Riwayat Koreksi</p>
                <span style="background: #e2e8f0; color: #475569; font-size: 11px; font-weight: 700; padding: 2px 9px; border-radius: 999px;">{{ $this->submission->logs->count() }}x</span>
            </div>

            <div style="position: relative; padding-left: 28px;">
                <div style="position: absolute; left: 9px; top: 8px; bottom: 8px; width: 2px; background: #e2e8f0;"></div>

                @foreach($this->submission->logs()->with('teacher')->orderBy('attempt_number')->get() as $log)
                    <div style="position: relative; margin-bottom: 16px;">
                        <div style="position: absolute; left: -24px; top: 16px; width: 12px; height: 12px; border-radius: 50%; border: 2px solid #ffffff; background: {{ $log->status_at_time === 'approved' ? '#22c55e' : '#ef4444' }};"></div>

                        <div style="border-radius: 14px; padding: 16px 18px; border: 1.5px solid {{ $log->status_at_time === 'approved' ? '#bbf7d0' : '#fecdd3' }}; background: {{ $log->status_at_time === 'approved' ? '#f0fdf4' : '#fff1f2' }};">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; margin-bottom: 10px;">
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: {{ $log->status_at_time === 'approved' ? '#16a34a' : '#dc2626' }};">
                                        Percobaan {{ $log->attempt_number }}
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; background: {{ $log->status_at_time === 'approved' ? '#dcfce7' : '#fee2e2' }}; color: {{ $log->status_at_time === 'approved' ? '#15803d' : '#b91c1c' }};">
                                        {{ $log->status_at_time === 'approved' ? '✅ Disetujui' : '❌ Ditolak' }}
                                    </span>
                                </div>
                                <span style="font-size: 11px; color: #64748b; font-weight: 500;">{{ $log->created_at?->format('d M Y • H:i') }}</span>
                            </div>

                            <p style="font-size: 13.5px; color: #1e293b; line-height: 1.6; margin-bottom: 8px;">{{ $log->feedback ?? 'Tidak ada catatan dari guru.' }}</p>
                            <p style="font-size: 11.5px; color: #64748b; margin: 0;">Dinilai oleh <strong style="color: #0f172a;">{{ $log->teacher?->name ?? 'Guru' }}</strong></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Action Bar (Tombol Kembali & Kerjakan Ulang) --}}
    <div style="display: flex; gap: 12px; align-items: center; padding: 16px 20px; background: var(--fi-card-bg, #ffffff); border: 1px solid rgba(148,163,184,0.25); border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
        <a href="{{ route('filament.peserta.pages.tugas') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 9px 20px; border-radius: 10px; background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; font-size: 13.5px; font-weight: 600; text-decoration: none;">
            ← Kembali
        </a>

        @if($this->submission?->status === 'rejected')
            <a href="{{ route('filament.peserta.pages.tugas.{task}.kerjakan', ['task' => $this->task->id]) }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 9px 20px; border-radius: 10px; background: #dc2626; color: #ffffff; font-size: 13.5px; font-weight: 600; text-decoration: none; box-shadow: 0 2px 8px rgba(220,38,38,0.3);">
                🔄 Kerjakan Ulang
            </a>
        @endif
    </div>

</div>
</x-filament-panels::page>