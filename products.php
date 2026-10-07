<!DOCTYPE html>
<html>
<body>

<h1>List of products</h1>

<?php
    require_once("./lib.php");
    $productsList = new Products("./products.xml");
    $productsList->print_html_table_with_all_products();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_add_product'])) {
        $result = $productsList->add_product($_POST);

        // Redirect στην ίδια σελίδα για αποφυγή επανεγγραφής στο Refresh
        header("Location: products.php?status=" . ($result['success'] ? 'success' : 'error'));
        exit();
    }
?>

</body>
</html>

<?php
    //Εμφάνιση μηνύματος επιτυχίας από το URL status
    if (isset($_GET['status']) && $_GET['status'] === 'success') {
        echo "<p style='color:green;'>Το προϊόν προστέθηκε με επιτυχία!</p>";
    }
?>

<?php

    // Συμπερίληψη της φόρμας για Add product
    require_once("./Add_product.php");
?>

</body>
</html>