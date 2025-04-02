<?php





?>
<style type="text/css">
    .copiar {
        cursor: pointer;
    }
    .none {
        display: none;
    }

    .valor {
        background-color: green;
        padding: .1rem .2rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        text-transform: uppercase;

    }

    .afastamento {
        background-color: #a934ff;
        padding: .1rem .2rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
        text-transform: uppercase;
        font-weight: bold;

    }
</style>
<script type="text/vbscript">

</script>
<script>
    $(function() {
        $(".accordionFaltas").accordion({
            collapsible: true,
            active: 2
        });
        $(".accordionAcionamentos").accordion({
            collapsible: true,
            active: 2
        });
        $(".accordionFerias").accordion({
            collapsible: true,
            active: 2
        });
        $(".accordionExtras").accordion({
            collapsible: true,
            active: 2
        });


        $("#dados_folhas tbody").sortable().disableSelection();

        var valores = new Array();

        $('.linha_tabela').each(function() {
            valores.push($(this).data('idlinha'));
        });

        // Faça o que preferir com os valores

        console.log(valores.indexOf(443));



        $("#imprimirperfil").click(function() {
            var elem = $('#perfil');
            var mywindow = window.open('', 'PRINT', 'height=400,width=600');

            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('<link rel="stylesheet" href="/siiupa/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<img src="/siiupa/imagens/siiupa.png">');

            mywindow.document.write(elem.html());
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();


            return true;
        });

        $("#abresubconteudo").click(function() {
            event.preventDefault();
            sessionStorage.setItem('linkanterior', $(this).attr('href'));
            $('#subconteudo').load($(this).attr('href'));


        });
        $('.copiar').click(function() {

            copyText = $(this).attr('data-text');
            navigator.clipboard.writeText(copyText);
            // $.alert(`Copiado: ${copyText}`);
            //$(this).notify(`Copiado: ${copyText}`, "success");
            $.notify(
                `Copiado: ${copyText}`, {
                    position: "top right",
                    className: "success"
                }
            );

        })

        $("#gerafrequencia").click(function() {

            event.preventDefault();
            var mesreferencia = prompt("Mês de referência (Exemplo: 01)");
            $link = $(this).attr('href') + "&mes=" + mesreferencia;
            window.open($link, "janela1")

            //$('#subconteudo').load($link);


        });

        $("#dialogPerfil").dialog({
            autoOpen: false,
            modal: true,
            title: 'Perfil',
            width: 'auto'
        });


        $("#dialogAcionamentos").confirm({
            autoOpen: true,
            title: 'Encountered an error!',
            content: 'Something went downhill, this may be serious',
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Try again',
                    btnClass: 'btn-red',
                    action: function() {}
                },
                close: function() {}
            }
        });


        //função para capturar o valor e campo para atualizar
        //tipo para diferenciar se precisa tratar a data ou não
        function editafunc(celula, idfunc, campo, valorinput, tipo) {
            linkatt = '/siiupa/administracao/perfil/atualiza_perfil.php?id=' + idfunc + '&campo=' + campo + '&valor=' + valorinput;
            //celula.load(linkatt);

            $.get(linkatt, function(data) {

                // alert(data);
                // location.reload();
                celula.html(data);

            });
            console.log(celula.html());
        }

        ////edita texto normal, puro
        $(".edita").dblclick(function() {
            var celula = $(this);
            var idfunc = celula.data('idfunc');
            var campo = celula.attr('id');
            var input = "<input id='" + campo + "' type='text' value='" + celula.text() + "' style='width:100%'> <button value='Alterar' id='btnedita'>Alterar</button>";
            celula.html(input)

            $(celula).on('keydown', function(e) {
                var keyCode = e.keyCode;
                if (keyCode == '13') {
                    var valorinput = encodeURI($(this).find('input').val());
                    //var valorinput = valorinput+encodeURI($(this).find('inputinput[name=editsexo]:checked').val());
                    editafunc(celula, idfunc, campo, valorinput);


                }
            });
            $('#btnedita').on('click', function(e) {

                var valorinput = encodeURI(celula.find('input').val());
                editafunc(celula, idfunc, campo, valorinput);



            });


        });

        //edita data. Insere input, captura o Enter e trata a data para padrão US
        $(".editadata").dblclick(function() {
            var celula = $(this);
            var idfunc = celula.data('idfunc');
            var campo = celula.attr('id');
            var input = "<input id='" + campo + "' type='text' value='" + celula.text() + "'>";

            celula.html(input);
            idcampo = '#' + campo;


            $(celula).on('keydown', function(e) {


                var keyCode = e.keyCode;
                if (keyCode == '13') {
                    parts = encodeURI($(this).find('input').val());

                    parts = parts.split('\/');
                    valorinput = parts[2] + '-' + parts[1] + '-' + parts[0];

                    editafunc(celula, idfunc, campo, encodeURI(valorinput));
                }
            });


        });


        /// edita vinculo
        $(".editaopt").dblclick(function() {

            var celula = $(this);
            var idfunc = celula.data('idfunc');
            var campo = celula.attr('id');
            var input = "<button id='bt" + campo + "' type='text' value='" + celula.text() + "'>";
            var valor = encodeURI(celula.text());
            console.log(valor);
            //celula.html(input)
            linkopt = '/siiupa/administracao/perfil/editar_opcoes.php?tipo=vinculo&id=' + idfunc + '&campo=' + campo + '&valor=' + valor;
            $.get(linkopt, function(data) {
                celula.html(data);
                idbtnoptselecionado = '#btn' + campo;
                $(idbtnoptselecionado).click(function() {
                    idoptselecionado = '#edit' + campo;
                    valorinput = $(idoptselecionado).val();
                    editafunc(celula, idfunc, campo, encodeURI(valorinput));
                });




            });


            console.log(celula.html());

            $(celula).on('keydown', function(e) {
                var keyCode = e.keyCode;
                if (keyCode == '13') {
                    var valorinput = encodeURI($(this).find('input').val());
                    editafunc(celula, idfunc, campo, valorinput);

                }
            });


        });
        //fim edita opções de select e radio


        //UPLOAD DE ARQUIVO
        $('.apagaArquivo').click(function(e) {
            e.preventDefault();
            const arquivo = $(this).data('arquivo'); // já vem com o caminho completo
            $.alert(arquivo);
            $.ajax({
                type: 'POST',
                url: '/siiupa/administracao/perfil/uploadarquivo.php?acao=apagarArquivo',

                data: {
                    arquivo: arquivo
                },
                success: function(response) {
                    if (response == 'success') {
                        //alert('File uploaded successfully.');
                        window.close();
                    } else {

                        //$('#testando').html(response);
                        //alert('Something went wrong. Please try again.');
                    }
                    //location.reload();

                }
            });

        });
        $('#fileProfile').change(function() {


            var file_data = $('.fileProfile').prop('files')[0];
            var idf = $('.fileProfile').data('idf');
            console.log(file_data);
            if (file_data != undefined) {
                var form_data = new FormData();
                form_data.append('file', file_data);
                console.log(form_data);
                $.ajax({
                    type: 'POST',
                    url: '/siiupa/administracao/perfil/uploadarquivo.php?acao=fotoperfil&id=' + idf,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(response, data) {
                        if (response == 'success') {
                            //alert('File uploaded successfully.');
                            window.close();
                        } else {

                            //$('#testando').html(response);
                            // alert('Something went wrong. Please try again.');
                            // alert(response);
                        }
                        window.location.reload();
                        $('.fileProfile').val('');
                    }
                });
            }
            return false;
        });

        //UPLOAD DE FOTO DO PERFIL
        $('.submitArquivo').on('click', function () {
  var files = $('.file').prop('files'); // isso agora é uma lista
  var idf = $('.file').data('idf');

  if (files.length > 0) {
    var form_data = new FormData();

    for (let i = 0; i < files.length; i++) {
      form_data.append('file[]', files[i]); // adiciona todos
    }

    $.ajax({
      type: 'POST',
      url: '/siiupa/administracao/perfil/uploadarquivo.php?acao=arquivos&id=' + idf,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (response) {
        if (response == 'success') {
          alert('Arquivos enviados com sucesso.');
          location.reload();
        } else {
          $('#testando').html(response);
          alert('Erro no envio.');
        }
        $('.file').val('');
      }
    });
  }

  return false;
});




    }); //fim do jquery
