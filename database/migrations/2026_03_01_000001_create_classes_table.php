<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('name');         // e.g. FY, SY, TY
            $table->string('label')->nullable(); // e.g. First Year
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Add class_id to users for future student→class assignment
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('course_id');
            $table->foreign('class_id')->references('id')->on('classes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
        Schema::dropIfExists('classes');
    }
};
