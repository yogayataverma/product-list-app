function fetchProducts(page = 1) {
    const url = new URL('fetch_products.php', window.location.href);
    url.searchParams.append('page', page);

    const formElements = document.forms['filters'].elements;
    url.searchParams.append('min_price', formElements['min_price'].value);
    url.searchParams.append('max_price', formElements['max_price'].value);
    url.searchParams.append('category', formElements['category'].value);
    url.searchParams.append('sale_status', formElements['sale_status'].value);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            displayProducts(data.data);
            setupPagination(data.totalPages, data.currentPage);
        })
        .catch(error => console.error('Error fetching data:', error));
}

function displayProducts(products) {
    const container = document.getElementById('products');
    container.innerHTML = ''; // Clear previous contents
    products.forEach(product => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <img class="product-image" src="data:image/jpeg;base64,${product.image}" alt="${product.name}">
            <div class="product-info">
                <div class="product-name">${product.name}</div>
                <div class="product-price">$${product.price}</div>
            </div>
        `;
        container.appendChild(card);
    });
}

function setupPagination(totalPages, currentPage) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = ''; // Clear previous pagination
    for (let i = 1; i <= totalPages; i++) {
        const pageLink = document.createElement('a');
        pageLink.href = `#`;
        pageLink.innerText = i;
        pageLink.addEventListener('click', function(e) {
            e.preventDefault();
            fetchProducts(i); // Fetch products for the selected page
        });
        if (i === currentPage) {
            pageLink.classList.add('active');
        }
        pagination.appendChild(pageLink);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    fetchProducts();
    document.getElementById('filters').addEventListener('submit', function(e) {
        e.preventDefault();
        fetchProducts();
    });
});
