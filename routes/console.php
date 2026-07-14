<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

// Events/classes are authored in Need Navigator; keep every
// feature-enabled site's local cache fresh.
Schedule::command('events:sync')->everyThirtyMinutes()->withoutOverlapping();
