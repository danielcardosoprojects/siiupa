<?php
include_once('../bd/conectabd.php');
session_start();
include_once('../bd/nivel.php');
?>
<style>
    .eleicaobtn-link {
        font-size: 8px;
        /* Tamanho pequeno */
        color: white;
        /* Texto branco para contraste com o fundo */
        background-color: #007bff;
        /* Fundo azul */
        text-decoration: none;
        /* Remove o sublinhado padrão do link */
        font-weight: bold;
        /* Texto em negrito */
        padding: 5px 10px;
        /* Espaçamento interno */
        border: 1px solid #007bff;
        /* Borda da mesma cor do fundo */
        border-radius: 15px;
        /* Borda arredondada */
        display: inline-block;
        /* Garante que o padding e a borda apareçam corretamente */
    }

    .eleicaobtn-link:hover {
        text-decoration: underline;
        /* Adiciona sublinhado ao passar o mouse */
        color: #0056b3;
        /* Escurece a cor ao passar o mouse */
    }

    .eleicaobtn-link:active {
        color: #003865;
        /* Cor ainda mais escura ao clicar no link */
    }

    .contagem_cargos {
        display: flex;
        gap: 2px;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .jconfirm-content {
        width: 100%;
        height: 500px;
        overflow: hidden;
        padding: 0;
    }

    .jconfirm-box {
        width: 80% !important;
        max-width: 800px !important;
    }

    iframe {
        width: 100%;
        height: 500px;
        border: none;
    }

    .copiarTexto {
        cursor: pointer;
    }
</style>
<div id="busca_impressao">
    <div>

        <div class="">
            <a href="?setor=adm&sub=rh&subsub=perfil_criar" id="bcadastrarFUNCIONARIO" class="btn btn-outline-success">
                <img src="/siiupa/imagens/icones/person_add.svg">
                Adicionar Servidor
            </a>

            <a href="#" id="imprimirbusca" class="btn btn-outline-success">
                <img src="/siiupa/imagens/icones/impressora.svg" width="20px">
                Imprimir
            </a>


            <!-- <a href="administracao/gera_tabela_excel.php" target="_blank" id="exportar_excel_funcionarios" class="btn btn-outline-success">
                Gerar Excel
            </a> -->
            <button onclick="exportarTabela()" class="btn btn-outline-success btnExcel">
                <span class="ui-icon ui-icon-arrowthickstop-1-s"></span>

                Exportar para Excel</button>
            <script>
                function exportarTabela() {
                    const tabela = document.getElementById("tabela_funcionarios");
                    const workbook = XLSX.utils.table_to_book(tabela, {
                        sheet: "Planilha1"
                    });
                    XLSX.writeFile(workbook, "Lista Servidores SIUPA.xlsx");
                }
            </script>
            <!-- <a href="#" id="gerarFrequencias" class="btn btn-outline-success">
                <img src="/siiupa/imagens/icones/frequencia.svg" width="20px">
                Gerar Frequencias
            </a> -->
            <a href="/siiupa/?setor=adm&sub=rh&subsub=servidores_inativos" id="servidoresInativos" class="btn btn-outline-success">
                Servidores Inativos
            </a>


        </div>

        <br>
        <form class="row g-3 form-inline" style="display:none">

            <div class="form-group mb-3">
                <label for="nomefunc" class="visually-hidden">Filtrar</label>
                <input size="30" type="text" name="nomefunc" id="buscanome" placeholder="Filtrar nome" value="<?php if (isset($_GET["nome"])) {
                                                                                                                    echo $_GET['nome'];
                                                                                                                } ?>" class="form-control" style="height:35px;" />



                <?php
                $sqlcargos = "SELECT  * FROM u940659928_siupa.tb_cargo order by descricao ASC";
                $resultcargos = mysqli_query($conn, $sqlcargos);
                if (mysqli_num_rows($resultcargos) > 0) {
                    echo "<label class='floatleft'>Cargo/Função:<select id='buscafunc' name='buscafunc' class='buscafunc form-control floatleft'>
                        <option value='undefined'>TODOS</option>";
                    while ($rowcargo = mysqli_fetch_assoc($resultcargos)) {

                        if (isset($_GET["func"])) {
                            if ($_GET["func"] == $rowcargo['id']) {


                                $selected = "selected";
                            } else {

                                $selected = "";
                            }
                        } else {
                            $selected = "";
                        }




                        //echo $row['descricao'];
                ?>
                        <option value="<?php echo $rowcargo['id']; ?>" <?php echo $selected; ?>> <?php echo $rowcargo['descricao']; ?></option>



                <?php

                    }
                    echo "</select></label>";
                }
                $bdsetores = new BD;
                $sqlsetores  = "SELECT  * FROM u940659928_siupa.tb_setor GROUP BY setor ASC";
                $resultadosetores  = $bdsetores->consulta($sqlsetores);
                echo "<label>Setor:<select id='setorbusca' name='setorbusca' class='setorbusca form-control'>
        <option value='undefined'>TODOS</option>";
                foreach ($resultadosetores as $setores) {
                    if (isset($_GET["buscasetor"])) {
                        if ($_GET["buscasetor"] == $setores->setor) {


                            $selected = "selected";
                        } else {

                            $selected = "";
                        }
                    } else {
                        $selected = "";
                    }
                    echo "<option value='$setores->setor' $selected>$setores->setor </option>";
                }
                echo "</select></label>";

                ?>
            </div>
            <div class="col-auto">

                <button id="busca" class="btn btn-outline-success mb-3">Buscar</button>
            </div>
        </form>





    </div>

    <?php
    // $sql = "SELECT * FROM u940659928_siupa.tb_funcionario";
    if (($_SESSION["buscasetor"]) != "") {

        $buscasetor = $_SESSION['buscasetor'];
        if ($buscasetor == 'undefined') {
            $bsetorsql = "";
        } else {
            $bsetorsql = " AND s.setor = '$buscasetor'";
        }
    } else {
        $buscasetor = "";
        $bsetorsql = "";
    }
    if (isset($_GET["nome"])) {
        $gw = $_GET['nome'];
        $where = "WHERE f.nome LIKE '%" . $gw . "%' AND status = 'ATIVO'";
    } else {
        $where = "WHERE f.nome LIKE '%%' AND status = 'ATIVO'";
    }

    if (isset($_GET["func"])) {

        $fc = $_GET['func'];
        if ($fc == 'undefined') {
            $fcsql = "";
        } else {
            $fcsql = " AND c.id = '" . $fc . "'";
        }
    } else {
        $fc = "";
        $fcsql = "";
    }


    if (isset($_GET["orderby"])) {
        $orderby = $_GET["orderby"];
        if ($orderby == 1) {
            $tipoorder = "ASC";
        }
    } else {
        $orderby = "ORDER BY nome asc";
    }

    //paginacao
    $total_reg = "1500"; // limita limite número de registros por página

    $pagina = isset($_GET['pagina']);
    if (!$pagina) {
        $pc = "1";
    } else {

        $pc = $_GET['pagina'];
    }
    $inicio = $pc - 1;
    $inicio = $inicio * $total_reg;



    //busca u940659928_siupa.tb_funcionario
    $sqlbusca = "SELECT  DATE_FORMAT(f.data_nasc,'%d\/%m\/%Y') as data_nascbr, f.*, DATE_FORMAT(f.admissao,'%d\/%m\/%Y') as admissaoBR, f.id AS idfuncionario, c.descricao AS cargo, c.id, c.carga_horaria, c.cbo, s.setor FROM u940659928_siupa.tb_funcionario AS f INNER JOIN u940659928_siupa.tb_cargo AS c ON f.fk_cargo = c.id INNER JOIN u940659928_siupa.tb_setor AS s ON f.fk_setor = s.id $where $fcsql $bsetorsql $orderby";





    // verifica o número total de registros
    $todosResultadosBusca = mysqli_query($conn, $sqlbusca);
    $tr = $todosResultadosBusca->num_rows; // verifica o número total de registros
    $tp = $tr / $total_reg; // verifica o número total de páginas

    $resultbusca = mysqli_query($conn, "$sqlbusca  LIMIT $inicio,$total_reg");


    echo '<div class="alert alert-success" role="alert">';

    echo $tr . " resultado(s).";

    ?>
