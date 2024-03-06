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
                <input type="checkbox" name="selectedItems[]" value="<?php echo $row['id']; ?>">
                    <span class="message_sender"><?php echo $row['sent_to']; ?></span>
                    <span class="message_subject">Subject: <?php echo $msg_title= strlen($row['title'])>25 ? substr($row['title'], 0, 25).'...' :$row['title']; ?></span>
                    <span class="message_time"><?php echo date('Y-m-d', strtotime($row['created'])); ?></span>
                </div>
                <div id="message_content_<?php echo $row['id']; ?>" class="message_content" style="display:none;">
                <span class="message_subject"><?php echo $row['title']; ?><br></span>
                <br>
                    <?php 
                    echo preg_replace('/\v+|\\\r\\\n/Ui','<br/>',$row["context"]);
                     ?>
                    <?php echo $row['file_path'];?>
                </div>
            </div>
        <?php }
        } ?>
</div>


<script>
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
    
    function deleteMessage() {
        var checkedTaskIds = getCheckedTaskIds();
        if (checkedTaskIds.length > 0) {
            var existingUrl = 'home.php?id=4&section=sent'; // Your existing URL with the ID parameter
            var delUrl = existingUrl + '&delete_outbox_ids=' + checkedTaskIds.join(','); // Join the array of IDs into a comma-separated string
            window.location.href = delUrl;
        } else {
            alert('Please select messages to delete.');
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
</script>

