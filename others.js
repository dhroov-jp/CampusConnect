document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-input');
    const products = document.querySelectorAll('.product');

    // Event listener for search input
    searchInput.addEventListener('input', function () {
        const searchText = searchInput.value.toLowerCase();

        // Loop through all products
        products.forEach(function (product) {
            const title = product.querySelector('h2').textContent.toLowerCase();

            // If the product title matches the search text, display it; otherwise, hide it
            if (title.includes(searchText)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    });
});