<div class="mailbox_block">
        <?php
        $inbox_query = "SELECT * FROM $MsgTab_name ORDER BY created DESC";
        $inbox_result = mysqli_query($con, $inbox_query);
        if(mysqli_num_rows($inbox_result)==0){
            echo '<p class="noMessages">You currenty have no messsages!<p>';
        }else{
        while($row=mysqli_fetch_array($inbox_result)){
            $messageMark='';
            switch($row['mark']){
                case'not_read':
                    $messageMark='notRead';
                    break;
                case'read':
                    $messageMark='read';
                    break;
                default:
                    $messageMark='notRead';
            }
            if($row['important']=='yes'){
                $messageMark='important';
            }
        
            
        ?>
          
            <div class="inbox_message" id="<?php echo $messageMark; ?>">
                <div class="message_info" onclick="showMessageContent(<?php echo $row['id']; ?>)">
                <input type="checkbox" name="message_id" value="<?php echo $row['id']; ?>">
                    <span class="message_sender"><?php echo $row['sent_by']; ?></span>
                    <span class="message_subject">Subject: <?php echo $msg_title= strlen($row['title'])>25 ? substr($row['title'], 0, 25).'...' :$row['title']; ?></span>
                    <span class="message_time"><?php echo date('Y-m-d', strtotime($row['created'])); ?></span>
                </div>
                <div id="message_content_<?php echo $row['id']; ?>" class="message_content" style="display:none;">
                    <span class="message_subject"><?php echo $row['title']; ?><br></span>
                    <br>
                    <?php echo $row['context']; ?>
                    <?php 
                    // check if files added to message
                    if (!empty($row['file_path'])) {
                        //divide file paths if multiple files added
                        $files = explode(',', $row['file_path']);
                        // show hyperlinks to each files
                        foreach ($files as $file) {
                            $file_name = basename($file); // get file name from path
                            echo '<a href="' . $file . '" download>' . $file_name . '</a><br>';
                        }
                    }
                    ?>
                    <br>
                    <p></p>
                    <br>
                    <button id="reply_button">&#8680; Reply</button>
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