<?php

namespace App\Listeners;


use App\Events\LoggerInterface;
use App\Repositories\LogRepositoryInterface;

class LoggerListener
{

    public $logRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logRepository = app(LogRepositoryInterface::class);
    }

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(LoggerInterface $event)
    {
        $this->logRepository->addLog(get_class($event), $event->log());
    }
}
