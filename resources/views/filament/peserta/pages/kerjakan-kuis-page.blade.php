<x-filament-panels::page>

<div class="max-w-2xl mx-auto" style="display:flex;flex-direction:column;gap:20px;">

    <div style="position:relative;background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#0f172a 100%);border-radius:18px;padding:24px 26px;border:1px solid rgba(255,255,255,0.07);">
        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(34,197,94,0.18);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:5px 14px;border-radius:999px;font-size:12px;font-weight:600;">
            📝 Kuis · {{ $task->questions->count() }} Soal
        </span>
        <p style="font-size:20px;font-weight:700;color:#f1f5f9;margin:14px 0 4px;">{{ $task->title }}</p>
        <p style="font-size:13px;color:#64748b;font-weight:500;">Diberikan oleh <span style="color:#94a3b8;">{{ $task->teacher?->name }}</span></p>
        <p style="font-size:13.5px;color:#94a3b8;line-height:1.6;margin-top:14px;">{{ $task->description }}</p>
    </div>

    @if($task->questions->isEmpty())
        <div style="text-align:center;padding:60px 20px;color:#64748b;">
            Guru belum menambahkan soal untuk kuis ini.
        </div>
    @else
        <form wire:submit="submitQuiz" style="display:flex;flex-direction:column;gap:16px;">
            @foreach($task->questions as $index => $question)
                <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:16px;padding:20px 22px;">
                    <p style="font-size:14.5px;font-weight:600;color:#f1f5f9;margin-bottom:14px;line-height:1.5;">
                        {{ $index + 1 }}. {{ $question->question }}
                    </p>

                    <div style="display:flex;flex-direction:column;gap:8px;">
                        @foreach($question->getOptionsList() as $key => $label)
                            <label
                                style="display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:10px;border:1.5px solid {{ ($answers[$question->id] ?? null) === $key ? '#22c55e' : 'rgba(148,163,184,0.2)' }};background:{{ ($answers[$question->id] ?? null) === $key ? 'rgba(34,197,94,0.08)' : 'transparent' }};cursor:pointer;transition:all .12s;"
                            >
                                <input
                                    type="radio"
                                    name="answers-{{ $question->id }}"
                                    value="{{ $key }}"
                                    wire:model="answers.{{ $question->id }}"
                                    style="accent-color:#22c55e;width:16px;height:16px;"
                                >
                                <span style="font-size:13.5px;color:#e2e8f0;">
                                    <strong style="color:#64748b;">{{ strtoupper($key) }}.</strong>
                                    {{ $label }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div style="display:flex;justify-content:flex-end;gap:10px;padding-top:6px;">
                <a href="{{ route('filament.peserta.pages.tugas') }}"
                   style="height:40px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13.5px;font-weight:600;text-decoration:none;border:1px solid rgba(148,163,184,0.2);color:#e2e8f0;">
                    Batal
                </a>
                <button type="submit"
                        style="height:40px;padding:0 22px;border-radius:10px;border:none;font-size:13.5px;font-weight:700;color:#0f172a;background:#22c55e;cursor:pointer;">
                    Kumpulkan Kuis
                </button>
            </div>
        </form>
    @endif

</div>

</x-filament-panels::page>
