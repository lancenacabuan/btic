<?php //********************BTIC Invoicing & Payroll System v15.22.0831.1140********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin' && $_SESSION['usertype']!='btic_invoice')
{ redirect_page(); }
$table='returns';
$_SESSION['formtype']=$table;
$_SESSION['HTTP_REFERER']='transactions-returns.php';
$colwidth=array();
$thname=array();
$colname=array();
$component=NULL;
$title=' - Accounts Return';
$tab=array('transactions-returns.php'=>'Returns');
html_start($title,$tab);

$form='Accounts Return Form';
$new='transactions-returns.php';
form_start($form,$new);

$id=$_POST['id'];

$name='id';
$value=$id;
input_hidden($name,$value);

$label='Date';
$name='date';
$attribute='required autofocus';
$value=validate($_POST[$name]);
input_date($label,$name,$attribute,$value);

$label='Customer Name';
$name='customer';
$attribute='required';
$selection=$_POST[$name];
$placeholder='--required-- (select an option)';
$array=array();
$query='SELECT * FROM accounts ORDER BY customertype DESC, customer ASC';
$index=$name;
select_option($label,$name,$attribute,$selection,$placeholder,$array,$query,$index);

$label='Returns Transaction Vendor Number';
$name='rtvnum';
$maxlength='15';
$placeholder='--required-- (maxlength: 15 characters)';
$attribute='required';
$value=validate($_POST[$name]);
input_text($label,$name,$maxlength,$placeholder,$attribute,$value);

$label='Amount';
$name='accrec';
$min='0';
$max='9999999999.99';
$step='0.01';
$placeholder='--required-- (max: 9,999,999,999.99)';
$attribute='oninput="javascript: if (this.value.length > this.maxLength) this.value=this.value.slice(0,this.maxLength);" maxlength="13" required';
$value=str_replace(',','',validate($_POST[$name]));
input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);

form_button_group($id);
form_end();

$date=validate($_POST['date']);
$customer=$_POST['customer'];
$rtvnum=validate($_POST['rtvnum']);
$accrec=number_format(validate($_POST['accrec']),2);
$x1=str_replace(',','',$accrec);
$sales=number_format(($x1/1.12),2);
$x2=str_replace(',','',$sales);
$outputvat=number_format(($x1-$x2),2);

