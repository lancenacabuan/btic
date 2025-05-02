<?php //********************BTIC Sales & Payroll System v15.24.0709.1718********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin' && $_SESSION['usertype']!='btic_payroll')
{ redirect_home(); }
if(isset($_POST['btnVisibility']) || $_SESSION['HTTP_REFERER']=='transactions-payroll.php' || $_SESSION['HTTP_REFERER']=='index-backup.php')
{
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
            alert('RECORD VISIBILITY: Showing all CURRENT and HIDDEN record/s.');
        }
    }
    reload_page();
}
$_SESSION['formtype']='payroll';
$_SESSION['HTTP_REFERER']='reports-payroll.php';
$title=' - Payroll Report';
if(isset($_POST['btnSelect1']) && $_POST['payrollmode1']!=NULL && $_POST['payrollmode2']==NULL)
{
    switch ($_POST['payrollmode1']) {
        case '1': $title=' - Basic Pay (For PhilHealth)'; break;
        case '2': $title=' - Gross Pay (For S.S.S.)'; break;
        case '3': $title=' - Total Regular Hours'; break;
        case '4': $title=' - Regular Overtime Hours'; break;
        case '5': $title=' - Special Overtime Hours'; break;
        case '6': $title=' - Night Differential Hours'; break;
        case '7': $title=' - Vacation Leave Used'; break;
        case '8': $title=' - Basic Pay and Adjustments'; break;
        case '9': $title=' - Overtime Pay'; break;
        case '10': $title=' - Holiday Pay'; break;
        case '11': $title=' - Vacation Leave Pay'; break;
        case '12': $title=' - S.S.S. Contributions'; break;
        case '13': $title=' - P.H.I.C. Contributions'; break;
        case '14': $title=' - H.D.M.F. Contributions'; break;
        case '15': $title=' - S.S.S. SL'; break;
        case '16': $title=' - S.S.S. CL'; break;
        case '17': $title=' - H.D.M.F. STL'; break;
        case '18': $title=' - H.D.M.F. CL'; break;
    }
    $heading='Payroll Report'.$title.' '.$_POST['year1'];
}
$tab=array('reports-payroll.php'=>'Payroll');
html_start($title,$tab);
btn_visibility();

if($_POST['id']!==NULL && $_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL)
{
    $id=$_POST['id'];
    $contenth=mysql_query("SELECT * FROM payroll where id='$id'");
    $totalh=mysql_affected_rows();
    for($h=0; $h<=$totalh-1; $h++)
    {
        $rowsh=mysql_fetch_array($contenth);
        $heading=$rowsh['fullname'];
    }
}
if($_SESSION['employee']!==NULL && $_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL)
{
    $employee=$_SESSION['employee'];
    $contenth=mysql_query("SELECT * FROM employees where employeenumber='$employee'");
    $totalh=mysql_affected_rows();
    for($h=0; $h<=$totalh-1; $h++)
    {
        $rowsh=mysql_fetch_array($contenth);
        $heading=$rowsh['lastname'].', '.$rowsh['firstname'];
    }
}
if(isset($_POST['btnSelect1']) && $_POST['payrollmode1']==NULL && $_POST['payrollmode2']!=NULL)
{ $heading='Payroll Report - '.$_POST['payrollmode2'].' '.$_POST['year2'].' ('.$_POST['cutoff2'].' Cut-Off)'; }

if($_SESSION['contents']==NULL || strpos($_SESSION['payrollalert'],'ERROR')!==false)
{ $tbldisplay='display: none;'; }


if($_SESSION['visibility']=='hidden')
{ $where=" "; }
else
{ $where=" NOT status='hidden' AND "; }
?>
<div class="panel-heading" style="font-size: 20px;"><?php if($heading!=NULL){ echo $heading; } else { echo 'Payroll Report'; } ?></div>
<div class="panel-body">
<?php
if($_SESSION['printslip']=='thirteenthmonth' && $_SESSION['printslip']!='payslip' && $_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL && !isset($_POST['btnSelect']) && !isset($_POST['btnSelect1']) && !isset($_POST['btnShowAll']) && !isset($_POST['btnReset']) && !isset($_POST['btnVisibility']))
{ include('include-payslip.php'); }

