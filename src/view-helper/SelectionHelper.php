<?php


namespace App\Http\ViewHelper;

use App\Helpers\TableColumnsConverter;

class SelectionHelper
{
    private $converter;
    
    public function __construct(TableColumnsConverter $converter)
    {
        $this->converter = $converter;
    }
    
    public function columns($key,$selected=null,$label=null,$name=null,$class=null)
    {
        $config = $this->converter->getConfig($key);
        $column_name = !empty($config)&&!empty($config['name'])?$config['name']:"";
        $collection = !empty($config)&&!empty($config['list'])?$config['list']:[];
        
        list($table,$column) = explode('.', $key, 2);
        $html = '<select name="'.($name?:$column).'" class="'.($class?:"").'">';
        $html .= '<option value="">'.($label?:"请选择".$column_name).'</option>';
        foreach ($collection as $key=>$value){
            if(strlen($selected)>0 && $selected===$key){
                $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
            } else {
                $html .= '<option value="'.$key.'">'.$value.'</option>';
            }
        }
        $html .= '</select>';
        
        return $html;
    }
    
    public function collection(array $data,$selected=null,$label=null,$name=null,$class=null)
    {
        $html = '<select name="'.($name?:"").'" class="'.($class?:"").'">';
        if(!is_null($label)){
            $html .= '<option value="">'.($label?:"请选择").'</option>';
        }
        foreach ($data as $key=>$value){
            if(strlen($selected)>0 && $selected===$key){
                $html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
            } else {
                $html .= '<option value="'.$key.'">'.$value.'</option>';
            }
        }
        $html .= '</select>';
        
        return $html;
    }
}