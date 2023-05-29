<?php
require_once PROJECT_ROOT_PATH . "common\\BaseModel.php";

class ProductModel extends BaseModel {

    public function __construct() {
        parent::__construct(Database::getConnection(),"products");
    } 
}

?>