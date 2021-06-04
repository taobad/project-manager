<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 32)->unique();
            $table->string('name', 255)->default('Project Title');
            $table->longText('description')->nullable();
            $table->integer('client_id');
            $table->string('currency', 32)->default('USD');
            $table->date('start_date', 32)->nullable();
            $table->date('due_date', 32)->nullable();
            $table->decimal('hourly_rate', 10, 2)->default(0.00)->nullable();
            $table->decimal('fixed_price', 10, 2)->default(0.00)->nullable();
            $table->integer('progress')->default(0);
            $table->longText('notes')->nullable();
            $table->integer('manager')->nullable();
            $table->string('status', 32)->default('Active');
            $table->tinyInteger('auto_progress')->default(1);
            $table->decimal('estimate_hours', 10, 2)->default(0.00);
            $table->text('settings')->nullable();
            $table->tinyInteger('alert_overdue')->default(0);
            $table->decimal('used_budget', 10, 2)->default(0.00);
            $table->decimal('billable_time', 10, 2)->default(0.00);
            $table->decimal('unbillable_time', 10, 2)->default(0.00);
            $table->decimal('unbilled', 10, 2)->default(0.00);
            $table->decimal('sub_total', 10, 2)->default(0.00);
            $table->decimal('total_expenses', 10, 2)->default(0.00);
            $table->decimal('todo_percent', 10, 2)->default(0.00);
            $table->integer('contract_id')->nullable();
            $table->string('billing_method', 32)->default('hourly_project_rate');
            $table->timestamp('archived_at')->nullable();
            $table->timestamp('overbudget_at')->nullable();
            $table->string('token')->nullable();
            $table->tinyInteger('rated')->default(0);
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
        Schema::dropIfExists('projects');
    }
}