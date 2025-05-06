<?php //********************BTIC Sales & Payroll System v15.24.0506.0855********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin' && $_SESSION['usertype']!='btic_sales')
{ redirect_home(); }
$table='accounts';
$_SESSION['formtype']=$table;
$_SESSION['HTTP_REFERER']='maintenance-accounts.php';
$colwidth=array('10%','10%','60%','20%');
$thname=array('Action','#','Account ID','Account Name','Account Type');
$colname=array();
$component='select';
$title=' - Customer Account Details';
$tab=array('maintenance-accounts.php'=>'Accounts');
html_start($title,$tab);

$form='Customer Account Details Form';
$new='maintenance-accounts.php';
form_start($form,$new);

$id=$_POST['id'];

$name='id';
$value=$id;
input_hidden($name,$value);
$colname[]=$name;

$colname[]='id';

$label='Account Name';
$name='customer';
$maxlength='80';
$placeholder='--required-- (maxlength: 80 characters)';
$attribute='required autofocus';
$value=validate($_POST[$name]);
input_text($label,$name,$maxlength,$placeholder,$attribute,$value);
$colname[]=$name;

?>
<div class="form-group">
    <label for="customertype">Account Type</label>
    <select class="form-control" id="customertype" name="customertype" required>
    <?php
    if($_POST['customertype']!='SUPERMARKET' && $_POST['customertype']!='PERSONAL')
    { $selected1='selected'; }
    else if($_POST['customertype']=='SUPERMARKET')
    { $selected2='selected'; }
    else if($_POST['customertype']=='PERSONAL')
    { $selected3='selected'; }
    else
    {
        $selected1=NULL;
        $selected2=NULL;
        $selected3=NULL;
    }
    ?>
        <option value="" disabled <?=$selected1;?>>--required-- (select an option)</option>
        <option value="SUPERMARKET" <?=$selected2;?>>SUPERMARKET</option>
        <option value="PERSONAL" <?=$selected3;?>>PERSONAL</option>
    </select>
</div>
<?php
$colname[]='customertype';

form_button_group($id);
form_end();
?>
<br />
<center>
<div id="toggle-subform" class="panel panel-default" style="width: 500px;">
    <div style="font-size: 20px;" class="panel-heading"><strong>Change Existing Records</strong></div>
