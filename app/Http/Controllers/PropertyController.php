<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertyFeatured;
use App\Models\Image;
use App\Models\PropertyLocation;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $property = Property::query();

        if ($request->has('status') && $request->status != "")
            $property->where('status', $request->status);

        if ($request->has('type') &&  $request->type != "")
            $property->where('type', $request->type);

        if ($request->has('bedrooms') && $request->bedrooms != "")
            $property->where('bedrooms', $request->bedrooms);

        if ($request->has('bathroom') && $request->bathroom != "")
            $property->where('bathroom', $request->bathroom);

        if ($request->has('garages') && $request->garages != "")
            $property->where('garages', $request->garages);


        return $property->with([
            'propertyFeatureds:id,name,property_id',
            'images:imageable_type,imageable_id,name',
            'user',
            'propertyLocation',
            'propertyLocation.city:id,name',
            'propertyLocation.state:id,name',
            'propertyLocation.country:id,name'
        ])->paginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->input(), [
            'user_id' => 'required',
            'title' => 'required',
            'status' => 'required',
            'type' => 'required',
            'price' => 'required',
            'size' => 'required',
            'year' => 'required',
            'bedrooms' => 'required',
            'bathroom' => 'required',
            'garages' => 'required',
            'features' => 'required',
            'location.address' => "required",
            'location.country_id' => 'required',
            'location.state_id' => 'required',
            'location.city_id' => 'required',
        ], [
            'location.address.required' => "address must requried",
            'location.country_id.required' => "please choose a country",
            'location.state_id.required' => "please choose a state",
            'location.city_id.required' => "please choose a city",
        ]);

        if ($validator->fails()) return response(['success' => false, 'error' => $validator->errors()]);


        $property = Property::create($request->only('user_id', 'title', 'type', 'status', 'price', 'size', 'year', 'bedrooms', 'bathroom', 'garages'));
        $property->propertyLocation()->create($request->location);

        if ($request->has('features')) {
            foreach ($request->features as $feature)
                PropertyFeatured::create(['name' => $feature, 'property_id' => $property->id]);
        }

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $originalName = explode(".", $image->getClientOriginalName())[0];
                $newName = str_replace(' ', '', $originalName) . "_" . $request->user_id . "_" . time() . "." . $image->extension();
                $image->move(public_path('uploads'), $newName);
                Image::create(['name' => $newName, 'imageable_type' => "App\\Models\\Property", "imageable_id" => $property->id]);
            }
        }

        return response(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return $property->load([
            'propertyFeatureds:id,name,property_id', 'images:imageable_type,imageable_id,name',
            'user',
            'propertyLocation',
            'propertyLocation.city:id,name',
            'propertyLocation.state:id,name',
            'propertyLocation.country:id,name'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
