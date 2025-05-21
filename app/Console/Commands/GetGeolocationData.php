<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\City;

class GetGeolocationData extends Command
{

    protected $signature = 'data:geocode';
    protected $description = 'Get geolocation data for cities from Google Geocoding API';


    public function handle()
    {
        $this->info(">>>>>> ...IMPORTING GEOLOCATION DATA... <<<<<<");
        $this->newLine();
        $this->importGeoData();
        $this->newLine();
        $this->info('✅ Saving geo-data finished');
    }


    private function importGeoData()
    {
        $apiKey = env('GOOGLE_GEOCODING_API_KEY');
        $cities = City::whereNull('latitude')->orWhereNull('longitude')
            ->orderBy('id', 'asc')
            ->get();

        foreach ($cities as $city) {
            $subDistrictName = $city->subDistrict->name;
            $query = "{$city->name}, {$subDistrictName}, Slovakia";

            $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
                'address' => $query,
                'key' => $apiKey,
            ]);

            if ($response->failed()) {
                $this->warn("API request failed on: {$city->name}");
                continue;
            }

            $data = $response->json();

            if (!empty($data['results'])) {
                $location = $data['results'][0]['geometry']['location'];

                $city->update([
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                ]);

                $this->info("✓ {$city->name} - {$location['lat']}, {$location['lng']}");
            } else {
                $this->warn("✕ No geo-data found for: {$city->name}");
            }
        }
    }
}
