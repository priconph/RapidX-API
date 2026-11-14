You have been redirected to the login page. Click <a href="">Refresh</a> after login.

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
// if( isset($_GET['urlx']) ){
// 	// echo "urlx='".$_GET['urlx']."';";
// }

?>
console.log(exp);
if(exp==1){
	window.open('http://rapid/', '_blank');
}
else{
	// get the current url based on the pass href "http://rapid/NAAYES/api/session_check.php?urlx=http://rapid/dlabel_cn_v2?packingandshipping=1";
	var url      = window.location.href; 
	
	// split the string "urlx=" and turn it to array, after that use the pop() method to remove the last "http://rapid/dlabel_cn_v2?packingandshipping=1" then return it
	var myString = url.split("urlx=").pop(); 
	
	// myString = http://rapid/dlabel_cn_v2?packingandshipping=1
	window.location.href = (myString); 
}
</script>