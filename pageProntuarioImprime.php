<table id="tabelapacientes" class="tblGrid" cellpadding="1" cellspacing="0" bordercolor="#000;" border="1" width="100%" style="border-collapse: collapse;font-family:arial">
<?php
@require_once("conectabd.php");
$idpaciente = $_GET['id_paciente'];
$sql = "SELECT * FROM u940659928_siupa.tb_cadastro WHERE id_paciente='$idpaciente'";
    $res = mysqli_query($conectaobd,$sql);

//Exibe as linhas encontradas na consulta 
	
	?>
		
			<tbody>
			
				
	<tr><td><img src=imagens/upa24hp.png></img></td><td style="text-align:center;">PREFEITURA MUNICIPAL DE CASTANHAL<br>SECRETARIA MUNICIPAL DE SAÚDE E MEIO AMBIENTE<br>UNIDADE DE PRONTO ATENDIMENTO<BR>UPA III - CASTANHAL</td><td><img src=imagens/PMCDAN.png width=70></img></td></tr>
	</tbody>
	</table>
	<table id="tabelapacientes2" class="tblGrid" cellpadding="1" cellspacing="0" bordercolor="#000;" border="1" width="100%" style="border-collapse: collapse;text-align:center;">
	<tbody>
	<tr><td><?php
				while ($row = mysqli_fetch_array($res)) {
					?>
	<?php echo $row['id_paciente']; ?>
	</td>
    

					<td><?php echo $row['nomecompleto']; ?>
					</td><td style='text-align:center;font-size:10px;'><button>Prontuários</button><button>Editar</button><button>Imprimir</button></tr>
				    
					

			
</tbody>
</table>

<br>
<b>Cartão SUS:</b> <?php echo $row['cartaosus']; ?>
<br>
<b>Nome:</b> <?php echo $row['nomecompleto']; ?> <b>Data de Nascimento:</b> <?php echo $row['datadenascimento']; ?>

<b>Sexo:</b> <?php echo $row['sexo']; ?>
<?php } ?>