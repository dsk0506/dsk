<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActiveEvent extends Event
{
    use SerializesModels;

    public $config;

    /**
     * Create a new event instance.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
