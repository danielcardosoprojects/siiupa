<script>
    $(function() {
        //$("#datepickerx").datepicker();
        //$("#datepickerx").datepicker("option", "dateFormat", "dd\/mm\/yy");

        $("#datepickerx").on('change', function() {
            var datapart = $("#datepickerx").val();
            var parts = datapart.split('-');
            parts[2] = +parts[2]; //tira o zero a esquerda
            parts[1] = +parts[1]; //tira o zero a esquerda
            linkalimento = "administracao/pagina_almoco.php?dia="+parts[2]+"&mes="+parts[1]+"&ano="+parts[0];
            $("#linkalimentacao").attr('href', linkalimento);
        });
    });
</script>
<p>Date: <input type="date" id="datepickerx" value=""></p> <a class="button" id="linkalimentacao" target="_blank" href="http://localhost/siiupa/administracao/pagina_almoco.php?dia=9&mes=11&ano=2021">GERAR</a>