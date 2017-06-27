 //(1)定义表单验证的函数
function checkForm()
{
    //定义用户名、密码正则表达式
    var pattern = /^[a-z0-9]{5,15}$/;
    if(!pattern.test(document.form1.username.value))
    {
        window.alert("用户名称没有填写或格式不正确！");
        document.form1.username.focus();
        return false;
    }else if(!pattern.test(document.form1.password.value))
    {
        alert("用户密码没有填写或格式不正确！");
        document.form1.password.focus();
        return false;
    }else if(document.form1.verify.value.length!=4)
    {
        window.alert("验证码没有填写或长度不够！");
        document.form1.verify.focus();
        return false;
    }
}
//(2)获取验证码
function getCaptcha(imgObj)
{
    imgObj.src = "?c=User&a=captcha&"+Math.random();
}