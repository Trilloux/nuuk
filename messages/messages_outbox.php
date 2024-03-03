<div class="mailbox_block">
        <?php
        $sentMail_table = 'user_'.$_SESSION['id'].'_outbox';
        $outbox_query = "SELECT * FROM $sentMail_table ORDER BY created DESC";
        $outbox_result = mysqli_query($con, $outbox_query);
        if(mysqli_num_rows($outbox_result)==0){
            echo '<p class="noMessages">You currenty have no sent messsages!<p>';
        }else{
        while($row=mysqli_fetch_array($outbox_result)){

        ?>
            <div class="inbox_message" id="read">
                <div class="message_info" onclick="showMessageContent(<?php echo $row['id']; ?>)">
                <input type="checkbox" name="message_id" value="<?php echo $row['id']; ?>">
                    <span class="message_sender"><?php echo $row['sent_to']; ?></span>
                    <span class="message_subject">Subject: <?php echo $msg_title= strlen($row['title'])>25 ? substr($row['title'], 0, 25).'...' :$row['title']; ?></span>
                    <span class="message_time"><?php echo date('Y-m-d', strtotime($row['created'])); ?></span>
                </div>
                <div id="message_content_<?php echo $row['id']; ?>" class="message_content" style="display:none;">
                <span class="message_subject"><?php echo $row['title']; ?><br></span>
                    <?php echo $row['context']; ?>
                    <?php echo $row['file_path'];?>
                </div>
            </div>
        <?php }
        } ?>
</div>


<script>
    //function to display full message conent or to hide it
    function showMessageContent(messageId) {
        var messageContent = document.getElementById('message_content_' + messageId);
        if (messageContent.style.display === 'none' || messageContent.style.display === '') {
            messageContent.style.display = 'block';
        } else {
            messageContent.style.display = 'none';
        }
    }
</script>