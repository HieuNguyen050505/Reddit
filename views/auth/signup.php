<h1 class="flex items-center w-full justify-center dark:text-white text-2xl font-bold mt-14">
    Sign Up
</h1>
<form method="POST" class="max-w-sm mx-auto my-4">
    <div class="mb-5">
        <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-3xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4 dark:bg-[#2a3236] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-white dark:focus:border-white" placeholder="Username" required />
        <span class="text-red-500 text-sm" id="username-error"></span>
    </div>
    <div class="mb-5">
        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-3xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4 dark:bg-[#2a3236] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-white dark:focus:border-white" placeholder="Email" required />
        <span class="text-red-500 text-sm" id="email-error"></span>
    </div>
    <div class="mb-5">
        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-3xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4 dark:bg-[#2a3236] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-white dark:focus:border-white" placeholder="Password" required />
        <span class="text-red-500 text-sm" id="password-error"></span>
    </div>
    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-full text-sm px-4 py-2 md:px-5 md:py-3 dark:bg-[#d93900] dark:hover:bg-[#ae2c00]">Submit</button>
    <p class="dark:text-[#abc1ca] text-sm my-6">Already a redditor? <a href="/reddit/login" class="text-[#5b80e0]">Login</a></p>
</form>