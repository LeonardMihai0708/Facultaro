<?php
include_once "dbs.inc.php";
include "autoloader.php";


foreach ($_POST as $key => $value) {
    $id = $key;
}
$item_insert = new addViz($id,$conn);
$item_insert->addVizFun();