<?php
namespace plugin\form;

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
     * 字段输入
     * 
     * @access public
     */
    public function getText($info, $value = NULL) {
        $field = $info['fieldName'];
        if (ACTION_NAME == 'add') {
			$value = $info['fieldDefaultValue'];
        } else {
			$value = $value ? $value : $this->data[$field];
        }
        if (!empty($info['fieldTips'])) {
            $fieldTipsHtml  = '<div class="layui-form-mid layui-word-aux">'.$info['fieldTips'].'</div>';
            $layuiClass     = 'layui-input-inline';
        } else {
            $layuiClass     = 'layui-input-block';
            $fieldTipsHtml  = '';
        }
        $parseStr = '<div class="layui-form-item">
            <label class="layui-form-label">'.$info['fieldTitle'].'</label>
            <div class="'.$layuiClass.'">
                <input type="text" name="'.$field.'" id="'.$field.'" lay-verify="required" placeholder="'.$info['fieldDescription'].'" autocomplete="off" class="layui-input">
            </div>
            '.$fieldTipsHtml.'
        </div>';
		return $parseStr;
    }
    
    /**
     * 
     */
    
}


