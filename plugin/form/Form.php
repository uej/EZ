<?php
namespace plugin\form;
use ez\core\Route;

/**
 * 表单自动生成类
 * 
 * @author lxj
 */
class Form {
    
    /**
     * @var array 方法列表
     */
    const METHOD_LIST   = [
        
    ];
    
    /**
     * @var array 数据
     */
    public $data    = [];
    
    
    /**
     * 构造函数
     *
     * @access public
     */
    public function __construct($data = []) {
         $this->data = $data;
    }
    
    /**
     * input type="text" html生成
     * 
     * @param array $info 字段信息
     * @param string $value 字段值
     * @return string
     * @access public
     */
    public function getText($info, $value = NULL) {
        $field = $info['fieldName'];
        if (strpos(ACTION_NAME, 'add') !== FALSE) {
			$value = htmlspecialchars($info['fieldDefaultValue']);
        } else {
			$value = htmlspecialchars($value ? $value : $this->data[$field]);
        }
        
        $commonData = $this->getCommonData($info);
        $parseStr = '<div class="layui-form-item">
            <label class="layui-form-label">'.$info['fieldTitle'].'</label>
            <div class="'.$commonData['layuiClass'].'" '.$commonData['style'].'>
                <input type="text" name="'.$field.'" id="'.$field.'" lay-verify="'.$commonData['verify'].'" placeholder="'.$info['fieldDescription'].'" autocomplete="off" class="layui-input" value="'.$value.'">
            </div>
            '.$commonData['fieldTipsHtml'].'
        </div>';
		return $parseStr;
    }
    
    /**
     * select html生成
     * 
     * @param array $info 字段信息
     * @param string $value 字段值
     * @return string
     * @access public
     */
    public function getSelect($info, $value = NULL) {
        $field = $info['fieldName'];
        if (strpos(ACTION_NAME, 'add') !== FALSE) {
			$value = $info['fieldDefaultValue'];
        } else {
			$value = $value ? $value : $this->data[$field];
        }
        
        $commonData = $this->getCommonData($info);
        $selectData = $this->getFieldDataSource($info['fieldDataSource']);
        $optionStr  = '<option value="">请选择</option>';
        foreach ($selectData as $val) {
            if ($val['key'] == $value) {
                $selected   = 'selected';
            }
            $optionStr  .= '<option value="'.$val['key'].'" '.$selected.'>'.$val['value'].'</option>';
        }
        $parseStr = '<div class="layui-form-item">
            <label class="layui-form-label">'.$info['fieldTitle'].'</label>
            <div class="'.$commonData['layuiClass'].'" '.$commonData['style'].'>
                <select name="'.$field.'" id="'.$field.'" lay-verify="'.$commonData['verify'].'">'.$optionStr.'</select>
            </div>
            '.$commonData['fieldTipsHtml'].'
        </div>';
		return $parseStr;
    }
    
    /**
     * input type="checkbox" html生成
     * 
     * @param array $info 字段信息
     * @param type $value 字段值
     * @return string
     * @access public
     */
    public function getCheckbox($info, $value = NULL) {
        $field = $info['fieldName'];
        if (strpos(ACTION_NAME, 'add') !== FALSE) {
			$value = $info['fieldDefaultValue'];
        } else {
			$value = $value ? $value : $this->data[$field];
        }
        
        $commonData     = $this->getCommonData($info);
        $checkboxData   = $this->getFieldDataSource($info['fieldDataSource']);
        foreach ($checkboxData as $val) {
            if ($val['key'] == $value) {
                $checked   = 'checked';
            }
            $inputStr  .= '<input type="checkbox" lay-skin="primary" name="'.$field.'" value="'.$val['value'].'" title="'.$val['value'].'" '.$checked.'>';
        }
        $parseStr = '<div class="layui-form-item">
            <label class="layui-form-label">'.$info['fieldTitle'].'</label>
            <div class="'.$commonData['layuiClass'].'" '.$commonData['style'].'>'.$inputStr.'</div>
            '.$commonData['fieldTipsHtml'].'
        </div>';
		return $parseStr;
    }
    
    /**
     * radio的html生成
     * 
     * @param array $info 字段信息
     * @param string $value 字段值
     * @return string
     * @access public
     */
    public function getRadio($info, $value = NULL) {
        $field = $info['fieldName'];
        if (strpos(ACTION_NAME, 'add') !== FALSE) {
			$value = $info['fieldDefaultValue'];
        } else {
			$value = $value ? $value : $this->data[$field];
        }
        $commonData = $this->getCommonData($info);
        $radioData  = $this->getFieldDataSource($info['fieldDataSource']);
        foreach ($radioData as $val) {
            if ($val['key'] == $value) {
                $checked   = 'checked';
            }
            $inputStr  .= '<input type="radio" name="'.$field.'" value="'.$val['value'].'" title="'.$val['value'].'" '.$checked.'>';
        }
        $parseStr = '<div class="layui-form-item">
            <label class="layui-form-label">'.$info['fieldTitle'].'</label>
            <div class="'.$commonData['layuiClass'].'" '.$commonData['style'].'>'.$inputStr.'</div>
            '.$commonData['fieldTipsHtml'].'
        </div>';
		return $parseStr;
    }
    
