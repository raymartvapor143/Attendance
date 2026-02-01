<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id(); // id
            $table->string('fullName'); // full name
            $table->string('position'); // position/title
            $table->string('type_attendee'); // type
            $table->string('phone_number'); // phone number
            $table->string('purpose')->nullable(); // purpose
            $table->string('company')->nullable(); // company, nullable
            $table->string('address')->nullable(); // address, nullable
            $table->string('photo')->nullable(); // photo path or URL
            $table->date('attendance_date')->nullable(); // date of attendance
            $table->time('attendance_time')->nullable(); // time of attendance
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
