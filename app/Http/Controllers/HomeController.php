<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\FoodWeight;
use App\Models\Duty;
use App\Models\Bazaar;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $role = Auth()->user()->role;

            if ($role == 'volunteer') {

                // $bazaars = Bazaar::all();
                $user = Auth::user();

                // Get the current volunteering information
                $currentBazaarName = $user->bazaarName;
                $currentDutyName = $user->dutyName;

                // Retrieve duty information based on dutyName
                $duty = Duty::where('dutyName', $currentDutyName)->first();
                $bazaar = Bazaar::where('bazaarName', $currentBazaarName)->first();
                $bazaarLocation = $bazaar ? $bazaar->bazaarAddress : null;
                $dutyRemarks = $duty ? $duty->dutyRemarks : null;
                $dutyLocation = $duty ? $duty->dutyLocation : null;

                return view('volunteer.dashboard', compact('currentBazaarName', 'currentDutyName','bazaarLocation', 'dutyRemarks', 'dutyLocation'));

                // return view('volunteer.dashboard');
            } else if ($role == 'admin') {
                $currentUser = Auth::user();

                $volunteerCount = User::where('role', 'volunteer')
                    ->count();

                $BLCount = User::where('role', 'bazaar_leader')
                    ->count();

                $notAssign = User::where('role', 'volunteer')
                    ->whereNull('dutyName') // Add this condition to filter users with no dutyName
                    ->count();

                $totalWeight = FoodWeight::sum('weight');
                $totalDuties = Duty::distinct('dutyName')->count();
                $totalBazaar = Duty::distinct('bazaarName')->count();



                return view('admin.adminhome')
                    ->with('volunteerCount', $volunteerCount)
                    ->with('BLCount', $BLCount)
                    ->with('notAssign', $notAssign)
                    ->with('totalWeight', $totalWeight)
                    ->with('totalDuties', $totalDuties)
                    ->with('totalBazaar', $totalBazaar)
                ;
            } else if ($role == 'bazaar_leader') {
                $currentUser = Auth::user();
                $bazaarName = $currentUser->bazaarName;

                $volunteerCount = User::where('role', 'volunteer')
                    ->where('bazaarName', $bazaarName)
                    ->count();

                $notAssign = User::where('role', 'volunteer')
                    ->where('bazaarName', $bazaarName)
                    ->whereNull('dutyName') // Add this condition to filter users with no dutyName
                    ->count();

                $totalWeight = FoodWeight::where('bazaarName', $bazaarName)
                    ->sum('weight'); // Calculate the sum of the 'weight' column in the food_weights table

                return view('bazaarleader.bazaarleaderhome')
                    ->with('volunteerCount', $volunteerCount)
                    ->with('notAssign', $notAssign)
                    ->with('totalWeight', $totalWeight);
            } else {
                return redirect()->back();
            }
        }
    }

    public function post()
    {
        return view('post');
    }

}