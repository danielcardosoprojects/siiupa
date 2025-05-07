<?php
@include_once("../bd/conectabd.php");

function pula($entrada)
{
    for ($i = 1; $i <= $entrada; $i++) {
        echo "</br>";
    }
}

class Formulario
{
    function input($label, $tipo, $nomeid, $valor, $classe = "", $extras = "")
    {

        echo "<label>$label <input type='$tipo' name='$nomeid' id='$nomeid' value='$valor' class='form-control $classe'  $extras required></label>";
    }
    function inputNR($label, $tipo, $nomeid, $valor, $classe = "", $extras = "")
    {

        echo "<label>$label <input type='$tipo' name='$nomeid' id='$nomeid' value='$valor' class='form-control $classe'  $extras></label>";
    }

    function select_abre($label, $nomeid)
    {
        echo "<select class='form-select' name='$nomeid' id='$nomeid'>";
    }
    function option($valor, $texto)
    {
        echo "<option value='$valor'>$texto</option>";
    }
    function select_fecha()
    {
        echo "</select>";
    }
}

?>

<script>
    $(document).ready(function() {

        $("#btenviar").click(function() {
            //alert();
            //console.log($("#formularioobito").serialize());
            var link = '?setor=adm&sub=producao&subsub=obitos&acao=enviar&' + $("#formularioobito").serialize();
            console.log(link);            
            $.get(link, function(data) {

               window.location.replace('?setor=adm&sub=producao&subsub=obitos');
               


            });



        });


        function Atualiza(idfalecido, campo, novo_valor, celula) {

            if (celula.data('tipo') == 'datetime-local') {

                var data_input = novo_valor;
                var novo_valor_br = data_input.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*).*/, '$3\/$2\/$1 $4:$5');
                var novo_valor = data_input.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*).*/, '$1-$2-$3 $4:$5:00');
                celula.data('date', data_input);
                //

            }
            var link = '?setor=adm&sub=producao&subsub=obitos&acao=enviar&id=' + idfalecido + '&att_campo=' + campo + '&att_valor=' + novo_valor;
            if (celula.data('tipo') == 'datetime-local') {
                novo_valor = novo_valor_br;
            }
            $.get(link, function(data) {

                celula.html(novo_valor);




            });


        }


        $('.editavel').dblclick(function() {
            var celula = $(this);

            var idfalecido = celula.data('idfalecido');
            var tipo_input = celula.data('tipo');
            if (tipo_input == 'datetime-local') {
                var valor = celula.data('date');
            } else {
                var valor = celula.text();
            }
            var campo = celula.data('campo');
            var html = '<form id="att_form"><input type="' + tipo_input + '" id="editandoobito" value="' + valor + '"><input type="submit" value="Atualiza"></form>';
            celula.html(html);
            $('#editandoobito').focus();
            $('#editandoobito').select();
            $('#att_form').submit(function() {
                event.preventDefault();
                var input = $('#editandoobito');
                var novo_valor = input.val();
                Atualiza(idfalecido, campo, novo_valor, celula);
            });
        });





    });
</script>
<?php


$id = pega('id');
$dataentrada = pega('dataentrada');
$nomefalecido = pega('nomefalecido');
$numeroregistro = pega('numeroregistro');
$dataobito = pega('dataobito');
$ndeclaracao_obito = pega('ndeclaracao_obito');
$obs = pega('obs');
$diag_a = pega('diag_a');
$diag_b = pega('diag_b');
$diag_c = pega('diag_c');
$diag_d = pega('diag_d');
$diag_e = pega('diag_e');
$diag_f = pega('diag_f');

$att_campo = pega('att_campo');
$att_valor = pega('att_valor');

echo "<h3>Registro de óbitos</h3>";
pula(1);
echo "<form id='formularioobito' class='form-control needs-validation was-validated'>";
$form = new Formulario;


$form->input('', 'hidden', 'id', $id);

$form->input('Data de entrada', 'datetime-local', 'dataentrada', $dataentrada);


$form->input('Numero do Prontuário', 'text', 'numeroregistro', $numeroregistro);

$form->input('Nome do falecido', 'text', 'nomefalecido', $nomefalecido, "w-100", 'size="100%"');


pula(2);
$form->input('Data do Óbito', 'datetime-local', 'dataobito', $dataobito);

$form->input('Nº D.O:', 'text', 'ndeclaracao_obito', $ndeclaracao_obito);
pula(2);

$form->inputNR('Causa da morte - A', 'text', 'diag_a', $diag_a);
$form->inputNR('Causa da morte - B', 'text', 'diag_b', $diag_b);
$form->inputNR('Causa da morte - C', 'text', 'diag_c', $diag_c);
$form->inputNR('Causa da morte - D', 'text', 'diag_d', $diag_d);
$form->inputNR('Causa da morte - E', 'text', 'diag_e', $diag_e);
$form->inputNR('Causa da morte - F', 'text', 'diag_f', $diag_f);


//$form->input('Observação', 'text', 'obs', $ndeclaracao_obito);
pula(2);
$form->select_abre('Observação', 'obs');
$form->option('UPA', 'UPA');
$form->option('DOMICILIO', 'DOMICILIO');
$form->option('IML', 'IML');
$form->select_fecha();
pula(2);


$form->input('', 'submit', 'btenviar', 'Enviar');

echo "</form>";

