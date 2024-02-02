<?php

namespace App\Http\Controllers;

use App\Actions\MyMenuAction;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $categoryTree = MyMenuAction::handle(auth()->user());
        dd($categoryTree);
        return Inertia::render('Dashboard', ['categoryTree' => $categoryTree]);
    }
}
