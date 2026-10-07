# PHP Challenge

A simple PHP web application for managing and displaying a list of products using an XML file as the data source.

The project demonstrates core PHP concepts such as object-oriented programming, form handling, XML parsing and manipulation, server-side validation, HTML generation, and the Post/Redirect/Get pattern.

## Features

- Display products stored in an XML file in an HTML table.
- Add new products through a web form.
- Validate required product fields.
- Read and parse XML data with `SimpleXML`.
- Modify and persist XML data with `DOMDocument`.
- Escape output with `htmlspecialchars()` to reduce HTML injection/XSS risks.
- Update the XML `LAST_UPDATE` timestamp when a product is added.
- Redirect after form submission to avoid duplicate submissions on page refresh.
- Display a success status after a product has been added.

## Technologies

- **PHP**
- **HTML5**
- **XML**
- **SimpleXML**
- **DOMDocument**

## Project Structure

```text
PHP_Challenge/
├── Add_product.php      # HTML form for adding a new product
├── Table_Form.php       # HTML table structure and column headers
├── lib.php              # Products class and product management logic
├── products.php         # Main application page and request handling
└── products.xml         # XML file used as the data store
```

## How It Works

The application is centered around the `Products` class defined in `lib.php`.

### 1. Display Products

`products.php` creates a `Products` object and provides the path to `products.xml`.

```php
$productsList = new Products("./products.xml");
$productsList->print_html_table_with_all_products();
```

The `print_html_table_with_all_products()` method:

1. Loads the XML file using `simplexml_load_file()`.
2. Includes the table structure from `Table_Form.php`.
3. Iterates through all `PRODUCT` elements.
4. Generates an HTML table row for each product.
5. Escapes values before displaying them.

### 2. Add a Product

The `Add_product.php` file provides a form containing fields such as:

- Name
- Price
- Quantity
- Category
- Manufacturer
- Barcode
- Weight
- Stock status
- Availability

The form submits the data to `products.php` using the HTTP `POST` method.

### 3. Process the Request

When a product is submitted, `products.php` calls:

```php
$productsList->add_product($_POST);
```

The `add_product()` method then:

- Validates the required product name.
- Checks that the XML file exists.
- Loads the XML document with `DOMDocument`.
- Locates the `PRODUCTS` element.
- Creates a new `PRODUCT` node.
- Adds the submitted product fields.
- Updates `LAST_UPDATE`.
- Saves the modified XML file.

### 4. Prevent Duplicate Form Submissions

After processing the form, the application redirects back to `products.php`:

```text
products.php?status=success
```

This follows the **Post/Redirect/Get (PRG)** pattern, preventing the browser from resubmitting the same POST request when the page is refreshed.

## Running the Project Locally

### Requirements

- PHP 7+ with the XML extensions enabled
- A local PHP development environment such as XAMPP, WAMP, MAMP, or the PHP built-in web server

### 1. Clone the repository

```bash
git clone https://github.com/Tsomaros/PHP_Challenge.git
cd PHP_Challenge
```

### 2. Start the PHP development server

```bash
php -S localhost:8000
```

### 3. Open the application

Visit:

```text
http://localhost:8000/products.php
```

You should see the existing products together with the form for adding a new product.

## Data Format

Products are stored in `products.xml`.

Each product contains fields such as:

```xml
<PRODUCT>
    <NAME>Product name</NAME>
    <PRICE>64.90</PRICE>
    <QUANTITY>3</QUANTITY>
    <CATEGORY id="113000102">Category</CATEGORY>
    <MANUFACTURER>Manufacturer</MANUFACTURER>
    <BARCODE>123456789</BARCODE>
    <WEIGHT>6.1kg</WEIGHT>
    <INSTOCK>Y</INSTOCK>
    <AVAILABILITY>Available</AVAILABILITY>
</PRODUCT>
```

## Main Components

### `Products` Class

The `Products` class is responsible for the main application logic:

- Loading product data
- Rendering product data
- Validating input
- Creating new XML product nodes
- Updating the XML document
- Saving changes

Keeping this logic inside a dedicated class separates the core product operations from the page-level request handling.

## Learning Objectives

This challenge was implemented to practice:

- PHP syntax and server-side programming
- Object-oriented PHP
- Handling `GET` and `POST` requests
- HTML form processing
- Input validation
- XML parsing and manipulation
- File-based data persistence
- Dynamic HTML generation
- Output escaping
- Basic separation of concerns
- Post/Redirect/Get request flow

## Possible Improvements

For a production-oriented implementation, the application could be extended with:

- A relational database such as MySQL instead of XML storage.
- A cleaner MVC architecture.
- Stronger validation and type checking for numeric fields.
- CSRF protection for form submissions.
- More comprehensive error handling and logging.
- Separate templates/views from business logic.
- Automated tests.
- Improved UI and responsive styling.
- CRUD operations for editing and deleting products.
- Unique barcode validation.
- Configuration through environment variables.

## Author

**Dimitris Vlachogiannis**

GitHub: [@Tsomaros](https://github.com/Tsomaros)
