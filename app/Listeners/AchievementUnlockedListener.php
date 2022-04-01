<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlockedEvent;
use App\Models\Badge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementUnlockedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AchievementUnlocked  $event
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        $user = $event->user;
        $achievementCount = $event->count();

        $badge = Badge::query()->where('achievement_count', $achievementCount)->first();

        if($badge){
            BadgeUnlockedEvent::dispatch($badge->name,$user);
            info("Congratulations on earning your new badge :  $badge->name");
        }
    }
}
