@extends('layouts.home')

@section('title', 'Child')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <div class="py-20 px-20">

        <!-- Tabs Section -->
        @include('components.tabs')
        <!-- Tabs Section -->

        <div class="flex justify-between items-center mb-10 mt-10 cursor-pointer">
            <div class="flex space-x-5">
                <h1 id="tab1" class="tab cursor-pointer font-bold text-lg text-gray-300 border-b border-gray-300"
                    onclick="toggleTab('tab1')">Rescue a baby</h1>
                <p id="tab2" class="tab tab-active cursor-pointer font-bold text-lg  text-blue-900"
                    onclick="toggleTab('tab2')">Child</p>
                {{-- <p id="tab3" class="tab cursor-pointer font-bold text-lg text-gray-300 border-b border-gray-300"
                    onclick="toggleTab('tab3')">Mother</p> --}}
            </div>
        </div>




        <!-- child tab-->
        @include('components.childtab')
        <!-- child tab-->


           <div class="container  px-2 py-2 tab2text" id="cardsSection">
            <div class="grid grid-cols-5 gap-10  py-5">
                @if ($children->isEmpty())
                    <p>No Children found</p>
                @else
                    @foreach ($children as $child)
                        <div class="flex flex-col bg-white rounded-lg shadow-md py-2 px-4"
                            id="{{ $child->id }}">
                            <img class="w-full h-40 object-fit: cover rounded-md  mt-2"
                                src="{{ asset('images/banners/moses.jpg') }}" alt="{{ $child->first_name }}">
                            <h3 class="text-lg font-medium  mt-5  text-blue-900" >{{ $child->first_name }}

                                {{ $child->second_name }}</h3>
                            {{-- age --}}
                            @php
                                // Calculate age based on date of birth
                                $dob = new DateTime($child->date_of_birth);
                                $now = new DateTime();
                                $age = $now->diff($dob)->y;
                            @endphp
                            <p class="text-gray-600 ">{{ $age }} years</p>

                            {{-- add link showing story --}}
                            <a href="" class="text-blue-900  underline justify-center mb-0"
                                onclick=" showStory('{{ $child->story }}', '{{ $child->first_name }}')">{{ $child->first_name }}'s
                                story</a>

                            
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                <span class="close-button" onclick="Close()">&times;</span> 
                                    <div class="upper-section">
                                        <div class="details-section">
                                            <img src="{{ asset('images/swisnl/filament-backgrounds/curated-by-swis/moses.jpg') }}"
                                                alt="Placeholder Image">
                                            <div>
                                                <h3 id="name">Title Here</h3>

                                                <p>$35,000</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="story-content">
                                        <p id="storyContent">Story Content Here</p>
                                    </div>

                                    {{-- button sponsor centered --}}
                                    <a href="{{ route('child.show', $child->id) }}"
                                        class="w-30 h-10 inline-flex  items-center px-4 py-2 justify-center text-white font-bold shadow-md hover:bg-blue-700 bg-blue-900 rounded-full mt-5">
                                        Sponsor
                                    </a>

                            
                                </div>
                            </div>
                                {{-- description --}}
                                <p class="text-gray-600 text-center">{{ $child->description }}</p>
                                <a href="{{ route('child.show', $child->id) }}"
                                    class="w-1/2 h-10 inline-flex  items-center px-4 py-2 mb-5 justify-center text-white font-bold shadow-md hover:bg-blue-700 bg-blue-900  rounded-md mt-5">
                                    SPONSOR
                                </a>
                            </div>
                    @endforeach
                @endif
            </div>
            {{ $children->links() }}
        </div>




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

    /* Modal Styles */
 
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close-button {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-button:hover,
    .close-button:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }


        .modal {
            display: none;
     
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
            font-family: Arial, sans-serif;
            
         
        }
        .modal-content {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .upper-section {
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .details-section {
            display: flex;
            align-items: center;
        }
        .details-section img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .details-section h3 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }
        .details-section p {
            font-size: 18px;
            color: #666;
            margin: 5px 0;
        }
        .story-content {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }
      
</style>


<script>
    function showStory(story, name, id) {
        event.preventDefault();
        document.getElementById('storyContent').innerHTML = story;
        document.getElementById('name').innerHTML = name;
        document.getElementById('myModal').style.display = 'block';
        //save id
        document.getElementById('child_id').value = id;
    }

    function Close() {
        document.getElementById('myModal').style.display = 'none';
    }
</script>
