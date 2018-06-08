<?php

use Illuminate\Database\Seeder;

class SongLyricsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Entities\SongLyrics::class,30)->create();
    }
}
