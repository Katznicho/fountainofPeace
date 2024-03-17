<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Mother;
use Illuminate\Http\Request;

class MotherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $cards = [
            [
                'title' => 'Feeding Program',
                'description' => 'Help provide nutritious meals to children in need.',
                'image' => 'feeding.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Medical Care',
                'description' => 'Support medical care and treatment for children.',
                'image' => 'medical.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            // Add more cards as needed
            [
                'title' => 'Education',
                'description' => 'Help provide access to education for children.',
                'image' => 'education.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Shelter',
                'description' => 'Support safe and secure housing for children.',
                'image' => 'shelter.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Clean Water',
                'description' => 'Help provide access to clean and safe drinking water.',
                'image' => 'water.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Disaster Relief',
                'description' => 'Support disaster relief efforts for children and families.',
                'image' => 'disaster.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Child Sponsorship',
                'description' => 'Sponsor a child and help provide access to education and more.',
                'image' => 'sponsorship.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Emergency Response',
                'description' => 'Support emergency response efforts for children and families.',
                'image' => 'emergency.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Nutrition',
                'description' => 'Help provide access to nutritious food and meals for children.',
                'image' => 'nutrition.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Child Protection',
                'description' => 'Support child protection and welfare programs for children.',
                'image' => 'protection.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
            [
                'title' => 'Healthcare',
                'description' => 'Help provide access to healthcare and medical services for children.',
                'image' => 'healthcare.jpg', // Image path
                'url' => '#', // Link URL
                'button_text' => 'Sponsor', // Button text
            ],
        ];

        $mothers = Mother::where('is_sponsored', false)->paginate(1);


        // $mothers = Mother::where('is_sponsored', false)->paginate(10);


        // Pass the data to the view
        return view('mother.mother', compact('cards', 'mothers'));

        // return view('child.child');
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
        //
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
