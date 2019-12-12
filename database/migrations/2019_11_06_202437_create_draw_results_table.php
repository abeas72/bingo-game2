<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    use SoftDeletes;
    
    public function up()
    {
        Schema::create('draw_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('game_id');
            $table->integer('draw_number');
            $table->smallInteger('first_number');
            $table->smallInteger('second_number');
            $table->smallInteger('third_number');
            $table->smallInteger('fourth_number');
            $table->smallInteger('fifth_number');
            $table->smallInteger('mega_number');
            $table->bigInteger('prize_amount');
            $table->boolean('rollover')->default(FALSE);
            $table->date('draw_date');
            $table->softDeletes();
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
        Schema::dropIfExists('draw_results');
    }
}
