<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $photoName = basename($_POST['name']);
        $fileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $uploadFile = $uploadDir . $photoName . '.' . $fileType;

        // Verifica se o arquivo é uma imagem
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo 'Tipo de arquivo não permitido. Por favor, envie uma imagem (JPEG, PNG, GIF).';
            exit;
        }

        // Verifica o tamanho do arquivo (limite de 10MB)
        if ($_FILES['file']['size'] > 10 * 1024 * 1024) {
            echo 'O tamanho do arquivo não deve exceder 10MB.';
            exit;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            echo 'Upload realizado com sucesso!';
        } else {
            echo 'Erro ao realizar upload.';
        }
    } else {
        echo 'Nenhum arquivo enviado ou erro no upload.';
    }
    exit;
}

// Função para listar as 100 imagens mais recentes
function listRecentImages($dir, $limit = 100) {
    $images = glob($dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    usort($images, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });

    return array_slice($images, 0, $limit);
}

$recentImages = listRecentImages('uploads/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Foto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Upload de Foto</h2>
                    <form id="uploadForm" action="index.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="fileInput" class="btn btn-primary btn-block">Escolher Foto</label>
                            <input type="file" class="form-control-file" id="fileInput" name="file" accept="image/*" capture="environment" required hidden>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="photoName" placeholder="Nome da Foto" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Upload</button>
                    </form>
                    <p id="statusMessage" class="mt-3 text-center"></p>

                    <div class="progress mt-3" style="height: 25px;">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <h3 class="mt-5">Imagens Recentes</h3>
                    <ul class="list-group">
                        <?php foreach ($recentImages as $image): ?>
                            <li class="list-group-item">
                                <a href="<?php echo $image; ?>" target="_blank"><?php echo basename($image); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('fileInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            document.querySelector('label[for="fileInput"]').textContent = file.name;
        }
    });

    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const fileInput = document.getElementById('fileInput');
        const photoName = document.getElementById('photoName').value;

        if (!fileInput.files.length) {
            document.getElementById('statusMessage').textContent = 'Por favor, selecione uma foto.';
            return;
        }

        const file = fileInput.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const maxSize = 10 * 1024 * 1024; // 10MB

        if (!allowedTypes.includes(file.type)) {
            document.getElementById('statusMessage').textContent = 'Por favor, selecione um arquivo de imagem válido (JPEG, PNG, GIF).';
            return;
        }

        if (file.size > maxSize) {
            document.getElementById('statusMessage').textContent = 'O tamanho do arquivo não deve exceder 10MB.';
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('name', photoName);

        const config = {
            onUploadProgress: function(progressEvent) {
                const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                const progressBar = document.getElementById('progressBar');
                progressBar.style.width = percentCompleted + '%';
                progressBar.setAttribute('aria-valuenow', percentCompleted);
            }
        };

        axios.post('index.php', formData, config)
            .then(response => {
                document.getElementById('statusMessage').textContent = response.data;
                if (response.data.includes('sucesso')) {
                    document.getElementById('statusMessage').classList.remove('text-danger');
                    document.getElementById('statusMessage').classList.add('text-success');
                } else {
                    document.getElementById('statusMessage').classList.remove('text-success');
                    document.getElementById('statusMessage').classList.add('text-danger');
                }
                setTimeout(() => location.reload(), 2000); // Reload the page after 2 seconds to update the image list
            })
            .catch(error => {
                console.error('Erro ao realizar upload:', error);
                document.getElementById('statusMessage').textContent = 'Erro ao realizar upload.';
                document.getElementById('statusMessage').classList.remove('text-success');
                document.getElementById('statusMessage').classList.add('text-danger');
            });
    });
</script>

</body>
</html>
