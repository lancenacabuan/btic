<?php //********************BTIC Sales & Payroll System v15.24.0202.1730********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin' && $_SESSION['usertype']!='btic_sales')
{ redirect_home(); }
$table='collections';
$upper="COLLECTIONS";
$ucfirst="Collections";
$_SESSION['formtype']=$table;
$_SESSION['HTTP_REFERER']='transactions-collections.php';
$colwidth=array();
$thname=array();
$colname=array();
$component=NULL;
$title=' - Accounts '.$ucfirst.'';
$tab=array('transactions-collections.php'=>''.$ucfirst.'');
html_start($title,$tab);

$form='Accounts '.$ucfirst.' Form';
$new='transactions-collections.php';
form_start($form,$new);

$id=$_POST['id'];
if($id!=NULL)
{
    $content1=mysql_query("SELECT * FROM ".$table." WHERE id=".$id."");
    $rows1=mysql_fetch_array($content1);
}

$name='id';
$value=$id;
input_hidden($name,$value);

$label='Delivery Date';
$name='date1';
$attribute='required autofocus';
$value=validate($rows1[$name]);
input_date($label,$name,$attribute,$value);

$label='Customer Name';
$name='customer[]';
$attribute='multiple required';
$selection=$rows1['customer'];
$placeholder='--required-- (select an option/s) (max: 100 items)';
$array=array();
$query='SELECT * FROM accounts ORDER BY customertype DESC, customer ASC';
$index='customer';
select_option($label,$name,$attribute,$selection,$placeholder,$array,$query,$index);

$label='Sales Invoice Number';
$name='sinum';
$maxlength='1050';
$placeholder='--required-- (maxlength: 1050 characters / 150 S.I. #)';
$attribute='required';
$value=validate($rows1[$name]);
input_textarea($label,$name,$maxlength,$placeholder,$attribute,$value);

$label='Invoice Amount';
$name='invoiceamt';
$min='0';
$max='9999999999.99';
$step='0.01';
$placeholder='--required-- (max: 9,999,999,999.99)';
$attribute='oninput="javascript: if (this.value.length > this.maxLength) this.value=this.value.slice(0,this.maxLength);" maxlength="13" required';
$value=str_replace(',','',validate($rows1[$name]));
input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);

$label='Purchase Order Number';
$name='ponum';
$maxlength='10';
$placeholder='--optional-- (maxlength: 10 characters)';
$attribute='';
$value=validate(strtoupper($rows1[$name]));
input_text($label,$name,$maxlength,$placeholder,$attribute,$value);

$label='Expanded Withholding Tax';
$name='ewt';
$min='0';
$max='9999999999.99';
$step='0.01';
$placeholder='--optional-- (max: 9,999,999,999.99)';
$attribute='oninput="javascript: if (this.value.length > this.maxLength) this.value=this.value.slice(0,this.maxLength);" maxlength="13"';
$value=str_replace(',','',validate($rows1[$name]));
input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);

$label='Returns';
$name='returns';
$min='0';
$max='9999999999.99';
$step='0.01';
$placeholder='--optional-- (max: 9,999,999,999.99)';
$attribute='oninput="javascript: if (this.value.length > this.maxLength) this.value=this.value.slice(0,this.maxLength);" maxlength="13"';
$value=str_replace(',','',validate($rows1[$name]));
input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);

$label='Miscellaneous';
$name='miscellaneous';
$min='0';
$max='9999999999.99';
$step='0.01';
$placeholder='--optional-- (max: 9,999,999,999.99)';
$attribute='oninput="javascript: if (this.value.length > this.maxLength) this.value=this.value.slice(0,this.maxLength);" maxlength="13"';
$value=str_replace(',','',validate($rows1[$name]));
input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);

$label='Check Date';
$name='date2';
$attribute='';
$value=validate($rows1[$name]);
input_date($label,$name,$attribute,$value);

$label='Check Number';
$name='checknum';
$maxlength='20';
$placeholder='--optional-- (maxlength: 20 characters)';
$attribute='';
$value=validate(strtoupper($rows1[$name]));
input_text($label,$name,$maxlength,$placeholder,$attribute,$value);

$label='Check Amount';
$name='checkamt';
$min='0';
$max='9999999999.99';
$step='0.01';
$placeholder='--optional-- (max: 9,999,999,999.99)';
$attribute='oninput="javascript: if (this.value.length > this.maxLength) this.value=this.value.slice(0,this.maxLength);" maxlength="13"';
$value=str_replace(',','',validate($rows1[$name]));
input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value);

