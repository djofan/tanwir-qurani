<x-filament-panels::page>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        .detail-page * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .task-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 28px 32px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.07);
        }
        .task-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
            border-radius: 50%;
        }
        .task-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 40px;
            width: 140px; height: 140px;
            background: radial-gradient(circle, rgba(34,211,238,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }

        .badge-voice {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(99,102,241,0.2);
            color: #a5b4fc;
            border: 1px solid rgba(99,102,241,0.3);
            padding: 5px 14px; border-radius: 999px;
            font-size: 12px; font-weight: 600;
            backdrop-filter: blur(8px);
        }
        .badge-video {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(251,146,60,0.2);
            color: #fdba74;
            border: 1px solid rgba(251,146,60,0.3);
            padding: 5px 14px; border-radius: 999px;
            font-size: 12px; font-weight: 600;
            backdrop-filter: blur(8px);
        }

        .task-title {
            font-size: 22px; font-weight: 700;
            color: #f1f5f9;
            line-height: 1.3;
            margin: 14px 0 4px;
        }
        .task-teacher {
            font-size: 13px; color: #64748b; font-weight: 500;
        }
        .task-teacher span { color: #94a3b8; }

        .desc-block {
            margin-top: 20px;
            padding: 16px 20px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
        }
        .desc-label {
            font-size: 11px; font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #475569;
            margin-bottom: 6px;
        }
        .desc-text {
            font-size: 14px; color: #94a3b8; line-height: 1.65;
        }

        /* Timeline riwayat */
        .section-header {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 15px; font-weight: 700;
            color: #1e293b;
        }
        .dark .section-title { color: #e2e8f0; }
        .section-count {
            background: #e2e8f0; color: #475569;
            font-size: 11px; font-weight: 700;
            padding: 2px 9px; border-radius: 999px;
        }
        .dark .section-count { background: #334155; color: #94a3b8; }

        .timeline { position: relative; padding-left: 28px; }
        .timeline::before {
            content: '';
            position: absolute; left: 9px; top: 8px; bottom: 8px;
            width: 2px;
            background: linear-gradient(to bottom, #e2e8f0, transparent);
        }
        .dark .timeline::before {
            background: linear-gradient(to bottom, #334155, transparent);
        }

        .timeline-item { position: relative; margin-bottom: 16px; }
        .timeline-dot {
            position: absolute; left: -24px; top: 16px;
            width: 12px; height: 12px; border-radius: 50%;
            border: 2px solid white;
        }
        .dark .timeline-dot { border-color: #1e293b; }
        .dot-approved { background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,0.15); }
        .dot-rejected { background: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.15); }

        .log-card {
            border-radius: 14px;
            padding: 16px 18px;
            border: 1.5px solid;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .log-card:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(0,0,0,0.07); }

        .log-approved {
            background: #f0fdf4;
            border-color: #bbf7d0;
        }
        .dark .log-approved {
            background: rgba(34,197,94,0.07);
            border-color: rgba(34,197,94,0.2);
        }
        .log-rejected {
            background: #fff1f2;
            border-color: #fecdd3;
        }
        .dark .log-rejected {
            background: rgba(239,68,68,0.07);
            border-color: rgba(239,68,68,0.2);
        }

        .log-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; margin-bottom: 10px; }
        .attempt-label {
            font-size: 12px; font-weight: 700; letter-spacing: 0.04em;
            text-transform: uppercase;
            display: flex; align-items: center; gap: 6px;
        }
        .attempt-approved { color: #16a34a; }
        .dark .attempt-approved { color: #4ade80; }
        .attempt-rejected { color: #dc2626; }
        .dark .attempt-rejected { color: #f87171; }

        .attempt-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 999px;
            font-size: 11px; font-weight: 700;
        }
        .badge-approved { background: #dcfce7; color: #15803d; }
        .dark .badge-approved { background: rgba(34,197,94,0.15); color: #4ade80; }
        .badge-rejected { background: #fee2e2; color: #b91c1c; }
        .dark .badge-rejected { background: rgba(239,68,68,0.15); color: #f87171; }

        .log-time {
            font-size: 11px; color: #94a3b8; font-weight: 500;
            white-space: nowrap;
        }
        .log-feedback {
            font-size: 13.5px; color: #374151; line-height: 1.6;
            margin-bottom: 8px;
        }
        .dark .log-feedback { color: #cbd5e1; }
        .log-teacher {
            font-size: 11.5px; color: #9ca3af; font-weight: 500;
        }
        .log-teacher strong { color: #6b7280; }
        .dark .log-teacher strong { color: #94a3b8; }

        /* Action bar */
        .action-bar {
            display: flex; gap: 12px; align-items: center;
            padding: 16px 20px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
        }
        .dark .action-bar {
            background: rgba(255,255,255,0.03);
            border-color: rgba(255,255,255,0.07);
        }
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 20px; border-radius: 10px;
            background: white; border: 1.5px solid #e2e8f0;
            color: #374151; font-size: 13.5px; font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
        }
        .dark .btn-back {
            background: #1e293b; border-color: #334155; color: #e2e8f0;
        }
        .btn-back:hover { border-color: #94a3b8; background: #f1f5f9; }
        .dark .btn-back:hover { background: #273549; }

        .btn-redo {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 20px; border-radius: 10px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white; font-size: 13.5px; font-weight: 600;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(239,68,68,0.35);
            transition: all 0.15s;
        }
        .btn-redo:hover {
            background: linear-gradient(135deg, #f87171, #ef4444);
            box-shadow: 0 4px 14px rgba(239,68,68,0.45);
            transform: translateY(-1px);
        }

        .history-card {
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 18px;
            padding: 22px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .dark .history-card {
            background: rgba(255,255,255,0.03);
            border-color: rgba(255,255,255,0.06);
        }
    </style>

    <div class="detail-page max-w-2xl mx-auto" style="display: flex; flex-direction: column; gap: 20px;">

        <div class="task-hero">
            <div style="position:relative;z-index:1;">
                @if($this->task->type === 'voice_note')
                    <span class="badge-voice">🎵 Voice Note</span>
                @elseif($this->task->type === 'quiz')
                    <span class="badge-video" style="background:rgba(34,197,94,0.2);color:#4ade80;border-color:rgba(34,197,94,0.3);">📝 Kuis</span>
                @else
                    <span class="badge-video">🎬 Video</span>
                @endif

                <p class="task-title">{{ $this->task->title }}</p>
                <p class="task-teacher">Diberikan oleh <span>{{ $this->task->teacher?->name }}</span></p>

                <div class="desc-block">
                    <p class="desc-label">Perintah Tugas</p>
                    <p class="desc-text">{{ $this->task->description }}</p>
                </div>
            </div>
        </div>

        @if($this->task->type === 'quiz' && $this->submission)
            <div class="history-card" style="text-align:center;">
                <p class="section-title" style="margin-bottom:8px;">Nilai Kuis Kamu</p>
                <p style="font-size:40px;font-weight:800;color:#22c55e;margin:0;">{{ $this->submission->score }}</p>
                <p style="font-size:12.5px;color:#64748b;margin-top:6px;">
                    {{ $this->submission->quizAnswers->where('is_correct', true)->count() }} benar dari {{ $this->submission->quizAnswers->count() }} soal
                </p>
            </div>

            <div class="history-card">
                <p class="section-title" style="margin-bottom:14px;">Pembahasan Jawaban</p>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($this->submission->quizAnswers as $index => $answer)
                        @php $q = $answer->question; @endphp
                        <div style="padding:14px 16px;border-radius:12px;background:rgba(255,255,255,0.03);border:1px solid {{ $answer->is_correct ? 'rgba(34,197,94,0.25)' : 'rgba(239,68,68,0.25)' }};">
                            <p style="font-size:13.5px;font-weight:600;color:#e2e8f0;margin-bottom:8px;">
                                {{ $index + 1 }}. {{ $q?->question }}
                                <span style="float:right;font-size:12px;">{{ $answer->is_correct ? '✅' : '❌' }}</span>
                            </p>
                            <p style="font-size:12.5px;color:{{ $answer->is_correct ? '#4ade80' : '#f87171' }};margin-bottom:2px;">
                                Jawaban kamu: <strong>{{ strtoupper($answer->selected_option) }}.</strong> {{ $q?->{'option_' . $answer->selected_option} }}
                            </p>
                            @if(!$answer->is_correct)
                                <p style="font-size:12.5px;color:#4ade80;">
                                    Jawaban benar: <strong>{{ strtoupper($q?->correct_option) }}.</strong> {{ $q?->{'option_' . $q?->correct_option} }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($this->submission && $this->submission->logs->count() > 0)
            <div class="history-card">
                <div class="section-header">
                    <p class="section-title">Riwayat Koreksi</p>
                    <span class="section-count">{{ $this->submission->logs->count() }}x</span>
                </div>

                <div class="timeline">
                    @foreach($this->submission->logs()->with('teacher')->orderBy('attempt_number')->get() as $log)
                        <div class="timeline-item">
                            <div @class([
                                'timeline-dot',
                                'dot-approved' => $log->status_at_time === 'approved',
                                'dot-rejected' => $log->status_at_time !== 'approved',
                            ])></div>

                            <div @class([
                                'log-card',
                                'log-approved' => $log->status_at_time === 'approved',
                                'log-rejected' => $log->status_at_time !== 'approved',
                            ])>
                                <div class="log-header">
                                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                        <span @class([
                                            'attempt-label',
                                            'attempt-approved' => $log->status_at_time === 'approved',
                                            'attempt-rejected' => $log->status_at_time !== 'approved',
                                        ])>
                                            Percobaan {{ $log->attempt_number }}
                                        </span>
                                        <span @class([
                                            'attempt-badge',
                                            'badge-approved' => $log->status_at_time === 'approved',
                                            'badge-rejected' => $log->status_at_time !== 'approved',
                                        ])>
                                            {{ $log->status_at_time === 'approved' ? '✅ Disetujui' : '❌ Ditolak' }}
                                        </span>
                                    </div>
                                    <span class="log-time">{{ $log->created_at?->format('d M Y • H:i') }}</span>
                                </div>

                                <p class="log-feedback">{{ $log->feedback ?? 'Tidak ada catatan dari guru.' }}</p>

                                <p class="log-teacher">
                                    Dinilai oleh <strong>{{ $log->teacher?->name ?? 'Guru' }}</strong>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="action-bar">
            <a href="{{ route('filament.peserta.pages.tugas') }}" class="btn-back">
                ← Kembali
            </a>

            @if($this->submission?->status === 'rejected')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.kerjakan', ['task' => $this->task->id]) }}"
                   class="btn-redo">
                    🔄 Kerjakan Ulang
                </a>
            @endif
        </div>

    </div>
</x-filament-panels::page>