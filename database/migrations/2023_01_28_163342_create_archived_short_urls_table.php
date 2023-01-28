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
        Schema::create('archived_short_urls', static function (Blueprint $table) {
            $table->id();
            $table->string('short_code');
            $table->text('long_url');
            $table->unsignedBigInteger('unique_hits');
            $table->unsignedBigInteger('total_hits');
            $table->dateTime('original_created_at');
            $table->dateTime('original_updated_at');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archived_short_urls');
    }
};
