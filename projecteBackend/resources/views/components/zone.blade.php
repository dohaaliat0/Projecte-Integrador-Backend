<div class="container mx-auto mt-6">
    <div class="container mx-auto mt-6">
        <div class="equip-details border rounded-lg shadow-md p-6 bg-white">
            
            
            <h1 class="text-3xl font-bold text-blue-800 mb-4 text-center">{{ $zone->name }}</h1>
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Pacientes</h2>
            @foreach ($zone->patients as $item)
                <div class="patiete-item mb-4">
                    <h3 class="text-xl font-semibold">{{ $item->fullName }}</h3>
                </div>
            @endforeach

            <h2 class="text-2xl font-bold text-gray-700 mb-4">Teleoperadores</h2>
            @foreach ($zone->operators as $item)
                <div class="patiete-item mb-4">
                    <h3 class="text-xl font-semibold">{{ $item->name }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</div>
