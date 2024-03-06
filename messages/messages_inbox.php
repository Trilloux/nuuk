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
                <input type="checkbox" name="selectedItems[]" value="<?php echo $row['id']; ?>">
                    <span class="message_sender"><?php echo $row['sent_by']; ?></span>
                    <span class="message_subject">Subject: <?php echo $msg_title= strlen($row['title'])>25 ? substr($row['title'], 0, 25).'...' :$row['title']; ?></span>
                    <span class="message_time"><?php echo date('Y-m-d', strtotime($row['created'])); ?></span>
                </div>
                <div id="message_content_<?php echo $row['id']; ?>" class="message_content" style="display:none;">
                    <span class="message_subject"><?php echo $row['title']; ?><br></span>
                    <br>
                    <?php 
                   echo preg_replace('/\v+|\\\r\\\n/Ui','<br/>',$row["context"]);
                    ?>
                    <br>
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
                    <br>
                    <p></p>
                    <br>
                    <button id="reply_button"><a href="?id=4&section=reply&reply_id=<?php echo $row['id']; ?>">&#8680; Reply</a></button>
                </div>
            </div>
        <?php }
    } ?>
</div>

<script>
  
//function to display full message content or to hide it
function showMessageContent(messageId) {
    var messageContent = document.getElementById('message_content_' + messageId);
    var checkbox = document.getElementById('checkbox_' + messageId);
    
    // check if event from checkbox, exclude checkbox form display content function!
    if (event.target.type !== 'checkbox') {
        if (messageContent.style.display === 'none' || messageContent.style.display === '') {
            messageContent.style.display = 'block';
        } else {
            messageContent.style.display = 'none';
        }
    }
}

    function getCheckedTaskIds() {
        var checkboxes = document.getElementsByName('selectedItems[]');
        var checkedIds = [];
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkedIds.push(checkboxes[i].value);
            }
        }
        return checkedIds;
    }

    function deleteMessage() {
        var checkedTaskIds = getCheckedTaskIds();
        if (checkedTaskIds.length > 0) {
            var existingUrl = 'home.php?id=4'; // Your existing URL with the ID parameter
            var delUrl = existingUrl + '&delete_inbox_ids=' + checkedTaskIds.join(','); // Join the array of IDs into a comma-separated string
            window.location.href = delUrl;
        } else {
            alert('Please select messages to delete.');
        }
    }

    function markImportant() {
    var checkedTaskIds = getCheckedTaskIds();
    if (checkedTaskIds.length > 0) {
        var existingUrl = 'home.php?id=4'; // Your existing URL with the ID parameter
        var delUrl = existingUrl + '&important_ids=' + checkedTaskIds.join(','); // Join the array of IDs into a comma-separated string
        window.location.href = delUrl;
    } else {
        alert('Please select messages to mark important.');
    }
}

function markRead() {
    var checkedTaskIds = getCheckedTaskIds();
    if (checkedTaskIds.length > 0) {
        var existingUrl = 'home.php?id=4'; // Your existing URL with the ID parameter
        var delUrl = existingUrl + '&read_ids=' + checkedTaskIds.join(','); // Join the array of IDs into a comma-separated string
        window.location.href = delUrl;
    } else {
        alert('Please select messages to mark important.');
    }
}

</script>
