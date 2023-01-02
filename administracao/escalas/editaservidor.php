<?php
include_once('../../bd/conectabd.php');
?>

<script>
    $(function() {
        //função pra atualizar escala
        function recarregaescala() {
            var urlescala = (location.search);
            var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;

            $('#subconteudo').load(recarregaescala);
        }
        //LINHA EM BRANCO
        $('.optlinhaembranco').click(function() {
            var linklinhabranca = "administracao/escalas/editaservidor_bd.php?acao=linhabranca&valor=" + $(this).val() + "&idef=" + $(this).data('idef');
            $('#executabd').load(linklinhabranca, function() {
                var urlescala = (location.search);
                var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;

                $('#subconteudo').load(recarregaescala);
            });
        });
        //posicao
        $('#linkposicao').click(function() {
            $(this).preventDefault;
            var idef = $(this).data('idef');
            $.confirm({
                title: 'Defina a posição!',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Digite abaixo a posição (ex: 5). Os nomes são agrupados primeiro pela ordem de Posição, em Seguida alfabética, e então por inserção do servidor.</label>' +
                    '<input type="text" placeholder="Posição" class="posicao form-control" required />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            var posicao = this.$content.find('.posicao').val();
                            if (!posicao) {
                                $.alert('Digite uma posição válida');
                                return false;
                            }
                            //$.alert('Your name is ' + posicao + idef);
                            var linkposicao = "administracao/escalas/editaservidor_bd.php?acao=posicao&valor=" + posicao + "&idef=" + idef;
                            $('#executabd').load(linkposicao, function() {
                                recarregaescala();
                            });

                        }
                    },
                    cancel: function() {
                        //close
                    },
                },
                onContentReady: function() {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });

        $('#linkferias').click(function() {
            var ferias = $(this);
            var idef = ferias.data('idef');
            $.confirm({
                title: 'Defina a posição!',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Informe o dia e inicio e fim neste mês das férias</label>' +
                    '<input type="text" placeholder="Primeiro dia neste mês" class="diainicio form-control" required />' +
                    '<input type="text" placeholder="Ultimo dia neste mês" class="diafim form-control" required />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            var diainicio = this.$content.find('.diainicio').val();
                            var diafim = this.$content.find('.diafim').val();

                            //$.alert('Your name is ' + posicao + idef);
                            var linkposicao = "administracao/escalas/editaservidor_bd.php?acao=ferias&inicio=" + diainicio + "&fim=" + diafim + "&idef=" + idef;
                            $('#executabd').load(linkposicao, function() {
                                recarregaescala();
                            });

                        }
                    },
                    cancel: function() {
                        //close
                    },
                },
                onContentReady: function() {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });



        //// liLINCEÇA

        $('#linklicenca').click(function() {
            var licenca = $(this);
            var idef = licenca.data('idef');
            $.confirm({
                title: 'Defina a posição!',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Informe o dia e inicio e fim neste mês da licença</label>' +
                    '<input type="text" placeholder="Primeiro dia neste mês" class="diainicio form-control" required />' +
                    '<input type="text" placeholder="Ultimo dia neste mês" class="diafim form-control" required />' +
                    '<input type="text" placeholder="Texto a ser exibido" class="texto_licenca form-control" required />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            var diainicio = this.$content.find('.diainicio').val();
                            var diafim = this.$content.find('.diafim').val();
                            var texto_licenca = encodeURI(this.$content.find('.texto_licenca').val());

                            //$.alert('Your name is ' + posicao + idef);
                            var linkposicao = "administracao/escalas/editaservidor_bd.php?acao=licenca&inicio=" + diainicio + "&fim=" + diafim + "&idef=" + idef + "&textolicenca=" + texto_licenca;
                            $('#executabd').load(linkposicao, function() {
                                recarregaescala();
                            });

                        }
                    },
                    cancel: function() {
                        //close
                    },
                },
                onContentReady: function() {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });

        //deleta

        $('#excluiservidor').click(function() {
            var exclui = $(this);
            var linkdeleta = "administracao/escalas/editaservidor_bd.php?acao=deleta" + "&idef=" + $(this).data('idef');

            //var confirmadelete = confirm("Ao excluir este(a) servidor(a) as informações dele(a) referente aos dias de escala serão perdidas.");
            $.confirm({
                title: 'Confirma exclusão?',
                content: 'Ao excluir este(a) servidor(a) as informações dele(a) referente aos dias de escala serão perdidas.',
                type: 'red',
                buttons: {
                    "confirmar": function() {
                        $('#executabd').load(linkdeleta, function() {
                            var urlescala = (location.search);
                            var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;
                            $("#dialogconfig").dialog("close");
                            $('#subconteudo').load(recarregaescala);
                        });
                    },
                    cancel: function() {
                        $.alert('Cancelado!');
                    }
                }
            });


        });


    });
