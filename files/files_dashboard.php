<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include '../admin_methods_files.php';

?>

<div id="file_dashboard_wrapper">
    <div id="file_dash_header">
        <h2>Workspace File Section</h2>
    </div>
    <div class="file_post_container">
        <?php
        global $con;
        $displayFiles_query="SELECT * FROM files ORDER BY created DESC";
        $displayFiles_result=mysqli_query($con, $displayFiles_query);
        if(mysqli_num_rows($displayFiles_result) > 0){
            while($row=mysqli_fetch_array($displayFiles_result)){
        ?>
    <div class="file_posts">
        <div class="file_post_title">
            <h3 class="file_dashboard"><?php echo $row['title']; ?></h3>
        </div>
        <div class="file_post_content">
            <?php
        if (strpos($row['text'], 'http') !== false) {
            // Replace links with html
            $text_with_links = preg_replace("/(http[^\s]+)/", "<a href='$1'>$1</a>", $row['text']);

            // replace `<br>` with empty space
            $text_with_links = str_replace('<br>', ' ', $text_with_links);

            // replace text with links and  \v+, \r, \n with <br/> tag
            echo preg_replace('/(?<!<\/a>)\v+|\\\r\\\n|\\n/', '<br/>', $text_with_links);
            } else {
            // If no links just display text
            echo preg_replace('/\v+|\\\r\\\n|\\n/', '<br/>', $row['text']);
            }
            ?>
        </div>
        <br>
        <div class="file_post_files">
        <?php 
                    // check if files added to message
                    if (!empty($row['file_path'])) {
                        //divide file paths if multiple files added
                        echo '<span style="color: #FFA824; font-weight: bold;">Added files:</span><br>';
                        $files = explode(',', $row['file_path']);
                        // show hyperlinks to each files
                        foreach ($files as $file) {
                            $file_name = basename($file); // get file name from path
                            echo '<a href="' . $file . '" download>' . $file_name . '</a><br>';
                        }
                    }
                    ?>
        </div>
        <div class="file_post_info">
            <p>
                <?php echo $row['author'].' '.$row['created']; ?>
            </p>
        </div>
        <br>
        </div>
        <?php }
        }else{
            echo '<p class="noMessages">There currently are no File posts!</p>';
        }
         ?>
    </div>
</div>
