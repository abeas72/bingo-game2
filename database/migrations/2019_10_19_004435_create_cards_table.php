<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    use SoftDeletes;

    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('game_id');
            $table->smallInteger('number1');
            $table->smallInteger('number2');
            $table->smallInteger('number3');
            $table->smallInteger('number4');
            $table->smallInteger('number5');
            $table->smallInteger('number6');
            $table->boolean('active')->nullable()->default(0);
            $table->boolean('winner')->nullable()->default(0);
            $table->smallInteger('hit_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
           // $table->date('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
