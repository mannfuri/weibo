<?php

namespace Database\Seeders;


use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::factory()->count(100)->create();
    }
}
