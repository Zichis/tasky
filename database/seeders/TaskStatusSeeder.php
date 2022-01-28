<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskStatus::create([
            'name' => 'To do',
            'slug' => Str::slug('To do')
        ]);

        TaskStatus::create([
            'name' => 'In Progress',
            'slug' => Str::slug('In Progress')
        ]);

        TaskStatus::create([
            'name' => 'Completed',
            'slug' => Str::slug('Completed')
        ]);
    }
}
