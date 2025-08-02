class MeuTopo extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: "open" });
    this.validarUsuario();
  }

  async validarUsuario() {
    // Captura o token da query string
    const params = new URLSearchParams(window.location.search);
    const token =
      "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3NpdXBhLmNvbS5iciIsImF1ZCI6Imh0dHBzOi8vc2l1cGEuY29tLmJyIiwiaWF0IjoxNzU0MDkyMzk2LCJleHAiOjE3NTQxMDY3OTYsImlkVXN1YXJpbyI6IjEiLCJuYmYiOjEzNTcwMDAwMDB9.SyVpAfuorkSEsLNHftwWR8EvyvSyOY54LMRI4fkp_-k";
    //const token = sessionStorage.token;
    //const token = params.get("token");

    // Se não houver token, redireciona para a raiz
    if (!token) {
      //window.location.href = "/";
      return;
    }

    // Consulta a API para validar o token
    try {
      const response = await fetch(
        `https://www.siupa.com.br/siiupa/api/api.php/records/usuarios?filter=token,eq,${token}`
      );
      const data = await response.json();

      // Se não houver usuário correspondente, redireciona para a raiz
      if (!data.records || data.records.length === 0) {
        window.location.href = "/";
        return;
      }

      // Extrai as informações do usuário
      const usuario = data.records[0];
      this.nome = usuario.nome;
      this.nivel = usuario.nivel;
      this.idservidor = usuario.idservidor;

      // Renderiza o topo após validar o usuário
      this.render();
    } catch (error) {
      console.error("Erro ao validar usuário:", error);
      window.location.href = "/";
    }
  }

  render() {
    const style = document.createElement("style");
    style.textContent = `
            @import url("https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css");
            #menu {
                background-color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            #menu a {
                margin: 0 5px;
            }
            nav {
                background-color: #343a40;
            }
        `;

    const header = document.createElement("header");
    header.id = "topo";
    header.innerHTML = `
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="/siiupa/">
                        <img src="/siiupa/imagens/siiupa.png" height="32" alt="Logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="/siiupa/?setor=adm" class="nav-link">Administração</a>
                            </li>
                            <li class="nav-item">
                                <a href="/siiupa/servidor/dist" class="nav-link">Servidor</a>
                            </li>
                            <li class="nav-item">
                                <a id="btnFarmacia" href="/siiupa/farmacia/" class="nav-link">Farmácia</a>
                            </li>
                            <li class="nav-item">
                                <a id="abreRecepcao" href="#" class="nav-link">Recepção</a>
                            </li>
                        </ul>
                        <div class="d-flex align-items-center" style="color:#b0b0b0">
                            <img src="/siiupa/administracao/rh/${this.idservidor}/foto_perfil" height="32" class="rounded-circle" alt="Perfil">
                            <span class="ms-2 me-3">
                                ${this.nome}
                                <img src="/siiupa/imagens/icones/nivel.svg" width="16" alt="Nível">
                                ${this.nivel}
                            </span>
                            <a class="btn btn-outline-info btn-sm me-2" href='/conexao/redefinirsenha.php'>Troca senha</a>
                            <a class="btn btn-outline-danger btn-sm" href="/conexao/logout.php" id="sair">Sair</a>
                        </div>
                    </div>
                </div>
            </nav>

            <h3 id="logo"><img src="../imagens/icones/farmacia.svg" height="30px"> Administração</h3>
            
            <nav class="navbar navbar-light" style="background-color: #e3f2fd;">

        <div class="">
            <a href="?setor=adm&sub=rh" id="bcadastrarFUNCIONARIO" class="btn btn-success btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/people.svg">
                SERVIDORES</a>
            <a href="?setor=adm&sub=rh&subsub=escalas" id="bEscalas" class="btn btn-info btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/calendario.svg" width="20">
                Escalas</a>


            <a href="?setor=adm&sub=rh&subsub=folhas" id="bFolhas" class="btn btn-info btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/folha.svg" width="20">
                Folhas</a>
            <a href="?setor=adm&sub=rh&subsub=atestados" id="bAtestados" class="btn btn-warning btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/doente2.svg" width="20">
                Afastamentos</a>

            <a href="?setor=adm&sub=rh&subsub=afastamentos" id="bAtestados" class="btn btn-warning btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/doente2.svg" width="20">
                Afastamentos 2 (testes)</a>





            <a href="?setor=adm&sub=rh&subsub=acionamentos" id="bAcionamentos" class="btn bg-verdeClaro btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/dinheiro2.svg" width="25">
                Acionamentos</a>

            <a href="?setor=adm&sub=rh&subsub=atestados" id="bAtestados" class="btn btn-dark btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/trocas.png" width="20">
                Trocas</a>

            <a href="?setor=adm&sub=rh&subsub=ferias" id="bFerias" class="btn btn-lg bt_menu_rh">
                <img src="/siiupa/imagens/icones/ferias3.svg" width="20">
                Férias</a>



            <a href="?setor=adm&sub=rh&subsub=alimentacao" id="bAlimentacao" class="btn btn-sm">
                <img src="/siiupa/imagens/icones/restaurant.svg">
                Lista de Alimentação</a>

            <a href="?setor=adm&sub=rh&subsub=listaepi" id="bListaEpi" class="">
                <img src="/siiupa/imagens/icones/mascara.svg" width="36px">
                Lista de EPI</a>
            <?php
            $mesAtual = date("m");
            ?>
            <a href="/siiupa/administracao/fotos_aniversario/fotos_aniversario.php?mes=<?= $mesAtual ?>" id="bListaEpi" class="" target="_blank">
                <img src="/siiupa/imagens/icones/birthday.png" width="20px">
                Aniversariantes do Mês</a>





        </div>





    </nav>
        `;

    this.shadowRoot.appendChild(style);
    this.shadowRoot.appendChild(header);
  }

  connectedCallback() {
    this.contarItensVencidos();
  }

  async contarItensVencidos() {
    const dataAtual = new Date().toISOString().split("T")[0];

    const data = new Date();
    const ano = data.getFullYear();
    const mes = data.getMonth();

    // Cria um novo objeto Date com o dia 0 do próximo mês.
    // Isso retorna o último dia do mês atual.
    const ultimoDia = new Date(ano, mes + 1, 0);

    const dia = ultimoDia.getDate();
    const mesFormatado = mes + 1 < 10 ? `0${mes + 1}` : mes + 1;

    const ultimoDiaMes = `${ano}-${mesFormatado}-${dia}`;

    try {
      const response = await fetch(
        `https://www.siupa.com.br/siiupa/api/api.php/records/tb_farmestoque?filter=data_validade,lt,${ultimoDiaMes}&filter=estoque,gt,0`
      );
      const data = await response.json();

      const totalVencidos = data.records ? data.records.length : 0;

      // Atualiza o elemento dentro do Shadow DOM
      this.shadowRoot.getElementById("totalVencidos").textContent =
        totalVencidos;
    } catch (error) {
      console.error("Erro ao buscar itens vencidos:", error);
      this.shadowRoot.getElementById("totalVencidos").textContent = "Erro";
    }
  }
}

customElements.define("meu-topo", MeuTopo);
