<?php

namespace Database\Seeders;

use App\Models\TaskPriority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskPriority::firstOrCreate([
            'name' => 'Low',
            'slug' => Str::slug('Low'),
            'color' => '#a6a6a6'
        ]);

        TaskPriority::firstOrCreate([
            'name' => 'Normal',
            'slug' => Str::slug('Normal'),
            'color' => '#80d4ff'
        ]);

        TaskPriority::firstOrCreate([
            'name' => 'High',
            'slug' => Str::slug('High'),
            'color' => '#ffc266'
        ]);

        TaskPriority::firstOrCreate([
            'name' => 'Urgent',
            'slug' => Str::slug('Urgent'),
            'color' => '#ff471a'
        ]);
    }
}
