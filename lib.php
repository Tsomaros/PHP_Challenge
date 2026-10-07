<?php
class Products
{

    private $xml_file_path = '';

    public function __construct($xml_file_path = '')
    {
        $this->xml_file_path = $xml_file_path;
    }

    
    /**
     * This function prints an HTML table with all the products as read from the xml file
     * @return void 
     */
    public function print_html_table_with_all_products()
    {
        //TODO 1:Θα πρέπει να συμπληρώσουμε την συνάρτηση ώστε να κάνει print το HTML table με τα προϊόντα του xml
        $xmldata = simplexml_load_file($this->xml_file_path) or die("Failed to load");
        $xml_data = $xmldata->children();

        //// Έναρξη του πίνακα
        include_once('./Table_Form.php');

        foreach ($xml_data->PRODUCTS->PRODUCT as $key => $prod) {
            
            $this->print_html_of_one_product_line($prod);
        
        }
        
        // Κλείσιμο του πίνακα
        echo '</tbody>';
        echo '</table>';
    }


    /**
     * This function prints an HTML tr for a given product
     * @param mixed $prod It is the product object as retrieved from the xml file
     * @return void 
     */
    private function print_html_of_one_product_line($prod){
        //TODO 2: Θα πρέπει να συμπληρώσουμε τη συνάρτηση ώστε να κάνει print τα tr με τα στοιχεία του ενός προϊόντος
        //var_dump($prod);

        $fields = [
            trim((string)$prod->NAME),
            trim((string)$prod->PRICE),
            trim((string)$prod->QUANTITY),
            trim((string)$prod->CATEGORY),
            trim((string)$prod->MANUFACTURER),
            trim((string)$prod->BARCODE),
            trim((string)$prod->WEIGHT),
            trim((string)$prod->INSTOCK),
            trim((string)$prod->AVAILABILITY),
        ];

        // Εκτύπωση της γραμμής του πίνακα
        echo '<tr>';
        foreach ($fields as $value) {
            echo '<td>' . htmlspecialchars(trim($value)) . '</td>';
        }
        echo '</tr>';

    }


    public function add_product($data){

        // 1. Έλεγχος υποχρεωτικού πεδίου NAME
        $name = isset($data['name']) ? trim($data['name']) : '';
        if (empty($name)) {
            return ['success' => false, 'message' => 'Name field is Mandatory!'];
        }

        // 2. Έλεγχος ύπαρξης του XML αρχείου
        if (!file_exists($this->xml_file_path)) {
            return ['success' => false, 'message' => 'XML file not found.'];
        }

        // 3. Φόρτωση του XML
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        if (!$dom->load($this->xml_file_path)) {
            return ['success' => false, 'message' => 'Failed to load the XML file.'];
        }

        // 4. Εντοπισμός του κόμβου <PRODUCTS>
        $productsNode = $dom->getElementsByTagName('PRODUCTS')->item(0);
        if (!$productsNode) {
            return ['success' => false, 'message' => '<PRODUCTS> not found in XML file.'];
        }

        // 5. Δημιουργία του νέου element <PRODUCT>
        $productNode = $dom->createElement('PRODUCT');

        // NAME
        $nameNode = $dom->createElement('NAME');
        $nameNode->appendChild($dom->createCDATASection($name));
        $productNode->appendChild($nameNode);

        // PRICE
        $priceNode = $dom->createElement('PRICE', htmlspecialchars(trim($data['price'] ?? '')));
        $productNode->appendChild($priceNode);

        // QUANTITY
        $quantityNode = $dom->createElement('QUANTITY', htmlspecialchars(trim($data['quantity'] ?? '')));
        $productNode->appendChild($quantityNode);

        // CATEGORY 
        $categoryNode = $dom->createElement('CATEGORY', htmlspecialchars(trim($data['category'] ?? '')));
        if (!empty($data['category_id'])) {
            $categoryNode->setAttribute('id', trim($data['category_id']));
        }
        $productNode->appendChild($categoryNode);

        // MANUFACTURER
        $manufacturerNode = $dom->createElement('MANUFACTURER', htmlspecialchars(trim($data['manufacturer'] ?? '')));
        $productNode->appendChild($manufacturerNode);

        // BARCODE 
        $barcodeNode = $dom->createElement('BARCODE');
        $barcodeNode->appendChild($dom->createCDATASection(trim($data['barcode'] ?? '')));
        $productNode->appendChild($barcodeNode);

        // WEIGHT 
        $weightNode = $dom->createElement('WEIGHT');
        $weightNode->appendChild($dom->createCDATASection(trim($data['weight'] ?? '')));
        $productNode->appendChild($weightNode);

        // INSTOCK
        $instockNode = $dom->createElement('INSTOCK', htmlspecialchars(trim($data['instock'] ?? 'Y')));
        $productNode->appendChild($instockNode);

        // AVAILABILITY
        $availabilityNode = $dom->createElement('AVAILABILITY', htmlspecialchars(trim($data['availability'] ?? '')));
        $productNode->appendChild($availabilityNode);

        // 6. Προσθήκη του νέου προϊόντος στο <PRODUCTS>
        $productsNode->appendChild($productNode);

        // 7. Ενημέρωση του <LAST_UPDATE>
        $lastUpdateNode = $dom->getElementsByTagName('LAST_UPDATE')->item(0);
        if ($lastUpdateNode) {
            $lastUpdateNode->nodeValue = date('Y-m-d H:i');
        }

        // 8. Αποθήκευση στο αρχείο XML
        if ($dom->save($this->xml_file_path)) {
            return ['success' => true, 'message' => 'The product has been successfully added.!'];
        } else {
            return ['success' => false, 'message' => 'Failed to save to the XML file.'];
        }
    }
}
