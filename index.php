<?php
session_start();
require_once dirname(__FILE__) . '/lib/googleclientapi/src/Google_Client.php';
require_once dirname(__FILE__) . '/lib/googleclientapi/src/contrib/Google_Oauth2Service.php';

$scriptUri = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER['PHP_SELF'];

$client = new Google_Client();
$client->setAccessType('online'); // default: offline
$client->setApplicationName('PideloConMaps');
$client->setClientId('386356220154-3n2cjof6o6hor9luh95c6382cda13fha.apps.googleusercontent.com');
$client->setClientSecret('sAuuiHDO4igWaAdQ-hC0Jp1H');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyCj-Junex5KZ2T2zzea9Mmz5rN10iSH8sg'); // API key
// $service implements the client interface, has to be set before auth call
$oauth2 = new Google_Oauth2Service($client);

if (isset($_REQUEST['logout'])) {
    unset($_SESSION['token']);
    unset($_SESSION['autenticado']);
    unset($_SESSION['nombre']);
    unset($_SESSION['imagen']);
    unset($_SESSION['email']);
    session_destroy();
    $client->revokeToken();
}

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    return;
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
    $user = $oauth2->userinfo->get();
    $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
    $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
    $name = $user['name'];

    $_SESSION['autenticado'] = true;
    $_SESSION['nombre'] = $name;
    $_SESSION['imagen'] = $img;
    $_SESSION['email'] = $email;

    $personMarkup = "<div><img class='img-circle' src='$img?sz=200'></div><h4>" . $name . "<h4>";

    // The access token may have been updated lazily.
    $_SESSION['token'] = $client->getAccessToken();
} else {
    $authUrl = $client->createAuthUrl();
}

require_once(dirname(__FILE__) . '/lib/face-sdk/facebook.php');
require_once (dirname(__FILE__) . '/lib/face-sdk/config.php');
$config = array(
    'appId' => APP_ID,
    'secret' => APP_SECRET,
    'cookie' => true
);

$facebook = new Facebook($config);
$user_id = $facebook->getUser();
?>
<!doctype html>
<html>
    <head><meta charset="utf-8">
        <title>Pidelo con Maps</title>
        <link rel="stylesheet" href="lib/css/bootstrap.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="lib/css/principal.css" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Sniglet' rel='stylesheet' type='text/css'>
        <style>
            body {
                font-family: 'Sniglet',serif;
            }
        </style>
    </head>
    <body>
        <?php
            if ($_SESSION['autenticado']) {
                print "<a class='logout pull-right' href='?logout'>Logout</a>";
            }
        ?>
        <div class="container">
            <div class="row text-center">
        <header><h1>Pedidos Maps</h1></header>
        <?php if (isset($personMarkup)): ?>
            <?php print $personMarkup ?>
        <?php endif ?>
        <?php
        if (isset($authUrl) || !isset($user_id)) {
            echo "<img src='lib/img/pollomarca.png' alt='' class='logo' />";
            echo "<h4>Inicio Sesión con:</h4>";
            echo "<a class='login btn btn-default' href='$authUrl'><img src='lib/img/google.svg' /> Google</a>";
            $login_url = $facebook->getLoginUrl();
            echo '<a class="btn btn-default" href="' . $login_url . '"><img src="lib/img/facebook.svg" /> Facebook</a>';
        } else {
            if ($user) {
                try {
                    //472148372819412 = la jungla
                    $user_profile = $facebook->api('/me', 'GET');
                    $fotoPerfil = "<img src='http://graph.facebook.com/" . $user_profile['id'] . "/picture?type=small'/>";
                    echo $fotoPerfil . "My Name: " . $user_profile['name'];

                    $token = $facebook->getAccessToken();
                } catch (FacebookApiException $e) {
                    $login_url = $facebook->getLoginUrl(array(
                        'scope' => 'user_status,publish_stream,user_photos,user_photo_video_tags'
                    ));
                    
                    error_log($e->getType());
                    error_log($e->getMessage());
                }
            }
            print "<br/><a class='login btn btn-success' href='principal.php'>Ir a Mapa</a></br>";

            //ingresa el usuario a la base de datos
            $link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
            mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');
            $nuevo_email = mysql_query("select email from usuarios where correo='$email'");
            if (mysql_num_rows($nuevo_email) == 0) {
                $query = 'INSERT INTO usuarios(nombres,email,imagen) '
                        . 'VALUES ("' . $name . '","' . $email . '","' . $img . '")';
                $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
            }
            mysql_close($link);
        }
        ?>
            </div>
            </div>  
    </body></html>