if($_SESSION['printslip']!='thirteenthmonth' && $_SESSION['printslip']=='payslip' && $_SESSION['contents']=='show' && $tbldisplay!='display: none;')
{
    if($_POST['id']!=NULL && $_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL)
    {
        $id=$_POST['id'];
        $content=mysql_query("SELECT * FROM payroll WHERE id='$id'");
        $total=mysql_affected_rows();
        for($x=0; $x<=$total-1; $x++)
        {
            $rows=mysql_fetch_array($content);
            $id=$rows['id'];
            $payyear=$rows['payyear'];
            $paymonth=$rows['paymonth'];
            $startdate=$rows['startdate'];
            $enddate=$rows['enddate'];
            $cutoff=$rows['cutoff'];
            $employeetype=$rows['employeetype'];
            $employeenumber=$rows['employeenumber'];
            $fullname=$rows['fullname'];
            $oldrate=$rows['oldrate'];
            $oldrateperhour=$rows['oldrateperhour'];
            $oldhrs=$rows['oldhrs'];
            $oldOT1=$rows['oldOT1'];
            $oldND1=$rows['oldND1'];
            $rate=$rows['rate'];
            $rateperhour=number_format((str_replace(',','',$rate)/8),6);
            $week1=$rows['week1'];
            $paid=$rows['paid'];
            $regular1=$rows['regular1'];
            $overtime1=$rows['overtime1'];
            $week2=$rows['week2'];
            $regular2=$rows['regular2'];
            $overtime2=$rows['overtime2'];
            $week3=$rows['week3'];
            $regular3=$rows['regular3'];
            $overtime3=$rows['overtime3'];
            $totalregular=$rows['totalregular'];
            $basicpay1=$rows['basicpay1'];
            $basicpay2=$rows['basicpay2'];
            $totalbasicpay=$rows['totalbasicpay'];
            $regularovertime=$rows['regularovertime'];
            $regularotpay=$rows['regularotpay'];
            $specialovertime1=$rows['specialovertime1'];
            $specialovertime2=$rows['specialovertime2'];
            $specialovertime3=$rows['specialovertime3'];
            $specialotpay=$rows['specialotpay'];
            $nightdifferential1=$rows['nightdifferential1'];
            $nightdifferential2=$rows['nightdifferential2'];
            $nightdifferential3=$rows['nightdifferential3'];
            $nighttimepay=$rows['nighttimepay'];
            $holiday=$rows['holiday'];
            $holidaypay=$rows['holidaypay'];
            $vacation=$rows['vacation'];
            $vacationpay=$rows['vacationpay'];
            $contentvl=mysql_query("SELECT * FROM employees WHERE employeenumber='$employeenumber'");
            $totalvl=mysql_affected_rows();
            for($vl=0; $vl<=$totalvl-1; $vl++)
            {
                $rowsvl=mysql_fetch_array($contentvl);
                $totalvacation=$rowsvl['totalvacation'];
            }
            $grosspay1=$rows['grosspay1'];
            $grosspay2=$rows['grosspay2'];
            $totalgrosspay=$rows['totalgrosspay'];
            $adjustment=$rows['adjustment'];
            $comment=$rows['comment'];
            $sssloan=$rows['sssloan'];
            $sssloan2=$rows['sssloan2'];
            $hdmfloan=$rows['hdmfloan'];
            $hdmfloan2=$rows['hdmfloan2'];
            $sss=$rows['sss'];
            $phic=$rows['phic'];
            $hdmf=$rows['hdmf'];
            $totaldeduction=$rows['totaldeduction'];
            $netpay=$rows['netpay'];
            $category=$rows['category'];
            $sssbracket=$rows['sssbracket'];
        }
        ?>
        <div style="zoom: 150%;">
        <div id="printReceipt2">
        <font size="1" face="Calibri">
        <?php include('include-payslip.php'); ?>
        </font>
        </div>
        </div>
        <br />
        <form method="post" action="transactions-payroll.php" novalidate>
        <input name="id" type="hidden" value="<?=$id;?>"/>
        <input name="payyear" type="hidden" value="<?=$payyear;?>"/>
        <input name="paymonth" type="hidden" value="<?=$paymonth;?>"/>
        <input name="startdate" type="hidden" value="<?=$startdate;?>"/>
        <input name="enddate" type="hidden" value="<?=$enddate;?>"/>
        <input name="cutoff" type="hidden" value="<?=$cutoff;?>"/>
        <input name="employeenumber" type="hidden" value="<?=$employeenumber;?>"/>
        <input name="fullname" type="hidden" value="<?=$fullname;?>"/>
        <input name="oldrate" type="hidden" value="<?=$oldrate;?>"/>
        <input name="oldrateperhour" type="hidden" value="<?=$oldrateperhour;?>"/>
        <input name="oldhrs" type="hidden" value="<?=$oldhrs;?>"/>
        <input name="oldOT1" type="hidden" value="<?=$oldOT1;?>"/>
        <input name="oldND1" type="hidden" value="<?=$oldND1;?>"/>
        <input name="rate" type="hidden" value="<?=$rate;?>"/>
        <input name="week1" type="hidden" value="<?=$week1;?>"/>
        <input name="paid" type="hidden" value="<?=$paid;?>"/>
        <input name="week2" type="hidden" value="<?=$week2;?>"/>
        <input name="week3" type="hidden" value="<?=$week3;?>"/>
        <input name="regular1" type="hidden" value="<?=$regular1;?>"/>
        <input name="regular2" type="hidden" value="<?=$regular2;?>"/>
        <input name="regular3" type="hidden" value="<?=$regular3;?>"/>
        <input name="overtime1" type="hidden" value="<?=$overtime1;?>"/>
        <input name="overtime2" type="hidden" value="<?=$overtime2;?>"/>
        <input name="overtime3" type="hidden" value="<?=$overtime3;?>"/>
        <input name="specialovertime1" type="hidden" value="<?=$specialovertime1;?>"/>
        <input name="specialovertime2" type="hidden" value="<?=$specialovertime2;?>"/>
        <input name="specialovertime3" type="hidden" value="<?=$specialovertime3;?>"/>
        <input name="nightdifferential1" type="hidden" value="<?=$nightdifferential1;?>"/>
        <input name="nightdifferential2" type="hidden" value="<?=$nightdifferential2;?>"/>
        <input name="nightdifferential3" type="hidden" value="<?=$nightdifferential3;?>"/>
        <input name="holiday" type="hidden" value="<?=$holiday;?>"/>
        <input name="vacation" type="hidden" value="<?=$vacation;?>"/>
        <input name="basicpay1" type="hidden" value="<?=$basicpay1;?>"/>
        <input name="grosspay1" type="hidden" value="<?=$grosspay1;?>"/>
        <input name="adjustment" type="hidden" value="<?=$adjustment;?>"/>
        <input name="comment" type="hidden" value="<?=$comment;?>"/>
        <input name="sssloan" type="hidden" value="<?=$sssloan;?>"/>
        <input name="sssloan2" type="hidden" value="<?=$sssloan2;?>"/>
        <input name="hdmfloan" type="hidden" value="<?=$hdmfloan;?>"/>
        <input name="hdmfloan2" type="hidden" value="<?=$hdmfloan2;?>"/>
        <input name="phic" type="hidden" value="<?=$phic;?>"/>
        <input name="hdmf" type="hidden" value="<?=$hdmf;?>"/>
        <input name="netpay" type="hidden" value="<?=$netpay;?>"/>
        <input name="category" type="hidden" value="<?=$category;?>"/>
        <input name="sssbracket" type="hidden" value="<?=$sssbracket;?>"/>
        <input style="height: 50px; width: 655px;" class="form-control btn btn-lg btn-info" type="button" onclick="printDiv2('printReceipt2')" value="PRINT RECEIPT"/><br />
        <input style="height: 50px; width: 655px;" class="form-control btn btn-lg btn-success" type="submit" name="btnUpdate2" value="UPDATE RECORD"/>
        </form>
        <script>
            function printDiv2(divName)
            {
                var printContents=document.getElementById(divName).innerHTML;
                var originalContents=document.body.innerHTML;
                document.body.innerHTML=printContents+"<hr style='width: 100%; height: 0px; margin: 20px 0 20px 0;'>"+printContents;
                window.print();
                document.body.innerHTML=originalContents;
            }
        </script>
        <br />
        <br />
    <?php
    }
    if($_POST['id']==NULL && $_SESSION['employee']!=NULL && $_SESSION['month']!=NULL && $_SESSION['printslip']=='payslip' && strpos($_SESSION['payrollalert'],'ERROR')===false && $_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL)
    {
        $employeenumber=$_SESSION['employee'];
        $payyear=$_SESSION['year'];
        $paymonth=$_SESSION['month'];
        $cutoff=$_SESSION['cutoff'];
        if($cutoff!='Both')
        {
            $content=mysql_query("SELECT * FROM payroll WHERE employeenumber='$employeenumber' AND payyear='$payyear' AND paymonth='$paymonth' AND cutoff='$cutoff'");
            $total=mysql_affected_rows();
            for($x=0; $x<=$total-1; $x++)
            {
                $rows=mysql_fetch_array($content);
                $id=$rows['id'];
                $payyear=$rows['payyear'];
                $paymonth=$rows['paymonth'];
                $startdate=$rows['startdate'];
                $enddate=$rows['enddate'];
                $cutoff=$rows['cutoff'];
                $employeetype=$rows['employeetype'];
                $employeenumber=$rows['employeenumber'];
                $fullname=$rows['fullname'];
                $oldrate=$rows['oldrate'];
                $oldrateperhour=$rows['oldrateperhour'];
                $oldhrs=$rows['oldhrs'];
                $oldOT1=$rows['oldOT1'];
                $oldND1=$rows['oldND1'];
                $rate=$rows['rate'];
                $rateperhour=number_format((str_replace(',','',$rate)/8),6);
                $week1=$rows['week1'];
                $paid=$rows['paid'];
                $regular1=$rows['regular1'];
                $overtime1=$rows['overtime1'];
                $week2=$rows['week2'];
                $regular2=$rows['regular2'];
                $overtime2=$rows['overtime2'];
                $week3=$rows['week3'];
                $regular3=$rows['regular3'];
                $overtime3=$rows['overtime3'];
                $totalregular=$rows['totalregular'];
                $basicpay1=$rows['basicpay1'];
                $basicpay2=$rows['basicpay2'];
                $totalbasicpay=$rows['totalbasicpay'];
                $regularovertime=$rows['regularovertime'];
                $regularotpay=$rows['regularotpay'];
                $specialovertime1=$rows['specialovertime1'];
                $specialovertime2=$rows['specialovertime2'];
                $specialovertime3=$rows['specialovertime3'];
                $specialotpay=$rows['specialotpay'];
                $nightdifferential1=$rows['nightdifferential1'];
                $nightdifferential2=$rows['nightdifferential2'];
                $nightdifferential3=$rows['nightdifferential3'];
                $nighttimepay=$rows['nighttimepay'];
                $holiday=$rows['holiday'];
                $holidaypay=$rows['holidaypay'];
                $vacation=$rows['vacation'];
                $vacationpay=$rows['vacationpay'];
                $contentvl=mysql_query("SELECT * FROM employees WHERE employeenumber='$employeenumber'");
                $totalvl=mysql_affected_rows();
                for($vl=0; $vl<=$totalvl-1; $vl++)
                {
                    $rowsvl=mysql_fetch_array($contentvl);
                    $totalvacation=$rowsvl['totalvacation'];
                }
                $grosspay1=$rows['grosspay1'];
                $grosspay2=$rows['grosspay2'];
                $totalgrosspay=$rows['totalgrosspay'];
                $adjustment=$rows['adjustment'];
                $comment=$rows['comment'];
                $sssloan=$rows['sssloan'];
                $sssloan2=$rows['sssloan2'];
                $hdmfloan=$rows['hdmfloan'];
                $hdmfloan2=$rows['hdmfloan2'];
                $sss=$rows['sss'];
                $phic=$rows['phic'];
                $hdmf=$rows['hdmf'];
                $totaldeduction=$rows['totaldeduction'];
                $netpay=$rows['netpay'];
                $category=$rows['category'];
                $sssbracket=$rows['sssbracket'];
            }
            ?>
            <div style="zoom: 150%;">
            <div id="printReceipt2">
            <font size="1" face="Calibri">
            <?php include('include-payslip.php'); ?>
            </font>
            </div>
            </div>
            <br />
            <form method="post" action="transactions-payroll.php" novalidate>
            <input name="id" type="hidden" value="<?=$id;?>"/>
            <input name="payyear" type="hidden" value="<?=$payyear;?>"/>
            <input name="paymonth" type="hidden" value="<?=$paymonth;?>"/>
            <input name="startdate" type="hidden" value="<?=$startdate;?>"/>
            <input name="enddate" type="hidden" value="<?=$enddate;?>"/>
            <input name="cutoff" type="hidden" value="<?=$cutoff;?>"/>
            <input name="employeenumber" type="hidden" value="<?=$employeenumber;?>"/>
            <input name="fullname" type="hidden" value="<?=$fullname;?>"/>
            <input name="oldrate" type="hidden" value="<?=$oldrate;?>"/>
            <input name="oldrateperhour" type="hidden" value="<?=$oldrateperhour;?>"/>
            <input name="oldhrs" type="hidden" value="<?=$oldhrs;?>"/>
            <input name="oldOT1" type="hidden" value="<?=$oldOT1;?>"/>
            <input name="oldND1" type="hidden" value="<?=$oldND1;?>"/>
            <input name="rate" type="hidden" value="<?=$rate;?>"/>
            <input name="week1" type="hidden" value="<?=$week1;?>"/>
            <input name="paid" type="hidden" value="<?=$paid;?>"/>
            <input name="week2" type="hidden" value="<?=$week2;?>"/>
            <input name="week3" type="hidden" value="<?=$week3;?>"/>
            <input name="regular1" type="hidden" value="<?=$regular1;?>"/>
            <input name="regular2" type="hidden" value="<?=$regular2;?>"/>
            <input name="regular3" type="hidden" value="<?=$regular3;?>"/>
            <input name="overtime1" type="hidden" value="<?=$overtime1;?>"/>
            <input name="overtime2" type="hidden" value="<?=$overtime2;?>"/>
            <input name="overtime3" type="hidden" value="<?=$overtime3;?>"/>
            <input name="specialovertime1" type="hidden" value="<?=$specialovertime1;?>"/>
            <input name="specialovertime2" type="hidden" value="<?=$specialovertime2;?>"/>
            <input name="specialovertime3" type="hidden" value="<?=$specialovertime3;?>"/>
            <input name="nightdifferential1" type="hidden" value="<?=$nightdifferential1;?>"/>
            <input name="nightdifferential2" type="hidden" value="<?=$nightdifferential2;?>"/>
            <input name="nightdifferential3" type="hidden" value="<?=$nightdifferential3;?>"/>
            <input name="holiday" type="hidden" value="<?=$holiday;?>"/>
            <input name="vacation" type="hidden" value="<?=$vacation;?>"/>
            <input name="basicpay1" type="hidden" value="<?=$basicpay1;?>"/>
            <input name="grosspay1" type="hidden" value="<?=$grosspay1;?>"/>
            <input name="adjustment" type="hidden" value="<?=$adjustment;?>"/>
            <input name="comment" type="hidden" value="<?=$comment;?>"/>
            <input name="sssloan" type="hidden" value="<?=$sssloan;?>"/>
            <input name="sssloan2" type="hidden" value="<?=$sssloan2;?>"/>
            <input name="hdmfloan" type="hidden" value="<?=$hdmfloan;?>"/>
            <input name="hdmfloan2" type="hidden" value="<?=$hdmfloan2;?>"/>
            <input name="phic" type="hidden" value="<?=$phic;?>"/>
            <input name="hdmf" type="hidden" value="<?=$hdmf;?>"/>
            <input name="netpay" type="hidden" value="<?=$netpay;?>"/>
            <input name="category" type="hidden" value="<?=$category;?>"/>
            <input name="sssbracket" type="hidden" value="<?=$sssbracket;?>"/>
            <input style="height: 50px; width: 655px;" class="form-control btn btn-lg btn-info" type="button" onclick="printDiv2('printReceipt2')" value="PRINT RECEIPT"/><br />
            <input style="height: 50px; width: 655px;" class="form-control btn btn-lg btn-success" type="submit" name="btnUpdate2" value="UPDATE RECORD"/>
            </form>
            <script>
                function printDiv2(divName)
                {
                    var printContents=document.getElementById(divName).innerHTML;
                    var originalContents=document.body.innerHTML;
                    document.body.innerHTML=printContents+"<hr style='width: 100%; height: 0px; margin: 20px 0 20px 0;'>"+printContents;
                    window.print();
                    document.body.innerHTML=originalContents;
                }
            </script>
            <br />
            <br />
        <?php
        }
        else if($cutoff=='Both')
        {
            $content=mysql_query("SELECT * FROM payroll WHERE employeenumber='$employeenumber' AND payyear='$payyear' AND paymonth='$paymonth' AND cutoff='1st'");
            $total=mysql_affected_rows();
            if($total<=0)
            { $hide='style="display: none;"'; }
            for($x=0; $x<=$total-1; $x++)
            {
                $rows=mysql_fetch_array($content);
                $id=$rows['id'];
                $payyear=$rows['payyear'];
                $paymonth=$rows['paymonth'];
                $startdate=$rows['startdate'];
                $enddate=$rows['enddate'];
                $cutoff=$rows['cutoff'];
                $employeetype=$rows['employeetype'];
                $employeenumber=$rows['employeenumber'];
                $fullname=$rows['fullname'];
                $oldrate=$rows['oldrate'];
                $oldrateperhour=$rows['oldrateperhour'];
                $oldhrs=$rows['oldhrs'];
                $oldOT1=$rows['oldOT1'];
                $oldND1=$rows['oldND1'];
                $rate=$rows['rate'];
                $rateperhour=number_format((str_replace(',','',$rate)/8),6);
                $week1=$rows['week1'];
                $paid=$rows['paid'];
                $regular1=$rows['regular1'];
                $overtime1=$rows['overtime1'];
                $week2=$rows['week2'];
                $regular2=$rows['regular2'];
                $overtime2=$rows['overtime2'];
                $week3=$rows['week3'];
                $regular3=$rows['regular3'];
                $overtime3=$rows['overtime3'];
                $totalregular=$rows['totalregular'];
                $basicpay1=$rows['basicpay1'];
                $basicpay2=$rows['basicpay2'];
                $totalbasicpay=$rows['totalbasicpay'];
                $regularovertime=$rows['regularovertime'];
                $regularotpay=$rows['regularotpay'];
                $specialovertime1=$rows['specialovertime1'];
                $specialovertime2=$rows['specialovertime2'];
                $specialovertime3=$rows['specialovertime3'];
                $specialotpay=$rows['specialotpay'];
                $nightdifferential1=$rows['nightdifferential1'];
                $nightdifferential2=$rows['nightdifferential2'];
                $nightdifferential3=$rows['nightdifferential3'];
                $nighttimepay=$rows['nighttimepay'];
                $holiday=$rows['holiday'];
                $holidaypay=$rows['holidaypay'];
                $vacation=$rows['vacation'];
                $vacationpay=$rows['vacationpay'];
                $contentvl=mysql_query("SELECT * FROM employees WHERE employeenumber='$employeenumber'");
                $totalvl=mysql_affected_rows();
                for($vl=0; $vl<=$totalvl-1; $vl++)
                {
                    $rowsvl=mysql_fetch_array($contentvl);
                    $totalvacation=$rowsvl['totalvacation'];
                }
                $grosspay1=$rows['grosspay1'];
                $grosspay2=$rows['grosspay2'];
                $totalgrosspay=$rows['totalgrosspay'];
                $adjustment=$rows['adjustment'];
                $comment=$rows['comment'];
                $sssloan=$rows['sssloan'];
                $sssloan2=$rows['sssloan2'];
                $hdmfloan=$rows['hdmfloan'];
                $hdmfloan2=$rows['hdmfloan2'];
                $sss=$rows['sss'];
                $phic=$rows['phic'];
                $hdmf=$rows['hdmf'];
                $totaldeduction=$rows['totaldeduction'];
                $netpay=$rows['netpay'];
                $category=$rows['category'];
                $sssbracket=$rows['sssbracket'];
            }
            ?>
            <div style="zoom: 150%;">
            <div id="printReceipt2">
            <font size="1" face="Calibri">
            <div <?=$hide;?>>
            <?php include('include-payslip.php'); ?>
            </div>
            </font>
            <?php
            if($hide==NULL)
            {
            ?>
                <hr style='width: 100%; height: 0px; margin: 20px 0 20px 0;'>
            <?php
            }
            $content=mysql_query("SELECT * FROM payroll WHERE employeenumber='$employeenumber' AND payyear='$payyear' AND paymonth='$paymonth' AND cutoff='2nd'");
            $total=mysql_affected_rows();
            for($x=0; $x<=$total-1; $x++)
            {
                $rows=mysql_fetch_array($content);
                $id=$rows['id'];
                $payyear=$rows['payyear'];
                $paymonth=$rows['paymonth'];
                $startdate=$rows['startdate'];
                $enddate=$rows['enddate'];
                $cutoff=$rows['cutoff'];
                $employeetype=$rows['employeetype'];
                $employeenumber=$rows['employeenumber'];
                $fullname=$rows['fullname'];
                $oldrate=$rows['oldrate'];
                $oldrateperhour=$rows['oldrateperhour'];
                $oldhrs=$rows['oldhrs'];
                $oldOT1=$rows['oldOT1'];
                $oldND1=$rows['oldND1'];
                $rate=$rows['rate'];
                $rateperhour=number_format((str_replace(',','',$rate)/8),6);
                $week1=$rows['week1'];
                $paid=$rows['paid'];
                $regular1=$rows['regular1'];
                $overtime1=$rows['overtime1'];
                $week2=$rows['week2'];
                $regular2=$rows['regular2'];
                $overtime2=$rows['overtime2'];
                $week3=$rows['week3'];
                $regular3=$rows['regular3'];
                $overtime3=$rows['overtime3'];
                $totalregular=$rows['totalregular'];
                $basicpay1=$rows['basicpay1'];
                $basicpay2=$rows['basicpay2'];
                $totalbasicpay=$rows['totalbasicpay'];
                $regularovertime=$rows['regularovertime'];
                $regularotpay=$rows['regularotpay'];
                $specialovertime1=$rows['specialovertime1'];
                $specialovertime2=$rows['specialovertime2'];
                $specialovertime3=$rows['specialovertime3'];
                $specialotpay=$rows['specialotpay'];
                $nightdifferential1=$rows['nightdifferential1'];
                $nightdifferential2=$rows['nightdifferential2'];
                $nightdifferential3=$rows['nightdifferential3'];
                $nighttimepay=$rows['nighttimepay'];
                $holiday=$rows['holiday'];
                $holidaypay=$rows['holidaypay'];
                $vacation=$rows['vacation'];
                $vacationpay=$rows['vacationpay'];
                $contentvl=mysql_query("SELECT * FROM employees WHERE employeenumber='$employeenumber'");
                $totalvl=mysql_affected_rows();
                for($vl=0; $vl<=$totalvl-1; $vl++)
                {
                    $rowsvl=mysql_fetch_array($contentvl);
                    $totalvacation=$rowsvl['totalvacation'];
                }
                $grosspay1=$rows['grosspay1'];
                $grosspay2=$rows['grosspay2'];
                $totalgrosspay=$rows['totalgrosspay'];
                $adjustment=$rows['adjustment'];
                $comment=$rows['comment'];
                $sssloan=$rows['sssloan'];
                $sssloan2=$rows['sssloan2'];
                $hdmfloan=$rows['hdmfloan'];
                $hdmfloan2=$rows['hdmfloan2'];
                $sss=$rows['sss'];
                $phic=$rows['phic'];
                $hdmf=$rows['hdmf'];
                $totaldeduction=$rows['totaldeduction'];
                $netpay=$rows['netpay'];
                $category=$rows['category'];
                $sssbracket=$rows['sssbracket'];
            }
            ?>
            <font size="1" face="Calibri">
            <?php include('include-payslip.php'); ?>
            </font>
            <?php
            if($hide!=NULL)
            {
            ?>
            <hr style='width: 100%; height: 0px; margin: 20px 0 20px 0;'>
            <font size="1" face="Calibri">
            <?php include('include-payslip.php'); ?>
            </font>
            <?php
            }
            ?>
            </div>
            </div>
            <br />
            <form>
            <input style="height: 50px; width: 655px;" class="form-control btn btn-lg btn-info" type="button" onclick="printDiv2('printReceipt2')" value="PRINT RECEIPT"/>
            </form>
            <script>
                function printDiv2(divName)
                {
                    var printContents=document.getElementById(divName).innerHTML;
                    var originalContents=document.body.innerHTML;
                    document.body.innerHTML=printContents;
                    window.print();
                    document.body.innerHTML=originalContents;
                }
            </script>
            <br />
            <br />
        <?php
        }
    }
}
?>
<form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<div class="form-group">
<?php
if(($_POST['payrollmode1']!=NULL && $_POST['payrollmode2']==NULL) || ($_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL))
{
?>
<div class="form-group">
<label style="width: 200px;">Payroll Mode 1 (Per Month)</label>
<select style="width: 250px; text-align-last: center;" class="form-control" name="payrollmode1">
    <option value="" disabled <?php if($_POST['payrollmode1']==NULL) echo 'selected'; ?>>---(select an option)---</option>
    <option value="1" <?php if($_POST['payrollmode1']=='1') echo 'selected'; ?>>Basic Pay (For PhilHealth)</option>
    <option value="2" <?php if($_POST['payrollmode1']=='2') echo 'selected'; ?>>Gross Pay (For S.S.S.)</option>
    <option value="3" <?php if($_POST['payrollmode1']=='3') echo 'selected'; ?>>Total Regular Hours</option>
    <option value="4" <?php if($_POST['payrollmode1']=='4') echo 'selected'; ?>>Regular Overtime Hours</option>
    <option value="5" <?php if($_POST['payrollmode1']=='5') echo 'selected'; ?>>Special Overtime Hours</option>
    <option value="6" <?php if($_POST['payrollmode1']=='6') echo 'selected'; ?>>Night Differential Hours</option>
    <option value="7" <?php if($_POST['payrollmode1']=='7') echo 'selected'; ?>>Vacation Leave Used</option>
    <option value="8" <?php if($_POST['payrollmode1']=='8') echo 'selected'; ?>>Basic Pay and Adjustments</option>
    <option value="9" <?php if($_POST['payrollmode1']=='9') echo 'selected'; ?>>Overtime Pay</option>
    <option value="10" <?php if($_POST['payrollmode1']=='10') echo 'selected'; ?>>Holiday Pay</option>
    <option value="11" <?php if($_POST['payrollmode1']=='11') echo 'selected'; ?>>Vacation Leave Pay</option>
    <option value="12" <?php if($_POST['payrollmode1']=='12') echo 'selected'; ?>>S.S.S. Contributions</option>
    <option value="13" <?php if($_POST['payrollmode1']=='13') echo 'selected'; ?>>P.H.I.C. Contributions</option>
    <option value="14" <?php if($_POST['payrollmode1']=='14') echo 'selected'; ?>>H.D.M.F. Contributions</option>
    <option value="15" <?php if($_POST['payrollmode1']=='15') echo 'selected'; ?>>S.S.S. SL</option>
    <option value="16" <?php if($_POST['payrollmode1']=='16') echo 'selected'; ?>>S.S.S. CL</option>
    <option value="17" <?php if($_POST['payrollmode1']=='17') echo 'selected'; ?>>H.D.M.F. STL</option>
    <option value="18" <?php if($_POST['payrollmode1']=='18') echo 'selected'; ?>>H.D.M.F. CL</option>
</select>
</div>
<div class="form-group" style="margin-left: 50px;">
    <label>Year</label>
    <input style="width: 100px;" class="form-control" type="number" name="year1" min="2000" max="2999" step="1" value="<?php if($_POST['year1']==NULL) { echo date("Y"); } else { echo $_POST['year1']; }?>">
</div><br />
<?php
}
if(($_POST['payrollmode1']==NULL && $_POST['payrollmode2']!=NULL) || ($_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL))
{
?>
<div class="form-group">
<label style="width: 200px;">Payroll Mode 2 (Per Cut-Off)</label>
<select style="width: 250px; text-align-last: center;" class="form-control" name="payrollmode2" data-placeholder="Select Pay Month">
    <option value="" disabled <?php if($_POST['payrollmode2']==NULL) echo 'selected'; ?>>---(select an option)---</option>
    <option value="JANUARY" <?php if($_POST['payrollmode2']=='JANUARY') echo 'selected'; ?>>JANUARY</option>
    <option value="FEBRUARY" <?php if($_POST['payrollmode2']=='FEBRUARY') echo 'selected'; ?>>FEBRUARY</option>
    <option value="MARCH" <?php if($_POST['payrollmode2']=='MARCH') echo 'selected'; ?>>MARCH</option>
    <option value="APRIL" <?php if($_POST['payrollmode2']=='APRIL') echo 'selected'; ?>>APRIL</option>
    <option value="MAY" <?php if($_POST['payrollmode2']=='MAY') echo 'selected'; ?>>MAY</option>
    <option value="JUNE" <?php if($_POST['payrollmode2']=='JUNE') echo 'selected'; ?>>JUNE</option>
    <option value="JULY" <?php if($_POST['payrollmode2']=='JULY') echo 'selected'; ?>>JULY</option>
    <option value="AUGUST" <?php if($_POST['payrollmode2']=='AUGUST') echo 'selected'; ?>>AUGUST</option>
    <option value="SEPTEMBER" <?php if($_POST['payrollmode2']=='SEPTEMBER') echo 'selected'; ?>>SEPTEMBER</option>
    <option value="OCTOBER" <?php if($_POST['payrollmode2']=='OCTOBER') echo 'selected'; ?>>OCTOBER</option>
    <option value="NOVEMBER" <?php if($_POST['payrollmode2']=='NOVEMBER') echo 'selected'; ?>>NOVEMBER</option>
    <option value="DECEMBER" <?php if($_POST['payrollmode2']=='DECEMBER') echo 'selected'; ?>>DECEMBER</option>
</select>
</div>
<div class="form-group" style="margin-left: 50px;">
    <label>Year</label>
    <input style="width: 100px;" class="form-control" type="number" name="year2" min="2000" max="2999" step="1" value="<?php if($_POST['year2']==NULL) { echo date("Y"); } else { echo $_POST['year2']; }?>">
</div><br />
<?php
if($_POST['cutoff2']=='1st')
{
    $checked1='checked';
    $checked2=NULL;
}
else if($_POST['cutoff2']=='2nd')
{
    $checked1=NULL;
    $checked2='checked';
}
else
{
    $checked1='checked';
    $checked2=NULL;
}
?>
<div class="form-group">
    <label class="radio-inline"><input type="radio" name="cutoff2" value="1st" <?=$checked1;?> required>1st Cut-Off</label>
    <label class="radio-inline"><input type="radio" name="cutoff2" value="2nd" <?=$checked2;?>>2nd Cut-Off</label>
</div>
</div><br />
<?php
}
?>
<br />
<input style="width: 100px;" class="form-control btn btn-primary" name="btnSelect1" type="submit" value="SELECT">
<a style="width: 100px;" href="reports-payroll.php" class="form-control btn btn-success" role="button">BACK</a>
</form>
<br />
<?php
if($_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL)
{
?>
<form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<div class="form-group">
<div class="form-group" style="margin-right: 20px;">
    <label>Month</label>
    <select style="width: 200px; text-align-last: center;" class="form-control" name="month">
        <option value="" disabled <?php if($_SESSION['month']==NULL) echo 'selected'; ?>>---(select an option)---</option>
        <option value="JANUARY" <?php if($_SESSION['month']=='JANUARY') echo 'selected'; ?>>JANUARY</option>
        <option value="FEBRUARY" <?php if($_SESSION['month']=='FEBRUARY') echo 'selected'; ?>>FEBRUARY</option>
        <option value="MARCH" <?php if($_SESSION['month']=='MARCH') echo 'selected'; ?>>MARCH</option>
        <option value="APRIL" <?php if($_SESSION['month']=='APRIL') echo 'selected'; ?>>APRIL</option>
        <option value="MAY" <?php if($_SESSION['month']=='MAY') echo 'selected'; ?>>MAY</option>
        <option value="JUNE" <?php if($_SESSION['month']=='JUNE') echo 'selected'; ?>>JUNE</option>
        <option value="JULY" <?php if($_SESSION['month']=='JULY') echo 'selected'; ?>>JULY</option>
        <option value="AUGUST" <?php if($_SESSION['month']=='AUGUST') echo 'selected'; ?>>AUGUST</option>
        <option value="SEPTEMBER" <?php if($_SESSION['month']=='SEPTEMBER') echo 'selected'; ?>>SEPTEMBER</option>
        <option value="OCTOBER" <?php if($_SESSION['month']=='OCTOBER') echo 'selected'; ?>>OCTOBER</option>
        <option value="NOVEMBER" <?php if($_SESSION['month']=='NOVEMBER') echo 'selected'; ?>>NOVEMBER</option>
        <option value="DECEMBER" <?php if($_SESSION['month']=='DECEMBER') echo 'selected'; ?>>DECEMBER</option>
    </select>
</div>
<?php
if($_SESSION['cutoff']=='1st')
{
    $checked1=NULL;
    $checked2='checked';
    $checked3=NULL;
}
if($_SESSION['cutoff']=='2nd')
{
    $checked1=NULL;
    $checked2=NULL;
    $checked3='checked';
}
if($_SESSION['cutoff']=='Both')
{
    $checked1='checked';
    $checked2=NULL;
    $checked3=NULL;
}
?>
<div class="form-group" style="margin-left: 45px; margin-top: 15px; margin-bottom: 15px;">
    <label class="radio-inline"><input type="radio" name="cutoff" value="Both" <?=$checked1;?> required>1st/2nd Cut-Off</label>
    <label class="radio-inline"><input type="radio" name="cutoff" value="1st" <?=$checked2;?>>1st Cut-Off</label>
    <label class="radio-inline"><input type="radio" name="cutoff" value="2nd" <?=$checked3;?>>2nd Cut-Off</label>
</div>
<div class="form-group" style="margin-left: 50px;">
    <label>Year</label>
    <input style="width: 100px;" class="form-control" type="number" name="year" min="2000" max="2999" step="1" value="<?php if($_SESSION['year']==NULL) { echo date("Y"); } else { echo $_SESSION['year']; }?>">
</div>
<br />
<label for="employee">Employee Name</label>
<?php
$placeholder=$_SESSION['employee'];
if($placeholder==NULL)
{ $placeholder='--optional-- (select an option)'; }
?>
<select style="width: 450px;" class="form-control chosen-select" id="employee" name="employee" data-placeholder="<?php echo($placeholder);?>">
<option></option>
<?php
if($array==NULL)
{
    ?>
    <optgroup label="Contractual">
    <?php
    $content=mysql_query("SELECT * FROM employees WHERE".$where."employeetype='CONTRACTUAL' ORDER BY lastname ASC");
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $employeenumber=$rows['employeenumber'];
        $lastname=$rows['lastname'];
        $firstname=$rows['firstname'];
        $fullname=$lastname.', '.$firstname;
        ?>
        <option value="<?=$employeenumber;?>" <?php if($_SESSION['employee']==$employeenumber) echo 'selected'; ?>><?php echo($fullname);?></option>
    <?php
    }
    ?>
    </optgroup>
    <?php
    ?>
    <optgroup label="Office">
    <?php
    $content=mysql_query("SELECT * FROM employees WHERE".$where."employeetype='OFFICE' ORDER BY lastname ASC");
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $employeenumber=$rows['employeenumber'];
        $lastname=$rows['lastname'];
        $firstname=$rows['firstname'];
        $fullname=$lastname.', '.$firstname;
        ?>
        <option value="<?=$employeenumber;?>" <?php if($_SESSION['employee']==$employeenumber) echo 'selected'; ?>><?php echo($fullname);?></option>
    <?php
    }
    ?>
    </optgroup>
    <?php
    ?>
    <optgroup label="Production">
    <?php
    $content=mysql_query("SELECT * FROM employees WHERE".$where."employeetype='PRODUCTION' ORDER BY lastname ASC");
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $employeenumber=$rows['employeenumber'];
        $lastname=$rows['lastname'];
        $firstname=$rows['firstname'];
        $fullname=$lastname.', '.$firstname;
        ?>
        <option value="<?=$employeenumber;?>" <?php if($_SESSION['employee']==$employeenumber) echo 'selected'; ?>><?php echo($fullname);?></option>
    <?php
    }
    ?>
    </optgroup>
    <?php
    ?>
    <optgroup label="Provincial">
    <?php
    $content=mysql_query("SELECT * FROM employees WHERE".$where."employeetype='PROVINCIAL' ORDER BY lastname ASC");
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $employeenumber=$rows['employeenumber'];
        $lastname=$rows['lastname'];
        $firstname=$rows['firstname'];
        $fullname=$lastname.', '.$firstname;
        ?>
        <option value="<?=$employeenumber;?>" <?php if($_SESSION['employee']==$employeenumber) echo 'selected'; ?>><?php echo($fullname);?></option>
    <?php
    }
    ?>
    </optgroup>
    <?php
    ?>
    <optgroup label="Store">
    <?php
    $content=mysql_query("SELECT * FROM employees WHERE".$where."employeetype='STORE' ORDER BY lastname ASC");
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $employeenumber=$rows['employeenumber'];
        $lastname=$rows['lastname'];
        $firstname=$rows['firstname'];
        $fullname=$lastname.', '.$firstname;
        ?>
        <option value="<?=$employeenumber;?>" <?php if($_SESSION['employee']==$employeenumber) echo 'selected'; ?>><?php echo($fullname);?></option>
    <?php
    }
    ?>
    </optgroup>
    <?php
    ?>
    <optgroup label="Supermarket">
    <?php
    $content=mysql_query("SELECT * FROM employees WHERE".$where."employeetype='SUPERMARKET' ORDER BY lastname ASC");
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $employeenumber=$rows['employeenumber'];
        $lastname=$rows['lastname'];
        $firstname=$rows['firstname'];
        $fullname=$lastname.', '.$firstname;
        ?>
        <option value="<?=$employeenumber;?>" <?php if($_SESSION['employee']==$employeenumber) echo 'selected'; ?>><?php echo($fullname);?></option>
    <?php
    }
    ?>
    </optgroup>
    <?php
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
</select><br />
<?php
if($_SESSION['printslip']=='payslip')
{
    $checked1='checked';
    $checked2=NULL;
}
if($_SESSION['printslip']=='thirteenthmonth')
{
    $checked1=NULL;
    $checked2='checked';
}
?>
<div class="form-group" style="margin-top: 10px;">
    <label class="radio-inline"><input type="radio" name="printslip" value="payslip" <?=$checked1;?> required>Payslip</label>
    <label class="radio-inline"><input type="radio" name="printslip" value="thirteenthmonth" <?=$checked2;?>>13th Month Pay</label>
