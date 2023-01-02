
conteudo = $("#subsubconteudo");
conteudo.html('Adicionar item');
$(document).ready(function() {
    $('.js-example-basic-single').select2();
    var opcoes = $("#myselect");
    
    $( "#myselect").change(()=>{
        let nome = opcoes.find(':selected').data('nome')
        conteudo.append(`<div><strong>${nome}</strong><div>Marca: <input type="text" placeholder="Digite a Marca"></div>Lote: <input type="text" placeholder="Digite o lote"></div></div><hr>`);
    });
    
});