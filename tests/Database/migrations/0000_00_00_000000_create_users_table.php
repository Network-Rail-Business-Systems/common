<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->string('azure_id');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
