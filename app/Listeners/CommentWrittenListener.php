<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\UserAchievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentWrittenListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $user = $event->comment->user;
        $comments  = $user->comments->count();

        $achievementQuery = Achievement::query()->where('type','comment');

        if($comments > 0){
            $achievement = $achievementQuery->where('count',$comments)->first();

            if($achievement){
               $user->achievements()->create(['achievement_id' => $achievement->id]);
               AchievementUnlocked::dispatch($achievement->name,$user);
            }
        }
    }
}
