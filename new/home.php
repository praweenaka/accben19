<?php
include "header.php";
include "connectioni.php";

?>



<?php

if (isset($_GET['url'])) {
    if ($_GET['url'] == "inv_ent") {
        include_once './inv_ent.php';
    }
    if ($_GET['url'] == "pay_dbt") {
        include_once './invoice.php';
    }
    if ($_GET['url'] == "lock_release_chq") {
        include_once './lock_release_chq.php';
    }
}

 

?>
 
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
include_once './footer.php';

?>

</body>
</html>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
 <!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(function() {
    $('.dt').datepicker({
    format: 'yyyy-mm-dd'
});

    
});
</script>
 

<script src="js/comman.js"></script>

<script>    
   $("body").addClass("sidebar-collapse");   
</script>    


    <?php
include 'login.php';
?>
