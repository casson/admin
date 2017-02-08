<?php

namespace app\extension;

use Yii;

class Util
{
	/**
	 *  functions.php 公共函数库
	 */

	 //文件大小转换
	 function formatBytes($size) { 
	  $units = array(' B', ' KB', ' MB', ' GB', ' TB'); 
	  for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 
	  return round($size, 2).$units[$i]; 
	 }
	 
	/**
	 * 多维数组键值排序
	 * @param $arr  处理数组  $keys 指定键值 $type 排序方式
	 * @return new array;
	 */
	function array_sort($arr,$keys,$type='asc')
	{ 
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		

		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		
	 
		
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
	} 
	 
	/**
	 * 返回经addslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	function new_add_slashes($string)
	{
		if(!is_array($string))return addslashes($string);
		foreach($string as $key=>$val)
		{
			$string[$key] = new_add_slashes($string);
		
		}
		return $string;

	}
	/**
	 * 返回经stripslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	function new_stripslashes($string) {
		if(!is_array($string)) return stripslashes($string);
		foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
		return $string;
	}

	/**
	 * 返回经htmlspecialchars处理过的字符串或数组
	 * @param $obj 需要处理的字符串或数组
	 * @return mixed
	 */
	function new_html_special_chars($string) {
		if(!is_array($string)) return htmlspecialchars($string);
		foreach($string as $key => $val) $string[$key] = new_html_special_chars($val);
		return $string;
	}
	/**
	* 安全过滤函数
	* @parame $string
	* @return string
	*/
	function safe_replace($string)
	{
		$string = str_replace('%20','',$string);
		$string = str_replace('%27','',$string);
		$string = str_replace('%2527','',$string);
		$string = str_replace('*','',$string);
		$string = str_replace('"','&quot;',$string);
		$string = str_replace("'",'',$string);
		$string = str_replace('"','',$string);
		$string = str_replace(';','',$string);
		$string = str_replace('>','&gt;',$string);
		$string = str_replace('<','&lt;',$string);
		$string = str_replace('{','',$string);
		$string = str_replace('}','',$string);
		$string = str_replace('\\','',$string);
		return $string;
	}

	/**
	 * 过滤ASCII码从0-28的控制字符
	 * @return String
	 */
	function trim_unsafe_control_chars($str) {
		$rule = '/[' . chr ( 1 ) . '-' . chr ( 8 ) . chr ( 11 ) . '-' . chr ( 12 ) . chr ( 14 ) . '-' . chr ( 31 ) . ']*/';
		return str_replace ( chr ( 0 ), '', preg_replace ( $rule, '', $str ) );
	}


	/**
	 * 文件夹删除
	 * @return String
	 */
	function deldir($dir)
	{
		$dh = opendir($dir);
		while ($file = readdir($dh))
		{
			if ($file != "." && $file != "..")
			{
				$fullpath = $dir . "/" . $file;
				if (!is_dir($fullpath))
				{
					unlink($fullpath);
				} else
				{
					deldir($fullpath);
				}
			}
		}
		closedir($dh);
		if (rmdir($dir))
		{
			return true;
		} else
		{
			return false;
		}
	}


	/**
	 * 格式化文本域内容
	 *
	 * @param $string 文本域内容
	 * @return string
	 */
	function trim_textarea($string) {
		$string = nl2br ( str_replace ( ' ', '&nbsp;', $string ) );
		return $string;
	}

