<x-filament-widgets::widget>
    <div class="relative overflow-hidden rounded-2xl px-5 py-5 sm:px-7 sm:py-6 text-white
        bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700">

        <div class="pointer-events-none absolute -right-8 -top-10 h-40 w-40 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -right-2 bottom-[-2.5rem] h-24 w-24 rounded-full bg-white/10"></div>

        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="min-w-0 flex items-start gap-4">
                <div class="hidden sm:flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-3xl backdrop-blur-sm">
                    📖
                </div>
                <div>
                    <p class="text-[11px] opacity-80 mb-1 tracking-wider uppercase font-semibold">
                        {{ $today }}
                    </p>
                    <h2 class="text-lg sm:text-xl font-bold leading-snug break-words">
                        Assalamu'alaikum, {{ $name }} 👋
                    </h2>
                    <p class="text-sm opacity-90 mt-1.5 max-w-md">
                        Semangat tadarus dan setor hafalan hari ini.
                    </p>
                </div>
            </div>

            @if($groupName)
                <div class="flex sm:flex-col items-center sm:items-end gap-2 shrink-0 self-stretch sm:self-center">
                    <div class="rounded-xl bg-white/15 backdrop-blur-sm px-4 py-2.5 text-center min-w-[7.5rem]">
                        <div class="text-sm font-extrabold leading-tight break-words">{{ $groupName }}</div>
                        <div class="text-[10px] uppercase tracking-wide opacity-85 mt-1">
                            Kelompok Kamu
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-filament-widgets::widget>
