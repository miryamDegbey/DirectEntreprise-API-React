<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('groupes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string ('actuality');
            $table->unsignedBigInteger('user_id');//clé étrangère
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');//cascade pour supprimer les groupes liés à un utilisateur lorsque celui-ci est supprimé
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupes');
    }
};
