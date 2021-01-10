<?php
function adminer_object() {
    // required to run any plugin
	include_once "./plugins/dump-alter.php";
	include_once "./plugins/dump-bz2.php";
	include_once "./plugins/dump-json.php";
	include_once "./plugins/dump-xml.php";
	include_once "./plugins/dump-zip.php";
	include_once "./plugins/login-password-less.php";
	include_once "./plugins/plugin.php";
	include_once "./plugins/tables-filter.php";
    
    // autoloader
    foreach (glob("plugins/*.php") as $filename) {
        include_once "./$filename";
    }    
    $plugins = array(
        // specify enabled plugins here       
		new AdminerDumpAlter, //экспорт БД для ее синхронизацци с другой БД
		new AdminerDumpBz2, //дамп в формат Bzip2
		new AdminerDumpJson, //дамп в формат JSON
		new AdminerDumpXml, //дамп в формат XML
		new AdminerDumpZip, //дамп в формат ZIP
		new AdminerLoginPasswordLess(password_hash("mypswd", PASSWORD_DEFAULT)),
		new AdminerTablesFilter, //
    );
    
    /* It is possible to combine customization and plugins:
    class AdminerCustomization extends AdminerPlugin {
    }
    return new AdminerCustomization($plugins);
    */
    
    return new AdminerPlugin($plugins);
}

// include original Adminer or Adminer Editor
include "./adminer.php";
?>