</script>

<!--------------------------------------------------IMPRIMIR ----------------------------------------------------->


<!--------------------------------------------------- FIM IMRPIMIR ------------------------------------------------->

<!--------------------------------------------------- SUCESSO --------------------------------------------------->
<div class="alert alert-success" role="alert">
    <?php
    // $sql = "SELECT * FROM u940659928_siupa.tb_funcionario";
    if (isset($_GET["where"])) {
        $gw = $_GET['where'];
        $where = "WHERE f.nome LIKE '%" . $gw . "%'";
    } elseif (isset($_GET["id"])) {
        $gw = $_GET['id'];
        $where = "WHERE f.id = '" . $gw . "'";
    } else {
        $where = "";
    }

    if (isset($_GET["orderby"])) {
        $orderby = $_GET["orderby"];
        if ($orderby == 1) {
            $tipoorder = "ASC";
        }
    }


    $orderby = "ORDER BY id desc";
    $sql = "SELECT  DATE_FORMAT(f.admissao,'%d\/%m\/%Y') as admissaobr, DATE_FORMAT(f.data_nasc,'%d\/%m\/%Y') as data_nascbr, f.*, c.titulo AS cargo, c.descricao AS cargo_desc, s.setor FROM u940659928_siupa.tb_funcionario AS f INNER JOIN u940659928_siupa.tb_cargo AS c ON f.fk_cargo = c.id INNER JOIN u940659928_siupa.tb_setor AS s ON f.fk_setor = s.id $where $orderby";
    $result = mysqli_query($conn, $sql);

    echo mysqli_num_rows($result) . " resultado(s).";

    ?>
</div>
<!--------------- FIM SUCESSO --------------->


<?php

$perfil = mysqli_fetch_object($result);

$negrito = "<span class='fw-bold lh-1'>";
$fspan = "</span>";

function negrita($texto)
{
    echo "<b>" . $texto . "</b>";
}

function pulalinha($qtd)
{
    $i = 1;
    while ($i <= $qtd) {
        $i++;
        echo "</br>";;
    }
}

function vinculo($vinc)
{
    if ($vinc == "E") {
        $vinculoext = "EFETIVO";
        echo $vinculoext;
    } elseif ($vinc == "T") {
        $vinculoext = "TEMPORÁRIO";
        echo $vinculoext;
    } else {
        echo "Não informado.";
    }
}

//diveditavel
function diveditavel($id, $campo, $valor)
{
    if ($valor == '') {
        $valor = "<span class='ui-icon  ui-icon-plus'></span>";
    }
    echo "<div id='$campo' class='edita float-left' data-idfunc='$id'>$valor</div>";
}

function diveditaveldata($id, $campo, $valor)
{
    if ($valor == '') {
        $valor = "<span class='ui-icon  ui-icon-plus'></span>";
    }
    echo "<div id='$campo' class='editadata' data-idfunc='$id'>$valor</div>";
}
function diveditavelopt($id, $campo, $valor)
{
    if ($valor == '') {
        $valor = "<span class='ui-icon  ui-icon-plus'></span>";
    }
    echo "<div id='$campo' class='editaopt' data-idfunc='$id'>$valor</div>";
}


class Grade
{
    function iniciagrade()
    {
        echo "<div class='container-fluid''>";
    }

    function inicialinha()
    {
        echo "<div class='row'>";
    }

    function iniciacoluna()
    {
        echo "<div class='col-sm px-0'>";
    }

    function fimcoluna()
    {
        echo "</div>";
    }

    function fimlinha()
    {
        echo "</div>";
    }

    function fimgrade()
    {
        echo "</div>";
    }
}


?>

