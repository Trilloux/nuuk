<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'admin_methods_user.php';
?>

    <div id="existing_users">
        <h2>Existing users</h2>
    </div>
    <div id="user_list">
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>E-mail</th>
                <th>Phome</th>
                <th>Role</th>
                <th colspan="2">Action</th>
            </tr>
        <?php
        //query to Get user data in DB
        $show_query = 'SELECT * FROM users';
        $show_result = mysqli_query($con, $show_query);
        while($row=mysqli_fetch_array($show_result)){
        ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['username'] ?></td>
                <td><?php echo $row['password'] ?></td>
                <td><?php echo $row['firstName'] ?></td>
                <td><?php echo $row['lastName'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['phone'] ?></td>
                <td><?php echo $row['role'] ?></td>
                <td><button><a id="edit_userlist" href="home.php?id=admin_1&edit_id=<?php echo $row['id']; ?>">Edit</a></button></td>
                <td><button onclick="deleteUser(<?php echo $row['id']; ?>)">Delete</button></td>
            </tr>
        <?php } ?>
        </table>
    </div>
<script>
    //useId is pased from <td><button onclick="deleteUser(echo $row['id']...
    function deleteUser(userId) {
    var confirmation = confirm('Delete this user?');
    console.log(userId);
    if (confirmation) {
        console.log("Confirmed");
        //Execute deleteUser function from admin_methods_user.php using Ajax
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'Admin/admin_methods_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                window.location.reload();
            } else {
                console.log('Request failed. Status: ' + xhr.status);
            }
        };
        //Sends data object , which contains delete ID
        var data = 'delete_id=' + userId;
        xhr.send(data);
    } else {
        console.log('Deletion canceled');
    }
}
</script>
