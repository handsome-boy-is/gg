
//显示/隐藏表单盒子
function show_form(type_val){
	console.log(getCookie("user_login_status"));
	if(getCookie("user_login_status")==1 && type_val!="none"){
		alert('你已经登录！');
	}else{

		//显示表单的盒子
		document.getElementById("login_box").style.display=type_val;
		//显示阴影盒子
		document.getElementById("shadown_box").style.display=type_val;
	}
 

				
}
function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	return unescape(arr[2]);
	else
	return null;
}
//onmouseover 是鼠标滑倒该元素时触发

function bodyScroll(event){
    event.preventDefault();
}

var offset_left;
var down_param_clientX;

var offset_top;
var down_param_clientY;

document.getElementById("login_box").onmousedown=function(down_param){
	
	//添加事件的方法一
	//this.onmousemove=function (move_param){
	//		this.style.left=(move_param.clientX-50)+"px";
	//		
	//}
	 
	 //移动关键点:定义初始值（offset_left：表单左边框离浏览器最左边的距离，down_param_clientX：鼠标点击一刻X轴的位置即clientX ）
	offset_left=this.offsetLeft;
	down_param_clientX=down_param.clientX;
	
	 //移动关键点:定义初始值（offset_top：表单上边框离浏览器最顶端的距离，down_param_clientY：鼠标点击一刻Y轴的位置即clientY ）
	offset_top=this.offsetTop;
	down_param_clientY=down_param.clientY;
	
	//addEventListener 给对象添加一个事件，第一个参数：事件的类型（不需要On），第二个参数就是事件要处理的逻辑方法
	this.addEventListener("mousemove",move_do_thing);
	
	this.onmouseup=function(move_param){
		//removeEventListener
		this.removeEventListener("mousemove",move_do_thing);
	
	//removeEvents(this,"mousemove",move_hs); 
	}
}

//鼠标移动时候的事件方法
function move_do_thing(move_param){
	//move_param.clientX 这个是移动时候的x距离
	//offsetLeft：432是当前登录盒子最左边和浏览器最左边的记录
	
	 var move_val = move_param.clientX -down_param_clientX;
	
	 var move_val_y = move_param.clientY -down_param_clientY;
	 
	//console.log(move_param.clientX-this.offsetLeft);
	var leftPx_val=offset_left+move_val;
 
	if(leftPx_val>=0 && leftPx_val<=document.body.offsetWidth-this.clientWidth){
		this.style.left=leftPx_val+"px";
	} 
	
	var topPx_val=offset_top+move_val_y;
	if(topPx_val>=0 && topPx_val<=document.body.clientHeight-this.clientHeight){
		this.style.top=topPx_val+"px";
	}
	
	 console.log(document.body.clientHeight); 
}

//function removeEvents(target, type, func){ 
// 
//    if (target.removeEventListener)  
//        target.removeEventListener(type, func);  
//    else if (target.detachEvent)  
//        target.detachEvent("on" + type, func);  
//    else target["on" + type] = null;  
//}




















//获取手机号码输入框
var input_element=document.getElementById("tel_phone");

//获取密码输入框
var pwd_inp_element=document.getElementById("password");

//获取用户名输入框
var name_inp_element=document.getElementById("name");

//在手机号码有输入值的时候触发
input_element.oninput=function(){
	check_form_input(this,'tel');
};

//在密码输入框，输入值的时候触发
pwd_inp_element.oninput=function(){
	check_form_input(this,"pwd");
}

//在姓名输入框，输入值的时候触
name_inp_element.oninput=function(){
	 
	check_form_input(this,"name");
}
 

//校验所有的input输入框是否合法
//如果不符合规范在父节点的上一个相邻节点进行提示，如果符合规范则隐藏提示信息
function check_form_input(input_name,check_type){
	
	
	//提示框的父节点
	var tip_parent_element=input_name.parentNode.previousElementSibling;
		
	 var zhengze;	
	 if(check_type=='pwd'){
		 	//定义校验密码的正则：必须>=6位，并且<=18位
		   zhengze=new RegExp(/^\w{6,18}$/);
	 }else if(check_type=='tel'){
		  zhengze=new RegExp(/^1[3578]\d{9}$/);
		
	 }else if(check_type=='name'){
		  zhengze=new RegExp(/^[\u4e00-\u9fa5]+$/);
		
	 }
		
	//通过匹配手机号码的正则来做提示
	if(zhengze.test(input_name.value)==false){//手机格式不正确才进来的
		//在手机号码区域的最右边显示错误提示
		
		
		if(tip_parent_element.childElementCount==0){//是没有span提示则创建一个新的
			//创建一个新的span
			var new_span_element=document.createElement("span");
			 
			//获取提示信息
			new_span_element.innerHTML=get_tips_html(check_type);
			
			//是在提示框的父节点的最后面添加新的标签
			tip_parent_element.appendChild(new_span_element);
		}else{
			//获取提示信息 
			tip_parent_element.children[0].innerHTML=get_tips_html(check_type);
			
			tip_parent_element.children[0].style.display="block";
		}
		//focus，让手机号码的输入框节点对焦
		input_name.focus();
		return false;
		
	}else{
		if(tip_parent_element.childElementCount==1){
			tip_parent_element.children[0].style.display="none";
		}
		
		return true;
	}
	
	
}

 

 
function get_tips_html(check_type){
	var tip_str;
	if(check_type=='pwd'){
		 tip_str="密码长度必须大于5位,并且小于19位！";
		
	}else if(check_type=='name'){
		 tip_str="只能输入中文！";
		
	}else{
		 tip_str="手机号码长度必须是11位！";
				
		if(input_element.value.length==11){
			tip_str="手机格式不正确！必须以1开头，第二位必须是3、5、7、8。";
		}
		
	}
	return "<b style='color:red;float:right;font-size:12px;'>"+tip_str+"</b>";
	
	
}

/*
* 检查表单
*用户提交表单时，调用的函数
*
*/
function check_form(){
	//调用校验手机号码是否符合规范的函数
	//符合就返回:true
	//不符合就返回:false
	var is_commit;
	//&& 所有的都是true，结果就是true
	//&& 只要有一个是false，结果就是false
	
	is_commit=check_form_input(name_inp_element,"name") && check_form_input(input_element,'tel') && check_form_input(pwd_inp_element,"pwd");
	 

	ajax_form_login();

	
	//是返回ture或者false
	return false;
}



 function ajax_form_login () {
             // 第一个参数：待载入页面的URL地址
            // 第二个参数：待发送 Key/value 参数。
            // 第三个参数：回调函数

            var user_name=input_element.value;
            var user_pwd=pwd_inp_element.value;

            var request_data={"user_name":user_name,"user_pwd":user_pwd};

              jQuery.get("login_action_cookie.php",request_data,function (retrun_data){
                //         如果有该用户就返回1、如果没有则返回0
                console.log(retrun_data);//Object { status: 1, msg: "登录成功" }
                // 1：登录成功
                // 0：失败
                if (retrun_data.status==1) {
                   console.log(retrun_data.msg);
                   show_form("none");
                }else{
                   document.getElementById("button_box").innerHTML=retrun_data.msg+document.getElementById("button_box").innerHTML;
                   console.log(retrun_data.msg);
                }
                 
              },"json");
      }