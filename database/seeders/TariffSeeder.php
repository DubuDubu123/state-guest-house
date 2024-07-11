<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tariff;
use App\Models\PartyTariff;
use App\Models\MembershipTariff;
use App\Models\SportsTariff;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $tariff_data = [
    [
    'type' => 'room',
    'total_rooms' => 8,
    'day' => 1,
    'rent_for_officers_family' => 300,
    'rent_for_others' => 750,
    ],
    [
      'type' => 'room',
      'total_rooms' => 8,
      'day' => 2,
      'rent_for_officers_family' => 300,
      'rent_for_others' => 750,
    ],
    [  'type' => 'room',
    'total_rooms' => 8,
    'day' => 3,
    'rent_for_officers_family' => 300,
    'rent_for_others' => 750,
    ],
    [  'type' => 'room',
    'total_rooms' => 8,
    'day' => 4,
    'rent_for_officers_family' => 300,
    'rent_for_others' => 750,
    ],
    [  'type' => 'room',
    'total_rooms' => 8,
    'day' => 5,
    'rent_for_officers_family' => 300,
    'rent_for_others' => 750,
    ],
    [  'type' => 'room',
    'total_rooms' => 8,
    'day' => 6,
    'rent_for_officers_family' => 750,
    'rent_for_others' => 1125,
    ],
    [  'type' => 'room',
    'total_rooms' => 8,
    'day' => 7,
    'rent_for_officers_family' => 750,
    'rent_for_others' => 1125,
    ],
    [  'type' => 'room',
    'total_rooms' => 8,
    'day' => 8,
    'rent_for_officers_family' => 750,
    'rent_for_others' => 1125,
    ],
    [  'type' => 'room',
    'total_rooms' => 8,
    'day' => 9,
    'rent_for_officers_family' => 750,
    'rent_for_others' => 1125,
    ],
    [  'type' => 'room',
    'total_rooms' => 8,
    'day' => 10,
    'rent_for_officers_family' => 750,
    'rent_for_others' => 1125,
    ],
    [ 
    'type' => 'membership',
    'name' => "Life Time Members",
    'membership_type' => 1,
    'price' => 20000, 
    ],
    [ 
      'type' => 'membership',
    'name' => "Associate Members",
    'membership_type' => 0,
    'price' => 10000, 
    ],
    [
      'type' => 'party', 
      'day' => 1,
      'price' => 1000 
      ],
      [
        'type' => 'party', 
        'day' => 2,
        'price' => 2000 
      ],
      [   'type' => 'party', 
      'day' => 3,
      'price' => 3000 
      ],
      [   'type' => 'party', 
      'day' => 4,
      'price' => 4000 
      ],
      [   'type' => 'party', 
      'day' => 5,
      'price' => 5000 
      ],
      [   'type' => 'party', 
      'day' => 6,
      'price' => 10000
      ],
      [  'type' => 'party', 
      'day' => 7,
      'price' => 10000 
      ],
      [   'type' => 'party', 
      'day' => 8,
      'price' => 10000 
      ],
      [   'type' => 'party', 
      'day' => 9,
      'price' => 10000 
      ],
      [   'type' => 'party', 
      'day' => 10,
      'price' => 10000 
      ],
    [  'type' => 'sports',
    'name' => 'Gymanasium',
    'daily_tariff' => 30,
    'mothly_tariff' => 275,
    'yearly_tariff' => 2500
    ],
    ['type' => 'sports',
    'name' => 'Cards',
    'daily_tariff' => 60,
    'mothly_tariff' => 275, 
    'yearly_tariff' => 0
    ],
    [ 'type' => 'sports',
    'name' => 'Billiards',
    'daily_tariff' => 60,
    'mothly_tariff' => 275, 
    'yearly_tariff' => 0
    ],
    [  'type' => 'sports',
    'name' => 'Table Tennis',
    'daily_tariff' => 25,
    'mothly_tariff' => 275, 
    'yearly_tariff' => 0
    ],
    [  'type' => 'sports',
    'name' => 'Tennis',
    'daily_tariff' => 30,
    'mothly_tariff' => 275, 
    'yearly_tariff' => 0
    ],
    [  'type' => 'sports',
    'name' => 'Badminton',
    'daily_tariff' => 30,
    'mothly_tariff' => 275, 
    'yearly_tariff' => 0
    ],
    [  'type' => 'sports',
    'name' => 'Swimming Pool',
    'daily_tariff' => 30,
    'mothly_tariff' => 275, 
    'yearly_tariff' => 0
    ] 
    ];


    public function run()
    {
     
     $created_params = $this->tariff_data;  
     foreach($created_params as $key=>$value)
     {
      if($value['type'] == "room")
      {
        $room = new Tariff();
        $room->total_rooms = $value['total_rooms'];
        $room->day = $value['day'];
        $room->rent_for_officers_family = $value['rent_for_officers_family'];
        $room->rent_for_others = $value['rent_for_others'];
        $room->save();
      }
      if($value['type'] == "membership")
      {
        $membership = new MembershipTariff();
        $membership->membership_type = $value['membership_type'];
        $membership->price = $value['price'];
        $membership->name = $value['name']; 
        $membership->save();
      }
      if($value['type'] == "party")
      {
        $party = new PartyTariff(); 
        $party->day = $value['day'];
        $party->price = $value['price'];
        $party->save();
      }
      if($value['type'] == "sports")
      {
        $sports = new SportsTariff();
        $sports->name = $value['name'];
        $sports->daily_tariff = $value['daily_tariff'];
        $sports->mothly_tariff = $value['mothly_tariff']; 
        $sports->yearly_tariff = $value['yearly_tariff']; 
        $sports->save();
      }
     } 
    }
}
