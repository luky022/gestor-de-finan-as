<?php
include_once('../db/db.php');
// verifica se está enviando algum dado, para não enviar dado vazio ao banco de dados.

if (isset($_POST['submit'])) {
    $salariorenda = $_POST['renda'];




    
    $result = mysqli_query($conexao, "UPDATE receitas SET receitavalor = $salariorenda");

  


    header('location: ../index.php');
};

header('location: ../index.php');




?>



















