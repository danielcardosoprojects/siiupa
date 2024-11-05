<?php

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Patrimônio</title>
    <link href="style.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Axios JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css">

    
    <script>

    </script>
</head>
<style>
    .select2-dropdown {
        z-index: 9999;
    }
</style>

<body>
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="/siiupa/?setor=adm">
    <img src="/siiupa/imagens/siiupa.png" class="d-inline-block align-top" alt="" width="200px">
    Administração - Controle de Patrimônio
  </a>
  <a href="lista_patrimonio" class="btn btn-primary">Lista Patrimônio</a>
</nav>
<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#botao_setores_offcanvas" aria-controls="botao_setores_offcanvas">
        Abrir Menu de Setores
    </button>

    <!-- Menu lateral Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="botao_setores_offcanvas" aria-labelledby="botao_setores_offcanvas_label">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="botao_setores_offcanvas_label">Setores</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Container dos botões -->
            <div id="botao_setores_container">
                <a href="?setor=0" class="btn btn-success">Todos</a>
                
                <!-- Os botões serão inseridos aqui -->
            </div>
        </div>
    </div>

    <div class="container my-5">
        
        <h2 id="titulo_setor"></h2>
        <div id="botao_setores_container">
            <!-- Os botões serão inseridos aqui -->
        </div>

        <div class="text-end mb-3">
            <button class="btn btn-success" id="addItemBtn">Adicionar Item</button>
        </div>
        <table id="equipamentosTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Qtd</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Número de Série</th>
                    <th>Data de Cadastro</th>
                    <th>Setor</th>
                    <th>Ações</th>
                    
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal para Adicionar/Editar Equipamentos -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Adicionar Equipamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="itemForm">
                        <button type="button" class="btn btn-primary" id="repetirUltimo">Carregar último</button>
                        <div class="mb-3">
                            <label for="setor" class="form-label">Setor</label>
                            <select class="form-select" id="setor" required>
                                <option value="">Selecione um setor</option>
                                <!-- As opções serão adicionadas dinamicamente pelo JavaScript -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" required list="suggestionsNome">
                            <datalist id="suggestionsNome"></datalist>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" required>
                                <option value="Equipamento">Equipamento</option>
                                <option value="Móvel">Móvel</option>
                                <option value="Material">Material</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="marca" required list="suggestionsMarca">
                            <datalist id="suggestionsMarca"></datalist>
                        </div>
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" required list="suggestionsModelo">
                            <datalist id="suggestionsModelo"></datalist>
                        </div>
                        <div class="mb-3">
                            <label for="numeroSerie" class="form-label">Número de Série</label>
                            <input type="text" class="form-control" id="numeroSerie" required list="suggestionsNumeroSerie">
                            <datalist id="suggestionsNumeroSerie"></datalist>
                        </div>



                        <input type="hidden" id="itemId">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>







    <script src="localstorage.js?<?php echo time(); ?>"></script>
    <script src="script.js?<?php echo time(); ?>"></script>
</body>

</html>