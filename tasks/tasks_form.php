<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'tasks_methods.php';
?>

<div id="task_form_wrapper">
    <div id="task_form_header">
    <span>Task information</span>
    </div>
<form method="POST" action="" id="task_form">
    <label>Title</label>
        <input type="text" name="title" id="task_title" required value="<?php echo $edit_title; ?>">
    <label>Description</label> 
        <textarea id="task_description" name="description" required><?php echo $edit_descr;?></textarea>
    <label>Alert on</label>
    <input type="datetime-local" name="alert" id="task_alert" value="<?php echo isset($edit_alert) ? $edit_alert : ''; ?>">
    <input type="submit" name="submit_alert" value="Remove alert" id="remove_alert">
</script>
    <label>Priority</label>
        <select name="priority" id="task_priority">
            <option value="high" <?php echo ($edit_priority === 'high') ? 'selected' : ''; ?>>High</option>
            <option value="medium" <?php echo ($edit_priority === 'medium') ? 'selected' : ''; ?>>Medium</option>
            <option value="low" <?php echo ($edit_priority === 'low') ? 'selected' : ''; ?>>Low</option>
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
