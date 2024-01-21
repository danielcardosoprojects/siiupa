<?php
include('conexao/verifica_login.php');
?>
<p><center>Olá, <?php echo $_SESSION['usuario'];?></center></p>
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

                  <h3 class="title has-text-grey">Cadastro de usuário</h3>

                  <?php
                  if(isset($_SESSION['nao_autenticado'])):
                  ?>
                  <div class="notification is-danger">
                    <p>ERRO: Erro de cadastro.</p>
                  </div>
                  <?php
                  endif;
                  unset($_SESSION['nao_autenticado']);

                  if(isset($_SESSION['erro_email'])):
                  ?>
                  <div class="notification is-danger">
                    <p>ERRO: Email já cadastrado.</p>
                  </div>
                  <?php
                  endif;
                  unset($_SESSION['erro_email']);
                  ?>

                    <div class="box">

                        <form action="conexao/cadastro.php" method="POST">

                            <div class="field">
                                <div class="control">
                                  <label>Nome de usuário</label>
                                    <input name="usuario" name="text" class="input is-large" placeholder="Seu nome de usuário" autofocus="" required>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                  <label>E-mail</label>
                                    <input name="email" name="text" class="input is-large" placeholder="Seu email" autofocus="" required>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                  <label>Senha</label>
                                    <input name="senha" class="input is-large" type="password" placeholder="Sua senha" required>
                                </div>
                            </div>

                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Cadastrar</button>

                        </form>

                        <h2><a href="usuarios.php">Usuários</a></h2>

                        <h2><a href="conexao/logout.php">Sair</a></h2>

                    </div><!-- .box -->

                </div>
            </div>
        </div><!-- .hero-body -->

    </section>

</body>

</html>
