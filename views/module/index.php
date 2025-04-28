<div class="my-7 w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Module List</h2>
        <?php if ($this->isAdmin()): ?>
            <button data-modal-target="add-module-modal" data-modal-toggle="add-module-modal" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 flex items-center">
                <img src="public/icons/add-icon.svg" alt="Add Module" class="w-4 h-4 mr-2">
                Add Module
            </button>
        <?php endif; ?>
    </div>
    <?php if ($this->isAdmin()): ?>
        <div id="add-module-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Module</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-module-modal">
                            <img src="public/icons/close-icon.svg" alt="Close" class="w-3 h-3">
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form method="POST" action="/reddit/module/add" class="p-6 space-y-4">
                        <div>
                            <label for="module_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Module Name</label>
                            <input type="text" name="module_name" id="module_name" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">Add Module</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Module Name</th>
                    <?php if ($this->isAdmin()): ?>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($modules)): ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td colspan="<?php echo $this->isAdmin() ? '2' : '1'; ?>" class="px-6 py-4 text-center">No modules found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($modules as $module): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <span class="module-name-<?php echo $module['module_id']; ?>">
                                    <?php echo htmlspecialchars($module['module_name']); ?>
                                </span>
                                <?php if ($this->isAdmin()): ?>
                                    <form action="/reddit/module/edit/<?php echo $module['module_id']; ?>" method="POST" class="hidden edit-form-<?php echo $module['module_id']; ?> mt-2">
                                        <input type="text" name="module_name" value="<?php echo htmlspecialchars($module['module_name']); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <div class="mt-2 flex gap-2">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-1">Save</button>
                                            <button type="button" onclick="toggleEditForm(<?php echo $module['module_id']; ?>)" class="text-gray-500 hover:text-white font-medium rounded-lg text-sm px-3 py-1">Cancel</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <?php if ($this->isAdmin()): ?>
                                <td class="pl-6 py-4">
                                    <div class="flex gap-4">
                                        <button onclick="toggleEditForm(<?php echo $module['module_id']; ?>)" class="font-medium text-blue-600 dark:text-blue-500 hover:text-blue-500 dark:hover:text-blue-400 inline-flex items-center">
                                            <img src="public/icons/edit-icon.svg" alt="Edit" class="w-4 h-4 mr-1">
                                            Edit
                                        </button>
                                        <a href="/reddit/module/delete/<?php echo $module['module_id']; ?>" class="font-medium text-red-600 dark:text-red-500 hover:text-red-500 dark:hover:text-red-400 inline-flex items-center" onclick="return confirm('Are you sure you want to delete this module?')">
                                            <img src="public/icons/delete-icon.svg" alt="Delete" class="w-4 h-4 mr-1">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleEditForm(moduleId) {
    const form = document.querySelector(`.edit-form-${moduleId}`);
    const name = document.querySelector(`.module-name-${moduleId}`);
    form.classList.toggle('hidden');
    name.classList.toggle('hidden');
}
</script>