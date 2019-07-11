<?php

namespace Lib;

use PDO;
use Lib\Router;

class Abstract_model
{

    const SAVE_TYPE_INSERT = 'insert';
    const SAVE_TYPE_UPDATE = 'update';

    protected static $id_field = 'id';
    protected static $relationships = array();
    protected static $parents = array();

    /**
     * Returns array of errors if errors happened, FALSE if no error occured.
     * @param array $data
     */
    public static function is_invalid(Array $data)
    {
    }

    public static function get_table()
    {
    }

    public static function get_grid_fields()
    {
    }

    public static function get_current_model_name()
    {
        return strtolower(
            basename(
                \str_replace('\\', '/', get_called_class())
            )
        );
    }

    public static function get_namespaced_model_path($model)
    {
        $model = Router::retrieve_class_name($model);
        $model_with_namespace = '\\Model\\' . $model;
        return $model_with_namespace;
    }

    public static function build_select_by_options(Array $options = array())
    {

        $where = ' WHERE ';
        $and = '';
        $table = static::get_table();
        if (isset($options['filter_model_key']) &&
            $options['filter_model_key'] != null &&
            isset($options['filter_model_value']) &&
            $options['filter_model_value'] != null &&
            $options['filter_model_value'] != '') {

            $relationship = static::$relationships[$options['filter_model_key']];
            $sql = " FROM " . $table .
                ' LEFT JOIN ' . $relationship['table'] .
                ' ON ' . $relationship['table'] . '.' . $relationship['id_field'] .
                ' = ' . $table . '.' . static::$id_field .
                $where . $and . $relationship['table'] . '.' . $relationship['relation_field'];

            if ($options['filter_model_value'] == 'na') {
                $sql .= ' IS NULL ';
            } else {
                $sql .= ' = ' . $options['filter_model_value'];
            }
            $where = '';
            $and = ' AND ';
        } else {
            $sql = " FROM " . static::get_table();
        }
        if (isset ($options ['where'])) {
            $sql .= $where . $and . $options ['where'];
        }
        return $sql;
    }

