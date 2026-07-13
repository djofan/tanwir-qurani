<x-filament-widgets::widget>
    <div style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);border-radius:16px;padding:18px 22px;border:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;background:rgba(245,158,11,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;">
                👥
            </div>
            <div>
                <p style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;font-weight:600;margin:0 0 2px;">
                    Kelompok Saya
                </p>
                <p style="font-size:17px;font-weight:700;color:#f1f5f9;margin:0;">
                    {{ $this->getGroupName() }}
                </p>
            </div>
        </div>

        @if($this->getGroupDescription())
            <p style="font-size:13px;color:#94a3b8;margin:0;max-width:300px;text-align:right;">
                {{ $this->getGroupDescription() }}
            </p>
        @endif
    </div>
</x-filament-widgets::widget>