<?php

define("PROJECT_ROOT_PATH", __DIR__."\\");

/**
 *         Misc
 */

// include main configuration file 
require_once PROJECT_ROOT_PATH . "inc\config.php";
// include route helper
require_once PROJECT_ROOT_PATH . "helper\RouteHelper.php";

/**
 *         Controllers
 */

// include the base controller file 
require_once PROJECT_ROOT_PATH . "common\BaseController.php";
//include Product Controller
require_once PROJECT_ROOT_PATH . "controller\ProductController.php";
//include Feature Controller
require_once PROJECT_ROOT_PATH . "controller\FeatureController.php";

/**
 *          Models
 */
// include the base model file
require_once PROJECT_ROOT_PATH . "common\\BaseModel.php";
// include product model
require_once PROJECT_ROOT_PATH . "models\Product.php";
// include fearture model
require_once PROJECT_ROOT_PATH . "models\Feature.php";

/**
 *           Routes
 */

// include router
require_once PROJECT_ROOT_PATH . "helper\\router\Router.php";
//include Product Routes
require_once PROJECT_ROOT_PATH . "routes\ProductRoutes.php";
//include Feature Routes
require_once PROJECT_ROOT_PATH . "routes\FeatureRoutes.php";

/**
 *           Interfaces
 */
 require_once PROJECT_ROOT_PATH . "common\IBaseMethods.php"; 

?>