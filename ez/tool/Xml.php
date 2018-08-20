<?php
namespace ez\tool;

/**
 * xml解析生成
 * 
 * @copyright   Copyright (C) 2007-2011 Tiwer Studio. All Rights Reserved.
 * @author      wgw8299 <wgw8299@gmail.com>
 * @package     Tiwer Developer Framework
 * @version     $Id: Xml.class.php 467 2014-07-24 09:29:17Z wgw $
 * @link        http://www.tiwer.cn
 */
class Xml
{
    private $document;
	private $root;
    
	/**
	 * xml解析
	 *
	 * @param string $xml xml字符内容
	 */
	public static function decode($xml)
    {
		$values = [];
		$index  = [];
		$array  = [];
		$parser = xml_parser_create('utf-8');
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parse_into_struct($parser, $xml, $values, $index);
		xml_parser_free($parser);
		
		$i      = 0;
		$name   = $values[$i]['tag'];
		$array[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : '';
		$array[$name] = self::_struct_to_array($values, $i);
		return $array;
	}
    
	/**
	 * xml编码
	 *
	 * @param array $data 数据
	 * @param strin $encoding 编码
	 * @param string $root 根结点
	 *        	
	 * @return string 生成的Xml
	 */
	public static function encode($data, $encoding = 'utf-8', $root = NULL)
    {
		$xml = '<?xml version="1.0" encoding="' . $encoding . '"?>';
		if (!empty($root)) {
			$xml .= '<' . $root . '>';
        }
		$xml .= self::_data_to_xml($data);
		if (!empty($root)) {
			$xml .= '</' . $root . '>';
        }
		return $xml;
	}
    
	private static function _struct_to_array($values, &$i)
    {
		$child = array();
		if (isset($values[$i]['value'])) {
			array_push($child, $values[$i]['value']);
        }
		
		while ($i++ < count($values)) {
			switch ($values[$i]['type']) {
				case 'cdata' :
					array_push($child, $values[$i]['value']);
					break;
				
				case 'complete' :
					$name = $values[$i]['tag'];
					if (!empty($name)) {
						$child [$name] = $values[$i]['value'] ? $values[$i]['value'] : '';
						if (isset($values[$i]['attributes'])) {
							$child[$name] = $values[$i]['attributes'];
						}
					}
					break;
				
				case 'open' :
					$name = $values[$i]['tag'];
					$size = isset($child[$name]) ? sizeof($child[$name]) : 0;
					$child[$name][$size] = self::_struct_to_array($values, $i);
					break;
				
				case 'close' :
					return $child;
					break;
			}
		}
		return $child;
	}
    
	private static function _data_to_xml($data) {
		
		/* 对象则转换成变量 */
		if (is_object($data)) {
			$data = get_object_vars($data);
        }
			
        /* 循环生成 */
		$xml = '';
		foreach ($data as $key => $val) {
			is_numeric($key) && $key = "item id=\"$key\"";
			$xml .= "<$key>";
			$xml .= (is_array($val) || is_object($val)) ? self::_data_to_xml($val) : $val;
			list($key, ) = explode(' ', $key);
			$xml .= "</$key>";
		}
		return $xml;
	}
	
}