$select="SELECT * FROM ".$table." ORDER BY date ASC, customer ASC";
$insert="INSERT INTO ".$table." VALUES (DEFAULT,'".$date."','".$customer."','".$rtvnum."','".$accrec."','".$outputvat."','".$sales."')";
$update="UPDATE ".$table." SET date='".$date."',customer='".$customer."',rtvnum='".$rtvnum."',accrec='".$accrec."',outputvat='".$outputvat."',sales='".$sales."' WHERE id='".$id."'";
$delete="DELETE FROM ".$table." WHERE id='$id'";
sql_execute_query($new,$select,$id,$insert,$update,$delete,$colwidth,$thname,$colname,$component);
?>
<br />
<div class="panel panel-default">
<div class="panel-body">
    <form class="form-inline" method="post" role="form">
    <?php
    $label='Customer Name';
    $name='customer';
    $attribute=NULL;
    $selection=$_POST[$name];
    $placeholder='--optional-- (select an option)';
    $array=array();
    $query='SELECT * FROM accounts ORDER BY customertype DESC, customer ASC';
    $index=$name;
    select_option($label,$name,$attribute,$selection,$placeholder,$array,$query,$index);
    
    if($_POST['month']==NULL)
    { $monthholder=NULL; }
    else
    { $monthholder=strtoupper(date("F",mktime(0,0,0,$_POST['month'],10))); }
    if($_POST['year']==NULL)
    { $yearholder=date("Y"); }
    else
    { $yearholder=$_POST['year']; }
    ?>
    <label style="margin-left: 20px;">Month</label>
    <select style="width: 200px; text-align-last: center;" class="form-control" id="month" name="month">
        <option value="" disabled <?php if($monthholder==NULL) echo 'selected'; ?>>---(select an option)---</option>
        <option value="01" <?php if($monthholder=='JANUARY') echo 'selected'; ?>>JANUARY</option>
        <option value="02" <?php if($monthholder=='FEBRUARY') echo 'selected'; ?>>FEBRUARY</option>
        <option value="03" <?php if($monthholder=='MARCH') echo 'selected'; ?>>MARCH</option>
        <option value="04" <?php if($monthholder=='APRIL') echo 'selected'; ?>>APRIL</option>
        <option value="05" <?php if($monthholder=='MAY') echo 'selected'; ?>>MAY</option>
        <option value="06" <?php if($monthholder=='JUNE') echo 'selected'; ?>>JUNE</option>
        <option value="07" <?php if($monthholder=='JULY') echo 'selected'; ?>>JULY</option>
        <option value="08" <?php if($monthholder=='AUGUST') echo 'selected'; ?>>AUGUST</option>
        <option value="09" <?php if($monthholder=='SEPTEMBER') echo 'selected'; ?>>SEPTEMBER</option>
        <option value="10" <?php if($monthholder=='OCTOBER') echo 'selected'; ?>>OCTOBER</option>
        <option value="11" <?php if($monthholder=='NOVEMBER') echo 'selected'; ?>>NOVEMBER</option>
        <option value="12" <?php if($monthholder=='DECEMBER') echo 'selected'; ?>>DECEMBER</option>
    </select>
    <label style="margin-left: 20px;">Year</label>
    <input style="width: 100px;" class="form-control" type="number" name="year" min="2000" max="2999" step="1" value="<?=$yearholder;?>">
    <br /><label style="margin-left: 20px;">R.T.V. #</label>
    <input class="form-control" type="text" name="rtv" value="<?=$_POST['rtv'];?>" placeholder="[Search R.T.V. Number...]">
    <span style="margin-left: 20px;"></span>
    <label style="margin-left: 20px;">Date</label>
    <input class="form-control" type="date" name="datefilter" value="<?=$_POST['datefilter'];?>"><br />
    <input class="form-control btn btn-primary" name="btnSelect" type="submit" value="SELECT">
    <input class="form-control btn btn-success" name="btnShowAll" type="submit" value="SHOW ALL RECORDS">
    <a style="width: 100px;" class="form-control btn btn-warning" href="transactions-returns.php">RESET</a>
    </form>
    <?php
    if(isset($_POST['btnSelect']))
    {
        $customer=$_POST['customer'];
        $month=$_POST['month'];
        $year=$_POST['year'];
        if($month!=NULL)
        { $date=$year.'-'.$month.'-'; }
        else
        { $date=NULL; }
        $rtvnum=$_POST['rtv'];
        $datefilter=$_POST['datefilter'];
    }
    else if(isset($_POST['btnShowAll']))
    {
        $customer=NULL;
        $month=NULL;
        $year=NULL;
        $date=NULL;
        $rtvnum=NULL;
        $datefilter=NULL;
    }
    
    if($rtvnum && $datefilter)
    { alert('ERROR: Invalid form input!!! Please try again.....'); }
    else if($rtvnum!=NULL)
    {
        $content=mysql_query("SELECT * FROM ".$table." WHERE rtvnum LIKE '%".$rtvnum."%' ORDER BY date ASC, customer ASC");
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing R.T.V. #'.$rtvnum.' record/s in RETURNS.');
    }
    else if($datefilter!=NULL)
    {
        $content=mysql_query("SELECT * FROM ".$table." WHERE date LIKE '%".$datefilter."%' ORDER BY customer ASC");
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing Date '.$datefilter.' record/s in RETURNS.');
    }
    else
    {
        if($customer!=NULL && isset($_POST['btnSelect']))
        {
            if($year!=NULL)
            { $AND='AND'; }
            $phpstring='of '.$customer.' ';
            $sqlstring="customer LIKE '%$customer%' $AND ";
        }
        if($date==NULL && isset($_POST['btnShowAll']))
        {
            $content=mysql_query("SELECT * FROM ".$table." ORDER BY date ASC, customer ASC");
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s in RETURNS.');
        }
        else if($month==NULL && $year==NULL && isset($_POST['btnSelect']))
        {
            if($sqlstring!=NULL)
            { $addstring='WHERE'; }
            $query=("SELECT * FROM ".$table." $addstring $sqlstring ORDER BY date ASC, customer ASC");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'in RETURNS.');
        }
        else if($month==NULL && $year!=NULL && isset($_POST['btnSelect']))
        {
            $query=("SELECT * FROM ".$table." WHERE $sqlstring date LIKE '".$year."-%' ORDER BY date ASC, customer ASC");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'from YEAR '.$year.' in RETURNS.');
        }
        else if($month!=NULL && $year!=NULL && isset($_POST['btnSelect']))
        {
            $query=("SELECT * FROM ".$table." WHERE $sqlstring date LIKE '%".$date."%' ORDER BY date ASC, customer ASC");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'from '.strtoupper(date('F',mktime(0,0,0,$month,10))).' '.$year.' in RETURNS.');
        }
        else
        {
            if(isset($_POST['btnSelect']))
            {
                alert('ERROR: No matching records found or invalid input!');
                reload_page();
            }
            $total=0;
        }
    }
    
    if($total!=0)
    {
    if($total>500)
    {
        $_SESSION['tblname']='optimize_returns';
        $json_array=array();
        while($row=mysql_fetch_assoc($content))
        { $json_array[]=$row; }
        $json_data=json_encode($json_array);
        file_put_contents('data/transaction-returns.json','{"data":'.$json_data.'}');
        ?>
        <div class="alert alert-info">
            <strong>NOTICE: </strong>Single SELECT button/s have been disabled to optimize table display speed. Please input R.T.V. Number in the <strong>R.T.V. #</strong> textbox above to SELECT a record...
        </div>
        <?php
    }
    else
    { $_SESSION['tblname']='total_returns'; }
    ?>
    <table id="<?=$_SESSION['tblname'];?>" class="table-striped nowrap">
    <thead>
    <?php
    if($total<=500)
    {
    ?>
    <th>Action</th>
    <th>#</th>
    <?php
    }
    ?>
    <th>Date</th>
    <th>Customer Name</th>
    <th>R.T.V. #</th>
    <th class="sum">Amount</th>
    <th class="sum">Output V.A.T.</th>
    <th class="sum">Sales</th>
    </thead>
    <tbody>
    <?php
    if($total<=500)
    {
        $ctr=0;
        while($rows=mysql_fetch_array($content))
        {
            $ctr=$ctr+1;
            echo "<tr>";
            echo "<form method=\"post\">";
            $id=$rows['id'];
            $date=$rows['date'];
            $customer=$rows['customer'];
            $rtvnum=$rows['rtvnum'];
            $accrec=$rows['accrec'];
            $outputvat=$rows['outputvat'];
            $sales=$rows['sales'];

            echo "<td><input class=\"btn btn-primary btn-s\" type=\"submit\" value=\"SELECT\"/></td>";
            echo "<td align=\"center\">$ctr</td>";
            echo "<td align=\"center\">$date</td>";
            echo "<td align=\"center\">$customer</td>";
            echo "<td align=\"center\">$rtvnum</td>";
            echo "<td align=\"center\">$accrec</td>";
            echo "<td align=\"center\">$outputvat</td>";
            echo "<td align=\"center\">$sales</td>";
            echo "<input name=\"id\" type=\"hidden\" value=\"$id\"/>";
            echo "<input name=\"date\" type=\"hidden\" value=\"$date\"/>";
            echo "<input name=\"customer\" type=\"hidden\" value=\"$customer\"/>";
            echo "<input name=\"rtvnum\" type=\"hidden\" value=\"$rtvnum\"/>";
            echo "<input name=\"accrec\" type=\"hidden\" value=\"$accrec\"/>";
            echo "<input name=\"outputvat\" type=\"hidden\" value=\"$outputvat\"/>";
            echo "<input name=\"sales\" type=\"hidden\" value=\"$sales\"/>";
            echo "</form>";
            echo "</tr>";
        }
    }
    ?>
    </tbody>
    <tfoot>
    <?php
    if($total<=500)
    {
    ?>
    <th></th>
    <th></th>
    <?php
    }
    ?>
    <th></th>
    <th></th>
    <th></th>
    <th>Amount</th>
    <th>Output V.A.T.</th>
    <th>Sales</th>
    </tfoot>
    </table>
    <?php
    }
    ?>
</div>
</div>
<?php
html_end();
?>