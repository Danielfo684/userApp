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
        Schema::create('users', function (Blueprint $table) {
            $table->id();   // basic id for every DB table
            $table->string('name');   //user name
             // mail that will recieve your 
            // confirmation and restoration msg
            $table->string('email')->unique();  
            // timestamp for email verification with changes.
            // Time Stamp setted after veritifaction and accepts null values, so the table keeps working while 
            // the user is not verified
            $table->timestamp('email_verified_at')->nullable();
            // role for the user, default is user
            $table->string('role')->default('user');
            // password for the user 
            $table->string('password');
          
            $table->rememberToken();
            // basic timestamp for the table
            $table->timestamps();
        });

        $user = new \App\Models\User();
        $user->name = 'Dani';
        $user->email = 'dani@test.es';
        $user->email_verified_at = now();
        $user->role = 'superadmin';
        
        // encrypting the password with Hash::make
        $user->password = \Illuminate\Support\Facades\Hash::make('password');

        $user->save();


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
