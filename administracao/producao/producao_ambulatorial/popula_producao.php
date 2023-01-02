<?php


$json = '{
    "DATA": "2022-02-01",
    "mes_abrev": "FEV",
    "quadrimestre": "1° Q",
    "ano": "2022",
    "idade.0_13": "734",
    "idade.14_21": "580",
    "idade.22_59": "3134",
    "idade.60_idoso": "789",
    "sexo.feminino": "2649",
    "sexo.masculino": "2588",
    "CRISE_HIPERTENSIVA": "1132",
    "COM_CARTAO_SUS": "4069",
    "SEM_CARTAO_SUS": "1168",
    "COM_CLASSIFICACAO": "4933",
    "SEM_CLASSIFICACAO": "304",
    "PA": "5427",
    "PULSOFC": "3693",
    "FR": "893",
    "INALACAO": "0",
    "GLICEMIA": "1252",
    "TEMPERATURA": "5747",
    "PESO": "532",
    "SURTO_PSICOTICO": "10",
    "HEMOPA": "19",
    "SUSIPE": "21",
    "MEDICAMENTOS": "11298",
    "CONSULTA_MEDICO": "8335",
    "CONSULTA_ENFERMEIRO": "9095",
    "CONSULTA_SERVICO_SOCIAL": "179",
    "ACIDTRANSITO.MOTO_X_CARRO": "44",
    "ACIDTRANSITO.MOTO_X_MOTO": "25",
    "ACIDTRANSITO.MOTO_X_VEICULO_GRANDE": "0",
    "ACIDTRANSITO.MOTO_-_QUEDA": "132",
    "ACIDTRANSITO.MOTO_-_OUTROS": "10",
    "ACIDTRANSITO.VEICULO_GRANDE": "0",
    "ACIDTRANSITO.CARRO_-_CAPOTAMENTO": "4",
    "ACIDTRANSITO.CARRO_X_CARRO": "1",
    "ACIDTRANSITO.CARRO_X_VEICULO_GRANDE": "1",
    "ACIDTRANSITO.CARRO_OUTROS": "18",
    "ACIDTRANSITO.ATROPELAMENTO": "21",
    "QUEDA.BICICLETA": "21",
    "AGRESSAO.FAB": "24",
    "AGRESSAO.FAF": "17",
    "ACID.TRABALHO": "38",
    "GESTANTE": "31",
    "AGRESSAO.FISICA": "18",
    "TRAUMA": "84",
    "QUEDA.PROPRIA_ALTURA": "126",
    "QUEDA._1m": "28",
    "QUEDA.CAMA": "13",
    "QUEDA.ESCADA": "14",
    "QUEDA.CAVALO": "1",
    "QUEDA.ARVORE": "3",
    "QUEDA.REDE": "16",
    "QUEDA.TELHADO": "1",
    "QUEDA.OUTROS": "8",
    "TENTATIVA_DE_SUICIDIO": "4",
    "TOTAL.ATEND_GERAL": "5237",
    "TOTAL.ACIDTRANSITO.MOTO": "211",
    "TOTAL.ACIDTRANSITO.CARRO": "24",
    "TOTAL.ACIDTRANSITO.VEICG": "0",
    "TOTAL.ACIDTRANSITO": "256",
    "OBSERVACAO": "539",
    "URGENCIA": "144",
    "EXAMES.LABORATORIO": "7223",
    "EXAMES.RAIO_X": "2416",
    "ATEND.ODONTOLOGIA": "359",
    "EXAMES.ELETROCARDIOGRAMA": "449",
    "TOTAL.SUTURA_CURATIVO": "205",
    "TOTAL.QUEDA": "210",
    "CURATIVO": "111",
    "IMOBILIZACAO": "14",
    "SUTURA": "71",
    "RETIRADA_CORPO_ESTRANHO": "9",
    "LAVAGEM": "0"
}';

$array = json_decode($json, true);



include_once('../../../bd/conectabd.php');
$busca = new BD;
$busca = $busca->conecta();
$id = $_GET['id'];
//$json = "{".$_GET['json']."}";

//$array = json_decode($json, true);

foreach($array as $valor) {
    $campo = key($array);
    echo $campo." -> ".$valor."<br>";


   
   $sql = "UPDATE `db_producao`.`producao_ambulatorial` SET `$campo` = '$valor' WHERE (`id` = '$id');";
   $insere = $busca->prepare($sql);
   $insere->execute();
   
    echo $sql;
   
    next($array);
   
    
    
}

/*
$sql = "INSERT INTO `db_producao`.`producao_ambulatorial` (`nome`, `fk_cargo`, `fk_setor`, `vinculo`, `status`) VALUES ('$nome', '$fk_cargo', '$fk_setor','$vinculo','$status')";
    
    
 
*/

?>