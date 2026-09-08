<x-filament-panels::page>

    <div class="kerjakan-page max-w-2xl mx-auto"
        style="display:flex; flex-direction:column; gap:18px;"
        @if($this->task->type !== 'quiz')
            x-data="recorderApp(@js($this->task->type))" x-init="init()"
        @endif
    >
        {{-- Hero Header Tugas --}}
        <div style="background: var(--fi-card-bg, #ffffff); border-radius: 20px; padding: 26px 28px; border: 1px solid rgba(148,163,184,0.25); box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
            <div style="position: relative; z-index: 1;">
                @if($this->task->type === 'voice_note')
                    <span style="display:inline-flex; align-items:center; gap:6px; background:rgba(59,130,246,0.1); color:#1d4ed8; border:1px solid rgba(59,130,246,0.2); padding:4px 14px; border-radius:999px; font-size:11.5px; font-weight:700;">🎵 Voice Note</span>
                @elseif($this->task->type === 'video')
                    <span style="display:inline-flex; align-items:center; gap:6px; background:rgba(245,158,11,0.1); color:#b45309; border:1px solid rgba(245,158,11,0.2); padding:4px 14px; border-radius:999px; font-size:11.5px; font-weight:700;">🎬 Video</span>
                @else
                    <span style="display:inline-flex; align-items:center; gap:6px; background:rgba(34,197,94,0.1); color:#15803d; border:1px solid rgba(34,197,94,0.2); padding:4px 14px; border-radius:999px; font-size:11.5px; font-weight:700;">📝 Kuis</span>
                @endif

                <p style="font-size:20px; font-weight:800; color:#0f172a; line-height:1.3; margin:12px 0 3px;">{{ $this->task->title }}</p>
                <p style="font-size:13px; color:#64748b;">Diberikan oleh <span style="color:#334155; font-weight:600;">{{ $this->task->teacher?->name }}</span></p>

                <div style="margin-top:16px; padding:14px 18px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px;">
                    <p style="font-size:10px; font-weight:700; letter-spacing:0.09em; text-transform:uppercase; color:#475569; margin-bottom:5px;">Perintah Tugas</p>
                    <p style="font-size:13.5px; color:#334155; line-height:1.65;">{{ $this->task->description }}</p>
                </div>

                @if($this->submission?->status === 'rejected')
                    @php $lastLog = $this->submission->logs()->latest()->first(); @endphp
                    <div style="display:flex; gap:10px; align-items:flex-start; margin-top:14px; padding:13px 15px; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.25); border-radius:12px;">
                        <div style="font-size:15px; line-height:1;">⚠️</div>
                        <div>
                            <p style="font-size:13px; font-weight:700; color:#b91c1c; margin-bottom:3px;">Percobaan sebelumnya ditolak</p>
                            @if($lastLog)
                                <p style="font-size:12.5px; color:#dc2626; line-height:1.55;">{{ $lastLog->feedback }}</p>
                            @else
                                <p style="font-size:12.5px; color:#dc2626; line-height:1.55;">Silakan perbaiki dan kirim ulang.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($this->task->type === 'quiz')
            <x-filament::card style="background: var(--fi-card-bg, #ffffff); border: 1px solid rgba(148,163,184,0.25); border-radius: 18px;">
                @if($this->task->google_form_url)
                    <div style="border-radius:14px; padding:16px 18px; margin-bottom:12px; background:#eff6ff; border:1px solid #bfdbfe;">
                        <p style="font-size:13px; font-weight:700; color:#1d4ed8; margin-bottom:10px;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:20px; height:20px; border-radius:999px; font-size:11px; font-weight:800; margin-right:6px; vertical-align:middle; background:#3b82f6; color:white;">1</span>
                            Kerjakan kuis di Google Form
                        </p>
                        <a href="{{ $this->task->google_form_url }}" target="_blank" style="display:inline-flex; align-items:center; gap:8px; padding:9px 20px; border-radius:10px; font-size:13px; font-weight:700; background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; text-decoration:none; box-shadow:0 2px 10px rgba(59,130,246,0.3);">
                            🔗 Buka Google Form
                        </a>
                    </div>
                @endif

                <div style="border-radius:14px; padding:16px 18px; margin-bottom:0; background:#fffbeb; border:1px solid #fde68a;">
                    <p style="font-size:13px; font-weight:700; color:#b45309; margin-bottom:6px;">
                        <span style="display:inline-flex; align-items:center; justify-content:center; width:20px; height:20px; border-radius:999px; font-size:11px; font-weight:800; margin-right:6px; vertical-align:middle; background:#f59e0b; color:white;">2</span>
                        Upload screenshot bukti pengerjaan
                    </p>
                    <p style="font-size:12.5px; color:#92400e; margin-bottom:10px; line-height:1.55;">Screenshot halaman konfirmasi Google Form setelah submit. Format: JPG, PNG, WEBP — Maks 10MB.</p>

                    <label style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; border: 2px dashed #cbd5e1; border-radius: 12px; background: #ffffff; cursor: pointer;">
                        <input type="file"
                            wire:model="screenshotFile"
                            accept="image/jpeg,image/png,image/webp"
                            style="display:none;">
                        <span style="font-size: 24px; margin-bottom: 6px;">🖼️</span>
                        <span style="font-size: 13.5px; font-weight: 700; color: #d97706;" x-text="$wire.screenshotFile ? '✓ File Terpilih' : 'Pilih Gambar Screenshot'"></span>
                    </label>

                    <div wire:loading wire:target="screenshotFile" style="margin-top:8px; font-size:13px; color:#d97706;">
                        ⏳ Mengupload...
                    </div>
                    @error('screenshotFile')
                        <p style="margin-top:8px; font-size:13px; color:#dc2626;">{{ $message }}</p>
                    @enderror
                </div>
            </x-filament::card>

            <div style="display:flex; gap:10px; align-items:center; padding:14px 18px; background:var(--fi-card-bg, #ffffff); border:1px solid rgba(148,163,184,0.25); border-radius:16px; justify-content:space-between; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <a href="{{ route('filament.peserta.pages.tugas') }}" style="display:inline-flex; align-items:center; padding:9px 18px; border-radius:10px; background:white; border:1.5px solid #cbd5e1; color:#374151; font-size:13px; font-weight:600; text-decoration:none;">← Batal</a>
                <button type="button"
                    wire:click="submit"
                    wire:loading.attr="disabled"
                    style="display:inline-flex; align-items:center; gap:6px; padding:9px 22px; border-radius:10px; font-size:13px; font-weight:700; background:linear-gradient(135deg,#f59e0b,#d97706); color:white; border:none; cursor:pointer; box-shadow:0 2px 10px rgba(245,158,11,0.35);">
                    <span wire:loading.remove wire:target="submit">
                        {{ $this->submission?->status === 'rejected' ? '📤 Kirim Bukti Ulang' : '📤 Kirim Bukti' }}
                    </span>
                    <span wire:loading wire:target="submit">⏳ Mengirim...</span>
                </button>
            </div>

        @else

            <x-filament::card style="background: var(--fi-card-bg, #ffffff); border: 1px solid rgba(148,163,184,0.25); border-radius: 18px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px; margin-bottom:20px; background:#f1f5f9; border-radius:12px; padding:5px;">
                    <button type="button"
                        wire:click="setMode('record')"
                        @click="resetRecorder()"
                        style="display:flex; align-items:center; justify-content:center;"
                        class="flex-1 py-2 px-4 rounded-lg text-sm font-medium border transition
                            {{ $this->mode === 'record' ? 'bg-white border-white text-gray-900 shadow-sm' : 'border-transparent text-gray-600 hover:bg-gray-200' }}">
                        🎙️ Rekam Langsung
                    </button>
                    <button type="button"
                        wire:click="setMode('upload')"
                        @click="resetRecorder()"
                        style="display:flex; align-items:center; justify-content:center;"
                        class="flex-1 py-2 px-4 rounded-lg text-sm font-medium border transition
                            {{ $this->mode === 'upload' ? 'bg-white border-white text-gray-900 shadow-sm' : 'border-transparent text-gray-600 hover:bg-gray-200' }}">
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
                            <p style="font-size:28px; font-weight:800; font-variant-numeric:tabular-nums; color:#0f172a; letter-spacing:0.03em;"
                                x-show="isRecording || recordingTime > 0"
                                x-text="formatTime(recordingTime)">
                            </p>
                            <div class="flex justify-center gap-4 w-full">
                                <button type="button" x-show="!isRecording && !hasRecording"
                                    @click="startRecording()"
                                    style="display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 28px; border-radius:14px; font-size:13.5px; font-weight:700; background:linear-gradient(135deg, #4f46e5, #3730a3); color:white; border:1px solid rgba(255,255,255,0.15); cursor:pointer;">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>🎙️ Mulai Rekam
                                </button>
                                <button type="button" x-show="isRecording"
                                    @click="stopRecording()"
                                    style="display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 28px; border-radius:14px; font-size:13.5px; font-weight:700; background:linear-gradient(135deg, #1e293b, #0f172a); color:#f1f5f9; border:1px solid rgba(255,255,255,0.15); cursor:pointer;">
                                    <span class="w-2 h-2 bg-red-500 rounded-sm animate-ping"></span>⏹️ Stop
                                </button>
                                <button type="button" x-show="hasRecording && !isRecording"
                                    @click="resetRecorder()"
                                    style="display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:12px 24px; border-radius:14px; font-size:13.5px; font-weight:600; background:#f8fafc; border:1.5px solid #cbd5e1; color:#334155; cursor:pointer;">
                                    🔄 Ulangi
                                </button>
                            </div>
                            <div x-show="hasRecording && !isRecording" class="w-full space-y-2">
                                <p class="text-xs text-gray-600 text-center">Preview hasil rekaman:</p>
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
                            <div class="flex justify-center gap-4 w-full">
                                <button type="button" x-show="!isRecording && !hasRecording"
                                    @click="startRecording()"
                                    style="display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 28px; border-radius:14px; font-size:13.5px; font-weight:700; background:linear-gradient(135deg, #4f46e5, #3730a3); color:white; border:1px solid rgba(255,255,255,0.15); cursor:pointer;">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>📷 Mulai Rekam
                                </button>
                                <button type="button" x-show="isRecording"
                                    @click="stopRecording()"
                                    style="display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 28px; border-radius:14px; font-size:13.5px; font-weight:700; background:linear-gradient(135deg, #1e293b, #0f172a); color:#f1f5f9; border:1px solid rgba(255,255,255,0.15); cursor:pointer;">
                                    <span class="w-2 h-2 bg-red-500 rounded-sm animate-ping"></span>⏹️ Stop
                                </button>
                                <button type="button" x-show="hasRecording && !isRecording"
                                    @click="resetRecorder()"
                                    style="display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:12px 24px; border-radius:14px; font-size:13.5px; font-weight:600; background:#f8fafc; border:1.5px solid #cbd5e1; color:#334155; cursor:pointer;">
                                    🔄 Ulangi
                                </button>
                            </div>
                            <p x-show="!cameraReady && !isRecording && !hasRecording" class="text-sm text-gray-600 text-center">
                                Klik "Mulai Rekam" untuk mengaktifkan kamera.
                            </p>
                        </div>
                    @endif
                @endif

                @if($this->mode === 'upload')
                    <div class="space-y-3">
                        <div style="font-size:13px; color:#334155; line-height:1.6; padding:11px 14px; background:#f8fafc; border-radius:10px; border:1px dashed #cbd5e1; margin-bottom:4px;">
                            Format yang diterima: <strong style="color:#d97706;">{{ $this->task->type === 'voice_note' ? 'MP3, WAV, WEBM' : 'MP4, WEBM' }}</strong>
                            — Maks <strong style="color:#d97706;">50MB</strong>.
                        </div>
                        
                        <label style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; border: 2px dashed #cbd5e1; border-radius: 12px; background: #ffffff; cursor: pointer;">
                            <input type="file"
                                wire:model="uploadedFile"
                                accept="{{ $this->task->type === 'voice_note' ? 'audio/*' : 'video/*' }}"
                                style="display:none;">
                            <span style="font-size: 26px; margin-bottom: 6px;">{{ $this->task->type === 'voice_note' ? '📁' : '🎥' }}</span>
                            <span style="font-size: 14px; font-weight: 700; color: #d97706;" x-text="$wire.uploadedFile ? '✓ File Berhasil Dipilih' : 'Klik untuk Pilih File Tugas'"></span>
                        </label>

                        <div wire:loading wire:target="uploadedFile" style="font-size:13px; color:#d97706; text-align:center; margin-top:4px;">
                            ⏳ Mengupload...
                        </div>
                        @error('uploadedFile')
                            <p style="font-size:13px; color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </x-filament::card>

            <div style="display:flex; gap:10px; align-items:center; padding:14px 18px; background:var(--fi-card-bg, #ffffff); border:1px solid rgba(148,163,184,0.25); border-radius:16px; justify-content:space-between; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <a href="{{ route('filament.peserta.pages.tugas') }}" style="display:inline-flex; align-items:center; padding:9px 18px; border-radius:10px; background:white; border:1.5px solid #cbd5e1; color:#374151; font-size:13px; font-weight:600; text-decoration:none;">← Batal</a>
                <button type="button"
                    @click="submitForm()"
                    x-bind:disabled="isRecording || (mode === 'record' && !hasRecording)"
                    x-bind:class="(isRecording || (mode === 'record' && !hasRecording))
                        ? 'bg-gray-200 text-gray-400 shadow-none cursor-not-allowed'
                        : ''"
                    style="display:inline-flex; align-items:center; gap:6px; padding:9px 22px; border-radius:10px; font-size:13px; font-weight:700; background:linear-gradient(135deg,#f59e0b,#d97706); color:white; border:none; cursor:pointer; box-shadow:0 2px 10px rgba(245,158,11,0.35);">
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