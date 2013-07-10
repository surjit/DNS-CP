<?php
session_start();
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

define("IN_PAGE", true);
if(!file_exists("config.php")) {
	die("Missing config file! Please change config.sample.php to your needs and rename it to config.php!");
}

// set config variables
$database               = array();                    // init database array
$conf                   = array();                    // init config array
$conf["version"]        = "0.1.7-dev";                // Version
$conf["build"]          = "2";                        // build number for internal version checking
$conf["typearray"]      = array('A', 'AAAA', 'CNAME', 'MX', 'NS', 'PTR', 'SRV', 'TXT');

// requirements
require_once("config.php");
require_once("lib/database/database.class.php");
require_once("lib/database/".$database["typ"].".database.class.php");
DB::connect($database["host"], $database["user"], $database["pw"], $database["db"]);
require_once("lib/user.class.php");
require_once("lib/server/server.class.php");
require_once("lib/server/".$conf['server'].".server.class.php");
require_once("lib/template.class.php");
require_once("lib/func.class.php");
require_once("lib/dns.class.php");

$page = NULL;
if(isset($_GET["page"]) && !empty($_GET["page"]))
	$page = trim($_GET["page"]);

// set default site
if(empty($page)) {
	$page = "home";
}

// menu array
$menu = array(
	"home"     => "Home",
	"zone"     => "Zones",
	"users"    => "Users",
	"settings" => "Settings",
	"tools"    => "Tools",
	"help"     => "Help"
);

// set title
$title = $conf["name"];
if(!empty($menu[$page])) {
	$title .= " :: ".$menu[$page];
}

if(func::isLoggedIn()){
	$tmenu = "";
	foreach($menu as $mpage => $menu_name) {
		if($page == $mpage) { $class = ' class="active"'; }else{ $class = null; }
		$tmenu .= '<li><a href="?page='.$mpage.'"'.$class.'>'.$menu_name.'</a></li>'."\n";
	}
	if(isset($page)) {
		if(@file_exists("page/".$page.".php")){
			$content = '<?php require_once("page/'.$page.'.php"); ?>';
		} else {
			$content = '<?php require_once("page/404.php"); ?>';
		}
	}
	$login = '<li class="logout"><a href="?page=logout">LOGOUT</a></li>';
} else {
	$tmenu ='<li><a href="?page=login" class="active">Login</a></li>';
	$content = '<?php require_once("page/login.php"); ?>';
	$login = '<li class="logout"><a href="?page=login">LOGIN</a></li>';
}
$data = array(
		"_title" => $title,
		"_name" => $conf["name"],
		"_login" => $login,
		"_menu" => $tmenu,
		"_content" => $content,
		"_build" => $conf["build"],
		"_version" => $conf["version"]
		);

$temp = template::get_template("index");
template::show($temp, $data);
?>