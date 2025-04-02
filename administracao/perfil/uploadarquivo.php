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
    $arquivo = $_POST['arquivo']; // Ex: "administracao/rh/14/20250402_Catalogo de transistores.pdf"
    
    $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]); // Ex: /home/.../public_html
    $arquivo_limpo = ltrim(urldecode($arquivo), '/'); // tira barra inicial se tiver

    //$caminho_completo = $base_dir . '/' . $arquivo_limpo;
    $caminho_completo = "/administracao/rh/14/20250402_Catalogo de transistores.pdf";
    if (file_exists($caminho_completo)) {
        if (is_file($caminho_completo)) {
            if (unlink($caminho_completo)) {
                echo "success";
            } else {
                echo "Erro ao tentar apagar o arquivo: $caminho_completo";
            }
        } else {
            echo "O caminho existe, mas não é um arquivo: $caminho_completo";
        }
    } else {
        echo "Arquivo não encontrado: $caminho_completo";
    }
}
