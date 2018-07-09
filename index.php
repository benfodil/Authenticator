<title>2 Factor Authentication</title>
<?php
session_start();
require_once( 'Authenticator.php' );
$autenticator = new GoogleAuthenticator();
?>
<form action="" method="GET">
	<input type="submit" name="gen" value="Generator">
	<input type="submit" name="val" value="Validation"></br>
</form>

<?php
if($_GET[gen]){
	$secret = $autenticator->createSecret();
	$service = "Google";
	$title = "AdeL";
	$_SESSION["secret"] = $secret;
	$url_qr_code = $autenticator->getQRCodeGoogleUrl( $title, $secret, $service );
	echo "<img src='".$url_qr_code."' /> \n</br>";
	echo "Service : ".$service."</br>Title : ".$title."</br>Secret : ".$secret;	
}elseif($_GET[val]){
?>
<form action="" method="POST">
	<input type="text" name="dig" placeholder="6-Digital" maxlength="6"></br>
	<input type="text" name="key" placeholder="Key!" value="<? echo $_SESSION["secret"];?>" maxlength="16"></br>
	<input type="submit" name="sub" value="Check!"></br>
</form>		
<?php
	if($_POST[sub]){
		$dig = $_POST["dig"];
		$key = $_POST["key"];
		$res = $autenticator->verifyCode( $key, $dig, 0 );
		if($res){
			echo "Ok!";
		}else{
			echo "Error!";
		}
	}
}
?>