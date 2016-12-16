<?

	session_start();
	
	$content=rand(1000,9999);
	$_SESSION['code']=$content;
	$w=120;
	$h=38;
	
	//创建画表
	$im=imagecreate($w,$h);
	
	//设置画表的颜色，待用
	$grey=imagecolorallocate($im,200,200,200);
	$white=imagecolorallocate($im,255,255,255);
	$black=imagecolorallocate($im,0,0,0);
	
	//填充背景
	imagefill($im,0,0,$grey);
	
	//设置内容
	imagestring($im,16,30,5,$content,$black);
	
	//干扰线
	$style=array($black,$black,$black,$black,$black,$grey,$grey,$grey,$grey,$grey);
	imagesetstyle($im,$style);
	$y1= rand(0,$h);
	$y2= rand(0,$h);
	$y3= rand(0,$h);
	$y4= rand(0,$h);
	imageline($im,0,$y1,$w,$y3,IMG_COLOR_STYLED);
	imageline($im,0,$y2,$w,$y4,IMG_COLOR_STYLED);
	
	
	
	//随机生成大量黑点，起干扰作用
	for($i = 0 ; $i <80 ; $i++){
		imagesetpixel($im,rand(0,$w),rand(0,$h),$black);
		};
		
	//输出图标
	imagepng($im);
	
	//释放使用
	imagedestroy($im);

?>