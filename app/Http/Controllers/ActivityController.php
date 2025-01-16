<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    // KAFA Admin Methods
    public function kafaManageActivity()
    {
        $activities = Activity::all();
        return view('ManageKAFAActivities.kafaActivity', ['activities' => $activities]);
    }

    public function kafaViewActivity(Activity $activity)
    {
        return view('ManageKAFAActivities.kafaViewActivity', ['activity' => $activity]);
    }

    public function kafaAddActivity()
    {
        return view('ManageKAFAActivities.kafaAddActivity');
    }

    public function kafaEditActivity($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return redirect()->back()->with('error', 'Activity not found.');
        }

        return view('ManageKAFAActivities.kafaEditActivity', ['activity' => $activity]);
    }

    public function kafaStoreActivity(Request $request)
    {
        $request->validate([
            'activityName' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date|after_or_equal:dateStart',
            'timeStart' => 'required|date_format:H:i',
            'timeEnd' => 'required|date_format:H:i|after:timeStart',
            'attendees' => 'required|string|max:255',
            'organizerName' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $activity = new Activity($request->all());
        $activity->status = 'Request'; // Default status for new activities
        $activity->save();

        return redirect()->route('kafa.manageActivity')->with('success', 'Activity created successfully.');
    }

    public function kafaDeleteActivity($id)
    {
        $activity = Activity::find($id);

        if ($activity) {
            $activity->delete();
            return redirect()->route('kafa.manageActivity')->with('success', 'Activity deleted successfully.');
        } else {
            return redirect()->route('kafa.manageActivity')->with('error', 'Activity not found.');
        }
    }

    public function kafaUpdateActivity(Request $request, Activity $activity)
    {
        if (!$activity) {
            return redirect()->route('kafa.manageActivity')->with('error', 'Activity not found.');
        }

        $activity->update($request->all());

        return redirect()->route('kafa.manageActivity')->with('success', 'Activity updated successfully.');
    }

    // MUIP Methods
    public function muipManageActivity(Request $request)
    {
        $search = $request->input('search');
        $activities = Activity::when($search, function ($query, $search) {
            return $query->where('activityName', 'like', '%' . $search . '%');
        })->get();

        return view('ManageKAFAActivities.muipActivity', ['activities' => $activities]);
    }

    public function muipViewActivity(Activity $activity)
    {
        return view('ManageKAFAActivities.muipViewActivity', ['activity' => $activity]);
    }

    public function muipApproveActivity(Request $request)
    {
        $search = $request->input('search');
        $activities = Activity::where('activityName', 'like', '%' . $search . '%')->get();
        return view('ManageKAFAActivities.muipApprovalActivity', compact('activities'));
    }

        //new fucntion for activity
    public function approveActivity($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->status = 'Approved'; // Set status to Approved
        $activity->save();

        return redirect()->route('muip.approveActivity')->with('success', 'Activity approved successfully.');
    }

    public function rejectActivity($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->status = 'Rejected'; // Set status to Rejected
        $activity->save();

        return redirect()->route('muip.approveActivity')->with('success', 'Activity rejected successfully.');
    }

    // Guardian View
    public function guardianManageActivity(Request $request)
    {
        $search = $request->input('search');
        $activities = Activity::where('status', 'Approved') // Show only approved activities
            ->when($search, function ($query, $search) {
                return $query->where('activityName', 'like', '%' . $search . '%');
            })->get();

        return view('ManageKAFAActivities.ParentsActivity', ['activities' => $activities]);
    }

    public function guardianViewActivity(Activity $activity)
    {
        return view('ManageKAFAActivities.ParentsViewActivity', ['activity' => $activity]);
    }

    // Teacher View
    public function teacherManageActivity(Request $request)
    {
        $search = $request->input('search');
        $activities = Activity::where('status', 'Approved') // Show only approved activities
            ->when($search, function ($query, $search) {
                return $query->where('activityName', 'like', '%' . $search . '%');
            })->get();

        return view('ManageKAFAActivities.teacherActivity', ['activities' => $activities]);
    }

    public function teacherViewActivity(Activity $activity)
    {
        return view('ManageKAFAActivities.teacherViewActivity', ['activity' => $activity]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
