<?php

use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Document::class, 10)->create();
    }
}
