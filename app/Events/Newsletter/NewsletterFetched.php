<?php

namespace App\Events\Newsletter;

use App\Events\DashboardEvent;

class NewsletterFetched extends DashboardEvent
{
    /** @var array */
    public $events;

    public function __construct(array $events)
    {
        $this->events = $events;
    }
}
