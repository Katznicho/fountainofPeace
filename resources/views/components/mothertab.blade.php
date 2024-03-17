<div class="bg-white-200 py-4 px-6 flex mb-20 items-center justify-between tab-text " id="tab3Text">
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
        <div class="flex-1 mr-4 ">
            <h1 class="text-7xl font-bold text-black mb-4">Sponsor a mother.</h1>
            <h1 class="text-7xl font-bold text-black mb-4">Raise a leader.</h1>
            <p class="text-lg text-gray-600 mt-1 mb-10">
                We provide orphaned and abandoned children with a loving Christian home
                where they receive all the love, care, protection and practical support they need to thrive.

            </p>
            <p class="text-lg text-gray-600 mt-10 ">
                With $38, we are able to rescue a child from wherever they are abandoned,
                feed them, provide shelter and for some in extreme health conditions, place them under intense medical
                program.
            </p>
            <!-- Sponsor Button -->
             <div class="mt-10">
                          <a class="bg-blue-900 text-white px-4 py-2 rounded-md my-5 " href="{{ route('contact') }}">Sponsor</a>
             </div>
        </div>
        <div class="flex-1 flex">
            <!-- Image with object-cover to cover the same height as text -->
            <img src="{{ asset('images/banners/child.jpg') }}" alt="Banner Image" class="h-1/4 w-full object-cover">
        </div>

    </div>
</div>
