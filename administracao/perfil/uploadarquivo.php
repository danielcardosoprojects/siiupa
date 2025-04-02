<?php

if ($_GET['acao'] == 'arquivos') {
    $id = $_GET['id'];

    // múltiplos arquivos
    if (!empty($_FILES['file']['name'][0])) {
        foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
            $nome = $_FILES['file']['name'][$key];
            $caminho = '../rh/' . $id . '/' . date('Ymd') . '_' . $nome;

            move_uploaded_file($tmp_name, $caminho);
        }

        echo "success";
        die();
    } else {
        echo "Nenhum arquivo selecionado.";
        die();
    }
}
 elseif ($_GET['acao'] == 'fotoperfil') {
    $id = $_GET['id'];
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < 5; $i++) {
        $key .= $keys[array_Rand($keys)];
    }

    $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
    $arquivo = "/siiupa/administracao/rh/$id/foto_perfil.jpg";
    $file_delete =  "$base_dir$arquivo";
    if (file_exists($file_delete)) {
        unlink($file_delete);
    }
    $arquivo = "/siiupa/administracao/rh/$id/foto_perfil.png";
    $file_delete =  "$base_dir$arquivo";
    if (file_exists($file_delete)) {
        unlink($file_delete);
    }
    $arquivo = "/siiupa/administracao/rh/$id/foto_perfil";
    $file_delete =  "$base_dir$arquivo";
    if (file_exists($file_delete)) {
        unlink($file_delete);
    }
    


    move_uploaded_file($_FILES['file']['tmp_name'], '../rh/' . $id . '/foto_perfil');
} elseif ($_GET['acao'] == 'apagarArquivo') {
    $arquivo = $_POST['arquivo'];

    $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
    $file_delete =  "$base_dir$arquivo";
    if (file_exists($file_delete)) {
        unlink($file_delete);
    }
    echo $file_delete;
}
