<?php

namespace App\Observers;

use App\Models\Pasien;

class PasienObserver
{
    /**
     * Handle the Pasien "created" event.
     */
    public function created(Pasien $pasien): void
    {
        if(!$pasien->kode){
            $pasien->kode = $pasien->id;
            $pasien->save();
        }
    }

    /**
     * Handle the Pasien "updated" event.
     */
    public function updated(Pasien $pasien): void
    {
        //
    }

    /**
     * Handle the Pasien "deleted" event.
     */
    public function deleted(Pasien $pasien): void
    {
        //
    }

    /**
     * Handle the Pasien "restored" event.
     */
    public function restored(Pasien $pasien): void
    {
        //
    }

    /**
     * Handle the Pasien "force deleted" event.
     */
    public function forceDeleted(Pasien $pasien): void
    {
        //
    }
}
