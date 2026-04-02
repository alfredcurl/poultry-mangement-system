<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\EggProduction;
use App\Models\Expense;
use App\Models\Feed;
use App\Models\Medication;
use App\Models\Bird;
use App\Models\MortalityRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Dashboard with overview
    public function dashboard()
    {
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        
        // Today's egg production
        $todayEggs = EggProduction::whereDate('production_date', $today)
            ->sum('good_eggs');
        
        // This month's sales
        $monthSales = Order::where('is_done', 1)
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$thisMonth])
            ->sum('total_price');
        
        // Total active birds
        $activeBirds = Bird::where('status', 'active')->get();
        $totalBirds = 0;
        foreach ($activeBirds as $bird) {
            $totalBirds += $bird->getCurrentQuantity();
        }
        
        // This month's mortality
        $monthMortality = MortalityRecord::whereRaw("DATE_FORMAT(death_date, '%Y-%m') = ?", [$thisMonth])
            ->sum('number_of_deaths');
        
        // Low stock alerts
        $lowStockFeeds = Feed::all()->filter(function($feed) {
            return $feed->getRemainingQuantity() < 50; // Less than 50kg
        });
        
        $lowStockMeds = Medication::all()->filter(function($med) {
            return $med->getRemainingQuantity() < 10;
        });
        
        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'todayEggs' => $todayEggs,
            'monthSales' => $monthSales,
            'totalBirds' => $totalBirds,
            'monthMortality' => $monthMortality,
            'lowStockFeeds' => $lowStockFeeds,
            'lowStockMeds' => $lowStockMeds
        ]);
    }

    // Profit & Loss Report
    public function profitLoss(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        // Income from egg sales
        $eggSales = Order::where('is_done', 1)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('total_price');
        
        // Expenses
        $generalExpenses = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');
        
        $feedExpenses = Feed::whereBetween('purchase_date', [$startDate, $endDate])
            ->sum('total_cost');
        
        $medicationExpenses = Medication::whereBetween('purchase_date', [$startDate, $endDate])
            ->sum('total_cost');
        
        $birdAcquisition = Bird::whereBetween('acquisition_date', [$startDate, $endDate])
            ->sum('acquisition_cost');
        
        $totalExpenses = $generalExpenses + $feedExpenses + $medicationExpenses + $birdAcquisition;
        $profit = $eggSales - $totalExpenses;
        
        return view('admin.reports.profit_loss', [
            'title' => 'Profit & Loss Report',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'eggSales' => $eggSales,
            'generalExpenses' => $generalExpenses,
            'feedExpenses' => $feedExpenses,
            'medicationExpenses' => $medicationExpenses,
            'birdAcquisition' => $birdAcquisition,
            'totalExpenses' => $totalExpenses,
            'profit' => $profit
        ]);
    }

    // Sales Report
    public function salesReport(Request $request)
    {
        $period = $request->input('period', 'monthly'); // daily, monthly, yearly
        $date = $request->input('date', date('Y-m'));
        
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        
        if ($period == 'daily') {
            $sales = Order::with('product')
                ->where('is_done', 1)
                ->whereDate('updated_at', $date)
                ->get();
            
            $groupedSales = $sales->groupBy('product_id')->map(function($orders) {
                return [
                    'product' => $orders->first()->product,
                    'quantity' => $orders->sum('quantity'),
                    'total' => $orders->sum('total_price'),
                    'orders' => $orders->count(),
                ];
            });
        } elseif ($period == 'monthly') {
            $sales = Order::with('product')
                ->where('is_done', 1)
                ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$date])
                ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(total_price) as total_sales, COUNT(*) as order_count')
                ->groupBy('product_id')
                ->get();
            
            $groupedSales = $sales->map(function($sale) {
                return [
                    'product' => \App\Models\Product::find($sale->product_id),
                    'quantity' => $sale->total_quantity,
                    'total' => $sale->total_sales,
                    'orders' => $sale->order_count
                ];
            });
        } else { // yearly
            $sales = Order::where('is_done', 1)
                ->whereRaw("YEAR(updated_at) = ?", [$date])
                ->selectRaw("DATE_FORMAT(updated_at, '%Y-%m') as month, SUM(total_price) as total_sales, SUM(quantity) as total_quantity")
                ->groupByRaw("DATE_FORMAT(updated_at, '%Y-%m')")
                ->orderByRaw("DATE_FORMAT(updated_at, '%Y-%m')")
                ->get();
            
            $groupedSales = $sales;
        }
        
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        
        $totalSales = is_object($groupedSales) ? $groupedSales->sum('total') : collect($groupedSales)->sum('total_sales');
        
        return view('admin.reports.sales', [
            'title' => 'Sales Report',
            'period' => $period,
            'date' => $date,
            'sales' => $groupedSales,
            'totalSales' => $totalSales
        ]);
    }

    // Inventory Report
    public function inventoryReport()
    {
        // Bird inventory
        $birds = Bird::where('status', 'active')->get();
        foreach ($birds as $bird) {
            $bird->current_quantity = $bird->getCurrentQuantity();
        }
        
        // Feed inventory
        $feeds = Feed::all();
        foreach ($feeds as $feed) {
            $feed->remaining = $feed->getRemainingQuantity();
        }
        
        // Medication inventory
        $medications = Medication::all();
        foreach ($medications as $medication) {
            $medication->remaining = $medication->getRemainingQuantity();
        }
        
        // Egg stock (from products)
        $eggProducts = \App\Models\Product::all();
        
        return view('admin.reports.inventory', [
            'title' => 'Inventory Report',
            'birds' => $birds,
            'feeds' => $feeds,
            'medications' => $medications,
            'eggProducts' => $eggProducts
        ]);
    }
}
