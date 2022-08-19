<?php

namespace App\Events\Koperasi;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MailOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order_header_id; 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order_header_id)
    {
        $this->order_header_id = $order_header_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
