<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    /**
     *  The achievements that a user has unlocked
     */
    public function achievement()
    {
        return $this->belongsToMany(Achievement::class,'user_achievements');
    }

    public function availableAchievements()
    {
            $nextAvailableAchievement = [];

            $lesson = Achievement::query()->where('type', 'lesson')->whereHas('userAchievement')->orderBy('count','desc')->first();

            if($lesson) {
                $next =  Achievement::query()->where('type', 'lesson')->where('count','>',$lesson->count)->orderBy('count','asc')->first();

                if($next) {
                    $nextAvailableAchievement[] = $next->name;  //push achievement name to the array
                }
            }
            else {

                $next =  Achievement::query()->where('type', 'lesson')->where('count','>',0)->orderBy('count','asc')->first();

                if($next) {
                    $nextAvailableAchievement[] = $next->name;  //push achievement name to the array
                }
            }


            /** get the next achievement for by name for the user */
            $comment = Achievement::query()->where('type', 'comment')->whereHas('userAchievement')->orderBy('count','desc')->first();

            /** if the user has not unlocked any achievement use count of 0 and display the first available achievement**/
            if($comment) {
                $next =  Achievement::query()->where('type', 'comment')->where('count','>',$comment->count)->orderBy('count','asc')->first();

                if($next) {
                    $nextAvailableAchievement[] = $next->name;  //push achievement name to the array
                }
            }
            else {

                $next =  Achievement::query()->where('type', 'comment')->where('count','>',0)->orderBy('count','asc')->first();

                if($next) {
                    $nextAvailableAchievement[] = $next->name; 
                }
            }

        return $nextAvailableAchievement;
    }
}
