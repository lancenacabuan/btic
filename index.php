<?php //********************BTIC Sales & Payroll System v15.25.0506.0900********************//
include('functions.php');
$_SESSION['formtype']=NULL;
$_SESSION['HTTP_REFERER']='index.php';

if($_GET['forgot']=='password')
{
    $title=NULL;
    $tab=array();
    html_start($title,$tab);
    $action='action="index.php"';
    form_login_start($action);

    $label='Username';
    $name='username';
    $maxlength='20';
    $placeholder='Please enter your username.';
    $attribute='required autofocus style="text-align: center;"';
    $value=validate($_POST[$name]);
    input_text($label,$name,$maxlength,$placeholder,$attribute,$value);

    $index=array('btnConfirm','CONFIRM','index-logout.php','Back to Log-in Page');
    form_login_end($index);
    html_end();
}
else
{
    if(isset($_POST['btnConfirm']))
    {
        $username=validate($_POST['username']);
        $content=mysql_query("SELECT * FROM users WHERE username='$username'");
        $rows=mysql_fetch_array($content);

        if(mysql_affected_rows()>0)
        {
            $securityquestion=$rows['securityquestion'];
            $answer=$rows['answer'];

            $title=NULL;
            $tab=array();
            html_start($title,$tab);
            $action='action="index.php"';
            form_login_start($action);

            input_hidden('username',$_POST['username']);

            $label='Security Question';
            $name='securityquestion';
            $maxlength='60';
            $placeholder='Security Question';
            $attribute='readonly style="text-align: center; background-color: transparent; border: none;"';
            $value=$securityquestion;
            input_text($label,$name,$maxlength,$placeholder,$attribute,$value);

            $label='Answer';
            $name='answer';
            $maxlength='40';
            $placeholder='Please enter your answer.';
            $attribute='required autofocus style="text-align: center;"';
            $value=validate($_POST[$name]);
            input_password($label,$name,$maxlength,$placeholder,$attribute,$value);

            $index=array('btnSubmit','SUBMIT','index-logout.php','Back to Log-in Page');
            form_login_end($index);
            html_end();
        }

        else
        {
            $info='ERROR: Username does not exist!!!';
            alert($info);
            redirect_page();
        }    
    }
    
    if($_POST['securityquestion']!=NULL && $_POST['answer']!=NULL)
    {
        $username=$_POST['username'];
        $securityquestion=validate($_POST['securityquestion']);
        $answer=validate($_POST['answer']);
        $content=mysql_query("SELECT * FROM users WHERE username='$username' AND securityquestion='$securityquestion' AND answer='$answer'");
        $rows=mysql_fetch_array($content);

        if(mysql_affected_rows()>0)
        {
            $_SESSION['username']=$rows['username'];
            php_security();

            $usertype=$rows['usertype'];
            $lastname=$rows['lastname'];
            $firstname=$rows['firstname'];
            $fullname=$firstname." ".$lastname;

            $_SESSION['usertype']=$usertype;
            $_SESSION['lastname']=$lastname;
            $_SESSION['firstname']=$firstname;
            $_SESSION['fullname']=$fullname;

            $title=' - Welcome';
            $tab=array('#'=>'Welcome');
            html_start($title,$tab);
            welcome($fullname);
            html_end();
        }
        else
        {
            $info='ERROR: Invalid answer for security question!!!';
            alert($info);
            redirect_page();
        }
    }
    else
    {
        if(isset($_POST['btnSubmit']))
        {
            $username=validate($_POST['username']);
            $password=validate($_POST['password']);
            $content=mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password'");
            $rows=mysql_fetch_array($content);

            if(mysql_affected_rows()>0)
            {
                $directory='C:/dbBackup';
                if(!is_dir($directory))
                { mkdir($directory); }

                $_SESSION['username']=$rows['username'];
                php_security();

                $usertype=$rows['usertype'];
                $lastname=$rows['lastname'];
                $firstname=$rows['firstname'];
                $fullname=$firstname." ".$lastname;

                $_SESSION['usertype']=$usertype;
                $_SESSION['lastname']=$lastname;
                $_SESSION['firstname']=$firstname;
                $_SESSION['fullname']=$fullname;

                $title=' - Welcome';
                $tab=array('#'=>'Welcome');
                html_start($title,$tab);
                welcome($_SESSION['fullname']);
                html_end();
                backup();
                reload_page();
            }
            else
            {
                $info='ERROR: Invalid username and password combination!!!';
                alert($info);
                redirect_page();
            }
        }
        if($_SESSION['username']==NULL)
        {
            $title=NULL;
            $tab=array();
            html_start($title,$tab);
            $action='action="index.php"';
            form_login_start($action);

            $label='Username';
            $name='username';
            $maxlength='20';
            $placeholder='Please enter your username.';
            $attribute='required autofocus style="text-align: center;"';
            $value=validate($_POST[$name]);
            input_text($label,$name,$maxlength,$placeholder,$attribute,$value);

            $label='Password';
            $name='password';
            $maxlength='20';
            $placeholder='Please enter your password.';
            $attribute='required style="text-align: center;"';
            $value=validate($_POST[$name]);
            input_password($label,$name,$maxlength,$placeholder,$attribute,$value);

            $index=array('btnSubmit','LOGIN','index.php','Forgot Password?');
            form_login_end($index);
            html_end();
        }
        else
        {
            $title=' - Welcome';
            $tab=array('#'=>'Welcome');
            html_start($title,$tab);
            welcome($_SESSION['fullname']);
            html_end();
        }
    }
}
?>