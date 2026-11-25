<?php
/*
 * imprimir_ferias.php  —  Férias / Recesso em A4 PAISAGEM
 * Salve em: administracao/ferias/imprimir_ferias.php
 *
 * AJUSTES NECESSÁRIOS:
 * 1) Caminho do include de conexão (abaixo).
 * 2) Se o sistema tem login/sessão, coloque aqui a mesma verificação
 *    que o index usa (session_start() + checagem), pois esta página
 *    abre sozinha, fora do index.
 */

include(__DIR__ . "/../../bd/conectabd.php"); // <- ajuste se necessário

function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

$MESES = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
          7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
$MESES_ABR = [1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 5 => 'Mai', 6 => 'Jun',
              7 => 'Jul', 8 => 'Ago', 9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'];

/* ---------- filtros (todos validados) ---------- */
$ano = isset($_GET['ano_ferias']) ? (int)$_GET['ano_ferias'] : (int)date('Y');
if ($ano < 2000 || $ano > 2100) { $ano = (int)date('Y'); }

$vinculo = strtolower($_GET['vinculo'] ?? '');
if (!in_array($vinculo, ['efetivo', 'temporario'], true)) { $vinculo = ''; }

$idsetor = isset($_GET['idsetor']) ? (int)$_GET['idsetor'] : 0;

/* ---------- setores (para o filtro e para o texto do cabeçalho) ---------- */
$setores = [];
if ($stmt = $conn->prepare("SELECT id, setor, categoria FROM u940659928_siupa.tb_setor ORDER BY setor ASC")) {
  $stmt->execute();
  $stmt->bind_result($sid, $snome, $scat);
  while ($stmt->fetch()) { $setores[$sid] = $snome . ($scat ? " - " . $scat : ""); }
  $stmt->close();
}

/* ---------- consulta principal (com prepared statement de verdade) ---------- */
$sql = "SELECT ferias.id, func.nome, c.titulo, s.setor, ferias.datainicio, ferias.datafim,
               ferias.ref_mes, func.vinculo, ferias.observacao
        FROM u940659928_siupa.tb_ferias AS ferias
        INNER JOIN u940659928_siupa.tb_funcionario AS func ON ferias.fk_funcionario = func.id
        INNER JOIN u940659928_siupa.tb_cargo AS c ON func.fk_cargo = c.id
        INNER JOIN u940659928_siupa.tb_setor AS s ON func.fk_setor = s.id
        WHERE func.status = 'ATIVO' AND ferias.ref_ano = ?";
$types = 'i';
$params = [$ano];
if ($vinculo !== '') { $sql .= " AND func.vinculo = ?"; $types .= 's'; $params[] = $vinculo; }
if ($idsetor > 0)    { $sql .= " AND func.fk_setor = ?"; $types .= 'i'; $params[] = $idsetor; }
$sql .= " ORDER BY ferias.ref_mes ASC, func.nome ASC";

$grupos = [];                       // [mes] => [linhas]
$porMes = array_fill(1, 12, 0);     // contagem por mês
$nomesUnicos = [];

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  $stmt->bind_result($fid, $nome, $cargo, $setor, $ini, $fim, $mes, $vin, $obs);
  while ($stmt->fetch()) {
    $mes = (int)$mes;
    $grupos[$mes][] = ['nome' => $nome, 'cargo' => $cargo, 'setor' => $setor, 'ini' => $ini,
                       'fim' => $fim, 'vinculo' => $vin, 'obs' => $obs];
    if ($mes >= 1 && $mes <= 12) { $porMes[$mes]++; }
    $nomesUnicos[$nome] = true;
  }
  $stmt->close();
}
ksort($grupos);

$totalRegistros = array_sum($porMes);
$totalServidores = count($nomesUnicos);
$maxMes = max($porMes);
$mesMaisCheio = $maxMes > 0 ? array_search($maxMes, $porMes) : null;

/* ---------- helpers de data ---------- */
function dataBr($d) {
  if (!$d || $d === '0000-00-00') return '—';
  return date('d/m/Y', strtotime($d));
}
function totalDias($i, $f) {
  if (!$i || !$f || $i === '0000-00-00' || $f === '0000-00-00') return null;
  try { return (new DateTime($i))->diff(new DateTime($f))->days + 1; }
  catch (Exception $e) { return null; }
}