$label='Official Receipt Number';
$name='ornum';
$maxlength='10';
$placeholder='--optional-- (maxlength: 10 characters)';
$attribute='';
$value=validate(strtoupper($rows1[$name]));
input_text($label,$name,$maxlength,$placeholder,$attribute,$value);

$label='Comment';
$name='comment';
$maxlength='500';
$placeholder='--optional-- (maxlength: 500 characters)';
$attribute='';
$value=validate($rows1[$name]);
input_textarea($label,$name,$maxlength,$placeholder,$attribute,$value);

form_button_group($id);
form_end();

$date1=validate($_POST['date1']);
$customer=implode(', ',$_POST['customer']);
$sinum=validate($_POST['sinum']);
$invoiceamt=number_format(validate($_POST['invoiceamt']),2);
$ponum=validate($_POST['ponum']);
$ewt=number_format(validate($_POST['ewt']),2);
$returns=number_format(validate($_POST['returns']),2);
$miscellaneous=number_format(validate($_POST['miscellaneous']),2);
if($_POST['date2']!=NULL)
{ $date2=validate($_POST['date2']); }
else
{ $date2=validate($_POST['date2']); }
$checknum=strtoupper(validate($_POST['checknum']));
$checkamt=number_format(validate($_POST['checkamt']),2);
$ornum=validate($_POST['ornum']);
$comment=validate($_POST['comment']);

