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

//TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

//コールバックURLをここでセット
$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

//callback.phpで使うのでセッションに入れる
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

//Twitter.com 上の認証画面のURLを取得( この行についてはコメント欄も参照 )
$url = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));

//Twitter.com の認証画面へリダイレクト
header( 'location: '. $url );
?>