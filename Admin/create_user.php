<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'admin_methods_user.php';
?>
<div id="create_user_form">
    <div id="heading_create_user">
    <p>User information</p>
    </div>
    <div>
        <form method="post" action="" id="user_form" >
            <label>Username:</label>
            <input type="text" name="user_name" maxlength="50" oninput="checkMinLength(this, 6)" required value="<?php echo $edit_username; ?>">
            <label>Password:</label>
            <input type="text" name="user_password" maxlength="50" oninput="checkMinLength(this, 8)" required value="<?php echo $edit_password; ?>">
            <label>Name:</label>
            <input type="text" name="user_fname" maxlength="50" required value="<?php echo $edit_fname; ?>" pattern="^[A-Za-zĀ-ž]+$" title="Name must only contain letters">
            <label>Last Name:</label>
            <input type="text" name="user_lname" maxlength="50" required value="<?php echo $edit_lname; ?>"pattern="^[A-Za-zĀ-ž]+$" title="Last name must  only contain letters">
            <label>E-mail:</label>
            <input type="email" name="user_email" maxlength="50" required value="<?php echo $edit_email; ?>">
            <label>Phone:</label>
            <input type="text" name="user_phone" required value="<?php echo $edit_phone; ?>" maxlength="20" pattern="[0-9+]+" title="Only numbers or +">
            <label>Role:</label>
            <select name="user_role">
            <option value="admin" <?php echo ($edit_role === 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="user" <?php echo ($edit_role === 'user') ? 'selected' : ''; ?>>User</option>
            </select>
            <div id="button_field">
                <?php if (isset($edit_id)) : ?>
        <!-- Ja ir rediģēšanas režīms, pievienot slepto lauku ar edit_id vērtību -->
        <!-- IF chosen edit user , will display Update on button and post will be = $_POST['submit_update'] > updateUser() -->
        <input type="hidden" name="update_id" value="<?php echo $edit_id; ?>">
        <input type="submit" name="submit_update" value="Update" class="form_button">
    <?php else : ?>
        <!-- Ja ir izveidošanas režīms, lietot parastu submit nosaukumu -->
        <!-- IF chosen create user , will display Create on button and post will be = $_POST['submit'] > createUser()-->
        <input type="submit" name="submit" value="Create" class="form_button">
    <?php endif; ?>
    <input type="reset" value="Reset" role="button" name="reset" class="form_button">
            </div>
        </form>
    </div>
</div>

<script>
    //Small form validation function for Username and password fields lenght
    //Called from oninput in form when form submitted, pass input and lenght
    function checkMinLength(input, minLength) {
        if (input.value.length < minLength) {
            input.setCustomValidity('Enter at least ' + minLength + ' characters.');
        } else {
            input.setCustomValidity('');
        }
    }
</script>