</div>


<div class=".result"></div>

<!--  IMPRIME RESULTADO-->
<div id="imprime_resultado">
    <h1>
        <?php echo $_SESSION['buscasetor']; ?>
    </h1>
    <style>
        #tabela_funcionarios_filter {
            width: 100%;
            text-align: left;
        }

        #tabela_funcionarios_filter label input,
        #tabela_funcionarios_filter label {


            width: 100%;
        }

        .teste {
            display: flex;
            margin-right: 10px;
            ;
        }

        .dataAdmissao {
            background-color: #DCE1E2;
            padding: .1rem .2rem;
            font-size: .5rem;
            border-radius: .2rem;
            color: #000;
            cursor: default;
            border-color: #0d6efd;
        }
    </style>


    <table class="table table-striped table-bordered table-hover  table-sm tablesorter" id="tabela_funcionarios">
        <thead>
            <tr>
                <!-- <th scope="col">=)</th> -->
                <!--  <th scope="col">ID</th>-->
                <th scope="col">#</th>
                <th scope="col">MATRICULA</th>

                <th scope="col">Férias</th>
                <th scope="col">NOME<img src="/siiupa/imagens/tablesorter.svg"></th>
                <th scope="col">CPF</th>
                <th scope="col">SEXO</th>
                <!-- <th scope="col">CONS.</th> -->
                <th scope="col">CARGO<img src="/siiupa/imagens/tablesorter.svg"></th>

                <th scope="col">SETOR<img src="imagens/tablesorter.svg"></th>
                <th scope="col">VINCULO<img src="/siiupa/imagens/tablesorter.svg"></th>
                <!-- <th scope="col">Férias 2022<img src="/siiupa/imagens/tablesorter.svg"></th> -->
                <th scope="col">CH</th>
                <th scope="col">Férias 2026</th>

                <!-- <th scope="col">Data Inicio</th> -->
                <!-- <th scope="col">Data Fim</th> -->

                <!-- <th scope="col">CNES<img src="/siiupa/imagens/tablesorter.svg"></th> -->

            </tr>
        </thead>
        <tbody>
            <script>
                var servidores = [];
                var servidores_freq = [];
                var conta_serv = 0;
            </script>
            <?php


            $contalinha = ($pc - 1) * 10 + 1;

            if (mysqli_num_rows($resultbusca) > 0) {
                while ($rownomes = mysqli_fetch_assoc($resultbusca)) {
                    $dados = (object) $rownomes;

                    $conta_serv = 0;
                    //from u940659928_siupa.tb_ferias
                    $queryf = "SELECT ferias.id, func.nome, c.titulo, s.setor, DATE_FORMAT(ferias.datainicio, '%d\/%m\/%Y'), DATE_FORMAT(ferias.datafim, '%d\/%m\/%Y'), ferias.ref_mes, ferias.ref_ano, func.vinculo, ferias.observacao FROM u940659928_siupa.tb_ferias AS ferias INNER JOIN u940659928_siupa.tb_funcionario AS func ON (ferias.fk_funcionario = func.id) INNER JOIN u940659928_siupa.tb_cargo AS c ON (func.fk_cargo = c.id) INNER JOIN u940659928_siupa.tb_setor AS s ON (func.fk_setor = s.id) WHERE func.status='ATIVO' AND ref_ano = 2026 AND ferias.fk_funcionario = '$dados->idfuncionario'";

                    if ($stmtf = $conn->prepare($queryf)) {
                        $stmtf->execute();
                        $stmtf->bind_result($feriasid, $nome, $funcao, $setor, $datainicio, $datafim, $ref_mes, $ref_ano, $vinculo, $observacao);
                        $conta_serv = 0;
                        while ($stmtf->fetch()) {
                            $grupomes[$ref_ano . $ref_mes][$nome] = ["feriasid" => $feriasid, "nome" => $nome, "funcao" => $funcao, "setor" => $setor, "ref_ano" => $ref_ano, "ref_mes" => $ref_mes, "datainicio" => $datainicio, "datafim" => $datafim, "vinculo" => $vinculo, "observacao" => $observacao];
                            $ref_mes = mes($ref_mes);

                            /* $tabela->tabrelinha();
                                    $tabela->tpopulalinha($nome);
                                    $tabela->tpopulalinha($funcao);
                                    $tabela->tpopulalinha($setor);
                                    $tabela->tpopulalinha($ref_ano);
                                    $tabela->tpopulalinha($ref_mes);
                                    $tabela->tpopulalinha($datainicio);
                                    $tabela->tpopulalinha($datafim);
                                    $tabela->tpopulalinha($vinculo);
                                    //$tabela->tpopulalinha($observacao);
                                    echo "<td class='editaobservacao' data-feriasid='$feriasid' data-campo='observacao'>$observacao</td>";
                                    $tabela->tfechalinha();
                                    */
                        }
                        // $stmt->close();
                    }
                    $foto_perfil = 'administracao/rh/' . $dados->idfuncionario . '/foto_perfil';
                    echo "
                    <script>
                    
                    servidores[$dados->idfuncionario]=[];                    
                    servidores[$dados->idfuncionario]['nome'] = '$dados->nome'; 
                    servidores[$dados->idfuncionario]['nomeMaiusculo'] = '$dados->nome'.toUpperCase(); 
                    servidores[$dados->idfuncionario]['data_nasc'] = '$dados->data_nascbr';
                    servidores[$dados->idfuncionario]['cpf'] = '$dados->cpf';
                    servidores[$dados->idfuncionario]['matricula'] = '$dados->matricula'; 
                    servidores[$dados->idfuncionario]['admissao'] = '$dados->admissaoBR'; 
                    servidores[$dados->idfuncionario]['cargo'] = '$dados->cargo';
                    servidores[$dados->idfuncionario]['cbo'] = '$dados->cbo';
                    servidores[$dados->idfuncionario]['carga_horaria'] = '$dados->carga_horaria';
                    servidores[$dados->idfuncionario]['conselho_tipo'] = '$dados->conselho_tipo';
                    servidores[$dados->idfuncionario]['conselho_n'] = '$dados->conselho_n';
                    servidores[$dados->idfuncionario]['vinculo'] = '$dados->vinculo';
                    servidores[$dados->idfuncionario]['setor'] = '$dados->setor';
</script>";

            ?>
                    <script>
                        conta_serv = "<?= $dados->nome ?>";
                        servidores_freq[conta_serv] = [];
                        servidores_freq[conta_serv]['nome'] = '<?= $dados->nome ?>';
                        servidores_freq[conta_serv]['data_nasc'] = '<?= $dados->data_nascbr ?>';
                        servidores_freq[conta_serv]['matricula'] = '<?= $dados->matricula ?>';
                        servidores_freq[conta_serv]['admissao'] = '<?= $dados->admissaoBR ?>';
                        servidores_freq[conta_serv]['cargo'] = '<?= $dados->cargo ?>';
                        servidores_freq[conta_serv]['vinculo'] = '<?= $dados->vinculo ?>';
                        servidores_freq[conta_serv]['setor'] = '<?= $dados->setor ?>';
                        //conta_serv++;
                    </script>
                    <?php
                    $conta_serv += 1;

                    echo "<tr>";
                    // echo "<td><a href='#' class='exibeFoto' data-foto='$foto_perfil'><img style='height:40px;' title='Foto perfil' alt='Sem foto'     src='/siiupa/$foto_perfil' class='rounded-circle img-thumbnail  float-left'></img></a></td>";
                    // echo "<th scope='row'><a class='abreperfil' href='?setor=adm&sub=rh&subsub=perfil&id=$dados->idfuncionario'>$dados->idfuncionario</a></th>";

                    //CONTA LINHA
                    //echo "<td>$contalinha</td>";
                    echo "<td></td>";
                    echo "<td id='matriculaFunc_$dados->idfuncionario'><span class='matriculaFunc' data-id='$dados->idfuncionario'>$dados->matricula</span><i><span class='ui-icon ui-icon-copy copiarTexto' data-text='$dados->matricula'></span></i></td>";




                    //BUTTON VACATIONS
                    echo "<td><button class='btn btn-success' onclick='abrirModalFerias($dados->idfuncionario)'>Férias</button></td>";

                    //LINE NAME
                    $token = $_SESSION['token'];
                    echo "<td>    <a target='_blank' class='abreperfil'  rel='noreferrer noopener' href='?setor=adm&sub=rh&subsub=perfil&id=$dados->idfuncionario&token=$token'>$dados->nome</a><i><span class='ui-icon ui-icon-copy copiarTexto' data-text='$dados->nome'></i></span><i><span class='ui-icon ui-icon-copy copiarCNES' data-text='$dados->idfuncionario'></span></i></td>";

                    //LINK TO CNES
                    //<a href='/siiupa/administracao/apicnes.php?id=$dados->idfuncionario' target='_blank'>CNES</a>
                    //LINK TO ELECTION DOCUMENT
                    //<a class='eleicaobtn-link' target='_blank' href='https://siupa.com.br/siiupa/administracao/pagina_rh_eleicao2022.php?nome=$dados->nome&cargo=$dados->cargo&cpf=$dados->cpf'>Eleição</a> 

                    //LINE BIRTH
                    //                    echo "<td>$dados->data_nascbr</td>";

                    //COLUMN WITH DOC CPF
                    echo "<td id='cpf_$dados->idfuncionario'></td>";
                    ?>
                    <script>
                        document.getElementById('cpf_<?= $dados->idfuncionario ?>').innerHTML = '<?= $dados->cpf ?>'.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    </script>


            <?php
                    //COL WITH GENDER
                    $dados_sexo = "";
                    if ($dados->sexo == "F") {
                        $dados_sexo = "FEMININO";
                    } else {
                        $dados_sexo = "MASCULINO";
                    }
                    echo "<td>$dados_sexo</td>";
                    // echo "<td>$dados->conselho_n</td>";
                    echo "<td><!-- $dados->fk_cargo -->$dados->cargo <i><span class='ui-icon ui-icon-copy copiarTexto' data-text='$dados->cargo'></span></i></td>";


                    echo "<td>$dados->setor</td>";
                    if ($dados->vinculo == "EFETIVO") {
                        $dataAdmissao = "<span class='dataAdmissao'>$dados->admissaoBR</span>";
                    } else {
                        $dataAdmissao = "";
                    }
                    echo "<td>$dados->vinculo <i><span class='ui-icon ui-icon-copy copiarTexto' data-text='$dados->vinculo'></span></i> </td>";
                    echo "<td>$dados->carga_horaria</td>";

                    //COLS VACATIONS
                    echo "<td> $dataAdmissao </br>";
                    $ferias23 = new BD;
                    $sqlF23 = "SELECT * FROM u940659928_siupa.tb_ferias where fk_funcionario = '$dados->idfuncionario' and ref_ano = '2026' ORDER BY ref_mes ASC;";
                    $rF23 = $ferias23->consulta($sqlF23);
                    $meses = [];
                    foreach ($rF23 as $ferias23) {
                        $meses[] = mes($ferias23->ref_mes);
                    }
                    echo implode('/', $meses);

                    echo "</td>";



                    // echo "<td class='edita' data-idfunc='$dados->idfuncionario' data-campo='CNES' data-valor='$dados->CNES'>$dados->CNES</td>";


                    // echo "<td>$dados->CNES</td>";


                    echo "</tr>";
                    $contalinha++;
                }
            } else {
                echo "0 results";
            }

            mysqli_close($conn);

            ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('.copiarTexto').click(function() {
                const textToCopy = $(this).attr('data-text');
                const tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(textToCopy).select();
                document.execCommand('copy');
                tempInput.remove();

                $(this).notify("Texto copiado: " + textToCopy, "success");
            });

            $('.copiarCNES').click(function() {
                const idFunc = $(this).attr('data-text');
                copiarParaCNES(
                    servidores[idFunc]['nomeMaiusculo'],
                    formatarCPF(servidores[idFunc]['cpf']),
                    servidores[idFunc]['conselho_tipo'] + ' ' +
                    servidores[idFunc]['conselho_n'],
                    servidores[idFunc]['cbo'],
                    servidores[idFunc]['carga_horaria'],
                    servidores[idFunc]['vinculo']);

                $(this).notify("Texto copiado para ser colado na planilha do CNES", "success");
            });
        });
    </script>
    <?php
    $queryString = filter_input(INPUT_SERVER, 'QUERY_STRING');

    $anterior = $pc - 1;
    $proximo = $pc + 1;
    //substitui a pagina na queryString

    $queryString = str_replace("&pagina=$pc", "", $queryString);



    if ($pc >= 1) {
        echo " <a href='?$queryString&pagina=$anterior' class='btn btn-secondary btn-sm'><<</a> ";
    }

    if ($tp > 1) {


        //NUMERAÇÕES DA PÁGINA


        for ($i = 1; $i <= ceil($tp); $i++) {

            if ($pc == $i) {
                $botaoPaginas = "btn-info";
            } else {
                $botaoPaginas = "btn-secondary";
            }
            echo "<a href='?$queryString&pagina=$i' class='btn $botaoPaginas btn-sm'>$i</a> ";
        }
    }

    //PROXIMA

    if ($pc < $tp) {
        echo " <a href='?$queryString&pagina=$proximo' class='btn btn-secondary btn-sm'>>></a>";
    }
    ?>
    <table class="table table-bordered table-striped table-sm" style="border-color:#000;display:none;">
        <tbody>
            <tr>
                <td>Janeiro<br><br><br></td>
                <td>Fevereiro<br><br><br></td>
                <td>Março<br><br><br></td>
                <td>Abril<br><br><br></td>
            </tr>
            <tr>
                <td>Maio<br><br><br></td>
                <td>Junho<br><br><br></td>
                <td>Julho<br><br><br></td>
                <td>Agosto<br><br><br></td>
            </tr>
            <tr>
                <td>Setembro<br><br><br></td>
                <td>Outubro<br><br><br></td>
                <td>Novembro<br><br><br></td>
                <td>Dezembro<br><br><br></td>
            </tr>

        </tbody>
    </table>

