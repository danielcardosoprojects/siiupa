$(function() {

    //exibe os checkbox de exclusao
    
    
    $("#blocodenotas").click((e) => {
        e.preventDefault();
        // $("#dialogAnota").dialog();
        // $("#dialogAnota").dialog({
        //     appendTo: "window"
        // });
        // $(".ui-dialog").css({
        //     'position': 'fixed',
        //     'top': '10px',
        //     'right': '0',    
        //     'z-index': '999'
        // });
        document.getElementById('bloco-de-notas').style.display = 'block';
    });


    $(".bt_oficial").click(function(e) {
        e.preventDefault();
        valor = $(this).data('oficial');
        idescala = $(this).data('idescala');
        mes = $(this).data('mes');
        ano = $(this).data('ano');
        linknovo = "?setor=adm&sub=rhescala_exibe&id=" + idescala + "&oficial=" + valor + "&mes=" + mes + "&ano=" + ano;
        if (valor == "sim") {
            bt_sucess = "btn btn-success";
            bt_sucess_out = "btn btn-outline-success";
            bt_rascunho_out = "btn btn-outline-warning";
            bt_rascunho = "btn btn-warning";
            $("#bt_esc_oficial").removeClass(bt_sucess_out);
            $("#bt_esc_oficial").addClass(bt_sucess);
            $("#bt_esc_rascunho").removeClass(bt_rascunho);
            $("#bt_esc_rascunho").addClass(bt_rascunho_out);
            $('#done-rascunho').hide();
            $("#done-oficial").removeClass("d-none");
            $('#done-oficial').show();

        } else {
            bt_sucess = "btn btn-success";
            bt_sucess_out = "btn btn-outline-success";
            bt_rascunho_out = "btn btn-outline-warning";
            bt_rascunho = "btn btn-warning";
            $("#bt_esc_rascunho").removeClass(bt_rascunho_out);
            $("#bt_esc_rascunho").addClass(bt_rascunho);
            $("#bt_esc_oficial").removeClass(bt_sucess);
            $("#bt_esc_oficial").addClass(bt_sucess_out);
            $('#done-rascunho').show();
            $('#done-oficial').hide();
        }
        var escala_oficial = 'administracao/escalas/atualiza_oficial.php?idescala=' + idescala + '&valor=' + valor;
        $("#load_status_escala").removeClass("d-none");
        $.get(escala_oficial, function(data) {

            window.history.pushState(null, 'hi', linknovo);
            window.location.reload();

            $("#load_status_escala").addClass("d-none");
        });
    });


    $("#dialogadd").dialog({
        autoOpen: false,
        height: 500,
        width: 600
    });
    $('#addservidor').click(function() {
        $("#dialogadd").dialog("open");

    });

    $("#btaddservidor").click(function(e){
        e.preventDefault();
        $('#form-busca-servidores').submit();
        $("#btAddTodos2").removeClass("d-none");
    });

    $('#form-busca-servidores').submit(function( event ) {
        

        event.preventDefault();
        
        var buscar = encodeURI($('#buscar').val());
        var busca_servidor_setor = $('#busca_servidor_setor').val();
        var acao = "buscar";
        var urlbusca = "administracao/escalas/buscarservidor.php?acao=busca&nome=" + buscar + "&setor=" + busca_servidor_setor;
        console.log(urlbusca);
        
        $('#dialogaddresultadobusca').load(urlbusca,
            function() {
                $(".escolhido").click(function(e) {
                    e.preventDefault();
                    var urlescala = (location.search);


                    var inserirlink = "administracao/escalas/buscarservidor.php" + urlescala + "&acao=insere&idservidor=" + $(this).data('idescolhido');

                    $('#dialogaddresultadobusca').load(inserirlink, function() {
                        var urlescala = (location.search);
                        var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;

                        $('#subconteudo').load(recarregaescala);

                    });



                });

                $('#btAddTodos2').click(function(e) {

                    var urlescala = (location.search);
                    buscaTodos = $(".escolhido");
                    let chave = $("#chaveAddServ").val();

                    todosArray = JSON.stringify(buscaTodos.toArray());

                    var todosJson = '{';
                    virgula = '';
                    $(buscaTodos).each(function() {
                        todosJson = todosJson + virgula;
                        todosJson = todosJson + '"' + ($(this).data('nome')) + '":' + ($(this).data('idescolhido'));
                        virgula = ',';

                    });
                    todosJson = todosJson + '}';

                    var urlescala = (location.search);
                    var inserirlink = "/siiupa/administracao/escalas/buscarservidor.php" + urlescala + "&acao=inseretodos";
                    console.log(inserirlink);

                    $.post(inserirlink, {
                        todos: todosJson,
                        chave: chave
                    }).done(function(data) {
                        $("#dialogaddresultadobusca").html(data);
                        var urlescala = (location.search);
                        var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;

                        $('#subconteudo').load(recarregaescala);
                    });

                });


            });
    });

    //DIALOGO QUE CONFIGURA OU EDITA OS SERVIDORES- CHAMADO DE CONFIG
    $("#dialogconfig").dialog({
        autoOpen: false,
        height: "auto",
        width: 500
    });

    $('.link-oculto').click(function(e) {
        e.preventDefault();

    });
    $('.editafuncionario').dblclick(function() {
        var edita = $(this);

        function centralizaDialog(idDialog) {
            appendTo: "body",
            $(idDialog).dialog({
                position: {
                    my: "center",
                    at: "center",
                    of: window
                }
            });
        }

        dialogConfig = $("#dialogconfig");
        var linkedita = 'administracao/escalas/editaservidor.php?idef=' + edita.data('idef') + '&idf=' + edita.data('idf') + '&nomeservidor=' + encodeURI(edita.data('nomeservidor')) + '&posicao=' + edita.data('posicao');
        $.get(linkedita, function(data) {
            dialogConfig.html(data), centralizaDialog("#dialogconfig");
        }).done(centralizaDialog("#dialogconfig"));
        //$("#dialogcfgresult").load(linkedita);
        $("#dialogconfig").dialog("open");



    });


});
