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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->date('birthday')->nullable()->after('email');
            $table->string('profile_photo')->nullable()->after('birthday');
            $table->text('about_me')->nullable()->after('profile_photo');
            $table->boolean('is_admin')->default(false)->after('about_me');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'birthday', 'profile_photo', 'about_me', 'is_admin']);
        });
    }
};
