<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Zone;

class Zones extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
            public Zone $zone
        ) 

        { }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.zone');
    }
}