<div class=''>
    <?php $token = $_GET['token']; ?>
    <a target="_blank" href="/siiupa/teste/cc/?m=<?=$perfil->matricula;?>&cpf=<?=$perfil->cpf;?>&<?=$token;?>">CC</a>
    <?php $linkfrequencia = '/siiupa/gerapdf.php?&matricula=' . urlencode($perfil->matricula) . '&admissao=' . urlencode($perfil->admissao) . '&nome=' . urlencode($perfil->nome) . '&cargo=' . urlencode($perfil->cargo_desc) . '&vinculo=' . urlencode($perfil->vinculo);     ?>
    <a target="_blank" href='<?php echo $linkfrequencia; ?>' id='gerafrequencia' class='btn btn-outline-success'>
        <img src="/siiupa/imagens/icones/note_add.svg">
        Gerar Frequencia
    </a>

    <a onclick="" href="#" id="imprimirperfil" class="btn btn-outline-primary">
        <img src="/siiupa/imagens/icones/print.svg">
        Imprimir Perfil
    </a>



    <a href='?setor=adm&sub=rh&subsub=rhcadastraferias&acao=cadastrar&id=<?php echo $perfil->id; ?>&nome=<?php echo urlencode($perfil->nome); ?>&cargo=<?php echo urlencode($perfil->cargo_desc); ?>&vinculo=<?= $perfil->vinculo; ?>' id='abresubconteudoanexadoc' class="btn btn-outline-danger">
        <img src="/siiupa/imagens/icones/houseboat.svg">
        Cadastrar Férias
    </a>
    <!-- <script>
        document.addEventListener("keydown", function(event) {
            // Verifica se a tecla pressionada foi "f" ou "F"
            if (event.key === "f" || event.key === "F") {
                let linkFerias = "?setor=adm&sub=rh&subsub=rhcadastraferias&acao=cadastrar&id=<?php echo $perfil->id; ?>&nome=<?php echo urlencode($perfil->nome); ?>&cargo=<?php echo urlencode($perfil->cargo_desc); ?>&vinculo=<?= $perfil->vinculo; ?>";
                window.location.href = linkFerias; // Redireciona para o link desejado
            }
        });
        </script> -->


    <a class='btn btn-outline-secondary' target="_blank" href="/siiupa/administracao/apicnes.php?id=<?php echo $perfil->id; ?>">
        <img src="/siiupa/imagens/icones/inventory.svg">
        Solicitação CNES
    </a>

    <!-- Botão que abre o modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarFuncionario">
  Editar dados
</button>

