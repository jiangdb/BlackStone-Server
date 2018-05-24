<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    //
    public function share(Request $request, $id)
    {
        $work = Work::findOrFail($id);

        return view('share', compact('work'));
    }
}
