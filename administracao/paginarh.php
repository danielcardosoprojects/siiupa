
<style>
    /* styles.css */
@import url('/siiupa/css/font_MontSerrat.css');

.floatleft {
    float: left;
}

.bg-grey {
    background-color: lightgrey !important;
}

#bFerias {
    background-color: #000;
    color: #fff;
}

#bFerias img {
    background-color: #fff;
}

#bFolhas {
    background-color: #139b70;
    color: #fff;
}

.bg-verdeClaro {
    background-color: #49c978 !important;
}

.noticias p {
    font-weight: bold;
}

.noticias {
    font-family: 'Josefin Sans', sans-serif;
    border-collapse: separate;
    border-radius: 10px;
    border-spacing: 8px 8px;
    font-size: 12px;
    display: none;
}

.lei {
    font-family: 'Josefin Sans', sans-serif;
    border-collapse: separate;
    border-radius: 10px;
    border-spacing: 8px 8px;
    font-size: 12px;
}

.bg-noticias {
    background-color: #C70039 !important;
    color: #fff;
    font-weight: bold;
}

.noticias_linha {
    font-weight: normal;
}

.noticias td {
    background-color: white;
    border-radius: 10px;
    padding: 5px;
    text-align: center;
}

.box_cima_branco {
    color: #fff;
    font-family: 'Josefin Sans', sans-serif;
    margin-top: 10px;
}

.box_cima_preto {
    color: #000;
    font-family: 'Josefin Sans', sans-serif;
    margin-top: 10px;
}

.dropdown {
    float: right;
    margin-left: 5px;
}

.bt_menu_rh {
    border-radius: 20rem;
}

</style>
<?php
function console_log($data) {
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}

function pega($entrada) {
    return isset($_GET[$entrada]) ? htmlspecialchars($_GET[$entrada]) : null;
}

function loadPageWithJS($page) {
    echo "<script>$(document).ready(function() { loadPage('$page'); });</script>";
}

function includePage($file) {
    if (file_exists($file)) {
        include_once($file);
    } else {
        echo "Página não encontrada.";
    }
}

$subsub = pega('subsub');

switch ($subsub) {
    case null:
        loadPageWithJS('pagina_rh_home');
        break;
    case 'perfil':
        includePage('pagina_rh_perfil.php');
        break;
    case 'ferias':
        includePage('pagina_rh_ferias.php');
        break;
    case 'folhas':
        includePage('pagina_rh_folhas.php');
        break;
    case 'escalas':
        includePage('pagina_rh_escalas.php');
        break;
    case 'listaepi':
        includePage('pagina_rh_farmacia_epi.php');
        break;
    case 'alimentacao':
        includePage('pagina_rh_alimentacao.php');
        break;
    case 'atestados':
        loadPageWithJS('pagina_rh_atestados');
        break;
    case 'acionamentos':
        loadPageWithJS('pagina_rh_acionamentos');
        break;
    case 'acionamento_exibe':
        includePage('pagina_rh_acionamento_exibe.php');
        break;
    case 'atestado_exibe':
        includePage('pagina_rh_atestados_exibe.php');
        break;
    case 'perfil_criar':
        includePage('pagina_rh_perfil_criar.php');
        break;
    case 'rhfolhas':
        includePage('pagina_rh_folhas.php');
        break;
    case 'rhfolhasmodifica':
        includePage('pagina_rh_folhas_criareditar.php');
        break;
    case 'rhfolhaexibe':
        includePage('pagina_rh_folha.php');
        break;
    case 'rhfolhaadicionaservidor':
        includePage('pagina_rh_folha_adicionaservidor.php');
        break;
    case 'rhcadastraferias':
        includePage('pagina_rh_cadastraferias.php');
        break;
    default:
        loadPageWithJS('pagina_rh_home');
        break;
}
?>
<script>
    // scripts.js
$(function() {
    $('.dropdown-toggle').dropdown();
    $('#buscanome').focus();

    $('.noticias_linha').hide();

    $('.copiarTexto').click(function(e) {
        e.preventDefault();
        const copyText = $(this).attr('data-text');
        copyToClipboard(copyText);
    });

    $('#bcadastrarFUNCIONARIO, .abreperfil').click(function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        sessionStorage.setItem('linkanterior', href);
        $('#subconteudo').load(href);
    });

    $('#busca').click(function() {
        const buscanome = encodeURIComponent($('#buscanome').val());
        const buscafunc = $('#buscafunc').val();
        const buscasetor = encodeURIComponent($('#setorbusca').val());
        const link = `administracao/paginarh.php?busca=1&nome=${buscanome}&func=${buscafunc}&buscasetor=${buscasetor}`;
        
        $('body').load(link, function() {
            window.history.pushState('page2', 'Title', link);
            sessionStorage.setItem('linkanterior', link);
        });
    });
});

async function copyToClipboard(textToCopy) {
    if (navigator.clipboard && window.isSecureContext) {
        try {
            await navigator.clipboard.writeText(textToCopy);
        } catch (err) {
            console.error('Failed to copy: ', err);
        }
    } else {
        const textArea = document.createElement('textarea');
        textArea.value = textToCopy;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
        } catch (err) {
            console.error('Failed to copy: ', err);
        }
        textArea.remove();
    }
}

async function loadPage(page) {
    $('#subsubconteudo').load(`/siiupa/administracao/${page}.php`);
}

</script>