<?php

namespace App\Models;

use App\Observers\LocationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([LocationObserver::class])]
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'marker_color',
    ];

    public function calculateDistance(float $latitude, float $longitude): float
    {
        $theta = $longitude - $this->longitude;
        $distance = sin(deg2rad($latitude)) * sin(deg2rad($this->latitude))
            + cos(deg2rad($latitude)) * cos(deg2rad($this->latitude)) * cos(deg2rad($theta));

        $distance = min(max($distance, -1.0), 1.0);

        $distance = acos($distance);
        $distance = rad2deg($distance);

        $miles = $distance * 60 * 1.1515;

        return $miles * 1.609344;
    }

}
