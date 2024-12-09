<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //KAFAAdmin
    /**
     * Display a listing of the activity in kafa page.
     */
    public function kafaManageActivity()
    {
        // Retrieve all records from the activities table
        $activities = Activity::all();

        // Pass the data to the view
        return view('ManageKAFAActivities.kafaActivity', ['activities' => $activities]);
    }


 // ActivityController.php

    public function kafaViewActivity(Activity $activity) //Page for activity details
    {
        // Pass the activity details to the view
        return view('ManageKAFAActivities.kafaViewActivity', ['activity' => $activity]);
    }


    public function kafaAddActivity() //Page for adding new activity
    {
        //Render and return the view for adding a new KAFA activity.
        // This view will contain the form where users can input details for a new activity.
        return view('ManageKAFAActivities.kafaAddActivity');
    }

    public function kafaEditActivity($id) //Page for editing activity
    {
        // Retrieve the activity record based on the provided ID
        $activity = Activity::find($id);
    
        // Check if the activity record exists
        if (!$activity) {
            // Redirect back with an error message if the activity does not exist
            return redirect()->back()->with('error', 'Activity not found.');
        }
    
        // Pass the activity details to the view for editing
        return view('ManageKAFAActivities.kafaEditActivity', ['activity' => $activity]);
    }

    public function kafaStoreActivity(Request $request) //Store new activity
    {
        // Validate the incoming request data
        // $request->validate([
        //     'activityName' => 'required|string|max:255',
        //     'venue' => 'required|string|max:255',
        //     'dateStart' => 'required|date',
        //     'dateEnd' => 'required|date|after_or_equal:dateStart',
        //     'timeStart' => 'required|date_format:H:i',
        //     'timeEnd' => 'required|date_format:H:i|after:timeStart',
        //     'attendees' => 'required|string|max:255',
        //     'organizerName' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'kafa_id' => 'required|exists:kafas,id',
        // ]);

        // Create a new activity instance
        $activity = new Activity();
        $activity->activityName = $request->input('activityName');
        $activity->venue = $request->input('venue');
        $activity->dateStart = $request->input('dateStart');
        $activity->dateEnd = $request->input('dateEnd');
        $activity->timeStart = $request->input('timeStart');
        $activity->timeEnd = $request->input('timeEnd');
        $activity->attendees = $request->input('attendees');
        $activity->organizerName = $request->input('organizerName');
        $activity->description = $request->input('description');
        $activity->kafa_id = $request->input('kafa_id');
        $activity->status = 'Request'; // Assuming default status is Request

        // Save the activity to the database
        $activity->save();

        // Redirect back with a success message
        return redirect()->route('kafa.manageActivity')->with('success', 'Activity created successfully.');
    }


    public function kafaDeleteActivity($id) //Delete activity
    {
        // Retrieve the activity record based on the provided ID
        $activity = Activity::find($id);

        // Check if the activity record exists
        if ($activity) {
            // Delete the activity
            $activity->delete();

            // Redirect back or to a specific page after deletion
            return redirect()->route('kafa.manageActivity')->with('success', 'Activity deleted successfully.');
        } else {
            // Redirect back or display an error message if the activity does not exist
            return redirect()->route('kafa.manageActivity')->with('error', 'Activity not found.');
        }
    }

    public function kafaUpdateActivity(Request $request, Activity $activity) //Update activity
    {
    
        // Check if the activity record exists
        if (!$activity) {
            // Redirect back or display an error message if the activity does not exist
            return redirect()->route('kafa.manageActivity')->with('error', 'Activity not found.');
        }
    
        // Validate the incoming request data
        // $validatedData = $request->validate([
        //     'activityName' => 'required|string|max:255',
        //     'venue' => 'required|string|max:255',
        //     'dateStart' => 'required|date',
        //     'dateEnd' => 'required|date|after_or_equal:dateStart',
        //     'attendees' => 'required|string|max:255',
        //     'organizerName' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'feedback' => 'nullable|string',
        // ]);

        //Update the activity with the validated data
        $activity->update([ 
            'activityName' => $request->input('activityName'),
            'venue' => $request->input('venue'),
            'dateStart' => $request->input('dateStart'),
            'dateEnd' => $request->input('dateEnd'),
            'timeStart' => $request->input('timeStart'),
            'timeEnd' => $request->input('timeEnd'),
            'attendees' => $request->input('attendees'),
            'organizerName' => $request->input('organizerName'),
            'description' => $request->input('description'),
            'feedback' => $request->input('feedback'),
        ]);
    
    
        // Redirect back with a success message
        return redirect()->route('kafa.manageActivity')->with('success', 'Activity updated successfully.');
    }
 


    //MUIP
    /**
     * Display a listing of the activity in muip page.
     */
    public function muipManageActivity(Request $request)
    {
        $search = $request->input('search');
        $activities = Activity::when($search, function ($query, $search) {
            return $query->where('activityName', 'like', '%' . $search . '%');
        })->get();
    
        return view('ManageKAFAActivities.muipActivity', ['activities' => $activities]);
    }
    
    public function muipViewActivity(Activity $activity) //Page for activity details
    {
        return view('ManageKAFAActivities.muipViewActivity', ['activity' => $activity]);
    }
    
    public function muipApproveActivity(Request $request) //Page for approving activity
    {
        $search = $request->input('search');
        $activities = Activity::where('activityName', 'like', '%' . $search . '%')->get();
        return view('ManageKAFAActivities.muipApprovalActivity', compact('activities'));
    }

    
    public function approveActivity($id) //Approve activity
    {
        $activity = Activity::findOrFail($id); //Find the activity by ID
        $activity->status = 'approved'; //Change the status to approved
        $activity->save(); //Save the changes
    
        return redirect()->route('muip.approveActivity')->with('success', 'Activity approved successfully.'); //Redirect back with a success message
    }
    
    public function rejectActivity($id) //Reject activity
    {
        $activity = Activity::findOrFail($id); //Find the activity by ID
        $activity->status = 'rejected'; //Change the status to rejected
        $activity->save(); //Save the changes
    
        return redirect()->route('muip.approveActivity')->with('success', 'Activity rejected successfully.'); //Redirect back with a success message
    }
    


    //Guardian
    /**
     * Display a listing of the activity in guardian page.
     */
    public function guardianManageActivity(Request $request) //Page for view activity list
    {
        $search = $request->input('search'); //Retrieve the search term from the request

        // Retrieve records from the activities table, filtering by the search term if provided
        $activities = Activity::when($search, function ($query, $search) {
            return $query->where('activityName', 'like', '%' . $search . '%'); //Filter by activity name
        })->get(); //Get the filtered records

        // Pass the data to the view
        return view('ManageKAFAActivities.ParentsActivity', ['activities' => $activities]);
    }


    public function guardianViewActivity(Activity $activity) //Page for activity details
    {
        // Pass the activity details to the view
        return view('ManageKAFAActivities.ParentsViewActivity', ['activity' => $activity]);
    }



    //Teacher
     /**
     * Display a listing of the activity in teacher page.
     */
    public function teacherManageActivity(Request $request) //Page for list activity
    {
        $search = $request->input('search');

        // Retrieve records from the activities table, filtering by the search term if provided
        $activities = Activity::when($search, function ($query, $search) { //Filter by activity name
            return $query->where('activityName', 'like', '%' . $search . '%'); //Filter by activity name
        })->get(); //Get the filtered records

        // Pass the data to the view
        return view('ManageKAFAActivities.teacherActivity', ['activities' => $activities]);
    }


    public function teacherViewActivity(Activity $activity) //Page for activity details
    {
        // Pass the activity details to the view
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
