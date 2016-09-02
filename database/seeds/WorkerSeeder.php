<?php

use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workerCount = env('WORKER_COUNT', 10);
        factory(Judgement\Sandbox::class, (int)$workerCount)->create();
    }
}
