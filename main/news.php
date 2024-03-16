<?php
include '../database.php';
$blog_query = 'SELECT * FROM news_feed ORDER BY id DESC' ;
$blog_result = mysqli_query($con, $blog_query);
while($row = mysqli_fetch_array($blog_result)){
//query to get news posts from DB in Desc order
?>

<div id="wraper_blog">
    <div id="title_field">
        <div id="blog_title">
        <span><?php echo $row['title']; ?></span>
        </div>
    </div>
    <div id="content_field">
        <div id="blog_content">
        <p id="content"><?php echo preg_replace('/\v+|\\\r\\\n/Ui','<br/>',$row['content']);?></p>
        </div>
    </div>
    <div id="author_field">
        <div id="blog_author">
        <span><?php echo $row['author'];?>: <?php echo $row['created']; ?></span>
        </div>
    </div>
</div>
<?php }if (!$blog_result) {
    die('Connection error' . mysqli_connect_error());
}
?>