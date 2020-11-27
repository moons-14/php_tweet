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

//login.phpでセットしたセッション
$request_token = [];  // [] は array() の短縮記法。詳しくは以下の「追々記」参照
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

//Twitterから返されたOAuthトークンと、あらかじめlogin.phpで入れておいたセッション上のものと一致するかをチェック
if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    die( 'Error!' );
}

//OAuth トークンも用いて TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

//アプリでは、access_token(配列になっています)をうまく使って、Twitter上のアカウントを操作していきます
$_SESSION['access_token'] = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
/*
ちなみに、この変数の中に、OAuthトークンとトークンシークレットが配列となって入っています。
*/

//セッションIDをリジェネレート
session_regenerate_id();

//マイページへリダイレクト
header( 'location: mypage.php' );
?>