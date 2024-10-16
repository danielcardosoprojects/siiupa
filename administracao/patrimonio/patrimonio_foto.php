<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Foto com Vue.js</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css">
    <!-- Axios JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>

    <div id="app" class="container mt-5">
        <h2>Upload de Foto <?= $_GET['foto']; ?></h2>
        <form @submit.prevent="uploadPhoto">
            <div class="form-group">
                <label for="fileInput">Escolha uma foto:</label>
                <input type="file" id="fileInput" @change="handleFileUpload" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <img src="../../loading.gif" style="display: hidden"/>
        <div v-if="uploadStatus" class="mt-3" :class="{'text-success': uploadStatus.success, 'text-danger': !uploadStatus.success}">
            {{ uploadStatus.message }}
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                selectedFile: null,
                uploadStatus: null,
            },
            methods: {
                handleFileUpload(event) {
                    this.selectedFile = event.target.files[0];
                },
                async uploadPhoto() {
                    if (!this.selectedFile) {
                        this.uploadStatus = {
                            success: false,
                            message: 'Por favor, escolha uma foto antes de enviar.'
                        };
                        return;
                    }

                    const formData = new FormData();
                    formData.append('foto', this.selectedFile);

                    try {
                        const response = await fetch('/siiupa/administracao/patrimonio/upload.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();
                        this.uploadStatus = {
                            success: result.success,
                            message: result.message
                        };

                        fotoUrl = "<?= $_GET['foto']; ?>";
                        // Handle both 'principal' and 'etiqueta' cases efficiently
                        const fotoKey = fotoUrl === 'principal' ? 'foto_frente' : 'foto_etiqueta';

                        const updatedData = {
                            [fotoKey]: result.filename, // Use computed property name for clarity
                        };

                        // URL da API para atualizar o recurso (substitua pela URL correta)
                        const url = `https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos/<?= $_GET['id']; ?>`;

                        axios.put(url, updatedData)
                            .then(response => {
                                console.log('Foto atualizada com sucesso:', response.data);
                                Swal.fire({
                                    icon: "success",
                                    title: "Foto cadastrada com sucesso",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    window.location.href = `/siiupa/administracao/patrimonio/<?=$_GET['id'];?>`;
                                }, 1600); // 3000 milissegundos = 3 segundos

                            })
                            .catch(error => {
                                console.error('Erro ao atualizar foto:', error);
                            });
                    } catch (error) {
                        this.uploadStatus = {
                            success: false,
                            message: 'Erro ao fazer upload da foto.'
                        };
                        console.error('Upload failed:', error);
                    }
                }
            }
        });
    </script>
</body>

</html>