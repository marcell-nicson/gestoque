<?php

namespace App\Events;

use App\Models\Produto;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProdutoCriado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $produto;

    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }
}
