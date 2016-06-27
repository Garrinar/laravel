<?php

namespace App\Listeners;

use Illuminate\Routing\Events\RouteMatched;

class RouterMatched
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
     * @param  RouteMatched  $event
     */
    public function handle(RouteMatched $event)
    {
        /*if(str_contains($event->route->getUri(), '{token?}') && !$event->route->hasParameter('token')) {
            //do something
        };*/
    }
}
