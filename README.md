# Product List Application

This is a PHP-based web application that displays a list of products. It allows users to filter products based on price, category, and sale status, and it supports pagination.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [File Structure](#file-structure)
- [Code Explanation](#code-explanation)
- [Contributing](#contributing)
- [License](#license)

## Features

- Display products in a card format with image, name, and price.
- Filter products based on price range, category, and sale status.
- Pagination support to navigate through products.
- Fixed sidebar for filter options and a responsive navigation bar.

## Requirements

- PHP 7.4 or higher
- MySQL or MariaDB database
- A web server like Apache or Nginx

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/your-username/product-list-app.git
   ```

2. **Navigate to the project directory:**

   ```bash
   cd product-list-app
   ```

3. **Set up the database:**

   - Create a MySQL database.
   - Import your SQL file to set up the `products` table.

4. **Configure database connection:**

   Update the database connection details in the `index.php` file:

   ```php
   $host = 'your-database-host';
   $dbname = 'your-database-name';
   $username = 'your-database-username';
   $password = 'your-database-password';
   ```

5. **Deploy the application:**

   - Copy the project files to your web server's document root (e.g., `/var/www/html` for Apache).

## Usage

1. Open your web browser and navigate to the URL where the application is hosted (e.g., `http://localhost/product-list-app`).

2. Use the sidebar to filter products based on price range, category, and sale status.

3. Navigate through pages using the pagination links at the bottom of the product list.

## File Structure

- `index.php`: The main PHP file that handles displaying products and filters.
- `products.sql`: SQL file to set up the `products` table in your database.

## Code Explanation

### HTML Structure

- **Sidebar:**
  The sidebar contains filter options for price range, category, and sale status. It uses a form with `GET` method to send filter parameters.

- **Navbar:**
  The navbar provides navigation links for different categories of products.

- **Container:**
  The container displays the list of products in a card format.

### PHP Logic

1. **Database Connection:**
   The script connects to the MySQL database using `mysqli`.

2. **Filter Handling:**
   The script processes filter parameters from the `GET` request and builds the SQL query accordingly.

3. **Pagination:**
   The script calculates the total number of pages based on the number of products and the limit per page.

4. **Product Display:**
   The script fetches products from the database and displays them in a card format with image, name, and price.

5. **Pagination Links:**
   The script generates pagination links at the bottom of the product list.

### CSS Styles

- Styles for the sidebar, navbar, container, cards, and pagination are defined in the `<style>` tag within the `head` section of the HTML.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any improvements or bug fixes.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.

---

Feel free to customize the README as per your project's specific requirements.