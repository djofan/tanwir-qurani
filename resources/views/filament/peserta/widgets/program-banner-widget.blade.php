<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-2">
            <h2 class="text-xl font-bold tracking-tight">
                Assalamu'alaikum, {{ auth()->user()->name }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400">
                Semangat tadarus dan setor hafalan hari ini.
            </p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>