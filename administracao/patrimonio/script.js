$(document).ready(function() {
    $('#equipamentosTable').DataTable();
});
document.getElementById('itemForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let data = {
        nome: document.getElementById('nome').value,
        tipo: document.getElementById('tipo').value,
        modelo: document.getElementById('modelo').value,
        numeroSerie: document.getElementById('numeroSerie').value,
        dataCadastro: document.getElementById('dataCadastro').value,
        itemId: document.getElementById('itemId').value
    };

    axios.post('https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos?join=setor_id,tb_setor', data)
         .then(response => {
             // Atualize a tabela com a nova entrada
             $('#equipamentosTable').DataTable().ajax.reload();
             $('#itemModal').modal('hide');
         })
         .catch(error => {
             console.error("Erro ao adicionar o item:", error);
         });
});
document.getElementById('addItemBtn').addEventListener('click', function() {
    // Exibe o modal
    let itemModal = new bootstrap.Modal(document.getElementById('itemModal'));
    itemModal.show();
});
