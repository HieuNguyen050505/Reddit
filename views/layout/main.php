<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet">
</head>
<body class="bg-white dark:bg-[#0e1113]">
    <nav class="fixed w-full py-1 z-40 bg-white dark:bg-[#0e1113] border-b-[1px] border-[#383b3c]">
        <div class="flex flex-wrap items-center justify-between mx-2 p-2">
            <a href="/reddit/post" class="flex items-center space-x-1 rtl:space-x-reverse">
                <?php include "public/icons/snoo-logo.svg"; ?>
                <?php include "public/icons/wordmark.svg"; ?>
            </a>
            <div class="flex items-center space-x-2">
                <a href="/reddit/post/create" class="flex items-center space-x-1 text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-full text-sm px-4 py-2.5 dark:bg-[#0e1113] dark:hover:bg-[#2a3236] dark:text-white">
                    <?php include "public/icons/add-icon.svg"; ?>
                    <span>Create</span>
                </a>
                <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <?php if (!$this->isLoggedIn()): ?>
                        <a href="/reddit/login" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-full text-sm px-4 py-2 md:px-3 md:py-2 dark:bg-[#d93900] dark:hover:bg-[#ae2c00]">Log In</a>
                    <?php else: ?>
                        <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-8 h-8 rounded-full cursor-pointer object-cover" src="<?php echo htmlspecialchars($_SESSION['avatar_path']); ?>" alt="User dropdown">
                        <div id="userDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-60 dark:bg-[#181c1f] dark:divide-gray-600 cursor-pointer">
                            <a href="/reddit/profile" class="flex items-center space-x-1 px-4 py-3 text-sm text-gray-900 dark:text-[#bcc4c9] dark:hover:text-white">
                                <img src="<?php echo htmlspecialchars($_SESSION['avatar_path']); ?>" class="w-8 h-8 rounded-full object-cover" alt="Rounded avatar">
                                <div>
                                    <div>View Profile</div>
                                    <div class="text-[11px]"><?php echo $_SESSION['username']; ?></div>
                                </div>
                            </a>
                            <a href="/reddit/logout" class="group px-4 py-4 flex items-center space-x-2 text-sm text-gray-900 dark:text-[#bcc4c9] dark:hover:text-white">
                                <?php include "public/icons/logout-icon.svg"; ?>
                                <div>Log out</div>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <div id="drawer-navigation" class="fixed top-0 left-0 h-screen p-4 overflow-y-auto bg-white w-64 dark:bg-[#0e1113] border-r-[1px] border-[#383b3c]">
        <div class="overflow-y-auto pt-14">
            <ul class="space-y-2 h-full pb-3 text-sm border-b-[1px] border-[#383b3c]">
                <li>
                    <a href="/reddit/post" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-[#2a3236] group">
                        <?php include "public/icons/home-icon.svg"; ?>
                        <span class="ms-3 text-[#abc1ca]">Home</span>
                    </a>
                    <?php if ($this->isAdmin()): ?>
                        <a href="/reddit/module" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-[#2a3236] group">
                            <?php include "public/icons/manage-modules-icon.svg"; ?>
                            <span class="ms-3 text-[#abc1ca]">Manage Modules</span>
                        </a>
                        <a href="/reddit/user" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-[#2a3236] group">
                            <?php include "public/icons/manage-users-icon.svg"; ?>
                            <span class="ms-3 text-[#abc1ca]">Manage Users</span>
                        </a>
                    <?php endif; ?>
                    <?php if ($this->isLoggedIn() && !$this->isAdmin()): ?>
                        <a href="/reddit/contact" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-[#2a3236] group">
                            <?php include "public/icons/contact-icon.svg"; ?>
                            <span class="ms-3 text-[#abc1ca]">Contact Us</span>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
            <ul class="text-sm mt-2">
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#2a3236]" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <span class="flex-1 text-left rtl:text-right whitespace-nowrap text-[#63747e] text-[13.5px] tracking-[1px]">TOPICS</span>
                        <?php include "public/icons/dropdown-arrow.svg"; ?>
                    </button>
                    <ul id="dropdown-example" class="py-2 space-y-2">
                        <?php if (!empty($_SESSION['modules'])): ?>
                            <?php foreach ($_SESSION['modules'] as $module): ?>
                                <li>
                                    <a href="/reddit/post/module/<?php echo $module['module_id']; ?>" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-[#abc1ca] dark:hover:bg-[#2a3236]">
                                        <?php echo htmlspecialchars($module['module_name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>
                                <span class="text-gray-500 pl-11">No modules available</span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <!-- Snackbar Component -->
    <div id="snackbar" class="fixed hidden bottom-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 z-50 transition-all duration-300 ease-in-out" role="alert">
        <div id="snackbar-icon" class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-lg"></div>
        <div id="snackbar-message" class="ml-3 flex-grow text-sm font-medium break-words"></div>
        <button type="button" id="snackbar-close" class="ml-2 flex-shrink-0 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
            <span class="sr-only">Close</span>
            <?php include "public/icons/snackbar-close.svg"; ?>
        </button>
    </div>

    <main class="ps-[17rem] pt-[3.5rem] me-4"><?php echo $content; ?></main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        function showSnackbar(message, type) {
            const snackbar = document.getElementById('snackbar');
            const messageElement = document.getElementById('snackbar-message');
            const iconElement = document.getElementById('snackbar-icon');
            const closeButton = document.getElementById('snackbar-close');

            messageElement.textContent = message;

            if (type === 'success') {
                iconElement.innerHTML = `<?php include "public/icons/snackbar-success.svg"; ?>`;
                iconElement.className = 'flex-shrink-0 inline-flex items-center justify-center w-10 h-10 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200';
                snackbar.className = snackbar.className.replace(/bg-.*?(?:\s|$)/g, '') + ' bg-white dark:bg-gray-800 border-l-4 border-green-500';
            } else if (type === 'error') {
                iconElement.innerHTML = `<?php include "public/icons/snackbar-error.svg"; ?>`;
                iconElement.className = 'flex-shrink-0 inline-flex items-center justify-center w-10 h-10 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200';
                snackbar.className = snackbar.className.replace(/bg-.*?(?:\s|$)/g, '') + ' bg-white dark:bg-gray-800 border-l-4 border-red-500';
            } else if (type === 'warning') {
                iconElement.innerHTML = `<?php include "public/icons/snackbar-warning.svg"; ?>`;
                iconElement.className = 'flex-shrink-0 inline-flex items-center justify-center w-10 h-10 text-yellow-500 bg-yellow-100 rounded-lg dark:bg-yellow-800 dark:text-yellow-200';
                snackbar.className = snackbar.className.replace(/bg-.*?(?:\s|$)/g, '') + ' bg-white dark:bg-gray-800 border-l-4 border-yellow-500';
            } else if (type === 'info') {
                iconElement.innerHTML = `<?php include "public/icons/snackbar-info.svg"; ?>`;
                iconElement.className = 'flex-shrink-0 inline-flex items-center justify-center w-10 h-10 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200';
                snackbar.className = snackbar.className.replace(/bg-.*?(?:\s|$)/g, '') + ' bg-white dark:bg-gray-800 border-l-4 border-blue-500';
            }

            snackbar.classList.remove('hidden');
            snackbar.classList.add('flex');
            snackbar.classList.add('opacity-0');
            setTimeout(() => {
                snackbar.classList.remove('opacity-0');
                snackbar.classList.add('opacity-100');
            }, 10);

            closeButton.onclick = () => hideSnackbar();

            const timeoutId = setTimeout(() => hideSnackbar(), 4000);
            snackbar.dataset.timeoutId = timeoutId;

            function hideSnackbar() {
                snackbar.classList.remove('opacity-100');
                snackbar.classList.add('opacity-0');
                setTimeout(() => {
                    snackbar.classList.add('hidden');
                    snackbar.classList.remove('flex', 'opacity-0');
                }, 300);
                
                if (snackbar.dataset.timeoutId) {
                    clearTimeout(parseInt(snackbar.dataset.timeoutId));
                    delete snackbar.dataset.timeoutId;
                }
            }
        }

        <?php if (isset($_SESSION['snackbar_message']) && isset($_SESSION['snackbar_type'])): ?>
            document.addEventListener("DOMContentLoaded", () => {
                showSnackbar("<?php echo addslashes($_SESSION['snackbar_message']); ?>", "<?php echo $_SESSION['snackbar_type']; ?>");
            });
            <?php unset($_SESSION['snackbar_message'], $_SESSION['snackbar_type']); ?>
        <?php endif; ?>
    </script>
</body>
</html>