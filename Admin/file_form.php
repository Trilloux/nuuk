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
            <input type="text" name="title" id="task_title" required>
        <label>Description</label>
            <textarea id="task_description" name="description" required></textarea>
        <label id="fileLabel">Attachments:</label><br>
            <input type="file" id="file_upload" name="file_upload[]" multiple>
            <div id="file_list"></div>

        <div id="button_field">
    <?php if (isset($file_id)) : ?>
        <input type="hidden" name="update_id" value="<?php echo $file_id; ?>">
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
    var files = this.files;
    var fileList = document.getElementById('file_list');

    // Notīra iepriekšējo sarakstu
    fileList.innerHTML = '';

    // Pārbauda, vai ir augšupielādēti faili
    if (files.length > 0) {
        // Veido jaunu sarakstu ar augšupielādētajiem failiem
        var ul = document.createElement('ul');
        for (var i = 0; i < files.length; i++) {
            var li = document.createElement('li');
            li.textContent = files[i].name + ' - ' + files[i].size + ' bytes';
            ul.appendChild(li);
        }
        fileList.appendChild(ul);
    }
});
</script>