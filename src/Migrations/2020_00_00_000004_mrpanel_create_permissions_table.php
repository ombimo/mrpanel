<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MrpanelCreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('tbz_permissions', function(Blueprint $table)
        {
            $table->id();
            $table->foreignId('role_id')->nullable()
                  ->constrained('tbz_roles')
                  ->onUpdate('no action')
                  ->onDelete('cascade');
            $table->foreignId('table_id')->nullable()
                  ->constrained('tbz_tables')
                  ->onUpdate('no action')
                  ->onDelete('cascade');
            $table->boolean('can_create')->default(0);
            $table->boolean('can_read')->default(0);
            $table->boolean('can_update')->default(0);
            $table->boolean('can_delete')->default(0);
            $table->timestamps();

            $table->unique(['role_id', 'table_id']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbz_permissions');
    }
}
