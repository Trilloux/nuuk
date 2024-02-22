<?php 
include '../database.php';
?>
<div id="admin_container">
    <div>
        <h1>Workspace Admin section</h1>
    </div>
    <div id="user_actions">
        <h2>User actions</h2>
        <p>All information regarding workspace users. Create new users, edit/delete existing users.</p>
        <button class="admin_buttons"><a href="?id=admin_1">Create User</a></button>
        <button class="admin_buttons"><a href="?id=admin_2">Edit/Delete Users</a></button>
    </div>
    <div id="news_actions">
        <h2>News feed actions</h2>
        <p>All information regarding workspace newsfeed section. Create new posts, edit/delete existing posts.</p>
        <button class="admin_buttons"><a href="?id=admin_3">Create New Post</a></button>
        <button class="admin_buttons"><a href="?id=admin_4">Edit/Delete Posts</a></button>
    </div>
    <div id="task_actions">
        <h2>Task actions</h2>
        <p>All information regarding workspace task section. Create new tasks, fallow current task progress.</p>
        <button class="admin_buttons"><a href="?id=admin_5">Create New Task</a></button>
        <button class="admin_buttons"><a href="?id=admin_6">Show current tasks</a></button>
    </div>
    <div id="calendar_actions">
        <h2>Calendar actions</h2>
        <p>All information regarding workspace calendar section. Create new calendar events or view existing events.</p>
        <button class="admin_buttons"><a href="?id=admin_7">Create Event</a></button>
    </div>
    
</div>
