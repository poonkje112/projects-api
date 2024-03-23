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
        Schema::create('member_project', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('member_id');

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

            $table->unique(['project_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_project');
    }
};
