<?php
/* 
https://qiita.com/sofpyon/items/982fe3a9ccebd8702867
ログイン部分はsofpyonさんのコードを使わせていただいています
*/
session_start();
//ここは情報を入力してください
define( 'CONSUMER_KEY', '' );
define( 'CONSUMER_SECRET', '' );
define( 'OAUTH_CALLBACK', '' );

require_once 'twitteroauth/autoload.php';
//twitteroauthを使用しています
use Abraham\TwitterOAuth\TwitterOAuth;


$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$user = $connection->get("account/verify_credentials");



$user = json_decode(json_encode($user), true);

 $stop="ツイートするアカウント:<br>".$user['name']."(".$user['screen_name'].")";
if(empty($_POST['note'])){

}else{
    $result = $connection->post(
        "statuses/update",
        array("status" => $_POST['note'])
);

if($connection->getLastHttpCode() == 200) {
    // ツイート成功
    $message="送信完了";
} else {
    // ツイート失敗
    $message="mmm...なにかエラーがおきているようです";
}
};
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="https://moonsnetwork.sakuraweb.com/history-note/css/uikit.min.css" />
<script src="https://moonsnetwork.sakuraweb.com/history-note/js/uikit.min.js"></script>
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<title>twitter送信</title>
<style>
</style>
  </head>
  <body>
  <h1 class='uk-text-center'>twitter送信</h1>
  <br><form name="Form" action="mypage.php" method="POST">
  <p style="text-align: center;"><?php echo$stop?></p>
<div style="margin: 0 auto;width:400px;"><textarea value="" type="url" name="note" style="width:400px;height:80px;margin: 0 auto;"></textarea></div>
  <br><div style="margin: 0 auto;width:400px;"><span><?php echo $message ?></span></div>
  <div style="margin: 0 auto;width:5%;"><input class='uk-button uk-button-primary' type="submit" value="登録" ></input></div>
  </form>
  </body>
</html>