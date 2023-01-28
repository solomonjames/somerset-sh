<?php

namespace App\Jobs;

use App\Events\ShortUrlVisit;
use App\Models\ShortUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * This job simply acts as an entrypoint, which emits and event so that it can fanout
 * the work to any number of listeners. You could simply fire the event from controller,
 * but then you could be processing any number of listeners. This way we make sure to only
 * fire 1 job off, that goes straight to a background queue, and then we let that do the fanout.
 */
class HandleShortUrlVisit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly ShortUrl $shortUrl, public readonly bool $isUnique)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new ShortUrlVisit($this->shortUrl, $this->isUnique));
    }
}
