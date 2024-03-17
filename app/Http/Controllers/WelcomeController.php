<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Mother;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    //
    public function index()
    {


        // Define static data here needs to be replaced with data from db


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

        $children = Children::where('is_sponsored', false)->paginate(10);


        $mothers = Mother::where('is_sponsored', false)->paginate(10);


        // Pass the data to the view
        return view('welcome', compact('cards', 'children', 'mothers'));
    }
}
