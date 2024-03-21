<?php
// Iekļaujam datubāzes pieslēgšanās informāciju
include 'database.php';

// Pārbaudam, vai GET pieprasījumā ir nodots lietotāja ID
if(isset($_GET['show_info'])) {
    // Saņemam lietotāja ID no GET pieprasījuma
    $user_id = $_GET['show_info'];
    $photoDir="uploads/user_$user_id/";

    // Izveidojam vaicājumu, lai iegūtu lietotāja informāciju no datubāzes
    $user_query = "SELECT * FROM users WHERE id = $user_id";
    $user_result = mysqli_query($con, $user_query);

    // Pārbaudam, vai ir rezultāti
    if(mysqli_num_rows($user_result) > 0) {
        // Iegūstam lietotāja informāciju
        $user_info = mysqli_fetch_assoc($user_result);

        // Attēlojam lietotāja informāciju
?>
    <div id="other_user_wrapper">
        <h2>Information about user</h2>
        <div class="other_user_info">
            <div class="profile_image_container">
        <?php 
        // Pārbaudam, vai direktorija eksistē
        if (file_exists($photoDir)) {
        ?>
            <a href="<?= $photoDir . $user_info['profile_image']; ?>"><img src="<?php echo $photoDir . $user_info['profile_image']; ?>" alt="Profile Picture" class="profile_image"></a>
        <?php 
        } else {
        ?>
            <a href="uploads/default.png"><img src="uploads/default.png" alt="Profile Picture" class="profile_image"></a>
        <?php
        }
        ?>
            </div>
            <div class="user_text_info">
                <p>First Name: <?php echo $user_info['firstName']; ?></p>
                <p>Last Name: <?php echo $user_info['lastName']; ?></p>
                <p>E-mail: <a class="other_user_email" href="mailto:<?php echo $user_info['email']; ?>"> <?php echo $user_info['email']; ?></a></p>
                <p>Phone: <?php echo $user_info['phone']; ?></p>
            </div>
        </div>
    </div>
<?php
    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}
?>
