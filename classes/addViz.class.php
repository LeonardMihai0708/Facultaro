<?php

include_once "../includes/dbs.inc.php";
session_start();

class addViz{
    public $sql;
    private $id;
    private $conn;

    public function __construct($id, $conn)
    {
        $this->id = $id;
        $this->conn = $conn;
    }

    public function addVizFun(){
        $this->sql = "UPDATE fisiere 
        SET descarcari = descarcari + 1 
        WHERE id = ".$this->id.";";
        mysqli_query($this->conn,$this->sql);
        header('Location: '.'../fisiere/'.$this->id.'.pdf');
        exit;
    }
        
}