<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Call;

class LlamadaActualizada implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $call;

    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    public function broadcastOn()
    {
        return new Channel('ConectaSalud');
    }

    public function broadcastAs()
    {
        return 'LlamadaActualizada';
    }
}

