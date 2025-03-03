<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function createJob(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'budget' => 'required|numeric',
            'category' => 'required'
        ]);

        $job = Job::create([
            'client_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'category' => $request->category
        ]);

        return response()->json(['message' => 'Job posted successfully', 'job' => $job]);
    }

    public function getJobs()
    {
        return Job::all();
    }
}

