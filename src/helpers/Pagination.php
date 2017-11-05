<?php


namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class Pagination
{
    /**
     * 根据builder及condition决定返回列表对象
     * @param Builder $builder
     * @param array $condition
     * @return mixed
     */
    public function make(Builder $builder,array $condition=[])
    {
        if (!empty($condition['all'])) {//获取全部列表
            return $this->all($builder,$condition);
        }else{//返回分页对象
            return $this->paginate($builder,$condition);
        }
    }
    /**
     * 返回全部集合列表
     * @param Builder $builder
     * @param array $condition
     * @return mixed
     */
    public function all(Builder $builder,array $condition=[])
    {
        return $this->sort($builder,$condition)->get();
    }
    
    /**
     * 返回分页对象
     * @param Builder $builder
     * @param array $condition
     * @return mixed
     */
    public function paginate(Builder $builder,array $condition=[])
    {
        $page_size = !empty($condition['page_size']) ? $condition['page_size'] : config("backend.list.page_size");
        return $this->sort($builder,$condition)->paginate($page_size);
    }
    
    /**
     * 根据输入处理需要筛选的column
     * @param array $input
     * @param array $columns
     * @return array
     */
    public function sortFilter(array $input,array $columns)
    {
        $column_key = config("backend.list.column_key");
        $sort_key = config("backend.list.sort_key");
        
        $column = isset($input[$column_key]) ? $input[$column_key] : '';
        $sort = isset($input[$sort_key]) ? $input[$sort_key] : '';
        
        return [
            $column_key=>in_array($column,$columns)?$column:'',
            $sort_key=>$sort,
        ];
    }
    
    /**
     * 根据需要排序的字段及排序方式生成排序条件
     * @param string $column
     * @param string $sort
     * @return array
     */
    public function generateSort($column,$sort='desc')
    {
        $column_key = config("backend.list.column_key");
        $sort_key = config("backend.list.sort_key");
        
        return [
            $column_key=>$column,
            $sort_key=>$sort,
        ];
    }
    
    /**
     * 处理排序相关处理
     * @param Builder $builder
     * @param array $condition
     * @return Builder
     */
    protected function sort(Builder $builder,array $condition=[])
    {
        //列表排序
        $column_key = config("backend.list.column_key");
        $sort_key = config("backend.list.sort_key");
        $sort_column = empty($condition[$column_key]) ? $builder->getModel()->getKeyName() : $condition[$column_key];
        if(empty($condition[$column_key])){
            $sort_type = config('backend.list.default_sort_type');
        }else{
            $sort_type = !empty($condition[$sort_key])&&in_array(strtolower($condition[$sort_key]),['asc','desc'])? strtolower($condition[$sort_key]) : 'desc';
        }
        $builder->orderBy($sort_column, $sort_type);
        
        return $builder;
    }
}