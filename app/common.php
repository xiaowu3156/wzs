<?php
/**
 * 机构端ajax返回格式
 * @param $status
 * @param $msg
 * @param string $url
 * @param string $data
 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
 */
function ajaxJson($status, $msg, $url = "", $data = "")
{
    return response(['code' => $status, 'message' => $msg, 'url' => $url, 'data' => $data]);
}

/**
 * 格式化标签显示
 * @param $value
 * @param string $delimiter
 * @param int $num
 * @return string
 */
function formatTag($value, $delimiter = '、', $num = 2)
{
    $arr = is_array($value) ? $value : explode(',', $value);
    $num = $num === 0 ? count($arr) : $num;
    if(count($arr) > $num){
        $temp = [];
        for($i = 0; $i < $num; $i++)
        {
            if($i === $num - 1)
            {
                $arr[$i] .= '...';
            }
            array_push($temp, $arr[$i]);
        }
        $arr = $temp;
    }
    return implode($delimiter, $arr);
}

/**
 * 处理课程评价均分显示
 * @param $teacher
 * @param $service
 * @return float|int|string
 */
function formatCourseScore($teacher, $service)
{
    if(intval($service) && intval($teacher))
    {
        return round(($service + $teacher) / 2, 2);
    }
    else if(intval($service))
    {
        return round($service, 2);
    }
    else if(intval($teacher))
    {
        return round($teacher, 2);
    }
    else
    {
        return '暂无评分';
    }
}


/**
 * 数组层级缩进转换
 * @param array $array 源数组
 * @param int   $pid
 * @param int   $level
 * @return array
 */
function array2level($array, $pid = 0, $level = 1)
{
    static $list = [];
    foreach ($array as $v) {
        if ($v['pid'] == $pid) {
            $v['level'] = $level;
            $list[]     = $v;
            array2level($array, $v['id'], $level + 1);
        }
    }

    return $list;
}

/**
 * 构建层级（树状）数组
 * @param array  $array          要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $id_name        当前ID字段名
 * @param string $pid_name       父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $id_name = 'id', $pid_name = 'pid', $child_key_name = 'children')
{
    $counter = array_children_count($array, $pid_name);
    if (!isset($counter[0]) || $counter[0] == 0) {
        return $array;
    }
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp[$id_name]]) && $counter[$temp[$id_name]] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid_name] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $id_name, $temp[$pid_name], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid_name);
    }

    return $tree;
}

/**
 * 子元素计数器
 * @param array $array
 * @param int   $pid
 * @return array
 */
function array_children_count($array, $pid)
{
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}

/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param array  $parent
 * @param string $id_name        当前ID字段名
 * @param int    $pid
 * @param array  $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $id_name, $pid, $child, $child_key_name)
{
    foreach ($parent as &$item) {
        if ($item[$id_name] == $pid) {
            if (!isset($item[$child_key_name]))
                $item[$child_key_name] = [];
            $item[$child_key_name][] = $child;
        }
    }

    return $parent;
}

/**
 * 替换数组的key值 二维数组
 * @param array $temp
 * @param array $param_key
 * @return array
 */
function array_key_replace($temp = [], $param_key = [])
{
    if($temp)
    {
        foreach ($temp as $key => $value){
            if(is_array($value))
            {
                foreach ($value as $k => $val)
                {
                    if(is_array($val))
                    {
                        $temp[$key][$k] = array_key_replace($val, $param_key);
                    }
                    if(array_key_exists($k, $param_key)) {
                        unset($temp[$key][$k]);
                        $temp[$key][$param_key[$k]] = $val;
                    }
                }
            }
        }
    }
    return $temp;
}