</script>
<?php

$idef = $_GET['idef'];
$idf = $_GET['idf'];
$nomeservidor = $_GET['nomeservidor'];
$posicao_servidor = $_GET['posicao'];
echo "<h5>".$_GET['idef'] . " - " . $nomeservidor . "</h5>";
?>
<div id="linhaembranco">
    <form>
        <hr>

        <div class="form-control">

            <a href="#" id="linkposicao" data-idef="<?php echo $idef; ?>"><span class="ui-icon ui-icon-caret-2-n-s"></span> Posição na escala: <?php echo $posicao_servidor; ?></a>

        </div>
        <hr>
        <div id="boxferias" class="form-control">Férias: <a href="#" id="linkferias" data-idef="<?php echo $idef; ?>">Adicionar na escala</a><br>

            <?php
            //vai buscar as férias desse servidor nesse periodo
            $bdconsferias = new BD;
            $sqlconsferias = "SELECT DATE_FORMAT(f.datainicio, '%d/%m/%Y') as inicio, DATE_FORMAT(f.datafim, '%d/%m/%Y') as fim , f.* FROM db_rh.tb_ferias AS f WHERE f.fk_funcionario = $idf";
            $resultadoconsferias = $bdconsferias->consulta($sqlconsferias);

            foreach ($resultadoconsferias as $consferias) {
                echo "$consferias->inicio - $consferias->fim<br>";
            }
            ?>

        </div>
        <hr>
        <div id="boxferias" class="form-control">Licença: <a href="#" id="linklicenca" data-idef="<?php echo $idef; ?>">Adicionar na escala</a></div>
        <hr>


        <div class="form-control">
            <script>
                $(function(){
                    $('#btn_limpar_escala').click(function(e){
                        e.preventDefault();
                        limar_escala_funcionario = '\"d1\":\"\"\,\"d2\":\"\"\,\"d3\":\"\"\,\"d4\":\"\"\,\"d5\":\"\"\,\"d6\":\"\"\,\"d7\":\"\"\,\"d8\":\"\"\,\"d9\":\"\"\,\"d10\":\"\"\,\"d11\":\"\"\,\"d12\":\"\"\,\"d13\":\"\"\,\"d14\":\"\"\,\"d15\":\"\"\,\"d16\":\"\"\,\"d17\":\"\"\,\"d18\":\"\"\,\"d19\":\"\"\,\"d20\":\"\"\,\"d21\":\"\"\,\"d22\":\"\"\,\"d23\":\"\"\,\"d24\":\"\"\,\"d25\":\"\"\,\"d26\":\"\"\,\"d27\":\"\"\,\"d28\":\"\"\,\"d29\":\"\"\,\"d30\":\"\"\,\"d31\":\"\"';
                        $('#autopreencher').val(limar_escala_funcionario);
                    });
                    $('#btn_autopreencher').click(function(e){
                        e.preventDefault();
                        var idef_auto = $('#autopreencher').data('idef');
                        var link_auto = 'administracao/escalas/popula_escala.php?id='+idef_auto+'&json='+$('#autopreencher').val();
                        
                        $.get(link_auto, function(data){
                            
                          location.reload();
                        });
                    });

                });
            </script>
            <span class="ui-icon ui-icon-arrowstop-1-s"></span>Linha em branco após este servidor? <label>Sim<input type="radio" value="sim" name="optlinhaembranco" class="optlinhaembranco" data-idef="<?php echo $idef; ?>"></label>
            <label>Nao<input type="radio" value="nao" name="optlinhaembranco" class="optlinhaembranco" data-idef="<?php echo $idef; ?>"></label>
        </div>

        <div class="form-control">
            <span class="ui-icon ui-icon-arrowstop-1-s"></span>Autopreencher escala JSON? <input type="text" id="autopreencher" data-idef="<?php echo $idef; ?>"><button id="btn_autopreencher">Auto</button><button id="btn_limpar_escala">Limpar</button>
            
        </div>

    </form>
    <hr>
    <button type="button" class="btn btn-danger" id="excluiservidor" data-idef="<?php echo $idef; ?>"><span class="ui-icon 	ui-icon-trash"></span>Excluir este servidor da escala</button>
    <div id="executabd"></div>
</div>