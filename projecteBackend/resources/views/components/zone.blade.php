<div class="zone-container">
    <div class="zone-card">
        <h1 class="zone-title">{{ $zone->name }}</h1>

        <h2 class="zone-section">Pacientes</h2>
        @foreach ($zone->patients as $item)
            <div class="zone-item">
                {{ $item->fullName }}
            </div>
        @endforeach

        <h2 class="zone-section">Teleoperadores</h2>
        @foreach ($zone->operators as $item)
            <div class="zone-item">
                {{ $item->name }}
            </div>
        @endforeach
    </div>
</div>