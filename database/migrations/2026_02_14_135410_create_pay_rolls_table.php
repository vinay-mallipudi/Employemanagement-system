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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('salary_amount', 10, 2);

            $table->date('pay_period_start');
            $table->date('pay_period_end');

            $table->enum('status', ['pending', 'paid'])
                ->default('pending');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->unique(['employee_id', 'pay_period_start', 'pay_period_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_rolls');
    }
};
