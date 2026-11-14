<?php
// header("Access-Control-Allow-Origin: *");

session_start();
// print_r($_SESSION);
?>

<script type="text/javascript">
    var exp = 0;
    var urlx = '';
    <?php
    if( !isset($_SESSION['username']) ){
        echo "exp=1;";
    }

    ?>

    
    console.log(exp);
    if(exp==1){
        window.open('http://rapidx/pats_ts/', '_blank');
    }
    else{
        // get the current url based on the pass href "http://rapid/NAAYES/api/session_check.php?urlx=http://rapid/dlabel_cn_v2?packingandshipping=1";
        var url      = 'http://rapidx/pats_ts_ppts/dashboard'; 
        
        window.location.href = (url); 
    }
</script>