<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\City;

class SearchController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function autocomplete(Request $request)
    {
        $query = Str::slug($request->get('query'), ' ');

        $results = City::where('search_name', 'like', "{$query}%")
            ->orderBy('name')
            ->limit(5)
            ->get(['id', 'name']);

        return response()->json($results);
    }
}
