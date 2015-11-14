<?php

namespace Library;

define('RDIO_API_ENDPOINT', 'http://api.rdio.com/1/');
define('RDIO_REQUEST_TOKEN', 'http://api.rdio.com/oauth/request_token');
define('RDIO_ACCESS_TOKEN', 'http://api.rdio.com/oauth/access_token');
class ApiRdio {
    private $key;
    private $secret;
    function __construct($key, $secret) {
        $this->key = $key;
        $this->secret = $secret;
    }

    private function _getOAuth() {
        $oauth = new OAuth($this->key, $this->secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_FORM);
        if (isset($_SESSION['access_key']) && isset($_SESSION['access_secret'])) {
            $oauth->setToken($_SESSION['access_key'], $_SESSION['access_secret']);
        } else if (isset($_SESSION['request_key']) && isset($_SESSION['request_secret'])) {
            $oauth->setToken($_SESSION['request_key'], $_SESSION['request_secret']);
        }
        return $oauth;
    }

    public function logOut() {
        unset($_SESSION['request_key']);
        unset($_SESSION['request_secret']);
        unset($_SESSION['access_key']);
        unset($_SESSION['access_secret']);
    }

    public function loggedIn() {
        return (isset($_SESSION['access_key']) && isset($_SESSION['access_secret']));
    }
    public function __call($method, $arguments) {
        // build the request
        if (count($arguments) > 0) {
            $params = $arguments[0];
        } else {
            $params = array();
        }
        $params['method'] = $method;
        // make the request
        $oauth = $this->_getOAuth();
        $oauth->fetch(RDIO_API_ENDPOINT, $params, OAUTH_HTTP_METHOD_POST);
        // parse the result
        return json_decode($oauth->getLastResponse(), FALSE);
    }
    public function begin_authentication($callback) {
        // reset previous auth state
        $this->logOut();

        $oauth = $this->_getOAuth();
        $pieces = $oauth->getRequestToken(RDIO_REQUEST_TOKEN, $callback);

        // save the request token
        $_SESSION['request_key'] = $pieces['oauth_token'];
        $_SESSION['request_secret'] = $pieces['oauth_token_secret'];
        // build the authentication URL
        return $pieces['login_url'] . '?oauth_token=' . $pieces['oauth_token'];
    }
    public function complete_authentication($verifier) {
        $oauth = $this->_getOAuth();
        $pieces = $oauth->getAccessToken(RDIO_ACCESS_TOKEN, '', $verifier);

        // save the access token
        $_SESSION['access_key'] = $pieces['oauth_token'];
        $_SESSION['access_secret'] = $pieces['oauth_token_secret'];

        // clear the request token
        unset($_SESSION['request_key']);
        unset($_SESSION['request_secret']);
    }
}
