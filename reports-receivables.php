<?php //********************BTIC Sales & Payroll System v15.24.0709.1718********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin' && $_SESSION['usertype']!='btic_sales')
{ redirect_home(); }
$table='receivables';
$_SESSION['formtype']='receivables';
$_SESSION['HTTP_REFERER']='reports-receivables.php';
$title=' - Accounts Receivable Report';
$tab=array('reports-receivables.php'=>'Receivables');
html_start($title,$tab);
?>
<div class="panel panel-default">
<div class="panel-heading" style="font-size: 20px;">Accounts Receivable Report</div>
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
    <br /><label style="margin-left: 20px;">Invoice #</label>
    <input class="form-control" type="text" name="invoice" value="<?=$_POST['invoice'];?>" placeholder="[Search Invoice Number...]">
    <span style="margin-left: 20px;"></span>
    <input class="form-control btn btn-primary" name="btnSelect" type="submit" value="SELECT">
    <input class="form-control btn btn-success" name="btnShowAll" type="submit" value="SHOW ALL RECORDS">
    <a style="width: 100px;" class="form-control btn btn-warning" href="reports-receivables.php">RESET</a>
    </form>
    <br />
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
        $invoice=$_POST['invoice'];
    }
    else if(isset($_POST['btnShowAll']))
    {
        $customer=NULL;
        $month=NULL;
        $year=NULL;
        $date=NULL;
        $invoice=NULL;
    }
    
    if($invoice!=NULL)
    {
        $content=mysql_query("SELECT * FROM ".$table." WHERE sinum LIKE '%".$invoice."%' ORDER BY sinum");
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing Sales Invoice #'.$invoice.' record/s in RECEIVABLES.');
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
            $content=mysql_query("SELECT * FROM ".$table." ORDER BY sinum");
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s in RECEIVABLES.');
        }
        else if($month==NULL && $year==NULL && isset($_POST['btnSelect']))
        {
            if($sqlstring!=NULL)
            { $addstring='WHERE'; }
            $query=("SELECT * FROM ".$table." $addstring $sqlstring ORDER BY sinum");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'in RECEIVABLES.');
        }
        else if($month==NULL && $year!=NULL && isset($_POST['btnSelect']))
        {
            $query=("SELECT * FROM ".$table." WHERE $sqlstring date1 LIKE '".$year."-%' ORDER BY sinum");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'from YEAR '.$year.' in RECEIVABLES.');
        }
        else if($month!=NULL && $year!=NULL && isset($_POST['btnSelect']))
        {
            $query=("SELECT * FROM ".$table." WHERE $sqlstring date1 LIKE '%".$date."%' ORDER BY sinum");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'from '.strtoupper(date('F',mktime(0,0,0,$month,10))).' '.$year.' in RECEIVABLES.');
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
        $_SESSION['tblname']='optimize_report';
        $json_array=array();
        while($row=mysql_fetch_assoc($content))
        { $json_array[]=$row; }
        $json_data=json_encode($json_array);
        file_put_contents('data/reports-receivables.json','{"data":'.$json_data.'}');
        ?>
        <div class="alert alert-info">
            <strong>NOTICE: </strong>Single SELECT button/s have been disabled to optimize table display speed. Please input Invoice Number in the <strong>Invoice #</strong> textbox above to SELECT a record...
        </div>
        <?php
    }
    else
    { $_SESSION['tblname']='report'; }
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
    <th>S.I. #</th>
    <th>Invoice Amount</th>
    <th>Comment</th>
    </thead>
    <tbody>
        <?php
        $ctr=0;
        while($rows=mysql_fetch_array($content))
        {
            $ctr=$ctr+1;
            ?>
            <tr>
            <form id="form<?=$x;?>" method="post" action="transactions-receivables.php">
            <?php
            $id=$rows['id'];
            $date1=$rows['date1'];
            $customer=$rows['customer'];
            $sinum=$rows['sinum'];
            $invoiceamt=$rows['invoiceamt'];
            $comment=$rows['comment'];

            echo "<td><input class=\"btn btn-primary btn-s\" type=\"submit\" value=\"SELECT\"/></td>";
            echo "<td align=\"center\">$ctr</td>";
            echo "<td align=\"center\">$date1</td>";
            echo "<td align=\"center\">$customer</td>";
            echo "<td align=\"center\">$sinum</td>";
            echo "<td align=\"right\">$invoiceamt</td>";
            echo "<td align=\"right\">$comment</td>";
            echo "<input name=\"id\" type=\"hidden\" value=\"$id\"/>";
            ?>
            </form>
            </tr>
        <?php
        }
        $returns=total_column('returns','accrec');
        $receivables=total_column('receivables','invoiceamt');
        ?>
    </tbody>
    <tfoot>
        <tr>
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
            <th><?php echo "Total: &nbsp;&nbsp;&nbsp;".$receivables; ?></th>
            <th>
                <?php
                    echo "Less (Returns): &nbsp;&nbsp;&nbsp;".$returns;
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grand Total: &nbsp;&nbsp;&nbsp;";
                    echo number_format((str_replace(',','',$receivables)-str_replace(',','',$returns)),2);
                ?>
            </th>
        </tr>
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