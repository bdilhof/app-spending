<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_spend_categories', function (Blueprint $table) {
            $table->decimal('budget')->after('title')->nullable();
        });
    }
};
