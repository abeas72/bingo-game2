<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShadowCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    use SoftDeletes;
    
    public function up()
    {
        Schema::create('shadow_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('card_id');
            $table->boolean('first_number')->default(0);
            $table->boolean('second_number')->default(0);
            $table->boolean('third_number')->default(0);
            $table->boolean('fourth_number')->default(0);
            $table->boolean('fifth_number')->default(0);
            $table->boolean('mega_number')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shadow_cards');
    }
}
