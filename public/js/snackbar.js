function showSnackbar(message, type) {
    const snackbar = document.getElementById('snackbar');
    const messageElement = document.getElementById('snackbar-message');
    const iconElement = document.getElementById('snackbar-icon');
    const closeButton = document.getElementById('snackbar-close');

    messageElement.textContent = message;

    if (type === 'success') {
        iconElement.innerHTML = document.getElementById('snackbar-success-icon').innerHTML;
        iconElement.className = 'flex-shrink-0 inline-flex items-center justify-center w-10 h-10 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200';
        snackbar.className = snackbar.className.replace(/bg-.*?(?:\s|$)/g, '') + ' bg-white dark:bg-gray-800 border-l-4 border-green-500';
    } else if (type === 'error') {
        iconElement.innerHTML = document.getElementById('snackbar-error-icon').innerHTML;
        iconElement.className = 'flex-shrink-0 inline-flex items-center justify-center w-10 h-10 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200';
        snackbar.className = snackbar.className.replace(/bg-.*?(?:\s|$)/g, '') + ' bg-white dark:bg-gray-800 border-l-4 border-red-500';
    } else if (type === 'warning') {
        iconElement.innerHTML = document.getElementById('snackbar-warning-icon').innerHTML;
        iconElement.className = 'flex-shrink-0 inline-flex items-center justify-center w-10 h-10 text-yellow-500 bg-yellow-100 rounded-lg dark:bg-yellow-800 dark:text-yellow-200';
        snackbar.className = snackbar.className.replace(/bg-.*?(?:\s|$)/g, '') + ' bg-white dark:bg-gray-800 border-l-4 border-yellow-500';
    } else if (type === 'info') {
        iconElement.innerHTML = document.getElementById('snackbar-info-icon').innerHTML;
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

// Initialize snackbar if there's a message in session
document.addEventListener("DOMContentLoaded", () => {
    const snackbarMessage = document.getElementById('initial-snackbar-message');
    const snackbarType = document.getElementById('initial-snackbar-type');
    
    if (snackbarMessage && snackbarType) {
        showSnackbar(snackbarMessage.value, snackbarType.value);
    }
});