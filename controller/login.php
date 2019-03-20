<?php
if(isset($_POST['sub']))
{
    $username=trim($_POST['username']);
    $password=$_POST['password'];
    echo $username."<br />".$password;
//     if($username&&$password)
//     {
//         $sql="select * from roleinfo where Role_ID='$username' and Password='$password'";
//         $result=mysql_query($sql);
//         $row=mysql_num_rows($result);
//         if($row)
//         {
//             echo "<script language=javascript>alert('登录成功！');location.href='Frame.php';</script>";
//             //header('location:../guorun/main.php');
//         }
//         else
//         {
//             echo "<script language=javascript>alert('用户名或密码填写错误！');history.back();</script>";
//         }
        
//     }
//     else
//     {
//         echo "<script language=javascript>alert('用户名或密码不能为空！');history.back();</script>";
//     }
}