<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('etat')->default(0);
            $table->string('activation_code',255)->nullable();
            $table->string('activation_token',255)->nullable();
            $table->json('deletion_reasons')->nullable();
            $table->text('deletion_feedback')->nullable();
            $table->softDeletes();
            $table->boolean('is_deactivated')->default(false);
            $table->timestamp('scheduled_deletion_at')->nullable();
            $table->string('cancellation_token',100)->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
