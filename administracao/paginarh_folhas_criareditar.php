<?php

@include("../bd/conectabd.php"); ?>
<script type="text/javascript" src="./js/script.js"></script>
<script>
    $(function() {
        $("#btenviar").click(function() {
            alert();

            function dataUS_BR(entrada) {
                var data = new Date();
                data = entrada;
                var dia = data.getDate().toString().padStart(2, '0'),
                    mes = (data.getMonth() + 1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
                    ano = data.getFullYear();
                return dia + "/" + mes + "/" + ano;
            }

            function dataBR_US(entrada) {
                var data = entrada;
                var dataFormatada = data.replace(/(\d*)\/(\d*)\/(\d*).*/, '$3-$2-$1');
                return dataFormatada;


            }
            //           ;

            // $('#subconteudo').load($(this).attr('href'));

            var id = $('#id').val();
            var ref_mes = $('#ref_mes').val();
            var ref_ano = $('#ref_ano').val();
            var periodoinicio = dataBR_US($('#periodoinicio').val());
            var periodofim = dataBR_US($('#periodofim').val());
            if(id==""){
                var acao = "criar";
            } else {
                var acao = "modifica";
            }




            var link = '?setor=adm&sub=rhfolhasmodifica&acao='+acao+'&id='+id+'&mes='+ref_mes+'&ano='+ref_ano+'&periodoinicio='+periodoinicio+'&periodofim='+periodofim;
            window.location.replace(link);
            //var link2 = '?setor=adm&sub=rhperfil&id='+id;
            // window.history.pushState('page2', 'Title', linkh);
            console.log(link);
            //sessionStorage.setItem('linkanterior', link);
            //$('#subconteudo').load(link);
            // window.location.replace(link2);


            // $("#buscanome").val() = buscanome;

        });
    });
</script>
<?php

if(isset($_GET['acao'])){
    $acao = $_GET['acao'];
    if($acao = 'criar'){
        
        $ref_mes=$_GET['mes'];
        $ref_ano=$_GET['ano'];
        $periodoinicio=$_GET['periodoinicio'];
        $periodofim=$_GET['periodofim'];

        $query = "INSERT INTO db_rh.tb_folhas (ref_mes, ref_ano, periodoinicio, periodofim) VALUES ('$ref_mes', '$ref_ano', '$periodoinicio', '$periodofim')";
        if (mysqli_query($conn, $query)) {
            $last_id = mysqli_insert_id($conn);
            echo "New record created successfully. Last inserted ID is: " . $last_id;
            print("<script>alert('Sucesso!');
        var link2 = '?setor=adm&sub=rhfolhas';
        window.location.replace(link2);
        </script>");
        } else {
            echo "Opa! Algo deu errado! \n Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }




} else{


?>

<h1>Criar folha</h1>
<form action="?setor=adm&sub=rhfolhasmodifica&acao=cria" method="POST">
    ID:<div name="id" id="id"></div></br>
    <label>Mês de Referência<input type="text" name="ref_mes" id="ref_mes"></label>
    </br>
    <label>Ano de Referência<input type="text" name="ref_ano" id="ref_ano"></label>
    </br>
    </br>
    <label>Período: Início<input type="text" name="periodoinicio" id="periodoinicio"></label>
    </br>
    <label>Período: Fim<input type="text" name="periodofim" id="periodofim"></label>
    </br>
    <input type="submit" value="Criar" class="btn btn-success" id="btenviar">

</form>
<div class="d-flex">
    <a href="?setor=adm&sub=rhfolhas" id="bcancela" class="btn btn-danger">
        <i><span class="material-icons">close</span></i>
        Cancelar</a>
</div>
<?php
}
?>