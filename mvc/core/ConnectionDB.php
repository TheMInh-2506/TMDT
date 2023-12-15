

<?php
class ConnectionDB
{
    protected $dbhost = "127.0.0.1";
    protected $dbuser = "root";
    protected $dbpass = "";
    protected $db = "cuahangnoithat";
    protected $conn;

    function __construct()
    {
        $this->conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->db) or die("Connect failed: %s\n" . $this->conn->error);
        mysqli_query($this->conn, "SET NAMES 'utf8'");
    }

    function getDataFromResultSet($rs)
    {
        if (mysqli_num_rows($rs) <= 0) {
            return array();
        } else {
            while ($row = mysqli_fetch_assoc($rs)) {
                $data[] = $row;
            }
        }
        if(count($data) == 1){
            return $data[0];
        }
        return $data;
    }
}
?>