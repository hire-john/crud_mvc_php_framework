<?php

/**
 * This is the main application controller. This should NEVER CHANGE. 
 * All site requests are built dynamically based on the routing table.
 * The routing table gives a route validity and prevents internal functions from being called.
 * A route must exist in the table BEFORE it can be accessed.
 * A page must be created for the route as well.
 * A route can be further extended by a path which should be listed within the route's row.
 * 
 * Example: localhost/?route=create&path=page (Capitalization doesn't matter)
 * 
 * 
 *
 */
class c_controller {

    public $view = false; // the view
    private $model = false; // the model & extended model
    private $route; // the REQUESTED ($_REQUEST) route
    private $path; // the REQUESTED ($_REQUEST) path
    private $authentication; // authentication extension

    function __construct() {

        // access control for pages/requests
        $this->authentication = new authentication ();
        $this->route = $this->setArgument('route');
        $this->path = $this->setArgument('path');

        // create model
        $error = $this->createModel();
        if ($error) {
            $this->controllerErrorHandler($error);
        }

        // create view
        $error = $this->createView();
        if ($error) {
            $this->controllerErrorHandler($error);
        }


        // switch for service (example: making ajax calls and getting xml only
        // results) or website (displaying templates)
        if ($this->route == "service") {
            $this->controllerService();
        } else {
            if (method_exists($this, $this->route())) {
                $this->{$this->route()}();
            } else {
                $this->controllerErrorHandler();
            }
        }
    }

    /**
     * main controller for non-service calls
     *
     * This checks the requested route against the route table and if it exists
     * and the user is authorized,
     * calls the camel-cased version of the route name (route + path) in the
     * extended model. For instance,
     * localhost/?route=create&path=page would call CreatePage() in the extended
     * model. The controller then
     * asks the view to display the page CreatePage.tpl.
     */
    function controller() {
        $result = false;
        $routeSettings = $this->model->getRouteFromDB($this->route, $this->path);
        if ($this->authentication->authorized($routeSettings ['scope'], $routeSettings ['id'])) {
            $method = ucwords($this->route);
            if ($this->path) {
                $method .= ucwords($this->path);
            }
            if (method_exists($this->model, $method)) {
                $result = $this->model->{$method}();
            }
            $this->view->setRouteSettings($routeSettings);
            $this->view->make($this->route, $this->path, $result);
        }else{
            $this->view->display('Login.tpl', 1, 1);
        }
    }
    
    /**
     *
     *
     *
     *
     * This method determines which controller method will handle the route -
     * controller() or controllerService(). It can be user defined as well
     * within the route table - method column. However, new methods should be
     * added in the extended controller.
     *
     * @return string
     *
     */
    protected function route() {
        switch ($this->route) {
            case false: {
                    $this->route = APPLICATION_DEF_ROUTE;
                    $this->path = APPLICATION_DEF_PATH;
                }break;
            case APPLICATION_ADMIN_ROUTE: {
                    $this->route = 'admin';
                    $this->path = 'panel';
                }break;
        }
        $route = $this->model->getRouteFromDB($this->route, $this->path);
        if ($route) {
            return $route ['method'];
        } else {
            return 'controllerErrorHandler';
        }
    }

    /**
     * This is the service handler.
     * This will interface the model/extended model for raw data
     * It will then format the data as requested and dump it to the view.
     */
    private function controllerService() {
        $returnType = $this->setArgument('format');
        $service = new service($returnType);
        $this->view->displayServiceResult($service->result);
    }

    // instantiate the view
    private function createView() {
        try {
            $this->view = new v_view($this->model->getSiteSettings(APPLICATION_NAME));
            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // instantiate the model and extended model
    private function createModel() {
        $this->model = new m_extended ();
        if ($this->model->error) {
            return $this->model->error;
        } else {
            return false;
        }
    }

    // handling errors - all errors ARE intended to be routed here
    private function controllerErrorHandler($error = null) {

        // handle default routing value - see router.class.php
        if (empty($error)) {
            $this->view->displayError('404.tpl');
        } else {
            // handle method error exceptions
            if ($this->view) {
                $this->view->assign("error", $error);
            } else {
                // view error - couldn't set smarty for some reason
                echo $error;
                exit();
            }
        }
    }

    // grab variables from request array
    private function setArgument($argument) {
        if (isset($_REQUEST [$argument])) {
            return $_REQUEST [$argument];
        } else {
            return false;
        }
    }

}
