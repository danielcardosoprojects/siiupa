<style type="text/css">
#formcadastro {
width:100%;

}
#formcadastro .form100 {
width:100%;
}

#formcadastro .floatleft {
float:left;


}

#formcadastro .floatright {
float:right;
margin-left:5px;
}
#formcadastropaciente span {
	margint:5px 0;
}

.linha5px {
width:100%;
	margin:5px 0;
}
#formcadastrapaciente{
	background-color:#ccc;
}

</style>

<div id="formcadastropaciente" title="Cadastrar Paciente">
	
<form id='formcadastrapaciente' name='formcadastrapaciente'>
	<label for="nomecompleto"><span>Nome completoa:</span>
		<input type="text" name="nomecompleto"  class="form100 text ui-widget-content ui-corner-all"/>
	</label><br/>

<label for="nomedamae">
	<span>Nome da mãe:</span>
	<input type="text" name="nomedamae"   class="form100 text ui-widget-content ui-corner-all"/>
	</label>
	<hr/>
<div style="overflow:hidden;"><!-- linha -->
	<span class="floatleft">
		<label for="idade"><span>Idade:</span>
			<input type="text" name="idade" size="2" class="text ui-widget-content ui-corner-all"/>			
		</label>
		<label for="datadenascimento"><span>Data de Nascimento:</span>
			 <input type="text" name="datadenascimento" id="datepicker" size="9" class="text ui-widget-content ui-corner-all">
		</label><script>$("#datepicker").mask("99/99/9999");</script>
	</span>

	<span class="" style="overflow:hidden;">
	<span>Sexo:</span>
		<label><input  type="radio" name="sexo" value="m"/>Masculino</label>
		<label><input  type="radio" name="sexo" value="f"/>Feminino</label>
	</span>

</div> 
<!--*************************** fimlinha***********************************************a-->

<div class="linha5px"></div>
<!-- ********************linha *********************************************************-->
<div style="overflow:hidden;">

<span class="floatleft">
		<label for="rg"><span>RG:</span>
			<input type="text" name="rg" size="11" class=" text ui-widget-content ui-corner-all"/>			
		</label>
		
		<label for="cpf"><span>CPF:</span>
			<input type="text" name="cpf" id="cpf" size="14" class=" text ui-widget-content ui-corner-all"/>			
		</label>
		<script>$("#cpf").mask("999.999.999-99");</script>
		
		<label for="cartaosus"><span>CNS:</span>
			<input type="text" name="cartaosus" size="11" class=" text ui-widget-content ui-corner-all"/>			
		</label>
		
	</span>


</div> 
<!-- *****************fimlinha***********************************************************************-->
<!-- ************************linha**************************************************** -->

<div class="linha5px"></div>

<div class="floatleft">

<label>
	<span>Telefone: </span>
	<input type="text" name="telefone1" id="telefone1" class="text ui-widget-content ui-corner-all" size="14">
</label><script>$("#telefone1").mask("(99) 9999-9999");</script>
<label>
	<span>Telefone: </span>
	<input type="text" name="telefone2" id="telefone2" class="telefone2xt ui-widget-content ui-corner-all" size="14">
</label><script>$("#telefone2").mask("(99) 9999-9999");</script>

<label>
	<span>Telefone: </span>
	<input type="text" name="telefone3" id="telefone3" class="text ui-widget-content ui-corner-all" size="14">
	</label><script>$("#telefone3").mask("(99) 9999-9999");</script>


</div>
<!--*********************fimlinha*****************************************************-->


<hr/>
<!--************************** linha *************************************************************-->
<div style="overflow:hidden;"><!-- linha -->
<label for="endereco_rua"><span>Endereço:</span>
			<input type="text" name="enderecoRua" class="text ui-widget-content ui-corner-all" size="50"/>			
		</label>
		
		<label for="enderecoNumero"><span>Número:</span>
			<input type="text" name="enderecoNumero" class="text ui-widget-content ui-corner-all" size="11"/>			
		</label><br/>

<div class="linha5px"></div>

		<label for="enderecoPerimetro"><span>Complemento:</span>
			<input type="text" name="enderecoPerimetro" class="text ui-widget-content ui-corner-all" size="12"/>			
		</label>
		<label for="enderecoBairro"><span>Bairro:</span>
			<input type="text" name="enderecoBairro" class="text ui-widget-content ui-corner-all" size="15"/>			
		</label>
		
		<label for="municipio"><span>Cidade:</span>
			<input type="text" name="municipio" class="text ui-widget-content ui-corner-all"/>			
		</label>
		
		
</div> <!-- fimlinha-->
<!--************************** fimlinha *************************************************************-->
<hr/>
<!--************************** linha *************************************************************-->
<div style="overflow:hidden;float:left;">
<div style="overflow:hidden;"><span><strong>Veio Acompanhado?</strong></span></div>
	<div class="floatleft" style="width:220px;float:left;">
	
	<label><input  type="radio" name="tipoacompanhante" value="Familiar"/>Familiar</label><br/>
	<label><input  type="radio" name="tipoacompanhante" value="Transeunte"/>Transeunte</label><br/>
	<label><input  type="radio" name="tipoacompanhante" value="Não acompanhado"/>Não acompanhado</label>
	
	</div>
	
	
	
</div>
<!-- veio por -->
	<div style="overflow:hidden;	;margin:0 0 0 10px;border-left:1px solid #000;padding:0 0 0 10px;"><span><strong>Veio por?</strong></span><br/>
		<div class="floatleft" style="float:left;">
	
			<label><input  id="ambulancia" type="checkbox" name="veioporx" value="ambulancia"/>Ambulância</label><br/>
			<label><input  class="tipoambulancia" type="radio" name="veiopor" value="Ambulância - SAMU"/>Samu</label><br/>
			<label><input  class="tipoambulancia" type="radio" name="veiopor" value="Ambulância - GBM"/>GBM</label><br/>
			<label><input  class="tipoambulancia" type="radio" name="veiopor" value="Ambulância - Tipo A"/>Tipo A</label>

	
		</div>
		<label><input  type="radio" name="veiopor" value="Meios próprios"/>Meios próprios</label>
		<label><input  type="radio" name="veiopor" value="Deambulando"/>Deambulando</label>

	</div>

	


<label><span>Responsavel: </span><input type="text" id="responsavel" name="responsavel" class=" text ui-widget-content ui-corner-all form100" >
<!--************************** fimlinha *************************************************************-->

<script>
$(function() {
  enable_ambulancia();
  $("#ambulancia").click(enable_ambulancia);
});

function enable_ambulancia() {
  if (this.checked) {
    $("input.tipoambulancia").removeAttr("disabled");

  } else {
    $("input.tipoambulancia").attr("disabled", true);
    $("input.tipoambulancia").css('color','#ccc');
  }
}
</script>

</form>
</div>