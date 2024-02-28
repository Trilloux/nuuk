<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'messages_methods.php';
?>

<div id="message_form_wrapper">
    <div id="message_form_header">
    <span>Message information</span>
    </div>
<form method="POST" action="" id="message_form">
<div id="recipients"></div>
    <label for="userinfo">Users</label>
        <select name="userinfo" id="userinfo">
            <?php
            $show_query = 'SELECT * FROM users';
            $show_result = mysqli_query($con, $show_query);   
            while($row = mysqli_fetch_array($show_result)){
                $get_id = $row['id'];
                $user_fname = $row['firstName'];
                $user_lname = $row['lastName'];
            ?>
                <option value="<?php echo $get_id; ?>"><?php echo $user_fname . ' ' . $user_lname; ?></option>
            <?php } ?>
        </select>
    <button type="button" id="addRecipient">Add Recipient</button>
    <label>Title</label>
        <input type="text" name="title" id="task_title" required value="<?php echo $edit_title; ?>">
    <label>Description</label>
        <textarea id="task_description" name="description" required><?php echo $edit_descr; ?></textarea>
    <label>Attachments:</label><br>
        <input type="file" id="file" name="file[]" multiple><br>

    <div id="button_field">
        <input type="submit" name="submit" value="Send" class="form_button">
        <input type="reset" value="Reset" role="button" name="reset" class="form_button">
            </div>
</form>
</div>

<script>
    document.getElementById('addRecipient').addEventListener('click', function() {
        var select = document.getElementById('userinfo');
        var selectedOption = select.options[select.selectedIndex];
        var userId = selectedOption.value;
        var userName = selectedOption.textContent;

        // Check if user is already selected
        if (document.getElementById('recipient_' + userId) === null) {
            var recipientDiv = document.createElement('div');
            recipientDiv.id = 'recipient_' + userId;
            recipientDiv.classList.add('recipient'); // Pievieno klasi, lai piemērotu CSS
            recipientDiv.innerHTML = userName + ' <button type="button" class="removeRecipient" id="removeRecipient" data-userid="' + userId + '">X</button>';
            document.getElementById('recipients').appendChild(recipientDiv);
        }
    });

    document.getElementById('recipients').addEventListener('click', function(event) {
        if (event.target.classList.contains('removeRecipient')) {
            var userId = event.target.getAttribute('data-userid');
            var recipientDiv = document.getElementById('recipient_' + userId);
            recipientDiv.parentNode.removeChild(recipientDiv);
        }
    });
</script>