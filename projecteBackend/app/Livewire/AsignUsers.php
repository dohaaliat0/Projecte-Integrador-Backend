<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Language;
use App\Models\Zone;
use App\Models\User;
use App\Enums\UserRole;

class AsignUsers extends Component
{
    public $patients = [];
    public $operators = [];
    public $filterLanguages = [];
    public $filterZones = [];
    public $selectedOperator = null;
    public $selectedPatients = [];

    public function mount()
    {
        $this->actualizarDatos();
    }

    public function applyFilter()
    {
        $this->actualizarDatos();
    }

    public function actualizarDatos()
    {
        $this->actualizarPacientes();
        $this->actualizarOperadores();
    }

    public function clearFilters()
{
    $this->filterLanguages = [];
    $this->filterZones = [];
    $this->actualizarDatos();
}


    public function actualizarPacientes()
    {
        $query = Patient::query();

        if (!empty($this->filterLanguages)) {
            $query->whereHas('languages', function ($q) {
                $q->whereIn('languages.id', $this->filterLanguages);
            });
        }

        if (!empty($this->filterZones)) {
            $query->whereIn('zoneId', $this->filterZones);
        }

        $this->patients = $query->get()->map(function ($patient) {
            return [
                'id' => $patient->id,
                'operatorId' => $patient->operatorId,
                'fullName' => $patient->fullName,
                'languages' => $patient->languages->pluck('name')->toArray(),
                'zone' => $patient->zone ? $patient->zone->name : 'N/A',
                'operator' => $patient->operator ? $patient->operator->name : 'N/A',
            ];
        })->toArray();
    }

    public function actualizarOperadores()
    {
        $query = User::where('role', UserRole::OPERATOR->value);

        if (!empty($this->filterLanguages)) {
            $query->whereHas('languages', function ($q) {
                $q->whereIn('languages.id', $this->filterLanguages);
            });
        }

        if (!empty($this->filterZones)) {
            $query->whereHas('zones', function ($q) {
                $q->whereIn('zones.id', $this->filterZones);
            });
        }

        $this->operators = $query->get(['id', 'name'])->toArray();
    }

    public function asignarOperador()
    {
        if (!$this->selectedOperator || empty($this->selectedPatients)) {
            return;
        }

        Patient::whereIn('id', $this->selectedPatients)->update(['operatorId' => $this->selectedOperator]);
        $this->actualizarPacientes();
        $this->selectedPatients = [];
    }

    public function render()
    {
        return view('livewire.asign-users', [
            'languages' => Language::all(),
            'zones' => Zone::all(),
        ]);
    }
}