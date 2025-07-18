<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Fetch skills for dropdown from Selection model
        $skills = \App\Models\Selection::where('table', 'Skills')
            ->where('field', 'Un-skill')
            ->orderBy('name')
            ->pluck('name', 'code')
            ->toArray();

        // Fetch Austrian regions for dropdown
        $austrianRegions = \App\Models\Region::orderBy('name')->pluck('name', 'id')->toArray();

        // Initialize variables
        $users = [];
        $selectedSkill = $request->input('skills');
        $selectedCountry = $request->input('country');
        $selectedRegionId = $request->input('region_id');
        $hasProfilePicture = $request->input('profile_picture');
        $description = $request->input('description');

        // Validate that country is selected before proceeding with search
        if (!$selectedCountry && ($selectedSkill || $selectedRegionId || $description || $hasProfilePicture)) {
            return view('home', compact('skills', 'users', 'selectedSkill', 'selectedCountry',
                'austrianRegions', 'hasProfilePicture', 'description'))
                ->withErrors(['country' => 'Please select a country to perform a search.']);
        }

        // Build query to fetch users if country is selected
        if ($selectedCountry) {
            $query = User::with(['person', 'skills'])->where('active', 1);

            // Filter by skill
            if ($selectedSkill) {
                $query->whereHas('skills', function ($q) use ($selectedSkill) {
                    $q->where('skill_name', $selectedSkill);
                });
            }

            // Filter by country
            $query->whereHas('person', function ($q) use ($selectedCountry) {
                $q->where('country', $selectedCountry);
            });

            // Filter by region_id only if provided and country is Austria
            if ($selectedRegionId && $selectedCountry === 'AT') {
                $query->whereHas('person', function ($q) use ($selectedRegionId) {
                    $q->where('region', $selectedRegionId);
                });
            }

            // Filter by profile picture
            if ($hasProfilePicture) {
                $query->whereHas('person', function ($q) {
                    $q->whereNotNull('profile_picture');
                });
            }

            // Filter by description in skills table
            if ($description) {
                $query->whereHas('skills', function ($q) use ($description) {
                    $q->where('description', 'LIKE', '%' . $description . '%');
                });
            }

            // Fetch users
            $users = $query->get();
        }

        return view('home', compact('skills', 'users', 'selectedSkill', 'selectedCountry',
            'austrianRegions', 'hasProfilePicture', 'description'));
    }
}
