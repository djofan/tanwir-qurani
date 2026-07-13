<x-filament-panels::page>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        .kerjakan-page * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .task-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
            border-radius: 20px; padding: 26px 28px;
            position: relative; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.07);
            margin-bottom: 0;
        }
        .task-hero::before {
            content:''; position:absolute; top:-70px; right:-70px;
            width:220px; height:220px;
            background: radial-gradient(circle, rgba(99,102,241,0.22) 0%, transparent 70%);
            border-radius:50%; pointer-events:none;
        }
        .task-hero::after {
            content:''; position:absolute; bottom:-50px; left:30px;
            width:160px; height:160px;
            background: radial-gradient(circle, rgba(34,211,238,0.10) 0%, transparent 70%);
            border-radius:50%; pointer-events:none;
        }
        .hero-inner { position:relative; z-index:1; }
        .type-badge {
            display:inline-flex; align-items:center; gap:6px;
            padding:4px 14px; border-radius:999px;
            font-size:11.5px; font-weight:700;
        }
        .badge-voice { background:rgba(99,102,241,0.2); color:#a5b4fc; border:1px solid rgba(99,102,241,0.3); }
        .badge-video { background:rgba(251,146,60,0.2); color:#fdba74; border:1px solid rgba(251,146,60,0.3); }
        .badge-quiz  { background:rgba(34,197,94,0.2);  color:#86efac; border:1px solid rgba(34,197,94,0.3); }
        .hero-title  { font-size:20px; font-weight:800; color:#f1f5f9; line-height:1.3; margin:12px 0 3px; }
        .hero-teacher { font-size:13px; color:#64748b; }
        .hero-teacher span { color:#94a3b8; }
        .hero-desc {
            margin-top:16px; padding:14px 18px;
            background:rgba(255,255,255,0.04);
            border:1px solid rgba(255,255,255,0.08); border-radius:12px;
        }
        .hero-desc-label {
            font-size:10px; font-weight:700; letter-spacing:0.09em;
            text-transform:uppercase; color:#475569; margin-bottom:5px;
        }
        .hero-desc-text { font-size:13.5px; color:#94a3b8; line-height:1.65; }
        .hero-alert {
            display:flex; gap:10px; align-items:flex-start;
            margin-top:14px; padding:13px 15px;
            background:rgba(239,68,68,0.10);
            border:1px solid rgba(239,68,68,0.25); border-radius:12px;
        }
        .hero-alert-title { font-size:13px; font-weight:700; color:#fca5a5; margin-bottom:3px; }
        .hero-alert-body  { font-size:12.5px; color:#f87171; line-height:1.55; }

        .mode-tabs {
            display:grid; grid-template-columns:1fr 1fr;
            gap:6px; margin-bottom:20px;
            background:#f8fafc; border-radius:12px; padding:5px;
        }
        .dark .mode-tabs { background:rgba(255,255,255,0.04); }
        .mode-tab-active {
            background:#fff !important; color:#1e293b !important;
            border-color:#fff !important;
            box-shadow:0 1px 4px rgba(0,0,0,0.10) !important;
        }
        .dark .mode-tab-active {
            background:#1e293b !important; color:#e2e8f0 !important;
            border-color:#1e293b !important;
        }

        .rec-time {
            font-size:28px; font-weight:800; font-variant-numeric:tabular-nums;
            color:#1e293b; letter-spacing:0.03em;
        }
        .dark .rec-time { color:#e2e8f0; }

        .step-box { border-radius:14px; padding:16px 18px; margin-bottom:12px; }
        .step-blue  { background:#eff6ff; border:1px solid #bfdbfe; }
        .dark .step-blue  { background:rgba(59,130,246,0.07); border-color:rgba(59,130,246,0.2); }
        .step-amber { background:#fffbeb; border:1px solid #fde68a; }
        .dark .step-amber { background:rgba(245,158,11,0.07); border-color:rgba(245,158,11,0.2); }
        .step-num {
            display:inline-flex; align-items:center; justify-content:center;
            width:20px; height:20px; border-radius:999px;
            font-size:11px; font-weight:800; margin-right:6px; vertical-align:middle;
        }
        .step-num-blue  { background:#3b82f6; color:white; }
        .step-num-amber { background:#f59e0b; color:white; }
        .step-title-blue  { font-size:13px; font-weight:700; color:#1d4ed8; margin-bottom:10px; }
        .dark .step-title-blue  { color:#93c5fd; }
        .step-title-amber { font-size:13px; font-weight:700; color:#b45309; margin-bottom:6px; }
        .dark .step-title-amber { color:#fcd34d; }
        .step-hint { font-size:12px; color:#92400e; margin-bottom:10px; line-height:1.55; }
        .dark .step-hint { color:#fbbf24; }
        
        /* Utility Buttons */
        .btn-gform {
            display:inline-flex; align-items:center; gap:8px;
            padding:9px 20px; border-radius:10px; font-size:13px; font-weight:700;
            background:linear-gradient(135deg,#3b82f6,#2563eb); color:white;
            text-decoration:none; box-shadow:0 2px 10px rgba(59,130,246,0.3); transition:all 0.15s;
        }
        .btn-gform:hover { box-shadow:0 4px 16px rgba(59,130,246,0.4); transform:translateY(-1px); }

        /* Recorder Custom Buttons */
        .btn-rec-start {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 24px; border-radius: 12px; font-size: 13.5px; font-weight: 700;
            background: linear-gradient(135deg, #ef4444, #dc2626); color: white;
            border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            transition: all 0.15s;
        }
        .btn-rec-start:hover { box-shadow: 0 6px 18px rgba(239, 68, 68, 0.45); transform: translateY(-1px); }
        
        .btn-rec-stop {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 24px; border-radius: 12px; font-size: 13.5px; font-weight: 700;
            background: linear-gradient(135deg, #4b5563, #374151); color: white;
            border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(75, 85, 99, 0.2);
            transition: all 0.15s;
        }
        .btn-rec-stop:hover { box-shadow: 0 6px 18px rgba(75, 85, 99, 0.35); transform: translateY(-1px); }

        .btn-rec-repeat {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 20px; border-radius: 12px; font-size: 13.5px; font-weight: 600;
            background: white; border: 1.5px solid #e2e8f0; color: #374151;
            cursor: pointer; transition: all 0.15s;
        }
        .dark .btn-rec-repeat { background: #1e293b; border-color: #334155; color: #e2e8f0; }
        .btn-rec-repeat:hover { border-color: #94a3b8; background: #f8fafc; }
        .dark .btn-rec-repeat:hover { background: #1e293b; border-color: #475569; }

        .upload-hint {
            font-size:13px; color:#64748b; line-height:1.6;
            padding:11px 14px; background:#f8fafc;
            border-radius:10px; border:1px dashed #e2e8f0;
            margin-bottom: 4px;
        }
        .dark .upload-hint { background:rgba(255,255,255,0.03); border-color:rgba(255,255,255,0.1); color:#94a3b8; }
        .upload-hint strong { color:#f59e0b; }

        .action-bar {
            display:flex; gap:10px; align-items:center;
            padding:14px 18px; background:#f8fafc;
            border:1px solid #e2e8f0; border-radius:16px;
            justify-content: space-between;
        }
        .dark .action-bar { background:rgba(255,255,255,0.03); border-color:rgba(255,255,255,0.07); }
        .btn-cancel {
            display:inline-flex; align-items:center;
            padding:9px 18px; border-radius:10px;
            background:white; border:1.5px solid #e2e8f0;
            color:#374151; font-size:13px; font-weight:600;
            text-decoration:none; transition:all 0.15s;
        }
        .dark .btn-cancel { background:#1e293b; border-color:#334155; color:#e2e8f0; }
        .btn-cancel:hover { border-color:#94a3b8; }
        .btn-submit-primary {
            display:inline-flex; align-items:center; gap:6px;
            padding:9px 22px; border-radius:10px; font-size:13px; font-weight:700;
            background:linear-gradient(135deg,#f59e0b,#d97706); color:white;
            border:none; cursor:pointer;
            box-shadow:0 2px 10px rgba(245,158,11,0.35); transition:all 0.15s;
        }
        .btn-submit-primary:hover:not(:disabled) {
            box-shadow:0 4px 16px rgba(245,158,11,0.45); transform:translateY(-1px);
        }
        .btn-submit-primary:disabled { background:#d1d5db; color:#9ca3af; cursor:not-allowed; box-shadow:none; }
        audio, video { border-radius:10px; }
    </style>

    <div class="kerjakan-page max-w-2xl mx-auto"
        style="display:flex; flex-direction:column; gap:18px;"
        @if($this->task->type !== 'quiz')
            x-data="recorderApp(@js($this->task->type))" x-init="init()"
        @endif
    >
        <div class="task-hero">
            <div class="hero-inner">
                @if($this->task->type === 'voice_note')
                    <span class="type-badge badge-voice">🎵 Voice Note</span>
                @elseif($this->task->type === 'video')
                    <span class="type-badge badge-video">🎬 Video</span>
                @else
                    <span class="type-badge badge-quiz">📝 Kuis</span>
                @endif

                <p class="hero-title">{{ $this->task->title }}</p>
                <p class="hero-teacher">Diberikan oleh <span>{{ $this->task->teacher?->name }}</span></p>

                <div class="hero-desc">
                    <p class="hero-desc-label">Perintah Tugas</p>
                    <p class="hero-desc-text">{{ $this->task->description }}</p>
                </div>

                @if($this->submission?->status === 'rejected')
                    @php $lastLog = $this->submission->logs()->latest()->first(); @endphp
                    <div class="hero-alert">
                        <div style="font-size:15px;line-height:1;">⚠️</div>
                        <div>
                            <p class="hero-alert-title">Percobaan sebelumnya ditolak</p>
                            @if($lastLog)
                                <p class="hero-alert-body">{{ $lastLog->feedback }}</p>
                            @else
                                <p class="hero-alert-body">Silakan perbaiki dan kirim ulang.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($this->task->type === 'quiz')
            <x-filament::card>
                @if($this->task->google_form_url)
                    <div class="step-box step-blue">
                        <p class="step-title-blue">
                            <span class="step-num step-num-blue">1</span>
                            Kerjakan kuis di Google Form
                        </p>
                        <a href="{{ $this->task->google_form_url }}" target="_blank" class="btn-gform">
                            🔗 Buka Google Form
                        </a>
                    </div>
                @endif

                <div class="step-box step-amber" style="margin-bottom:0;">
                    <p class="step-title-amber">
                        <span class="step-num step-num-amber">2</span>
                        Upload screenshot bukti pengerjaan
                    </p>
                    <p class="step-hint">Screenshot halaman konfirmasi Google Form setelah submit. Format: JPG, PNG, WEBP — Maks 10MB.</p>

                    <input type="file"
                        wire:model="screenshotFile"
                        accept="image/jpeg,image/png,image/webp"
                        class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4 file:rounded-lg
                            file:border-0 file:text-sm file:font-medium
                            file:bg-amber-100 file:text-amber-700
                            hover:file:bg-amber-200 dark:file:bg-amber-900/50 dark:file:text-amber-400">

                    <div wire:loading wire:target="screenshotFile" class="mt-2 text-sm text-amber-600">
                        ⏳ Mengupload...
                    </div>
                    @error('screenshotFile')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </x-filament::card>

            <div class="action-bar">
                <a href="{{ route('filament.peserta.pages.tugas') }}" class="btn-cancel">← Batal</a>
                <button type="button"
                    wire:click="submit"
                    wire:loading.attr="disabled"
                    class="btn-submit-primary">
                    <span wire:loading.remove wire:target="submit">
                        {{ $this->submission?->status === 'rejected' ? '📤 Kirim Bukti Ulang' : '📤 Kirim Bukti' }}
                    </span>
                    <span wire:loading wire:target="submit">⏳ Mengirim...</span>
                </button>
            </div>

        @else

            <x-filament::card>
                <div class="mode-tabs">
                    <button type="button"
                        wire:click="setMode('record')"
                        @click="resetRecorder()"
                        class="flex-1 py-2 px-4 rounded-lg text-sm font-medium border transition
                            {{ $this->mode === 'record' ? 'mode-tab-active bg-white border-white text-gray-900' : 'border-transparent text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        🎙️ Rekam Langsung
                    </button>
                    <button type="button"
                        wire:click="setMode('upload')"
                        @click="resetRecorder()"
                        class="flex-1 py-2 px-4 rounded-lg text-sm font-medium border transition
                            {{ $this->mode === 'upload' ? 'mode-tab-active bg-white border-white text-gray-900' : 'border-transparent text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        📁 Upload File
                    </button>
                </div>

                @if($this->mode === 'record')
                    @if($this->task->type === 'voice_note')
                        <div class="flex flex-col items-center gap-4 py-4">
                            <canvas x-ref="visualizer" width="400" height="72"
                                class="w-full rounded-xl"
                                style="background:#0f172a;"
                                x-show="isRecording">
                            </canvas>
                            <p class="rec-time"
                                x-show="isRecording || recordingTime > 0"
                                x-text="formatTime(recordingTime)">
                            </p>
                            <div class="flex gap-3">
                                <button type="button" x-show="!isRecording && !hasRecording"
                                    @click="startRecording()"
                                    class="btn-rec-start">
                                    <span class="w-2.5 h-2.5 bg-white rounded-full animate-ping"></span>🔴 Mulai Rekam
                                </button>
                                <button type="button" x-show="isRecording"
                                    @click="stopRecording()"
                                    class="btn-rec-stop">
                                    <span class="w-2.5 h-2.5 bg-white rounded-sm"></span> ⏹️ Stop
                                </button>
                                <button type="button" x-show="hasRecording && !isRecording"
                                    @click="resetRecorder()"
                                    class="btn-rec-repeat">
                                    🔄 Ulangi Rekaman
                                </button>
                            </div>
                            <div x-show="hasRecording && !isRecording" class="w-full space-y-2">
                                <p class="text-xs text-gray-500 text-center">Preview hasil rekaman:</p>
                                <audio x-ref="audioPreview" controls class="w-full"></audio>
                            </div>
                        </div>
                    @endif

                    @if($this->task->type === 'video')
                        <div class="flex flex-col items-center gap-4 py-4">
                            <div class="relative w-full">
                                <video x-ref="videoPreview" autoplay muted playsinline
                                    x-show="isRecording || (!hasRecording && cameraReady)"
                                    class="w-full rounded-xl bg-black max-h-64">
                                </video>
                                <div x-show="isRecording"
                                    class="absolute top-3 left-3 flex items-center gap-1.5 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> REC
                                </div>
                                <div x-show="isRecording"
                                    class="absolute top-3 right-3 bg-black/60 text-white text-sm font-mono px-2 py-1 rounded-lg">
                                    <span x-text="formatTime(recordingTime)"></span>
                                </div>
                            </div>
                            <video x-ref="recordedVideo" controls
                                x-show="hasRecording && !isRecording"
                                class="w-full rounded-xl bg-black max-h-64">
                            </video>
                            <div class="flex gap-3">
                                <button type="button" x-show="!isRecording && !hasRecording"
                                    @click="startRecording()"
                                    class="btn-rec-start">
                                    <span class="w-2.5 h-2.5 bg-white rounded-full animate-ping"></span>🔴 Mulai Rekam
                                </button>
                                <button type="button" x-show="isRecording"
                                    @click="stopRecording()"
                                    class="btn-rec-stop">
                                    <span class="w-2.5 h-2.5 bg-white rounded-sm"></span> ⏹️ Stop
                                </button>
                                <button type="button" x-show="hasRecording && !isRecording"
                                    @click="resetRecorder()"
                                    class="btn-rec-repeat">
                                    🔄 Ulangi Rekaman
                                </button>
                            </div>
                            <p x-show="!cameraReady && !isRecording && !hasRecording" class="text-sm text-gray-500 text-center">
                                Klik "Mulai Rekam" untuk mengaktifkan kamera.
                            </p>
                        </div>
                    @endif
                @endif

                @if($this->mode === 'upload')
                    <div class="space-y-3">
                        <div class="upload-hint">
                            Format yang diterima: <strong>{{ $this->task->type === 'voice_note' ? 'MP3, WAV, WEBM' : 'MP4, WEBM' }}</strong>
                            — Maks <strong>50MB</strong>.
                        </div>
                        <input type="file"
                            wire:model="uploadedFile"
                            accept="{{ $this->task->type === 'voice_note' ? 'audio/*' : 'video/*' }}"
                            class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg
                                file:border-0 file:text-sm file:font-medium
                                file:bg-amber-50 file:text-amber-700
                                hover:file:bg-amber-100 dark:file:bg-amber-900/30 dark:file:text-amber-400">
                        <div wire:loading wire:target="uploadedFile" class="text-sm text-amber-600">
                             Mengupload...
                        </div>
                        @error('uploadedFile')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </x-filament::card>

            <div class="action-bar">
                <a href="{{ route('filament.peserta.pages.tugas') }}" class="btn-cancel">← Batal</a>
                <button type="button"
                    @click="submitForm()"
                    x-bind:disabled="isRecording || (mode === 'record' && !hasRecording)"
                    x-bind:class="(isRecording || (mode === 'record' && !hasRecording))
                        ? 'btn-submit-primary !bg-gray-200 !text-gray-400 !shadow-none !cursor-not-allowed'
                        : 'btn-submit-primary'"
                    class="btn-submit-primary">
                    {{ $this->submission?->status === 'rejected' ? '📤 Submit Ulang' : '📤 Kumpulkan Tugas' }}
                </button>
            </div>

            <script>
                function recorderApp(taskType) {
                    return {
                        taskType:      taskType,
                        isRecording:   false,
                        hasRecording:  false,
                        cameraReady:   false,
                        recordingTime: 0,
                        timer:         null,
                        mediaRecorder: null,
                        chunks:        [],
                        stream:        null,
                        blob:          null,
                        mode:          @js($this->mode),

                        init() {
                            this.$watch('$wire.mode', (val) => { this.mode = val; });
                        },

                        formatTime(seconds) {
                            const m = String(Math.floor(seconds / 60)).padStart(2, '0');
                            const s = String(seconds % 60).padStart(2, '0');
                            return `${m}:${s}`;
                        },

                        async startRecording() {
                            try {
                                const constraints = this.taskType === 'voice_note'
                                    ? { audio: true }
                                    : { audio: true, video: true };
                                this.stream = await navigator.mediaDevices.getUserMedia(constraints);
                                if (this.taskType === 'video' && this.$refs.videoPreview) {
                                    this.$refs.videoPreview.srcObject = this.stream;
                                    this.cameraReady = true;
                                }
                                if (this.taskType === 'voice_note') this.startVisualizer();
                                this.chunks        = [];
                                this.mediaRecorder = new MediaRecorder(this.stream);
                                this.mediaRecorder.ondataavailable = (e) => {
                                    if (e.data.size > 0) this.chunks.push(e.data);
                                };
                                this.mediaRecorder.onstop = () => {
                                    this.blob = new Blob(this.chunks, {
                                        type: this.taskType === 'voice_note' ? 'audio/webm' : 'video/webm'
                                    });
                                    const url = URL.createObjectURL(this.blob);
                                    if (this.taskType === 'voice_note' && this.$refs.audioPreview) {
                                        this.$refs.audioPreview.src = url;
                                    }
                                    if (this.taskType === 'video' && this.$refs.recordedVideo) {
                                        this.$refs.recordedVideo.src = url;
                                        this.$refs.videoPreview.srcObject = null;
                                    }
                                    this.hasRecording = true;
                                    const reader = new FileReader();
                                    reader.onload = () => {
                                        const fileName = `rekaman_${Date.now()}.webm`;
                                        @this.call('saveRecordedData', reader.result, fileName);
                                    };
                                    reader.onloadend = () => {
                                        @this.set('hasRecording', true);
                                    };
                                    reader.readAsDataURL(this.blob);
                                };
                                this.mediaRecorder.start();
                                this.isRecording   = true;
                                this.recordingTime = 0;
                                this.timer = setInterval(() => { this.recordingTime++; }, 1000);
                            } catch (err) {
                                alert('Tidak bisa mengakses mikrofon/kamera.\n\nError: ' + err.message);
                            }
                        },

                        stopRecording() {
                            if (this.mediaRecorder && this.isRecording) {
                                this.mediaRecorder.stop();
                                this.isRecording = false;
                                clearInterval(this.timer);
                                if (this.stream) this.stream.getTracks().forEach(t => t.stop());
                            }
                        },

                        resetRecorder() {
                            this.stopRecording();
                            this.hasRecording  = false;
                            this.cameraReady   = false;
                            this.recordingTime = 0;
                            this.chunks        = [];
                            this.blob          = null;
                            if (this.$refs.audioPreview)  this.$refs.audioPreview.src = '';
                            if (this.$refs.recordedVideo) this.$refs.recordedVideo.src = '';
                            @this.set('recordedFileData', null);
                            @this.set('hasRecording', false);
                        },

                        startVisualizer() {
                            const canvas   = this.$refs.visualizer;
                            if (!canvas) return;
                            const ctx      = canvas.getContext('2d');
                            const audioCtx = new AudioContext();
                            const source   = audioCtx.createMediaStreamSource(this.stream);
                            const analyser = audioCtx.createAnalyser();
                            analyser.fftSize = 256;
                            source.connect(analyser);
                            const bufferLength = analyser.frequencyBinCount;
                            const dataArray    = new Uint8Array(bufferLength);
                            const draw = () => {
                                if (!this.isRecording) return;
                                requestAnimationFrame(draw);
                                analyser.getByteFrequencyData(dataArray);
                                ctx.clearRect(0, 0, canvas.width, canvas.height);
                                ctx.fillStyle = '#0f172a';
                                ctx.fillRect(0, 0, canvas.width, canvas.height);
                                const barWidth = (canvas.width / bufferLength) * 2.5;
                                let x = 0;
                                for (let i = 0; i < bufferLength; i++) {
                                    const barHeight = dataArray[i] / 2;
                                    const g = ctx.createLinearGradient(0, canvas.height - barHeight, 0, canvas.height);
                                    g.addColorStop(0, '#f59e0b');
                                    g.addColorStop(1, '#d97706');
                                    ctx.fillStyle = g;
                                    ctx.fillRect(x, canvas.height - barHeight, barWidth, barHeight);
                                    x += barWidth + 1;
                                }
                            };
                            draw();
                        },

                        submitForm() {
                            @this.call('submit');
                        },
                    };
                }
            </script>
        @endif

    </div>
</x-filament-panels::page>