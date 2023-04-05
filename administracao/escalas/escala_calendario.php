<!DOCTYPE html>
<html>

<head>
    <title>Calendário</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        .nomes {

            white-space: nowrap;
            margin: 0;
            padding: 0;
            line-height: 10pt;

            font-size: 16px;
        }

        .nomes p {
            margin: 0;
        }

        body {
            display: flex;
            /* Define o display do body como flex para alinhar a imagem */
            justify-content: center;
            /* Alinha horizontalmente o conteúdo do body */
            align-items: center;
            /* Alinha verticalmente o conteúdo do body */
            margin: 0 auto;

        }

        img {
            display: block;
            /* Define o display da imagem como block para que a margem auto funcione */
            margin: 10px auto;
            /* Define as margens esquerda e direita como auto para centralizar a imagem */

        }

        h2 {
            text-align: center;
            margin: 20px 0;

        }

        .containers {
            width: 100%;
        }
    </style>
</head>


<body>
    <div class="containers">
        <img src="/siiupa/imagens/cabeçalho_2022.JPG" alt="Imagem">

        <h2>Escala <span id="tituloMesAno"></span></h2>
        <?php
        // Recebe o mês e o ano via querystring
        $month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        !$id ? die : "";

        // Calcula o número de dias no mês e o primeiro dia da semana
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $first_day = mktime(0, 0, 0, $month, 1, $year);
        $first_day_weekday = date('N', $first_day);

        // Define os dias da semana
        $weekdays = array('SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÁBADO', 'DOMINGO');
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php
                    // Cria as células de cabeçalho com os dias da semana
                    foreach ($weekdays as $weekday) {
                        echo '<th>' . $weekday . '</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $day_count = 1; // Contador de dias

                // Loop pelos dias
                for ($i = 0; $i < 6; $i++) { // assume 6 semanas para o exemplo
                    echo '<tr>';

                    // Loop pelos dias da semana
                    for ($j = 0; $j < 7; $j++) {
                        // Cria a célula da tabela com o número do dia

                        if (($i == 0 && $j < $first_day_weekday - 1) || $day_count > $days) {
                            // Preenche com um espaço em branco antes do primeiro dia do mês e após o último dia do mês
                            echo "<td>";
                            echo '&nbsp;';
                            echo '</td>';
                        } else {
                            echo "<td>";

                            if ($j == 5 || $j == 6) {
                                echo "<b style='color:red'>$day_count</b>";
                            } else {
                                echo "<b>$day_count</b>";
                            }
                            echo "<br/><span class='nomes' id='$day_count'></span>";
                            echo '</td>';
                            $day_count++;
                        }
                    }

                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>
        <div id="legenda"></div>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function reduzirNome(nomeCompleto) {
            const palavras = nomeCompleto.split(' ');
            const primeiroNome = palavras[0];
            const segundoNome = palavras[1];

            const ultimoNome = palavras[palavras.length - 1];
            if (primeiroNome.toUpperCase() != "MARIA") {
                return `${primeiroNome} <small>${ultimoNome}</small>`;
            } else {
                const ignorar = ["DE", "DA", "DOS", "DAS", "DO"];
                if (ignorar.includes(segundoNome.toUpperCase())) {
                    const terceiroNome = palavras[2];
                    return `<small>Mª.</small> ${terceiroNome} <small>${ultimoNome}</small>`;
                } else {
                    return `<small>Mª.</small> ${segundoNome} <small>${ultimoNome}</small>`;
                }
            }
        }
        // Adiciona classe 'today' à célula da tabela do dia atual
        var today = new Date().getDate();
        $("td:contains(" + today + ")").addClass("today");


        async function getEsc() {
            try {
                const response = await axios.get('/siiupa/api/rh/api.php/records/tb_escalas?join=tb_setor&filter=id,eq,<?= $id ?>');
                const escalaDados = response.data.records;

                escalaDados.map((escala) => {
                    nomeMes = nomeDoMes(escala.mes);
                    $("#tituloMesAno").text(`${escala.fk_setor.setor} - ${nomeMes}/${escala.ano}`);
                    $("#legenda").html(`Legendas:<p>${escala.legenda}</p>`);
                });
            } catch (error) {
                console.error(error);
            }
        }
        async function getEscFunc() {
            try {
                const response = await axios.get('/siiupa/api/rh/api.php/records/tb_escala_funcionario?join=tb_funcionario&join=tb_escalas,tb_setor&filter=fk_escala,eq,<?= $id ?>');
                const funcDados = response.data.records;

                function ordenarPorNome(array) {
                    array.sort(function(a, b) {
                        var nomeA = a.fk_funcionario.nome.toUpperCase(); // converte o nome para maiúsculas
                        var nomeB = b.fk_funcionario.nome.toUpperCase(); // converte o nome para maiúsculas
                        if (nomeA < nomeB) {
                            return -1;
                        }
                        if (nomeA > nomeB) {
                            return 1;
                        }
                        return 0;
                    });
                    return array;
                }
                ordenarPorNome(funcDados);
                funcDados.map((func) => {

                    for (let i = 1; i <= 31; i++) {
                        diaPlantao = func[`d${i}`];

                        nomeReduzido = reduzirNome(func.fk_funcionario.nome);

                        if (diaPlantao != "" && diaPlantao != null) {
                            diaPlantao = diaPlantao.replace(/Â/g, '');
                            $(`#${i}`).append(`<p>${nomeReduzido} (${diaPlantao})</p>`);
                        }
                    }


                });
            } catch (error) {
                console.error(error);
            }
        }
        getEsc();
        getEscFunc();

        function nomeDoMes(numeroDoMes) {
            // Verifica se o argumento passado é um número inteiro entre 1 e 12
            if (Number.isInteger(numeroDoMes) && numeroDoMes >= 1 && numeroDoMes <= 12) {
                // Cria um array com os nomes dos meses
                const nomesDosMeses = [
                    'Janeiro',
                    'Fevereiro',
                    'Março',
                    'Abril',
                    'Maio',
                    'Junho',
                    'Julho',
                    'Agosto',
                    'Setembro',
                    'Outubro',
                    'Novembro',
                    'Dezembro'
                ];
                // Retorna o nome do mês correspondente ao número passado como argumento
                return nomesDosMeses[numeroDoMes - 1];
            } else {
                // Se o argumento não for válido, retorna uma mensagem de erro
                return 'Número de mês inválido';
            }
        }
    </script>

</body>

</html>