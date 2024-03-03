<?php
session_start();
include 'update_user_info.php';
?>
<div id="profile_form_field">
<?php
// Get profile pic name form DB
$profileImageQuery = "SELECT profile_image FROM users WHERE id = $id";
$profileImageResult = mysqli_query($con, $profileImageQuery);
if ($profileImageResult && $row = mysqli_fetch_assoc($profileImageResult)) {
	$targetDir = "uploads/user_$id/";
	$profileImage = $row['profile_image'];
	// If profile_image field in DB empty then use default picuture in uploads folder
	if (empty($profileImage)) {
	$targetDir = "uploads/";
	$profileImage = "default.png"; 
	}
} 
?>
<a href="<?= $targetDir . $profileImage ?>">
  <img src="<?= $targetDir . $profileImage ?>" id="prof_pic_edit" alt="Profile picture">
</a>
    <form method="post" action="" id="profile_form" enctype="multipart/form-data">
        <div id="profile_pic">
            <label for="file_input">Change Picture</label>
            <input type="file" id="file_input" name="profile_image" accept="image/*" onchange="previewImage(this)">
        </div>
        <label>Name:</label>
        <input type="text" name="first_name" required value="<?php echo $edit_fname; ?>" pattern="^[A-Za-zĀ-ž\s]+$" title="Name must only contain letters">
        <label>Last Name:</label>
        <input type="text" name="last_name" required value="<?php echo $edit_lname; ?>" pattern="^[A-Za-zĀ-ž\s]+$" title="Last name must  only contain letters">
        <label>E-mail:</label>
        <input type="email" name="email" required value="<?php echo $edit_email; ?>">
        <label>Phone:</label>
        <input type="text" name="phone" required value="<?php echo $edit_phone; ?>" pattern="[0-9+]+" title="Only numbers or +">
        <div id="button_field">
            <input type="submit" value="Update" role="button" name="submit" class="form_button">
            <input type="reset" value="Reset" role="button" name="reset" class="form_button">
        </div>
    </form>
    <script>
        //Function to preview new uploaded image before form is submitted
  // Function called when image is uploaded
  function previewImage(input) {
    var preview = document.getElementById('prof_pic_edit');
    var file = input.files[0];
    var reader = new FileReader();
    reader.onloadend = function () {
      preview.src = reader.result;
      preview.style.display = 'block';
    }
    if (file) {
      reader.readAsDataURL(file);
    } else {
      preview.src = '#';
      preview.style.display = 'none';
    }
  }
</script>
</div>
