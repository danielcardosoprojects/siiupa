const express = require('express');
const router = express.Router();
const mysql = require('mysql2');

// Configuração do banco de dados
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'apuapu',
  database: 'db_rh'
});

// Rota para buscar dados
router.get('/dados', (req, res) => {
  connection.query('SELECT * FROM tb_historico', (error, results) => {
    if (error) {
      res.status(500).json({ error: 'Erro ao buscar dados.' });
    } else {
      res.status(200).json(results);
    }
  });
});

module.exports = router;