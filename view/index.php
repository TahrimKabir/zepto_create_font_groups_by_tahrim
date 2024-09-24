<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form id="upload_font" enctype="multipart/form-data">
    <input type="file" name="upload_font" id="upload_font_file">
    
</form>

<script>
document.getElementById('upload_font_file').addEventListener('change', function () {
    let formData = new FormData();
    let file = document.getElementById('upload_font_file').files[0];

    if (file) {
        formData.append('upload_font', file);

        // Create an AJAX request object
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../controllers/upload.php', true);

        // Callback for when the request is complete
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('File uploaded successfully:', xhr.responseText);
            } else {
                console.log('Error uploading file.');
            }
        };

        // Send the request
        xhr.send(formData);
    } else {
        console.log('No file selected');
    }
});
</script>
</body>
</html>