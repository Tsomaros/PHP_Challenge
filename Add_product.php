<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List of products</title>
</head>
<body>

<h2>Add New Product</h2>
<form method="POST" action="products.php">
    <div>
        <label for="name">Name <span style="color:red;">*</span>:</label><br>
        <input type="text" id="name" name="name" required>
    </div><br>

    <div>
        <label for="price">Price:</label><br>
        <input type="number" step="0.01" id="price" name="price">
    </div><br>

    <div>
        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity">
    </div><br>

    <div>
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category">
    </div><br>

    <div>
        <label for="manufacturer">Manufacturer:</label><br>
        <input type="text" id="manufacturer" name="manufacturer">
    </div><br>

    <div>
        <label for="barcode">Barcode:</label><br>
        <input type="text" id="barcode" name="barcode">
    </div><br>

    <div>
        <label for="weight">Weight:</label><br>
        <input type="text" id="weight" name="weight">
    </div><br>

    <div>
        <label for="instock">In Stock:</label><br>
        <select id="instock" name="instock">
            <option value="Y">Y</option>
            <option value="N">N</option>
        </select>
    </div><br>

    <div>
        <label for="availability">Availability:</label><br>
        <input type="text" id="availability" name="availability">
    </div><br>

    <button type="submit" name="submit_add_product">Add Product</button>
</form>

</body>
</html>