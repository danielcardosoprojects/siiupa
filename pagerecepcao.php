<?php
require_once("conectabd.php");
?>
<script type="text/javascript" src="js/script.js"></script>
<style>

</style>


<div style="float:left"><button id="bformcadastropaciente"><img src="imagens/addusuario.png" width="10px" />Cadastrar Paciente</button></div>
<div style="float:left"><input size="30" type="text" name="nomedamae" placeholder="Buscar pelo nome" class=" text ui-widget-content ui-corner-all" style="height:35px;" />
	<button>Buscar</button>
</div>

<div style="clear:both;"></div>
<div style="background-color:#fff;padding:2px;margin-top:5px;" class="ui-widget-content ui-corner-all">
	<h2>Últimos cadastros</h2>

	<table id="tabelapacientes" class="tblGrid" cellpadding="1" cellspacing="0" bordercolor="#000;" border="1" width="100%" style="border-collapse: collapse">
		<?php
		$sql = "SELECT * FROM u940659928_siupa.tb_cadastro ORDER BY id_paciente DESC";
		$res = mysqli_query($conectaobd, $sql);

		//Exibe as linhas encontradas na consulta 

		?>
		<thead bgcolor="#00A3D9">
			<tr>
				<th>Senha</th>
				<th>Nome</th>
				<th>Último Prontuário</th>

			</tr>
		</thead>
		<tbody>

			<?php
			while ($row = mysqli_fetch_array($res)) {
				echo "<tr><td>";
				echo $row['id_paciente'];
				echo "</td>";


				echo "<td>";
				echo $row['nomecompleto'];
				echo "	</td><td style='text-align:center;font-size:10px;'><a href='/siiupa/gerapdf.php?id_paciente=" . $row['id_paciente'] . "' target='_blank' class='abreprontuario'>Prontuários</a><button>Editar</button><button>Imprimir</button></tr>";
			} ?>


		</tbody>
	</table>


</div>