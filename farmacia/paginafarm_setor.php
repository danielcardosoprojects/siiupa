<?php

include_once("../bd/conectabd.php");

?>
 <a href="/siiupa/farmacia/setor/novo" onclick='setorCarrega(this, event)' id="novoSetor" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px"> Cadastrar novo setor</a>
    <br>

    <?php

$query = "SELECT * FROM u940659928_siupa.tb_farmsetor";


if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id, $setor, $criadoem);
    echo "<table class='table'>";
    echo "<thead><th>Setor</th><th>Ação</th></thead>";
    echo "<tbody>";
    while ($stmt->fetch()) {
        echo "<tr>";
        echo "<td>$id - $setor</td>";
        echo "<td><a href='/siiupa/farmacia/setor/novo' data-id='$id' data-setor='$setor' onclick='editaSetor(this, event)'>Editar</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    $stmt->close();
}
?>
<script>
    function editaSetor(botao, e) {
        e.preventDefault();
        console.log($(botao).attr('href'));
        dados = {
            link: $(botao).attr('href'),
            id: $(botao).data('id'),
            setor: $(botao).data('setor'),
        }
        $.post(dados.link, {id: dados.id, setor: dados.setor, acao: "editasetor"},function(data){
            $("#dialogSetor").html(data);
        });
    }
</script>