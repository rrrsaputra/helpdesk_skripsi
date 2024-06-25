<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $paginationCount = 10;
        $feedbacks = Feedback::orderBy('created_at', 'desc')->paginate($paginationCount);

        return view('admin.feedback.index', compact('feedbacks'));
    }
}