    public static function count(Array $options = array())
    {

        global $pdo;

        $sql = "SELECT COUNT(*) as count " . static::build_select_by_options($options);

        $stmt = $pdo->query($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $row ['count'];
        return $count;
    }

    public static function fetch(Array $options = array())
    {

        global $pdo;

        $table = static::get_table();
        $sql = "SELECT DISTINCT ${table}.* " . static::build_select_by_options($options);

        if (isset ($options ['order_by'])) {
            $sql .= ' ORDER BY ' . $options ['order_by'];
        }

        if (isset ($options ['limit'])) {
            $sql .= ' LIMIT ' . $options ['limit'];
        }

        if (isset ($options ['offset'])) {
            $sql .= ' OFFSET ' . $options ['offset'];
        }

        $stmt = $pdo->query($sql);
        return $stmt;
    }

    public static function fetch_all(Array $options = array())
    {
        $stmt = static::fetch($options);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function save(Array $data)
    {

        $response = array('validation' => true);

        $errors = static::is_invalid($data);
        if ($errors !== false) {
            $response ['validation'] = $errors;
            return $response;
        }

        $data ['updated_on'] = date(DATETIME_FORMAT_PHP);
        if (!is_numeric($data [static::$id_field])) {
            $data = static::insert($data);
            $response ['save_type'] = static::SAVE_TYPE_INSERT;
        } else {
            static::update($data);
            $response ['save_type'] = static::SAVE_TYPE_UPDATE;
        }

        static::save_relationships($data);

        $response ['data'] = $data;

        return $response;
    }

    public static function save_relationship($model_key, $id, $related_ids)
    {

        global $pdo;

        $relationship = static::$relationships[$model_key];

        $save = function ($pdo, $relationship, $id, $related_id) {

            $sql = 'INSERT INTO ' . $relationship['table'] .
                '( ' . $relationship['id_field'] . ' , ' . $relationship['relation_field'] . ' ) ' .
                'VALUES (' . $id . ' , ' . $related_id . ' )';
            $pdo->query($sql);

        };

        if (is_array($related_ids)) {
            foreach ($related_ids as $related_id) {
                $save($pdo, $relationship, $id, $related_id);
            }
        } else {
            $save($pdo, $relationship, $id, $related_ids);
        }
    }

    public static function save_relationships(Array $data)
    {

        $id = $data[static::$id_field];

        foreach (static::$relationships as $model_key => $relationship) {
            if ($relationship['always_save'] == true) {
                static::delete_relationship($model_key, $id);
                if (isset($data[$model_key])) {
                    static::save_relationship($model_key, $id, $data[$model_key]);
                }
            }
        }
    }

    public static function insert(Array $data)
    {
        global $pdo;
        $sql = 'INSERT INTO ' . static::get_table() . ' ';

        $sql_data = array();
        $sql_fields = '(';
        $sql_values = '(';
        $comma = '';

        foreach ($data as $field => $value) {
            if ($field != static::$id_field && !isset(static::$relationships[$field])) {
                $sql_data [':' . $field] = $value;
                $sql_fields .= $comma . $field;
                $sql_values .= $comma . ':' . $field;
                $comma = ', ';
            }
        }
        $sql_fields .= ')';
        $sql_values .= ')';

        $sql .= $sql_fields . ' VALUES ' . $sql_values;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($sql_data);
        $data [static::$id_field] = $pdo->lastInsertId();
        return $data;
    }

    public static function update(Array $data)
    {
        global $pdo;
        $sql = 'UPDATE ' . static::get_table() . ' SET ';

        $sql_data = array();
        $sql_fields = '(';
        $sql_values = '(';
        $comma = '';

        foreach ($data as $field => $value) {
            if ($field != static::$id_field && !isset(static::$relationships[$field])) {
                $sql_data [':' . $field] = $value;
                $sql .= $comma . $field . ' = :' . $field;
                $comma = ', ';
            }
        }
        $sql .= ' WHERE ' . static::$id_field . ' = ' . $data [static::$id_field];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($sql_data);
    }

    public static function load($id)
    {
        global $pdo;

        $sql = 'SELECT * FROM ' . static::get_table() . ' WHERE ' . static::$id_field . ' = ' . $id;
        $stmt = $pdo->query($sql);
        $response = array();
        $response ['data'] = $stmt->fetch(PDO::FETCH_ASSOC);

        $response['relationships'] = static::load_relationships($id);

        return $response;
    }

    public static function load_relationship($model_key, $id)
    {
        global $pdo;

        $relationship = static::$relationships[$model_key];

        $sql = 'SELECT  ' . $relationship['relation_field'] .
            ' FROM ' . $relationship['table'] .
            ' WHERE ' . $relationship['id_field'] . ' = ' . $id;
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function load_relationships($id)
    {
        $relationships = array();
        foreach (static::$relationships as $model_key => $relationship) {
            if ($relationship['always_load'] == true) {
                $relationships[$model_key] = static::load_relationship($model_key, $id);
            }
        }
        return $relationships;
    }

    public static function delete($id)
    {
        global $pdo;

        static::delete_parent_relationships($id);
        static::delete_relationships($id);
        $sql = 'DELETE FROM ' . static::get_table() . ' WHERE ' . static::$id_field . ' = ' . $id;
        $stmt = $pdo->query($sql);
    }

    public static function jqgrid($page, $limit, $sidx, $sord, $filter_model_key = null, $filter_model_value = null)
    {
        if (!$sidx) {
            $sidx = 1;
        }

        $offset = max(0, $limit * $page - $limit); // do not put $limit*($page - 1)
        $order_by = "$sidx $sord";

        $options = array(
            'offset' => $offset,
            'limit' => $limit,
            'order_by' => $order_by,
            'filter_model_key' => $filter_model_key,
            'filter_model_value' => $filter_model_value
        );

        $count = static::count($options);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $response = array();
        $response ['page'] = $page;
        $response ['total'] = $total_pages;
        $response ['records'] = $count;

        $stmt = static::fetch($options);

        $grid_fields = static::get_grid_fields();
        $i = 0;

        while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
            $response ['rows'] [$i] [static::$id_field] = $row [static::$id_field];

            $cell = array();
            foreach ($grid_fields as $field) {
                $cell [] = $row [$field];
            }

            $response ['rows'] [$i] ['cell'] = $cell;
            $i++;
        }
        return $response;
    }

    public static function delete_relationship($model_key, $id)
    {
        global $pdo;
        $relationship = static::$relationships [$model_key];
        $sql = 'DELETE FROM ' . $relationship ['table'] . ' WHERE ' . $relationship ['id_field'] . ' = ' . $id;
        $stmt = $pdo->query($sql);
    }

    public static function delete_relationships($id)
    {
        foreach (static::$relationships as $model_key => $relationship) {
            static::delete_relationship($model_key, $id);
        }
    }

    public static function delete_parent_relationship($parent_model, $id)
    {
        global $pdo;
        $parent_model = static::get_namespaced_model_path($parent_model);
        $current_model = static::get_current_model_name();
        $relationship = $parent_model::$relationships[$current_model];
        $sql = 'DELETE FROM ' . $relationship ['table'] . ' WHERE ' . $relationship ['relation_field'] . ' = ' . $id;
        $stmt = $pdo->query($sql);
    }

    public static function delete_parent_relationships($id)
    {
        foreach (static::$parents as $parent_model) {
            static::delete_parent_relationship($parent_model, $id);
        }
    }
}
