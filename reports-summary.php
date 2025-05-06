<?php //********************BTIC Sales & Payroll System v15.25.0506.0900********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin' && $_SESSION['usertype']!='btic_sales')
{ redirect_home(); }
$_SESSION['formtype']=NULL;
$_SESSION['HTTP_REFERER']='reports-summary.php';
$title=' - Accounts Summary';
$tab=array('reports-summary.php'=>'Summary');
html_start($title,$tab);
?>
<script>$('#db_backup').hide();</script>
<div class="panel panel-default">
<div class="panel-heading" style="font-size: 20px;">Accounts Summary</div>
<div class="panel-body">
    <form class="form-inline" method="post" role="form">
    <?php
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
    <input class="form-control btn btn-primary" name="btnSelect" type="submit" value="SELECT">
    <a style="width: 100px;" class="form-control btn btn-warning" href="reports-summary.php">RESET</a>
    </form>
    <br />
    <?php
    if(isset($_POST['btnSelect']))
    {
        $month=$_POST['month'];
        $year=$_POST['year'];
        if($month!=NULL)
        { $date=$year.'-'.$month.'-'; }
        else
        { $date=NULL; }
    }
    else if(isset($_POST['btnShowAll']))
    {
        $month=NULL;
        $year=NULL;
        $date=NULL;
    }
    
    if($month==NULL && $year!=NULL && isset($_POST['btnSelect']))
    {
        $query=("SELECT * FROM receivables WHERE date1 LIKE '".$year."-%' UNION SELECT * FROM collections WHERE date1 LIKE '".$year."-%' ORDER BY date1");
        $content=mysql_query($query);
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s from YEAR '.$year.' for SUMMARY.');
    }
    else if($month!=NULL && $year!=NULL && isset($_POST['btnSelect']))
    {
        $query=("SELECT * FROM receivables WHERE date1 LIKE '%".$date."%' UNION SELECT * FROM collections WHERE date1 LIKE '%".$date."%' ORDER BY date1");
        $content=mysql_query($query);
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s from '.strtoupper(date('F',mktime(0,0,0,$month,10))).' '.$year.' for SUMMARY.');
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
    
    if($total!=0)
    {
        $_SESSION['tblname']='optimize_summary';
        $json_array=array();
        while($row=mysql_fetch_assoc($content))
        { $json_array[]=$row; }
        $json_data=json_encode($json_array);
        file_put_contents('data/transaction-summary.json','{"data":'.$json_data.'}');
        ?>
        <table id="<?=$_SESSION['tblname'];?>" class="table-striped nowrap">
            <thead>
                <th>Delivery Date</th>
                <th>Customer Name</th>
                <th>S.I. #</th>
                <th class="sum">Invoice Amount</th>
                <th>P.O. #</th>
                <th class="sum">E.W.T.</th>
                <th class="sum">Returns</th>
                <th class="sum">Miscellaneous</th>
                <th class="sum">Total Billing</th>
                <th>Check Date</th>
                <th>Check #</th>
                <th class="sum">Check Amount</th>
                <th>O.R. #</th>
                <th class="sum">Balance</th>
                <th>Comment</th>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <th></th>
                <th></th>
                <th></th>
                <th>Invoice Amount</th>
                <th></th>
                <th>EWT</th>
                <th>Returns</th>
                <th>Miscellaneous</th>
                <th>Total Billing</th>
                <th></th>
                <th></th>
                <th>Check Amount</th>
                <th></th>
                <th>Balance</th>
                <th></th>
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