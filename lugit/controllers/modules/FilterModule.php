<?php
class FilterModule extends Singleton
{
    /**
     * 应用过滤器并返回过滤后的结果.
     * 用法:
     * Singleton->getInstance('FilterModule')->applyFilter('trim', ' abc ');
     * //返回'abc'
     *
     * Singleton->getInstance('FilterModule')->applyFilter('trim', array(' abc ', 'abc '));
     * //返回array('abc', 'abc')
     *
     * 支持静态方法
     * Singleton->getInstance('FilterModule')->applyFilter('YourClass::yourMethod', ' abc ');
     * 
     * @access public
     * @param string $filter 过滤器名称
     * @param mixed $data 要处理的数据
     * @return mixed 处理后的数据
     */
    public function applyFilter($filter, $data)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$v) {
                $v = $this->_applyStringFilter($filter, $v);
            }
        }

        if (is_array($filter)) {
            $callback = $filter[0];
            if (!$callback) return $data;
            $filter[0] = $data;
            $data = $filter;
        } else {
            $callback = $filter;
            $data = array($data);
        }
        return call_user_func_array(Basic::resolveCallback($callback, __CLASS__), $data);
    }


    /**
     * 应用多个过滤器并返回过滤后的结果.
     * 
     * @access public
     * @param array $filters 过滤器列表
     * @param mixed $data
     * @return mixed 处理后的数据
     */
    public function applyFilters($filters, $data)
    {
        if (is_array($filters)) {
            foreach ($filters as $filter) {
                $data = $this->applyFilter($filter, $data);
            }
        } else {
            throw new exception('applyFilters() need first param to be a array.');
        }
        return $data;
    }


    public static function ()
    {
    }


}
