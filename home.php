 <?php
    @include("../conexao/verifica_login.php");
    ?>








 <div class="container">
     <div class="row">
         <?php
            if ($_SESSION['nivel'] == 1) {
            ?>
             <div class="col-sm">
                 <!-- ADMINISTRACAO -->
                 <div class="card" style="width: 18rem;text-align:center">
                     <br>
                     <img src="imagens/icones/adm.svg" class="card-img-top" alt="..." height="150px">
                     <div class="card-body">

                         <a href="?setor=adm" class="btn btn-primary">Administração</a>
                         <br>
                         <a href="/siiupa/?setor=adm&sub=rh" class="btn btn-sm btn-light">Servidores</a>
                         <a href="/siiupa/?setor=adm&sub=rh&subsub=escalas" class="btn btn-sm btn-light">Escalas</a>
                         <a href="/siiupa/?setor=adm&sub=rh&subsub=folhas" class="btn btn-sm btn-light">Folhas</a>
                         <a href="/siiupa/?setor=adm&sub=rh&subsub=atestados" class="btn btn-sm btn-light">Afastamentos</a>
                         <a href="/siiupa/?setor=adm&sub=rh&subsub=acionamentos" class="btn btn-sm btn-light">Acionamentos</a>
                         <a href="/siiupa/?setor=adm&sub=rh&subsub=ferias" class="btn btn-sm btn-light">Férias</a>
                         <a href="/siiupa/administracao/patrimonio" class="btn btn-sm btn-light">Patrimônio</a>


                     </div>

                     <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                         <li class="nav-link active">

                         </li>
                     </ul>
                 </div>
             </div>
         <?php } ?>
         <div class="col-sm">
             <!-- farmacia -->
             <div class="card" style="width: 18rem;text-align:center">
                 <br>
                 <img src="imagens/icones/farmacia.svg" class="card-img-top" alt="..." height="150px">
                 <div class="card-body">
                     <a href="/siiupa/farmacia/" class="btn btn-primary">Farmácia</a>
                     <br>

                     <a href="/siiupa/farmacia/estoque/" class="btn btn-sm btn-light">Estoque</a>
                     <?php
                        if ($_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 1) {
                        ?>
                         <a href="/siiupa/farmacia/movimento/entrada" class="btn btn-sm btn-light">Entrada de Item</a>
                         <a href="/siiupa/farmacia/movimento/saida" class="btn btn-sm btn-light">Saída de Item</a>
                         <a href="/siiupa/farmacia/movimentos/" class="btn btn-sm btn-light">Filtrar movimentos</a>
                         <a href="/siiupa/farmacia/ranking/" class="btn btn-sm btn-light">Ranking</a>
                         <a href="/siiupa/farmacia/validade/" class="btn btn-sm btn-light">Validade</a>
                     <?php } ?>
                 </div>

                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                     <li class="nav-link active">

                     </li>
                 </ul>
             </div>
         </div>
         <div class="col-sm">
             <div class="card" style="width: 18rem;text-align:center">
             <br>
                 <img src="imagens/icones/postoenfermagem.svg" class="card-img-top" alt="..." height="150px">
                 <div class="card-body">
                    <br>
                     <a href="#" class="btn btn-primary">Posto de Enfermagem</a>
                     <br>
                     <a href="#" class="btn btn-sm btn-light">Censo</a>
                     <a href="#" class="btn btn-sm btn-light">Dieta</a>
                     <a href="#" class="btn btn-sm btn-light">Prescrição de Enfermagem</a>
                     <a href="#" class="btn btn-sm btn-light">Evolução</a>
                     <a href="#" class="btn btn-sm btn-light">Pacientes</a>
                 </div>
             </div>
         </div>
     </div>
 </div>