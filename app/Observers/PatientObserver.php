<?php

namespace App\Observers;

use App\Jobs\PatientQueueHandler;
use App\Models\Patient;

class PatientObserver
{
    protected const TTL = 300;

    public function __construct(public readonly Cache $cache)
    {
    }

    public function created(Patient $patient): void
    {
        $this->cache->tags(['patient'])->put('patient:'.$patient->id, $patient, self::TTL);

        PatientQueueHandler::dispatch($patient);
    }

    /**
     * Handle the Patient "updated" event.
     */
    public function updated(Patient $patient): void
    {
        //
    }

    /**
     * Handle the Patient "deleted" event.
     */
    public function deleted(Patient $patient): void
    {
        //
    }

    /**
     * Handle the Patient "restored" event.
     */
    public function restored(Patient $patient): void
    {
        //
    }

    /**
     * Handle the Patient "force deleted" event.
     */
    public function forceDeleted(Patient $patient): void
    {
        //
    }
}
