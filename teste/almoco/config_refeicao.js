/* Configuração compartilhada: lista_refeicao.html e previsao_refeicao.html */

/* ===== CONFIGURAÇÃO ===== */
const CFG = {
  API: '/siiupa/api/rh/api.php/records',   // mesmo domínio
  HEADERS: {},                              // quando religar o token, ex.: { 'X-Authorization': 'Bearer SEU_TOKEN' }
  PAGE_SIZE: 300
};

/* IDs (fk_funcionario.id) de quem não almoça nem janta. Ex.: [68, 359, 14] */
const EXCLUIR_IDS = [107/*walter */, 409/* Euriene */, 410/*Marlilson */, 407/*kATAOKA*/, /*'14' DANIEL,*/ 201 /*EMILY*/, 17 /*FLAVIA*/, 434/*IGOR*/ ];
const DEFAULTS = {
  unit: 'UPA',
  fixL: ['Guarda 1', 'Guarda 2', 'Médico 1', 'Médico 2', 'Médico 3', 'Médico 4', 'Médico 5'].join('\n'),
  fixJ: ['Guarda 1', 'Guarda 2', 'Médico 1', 'Médico 2', 'Médico 3', 'Médico 4'].join('\n')
};
