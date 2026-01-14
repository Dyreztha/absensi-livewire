<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkLocation extends Model
{
    protected $fillable = ['name','lat','lng','radius_meters','active'];

}
