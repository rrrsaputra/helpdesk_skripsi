<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $paginationCount = 10;
        $feedbacks = Feedback::orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                $query->where('category', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })
            ->paginate($paginationCount);

        return view('admin.feedback.index', compact('feedbacks'));
    }
}
