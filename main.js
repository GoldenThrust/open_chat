function previewImage(event) {
    const imagePreviewContainer = document.getElementById('imagePreview');
    const imagePreviewImage = imagePreviewContainer.querySelector('.image-preview__image');
    const imagePreviewDefaultText = imagePreviewContainer.querySelector('.image-preview__default-text');
    
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            imagePreviewDefaultText.style.display = "none";
            imagePreviewImage.style.display = "block";
            imagePreviewImage.setAttribute('src', e.target.result);
        }
        
        reader.readAsDataURL(file);
    } else {
        imagePreviewDefaultText.style.display = null;
        imagePreviewImage.style.display = null;
        imagePreviewImage.setAttribute('src', '');
    }
}

document.getElementById('signup-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const errorMessage = document.getElementById('error-message');
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const image = document.getElementById('image').files[0];

    if (!username || !password || !image) {
        errorMessage.textContent = 'All fields are required!';
        errorMessage.style.display = 'block';
    } else {
        // Clear error message
        errorMessage.style.display = 'none';
        errorMessage.textContent = '';

        // Submit the form (you can customize this part as needed)
        this.submit();
    }
});
