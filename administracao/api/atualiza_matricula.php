<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
?>
<script>fetch("http://siupa.com.br/siiupa/api/rh/api.php/records/tb_funcionario?filter=status,eq,ativo&order=id,desc", {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
    },
   /*body: JSON.stringify({
        username: 'danielcardoso',
        password: 'c*123c12'
    }),*/
})
.then(response => response.json())
.then(data => {
    
    data.records.forEach((item) => {
        console.log(item.cpf);
    });
})
.catch(error => {
    // Lide com erros aqui
    console.error('Erro na solicitação:', error);
});
</script>