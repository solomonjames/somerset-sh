<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_urls', static function (Blueprint $table) {
            $table->id();
            $table->string('short_code')->unique();
            $table->string('long_url');
            $table->unsignedBigInteger('unique_hits')->default(0);
            $table->unsignedBigInteger('total_hits')->default(0);
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
        Schema::dropIfExists('short_urls');
    }
};
