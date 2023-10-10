<?php
session_start();
session_destroy();
echo '<script>

redirectTime = "1000";
redirectURL = "login.php";
function timedRedirect() {
    setTimeout("location.href = redirectURL;",redirectTime);
}
timedRedirect();
</script>';
?>
