<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Membuat Roti',
                'status' => 0
            ],
            [
                'title' => 'Membuat Bolu',
                'status' => 0
            ],
            [
                'title' => 'Membuat Nasi',
                'status' => 0
            ],
        ];

        foreach($data as $item){
            $task = new Task();
            $task->title = $item['title'];
            $task->status = $item['status'];
            $task->save();
        }
    }
}
