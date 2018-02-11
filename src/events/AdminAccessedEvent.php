<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Model\Admin;

class AdminAccessedEvent
{
    use InteractsWithSockets, SerializesModels;
    
    public $admin;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
