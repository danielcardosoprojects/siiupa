<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de JPEG para PNG</title>
</head>
<body>
    <h1>Conversor de JPEG para PNG</h1>
    <form action="convert.php" method="post" enctype="multipart/form-data">
        <label for="files">Selecione até 40 arquivos JPEG:</label>
        <input type="file" name="files[]" id="files" multiple accept="image/jpeg" required>
        <br><br>
        <button type="submit">Converter para PNG</button>
    </form>
</body>
</html>