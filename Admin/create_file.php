<?php 
if (!isset($_SESSION["id"])) {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit();
}

include 'admin_methods_files.php';
?>

<div id="file_form_wrapper">
    <div class="file_form_header">
    <span>File information</span>
    </div>
    <form method="POST" action="" id="file_form" enctype="multipart/form-data">
<!-- Pārējās formas lauki... -->
    <label>Title</label>
            <input type="text" name="title" id="task_title" required value="<?php echo $edit_file_title; ?>">
        <label>Description</label>
            <textarea id="task_description" name="description" required><?php echo $edit_file_content;?></textarea>
        <label id="fileLabel">Attachments:</label><br>
            <input type="file" id="file_upload" name="file_upload[]" multiple>
            <div id="file_list">
            <!-- Šeit tiks parādīti esošie faili -->
            <?php
            // Parādīt esošos failus, ja tie ir
            if($existing_files && count($edit_file_path) != NULL){ // Pārbauda, vai ir esoši faili
                foreach ($edit_file_path as $file) {
                    echo '<div><a href="' . $file . '" target="_blank">' . basename($file) . '</a>';
                    echo '<button class="remove-file" data-file="' . $file . '">X</button></div>';
                }
            } else {
                echo '<div>No existing files</div>';
            }
            ?>
        </div>

        <div id="button_field">
    <?php if (isset($editFile_id)) : ?>
        <input type="hidden" name="edit_file" value="<?php echo $editFile_id; ?>">
        <input type="submit" name="submit_update" value="Update" class="form_button">
    <?php else : ?>
        <input type="submit" name="submit" value="Create" class="form_button">
    <?php endif; ?>
    <input type="reset" value="Reset" role="button" name="reset" class="form_button">
</div>

    </form>
</div>
<script>
document.getElementById('file_upload').addEventListener('change', function() {
    var files = Array.from(this.files); // Pārvērš failu sarakstu par masīvu
    var fileList = document.getElementById('file_list');
    var removeButtons = document.querySelectorAll('.remove-file');

    // Notīra iepriekšējo sarakstu
    fileList.innerHTML = '';

    // Pārbauda, vai ir augšupielādēti faili
    if (files.length > 0) {
        // Veido jaunu sarakstu ar augšupielādētajiem failiem
        var ul = document.createElement('ul');
        files.forEach(function(file) {
            var li = document.createElement('li');
            li.textContent = file.name + ' - ' + file.size + ' bytes';
            var removeButton = document.createElement('button');
            removeButton.textContent = 'X';
            removeButton.className = 'remove-file';
            removeButton.dataset.file = file.name;
            li.appendChild(removeButton);
            ul.appendChild(li);
        });
        fileList.appendChild(ul);
    }

    // Parāda vai paslēpj "X" pogas atkarībā no failu klātbūtnes
    if (files.length > 0) {
        removeButtons.forEach(function(button) {
            button.style.display = 'inline-block';
        });
    } else {
        removeButtons.forEach(function(button) {
            button.style.display = 'none';
        });
    }
});

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-file')) {
        var fileToRemove = event.target.dataset.file;
        var fileList = document.getElementById('file_list');
        
        // Izņemt failu no saraksta
        event.target.parentElement.remove();
        
        // Atjaunot failu sarakstu, izņemot noņemto failu
        var ul = fileList.querySelector('ul');
        var lis = ul.querySelectorAll('li');
        for (var i = 0; i < lis.length; i++) {
            if (lis[i].textContent.includes(fileToRemove)) {
                ul.removeChild(lis[i]);
                break;
            }
        }

        // Pārbauda, vai vairs nav failu, lai paslēptu "X" pogu
        var removeButtons = document.querySelectorAll('.remove-file');
        if (ul.children.length === 0) {
            removeButtons.forEach(function(button) {
                button.style.display = 'none';
            });
        }
    }
});
</script>