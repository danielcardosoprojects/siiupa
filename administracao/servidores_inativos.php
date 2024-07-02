<?php
include_once('bd/conectabd.php');
session_start();
include_once('bd/nivel.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servidores Inativos</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            color: #005c99; /* Azul do logotipo das UPAs 24h */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th {
            background-color: #005c99; /* Azul do logotipo das UPAs 24h */
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Servidores Inativos</h1>
        <table id="servidores-table" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Função</th>
                    <th>CPF</th>
                    <th>Data de Admissão</th>
                    <th>Data de Desligamento</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <!-- Conteúdo gerado dinamicamente -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        function openModal() {
            $.confirm({
                title: 'Servidores Inativos',
                content: 'url:https://siupa.com.br/siiupa/administracao/servidores_inativos.php',
                type: 'blue',
                boxWidth: '80%',
                useBootstrap: false,
                buttons: {
                    fechar: function () {
                        // Fecha o modal
                    }
                },
                onContentReady: function () {
                    const iframe = this.$content.find('iframe')[0];
                    iframe.onload = function() {
                        try {
                            const iframeContent = iframe.contentDocument || iframe.contentWindow.document;
                            $(iframeContent).ready(function() {
                                $(iframeContent).find('#servidores-table').DataTable({
                                    language: {
                                        url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/Portuguese-Brasil.json"
                                    },
                                    pageLength: 10,
                                    lengthChange: false,
                                    searching: true,
                                    ordering: true
                                });
                            });
                        } catch (error) {
                            console.error('Erro ao acessar o conteúdo do iframe:', error);
                        }
                    };
                }
            });
        }
    </script>
</body>
</html>
