<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Foto com Vue.js</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>
<body>
<div id="app" class="container mt-5">
    <h2>Upload de Foto</h2>
    <form @submit.prevent="uploadPhoto">
        <div class="form-group">
            <label for="fileInput">Escolha uma foto:</label>
            <input type="file" id="fileInput" @change="handleFileUpload" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
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
                    this.uploadStatus = { success: false, message: 'Por favor, escolha uma foto antes de enviar.' };
                    return;
                }

                const formData = new FormData();
                formData.append('foto', this.selectedFile);

                try {
                    const response = await fetch('upload.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    this.uploadStatus = { success: result.success, message: result.message };
                } catch (error) {
                    this.uploadStatus = { success: false, message: 'Erro ao fazer upload da foto.' };
                    console.error('Upload failed:', error);
                }
            }
        }
    });
</script>
</body>
</html>
