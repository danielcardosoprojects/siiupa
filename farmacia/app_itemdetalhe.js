$(".editaValidade").click((e) => {
    e.preventDefault();
 
    let link = $(e.currentTarget);
    let idLote = $(e.currentTarget).data('idlote');
    let celula = $(`#val_${idLote}`);
    let spanVal = $(`#val_${idLote} span`);    
    let valAnt = $(`#val_${idLote} span`).html();
    let dataAnt = valAnt.split("/");
    spanVal.html(`<input type='date' id='val_${idLote}_novo' value='${dataAnt[2]}-${dataAnt[1]}-${dataAnt[0]}'>`);
    $(`#val_${idLote}_novo`).focus();
    $(link).hide();
    $(celula).append(`<a href='#' id='salvaValidade_${idLote}'><img src='/siiupa/imagens/icones/done.svg'></a>`);
    
    $(`#salvaValidade_${idLote}`).click((e)=>{
        e.preventDefault();
        dataNov = $(`#val_${idLote}_novo`).val();
        let linkAtt = `/siiupa/farmacia/item/atualiza-lote/`;
        $.post(linkAtt, {acao: 'atualizaloteval',idlote: idLote, datavalidade: dataNov}, (data)=>{
            puxaData = data.split("-");
           spanVal.html(`${puxaData[2]}/${puxaData[1]}/${puxaData[0]}`);
           $(`#salvaValidade_${idLote}`).remove();
           $(link).show();
        });
    });

});

$(".editaLote").click((e) => {
    e.preventDefault();
 
    let link = $(e.currentTarget);
    let idLote = $(e.currentTarget).data('idlote');
    let celula = $(`#lote_${idLote}`);
    let spanVal = $(`#lote_${idLote} span`);    
    let valAnt = $(`#lote_${idLote} span`).html();
    
    spanVal.html(`<input type='text' id='lote_${idLote}_novo' value='${valAnt}'>`);
    $(`#lote_${idLote}_novo`).focus();
    $(link).hide();
    $(celula).append(`<a href='#' id='salvaLote_${idLote}'><img src='/siiupa/imagens/icones/done.svg'></a>`);
    
    $(`#salvaLote_${idLote}`).click((e)=>{
        e.preventDefault();
        loteNov = $(`#lote_${idLote}_novo`).val();
        let linkAtt = `/siiupa/farmacia/item/atualiza-lote/`;
        $.post(linkAtt, {acao: 'atualizalotenome',idlote: idLote, nomelote: loteNov}, (data)=>{
            
           spanVal.html(data);
           $(`#salvaLote_${idLote}`).remove();
           $(link).show();
        });
    });

});

$(".editaBarcode").click((e) => {
    e.preventDefault();
    
    let link = $(e.currentTarget);
    let idLote = $(e.currentTarget).data('idlote');
    let celula = $(`#barcode_${idLote}`);
    let spanVal = $(`#barcode_${idLote} span`);    
    let valAnt = $(`#barcode_${idLote} span`).html();
    
    spanVal.html(`<input type='text' id='barcode_${idLote}_novo' value='${valAnt}'>`);
    $(`#barcode_${idLote}_novo`).focus();
    $(link).hide();
    $(celula).append(`<a href='#' id='salvaBarcode_${idLote}'><img src='/siiupa/imagens/icones/done.svg'></a>`);
    
    $(`#salvaBarcode_${idLote}`).click((e)=>{
        e.preventDefault();
        barcodeNov = $(`#barcode_${idLote}_novo`).val();
        let linkAtt = `/siiupa/farmacia/item/atualiza-lote/`;
        $.post(linkAtt, {acao: 'atualizalotebarcode',idlote: idLote, barcode: barcodeNov}, (data)=>{
            
           spanVal.html(data);
           $(`#salvaLote_${idLote}`).remove();
           $(link).show();
        });
    });

});

$(".editaNomeProduto").click((e) => {
    e.preventDefault();
    
    let link = $(e.currentTarget);
    let idLote = $(e.currentTarget).data('idlote');
    let celula = $(`#nomeproduto_${idLote}`);
    let spanVal = $(`#nomeproduto_${idLote} span`);    
    let valAnt = $(`#nomeproduto_${idLote} span`).html();
    
    spanVal.html(`<input type='text' id='nomeproduto_${idLote}_novo' value='${valAnt}'>`);
    $(`#nomeproduto_${idLote}_novo`).focus();
    $(link).hide();
    $(celula).append(`<a href='#' id='salvanomeproduto_${idLote}'><img src='/siiupa/imagens/icones/done.svg'></a>`);
    
    $(`#salvanomeproduto_${idLote}`).click((e)=>{
        e.preventDefault();
        nomeprodutoNov = $(`#nomeproduto_${idLote}_novo`).val();
        let linkAtt = `/siiupa/farmacia/item/atualiza-lote/`;
        $.post(linkAtt, {acao: 'atualizalotenomeproduto',idlote: idLote, nomeproduto: nomeprodutoNov}, (data)=>{
            
           spanVal.html(data);
           $(`#salvanomeproduto_${idLote}`).remove();
           $(link).show();
        });
    });

});

$(document).ready(function() {
    if(lapis){
    $(".lapis").show()
    };
});