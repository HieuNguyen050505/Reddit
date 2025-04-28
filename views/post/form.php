<form method="POST" enctype="multipart/form-data" class="space-y-4 max-w-5xl mx-auto p-6 rounded-lg shadow mt-2">
    <h1 class="flex dark:text-[#b3c0bf] text-2xl font-bold"><?php echo isset($post) ? 'Edit post' : 'Create post'; ?></h1>
    <div>
        <select name="module_id" required class="font-medium bg-gray-50 text-gray-900 text-sm rounded-3xl block py-2.5 pr-7 pl-3 dark:bg-[#2a3236] dark:placeholder-gray-400 dark:text-white">
            <?php if (!isset($post)): ?>
                <option selected class="hidden">Select a module</option>
            <?php endif; ?>
            <?php foreach ($modules as $module): ?>
                <option value="<?php echo $module['module_id']; ?>" <?php echo (isset($post) && $module['module_id'] == $post['module_id']) ? 'selected' : ''; ?> class="font-medium">
                    <?php echo htmlspecialchars($module['module_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <input type="text" name="title" placeholder="Title" value="<?php echo isset($post) ? htmlspecialchars($post['title']) : ''; ?>" required class="block w-full p-4 text-gray-900 border border-gray-300 rounded-3xl bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-[#0e1113] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-white" id="title">
        <?php if (isset($post)): ?>
            <span class="text-red-500 text-sm" id="title-error"></span>
        <?php endif; ?>
    </div>
    <div>
        <div class="w-full mb-4 border border-gray-200 rounded-3xl bg-gray-50 dark:bg-[#0e1113] dark:border-gray-600">
            <div class="flex items-center justify-between px-3 py-2">
                <div class="flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
                    <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                        <button type="button" id="upload-image-btn" class="p-2 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                            <?php include "public/icons/upload-image.svg"; ?>
                            <span class="sr-only">Upload image</span>
                        </button>
                        <input type="file" id="image-input" name="image" accept="image/*" class="hidden">
                    </div>
                </div>
            </div>
            <div class="px-4 py-2 bg-white rounded-b-3xl dark:bg-[#0e1113]">
                <textarea name="content" required rows="5" class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-[#0e1113] focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Body" id="content"><?php echo isset($post) ? htmlspecialchars($post['content']) : ''; ?></textarea>
                <?php if (isset($post)): ?>
                    <span class="text-red-500 text-sm" id="content-error"></span>
                <?php endif; ?>
                <?php if (isset($post) && $post['image_path']): ?>
                    <div id="image-preview" class="mt-2">
                        <img src="<?php echo htmlspecialchars($post['image_path']); ?>" id="preview-img" class="max-w-full h-auto rounded-lg" alt="Image preview">
                    </div>
                <?php else: ?>
                    <div id="image-preview" class="mt-2 hidden">
                        <img id="preview-img" class="max-w-full h-auto rounded-lg" alt="Image preview">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="flex justify-end w-full">
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-3xl text-sm px-4 py-2 md:px-4 md:py-3 dark:bg-[#115bca] dark:hover:bg-[#ae2c00]">
            <?php echo isset($post) ? 'Update' : 'Post'; ?>
        </button>
    </div>
</form>

<script src="/reddit/public/js/post-form.js"></script>