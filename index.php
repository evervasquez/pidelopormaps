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

    $personMarkup = "$email<div><img src='$img?sz=200'></div>" . $name;

    // The access token may have been updated lazily.
    $_SESSION['token'] = $client->getAccessToken();
} else {
    $authUrl = $client->createAuthUrl();
}
?>
<!doctype html>
<html>
    <head><meta charset="utf-8"></head>
    <body>
        <header><h1>Pidelo Con Maps</h1></header>
        <?php if (isset($personMarkup)): ?>
            <?php print $personMarkup ?>
        <?php endif ?>
        <?php
        if (isset($authUrl)) {
            print "<a class='login' href='$authUrl'>Iniciar Sesión</a>";
        } else {
            print "<a class='login' href='principal.php'>Ir a Mapa</a></br>";
            if ($_SESSION['autenticado']) {
                print "<a class='logout' href='?logout'>Logout</a></br>";
            }

            $link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
            mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');

            $nuevo_email = mysql_query("select correo from usuarios where correo='$email'");
            
            if (mysql_num_rows($nuevo_email) == 0) {
                $query = 'INSERT INTO usuarios(nombres,correo,imagen) '
                        . 'VALUES ("' . $name . '","' . $email . '","' . $img . '")';
                $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
            }

            

            mysql_close($link);
        }
        ?>
    </body></html>