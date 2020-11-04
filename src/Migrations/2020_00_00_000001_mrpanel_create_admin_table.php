<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MrpanelCreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbz_admin', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')->nullable()
                  ->constrained('tbz_roles')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('username', 20)->unique()->nullable();
            $table->string('password', 500)->nullable();
            $table->boolean('is_superadmin')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('tbz_admin')->insert([
            'name' => 'bimo',
            'email' => 'bimo.aji.92@gmail.com',
            'username' => 'bimo',
            'is_superadmin' => 1,
            'password' => Hash::make('asd'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbz_admin');
    }
}
