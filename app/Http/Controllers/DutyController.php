<?php

namespace App\Http\Controllers;

use App\Models\Duty;
use App\Models\Bazaar;
use Illuminate\Http\Request;

class DutyController extends Controller
{
    public function create()
    {
        // Retrieve all bazaar names for filtering
        $bazaarNames = Bazaar::pluck('bazaarName', 'id');

        return view('duty.create', compact('bazaarNames'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dutyType' => 'required',
            'bazaarName' => 'required',
            'dutyRemarks' => 'nullable|string',
            'dutyLocation' => 'nullable|string',
        ]);

        // Create the duty name with the format "dutyType(bazaarName)"
        $dutyName = $request->input('dutyType') . '(' . $request->input('bazaarName') . ')';

        // Check if a duty with the same name already exists
        $existingDuty = Duty::where('dutyName', $dutyName)->first();

        if ($existingDuty) {
            // return redirect()->back()->withErrors(['dutyName' => 'A duty with the same name already exists. Please choose a different name.'])->withInput();
            return redirect()->back()->with('error', 'A duty with the same name already exists. Please choose a different name.');
        }

        Duty::create([
            'dutyName' => $dutyName,
            'bazaarName' => $validatedData['bazaarName'],
            'dutyRemarks' => $validatedData['dutyRemarks'],
            'dutyLocation' => $validatedData['dutyLocation'],
        ]);

        $selectedBazaar = $request->input('bazaarName');

        return redirect()->route('duty.list');
    }

    public function list(Request $request)
    {
        $bazaars = Bazaar::all();
        $bazaarNames = Bazaar::pluck('bazaarName');
        $selectedBazaar = $request->input('bazaarFilter');

        $duties = Duty::query();

        // Filter by bazaar if the filter value is provided
        if ($selectedBazaar) {
            $duties->where('bazaarName', $selectedBazaar);
        }

        // Sort duties by bazaarName in ascending order
        $duties->orderBy('bazaarName');

        $duties = $duties->get();

        return view('duty.list', compact('duties', 'bazaarNames', 'selectedBazaar','bazaars'));
    }



    public function edit(Duty $duty)
    {
        // Retrieve all bazaar names for filtering
        $bazaarNames = Bazaar::pluck('bazaarName', 'id');

        return view('duty.edit', compact('duty', 'bazaarNames'));
    }

    public function update(Request $request, Duty $duty)
    {
        $validatedData = $request->validate([
            'dutyType' => 'required',
            'bazaarName' => 'required',
            'dutyRemarks' => 'nullable|string',
            'dutyLocation' => 'nullable|string',
        ]);

        $selectedBazaar = $request->input('bazaarName');

        // Create the duty name with the format "dutyType(bazaarName)"
        $dutyName = $request->input('dutyType') . '(' . $request->input('bazaarName') . ')';

        // Check if a duty with the same name already exists
        $existingDuty = Duty::where('dutyName', $dutyName)->first();

        if ($existingDuty && $existingDuty->id !== $duty->id) {
            return redirect()->back()->with('error', 'A duty with the same name already exists. Please choose a different name.')
                ->withInput($request->input());
        }

        // Update the dutyName field in the validated data
        $validatedData['dutyName'] = $dutyName;

        $duty->update($validatedData);

        return redirect()->route('duty.list');
    }

    public function destroy(Duty $duty)
    {
        $duty->delete();

        return redirect()->route('duty.list')->with('success', 'Duty deleted successfully.');
    }

}