<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Events\AchievementUnlockedEvent;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LessonWatchedListener
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
     * @param  \App\Events\LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        $user = $event->user;
        $watchCount  = $user->watched->count();

        $achievementQuery = Achievement::query()->where('type','lesson');

        if($watchCount > 0){

            $achievement = $achievementQuery->where('count',$watchCount)->first();

            if($achievement){
                $user->achievements()->firstOrCreate(['achievement_id' => $achievement->id]);
                AchievementUnlockedEvent::dispatch($achievement->name,$user);
            }
        }
    }
}
