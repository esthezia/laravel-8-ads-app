<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_category')->unsigned();
            $table->bigInteger('id_subcategory')->unsigned();
            $table->bigInteger('id_city')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['free', 'premium'])->default('free');
            $table->string('image')->nullable()->default(null)->comment('Only the file name (and extension) will be kept here. They will be loaded from the ./storage/app/public/ads/ folder.');
            $table->timestamp('created_at')->default(\DB::raw('NOW()'));
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            // foreign keys
            $table->foreign('id_category')->references('id')->on('categories')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('id_subcategory')->references('id')->on('subcategories')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('id_city')->references('id')->on('cities')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
