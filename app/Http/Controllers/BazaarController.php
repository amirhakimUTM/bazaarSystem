<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Bazaar;
use App\Models\User;
use App\Models\Duty;

class BazaarController extends Controller
{
    public function create()
    {
        return view('bazaar.addBazaar');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bazaarName' => 'required',
            'bazaarAddress' => 'required',
            'volunteerLimit' => 'required|integer|min:0', // Add validation for volunteerLimit
        ]);

        $bazaar = Bazaar::create([
            'bazaarName' => $request->input('bazaarName'),
            'bazaarAddress' => $request->input('bazaarAddress'),
            'volunteerLimit' => $request->input('volunteerLimit'), // Store the volunteerLimit value
        ]);

        return redirect()->route('bazaar.bazaarList')->with('success', 'Bazaar added successfully.');
    }

    public function index()
    {
        $bazaars = Bazaar::all();

        return view('bazaar.bazaarList', compact('bazaars'));
    }


    public function edit($bazaarName)
    {
        $bazaar = Bazaar::where('bazaarName', $bazaarName)->first();

        if (!$bazaar) {
            return redirect()->route('bazaar.index')->with('error', 'Bazaar not found.');
        }

        return view('bazaar.editBazaar', compact('bazaar'));
    }

    public function update(Request $request, $bazaarName)
    {
        $request->validate([
            'bazaarName' => 'required',
            'bazaarAddress' => 'required',
            'volunteerLimit' => 'required|integer|min:0',
        ]);

        $bazaar = Bazaar::where('bazaarName', $bazaarName)->first();

        if (!$bazaar) {
            return redirect()->route('bazaar.index')->with('error', 'Bazaar not found.');
        }

        $bazaar->bazaarName = $request->input('bazaarName');
        $bazaar->bazaarAddress = $request->input('bazaarAddress');
        $bazaar->volunteerLimit = $request->input('volunteerLimit');
        $bazaar->save();

        return redirect()->route('bazaar.bazaarList')->with('success', 'Bazaar updated successfully.');
    }


    public function destroy($bazaarName)
    {
        $bazaar = Bazaar::where('bazaarName', $bazaarName)->first();

        if (!$bazaar) {
            return redirect()->route('bazaar.bazaarList')->with('error', 'Bazaar not found.');
        }

        // Delete the associated food_weights records
        $bazaar->foodWeights()->delete();

        $bazaarLeader = User::where('name')
            ->where('bazaarName', $bazaar)
            ->where('role', 'bazaar_leader')
            ->first();

        if ($bazaarLeader) {
            $bazaarLeader->delete();
        }

        // Delete the bazaar record
        $bazaar->delete();

        return redirect()->route('bazaar.bazaarList')->with('success', 'Bazaar and associated data deleted successfully.');
    }


    public function createBL()
    {
        $bazaars = Bazaar::all();
        return view('bazaar.addBL', compact('bazaars'));
    }

    public function storeBL(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telNo' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'bazaarName' => 'nullable|exists:bazaars,bazaarName',
        ]);

        // Create a new bazaar leader
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'telNo' => $validatedData['telNo'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'bazaar_leader',
            'bazaarName' => $validatedData['bazaarName'],
        ]);

        return redirect()->route('bazaar.indexBL')->with('success', 'Bazaar leader created successfully.');
    }

    public function updateBL(Request $request, $name)
    {
        // Find the Bazaar leader by name
        $user = User::where('name', $name)->first();

        if (!$user) {
            // Handle the case where the Bazaar leader is not found
            return redirect()->back()->with('error', 'Bazaar leader not found.');
        }

        // Update the bazaarName field with the new value
        $user->bazaarName = $request->input('bazaarName');
        $user->save();

        // Redirect back to the page or any other suitable action
        return redirect()->back()->with('success', 'Bazaar leader bazaarName updated successfully.');
    }


    public function editBL($bazaarName)
    {
        // Find the Bazaar leader by the assigned Bazaar name
        $user = User::where('bazaarName', $bazaarName)->first();

        if (!$user) {
            // Handle the case where the Bazaar leader is not found
            return redirect()->back()->with('error', 'Bazaar leader not found.');
        }

        // Get the list of available Bazaars for reassignment
        $bazaars = Bazaar::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('bazaarName', $user->bazaarName);
        })->get();

        // Pass the Bazaar leader and available Bazaars to the view
        return view('bazaar.editBL', compact('user', 'bazaars'));
    }



    public function indexBL()
    {
        // Retrieve users with role 'bazaar_leader'
        $users = User::where('role', 'bazaar_leader')->get();
        return view('bazaar.bazaarLeaderList', ['users' => $users]);
    }

    public function indexV()
    {
        $userRole = auth()->user()->role; // Get the authenticated user's role

        if ($userRole === 'bazaar_leader') {
            $bazaarName = auth()->user()->bazaarName; // Assuming the bazaarName is stored in the authenticated user's model
            $users = User::where('role', 'volunteer')
                ->where('bazaarName', $bazaarName)
                ->get();
        } else {
            $users = User::where('role', 'volunteer')->get();
        }

        $bazaars = Bazaar::all(); // Assuming you have a Bazaar model and table

        return view('bazaar.volunteerList', ['users' => $users, 'bazaars' => $bazaars, 'userRole' => $userRole]);
    }


    public function chooseVolunteer()
    {
        $bazaars = Bazaar::all();
        $user = Auth::user();

        // Get the current volunteering information
        $currentBazaarName = $user->bazaarName;
        $currentDutyName = $user->dutyName;

        // Retrieve duty information based on dutyName
        $duty = Duty::where('dutyName', $currentDutyName)->first();
        $dutyRemarks = $duty ? $duty->dutyRemarks : null;
        $dutyLocation = $duty ? $duty->dutyLocation : null;

        return view('volunteer.chooseVolunteer', compact('bazaars', 'currentBazaarName', 'currentDutyName', 'dutyRemarks', 'dutyLocation'));
    }


    public function volunteerToBazaar(Request $request)
    {
        $bazaarName = $request->input('bazaarName');
        $user = Auth::user();

        // Check if the user is a volunteer
        if ($user->role !== 'volunteer') {
            return redirect()->back()->with('error', 'Only volunteers can volunteer for a bazaar.');
        }

        // Check if the volunteer limit has been reached
        $bazaar = Bazaar::where('bazaarName', $bazaarName)->first();
        if ($bazaar && $bazaar->users()->where('role', 'volunteer')->count() >= $bazaar->volunteerLimit) {
            return redirect()->back()->with('error', 'Volunteer limit has been reached for this bazaar.');
        }

        // Update the user's bazaarName and dutyName
        $user->bazaarName = $bazaarName;
        $user->dutyName = null; // Update this value as needed
        $user->save();

        return redirect()->back()->with('success', 'Volunteered successfully for the bazaar.');
    }

    public function assignDuty(Request $request)
    {
        $userId = $request->input('userId');
        $dutyName = $request->input('dutyName');

        // Find the user by ID
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update the dutyName for the user
        $user->dutyName = $dutyName;
        $user->save();

        return response()->json(['message' => 'Duty assigned successfully']);
    }

    public function deleteVolunteer($name)
    {
        $user = User::where('name', $name)->first();

        if ($user) {
            $user->delete();
            // Perform any additional actions or redirects after deletion
            return redirect()->back()->with('success', 'Volunteer deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Volunteer not found');
        }
    }

}