	/**
	 * 将文本格式成适合js输出的字符串
	 * @param string $string 需要处理的字符串
	 * @param intval $isjs 是否执行字符串格式化，默认为执行
	 * @return string 处理后的字符串
	 */
	function format_js($string, $isjs = 1) {
		$string = addslashes(str_replace(array("\r", "\n", "\t"), array('', '', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}
	/**
	 * 获取当前页面完整URL地址
	 */
	function get_url() {
		$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		$php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
		$path_info = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
		$relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.safe_replace($_SERVER['QUERY_STRING']) : $path_info);
		return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	}
	/**
	 * 字符截取 支持UTF8/GBK
	 * @param $string
	 * @param $length
	 * @param $dot
	 */
	function str_cut($string, $length, $dot = '...') {
		$strlen = strlen($string);
		if($strlen <= $length) return $string;
		$string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
		$strcut = '';
		if(strtolower(CHARSET) == 'utf-8') {
			$length = intval($length-strlen($dot)-$length/3);
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t <= 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}
				if($noc >= $length) {
					break;
				}
			}
			if($noc > $length) {
				$n -= $tn;
			}
			$strcut = substr($string, 0, $n);
			$strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
		} else {
			$dotlen = strlen($dot);
			$maxi = $length - $dotlen - 1;
			$current_str = '';
			$search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
			$replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
			$search_flip = array_flip($search_arr);
			for ($i = 0; $i < $maxi; $i++) {
				$current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
				if (in_array($current_str, $search_arr)) {
					$key = $search_flip[$current_str];
					$current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
				}
				$strcut .= $current_str;
			}
		}
		return $strcut.$dot;
	}



	/**
	 * 获取请求ip
	 *
	 * @return ip地址
	 */
	function ip() {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$ip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
	}

	/**
	 * 程序执行时间
	 *
	 * @return	int	单位ms
	 */
	function execute_time() {
		$stime = explode ( ' ', SYS_START_TIME );
		$etime = explode ( ' ', microtime () );
		return number_format ( ($etime [1] + $etime [0] - $stime [1] - $stime [0]), 6 );
	}

	/**
	* 产生随机字符串
	*
	* @param    int        $length  输出长度
	* @param    string     $chars   可选的 ，默认为 0123456789
	* @return   string     字符串
	*/
	static function random($length, $chars = '0123456789') {
		$hash = '';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
		return $hash;
	}

	/**
	* 将字符串转换为数组
	*
	* @param	string	$data	字符串
	* @return	array	返回数组格式，如果，data为空，则返回空数组
	*/
	function string2array($data) {
		if($data == '') return array();
		@eval("\$array = $data;");
		return $array;
	}
	/**
	* 将数组转换为字符串
	*
	* @param	array	$data		数组
	* @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
	* @return	string	返回字符串，如果，data为空，则返回空
	*/
	function array2string($data, $isformdata = 1) {
		if($data == '') return '';
		if($isformdata) $data = new_stripslashes($data);
		return addslashes(var_export($data, TRUE));
	}

