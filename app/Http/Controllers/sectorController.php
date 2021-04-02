<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sectorController extends Controller
{
    public function business(){
        return view('sectors.business');
    }
    public function defense(){
        return view('sectors.defense');
    }

    public function fc(){
        return view('sectors.fc');
    }

    public function government(){
        return view('sectors.government');
    }

    public function hospitality(){
        return view('sectors.hospitality');
    }
    public function  info_tech(){
        return view('sectors.info_tech');
    }

    public function media(){
        return view('sectors.media');
    }
    public function legal(){
        return view('sectors.legal');
    }

    public function medical(){
        return view('sectors.medical');
    }

}