<br />
<form method="post">
<div class="form-group">
<label>Change [Customer Account Name] from:</label><br />
<select style="width: 450px;" class="chosen-select" id="changefrom1" name="changefrom1" data-placeholder="[Please select Customer Account Name to be changed...]">
<option></option>
<?php
if($array==NULL)
{
    $content=mysql_query('SELECT * FROM accounts ORDER BY customer ASC');
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $value=$rows['customer'];
        ?>
        <option title="<?php echo($value);?>"><?php echo($value);?></option>
    <?php
    }
}
else
{
    $total=count($array);
    for($x=0; $x<$total; $x++)
    {
    ?>
        <option><?php echo($array[$x]);?></option>
    <?php
    }
}
?>
</select>
<br />
<label>-----OR-----</label>
<br />
<label>Change [Customer Account Name] from:</label>
<input style="text-align: center;" class="form-control" type="text" id="changefrom2" name="changefrom2" placeholder="[Please type Customer Account Name to be changed...]">
<br />
<br />
<label>Change [Customer Account Name] into:</label>
<input style="text-align: center;" class="form-control" type="text" name="changeinto" placeholder="[Please type new Customer Account Name to be saved...]">
</div>
<input style="width: 450px;" class="btn btn-primary" type="submit" name="btnChange" value="CONFIRM RECORD CHANGE">
<br />
<br />
</form>
</div>
</center>
<?php
if(isset($_POST['btnChange']))
{
    if($_POST['changefrom1']!=NULL && $_POST['changefrom2']==NULL)
    { $changefrom=ucwords(validate($_POST['changefrom1'])); }
    else if($_POST['changefrom1']==NULL && $_POST['changefrom2']!=NULL)
    { $changefrom=ucwords(validate($_POST['changefrom2'])); }
    else
    {
        alert('ERROR: Invalid input!!!');
        reload_page();
        die();
    }
    $content=mysql_query("SELECT * FROM accounts");
    $total=mysql_affected_rows();
    for($a=0; $a<$total; $a++)
    {
        $rows=mysql_fetch_array($content);
        $id=$rows['id'];
        $customer=$rows['customer'];
        $string1=$changefrom;
        if(strpos($customer,$string1)!==false)
        {
            $string2=validate($_POST['changeinto']);
            $customer2=ucwords(str_replace($string1,$string2,$customer));
            mysql_query("UPDATE accounts SET customer='$customer2' WHERE id='$id'");
            $alert1=$alert1+mysql_affected_rows();
        }
    }
    $alert1=number_format($alert1);
    alert('UPDATED '.$alert1.' RECORDS IN ACCOUNTS!!!');

    $content=mysql_query("SELECT * FROM receivables");
    $total=mysql_affected_rows();
    for($a=0; $a<$total; $a++)
    {
        $rows=mysql_fetch_array($content);
        $id=$rows['id'];
        $customer=$rows['customer'];
        $string1=$changefrom;
        if(strpos($customer,$string1)!==false)
        {
            $string2=validate($_POST['changeinto']);
            $customer2=ucwords(str_replace($string1,$string2,$customer));
            mysql_query("UPDATE receivables SET customer='$customer2' WHERE id='$id'");
            $alert2=$alert2+mysql_affected_rows();
        }
    }
    $alert2=number_format($alert2);
    alert('UPDATED '.$alert2.' RECORDS IN RECEIVABLES!!!');

    $content=mysql_query("SELECT * FROM collections");
    $total=mysql_affected_rows();
    for($a=0; $a<$total; $a++)
    {
        $rows=mysql_fetch_array($content);
        $id=$rows['id'];
        $customer=$rows['customer'];
        $string1=$changefrom;
        if(strpos($customer,$string1)!==false)
        {
            $string2=validate($_POST['changeinto']);
            $customer2=ucwords(str_replace($string1,$string2,$customer));
            mysql_query("UPDATE collections SET customer='$customer2' WHERE id='$id'");
            $alert3=$alert3+mysql_affected_rows();
        }
    }
    $alert3=number_format($alert3);
    alert('UPDATED '.$alert3.' RECORDS IN COLLECTIONS!!!');

    $content=mysql_query("SELECT * FROM returns");
    $total=mysql_affected_rows();
    for($a=0; $a<$total; $a++)
    {
        $rows=mysql_fetch_array($content);
        $id=$rows['id'];
        $customer=$rows['customer'];
        $string1=$changefrom;
        if(strpos($customer,$string1)!==false)
        {
            $string2=validate($_POST['changeinto']);
            $customer2=ucwords(str_replace($string1,$string2,$customer));
            mysql_query("UPDATE returns SET customer='$customer2' WHERE id='$id'");
            $alert5=$alert5+mysql_affected_rows();
        }
    }
    $alert5=number_format($alert5);
    alert('UPDATED '.$alert5.' RECORDS IN RETURNS!!!');
    reload_page();
}

$customer=ucwords(validate($_POST['customer']));
$customertype=$_POST['customertype'];

$select="SELECT * FROM ".$table." ORDER BY customertype DESC, customer ASC";
$insert="INSERT INTO ".$table." VALUES (DEFAULT,'".$customer."','".$customertype."')";
$update="UPDATE ".$table." SET customer='".$customer."',customertype='".$customertype."' WHERE id='".$id."'";
$delete="DELETE FROM ".$table." WHERE id='$id'";
sql_execute_query($new,$select,$id,$insert,$update,$delete,$table,$colwidth,$thname,$colname,$component);
html_end();
?>