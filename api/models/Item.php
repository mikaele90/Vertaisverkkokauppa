<?php
class Item {
    // DB stuff
    private $dblink;
    private $table = 'ItemDB';

    // Item Properties
    public $item_id;
    public $item_name;
    public $item_category_name;
    public $item_subcategory_name;
    public $item_price;
    public $item_description;
    public $item_imagelink;
    public $item_availability;

    // Constructor with DB
    public function __construct($database) {
        $this->dblink = $database;
    }

    // Get Posts
    public function read() {
        // Create query
        $query = 'SELECT 
            i.itemid AS item_id,
            i.itemname AS item_name,
            i.itemcategory AS item_category_name,
            i.itemsubcategory AS item_subcategory_name,
            i.itemprice AS item_price,
            i.itemdescription AS item_description,
            i.imagelink AS item_imagelink,
            i.availability AS item_availability
        FROM 
            ' . $this->table . ' i 
        ORDER BY 
            ItemId 
        ASC';

        // Prepare statement
        $stmt = $this->dblink->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Item
    public function read_one() {
        // Create query
        $query = 'SELECT 
            i.itemid, 
            i.itemname, 
            i.itemcategory, 
            i.itemsubcategory, 
            i.itemprice, 
            i.itemdescription, 
            i.imagelink, 
            i.availability 
        FROM 
            ' . $this->table . ' i 
        WHERE 
            ItemId = ?';

        // Prepare statement
        $stmt = $this->dblink->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->item_id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->item_id = $row['itemid'];
        $this->item_name = $row['itemname'];
        $this->item_category_name = $row['itemcategory'];
        $this->item_subcategory_name = $row['itemsubcategory'];
        $this->item_price = $row['itemprice'];
        $this->item_description = $row['itemdescription'];
        $this->item_imagelink = $row['imagelink'];
        $this->item_availability = $row['availability'];
    }


}