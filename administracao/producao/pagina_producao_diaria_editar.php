<?php
header('Content-type: text/html; charset=utf-8');
include("../../bd/conectabd.php");

?>
<style>
    .box {
        height: 130px;
    }

    .bt_altera {
        display: none;
    }

    .box:hover+.bt_altera {
        display: block;

    }

    td {
        font-size: 20px;
        font-weight: bold;
    }

    #capturaTecla {
        font-size: larger;
    }

    .backgroundVerde {
        animation: fundoVerde 0.1s;
    }

    @keyframes fundoVerde {
        0% {
            background: #FFF;

        }

        50% {
            background: green;

        }

        100% {
            background: #FFF;

        }
    }

    .vermelho {
        color: blue;
        border: solid 1px blue;
        background-color: lightblue;
    }

    .KeyA,
    .KeyB,
    .KeyC,
    .KeyD,
    .KeyE,
    .KeyF,
    .KeyG,
    .KeyH,
    .KeyI,
    .KeyJ,
    .KeyK,
    .KeyL,
    .KeyM,
    .KeyN,
    .KeyO,
    .KeyP,
    .KeyQ,
    .KeyR,
    .KeyS,
    .KeyT,
    .KeyU,
    .KeyV,
    .KeyW,
    .KeyX,
    .KeyY,
    .KeyZ,
    .Numpad0,
    .Numpad1,
    .Numpad2,
    .Numpad3,
    .Numpad4,
    .Numpad5,
    .Numpad6,
    .Numpad7,
    .Numpad8,
    .Numpad9,
    .Numpad0 {
        background-size: 60px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: 50px 50px;
    }

    .KeyA {
        background-image: url('imagens/producao/a.png');
    }

    .KeyB {
        background-image: url('imagens/producao/b.png');
    }

    .KeyC {
        background-image: url('imagens/producao/c.png');
    }

    .KeyD {
        background-image: url('imagens/producao/d.png');
    }

    .KeyE {
        background-image: url('imagens/producao/e.png');
    }

    .KeyF {
        background-image: url('imagens/producao/f.png');
    }

    .KeyG {
        background-image: url('imagens/producao/g.png');
    }

    .KeyH {
        background-image: url('imagens/producao/h.png');
    }

    .KeyI {
        background-image: url('imagens/producao/i.png');
    }

    .KeyJ {
        background-image: url('imagens/producao/j.png');
    }

    .KeyK {
        background-image: url('imagens/producao/k.png');
    }

    .KeyL {
        background-image: url('imagens/producao/l.png');
    }

    .KeyM {
        background-image: url('imagens/producao/m.png');
    }

    .KeyN {
        background-image: url('imagens/producao/n.png');
    }

    .KeyO {
        background-image: url('imagens/producao/o.png');
    }

    .KeyP {
        background-image: url('imagens/producao/p.png');
    }

    .KeyQ {
        background-image: url('imagens/producao/q.png');


    }

    .KeyR {
        background-image: url('imagens/producao/r.png');
    }

    .KeyS {
        background-image: url('imagens/producao/s.png');
    }

    .KeyT {
        background-image: url('imagens/producao/t.png');
    }

    .KeyU {
        background-image: url('imagens/producao/u.png');
    }

    .KeyV {
        background-image: url('imagens/producao/v.png');
    }

    .KeyW {
        background-image: url('imagens/producao/w.png');
    }

    .KeyX {
        background-image: url('imagens/producao/x.png');
    }

    .KeyY {
        background-image: url('imagens/producao/y.png');
    }

    .KeyZ {
        background-image: url('imagens/producao/z.png');
    }

    .Digit1,
    .Numpad1 {
        background-image: url('imagens/producao/1.png');
    }

    .Digit2,
    .Numpad2 {
        background-image: url('imagens/producao/2.png');
    }

    .Digit3,
    .Numpad3 {
        background-image: url('imagens/producao/3.png');
    }

    .Digit4,
    .Numpad4 {
        background-image: url('imagens/producao/4.png');
    }

    .Digit5,
    .Numpad5 {
        background-image: url('imagens/producao/5.png');
    }

    .Digit6,
    .Numpad6 {
        background-image: url('imagens/producao/6.png');
    }

    .Digit7,
    .Numpad7 {
        background-image: url('imagens/producao/7.png');
    }

    .Digit8,
    .Numpad8 {
        background-image: url('imagens/producao/8.png');
    }

    .Digit9,
    .Numpad9 {
        background-image: url('imagens/producao/9.png');
    }

    .Digit0,
    .Numpad0 {
        background-image: url('imagens/producao/0.png');
    }
