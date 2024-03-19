<?php

//Check if reply is pressed and has message id 
if(isset($_GET['section']) && $_GET['section'] == 'reply' && isset($_GET['reply_id'])) {
    $message_id = $_GET['reply_id'];

    //Show message content from db using message id
    $message_query = "SELECT * FROM $MsgTab_name WHERE id = $message_id";
    $message_result = mysqli_query($con, $message_query);
    $message_row = mysqli_fetch_array($message_result);
    
}
?>

<?php if(isset($message_row)) { ?>
    <div id="message_form_wrapper">
        <div class="message_form_header">
            <span>Reply to  Message</span>
        </div>
        <form method="POST" action="" id="message_form" enctype="multipart/form-data">
            <input type="text" name="recipient" required value="<?php echo htmlspecialchars($message_row['sent_by']); ?>" readonly>
            <input type="text" name="title" value="RE: <?php echo htmlspecialchars($message_row['title']); ?>" readonly>
            <div id="context_header">
                <br>                
            </div>
            <label for="reply_text">Reply Text:</label>
            <textarea id="task_description" name="description" required>
                <?php echo "----------REPLY----------\n"; ?>
                <?php echo htmlspecialchars($message_row['sent_by']); ?><br>
                <?php echo preg_replace('/\v+|\\\r\\\n/Ui','<br/>',$message_row["context"]); ?><br>
                <?php echo $message_row['file_path']; ?><br>
            </textarea>
            <label id="fileLabel">Attachments:</label><br>
            <input type="file" id="file_upload" name="file_upload[]" multiple>

            <div id="button_field">
                <input type="submit" name="submit_reply" value="Send" class="form_button">
                <input type="reset" value="Reset" role="button" name="reset_reply" class="form_button">
            </div>
        </form>
    </div>
<?php } ?>

