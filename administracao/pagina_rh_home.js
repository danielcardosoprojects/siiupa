
$(function () {
    $("#dialogFotoPerfil").dialog({
        autoOpen: false,
        modal: true,
        title: 'Foto do perfil',
        width: 'auto'
    });

    $(".exibeFoto").click(function (e) {
        e.preventDefault();

        foto = $(this).data('foto');
        imagem = "<img style='max-height:400px' src='/siiupa/" + foto + "'></img>";


        $('#dialogFotoPerfil').html(imagem);

        $("#dialogFotoPerfil").dialog("open");

    });

    $('#gerarFrequencias').click(function () {
        // $.alert({
        //     title: 'Desabilitado!',
        //     content: 'Para imprimir a frequência de um usuário específico, abra primeiramente o perfil do servidor!',
        // });
        servidoresJson = "{";
        contVirgula = 0;
        servidores_freq.map(function (array) {

            if(contVirgula>0){
                virgulaDentro = ",";
            } else {
                virgulaDentro = "";
            }
            func = `${virgulaDentro}"${array.nome}":{"matricula":"${array.matricula}", "admissao":"${array.admissao}", "nome": "${array.nome}", "cargo":"${array.cargo}","vinculo":"${array.vinculo}","mes":1,"setor":"${array.setor}"}`;
            contVirgula++;

            
            servidoresJson += (func);
            //prompt("teste",servidoresJson);




            //$.get("gerapdf.php?&matricula=" + array.matricula + "&admissao=" + array.admissao + "&nome=" + array.nome + "&cargo=" + array.cargo + "&vinculo=" + array.vinculo + "&mes=1" + "&setor=" + array.setor);
        });

        servidoresJson = servidoresJson + "}";
        
        data_freq = {
            dado:servidoresJson
        }
        console.log(data_freq);
        $.post("gerapdf_varias.php", data_freq);
        // data?json=${encodeURI(servidoresJson)}`).then(function(){alert("Sucesso!")});
    });

    $("#tabela_funcionarios").tablesorter();
    $("#imprimirbusca").click(function () {
        var elem = $('#imprime_resultado');
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        mywindow.document.write('<link rel="stylesheet" href="/siiupa/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<img src="imagens/siiupa.png">');

        mywindow.document.write(elem.html());
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        // mywindow.close();


        return true;
    });

    //EXPORTAR PARA O EXCEL
    $('#exportar_excel_funcionarios').click(function (e) {
        e.preventDefault();
        tabela = $.find('#tabela_funcionarios');
        //console.log(tabela[0]);
        $("#tabela_funcionarios").table2excel({
            filename: "file.xls"
        });
    });

    $(".edita").dblclick(function () {
        let celula = $(this);

        let idfunc = celula.data('idfunc');
        let campo = celula.data('campo');
        let valor = celula.data('valor');
        let input = `<input type="text" value="PENDENTE" id="edita_${idfunc}" data-idfunc="${idfunc}" data-campo="${campo}">`;
        let idinput = `#edita_${idfunc}`;
        $(idinput).focus();
        celula.html(input);
        $(idinput).on('keydown', function (e) {
            var keyCode = e.keyCode;
            if (keyCode == '13') {
                let input = $(this);

                let idfunc = input.data('idfunc');
                let campo = input.data('campo');
                let valornovo = input.val();
                console.log(`id: ${idfunc}, campo: ${campo}, valor novo: ${valornovo}`);


                linkatt = '/siiupa/administracao/perfil/atualiza_perfil.php?id=' + idfunc + '&campo=' + campo + '&valor=' + valornovo;
                console.log(linkatt);

                $.get(linkatt, function (data) {

                    // alert(data);
                    // location.reload();
                    celula.html(data);

                });

            }
        });
    });

});//fim do function que carrega o script após o carregamento da página
$(document).ready(function () {
    $('#tabela_funcionarios').DataTable({
        "dom": '<"top"<"teste"f><"teste"l>ip>rt<"bottom"p><"clear">',
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tudo"]],
        language: {
            url: "/siiupa/js/dataTables/pt-BR.json"
        }
    });
});