</style>
<div id="capturaTecla"></div>
<h1>Data:
    <table class="table table-bordered" id="tabela_producao_diaria">
        <thead>

        </thead>
        <tbody>
            <tr>
                <th colspan="6" class="text-center">Total de Atendimentos: </th>
            </tr>
            <tr>
                <td class="box " data-campo="idade.0_13">PA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="idade.14_21">Glicemia<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box " data-campo="idade.22_59">FR<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box r" data-campo="idade.60_idoso">FC<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="sexo.feminino">Saturação<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="sexo.masculino">CRISE HIPERTENSIVA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
            </tr>
            <tr>
                <td class="box" data-campo="CRISE_HIPERTENSIVA">TEMPERATURA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="COM_CARTAO_SUS">PESO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                </tr>
            <tr>
                <td class="box" data-campo="CONSULTA_MEDICO">CONSULTA MÉDICO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="CONSULTA_ENFERMEIRO">CONSULTA ENFERMEIRO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="CONSULTA_SERVICO_SOCIAL">CONSULTA SERVIÇO SOCIAL<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                
            </tr>
            <tr>
            <td class="box" data-campo="FR">SEM CNS<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="INALACAO">SEM CLASSIFICAÇÃO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                </tr>
            <tr>
                <td class="box" data-campo="GLICEMIA">Idade 0-13<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
         
                <td class="box" data-campo="TEMPERATURA">Idade 14-21<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="PESO">Idade 22-59<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="SURTO_PSICOTICO">Idade 60+<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
            </tr>
            <tr>
                <th class="text-center" colspan="6">ANAMNESE</th>
            </tr>
            <tr>
                <td class="box" data-campo="PA">PA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="PULSOFC">PULSO/FC<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
               
                
                
                <td class="box" data-campo="HEMOPA">HEMOPA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="SUSIPE">SUSIPE<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
            </tr>

            <tr>
                <th class="text-center" colspan="6">MEDICAMENTOS / CONSULTAS</th>
            </tr>

            <tr>
                <td class="box" data-campo="MEDICAMENTOS">MEDICAMENTOS<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="CONSULTA_MEDICOx">CONSULTA MÉDICO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="CONSULTA_ENFERMEIROx">CONSULTA ENFERMEIRO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="CONSULTA_SERVICO_SOCIALx">CONSULTA SERVIÇO SOCIAL<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
            </tr>

            <tr>
                <th class="text-center" colspan="6">ACIDENTES / OCORRÊNCIAS / QUEDAS</th>
            </tr>

            <tr>
                <td class="box" data-campo="ACIDTRANSITO.MOTO_X_CARRO">MOTO X CARRO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.MOTO_X_MOTO">MOTO X MOTO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.MOTO_X_VEICULO_GRANDE">MOTO X VEÍCULO GRANDE<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.MOTO_-_QUEDA">MOTO – QUEDA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.MOTO_-_OUTROS">MOTO - OUTROS<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.VEICULO_GRANDE">VEÍCULO GRANDE<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
            </tr>

            <tr>
                <td class="box" data-campo="ACIDTRANSITO.CARRO_-_CAPOTAMENTO">CARRO – CAPOTAMENTO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.CARRO_X_CARRO">CARRO X CARRO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.CARRO_X_VEICULO_GRANDE">CARRO X VEÍCULO GRANDE<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.CARRO_OUTROS">CARRO – OUTROS<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACIDTRANSITO.ATROPELAMENTO">ATROPELAMENTO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="QUEDA.BICICLETA">BICICLETA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
            </tr>

            <tr>
                <td class="box" data-campo="AGRESSAO.FAB">FAB<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="AGRESSAO.FAF">FAF<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="ACID.TRABALHO">ACIDENTE DE TRABALHO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="GESTANTE">GESTANTE<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="AGRESSAO.FISICA">AGRESSÃO FÍSICA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="TRAUMA">TRAUMA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
            </tr>

            <tr>
                <td class="box" data-campo="QUEDA.PROPRIA_ALTURA">PRÓPRIA ALTURA <br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="QUEDA._1m">+1m<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="QUEDA.CAMA">CAMA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="QUEDA.ESCADA">ESCADA<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="QUEDA.CAVALO">CAVALO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>

            </tr>

            <tr>
                <td class="box" data-campo="QUEDA.ARVORE">QUEDA DE ÁRVORE <br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="QUEDA.REDE">REDE <br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="QUEDA.TELHADO">TELHADO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="QUEDA.OUTROS">OUTROS<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>
                <td class="box" data-campo="TENTATIVA_DE_SUICIDIO">TENTATIVA DE SUICIDIO<br>
                    <h3>
                        <p>0</p>
                    </h3>
                </td>

            </tr>


        </tbody>
    </table>
    <style>
        #cadastro {
            display: none;
        }
    </style>

    <td id="login" class="bg-danger">Teste 1</td>
    <td id="cadastro" class="bg-info">Teste 2</td>
    <button id="btn_cadastrar">Vai</button>

    <script>
        $(function() {
            $("#btn_cadastrar").click(function() {
                $('#login').hide('slide', {
                    direction: 'left'
                }, 1000);
                $('#cadastro').show('slide', {
                    direction: 'right'
                }, 1000);
            });
            tabela = $("#tabela_producao_diaria");
            i = 0;
            letras = ["KeyQ", "KeyW", "KeyE", "KeyR", "KeyT", "KeyY", "KeyA", "KeyS", "KeyX", "KeyC", "KeyV", "KeyF", "KeyG", "KeyH", "KeyJ", "KeyK", "KeyL", "KeyK", "KeyL", "Semicolon", "KeyZ", "KeyX", "KeyC", "KeyV", "KeyB", "KeyN", "KeyM", "Numpad1", "Numpad2", "Numpad3", "Numpad4", "Numpad5", "Numpad6", "Numpad7", "Numpad8", "Numpad9", "Numpad0"];
            $('.box').each(function(index) {
                letra = letras[i];
                $(this).addClass(letra);
                i = i + 1
            });

            $(".box").hover(
                function() {
                    var $teste3 = $("<span class='bt_altera'><button class='bg-success form-control'>+</button><button class='bg-danger form-control'>-</button></span>");

                    esteCampo = $(this).data('campo');
                    $(this).append("<span><button class='bg-success form-control bt_add' data-campo='" + esteCampo + "'>+</button><button class='bg-danger form-control bt_remove'>-</button></span>");
                    $(".bt_add").click(function() {
                        addProd(esteCampo);

                    });
                    $(".bt_remove").click(function() {
                        removeProd(esteCampo);
                    });

                },
                function() {
                    $(this).find("span").last().remove();
                }
            );
            $("body").keypress(function(event) {
                $("#capturaTecla").text(event.which + event.code);
                const keyPressed = event.which;

                function mapearTeclas(keyCode) {
                    const mapeamento = {
                        113: "idade.0_13", // q
                        119: "idade.14_21", // w
                        101: "idade.22_59", // e
                        114: "idade.60_idoso", // r
                        116: "sexo.feminino", // t
                        121: "sexo.masculino", // y
                        117: "CRISE_HIPERTENSIVA", // u
                        105: "COM_CARTAO_SUS", // i
                        111: "SEM_CARTAO_SUS", // o
                        112: "COM_CLASSIFICACAO", // p
                        97: "CRISE_HIPERTENSIVA", // a
                        115: "COM_CARTAO_SUS", // s
                        100: "PULSOFC", // d
                        102: "FR", // f
                        103: "INALACAO", // g
                        104: "GLICEMIA", // h
                        106: "TEMPERATURA", // j
                        107: "PESO", // k
                        108: "SURTO_PSICOTICO", // l
                        231: "HEMOPA", // ç
                        122: "SUSIPE", // z
                        120: "CONSULTA_MEDICO", // x
                        99: "CONSULTA_ENFERMEIRO", // c
                        118: "CONSULTA_SERVICO_SOCIAL", // v
                        98: "CONSULTA_SERVICO_SOCIAL", // b
                        110: "ACIDTRANSITO.MOTO_X_CARRO", // n
                        109: "ACIDTRANSITO.MOTO_X_MOTO", // m
                        49: "ACIDTRANSITO.MOTO_X_VEICULO_GRANDE", // 1
                        50: "ACIDTRANSITO.MOTO_-_QUEDA", // 2
                        51: "ACIDTRANSITO.MOTO_-_OUTROS", // 3
                        52: "ACIDTRANSITO.VEICULO_GRANDE", // 4
                        53: "ACIDTRANSITO.CARRO_-_CAPOTAMENTO", // 5
                        54: "ACIDTRANSITO.CARRO_X_CARRO", // 6
                        55: "ACIDTRANSITO.CARRO_X_VEICULO_GRANDE", // 7
                        56: "ACIDTRANSITO.CARRO_OUTROS", // 8
                        57: "ACIDTRANSITO.ATROPELAMENTO", // 9
                        48: "QUEDA.BICICLETA" // 0
                        // Adicione mais mapeamentos aqui, se necessário
                    };

                    return mapeamento[keyCode] || false;
                }
                const valorMapeado = mapearTeclas(keyPressed);
                console.log(valorMapeado);
                //const executaTecla = mapearTeclas[keyPressed];
                if (valorMapeado) {
                    addProd(valorMapeado);
                } else {
                    console.log("Tecla não mapeada");
                }


            });

            function addProd(esteCampo) {
                box = $(".box[data-campo='" + esteCampo + "']");
                boxValor = $(".box[data-campo='" + esteCampo + "'] p");
                textoBox = parseInt(boxValor.text());
                soma = textoBox + 1;
                boxValor.text(soma);
                box.addClass("backgroundVerde");
                setTimeout(function() {
                    box.removeClass("backgroundVerde")
                }, 100);

                tabela = $("#tabela_producao_diaria");
                ultimoEditado = tabela.find(".vermelho");
                if (ultimoEditado.length) {
                    ultimoEditado.removeClass("vermelho");
                    box.addClass("vermelho");
                } else {
                    box.addClass("vermelho");
                }


                return null;
            }

            function removeProd(esteCampo) {
                textoBox = parseInt($(".box[data-campo='" + esteCampo + "'] p").text());
                diminui = textoBox - 1;
                if (diminui < 0) {
                    diminui = 0;
                }
                $(".box[data-campo='" + esteCampo + "'] p").text(diminui);
                return null;
            }


        });
    </script>

    <style>
        .bt_altera {
            background-color: yellow;
            padding: 20px;
            display: none;
        }

        .box:hover+.bt_altera {
            display: block;
        }
    </style>