/* ---------- texto descritivo do filtro ---------- */
$partesFiltro = [];
$partesFiltro[] = $vinculo === 'efetivo' ? 'Servidores efetivos' : ($vinculo === 'temporario' ? 'Servidores temporários' : 'Todos os vínculos');
$partesFiltro[] = $idsetor > 0 && isset($setores[$idsetor]) ? 'Setor: ' . $setores[$idsetor] : 'Todos os setores';
$textoFiltro = implode(' | ', $partesFiltro);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Férias e Recesso <?= h($ano) ?></title>
<style>
  :root {
    --pine: #1f5c4a;        /* verde institucional */
    --pine-dark: #153f33;
    --mint: #e7f1ec;        /* fundo suave */
    --ink: #1c2a26;
    --muted: #6b7b75;
    --rule: #d3ddd8;
    --amber: #a8650c;
    --amber-bg: #fbeed6;
    --paper: #ffffff;
  }
  * { box-sizing: border-box; }
  html { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  body {
    margin: 0; color: var(--ink); background: #e9eeeb;
    font-family: "Segoe UI", system-ui, -apple-system, Arial, sans-serif;
    font-size: 10pt; line-height: 1.35;
  }

  /* ===== barra de ferramentas (só na tela) ===== */
  .toolbar {
    position: sticky; top: 0; z-index: 10; display: flex; flex-wrap: wrap; gap: 10px;
    align-items: center; padding: 10px 16px; background: var(--pine-dark); color: #fff;
  }
  .toolbar form { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin: 0; }
  .toolbar select, .toolbar button, .toolbar a.btn {
    font: inherit; padding: 6px 10px; border-radius: 6px; border: 1px solid #ffffff55;
    background: #ffffff18; color: #fff; text-decoration: none; cursor: pointer;
  }
  .toolbar select option { color: #000; }
  .toolbar .spacer { flex: 1; }
  .toolbar .btn-print { background: #fff; color: var(--pine-dark); font-weight: 600; border-color: #fff;
    display: inline-flex; align-items: center; gap: 6px; }
  .toolbar :focus-visible { outline: 2px solid #fff; outline-offset: 2px; }

  /* ===== "folha" A4 paisagem na tela ===== */
  .sheet {
    width: 297mm; min-height: 210mm; margin: 16px auto; padding: 10mm;
    background: var(--paper); box-shadow: 0 2px 14px #0003;
  }

  /* ===== cabeçalho ===== */
  .head { display: flex; align-items: center; gap: 14px; padding-bottom: 10px; border-bottom: 3px solid var(--pine); }
  .head .logo { width: 46px; height: 46px; border-radius: 10px; background: var(--pine); color: #fff;
    display: grid; place-items: center; flex: none; }
  .head h1 { margin: 0; font-size: 22pt; line-height: 1.1; color: var(--pine-dark); letter-spacing: -0.3px; }
  .head .sub { color: var(--muted); font-size: 9.5pt; margin-top: 2px; }
  .head .meta { margin-left: auto; text-align: right; font-size: 9pt; color: var(--muted); }
  .head .meta strong { color: var(--ink); display: block; font-size: 10pt; }

  /* ===== resumo + gráfico por mês ===== */
  .summary { display: flex; gap: 18px; align-items: stretch; margin: 12px 0 14px; }
  .stats { display: flex; flex-direction: column; gap: 8px; width: 62mm; flex: none; }
  .stat { background: var(--mint); border-radius: 8px; padding: 8px 12px; }
  .stat b { display: block; font-size: 20pt; line-height: 1; color: var(--pine-dark); }
  .stat span { font-size: 9pt; color: var(--muted); }
  .chart-box { flex: 1; border: 1px solid var(--rule); border-radius: 8px; padding: 8px 12px 6px; }
  .chart-title { font-size: 9pt; color: var(--muted); margin-bottom: 4px; }
  .chart { display: flex; align-items: flex-end; gap: 8px; height: 74px; }
  .chart .col { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; height: 100%; }
  .chart .n { font-size: 9pt; font-weight: 600; color: var(--pine-dark); }
  .chart .n.zero { color: #a9b6b0; font-weight: 400; }
  .chart .bar { width: 100%; max-width: 30px; background: var(--pine); border-radius: 3px 3px 0 0; min-height: 2px; }
  .chart .bar.zero { background: var(--rule); }
  .chart .m { font-size: 8.5pt; color: var(--muted); margin-top: 3px; }

  /* ===== blocos por mês ===== */
  .mes { margin-top: 12px; }
  .mes-head { display: flex; align-items: baseline; gap: 10px; padding: 5px 10px;
    background: var(--pine); color: #fff; border-radius: 6px 6px 0 0; break-after: avoid; page-break-after: avoid; }
  .mes-head h2 { margin: 0; font-size: 13pt; font-weight: 600; }
  .mes-head .qtd { margin-left: auto; font-size: 9pt; opacity: .9; }

  table { width: 100%; border-collapse: collapse; table-layout: fixed; }
  thead { display: table-header-group; }
  th { text-align: left; font-size: 8.5pt; font-weight: 600; color: var(--pine-dark);
    background: var(--mint); padding: 5px 8px; border-bottom: 1.5px solid var(--pine); }
  td { padding: 5px 8px; border-bottom: 1px solid var(--rule); vertical-align: top; word-wrap: break-word; }
  tr { break-inside: avoid; page-break-inside: avoid; }
  tbody tr:nth-child(even) td { background: #f7faf8; }
  td.nome { font-weight: 600; }
  td.centro, th.centro { text-align: center; }
  td.periodo { white-space: nowrap; }
  .dias { display: inline-block; min-width: 28px; padding: 1px 6px; border-radius: 10px;
    background: var(--mint); color: var(--pine-dark); font-weight: 600; font-size: 9pt; text-align: center; }
  .vinc { display: inline-block; padding: 1px 8px; border-radius: 10px; font-size: 8.5pt; font-weight: 600; }
  .vinc.efetivo { background: #dcefe6; color: var(--pine-dark); }
  .vinc.temporario { background: var(--amber-bg); color: var(--amber); }
  .vazio { color: #a9b6b0; }
  .obs { font-size: 9pt; color: #3d4b46; }

  .sem-dados { padding: 30px; text-align: center; color: var(--muted); border: 1px dashed var(--rule); border-radius: 8px; margin-top: 14px; }

  .rodape { margin-top: 14px; padding-top: 6px; border-top: 1px solid var(--rule);
    display: flex; justify-content: space-between; font-size: 8.5pt; color: var(--muted); }

  /* ===== impressão ===== */
  @page {
    size: A4 landscape;
    margin: 10mm 10mm 12mm 10mm;
    @bottom-right { content: "Página " counter(page) " de " counter(pages); font-size: 8pt; color: #6b7b75; }
  }
  @media print {
    body { background: #fff; }
    .toolbar { display: none !important; }
    .sheet { width: auto; min-height: 0; margin: 0; padding: 0; box-shadow: none; }
  }
</style>
</head>
<body>

<!-- ============ BARRA DE FERRAMENTAS (não imprime) ============ -->
<div class="toolbar">
  <form method="get">
    <select name="ano_ferias" aria-label="Ano">
      <?php for ($a = (int)date('Y') - 4; $a <= (int)date('Y') + 1; $a++): ?>
        <option value="<?= $a ?>" <?= $a === $ano ? 'selected' : '' ?>><?= $a ?></option>
      <?php endfor; ?>
    </select>
    <select name="vinculo" aria-label="Vínculo">
      <option value="">Todos os vínculos</option>
      <option value="efetivo" <?= $vinculo === 'efetivo' ? 'selected' : '' ?>>Efetivos</option>
      <option value="temporario" <?= $vinculo === 'temporario' ? 'selected' : '' ?>>Temporários</option>
    </select>
    <select name="idsetor" aria-label="Setor">
      <option value="">Todos os setores</option>
      <?php foreach ($setores as $id => $txt): ?>
        <option value="<?= (int)$id ?>" <?= $id === $idsetor ? 'selected' : '' ?>><?= h($txt) ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Aplicar filtros</button>
  </form>
  <span class="spacer"></span>
  <button type="button" class="btn-print" onclick="window.print()">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
    Imprimir
  </button>
</div>

<!-- ============ FOLHA ============ -->
<main class="sheet">

  <header class="head">
    <div class="logo" aria-hidden="true">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
    </div>
    <div>
      <h1>Férias e Recesso <?= h($ano) ?></h1>
      <div class="sub"><?= h($textoFiltro) ?></div>
    </div>
    <div class="meta">
      <strong>SIIUPA - Administração</strong>
      Emitido em <?= date('d/m/Y \à\s H:i') ?>
    </div>
  </header>

  <?php if ($totalRegistros === 0): ?>
    <div class="sem-dados">Nenhum registro de férias encontrado para este filtro. Altere o ano, o vínculo ou o setor.</div>
  <?php else: ?>

  <section class="summary">
    <div class="stats">
      <div class="stat"><b><?= (int)$totalServidores ?></b><span>servidores com férias em <?= h($ano) ?></span></div>
      <div class="stat"><b><?= $mesMaisCheio ? h($MESES[$mesMaisCheio]) : '—' ?></b><span>mês com mais saídas (<?= (int)$maxMes ?>)</span></div>
    </div>
    <div class="chart-box">
      <div class="chart-title">Quantidade de servidores de férias em cada mês</div>
      <div class="chart">
        <?php foreach ($porMes as $m => $q):
          $altura = $maxMes > 0 ? max(2, round(($q / $maxMes) * 46)) : 2; ?>
          <div class="col">
            <span class="n <?= $q ? '' : 'zero' ?>"><?= (int)$q ?></span>
            <div class="bar <?= $q ? '' : 'zero' ?>" style="height:<?= (int)$altura ?>px"></div>
            <span class="m"><?= $MESES_ABR[$m] ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php foreach ($grupos as $m => $linhas): ?>
    <section class="mes">
      <div class="mes-head">
        <h2><?= h($MESES[$m] ?? $m) ?> de <?= h($ano) ?></h2>
        <span class="qtd"><?= count($linhas) ?> <?= count($linhas) === 1 ? 'servidor' : 'servidores' ?></span>
      </div>
      <table>
        <colgroup>
          <col style="width:22%"><col style="width:17%"><col style="width:15%">
          <col style="width:9%"><col style="width:9%"><col style="width:6%">
          <col style="width:9%"><col style="width:13%">
        </colgroup>
        <thead>
          <tr>
            <th>Nome</th><th>Cargo</th><th>Setor</th>
            <th class="centro">Início</th><th class="centro">Término</th><th class="centro">Dias</th>
            <th class="centro">Vínculo</th><th>Observação</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($linhas as $l):
          $dias = totalDias($l['ini'], $l['fim']);
          $vclass = strtolower(strtr($l['vinculo'], ['Á'=>'A','á'=>'a','Ã'=>'A','ã'=>'a']));
          $vclass = $vclass === 'temporario' ? 'temporario' : 'efetivo';
          $vlabel = $vclass === 'temporario' ? 'Temporário' : 'Efetivo'; ?>
          <tr>
            <td class="nome"><?= h($l['nome']) ?></td>
            <td><?= h($l['cargo']) ?></td>
            <td><?= h($l['setor']) ?></td>
            <td class="centro periodo"><?= dataBr($l['ini']) ?></td>
            <td class="centro periodo"><?= dataBr($l['fim']) ?></td>
            <td class="centro"><?= $dias !== null ? '<span class="dias">' . (int)$dias . '</span>' : '<span class="vazio">—</span>' ?></td>
            <td class="centro"><span class="vinc <?= $vclass ?>"><?= $vlabel ?></span></td>
            <td class="obs"><?= trim((string)$l['obs']) !== '' ? h($l['obs']) : '<span class="vazio">—</span>' ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  <?php endforeach; ?>

  <?php endif; ?>

  <footer class="rodape">
    <span>Documento gerado pelo SIIUPA. Informações conforme o cadastro no momento da emissão.</span>
    <span>Total: <?= (int)$totalRegistros ?> <?= $totalRegistros === 1 ? 'registro' : 'registros' ?></span>
  </footer>

</main>

<?php if (!empty($_GET['auto'])): ?>
<script>window.addEventListener('load', function () { window.print(); });</script>
<?php endif; ?>
</body>
</html>
