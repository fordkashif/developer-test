<?php

namespace App\Http\Controllers;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $achievements = $user->achievement()->orderBy('type')->pluck('name')->toArray();
        $nextAvailableAchievements = $user->availableAchievements() ;
        $achievementCount =  $user->achievements->count();

        $currentBadge =  Badge::query()->where('achievement_count','<=', $achievementCount)
            ->orderBy('achievement_count','desc')->first();

        $nextBadge = Badge::query()->where('achievement_count','>', $achievementCount)
            ->orderBy('achievement_count','asc')->first();

        $diff = $nextBadge && $nextBadge->achievementCount ? $nextBadge->achievementCount - $achievementCount :0;

        $remainder  =  $diff <= 0 ? 0 : $diff; 


        return response()->json([
            'unlocked_achievements' => $achievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge->name ?? '',
            'next_badge' => $nextBadge->name ?? '',
            'remaing_to_unlock_next_badge' => $remainder
        ]);
    }

    public function commentRequest(Request $request)
    {
        $request->validate(
            [   'body'    => 'required|string|',
                'user_id' => 'required|integer|exists:users,id',
            ]);

        $data = $request->all();
        $comment =  Comment::query()->create($data);

        CommentWritten::dispatch($comment);
        return true;

    }

    public function lessonWatchedRequest(Request $request)
    {
        $request->validate(
            [
                'user_id'   => 'required|integer|exists:users,id',
                'lesson_id' => 'required|integer|exists:lessons,id',
            ]);

        $data   = $request->all();
        $user   = User::query()->find($data['user_id']);
        $lesson = Lesson::query()->find($data['lesson_id']);

        DB::table('lesson_user')->updateOrInsert(
            ['user_id'=>$user->id,'lesson_id'=>$lesson->id],
            ['watched'=>true]);

        LessonWatched::dispatch($lesson,$user);

        return true;
    }

}
