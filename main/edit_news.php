<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'Admin/admin_methods_news.php';
?>

<div id="news_list">
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Content</th>
            <th>Created</th>
            <th colspan="2">Action</th>
        </tr>
        <?php 
        $listNewsQuery="SELECT * FROM news_feed";
        $listResult=mysqli_query($con, $listNewsQuery);
        while($row=mysqli_fetch_array($listResult)){
        ?>
        <tr>
            <td><?php echo $row['id'] ?></td>
            <td class="cut_text_cell"><?php echo $row['title'] ?></td>
            <td><?php echo $row['author'] ?></td>
            <td class="cut_text_cell"><?php echo $row['content'] ?></td>
            <td><?php echo $row['created'] ?></td>
            <td><button><a id="edit_newslist" href="home.php?id=admin_3&edit_newslist=<?php echo $row['id']; ?>">Edit</a></button></td>
            <td><button onclick="deleteNews(<?php echo $row['id']; ?>)">Delete</button></td>
            </tr>
        <?php } ?>
        </table>
</div>

<script>
    //newsId is pased from <td><button onclick="deleteNews(echo $row['id']...
    function deleteNews(newsId) {
    var confirmation = confirm('Delete this news post?');
    console.log(newsId);
    if (confirmation) {
        console.log("Confirmed");
        //Execute deleteNews function from admin_methods_news.php using Ajax
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin/admin_methods_news.php', true);
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
        var data = 'news_id=' + newsId;
        xhr.send(data);
    } else {
        console.log('Deletion canceled');
    }
}
</script>