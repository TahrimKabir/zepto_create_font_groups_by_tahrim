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
    <form>
    <h1>Add Multiple Divs</h1>
    <div>
        <input type="text" name="font_group" id="">
    </div>
    <div id="divContainer">
        <div class="div-box">
            <input type="text" name="font_name" class="input-field" placeholder="Input Field">
            <select name="font_id[]" class="font-select">
                <option value=""></option>
            </select>
            <input type="number" name="specific_size[]" id="">
            <input type="number" name="price_change[]" id="">
            <button class="remove-button">Remove</button>
        </div>
    </div>
    <button id="addDivButton" type="button">Add Div</button>
    <button type="submit">create</button>
</form>
    <script>
        document.getElementById('upload_font_file').addEventListener('change', function() {
            let formData = new FormData();
            let file = document.getElementById('upload_font_file').files[0];

            if (file) {
                formData.append('upload_font', file);


                let xhr = new XMLHttpRequest();
                xhr.open('POST', '../controllers/upload.php', true);


                xhr.onload = function() {
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

            xhr.onload = function() {
                if (xhr.status === 200) {

                    let fonts = JSON.parse(xhr.responseText);

                    console.log(fonts);
                    let output = '<table>';
                    output += '<tr><th>Font Name</th><th>File Name</th></tr>';
                    if (fonts.length > 0) {
                        fonts.forEach(function(font) {
                            output += '<tr><td>' + font.font_name + '</td><td>' + font.file_name + '</td>';
                            output += '<td><button onclick="deleteFont(' + font.id + ')">Delete</button></td></tr>';
                        });
                    } else {
                        output += '<tr><td colspan="2">No fonts uploaded yet.</td></tr>';
                    }
                    output += '</table>';


                    document.getElementById('font_list').innerHTML = output;
                    populateFontSelects(fonts);
                } else {
                    console.log('Error loading font list.');
                }
            };


            xhr.send();
        }

        function deleteFont(fontId) {
            let xhr = new XMLHttpRequest();
            xhr.open('DELETE', '../controllers/delete_font.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json'); // Set the content type to JSON

            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log(fontId);
                    console.log('Font deleted successfully:', xhr.responseText);
                    loadInsertedList(); // Refresh the font list after deletion
                } else {
                    console.log('Error deleting font.');
                }
            };

            // Send the ID as JSON
            xhr.send(JSON.stringify({
                id: fontId
            }));
        }


        window.onload = function() {
            loadInsertedList();
        };
    </script>
    <script>
        document.getElementById('addDivButton').addEventListener('click', function() {
    const divContainer = document.getElementById('divContainer');
    
    // Get the first div as a template
    const templateDiv = divContainer.querySelector('.div-box');
    
    // Clone the template div
    const newDiv = templateDiv.cloneNode(true); // true means deep clone
    
    // Clear the input field in the cloned div
    const inputField = newDiv.querySelector('.input-field');
    inputField.value = ''; // Clear the input field for the new div
    
    // Append the new div to the container
    divContainer.appendChild(newDiv);
    
    // Add functionality to the remove button of the cloned div
    const removeButton = newDiv.querySelector('.remove-button');
    removeButton.addEventListener('click', function() {
        divContainer.removeChild(newDiv);
    });
});

    </script>
    <script>
                function populateFontSelects(fonts) {
            let selects = document.querySelectorAll('.font-select');
            selects.forEach(function (select) {
                select.innerHTML = '<option value="">Select a font</option>'; // Clear existing options
                fonts.forEach(function (font) {
                    let option = document.createElement('option');
                    option.value = font.file_name;
                    option.textContent = font.font_name;
                    select.appendChild(option);
                });
            });
        }
    </script>
</body>

</html>