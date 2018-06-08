<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSongLyricsTable.
 */
class CreateSongLyricsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('song_lyrics', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('artist');
            $table->text('lyrics');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('song_lyrics');
	}
}
