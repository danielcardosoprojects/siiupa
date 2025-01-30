class MeuTopo extends HTMLElement {
    constructor() {
        super();
        const shadow = this.attachShadow({ mode: 'open' });
        const style = document.createElement('style');
        style.textContent = `
                                        @import url("https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css");
                                        #logo {
                                        }
                                        #menu {
                                        background-color: #fff;
                                        display: flex;
                                        align-items: center;                            
                                        justify-content: center; }
                                        #menu a {
                                        margin: 0 5px;
                                        }
                                        nav {
                                        background-color: #343a40;}

                                        
                                        `;
        
        const header = document.createElement('header');
        header.id = 'topo';
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
					<img src="/siiupa/administracao/rh/<?php echo $_SESSION['idServidorUsuario']; ?>/foto_perfil" height="32" class="rounded-circle" alt="Perfil">
					<span class="ms-2 me-3">
						<?php echo $_SESSION['nomeusuario']; ?>
						<img src="/siiupa/imagens/icones/nivel.svg" width="16" alt="Nível">
						<?php echo $_SESSION['nivel']; ?>
					</span>
					<a class="btn btn-outline-info btn-sm me-2" href='/conexao/redefinirsenha.php'>Troca senha</a>
					<a class="btn btn-outline-danger btn-sm" href="/conexao/logout.php" id="sair">Sair</a>
				</div>
			</div>
		</div>
	</nav>
	
                <h3 id="logo"><img src="../imagens/icones/farmacia.svg" height="30px"> Farmácia</h3>
                <div id="menu">
                <a href="/siiupa/farmacia/" class="btn btn-primary btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="../imagens/icones/home2.png" height="20px"> Inicio</a>
                <a href="/siiupa/farmacia/estoque/" class="btn btn-info btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="../imagens/icones/estoque.svg" height="20px"> Estoque</a>
                <a href="/siiupa/farmacia/movimento/entrada" id="cadastrarMovimentoE" class="btn btn-success btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/movimento.svg" height="20px">Entrada de Item</a>
                <a href="/siiupa/farmacia/movimento/saida" id="cadastrarMovimentoS" class="btn btn-danger btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/movimento.svg" height="20px">Saída de Item</a>
                <a href="/siiupa/farmacia/movimentos/" id="filtrarMovimentoS" class="btn btn-warning btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/calendario2.svg" height="20px">Filtrar movimentos</a>
                <a href="/siiupa/farmacia/ranking/" id="filtrarMovimentoS" class="btn btn-secondary btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/rank.fw.png" height="20px"> Ranking</a>
                </div>
                `;

        shadow.appendChild(style);
        shadow.appendChild(header);
        


    }
}

customElements.define('meu-topo', MeuTopo);
