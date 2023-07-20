<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bazaar;
use App\Models\FoodWeight;

class FoodWeightsController extends Controller
{
    public function create(Request $request)
    {
        $bazaars = Bazaar::pluck('bazaarName', 'bazaarName');
        $years = [2022, 2023, 2024];

        $selectedBazaar = $request->input('bazaarName');
        $selectedYear = $request->input('year');

        $foodWeights = FoodWeight::where('bazaarName', $selectedBazaar)
            ->where('year', $selectedYear)
            ->orderBy('day')
            ->get();

        return view('foodweights.create', compact('bazaars', 'years', 'selectedBazaar', 'selectedYear', 'foodWeights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bazaarName' => 'required',
            'year' => 'required|integer',
            'day' => 'required|integer|min:1|max:30',
            'weight' => 'required|numeric',
        ]);

        $bazaarName = $request->input('bazaarName');
        $year = $request->input('year');
        $day = $request->input('day');
        $weight = $request->input('weight');

        FoodWeight::create([
            'bazaarName' => $bazaarName,
            'year' => $year,
            'day' => $day,
            'weight' => $weight,
        ]);

        return redirect()->back()->with('success', 'Food weight added successfully.');
    }

    public function index(Request $request)
    {
        $years = [2022, 2023, 2024];
        $selectedYear = $request->query('year');
        $selectedBazaar = $request->query('bazaarName');
        $selectedBazaar = auth()->user()->bazaarName;
        $userRole = auth()->user()->role;
        $foodWeights = FoodWeight::where('year', $selectedYear)
            ->where('bazaarName', $selectedBazaar)
            ->orderBy('day')
            ->get();

        $bazaars = Bazaar::pluck('bazaarName', 'bazaarName');

        // Get the authenticated user's role
         // Update this based on your authentication system

        return view('foodweights.foodWeightList', compact('years', 'selectedYear', 'selectedBazaar', 'foodWeights', 'bazaars', 'userRole'));
    }

    public function indexAdmin(Request $request)
    {
        $years = [2022, 2023, 2024];
        $selectedYear = $request->query('year');
        $selectedBazaar = $request->query('bazaarName');
  

        $foodWeights = FoodWeight::where('year', $selectedYear)
            ->where('bazaarName', $selectedBazaar)
            ->orderBy('day')
            ->get();

        $bazaars = Bazaar::pluck('bazaarName', 'bazaarName');

        return view('foodweights.foodWeightListAdmin', compact('years', 'selectedYear', 'selectedBazaar', 'foodWeights', 'bazaars'));
    }

    public function update(Request $request, FoodWeight $foodWeight)
    {
        $request->validate([
            'weight' => 'required|numeric',
        ]);

        $foodWeight->weight = $request->input('weight');
        $foodWeight->save();

        return redirect()->back()->with('success', 'Food weight updated successfully.');
    }

    public function analysisByBazaar(Request $request)
    {
        $bazaars = Bazaar::pluck('bazaarName', 'bazaarName');
        $years = [2022, 2023, 2024];

        $selectedBazaar = $request->input('bazaarName', []);
        $selectedYear = $request->input('year');

        $foodWeightsQuery = FoodWeight::query();

        if (!empty($selectedBazaar)) {
            $foodWeightsQuery->whereIn('bazaarName', $selectedBazaar);
        }

        if ($selectedYear) {
            $foodWeightsQuery->where('year', $selectedYear);
        }

        $foodWeights = $foodWeightsQuery->orderBy('day')->get();

        // Calculate the total weight for each bazaar
        $bazaarWeights = $foodWeights->groupBy('bazaarName')->map(function ($group) {
            return $group->sum('weight');
        });

        // Calculate the average weight for each bazaar
        $bazaarAverages = $foodWeights->groupBy('bazaarName')->map(function ($group) {
            $nonZeroWeights = $group->where('weight', '>', 0);
            if ($nonZeroWeights->isNotEmpty()) {
                return $nonZeroWeights->avg('weight');
            } else {
                return 0;
            }
        });

        // Calculate the total weight for the selected bazaars and year
        $selectedBazaarTotalWeight = $bazaarWeights->only($selectedBazaar)->sum();

        $countInstances = $foodWeightsQuery->count();

        // Calculate the average weight for the selected bazaars and year
        $selectedBazaarAverageWeight = $countInstances > 0 ? ($selectedBazaarTotalWeight / $countInstances) : 0;

        return view(
            'foodweights.analysisByBazaar',
            compact(
                'bazaars',
                'years',
                'selectedBazaar',
                'selectedYear',
                'foodWeights',
                'bazaarWeights',
                'bazaarAverages',
                'selectedBazaarTotalWeight',
                'countInstances',
                'selectedBazaarAverageWeight'
            )
        );
    }


