<?php

	class ActionFormHelper
	{
		/**
		 * 栏目选择
		 * @param intval/array $catid 别选中的ID，多选是可以是数组
		 * @param string $str 属性
		 * @param string $default_option 默认选项
		 * @param intval $model_id 按所属模型筛选
		 * @param intval $type 栏目类型
		 * @param intval $only_sub 只可选择子栏目
		 */
		public static function select_category($cat_id = 1, $str = '', $default_option = '', $model_id = 0, $type = -1, $only_sub = 0,$is_push = 0) {
			$tree = new Tree;
			
			$category = Category::model()->findAll();
			
			$i=0;
			foreach($category as $o)
			{
				
				$result[$i]['cat_id'] = $o->cat_id;
				$result[$i]['parent_id'] = $o->parent_id;
				$result[$i]['cat_name'] = $o->cat_name;
				$result[$i]['type'] = $o->type;
				$result[$i]['child'] = $o->child;
				$i++;	
			}
			
			$string = '<select '.$str.'>';
			if($default_option) $string .= "<option value='0'>$default_option</option>";
			if (is_array($result)) {
				foreach($result as $r) {
					if( ($type >= 0 && $r['type'] != $type)) continue;
					$r['selected'] = '';
					if(is_array($cat_id)) {
						$r['selected'] = in_array($r['cat_id'], $cat_id) ? 'selected' : '';
					} elseif(is_numeric($cat_id)) {
						$r['selected'] = $cat_id==$r['cat_id'] ? 'selected' : '';
					}
					$r['html_disabled'] = "0";
					if (!empty($onlysub) && $r['child'] != 0) {
						$r['html_disabled'] = "1";
					}
					$categorys[$r['cat_id']] = $r;
					if($model_id && $r['model_id']!= $model_id ) unset($categorys[$r['cat_id']]);
				}
			}
			$str  = "<option value='\$cat_id' \$selected>\$spacer \$cat_name</option>;";
			$str2 = "<optgroup label='\$spacer \$cat_name'></optgroup>";
	
			$tree->init($categorys);
			$string .= $tree->get_tree_category(0, $str, $str2);
				
			$string .= '</select>';
			
			return $string;
		}
		
	}

?>