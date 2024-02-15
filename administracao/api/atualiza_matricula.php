<?php
header('Access-Control-Allow-Origin: *');
?>
<script>fetch("http://siupa.com.br/siiupa/api/rh/api.php/records/tb_funcionario?filter=status,eq,ativo&order=id,desc", {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
    },
   /* body: JSON.stringify({
        username: 'danielcardoso',
        password: 'c*123c12'
    }),*/
})
.then(response => response.json())
.then(data => {
    console.log(data);
})
.catch(error => {
    // Lide com erros aqui
    console.error('Erro na solicitação:', error);
});
</script>