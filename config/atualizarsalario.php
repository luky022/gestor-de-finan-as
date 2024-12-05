<?php
include_once('../db/db.php');
// verifica se está enviando algum dado, para não enviar dado vazio ao banco de dados.

if (isset($_POST['submit'])) {
    $salariovalor = $_POST['salario'];




    
    $result = mysqli_query($conexao, "UPDATE salario SET salariovalor = $salariovalor");

  


    header('location: ../index.php');
};

header('location: ../index.php');




?>



