</div><!-- FIM DA AREA DE IMPRESSAO -->
<div class="contagem_cargos">
    <?php
    $bdContagemCargos = new BD;
    $sqlCG = "SELECT c.titulo, count(c.titulo) as total, c.id FROM u940659928_siupa.tb_funcionario as f inner join u940659928_siupa.tb_cargo AS c on (f.fk_cargo = c.id) where status='ATIVO' group by c.titulo";
    $rConsultaCargos = $bdContagemCargos->consulta($sqlCG);
    foreach ($rConsultaCargos as $rCG) {
        $tituloCG = $rCG->titulo;
        echo "<a class='contagem_cargo btn btn-sm btn-light' href='/siiupa/?setor=adm&sub=rh&busca=1&nome=&func=$rCG->id&buscasetor=undefined'>$tituloCG: $rCG->total</a>";
    }

    $bdContagemSetores = new BD;
    $sqlCS = "SELECT s.id, s.setor, count(s.setor) as totalS FROM u940659928_siupa.tb_funcionario as f inner join u940659928_siupa.tb_setor as s on(f.fk_setor = s.id) where status='ATIVO' group by s.setor;";
    $rConsultaSetores = $bdContagemSetores->consulta($sqlCS);
    foreach ($rConsultaSetores as $rCS) {
        $tituloCS = $rCS->setor;
        echo "<a class='contagem_cargo btn btn-sm btn-success' href='/siiupa/?setor=adm&sub=rh&busca=1&nome=&func=undefined&buscasetor=$tituloCS'>$tituloCS: $rCS->totalS</a>";
    }

    ?>
