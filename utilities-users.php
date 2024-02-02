<?php //********************BTIC Sales & Payroll System v15.24.0202.1730********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin')
{ redirect_home(); }
$table='users';
$_SESSION['formtype']=$table;
$_SESSION['HTTP_REFERER']='utilities-users.php';
$colwidth=array();
$thname=array('Action','#','User ID','User Type','Last Name','First Name','User Name','Password','Security Question','Answer');
$colname=array();
$component='select';
$title=' - System User Details';
$tab=array('utilities-users.php'=>'Users');
html_start($title,$tab);

$form='System User Details Form';
$new='utilities-users.php';
form_start($form,$new);

$id=$_POST['id'];

$name='id';
$value=$id;
input_hidden($name,$value);
$colname[]=$name;

$colname[]='id';

?>
<div class="form-group">
    <label for="usertype">User Type</label>
    <select class="form-control" id="usertype" name="usertype" required autofocus>
    <?php
    if($_POST['usertype']!='btic_admin' && $_POST['usertype']!='btic_payroll' && $_POST['usertype']!='btic_sales')
    { $selected1='selected'; }
    else if($_POST['usertype']=='btic_admin')
    { $selected2='selected'; }
    else if($_POST['usertype']=='btic_payroll')
    { $selected3='selected'; }
    else if($_POST['usertype']=='btic_sales')
    { $selected4='selected'; }
    else
    {
        $selected1=NULL;
        $selected2=NULL;
        $selected3=NULL;
        $selected4=NULL;
    }
    ?>
        <option value="" disabled <?=$selected1;?>>--required-- (select an option)</option>
        <option value="btic_admin" <?=$selected2;?>>ADMIN</option>
        <option value="btic_payroll" <?=$selected3;?>>PAYROLL</option>
        <option value="btic_sales" <?=$selected4;?>>SALES</option>
    </select>
</div>
<?php
$colname[]='usertype';

$label='Last Name';
$name='lastname';
$maxlength='80';
$placeholder='--required-- (maxlength: 80 characters)';
$attribute='required';
$value=validate($_POST[$name]);
input_text($label,$name,$maxlength,$placeholder,$attribute,$value);
$colname[]=$name;

$label='First Name';
$name='firstname';
$maxlength='80';
$placeholder='--required-- (maxlength: 80 characters)';
$attribute='required';
$value=validate($_POST[$name]);
input_text($label,$name,$maxlength,$placeholder,$attribute,$value);
$colname[]=$name;

$label='User Name';
$name='username';
$maxlength='80';
$placeholder='--required-- (maxlength: 80 characters)';
$attribute='required';
$value=validate($_POST[$name]);
input_text($label,$name,$maxlength,$placeholder,$attribute,$value);
$colname[]=$name;

$label='Password';
$name='password';
$maxlength='80';
$placeholder='--required-- (maxlength: 80 characters)';
$attribute='required';
$value=validate($_POST[$name]);
input_password($label,$name,$maxlength,$placeholder,$attribute,$value);
$colname[]=$name;

$label='Security Question';
$name='securityquestion';
$maxlength='200';
$placeholder='--required-- (maxlength: 200 characters)';
$attribute='required';
$value=validate($_POST[$name]);
input_textarea($label,$name,$maxlength,$placeholder,$attribute,$value);
$colname[]=$name;

$label='Answer';
$name='answer';
$maxlength='80';
$placeholder='--required-- (maxlength: 80 characters)';
$attribute='required';
$value=validate($_POST[$name]);
input_password($label,$name,$maxlength,$placeholder,$attribute,$value);
$colname[]=$name;

form_button_group($id);
form_end();

$usertype=$_POST['usertype'];
$lastname=ucwords(validate($_POST['lastname']));
$firstname=ucwords(validate($_POST['firstname']));
$username=strtolower(validate($_POST['username']));
$password=strtolower(validate($_POST['password']));
$securityquestion=ucfirst(validate($_POST['securityquestion']));
$answer=strtolower(validate($_POST['answer']));

$select="SELECT * FROM ".$table." ORDER BY usertype ASC, lastname ASC";
$insert="INSERT INTO ".$table." VALUES (DEFAULT,'".$usertype."','".$lastname."','".$firstname."','".$username."','".$password."','".$securityquestion."','".$answer."')";
$update="UPDATE ".$table." SET usertype='".$usertype."',lastname='".$lastname."',firstname='".$firstname."',username='".$username."',password='".$password."',securityquestion='".$securityquestion."',answer='".$answer."' WHERE id='".$id."'";
$delete="DELETE FROM ".$table." WHERE id='$id'";
sql_execute_query($new,$select,$id,$insert,$update,$delete,$table,$colwidth,$thname,$colname,$component);
html_end();
?>