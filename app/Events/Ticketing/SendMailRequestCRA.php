<?php

namespace App\Events\Ticketing;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMailRequestCRA
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $header;
    public $detail;
    public $user_nik;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($header,$detail,$user_nik)
    {
        $this->header = $header;
        $this->detail = $detail;
        $this->user_nik = $user_nik;
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
