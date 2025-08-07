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
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_type_id')->constrained('user_permission_types')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('0: Reddedildi, 1: Onaylandı, 2: Beklemede');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
