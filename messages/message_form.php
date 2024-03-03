
<div id="message_form_wrapper">
    <div id="message_form_header">
    <span>Message information</span>
    </div>
    <form method="POST" action="" id="message_form" enctype="multipart/form-data">
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

<!-- Pārējās formas lauki... -->
    <label>Title</label>
        <input type="text" name="title" id="task_title" required>
    <label>Description</label>
        <textarea id="task_description" name="description" required></textarea>
    <label id="fileLabel">Attachments:</label><br>
        <input type="file" id="file_upload" name="file_upload[]" multiple>

    <div id="button_field">
        <input type="submit" name="submit" value="Send" class="form_button">
        <input type="reset" value="Reset" role="button" name="reset" class="form_button">
            </div>
</form>
</div>

<script>

// Definējam globālo mainīgo, kas glabā saņēmēju skaitu
var recipientCount = 0;

// Pievienojam notikuma klausītāju pogai "Add Recipient"
document.getElementById('addRecipient').addEventListener('click', function() {
    // Iegūstam izvēlēto lietotāju un viņa ID
    var select = document.getElementById('userinfo');
    var selectedOption = select.options[select.selectedIndex];
    var userId = selectedOption.value;
    var userName = selectedOption.textContent;

    // Pārbaudam, vai saņēmējs jau ir pievienots
    if (document.getElementById('recipient_input_' + userId) === null) {
        recipientCount++; // Palielinam skaitītāju

        // Izveidojam jaunu div elementu saņēmēja rindai
        var recipientDiv = document.createElement('div');
        recipientDiv.id = 'recipient_' + userId + '_' + recipientCount; // Piešķiram unikālu ID
        recipientDiv.classList.add('recipient');
        recipientDiv.innerHTML = userName + ' <button type="button" class="removeRecipient" id="removeRecipient_' + userId + '" data-userid="' + userId + '">X</button>';
        document.getElementById('recipients').appendChild(recipientDiv);
        
        // Izveidojam jaunu slēpto ievades lauku saņēmēja ID
        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'recipients[]';
        hiddenInput.value = userId;
        hiddenInput.id = 'recipient_input_' + userId + '_' + recipientCount; // Piešķiram unikālu ID
        document.getElementById('recipients').appendChild(hiddenInput);

        // Pievienojam notikuma klausītāju pogai "X", lai noņemtu saņēmēju
        document.getElementById('removeRecipient_' + userId).addEventListener('click', function() {
            recipientDiv.parentNode.removeChild(recipientDiv);
            hiddenInput.parentNode.removeChild(hiddenInput);
        });
    }
});

// Pievienojam notikuma klausītāju formas iesniegšanai
document.getElementById('message_form').addEventListener('submit', function() {
    // Veic pārlādi pēc formas iesniegšanas
    location.reload();
});

</script>


