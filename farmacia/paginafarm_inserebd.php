<?php

use SimpleCrud\Fields\Datetime;

include_once("../bd/conectabd.php");


if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];
} else {
    $acao = $_GET['acao'];
}


if ($acao == 'entradamovimento') {

    $idUsuario = $_SESSION['idUsuario'];

    $tipo_movimento = $_POST['tipo_movimento']; 
    $origem = $_POST['origem'];
    $destino = $_POST['destino'];
    var_dump($destino);
    $chave = $_POST['chave'];
    $registroEstorno = "";

    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $datahora = "$data $hora:00";

    if (isset($_POST['profissional'])) {
        $profissional = $_POST['profissional'];
    } else {
        $profissional = 0;
    }


    //captura todos os itens do movimento e faz um loop
    $itens = $_POST['arrayitem'];
    foreach ($itens as $item) {


        $item_fk = $item['id'];
        $categoria = $item['categoria'];
        $qtd = $item['qtd']; //quantidade a ser movimentada
        $qtd_total = $qtd; //guarda a quantidade que foi movimentada
        $qtd_total_solicitada = $qtd; //guarda de novo a quantidade que foi movimentada
        
        $estoque = new BD;
        $sqlE = "SELECT sum(estoque) as qtd_atual FROM db_farmacia.tb_farmestoque  where item_fk = '$item_fk'";




        if ($stmt = $conn->prepare($sqlE)) {
            $stmt->execute();
            $stmt->bind_result($qtd_atual);
            while ($stmt->fetch()) {
            }
            $stmt->close();
        }

        //trata se for nulo para inteiro 0

        if ($qtd_atual == '' || $qtd_atual == null) {
            $qtd_atual = '0';
        }



        //Caso seja entrada, soma. Caso seja saida, subtrai.
        if ($tipo_movimento == "entrada") {
            $estoqueAnterior = intval($qtd_atual);
            $novoEstoque = intval($qtd_atual) + intval($qtd);
            
        } else {
            $estoqueAnterior = intval($qtd_atual);
            $novoEstoque = intval($qtd_atual) - intval($qtd);
            
        }

        $nomeproduto = utf8_encode($item['nomeproduto']);
        $lote = $item['lote'];
        $validade = $item['validade'];
        $barcode_lote = $item['barcode'];






        //LOTE Verifica se o lote já existe. Se existir irá atualizar o lote, se não existe irá criar novo.
        $buscaLote = new BD;
        $sqlLote = "SELECT estoque FROM db_farmacia.tb_farmestoque where lote='$lote' and item_fk='$item_fk'";

        $buscaLote = $buscaLote->conecta();
        $consultaLote = $buscaLote->prepare($sqlLote);
        $consultaLote->execute();

        var_dump($consultaLote->rowCount());
        if ($consultaLote->rowCount() == 0) {
            $novoLote = new BD;
            
            $sqlNovoLote = "INSERT INTO db_farmacia.tb_farmestoque(id, item_fk, nome_produto, lote, barcode, data_validade, estoque, user, chave) VALUES (NULL, $item_fk, '$nomeproduto', '$lote', '$barcode_lote', '$validade', $qtd, $idUsuario, '$chave')";
            echo $sqlNovoLote;
            $novoLote = $novoLote->conecta();
            $cadastraLote = $novoLote->prepare($sqlNovoLote);
            $cadastraLote->execute();
            $sqlPegaIdDesteLote = "SELECT id FROM db_farmacia.tb_farmestoque where chave = '$chave'";
            $pegaIdDesteLote = new BD;
            $pegaIdDesteLote->consulta($sqlPegaIdDesteLote);
            foreach ($pegaIdDesteLote as $idDesteLote){
            $registroEstorno .= "'$idDesteLote->id':'$qtd',";

            }
        } else {
            $atualizaLote = new BD;
            date_default_timezone_set("America/Belem");
            $atualizado_em = date("Y-m-d H:i:s");
            foreach ($consultaLote as $loteObj) {
                var_dump($loteObj);
                $qtd_nova = $loteObj['estoque'] + $qtd;
            }
            $sqlAttLote = "UPDATE db_farmacia.tb_farmestoque SET estoque='$qtd_nova', updated_at='$atualizado_em', chave='$chave' where lote='$lote' and item_fk='$item_fk'";
            $sqlPegaIdDesteLote = "SELECT id FROM db_farmacia.tb_farmestoque where lote='$lote' and item_fk='$item_fk'";
            $pegaIdDesteLote = new BD;
            $pegaIdDesteLote->consulta($sqlPegaIdDesteLote);
            foreach ($pegaIdDesteLote as $idDesteLote){
            $registroEstorno .= "'$idDesteLote->id':'$qtd',";

            }

            echo $sqlAttLote;
            $atualizaLote = $atualizaLote->conecta();
            $attLote = $atualizaLote->prepare($sqlAttLote);
            $attLote->execute();
        }

        //busca chave unica para garantir que o estoque realmente foi atualizado e só então registra o movimento
        
        $bChave = new BD;
        $sqlChave = "SELECT chave FROM db_farmacia.tb_farmestoque where chave='$chave'";

        $bChave = $bChave->conecta();
        $consultChave = $bChave->prepare($sqlLote);
        $consultChave->execute();

        var_dump($consultChave->rowCount());
        //Registra o movimento se o estoque estiver sido registrado
        if ($consultChave != 0) {

            $busca = new BD;
            $sql = "INSERT INTO db_farmacia.tb_farmmovimento (`profissional_fk`, `id`, `item_fk`, `tipo`, `setor_origem_fk`, `setor_dest_fk`, `datahora`, `observacao`, `quantidade`, `novoestoque`, `estoqueanterior`, `usuario`) VALUES ($profissional, NULL, '$item_fk', '$tipo_movimento', '$origem', '$destino', '$datahora', NULL, '$qtd_total_solicitada', '$novoEstoque', '$estoqueAnterior', '$idUsuario')";
            echo $sql;

            $busca = $busca->conecta();
            $insere = $busca->prepare($sql);
            $insere->execute();
        }

        //Atualiza o estoque
        $attE = new BD;

        $sqlAttE = "UPDATE db_farmacia.tb_farmitem SET quantidade='$novoEstoque' WHERE id=$item_fk";




        $attE = $attE->conecta();
        $atualiza = $attE->prepare($sqlAttE);
        $atualiza->execute();

        echo "Adicionado com sucesso!";
        //echo $sql;
        var_dump($itens);
        echo "<script>window.location.href='/siiupa/farmacia';</script>";
    }
} elseif ($acao == 'saidamovimento') {



    $idUsuario = $_SESSION['idUsuario'];

    $tipo_movimento = $_POST['tipo_movimento'];
    $origem = $_POST['origem'];
    $destino = $_POST['destino'];
    $chave = $_POST['chave'];


    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $datahora = "$data $hora:00";

    if (isset($_POST['profissional'])) {
        $profissional = $_POST['profissional'];
    } else {
        $profissional = 0;
    }



    $itens = $_POST['arrayitem'];
    foreach ($itens as $item) {


        $item_fk = $item['id'];
        $categoria = $item['categoria'];
        $qtd = $item['qtd'];
        $qtd_total_solicitada = $qtd;

        $estoque = new BD;
        $sqlE = "SELECT sum(estoque) as qtd_atual FROM db_farmacia.tb_farmestoque  where item_fk = '$item_fk'";




        if ($stmt = $conn->prepare($sqlE)) {
            $stmt->execute();
            $stmt->bind_result($qtd_atual);
            while ($stmt->fetch()) {
            }
            $stmt->close();
        }

        //trata se for nulo para inteiro 0
        
        if ($qtd_atual == '' || $qtd_atual == null) {
            $qtd_atual = '0';
        }
        



        //Caso seja entrada, soma. Caso seja saida, subtrai.
        if ($tipo_movimento == "entrada") {
            $novoEstoque = intval($qtd_atual) + intval($qtd);
            $estoqueAnterior = intval($qtd_atual);
        } else {
            $novoEstoque = intval($qtd_atual) - intval($qtd);
            $estoqueAnterior = intval($qtd_atual);
        }
        var_dump($item);

        $buscaLotes = new BD;
        $sqlBuscaLotes = "SELECT * FROM db_farmacia.tb_farmestoque where item_fk='$item_fk' AND estoque>0 order by data_validade ASC;";


        $organizaLotes = $buscaLotes->consulta($sqlBuscaLotes);
        var_dump($organizaLotes);
        foreach ($organizaLotes as $cadaLote) {
            $qtd_total = $qtd;
            if ($cadaLote->estoque >= $qtd_total) {
                $saidaLote = new BD;
                $sqlSaidaLotes = "UPDATE db_farmacia.tb_farmestoque SET estoque = estoque-$qtd, chave='$chave' WHERE lote='$cadaLote->lote' and item_fk='$item_fk'";

                $saidaLote = $saidaLote->conecta();
                $attSaidaLote = $saidaLote->prepare($sqlSaidaLotes);
                $attSaidaLote->execute();
                break;
            } else {
                $qtd = $qtd - $cadaLote->estoque;
                $saidaLote = new BD;
                $sqlSaidaLotes = "UPDATE db_farmacia.tb_farmestoque SET estoque = 0, chave='$chave' WHERE lote='$cadaLote->lote' and item_fk='$item_fk'";

                $saidaLote = $saidaLote->conecta();
                $attSaidaLote = $saidaLote->prepare($sqlSaidaLotes);
                $attSaidaLote->execute();
                echo $sqlSaidaLotes;
            }
        }


        //busca chave unica para garantir que o estoque realmente foi atualizado e só então registra o movimento
        echo "teste";
        $bChave = new BD;
        $sqlChave = "SELECT chave FROM db_farmacia.tb_farmestoque where chave='$chave'";
        echo "teste";
        $bChave = $bChave->conecta();
        echo "teste";
        $consultChave = $bChave->prepare($sqlChave);
        echo "testex";
        $consultChave->execute();

        echo "teste";
        var_dump($consultChave->rowCount());

        if ($consultChave != 0) {

            $busca = new BD;
            $sql = "INSERT INTO db_farmacia.tb_farmmovimento (`profissional_fk`, `id`, `item_fk`, `tipo`, `setor_origem_fk`, `setor_dest_fk`, `datahora`, `observacao`, `quantidade`, `novoestoque`, `estoqueanterior`, `usuario`) VALUES ($profissional, NULL, '$item_fk', '$tipo_movimento', '$origem', '$destino', '$datahora', NULL, '$qtd_total_solicitada', '$novoEstoque ', '$estoqueAnterior', '$idUsuario')";

            
            $busca = $busca->conecta();
            $insere = $busca->prepare($sql);
            $insere->execute();
        }
        
    }
    echo "<script>window.location.href='/siiupa/farmacia';</script>";
} elseif ($acao == "cadastraProfissional") {

    $nome = utf8_encode($_POST['nome']);
    $cargo = utf8_decode($_POST['cargo']);
    $conselho = $_POST['conselho'];


    $addProfissional = new BD;
    $queryAddProfissional = "INSERT INTO db_farmacia.tb_farmprofissional (profissional, funcao, n_conselho) VALUES ('$nome', '$cargo', '$conselho')";


    $addProfissional = $addProfissional->conecta();
    $executa = $addProfissional->prepare($queryAddProfissional);
    $executa->execute();

    echo "Cadastrado com sucesso.";
    echo utf8_encode($nome);
} elseif ($acao == "atualizaProfissional") {
    $idProfissional = $_POST['id'];
    $nome = utf8_decode($_POST['nome']);
    $cargo = utf8_decode($_POST['cargo']);
    $conselho = $_POST['conselho'];
    $attProfissional = new BD;

    $queryAttProfissional = "UPDATE db_farmacia.tb_farmprofissional SET profissional = '$nome', funcao = '$cargo', n_conselho='$conselho' WHERE (id = '$idProfissional')";

    $attProfissional = $attProfissional->conecta();
    $executa = $attProfissional->prepare($queryAttProfissional);
    $executa->execute();

    echo "Atualizado com sucesso.";
} elseif ($acao == "novosetor") {
    $setor = $_POST['setor'];

    $addSetor = new BD;
    $queryAddSetor = "INSERT INTO db_farmacia.tb_farmsetor (setor) VALUES ('$setor')";


    $addSetor = $addSetor->conecta();
    $executa = $addSetor->prepare($queryAddSetor);
    $executa->execute();

    echo "<script>$.alert('Setor Cadastrado com Sucesso');window.location.reload()</script>";
} elseif ($acao == "editasetor") {
    $setor = utf8_decode($_POST['setor']);
    $idSetor = $_POST['id'];

    $attSetor = new BD;
    $queryAttSetor = "UPDATE db_farmacia.tb_farmsetor SET setor = '$setor' WHERE (id = '$idSetor')";

    $attSetor = $attSetor->conecta();
    $executa = $attSetor->prepare($queryAttSetor);
    $executa->execute();

    echo "<script>$.alert('Setor atualizado com Sucesso');$('#dialogSetor').load('/siiupa/farmacia/setor');</script>";
} elseif ($acao == "novoGenero") {
    $novoGenero = $_POST['novoGenero'];

    $attSetor = new BD;
    $query = "INSERT INTO db_farmacia.tb_farmgenero (genero) VALUES ('$novoGenero')";

    $attSetor->insere($query);

    echo "Genero cadastrado com sucesso!";
} elseif ($acao == "novaCategoria") {
    $novaCategoria = utf8_decode($_POST['novaCategoria']);

    $attSetor = new BD;
    $query = "INSERT INTO db_farmacia.tb_farmcategoria (categoria) VALUES ('$novaCategoria')";

    $attSetor->insere($query);

    echo "Classe cadastrada com sucesso!";
} elseif ($acao == "novoItem") {
    $addItem = new BD;

    $nome_ant = $_POST['nome'];
    $caracteres_sem_acento = array(
        'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Â' => 'Z', 'Â' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
        'Ï' => 'I', 'Ñ' => 'N', 'Å' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
        'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'Å' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f',
        'Ä' => 'a', 'î' => 'i', 'â' => 'a', 'È' => 's', 'È' => 't', 'Ä' => 'A', 'Î' => 'I', 'Â' => 'A', 'È' => 'S', 'È' => 'T',
    );
    $nome = strtr($nome_ant, $caracteres_sem_acento);
    $categoria_fk = intval($_POST['categoria']);
    $categoria2_fk = intval($_POST['categoria2']);
    $categoria3_fk = intval($_POST['categoria3']);
    $categoria4_fk = intval($_POST['categoria4']);
    $genero_fk = intval($_POST['genero']);
    $barcode = $_POST['barcode'];
    $unidade = '';
    $quantidade = 0;

    $query = "INSERT INTO db_farmacia.tb_farmitem (nome, categoria_fk, categoria2_fk, categoria3_fk, categoria4_fk, genero_fk, barcode, unidade, quantidade) VALUES ('$nome', '$categoria_fk', '$categoria2_fk', '$categoria3_fk', '$categoria4_fk', '$genero_fk', '$barcode', '$unidade', '$quantidade')";

    $addItem->insere($query);

    echo "Item cadastrado com sucesso! $nome";
} elseif ($acao == "editaItem") {
    $addItem = new BD;

    $iditem = $_POST['id'];
    $nome_ant = utf8_decode($_POST['nome']);
    $caracteres_sem_acento = array(
        'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Â' => 'Z', 'Â' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
        'Ï' => 'I', 'Ñ' => 'N', 'Å' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
        'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'Å' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f',
        'Ä' => 'a', 'î' => 'i', 'â' => 'a', 'È' => 's', 'È' => 't', 'Ä' => 'A', 'Î' => 'I', 'Â' => 'A', 'È' => 'S', 'È' => 'T',
    );
    //$nome = strtr($nome_ant, $caracteres_sem_acento);
    $nome = $nome_ant;
    $nome_antigo_banco = new BD;
    $sqlNomeAntigo = "SELECT nome, historico_nome FROM db_farmacia.tb_farmitem where id='$iditem';";
    $nomes_antigos = $nome_antigo_banco->consulta($sqlNomeAntigo);
    $historico_nome_att = $nomes_antigos[0]->nome . ";" . $nomes_antigos[0]->historico_nome;

    


    $categoria_fk = intval($_POST['categoria']);
    $categoria2_fk = intval($_POST['categoria2']);
    $categoria3_fk = intval($_POST['categoria3']);
    $categoria4_fk = intval($_POST['categoria4']);
    $genero_fk = intval($_POST['genero']);
    $barcode = $_POST['barcode'];
    $unidade = '';
    $quantidade = 0;


    //$query = "INSERT INTO db_farmacia.tb_farmitem (nome, categoria_fk, genero_fk, barcode, unidade, quantidade) VALUES ('$nome', '$categoria_fk', '$genero_fk', '$barcode', '$unidade', '$quantidade')";
    $query = "UPDATE db_farmacia.tb_farmitem SET nome='$nome', categoria_fk='$categoria_fk', categoria2_fk='$categoria2_fk', categoria3_fk='$categoria3_fk', categoria4_fk='$categoria4_fk', genero_fk='$genero_fk', barcode='$barcode', unidade='$unidade', historico_nome='$historico_nome_att' where id='$iditem'";

    $attItem = new BD;
    $attItem = $attItem->conecta();
    $atualizaItem = $attItem->prepare($query);
    $atualizaItem->execute();

    echo "Item atualizado com sucesso!";
} elseif ($acao == "uniritem") {
    $esse = $_GET['esse'];
    $outro = $_GET['outro'];
    //UPDATE `db_farmacia`.`tb_farmmovimento` SET `item_fk` = '68' WHERE `item_fk` = '69');
    //UPDATE `db_farmacia`.`tb_farmestoque` SET `item_fk` = '690]' WHERE `item_fk` = '21');
    //DELETE FROM `db_farmacia`.`tb_farmitem` WHERE (`id` = '331');

    $attMov = "UPDATE db_farmacia.tb_farmmovimento SET item_fk = '$esse' WHERE item_fk = '$outro';";
    $attEst = "UPDATE db_farmacia.tb_farmestoque SET item_fk = '$esse' WHERE item_fk = '$outro';";
    $delItem = "DELETE FROM db_farmacia.tb_farmitem WHERE id = '$outro';";

    $unirM = new BD;
    $unirM = $unirM->conecta();
    $mov = $unirM->prepare($attMov);
    $mov->execute();

    $unirE = new BD;
    $unirE = $unirE->conecta();
    $est = $unirE->prepare($attEst);
    $est->execute();

    $dItem = new BD;
    $dItem = $dItem->conecta();
    $deletaItem = $dItem->prepare($delItem);
    $deletaItem->execute();

    echo "Mov: " . $mov->rowCount() . "<br>Est: " . $est->rowCount() . "<br>Del:    " . $deletaItem->rowCount();
} elseif ($acao == "atualizaloteval") {
    $idLote = $_POST['idlote'];
    $data = $_POST['datavalidade'];

    $sqlAttVal = "UPDATE db_farmacia.tb_farmestoque SET data_validade = '$data' WHERE (id = '$idLote')";
    $attVal = new BD;
    $rVal = $attVal->consulta($sqlAttVal);

    $feedBack = "SELECT data_validade FROM db_farmacia.tb_farmestoque WHERE id = '$idLote'";
    $fB = new BD;
    $dataValidadeNova = $fB->consulta($feedBack);
    echo $dataValidadeNova[0]->data_validade;
} elseif ($acao == "atualizalotenome") {
    $idLote = $_POST['idlote'];
    $nome = utf8_decode($_POST['nomelote']);
    $sqlAttNomeLote = "UPDATE db_farmacia.tb_farmestoque SET lote = '$nome' WHERE (id = '$idLote')";
    //echo $sqlAttNomeLote;
    $conAttNomeLote = new BD;
    $attNomeLote = $conAttNomeLote->consulta($sqlAttNomeLote);

    $feedBack = "SELECT lote FROM db_farmacia.tb_farmestoque WHERE id='$idLote'";
    $fB = new BD;
    $puxaNomeLote = $fB->consulta($feedBack);
    echo utf8_encode($puxaNomeLote[0]->lote);
}  elseif ($acao == "atualizalotebarcode") {
    $idLote = $_POST['idlote'];
    $barcode = utf8_decode($_POST['barcode']);
    $sqlAttNomeLote = "UPDATE db_farmacia.tb_farmestoque SET barcode = '$barcode' WHERE (id = '$idLote')";
    //echo $sqlAttNomeLote;
    $conAttNomeLote = new BD;
    $attNomeLote = $conAttNomeLote->consulta($sqlAttNomeLote);

    $feedBack = "SELECT barcode FROM db_farmacia.tb_farmestoque WHERE id='$idLote'";
    $fB = new BD;
    $puxaNomeLote = $fB->consulta($feedBack);
    echo utf8_encode($puxaNomeLote[0]->barcode);
} elseif ($acao == "atualizalotenomeproduto") {
    $idLote = $_POST['idlote'];
    $nomeproduto = utf8_decode($_POST['nomeproduto']);
    $sqlAttNomeLote = "UPDATE db_farmacia.tb_farmestoque SET nome_produto = '$nomeproduto' WHERE (id = '$idLote')";
    //echo $sqlAttNomeLote;
    $conAttNomeLote = new BD;
    $attNomeLote = $conAttNomeLote->consulta($sqlAttNomeLote);

    $feedBack = "SELECT nome_produto FROM db_farmacia.tb_farmestoque WHERE id='$idLote'";
    $fB = new BD;
    $puxaNomeLote = $fB->consulta($feedBack);
    echo utf8_encode($puxaNomeLote[0]->nome_produto);
}else {
    echo "Desviou";
    echo $acao;
}
