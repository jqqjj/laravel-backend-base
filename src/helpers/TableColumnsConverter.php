<?php


namespace App\Helpers;

class TableColumnsConverter
{
    public function format($key,$value)
    {
        $config = config("column.columns");
        list($table,$column) = explode('.', $key, 2);
        return key_exists($table, $config) 
                && key_exists($column, $config[$table]) 
                && key_exists($value, $config[$table][$column]['list']) 
                ? $config[$table][$column]['list'][$value] : "";
    }
    
    public function getConfig($key)
    {
        $config = config("column.columns");
        list($table,$column) = explode('.', $key, 2);
        return key_exists($table, $config) 
                && key_exists($column, $config[$table]) 
                ? $config[$table][$column] : [];
    }
}