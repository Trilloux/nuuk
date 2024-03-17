<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'Admin/admin_methods_news.php';
?>
<div id="existing_files">
    <h2>Existing files posts</h2>
</div>
<div id="files_list">
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Content</th>
            <th>Attachements</th>
            <th>Created</th>
            <th colspan="2">Action</th>
        </tr>
        <?php 
        $listFilesQuery="SELECT * FROM files";
        $filesResult=mysqli_query($con, $listFilesQuery);
        if(mysqli_num_rows($filesResult) > 0){
            while($row=mysqli_fetch_array($filesResult)){
        ?>
        <tr>
            <td><?php echo $row['id'] ?></td>
            <td class="cut_text_cell_file"><?php echo $row['title'] ?></td>
            <td><?php echo $row['author'] ?></td>
            <td class="cut_text_cell_file"><?php echo $row['text'] ?></td>
            <td class="cut_text_cell_file"><?php echo $row['file_path'] ?></td>
            <td><?php echo $row['created'] ?></td>
            <td><button><a id="edit_newslist" href="home.php?id=admin_9&edit_file=<?php echo $row['id']; ?>">Edit</a></button></td>
            <td><button onclick="deleteNews(<?php echo $row['id']; ?>)">Delete</button></td>
            </tr>
        <?php }
        }else{
            echo '<p class="noMessages">There currently are no File posts!</p>';
        }
    
        ?>
        </table>
</div>

<script>
    //newsId is pased from <td><button onclick="deleteNews(echo $row['id']...
    function deleteNews(filePostId) {
    var confirmation = confirm('Delete this files post?');
    console.log(filePostId);
    if (confirmation) {
        console.log("Confirmed");
        //Execute deleteNews function from admin_methods_news.php using Ajax
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin/admin_methods_files.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                window.location.reload();
            } else {
                console.log('Request failed. Status: ' + xhr.status);
            }
        };
        //Sends data object , which contains delete ID
        var data = 'file_post_id=' + filePostId;
        xhr.send(data);
    } else {
        console.log('Deletion canceled');
    }
}
</script>