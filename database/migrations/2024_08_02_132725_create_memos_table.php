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
	    Schema::create('memos', function (Blueprint $table) {
		    $table->id();
			$table->integer('bid');
			$table->integer('pid');
			$table->string('userid', 100); // 필드명은 title, 글자수는 100글자로 정의
			$table->text('memo');          // 필드명은 body,  글자수는 DB 시스템의 text 글자수 기준 ( mysql  - 64kbyte )
			$table->tinyInteger('status')->default(1);  // 필드명은 clicks, 숫자만 입력
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memos');
    }
};
