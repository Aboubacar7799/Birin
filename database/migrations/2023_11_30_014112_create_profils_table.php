<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('lien')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');//c'est une clé etrangere provenant de la table user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.POUR ANNULER UNE MIGRATION ON a:------------ php artisan migrate:rollback
     *                         POUR LE STATUT DES MIGRATIONS: ------------- php artisan migrate:status
     *                         POUR SUPPRIMER TOUTES LES TABLES:----------- php artisan migrate:fresh
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profils');
    }
}
