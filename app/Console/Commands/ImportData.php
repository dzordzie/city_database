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
        /* $this->info(">>>>>> ...IMPORTING SUB-DISTRICTS... <<<<<<");
        $this->newLine();
        $this->importSubDistricts();
        $this->newLine();

        $this->info(">>>>>> ...IMPORTING CITIES... <<<<<<");
        $this->importCities();
        $this->newLine(); */

        $this->info(">>>>>> ...IMPORTING DETAILS FOR CITIES... <<<<<<");
        $this->newLine();
        $this->importCityDetails();
        $this->newLine();
    }

    private function importSubDistricts()
    {
        $url = 'https://www.e-obce.sk/kraj/NR.html';
        $html = file_get_html($url);

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
            $html = file_get_html($subDistrict->url);

            $this->newLine();
            $this->info("...from sub-district $subDistrict->name");
            $this->newLine();

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
        $progressBar->setFormat(" %current%/%max% [%bar%] %percent:3s%% - %message%");
        $progressBar->start();

        foreach ($cities as $city) {
            $progressBar->setMessage("Importing city: $city->name");
            $html = file_get_html($city->url);

            $contactTable = null;
            $infoTable = null;

            $mayorName = null;
            $address = null;
            $phone = null;
            $fax = null;
            $email = null;
            $web = null;

            foreach ($html->find('h1') as $h1) {
                if (str_contains($h1->plaintext, 'Obec ' . $city->name) || str_contains($h1->plaintext, 'Mesto ' . $city->name)) {
                    $trel = $h1;
                    $contactTable = $h1->parent()->parent()->parent();
                    $infoTable = $contactTable->next_sibling();
                    break;
                }
            }

            $rows = $contactTable->find('tr');

            foreach ($rows as $index => $row) {
                $cells = $row->find('td');

                if ($phone === null && count($cells) >= 4 && trim($cells[2]->plaintext) === 'Tel:') {
                    $phone = trim($cells[3]->plaintext);
                }

                if ($fax === null && count($cells) >= 3 && trim($cells[1]->plaintext) === 'Fax:') {
                    $fax = trim($cells[2]->plaintext);
                }

                if ($email === null && count($cells) >= 3 && trim($cells[1]->plaintext) === 'Email:') {
                    $emailLinks = $cells[2]->find('a');

                    $emails = [];
                    foreach ($emailLinks as $a) {
                        $emails[] = trim($a->plaintext);
                    }

                    $email = json_encode($emails);
                }

                if ($web === null && count($cells) >= 3 && trim($cells[1]->plaintext) === 'Web:') {
                    $web = trim(optional($cells[2]->find('a', 0))->href);
                }

                if ($address === null && $index === 6) {
                    $address = trim($cells[0]->plaintext);
                }

                if ($address !== null && $index === 7) {
                    $address = $address . ', ' . trim($cells[0]->plaintext);
                }
            }


            $rows = $infoTable->find('tr');

            foreach ($rows as $row) {
                $cells = $row->find('td');

                if ($mayorName === null && count($cells) >= 2 && (trim($cells[0]->plaintext) === 'Starosta:' || trim($cells[0]->plaintext) === 'Primátor:')) {
                    $mayorName = trim($cells[1]->plaintext);
                }
            }

            City::updateOrCreate(
                ['name' => $city->name],
                [
                    'mayor_name' => $mayorName,
                    'city_hall_address' => $address,
                    'phone' => $phone,
                    'fax' => $fax,
                    'email' => $email,
                    'web' => $web
                ]
            );

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info('✅ Importing is done');
    }
}
