<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script
  src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  crossorigin="anonymous"></script>
</head>
<body>
    

<script>
    async function getData() {
        // URL da API
        const url = 'https://apitransparencia.layoutsistemas.com.br/api/resumoservidores/?departamento=001050&entidade=477&transparencia=23140&page=1&page_size=2000';

        const response = await fetch(url);
         
        // Converter o retorno para JSON
        const data = await response.json();
        let results = data.results;
        console.log(results);

        // Mapear o retorno
        const mappedData = results.map((item) => {
            div = document.getElementById("nomes");
            div.innerHTML += `<tr><td>${item.nome}</td><td id='${item.id}'></td></tr>`;
            
            getDataServidor(item.id)

        });

        
        
    }
    async function getDataServidor(id) {
        // URL da API
        const url = `https://apitransparencia.layoutsistemas.com.br/api/servidores/${id}/`;

        const response = await fetch(url);

        // Converter o retorno para JSON
        const data = await response.json();

      $(`#${id}`).html(data.nome_mae);
    } 


    getData();

    $(document).ready( function () {
 
} );
</script>
<table id="nomes1" class="table table-bordered table-hover">
    <thead>
        <th>NOME</th>
        <th>Coluna 1</th>
    </thead>
    <tbody id="nomes">

    </tbody>
</table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" ></script>

</body>
</html>