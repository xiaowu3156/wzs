<?php
if (! function_exists('get_param')) {

    function get_param ($params, $key, $default = 0)
    {
        if (isset($params[$key])) {
            return $params[$key];
        } else {
            return $default; 
        }
    }
}

if (! function_exists('get_int')) {

    function get_int ($params, $key, $default = 0)
    {
        if (isset($params[$key])) {
            return intval($params[$key]);
        } else {
            return $default;
        }
    }
}

if (! function_exists('get_strtotime')) {

    function get_strtotime ($params, $key, $default = 0)
    {
        if (isset($params[$key])) {
            return strtotime($params[$key]);
        } else {
            return $default;
        }
    }
}

if (! function_exists('get_last_query')) {

    function get_last_query ($link = null)
    {
        $queries = $link ? \DB::connection($link)->getQueryLog() : \DB::getQueryLog();
        $sql = end($queries);
        
        if (! empty($sql['bindings'])) {
            $pdo = $link ? \DB::connection($link)->getPdo() : \DB::getPdo();
            foreach ($sql['bindings'] as $binding) {
                $sql['query'] = preg_replace('/\?/', $pdo->quote($binding), 
                        $sql['query'], 1);
            }
        }
        
        return $sql['query'];
    }
}
if (! function_exists('get_db_query')) {

    function get_db_query ($link = null)
    {
        $queries = $link ? \DB::connection($link)->getQueryLog() : \DB::getQueryLog();
        $sql_array = array();
        foreach ($queries as $sql) {
            // var_dump($sql)."<br />";
            if (! empty($sql['bindings'])) {
                $pdo = $link ? \DB::connection($link)->getPdo() : \DB::getPdo();
                foreach ($sql['bindings'] as $binding) {
                    $sql['query'] = preg_replace('/\?/', $pdo->quote($binding), 
                            $sql['query'], 1);
                }
            }
            $sql_array[] = $sql['query'];
        }
        return $sql_array;
    }
}

if (! function_exists('_debug')) {

    function _debug ()
    {
        return view('debugbar', []);
    }
}