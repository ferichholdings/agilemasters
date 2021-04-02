<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    
    protected $guarded =[];

    public function employmentHistories(){
        return $this->hasMany('App\Models\EmploymentHistory');
    }
    public function educationHistories(){
        return $this->hasMany('App\Models\EducationHistory');
    }
    public function references(){
        return $this->hasMany('App\Models\Reference');
    }
    public function certifications(){
        return $this->hasMany('App\Models\Certification');
    }
}
