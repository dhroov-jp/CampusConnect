document.getElementById('sellForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const email = document.getElementById('email').value;
    const category = document.getElementById('category').value;
    const description = document.getElementById('description').value;
    const price = document.getElementById('price').value;
    const image = document.getElementById('image').files[0];

    // Compress and resize image using a canvas
    const reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = function() {
        const imageData = reader.result;
        
        // Create an off-screen canvas to resize the image
        const img = new Image();
        img.src = imageData;
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Set desired width and height for compression (e.g., 200px wide)
            const MAX_WIDTH = 200;
            const scaleSize = MAX_WIDTH / img.width;
            canvas.width = MAX_WIDTH;
            canvas.height = img.height * scaleSize;
            
            // Draw the image on the canvas with new dimensions
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            
            // Get compressed image data from canvas
            const compressedImage = canvas.toDataURL('image/jpeg', 0.7); // 70% quality

            // Save item details including the compressed image in localStorage
            saveItem(name, phone, email, category, description, price, compressedImage);
        };
    };
});

function saveItem(name, phone, email, category, description, price, image) {
    // Create object to save in localStorage
    const itemDetails = {
        name,
        phone,
        email,
        description,
        price,
        image
    };

    // Retrieve existing items from localStorage for the category
    const existingItems = JSON.parse(localStorage.getItem(category)) || [];

    // Add new item to existing items
    existingItems.push(itemDetails);

    try {
        // Save updated list back to localStorage
        localStorage.setItem(category, JSON.stringify(existingItems));

        // Redirect to category-specific page
        window.location.href = category + ".html";
    } catch (e) {
        if (e.code === DOMException.QUOTA_EXCEEDED_ERR) {
            alert("Storage limit exceeded! Try reducing the size of the images.");
        }
    }
}