</div>
<select id="setor-select">
    <option value="">Selecione um setor</option>
    <option value="Enfermagem - Enfermeiros(as)">Enfermagem - Enfermeiros(as)</option>
    <option value="Enfermagem - Tec. de Enfermagem">Enfermagem - Tec. de Enfermagem</option>
    <!-- Adicione outros setores aqui -->
</select>
<button id="gerar-frequencias">Gerar Frequências</button>

<div id="frequencias-container"></div>
<script>
    // Função para gerar frequências por setor
    function gerarFrequenciasPorSetor(setorEscolhido) {
        const container = document.getElementById("frequencias-container");
        container.innerHTML = ""; // Limpar frequências anteriores

        // Filtrar os servidores pelo setor escolhido
        const servidoresDoSetor = Object.values(servidores_freq).filter(
            (servidor) => servidor.setor === setorEscolhido
        );

        if (servidoresDoSetor.length === 0) {
            container.innerHTML = "<p>Nenhum servidor encontrado para o setor selecionado.</p>";
            return;
        }

        // Carregar as frequências via AJAX
        servidoresDoSetor.forEach((servidor) => {
            const dados = {
                nome: servidor.nome,
                cargo: servidor.cargo,
                vinculo: servidor.vinculo,
                mes: 1, // Mês fixo para este exemplo
            };

            // Fazer a requisição AJAX para obter a frequência
            fetch("https://siupa.com.br/siiupa/mpdf/modelo/frequenciapdf.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams(dados).toString(),
                })
                .then((response) => {
                    if (!response.ok) throw new Error("Erro ao carregar a frequência.");
                    return response.text();
                })
                .then((html) => {
                    // Criar um novo elemento de página para exibir a frequência
                    const page = document.createElement("div");
                    page.style.marginBottom = "20px";
                    page.style.padding = "20px";
                    page.style.border = "1px solid #ddd";
                    page.innerHTML = html; // Inserir o HTML retornado no container

                    container.appendChild(page);
                })
                .catch((error) => {
                    console.error("Erro ao carregar a frequência:", error);
                });
        });
    }

    // Evento para o botão "Gerar Frequências"
    document.getElementById("gerar-frequencias").addEventListener("click", () => {
        const setorSelecionado = document.getElementById("setor-select").value;

        if (!setorSelecionado) {
            alert("Por favor, selecione um setor!");
            return;
        }

        gerarFrequenciasPorSetor(setorSelecionado);
    });
