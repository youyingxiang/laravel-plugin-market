<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketPluginVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_plugin_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("plugin_id");
            $table->string("version");
            $table->string("download_link");
            $table->unsignedInteger("download_times")->default(0);
            $table->unsignedInteger("price")->default(0);
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
        Schema::dropIfExists('market_plugin_versions');
    }
}
