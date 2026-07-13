<div style="display:flex;flex-direction:column;gap:10px;max-height:60vh;overflow-y:auto;">
    @foreach($submission->quizAnswers as $index => $answer)
        @php $q = $answer->question; @endphp
        <div style="padding:14px 16px;border-radius:12px;background:rgba(0,0,0,0.02);border:1px solid {{ $answer->is_correct ? 'rgba(34,197,94,0.3)' : 'rgba(239,68,68,0.3)' }};">
            <p style="font-size:13.5px;font-weight:600;margin-bottom:8px;">
                {{ $index + 1 }}. {{ $q?->question }}
                <span style="float:right;">{{ $answer->is_correct ? '✅' : '❌' }}</span>
            </p>
            <p style="font-size:12.5px;color:{{ $answer->is_correct ? '#16a34a' : '#dc2626' }};margin-bottom:2px;">
                Jawaban murid: <strong>{{ strtoupper($answer->selected_option) }}.</strong> {{ $q?->{'option_' . $answer->selected_option} }}
            </p>
            @if(!$answer->is_correct)
                <p style="font-size:12.5px;color:#16a34a;">
                    Jawaban benar: <strong>{{ strtoupper($q?->correct_option) }}.</strong> {{ $q?->{'option_' . $q?->correct_option} }}
                </p>
            @endif
        </div>
    @endforeach
</div>
