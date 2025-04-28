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
    <?php include "views/components/snackbar.php"; ?>

    <main class="ps-[17rem] pt-[3.5rem] me-4"><?php echo $content; ?></main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="/reddit/public/js/snackbar.js"></script>
</body>
</html>