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

                  <h3 class="title has-text-grey">Lista de usuário</h3>

                    <div class="box">

                      <?php
                      include('conexao/conexao.php');

                      if (!$conexao) {
                          die("Falha de conexão " . mysqli_connect_error());
                      }

                      $sql = "SELECT id, usuario, email FROM usuarios";
                      $result = mysqli_query($conexao, $sql);

                      if (mysqli_num_rows($result) > 0) {
                          // output data of each row
                          while($row = mysqli_fetch_assoc($result)) {
                              echo $row["id"]. " - Nome: <b>" . $row["usuario"]. "</b> " . $row["email"]. "<br>";
                          }
                      } else {
                          echo "0 results";
                      }

                      mysqli_close($conexao);
                      ?>

                    </div><!-- .box -->

                    <h2 style='color:grey'><a href="painel.php">Cadastrar usuário</a></h2>

                    <h2 style='color:grey'><a href="conexao/logout.php">Sair</a></h2>

                </div>
            </div>
        </div><!-- .hero-body -->

    </section>

</body>

</html>
