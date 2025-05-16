<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportData extends Command
{

    protected $signature = 'data:import';
    protected $description = 'Imports municipalities data';



    public function handle()
    {
        $url = 'https://www.e-obce.sk/kraj/NR.html';
        $html = file_get_html($url);

        foreach ($html->find('a.okreslink') as $node) {
            $text = trim($node->plaintext);
            $this->line("$text");
        }
    }
}
