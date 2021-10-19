<?php 
    require("../header.php"); 
    session_start();
    session_unset();
    session_destroy();
?>
    
    <div><p>U have been logged out.</p></div>    

<?php require("../footer.php"); ?>
