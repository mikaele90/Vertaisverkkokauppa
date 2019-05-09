<?php
class ItemCategory {
    // DB Stuff
    private $dblink;
    private $table = 'ItemDB';

    // Properties
    public $item_id;
    public $item_name;
    public $item_category_name;
    public $item_subcategory_name;

    // Constructor with DB
    public function __construct($database) {
        $this->dblink = $database;
    }

    // Get categories
    public function read() {
        // Create query
        $query = 'SELECT 
            itemid AS item_id,
            itemname AS item_name,
            itemcategory AS item_category_name,
            itemsubcategory AS item_subcategory_name 
        FROM 
            ' . $this->table . ' 
        ORDER BY 
            itemcategory 
        ASC';

        // Prepare statement
        $stmt = $this->dblink->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single ItemCategory
    public function read_one()
    {
        // Create query
        $query = 'SELECT
          i.itemid,
          i.itemname
        FROM
          ' . $this->table . ' i
        WHERE 
            i.itemcategory = ?
        LIMIT 0,1';

        //Prepare statement
        $stmt = $this->dblink->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->item_id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->item_id = $row['itemid'];
        $this->item_name = $row['itemname'];
    }
}
