<?php
$fcpfn = $_GET['cpf'];
?>
<script>

const apiURL<?php echo $fcpfn;?> = `https://apionline.layoutsistemas.com.br/api/matriculas/?cpf=<?php echo $fcpfn;?>`;
const authorizationHeader<?php echo $fcpfn;?> = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbl90eXBlIjoiYWNjZXNzIiwiZXhwIjoxNzA3Mzk2NzYzLCJqdGkiOiJhODAzNmM1Zjk1Mzc0NmQzYmQyMGNjN2NhZTg4NzBhOSIsInVzZXJfaWQiOjE5MDY3M30.fxJ4r3w9Z7LjCxpySFRlKwBMnKm2dZwq40N695OR2Ts";

// Fazer uma solicitação GET usando a função fetch
fetch(apiURL<?php echo $fcpfn;?>, {
  method: "GET",
  headers: {
    "Authorization": authorizationHeader<?php echo $fcpfn;?>
  }
})
  .then(response => {
    if (!response.ok) {
      throw new Error(`Erro na solicitação: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    // Verificar se a resposta foi bem-sucedida e obter o CPF
    console.log("<?php echo $nome;?>");
    if (data.results && data.results.length > 0) {
      const matricula = data.results[0].matricula;
      console.log("CPF:", matricula);
      //document.getElementById('<?php echo $fcpfn;?>').textContent = matricula;
    } else {
      console.log("CPF não encontrado na resposta da API.");
    }
  })
  .catch(error => {
    console.error("Erro na solicitação:", error);
  });
</script>