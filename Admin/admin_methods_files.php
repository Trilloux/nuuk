<?php
include '../database.php';


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
        //updateTask($table_name, $task_id, $task_title, $task_descr, $task_priority, $task_alert);
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
?>