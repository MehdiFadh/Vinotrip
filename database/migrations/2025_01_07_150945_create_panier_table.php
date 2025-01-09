<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanierTable extends Migration
{
    public function up()
    {
        Schema::create('panier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idclient')->nullable();
            $table->unsignedBigInteger('numcommande')->nullable();
            $table->unsignedBigInteger('sejour_id');
            $table->string('titresejour');
            $table->decimal('prix_sejour', 10, 2);
            $table->string('url_photo_sejour')->nullable();
            $table->integer('adultes')->default(0);
            $table->integer('enfants')->default(0);
            $table->integer('chambres')->default(0);
            $table->text('message')->nullable();
            $table->boolean('mode_cadeau')->default(false);
            $table->date('date_sejour');
            $table->json('options')->nullable();
            $table->decimal('prix_total', 10, 2);
            $table->timestamps();

            $table->foreign('idclient')->references('idclient')->on('users')->onDelete('set null');
            $table->foreign('numcommande')->references('numcommande')->on('commande')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('panier');
    }
}

