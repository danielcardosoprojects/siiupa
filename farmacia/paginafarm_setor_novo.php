<?php
if(isset($_POST['setor'])){
    $setor = $_POST['setor'];
    $acao = 'edita';
    $idsetor = $_POST['id'];
    $funcao = "setorEdita";
    $textoBotao = "Atualizar setor";


}else {

    $setor = '';
    $acao = 'novo';
    $idsetor = '';
    $funcao = "setorCadastra";
    $textoBotao = "Cadastrar novo setor";
}
?>
<h4><?=$acao;?> setor ou entidade</h4>
<input type="hidden" id="idsetor" value="<?=$idsetor;?>"><br>
<input type="text" id="setor" value="<?=$setor;?>"><br>
<br>
<a href="/siiupa/farmacia/setor/registra/<?=$acao;?>" onclick='<?=$funcao;?>(this, event)' id="novoSetor" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/remedio.svg" height="20px"><?=$textoBotao;?></a>


<script>
function setorCadastra(botao, e) {    
    e.preventDefault();
    dados = {
        link: $(botao).attr('href'),
        nome: $("#setor").val(),
        janela: $("#dialogSetor"),
    }
    if(dados.nome == ""){
        $.alert("O campo não pode estar vazio.");
        return;
    }
    $.post(dados.link, {setor: dados.nome}, function(data){
        dados.janela.html(data);
    });

}
function setorEdita(botao, e) {    
    e.preventDefault();
    dados = {
        link: $(botao).attr('href'),
        nome: $("#setor").val(),
        id: $("#idsetor").val(),
        janela: $("#dialogSetor"),
    }
    if(dados.nome == ""){
        $.alert("O campo não pode estar vazio.");
        return;
    }
    $.post(dados.link, {id: dados.id, setor: dados.nome}, function(data){
        dados.janela.html(data);
    });

}
</script>
