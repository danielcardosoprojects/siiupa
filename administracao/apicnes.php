<?php
header('Content-type: text/html; charset=utf-8');
include("../bd/conectabd.php");

$idfunc = $_GET['id'];

echo "<div style='color:dark'>";

$query = "SELECT f.nome, f.cpf, f.cns, f.conselho_tipo, f.conselho_n, f.sexo, f.mae, f.pai, DATE_FORMAT( f.data_nasc, \"%d/%m/%Y\" ), f.municipio_uf_nascimento, f.vinculo, c.cbo, c.descricao, c.carga_horaria, DATE_FORMAT( f.admissao, \"%d/%m/%Y\" ) FROM u940659928_siupa.tb_funcionario as f INNER JOIN u940659928_siupa.tb_cargo AS c on (fk_cargo = c.id) WHERE STATUS = \"ATIVO\" and f.id=$idfunc";



if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($nome, $cpf, $cns, $conselho_tipo, $conselho_n, $sexo, $mae, $pai, $data_nasc, $municipio_uf_nascimento, $vinculo, $cbo, $descricao, $carga_horaria_mes, $admissao);
    while ($stmt->fetch()) {
        //printf("%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s\n", $nome, $cpf, $cns, $sexo, $mae, $pai, $data_nasc, $municipio_uf_nascimento, $vinculo, $descricao, $admissao);
        $carga_horaria_semana = $carga_horaria_mes/4;

   echo "
        <table style='border:solid 1px #000'>
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>CPF</th>
                    <th>REGISTRO NO CONSELHO</th>
                    <th>...</th>
                    <th>...</th>
                    <th>CBO</th>
                    <th>CH SEMANAL</th>
                    <th>VÍNCULO</th>
                </tr>
            </thead>
    
        <tbody>
            <tr>
                <td style='border:solid 1px #000; text-align:center'>$nome</td>
                <td style='border:solid 1px #000; text-align:center'>$cpf</td>
                <td style='border:solid 1px #000; text-align:center'>$conselho_tipo $conselho_n</td>
                <td style='border:solid 1px #000; text-align:center'></td>
                <td style='border:solid 1px #000; text-align:center'></td>
                <td style='border:solid 1px #000; text-align:center'>$cbo</td>
                <td style='border:solid 1px #000; text-align:center'>$carga_horaria_mes</td>
                <td style='border:solid 1px #000; text-align:center'>$vinculo</td>
            </tr>
        </tbody>
    </table>
    <br />
    <br />
    <br />
    ";
    
        echo "<strong>UPA CASTANHAL - CNES 7474423 - SOLICITAÇÃO DE CADASTRO CNES - PROFISSIONAL ".strtoupper($nome)."</strong></br></br>
               

                TIPO: <strong>INCLUSÃO - SUS</strong>
                </br></br>

                <strong>NOME FANTASIA DO ESTABELECIMENTO:</strong></br>
                UPA PORTE III CASTANHAL GOVERNADOR ALMIR GABRIEL

                </br></br>";
        if ($vinculo == "TEMPORÁRIO") {
            $vinculacao = "VINCULO EMPREGATICIO - CONTRATO POR PRAZO DETERMINADO";
        } elseif ($vinculo == "EFETIVO") {
            $vinculacao = "VINCULO EMPREGATICIO - ESTATUTARIO";
        } elseif ($vinculo == "PRESTADOR") {
            $vinculacao = "VINCULO EMPREGATICIO - CONTRATO POR PRAZO DETERMINADO";
        } elseif ($vinculo == "COMISSIONADO") {
            $vinculacao = "CARGO COMISSIONADO - CARGO COMISSIONADO NÃO CEDIDO";
        } else {
            $vinculacao = "VINCULO EMPREGATICIO - CONTRATO POR PRAZO DETERMINADO";
        }
    


        printf("
        <strong>NOME DO PROFISSIONAL:</strong></br>%s</br></br>
        <strong>CPF:</strong></br>%s</br></br>
        <strong>CNS:</strong></br>%s</br></br>
        <strong>SEXO:</strong></br>%s</br></br>
        <strong>NOME DA MAE:</strong></br>%s</br></br>
        <strong>NOME DO PAI:</strong></br>%s</br></br>
        <strong>DATA DE NASCIMENTO:</strong></br>%s</br></br>
        <strong>MUNICÍPIO DE NASCIMENTO:</strong></br>%s</br></br>
        <strong>VINCULO:</strong></br>%s</br>%s<br></br>
        <strong>FUNÇÃO (CBO):</strong></br>%s - %s</br></br>
        <strong>CARGA HORÁRIA SEMANAL:</strong></br>%sh - amb</br></br>
        <strong>DATA DE ADMISSÃO:</strong></br>%s</br></br>
        ", strtoupper($nome), $cpf, $cns, $sexo, $mae, $pai, $data_nasc, strtoupper($municipio_uf_nascimento), $vinculo, $vinculacao, $cbo, $descricao, $carga_horaria_semana, $admissao);
    }

    $stmt->close();
}
echo "</div>";