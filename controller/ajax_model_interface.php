<?php

namespace Controller;

use PDO;
use Lib\Json;
use Lib\Abstract_model;
use Lib\Router;
use Lib\Controller_base;

class Ajax_model_interface extends Controller_base
{

    public function save($model)
    {
        $model = Abstract_model::get_namespaced_model_path($model);
        $data = Json::decode($_POST['data']);
        $response = $model::save($data);
        $this->send_json($response);
    }

    public function load($model, $id)
    {
        $model = Abstract_model::get_namespaced_model_path($model);
        $response = $model::load($id);
        $this->send_json($response);
    }

    public function delete($model, $id)
    {
        $model = Abstract_model::get_namespaced_model_path($model);
        $model::delete($id);
    }

    public function fetch($model, $sort_field = null, $sort_direction = null)
    {
        $model = Abstract_model::get_namespaced_model_path($model);
        $options = array();
        if ($sort_field != null) {
            $options ['order_by'] = $sort_field . ' ' . $sort_direction;
        }
        $response = $model::fetch_all($options);
        $this->send_json($response);
    }

    public function load_relationship($model, $id)
    {
        $model = Abstract_model::get_namespaced_model_path($model);
        $response = $model::load_relationship($id);
        $this->send_json($response);
    }

    public function jqgrid($model, $filter_model_key = null, $filter_model_value = null)
    {
        $model = Abstract_model::get_namespaced_model_path($model);
        $response = $model::jqgrid($_GET ['page'], $_GET ['rows'], $_GET ['sidx'], $_GET ['sord'], $filter_model_key, $filter_model_value);
        $this->send_json($response);
    }

}