$select="SELECT * FROM ".$table." ORDER BY sinum";
$insert="INSERT INTO ".$table." VALUES (DEFAULT,'".$date1."','".$customer."','".$sinum."','".$invoiceamt."','".$ponum."','".$ornum."','".$date2."','".$checknum."','".$totalbill."','".$ewt."','".$returns."','".$miscellaneous."','".$checkamt."','".$balance."','".$comment."')";
$update="UPDATE ".$table." SET date1='".$date1."',customer='".$customer."',sinum='".$sinum."',invoiceamt='".$invoiceamt."',ponum='".$ponum."',ornum='".$ornum."',date2='".$date2."',checknum='".$checknum."',totalbill='".$totalbill."',ewt='".$ewt."',returns='".$returns."',miscellaneous='".$miscellaneous."',checkamt='".$checkamt."',balance='".$balance."',comment='".$comment."' WHERE id='".$id."'";
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
    <br />
    <br />
    <div class="form-group">
        <label for="filter-search">Filter Search By:</label>
        <select class="selectpicker form-control" id="filter-search">
            <option value="" selected disabled>Select an Option</option>
            <option value="invoice">Sales Invoice #</option>
            <option value="po_num">Purchase Order #</option>
            <option value="checkno">Check #</option>
            <option value="or_num">Official Receipt #</option>
            <option value="datefilter">Delivery Date</option>
        </select>
    </div>
    <input class="form-control filters" type="text" id="invoice" name="invoice" value="<?=$_POST['invoice'];?>" placeholder="[Search Sales Invoice Number...]" style="width: 308px; text-align: center;">
    <input class="form-control filters" type="text" id="po_num" name="po_num" value="<?=$_POST['po_num'];?>" placeholder="[Search Purchase Order Number...]" style="width: 308px; text-align: center;">
    <input class="form-control filters" type="text" id="checkno" name="checkno" value="<?=$_POST['checkno'];?>" placeholder="[Search Check Number...]" style="width: 308px; text-align: center;">
    <input class="form-control filters" type="text" id="or_num" name="or_num" value="<?=$_POST['or_num'];?>" placeholder="[Search Official Receipt Number...]" style="width: 308px; text-align: center;">
    <input class="form-control filters" type="date" id="datefilter" name="datefilter" value="<?=$_POST['datefilter'];?>" style="width: 200px; text-align: center;"><br />
    <br />
    <input class="form-control btn btn-primary" name="btnSelect" type="submit" value="SELECT">
    <input class="form-control btn btn-success" name="btnShowAll" type="submit" value="SHOW ALL RECORDS">
    <a style="width: 100px;" class="form-control btn btn-warning" href="transactions-collections.php">RESET</a>
    </form>
    <br />
    <script>
        $('#filter-search').on('change', function(){
            if($('#customer').val() || $('#month').val()){
                $('#customer').val('');
                $('#customer').trigger('chosen:updated');
                $('#month').val('')
            }
        });
        setInterval(() => {
            if($('#customer').val() || $('#month').val()){
                $('#filter-search').val('');
            }
            $('.filters').each(function(){
                if(!$(this).is(':visible')){
                    $(this).val('');
                }
            });
            if($('#filter-search').val() == 'invoice'){
                $('#invoice').show();
                $('#po_num').hide();
                $('#checkno').hide();
                $('#or_num').hide();
                $('#datefilter').hide();
            }
            else if($('#filter-search').val() == 'po_num'){
                $('#invoice').hide();
                $('#po_num').show();
                $('#checkno').hide();
                $('#or_num').hide();
                $('#datefilter').hide();
            }
            else if($('#filter-search').val() == 'checkno'){
                $('#invoice').hide();
                $('#po_num').hide();
                $('#checkno').show();
                $('#or_num').hide();
                $('#datefilter').hide();
            }
            else if($('#filter-search').val() == 'or_num'){
                $('#invoice').hide();
                $('#po_num').hide();
                $('#checkno').hide();
                $('#or_num').show();
                $('#datefilter').hide();
            }
            else if($('#filter-search').val() == 'datefilter'){
                $('#invoice').hide();
                $('#po_num').hide();
                $('#checkno').hide();
                $('#or_num').hide();
                $('#datefilter').show();
            }
            else{
                $('.filters').hide();
                $('.filters').val('');
            }
        }, 0);
    </script>
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
        $po_num=$_POST['po_num'];
        $checkno=$_POST['checkno'];
        $or_num=$_POST['or_num'];
        $datefilter=$_POST['datefilter'];
    }
    else if(isset($_POST['btnShowAll']))
    {
        $customer=NULL;
        $month=NULL;
        $year=NULL;
        $date=NULL;
        $invoice=NULL;
        $po_num=NULL;
        $checkno=NULL;
        $or_num=NULL;
        $datefilter=NULL;
    }
    
    if(($invoice && $checkno) || ($checkno && $datefilter) || ($invoice && $datefilter))
    { alert('ERROR: Invalid form input!!! Please try again.....'); }
    else if($invoice!=NULL)
    {
        $content=mysql_query("SELECT * FROM ".$table." WHERE sinum LIKE '%".$invoice."%' ORDER BY sinum");
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing Sales Invoice #'.$invoice.' record/s in '.$upper.'.');
    }
    else if($po_num!=NULL)
    {
        $content=mysql_query("SELECT * FROM ".$table." WHERE ponum LIKE '%".$po_num."%' ORDER BY ponum");
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing Purchase Order #'.$invoice.' record/s in '.$upper.'.');
    }
    else if($checkno!=NULL)
    {
        $content=mysql_query("SELECT * FROM ".$table." WHERE checknum LIKE '%".$checkno."%' ORDER BY sinum");
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing Check #'.$checkno.' record/s in '.$upper.'.');
    }
    else if($or_num!=NULL)
    {
        $content=mysql_query("SELECT * FROM ".$table." WHERE ornum LIKE '%".$or_num."%' ORDER BY ornum");
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing Official Receipt #'.$invoice.' record/s in '.$upper.'.');
    }
    else if($datefilter!=NULL)
    {
        $content=mysql_query("SELECT * FROM ".$table." WHERE date1 LIKE '%".$datefilter."%' ORDER BY sinum");
        $total=mysql_affected_rows();
        alert('SUCCESS: '.$total.' matching record/s found.\nShowing Delivery Date '.$datefilter.' record/s in '.$upper.'.');
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
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s in '.$upper.'.');
        }
        else if($month==NULL && $year==NULL && isset($_POST['btnSelect']))
        {
            if($sqlstring!=NULL)
            { $addstring='WHERE'; }
            $query=("SELECT * FROM ".$table." $addstring $sqlstring ORDER BY sinum");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'in '.$upper.'.');
        }
        else if($month==NULL && $year!=NULL && isset($_POST['btnSelect']))
        {
            $query=("SELECT * FROM ".$table." WHERE $sqlstring date1 LIKE '".$year."-%' ORDER BY sinum");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'from YEAR '.$year.' in '.$upper.'.');
        }
        else if($month!=NULL && $year!=NULL && isset($_POST['btnSelect']))
        {
            $query=("SELECT * FROM ".$table." WHERE $sqlstring date1 LIKE '%".$date."%' ORDER BY sinum");
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            alert('SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s '.$phpstring.'from '.strtoupper(date('F',mktime(0,0,0,$month,10))).' '.$year.' in '.$upper.'.');
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
        $_SESSION['tblname']='optimize_collections';
        $json_array=array();
        while($row=mysql_fetch_assoc($content))
        { $json_array[]=$row; }
        $json_data=json_encode($json_array);
        file_put_contents('data/transaction-collections.json','{"data":'.$json_data.'}');
        ?>
        <div class="alert alert-info">
            <strong>NOTICE: </strong>Single SELECT button/s have been disabled to optimize table display speed. Please input Invoice Number in the <strong>Invoice #</strong> textbox above to SELECT a record...
        </div>
        <?php
    }
    else
    { $_SESSION['tblname']='tbl'.$ucfirst.''; }
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
    <?php
    if($total<=500)
    {
        $ctr=0;
        while($rows=mysql_fetch_array($content))
        {
            $ctr=$ctr+1;
            echo "<tr>";
            ?>
            <form id="form<?=$ctr;?>" method="post">
            <?php
            $id=$rows['id'];
            $date1=$rows['date1'];
            $customer=$rows['customer'];
            $sinum=$rows['sinum'];
            $invoiceamt=$rows['invoiceamt'];
            $ponum=$rows['ponum'];
            $ewt=$rows['ewt'];
            $returns=$rows['returns'];
            $miscellaneous=$rows['miscellaneous'];
            $date2=$rows['date2'];
            $checknum=$rows['checknum'];
            if($rows['checkamt']==NULL)
            { $checkamt='0.00'; }
            else
            { $checkamt=$rows['checkamt']; }
            $ornum=$rows['ornum'];
            $x1=str_replace(',','',$invoiceamt);
            $x2=str_replace(',','',$ewt);
            $x3=str_replace(',','',$returns);
            $x4=str_replace(',','',$miscellaneous);
            $totalbill=number_format(($x1-$x2-$x3-$x4),2);
            $x5=str_replace(',','',$totalbill);
            $x6=str_replace(',','',$checkamt);
            $balance=number_format(($x5-$x6),2);
            $comment=$rows['comment'];
            
            echo "<td><input class=\"btn btn-primary btn-s\" type=\"submit\" value=\"SELECT\"/>";
            echo "<button type=\"button\" class=\"btn btn-link\" data-toggle=\"modal\" data-target=\"#info$ctr\">Info</button></td>";
            echo "<td align=\"center\">$ctr</td>";
            echo "<td align=\"center\">$date1</td>";
            echo "<td align=\"center\">$customer</td>";
            echo "<td align=\"center\">$sinum</td>";
            echo "<td align=\"center\">$invoiceamt</td>";
            echo "<td align=\"center\">$ponum</td>";
            echo "<td align=\"center\">$ewt</td>";
            echo "<td align=\"center\">$returns</td>";
            echo "<td align=\"center\">$miscellaneous</td>";
            echo "<td align=\"center\">$totalbill</td>";
            echo "<td align=\"center\">$date2</td>";
            echo "<td align=\"center\">$checknum</td>";
            echo "<td align=\"center\">$checkamt</td>";
            echo "<td align=\"center\">$ornum</td>";
            echo "<td align=\"center\">$balance</td>";
            echo "<td align=\"center\">$comment</td>";
            echo "<input name=\"id\" type=\"hidden\" value=\"$id\"/>";
            ?>
            <div id="info<?=$ctr;?>" class="modal fade" role="dialog" style="position: fixed; top: 110px;">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><strong><?=$customer;?></strong></h4>
            </div>
            <div class="modal-body">
            <div style="zoom: 120%;">
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Delivery Date</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$date1;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>S.I. #</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <strong><?=$sinum;?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Invoice Amount</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$invoiceamt;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>P.O. #</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$ponum;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>E.W.T.</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$ewt;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Returns</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$returns;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Miscellaneous</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$miscellaneous;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Total Billing</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$totalbill;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Check Date</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$date2;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Check #</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$checknum;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Check Amount</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$checkamt;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>O.R. #</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$ornum;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Balance</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$balance;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: left;">
                        <strong>Comment</strong>
                    </div>
                    <div class="col-sm-8" style="text-align: left;">
                        <?=$comment;?>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" value="SELECT" onclick="document.getElementById('form<?=$ctr;?>').submit();"/>
                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
            </div>
            </div>
            </div>
            </form>
            <?php
            echo "</tr>";
            ?>
        <?php
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