</div><br /><br />
<input style="width: 100px;" class="form-control btn btn-primary" name="btnSelect" type="submit" value="SELECT">
<input class="form-control btn btn-success" name="btnShowAll" type="submit" value="SHOW ALL RECORDS">
<input style="width: 100px;" class="form-control btn btn-warning" name="btnReset" type="submit" value="RESET">
</div>
</form>
<br />
<?php
if(isset($_POST['btnSelect']))
{
    $_SESSION['month']=$_POST['month'];
    $_SESSION['cutoff']=$_POST['cutoff'];
    $_SESSION['year']=$_POST['year'];
    $_SESSION['printslip']=$_POST['printslip'];
    $_SESSION['employee']=$_POST['employee'];
    $_SESSION['showall']=NULL;
    $_SESSION['contents']='show';
    reload_page();
}
if(isset($_POST['btnShowAll']))
{
    $_SESSION['month']=NULL;
    $_SESSION['cutoff']=NULL;
    $_SESSION['year']=NULL;
    $_SESSION['printslip']=NULL;
    $_SESSION['employee']=NULL;
    $_SESSION['showall']='true';
    $_SESSION['contents']='show';
    reload_page();
}
if(isset($_POST['btnReset']))
{
    $_SESSION['month']=NULL;
    $_SESSION['cutoff']=NULL;
    $_SESSION['year']=NULL;
    $_SESSION['printslip']=NULL;
    $_SESSION['employee']=NULL;
    $_SESSION['showall']=NULL;
    $_SESSION['contents']=NULL;
    reload_page();
}
$month=$_SESSION['month'];
$cutoff=$_SESSION['cutoff'];
$payyear=$_SESSION['year'];
$employee=$_SESSION['employee'];
$printslip=$_SESSION['printslip'];
if(!isset($_POST['btnSelect1']))
{
    if($_SESSION['visibility']!='hidden')
    {
        $hidden=array();
        $hidden[]=' ';
        $contentx=mysql_query("SELECT * FROM employees WHERE status='hidden' ORDER BY employeetype ASC, lastname ASC");
        $totalx=mysql_affected_rows();
        for($a=0; $a<=$totalx-1; $a++)
        {
            $rowsx=mysql_fetch_array($contentx);
            array_push($hidden," AND NOT employeenumber='".$rowsx['employeenumber']."'");
        }
        $filter=implode($hidden);
        $filter2='WHERE'.substr($filter, 5);
        $concat='(EXCLUDING hidden record/s).';
        if($totalx>0)
        { $where2=' AND'; }
    }
    else
    {
        $concat='(INCLUDING hidden record/s).';
        $where2='WHERE';
    }

    if($printslip!='thirteenthmonth')
    {
    if($_SESSION['showall']=='true')
    {
        $query="SELECT * FROM payroll ".$filter2." ORDER BY startdate DESC, employeetype ASC, fullname ASC";
        $content=mysql_query($query);
        $total=mysql_affected_rows();
            if($total>0)
            { $alert='SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s of ALL employees.'; }
            else
            {
                $alert='ERROR: No matching records found!';
                $_SESSION['contents']=NULL;
                $total=0;
            }
        $optimize=true;
    }
    else
    {
    if($employee!=NULL)
    {
        if($month!=NULL && $payyear==NULL && $_SESSION['contents']=='show')
        {
            $alert='ERROR: Year is required if Month is selected!!!';
            $total=0;
        }
        else if($month==NULL && $cutoff!=NULL && $cutoff!='Both' && $_SESSION['contents']=='show')
        {
            $alert='ERROR: Month is required if Cut-Off is selected!!!';
            $total=0;
        }
        else if($month==NULL && $payyear==NULL && $_SESSION['contents']=='show')
        {
            $query="SELECT * FROM payroll WHERE employeenumber='".$employee."'".$filter." ORDER BY startdate DESC, employeetype ASC, fullname ASC";
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            $contentz=mysql_query("SELECT * FROM employees where employeenumber='$employee'");
            $totalz=mysql_affected_rows();
            for($z=0; $z<=$totalz-1; $z++)
            {
                $rowsz=mysql_fetch_array($contentz);
                $fullname=$rowsz['lastname'].', '.$rowsz['firstname'];
            }
                if($total>0)
                { $alert='SUCCESS: '.$total.' matching record/s found.\nShowing ALL record/s of '.$fullname.'.'; }
                else
                { $alert='ERROR: No matching records found!'; }
            $optimize=true;
        }
        else if($month==NULL && $cutoff=='Both' && $payyear!=NULL && $_SESSION['contents']=='show')
        {
            $query="SELECT * FROM payroll WHERE employeenumber='".$employee."' AND payyear='$payyear'".$filter." ORDER BY startdate DESC, employeetype ASC, fullname ASC";
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            $contentz=mysql_query("SELECT * FROM employees where employeenumber='$employee'");
            $totalz=mysql_affected_rows();
            for($z=0; $z<=$totalz-1; $z++)
            {
                $rowsz=mysql_fetch_array($contentz);
                $fullname=$rowsz['lastname'].', '.$rowsz['firstname'];
            }
                if($total>0)
                { $alert='SUCCESS: '.$total.' matching record/s found.\nShowing all '.$payyear.' record/s of '.$fullname.'.'; }
                else
                { $alert='ERROR: No matching records found!'; }
            $optimize=true;
        }
        else if($month!=NULL && $cutoff!='Both' && $_SESSION['contents']=='show')
        {
            $query="SELECT * FROM payroll WHERE paymonth='".$month."' AND payyear='$payyear' AND cutoff='".$cutoff."' AND employeenumber='".$employee."'".$filter." ORDER BY startdate DESC, employeetype ASC, fullname ASC";
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            $contentz=mysql_query("SELECT * FROM employees where employeenumber='$employee'");
            $totalz=mysql_affected_rows();
            for($z=0; $z<=$totalz-1; $z++)
            {
                $rowsz=mysql_fetch_array($contentz);
                $fullname=$rowsz['lastname'].', '.$rowsz['firstname'];
            }
                if($total>0)
                { $alert='SUCCESS: '.$total.' matching record/s found.\nShowing record/s of '.$fullname.' for the '.$cutoff.' Cut-Off of '.$month.' '.$payyear.'.'; }
                else
                { $alert='ERROR: No matching records found!'; }
        }
        else if($month!=NULL && $cutoff=='Both' && $_SESSION['contents']=='show')
        {
            $query="SELECT * FROM payroll WHERE paymonth='".$month."' AND payyear='$payyear' AND employeenumber='".$employee."'".$filter." ORDER BY startdate DESC, employeetype ASC, fullname ASC";
            $content=mysql_query($query);
            $total=mysql_affected_rows();
            $contentz=mysql_query("SELECT * FROM employees where employeenumber='$employee'");
            $totalz=mysql_affected_rows();
            for($z=0; $z<=$totalz-1; $z++)
            {
                $rowsz=mysql_fetch_array($contentz);
                $fullname=$rowsz['lastname'].', '.$rowsz['firstname'];
            }
                if($total>0)
                { $alert='SUCCESS: '.$total.' matching record/s found.\nShowing record/s of '.$fullname.' for '.$month.' '.$payyear.'.'; }
                else
                { $alert='ERROR: No matching records found!'; }
        }
        else
        {
            alert("NOTICE: Please select record details to be displayed...");
            $_SESSION['contents']=NULL;
            $total=0;
        }
    }
    else
    {
        if($month!=NULL && $payyear==NULL && $_SESSION['contents']=='show')
        {
            $alert='ERROR: Year is required if Month is selected!!!';
            $total=0;
        }
        else if($month==NULL && $cutoff!=NULL && $cutoff!='Both' && $_SESSION['contents']=='show')
        {
            $alert='ERROR: Month is required if Cut-Off is selected!!!';
            $total=0;
        }
        else if($month==NULL && $payyear==NULL && $_SESSION['contents']=='show')
        {
            $alert='ERROR: Month and/or Year is a required input!!!';
            $total=0;
        }
        else if($month==NULL && $cutoff=='Both' && $payyear!=NULL && $_SESSION['contents']=='show')
        {
            $query="SELECT * FROM payroll WHERE payyear='$payyear'".$filter." ORDER BY startdate DESC, employeetype ASC, fullname ASC";
            $content=mysql_query($query);
            $total=mysql_affected_rows();
                if($total>0)
                { $alert='SUCCESS: '.$total.' matching record/s found.\nShowing all '.$payyear.' record/s of all employees.'; }
                else
                { $alert='ERROR: No matching records found!'; }
            $optimize=true;
        }
        else if($month!=NULL && $cutoff!='Both' && $_SESSION['contents']=='show')
        {
            $query="SELECT * FROM payroll WHERE paymonth='".$month."' AND payyear='$payyear' AND cutoff='".$cutoff."'".$filter." ORDER BY startdate DESC, employeetype ASC, fullname ASC";
            $content=mysql_query($query);
            $total=mysql_affected_rows();
                if($total>0)
                { $alert='SUCCESS: '.$total.' matching record/s found.\nShowing record/s of all employees for the '.$cutoff.' Cut-Off of '.$month.' '.$payyear.'.'; }
                else
                { $alert='ERROR: No matching records found!'; }
        }
        else if($month!=NULL && $cutoff=='Both' && $_SESSION['contents']=='show')
        {
            $query="SELECT * FROM payroll WHERE paymonth='".$month."' AND payyear='$payyear'".$filter." ORDER BY startdate DESC, employeetype ASC, fullname ASC";
            $content=mysql_query($query);
            $total=mysql_affected_rows();
                if($total>0)
                { $alert='SUCCESS: '.$total.' matching record/s found.\nShowing record/s of all employees for '.$month.' '.$payyear.'.'; }
                else
                { $alert='ERROR: No matching records found!'; }
        }
        else
        {
            alert("NOTICE: Please select record details to be displayed...");
            $_SESSION['contents']=NULL;
            $total=0;
        }
    }
    }
    if($alert!=NULL)
    {
        $_SESSION['payrollquery']=str_replace(' employeetype ASC,','',$query);
        $_SESSION['payrollalert']=$alert.'\n'.$concat;
        alert($_SESSION['payrollalert']);
    }
    }
    else
    {
        if($payyear==NULL && $employee==NULL)
        { alert("ERROR: Year and Employee Name are required for 13th Month Pay Receipt!!!"); }
        else if($payyear==NULL)
        { alert("ERROR: Year is required for 13th Month Pay Receipt!!!"); }
        else if($employee==NULL)
        { alert("ERROR: Employee Name is required for 13th Month Pay Receipt!!!"); }
        $_SESSION['month']=NULL;
        $_SESSION['cutoff']=NULL;
        $_SESSION['showall']=NULL;
        $_SESSION['contents']=NULL;
        $total=0;
    }
    if($optimize==true)
    {
        $_SESSION['tblname']='optimize_payroll_report';
        $json_array=array();
        while($row=mysql_fetch_assoc($content))
        { $json_array[]=$row; }
        $json_data=json_encode($json_array);
        file_put_contents('data/reports-payroll.json','{"data":'.$json_data.'}');
        ?>
        <div class="alert alert-info">
            <strong>NOTICE: </strong>Single SELECT button/s have been disabled to optimize table display speed. Please fill out record details to be displayed or selected instead from the form above...
        </div>
        <?php
    }
    else
    { $_SESSION['tblname']='payroll_report'; }
    ?>
    <div style="<?=$tbldisplay;?>">
    <table id="<?=$_SESSION['tblname'];?>" class="table-striped nowrap">
    <thead style="background-color: white;">
    <?php
    if($optimize!=true)
    {
    ?>
    <th>Action</th>
    <?php
    }
    ?>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Cut-Off</th>
    <th>Employee Type</th>
    <th>Employee #</th>
    <th>Employee Name</th>
    <th class="sum">Total Regular Hours</th>
    <th class="sum">Current Basic Pay</th>
    <th class="sum">Regular Overtime Hours</th>
    <th class="sum">Regular Overtime Pay</th>
    <th class="sum">Total Special Overtime</th>
    <th class="sum">Special Overtime Pay</th>
    <th class="sum">Total Night Differential</th>
    <th class="sum">Night Differential Pay</th>
    <th class="sum">Holiday</th>
    <th class="sum">Holiday Pay</th>
    <th class="sum">Vacation</th>
    <th class="sum">Vacation Pay</th>
    <th class="sum">Current Gross Pay</th>
    <th class="sum">Adjustment</th>
    <th class="sum">S.S.S. SL</th>
    <th class="sum">S.S.S. CL</th>
    <th class="sum">H.D.M.F. STL</th>
    <th class="sum">H.D.M.F. CL</th>
    <th class="sum">S.S.S.</th>
    <th class="sum">P.H.I.C.</th>
    <th class="sum">H.D.M.F.</th>
    <th class="sum">Total Deduction</th>
    <th class="sum">Net Pay</th>
    <?php
    if($optimize!=true)
    {
    ?>
    <th>Signature</th>
    <?php
    }
    ?>
    </thead>
    <tbody>
    <?php
    if($optimize!=true)
    {
        $ctr=0;
        while($rows=mysql_fetch_array($content))
        {
            $ctr=$ctr+1;
            ?>
            <tr>
            <?php
            $id=$rows['id'];
            $payyear=$rows['payyear'];
            $paymonth=$rows['paymonth'];
            $startdate=$rows['startdate'];
            $enddate=$rows['enddate'];
            $cutoff=$rows['cutoff'];
            $employeetype=$rows['employeetype'];
            $employeenumber=$rows['employeenumber'];
            $fullname=$rows['fullname'];
            $rate=$rows['rate'];
            $rateperhour=number_format((str_replace(',','',$rate)/8),6);
            $overalltotal=$rows['overalltotal'];
            $week1=$rows['week1'];
            $paid=$rows['paid'];
            $regular1=$rows['regular1'];
            $overtime1=$rows['overtime1'];
            $week2=$rows['week2'];
            $regular2=$rows['regular2'];
            $overtime2=$rows['overtime2'];
            $week3=$rows['week3'];
            $regular3=$rows['regular3'];
            $overtime3=$rows['overtime3'];
            $totalregular=$rows['totalregular'];
            $basicpay1=$rows['basicpay1'];
            $basicpay2=$rows['basicpay2'];
            $totalbasicpay=$rows['totalbasicpay'];
            $regularovertime=$rows['regularovertime'];
            $regularotpay=$rows['regularotpay'];
            $specialovertime1=$rows['specialovertime1'];
            $specialovertime2=$rows['specialovertime2'];
            $specialovertime3=$rows['specialovertime3'];
            $totalspecialot=$rows['totalspecialot'];
            $specialotpay=$rows['specialotpay'];
            $nightdifferential1=$rows['nightdifferential1'];
            $nightdifferential2=$rows['nightdifferential2'];
            $nightdifferential3=$rows['nightdifferential3'];
            $totalnightdiff=$rows['totalnightdiff'];
            $nighttimepay=$rows['nighttimepay'];
            $holiday=$rows['holiday'];
            $holidaypay=$rows['holidaypay'];
            $vacation=$rows['vacation'];
            $vacationpay=$rows['vacationpay'];
            $contentvl=mysql_query("SELECT * FROM employees WHERE employeenumber='$employeenumber'");
            $totalvl=mysql_affected_rows();
            for($vl=0; $vl<=$totalvl-1; $vl++)
            {
                $rowsvl=mysql_fetch_array($contentvl);
                $totalvacation=$rowsvl['totalvacation'];
            }
            $grosspay1=$rows['grosspay1'];
            $grosspay2=$rows['grosspay2'];
            $totalgrosspay=$rows['totalgrosspay'];
            $adjustment=$rows['adjustment'];
            $comment=$rows['comment'];
            $sssloan=$rows['sssloan'];
            $sssloan2=$rows['sssloan2'];
            $hdmfloan=$rows['hdmfloan'];
            $hdmfloan2=$rows['hdmfloan2'];
            $sss=$rows['sss'];
            $phic=$rows['phic'];
            $hdmf=$rows['hdmf'];
            $totaldeduction=$rows['totaldeduction'];
            $netpay=$rows['netpay'];
            $sssbracket=$rows['sssbracket'];
            $words=explode(' ',$fullname);
            $signature=NULL;
            foreach($words as $w)
            { $signature.=$w[0]; }
            $signature.='_______________';
            if($cutoff=='2nd')
            {
                $content1=mysql_query("SELECT * FROM payroll WHERE employeenumber='$employeenumber' AND payyear='$payyear' AND paymonth='$paymonth' AND cutoff='1st'");
                $total1=mysql_affected_rows();
                for($x1=0; $x1<=$total1-1; $x1++)
                {
                    $rows1=mysql_fetch_array($content1);
                }
                if($basicpay2!=$rows1['basicpay1'])
                {
                    $basicpay2=$rows1['basicpay1'];
                    alert($basicpay2);
                    $totalbasicpay=number_format((str_replace(',','',$basicpay1))+(str_replace(',','',$basicpay2)),2);
                    $tb=str_replace(',','',$totalbasicpay);
                    if($payyear<2020)
                    {
                        $phic1='137.50';
                        $phic2='0.0275';
                    }
                    else if($payyear==2020)
                    {
                        $phic1='150.00';
                        $phic2='0.03';
                    }
                    else if($payyear==2021)
                    {
                        $phic1='150.00';
                        $phic2='0.03';
                    }
                    else if($paymonth=='MAY' && $payyear==2022)
                    {
                        $phic1='150.00';
                        $phic2='0.03';
                    }
                    else if($paymonth!='MAY' && $payyear==2022)
                    {
                        $phic1='200.00';
                        $phic2='0.04';
                    }
                    else if($payyear==2023)
                    {
                        $phic1='200.00';
                        $phic2='0.04';
                    }
                    else if($payyear==2024)
                    {
                        $phic1='250.00';
                        $phic2='0.05';
                    }
                    else if($payyear>2024)
                    {
                        $phic1='250.00';
                        $phic2='0.05';
                    }
                    if($tb<=10000)
                    { $phic=number_format(($phic1),2); }
                    else if($tb>=10000.01)
                    { $phic=number_format((($tb*$phic2)/2),2); }
                    if($rows1['basicpay1']==NULL)
                    { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
                    else
                    { $hdmf='0.00'; }
                    if(strpos($sssbracket,'new')!==false)
                    {
                        $grosspay2=$rows1['grosspay1'];
                        $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                        $tg=str_replace(',','',$totalgrosspay);
                        do
                        {
                            if($payyear>=2025)
                            {
                                if      ($tg >= 29749.99)   $sss = 1000.00;
                                else if ($tg >= 29249.99)   $sss = 1000.00;
                                else if ($tg >= 28749.99)   $sss = 1000.00;
                                else if ($tg >= 28249.99)   $sss = 1000.00;
                                else if ($tg >= 27749.99)   $sss = 1000.00;
                                else if ($tg >= 27249.99)   $sss = 1000.00;
                                else if ($tg >= 26749.99)   $sss = 1000.00;
                                else if ($tg >= 26249.99)   $sss = 1000.00;
                                else if ($tg >= 25749.99)   $sss = 1000.00;
                                else if ($tg >= 25249.99)   $sss = 1000.00;
                                else if ($tg >= 24749.99)   $sss = 1000.00;
                                else if ($tg >= 24249.99)   $sss = 1000.00;
                                else if ($tg >= 23749.99)   $sss = 1000.00;
                                else if ($tg >= 23249.99)   $sss = 1000.00;
                                else if ($tg >= 22749.99)   $sss = 1000.00;
                                else if ($tg >= 22249.99)   $sss = 1000.00;
                                else if ($tg >= 21749.99)   $sss = 1000.00;
                                else if ($tg >= 21249.99)   $sss = 1000.00;
                                else if ($tg >= 20749.99)   $sss = 1000.00;
                                else if ($tg >= 20249.99)   $sss = 1000.00;
                                else if ($tg >= 19749.99)   $sss = 975.00;
                                else if ($tg >= 19249.99)   $sss = 950.00;
                                else if ($tg >= 18749.99)   $sss = 925.00;
                                else if ($tg >= 18249.99)   $sss = 900.00;
                                else if ($tg >= 17749.99)   $sss = 875.00;
                                else if ($tg >= 17249.99)   $sss = 850.00;
                                else if ($tg >= 16749.99)   $sss = 825.00;
                                else if ($tg >= 16249.99)   $sss = 800.00;
                                else if ($tg >= 15749.99)   $sss = 775.00;
                                else if ($tg >= 15249.99)   $sss = 750.00;
                                else if ($tg >= 14749.99)   $sss = 725.00;
                                else if ($tg >= 14249.99)   $sss = 700.00;
                                else if ($tg >= 13749.99)   $sss = 675.00;
                                else if ($tg >= 13249.99)   $sss = 650.00;
                                else if ($tg >= 12749.99)   $sss = 625.00;
                                else if ($tg >= 12249.99)   $sss = 600.00;
                                else if ($tg >= 11749.99)   $sss = 575.00;
                                else if ($tg >= 11249.99)   $sss = 550.00;
                                else if ($tg >= 10749.99)   $sss = 525.00;
                                else if ($tg >= 10249.99)   $sss = 500.00;
                                else if ($tg >= 9749.99)    $sss = 475.00;
                                else if ($tg >= 9249.99)    $sss = 450.00;
                                else if ($tg >= 8749.99)    $sss = 425.00;
                                else if ($tg >= 8249.99)    $sss = 400.00;
                                else if ($tg >= 7749.99)    $sss = 375.00;
                                else if ($tg >= 7249.99)    $sss = 350.00;
                                else if ($tg >= 6749.99)    $sss = 325.00;
                                else if ($tg >= 6249.99)    $sss = 300.00;
                                else if ($tg >= 5749.99)    $sss = 275.00;
                                else if ($tg <  5250.00)    $sss = 250.00;
                                else                        $sss = 250.00;
                            }
                            else if($payyear>=2023)
                            {
                                if($tg<4250.00)
                                { $sss=180.00; }
                                else if($tg<=4749.99)
                                { $sss=202.50; }
                                else if($tg<=5249.99)
                                { $sss=225.00; }
                                else if($tg<=5749.99)
                                { $sss=247.50; }
                                else if($tg<=6249.99)
                                { $sss=270.00; }
                                else if($tg<=6749.99)
                                { $sss=292.50; }
                                else if($tg<=7249.99)
                                { $sss=315.00; }
                                else if($tg<=7749.99)
                                { $sss=337.50; }
                                else if($tg<=8249.99)
                                { $sss=360.00; }
                                else if($tg<=8749.99)
                                { $sss=382.50; }
                                else if($tg<=9249.99)
                                { $sss=405.00; }
                                else if($tg<= 9749.99)
                                { $sss=427.50; }
                                else if($tg<=10249.99)
                                { $sss=450.00; }
                                else if($tg<=10749.99)
                                { $sss=472.50; }
                                else if($tg<=11249.99)
                                { $sss=495.00; }
                                else if($tg<=11749.99)
                                { $sss=517.50; }
                                else if($tg<=12249.99)
                                { $sss=540.00; }
                                else if($tg<=12749.99)
                                { $sss=562.50; }
                                else if($tg<=13249.99)
                                { $sss=585.00; }
                                else if($tg<=13749.99)
                                { $sss=607.50; }
                                else if($tg<=14249.99)
                                { $sss=630.00; }
                                else if($tg<=14749.99)
                                { $sss=652.50; }
                                else if($tg<=15249.99)
                                { $sss=675.00; }
                                else if($tg<=15749.99)
                                { $sss=697.50; }
                                else if($tg<=16249.99)
                                { $sss=720.00; }
                                else if($tg<=16749.99)
                                { $sss=742.50; }
                                else if($tg<=17249.99)
                                { $sss=765.00; }
                                else if($tg<=17749.99)
                                { $sss=787.50; }
                                else if($tg<=18249.99)
                                { $sss=810.00; }
                                else if($tg<=18749.99)
                                { $sss=832.50; }
                                else if($tg<=19249.99)
                                { $sss=855.00; }
                                else if($tg<=19749.99)
                                { $sss=877.50; }
                                else if($tg<=20249.99)
                                { $sss=900.00; }
                                else if($tg<= 20749.99)
                                { $sss=877.50; }
                                else if($tg<=21249)
                                { $sss=900.00; }
                                else
                                { $sss=900.00; }
                            }
                            else if($payyear>=2021)
                            {
                                if($tg>=0 && $tg<=3249.99)
                                { $sss=135.00; }
                                else if($tg>=3250 && $tg<=3749.99)
                                { $sss=157.50; }
                                else if($tg>=3750 && $tg<=4249.99)
                                { $sss=180.00; }
                                else if($tg>=4250 && $tg<=4749.99)
                                { $sss=202.50; }
                                else if($tg>=4750 && $tg<=5249.99)
                                { $sss=225.00; }
                                else if($tg>=5250 && $tg<=5749.99)
                                { $sss=247.50; }
                                else if($tg>=5750 && $tg<=6249.99)
                                { $sss=270.00; }
                                else if($tg>=6250 && $tg<=6749.99)
                                { $sss=292.50; }
                                else if($tg>=6750 && $tg<=7249.99)
                                { $sss=315.00; }
                                else if($tg>=7250 && $tg<=7749.99)
                                { $sss=337.50; }
                                else if($tg>=7750 && $tg<=8249.99)
                                { $sss=360.00; }
                                else if($tg>=8250 && $tg<=8749.99)
                                { $sss=382.50; }
                                else if($tg>=8750 && $tg<=9249.99)
                                { $sss=405.00; }
                                else if($tg>=9250 && $tg<=9749.99)
                                { $sss=427.50; }
                                else if($tg>=9750 && $tg<=10249.99)
                                { $sss=450.00; }
                                else if($tg>=10250 && $tg<=10749.99)
                                { $sss=472.50; }
                                else if($tg>=10750 && $tg<=11249.99)
                                { $sss=495.00; }
                                else if($tg>=11250 && $tg<=11749.99)
                                { $sss=517.50; }
                                else if($tg>=11750 && $tg<=12249.99)
                                { $sss=540.00; }
                                else if($tg>=12250 && $tg<=12749.99)
                                { $sss=562.50; }
                                else if($tg>=12750 && $tg<=13249.99)
                                { $sss=585.00; }
                                else if($tg>=13250 && $tg<=13749.99)
                                { $sss=607.50; }
                                else if($tg>=13750 && $tg<=14249.99)
                                { $sss=630.00; }
                                else if($tg>=14250 && $tg<=14749.99)
                                { $sss=652.50; }
                                else if($tg>=14750 && $tg<=15249.99)
                                { $sss=675.00; }
                                else if($tg>=15250 && $tg<=15749.99)
                                { $sss=697.50; }
                                else if($tg>=15750 && $tg<=16249.99)
                                { $sss=720.00; }
                                else if($tg>=16250 && $tg<=16749.99)
                                { $sss=742.50; }
                                else if($tg>=16750 && $tg<=17249.99)
                                { $sss=765.00; }
                                else if($tg>=17250 && $tg<=17749.99)
                                { $sss=787.50; }
                                else if($tg>=17750 && $tg<=18249.99)
                                { $sss=810.00; }
                                else if($tg>=18250 && $tg<=18749.99)
                                { $sss=832.50; }
                                else if($tg>=18750 && $tg<=19249.99)
                                { $sss=855.00; }
                                else if($tg>=19250 && $tg<=19749.99)
                                { $sss=877.50; }
                                else if($tg>=19750)
                                { $sss=900.00; }
                                else
                                { $sss=900.00; }
                            }
                            else
                            {
                                if($tg>=0 && $tg<=2249.99)
                                { $sss=80.00; }
                                else if($tg>=2250 && $tg<=2749.99)
                                { $sss=100.00; }
                                else if($tg>=2750 && $tg<=3249.99)
                                { $sss=120.00; }
                                else if($tg>=3250 && $tg<=3749.99)
                                { $sss=140.00; }
                                else if($tg>=3750 && $tg<=4249.99)
                                { $sss=160.00; }
                                else if($tg>=4250 && $tg<=4749.99)
                                { $sss=180.00; }
                                else if($tg>=4750 && $tg<=5249.99)
                                { $sss=200.00; }
                                else if($tg>=5250 && $tg<=5749.99)
                                { $sss=220.00; }
                                else if($tg>=5750 && $tg<=6249.99)
                                { $sss=240.00; }
                                else if($tg>=6250 && $tg<=6749.99)
                                { $sss=260.00; }
                                else if($tg>=6750 && $tg<=7249.99)
                                { $sss=280.00; }
                                else if($tg>=7250 && $tg<=7749.99)
                                { $sss=300.00; }
                                else if($tg>=7750 && $tg<=8249.99)
                                { $sss=320.00; }
                                else if($tg>=8250 && $tg<=8749.99)
                                { $sss=340.00; }
                                else if($tg>=8750 && $tg<=9249.99)
                                { $sss=360.00; }
                                else if($tg>=9250 && $tg<=9749.99)
                                { $sss=380.00; }
                                else if($tg>=9750 && $tg<=10249.99)
                                { $sss=400.00; }
                                else if($tg>=10250 && $tg<=10749.99)
                                { $sss=420.00; }
                                else if($tg>=10750 && $tg<=11249.99)
                                { $sss=440.00; }
                                else if($tg>=11250 && $tg<=11749.99)
                                { $sss=460.00; }
                                else if($tg>=11750 && $tg<=12249.99)
                                { $sss=480.00; }
                                else if($tg>=12250 && $tg<=12749.99)
                                { $sss=500.00; }
                                else if($tg>=12750 && $tg<=13249.99)
                                { $sss=520.00; }
                                else if($tg>=13250 && $tg<=13749.99)
                                { $sss=540.00; }
                                else if($tg>=13750 && $tg<=14249.99)
                                { $sss=560.00; }
                                else if($tg>=14250 && $tg<=14749.99)
                                { $sss=580.00; }
                                else if($tg>=14750 && $tg<=15249.99)
                                { $sss=600.00; }
                                else if($tg>=15250 && $tg<=15749.99)
                                { $sss=620.00; }
                                else if($tg>=15750 && $tg<=16249.99)
                                { $sss=640.00; }
                                else if($tg>=16250 && $tg<=16749.99)
                                { $sss=660.00; }
                                else if($tg>=16750 && $tg<=17249.99)
                                { $sss=680.00; }
                                else if($tg>=17250 && $tg<=17749.99)
                                { $sss=700.00; }
                                else if($tg>=17750 && $tg<=18249.99)
                                { $sss=720.00; }
                                else if($tg>=18250 && $tg<=18749.99)
                                { $sss=740.00; }
                                else if($tg>=18750 && $tg<=19249.99)
                                { $sss=760.00; }
                                else if($tg>=19250 && $tg<=19749.99)
                                { $sss=780.00; }
                                else if($tg>=19750)
                                { $sss=800.00; }
                                else
                                { $sss=800.00; }
                            }
                        }
                        while($sss<80.00);
                        $sss=number_format(($sss-(str_replace(',','',$rows1['sss']))),2);
                    }
                    else
                    {
                        $grosspay2=$rows1['grosspay1'];
                        $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                        $tg=str_replace(',','',$totalgrosspay);
                        do
                        {
                            if($tg>=0 && $tg<=1249.99)
                            { $sss=36.30; }
                            else if($tg>=1250 && $tg<=1749.99)
                            { $sss=54.50; }
                            else if($tg>=1750 && $tg<=2249.99)
                            { $sss=72.70; }
                            else if($tg>=2250 && $tg<=2749.99)
                            { $sss=90.80; }
                            else if($tg>=2750 && $tg<=3249.99)
                            { $sss=109.00; }
                            else if($tg>=3250 && $tg<=3749.99)
                            { $sss=127.20; }
                            else if($tg>=3750 && $tg<=4249.99)
                            { $sss=145.30; }
                            else if($tg>=4250 && $tg<=4749.99)
                            { $sss=163.50; }
                            else if($tg>=4750 && $tg<=5249.99)
                            { $sss=181.70; }
                            else if($tg>=5250 && $tg<=5749.99)
                            { $sss=199.80; }
                            else if($tg>=5750 && $tg<=6249.99)
                            { $sss=218.00; }
                            else if($tg>=6250 && $tg<=6749.99)
                            { $sss=236.20; }
                            else if($tg>=6750 && $tg<=7249.99)
                            { $sss=254.30; }
                            else if($tg>=7250 && $tg<=7749.99)
                            { $sss=272.50; }
                            else if($tg>=7750 && $tg<=8249.99)
                            { $sss=290.70; }
                            else if($tg>=8250 && $tg<=8749.99)
                            { $sss=308.80; }
                            else if($tg>=8750 && $tg<=9249.99)
                            { $sss=327.00; }
                            else if($tg>=9250 && $tg<=9749.99)
                            { $sss=345.20; }
                            else if($tg>=9750 && $tg<=10249.99)
                            { $sss=363.30; }
                            else if($tg>=10250 && $tg<=10749.99)
                            { $sss=381.50; }
                            else if($tg>=10750 && $tg<=11249.99)
                            { $sss=399.70; }
                            else if($tg>=11250 && $tg<=11749.99)
                            { $sss=417.80; }
                            else if($tg>=11750 && $tg<=12249.99)
                            { $sss=436.00; }
                            else if($tg>=12250 && $tg<=12749.99)
                            { $sss=454.20; }
                            else if($tg>=12750 && $tg<=13249.99)
                            { $sss=472.30; }
                            else if($tg>=13250 && $tg<=13749.99)
                            { $sss=490.50; }
                            else if($tg>=13750 && $tg<=14249.99)
                            { $sss=508.70; }
                            else if($tg>=14250 && $tg<=14749.99)
                            { $sss=526.80; }
                            else if($tg>=14750 && $tg<=15249.99)
                            { $sss=545.00; }
                            else if($tg>=15250 && $tg<=15749.99)
                            { $sss=563.20; }
                            else if($tg>=15750)
                            { $sss=581.30; }
                            else
                            { $sss=581.30; }
                        }
                        while($sss<36.30 || $sss>581.30);
                        $sss=number_format(($sss-(str_replace(',','',$rows1['sss']))),2);
                    }
                    if(strpos($sssbracket,'no')!==false || ($payyear=='2020' && $paymonth=='APRIL') || ($payyear=='2020' && $paymonth=='MAY' && $category!='Direct Labor'))
                    {
                        $sssloan='0.00';
                        $sssloan2='0.00';
                        $hdmfloan='0.00';
                        $hdmfloan2='0.00';
                        $sss='0.00';
                        $phic='0.00';
                        $hdmf='0.00';
                    }
                    $y1=str_replace(',','',$sssloan);
                    $y2=str_replace(',','',$sssloan2);
                    $y3=str_replace(',','',$hdmfloan);
                    $y4=str_replace(',','',$hdmfloan2);
                    $y5=str_replace(',','',$sss);
                    $y6=str_replace(',','',$phic);
                    $y7=str_replace(',','',$hdmf);
                    $totaldeduction=$y1+$y2+$y3+$y4+$y5+$y6+$y7;
                    $adjust=str_replace(',','',$adjustment);
                    if($adjust<0)
                    { $totaldeduction=$totaldeduction-$adjust; }
                    $totaldeduction=number_format($totaldeduction,2);
                    $netpay=number_format((str_replace(',','',$grosspay1))-(str_replace(',','',$totaldeduction)),2);
                    mysql_query("UPDATE payroll SET basicpay1='".$basicpay1."',basicpay2='".$basicpay2."',totalbasicpay='".$totalbasicpay."',grosspay1='".$grosspay1."',grosspay2='".$grosspay2."',totalgrosspay='".$totalgrosspay."',sss='".$sss."',phic='".$phic."',hdmf='".$hdmf."',totaldeduction='".$totaldeduction."',netpay='".$netpay."' WHERE id='".$id."'");
                }
            }
            ?>
            <td><input class="btn btn-primary btn-s" form="select<?=$ctr;?>" type="submit" value="SELECT"/></td>
            <?php
            echo "<td align=\"center\">$startdate</td>";
            echo "<td align=\"center\">$enddate</td>";
            echo "<td align=\"center\">$cutoff</td>";
            echo "<td align=\"center\">$employeetype</td>";
            echo "<td align=\"center\">$employeenumber</td>";
            echo "<td align=\"center\">$fullname</td>";
            echo "<td align=\"center\">$totalregular</td>";
            echo "<td align=\"center\">$basicpay1</td>";
            echo "<td align=\"center\">$regularovertime</td>";
            echo "<td align=\"center\">$regularotpay</td>";
            echo "<td align=\"center\">$totalspecialot</td>";
            echo "<td align=\"center\">$specialotpay</td>";
            echo "<td align=\"center\">$totalnightdiff</td>";
            echo "<td align=\"center\">$nighttimepay</td>";
            echo "<td align=\"center\">$holiday</td>";
            echo "<td align=\"center\">$holidaypay</td>";
            echo "<td align=\"center\">$vacation</td>";
            echo "<td align=\"center\">$vacationpay</td>";
            echo "<td align=\"center\">$grosspay1</td>";
            echo "<td align=\"center\">$adjustment</td>";
            echo "<td align=\"center\">$sssloan</td>";
            echo "<td align=\"center\">$sssloan2</td>";
            echo "<td align=\"center\">$hdmfloan</td>";
            echo "<td align=\"center\">$hdmfloan2</td>";
            echo "<td align=\"center\">$sss</td>";
            echo "<td align=\"center\">$phic</td>";
            echo "<td align=\"center\">$hdmf</td>";
            echo "<td align=\"center\">$totaldeduction</td>";
            echo "<td align=\"center\">$netpay</td>";
            echo "<td align=\"center\">$signature</td>";
            ?>
            <form id="select<?=$ctr;?>" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" novalidate>
            <input name="id" type="hidden" value="<?=$id;?>"/>
            </form>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
    <tfoot style="background-color: white;">
    <?php
    if($optimize!=true)
    {
    ?>
    <th></th>
    <?php
    }
    ?>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th class="sum">Total Regular Hours</th>
    <th class="sum">Current Basic Pay</th>
    <th class="sum">Regular Overtime Hours</th>
    <th class="sum">Regular Overtime Pay</th>
    <th class="sum">Total Special Overtime</th>
    <th class="sum">Special Overtime Pay</th>
    <th class="sum">Total Night Differential</th>
    <th class="sum">Night Differential Pay</th>
    <th class="sum">Holiday</th>
    <th class="sum">Holiday Pay</th>
    <th class="sum">Vacation</th>
    <th class="sum">Vacation Pay</th>
    <th class="sum">Current Gross Pay</th>
    <th class="sum">Adjustment</th>
    <th class="sum">S.S.S. SL</th>
    <th class="sum">S.S.S. CL</th>
    <th class="sum">H.D.M.F. STL</th>
    <th class="sum">H.D.M.F. CL</th>
    <th class="sum">S.S.S.</th>
    <th class="sum">P.H.I.C.</th>
    <th class="sum">H.D.M.F.</th>
    <th class="sum">Total Deduction</th>
    <th class="sum">Net Pay</th>
    <?php
    if($optimize!=true)
    {
    ?>
    <th></th>
    <?php
    }
    ?>
    </tfoot>
    </table>
    </div>
    <?php
    }
}
if(isset($_POST['btnSelect1']))
{
if($_POST['payrollmode1']==NULL && $_POST['payrollmode2']==NULL)
{
    alert('ERROR: Atleast 1 Payroll Mode is a required input!!!');
    reload_page();
    die();
}
if($_POST['payrollmode1']!=NULL && $_POST['payrollmode2']!=NULL)
{
    alert('ERROR: Only 1 Payroll Mode can be selected at a time!!!');
    reload_page();
    die();
}
if($_POST['payrollmode1']!=NULL)
{
    $payyear=$_POST['year1'];
    if($payyear==NULL)
    {
        alert('ERROR: Year is a required input!!!');
        reload_page();
        die();
    }
    $_SESSION['month']=NULL;
    $_SESSION['cutoff']=NULL;
    $_SESSION['year']=NULL;
    $_SESSION['printslip']=NULL;
    $_SESSION['employee']=NULL;
    $_SESSION['showall']=NULL;
    $_SESSION['contents']=NULL;

    if($_SESSION['visibility']!='hidden')
    {
        $hidden=array();
        $hidden[]=' ';
        $contentx=mysql_query("SELECT * FROM employees WHERE status='hidden' ORDER BY employeetype ASC, lastname ASC");
        $totalx=mysql_affected_rows();
        for($a=0; $a<=$totalx-1; $a++)
        {
            $rowsx=mysql_fetch_array($contentx);
            array_push($hidden," AND NOT employeenumber='".$rowsx['employeenumber']."'");
        }
        $filter=implode($hidden);
        if($totalx>0)
        { $add='WHERE'; }
        $filter2=$add.substr($filter,5);
        $concat='(EXCLUDING hidden record/s).';
    }
    else
    { $concat='(INCLUDING hidden record/s).'; }

    if($_POST['payrollmode1']=='1')
    { $sum="SUM(REPLACE(basicpay1,',',''))+SUM(CASE WHEN (REPLACE(adjustment,',',''))>0 THEN (REPLACE(adjustment,',','')) ELSE 0 END)"; $display='Basic Pay (For PhilHealth)'; }
    else if($_POST['payrollmode1']=='2')
    { $sum="SUM(REPLACE(grosspay1,',',''))"; $display='Gross Pay (For S.S.S.)'; }
    else if($_POST['payrollmode1']=='3')
    { $sum="SUM(REPLACE(totalregular,',',''))"; $display='Total Regular Hours'; }
    else if($_POST['payrollmode1']=='4')
    { $sum="SUM(REPLACE(regularovertime,',',''))"; $display='Regular Overtime Hours'; }
    else if($_POST['payrollmode1']=='5')
    { $sum="SUM(REPLACE(specialovertime1,',',''))+SUM(REPLACE(specialovertime2,',',''))+SUM(REPLACE(specialovertime3,',',''))"; $display='Special Overtime Hours'; }
    else if($_POST['payrollmode1']=='6')
    { $sum="SUM(REPLACE(nightdifferential1,',',''))+SUM(REPLACE(nightdifferential2,',',''))+SUM(REPLACE(nightdifferential3,',',''))"; $display='Night Differential Hours'; }
    else if($_POST['payrollmode1']=='7')
    { $sum="SUM(REPLACE(vacation,',',''))"; $display='Vacation Leave Used'; }
    else if($_POST['payrollmode1']=='8')
    { $sum="SUM(REPLACE(basicpay1,',',''))+SUM(REPLACE(adjustment,',',''))"; $display='Basic Pay and Adjustments'; }
    else if($_POST['payrollmode1']=='9')
    { $sum="SUM(REPLACE(regularotpay,',',''))+SUM(REPLACE(specialotpay,',',''))+SUM(REPLACE(nighttimepay,',',''))"; $display='Overtime Pay'; }
    else if($_POST['payrollmode1']=='10')
    { $sum="SUM(REPLACE(holidaypay,',',''))"; $display='Holiday Pay'; }
    else if($_POST['payrollmode1']=='11')
    { $sum="SUM(REPLACE(vacationpay,',',''))"; $display='Vacation Leave Pay'; }
    else if($_POST['payrollmode1']=='12')
    { $sum="SUM(REPLACE(sss,',',''))"; $display='S.S.S. Contributions'; }
    else if($_POST['payrollmode1']=='13')
    { $sum="SUM(REPLACE(phic,',',''))"; $display='P.H.I.C. Contributions'; }
    else if($_POST['payrollmode1']=='14')
    { $sum="SUM(REPLACE(hdmf,',',''))"; $display='H.D.M.F. Contributions'; }
    else if($_POST['payrollmode1']=='15')
    { $sum="SUM(REPLACE(sssloan,',',''))"; $display='S.S.S. SL'; }
    else if($_POST['payrollmode1']=='16')
    { $sum="SUM(REPLACE(sssloan2,',',''))"; $display='S.S.S. CL'; }
    else if($_POST['payrollmode1']=='17')
    { $sum="SUM(REPLACE(hdmfloan,',',''))"; $display='H.D.M.F. STL'; }
    else if($_POST['payrollmode1']=='18')
    { $sum="SUM(REPLACE(hdmfloan2,',',''))"; $display='H.D.M.F. CL'; }
    ?>
    <div style="width: 1200px;">
    <table id="payroll_report2" class="table-striped nowrap">
    <thead style="background-color: white;">
    <th>Employee Name</th>
    <th class="sum">January</th>
    <th class="sum">February</th>
    <th class="sum">March</th>
    <th class="sum">April</th>
    <th class="sum">May</th>
    <th class="sum">June</th>
    <th class="sum">July</th>
    <th class="sum">August</th>
    <th class="sum">September</th>
    <th class="sum">October</th>
    <th class="sum">November</th>
    <th class="sum">December</th>
    <th class="sum">TOTAL</th>
    </thead>
    <tbody>
        <?php
        $content=mysql_query("SELECT DISTINCT fullname FROM payroll ".$filter2." ORDER BY fullname ASC");
        $total=mysql_affected_rows();
        for($x=0; $x<=$total-1; $x++)
        {
            ?>
            <tr>
            <?php
            $rows=mysql_fetch_array($content);
            $id=$rows['id'];
            $paymonth=$rows['paymonth'];
            $startdate=$rows['startdate'];
            $enddate=$rows['enddate'];
            $cutoff=$rows['cutoff'];
            $employeenumber=$rows['employeenumber'];
            $fullname=$rows['fullname'];
            $totalregular=$rows['totalregular'];
            $basicpay1=$rows['basicpay1'];
            $regularovertime=$rows['regularovertime'];
            $regularotpay=$rows['regularotpay'];
            $totalspecialot=$rows['totalspecialot'];
            $specialotpay=$rows['specialotpay'];
            $totalnightdiff=$rows['totalnightdiff'];
            $nighttimepay=$rows['nighttimepay'];
            $holiday=$rows['holiday'];
            $holidaypay=$rows['holidaypay'];
            $vacation=$rows['vacation'];
            $vacationpay=$rows['vacationpay'];
            $grosspay1=$rows['grosspay1'];
            $adjustment=$rows['adjustment'];
            $sssloan=$rows['sssloan'];
            $sssloan2=$rows['sssloan2'];
            $hdmfloan=$rows['hdmfloan'];
            $hdmfloan2=$rows['hdmfloan2'];
            $sss=$rows['sss'];
            $phic=$rows['phic'];
            $hdmf=$rows['hdmf'];
            $totaldeduction=$rows['totaldeduction'];
            $netpay=$rows['netpay'];

            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='JANUARY' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $january=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='FEBRUARY' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $february=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='MARCH' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $march=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='APRIL' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $april=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='MAY' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $may=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='JUNE' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $june=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='JULY' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $july=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='AUGUST' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $august=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='SEPTEMBER' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $september=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='OCTOBER' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $october=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='NOVEMBER' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $november=number_format(($rows1['sumtotal']),2);
            }
            $content1=mysql_query("SELECT $sum AS sumtotal FROM payroll WHERE fullname='$fullname' AND paymonth='DECEMBER' AND payyear='$payyear'");
            $total1=mysql_affected_rows();
            for($x1=0; $x1<=$total1-1; $x1++)
            {
                $rows1=mysql_fetch_assoc($content1);
                $december=number_format(($rows1['sumtotal']),2);
            }

            $grand1=str_replace(',','',$january);
            $grand2=str_replace(',','',$february);
            $grand3=str_replace(',','',$march);
            $grand4=str_replace(',','',$april);
            $grand5=str_replace(',','',$may);
            $grand6=str_replace(',','',$june);
            $grand7=str_replace(',','',$july);
            $grand8=str_replace(',','',$august);
            $grand9=str_replace(',','',$september);
            $grand10=str_replace(',','',$october);
            $grand11=str_replace(',','',$november);
            $grand12=str_replace(',','',$december);
            $grandtotal=number_format(($grand1+$grand2+$grand3+$grand4+$grand5+$grand6+$grand7+$grand8+$grand9+$grand10+$grand11+$grand12),2);
            $grandtotalx=$grandtotalx+str_replace(',','',$grandtotal);

            echo "<td align=\"center\">$fullname</td>";
            echo "<td align=\"center\">$january</td>";
            echo "<td align=\"center\">$february</td>";
            echo "<td align=\"center\">$march</td>";
            echo "<td align=\"center\">$april</td>";
            echo "<td align=\"center\">$may</td>";
            echo "<td align=\"center\">$june</td>";
            echo "<td align=\"center\">$july</td>";
            echo "<td align=\"center\">$august</td>";
            echo "<td align=\"center\">$september</td>";
            echo "<td align=\"center\">$october</td>";
            echo "<td align=\"center\">$november</td>";
            echo "<td align=\"center\">$december</td>";
            echo "<td align=\"center\">$grandtotal</td>";
            ?>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot style="background-color: white;">
    <th>&nbsp;</th>
    <th class="sum">January</th>
    <th class="sum">February</th>
    <th class="sum">March</th>
    <th class="sum">April</th>
    <th class="sum">May</th>
    <th class="sum">June</th>
    <th class="sum">July</th>
    <th class="sum">August</th>
    <th class="sum">September</th>
    <th class="sum">October</th>
    <th class="sum">November</th>
    <th class="sum">December</th>
    <th class="sum">TOTAL</th>
    </tfoot>
    </table>
    </div>
    <?php
    if($_POST['payrollmode1']=='3' || $_POST['payrollmode1']=='4' || $_POST['payrollmode1']=='5' || $_POST['payrollmode1']=='6')
    { alert('SUCCESS: '.number_format(($grandtotalx),2).' overall total number of hours for: \n=====['.$display.']=====\nShowing '.$payyear.' record/s of all employees.\n'.$concat); }
    else if($_POST['payrollmode1']=='7')
    { alert('SUCCESS: '.number_format(($grandtotalx),2).' overall total number of days for: \n=====['.$display.']=====\nShowing '.$payyear.' record/s of all employees.\n'.$concat); }
    else
    { alert('SUCCESS: ₱'.number_format(($grandtotalx),2).' grand total amount for: \n=====['.$display.']=====\nShowing '.$payyear.' record/s of all employees.\n'.$concat); }
}
if($_POST['payrollmode2']!=NULL)
{
    $payyear=$_POST['year2'];
    $paymonth=$_POST['payrollmode2'];
    $cutoff=$_POST['cutoff2'];
    if($payyear==NULL)
    {
        alert('ERROR: Year is a required input!!!');
        reload_page();
        die();
    }
    $_SESSION['month']=NULL;
    $_SESSION['cutoff']=NULL;
    $_SESSION['year']=NULL;
    $_SESSION['printslip']=NULL;
    $_SESSION['employee']=NULL;
    $_SESSION['showall']=NULL;
    $_SESSION['contents']=NULL;

    $content1=mysql_query("SELECT SUM(REPLACE(basicpay1,',','')) + SUM(REPLACE(regularotpay,',','')) + SUM(REPLACE(specialotpay,',','')) + SUM(REPLACE(nighttimepay,',','')) + SUM(REPLACE(holidaypay,',','')) + SUM(CASE WHEN (REPLACE(adjustment,',',''))>0 THEN (REPLACE(adjustment,',','')) ELSE 0 END) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear' AND category='Salaries and Wages'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal1=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(basicpay1,',','')) + SUM(REPLACE(regularotpay,',','')) + SUM(REPLACE(specialotpay,',','')) + SUM(REPLACE(nighttimepay,',','')) + SUM(REPLACE(holidaypay,',','')) + SUM(CASE WHEN (REPLACE(adjustment,',',''))>0 THEN (REPLACE(adjustment,',','')) ELSE 0 END) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear' AND category='Direct Labor'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal2=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(vacationpay,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal3=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(sss,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal4=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(phic,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal5=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(hdmf,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal6=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(sssloan,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal7=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(sssloan2,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal8=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(hdmfloan,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal9=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(hdmfloan2,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal10=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(CASE WHEN (REPLACE(adjustment,',',''))<0 THEN (REPLACE(adjustment,',','')) ELSE 0 END) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal11=number_format(($rows1['sumtotal']),2);
    }

    $content1=mysql_query("SELECT SUM(REPLACE(netpay,',','')) AS sumtotal FROM payroll WHERE cutoff='$cutoff' AND paymonth='$paymonth' AND payyear='$payyear'");
    $total1=mysql_affected_rows();
    for($x1=0; $x1<=$total1-1; $x1++)
    {
        $rows1=mysql_fetch_assoc($content1);
        $sumtotal12=number_format(($rows1['sumtotal']),2);
    }
    ?>
    <br />
    <table align="center" width="800" border="0">
      <tr>
        <td width="400"><h2 align="left" style="vertical-align: middle;">Salaries and Wages:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;₱</h2></td>
        <td width="200"><h2 align="right" style="vertical-align: middle;"><?=$sumtotal1;?></h2></td>
        <td width="200"><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">Direct Labor:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal2;?></h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">Employees Benefit:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal3;?></h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">S.S.S. Contributions:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal4;?></h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">P.H.I.C. Contributions:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal5;?></h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">H.D.M.F. Contributions:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal6;?></h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">S.S.S. SL:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal7;?></h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">S.S.S. CL:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal8;?></h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">H.D.M.F. STL:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal9;?></h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">H.D.M.F. CL:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=$sumtotal10;?></h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">Advances to Employees:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle;"><?=str_replace('-','',$sumtotal11);?></h2></td>
      </tr>
      <tr>
        <td><h2 align="left" style="vertical-align: middle;">Cash in Bank:</h2></td>
        <td><h2 align="right" style="vertical-align: middle;">&nbsp;</h2></td>
        <td><h2 align="right" style="vertical-align: middle; border-top: double;"><?=$sumtotal12;?></h2></td>
      </tr>
    </table>
    <br />
    <?php
    alert('SUCCESS: Showing Payroll Summary Report for: \n====='.$paymonth.' '.$payyear.' ('.$cutoff.' Cut-Off)=====');
}
}
?>
</div>
</div>
<?php
html_end();
function checklabel($checklabel)
{
    $checklabel=str_replace("Jan. 32","Feb. 1",$checklabel);
    if(strpos($checklabel,'Feb. 29')!==false || strpos($checklabel,'Feb. 30')!==false)
    {
        if(($_SESSION['year']%4==0 && $_SESSION['year']%100!=0) || $_SESSION['year']%400==0)
        { $checklabel=str_replace("Feb. 30","Mar. 1",$checklabel); }
        else
        { $checklabel=str_replace("Feb. 29","Mar. 1",$checklabel); }
    }
    $checklabel=str_replace("Mar. 32","Apr. 1",$checklabel);
    $checklabel=str_replace("Apr. 31","May 1",$checklabel);
    $checklabel=str_replace("May 32","June 1",$checklabel);
    $checklabel=str_replace("June 31","July 1",$checklabel);
    $checklabel=str_replace("July 32","Aug. 1",$checklabel);
    $checklabel=str_replace("Aug. 32","Sept. 1",$checklabel);
    $checklabel=str_replace("Sept. 31","Oct. 1",$checklabel);
    $checklabel=str_replace("Oct. 32","Nov. 1",$checklabel);
    $checklabel=str_replace("Nov. 31","Dec. 1",$checklabel);
    $checklabel=str_replace("Dec. 32","Jan. 1",$checklabel);
    return $checklabel;
}
?>