<?php
ini_set('allow_url_include', 'On');
ini_set('display_errors', 'On'); 
session_start();
require_once('lib/face-sdk/facebook.php');

if (isset($_REQUEST['error_reason'])) {
    echo("<script>self.close();</script>");
    exit;
}

$permisos = 'email,publish_actions';
$script_url = 'http://pedidosmaps.esy.es/';
$fb_apikey = '623079911094102';
$fb_secret = '08a99f453f2dc6f5d6d99f8c1b3de748';

$config = array(
    'appId' => $fb_apikey,
    'secret' => $fb_secret
);

$code = $_REQUEST["code"];

$facebook = new Facebook($config);

$urlLogin = $facebook->getLoginUrl(array(
    'scope' => $permisos,
    'redirect_uri' => $script_url
        ));
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
//            if ($_SESSION['autenticado']) {
//                print "<a class='logout pull-right' href='?logout'>Logout</a>";
//            }
        ?>
        <div class="container">
            <div class="row text-center">
                <header><h1>Pedidos Maps</h1></header>
                <?php
                if (empty($code)) {
                    echo "<img src='lib/img/pollomarca.png' alt='' class='logo' />";
                    echo "<h4>Inicio Sesión con:</h4>";
                    echo '<a class="btn btn-default" href="' . $urlLogin . '"><img src="lib/img/facebook.svg" /> Facebook</a>';
                    exit;
                } else {
                    // obtener el token de autenticacion a partir de Facebook Graph  
                    $token_url = "https://graph.facebook.com/oauth/access_token?"
                            . "client_id=" . $fb_apikey . "&redirect_uri=" . urlencode($script_url)
                            . "&client_secret=" . $fb_secret . "&code=" . $code;
                    // obteenemos la respuesta y la interpretamos 
                    //
                    //die($token_url);
                        $response = @file_get_contents($token_url);

//                        $c = curl_init($token_url);
//                        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
//                        curl_setopt($c, CURLOPT_HEADER, false);
//                        $t_output = curl_exec($c);
//
//                        curl_close($c);
//
                        $params = null;

                        parse_str($response, $params);
                        // asignamos al objecto Facebook el token para proceder a realizar  
                        // llamadas al API posteriormente 
//            var_dump($params);
//            exit;
                        $facebook->setAccessToken($params['access_token']);
                        $fbme = $facebook->api('/me', 'GET');
                        var_dump($fbme);
                    
                    if ($fbme) {
                        proceed_login_or_register($fbme);
                    }
                }
//                if ($user <> 0) {
//
//                    // We have a user ID, so probably a logged in user.
//                    // If not, we'll get an exception, which we handle below.
//                    try {
//                        //472148372819412 = la jungla
//                        $user_profile = $facebook->api('/me', 'GET');
//
//                        $fotoPerfil = "<img src='http://graph.facebook.com/" . $user_profile['id'] . "/picture?type=small'/>";
//                        echo $fotoPerfil . "My Name: " . $user_profile['name'];
//
//                        $token = $facebook->getAccessToken();
//                    } catch (FacebookApiException $e) {
//                        $login_url = $facebook->getLoginUrl(array(
//                            'scope' => 'user_status,publish_stream,user_photos,user_photo_video_tags'
//                        ));
//                        error_log($e->getType());
//                        error_log($e->getMessage());
//                    }
//                } else {
//
//                    // No user, print a link for the user to login
//                    //$login_url = $facebook->getLoginUrl();
//                    echo "<img src='lib/img/pollomarca.png' alt='' class='logo' />";
//                    echo "<h4>Inicio Sesión con:</h4>";
//                    echo '<a class="btn btn-default" href="' . $urlLogin . '"><img src="lib/img/facebook.svg" /> Facebook</a>';
//                }
//        if (isset($authUrl) || !isset($user_id)) {
//            echo "<img src='lib/img/pollomarca.png' alt='' class='logo' />";
//            echo "<h4>Inicio Sesión con:</h4>";
//            echo "<a class='login btn btn-default' href='$authUrl'><img src='lib/img/google.svg' /> Google</a>";
//            $login_url = $facebook->getLoginUrl();
//            ///echo '<a class="btn btn-default" href="' . $login_url . '"><img src="lib/img/facebook.svg" /> Facebook</a>';
//        } else {
//            if ($user) {
//                try {
//                    //472148372819412 = la jungla
//                    $user_profile = $facebook->api('/me', 'GET');
//                    $fotoPerfil = "<img src='http://graph.facebook.com/" . $user_profile['id'] . "/picture?type=small'/>";
//                    echo $fotoPerfil . "My Name: " . $user_profile['name'];
//
//                    $token = $facebook->getAccessToken();
//                } catch (FacebookApiException $e) {
//                    $login_url = $facebook->getLoginUrl(array(
//                        'scope' => 'user_status,publish_stream,user_photos,user_photo_video_tags'
//                    ));
//                    
//                    error_log($e->getType());
//                    error_log($e->getMessage());
//                }
//            }
//            //print "<br/><a class='login btn btn-success' href='principal.php'>Ir a Mapa</a></br>";
//
//            //ingresa el usuario a la base de datos
//            $link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
//            mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');
//            $nuevo_email = mysql_query("select idusuario from usuarios where correo='$email'");
//            if (mysql_num_rows($nuevo_email) == 0) {
//                $query = 'INSERT INTO usuarios(nombres,email,imagen) '
//                        . 'VALUES ("' . $name . '","' . $email . '","' . $img . '")';
//                $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
//                
//                
//                mysql_free_result($result);
//            }
//            $query2 = 'SELECT MAX(idusuario) FROM usuarios';
//            $result2 = mysql_query($query2) or die('Consulta fallida: ' . mysql_error());
//            $_SESSION['idusuario'] = $result2;
//            mysql_free_result($result2);
//            mysql_close($link);
//        }
                ?>
            </div>
        </div>  
    </body></html>