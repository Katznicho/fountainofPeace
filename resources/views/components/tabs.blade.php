{{-- <div class="flex justify-between items-center mb-10 mt-10 cursor-pointer">
    <div class="flex space-x-5">
        <h1 id="tab1" class="tab tab-active cursor-pointer font-bold text-lg text-blue-900" onclick="toggleTab('tab1')">Rescue a baby</h1>
        <p id="tab2" class="tab cursor-pointer font-bold text-lg text-gray-300 border-b border-gray-300" onclick="toggleTab('tab2')">Child</p>
        <p id="tab3" class="tab cursor-pointer font-bold text-lg text-gray-300 border-b border-gray-300" onclick="toggleTab('tab3')">Mother</p>
    </div>
</div> --}}

<script>
function toggleTab(tabId) {
 

    //route to child tab
    if (tabId === 'tab2') {
       
        window.location.href = "{{ route('child.index') }}";
        //,ake
    }

    else if (tabId === 'tab3') {
        window.location.href = "{{ route('mother.index') }}";
    }

    else {
        window.location.href = "{{ route('home') }}";
    }

    


}
</script>



