<?php

namespace App\Http\Controllers;

use App\Models\Attachment_Feedback;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('user.feedback.index');
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
        $category = $request->input('category');
        $feedback = $request->input('message');
        $subject = $request->input('subject');
        $feedbackModel = new Feedback();
        $feedbackModel->category = $category;
        $feedbackModel->message = $feedback;
        $feedbackModel->subject = $subject;
        $feedbackModel->user_id = Auth::id();

        if (!$feedbackModel->save()) {
            return redirect()->back()->with('error', 'An error occurred while submitting feedback. Please try again.');
        }

        $filepondData = json_decode($request->input('filepond'), true);

        if ($filepondData) {
            foreach ($filepondData as $fileData) {
                $serverId = json_decode($fileData['serverId'], true);
                $path = $serverId['path'];
                $name = $fileData['name'];
                
                if (!Attachment_Feedback::create([
                    'name' => $name,
                    'path' => $path,
                    'feedback_id' => $feedbackModel->id
                ])) {
                    return redirect()->back()->with('error', 'An error occurred while uploading attachments. Please try again.');
                }
            }
        }

        return redirect()->route('user.feedback.index')->with('success', 'Feedback submitted successfully');
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