$acao = pega('acao');
if ($acao == 'enviar') {
    echo "enviado";
    if ($id != "") {
        echo "para atualizar";
        $dataentrada = str_replace('T', ' ', $dataentrada) . ':00';
        $dataobito = str_replace('T', ' ', $dataobito) . ':00';
        $query = "UPDATE u940659928_siupa.tb_obitos SET $att_campo = '$att_valor' WHERE id='$id'";


        if (mysqli_query($conn, $query)) {
            $last_id = mysqli_insert_id($conn);
            print("<script>alert('Atualizado com Sucesso!');
            var link2 = '?setor=adm&sub=producao&subsub=obitos';
            window.location.replace(link2);
            </script>");
        } else {
            echo "Opa! Algo deu errado! \n Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "para adicionar";


        $dataentrada = str_replace('T', ' ', $dataentrada) . ':00';
        $dataobito = str_replace('T', ' ', $dataobito) . ':00';

        $query = "INSERT INTO u940659928_siupa.tb_obitos (dataentrada, nomefalecido, numeroregistro, dataobito, ndeclaracao_obito, diag_a, diag_b, diag_c, diag_d, diag_e, diag_f, obs) VALUES ('$dataentrada', '$nomefalecido', '$numeroregistro', '$dataobito','$ndeclaracao_obito', '$diag_a', '$diag_b', '$diag_c', '$diag_d', '$diag_e', '$diag_f', '$obs')";
        
        
        if (mysqli_query($conn, $query)) {
            $last_id = mysqli_insert_id($conn);
            echo "Novo Registro adicionado com sucesso. Ultimo ID inserido foi: " . $last_id;
            print("<script>alert('Sucesso!');
                    var link2 = '?setor=adm&sub=producao&subsub=obitos';
            window.location.replace(link2);

                    $('#formularioobito ').trigger('reset');

                    </script>");
        } else {
            echo "Opa! Algo deu errado! \n Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
} else {
    echo "nao enviado";
}
echo '
<table class="table  table-bordered  border-primary">
        <thead>
          <tr>
            <th scope="col">ID#</th>
            <th scope="col">DATA DE ENTRADA</th>
            <th scope="col">NOME DO FALECIDO</th>
            <th scope="col">NUMERO PRONTUÁRIO</th>
            <th scope="col">DATA DO OBITO</th>
            <th scope="col">Nº DECL. OBITO</th>
            <th scope="col" colspan="6">Causas da morte</th>
            <th scope="col">Observação</th>
          </tr>
        </thead>
        <tbody>
        ';
$query = "SELECT id, DATE_FORMAT(dataentrada, '%Y-%m-%d %H:%i'), DATE_FORMAT(dataentrada, '%d\/%m\/%Y %H:%i'), nomefalecido, numeroregistro, DATE_FORMAT(dataobito, '%Y-%m-%dT%H:%i'), DATE_FORMAT(dataobito, '%d\/%m\/%Y  %H:%i'), ndeclaracao_obito, diag_a, diag_b, diag_c, diag_d, diag_e, diag_f, obs  FROM u940659928_siupa.tb_obitos ORDER BY id DESC";


if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id, $dataentrada, $dataentrada_br, $nomefalecido, $numeroregistro, $dataobito, $dataobito_br, $ndeclaracao_obito, $diag_a, $diag_b, $diag_c, $diag_d, $diag_e, $diag_f, $obs);
    while ($stmt->fetch()) {
        $link = "?setor=adm&sub=producao&subsub=obitos&id=$id&dataentrada=$dataentrada&nomefalecido=$nomefalecido&numeroregistro=$numeroregistro&dataobito=$dataobito";
        printf("<tr>
        <td data-idfalecido='$id' data-campo='id'>%s</td>
        <td style='text-align:center' class='dataentrada editavel' data-idfalecido='$id' data-campo='dataentrada' data-tipo='datetime-local' data-date='%s'>%s</td>
        <th scope='row' class='nomefalecido editavel' data-idfalecido='$id' data-campo='nomefalecido'  data-tipo='text'>%s</a></th>
        <td style='text-align:center'class='numeroregistro editavel' data-idfalecido='$id' data-campo='numeroregistro'  data-tipo='text'>%s</td>
        <td style='text-align:center' class='dataobito editavel' data-idfalecido='$id' data-campo='dataobito'  data-tipo='datetime-local' data-date='%s'>%s</td>
        <td class='ndeclaracao_obito editavel' data-idfalecido='$id' data-campo='ndeclaracao_obito'  data-tipo='text'>%s</td>
        <td class='diag_a editavel' data-idfalecido='$id' data-campo='diag_a'  data-tipo='text'>%s</td>
        <td class='diag_b editavel' data-idfalecido='$id' data-campo='diag_b'  data-tipo='text'>%s</td>
        <td class='diag_c editavel' data-idfalecido='$id' data-campo='diag_c'  data-tipo='text'>%s</td>
        <td class='diag_d editavel' data-idfalecido='$id' data-campo='diag_d'  data-tipo='text'>%s</td>
        <td class='diag_e editavel' data-idfalecido='$id' data-campo='diag_e'  data-tipo='text'>%s</td>
        <td class='diag_f editavel' data-idfalecido='$id' data-campo='diag_f'  data-tipo='text'>%s</td>
        <td class='obs editavel' data-idfalecido='$id' data-campo='obs'  data-tipo='text'>%s</td>

      </tr>", $id, $dataentrada, $dataentrada_br, $nomefalecido, $numeroregistro, $dataobito, $dataobito_br, $ndeclaracao_obito, $obs);
    }
    $stmt->close();
}

echo '</tbody>
</table>';

?>