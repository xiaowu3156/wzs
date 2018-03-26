<?php

namespace App\Listeners;

use App\Events\Wzs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WzsListener implements ShouldQueue
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
     * @param  Wzs  $event
     * @return void
     */
    public function handle(Wzs $event)
    {
//        dd($event->id);
    }

    /**
     * 处理任务失败
     *
     * @param  \App\Events\Wzs  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(Wzs $event, $exception)
    {
        //
    }
}
