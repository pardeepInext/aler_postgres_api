<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    function countries($q)
    {
        return Country::where('name', 'ilike', "%$q%")->get();
    }

    function states(Request $request)
    {
        return State::where([['country_id', '=', $request->country_id], ['name', 'ilike', "%$request->name%"]])->get();
    }

    function cities(Request $request)
    {
        return City::where([['state_id', '=', $request->state_id], ['name', 'ilike', "%$request->name%"]])->get();
    }

    function home()
    {
        $property = Property::latest()->take(3)->with([
            'images:imageable_type,imageable_id,name',
            'propertyLocation',
            'propertyLocation.city:id,name',
            'propertyLocation.state:id,name',
            'propertyLocation.country:id,name'
        ])->get();

        $propertyCount = Property::select('type',DB::raw('count(type) as count'))->groupBy('type')->get();
        return response(['properties' => $property, "count" => $propertyCount]);
    }
}
