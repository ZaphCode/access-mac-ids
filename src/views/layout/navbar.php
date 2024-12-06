<nav class="flex justify-between py-1.5 items-center px-4 bg-black w-full">
    <!-- Logo alineado a la izquierda -->
    <div class="flex-shrink-0">
        <a href="/public/">
            <img src="/public/assets/logo.png" class="w-28 hidden sm:block sm:w-36 md:w-40" alt="logo">
            <img src="/public/assets/logo-sm.png" class="w-10 sm:hidden" alt="logo">
        </a>
    </div>

    <div class="flex-grow flex justify-center">
        <input type="text" placeholder="Search your products..." class="pl-4 pr-10 py-1 outline-none md:-ml-24 md:w-1/2 w-2/3 rounded-md">
        <button class="-ml-8 -mt-0.5">
            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>
        </button>
    </div>

    <div class="flex-shrink-0 pr-4 flex">
        <?php if (isUserLogged()) : ?>
            <a class="cursor-pointer" href="/account">
                <svg class="w-9 h-9 text-[#DDD183] transition-colors duration-300 hover:text-[#A38241]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd" />
                </svg>

            </a>
        <?php else :  ?>
            <a class="cursor-pointer" href="/account">
                <svg class="w-9 h-9 text-[#DDD183] transition-colors duration-300 hover:text-[#A38241]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="1.2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </a>
        <?php endif; ?>
        <a class="md:pl-1 cursor-pointer relative" href="/cart">
            <svg class="w-9 h-9 text-[#DDD183] transition-colors duration-300 hover:text-[#A38241]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
            </svg>
            <span id="cart-counter" class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
        </a>
    </div>
</nav>