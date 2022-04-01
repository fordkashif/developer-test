<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =   [
            ['name'=>'Beginner',     'achievement_count' => 0],
            ['name'=>'Intermediate', 'achievement_count' => 4],
            ['name'=>'Advanced',     'achievement_count' => 8],
            ['name'=>'Master',       'achievement_count' => 10],
        ];

        Badge::query()->truncate();
        Badge::query()->insert($data);
    }
}
