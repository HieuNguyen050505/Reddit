document.addEventListener('DOMContentLoaded', function() {
    // Get references to DOM elements
    const fileInput = document.querySelector('input[name="avatar"]');
    const avatarImg = document.getElementById('avatar');
    
    // Add event listener to file input
    if (fileInput && avatarImg) {
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    fileInput.value = '';
                    return;
                }
                
                // Validate file size (5MB max)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    alert('File is too large. Maximum size is 5MB');
                    fileInput.value = '';
                    return;
                }
                
                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});