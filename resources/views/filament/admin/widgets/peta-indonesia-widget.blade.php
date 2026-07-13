<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            🗺️ Peta Persebaran Guru & Peserta
        </x-slot>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <div id="peta-indonesia" style="height: 450px; border-radius: 12px; z-index: 1;"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                initPeta();
            });

            document.addEventListener('livewire:navigated', function () {
                initPeta();
            });

            function initPeta() {
                const container = document.getElementById('peta-indonesia');
                if (!container || container._leaflet_id) return;

                const map = L.map('peta-indonesia').setView([-2.5, 118], 5);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 18,
                }).addTo(map);

                const locations = @json($this->getLocations());

                if (locations.length === 0) {
                    return;
                }

                const markers = [];

                locations.forEach(function (loc) {
                    const color = loc.role === 'guru' ? '#3b82f6' : '#f59e0b';
                    const icon = L.divIcon({
                        className: 'custom-marker',
                        html: `<div style="background:${color};width:14px;height:14px;border-radius:50%;border:2px solid white;box-shadow:0 1px 4px rgba(0,0,0,0.4);"></div>`,
                        iconSize: [14, 14],
                    });

                    const marker = L.marker([loc.lat, loc.lng], { icon: icon }).addTo(map);

                    marker.bindPopup(`
                        <div style="font-family: sans-serif; min-width: 160px;">
                            <strong>${loc.name}</strong><br>
                            <span style="font-size: 12px; color: ${color}; font-weight: 600;">
                                ${loc.role === 'guru' ? '👨‍🏫 Guru' : '👤 Peserta'}
                            </span><br>
                            <span style="font-size: 12px; color: #666;">${loc.alamat ?? '-'}</span>
                        </div>
                    `);

                    markers.push(marker);
                });

                if (markers.length > 0) {
                    const group = L.featureGroup(markers);
                    map.fitBounds(group.getBounds(), { padding: [40, 40] });
                }
            }
        </script>

        <div style="display: flex; gap: 16px; margin-top: 12px; font-size: 13px;">
            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="width: 10px; height: 10px; background: #3b82f6; border-radius: 50%; display: inline-block;"></span>
                Guru
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="width: 10px; height: 10px; background: #f59e0b; border-radius: 50%; display: inline-block;"></span>
                Peserta
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>