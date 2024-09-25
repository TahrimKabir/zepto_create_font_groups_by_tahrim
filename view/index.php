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
<div id="font_list"></div>

<script>
document.getElementById('upload_font_file').addEventListener('change', function () {
    let formData = new FormData();
    let file = document.getElementById('upload_font_file').files[0];

    if (file) {
        formData.append('upload_font', file);

  
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../controllers/upload.php', true);

   
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('File uploaded successfully:', xhr.responseText);
                loadInsertedList();
            } else {
                console.log('Error uploading file.');
            }
        };

        
        xhr.send(formData);
    } else {
        console.log('No file selected');
    }
});
  
function loadInsertedList() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../controllers/fetch_fonts.php', true); 

    xhr.onload = function () {
        if (xhr.status === 200) {
            
            let fonts = JSON.parse(xhr.responseText);

            
            let output = '<table>';
            output += '<tr><th>Font Name</th><th>File Name</th></tr>'; 
            if (fonts.length > 0) {
                fonts.forEach(function (font) {
                    output += '<tr><td>' + font.font_name + '</td><td>' + font.file_name + '</td>';
                    output += '<td><button onclick="deleteFont(' + font.id + ')">Delete</button></td></tr>';
                });
            } else {
                output += '<tr><td colspan="2">No fonts uploaded yet.</td></tr>';
            }
            output += '</table>';

            
            document.getElementById('font_list').innerHTML = output;
        } else {
            console.log('Error loading font list.');
        }
    };

   
    xhr.send();
}


window.onload = function() {
    loadInsertedList();
};
</script>
</body>
</html>