<?php
include_once('bd/conectabd.php');
session_start();
include_once('bd/nivel.php');
?>
   <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100%;
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

    <script>
        const apiURL = 'https://siupa.com.br/siiupa/api/rh/api.php/records/tb_funcionario/?filter=status,eq,INATIVO&join=tb_cargo';

        document.addEventListener('DOMContentLoaded', () => {
            fetchRecords();
        });

        function fetchRecords() {
            fetch(apiURL)
                .then(response => response.json())
                .then(data => {
                    displayRecords(data.records);
                })
                .catch(error => console.error('Erro ao buscar registros:', error));
        }

        function displayRecords(records) {
            const tableBody = document.querySelector('#servidores-table tbody');
            tableBody.innerHTML = '';

            records.forEach(record => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${record.id}</td>
                    <td>${record.nome}</td>
                    <td>${record.fk_cargo.funcao_upa}</td>
                    <td>${record.cpf || ''}</td>
                    <td>${record.admissao}</td>
                    <td>${record.desligamento || ''}</td>
                    <td><a href="https://siupa.com.br/siiupa/?setor=adm&sub=rh&subsub=perfil&id=${record.id}" target="_blank">Abrir Perfil</a></td>
                `;
                tableBody.appendChild(row);
            });

            $('#servidores-table').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
                },
                pageLength: 10,
                lengthChange: false,
                searching: true,
                ordering: true
            });
        }
    </script>
