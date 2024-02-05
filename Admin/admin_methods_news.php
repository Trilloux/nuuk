<?php
include '../database.php';
if (isset($_GET['edit_newslist'])) {
    $edit_id = mysqli_real_escape_string($con, $_GET['edit_newslist']);
    $selNew_query = 'SELECT * FROM news_feed WHERE id = ?';
    $selNew_stmt = mysqli_prepare($con, $selNew_query);
    mysqli_stmt_bind_param($selNew_stmt, 'i', $edit_id);
    mysqli_stmt_execute($selNew_stmt);
    $news_result = mysqli_stmt_get_result($selNew_stmt);
    //Show news post data in form fields
    if ($row = mysqli_fetch_array($news_result)) {
        $edit_title = $row['title'];
        $edit_author = $row['author'];
        $edit_content = $row['content'];
    }
}

if(isset($_POST['submit']) || isset($_POST['submit_update'])) {
    // Create new variables from form input fields when form is submitted
    $news_title = mysqli_real_escape_string($con, $_POST['title']);
    $news_content = mysqli_real_escape_string($con, $_POST['content']);
    $news_author = mysqli_real_escape_string($con, $_POST['author']);
    
    //If statement if submit - create news post , if submit_update - update news post data
    if(isset($_POST['submit'])){
    postNews($news_title, $news_author, $news_content);
    }else if(isset($_POST['submit_update'])){
    $updNewsId=$_GET['edit_newslist'];
    updateNews($updNewsId, $news_title, $news_content, $news_author);
 }
}
//Update existing news post function
function updateNEWS($updNewsId, $news_title, $news_content, $news_author){
    global $con;
    $updNews_query = "UPDATE news_feed SET title = ?, content = ?, author = ? WHERE id = ?";
        $updNews_stmt = mysqli_prepare($con, $updNews_query);
        mysqli_stmt_bind_param($updNews_stmt, 'sssi', $news_title, $news_content, $news_author, $updNewsId);
        if (mysqli_stmt_execute($updNews_stmt)) {
            if (mysqli_stmt_affected_rows($updNews_stmt) > 0) {
                echo 'News updated successfully';
            } else {
                echo 'No changes were made to the news data';
            }
        } else {
            echo 'Error: Data was NOT updated!' . mysqli_error($con);
        }    
    }
//Create new news post function
function postNews($news_title, $news_author, $news_content) {
    global $con;
    $news_query = "INSERT INTO news_feed (title, author, content) VALUES (?, ?, ?)";
    $news_stmt = mysqli_prepare($con, $news_query);
    if ($news_stmt) {
        mysqli_stmt_bind_param($news_stmt, 'sss', $news_title, $news_author, $news_content);

        if (mysqli_stmt_execute($news_stmt)) {
            echo 'News posted successfully!';
        } else {
            echo 'Error executing statement: ' . mysqli_stmt_error($news_stmt);
        }
    } else {
        echo 'Error preparing statement: ' . mysqli_error($con);
    }
}

//Delete user function
function deleteNews($newsId) {
    global $con;
    $delNew_query = 'DELETE FROM news_feed WHERE id = ?';
    $delNew_stmt = mysqli_prepare($con, $delNew_query);
    mysqli_stmt_bind_param($delNew_stmt, 'i', $newsId);
    mysqli_stmt_execute($delNew_stmt);

    if (mysqli_stmt_affected_rows($delNew_stmt) > 0) {
        echo "Post deleted!";
    } else {
        echo "Error deleting post!";
        echo $newsId;
    }
}
//get id of news post to delete, pass the id to deleteNews function
if (isset($_POST['news_id'])) {
    $newsId = $_POST['news_id'];
    //Call delete news funciton, pass id to delete
    deleteNews($newsId);
}

?>
