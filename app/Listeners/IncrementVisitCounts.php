<?php

namespace App\Listeners;

use App\Actions\IncrementVisitCountsAction;
use App\Events\ShortUrlVisit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncrementVisitCounts implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct(private readonly IncrementVisitCountsAction $incrementVisitCountsAction)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(ShortUrlVisit $event): void
    {
        $this->incrementVisitCountsAction->execute($event->shortUrl, $event->isUnique);
    }
}
