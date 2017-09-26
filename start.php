<?php
require_once(dirname(__FILE__) . "/../../vendor/autoload.php");
spl_autoload_register("graphql_autoloader");
function graphql_autoloader($class) {
    $filename = "classes/" . str_replace("\\", "/", $class) . ".php";
    if (file_exists(dirname(__FILE__) . "/" . $filename)) {
        include($filename);
    }
}

function graphql_init() {
    set_csrf_token();
    elgg_register_page_handler("graphql", "graphql_page_handler");
}

function set_csrf_token() {
    if (isset($_COOKIE["CSRF_TOKEN"])) {
    	return;
    }
 
    $token = md5(openssl_random_pseudo_bytes(32));
    $domain = ini_get("session.cookie_domain");

    setcookie("CSRF_TOKEN", $token, 0, "/", $domain);
}

function graphql_page_handler($page) {
    include("pages/graphql.php");
    return true;
}

elgg_register_event_handler("init", "system", "graphql_init");
