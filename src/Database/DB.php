<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/20/2020
 * Time: 12:57 PM
 */

namespace Pondit\Database;

use PDO;

class DB
{
    private $conn;

    /**
     * DB constructor.
     */
    public function __construct() {
        try {
            $this->conn = new PDO('mysql:host=' .DB_HOST .';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }

}