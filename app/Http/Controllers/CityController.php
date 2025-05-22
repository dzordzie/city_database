<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function show($id)
    {
        $city = City::findOrFail($id);

        $data = [
            'Meno starostu:' => $city->mayor_name,
            'Adresa obecného úradu:' => $city->city_hall_address,
            'Telefón:' => $city->phone,
            'Fax:' => $city->fax,
            'Email:' => $city->email,
            'Web:' => $city->web,
            'Zemepisné súradnice:' => "$city->latitude, $city->longitude"
        ];
        return view('city-detail', compact('data', 'city'));
    }
}
