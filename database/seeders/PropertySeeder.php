<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Image;
use App\Models\PropertyFeatured;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ['apartment', 'house', 'office', 'villa', 'store', 'resturent'];
        $locations = [
            ['state_id' => 22, 'city_id' => 2726, 'country_id' => 101, 'address' => 'xyz street'],
            ['state_id' => 33, 'city_id' => 3378, 'country_id' => 101, 'address' => 'abc town'],
            ['state_id' => 10, 'city_id' => 707, 'country_id' => 101, 'address' => 'abc street'],
        ];

        $status = ['rent', 'sale'];
        $i = 1;
        $properperties = [
            [
                "title" => "Home in Merrick Way",
                "price" => "400000",
                "property_id" => '45617',
                'size' => '2283',
                'bedrooms' => '5',
                'bathroom' => '2',
                'garages' => '1',
                'year' => '1991',
                'feature' => [
                    "air conditioning",
                    "barbeque",
                    "dryer",
                    "gym"
                ]

            ],
            [
                "title" => "Unimont Aurum",
                "price" => "45678",
                "property_id" => '3645',
                'size' => '4789',
                'bedrooms' => '10',
                'bathroom' => '6',
                'garages' => '2',
                'year' => '1978',
                'feature' => [
                    'refrigerator',
                    'sauna',
                    'swimming pool',
                    'tv cable'
                ]

            ],
            [
                "title" => "Vrindavan Flora",
                "price" => "400000",
                "property_id" => '7894',
                'size' => '6894',
                'bedrooms' => '15',
                'bathroom' => '7',
                'garages' => '3',
                'year' => '2003',
                'feature' => [
                    'washer',
                    'Wifi',
                    'window coverings',
                    'villa'
                ]

            ],
            [
                "title" => "Shramik Vaibhav",
                "price" => "6512345",
                "property_id" => '78945',
                'size' => '12345',
                'bedrooms' => '10',
                'bathroom' => '4',
                'garages' => '6',
                'year' => '1203',
                'feature' => [
                    'refrigerator',
                    'sauna',
                    'swimming pool',
                    'tv cable'
                ]

            ],
            [
                "title" => "Poddar Wondercity",
                "price" => "1245646",
                "property_id" => '65423',
                'size' => '45614',
                'bedrooms' => '3',
                'bathroom' => '2',
                'garages' => '1',
                'year' => '1990',
                'feature' => [
                    'washer',
                    'Wifi',
                    'window coverings',
                    'villa'
                ]

            ],
            [
                "title" => "GoldCrest Residency",
                "price" => "9874546",
                "property_id" => '14561',
                'size' => '78945',
                'bedrooms' => '12',
                'bathroom' => '11',
                'garages' => '5',
                'year' => '2000',
                'feature' => [
                    "air conditioning",
                    "barbeque",
                    "dryer",
                    "gym"
                ]

            ],

        ];

        foreach ($properperties as $property) {
            $images = [];
            unset($images);
            $images[] = "property-$i.jpg";
            $images[] = "ps-" . rand(1, 2) . ".jpg";
            $images[] = "ps-" . rand(3, 5) . ".jpg";

            $propertyInsert = Property::create([
                'title' => $property['title'],
                'price' => $property['price'],
                'size' => $property['size'],
                'type' => $type[array_rand($type)],
                'status' => $status[array_rand($status)],
                'bedrooms' => $property['bedrooms'],
                'bathroom' => $property['bathroom'],
                'garages' => $property['garages'],
                'year' => $property['year'],
                'user_id' => rand(1, 5)
            ]);

            $propertyInsert->propertyLocation()->create(
                $locations[array_rand($locations)]);


            foreach ($images as $image)
                Image::create(['name' => $image, 'imageable_type' => "App\\Models\\Property", "imageable_id" => $propertyInsert->id]);


            foreach ($property['feature'] as $feature)
                PropertyFeatured::create(['name' => $feature, 'property_id' => $propertyInsert->id]);


            $i++;
        }
    }
}
