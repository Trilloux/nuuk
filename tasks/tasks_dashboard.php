<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'tasks_methods.php';
?>

<div id="tasks_wrapper">
    <div id="tasks_cpanel">
        <button class="task_buttons"><a href="?id=21">&#x2295; New</a></button>
        <button class="task_buttons" onclick="editTask()">&#x2190; Edit</button>
        <button class="task_buttons" onclick="deleteTasks()">&#x2716; Delete</button>
        <button class="task_buttons"onclick="activeTasks()">&#x2605; Active</button>
        <button class="task_buttons" onclick="compTasks()" >&#x2713; Completed</button>
    </div>
    <div id="tasks_list">
        <div id="task_block">
            <table id="tasks">
                <?php
                $shwTab_query="SELECT * FROM $table_name ORDER BY created DESC ";
                $shwTab_result=mysqli_query($con, $shwTab_query);
                if(mysqli_num_rows($shwTab_result)==0){
                    echo '<p class="noMessages">You currently have no tasks!</p>';
                }else{
                while($row=mysqli_fetch_array($shwTab_result)){
                    $priorityClass = '';
                //                               --- Switch to get priority class for CSS  ----
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
                if($row['status']=='completed'){
                    $priorityClass = 'completed';
                }
            
                
                ?>
               <tr class="<?php echo $priorityClass; ?>">
                    <td rowspan="3" id="tb_checkbox"><?php  echo '<input type="checkbox" name="selectedItems[]" value="'. $row['id'] .'">'; ?></td>
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
            }?>
            </table>
        </div>
    </div>
</div>

<script>
//                                ----Javascript functions to get checkboxes ids----

//                                  ---EDIT FUNCTIONS---
function editTask() {
    var checkedTaskId = getCheckedTaskId();
    if (checkedTaskId !== null) {
        var existingUrl = 'home.php?id=21'; // Your existing URL with the ID parameter
        var editUrl = existingUrl + '&task_id=' + checkedTaskId; // Append the checked task ID as another parameter
        window.location.href = editUrl;
    } else {
        alert('Please select a task to edit.');
    }
}
function getCheckedTaskId() {
        var checkboxes = document.getElementsByName('selectedItems[]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                return checkboxes[i].value;
            }
        }
        return null; // Return null if no checkbox is checked
    }

//                                  ---DELETE/EDIT STATUS FUNCTIONS---
function deleteTasks() {
    var checkedTaskIds = getCheckedTaskIds();
    if (checkedTaskIds.length > 0) {
        var existingUrl = 'home.php?id=2'; // Your existing URL with the ID parameter
        var delUrl = existingUrl + '&delete_ids=' + checkedTaskIds.join(','); // Join the array of IDs into a comma-separated string
        window.location.href = delUrl;
    } else {
        alert('Please select tasks to delete.');
    }
}

function compTasks() {
    var checkedTaskIds = getCheckedTaskIds();
    if (checkedTaskIds.length > 0) {
        var existingUrl = 'home.php?id=2'; // Your existing URL with the ID parameter
        var delUrl = existingUrl + '&comp_ids=' + checkedTaskIds.join(','); // Join the array of IDs into a comma-separated string
        window.location.href = delUrl;
    } else {
        alert('Please select tasks to mark completed.');
    }
}

function activeTasks() {
    var checkedTaskIds = getCheckedTaskIds();
    if (checkedTaskIds.length > 0) {
        var existingUrl = 'home.php?id=2'; // Your existing URL with the ID parameter
        var delUrl = existingUrl + '&active_ids=' + checkedTaskIds.join(','); // Join the array of IDs into a comma-separated string
        window.location.href = delUrl;
    } else {
        alert('Please select tasks to mark active.');
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