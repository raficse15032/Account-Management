<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number')->unique();
            $table->string('date')->nullable();
            $table->string('due_date')->nullable();
            $table->integer('commission_type')->nullable();
            $table->double('commission_amount')->nullable();
            $table->longText('invoice_items')->nullable();
            $table->double('shipping_charge')->nullable();
            $table->double('adjustment')->nullable();
            $table->double('total')->nullable();
            $table->double('amount')->nullable();
            $table->integer('mode')->nullable();
            $table->double('down_payment')->nullable();
            $table->integer('installment_type')->nullable();
            $table->integer('total_installment')->nullable();
            $table->double('per_installment_amount')->nullable();
            $table->integer('payment_id')->nullable()->unsigned();
            //$table->double('pr_adjustment')->nullable();
            //$table->string('pr_note')->nullable();
            //$table->longText('personal_note')->nullable();
            //$table->tinyInteger('save')->nullable();
            //$table->integer('payment_type');
            //$table->integer('installment_status')->nullable();
            //$table->integer('installment_type')->nullable();
            //$table->integer('installment_date')->nullable();
            //$table->integer('installment_number')->nullable();
            $table->integer('visa_id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->text('personal_note')->nullable();
            $table->text('customer_note')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamps();
        });
        Schema::table('invoices', function(Blueprint $table){
            $table->foreign('visa_id')->references('id')->on('visas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
