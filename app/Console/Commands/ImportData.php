<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubDistrict;
use App\Models\City;
use Illuminate\Support\Facades\Http;

class ImportData extends Command
{

    protected $signature = 'data:import';
    protected $description = 'Imports municipalities data';

    public function handle()
    {
        $this->info(">>>>>> ...IMPORTING SUB-DISTRICTS... <<<<<<");
        $this->newLine();
        $this->importSubDistricts();
        $this->newLine();

        $this->info(">>>>>> ...IMPORTING CITIES... <<<<<<");
        $this->importCities();
        $this->newLine();

        $this->info(">>>>>> ...IMPORTING DETAILS FOR CITIES... <<<<<<");
        $this->newLine();
        $this->importCityDetails();
        $this->newLine();
    }

    private function importSubDistricts()
    {
        $html = file_get_html('https://www.e-obce.sk/kraj/NR.html');

        foreach ($html->find('a.okreslink') as $node) {
            $name = trim($node->plaintext);
            $link = trim($node->href);

            SubDistrict::updateOrCreate(
                ['name' => $name],
                ['url' => $link]
            );

            $this->info("✓ $name");
        }
    }

    private function importCities()
    {
        $allSubDistricts = SubDistrict::all();

        foreach ($allSubDistricts as $subDistrict) {
            $this->newLine();
            $this->info("...from sub-district $subDistrict->name");
            $this->newLine();

            $html = file_get_html($subDistrict->url);

            foreach ($html->find('b') as $b) {
                if (str_contains($b->plaintext, "Vyberte si obec")) {
                    $table = $b->next_sibling();

                    foreach ($table->find('a') as $node) {
                        $name = trim($node->plaintext);
                        $link = trim($node->href);

                        if (str_contains($name, "Inzercia")) {
                            continue;
                        }

                        City::updateOrCreate(
                            ['name' => $name],
                            ['url' => $link, 'sub_district_id' => $subDistrict->id]
                        );

                        $this->info("✓ $name");
                    }
                    break;
                }
            }
        }
    }

    private function importCityDetails()
    {
        $cities = City::all();

        $progressBar = $this->output->createProgressBar(count($cities));
        $progressBar->setFormat("%percent:3s%% - %message% ... %current%/%max%");
        $progressBar->start();

        foreach ($cities as $city) {
            $progressBar->setMessage("Importing city data: $city->name");

            $html = file_get_html($city->url);
            $contactTable = null;
            $infoTable = null;

            /* =============== FIND TWO PARENT TABLES WITH ALL INFO =============== */
            foreach ($html->find('h1') as $h1) {
                if (str_contains($h1->plaintext, 'Obec ' . $city->name) || str_contains($h1->plaintext, 'Mesto ' . $city->name)) {
                    $trel = $h1;
                    $contactTable = $h1->parent()->parent()->parent();
                    $infoTable = $contactTable->next_sibling();
                    break;
                }
            }

            $contactTableData = $this->parseContactTable($contactTable);
            $mayorName = $this->parseMayorInfo($infoTable);
            $coatOfArmsUrl = $this->downloadCoatOfArms($contactTable, $city);

            City::updateOrCreate(
                ['name' => $city->name],
                array_merge($contactTableData, [
                    'mayor_name' => $mayorName,
                    'coat_of_arms_image' => $coatOfArmsUrl
                ])
            );

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info('✅ Importing is done');
    }



    /* ============================== HELPING METHODS ============================== */

    private function parseContactTable($table): array
    {
        $data = [
            'city_hall_address' => null,
            'phone' => null,
            'fax' => null,
            'email' => null,
            'web' => null,
        ];

        $rows = $table->find('tr');

        foreach ($rows as $index => $row) {
            $cells = $row->find('td');

            if (count($cells) >= 4 && trim($cells[2]->plaintext) === 'Tel:') {
                $data['phone'] = trim($cells[3]->plaintext);
            }

            if (count($cells) >= 3 && trim($cells[1]->plaintext) === 'Fax:') {
                $data['fax'] = trim($cells[2]->plaintext);
            }

            if (count($cells) >= 3 && trim($cells[1]->plaintext) === 'Email:') {
                $emails = [];
                foreach ($cells[2]->find('a') as $a) {
                    $emails[] = trim($a->plaintext);
                }
                $data['email'] = json_encode($emails);
            }

            if (count($cells) >= 3 && trim($cells[1]->plaintext) === 'Web:') {
                $data['web'] = trim($cells[2]->find('a', 0)->href);
            }

            if ($index === 6) {
                $data['city_hall_address'] = trim($cells[0]->plaintext);
            }

            if ($index === 7 && $data['city_hall_address']) {
                $data['city_hall_address'] .= ', ' . trim($cells[0]->plaintext);
            }
        }

        return $data;
    }


    private function parseMayorInfo($table): ?string
    {
        foreach ($table->find('tr') as $row) {
            $cells = $row->find('td');
            if (count($cells) >= 2 && in_array(trim($cells[0]->plaintext), ['Starosta:', 'Primátor:'])) {
                return trim($cells[1]->plaintext);
            }
        }
        return null;
    }


    private function downloadCoatOfArms($table, City $city): ?string
    {
        foreach ($table->find('img') as $img) {
            $src = $img->src;

            if (str_contains($src, '/erb/')) {
                $fileName = basename(parse_url($src, PHP_URL_PATH));
                $filePath = public_path('images/' . $fileName);

                if (!file_exists($filePath)) {
                    $this->line(" and downloading image: $fileName");
                    file_put_contents($filePath, file_get_contents($src));
                }
                return 'images/' . $fileName;
            }
        }
        return null;
    }
}
