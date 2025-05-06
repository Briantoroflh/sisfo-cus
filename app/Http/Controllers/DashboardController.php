<?php
namespace App\Http\Controllers;

use App\Models\Borrowed;
use App\Models\CategoryItems;
use App\Models\Items;
use App\Models\User;
use App\Models\DetailReturn;
use App\Models\DetailBorrow;


class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.Home', [
            'total_users' => User::count(),
            'total_categories' => CategoryItems::count(),
            'total_items' => Items::count(),
            'total_borrows' => Borrowed::count(),
            'total_returns' => Borrowed::where('status', 'returned')->count(),
            'recent_borrows' => Borrowed::with('user')->latest()->limit(5)->get(),
            'recent_users' => User::latest()->limit(5)->get(),
        ]);
    }
}
