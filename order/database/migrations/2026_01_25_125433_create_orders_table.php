<?php

use App\Modules\Order\Domain\Entity\OrderStatusEnum;
use App\Utils\EnumFields;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('user_id')->nullable();
            $table->string('email')->nullable();
            $table->string('amount');
            $table->enum('status', EnumFields::getColumn(OrderStatusEnum::class))->default(OrderStatusEnum::pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
