<nav class="bg-blue-900 text-white p-4 md:p-6 fixed w-full z-10" id="header">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <img src="https://fountainofpeace.org.ug/wp-content/uploads/2023/08/resized-strch-fop-logo.png" alt="Logo" class="h-8 w-auto mr-2">
            <span class="text-xl font-bold hidden md:inline"></span>
        </div>
        <div class="flex items-center space-x-4 md:space-x-6">
            <button id="menu-toggle" class="md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div id="mobile-menu" class="hidden md:flex items-center space-x-4">
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
                <a href="{{route('register')}}" class="hover:underline">Register</a>
            </div>
        </div>
    </div>
    <!-- Dropdown menu -->
    <div id="dropdown-menu" class="md:hidden mt-2 hidden">
         <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
                <a href="{{route('register')}}" class="hover:underline">Register</a>
    </div>
</nav>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const dropdownMenu = document.getElementById('dropdown-menu');
    const desktopMenu = document.querySelector('.hidden.md\\:flex');

    menuToggle.addEventListener('click', () => {
        if (mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.remove('hidden');
            dropdownMenu.classList.remove('hidden');
            desktopMenu.classList.add('hidden');
        } else {
            mobileMenu.classList.add('hidden');
            dropdownMenu.classList.add('hidden');
            desktopMenu.classList.remove('hidden');
        }
    });
</script>