<?php

namespace App\Events;

use App\Models\ShortUrl;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShortUrlVisit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public readonly ShortUrl $shortUrl, public readonly bool $isUnique)
    {
    }
}
