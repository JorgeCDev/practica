<?php
require_once PROJECT_ROOT_PATH . "common\IBaseMethods.php";
require PROJECT_ROOT_PATH . "models\Feature.php";
class FeatureController extends BaseController implements IBaseMethods
{

    private $featureModel;
    private $tableFields;
    public function __construct()
    {
        $this->featureModel = new FeatureModel();
        $this->tableFields = 'id, feature, value';
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
            $page = ($params['page'] <= 0 ? 1 : $params['page']);

            if (isset($params['perPage']) && $params['perPage'] == "")
            $perPage = ($params['perPage'] <= 0 ? 10 : $params['perPage']);

            if (isset($params['feature']) && $params['feature'] != "")
            $data = $data . ($params['feature'] ? " and feature = '" . $params['feature'] . "'" : " ");

            if (isset($params['value']) && $params['value'] != "")
            $data = $data . ($params['value'] ? " and value = '" . $params['value'] . "'" : " ");

            if (isset($params['pid']) && $params['pid'] != "")
            $data = $data . ($params['pid'] ? " and pid = " . $params['pid'] : " ");

            $responseData = $this->featureModel->all($page, $perPage, $data, $this->tableFields);

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
                $responseData = $this->featureModel->findById($id, $this->tableFields);
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
            $responseData = $this->featureModel->create($data);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Feature created Success!fully', 'status' => 'Success!', 'data' => $responseData, 'statusCode' => 200);
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
            $responseData = $this->featureModel->update($id, $data);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Feature updated Success!fully', 'status' => 'Success!', 'data' => $responseData, 'statusCode' => 200);
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
            $responseData = $this->featureModel->delete($id);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        if (!$strErrorDesc) {
            $response = array('message' => 'Feature deleted Success!fully', 'status' => 'Success!', 'data' => $responseData, 'statusCode' => 200);
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
