<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ApplicationTest extends TestCase
{
    use WithFaker;

    /**
     * Comment Tests
     *
     * @return void
     */
    
    public function test_addCommentUnlockFirstAchievements()
    {
        $user = User::factory()->create();

        $data = ['user_id'=>$user->id,'body'=>$this->faker->text];

        $response = $this->post('/users/comment/add',$data);

        $response->assertStatus(200);
    }

    public function test_addEmptyCommentBody()
    {
        $user = User::first();

        $data = ['user_id'=>$user->id];

        $response = $this->post('/users/comment/add',$data);

        $response->assertStatus(302);
    }

    public function test_sendEmptyUserID()
    {
        $data = ['body'=>$this->faker->text];

        $response = $this->post('/users/comment/add',$data);

        $response->assertStatus(302);
    }

    public function test_sendEmptyParameters()
    {

        $data = [];

        $response = $this->post('/users/comment/add',$data);

        $response->assertStatus(302);
    }

    public function testUnlockUpToTenCommentAchievement()
    {
        $user = User::first();

        for ($i=0; $i < 10; $i++)
        {
            $data = ['user_id'=>$user->id,'body'=>$this->faker->text];

            $response = $this->post('/users/comment/add',$data);

        }

        $response->assertStatus(200)->assertSee(true);

    }

    public function test_unlockAllCommentAchievements()
    {
        $user = User::first();

        for ($i=0; $i < 20; $i++)
        {
            $data = ['user_id'=>$user->id,'body'=>$this->faker->text];

            $response = $this->post('/users/comment/add',$data);

        }

        $response->assertStatus(200)->assertSee(true);

    }

    /**
     * Lesson Watched Tests
     *
     * @return void
     */

    public function test_firstAchievementFromLessonWatched()
    {
        $user = User::query()->first();
        $lesson = Lesson::query()->first();
        $data = ['user_id'=>$user->id,'lesson_id'=>$lesson->id];
        $response = $this->post('/users/watched-lesson/add',$data);
        $response->assertStatus(200)->assertSee(true);
    }

    public function test_addEmptyUserID()
    {
        $lesson = Lesson::query()->first();
        $data = ['lesson_id'=>$lesson->id];
        $response = $this->post('/users/watched-lesson/add',$data);
        $response->assertStatus(302);
    }

    public function test_unlockUpToTenLessonAchievements()
    {

        $user = User::first();
        $response = null;
        Lesson::query()->limit(10)->each(function ($lesson) use ($user,&$response){
            $data = ['user_id'=>$user->id,'lesson_id'=>$lesson->id];
            $response = $this->post('/users/watched-lesson/add',$data);
        });


        $response->assertStatus(200)->assertSee(true);

    }

    public function testUnlockAllLessonAchievements()
    {

        $user = User::first();
        $response = null;
        Lesson::query()->each(function ($lesson) use ($user,&$response){
            $data = ['user_id'=>$user->id,'lesson_id'=>$lesson->id];
            $response = $this->post('/users/watched-lesson/add',$data);
        });

        $response->assertStatus(200)->assertSee(true);

    }

}
