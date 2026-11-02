<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;

class MyAspirationController extends Controller
{
    public function index(Request $request)
    {
        $aspirations = Aspiration::authoredBy($request->user())
            ->with('category')
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        return view('aspiration.my', compact('aspirations'));
    }
}
