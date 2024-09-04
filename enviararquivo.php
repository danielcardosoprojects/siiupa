<?php
require __DIR__ . '/vendor/autoload.php';
?>
<link rel="stylesheet" href="/siiupa/vendor/coffeecode/uploader/style.css">

<div class="form">

    <form name="env" method="post" enctype="multipart/form-data">
        <?php
        require __DIR__ . "/vendor/coffeecode/uploader/src/Uploader.php";
        require __DIR__ . "/vendor/coffeecode/uploader/src/File.php";

        $file = new CoffeeCode\Uploader\File("arquivos", "", false); //SEM PASTAS DE ANO E MÊS
        // $file = new CoffeeCode\Uploader\File("uploads", "files");


        if ($_FILES) {
            try {
                $upload = $file->upload($_FILES['file'], $_POST['name']);
                echo "<p><a href='{$upload}' target='_blank'>$upload</a></p>";
            } catch (Exception $e) {
                echo "<p>(!) {$e->getMessage()}</p>";
            }
        }
        ?>
        <input type="text" name="name" placeholder="Nome do arquivo" required/>
        <input type="file" name="file" required/>
        <button>Enviar arquivo</button>
    </form>
    <div style="position:fixed;margin-left:0px;">
<?php

$diretorio = 'arquivos'; // Substitua pelo caminho da sua pasta
$arquivos = scandir($diretorio);

foreach ($arquivos as $arquivo) {
    // Ignora os diretórios especiais "." e ".."
    if ($arquivo !== "." && $arquivo !== "..") {
        // Gera um link para o arquivo
        echo '<span><li><a href="' . $diretorio . '/' . $arquivo . '">' . $arquivo . '</a></li></span><span></span>';
    }
}
?>
</div>
</div>


