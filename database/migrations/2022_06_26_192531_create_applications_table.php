<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('single_name');
            $table->string('description');
            $table->string('short_description');
            $table->text('link');
            $table->text('display_image');
            $table->boolean('internal')->default(1);
            $table->boolean('external')->default(0);
            $table->boolean('published')->default(0);
            $table->integer('internal_users_no')->default(0);
            $table->integer('external_users_no')->default(0);
            $table->bigInteger('lead_dev')->unsigned()->index();
            $table->date('release_date');
            $table->bigInteger('status_id')->unsigned()->index();
            $table->bigInteger('published_by')->unsigned()->index()->nullable();
            $table->bigInteger('registered_by')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('updated_by')->unsigned()->index()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->index()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('lead_dev')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('published_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
