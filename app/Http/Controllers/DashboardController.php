<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $homeController = app()->make(HomeController::class);

        return $homeController->index();
    }
}
