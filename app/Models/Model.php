<?php
require_once('Database.php');
class Model {
//Ik heb bij alle parameters een bind gedaan omdat je dan geprotect ben tegen sqlinjection.
    private $conn;
    //dit is de construct function, hierin maakt hij een connection en die word doorgestuurt zodat er maar één connection open is en niet meerderen waardoor je geen too many connections error krijgt.
    public function __construct($conn) {
        $this->conn = $conn;
    }
}