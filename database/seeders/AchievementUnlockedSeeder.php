<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementUnlockedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =   [

            ['name'=>'First Lesson Watched', 'count' => 1, 'type'=>'lesson'],
            ['name'=>'5 Lessons Watched',    'count' => 5, 'type'=>'lesson'],
            ['name'=>'10 Lesson Watched',    'count' => 10,'type'=>'lesson'],
            ['name'=>'25 Lesson Watched',    'count' => 25,'type'=>'lesson'],
            ['name'=>'50 Lesson Watched',    'count' => 50,'type'=>'lesson'],

            ['name'=>'First Comment Written',    'count' => 1, 'type'=>'comment'],
            ['name'=>'3 Comments    Written',    'count' => 3, 'type'=>'comment'],
            ['name'=>'5 Comments    Written',    'count' => 5, 'type'=>'comment'],
            ['name'=>'10 Comments   Written',    'count' => 10,'type'=>'comment'],
            ['name'=>'20 Comments   Written',    'count' => 20,'type'=>'comment'],

        ];


      Achievement::query()->truncate();
      Achievement::query()->insert($data);
    }
}
