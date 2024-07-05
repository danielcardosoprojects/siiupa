<script type="text/javascript" src="/siiupa/js/script.js"></script>
<script>
    $(function() {
        $('.dropdown-toggle').dropdown();
        $('#buscanome').focus();

        $('.noticias_linha').hide();

        $('.copiarTexto').click(function(e) {
            e.preventDefault();
            copyText = $(this).attr('data-text');

            //navigator.clipboard.writeText(copyText);
            function copyToClipboard(textToCopy) {
                // navigator clipboard api needs a secure context (https)
                if (navigator.clipboard && window.isSecureContext) {
                    // navigator clipboard api method'
                    return navigator.clipboard.writeText(textToCopy);
                } else {
                    // text area method
                    let textArea = document.createElement("textarea");
                    textArea.value = textToCopy;
                    // make the textarea out of viewport
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    textArea.style.top = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    return new Promise((res, rej) => {
                        // here the magic happens
                        document.execCommand('copy') ? res() : rej();
                        textArea.remove();
                    });
                }
            }
            copyToClipboard(copyText);

        });




        $("#bcadastrarFUNCIONARIO").click(function() {
            $('#subconteudo').load($(this).attr('href'));
        });

        $(".abreperfil").click(function() {
            sessionStorage.setItem('linkanterior', $(this).attr('href'));
            $('#subconteudo').load($(this).attr('href'));


        });


        $("#busca").click(function() {
            // $('#subconteudo').load($(this).attr('href'));

            var buscanome = encodeURI($('#buscanome').val());
            var buscafunc = $('#buscafunc').val();

            var buscasetor = encodeURI($('#setorbusca').val());

            var linkh = '?setor=adm&sub=rh&busca=1&nome=' + buscanome + '&func=' + buscafunc + '&buscasetor=' + buscasetor;
            var link = 'administracao/paginarh.php?busca=1&nome=' + buscanome + '&func=' + buscafunc + '&buscasetor=' + buscasetor;

            $('body').load(linkh, function() {
                window.history.pushState('page2', 'Title', linkh);

                sessionStorage.setItem('linkanterior', linkh);
            });



            // $("#buscanome").val('buscanome');

        });

    });
</script>
<style>
    @import url('/siiupa/css/font_MontSerrat.css');

    .floatleft {
        float: left;
    }


    .bg-grey {
        background-color: lightgrey !important;
    }

    #bFerias {
        background-color: #000;
        color: #fff;
    }

    #bFerias img {
        background-color: #fff;
    }

    #bFolhas {
        background-color: #139b70;
        color: #fff;
    }

    .bg-verdeClaro {
        background-color: #49c978 !important;
    }

    .noticias p {
        font-weight: bold;

    }

    .noticias {
        font-family: 'Josefin Sans', sans-serif;
        border-collapse: separate;
        border-radius: 10px;
        border-spacing: 8px 8px;
        font-size: 12px;
        display: none;

    }

    .lei {
        font-family: 'Josefin Sans', sans-serif;
        border-collapse: separate;
        border-radius: 10px;
        border-spacing: 8px 8px;
        font-size: 12px;


    }

    .bg-noticias {
        background-color: #C70039 !important;
        color: #fff;
        font-weight: bold;

    }

    .noticias_linha {
        font-weight: normal;
    }

    .noticias td {
        background-color: white;
        border-radius: 10px;
        padding: 5px;
        text-align: center;
    }

    .box_cima_branco {
        color: #fff;
        font-family: 'Josefin Sans', sans-serif;

        margin-top: 10px;
    }

    .box_cima_preto {
        color: #000;
        font-family: 'Josefin Sans', sans-serif;
        margin-top: 10px;
    }

    .dropdown {
        float: right;
        margin-left: 5px;
    }

    .bt_menu_rh {
        border-radius: 20rem;
    }
</style>

