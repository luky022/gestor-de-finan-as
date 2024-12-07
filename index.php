
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link rel="stylesheet" href="estilo.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTÃO FINANCEIRA</title>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</head>

<body>

<!-- PUXANDO VALOR DO DOLAR API -->
 <?php 
 $url = "https://economia.awesomeapi.com.br/json/last/USD-BRL";
 $dolar = json_decode(file_get_contents($url, true));


 $bid = $dolar->USDBRL->bid;

 $bid2 = number_format($bid, 2, ',', '');
    

 ?>
    

    <header>
        
        <h1>Gestão de Finanças</h1>
        <p>VALOR ATUAL DO DÓLAR: <strong>R$ <?=$bid2?></strong></p>
    </header>

    <div class="container">
        <div class="summary">
            <div class="card">

                <!-- OPÇÃO PARA ATUALIZAR O SALARIO MENSAL -->
                <h3>Salário do Mês</h3>
                <?php
                include_once('./db/db.php');

                $sqlupdate = "SELECT salariovalor FROM salario";
                $resultupdate = $conexao->query($sqlupdate);

                while ($user_data = mysqli_fetch_assoc($resultupdate)) {
                    echo "<p>" . "R$ " . $user_data['salariovalor'] . "</p>";

                    $salario = $user_data['salariovalor'];
                }



                ?>

                <button type="button" class="btn btn-warning m-2" data-bs-toggle="modal" data-bs-target="#modal3">
                    ATUALIZAR
                </button>

            </div>

            <!-- OPÇÃO PARA ATUALIZAR A RENDA EXTRA DO MÊS -->
            <div class="card">
                <h3>Renda Extra</h3>

                <?php

                include_once('./db/db.php');

                $sqlreceita = "SELECT receitavalor FROM receitas";
                $resultreceita = $conexao->query($sqlreceita);

                while ($user_data = mysqli_fetch_assoc($resultreceita)) {
                    echo "<p>" . "R$ " . $user_data['receitavalor'] . "</p>";
                    $receita = $user_data['receitavalor'];
                }

                ?>

                <button type="button" class="btn btn-danger m-2" data-bs-toggle="modal" data-bs-target="#modal4">
                    ATUALIZAR
                </button>
            </div>

            <!-- OPÇÃO QUE IRÁ MOSTRAR TODA A DESPESA DO MÊS ATUAL -->
            <div class="card">
                <h3>Despesas totais do mês</h3>
                <?php

                $mesatual = date('m');



                include_once('./db/db.php');

                $sqlreceita = "SELECT SUM(despesavalor) AS total FROM despesas WHERE MONTH(data) = $mesatual";


                $resultreceita = $conexao->query($sqlreceita);

                while ($user_data = mysqli_fetch_assoc($resultreceita)) {
                    echo "<p>" . "R$ " . $user_data['total'] . "</p>";

                    $despesa = $user_data['total'];
                }

                $rendatotal = $receita + $salario;

                if ($rendatotal < $despesa) {
                    echo "<p style='background-color: red;' >SUA DESPESA ESTÁ MAIOR QUE SUA RENDA MENSAL.</p>";
                };

                ?>
            </div>

            
        </div>

        <!-- BOTÕES PARA ABRIR MODAL -->

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal1">
            NOVA DESPESA
        </button>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal2">
            CATEGORIA/DELETAR/CRIAR
        </button>





        <!-- Modal 1 CADASTRAR NOVA DESPESA-->
        <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal1Label">NOVA DESPESA</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <form method="post" action="config/novadespesa.php" class="row g-3">
                            <div class="col-md-4">
                                <label for="datavencimento" class="form-label">DATA DE VENCIMENTO</label>
                                <input type="date" class="form-control" id="datavencimento" name="datavencimento" required>
                            </div>

                            <div class="col-md-4">
                                <label for="descricao" class="form-label">DESCRIÇÃO</label>
                                <input type="text" class="form-control" name="descricao" id="descricao" required>
                            </div>


                            <div class="col-md-6">
                                <label for="despesavalor" class="form-label">VALOR DA DESPESA</label>
                                <input required type="number" class="form-control" id="despesavalor" name="despesavalor">
                            </div>

                            <div class="col-md-3">
                                <label for="validationDefault04" class="form-label">CATEGORIA</label>
                                <select name="selecionarcategorias" class="form-select" id="validationDefault04" required="">
                                    <option selected="" disabled="" value="">escolha...</option>

                                    <!-- SELECIONAR CATEGORIAS DO BANCO -->

                                    <?php
                                    $categoriaadd = "SELECT * FROM categorias";
                                    $result = $conexao->query($categoriaadd);

                                    while ($user_data = mysqli_fetch_assoc($result)) {

                                        echo "<option>" . $user_data['categoriasnome'] . "</option>";
                                    }


                                    ?>

                                </select>

                            </div>



                            <div class="col-12">
                                <input class="btn btn-primary" type="submit" name="submit" value="SALVAR">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal 2 CRIAR UMA NOVA CATEGORIA, OU DELETAR ALGUM EXISTENTE-->
        <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal2Label">CRIAR OU DELETAR CATEGORIAS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- dentro do model -->

                        <form method="post" action="../config/addcategorias.php" class="row g-3">


                            <div class="col-md-4">
                                <label for="descricao" class="form-label">NOVA CATEGORIA</label>
                                <input id="addcategoria" name="addcategoria" placeholder="digite o nome da categoria" type="text" class="form-control" id="descricao">
                            </div>

                            <div class="col-12">
                                <button id="submit" name="submit" class="btn btn-primary" type="submit">SALVAR</button>
                            </div>
                        </form>

                        <h3>categorias cadastradas</h3>

                        <table>
                            <tr>
                                <th>NOME</th>
                                <th>#</th>
                            </tr>
                            <!-- MOSTRAR CATEGORIAS CADASTRADAS NO BANCO DE DADOS -->
                            <?php
                            include_once('db/db.php');

                            $sql = "SELECT * FROM categorias";
                            $result = $conexao->query($sql);

                            while ($user_data = mysqli_fetch_assoc($result)) {

                                echo "<tr>";

                                echo "<td>" . $user_data['categoriasnome'] . "</td>";
                                echo "<td>
                               <a href='../config/deletarcategoria.php?id=" . $user_data['id'] . "' class='botaoo'>
                               <img width='20px' src='img/deletar.png' alt='deletar'>
                               </a>
                                 </td>";

                                echo "<tr>";
                            }


                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- ATUALIZAR SALARIO -->
        <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal3Label">EDITAR SALARIO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="../config/atualizarsalario.php" class="row g-3">


                            <div class="col-md-4">
                                <label for="salario" class="form-label">ATUALIZAR SALARIO</label>
                                <input value=" 1412 " type="text" class="form-control" name="salario" id="salario">
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" id="submit" name="submit" type="submit">SALVAR</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>


        <!-- ATUALIZAR RENDA EXTRA -->
        <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="modal4Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal4Label">EDITAR RENDA EXTRA</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <form method="post" action="../config/receita.php" class="row g-3">


                            <div class="col-md-4">
                                <label for="salario" class="form-label">ATUALIZAR RENDA EXTRA</label>
                                <input value="1000" type="text" class="form-control" name="renda" id="renda">
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" id="submit" name="submit" type="submit">SALVAR</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>

        



    </div>

    </div>
    <br><br>

    <div class="transactions">
        <h2>Transações Recentes</h2>

        <form  method="post" action="<?= $_SERVER['PHP_SELF'] ?>">

            <select name="meses" class="form-select" aria-label="Default select example">

                <option selected>BUSCAR POR MÊS</option>
                <option value="1">01 Janeiro</option>
                <option value="2">02 Fevereiro</option>
                <option value="3">03 Março</option>
                <option value="4">04 Abril</option>
                <option value="5">05 Maio</option>
                <option value="6">06 Junho</option>
                <option value="7">07 Julho</option>
                <option value="8">08 Agosto</option>
                <option value="9">09 Setembro</option>
                <option value="10">10 Outubro</option>
                <option value="11">11 Novembro</option>
                <option value="12">12 Dezembro</option> 

                <input class="btn btn-primary" type="submit" name="submit" value="BUSCAR">

            </select>

        </form>

        <?php


        $puxarmes = $_POST['meses'] ??  $mesatual;



        ?>


        <br>

        <table>
            <thead>
                <tr>

                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th>#</th>
                </tr>
            </thead>

            <?php
            include_once('db/db.php');

            $sql = "SELECT * FROM despesas  WHERE MONTH(data) = $mesatual";
            $result = $conexao->query($sql);

            if ($puxarmes == 1) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 01";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 2) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 02";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 3) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 03";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 4) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 04";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 5) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 05";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 6) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 06";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 7) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 07";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 8) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 08";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 9) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 09";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 10) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 10";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 11) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 11";
                $result = $conexao->query($sql);
            } elseif ($puxarmes == 12) {
                $sql = "SELECT * FROM despesas  WHERE MONTH(data) = 12";
                $result = $conexao->query($sql);
            };



            while ($user_data = mysqli_fetch_assoc($result)) {
                $data = $user_data['data'];
                $dataF = date('d/m/Y', strtotime($data));


                echo "<tr>";

                echo "<td>" . $dataF . "</td>";
                echo "<td>" . $user_data['descricao'] . "</td>";
                echo "<td>" . $user_data['categoria'] . "</td>";
                echo "<td>" . "R$ " . $user_data['despesavalor'] . "</td>";
                echo "<td>
                        <a href='../config/deletar.php?id=" . $user_data['id'] . "' class='botaoo'>
                           <img width='20px' src='img/deletar.png' alt='deletar'>
                        </a>
                        </td>";

                echo "<tr>";
            }






            ?>
        </table>
        
    </div>
    </div>




    <script>
        // Função para o Modal 1 - Exibir Alerta
        const alertButton = document.getElementById('alertButton');
        alertButton.addEventListener('click', () => {
            alert('Alerta do Modal 1 acionado!');
        });

        // Função para o Modal 2 - Alterar Texto
        const changeTextButton = document.getElementById('changeTextButton');
        const dynamicText = document.getElementById('dynamicText');
        changeTextButton.addEventListener('click', () => {
            dynamicText.textContent = 'O texto foi alterado pelo botão no Modal 2!';
        });
    </script>




</body>

</html>
