document.addEventListener('DOMContentLoaded', function() {
    // Make the toggleEditForm function globally available
    window.toggleEditForm = function(moduleId) {
        const form = document.querySelector(`.edit-form-${moduleId}`);
        const name = document.querySelector(`.module-name-${moduleId}`);
        
        if (form && name) {
            form.classList.toggle('hidden');
            name.classList.toggle('hidden');
        }
    };
    
    if (typeof initModals === 'function') {
        initModals();
    }
});