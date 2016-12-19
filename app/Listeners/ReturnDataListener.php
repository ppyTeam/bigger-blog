<?php

namespace App\Listeners;

use App\Events\ReturnDataEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReturnDataListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReturnDataEvent $event
     * @return void
     */
    public function handle(ReturnDataEvent $event)
    {
        //
        $res = $event->return_data;
        $type = $event->type;
        if ($type == 'api') {
            return $res;
        } else {
            $res = view('index', compact('res'));
            return $res;
        }

    }
}
