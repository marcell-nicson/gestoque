<?php

namespace App\Events;

use App\Models\Produto;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProdutoCriado implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public $produto;

    /**
     * Create a new event instance.
     *
     * @param Produto $produto
     */
    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel-name');
    }
}
