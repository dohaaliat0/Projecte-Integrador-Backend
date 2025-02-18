<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Call;
use App\Models\Zone;
use Carbon\Carbon;
use Livewire\Attributes\On;

class Llamadas extends Component
{
    public $calls = [];
    public $filterZones = [];
    public $filterDate = null;

    public function mount()
    {
        $this->actualizarLlamadas();
    }
    
    #[On('LlamadaActualizada')]
    public function actualizarDesdeEvento(){
        $this->actualizarLlamadas();
        $this->dispatch('$refresh');
    }
    

    public function applyFilter()
    {
        $this->actualizarLlamadas();
    }

    public function clearFilters()
    {
        $this->filterZones = [];
        $this->filterDate = null;
        $this->actualizarLlamadas();
    }

    public function actualizarLlamadas()
    {
        $query = Call::query();

        if (!empty($this->filterZones)) {
            $query->whereHas('patient', function ($q) {
                $q->whereIn('zoneId', $this->filterZones);
            });
        }

        if ($this->filterDate) {
            $query->whereDate('dateTime', $this->filterDate);
        }

        $this->calls = $query->with(['operator', 'patient', 'incomingCall', 'outgoingCall'])->get()->map(function ($call) {
            return [
                'id' => $call->id,
                'patient' => $call->patient ? $call->patient->fullName : 'N/A',
                'operator' => $call->operator ? $call->operator->name : 'N/A',
                'details' => $call->details,
                'dateTime' => $call->dateTime,
                'typeCall' => $call->incomingCall ? 'Entrante' : ($call->outgoingCall ? 'Saliente' : 'Desconocido'),
                'type' => $call->incomingCall ? $call->incomingCall->type : ($call->outgoingCall ? $call->outgoingCall->type : 'Desconocido'),
            ];
        });
    }

    public function createCall($patientId, $operatorId, $details, $dateTime = null)
    {
        Call::create([
            'patientId' => $patientId,
            'operatorId' => $operatorId,
            'details' => $details,
            'dateTime' => $dateTime ?? Carbon::now(),
        ]);

        $this->actualizarLlamadas();
    }

    public function render()
    {
        return view('livewire.llamadas', [
            'zones' => Zone::all(),
        ]);
    }
}

?>