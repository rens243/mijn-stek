<?php

namespace App\Http\Controllers;

use App\Services\TrashVaccineService;
use Illuminate\Http\Request;

class TrashVaccineController extends Controller
{
    public function index()
    {
        $service = new TrashVaccineService();

        $response = $service->emailAvailableVaccineLocations();

        return view('trash-test', compact(['response']));
    }
}
