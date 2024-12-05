<?php 
include_once('../db/db.php');

if (!empty($_GET['id'])) {
    

    $id = $_GET['id'];

    $selectsql = "SELECT * FROM categorias WHERE id=$id";

    $resultado = $conexao->query($selectsql);



    if ($resultado->num_rows > 0) {

        $deletarproduto = "DELETE FROM categorias WHERE id=$id";
        $resultadodeletar = $conexao->query($deletarproduto);
        header('location: ../index.php');  
        
    } else {
        header('location: ../index.php');
    };
};

header('location: ../index.php');





?>