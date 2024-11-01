<?php

$con = new mysqli('localhost','root','','cms');

if(!$con){
    die(mysqli_error($con));
}

?>