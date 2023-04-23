<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->string('vocabulary', 255);
            $table->string('pronunciation', 255)->nullable();
            $table->string('vietnamese', 255);
            $table->tinyInteger('stress')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('type', 100);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('vocabularies_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->integer('vocabularies_id');
            $table->string('vocabulary', 255)->nullable();

            $table->primary(['lang_code', 'vocabularies_id'], 'vocabularies_translations_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vocabularies');
        Schema::dropIfExists('vocabularies_translations');
    }
};
