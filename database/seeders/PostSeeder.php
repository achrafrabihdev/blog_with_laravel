<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();

        if($users->count() == 0){
            $this->command->info("please create some users !");
            return;
        }

        $nbPosts =(int) $this->command->ask("How many of post you want generate ?",50);

        Post::factory()->count($nbPosts)->make()->each(function($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