    /**
     * 日期筛选器html
     * 
     * @param array $info
     * @param string $value
     * @return string
     * @access public
     */
    public function getDate($info, $value = NULL) {
        $field = $info['fieldName'];
        if (strpos(ACTION_NAME, 'add') !== FALSE) {
			$value = $info['fieldDefaultValue'];
        } else {
			$value = $value ? $value : $this->data[$field];
        }
        $commonData = $this->getCommonData($info);
        $parseStr = '<div class="layui-form-item">
            <label class="layui-form-label">'.$info['fieldTitle'].'</label>
            <div class="'.$commonData['layuiClass'].'" '.$commonData['style'].'>
                <input type="text" name="'.$field.'" id="'.$field.'" lay-verify="'.$commonData['verify'].'" placeholder="'.$info['fieldDescription'].'" autocomplete="off" class="layui-input" value="'.$value.'">
            </div>
            '.$commonData['fieldTipsHtml'].'
        </div>';
        $parseStr .= '<script>
            laydate = layui.laydate;
            laydate.render({
                elem: "#'.$field.'"
            });
        </script>';
		return $parseStr;
    }
    
    /**
     * 单图片上传
     * 
     * @access public
     */
    public function uploadPic($info, $value = NULL) {
        $field = $info['fieldName'];
        if (strpos(ACTION_NAME, 'add') !== FALSE) {
			$value = $info['fieldDefaultValue'];
        } else {
			$value = $value ? $value : $this->data[$field];
        }
        $commonData = $this->getCommonData($info);
        $parseStr = '<div class="layui-form-item">
            <label class="layui-form-label">'.$info['fieldTitle'].'</label>
            <div class="layui-input-inline" '.$commonData['style'].'>
                <input type="text" name="'.$field.'" id="'.$field.'" lay-verify="'.$commonData['verify'].'" placeholder="'.$info['fieldDescription'].'" autocomplete="off" class="layui-input" value="'.$value.'">
            </div>'.$commonData['fieldTipsHtml'].'
            <button class="layui-btn" id="upload'.$field.'">上传</button>
            <button class="layui-btn layui-btn-primary" id="preview'.$field.'">预览</button>
        </div>';
        $parseStr .= '<script>
        upload = layui.upload;
        var upload'.$field.' = upload.render({
            elem: "#upload'.$field.'"
            ,url: "'.Route::createUrl('manage/manage/openupload').'"
            ,done: function(res) {
                if (res.code === 0) {
                    $("#'.$field.'").val(res.savePath);
                } else {
                    layer.alert(res.msg);
                }
            }
            ,error: function() {
                layer.alert("上传失败");
            }
        });
        
        </script>';
		return $parseStr;
    }
    
    /**
     * 获取数据资源
     * 
     * @param string $fieldDataSource 数据资源字符串，支持格式json及逗号分隔符
     * <code>
	 *      1=贵阳,2=铜仁,3=遵义,4=兴义,5=安顺
	 * </code>
     * @return mixed 数据数组
     * @access public
     */
    public function getFieldDataSource($fieldDataSource) {
        $data   = json_decode($fieldDataSource, TRUE);
        
 		if ($data) {
            return $data;
		} else {
			/* 字符数据源 */
			$array = explode(',', $fieldDataSource);
			foreach ($array as $value) {
				$temp = explode("=", $value);
				$arr['key']   = $temp[0];
				$arr['value'] = $temp[1];
				$data[] = $arr;
			}
			return $data;
		}
		return false;
    }
    
    /**
     * 获取公共部分数据
     * 
     * @param array $info
     * @return array
     */
    public function getCommonData($info) {
        if (!empty($info['fieldTips'])) {
            $fieldTipsHtml  = '<div class="layui-form-mid layui-word-aux">'.$info['fieldTips'].'</div>';
            $layuiClass     = 'layui-input-inline';
        } else {
            $layuiClass     = 'layui-input-block';
            $fieldTipsHtml  = '';
        }
        if (!empty($info['boxStyle'])) {
            $style  = 'style="'.$info['boxStyle'].'"';
        } else {
            $style  = '';
        }
        
        if (!empty($info['fieldInputFilter'])) {
            $verify = $info['fieldInputFilter'];
        } else {
            $verify = '';
        }
        
        return [
            'fieldTipsHtml' => $fieldTipsHtml,
            'layuiClass'    => $layuiClass,
            'style'         => $style,
            'verify'        => $verify,
        ];
    }
    
    /**
     * 生成html
     * 
     * @access public
     * fieldInputPicker	表单值采集器这个字段好像不需要了
     */
    public function createHtml($fieldDatas, $data = NULL) {
        $html   = '<form class="layui-form" action="">';
        
        if (!empty($data)) {
            $html   .= '<input type="hidden" name="id" value="'.$data['id'].'">';
        }
        
        foreach ($fieldDatas as $val) {
            $html   .= $this->$val['fieldInput']($val, $data[$val['fieldName']]);
        }
        
        $html .= '<div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="dosubmit">立即提交</button>
                </div>
            </div>
        </form>';
        
        $html .= '<script>
        var form = layui.form;
        
        form.verify({
            pass: [
                /^[\S]{6,12}$/
                ,"密码必须6到12位，且不能出现空格"
            ]
        }); 
        
        form.on("submit(dosubmit)", function(data) {
            $.ajax({
                url: "'.Route::createUrl(ACTION_NAME).'",
                data: data.field,
                type: "post",
                dataType: "json",
                success: function(res) {
                    if(res.status == 1) {
                        layer.alert(res.info, {icon: 1}, function() {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        });
                    } else {
                        layer.alert(res.info, {icon: 2});
                    }
                },
                error: function() {
                    layer.alert("系统错误", {icon: 0});
                }
            });
            return false;
        });
        </script>';
    }
    
}


