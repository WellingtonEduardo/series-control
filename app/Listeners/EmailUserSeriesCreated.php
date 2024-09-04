<?php

namespace App\Listeners;

use App\Mail\SeriesCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailUserSeriesCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $usersAll = User::all();

        foreach ($usersAll as $i => $user) {
            $went = now()->addSecond($i * 10);
            $email = new SeriesCreated($event->seriesName, "/");
            Mail::to($user->email)->later($went, $email);
        }

    }
}