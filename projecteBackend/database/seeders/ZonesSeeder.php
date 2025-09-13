<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            'Alacantí', 'Alcalatén', 'Alcoià', 'Alt Maestrat', 'Alto Mijares', 
            'Alto Palancia', 'Alto Vinalopó / Alt Vinalopó', 'Baix Maestrat', 'Baix Vinalopó', 
            'Camp de Morvedre', 'Camp de Túria', 'Canal de Navarrés', 'Comtat', 'Costera', 
            'Horta Nord', 'Horta Sud', 'Hoya de Buñol', 'Marina Alta', 'Marina Baixa', 
            'Plana Alta', 'Plana Baixa', 'Ports', 'Requena-Utiel', 'Ribera Alta', 'Ribera Baixa', 
            'Rincón de Ademuz', 'Safor', 'Serranos', 'València', 'Vall d\'Albaida', 
            'Valle de Ayora-Cofrentes', 'Vega Baja / Baix Segura', 'Vinalopó Mitjà / Vinalopó Medio'
        ];

        foreach ($zones as $zone) {
            Zone::create(['name' => $zone]);
        }
    }
}
