<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSenderToRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sender_recipient', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->default(null);
            $table->unsignedInteger('email_id')->nullable()->default(null);
            $table->unsignedInteger('recipient_id')->nullable()->default(null);
            $table->timestamps();

            $table->unsignedInteger('status_id')->nullable()->default(null);

            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('recipient_id')->references('id')->on('recipients');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('email_id')->references('id')->on('emails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sender_recipient');
    }
}
