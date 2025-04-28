<div class="my-7 w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">User List</h2>
        <?php if ($this->isAdmin()): ?>
            <button data-modal-target="add-user-modal" data-modal-toggle="add-user-modal" 
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 flex items-center">
                <img src="public/icons/add-icon.svg" alt="Add User" class="w-4 h-4 mr-2">
                Add User
            </button>
        <?php endif; ?>
    </div>

    <?php if ($this->isAdmin()): ?>
        <div id="add-user-modal" tabindex="-1" aria-hidden="true" 
             class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New User</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-user-modal">
                            <img src="public/icons/close-icon.svg" alt="Close" class="w-3 h-3">
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form method="POST" action="/reddit/user/add" class="p-6 space-y-4">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                            <input type="text" name="username" id="username" required 
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <span class="text-red-500 dark:text-red-400 text-sm mt-1" id="username-error"></span>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" required 
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <span class="text-red-500 dark:text-red-400 text-sm mt-1" id="email-error"></span>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input type="password" name="password" id="password" required 
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <span class="text-red-500 dark:text-red-400 text-sm mt-1" id="password-error"></span>
                        </div>
                        <button type="submit" name="add_user" 
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            Add User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Username</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Admin</th>
                    <?php if ($this->isAdmin()): ?>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td colspan="<?php echo $this->isAdmin() ? '4' : '3'; ?>" class="px-6 py-4 text-center">No users found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <span class="username-<?php echo $user['user_id']; ?>">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </span>
                                <?php if ($this->isAdmin() && $user['user_id'] != $_SESSION['user_id']): ?>
                                    <form action="/reddit/user/edit/username/<?php echo $user['user_id']; ?>" method="POST" class="hidden edit-username-form-<?php echo $user['user_id']; ?> mt-2">
                                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" 
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <div class="mt-2 flex gap-2">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-1">Save</button>
                                            <button type="button" onclick="toggleEditUsernameForm(<?php echo $user['user_id']; ?>)" 
                                                    class="text-gray-500 hover:text-white font-medium rounded-lg text-sm px-3 py-1">Cancel</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="email-<?php echo $user['user_id']; ?>">
                                    <?php echo htmlspecialchars($user['email']); ?>
                                </span>
                                <?php if ($this->isAdmin() && $user['user_id'] != $_SESSION['user_id']): ?>
                                    <form action="/reddit/user/edit/email/<?php echo $user['user_id']; ?>" method="POST" class="hidden edit-email-form-<?php echo $user['user_id']; ?> mt-2">
                                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <div class="mt-2 flex gap-2">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-1">Save</button>
                                            <button type="button" onclick="toggleEditEmailForm(<?php echo $user['user_id']; ?>)" 
                                                    class="text-gray-500 hover:text-white font-medium rounded-lg text-sm px-3 py-1">Cancel</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4"><?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></td>
                            <?php if ($this->isAdmin() && $user['user_id'] != $_SESSION['user_id']): ?>
                                <td class="pl-6 py-4">
                                    <div class="flex gap-4 flex-wrap">
                                        <button onclick="toggleEditUsernameForm(<?php echo $user['user_id']; ?>)" 
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:text-blue-500 dark:hover:text-blue-400 inline-flex items-center">
                                            <img src="public/icons/edit-icon.svg" alt="Edit Username" class="w-4 h-4 mr-1">
                                            Edit Username
                                        </button>
                                        <button onclick="toggleEditEmailForm(<?php echo $user['user_id']; ?>)" 
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:text-blue-500 dark:hover:text-blue-400 inline-flex items-center">
                                            <img src="public/icons/edit-icon.svg" alt="Edit Email" class="w-4 h-4 mr-1">
                                            Edit Email
                                        </button>
                                        <a href="/reddit/user/delete/<?php echo $user['user_id']; ?>" 
                                           class="font-medium text-red-600 dark:text-red-500 hover:text-red-500 dark:hover:text-red-400 inline-flex items-center"
                                           onclick="return confirm('Are you sure you want to delete this user?')">
                                            <img src="public/icons/delete-icon.svg" alt="Delete" class="w-4 h-4 mr-1">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            <?php elseif ($this->isAdmin()): ?>
                                <td class="pl-6 py-4">N/A</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="/reddit/public/js/user-management.js"></script>
