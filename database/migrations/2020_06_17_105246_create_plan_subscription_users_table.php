<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanSubscriptionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_subscription_users', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('renter_id');
            $table->foreign('renter_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');

            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');

            $table->unsignedBigInteger('warehouse_ad_id');
            $table->foreign('warehouse_ad_id')->references('id')->on('warehouse_ads')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->integer('paid')->default(0);

            $table->enum('payment_status', ['pending', 'paid', 'nopaid'])->default('pending');
            
            $table->unsignedBigInteger('account_number')->default(0);
            
            $table->enum('system_verification',['pending', 'verified',])->default('pending');
            
            $table->dateTime('paid_at')->nullable();

            



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_subscription_users');
    }
}
