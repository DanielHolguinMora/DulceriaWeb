<?php

$conn = mysqli_connect("localhost", "root", "", "usuarios_db");

if(!$conn){
    die("Error de conexión: " . mysqli_connect_error());
}