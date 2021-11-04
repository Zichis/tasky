<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

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
            'name' => "To do"
        ]);

        TaskStatus::create([
            'name' => "In Progress"
        ]);

        TaskStatus::create([
            'name' => "Completed"
        ]);
    }
}
