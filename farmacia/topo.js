class MeuTopo extends HTMLElement {
    constructor() {
        super();
        const shadow = this.attachShadow({ mode: 'open' });

        shadow.innerHTML = `
            <style>
                header { background: #333; color: white; padding: 10px; text-align: center; }
            </style>
            <header>
            <h3><img src="../imagens/icones/farmacia.svg" height="30px"> Farmácia</h3>
	<a href="/siiupa/farmacia/" class="btn btn-primary btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/home2.png" height="20px"> Inicio</a>
	<a href="/siiupa/farmacia/estoque/" class="btn btn-info btn-lg active bt_menu_farm" role="button" aria-pressed="true"><img src="/siiupa/imagens/icones/estoque.svg" height="20px"> Estoque</a>

                <h1>Teste</h1>
            </header>
        `;
    }
}

customElements.define('meu-topo', MeuTopo);
