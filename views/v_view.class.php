<?php

/**
 * 
 * This is the main view class. Ideally, this should never change or need to be extended.
 * Since pages are loaded dynamically, all pages should be placed in the following directory structure:
 *  
 *    General Content Pages : views/smarty_templates/DOMAIN NAME/pages
 *    Error Pages : views/smarty_templates/DOMAIN NAME/pages/errors
 *    Headers : views/smarty_templates/DOMAIN NAME/header
 *    Footers : views/smarty_templates/DOMAIN NAME/footer
 *    
 *    Unlike directories and extensions, which MUST BE LOWER CASE, I've decided to make templates
 *    resemble their method name. So localhost/?route=create&path=page template would be CreatePage.tpl as its method would be CreatePage
 *    The camel casing is for readability.
 */
class v_view {

    private $smarty;
    private $routeSettings;
    private $siteSettings;

    function __construct($siteSettings) {
        $this->createSmarty();
        $this->siteSettings = $siteSettings;
    }

    /**
     * 
     * @param string $route : route accessed
     * @param string $path : path accessed
     * @param array $result : result array from extended model - contains page data, result status, and more. see extended model.
     */
    function make($route, $path, $result) {
        // if a model call was made assign the result
        if ($result) {
            $this->smarty->assign($result);
        }

        if ($route == APPLICATION_ADMIN_ROUTE) {
            $page = ADMIN_PAGES_PATH;
            $header = ADMIN_HEADER_PATH;
            $footer = ADMIN_FOOTER_PATH;
        } else {
            $page = APPLICATION_RELPAGES_PATH;
            $header = APPLICATION_HEADER;
            $footer = APPLICATION_FOOTER;
        }

        if (!empty($route)) {
            $page.= ucwords($route);
        }

        if (!empty($path)) {
            $page .= ucwords($path);
        }
        $page .= ".tpl";

        // if display header for route is on - show site header
        if ($this->routeSettings ['header']) {
            $this->smarty->assign("header", $header);
        }

        // if display footer for route is on - show site footer
        if ($this->routeSettings ['footer']) {
            $this->smarty->assign("footer", $footer);
        }

        // dynamically generate and assign page template to main.tpl
        $this->smarty->assign("page", $page);
        $this->smarty->display("main.tpl");
    }

    /**
     * 
     * @param string $template - filename of page template to display 
     * TODO handle header and footer
     */
    function display($page, $header=false, $footer=false, $admin=false) {
        
        if($admin){
            $header= APPLICATION_ADMIN_HEADER;
            $footer= APPLICATION_ADMIN_FOOTER;
            $page = ADMIN_PAGES_PATH . $page;
        }else{
            $header = APPLICATION_HEADER;
            $footer = APPLICATION_FOOTER;
            $page = APPLICATION_RELPAGES_PATH . $page;
        }
        
        if ($header) {
            $this->smarty->assign("header", $header);
        }

        // if display footer for route is on - show site footer
        if ($footer) {
            $this->smarty->assign("footer", $footer);
        }

        

        $this->smarty->assign("page", $page);
        $this->smarty->display("main.tpl");
    }

    /**
     * 
     * @param string $template - filename of error page template to display 
     */
    function displayError($template, $header=false, $footer=false) {
        $this->routeSettings ['header'] = $header;
        $this->routeSettings ['footer'] = $footer;
        $this->smarty->display(APPLICATION_ERROR_PAGES . $template);
    }

    /**
     * 
     * @param string $name
     * @param variable $value 
     * Interface for smarty assign method
     */
    function assign($name, $value) {
        $this->smarty->assign($name, $value);
    }

    /**
     * 
     * @param array $routeSettings - row of values from the routes table for request route (id, header, footer, name etc)
     */
    function setRouteSettings($settings) {
        $this->routeSettings = $settings;
    }

    /**
     * instantiate the smarty class
     */
    private function createSmarty() {
        try {
            $smarty = new Smarty ();
            $smarty->setTemplateDir(SMARTY_TEMPLATE_DIR)->setCacheDir(SMARTY_CACHE_DIR)->setCompileDir(SMARTY_COMPILED_DIR)->setConfigDir(SMARTY_CONFIGS_DIR);
            $this->smarty = $smarty;
            $this->smarty->assign("siteTitlePrefix", $this->siteSettings);
            $this->smarty->assign("cssPath", APPLICATION_CSS_PATH);
            $this->smarty->assign("imgPath", APPLICATION_IMG_PATH);
            $this->smarty->assign("jsPath", APPLICATION_JS_PATH);
            return false;
        } catch (SmartyException $e) {
            return $e->getMessage();
        }
    }

}