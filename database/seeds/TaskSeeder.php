<?php

use App\Task;
use App\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user) {
            $tasks = factory(Task::class, random_int(5, 30))->make();

            $user->tasks()->saveMany($tasks);
        });
    }
}
