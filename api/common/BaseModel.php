<?php 
require_once PROJECT_ROOT_PATH . "config\\Database.php";
require_once PROJECT_ROOT_PATH . "models\\Product.php";
class BaseModel extends Database {
    protected $table;
    protected $conn;

    public function __construct($conn, $table) {
        $this->table = $table;
        $this->conn = $conn;
    }

    public function all($page, $perPage, $data, $fields) {

        //Pagination and query
        $offset = ($page - 1) * $perPage;
        $sql = 
        "SELECT $fields
        FROM $this->table ".(
        $this->table == "products" ? " where isActive = 1 " : " ")."$data
        LIMIT $perPage 
        OFFSET $offset;";
        //Return results
        $result = $this->conn->query($sql);
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function create($data) {
            $columns = implode(", ", array_keys($data));
            $values = "'" . implode("', '", array_values($data)) . "'";
            $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";
            
            $result = $this->conn->query($sql);
            return $result;
    }

    public function update($id, $data) {
        $updates = array();
        foreach ($data as $key => $value) {
            $updates[] = "$key = '$value'";
        }
        $updates = implode(", ", $updates);
        $sql = "UPDATE $this->table SET $updates WHERE id = $id";
        
        $result = $this->conn->query($sql);
        return $result;
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = $id";
        
        $result = $this->conn->query($sql);
        return $result;
    }

    public function findById($id, $fields) {
        $sql = "SELECT $fields FROM $this->table WHERE id = $id ".($this->table=='products'?"and isActive = 1":" ");
        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();
        return $row;
    }

    public function findByIdAndUpdate($id, $data) {
        $updates = array();
        foreach ($data as $key => $value) {
            $updates[] = "$key = '$value'";
        }
        $updates = implode(", ", $updates);
        $sql = "UPDATE $this->table SET $updates WHERE id = $id";
        
        $result = $this->conn->query($sql);
        return $result;
    }

    public function queryExecutor($query) {
        $result = $this->conn->query($query);
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
}






?>