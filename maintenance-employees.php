<?php //********************BTIC Invoicing & Payroll System v15.22.0831.1140********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin' && $_SESSION['usertype']!='btic_payroll')
{ redirect_page(); }
if(isset($_POST['btnVisibility']))
{
    if($_SESSION['visibility']=='hidden')
    {
        $_SESSION['visibility']=NULL;
        alert('RECORD VISIBILITY: Showing only CURRENT record/s.');
    }
    else
    {
        $_SESSION['visibility']='hidden';
        alert('RECORD VISIBILITY: Showing only HIDDEN record/s.');
    }
    reload_page();
}
$table='employees';
$_SESSION['formtype']=$table;
$_SESSION['HTTP_REFERER']='maintenance-employees.php';
$colwidth=array();
$thname=array('Action','#','Employee ID','Employee #','Last Name','First Name','Employee Type','Rate','S.S.S. SL','S.S.S. CL','H.D.M.F. STL','H.D.M.F. CL','Total Vacation');
$colname=array();
$component='select';
$title=' - Employee Account Details';
$tab=array('maintenance-employees.php'=>'Employees');
html_start($title,$tab);
btn_visibility();
  
if($_SESSION['updateall']==NULL)
{
?>
    <form method="post" role="form" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <button class="btn btn-primary" type="submit" name="btnUpdateAll" style="position: fixed; top: 105px; left: 145px; right: 0px; z-index: 1000; box-shadow: 5px 5px 5px grey; width: 150px;">UPDATE ALL</button>
    </form>
    <?php
    $form='Employee Account Details Form';
    $new='maintenance-employees.php';

    form_start($form,$new);
    ?>
    <input type="hidden" name="employeenumber1" value="<?=$_POST['employeenumber'];?>"/>
    <?php
    $employeenumber1=$_POST['employeenumber1'];
    $id=$_POST['id'];

    $name='id';
    $value=$id;
    input_hidden($name,$value);
    $colname[]=$name;

    $colname[]='id';

    $label='Employee Number';
    $name='employeenumber';
    $maxlength='10';
    $placeholder='--required-- (maxlength: 10 characters)';
    $attribute='required autofocus';
    $value=validate($_POST[$name]);
    input_text($label,$name,$maxlength,$placeholder,$attribute,$value);
    $colname[]=$name;

    $label='Last Name';
    $name='lastname';
    $maxlength='40';
    $placeholder='--required-- (maxlength: 40 characters)';
    $attribute='required';
    $value=validate($_POST[$name]);
    input_text($label,$name,$maxlength,$placeholder,$attribute,$value);
    $colname[]=$name;

    $label='First Name';
    $name='firstname';
    $maxlength='40';
    $placeholder='--required-- (maxlength: 40 characters)';
    $attribute='required';
    $value=validate($_POST[$name]);
    input_text($label,$name,$maxlength,$placeholder,$attribute,$value);
    $colname[]=$name;

    ?>
    <div class="form-group">
        <label for="employeetype">Employee Type</label>
        <select class="form-control" id="employeetype" name="employeetype" required>
        <?php
        if($_POST['employeetype']!='CONTRACTUAL' && $_POST['employeetype']!='OFFICE' && $_POST['employeetype']!='PRODUCTION' && $_POST['employeetype']!='PROVINCIAL' && $_POST['employeetype']!='STORE' && $_POST['employeetype']!='SUPERMARKET')
        { $selected1='selected'; }
        else if($_POST['employeetype']=='CONTRACTUAL')
        { $selected2='selected'; }
        else if($_POST['employeetype']=='OFFICE')
        { $selected3='selected'; }
        else if($_POST['employeetype']=='PRODUCTION')
        { $selected4='selected'; }
        else if($_POST['employeetype']=='PROVINCIAL')
        { $selected5='selected'; }
        else if($_POST['employeetype']=='STORE')
        { $selected6='selected'; }
        else if($_POST['employeetype']=='SUPERMARKET')
        { $selected7='selected'; }
        else
        {
            $selected1=NULL;
            $selected2=NULL;
            $selected3=NULL;
            $selected4=NULL;
            $selected5=NULL;
            $selected6=NULL;
            $selected7=NULL;
        }
        ?>
            <option value="" disabled <?=$selected1;?>>--required-- (select an option)</option>
            <option value="CONTRACTUAL" <?=$selected2;?>>CONTRACTUAL</option>
            <option value="OFFICE" <?=$selected3;?>>OFFICE</option>
            <option value="PRODUCTION" <?=$selected4;?>>PRODUCTION</option>
            <option value="PROVINCIAL" <?=$selected5;?>>PROVINCIAL</option>
            <option value="STORE" <?=$selected6;?>>STORE</option>
            <option value="SUPERMARKET" <?=$selected7;?>>SUPERMARKET</option>
        </select>
    </div>
    <?php
    $colname[]='employeetype';

    $label='Rate';
    $name='rate';
    $min='0';
    $max=NULL;
    $step='0.01';
    $placeholder='--required--';
    $attribute='required';
    $value=str_replace(',','',validate($_POST[$name]));
    input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);
    $colname[]=$name;

    $label='S.S.S. SL';
    $name='sssloan';
    $min='0';
    $max=NULL;
    $step='0.01';
    $placeholder='--optional--';
    $attribute=NULL;
    $value=str_replace(',','',validate($_POST[$name]));
    input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);
    $colname[]=$name;
 
    $label='S.S.S. CL';
    $name='sssloan2';
    $min='0';
    $max=NULL;
    $step='0.01';
    $placeholder='--optional--';
    $attribute=NULL;
    $value=str_replace(',','',validate($_POST[$name]));
    input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);
    $colname[]=$name;

    $label='H.D.M.F STL';
    $name='hdmfloan';
    $min='0';
    $max=NULL;
    $step='0.01';
    $placeholder='--optional--';
    $attribute=NULL;
    $value=str_replace(',','',validate($_POST[$name]));
    input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);
    $colname[]=$name;
 
    $label='H.D.M.F CL';
    $name='hdmfloan2';
    $min='0';
    $max=NULL;
    $step='0.01';
    $placeholder='--optional--';
    $attribute=NULL;
    $value=str_replace(',','',validate($_POST[$name]));
    input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);
    $colname[]=$name;

    $label='Total Vacation';
    $name='totalvacation';
    $min='0';
    $max='12';
    $step='1';
    $placeholder='--optional--';
    $attribute=NULL;
    $value=validate($_POST[$name]);
    input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);
    $colname[]=$name;

    form_button_group($id);
    form_end();

    $employeenumber=strtoupper(validate($_POST['employeenumber']));
    $lastname=strtoupper(validate($_POST['lastname']));
    $firstname=strtoupper(validate($_POST['firstname']));
    $fullname=$lastname.', '.$firstname;
    $employeetype=$_POST['employeetype'];
    $rate=number_format(str_replace(',','',validate($_POST['rate'])),2);
    $sssloan=number_format(str_replace(',','',validate($_POST['sssloan'])),2);
    $sssloan2=number_format(str_replace(',','',validate($_POST['sssloan2'])),2);
    $hdmfloan=number_format(str_replace(',','',validate($_POST['hdmfloan'])),2);
    $hdmfloan2=number_format(str_replace(',','',validate($_POST['hdmfloan2'])),2);
    $totalvacation=number_format(validate($_POST['totalvacation']),2);
    $status=NULL;


    if($_SESSION['visibility']=='hidden')
    { $where1=" WHERE status='hidden' "; }
    else
    { $where1=" WHERE NOT status='hidden' "; }

    if(isset($_POST['btnUpdateAll']))
    {
        if($_SESSION['updateall']!='enabled')
        {
            $_SESSION['updateall']='enabled';
            reload_page();
        }
    }

    $select="SELECT * FROM ".$table."".$where1."ORDER BY employeetype ASC, lastname ASC";
    $insert="INSERT INTO ".$table." VALUES (DEFAULT,'".$employeenumber."','".$lastname."','".$firstname."','".$employeetype."','".$rate."','".$sssloan."','".$sssloan2."','".$hdmfloan."','".$hdmfloan2."','".$totalvacation."','".$status."')";
    $update="UPDATE ".$table." SET employeenumber='".$employeenumber."',lastname='".$lastname."',firstname='".$firstname."',employeetype='".$employeetype."',rate='".$rate."',sssloan='".$sssloan."',sssloan2='".$sssloan2."',hdmfloan='".$hdmfloan."',hdmfloan2='".$hdmfloan2."',totalvacation='".$totalvacation."' WHERE id='".$id."'";
    $delete="DELETE FROM ".$table." WHERE id='$id'";
    $_SESSION['query']="UPDATE payroll SET employeenumber='".$employeenumber."',fullname='".$fullname."',employeetype='".$employeetype."' WHERE employeenumber='".$employeenumber1."'";
    sql_execute_query($new,$select,$id,$insert,$update,$delete,$table,$colwidth,$thname,$colname,$component);
}
else
{
    if($_SESSION['visibility']=='hidden')
    { $where=" WHERE status='hidden' "; }
    else
    { $where=" WHERE NOT status='hidden' "; }
    ?>
    <form method="post" role="form" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <button class="btn btn-primary" type="submit" name="btnBack" style="position: fixed; top: 105px; left: 145px; right: 0px; z-index: 1200; box-shadow: 5px 5px 5px grey; width: 150px;">BACK</button>
    </form>
    <a href="maintenance-employees.php">
        <button id="new" type="button" data-toggle="tooltip" data-placement="right" title="Create new record.">+</button>
    </a>
    <div class="panel panel-default">
    <div class="panel-heading" style="font-size: 20px;">Employee Account Details Form</div>
    <form class="form-inline" method="post" role="form" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <br />
    <table id="employees_form" class="table-striped nowrap">
    <thead style="background-color: white;">
        <th>Employee Number</th>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Employee Type</th>
        <th>Rate</th>
        <th>S.S.S. SL</th>
        <th>S.S.S. CL</th>
        <th>H.D.M.F. STL</th>
        <th>H.D.M.F. CL</th>
        <th>Total Vacation</th>
    </thead>
    <tbody>
    <?php
    $content=mysql_query("SELECT * FROM employees".$where."ORDER BY employeetype ASC, lastname ASC");
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $id=$rows['id'];
        ?>
        <tr>
        <input name="id[]" type="hidden" value="<?=$id;?>">
        <td><input style="width: 70px;" class="form-control" name="employeenumber[]" type="text" maxlength="10" value="<?=validate($rows['employeenumber']);?>" required></td>
        <td><input style="width: 165px;" class="form-control" name="lastname[]" type="text" maxlength="40" value="<?=validate($rows['lastname']);?>" required></td>
        <td><input style="width: 165px;" class="form-control" name="firstname[]" type="text" maxlength="40" value="<?=validate($rows['firstname']);?>" required></td>
        <td>
        <select style="width: 160px;" class="form-control" name="employeetype[]" required>
        <?php
        if($rows['employeetype']!='CONTRACTUAL' && $rows['employeetype']!='OFFICE' && $rows['employeetype']!='PRODUCTION' && $rows['employeetype']!='PROVINCIAL' && $rows['employeetype']!='STORE' && $rows['employeetype']!='SUPERMARKET')
        { $selected1='selected'; }
        else if($rows['employeetype']=='CONTRACTUAL')
        { $selected2='selected'; }
        else if($rows['employeetype']=='OFFICE')
        { $selected3='selected'; }
        else if($rows['employeetype']=='PRODUCTION')
        { $selected4='selected'; }
        else if($rows['employeetype']=='PROVINCIAL')
        { $selected5='selected'; }
        else if($rows['employeetype']=='STORE')
        { $selected6='selected'; }
        else if($rows['employeetype']=='SUPERMARKET')
        { $selected7='selected'; }
        else
        {
            $selected1=NULL;
            $selected2=NULL;
            $selected3=NULL;
            $selected4=NULL;
            $selected5=NULL;
            $selected6=NULL;
            $selected7=NULL;
        }
        ?>
            <option value="" disabled <?=$selected1;?>>--required-- (select an option)</option>
            <option value="CONTRACTUAL" <?=$selected2;?>>CONTRACTUAL</option>
            <option value="OFFICE" <?=$selected3;?>>OFFICE</option>
            <option value="PRODUCTION" <?=$selected4;?>>PRODUCTION</option>
            <option value="PROVINCIAL" <?=$selected5;?>>PROVINCIAL</option>
            <option value="STORE" <?=$selected6;?>>STORE</option>
            <option value="SUPERMARKET" <?=$selected7;?>>SUPERMARKET</option>
        </select>
        </td>
        <td><input style="width: 100px;" class="form-control" name="rate[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['rate']);?>"></td>
        <td><input style="width: 100px;" class="form-control" name="sssloan[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['sssloan']);?>"></td>
        <td><input style="width: 100px;" class="form-control" name="sssloan2[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['sssloan2']);?>"></td>
        <td><input style="width: 100px;" class="form-control" name="hdmfloan[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['hdmfloan']);?>"></td>
        <td><input style="width: 100px;" class="form-control" name="hdmfloan2[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['hdmfloan2']);?>"></td>
        <td><input style="width: 75px;" class="form-control" name="totalvacation[]" type="number" min="0" step="1" value="<?=str_replace(',','',$rows['totalvacation']);?>"></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    </table>        
    <br />
    <input class="form-control btn btn-success" id="btnUpdate2" name="btnUpdate2" type="submit" value="UPDATE RECORD" onclick="return confirm('UPDATE: Do you really want to UPDATE this record?');" style="position: fixed; top: 105px; right: 240px; z-index: 1000; box-shadow: 5px 5px 5px grey; width: 150px;"/>
    </form>
    </div>
    <?php
    if(isset($_POST['btnBack']))
    {
        if($_SESSION['updateall']=='enabled')
        {
            $_SESSION['updateall']=NULL;
            reload_page();
        }
    }
    if(isset($_POST['btnUpdate2']))
    {
        if($_SESSION['visibility']=='hidden')
        { $filter1=" WHERE status='hidden' "; }
        else
        { $filter1=" WHERE NOT status='hidden' "; }
        $content1=mysql_query("SELECT * FROM employees".$filter1."ORDER BY employeetype ASC, lastname ASC");
        $total1=mysql_affected_rows();
        for($x1=0; $x1<=$total1-1; $x1++)
        {
            $rows1=mysql_fetch_array($content1);
            $employeenumber1=$rows1['employeenumber'];
            $id=$_POST['id'][$x1];
            $employeenumber=validate($_POST['employeenumber'][$x1]);
            $lastname=strtoupper(validate($_POST['lastname'][$x1]));
            $firstname=strtoupper(validate($_POST['firstname'][$x1]));
            $fullname=$lastname.', '.$firstname;
            $employeetype=strtoupper(validate($_POST['employeetype'][$x1]));
            $rate=number_format(str_replace(',','',validate($_POST['rate'][$x1])),2);
            $sssloan=number_format(str_replace(',','',validate($_POST['sssloan'][$x1])),2);
            $sssloan2=number_format(str_replace(',','',validate($_POST['sssloan2'][$x1])),2);
            $hdmfloan=number_format(str_replace(',','',validate($_POST['hdmfloan'][$x1])),2);
            $hdmfloan2=number_format(str_replace(',','',validate($_POST['hdmfloan2'][$x1])),2);
            $totalvacation=number_format(validate($_POST['totalvacation'][$x1]),2);
            
            if($employeenumber!=$rows1['employeenumber'] || $lastname!=$rows1['lastname'] || $firstname!=$rows1['firstname'] || $employeetype!=$rows1['employeetype'] || $rate!=$rows1['rate'] || $sssloan!=$rows1['sssloan'] || $sssloan2!=$rows1['sssloan2'] || $hdmfloan!=$rows1['hdmfloan'] || $hdmfloan2!=$rows1['hdmfloan2'] || $totalvacation!=$rows1['totalvacation'])
            {
                mysql_query("UPDATE employees SET employeenumber='".$employeenumber."',lastname='".$lastname."',firstname='".$firstname."',employeetype='".$employeetype."',rate='".$rate."',sssloan='".$sssloan."',sssloan2='".$sssloan2."',hdmfloan='".$hdmfloan."',hdmfloan2='".$hdmfloan2."',totalvacation='".$totalvacation."' WHERE id='".$id."'");
                $check_query=mysql_affected_rows();
                $mysql_affected_rows=$mysql_affected_rows+$check_query;

                mysql_query("UPDATE payroll SET employeenumber='".$employeenumber."',fullname='".$fullname."',employeetype='".$employeetype."' WHERE employeenumber='".$employeenumber1."'");
                $check_queryp=mysql_affected_rows();
                $mysql_affected_rowsp=$mysql_affected_rowsp+$check_queryp;
            }
            else
            { $equalizer=$equalizer+1; }
            
            $id=NULL;
            $employeenumber=NULL;
            $lastname=NULL;
            $firstname=NULL;
            $fullname=NULL;
            $employeetype=NULL;
            $rate=NULL;
            $sssloan=NULL;
            $sssloan2=NULL;
            $hdmfloan=NULL;
            $hdmfloan2=NULL;
            $totalvacation=NULL;
        }
        if($equalizer==$total1)
        { alert('ERROR: No Employee record changes have been found.'); }
        if($mysql_affected_rows<=0)
        { alert('ERROR: Unable to update Employee record/s.'); }
        else
        { alert('SUCCESS: '.$mysql_affected_rows.' Employee record/s have been updated.'); }
        if($mysql_affected_rowsp>0)
        { alert('SUCCESS: '.$mysql_affected_rowsp.' Payroll record/s have been updated.'); }
        $_SESSION['updateall']=NULL;
        reload_page();
    }
    ?>
    <div class="panel panel-default">
        <table id="employees" class="table-striped nowrap">
        <thead style="background-color: white;">
        <th>Action</th>
        <th>#</th>
        <th>Employee Number</th>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Employee Type</th>
        <th>Rate</th>
        <th>S.S.S. SL</th>
        <th>S.S.S. CL</th>
        <th>H.D.M.F. STL</th>
        <th>H.D.M.F. CL</th>
        <th>Total Vacation</th>
        </thead>
            <tbody>
            <?php
            if($_SESSION['visibility']=='hidden')
            { $filter=" WHERE status='hidden' "; }
            else
            { $filter=" WHERE NOT status='hidden' "; }
            $content=mysql_query("SELECT * FROM ".$table."".$filter."ORDER BY employeetype ASC, lastname ASC");
            $total=mysql_affected_rows();
            $ctr=0;
            for($x=0; $x<=$total-1; $x++)
            {
            ?>
                <tr>
                <?php
                $rows=mysql_fetch_array($content);
                $ctr=$ctr+1;
                $id=$rows['id'];
                $employeenumber=$rows['employeenumber'];
                $lastname=$rows['lastname'];
                $firstname=$rows['firstname'];
                $employeetype=$rows['employeetype'];
                $rate=$rows['rate'];
                $sssloan=$rows['sssloan'];
                $sssloan2=$rows['sssloan2'];
                $hdmfloan=$rows['hdmfloan'];
                $hdmfloan2=$rows['hdmfloan2'];
                $totalvacation=$rows['totalvacation'];
                ?>
                    <td><input class="btn btn-primary btn-s" form="select<?=$x;?>" name="btnSelect" type="submit" value="SELECT"/></td>
                    <?php
                    echo "<td align=\"center\">$ctr</td>";
                    echo "<td align=\"center\">$employeenumber</td>";
                    echo "<td align=\"center\">$lastname</td>";
                    echo "<td align=\"center\">$firstname</td>";
                    echo "<td align=\"center\">$employeetype</td>";
                    echo "<td align=\"center\">$rate</td>";
                    echo "<td align=\"center\">$sssloan</td>";
                    echo "<td align=\"center\">$sssloan2</td>";
                    echo "<td align=\"center\">$hdmfloan</td>";
                    echo "<td align=\"center\">$hdmfloan2</td>";
                    echo "<td align=\"center\">$totalvacation</td>";
                    ?>
                    <form id="select<?=$x;?>" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" novalidate>
                    <input name="id" type="hidden" value="<?=$id;?>"/>
                    <input name="employeenumber" type="hidden" value="<?=$employeenumber;?>"/>
                    <input name="lastname" type="hidden" value="<?=$lastname;?>"/>
                    <input name="firstname" type="hidden" value="<?=$firstname;?>"/>
                    <input name="employeetype" type="hidden" value="<?=$employeetype;?>"/>
                    <input name="rate" type="hidden" value="<?=$rate;?>"/>
                    <input name="sssloan" type="hidden" value="<?=$sssloan;?>"/>
                    <input name="sssloan2" type="hidden" value="<?=$sssloan2;?>"/>
                    <input name="hdmfloan" type="hidden" value="<?=$hdmfloan;?>"/>
                    <input name="hdmfloan2" type="hidden" value="<?=$hdmfloan2;?>"/>
                    <input name="totalvacation" type="hidden" value="<?=$totalvacation;?>"/>
                    </form>
                </tr>
                <?php
            if(isset($_POST['btnSelect']))
            {
                if($_SESSION['updateall']=='enabled')
                {
                    $_SESSION['updateall']=NULL;
                    echo('<script type="text/javascript">window.location.reload();</script>');
                }
            }
            }
            ?>
        </tbody>
        </table>
    </div>
<?php
}
html_end();
?>