<!-- Modal -->
<div class="modal fade" id="modalEditarFuncionario" tabindex="-1" aria-labelledby="modalEditarFuncionarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Funcionário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarFuncionario" class="row g-3">
          <input type="hidden" id="funcionarioId">

          <!-- Campos principais -->
          <div class="">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome">
          </div>

          <div class="none">
            <label for="funcao_upa" class="form-label">Função</label>
            <input type="text" class="form-control" id="funcao_upa">
          </div>

          <div class="col-md-6">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf">
          </div>

          <div class="col-md-6">
            <label for="cns" class="form-label">CNS</label>
            <input type="text" class="form-control" id="cns">
          </div>

          <div class="col-md-3" >
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula">
          </div>

          <div class="col-md-3">
            <label for="admissao" class="form-label">Admissão</label>
            <input type="text" class="form-control" id="admissao">
          </div>

          <div class="col-md-3">
            <label for="desligamento" class="form-label">Desligamento</label>
            <input type="text" class="form-control" id="desligamento">
          </div>

          <div class="col-md-3">
            <label for="data_nasc" class="form-label">Data Nasc.</label>
            <input type="text" class="form-control" id="data_nasc">
          </div>

          <div class="">
            <label for="municipio_uf_nascimento" class="form-label">Município-UF Nasc.</label>
            <input type="text" class="form-control" id="municipio_uf_nascimento">
          </div>

          <div class="">
            <label for="sexo" class="form-label">Sexo</label>
            
            <select id="sexo">
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>
          </div>

          <div class="">
            <label for="mae" class="form-label">Nome da Mãe</label>
            <input type="text" class="form-control" id="mae">
          </div>

          <div class="">
            <label for="pai" class="form-label">Nome do Pai</label>
            <input type="text" class="form-control" id="pai">
          </div>

          <div class="col-md-10">
            <label for="end_rua" class="form-label">end_rua</label>
            <input type="text" class="form-control" id="end_rua">
          </div>
          <div class="col-md-2">
            <label for="end_numero" class="form-label">end_numero</label>
            <input type="text" class="form-control" id="end_numero">
          </div>
          <div class="col-md-3">
            <label for="end_compl" class="form-label">end_compl</label>
            <input type="text" class="form-control" id="end_compl">
          </div>
          <div class="col-md-3">
            <label for="end_bairro" class="form-label">end_bairro</label>
            <input type="text" class="form-control" id="end_bairro">
          </div>
          <div class="col-md-3">
            <label for="end_cidade" class="form-label">end_cidade</label>
            <input type="text" class="form-control" id="end_cidade">
          </div>
          <div class="col-md-3">
            <label for="end_uf" class="form-label">end_uf</label>
            <input type="text" class="form-control" id="end_uf">
          </div>
          <div class="col-md-6">
            <label for="conselho_tipo" class="form-label">conselho_tipo</label>
            <input type="text" class="form-control" id="conselho_tipo">
          </div>
          <div class="col-md-6">
            <label for="conselho_n" class="form-label">conselho_n</label>
            <input type="text" class="form-control" id="conselho_n">
          </div>

          

          <div class="col-md-4">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone">
          </div>

          <div class="col-md-4">
            <label for="telefone2" class="form-label">Telefone 2</label>
            <input type="text" class="form-control" id="telefone2">
          </div>

          <div class="col-md-4">
            <label for="telefone3" class="form-label">Telefone 3</label>
            <input type="text" class="form-control" id="telefone3">
          </div>

          <div class="">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email">
          </div>

      

          <div class="col-md-12">
            <label for="notepad" class="form-label">Anotações</label>
            <textarea class="form-control" id="notepad" rows="3"></textarea>
          </div>

          <div class="modal-footer mt-4">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success" id="btnEditarFuncionario">Salvar</button>
            <div id="editaFuncionario_loading" class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    $('#editaFuncionario_loading').hide();
  function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  const token = getQueryParam("token");
  const funcionarioId = getQueryParam("id");

  async function carregarFuncionario(id) {
    try {
      const response = await axios.get(`https://api-siupa.vercel.app/funcionarios/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });

      const f = response.data;
      document.getElementById("funcionarioId").value = f.id;
      document.getElementById("nome").value = f.nome || "";
      document.getElementById("funcao_upa").value = f.funcao_upa || "";
      document.getElementById("cpf").value = f.cpf || "";
      document.getElementById("cns").value = f.cns || "";
      document.getElementById("matricula").value = f.matricula || "";
      document.getElementById("admissao").value = f.admissao || "";
      document.getElementById("desligamento").value = f.desligamento || "";
      document.getElementById("data_nasc").value = f.data_nasc || "";
      document.getElementById("municipio_uf_nascimento").value = f.municipio_uf_nascimento || "";
      document.getElementById("sexo").value = f.sexo || "";
      document.getElementById("mae").value = f.mae || "";
      document.getElementById("pai").value = f.pai || "";
      document.getElementById("end_rua").value = f.end_rua || "";
      document.getElementById("end_numero").value = f.end_numero || "";
      document.getElementById("end_compl").value = f.end_compl || "";
      document.getElementById("end_bairro").value = f.end_bairro || "";
      document.getElementById("end_cidade").value = f.end_cidade || "";
      document.getElementById("end_uf").value = f.end_uf || "";
      document.getElementById("conselho_tipo").value = f.conselho_tipo || "";
      document.getElementById("conselho_n").value = f.conselho_n || "";
      document.getElementById("pai").value = f.pai || "";
      document.getElementById("telefone").value = f.telefone || "";
      document.getElementById("telefone2").value = f.telefone2 || "";
      document.getElementById("telefone3").value = f.telefone3 || "";
      document.getElementById("email").value = f.email || "";
      document.getElementById("ram").value = f.ram || "";
      document.getElementById("notepad").value = f.notepad || "";

    } catch (error) {
      alert("Erro ao carregar dados do funcionário.");
      console.error(error);
    }
  }

  document.getElementById("btnEditarFuncionario").addEventListener("click", async function (e) {
    e.preventDefault();
    $('#editaFuncionario_loading').show();

    const id = document.getElementById("funcionarioId").value;

    const data = {
      nome: document.getElementById("nome").value,
      funcao_upa: document.getElementById("funcao_upa").value,
      cpf: document.getElementById("cpf").value,
      cns: document.getElementById("cns").value,
      matricula: document.getElementById("matricula").value,
      admissao: document.getElementById("admissao").value,
      desligamento: document.getElementById("desligamento").value,
      data_nasc: document.getElementById("data_nasc").value,
      municipio_uf_nascimento: document.getElementById("municipio_uf_nascimento").value,
      sexo: document.getElementById("sexo").value,
      mae: document.getElementById("mae").value,
      pai: document.getElementById("pai").value,
      end_rua: document.getElementById("end_rua").value,
      end_numero: document.getElementById("end_numero").value,
      end_compl: document.getElementById("end_compl").value,
      end_bairro: document.getElementById("end_bairro").value,
      end_cidade: document.getElementById("end_cidade").value,
      end_uf: document.getElementById("end_uf").value,
      conselho_tipo: document.getElementById("conselho_tipo").value,
      conselho_n: document.getElementById("conselho_n").value,
      telefone: document.getElementById("telefone").value,
      telefone2: document.getElementById("telefone2").value,
      telefone3: document.getElementById("telefone3").value,
      email: document.getElementById("email").value,
      ram: document.getElementById("ram").value,
      notepad: document.getElementById("notepad").value,
    };

    try {
      await axios.put(`https://api-siupa.vercel.app/funcionarios/${id}`, data, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });

    //   alert("Funcionário atualizado com sucesso!");
      location.reload();
      $.notify(
                `Atualizado com sucesso`, {
                    position: "top right",
                    className: "success"
                }
            );


      const modalEl = document.getElementById('modalEditarFuncionario');
      const modal = bootstrap.Modal.getInstance(modalEl);
      modal.hide();

    } catch (error) {
      alert("Erro ao atualizar funcionário.");
      console.error(error);
    }
  });

  // Carregar automaticamente ao abrir a página
  if (funcionarioId && token) {
    carregarFuncionario(funcionarioId);
  }
</script>

</div>


