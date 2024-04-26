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
        input[type="text"] {
            padding: 10px;
            margin-bottom: 20px;
            width: 300px;
            border: 1px solid #ddd;
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
            display: none; /* Start with no files displayed */
        }
        li a {
            text-decoration: none;
            color: #0066cc;
        }
        li a:hover {
            text-decoration: underline;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .open-pdf {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .open-pdf:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Arquivos PDF no diretório</h1>
    <input type="text" id="searchBox" onkeyup="searchPDFs()" placeholder="Buscar arquivo...">
    <ul id="pdfList">
    <?php
    $diretorio = './'; // Substitua pelo caminho do diretório que contém os PDFs
    $arquivos = scandir($diretorio);

    foreach ($arquivos as $arquivo) {
        if (pathinfo($arquivo, PATHINFO_EXTENSION) === 'pdf') {
            echo "<li style='display: block;'><a href='#' onclick='openModal(\"$diretorio/$arquivo\")'>$arquivo</a></li>";
        }
    }
    ?>
    </ul>

    <!-- The Modal -->
    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <iframe id="pdfFrame" style="width:100%; height:500px;" frameborder="0"></iframe>
            <button class="open-pdf" onclick="openPDFInNewTab()">Abrir em Nova Aba</button>
        </div>
    </div>

    <script>
        var currentPDFUrl = '';

        function searchPDFs() {
            var input = document.getElementById('searchBox');
            var filter = input.value.toUpperCase();
            var ul = document.getElementById('pdfList');
            var li = ul.getElementsByTagName('li');

            for (var i = 0; i < li.length; i++) {
                var a = li[i].getElementsByTagName("a")[0];
                var txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "block";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        function openModal(pdfUrl) {
            currentPDFUrl = pdfUrl;  // Store current PDF URL to use for opening in a new tab
            var modal = document.getElementById('pdfModal');
            var iframe = document.getElementById('pdfFrame');
            iframe.src = pdfUrl;
            modal.style.display = "block";
        }

        function closeModal() {
            var modal = document.getElementById('pdfModal');
            modal.style.display = "none";
            document.getElementById('pdfFrame').src = '';
        }

        function openPDFInNewTab() {
            window.open(currentPDFUrl, '_blank');
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('pdfModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
