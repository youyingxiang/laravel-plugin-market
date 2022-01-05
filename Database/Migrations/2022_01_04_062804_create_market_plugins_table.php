<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketPluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_plugins', function (Blueprint $table) {
            $table->id();
            $table->string("plugin_name");
            $table->unsignedInteger("market_user_id");
            $table->string("download_link");
            $table->unsignedTinyInteger("type");
            $table->unsignedTinyInteger("status")->default(0);
            $table->json("plugin_metadata");
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
        Schema::dropIfExists('market_plugins');
    }
}
