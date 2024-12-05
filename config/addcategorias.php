<?php
include_once('../db/db.php');
// verifica se está enviando algum dado, para não enviar dado vazio ao banco de dados.

if (isset($_POST['submit'])) {
    $categoria = $_POST['addcategoria'];



    
    $result = mysqli_query($conexao, "INSERT INTO categorias (categoriasnome) VALUES('$categoria')");

  


    header('location: ../index.php');
};

header('location: ../index.php');




?>



















