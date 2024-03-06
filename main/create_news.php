<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'Admin/admin_methods_news.php';
?>
<div id="news_heading">
    <span>News Information</span>
</div>
<div id="news_form_wrapper">
<form method="POST" action="" id="news_form">
    <label>Title</label>
    <input type="text" name="title" id="news_title" required value="<?php echo $edit_title; ?>">
    <label>Content</label>
    <textarea id="news_content" name="content" required><?php echo preg_replace('/\v+|\\\r\\\n/Ui','<br/>',$edit_content);?></textarea>
    <label>Author</label>
    <input type="text" name="author" id="news_author" required value="<?php echo $edit_author; ?>">
    <div id="button_field">
    <?php if (isset($edit_id)) : ?>
        <input type="hidden" name="update_id" value="<?php echo $edit_id; ?>">
        <input type="submit" name="submit_update" value="Update" class="form_button">
    <?php else : ?>
        <input type="submit" name="submit" value="Create" class="form_button">
    <?php endif; ?>
    <input type="reset" value="Reset" role="button" name="reset" class="form_button">
            </div>
</form>
</div>