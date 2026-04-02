<?php

namespace App\Http\Controllers;

use App\Models\Bird;
use App\Models\EggProduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EggProductionController extends Controller
{
    // Display egg production records
    public function index(Request $request)
    {
        $query = EggProduction::with('bird');
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('production_date', [$request->start_date, $request->end_date]);
        }
        
        $productions = $query->orderBy('production_date', 'desc')->get();
        
        // Calculate totals
        $totalEggs = $productions->sum('eggs_collected');
        $totalDamaged = $productions->sum('damaged_eggs');
        $totalGood = $productions->sum('good_eggs');
        
        return view('admin.egg_production.index', [
            'title' => 'Egg Production',
            'productions' => $productions,
            'totalEggs' => $totalEggs,
            'totalDamaged' => $totalDamaged,
            'totalGood' => $totalGood
        ]);
    }

    // Show form to add production record
    public function create()
    {
        $birds = Bird::where('status', 'active')
            ->where('bird_type', 'Layer')
            ->get();
        
        return view('admin.egg_production.create', [
            'title' => 'Record Egg Production',
            'birds' => $birds
        ]);
    }

    // Store production record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bird_id' => 'required|exists:birds,id',
            'production_date' => 'required|date',
            'eggs_collected' => 'required|integer|min:0',
            'damaged_eggs' => 'required|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate damaged eggs don't exceed collected eggs
        if ($request->damaged_eggs > $request->eggs_collected) {
            return redirect()->back()
                ->withErrors(['damaged_eggs' => 'Damaged eggs cannot exceed total eggs collected'])
                ->withInput();
        }

        EggProduction::create($request->all());

        return redirect('/egg-production')->with('success', 'Egg production recorded successfully!');
    }

    // Daily report
    public function dailyReport(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        $productions = EggProduction::with('bird')
            ->whereDate('production_date', $date)
            ->get();
        
        $totalEggs = $productions->sum('eggs_collected');
        $totalDamaged = $productions->sum('damaged_eggs');
        $totalGood = $productions->sum('good_eggs');
        
        return view('admin.reports.daily_egg_production', [
            'title' => 'Daily Egg Production Report',
            'date' => $date,
            'productions' => $productions,
            'totalEggs' => $totalEggs,
            'totalDamaged' => $totalDamaged,
            'totalGood' => $totalGood
        ]);
    }

    // Monthly report
    public function monthlyReport(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        
        $productions = EggProduction::with('bird')
            ->whereRaw("DATE_FORMAT(production_date, '%Y-%m') = ?", [$month])
            ->selectRaw('bird_id, SUM(eggs_collected) as total_eggs, SUM(damaged_eggs) as total_damaged, SUM(good_eggs) as total_good')
            ->groupBy('bird_id')
            ->get();
        
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        
        $totalEggs = $productions->sum('total_eggs');
        $totalDamaged = $productions->sum('total_damaged');
        $totalGood = $productions->sum('total_good');
        
        return view('admin.reports.monthly_egg_production', [
            'title' => 'Monthly Egg Production Report',
            'month' => $month,
            'productions' => $productions,
            'totalEggs' => $totalEggs,
            'totalDamaged' => $totalDamaged,
            'totalGood' => $totalGood
        ]);
    }

    // Yearly report
    public function yearlyReport(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        
        $productions = EggProduction::whereRaw("YEAR(production_date) = ?", [$year])
            ->selectRaw("DATE_FORMAT(production_date, '%Y-%m') as month, SUM(eggs_collected) as total_eggs, SUM(damaged_eggs) as total_damaged, SUM(good_eggs) as total_good")
            ->groupByRaw("DATE_FORMAT(production_date, '%Y-%m')")
            ->orderByRaw("DATE_FORMAT(production_date, '%Y-%m')")
            ->get();
        
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        
        $totalEggs = $productions->sum('total_eggs');
        $totalDamaged = $productions->sum('total_damaged');
        $totalGood = $productions->sum('total_good');
        
        return view('admin.reports.yearly_egg_production', [
            'title' => 'Yearly Egg Production Report',
            'year' => $year,
            'productions' => $productions,
            'totalEggs' => $totalEggs,
            'totalDamaged' => $totalDamaged,
            'totalGood' => $totalGood
        ]);
    }
}
