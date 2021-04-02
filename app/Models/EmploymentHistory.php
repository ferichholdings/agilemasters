<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function instructor(){
        return $this->belongsTo('App\Models\Instructor');
    }
}