    public function analysisByYear(Request $request)
    {
        $bazaars = Bazaar::pluck('bazaarName', 'bazaarName');
        $years = [2022, 2023, 2024];

        $selectedBazaar = $request->input('bazaarName');
        $selectedYears = $request->input('years', []);

        $foodWeights = FoodWeight::where(function ($query) use ($selectedBazaar, $request) {
            if (!empty($selectedBazaar)) {
                $query->whereIn('bazaarName', [$request->input('bazaarName')]);
            }
        })
            ->when(!empty($selectedYears), function ($query) use ($selectedYears) {
                $query->whereIn('year', $selectedYears);
            })
            ->orderBy('day')
            ->get();

        // Calculate the total weight for each year in the selected bazaar
        $bazaarWeights = $foodWeights->groupBy('year')->map(function ($group) {
            return $group->sum('weight');
        });

        $selectedYearsTotalWeight = $bazaarWeights->only($selectedYears)->sum();

        $countInstances = FoodWeight::whereIn('year', $selectedYears)
            ->where('bazaarName', $selectedBazaar)
            ->count();


        // Calculate the average weight for the selected bazaars and year
        $selectedYearsAverageWeight = $countInstances > 0 ? ($selectedYearsTotalWeight / $countInstances) : 0;


        return view('foodweights.analysisByYear', compact('bazaars', 'years', 'selectedBazaar', 'selectedYears', 'foodWeights', 'bazaarWeights', 'selectedYearsTotalWeight', 'selectedYearsAverageWeight'));
    }
    public function analysisByBazaar2(Request $request)
    {
        $bazaars = Bazaar::pluck('bazaarName', 'bazaarName');
        $years = [2022, 2023, 2024];

        $selectedBazaar = $request->input('bazaarName', []);
        $selectedYear = $request->input('year');

        $foodWeightsQuery = FoodWeight::query();

        if (!empty($selectedBazaar)) {
            $foodWeightsQuery->whereIn('bazaarName', $selectedBazaar);
        }

        if ($selectedYear) {
            $foodWeightsQuery->where('year', $selectedYear);
        }

        $foodWeights = $foodWeightsQuery->orderBy('day')->get();

        // Calculate the total weight for each bazaar
        $bazaarWeights = $foodWeights->groupBy('bazaarName')->map(function ($group) {
            return $group->sum('weight');
        });

        // Calculate the average weight for each bazaar
        $bazaarAverages = $foodWeights->groupBy('bazaarName')->map(function ($group) {
            $nonZeroWeights = $group->where('weight', '>', 0);
            if ($nonZeroWeights->isNotEmpty()) {
                return $nonZeroWeights->avg('weight');
            } else {
                return 0;
            }
        });

        // Calculate the total weight for the selected bazaars and year
        $selectedBazaarTotalWeight = $bazaarWeights->only($selectedBazaar)->sum();

        $countInstances = $foodWeightsQuery->count();

        // Calculate the average weight for the selected bazaars and year
        $selectedBazaarAverageWeight = $countInstances > 0 ? ($selectedBazaarTotalWeight / $countInstances) : 0;

        return view(
            'analysis.analysisByBazaar',
            compact(
                'bazaars',
                'years',
                'selectedBazaar',
                'selectedYear',
                'foodWeights',
                'bazaarWeights',
                'bazaarAverages',
                'selectedBazaarTotalWeight',
                'countInstances',
                'selectedBazaarAverageWeight'
            )
        );
    }


    public function analysisByYear2(Request $request)
    {
        $bazaars = Bazaar::pluck('bazaarName', 'bazaarName');
        $years = [2022, 2023, 2024];

        $selectedBazaar = $request->input('bazaarName');
        $selectedYears = $request->input('years', []);

        $foodWeights = FoodWeight::where(function ($query) use ($selectedBazaar, $request) {
            if (!empty($selectedBazaar)) {
                $query->whereIn('bazaarName', [$request->input('bazaarName')]);
            }
        })
            ->when(!empty($selectedYears), function ($query) use ($selectedYears) {
                $query->whereIn('year', $selectedYears);
            })
            ->orderBy('day')
            ->get();

        // Calculate the total weight for each year in the selected bazaar
        $bazaarWeights = $foodWeights->groupBy('year')->map(function ($group) {
            return $group->sum('weight');
        });

        $selectedYearsTotalWeight = $bazaarWeights->only($selectedYears)->sum();

        $countInstances = FoodWeight::whereIn('year', $selectedYears)
            ->where('bazaarName', $selectedBazaar)
            ->count();


        // Calculate the average weight for the selected bazaars and year
        $selectedYearsAverageWeight = $countInstances > 0 ? ($selectedYearsTotalWeight / $countInstances) : 0;


        return view('analysis.analysisByYear', compact('bazaars', 'years', 'selectedBazaar', 'selectedYears', 'foodWeights', 'bazaarWeights', 'selectedYearsTotalWeight', 'selectedYearsAverageWeight'));
    }

}