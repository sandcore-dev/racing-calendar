<?php

namespace App\Observers;

use App\Models\Race;
use App\Models\RaceSession;

class RaceObserver
{
    public function updating(Race $race): void
    {
        if (!$race->isDirty('start_time')) {
            return;
        }

        $diffInDays = $race->start_time->diffInDays($race->getOriginal('start_time'), false);

        $race->sessions()->each(function (RaceSession $session) use ($diffInDays) {
            $session->start_time = $session->start_time->subDays($diffInDays);
            $session->end_time = $session->end_time->subDays($diffInDays);
            $session->save();
        });
    }
}
