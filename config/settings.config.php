<?php
require_once ('autoloader.function.php');

date_default_timezone_set ( 'America/New_York' );

define ( 'APPLICATION_NAME', $_SERVER ['HTTP_HOST'] );

define ( 'APPLICATION_ROOT_PATH', "" );
define ( 'APPLICATION_CSS_PATH', APPLICATION_ROOT_PATH . "/css/" . APPLICATION_NAME . "/" );
define ( 'APPLICATION_IMG_PATH', APPLICATION_ROOT_PATH . "/img/" . APPLICATION_NAME . "/");
define ( 'APPLICATION_JS_PATH', APPLICATION_ROOT_PATH . "/js/" . APPLICATION_NAME . "/");

define ( 'APPLICATION_BASE_PATH', realpath ( '.' ) );
define ( 'APPLICATION_MODEL_PATH', APPLICATION_BASE_PATH . "/model/" );
define ( 'APPLICATION_VIEW_PATH', APPLICATION_BASE_PATH . "/views/" );
define ( 'APPLICATION_CONTROLLER_PATH', APPLICATION_BASE_PATH . "/controller/" );
define ( 'APPLICATION_EXTENSION_PATH', APPLICATION_BASE_PATH . "/extensions/" );
define ( 'APPLICATION_CONFIG_PATH', APPLICATION_BASE_PATH . "/config/" );

define ( 'APPLICATION_DATABASE_HOST', "" );
define ( 'APPLICATION_DATABASE_USERNAME', "" );
define ( 'APPLICATION_DATABASE_PASSWORD', "" );
define ( 'APPLICATION_DATABASE_SCHEMA', "crudmvc" );

define ( 'SMARTY_TEMPLATE_DIR', APPLICATION_VIEW_PATH . "smarty_templates" );
define ( 'SMARTY_CONFIGS_DIR', APPLICATION_CONFIG_PATH . "smarty_configs" );
define ( 'SMARTY_COMPILED_DIR', APPLICATION_VIEW_PATH . "smarty_templates_c" );
define ( 'SMARTY_CACHE_DIR', APPLICATION_VIEW_PATH . "smarty_cache" );
define ( 'SMARTY_SYSPLUGINS_DIR', APPLICATION_EXTENSION_PATH . "smarty/sysplugins/" );
define ( 'SMARTY_PLUGINS_DIR', APPLICATION_EXTENSION_PATH . "smarty/plugins/" );

define ( 'APPLICATION_HEADER', SMARTY_TEMPLATE_DIR . "/" . APPLICATION_NAME . "/header/header.tpl" );
define ( 'APPLICATION_PAGES', SMARTY_TEMPLATE_DIR . "/" . APPLICATION_NAME . "/pages/" );
define ( 'APPLICATION_FOOTER', SMARTY_TEMPLATE_DIR . "/" . APPLICATION_NAME . "/footer/footer.tpl" );
define ( 'APPLICATION_ERROR_PAGES', SMARTY_TEMPLATE_DIR . "/" . APPLICATION_NAME . "/pages/errors/" );
define ( 'APPLICATION_RELPAGES_PATH', APPLICATION_NAME . "/pages/" );
define ( 'APPLICATION_DEF_ROUTE', "site" );
define ( 'APPLICATION_DEF_PATH', "index" );

define ( 'APPLICATION_ADMIN_ROUTE', "" );
