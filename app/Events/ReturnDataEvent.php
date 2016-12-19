<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class ReturnDataEvent
{
    use InteractsWithSockets, SerializesModels;

    public $return_data;

    public $type;

    /**
     * Create a new event instance.
     *
     * @param $return_data
     * @param Request $request
     */
    public function __construct($return_data)
    {
        $this->return_data = $return_data;
        if (request()->headers->get('return_type') == 'api') {
            $this->type = 'api';
        } else {
            $this->type = 'web';
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('return-data');
    }
}
