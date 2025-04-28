document.addEventListener('DOMContentLoaded', function() {
    // Toggle username edit form
    window.toggleEditUsernameForm = function(userId) {
        const form = document.querySelector(`.edit-username-form-${userId}`);
        const name = document.querySelector(`.username-${userId}`);
        
        if (form && name) {
            form.classList.toggle('hidden');
            name.classList.toggle('hidden');
        }
    };
    
    // Toggle email edit form
    window.toggleEditEmailForm = function(userId) {
        const form = document.querySelector(`.edit-email-form-${userId}`);
        const email = document.querySelector(`.email-${userId}`);
        
        if (form && email) {
            form.classList.toggle('hidden');
            email.classList.toggle('hidden');
        }
    };
    
    // Initialize modal functionality if using a library like Flowbite
    // This is assuming you're using Flowbite for modals based on the data attributes
    if (typeof initModals === 'function') {
        initModals();
    }
});