<?php

namespace App\Http\Controllers;

use App\Models\FunFact;
use App\Models\SiteContactDetail;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function index()
    {
        $contact = SiteContactDetail::first();
        $funFacts = FunFact::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
            
        $skillCategories = SkillCategory::with(['skills' => function($query) {
            $query->where('is_active', true)
                  ->orderBy('order');
        }])->orderBy('order')->get();
        
        return view('about', [
            'contact' => $contact,
            'funFacts' => $funFacts,
            'skillCategories' => $skillCategories
        ]);
    }
}
