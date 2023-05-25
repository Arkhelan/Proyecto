<?php
namespace App\Http\Controllers;

use App\Models\USB;

class USBController extends Controller
{
    public function index()
    {
        $usbs = USB::all();

        return view('index', compact('usbs'));
    }
}
