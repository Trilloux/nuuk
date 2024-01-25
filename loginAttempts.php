<?php 
session_start();

function shouldBlockSubmitButton() {
    return isLoginBlocked();
}

function invalid_logins(){
    if(!isset($_SESSION['login_attempts'])){
        $_SESSION['login_attempts']=1;
    } else {
        $_SESSION['login_attempts']++;
    }

    if($_SESSION['login_attempts']>=5){
        $_SESSION['login_blocked_until'] = time() + 30;
    }
}

function reset_logins(){
    unset ($_SESSION['login_attempts']);
    unset ($_SESSION['login_blocked_until']);
}

function isLoginBlocked(){
    return isset($_SESSION['login_blocked_until']) && $_SESSION['login_blocked_until'] > time();
}

function displayTooManyAttemptsMessage() {
    if (isLoginBlocked()) {
       

        $blockedUntil = $_SESSION['login_blocked_until'];
        $currentTime = time();
        $timeLeft = max(0, $blockedUntil - $currentTime);

        //Display remaining time
        echo 'Too many attempts - Page will reload in '.$timeLeft.' seconds!';

        // Reload page in required time
        echo "<script>
                setTimeout(function () {
                    location.reload();
                }, $timeLeft * 1000); // Pārveido sekundes par milisekundēm
              </script>";

    }
}
?>

