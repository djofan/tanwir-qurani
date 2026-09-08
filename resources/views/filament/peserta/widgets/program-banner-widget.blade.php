<x-filament-widgets::widget>
    <!-- Menambahkan background, shadow, dan padding agar tidak polos -->
    <x-filament::section class="bg-white dark:bg-gray-900 shadow-sm rounded-xl p-4">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            Assalamu'alaikum, {{ auth()->user()->name }} 
        </h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Semangat setoran hafalan dan cek tugas hari ini!
        </p>
    </x-filament::section>
</x-filament-widgets::widget>