<div style="text-align:left;">

    <h1 text-color="#fff" style="float:left" id="tituloRH">Recursos Humanos
        <small><a href="administracao/leimunicipal003991999.pdf" target="_blank" class="lei">LEI MUNICIPAL Nº 003/99 <img width="20px" src="/siiupa/imagens/icones/pdf.svg"></a></small>
        <small><a href="https://transparencia.layoutsistemas.com.br/servidores/resumo?codigo_entidade=441402" target="_blank" class="lei">Transparência Saúde <img width="20px" src="/siiupa/imagens/icones/layoutonline.png"></a></small>
        <small><a href="https://sites.google.com/castanhal.pa.gov.br/diariooficialdecastanhal/inicio" target="_blank" class="lei">Diário Oficial <img width="20px" src="/siiupa/imagens/icones/diario.jpg"></a></small>
        <small><a href="http://cnes2.datasus.gov.br/Exibe_Ficha_Estabelecimento.asp?VCo_Unidade=1502407474423&VListar=1&VEstado=15&VMun=150240" target="_blank" class="lei">Site do CNES<img width="20px" src="/siiupa/imagens/icones/diario.jpg"></a></small>
    </h1>
    <script>
        var dataToken = sessionStorage.getItem("token");
        //$("#tituloRH").text(dataToken);
    </script>
    <div class="noticias_linha">
        <?php
        $dtz = new DateTimeZone("America/Belem");
        $mesatual = date('n');
        $anoatual = date('Y');
        $diaatual = date('d');
        $dataatual = new DateTime("", $dtz);


        $query = "SELECT af.id, af.fk_funcionario, af.fk_afastamentos, f.nome, afs.afastamento, month(af.data_inicio), month(af.data_fim), af.data_fim FROM u940659928_siupa.tb_afastamento as af inner join u940659928_siupa.tb_funcionario as f on (af.fk_funcionario = f.id) inner join u940659928_siupa.tb_afastamentos as afs on (af.fk_afastamentos = afs.id) where (year(af.data_inicio) = '$anoatual' OR year(af.data_fim) = '$anoatual') AND (month(data_inicio) = $mesatual OR month(data_fim) = $mesatual)";

        $atestado_ativo = 0;
        $atestado_novo = 0;
        $faltas = 0;

        if ($stmt = $conn->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($field1, $fk_funcionario, $fk_afastamento, $nome, $afastamento, $mes_inicio, $mes_fim, $data_fim);
            while ($stmt->fetch()) {

                $data_fim = new DateTime($data_fim, $dtz);

                switch ($afastamento) {
                    case "Atestado":
                        if ($data_fim->format('Y-m-d') >= $dataatual->format('Y-m-d')) {
                            $atestado_ativo += 1;
                        }
                        if ($mes_inicio == $mesatual) {
                            $atestado_novo += 1;
                        }
                        break;
                    case "Falta":
                        $faltas += 1;
                        break;
                }
            }
            $stmt->close();
        }

        ?>
        <table class="noticias">
            <tbody>
                <tr>

                    <td class="bg-noticias">NOTÍCIAS<br>JULHO/2022</td>
                    <td class="bg-success box_cima_branco">ATESTADOS<br>Ativo(s): <?php echo $atestado_ativo; ?> | Novo(s): <?php echo $atestado_novo; ?></a></td>
                    <td class="bg-danger box_cima_branco">FALTAS: <?php echo $faltas; ?></td>
                    <td class="bg-warning box_cima_preto">BENEFÍCIOS<br>ativos: 1 | novos: 1</td>
                    <td class="bg-info box_cima_preto">ROTATIVIDADE: 7</td>
                    <td class="bg-secondary box_cima_branco">ACIONAMENTOS: 12 - R$ 36.320,00</td>
                </tr>
            </tbody>

        </table>
    </div>
    <div style="clear:both">
    </div>
    <nav class="navbar navbar-light" style="background-color: #e3f2fd;">

        <div class="">
            <a href="?setor=adm&sub=rh" id="bcadastrarFUNCIONARIO" class="btn btn-success btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/people.svg">
                SERVIDORES</a>
            <a href="?setor=adm&sub=rh&subsub=escalas" id="bEscalas" class="btn btn-info btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/calendario.svg" width="20">
                Escalas</a>


            <a href="?setor=adm&sub=rh&subsub=folhas" id="bFolhas" class="btn btn-info btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/folha.svg" width="20">
                Folhas</a>
            <a href="?setor=adm&sub=rh&subsub=atestados" id="bAtestados" class="btn btn-warning btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/doente2.svg" width="20">
                Afastamentos</a>


            <a href="?setor=adm&sub=rh&subsub=acionamentos" id="bAcionamentos" class="btn bg-verdeClaro btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/dinheiro2.svg" width="25">
                Acionamentos</a>

            <a href="?setor=adm&sub=rh&subsub=ferias" id="bFerias" class="btn btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/ferias3.svg" width="20">
                Férias</a>



            <a href="?setor=adm&sub=rh&subsub=alimentacao" id="bAlimentacao" class="btn btn-sm">
                <img src="/siiupa/imagens/icones/restaurant.svg">
                Lista de Alimentação</a>

            <a href="?setor=adm&sub=rh&subsub=listaepi" id="bListaEpi" class="">
                <img src="/siiupa/imagens/icones/mascara.svg" width="36px">
                Lista de EPI</a>





        </div>





    </nav>




    <div id="subsubconteudo">

        <?php
        function console_log($data)
        {
            echo '<script>';
            echo 'console.log(' . json_encode($data) . ')';
            echo '</script>';
        }






        function pega($entrada)
        {
            if (isset($_GET[$entrada])) {
                return $_GET[$entrada];
            }
            return null;
        }



        $subsub = pega('subsub');
        // console_log($subsub); // [1,2,3]favicon

        switch ($subsub) {
            case null:
                echo "<script>$(document).ready(function() {loadPage('pagina_rh_home');});</script>";
                break;
            case 'perfil':
                include_once('pagina_rh_perfil.php');
                break;
            case 'servidores_inativos':
                include_once('servidores_inativos.php');
                break;
            case 'ferias':
                include_once('pagina_rh_ferias.php');
                break;
            case 'folhas':
                include_once('pagina_rh_folhas.php');
                break;
            case 'escalas':
                include_once('pagina_rh_escalas.php');
                break;
            case 'listaepi':
                include_once('pagina_rh_farmacia_epi.php');
                break;
            case 'alimentacao':
                include_once('pagina_rh_alimentacao.php');
                break;
            case 'atestados':
                echo "<script>$(document).ready(function() {loadPage('pagina_rh_atestados');});</script>";
                break;
            case 'afastamentos':
                echo "<script>$(document).ready(function() {loadPage('pagina_rh_afastamento');});</script>";
                break;
            case 'acionamentos':
                echo "<script>$(document).ready(function() {loadPage('pagina_rh_acionamentos');});</script>";
                break;
            case 'acionamento_exibe':
                include_once('pagina_rh_acionamento_exibe.php');
                break;
            case 'atestado_exibe':
                include_once('pagina_rh_atestados_exibe.php');
                break;
            case 'perfil_criar':
                include_once('pagina_rh_perfil_criar.php');
                break;
            case 'rhfolhas':
                include_once('pagina_rh_folhas.php');
                break;
            case 'rhfolhasmodifica':
                include_once('pagina_rh_folhas_criareditar.php');
                break;
            case 'rhfolhaexibe':
                include_once('pagina_rh_folha.php');
                break;
            case 'rhfolhaadicionaservidor':
                include_once('pagina_rh_folha_adicionaservidor.php');
                break;
            case 'rhcadastraferias':
                include_once('pagina_rh_cadastraferias.php');
                break;
            default:
                echo "<script>$(document).ready(function() {loadPage('pagina_rh_home');});</script>";
                break;
        }

        ?>
    </div>

</div>
</div>
<script>
    async function loadPage(page) {

        $('#subsubconteudo').load(`/siiupa/administracao/${page}.php`);



    }
</script>