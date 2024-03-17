@extends('layouts.home')

@section('title', 'Welcome')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <div class="py-20 px-20">

        <!-- Tabs Section -->
        @include('components.tabs')
        <!-- Tabs Section -->


        <div class="flex space-x-5 mt-10">
            <h1 id="tab1" class="tab tab-active cursor-pointer font-bold text-lg text-blue-900"
                onclick="toggleTab('tab1')">Rescue a baby</h1>
            <p id="tab2" class="tab cursor-pointer font-bold text-lg text-gray-300 border-b border-gray-300"
                onclick="toggleTab('tab2')">Child</p>
            {{-- <p id="tab3" class="tab cursor-pointer font-bold text-lg text-gray-300 border-b border-gray-300"
                onclick="toggleTab('tab3')">Mother</p> --}}
        </div>



        <!-- Banner Section -->
        @include('components.babytab')
        <!-- Banner Section -->






        @include('components.sponsorship')

        <div class="container mx-auto px-4 py-8 items-center">
            <div class="flex flex-col items-center justify-center mt-8">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Sign up today and make a lasting impact in their lives.
                </h2>
                <div class="flex items-center mt-10">

                    <a href="{{ route('contact') }}"
                        class="inline-flex  items-center px-4 py-2 text-white font-bold shadow-md hover:bg-blue-700 bg-blue-900 text-white px-4 py-2 rounded-md my-5 ">
                        Join Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .tab {
        @apply bg-gray-500 text-white px-4 py-2 rounded-md cursor-pointer;
        border-bottom: 2px solid transparent;
    }

    .tab-active {
        @apply bg-gray-500 text-white px-4 py-2 rounded-md cursor-pointer;
        border-bottom: 2px solid blue;
    }

    .tab-text {
        @apply text-black;
    }
</style>
