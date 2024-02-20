<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'admin_methods_tasks.php';
?>

<div id="task_form_wrapper">
    <div id="task_form_header">
    <span>Task information</span>
    </div>
<form method="POST" action="" id="task_form">
    <label>Title</label>
        <input type="text" name="title" id="task_title" required value="<?php echo $edit_title; ?>">
    <label>Description</label>
        <textarea id="task_description" name="description" required><?php echo $edit_descr; ?></textarea>
    <label>Priority</label>
        <select name="priority" id="task_priority">
            <option value="high" <?php echo ($edit_priority === 'high') ? 'selected' : ''; ?>>High</option>
            <option value="medium" <?php echo ($edit_priority === 'medium') ? 'selected' : ''; ?>>Medium</option>
            <option value="low" <?php echo ($edit_priority === 'low') ? 'selected' : ''; ?>>Low</option>
        </select>
        <label>User</label>
        <select name="userinfo">
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
    <div id="button_field">
    <?php if (isset($task_id)) : ?>
        <input type="hidden" name="update_id" value="<?php echo $task_id; ?>">
        <input type="submit" name="submit_update" value="Update" class="form_button">
    <?php else : ?>
        <input type="submit" name="submit" value="Create" class="form_button">
    <?php endif; ?>
    <input type="reset" value="Reset" role="button" name="reset" class="form_button">
            </div>
</form>
</div>