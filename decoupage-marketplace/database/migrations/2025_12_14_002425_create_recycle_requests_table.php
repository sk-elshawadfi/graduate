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
        Schema::create('recycle_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('handled_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->string('image_path')->nullable();
            $table->text('description');
            $table->enum('request_type', ['recycle', 'sell'])->default('recycle');
            $table->decimal('admin_price', 10, 2)->nullable();
            $table->enum('status', ['pending', 'reviewing', 'approved', 'rejected', 'completed'])->default('pending')->index();
            $table->text('feedback')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recycle_requests');
    }
};
