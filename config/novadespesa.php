<?php
include_once('../db/db.php');
// verifica se está enviando algum dado, para não enviar dado vazio ao banco de dados.

if (isset($_POST['submit'])) {
    $datavencimento = $_POST['datavencimento'];
    $descricao = $_POST['descricao'];
    $despesavalor = $_POST['despesavalor'];
    $categoria = $_POST['selecionarcategorias'];



    
    $result = mysqli_query($conexao, "INSERT INTO despesas (data, descricao, despesavalor, categoria) VALUES('$datavencimento', '$descricao', '$despesavalor', '$categoria')");

  


    header('location: ../index.php');
};

header('location: ../index.php');




?>



















