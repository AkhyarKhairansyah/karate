    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up()
    {
        Schema::create('dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('file_path');
            $table->timestamps();
        });
    }


        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('dokumentasis');
        }
    };
