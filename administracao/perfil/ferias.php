<?php

class ferias
{

}

$ferias = new ferias;
$ferias->idServidor = $_GET['id'];

$query = "SELECT DATE_FORMAT(datainicio, '%d\/%m\/%Y'), DATE_FORMAT(datafim, '%d\/%m\/%Y'), ref_mes, ref_ano, observacao, id FROM db_rh.tb_ferias WHERE fk_funcionario = $ferias->idServidor";
            echo '
<table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">ANO</th>
            <th scope="col">MÊS</th>
            <th scope="col">INÍCIO</th>
            <th scope="col">TÉRMINO</th>
            <th scope="col">OBSERVAÇÃO</th>
            <th scope="col">Excluir</th>
            
          </tr>
        </thead>
        <tbody>
        ';
            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();
                $stmt->bind_result($datainicio, $datafim, $ref_mes, $ref_ano, $observacao, $idferias);
                while ($stmt->fetch()) {
                    printf('
        
        <tr>
        <th scope="row">%s</th>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td><a class="deletaFerias" data-idferias="%s" data-idservidor="%s" href="#boxFerias"><img src="/siiupa/imagens/icones/lixeira.svg" width="30px"></a></td>


      </tr>', $ref_ano, $ref_mes, $datainicio, $datafim, $observacao, $idferias, $ferias->idServidor);
                }
                $stmt->close();
            }
            echo '</tbody>
</table>';

?>
<script>
    $(".deletaFerias").click(function(e){
        e.preventDefault();
       
        
        idFerias = $(this).data('idferias');
        idServidor = $(this).data('idservidor');
        deletaFerias = "administracao/paginarh_cadastraferias.php?acao=deleta&idferias="+idFerias+"&id="+idServidor;
       $('#boxFerias').load(deletaFerias);

            
    });
    
</script>