	/**
	* 转换字节数为其他单位
	*
	*
	* @param	string	$filesize	字节大小
	* @return	string	返回大小
	*/
	function sizecount($filesize) {
		if ($filesize >= 1073741824) {
			$filesize = round($filesize / 1073741824 * 100) / 100 .' GB';
		} elseif ($filesize >= 1048576) {
			$filesize = round($filesize / 1048576 * 100) / 100 .' MB';
		} elseif($filesize >= 1024) {
			$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
		} else {
			$filesize = $filesize.' Bytes';
		}
		return $filesize;
	}
	/**
	* 对用户密码进行加密
	* @parame $password
	* @parame $encrypt //加密因子
	* @return string
	*/
	static function password($password,$encrypt='')
	{
		$pwd = array();
		$pwd['encrypt'] = $encrypt ? $encrypt : self::random(6, $chars = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
		$pwd['password'] = md5(md5($password).$pwd['encrypt']);
		return $encrypt?$pwd['password']:$pwd;
	}

	/**
	* 判断密码是否符合要求
	* @parame $password
	* return boolean
	*/
	function is_password($password)
	{
		$strlen = strlen($password);
		if($strlen>=6 && $strlen<=20)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* 判断是否为非法输入
	* @parame $string
	* return boolean
	*/
	function is_bad_word($string)
	{

		$array = array('"','\\',' ','&','*','#','/','<','>','\r','\t','\n','#',"'");
		foreach($array as $value)
		{
			if(strpos($string,$value)!==false)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

	}
	/**
	 * 对数据进行编码转换
	 * @param array/string $data       数组
	 * @param string $input     需要转换的编码
	 * @param string $output    转换后的编码
	 */
	 function array_iconv($data,$input='gbk',$output='utf-8')
	 {
	 	if(!is_array($data))
		{
			$data =  iconv($input,$output,$data);
		}
		else
		{
			foreach($data as $key=>$value)
			{
				$data[$key]  = iconv($input,$output,$value);
			}
			
			
		}
	 
	 	return $data;
	 }
	/**
	* 字符串加密、解密函数
	*
	*
	* @param	string	$txt		字符串
	* @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
	* @param	string	$key		密钥：数字、字母、下划线
	* @param	string	$expiry		过期时间
	* @return	string
	*/
	function sys_auth($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
		$key_length = 4;
		$key = md5($key != '' ? $key : AUTH_KEY);
		$fixedkey = md5($key);
		$egiskeys = md5(substr($fixedkey, 16, 16));
		$runtokey = $key_length ? ($operation == 'ENCODE' ? substr(md5(microtime(true)), -$key_length) : substr($string, 0, $key_length)) : '';
		$keys = md5(substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
		$string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));

		$i = 0; $result = '';
		$string_length = strlen($string);
		for ($i = 0; $i < $string_length; $i++){
			$result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));
		}
		if($operation == 'ENCODE') {
			return $runtokey . str_replace('=', '', base64_encode($result));
		} else {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$egiskeys), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		}
	}

	function getmicrotime() {
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	/**
	 * 取得文件扩展
	 *
	 * @param $filename 文件名
	 * @return 扩展名
	 */
	function fileext($filename) {
		return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
	}
	
	//判断远程文件 
	function check_remote_file_exists($url) 
	{ 
		$curl = curl_init($url); 
		// 不取回数据 
		curl_setopt($curl, CURLOPT_NOBODY, true); 
		// 发送请求 
		$result = curl_exec($curl); 
		$found = false; 
		// 如果请求没有发送失败 
		if ($result !== false) 
		{ 
			// 再检查http响应码是否为200 
			$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
			if ($statusCode == 200) 
			{ 
				$found = true; 
			} 
		} 
		curl_close($curl); 

		return $found; 
	} 

	/**
	 * 判断是否为图片
	 */
	function is_image($file) {
		$ext_arr = array('jpg','gif','png','bmp','jpeg','tiff');
		$ext = fileext($file);
		return in_array($ext,$ext_arr) ? $ext_arr :false;
	}

	function multi1($num, $perpage, $curpage, $mpurl ,$todiv='') { 

		echo '<link href="css.css" rel="stylesheet" type="text/css" />';
		global $_SGLOBAL;
		$page = 7;
		if($_SGLOBAL['showpage']) $page = $_SGLOBAL['showpage'];
		
		$multipage = '';
		//$mpurl .= strpos($mpurl, '?') ? '&' : '?';
		$realpages = 1;
		if($num > $perpage) {
			$offset = 2;
			$realpages = @ceil($num / $perpage);
			$pages = $realpages;
			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if($to - $from < $page) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}
			$multipage = '';
			$urlplus = $todiv?"#$todiv":'';
			$zts = ceil($num/$perpage);
		
			$multipage .= "<div align='center' id='style'>共 <strong>".$num."</strong>个".$types."小游戏</div><div align='center' id='style_l'>".$curpage ."/".$zts."</div>" ;
		
			if($curpage - $offset > 1 && $pages > $page) {
				$multipage .= "<a ";
				{
					//$multipage .= "href=\"{$mpurl}page=1{$urlplus}\"";
					//$multipage.='1.html';
					$multipage.=' target="_self" href="'.$mpurl.(1).'.html" ';
				}
				$multipage .= " class=\"first\"><div align='center' id='index'>首页</div></a>";
			}
			if($curpage > 1) {
				$multipage .= "<a ";
				{
					//$multipage .= "href=\"{$mpurl}page=".($curpage-1)."$urlplus\"";
					//$multipage.=($curpage-1).'.html';
					$multipage.=' target="_self" href="'.$mpurl.($curpage-1).'.html" ';
				}
				$multipage .= " class=\"prev\"><div align='center'id='sy'>上页</div></a>";
			}
			for($i = $from; $i <= $to; $i++) {
				if($i == $curpage) {
					$multipage .= "<strong><div align='center' id='onenum'>".$i.'</div></strong>';
				} else {
					$multipage .= "<a ";
					{
						//$multipage .= "href=\"{$mpurl}page=$i{$urlplus}\"";
						//$multipage.=($i).'.html';
						$multipage.=' target="_self" href="'.$mpurl.($i).'.html" ';
					}
					$multipage .= "><div align='center' id='num'>$i</div></a>";
				}
			}
			if($curpage < $pages) {
				$multipage .= "<a ";
				{
					//$multipage .= "href=\"{$mpurl}page=".($curpage+1)."{$urlplus}\"";
					//$multipage.=($curpage+1).'.html';
					$multipage.=' target="_self" href="'.$mpurl.($curpage+1).'.html" ';
				}
				$multipage .= " class=\"next\"><div align='center'id='next'>下页</div></a>";
			}
			if($to < $pages) {
				$multipage .= "<a ";
				{
					//$multipage .= "href=\"{$mpurl}page=$pages{$urlplus}\"";
					$multipage.=' target="_self" href="'.$mpurl.($pages).'.html" ';
				}
				$multipage .= " class=\"last\"><div align='center' id='end'>尾页</div></a>";
			}
		
			if($multipage) {
				$multipage = ''.$multipage;
			}
		}
		$option='';
		
		$aa = ceil($num /$perpage);
		for($d=1; $d<=$aa;$d++){
			$option.= "<option value='".$mpurl.$d.".html'>$d</a>  </option>";
		}
		/*if($d>2){
		 $multipage.="<div style='float:left'><select  onChange='location.replace(this.value)'> ".$option."</select></div>";
		}	*/
		
		return $multipage;
		
	}


	function cn_substr($str, $position, $length,$type=1){
		$startPos = strlen($str);
		$startByte = 0;
		$endPos = strlen($str);
		$count = 0;
		for($i=0; $i<strlen($str); $i++){
			if($count>=$position && $startPos>$i){
				$startPos = $i;
				$startByte = $count;
			}
			if(($count-$startByte) >= $length) {
				$endPos = $i;
				break;
			}
			$value = ord($str[$i]);
			if($value > 127){
				$count++;
				if($value>=192 && $value<=223) $i++;
				elseif($value>=224 && $value<=239) $i = $i + 2;
				elseif($value>=240 && $value<=247) $i = $i + 3;
				else return self::raiseError("\"$str\" Not a UTF-8 compatible string", 0, __CLASS__, __METHOD__, __FILE__, __LINE__);
			}
			$count++;

		}
		if($type==1 && ($endPos-6)>$length){
			return substr($str, $startPos, $endPos-$startPos)."...";
		}else{
			return substr($str, $startPos, $endPos-$startPos);
		}

	}
	//文件夹创建
	function folder($fileurl){
		$luj =  explode("/",$fileurl);
		array_pop($luj);
		foreach($luj as $pic){
			$str.=$pic."/";
			if(!is_dir("./".$str))  mkdir("./".$str);
		}
	}

	//截取网页文字，去除标签，
	/** 
		@$string 待截取的字符串； 
		@num 截取的长度；
		@patten 截取模式；
	**/
	function  stripstr($string,$num,$patten=1){
		$str = '';
		if(!$string) return $str ;
		if($patten==1){
			$string = strip_tags($string);
			$str = mb_substr($string,0,$num,'utf-8');
			$str = preg_replace('/[(&nbsp;)\s]/','',$str);
		}else if($patten==2){
			$string = strip_tags($string);
			$str = substr($string,0,$num);
		}
		return $str;
	}
    
    /**
     * 判断是否是超级管理员
     *
     */
    static function isAdministrator()
    {
        if(Yii::$app->session['role_id']==1)
        {
            return true;
        } else {
            return false;
        }        
    }
    
}

?>