<?php 
/**
 * Function : Recursive
 * Author   : JosT
 * Date     : Dec 6, 2014
 */

	function buildArr($data, $columnName, $parentValue = 0)
	{
		recursive($data, $columnName, $parentValue, 1, $resultArr);
		return $resultArr;
	}
	
	function recursive($data,$columnName = "",$parentValue = 0, $level = 1,&$resultArr)
	{
		if(count($data) > 0){
			foreach ($data as $key => $value) {
                if(isset($value['parent'])) {
                    if($value['parent'] == $parentValue){
                        $value['level'] = $level;
                        $resultArr[] = $value;
                        $newParent = $value['id'];
                        unset($data[$key]);
                        recursive($data,$columnName,$newParent,$level+1,$resultArr);
                    }
                }elseif(isset($value['parentId'])) {
                    if($value['parentId'] == $parentValue){
                        $value['level'] = $level;
                        $resultArr[] = $value;
                        $newParent = $value['id'];
                        unset($data[$key]);
                        recursive($data,$columnName,$newParent,$level+1,$resultArr);
                    }
                }

			}
		}
	}

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $key1=>$element) {
            if ($element['parent'] == $parentId) {
                $children = buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }
	
	function makeTree(&$items) {
		$tree = array();
		$total = count($items);
		for($i = 0; $i < $total; $i++) {
			$items[$i]['itemIndex'] = $i;
			$items[$i]['hasParent'] = false;
		}
		for($i = 0; $i < $total; $i++) {
			for($j = $i + 1; $j < $total; $j++) {
				if($items[$j]['parent'] == $items[$i]['id']) {
					$items[$j]['hasParent'] = true;
					if(!isset($items[$i]['childrenIndexes'])) {
						$items[$i]['childrenIndexes'] = array();
					}
					$items[$i]['childrenIndexes'][] = $j;
				} else if($items[$i]['parent'] == $items[$j]['id']) {
					$items[$i]['hasParent'] = true;
					if(!isset($items[$j]['childrenIndexes'])) {
						$items[$j]['childrenIndexes'] = array();
					}
					$items[$j]['childrenIndexes'][] = $i;
				}
			}
		}
		
		for($i = 0; $i < $total; $i++) {
			if($items[$i]['hasParent'] == false) {
				$tree[] = $items[$i]['itemIndex'];
			}
		}
		
		return $tree;
	}
	
	function parseTree(&$items, $tree, &$result, $level = 1) {
		foreach($tree as $index) {
			$items[$index]['level'] = $level;
			$result[] = $items[$index];
			if(isset($items[$index]['childrenIndexes'])) {
				parseTree($items, $items[$index]['childrenIndexes'],$result, $level+1);
			}
		}
	}
	
	function treefy(&$items) {
		$tree = makeTree($items);
		$result = array();
		parseTree($items, $tree, $result);
		return $result;
	}

    function show_menu($array = array(), $firstUlClass='nav nav-justified multi-level', $ulClass = 'dropdown-menu', $liClass = 'dropdown', $first = true)
    {
		static $currentCategory;
		if(!$currentCategory) {
			$currentCategory = _db()->getTableEntity('categories')->load(pzk_request()->getSegment(3));
		}
        echo '<ul class="' . ( $first? $firstUlClass : $ulClass ) . '">';
        foreach ($array as $item) {
        	$class_action = ' class="'.$liClass.'"';
        	if( pzk_session(MENU) === $item['router']){
        		$class_action = ' class="' . $liClass . ' action"';
        	}
            echo '<li'.$class_action.'>';
			$href = '';
			if(strpos($item['router'], 'http://') !== false) {
				$href = $item['router'];
			} else {
				if(SEO_MODE && @$item['alias']) {
					$href = '/' . @$item['alias'];
				} else {
					$href = pzk_request()->build($item['router'].'/'.$item['id']);
				}
				
			}
			
			
			$active = strpos($currentCategory->getParents(), ',' . $item['id'] . ',') !== false ? 'active': '';
            echo '<a class="'.$active.' dropdown-toggle menu_item_'.$item['id'].'" href="'.$href.'">';
            echo $item['name'];
            echo '</a>';
            if (!empty($item['children']))
            {
                show_menu($item['children'], $firstUlClass, $ulClass, $liClass, false);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
	
	function buildBs($data) {
		foreach($data as $val) {
			$parentId = $val['parent'];
			$dataXuli[$parentId][] = $val; 
		}
		return $dataXuli;
	}
	
	function showBsMenu($dataXuli, $parentId=0)
    {
		if(isset($dataXuli[$parentId])) {
		echo "<ul class='dropdown-menu'>";
		foreach($dataXuli[$parentId] as $key => $val) {
			echo "<li>";
			$parentId = $val['id'];
			if(isset($dataXuli[$parentId])) {
				echo "<a class='link' href='javascript:void(0);'>".$val['name']."</a>";
			}else {
				echo "<a href='#view$parentId'>".$val['name']."</a>";
			}
			unset($dataXuli[$key]);
			showBsMenu($dataXuli, $parentId);
			echo "</li>";	
		}
		echo "</ul>";
		}
    }
	
	

	function showAdminMenu($array = array()){
    	echo '<ul class="drop">';
        foreach ($array as $item){
        	$class_action = "";
        	if( pzk_session(MENU) === $item['admin_controller']){
        		$class_action = " class = 'action'";
        	}
            echo '<li'.$class_action.'>';
            if(substr($item['admin_controller'], 0, 1) == '0'){
                echo '<a href="javarscript:void(0);">';
            }else {
                echo '<a href="/'.$item['admin_controller'].'/index">';
            }
            echo $item['name'];
            echo '</a>';
            if (!empty($item['children']))
            {
                showAdminMenu($item['children']);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
    
    function convertContentArray($str = ''){
    	
    	if(!empty($str)){
    		
    		$content = explode('|', $str);
    		
    		foreach ($content as $key => $value){
    			 
    			$is_check = strpos($value,'_');
    			if($is_check != 0){
    		
    				$content[$key] 	 		= str_replace('_', '', $value);
    				$content['main'] 		= str_replace('_', '', $value);
    			}else{
    		
    				$content[$key]		 	= $value;
    				$content['extra'] 		= $value;
    			}
    		}
    		return $content;
    	}
    	return null;
    }
    
    function checkArray($str ="", $hashArray = array(), $k = "content"){
    	
    	if(!empty($str) && is_array($hashArray)){
    		$dataArray = array();
    		foreach ($hashArray as $key =>$value){
    			$dataArray[] = trim($value[$k]);
    		}
    		if(in_array(trim($str), $dataArray)){
    			
    			return true;
    		}
    	}
    	return false;
    }
    
    function numPage($quantity){
    	$numpage= ceil($quantity/3);
    	return $numpage;
    }
    

 ?>