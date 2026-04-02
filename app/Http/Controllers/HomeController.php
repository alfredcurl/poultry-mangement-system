<?php

namespace App\Http\Controllers;

use App\Models\{Role, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Middleware\Authorize;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Home";
        
        // Get poultry management data for admin dashboard
        if (auth()->user()->role_id == 1) { // Admin
            $today = date('Y-m-d');
            $thisMonth = date('Y-m');
            
            // Today's egg production
            $todayEggs = \App\Models\EggProduction::whereDate('production_date', $today)
                ->sum('good_eggs');
            
            // This month's sales
            $monthSales = \App\Models\Order::where('is_done', 1)
                ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$thisMonth])
                ->sum('total_price');
            
            // Total active birds
            $activeBirds = \App\Models\Bird::where('status', 'active')->get();
            $totalBirds = 0;
            foreach ($activeBirds as $bird) {
                $totalBirds += $bird->getCurrentQuantity();
            }
            
            // This month's mortality
            $monthMortality = \App\Models\MortalityRecord::whereRaw("DATE_FORMAT(death_date, '%Y-%m') = ?", [$thisMonth])
                ->sum('number_of_deaths');
            
            // Low stock alerts
            $lowStockFeeds = \App\Models\Feed::all()->filter(function($feed) {
                return $feed->getRemainingQuantity() < 50;
            })->count();
            
            $lowStockMeds = \App\Models\Medication::all()->filter(function($med) {
                return $med->getRemainingQuantity() < 10;
            })->count();
            
            // Total products (egg types)
            $totalProducts = \App\Models\Product::count();
            
            // Pending orders
            $pendingOrders = \App\Models\Order::where('is_done', 0)
                ->where('status_id', '!=', 4) // Not cancelled
                ->count();
            
            return view("/home/index", compact(
                "title", 
                "todayEggs", 
                "monthSales", 
                "totalBirds", 
                "monthMortality",
                "lowStockFeeds",
                "lowStockMeds",
                "totalProducts",
                "pendingOrders"
            ));
        }

        return view("/home/index", compact("title"));
    }

    public function customers()
    {
        $this->authorize("is_admin");

        $title = "Customers";
        $customers = User::with("role")->get();

        return view("home/customers",  compact("title", "customers"));
    }
}
