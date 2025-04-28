<!-- Snackbar Component -->
<div id="snackbar" class="fixed hidden bottom-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 z-50 transition-all duration-300 ease-in-out" role="alert">
    <div id="snackbar-icon" class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-lg"></div>
    <div id="snackbar-message" class="ml-3 flex-grow text-sm font-medium break-words"></div>
    <button type="button" id="snackbar-close" class="ml-2 flex-shrink-0 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
        <span class="sr-only">Close</span>
        <?php include "public/icons/snackbar-close.svg"; ?>
    </button>
</div>

<!-- Hidden SVG templates for snackbar icons -->
<div class="hidden">
    <div id="snackbar-success-icon"><?php include "public/icons/snackbar-success.svg"; ?></div>
    <div id="snackbar-error-icon"><?php include "public/icons/snackbar-error.svg"; ?></div>
    <div id="snackbar-warning-icon"><?php include "public/icons/snackbar-warning.svg"; ?></div>
    <div id="snackbar-info-icon"><?php include "public/icons/snackbar-info.svg"; ?></div>
</div>

<?php if (isset($_SESSION['snackbar_message']) && isset($_SESSION['snackbar_type'])): ?>
    <input type="hidden" id="initial-snackbar-message" value="<?php echo htmlspecialchars($_SESSION['snackbar_message']); ?>">
    <input type="hidden" id="initial-snackbar-type" value="<?php echo htmlspecialchars($_SESSION['snackbar_type']); ?>">
    <?php unset($_SESSION['snackbar_message'], $_SESSION['snackbar_type']); ?>
<?php endif; ?>