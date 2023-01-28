<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>

<body>
    <style>
        .app {
            padding: 10px;
        }

        .flex {
            display: flex;
            gap: 10px;
            padding: 10px;
        }
    </style>
    <div id="app">
        <form method="POST">
            <div class="flex">
                <label for="N_PA">Número do Prontuário:</label>
                <input type="text" id="N_PA" name="N_PA"><br>

                <label for="DATA_ATEND">Data do Atendimento:</label>
                <input type="date" id="DATA_ATEND" name="DATA_ATEND"><br>

                <label for="ATEND_HORA">Hora do Atendimento:</label>
                <input type="time" id="ATEND_HORA" name="ATEND_HORA"><br>
            </div>
            <div class="flex">
                <label for="CNS">CNS:</label>
                <input type="text" id="CNS" name="CNS"><br>
            </div>
            <div class="flex">
                <label for="NOME">Nome:</label>
                <input type="text" id="NOME" name="NOME"><br>

                <label for="DATA_NASC">Data de Nascimento:</label>
                <input type="date" id="DATA_NASC" name="DATA_NASC" onchange="calculateAge()"><br>

                <label for="idade">Idade:</label>
                <input type="text" id="idade" name="idade">
                <br>
            </div>
            <div class="flex">
                <label for="MAE">Nome da Mãe:</label>
                <input type="text" id="MAE" name="MAE"><br>

                <label for="SEXO">Sexo:</label>
                <select id="SEXO" name="SEXO">
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                    <option value="outro">Outro</option>
                </select><br>
            </div>
            <div class="flex">

                <label for="END_RUA">Endereço (Rua):</label>
                <input type="text" id="END_RUA" name="END_RUA"><br>

                <label for="END_N">Endereço (Número):</label>
                <input type="text" id="END_N" name="END_N"><br>

                <label for="END_BAIRRO">Endereço (Bairro):</label>
                <input type="text" id="END_BAIRRO" name="END_BAIRRO"><br>
            </div>
            <div class="flex">
            <label for="END_MUN">Endereço (Município):</label>
            <input type="text" id="END_MUN" name="END_MUN"><br>

            <label for="END_UF">Endereço (UF):</label>
            <input type="text" id="END_UF" name="END_UF"><br>
            </div>
            <hr/>


    <input type="submit" value="Enviar">
    </form>
    <script>


        function calculateAge() {
            var dataNasc = new Date(document.getElementById("DATA_NASC").value);
            var today = new Date();
            var age = today.getFullYear() - dataNasc.getFullYear();
            var m = today.getMonth() - dataNasc.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dataNasc.getDate())) {
                age--;
            }
            document.getElementById("idade").value = age;
        }
        window.onload = function() {
    var dataAtendimento = document.getElementById("DATA_ATEND");
    var data = new Date();
    var dia = data.getDate();
    var mes = data.getMonth() + 1;
    var ano = data.getFullYear();
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    var dataFormatada = ano + "-" + mes + "-" + dia;
    dataAtendimento.value = dataFormatada;

    var horaAtendimento = document.getElementById("ATEND_HORA");
    var data = new Date();
    var hora = data.getHours();
    var minuto = data.getMinutes();
    var segundo = data.getSeconds();
    if (hora < 10) {
      hora = "0" + hora;
    }
    if (minuto < 10) {
      minuto = "0" + minuto;
    }
    if (segundo < 10) {
      segundo = "0" + segundo;
    }
    var horaFormatada = hora + ":" + minuto + ":" + segundo;
    horaAtendimento.value = horaFormatada;
  }
    </script>

    <?php

    if ($_POST) {


        // Inicia a conexão com o banco de dados
        $conn = new mysqli("localhost", "root", "apuapu", "test");

        // Verifica se a conexão foi estabelecida com sucesso
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }
        // Recebe os dados do formulário via POST

        $N_PA = $_POST['N_PA'];
        $DATA_ATEND = $_POST['DATA_ATEND'];
        $ATEND_HORA = $_POST['ATEND_HORA'];
        $CNS = $_POST['CNS'];
        $NOME = $_POST['NOME'];
        $DATA_NASC = $_POST['DATA_NASC'];
        $MAE = $_POST['MAE'];
        $SEXO = $_POST['SEXO'];
        $END_RUA = $_POST['END_RUA'];
        $END_N = $_POST['END_N'];
        $END_MUN = $_POST['END_MUN'];
        $END_BAIRRO = $_POST['END_BAIRRO'];
        $END_UF = $_POST['END_UF'];
     


        // Insere os dados no banco de dados
        $sql = "INSERT INTO test.teste_pacientes (N_PA, DATA_ATEND, ATEND_HORA, CNS, NOME, DATA_NASC, MAE, SEXO, END_RUA, END_N, END_MUN, END_BAIRRO, END_UF)
    VALUES ('$N_PA', '$DATA_ATEND', '$ATEND_HORA', '$CNS', '$NOME', '$DATA_NASC', '$MAE', '$SEXO', '$END_RUA', '$END_N', '$END_MUN', '$END_BAIRRO', '$END_UF')";

        if ($conn->query($sql) === TRUE) {
            echo "Dados inseridos com sucesso!";
        } else {
            echo "Erro ao inserir dados: " . $conn->error;
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    }




    // Cria uma nova conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "apuapu", "test");

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Executa a consulta SQL
    $sql = "SELECT N_PA, NOME, DATA_NASC, SEXO, END_RUA, END_MUN, COR_PRIORID FROM test.teste_pacientes ORDER BY id DESC";
    $result = $conn->query($sql);

    // Fecha a conexão com o banco de dados
    $conn->close();

    // Inicia a tabela HTML
    echo "<table class='table table-bordered table-hovered'>";

    // Cabeçalho da tabela
    echo "<tr>
        <th>Número do Paciente</th>
        <th>Nome</th>
        <th>Data de Nascimento</th>
        <th>Sexo</th>
        <th>Endereço (Rua)</th>
        <th>Endereço (Município)</th>  
        <th>Cor/Prioridade</th>
        </tr>";

    // Verifica se há resultados
    if ($result->num_rows > 0) {
        // Exibe os resultados
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                  <td>" . $row["N_PA"] . "</td>
                  <td>" . $row["NOME"] . "</td>
                  <td>" . $row["DATA_NASC"] . "</td>
                  <td>" . $row["SEXO"] . "</td>
                  <td>" . $row["END_RUA"] . "</td>
                  <td>" . $row["END_MUN"] . "</td>
                  <td>" . $row["COR_PRIORID"] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Nenhum resultado encontrado.</td></tr>";
    }

    // Fecha a tabela HTML
    echo "</table>";
    ?>

    </div>
</body>

</html>