<?php
require_once PROJECT_ROOT_PATH . "common\IBaseMethods.php";
require_once PROJECT_ROOT_PATH . "helper\RouteHelper.php";
require_once PROJECT_ROOT_PATH . "models\Product.php";
class ProductController extends BaseController implements IBaseMethods
{

    private $productModel;
    private $tableFields; 
    public function __construct()
    {
        $this->productModel = new ProductModel();
         $this->tableFields = 'id, name, category'; 
    }
    public function All()
    {
        $strErrorDesc = '';
        $responseData = array();
        try {
            //TODO:reemplazar por builder
            $data = "";
            $page = 1;
            $perPage = 10;
            parse_str($_SERVER['QUERY_STRING'], $params);
            if (isset($params['page']) && $params['page'] != "")
            $page = $params['page'] <= 0 ? 1 : $params['page'];
            if (isset($params['perPage']) && $params['perPage'] == "")
            $perPage = $params['perPage'] <= 0 ? 10 : $params['perPage'];
            if (isset($params['category']) && $params['category'] != "")
            $data = $data.($params['category'] ? " and category = '" . $params['category'] . "'" : " ");
            if (isset($params['name']) && $params['name'] != "")
            $data = $data.($params['name'] ? " and name = '" . $params['name'] . "'" : " ");

            $responseData = $this->productModel->all($page, $perPage, $data, $this->tableFields);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . ' Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Completed', 'status' => 'Success!', 'data' => $responseData, 'statusCode' => 200);
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $response = array('message' => $strErrorDesc, 'status' => 'error', 'data' => $responseData, 'statusCode' => 500);
            $this->sendOutput($response,
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function getById()
    {
        $strErrorDesc = '';
        $responseData = array();
        $statusCode = 0;
        try {
            $id = $this->getUriSegments();
            if (isset($id[3]) && $id[3] != "") {
                $id = $id[3];
                $responseData = $this->productModel->findById($id, $this->tableFields);
            } else {
                $strErrorDesc = 'Invalid Id';
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
                $statusCode = 400;
            }
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $statusCode = 500;
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Completed', 'status' => 'Success!', 'data' => $responseData ? $responseData : "", 'statusCode' => 200);
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $response = array('message' => $strErrorDesc, 'status' => 'error', 'data' => $responseData, 'statusCode' => $statusCode);
            $this->sendOutput($response,
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function create()
    {
        $strErrorDesc = '';
        $responseData = array();
        try {
            $data = RouteHelper::getBody();
            $responseData = $this->productModel->create($data);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Product created Successfully', 'status' => 'Success!', 'data' => $responseData, 'statusCode' => 200);
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $response = array('message' => 'Something went wrong!', 'status' => 'error', 'data' => $responseData, 'statusCode' => 500);
            $this->sendOutput($response,
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function update()
    {
        $strErrorDesc = '';
        $responseData = array();
        try {
            $id = $this->getUriSegments();
            $id = $id[3];
            $data = RouteHelper::getBody();
            $responseData = $this->productModel->update($id, $data);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Product updated Successfully', 'status' => 'Success!', 'data' => $responseData, 'statusCode' => 200);
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $response = array('message' => 'Something went wrong!', 'status' => 'error', 'data' => $responseData, 'statusCode' => 500);
            $this->sendOutput($response,
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function remove()
    {
        $strErrorDesc = '';
        $responseData = array();
        try {
            $id = $this->getUriSegments();
            $id = $id[3];
            $data = array('isActive' => 0);
            $responseData = $this->productModel->update($id, $data);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Product deleted Success!fully', 'status' => 'Success!', 'data' => $responseData, 'statusCode' => 200);
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $response = array('message' => 'Something went wrong!', 'status' => 'error', 'data' => $responseData, 'statusCode' => 500);
            $this->sendOutput($response,
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    public function category() {
     
        $strErrorDesc = '';
        $responseData = array();
        try {
      
            $query = "SELECT DISTINCT category FROM products WHERE isActive = 1";
            $responseData = $this->productModel->queryExecutor($query);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Completed', 'status' => 'Success!', 'data' => $responseData, 'statusCode' => 200);
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $response = array('message' => 'Something went wrong!', 'status' => 'error', 'data' => $responseData, 'statusCode' => 500);
            $this->sendOutput($response,
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
            
    }
}
