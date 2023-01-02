<style type="text/css">
#formcadastroprontuario {
width:100%;

}
#formcadastroprontuario .form100 {
width:100%;
}

#formcadastroprontuario .floatleft {
float:left;

margin-left:5px;
}

#formcadastroprontuario .floatright {
float:right;
}

#formcadastroprontuario h3 {
	margin:2px 0;
}/*
.primary.ui-state-default, .primary.ui-widget-content .primary.ui-state-default, .primary.ui-widget-header .primary.ui-state-default { 
	border: 1px solid #407998; 
	background: #004c75 url(../jquery-ui-1.10.4/themes/base/images/ui-bg_glass_40_004c75_1x400.png) 50% 50% repeat-x; 
	font-weight: normal; color: #ffffff; }

.primary.ui-state-default a, .primary.ui-state-default a:link, .primary.ui-state-default a:visited { 
	color: #ffffff; 
	text-decoration: none; }

.primary.ui-state-hover, .primary.ui-widget-content .primary.ui-state-hover, .primary.ui-widget-header .primary.ui-state-hover, .primary.ui-state-focus, .primary.ui-widget-content .primary.ui-state-focus, .primary.ui-widget-header .primary.ui-state-focus { 
	border: 1px solid #407998; 
	background: #407998 url(css/jquery_ui/images/ui-bg_glass_40_407998_1x400.png) 50% 50% repeat-x; 
	font-weight: normal; color: #ffffff; }

.primary.ui-state-hover a, .primary.ui-state-hover a:hover { 
	color: #ffffff; 
	text-decoration: none; }*/
.radioVermelho.ui-state-default{
border: 1px solid #ccc; 
	background: #F00 url(jquery-ui-1.10.4/themes/base/images/fundobvermelho.jpg) 50% 50% repeat-x!important; 
	font-weight: normal; 
	color: #000; 
}
.radioAmarelo.ui-state-default{
border: 1px solid #ccc; 
	background: #FF0 url(jquery-ui-1.10.4/themes/base/images/fundobamarelo.jpg) 50% 50% repeat-x!important; 
	font-weight: normal; 
	color: #000; 
}
.radioVerde.ui-state-default{
border: 1px solid #ccc; 
	background: #FF0 url(jquery-ui-1.10.4/themes/base/images/fundobverde.jpg) 50% 50% repeat-x!important; 
	font-weight: normal; 
	color: #000; 
}
.radioAzul.ui-state-default{
border: 1px solid #ccc; 
	background: #FF0 url(jquery-ui-1.10.4/themes/base/images/fundobazul.jpg) 50% 50% repeat-x!important; 
	font-weight: normal; 
	color: #000; 
}
.radioVermelho.ui-state-active, .radioAmarelo.ui-state-active,.radioVerde.ui-state-active, .radioAzul.ui-state-active { 
	border: 2px solid #000; 
	
	font-weight: bold; 
	color: #000; 
	}


</style>
<div id="formcadastroprontuario" title="Cadastrar Prontuário">
	<h3>Paciente: José da Silva Sauro a</h3>
<form action='gerenciabd.php' id='formulariocadastroprontuario'>



<div style="overflow:hidden;"><!-- linha -->

<label><span>Queixa principal:</span><br/>
<textarea class="text ui-widget-content ui-corner-all form100" rows="4"></textarea>

</div> <!-- fimlinha-->


<div style="overflow:hidden;"><!-- linha -->

	
		
		<label for="has"><span>HAS:</span>
			<input type="text" name="has" class="text ui-widget-content ui-corner-all" size="4"/>			
		</label>
		
		<label for="dm"><span>DM:</span>
			<input type="text" name="dm" class="text ui-widget-content ui-corner-all" size="4"/>			
		</label>
		
		<label for="ram"><span>RAM/Qual?:</span>
			<input type="text" name="ram" class="text ui-widget-content ui-corner-all" />			
		</label>
		
		<label for="intensidadedador"><span>Intensidade da dor:</span>
			<input type="text" name="intensidadedador" class="text ui-widget-content ui-corner-all" size="4"/>			
		</label>


</div> <!-- fimlinha-->
<div style="overflow:hidden;"><!-- linha -->

	<label for="hora1_prontuario"><span>Hora:</span>
		<input type="text" name="hora1_prontuario" class="text ui-widget-content ui-corner-all" size="4"/>			
	</label>

	<label for="fc1_prontuario"><span>FC:</span>
		<input type="text" name="fc1_prontuario" class="text ui-widget-content ui-corner-all" size="3"/>			
	</label>

	<label for="fr1_prontuario"><span>FR:</span>
		<input type="text" name="fr1_prontuario" class="text ui-widget-content ui-corner-all" size="3"/>			
	</label>

	<label for="t1_prontuario"><span>T:</span>
		<input type="text" name="t1_prontuario" class="text ui-widget-content ui-corner-all" size="3"/>			
	</label>

	<label for="pa1_prontuario"><span>PA:</span>
		<input type="text" name="pa1_prontuario" class="text ui-widget-content ui-corner-all" size="3"/>			
	</label>

	<label for="spo21_prontuario"><span>SPO2:</span>
		<input type="text" name="spo21_prontuario" class="text ui-widget-content ui-corner-all" size="3"/>			
	</label>

	<label for="gliccap1_prontuario"><span>GLIC. CAP:</span>
		<input type="text" name="gliccap1_prontuario" class="text ui-widget-content ui-corner-all" size="3"/>			
	</label>


</div> <!-- fimlinha-->	

<hr/>
<div id="radio">

<span>Classificação:</span>
		<input type="radio" id="radio1" name="grauderisco1_prontuario" /><label class="radioVermelho" for="radio1">Vermelho</label>
		<input type="radio" id="radio2" name="grauderisco1_prontuario" /><label class="radioAmarelo" for="radio2">Amarela</label>
		<input type="radio" id="radio3" name="grauderisco1_prontuario" /><label class="radioVerde" for="radio3">Verde</label>
		<input type="radio" id="radio4" name="grauderisco1_prontuario" /><label class="radioAzul" for="radio4">Azul</label>


</div>
<hr/>




<div style="overflow:hidden;"><!-- linha -->

	<label><span>Avaliação médica:</span><br/>
	<textarea class="text ui-widget-content ui-corner-all form100" rows="4" name="avaliacaomedica1_prontuario"></textarea>
	</label>
	


</div> 


</form>
</div>

