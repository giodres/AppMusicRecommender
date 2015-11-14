<?

session_start();
require_once("rdio.php");
// basic API set up
define('CONSUMER_KEY', 'KEY');
define('CONSUMER_SECRET', 'SECRET');
$rdio = new Rdio(CONSUMER_KEY, CONSUMER_SECRET);
// work out our current URL.
$protocol = 'http';
if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) {
    $protocol .= 's';
    $protocol_port = $_SERVER['SERVER_PORT'];
} else {
    $protocol_port = 80;
}
$host = $_SERVER['HTTP_HOST'];
$port = $_SERVER['SERVER_PORT'];
$request = $_SERVER['PHP_SELF'];
$query = substr($_SERVER['argv'][0], strpos($_SERVER['argv'][0], ';') + 1);
$BASEURL = $protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request;
$op = $_GET["op"];
if($op == "login") {
    $callback_url = $BASEURL . '?op=login-callback';
    $auth_url = $rdio->begin_authentication($callback_url);
    header("Location: ".$auth_url);
} else if($op == "login-callback") {
    $rdio->complete_authentication($_GET["oauth_verifier"]);
    header("Location: ".$BASEURL);
} else if($op == "logout") {
    $rdio->logOut();
    header("Location: ".$BASEURL);
} else {
    if ($rdio->loggedIn()) {
        $person = $rdio->currentUser()->result;

        // make the API call
        $results = $rdio->search(
            array(
                "query" => $person->firstName,
                "types" => "Track",
                "never_or" => "true"))->result->results;
        ?><p>
        hi there, <?=$person->firstName?>, here are some songs for you:<br>
        <? for($i=0; $i<count($results); $i++) {?>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                    codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
                    width="500" height="25">
                <param name="movie" value="<?=$results[$i]->embedUrl?>">
                <param name="quality" value="high">
                <embed src="<?=$results[$i]->embedUrl?>"
                       quality="high" width="500" height="25" type="application/x-shockwave-flash">
                </embed>
            </object>
            <br>
            <?
        }
        ?><p><a href="<?= $BASEURL . "?op=logout" ?>">Log out</a>?</p><?
    } else {
        ?>
        <p>Hi, would you like to <a href="<?= $BASEURL . "?op=login" ?>">log in</a> to Rdio?
        </p><?
    }
}