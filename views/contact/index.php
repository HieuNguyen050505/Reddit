<div class="max-w-lg mx-auto my-10 bg-white p-8 rounded-xl shadow-lg dark:bg-gray-800">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-white">Contact Us</h1>
    <p class="text-gray-600 mb-6 text-center dark:text-gray-300">Fill out the form below to get in touch with admin</p>
    <form method="POST" class="space-y-5" novalidate>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-200">Name</label>
            <input type="text" name="name" id="name" class="w-full p-2.5 text-sm rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-200">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2.5 text-sm rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-200">Message</label>
            <textarea name="message" id="message" rows="4" class="w-full p-2.5 text-sm rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400" required><?php echo htmlspecialchars($message); ?></textarea>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-400">Send Message</button>
    </form>
</div>