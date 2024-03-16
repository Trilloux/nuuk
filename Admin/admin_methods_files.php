<?php
include '../database.php';
if (isset($_GET['edit_file'])) {
    $editFile_id = mysqli_real_escape_string($con, $_GET['edit_file']);
    $selFile_query = 'SELECT * FROM files WHERE id = ?';
    $selFile_stmt = mysqli_prepare($con, $selFile_query);
    mysqli_stmt_bind_param($selFile_stmt, 'i', $editFile_id);
    mysqli_stmt_execute($selFile_stmt);
    $files_result = mysqli_stmt_get_result($selFile_stmt);
    // show info in form
    if ($row = mysqli_fetch_array($files_result)) {
        $edit_file_title = $row['title'];
        $edit_file_content = $row['text'];
        //show file paths in form
        $edit_file_path = explode(',', $row['file_path']);
       
    }

    // get file paths from db
    $existing_files_query = "SELECT file_path FROM files";
    $existing_files_result = mysqli_query($con, $existing_files_query);

    // save in array
    $existing_files = array();

    // check if there are results
    if(mysqli_num_rows($existing_files_result) > 0) {
        while($row = mysqli_fetch_assoc($existing_files_result)) {
            // add file_path to arrray
            $existing_files[] = $row['file_path'];
        }
    }
}


if(isset($_POST['submit']) || isset($_POST['submit_update'])) {
    // Create new variables from form input fields when form is submitted
    $filePost_title =  $_POST['title'];
    $filePost_descr = $_POST['description'];
    $filePost_by = $_SESSION['firstName'].' '.$_SESSION['lastName'];

    if(isset($_FILES['file_upload']) && is_array($_FILES['file_upload']['name'])) {
        $upload_dir = 'file_storage/';

        // Save all files
        $uploaded_files = array();

        // Loop through each uploaded file
        for($i = 0; $i < count($_FILES['file_upload']['name']); $i++) {
            $file_name = $_FILES['file_upload']['name'][$i];
            $file_tmp = $_FILES['file_upload']['tmp_name'][$i];
            
            // Generate a unique identifier (e.g., timestamp)
            $unique_identifier = time(); // You can use other methods to generate a unique identifier
            
            // Get file extension
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            
            // Construct new file name with unique identifier
            $new_file_name = $file_name . '_' . $unique_identifier . '.' . $file_extension;
            
            // Move the uploaded file to the upload directory with the new name
            if(move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
                $uploaded_files[] = $upload_dir . $new_file_name;
            } 
        }
        //create variable to store file paths to be inserted in DB
        if (!empty($uploaded_files)) {
            $add_file = implode(',', $uploaded_files);
        }
    } else {
        // If no files uploaded , then empty field to be stored in DB
        $add_file = '';
    }
    // If statement if submit - create new task, if submit_update - update task data
    if(isset($_POST['submit'])) {
        PostFiles($filePost_title, $filePost_descr, $filePost_by, $add_file);
    } else if(isset($_POST['submit_update'])) {
        $file_id = $_POST['edit_file'];
        editFiles($file_id, $filePost_title, $filePost_descr, $filePost_by, $add_file);
    
    }
}


function PostFiles($filePost_title, $filePost_descr, $filePost_by, $add_file){
    global $con;
    $postFile_query = "INSERT INTO files (title, text, author, file_path) VALUES  (?, ?, ?, ?)";
    $postFile_stmt = mysqli_prepare($con, $postFile_query);
    if($postFile_stmt){
        mysqli_stmt_bind_param($postFile_stmt, 'ssss', $filePost_title, $filePost_descr, $filePost_by, $add_file);
        if(mysqli_stmt_execute($postFile_stmt)){
        echo 'File post created!';
        }else{
        echo 'Error creating file post '.mysqli_stmt_error($postFile_stmt);
        }
    }

}

function editFiles($file_id, $filePost_title, $filePost_descr, $filePost_by, $add_file){
    global $con;
    $updateFile_query = "UPDATE files SET title = ?, text = ?, author = ?, file_path = ? WHERE id = ?";
    $updateFile_stmt = mysqli_prepare($con, $updateFile_query);
    if($updateFile_stmt){
        mysqli_stmt_bind_param($updateFile_stmt, 'ssssi', $filePost_title, $filePost_descr, $filePost_by, $add_file, $file_id);
        if(mysqli_stmt_execute($updateFile_stmt)){
            echo 'File post updated!';
            header ("Location: home.php?id=admin_10");
        }else{
            echo 'Error updating file post '.mysqli_stmt_error($updateFile_stmt);
        }
    }
    
}

//get id of news post to delete, pass the id to deleteFilePost function
if (isset($_POST['file_post_id'])) {
    $filePostId = $_POST['file_post_id'];
    //Call delete news funciton, pass id to delete
    deleteFilePost($filePostId);
}
function deleteFilePost($filePostId) {
    global $con;
    $delFile_query = 'DELETE FROM files WHERE id = ?';
    $delFile_stmt = mysqli_prepare($con, $delFile_query);
    mysqli_stmt_bind_param($delFile_stmt, 'i', $filePostId);
    mysqli_stmt_execute($delFile_stmt);

    if (mysqli_stmt_affected_rows($delFile_stmt) > 0) {
        echo "Post deleted!";
    } else {
        echo "Error deleting post!";
        echo $filePostId;
    }
}

?>

