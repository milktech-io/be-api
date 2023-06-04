<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = Document::create([
            'name' => 'terminos-y-condiciones',
            'extension' => '.pdf',
        ]);
        $document->storeFromLocal('documents/terminos-y-condiciones.pdf', 'file_url');

        $document = Document::create([
            'name' => 'anexo-multiplier',
            'extension' => '.pdf',
        ]);
        $document->storeFromLocal('documents/anexo-multiplier.pdf', 'file_url');

        $document = Document::create([
            'name' => 'manual-compromiso',
            'extension' => '.pdf',
        ]);
        $document->storeFromLocal('documents/manual-compromiso.pdf', 'file_url');

        $document = Document::create([
            'name' => 'acuerdo-time-leader',
            'extension' => '.pdf',
        ]);
        $document->storeFromLocal('documents/acuerdo-time-leader.pdf', 'file_url');
    }
}
