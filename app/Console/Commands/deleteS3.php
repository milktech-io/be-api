<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\Profile;
use Illuminate\Console\Command;

class DeleteS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteS3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Profile::all() as $image) {
            $image->unlink('image_url');
        }

        foreach (Document::all() as $document) {
            $document->unlink('file_url');
        }

        return 0;
    }
}
