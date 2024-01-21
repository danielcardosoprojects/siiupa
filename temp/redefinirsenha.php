<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Segurança da Informação</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                <img src="/siiupa/imagens/siiupa.png"><br><br>
                    <h3 class="title has-text-grey">Redefinição de senha</h3>
                    <?php
               
                    if(isset($_SESSION['errosenha'])):
                    ?>
                    <div class="notification is-danger">
                      <p>ERRO: Repetição de senha nova não bate.</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['errosenha']);

                    if(isset($_SESSION['errocodigo'])):
                    ?>
                    <div class="notification is-danger">
                      <p>ERRO: Senha atual incorreta.</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['errocodigo']);
                    ?>
                    <div class="box">

                        <form action="conexao/salvarsenha.php" method="POST">
                            

                            <div class="field">
                                <div class="control">
                                  <label>Senha atual</label>
                                    <input name="codigo" name="password" class="input is-large" placeholder="Digite a senha atual" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                  <label>Inserir nova senha</label>
                                    <input name="senha1" class="input is-large" type="password" placeholder="Sua nova senha">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                  <label>Repetir nova senha</label>
                                    <input name="senha2" class="input is-large" type="password" placeholder="Repita sua nova senha">
                                </div>
                            </div>

                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Salvar</button>

                        </form>
                        <a href="/siiupa">Retornar</a>

                        

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
