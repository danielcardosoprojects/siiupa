<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar PDFs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            color: #5a5a5a;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        li a {
            text-decoration: none;
            color: #0066cc;
        }
        li a:hover {
            text-decoration: underline;
        }
        /* Estilos para o modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
    </style>
</head>
<body>
    <h1>Arquivos PDF no diretório</h1>
    <ul>
    <?php
    $diretorio = './'; // Substitua pelo caminho do diretório que contém os PDFs
    $arquivos = scandir($diretorio);

    foreach ($arquivos as $arquivo) {
        if (pathinfo($arquivo, PATHINFO_EXTENSION) === 'pdf') {
            echo "<li><a href='#' onclick='openModal(\"$diretorio/$arquivo\")'>$arquivo</a></li>";
        }
    }
    ?>
    </ul>

    <!-- O Modal -->
    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span onclick="closeModal()" style="cursor:pointer;float:right;">&times;</span>
            <iframe id="pdfFrame" style="width:100%; height:500px;" frameborder="0"></iframe>
        </div>
    </div>

    <script>
        function openModal(pdfUrl) {
            document.getElementById('pdfFrame').src = pdfUrl;
            document.getElementById('pdfModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('pdfModal').style.display = "none";
            document.getElementById('pdfFrame').src = '';
        }

        // Close the modal if the user clicks anywhere outside of the modal
        window.onclick = function(event) {
            var modal = document.getElementById('pdfModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
