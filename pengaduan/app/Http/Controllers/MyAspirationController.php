<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;

class MyAspirationController extends Controller
{
    public function index()
    {
        $myTokens = session()->get('my_aspiration_tokens', []);

        if (empty($myTokens)) {
            $aspirations = collect([]);
        } else {
            $aspirations = Aspiration::with('category')
                ->whereIn('owner_token', $myTokens)
                ->latest()
                ->paginate(10);
        }

        return view('aspiration.my', compact('aspirations'));
    }
}