<div id='perfil'>
    <style>
        #fileProfile {
            display: none;
        }
    </style>
    <?php

    echo "<p class='lh-1'>";

    ?>

    <script>
        document.title = 'SIUPA <?= $perfil->nome; ?>';
    </script>
    <?php






    $grade = new Grade();
    $grade->iniciagrade();

    $grade->inicialinha();
    $grade->iniciacoluna();

    $foto_perfil = '/siiupa/administracao/rh/' . $perfil->id . '/foto_perfil';

    if (file_exists($foto_perfil)) {
        $foto_perfil = '/siiupa/administracao/rh/' . $perfil->id . '/foto_perfil';
    } else {
        $foto_perfil = '/siiupa/administracao/rh/' . $perfil->id . '/foto_perfil';
        //$foto_perfil = 'imagens/sem_imagem.png';
    }

    ?>
    <form nctype="multipart/form-data">

        <input type="file" name="fileProfile" id="fileProfile" class="fileProfile btn btn-primary btn-sm" data-idf="<?php echo $perfil->id; ?>" value="foto_perfil" required>

    </form>
    <?php

    echo "<table class='table'>
        <tbody>
            <tr>
                <td>";
    echo "<div class='rounded-circle float-right' style='width:90px; border:1px solid #000;height:90px;background-color:#ccc;background-image:url(\"$foto_perfil\");background-size: 80px auto;background-repeat: no-repeat;background-position:center;' title='Foto perfil' alt='Sem foto' class='img-thumbnail  float-left'></div>";

    echo "<label for='fileProfile'><img src='/siiupa/imagens/icones/foto.jpg' height='20px' style='pointer:click'></label>";

    echo "</td>";

    //// N O M E /////
    echo "<td class='d-flex align-items-center'>";

    //negrita("NOME:");
    echo "<h1>";
    echo "<div class='copiar' data-text='$perfil->nome'>"; //copia nome
    diveditavel($perfil->id, 'nome', $perfil->nome);
    echo "</div>"; //fim copia nome


    echo diveditavelopt($perfil->id, 'fk_cargo', $perfil->cargo_desc) . "</h1>";

    echo "</td>
    
            </tr>";


    echo "
            
            </tbody< /table>";

    $grade->fimcoluna();


    $grade->fimlinha();
    echo "</table>";
    echo "<div class='copiar btn btn-sm btn-grey' data-text='C:\wamp64\www\siiupa\administracao\\rh\\$perfil->id\'>Pasta Windows</div>";

    ?>
    <table id='sistema' class='table table-hover'>
        <thead>
            <tr>
                <th>STATUS</th>
                <th>VÍNCULO</th>
                <th>MATRÍCULA</th>
                <th>ADMISSÃO</th>
                <th>CNES</th>
                <th>DESLIGAMENTO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php diveditavel($perfil->id, 'status', $perfil->status); ?></td>
                <td><?php diveditavelopt($perfil->id, 'vinculo', $perfil->vinculo); ?></td>
                <td><?php diveditavel($perfil->id, 'matricula', $perfil->matricula); ?></td>
                <td><?php diveditaveldata($perfil->id, 'admissao', $perfil->admissaobr); ?></td>
                <td><?php diveditavelopt($perfil->id, 'CNES', $perfil->CNES); ?></td>
                <td><?php diveditavel($perfil->id, 'desligamento', $perfil->desligamento); ?></td>

                <td></td>
            </tr>
        </tbody>
    </table>
    <table id="detalhes_cargo" class="table table-hover table-bordered">
        <thead>
            <th>Cargo</th>
            <th>CPF</th>
            <th>Conselho de Classe</th>
        </thead>
        <tbody>
            <td><?php diveditavelopt($perfil->id, 'fk_cargo', $perfil->cargo_desc); ?></td><!-- VALOR CARGO -->
            <td><?php echo diveditavel($perfil->id, 'cpf', $perfil->cpf); ?></td><!-- VALOR CPF -->
            <td><?php echo diveditavelopt($perfil->id, 'conselho_tipo', $perfil->conselho_tipo); ?></td><!-- VALOR TIPO CONSELHO -->
        </tbody>
        <thead>
            <th>Setor</th>
            <th>CNS</th>
            <th>Nº Conselho</th>
        </thead>
        <tbody>
            <td><?php diveditavelopt($perfil->id, 'fk_setor', $perfil->setor); ?></td><!-- VALOR SETOR -->
            <td><?php echo diveditavel($perfil->id, 'cns', $perfil->cns); ?></td><!-- VALOR CNS -->
            <td><?php echo diveditavel($perfil->id, 'conselho_n', $perfil->conselho_n); ?></td><!-- VALOR CONSELHO -->
        </tbody>
    </table>


    <table id='dados' class='table table-hover table-bordered'>
        <thead>
            <tr>
                <th>SEXO</th>
                <th>MÃE</th>
                <th>PAI</th>
                <th>DATA DE NASCIMENTO</th>
                <th>NATURALIDADE</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php diveditavelopt($perfil->id, 'sexo', $perfil->sexo); ?></td>
                <td><?php diveditavel($perfil->id, 'mae', $perfil->mae); ?></td>
                <td><?php diveditavel($perfil->id, 'pai', $perfil->pai); ?></td>
                <td><?php diveditaveldata($perfil->id, 'data_nasc', $perfil->data_nascbr); ?></td>
                <td><?php diveditavel($perfil->id, 'municipio_uf_nascimento', $perfil->municipio_uf_nascimento); ?></td>


            </tr>
        </tbody>
    </table>

    <?php

    ?>
    <table id='endereco' class='table table-hover table-bordered'>
        <thead>
            <tr>
                <th>Rua</th>
                <th>Numero</th>
                <th>Complemento</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>UF</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php diveditavel($perfil->id, 'end_rua', $perfil->end_rua); ?></td>
                <td><?php diveditavel($perfil->id, 'end_numero', $perfil->end_numero); ?></td>
                <td><?php diveditavel($perfil->id, 'end_compl', $perfil->end_compl); ?></td>
                <td><?php diveditavel($perfil->id, 'end_bairro', $perfil->end_bairro); ?></td>
                <td><?php diveditavel($perfil->id, 'end_cidade', $perfil->end_cidade); ?></td>
                <td><?php diveditavel($perfil->id, 'end_uf', $perfil->end_uf); ?></td>


            </tr>
        </tbody>
    </table>


    <?php



    pulalinha(1);

    ?>
    <table id='telefones' class='table table-hover table-bordered'>
        <thead>
            <tr>
                <th>Telefone 1</th>
                <th>Telefone 2</th>
                <th>Telefone 3</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php diveditavel($perfil->id, 'telefone', $perfil->telefone); ?></td>
                <td><?php diveditavel($perfil->id, 'telefone2', $perfil->telefone2); ?></td>
                <td><?php diveditavel($perfil->id, 'telefone3', $perfil->telefone3); ?></td>
                <td><?php diveditavel($perfil->id, 'email', $perfil->email); ?></td>


            </tr>
        </tbody>
    </table>


    <?php



    $grade->inicialinha();

    $grade->iniciacoluna();
    negrita("REAÇÃO ALERGICA A MEDICAMENTOS:");
    pulalinha(1);
    diveditavel($perfil->id, 'ram', $perfil->ram);
    pulalinha(2);

    $grade->fimcoluna();
    $grade->fimlinha();

    // ************************** AFASTAMENTS *********************//


    echo '<div class="accordionFaltas">
    <h3><img src="/siiupa/imagens/icones/atestados2.svg" width="20"> AFASTAMENTOS DO SERVIDOR</h3>
    <div>';
    echo "<table>";
    echo "<tbody>";

    $idservidor = $_GET['id'];

    $sqlAfastamentos = "SELECT afs.afastamento,afs.id as afastamento_id, A.*, f.nome, c.titulo FROM u940659928_siupa.tb_afastamento as A inner join u940659928_siupa.tb_funcionario as f ON (A.fk_funcionario = f.id) inner join u940659928_siupa.tb_cargo AS c on (f.fk_cargo = c.id) inner join u940659928_siupa.tb_afastamentos as afs on (A.fk_afastamentos = afs.id) where A.fk_funcionario = '$idservidor' order by A.data_fim DESC";
    if ($bancoAfastamentos = $conn->query($sqlAfastamentos)) {

        while ($dadosAfastamentos = $bancoAfastamentos->fetch_object()) {
            $espaco = " ";
            $hifen = " - ";

            $pulalinha = "</br>";
            $data_inicio = new DateTime($dadosAfastamentos->data_inicio);
            $data_fim = new DateTime($dadosAfastamentos->data_fim);
            $periodo = $data_inicio->diff($data_fim);
            $periodo = $periodo->days + 1;
            $mesInicio = mes($data_inicio->format("m"));
            $mesFim = mes($data_fim->format("m"));
            if ($periodo == 1) {
                $entredata = "";
            } else {
                $entredata = " à " . $data_fim->format("d/m/Y");
            }
            if ($periodo == 1) {
                $entredata = "";
            } else {
                $entredata = " à " . $data_fim->format("d/m/Y");
            }

            if ($mesInicio == $mesFim) {
                $mesPeriodo = $mesInicio . "/" . $data_inicio->format("y");
            } else {
                $mesPeriodo = "$mesInicio/" . $data_inicio->format("y") . " → $mesFim/" . $data_fim->format("y");
            }



            echo "<tr>";
            echo "<td><span class='valor'>$mesPeriodo</span></td><td><span class='afastamento' style='text-align:center'>$dadosAfastamentos->afastamento</span></td><td>" . $espaco . $dadosAfastamentos->nome  . $hifen . $data_inicio->format("d/m/Y") . $entredata . $hifen . $periodo . " dia(s)</td>";
            echo "</tr>";
        }
        $bancoAfastamentos->close();
    }
    echo "</tbody></table>";
    echo '</div></div><hr>';




    /**************************FIM AFASTAMENTOS **********/
    //INICIO ACIONAMENTOS

    echo '<div class="accordionAcionamentos">
                <h3><img src="/siiupa/imagens/icones/dinheiro2.svg" width="20px"> ACIONAMENTOS DO SERVIDOR</h3>
                <div>';
    echo "<table class='table table-hover' id='tabelaAcionamento'>";
    echo "<thead>
                <th>Nome</th>
                <th>Data Acionamento</th>
                <th>CH</th>
                <th>Valor</th>
                <th>Motivo</th>
                <th>Afastamento</th>
                
                </thead>";
    echo "<tbody>";

    $consulta_acionamento = new BD;
    $sqlConsulta_Acionamento = "SELECT ac.*, f.nome, acs.acionamento FROM u940659928_siupa.tb_acionamento as ac inner join u940659928_siupa.tb_funcionario as f on (ac.fk_funcionario = f.id) inner join u940659928_siupa.tb_acionamentos as acs on(ac.fk_acionamentos = acs.id) WHERE ac.fk_funcionario = '$idservidor' ORDER BY ac.id DESC";
    $resultadoConsulta_Acionamento = $consulta_acionamento->consulta($sqlConsulta_Acionamento);

    foreach ($resultadoConsulta_Acionamento as $resultado_acionamento) {
        echo "<tr>";
        $fk_afastamento = $resultado_acionamento->fk_afastamento;


        $data_acionamento = new DateTime($resultado_acionamento->data_acionamento);

        $dataAcionamento = $data_acionamento->format('d/m/Y');

        if ($resultado_acionamento->turno == "diurno") {
            $turnoAcionamento = "D";
        } elseif ($resultado_acionamento->turno == "noturno") {
            $turnoAcionamento = "N";
        } elseif ($resultado_acionamento->turno == "plantao_24h") {
            $turnoAcionamento = "P";
        } else {
            $turnoAcionamento = "D";
        }
        echo "<td>$resultado_acionamento->nome</td><td>$dataAcionamento</td><td class='colunaHorasAcionamento'>$resultado_acionamento->qtd_horas $turnoAcionamento</td><td class='coluna_valor'>R$ $resultado_acionamento->valor,00</td><td>" . utf8_encode($resultado_acionamento->acionamento) . "</td>";
        echo "<td>";
        if ($resultado_acionamento->fk_afastamento != 0) {
            $consulta_afastamento = new BD;
            $sqlConsulta_Afastamento = "SELECT f.nome as nomeAfastado, c.titulo as tituloCargo, afs.afastamento, af.id as idAfastado, af.data_inicio, af.data_fim FROM u940659928_siupa.tb_afastamento as af inner join u940659928_siupa.tb_funcionario as f on (af.fk_funcionario = f.id) inner join u940659928_siupa.tb_afastamentos as afs on (af.fk_afastamentos = afs.id) inner join u940659928_siupa.tb_cargo AS c on (f.fk_cargo = c.id) WHERE af.id='$resultado_acionamento->fk_afastamento'";

            $resultadoConsultaAfastamento = $consulta_afastamento->consulta($sqlConsulta_Afastamento);
            ////////////////////////////////// var_dump($resultadoAfastamento);
            $resultadoAfastamento = $resultadoConsultaAfastamento[0];
            $dataInicio = new DateTime($resultadoAfastamento->data_inicio);
            $dataFim = new DateTime($resultadoAfastamento->data_fim);
            $dataInicio = $dataInicio->format('d/m/Y');
            $dataFim = $dataFim->format('d/m/Y');
            echo "<span class='tipo_afastamento'>$resultadoAfastamento->afastamento</span>";
            echo "<span> <img src='/siiupa/imagens/pessoa_falta.svg'><a href='#'>$resultadoAfastamento->nomeAfastado - $resultadoAfastamento->tituloCargo - $dataInicio a $dataFim</a></sp>";
        }
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo '</div></div>';
    echo "<hr>";
    //FIM ACIONAMENTOS


    // ********** FOLHA DE PAGAMENTO DE EXTRA ****///
    echo '<div class="accordionExtras">
    <h3><img src="/siiupa/imagens/dinheiro.svg" width="20px"> FOLHAS DE PAGAMENTO DE EXTRAS</h3>
    <div>';
    $grade->iniciacoluna();
    // negrita("FOLHAS DE PAGAMENTO DE EXTRAS:");
    echo  "<br><small><small>Exibindo do mais recente para o mais antigo.</small></small>";
    pulalinha(1);
    echo '
<table id="dados_folhas" class="table  table-bordered  border-dark table-sm table-hover table-striped Tabela_folha" style="font-size:12px">
        <thead>
          <tr>
            <th scope="col">N#</th>
            <th scope="col">COMPETÊNCIA</th>
            <th scope="col">NOME</th>
            
            <th scope="col">FUNÇÃO</th>
            <th scope="col">ADC.NOT</th>
            <th scope="col">06h</th>
            <th scope="col">12h</th>
            <th scope="col">24h</th>
            <th scope="col">ACION.</th>
            <th scope="col">TRANSF.</th>
            <th scope="col">FIXOS</th>
            <th scope="col">VALOR TOTAL</th>
            <th scope="col" class="col-2">OBS</th>
           
            
          </tr>
        </thead>
        <tbody>
        ';

    $query = "SELECT fls.ref_mes, fls.ref_ano, fl.fk_folhas, fl.id as id_linha, func.id,func.nome, cargo.funcao_upa, fl.adc_not, fl.ext_6, fl.ext_12, fl.ext_24, fl.acionamento, fl.transferencia, fl.fixos, fl.obs, cargo.valor_plantao, cargo.valor_acionamento, cargo.valor_transferencia FROM u940659928_siupa.tb_folha AS fl INNER JOIN u940659928_siupa.tb_funcionario AS func ON (fl.fk_funcionario = func.id) inner join u940659928_siupa.tb_folhas as fls on (fl.fk_folhas = fls.id) INNER JOIN u940659928_siupa.tb_cargo AS cargo ON (func.fk_cargo = cargo.id) WHERE fk_funcionario = '$perfil->id' ORDER BY id_linha DESC";

    function trataNaoNumericos($naoNumericos)
    {
        if ($naoNumericos == '' || $naoNumericos == null) {
            return 0;
        } else {
            return floatval($naoNumericos);
        }
    }

    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($ref_mes, $ref_ano, $idfolha, $id_linha, $func_id, $nome, $funcao_upa, $adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, $fixos, $obs, $valor_plantao, $valor_acionamento, $valor_transferencia);




        $i = 0;
        $valor_geral = 0;

        while ($stmt->fetch()) {
            $i++;

            if ($ext_6 == "") {
                $ext_6 = 0;
            }
            if ($ext_12 == "") {
                $ext_12 = 0;
            }
            if ($ext_24 == "") {
                $ext_24 = 0;
            }
            if ($acionamento == "") {
                $acionamento = 0;
            }
            $valor_plantao = floatval($valor_plantao);
            $valor_acionamento = floatval($valor_acionamento);
            $valores_exibe[$func_id] = "";

            //$acionamento, $transferencia, $fixos, $obs, $valor_plantao, $valor_acionamento, $valor_transferencia)
            $transferencia = trataNaoNumericos($transferencia);
            $fixos = trataNaoNumericos($fixos);
            $valor_transferencia = trataNaoNumericos($valor_transferencia);
            $ext_6 = trataNaoNumericos($ext_6);
            $ext_12 = trataNaoNumericos($ext_12);
            $ext_24 = trataNaoNumericos($ext_24);



            $valor_total = ($ext_6 * ($valor_plantao / 2)) + ($ext_12 * $valor_plantao) + ($ext_24 * ($valor_plantao * 2)) + ($valor_acionamento * $acionamento) + ($valor_transferencia * $transferencia) + $fixos;
            //var_dump($ref_mes, $ref_ano, $idfolha, $id_linha, $func_id, $nome, $funcao_upa, $adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, $fixos, $obs, $valor_plantao, $valor_acionamento, $valor_transferencia);
            $valor_geral = $valor_geral + $valor_total;
            $link_para_alterar = "/siiupa/adm/rh/folha/$idfolha#$id_linha";

            printf("
                
                <tr class='align-middle linha_tabela' data-idlinha='%s'>
                <td>%s</td>
                <td>%s/%s</td>
               
                <td title='%s'><a href='%s'class='text-dark text-decoration-none'>%s</a></td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td  class='table-responsive-lg text-right' style='text-align:right'><i>R$</i> %s</td>
                <td>%s</td>
        
              </tr>", $id_linha, $i, $ref_mes, $ref_ano, $id_linha, $link_para_alterar, $nome, $funcao_upa, $adc_not, $ext_6, $ext_12, $ext_24, $acionamento, $transferencia, number_format($fixos, 2, ',', '.'), number_format($valor_total, 2, ',', '.'), $obs);
        }
        $stmt->close();
    }
    echo "<tr><td colspan='11' style='text-align:right'>Total: </td><td colspan='2'>R$ $valor_geral,00</td></tr>";
    echo '</tbody>
    </table>';
    echo "</div></div>"; //fim do accordion dos extras

    $grade->fimcoluna();


    $grade->iniciacoluna();
    echo '<hr><div class="accordionFerias">
            <h3><img src="/siiupa/imagens/icones/ferias2.svg" width="20px"> FÉRIAS DO SERVIDOR</h3>
            <div id="boxFerias"><h2>' . $perfil->nome . '</h2>';
    include('perfil/ferias.php');
    echo '</div></div>';
    $grade->fimcoluna();

    //

    $grade->fimlinha();

    $grade->fimgrade();
    echo "</p>";
    //echo "</div>"; //DIV PERFIL

    /// lista de documentos para contratação /////

    ?>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    DOCUMENTOS PARA CONTRATAÇÃO
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <table class="table-bordered">
                        <tbody>
                            <?php
                            $docs_contratacao = array(
                                "doc_rg" => "RG",

                                "doc_cpf" => "CPF",

                                "doc_titulo_eleitor" => "Titulo de Eleitor",

                                "doc_ctps" => "Carteira de Trabalho",

                                "doc_pispasep" => "PIS-PASEP / NIT / NIS",

                                "doc_pispasep_data" => "DATA DE CADASTRAMENTO(PISPASEP)",

                                "doc_comp_escolaridade" => "Diploma de Escolaridade",

                                "doc_carteira_profissional" => "Carteira Profissional",

                                "doc_declaracao_conselho" => "Declaracao Conselho",

                                "doc_endereco" => "Comprovante de Endereço",

                                "doc_cns" => "Cartão do SUS",

                                "doc_tip_sanguinea" => "Tipagem Sanguinea",

                                "doc_telefone" => "Telefone",

                                "doc_email" => "E-mail",

                                "doc_certidao_Nasc_Casam" => "Certidão de nascimento, casamento ou divórcio",

                                "doc_certidao_filhos" => "Certidão de filhos menor de 14 anos",

                                "doc_reservista" => "(HOMENS) Reservista",

                                "doc_conta_banco" => "Conta Corrente Banco Itaú",
                            );

                            echo "<h4>$perfil->nome</h4>";
                            $i_doc = 0;
                            foreach ($docs_contratacao as $documento_contratacao) {
                                $i_doc = $i_doc + 1;
                                $coluna_doc = key($docs_contratacao);


                                if ($perfil->$coluna_doc == "sim") {
                                    $fundo_doc = "style='background-color:#00FF7F;'";
                                } else {
                                    $fundo_doc = "style='background-color:#FA8072;'";
                                }
                                echo "<tr $fundo_doc>";
                                echo "<th>$i_doc ";
                                echo $documento_contratacao;
                                echo "</th>";
                                echo "<td>";

                                diveditavel($perfil->id, $coluna_doc, $perfil->$coluna_doc);


                                echo "</td>";
                                echo "</tr>";
                                next($docs_contratacao);
                            }
                            ?>



                        </tbody>
                    </table>





                </div>
            </div>
        </div>
    </div>

    <?php

    ////// fim da list de documentos para contratação ///////





    echo "<div class='copiar btn btn-sm btn-info' data-text='C:\wamp64\www\siiupa\administracao\\rh\\$perfil->id\'>C:\\wamp64\\www\\siiupa\\administracao\\rh\\$perfil->id</div>";

    ?>
<form enctype="multipart/form-data">
  <p>
    <input 
      type="file" 
      name="file[]" 
      class="file btn btn-primary btn-sm" 
      data-idf="<?php echo $perfil->id; ?>" 
      multiple 
      required
    >
  </p>
  <input type="submit" name="submitArquivo" class="submitArquivo btn btn-sm" value="Enviar">
</form>



    <div id="arquivostemporarios"></div>
    <div id='testando'></div>
    <!-- Inclua o Axios no seu HTML -->

    <div id="dialogAcionamentos">Teste acionamentos</div>
    <script>
       
    </script>
    <script>
        // Fazendo uma requisição GET
        axios.get('https://siupa.com.br/siiupa/api/rh/api.php/records/tb_acionamento?join=tb_acionamentos&page=3,4')
            .then(response => {
                console.log('Dados da resposta:', response.data);
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
            });
    </script>

    <?php
    //$path = "../rh/" . $perfil->id . "/";
    $path = "administracao/rh/$perfil->id/";


    if (!file_exists($path)) {
        mkdir($path, 0755);
    }

    $diretorio = dir($path);


    echo "Lista de Arquivos do diretório '<strong>" . $path . "</strong>':<br />";
    echo "<table><theady><th>Nome do arquivo</th><th>Apagar</th></thead><tbody>";
    while ($arquivo = $diretorio->read()) {
        if ($arquivo == '.' || $arquivo == '..') {
            continue;
        }
        $linkLixeira = "<img src='/siiupa/imagens/icones/lixeira.svg' width='15px'>";

        $arquivoURI = urlencode($arquivo);

        echo "<tr><td><a target='_blank' href='" . $path . $arquivo . "'>" . $arquivo . "</a></td><td><a href='#' class='apagaArquivo' data-arquivo=" . $path . $arquivoURI . ">$linkLixeira</a></td></tr>";
    }
    echo "</tbody></table>";
    $diretorio->close();




    /* HISTORICO */
    $sqlhist = "SELECT  * FROM u940659928_siupa.tb_historico WHERE fk_funcionario = $perfil->id ORDER BY data_registro DESC";
    $resulthist = mysqli_query($conn, $sqlhist);

    echo "<div class='alert alert-success' role='alert'>";
    negrita("Histórico: ");
    echo mysqli_num_rows($resulthist) . " registro(s).";
    echo "</div>";


    if (mysqli_num_rows($resulthist) > 0) {
        while ($hist = mysqli_fetch_object($resulthist)) {
            $DataRegpuro = new DateTime($hist->data_registro);

            $DataReg = $DataRegpuro->format('d/m/Y H:i:s');

    ?>


            <div class="accordion accordion-flush" id="accordionFlushHist" style="border-color:midnightblue;">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-heading<?php echo $hist->id; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $hist->id; ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $hist->id; ?>">
                            <?php
                            negrita($DataReg);
                            echo " - ";
                            echo $hist->titulo;

                            if ($hist->data_inicio != "") {
                                $historicoprazo = "<br>De: " . $hist->data_inicio . " a " . $hist->data_fim;
                            } else {
                                $historicoprazo = "";
                            }

                            ?>
                        </button>
                    </h2>
                    <div id="flush-collapse<?php echo $hist->id; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $hist->id; ?>" data-bs-parent="#accordionFlushHist">
                        <div class="accordion-body"> <?php echo $hist->descricao . $historicoprazo; ?></div>
                    </div>
                </div>
            </div>

            <div id="dialogPerfil"></div>
            

    <?php
        }
    } else {
        echo "0 results";
    }


    mysqli_close($conn);
    function mes($entrada)
    {
        switch ($entrada) {
            case 1:
                return "Janeiro";
            case 2:
                return "Fevereiro";
            case 3:
                return "Março";
            case 4:
                return "Abril";
            case 5:
                return "Maio";
            case 6:
                return "Junho";
            case 7:
                return "Julho";
            case 8:
                return "Agosto";
            case 9:
                return "Setembro";
            case 10:
                return "Outubro";
            case 11:
                return "Novembro";
            case 12:
                return "Dezembro";
        }
        return $entrada;
    }
    ?>