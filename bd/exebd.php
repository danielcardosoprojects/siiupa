<?php
include("../bd/conectabd.php");



function cadFUNC($perfil)
{
    include("../bd/conectabd.php");
    $sql = "INSERT INTO tb_funcionario (id, nome, cpf, cns, fk_cargo, fk_setor, admissao, matricula, data_nasc, sexo, end_rua, end_numero, end_compl, end_bairro, telefone, telefone2, telefone3, email, ram, vinculo, status) VALUES (NULL, '$perfil->nome', '$perfil->cpf', '$perfil->cns', '$perfil->fk_cargo', '$perfil->fk_setor', '$perfil->admissao', '$perfil->matricula', '$perfil->data_nasc', '$perfil->sexo', '$perfil->end_rua', '$perfil->end_numero', '$perfil->end_compl', '$perfil->end_bairro', '$perfil->telefone', '$perfil->telefone2', '$perfil->telefone3', '$perfil->email', '$perfil->ram', '$perfil->vinculo', '$perfil->status')";


    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        echo "New record created successfully. Last inserted ID is: " . $last_id;
        Cadhistorico($last_id, "Funcionário Cadastrado.", "Funcionário Cadastrado", null, null);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function AttFUNC($dados)
{
    //UPDATE `tb_funcionario` SET 'nome' = $dados->nome, 'cpf' = $dados->cpf, 'cns' = $dados->cns, 'fk_cargo' = $dados->fk_cargo, 'fk_setor' = fk_setor, 'admissao' = $dados->admissao, 'matricula' = $dados->matricula, 'desligamento' = $dados->desligamento, 'data_nasc' = $dados->data_nasc, 'sexo' = $dados->sexo, 'end_rua' = $dados->end_rua, 'end_numero' = $dados->end_numero, 'end_compl' = $dados->end_compl, 'end_bairro' = $dados->end_bairro, 'telefone' = $dados->telefone, 'telefone2' = $dados->telefone2, 'telefone3' = $dados->telefone3, 'email' = $dados->email, 'ram' = $dados->ram, 'vinculo' = $dados->vinculo, 'status' = $dados->status WHERE `tb_funcionario`.`id` = $dados->id; 
    //STR_TO_DATE('$dados->admissao','%d/%m/%y')
    include("../bd/conectabd.php");
    $sqlatt = "UPDATE tb_funcionario SET nome = '$dados->nome',  cpf = '$dados->cpf', cns = '$dados->cns', fk_cargo = '$dados->fk_cargo', fk_setor = '$dados->fk_setor', admissao = '$dados->admissao', matricula = '$dados->matricula', data_nasc = '$dados->data_nasc', sexo = '$dados->sexo', end_rua = '$dados->end_rua', end_numero = '$dados->end_numero', end_compl = '$dados->end_compl', end_bairro = '$dados->end_bairro', telefone = '$dados->telefone', telefone2 = '$dados->telefone2', telefone3 = '$dados->telefone3', email = '$dados->email', ram = '$dados->ram', vinculo = '$dados->vinculo', status = '$dados->status' WHERE id='$dados->id'";

    
    if (mysqli_query($conn, $sqlatt)) {
        $last_id = mysqli_insert_id($conn);
        echo "Funcionário atualizado com sucesso.";
        Cadhistorico($dados->id, "Dados Atualizados", $dados->historico, null, null);
    } else {
        echo "Error: " . $sqlatt . "<br>" . mysqli_error($conn);
    }

    //'id = '$dados->id, nome' = $dados->nome, cpf' = $dados->cpf, cns' = $dados->cns, fk_cargo' = $dados->fk_cargo, fk_setor' = fk_setor, admissao' = $dados->admissao, 'matricula' = $dados->matricula, 'desligamento' = $dados->desligamento, 'data_nasc' = $dados->data_nasc, 'sexo' = $dados->sexo, 'end_rua' = $dados->end_rua, 'end_numero' = $dados->end_numero, 'end_compl' = $dados->end_compl, 'end_bairro' = $dados->end_bairro, 'telefone' = $dados->telefone, 'telefone2' = $dados->telefone2, 'telefone3' = $dados->telefone3, 'email' = $dados->email, 'ram' = $dados->ram, 'vinculo' = $dados->vinculo, 'status' = $dados->status, 
}


function Cadhistorico($idFunc, $titulo, $mensagem, $datainicio, $datafim)
{
   



    include("../bd/conectabd.php");
    $sql = "INSERT INTO tb_historico (id, fk_funcionario, titulo, descricao, data_inicio, data_fim, status) VALUES (NULL, $idFunc, '$titulo', '$mensagem', '$datainicio', '$datafim', 'OK'); ";
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        echo "Historico: " . $last_id;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


    mysqli_close($conn);
}

function Atthistorico($idFunc)
{
    include("../bd/conectabd.php");
    $sql = "INSERT INTO tb_historico (id, fk_funcionario, titulo, descricao, data_inicio, data_fim, status) VALUES (NULL, $idFunc, 'Funcionário cadastrado.', 'Dados de Funcionário atualizados.', NULL, NULL, 'OK'); ";
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        echo "Historico: " . $last_id;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


    mysqli_close($conn);
}
