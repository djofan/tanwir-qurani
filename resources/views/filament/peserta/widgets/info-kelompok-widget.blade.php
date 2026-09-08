<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelompok Anda</p>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    {{-- Variabel nama kelompok Anda --}}
                    {{ $namaKelompok ?? 'Belum ada kelompok' }}
                </h3>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>