</script>
</div>
</div>

<!-- Dialog Ferias CC -->
<div class="modal fade" id="modalFerias" tabindex="-1" aria-labelledby="modalFeriasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Férias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <iframe id="iframeFerias" style="width: 100%; height: 100vh; border: none;backgroun-color:#000" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script>
    function abrirModalFerias(idFuncionario) {
        const token = '<?= $token; ?>'; // Usa o token gerado no PHP
        const iframe = document.getElementById('iframeFerias');
        const modal = new bootstrap.Modal(document.getElementById('modalFerias'));

        iframe.src = `https://ferias-siupa.vercel.app/funcionario/${idFuncionario}?token=${token}`;
        modal.show();
    }
</script>


<!-- fim Dialog Contracheque CC -->
<div id="dialogFotoPerfil"></div>
<?php
$idunico = uniqid();
?>

<script type="text/javascript" src="/siiupa/js/tablesorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="/siiupa/administracao/pagina_rh_home.js"></script>
<script>
    $(".matriculaFunc").dblclick(function(e) {
        let span = $(this);
        let idF = span.data('id');
        let td = $(`#matriculaFunc_${idF}`);


        let matAnt = span.text();
        console.log(matAnt);
        let input = `<input type='text' value='${matAnt}' id='inpEditaMat_${idF}'><button id='btEditaMat_${idF}'>OK</button>`;

        td.html(input);

        let inputEdita = $(`#inpEditaMat_${idF}`);
        console.log(`#inpEditaMat_${idF}`);

        $(`#btEditaMat_${idF}`).click(function(e) {
            let valorInput = inputEdita.val();
            dataPost = {
                'banco': 'u940659928_siupa',
                'tabela': 'tb_funcionario',
                'camposValores': `{"matricula":"${valorInput}"}`,
                'id': `${idF}`
            };
            $.post('/siiupa/administracao/editabd_json.php', dataPost)
                .done(function(data) {
                    td.html(`<span class='matriculaFunc' data-id='${idF}'>${data}</span>`);
                });


        });




    })


    function formatarCPF(cpf) {
        // Remove caracteres não numéricos
        cpf = cpf.replace(/\D/g, "");

        // Verifica o tamanho
        if (cpf.length !== 11) {
            return "CPF inválido"; // Ou retorne o valor original, dependendo do caso de uso
        }

        // Aplica a formatação
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    }

    function aplicarMascaraCPF(input) {
        let cpf = input.value;
        cpf = formatarCPF(cpf);
        input.value = cpf;

        // Adiciona/remove classe de erro visualmente, se necessário
        if (cpf === "CPF inválido") {
            input.classList.add("cpf-invalido"); // Adicione a classe de erro
        } else {
            input.classList.remove("cpf-invalido"); // Remove a classe de erro
        }
    }

    function copiarParaCNES(...itens) {
        // Junta os itens com tabulações (\t), que o Excel entende como separador de colunas
        const texto = itens.join('\t');

        // Cria uma área de transferência temporária
        const textarea = document.createElement('textarea');
        textarea.value = texto;
        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy');
            //alert('Copiado com sucesso! Cole no Excel (Ctrl+V).');
        } catch (err) {
            console.error('Erro ao copiar: ', err);
        }

        document.body.removeChild(textarea);
    }
</script>
<?php
function mes($entrada)
{
    switch ($entrada) {
        case 1:
            return "Janeiro";
        case 2:
            return "Fevereiro";
        case 3:
            return "Março";
        case 4:
            return "Abril";
        case 5:
            return "Maio";
        case 6:
            return "Junho";
        case 7:
            return "Julho";
        case 8:
            return "Agosto";
        case 9:
            return "Setembro";
        case 10:
            return "Outubro";
        case 11:
            return "Novembro";
        case 12:
            return "Dezembro";
    }
    return $entrada;
}


function formatarCPF(string $cpf)
{
    // Remove qualquer caractere que não seja número
    $cpf = preg_replace('/\D/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos (após a limpeza)
    if (strlen($cpf) != 11) {
        return "CPF inválido (número de dígitos incorreto)."; // Ou lançar uma exceção, dependendo da sua necessidade
    }

    // Formata o CPF usando sprintf
    return sprintf(
        '%s.%s.%s-%s',
        substr($cpf, 0, 3),
        substr($cpf, 3, 3),
        substr($cpf, 6, 3),
        substr($cpf, 9, 2)
    );
}

?>