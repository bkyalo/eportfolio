<?php

namespace App\Http\Controllers;

use App\Models\FunFact;
use App\Models\SiteContactDetail;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function index()
    {
        $contact = SiteContactDetail::first();
        $funFacts = FunFact::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
        
        return view('about', [
            'contact' => $contact,
            'funFacts' => $funFacts
        ]);
    }
}
