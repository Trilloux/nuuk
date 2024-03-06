<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include '../database.php';

// Definē funkciju ārpus galvenā koda
function showTable($table_name, $con){
    $shwoTab_query = "SELECT * FROM $table_name ORDER BY created DESC";
    $shwoTab_result = mysqli_query($con, $shwoTab_query);
    while ($row = mysqli_fetch_array($shwoTab_result)) {
        $priorityClass = '';
        switch ($row['priority']) {
            case 'high':
                $priorityClass = 'high-priority';
                break;
            case 'medium':
                $priorityClass = 'medium-priority';
                break;
            case 'low':
                $priorityClass = 'low-priority';
                break;
            default:
                $priorityClass = '';
        }

        if ($row['status'] == 'completed') {
            $priorityClass = 'completed';
        }
        ?>
        <tr class="<?php echo $priorityClass; ?>">
            <td colspan="5" id="tb_title"><?php echo $row['title'] ?></td>
        </tr>
        <tr class="<?php echo $priorityClass; ?>">
            <td colspan="5"><?php echo preg_replace('/\v+|\\\r\\\n/Ui','<br/>',$row['description']);?></td>
        </tr>
        <tr class="<?php echo $priorityClass; ?>">
            <td><?php echo $row['created_by'] ?></td>
            <td><?php echo $row['priority'] ?></td>
            <td><?php echo $row['status'] ?></td>
            <td><?php echo $row['created'] ?></td>
            <td>&#x26A0; <?php echo $row['alert'] !== null ? $row['alert'] : '---- -- -- --:--:--'; ?></td>
        </tr>
        <tr id="spacer-row">
            <td colspan="6"></td>
        </tr>
    <?php }
} ?>
<div id="existing_tasks">
    <h2>Existing tasks</h2>
</div>

<div id="task_display">
    <div>
        <?php
        $show_query = 'SELECT * FROM users';
        $show_result = mysqli_query($con, $show_query);
        while ($row = mysqli_fetch_array($show_result)) {
            ?>
            <div class="user_field">
                <span class="users_name"><?php echo $row['firstName'] . ' ' . $row['lastName'] . '<br>'; ?></span>
                <?php
                $user_id = $row['id'];
                $table_name = 'user_' . $user_id . '_tasks';
                // Izmanto funkciju, lai parādītu tabulu
                echo '<p><table id="tasks">';
                showTable($table_name, $con);
                echo '</table></p>';
                ?>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    setTimeout(function(){
        location.reload();
    }, 60000);
    </script>


