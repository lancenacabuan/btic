<?php //********************BTIC Sales & Payroll System v15.23.0209.1630********************//
if($_SESSION['printslip']=='thirteenthmonth')
{
    $employee=$_SESSION['employee'];
    $year=$_SESSION['year'];
    $prevyear=$year-1;
    if($year=='2020')
    {
        $query="SELECT * FROM payroll WHERE employeenumber='$employee' AND ((paymonth='APRIL' AND payyear='$year') OR (paymonth='MAY' AND payyear='$year') OR (paymonth='JUNE' AND payyear='$year') OR (paymonth='JULY' AND payyear='$year') OR (paymonth='AUGUST' AND payyear='$year') OR (paymonth='SEPTEMBER' AND payyear='$year') OR (paymonth='OCTOBER' AND payyear='$year') OR (paymonth='NOVEMBER' AND payyear='$year'))";
    }
    else
    {
        $query="SELECT * FROM payroll WHERE employeenumber='$employee' AND ((paymonth='DECEMBER' AND payyear='$prevyear') OR (paymonth='JANUARY' AND payyear='$year') OR (paymonth='FEBRUARY' AND payyear='$year') OR (paymonth='MARCH' AND payyear='$year') OR (paymonth='APRIL' AND payyear='$year') OR (paymonth='MAY' AND payyear='$year') OR (paymonth='JUNE' AND payyear='$year') OR (paymonth='JULY' AND payyear='$year') OR (paymonth='AUGUST' AND payyear='$year') OR (paymonth='SEPTEMBER' AND payyear='$year') OR (paymonth='OCTOBER' AND payyear='$year') OR (paymonth='NOVEMBER' AND payyear='$year'))";
    }
    $content=mysql_query($query);
    $total=mysql_affected_rows();
    if($total>0)
    {
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
            $overallregular=number_format((str_replace(',','',$overallregular)+str_replace(',','',$totalregular)),2);
        }
        $divideby8=number_format((str_replace(',','',$overallregular)/8),15);
        $divideby312=number_format((str_replace(',','',$divideby8)/312),15);
        $times26=number_format((str_replace(',','',$divideby312)*26),15);
        $thirteenthmonthpay=number_format(($times26*str_replace(',','',$rate)),2);
        $divideby8=substr($divideby8,0,-13);
        $divideby312=substr($divideby312,0,-13);
        $times26=substr($times26,0,-13);
        ?>
        <div style="zoom: 150%;">
        <div id="printReceipt1">
        <font size="1" face="Calibri">
        <table cellspacing="0" cellpadding="0" border="0">
          <col width="93" />
          <col width="24" />
          <col width="67" />
          <col width="17" />
          <col width="53" />
          <col width="18" />
          <col width="29" />
          <col width="84" />
          <col width="34" />
          <col width="28" />
          <col width="64" />
          <col width="46" />
          <col width="64" />
          <col width="50" span="2" />
          <tr  style="line-height: 12px;">
            <td style="text-align: left;" colspan="6" width="272">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAYSLIP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BETTER THAN ICE CREAM, INC.</td>
            <td width="29"></td>
            <td width="84"></td>
            <td width="34"></td>
            <td style="text-align: left;" colspan="5" width="375">PAYROLL RECEIPT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BETTER THAN ICE CREAM, INC.</td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EMPL#<?=$employeenumber;?></td>
            <td></td>
            <td></td>
            <td style="text-align: left;" colspan="5">13TH MONTH PAY:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DECEMBER <?=$year;?></td>
            <td></td>
            <td style="text-align: left;" colspan="5">Employer's Copy&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dept: <?=$employeetype;?></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$fullname;?></td>
            <td style="text-align: left;" colspan="5">Dept: <?=$employeetype;?></td>
            <td></td>
            <td style="text-align: left;" colspan="3">13TH MONTH PAY:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DECEMBER <?=$year;?></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 20px;">
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13th Month Pay </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?=$thirteenthmonthpay;?></td>
            <td></td>
            <td style="text-align: left;" colspan="2">EMPL#<?=$employeenumber;?></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 20px;">
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 24px;">
            <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Computation: </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: left;" colspan="3"><?=$fullname;?></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;" colspan="3" width="272">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total No. of Regular Hrs. </td>
            <td style="text-align: left;" colspan="2"><?=$overallregular;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ÷ &nbsp;&nbsp;&nbsp;8 hrs </td>
            <td style="text-align: left;" colspan="2"><?=$divideby8;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: left;" colspan="2">Amount Paid: &nbsp;&nbsp;&nbsp;P</td>
            <td style="text-align: left;" colspan="2">_______________</td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ÷ &nbsp;&nbsp;&nbsp;312 days (26*12) </td>
            <td style="text-align: left;" colspan="2"><?=$divideby312;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; x &nbsp;&nbsp;&nbsp;26 days (work days) </td>
            <td style="text-align: left;" colspan="2"><?=$times26;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; x &nbsp;&nbsp;&nbsp;Rate </td>
            <td style="text-align: left;" colspan="2"><?=$rate;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: left;" colspan="5">Received By: _______________ &nbsp;&nbsp;&nbsp; Date: _______________</td>
          </tr>
          <tr  style="line-height: 12px;">
            <td style="text-align: left;" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13th Month Pay </td>
            <td style="text-align: left;" colspan="2"><?=$thirteenthmonthpay;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr  style="line-height: 12px;">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: left;" colspan="2"> NET PAY </td>
            <td><?=$thirteenthmonthpay;?></td>
            <td></td>
            <td style="text-align: left;" colspan="3">Print Date: <?=date('Y-m-d');?></td>
            <td></td>
            <td></td>
          </tr>
        </table>
        </font>
        </div>
        </div>
        <br />
        <input style="height: 50px; width: 655px;" class="form-control btn btn-lg btn-info" type="button" onclick="printDiv1('printReceipt1')" value="PRINT RECEIPT"/>
        <script>
            function printDiv1(divName)
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
        alert('SUCCESS: Showing 13th Month Pay Receipt.\nEmployee Name: '.$fullname.'\nTotal Regular Hours: '.$overallregular.' Hours in Year '.$year.'\n13th Month Pay: ₱ '.$thirteenthmonthpay);
    }
}
else if($_SESSION['printslip']=='payslip')
{
    $wk1start=substr($startdate,8,2);
    if(substr($wk1start,0,1)=='0')
    { $wk1start=str_replace('0','',$wk1start); }
    $wk1end=$wk1start+6;
    if(substr($startdate,5,2)=='01' || substr($startdate,5,2)=='03' || substr($startdate,5,2)=='05' || substr($startdate,5,2)=='07' || substr($startdate,5,2)=='08' || substr($startdate,5,2)=='10' || substr($startdate,5,2)=='12')
    {
        if($wk1end>31)
        {
            $wk1end=$wk1end-31;
            if(substr($startdate,5,2)!='10' && substr($startdate,5,2)!='12')
            {
                $wk1endm=(substr($startdate,6,1))+1;
                $wk1end='0'.$wk1endm.'-'.$wk1end;
            }
            else
            {
                $wk1endm=(substr($startdate,5,2))+1;
                if($wk1endm=='13')
                { $wk1endm='01'; }
                $wk1end=$wk1endm.'-'.$wk1end;
            }
        }
        else
        {
            if(substr($startdate,5,2)!='10' && substr($startdate,5,2)!='12')
            {
                $wk1endm=(substr($startdate,6,1));
                $wk1end='0'.$wk1endm.'-'.$wk1end;
            }
            else
            {
                $wk1endm=(substr($startdate,5,2));
                $wk1end=$wk1endm.'-'.$wk1end;
            }
        }
    }
    else if(substr($startdate,5,2)=='02')
    {
        if((substr($startdate,0,4)%4==0 && substr($startdate,0,4)%100!=0) || substr($startdate,0,4)%400==0)
        { $base=29; }
        else
        { $base=28; }
        if($wk1end>$base)
        {
            $wk1end=$wk1end-$base;
            $wk1endm=(substr($startdate,6,1))+1;
            $wk1end='0'.$wk1endm.'-'.$wk1end;
        }
        else
        {
            $wk1endm=(substr($startdate,6,1));
            $wk1end='0'.$wk1endm.'-'.$wk1end;
        }
    }
    else
    {
        if($wk1end>30)
        {
            $wk1end=$wk1end-30;
            if(substr($startdate,5,2)!='11')
            {
                $wk1endm=(substr($startdate,6,1))+1;
                if($wk1endm=='10')
                { $wk1end=$wk1endm.'-'.$wk1end; }
                else
                $wk1end='0'.$wk1endm.'-'.$wk1end;
            }
            else
            {
                $wk1endm=(substr($startdate,5,2))+1;
                $wk1end=$wk1endm.'-'.$wk1end;
            }
        }
        else
        {
            if(substr($startdate,5,2)!='11')
            {
                $wk1endm=(substr($startdate,6,1));
                $wk1end='0'.$wk1endm.'-'.$wk1end;
            }
            else
            {
                $wk1endm=(substr($startdate,5,2));
                $wk1end=$wk1endm.'-'.$wk1end;
            }
        }
    }
    $mstart=substr($startdate,5,2);
    if($mstart=='01')
    { $mstart='Jan.'; }
    if($mstart=='02')
    { $mstart='Feb.'; }
    if($mstart=='03')
    { $mstart='Mar.'; }
    if($mstart=='04')
    { $mstart='Apr.'; }
    if($mstart=='05')
    { $mstart='May'; }
    if($mstart=='06')
    { $mstart='June'; }
    if($mstart=='07')
    { $mstart='July'; }
    if($mstart=='08')
    { $mstart='Aug.'; }
    if($mstart=='09')
    { $mstart='Sept.'; }
    if($mstart=='10')
    { $mstart='Oct.'; }
    if($mstart=='11')
    { $mstart='Nov.'; }
    if($mstart=='12')
    { $mstart='Dec.'; }
    if(substr($wk1end,0,3)=='01-')
    { $mend=str_replace('01-','Jan. ',$wk1end); }
    if(substr($wk1end,0,3)=='02-')
    { $mend=str_replace('02-','Feb. ',$wk1end); }
    if(substr($wk1end,0,3)=='03-')
    { $mend=str_replace('03-','Mar. ',$wk1end); }
    if(substr($wk1end,0,3)=='04-')
    { $mend=str_replace('04-','Apr. ',$wk1end); }
    if(substr($wk1end,0,3)=='05-')
    { $mend=str_replace('05-','May ',$wk1end); }
    if(substr($wk1end,0,3)=='06-')
    { $mend=str_replace('06-','June ',$wk1end); }
    if(substr($wk1end,0,3)=='07-')
    { $mend=str_replace('07-','July ',$wk1end); }
    if(substr($wk1end,0,3)=='08-')
    { $mend=str_replace('08-','Aug. ',$wk1end); }
    if(substr($wk1end,0,3)=='09-')
    { $mend=str_replace('09-','Sept. ',$wk1end); }
    if(substr($wk1end,0,3)=='10-')
    { $mend=str_replace('10-','Oct. ',$wk1end); }
    if(substr($wk1end,0,3)=='11-')
    { $mend=str_replace('11-','Nov. ',$wk1end); }
    if(substr($wk1end,0,3)=='12-')
    { $mend=str_replace('12-','Dec. ',$wk1end); }
    $week1label=$mstart.' '.$wk1start.' to '.$mend;

    $wk1end=substr($wk1end,3,2);
    if(strlen($wk1endm)==1)
    { $wk1endm='0'.$wk1endm; }
    $wk2start=$wk1end+1;
    $wk2end=$wk2start+6;
    if($wk1endm=='01' || $wk1endm=='03' || $wk1endm=='05' || $wk1endm=='07' || $wk1endm=='08' || $wk1endm=='10' || $wk1endm=='12')
    {
        if($wk2end>31)
        {
            $wk2end=$wk2end-31;
            if(substr($wk1endm,0,2)!='10' && substr($wk1endm,0,2)!='12')
            {
                $wk2endm=(substr($wk1endm,1,1))+1;
                $wk2end='0'.$wk2endm.'-'.$wk2end;
            }
            else
            {
                $wk2endm=(substr($wk1endm,0,2))+1;
                if($wk2endm=='13')
                { $wk2endm='01'; }
                $wk2end=$wk2endm.'-'.$wk2end;
            }
        }
        else
        {
            if(substr($wk1endm,0,2)!='10' && substr($wk1endm,0,2)!='12')
            {
                $wk2endm=(substr($wk1endm,1,1));
                $wk2end='0'.$wk2endm.'-'.$wk2end;
            }
            else
            {
                $wk2endm=(substr($wk1endm,0,2));
                $wk2end=$wk2endm.'-'.$wk2end;
            }
        }
    }
    else if($wk2endm=='02')
    {
        if((substr($startdate,0,4)%4==0 && substr($startdate,0,4)%100!=0) || substr($startdate,0,4)%400==0)
        { $base=29; }
        else
        { $base=28; }
        if($wk2end>$base)
        {
            $wk2end=$wk2end-$base;
            $wk2endm=(substr($wk1endm,1,1))+1;
            $wk2end='0'.$wk2endm.'-'.$wk2end;
        }
        else
        {
            $wk2endm=(substr($wk1endm,1,1));
            $wk2end='0'.$wk2endm.'-'.$wk2end;
        }
    }
    else
    {
        if($wk2end>30)
        {
            $wk2end=$wk2end-30;
            if(substr($wk1endm,0,2)!='11')
            {
                $wk2endm=(substr($wk1endm,1,1))+1;
                if($wk2endm=='10')
                { $wk2end=$wk2endm.'-'.$wk2end; }
                else
                $wk2end='0'.$wk2endm.'-'.$wk2end;
            }
            else
            {
                $wk2endm=(substr($wk1endm,0,2))+1;
                $wk2end=$wk2endm.'-'.$wk2end;
            }
        }
        else
        {
            if(substr($wk1endm,0,2)!='11')
            {
                $wk2endm=(substr($wk1endm,1,1));
                $wk2end='0'.$wk2endm.'-'.$wk2end;
            }
            else
            {
                $wk2endm=(substr($wk1endm,0,2));
                $wk2end=$wk2endm.'-'.$wk2end;
            }
        }
    }
    $mstart=$wk1endm;
    if($mstart=='01')
    { $mstart='Jan.'; }
    if($mstart=='02')
    { $mstart='Feb.'; }
    if($mstart=='03')
    { $mstart='Mar.'; }
    if($mstart=='04')
    { $mstart='Apr.'; }
    if($mstart=='05')
    { $mstart='May'; }
    if($mstart=='06')
    { $mstart='June'; }
    if($mstart=='07')
    { $mstart='July'; }
    if($mstart=='08')
    { $mstart='Aug.'; }
    if($mstart=='09')
    { $mstart='Sept.'; }
    if($mstart=='10')
    { $mstart='Oct.'; }
    if($mstart=='11')
    { $mstart='Nov.'; }
    if($mstart=='12')
    { $mstart='Dec.'; }
    if(substr($wk2end,0,3)=='01-')
    { $mend=str_replace('01-','Jan. ',$wk2end); }
    if(substr($wk2end,0,3)=='02-')
    { $mend=str_replace('02-','Feb. ',$wk2end); }
    if(substr($wk2end,0,3)=='03-')
    { $mend=str_replace('03-','Mar. ',$wk2end); }
    if(substr($wk2end,0,3)=='04-')
    { $mend=str_replace('04-','Apr. ',$wk2end); }
    if(substr($wk2end,0,3)=='05-')
    { $mend=str_replace('05-','May ',$wk2end); }
    if(substr($wk2end,0,3)=='06-')
    { $mend=str_replace('06-','June ',$wk2end); }
    if(substr($wk2end,0,3)=='07-')
    { $mend=str_replace('07-','July ',$wk2end); }
    if(substr($wk2end,0,3)=='08-')
    { $mend=str_replace('08-','Aug. ',$wk2end); }
    if(substr($wk2end,0,3)=='09-')
    { $mend=str_replace('09-','Sept. ',$wk2end); }
    if(substr($wk2end,0,3)=='10-')
    { $mend=str_replace('10-','Oct. ',$wk2end); }
    if(substr($wk2end,0,3)=='11-')
    { $mend=str_replace('11-','Nov. ',$wk2end); }
    if(substr($wk2end,0,3)=='12-')
    { $mend=str_replace('12-','Dec. ',$wk2end); }
    $week2label=$mstart.' '.$wk2start.' to '.$mend;

    $wk2end=substr($wk2end,3,2);
    if(strlen($wk2endm)==1)
    { $wk2endm='0'.$wk2endm; }
    $wk3start=$wk2end+1;
    $wk3end=$wk3start+6;
    if($wk2endm=='01' || $wk2endm=='03' || $wk2endm=='05' || $wk2endm=='07' || $wk2endm=='08' || $wk2endm=='10' || $wk2endm=='12')
    {
        if($wk3end>31)
        {
            $wk3end=$wk3end-31;
            if(substr($wk2endm,0,2)!='10' && substr($wk2endm,0,2)!='12')
            {
                $wk3endm=(substr($wk2endm,1,1))+1;
                $wk3end='0'.$wk3endm.'-'.$wk3end;
            }
            else
            {
                $wk3endm=(substr($wk2endm,0,2))+1;
                if($wk3endm=='13')
                { $wk3endm='01'; }
                $wk3end=$wk3endm.'-'.$wk3end;
            }
        }
        else
        {
            if(substr($wk2endm,0,2)!='10' && substr($wk2endm,0,2)!='12')
            {
                $wk3endm=(substr($wk2endm,1,1));
                $wk3end='0'.$wk3endm.'-'.$wk3end;
            }
            else
            {
                $wk3endm=(substr($wk2endm,0,2));
                $wk3end=$wk3endm.'-'.$wk3end;
            }
        }
    }
    else if($wk3endm=='02')
    {
        if((substr($startdate,0,4)%4==0 && substr($startdate,0,4)%100!=0) || substr($startdate,0,4)%400==0)
        { $base=29; }
        else
        { $base=28; }
        if($wk3end>$base)
        {
            $wk3end=$wk3end-$base;
            $wk3endm=(substr($wk2endm,1,1))+1;
            $wk3end='0'.$wk3endm.'-'.$wk3end;
        }
        else
        {
            $wk3endm=(substr($wk2endm,1,1));
            $wk3end='0'.$wk3endm.'-'.$wk3end;
        }
    }
    else
    {
        if($wk3end>30)
        {
            $wk3end=$wk3end-30;
            if(substr($wk2endm,0,2)!='11')
            {
                $wk3endm=(substr($wk2endm,1,1))+1;
                if($wk3endm=='10')
                { $wk3end=$wk3endm.'-'.$wk3end; }
                else
                $wk3end='0'.$wk3endm.'-'.$wk3end;
            }
            else
            {
                $wk3endm=(substr($wk2endm,0,2))+1;
                $wk3end=$wk3endm.'-'.$wk3end;
            }
        }
        else
        {
            if(substr($wk2endm,0,2)!='11')
            {
                $wk3endm=(substr($wk2endm,1,1));
                $wk3end='0'.$wk3endm.'-'.$wk3end;
            }
            else
            {
                $wk3endm=(substr($wk2endm,0,2));
                $wk3end=$wk3endm.'-'.$wk3end;
            }
        }
    }
    $mstart=$wk2endm;
    if($mstart=='01')
    { $mstart='Jan.'; }
    if($mstart=='02')
    { $mstart='Feb.'; }
    if($mstart=='03')
    { $mstart='Mar.'; }
    if($mstart=='04')
    { $mstart='Apr.'; }
    if($mstart=='05')
    { $mstart='May'; }
    if($mstart=='06')
    { $mstart='June'; }
    if($mstart=='07')
    { $mstart='July'; }
    if($mstart=='08')
    { $mstart='Aug.'; }
    if($mstart=='09')
    { $mstart='Sept.'; }
    if($mstart=='10')
    { $mstart='Oct.'; }
    if($mstart=='11')
    { $mstart='Nov.'; }
    if($mstart=='12')
    { $mstart='Dec.'; }
    if(substr($wk3end,0,3)=='01-')
    { $mend=str_replace('01-','Jan. ',$wk3end); }
    if(substr($wk3end,0,3)=='02-')
    { $mend=str_replace('02-','Feb. ',$wk3end); }
    if(substr($wk3end,0,3)=='03-')
    { $mend=str_replace('03-','Mar. ',$wk3end); }
    if(substr($wk3end,0,3)=='04-')
    { $mend=str_replace('04-','Apr. ',$wk3end); }
    if(substr($wk3end,0,3)=='05-')
    { $mend=str_replace('05-','May ',$wk3end); }
    if(substr($wk3end,0,3)=='06-')
    { $mend=str_replace('06-','June ',$wk3end); }
    if(substr($wk3end,0,3)=='07-')
    { $mend=str_replace('07-','July ',$wk3end); }
    if(substr($wk3end,0,3)=='08-')
    { $mend=str_replace('08-','Aug. ',$wk3end); }
    if(substr($wk3end,0,3)=='09-')
    { $mend=str_replace('09-','Sept. ',$wk3end); }
    if(substr($wk3end,0,3)=='10-')
    { $mend=str_replace('10-','Oct. ',$wk3end); }
    if(substr($wk3end,0,3)=='11-')
    { $mend=str_replace('11-','Nov. ',$wk3end); }
    if(substr($wk3end,0,3)=='12-')
    { $mend=str_replace('12-','Dec. ',$wk3end); }
    $week3label=$mstart.' '.$wk3start.' to '.$mend;
    ?>
    <table cellspacing="0" cellpadding="0" border="0">
      <col width="22" />
      <col width="72" />
      <col width="29" />
      <col width="94" />
      <col width="17" />
      <col width="76" />
      <col width="22" />
      <col width="66" />
      <col width="48" span="2" />
      <col width="45" />
      <col width="28" />
      <col width="64" span="3" />
      <col width="85" />
      <col width="68" />
      <col width="64" />
      <tr style="line-height: 12px;">
        <td style="text-align: left;" width="22"></td>
        <td style="text-align: left;" colspan="5" width="288">PAYSLIP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BETTER THAN ICE CREAM, INC.</td>
        <td width="22"></td>
        <td width="66"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="45"></td>
        <td width="28"></td>
        <td style="text-align: left;" colspan="2">PAYROLL RECEIPT</td>
        <td style="text-align: left;" colspan="3">BETTER THAN ICE CREAM, INC.</td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td style="text-align: left;" colspan="2">EMPL#<?=$employeenumber;?></td>
        <td></td>
        <td></td>
        <td style="text-align: left;" colspan="6"><?=$cutoff;?> Half of <?=$paymonth;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$startdate;?> to <?=$enddate;?></td>
        <td></td>
        <td style="text-align: left;" colspan="2">Employer's Copy</td>
        <td style="text-align: left;" colspan="3">Dept: <?=$employeetype;?></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td style="text-align: left;" colspan="3"><?=$fullname;?></td>
        <td></td>
        <td style="text-align: left;" colspan="3">Dept: <?=$employeetype;?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: left;" colspan="2"><?=$cutoff;?> Half of <?=$paymonth;?></td>
        <td style="text-align: left;" colspan="3"><?=$startdate;?> to <?=$enddate;?></td>
      </tr>
      <tr style="line-height: 20px;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"> Week </td>
        <td>Reg. Hr.</td>
        <td>0.25</td>
        <td>0.3</td>
        <td>N/D</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php if($regular1!=NULL && $regular1>0) { ?>
        <td style="text-align: left;" colspan="3"> <?=checklabel($week1label);?> </td>
        <td style="text-align: right;"><?=$regular1;?></td>
        <td style="text-align: right;"><?=$overtime1;?></td>
        <td style="text-align: right;"><?=$specialovertime1;?></td>
        <td style="text-align: right;"><?=$nightdifferential1;?></td>
        <?php } else { echo"<td colspan=\"7\">&nbsp;</td>"; } ?>
        <td></td>
        <td style="text-align: left;" colspan="2">EMPL#<?=$employeenumber;?></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php if($regular2!=NULL && $regular2>0) { ?>
        <td style="text-align: left;" colspan="3"> <?=checklabel($week2label);?> </td>
        <td style="text-align: right;"><?=$regular2;?></td>
        <td style="text-align: right;"><?=$overtime2;?></td>
        <td style="text-align: right;"><?=$specialovertime2;?></td>
        <td style="text-align: right;"><?=$nightdifferential2;?></td>
        <?php } else { echo"<td colspan=\"7\">&nbsp;</td>"; } ?>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php if($regular3!=NULL && $regular3>0) { ?>
        <td style="text-align: left;" colspan="3"> <?=checklabel($week3label);?> </td>
        <td style="text-align: right;"><?=$regular3;?></td>
        <td style="text-align: right;"><?=$overtime3;?></td>
        <td style="text-align: right;"><?=$specialovertime3;?></td>
        <td style="text-align: right;"><?=$nightdifferential3;?></td>
        <?php } else { echo"<td colspan=\"7\">&nbsp;</td>"; } ?>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 20px;">
        <td></td>
        <td style="text-align: left;">INCOME</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: left;" colspan="2">DEDUCTIONS</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td style="text-align: left;" colspan="2">Reg Pay</td>
        <td style="text-align: right;"><?=$basicpay1;?></td>
        <td></td>
        <td style="text-align: left;" colspan="2">SSS</td>
        <td style="text-align: right;"><?=$sss;?></td>
        <td></td>
        <td style="text-align: left;"># of VL</td>
        <td style="text-align: right;"><?=$totalvacation;?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td style="text-align: left;" colspan="2">Overtime</td>
        <td style="text-align: right;"><?=number_format((str_replace(',','',$regularotpay)+str_replace(',','',$specialotpay)),2);?></td>
        <td></td>
        <td style="text-align: left;" colspan="2">PHIC</td>
        <td style="text-align: right;"><?=$phic;?> </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: left;" colspan="3"><?=$fullname;?></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td style="text-align: left;" colspan="2">Night Differential</td>
        <td style="text-align: right;"><?=$nighttimepay;?></td>
        <td></td>
        <td style="text-align: left;" colspan="2">HDMF</td>
        <td style="text-align: right;"><?=$hdmf;?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td style="text-align: left;" colspan="2">VL Pay</td>
        <td style="text-align: right;"><?=$vacationpay;?></td>
        <td></td>
        <td style="text-align: left;" colspan="2">SSS SL</td>
        <td style="text-align: right;"><?=$sssloan;?></td>
        <td></td>
        <td style="text-align: left;" colspan="1">SSS CL</td>
        <td style="text-align: right;"><?php if($sssloan2<=0){ echo '0.00'; } else { echo $sssloan2; } ?></td>
        <td></td>
        <td style="text-align: left;" colspan="2">Amount Paid: &nbsp;&nbsp;&nbsp;P</td>
        <td>_______________</td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td style="text-align: left;" colspan="2">Hol Pay</td>
        <td style="text-align: right;"><?=$holidaypay;?></td>
        <td></td>
        <td style="text-align: left;" colspan="2">HDMF STL</td>
        <td style="text-align: right;"><?=$hdmfloan;?></td>
        <td></td>
        <td style="text-align: left;" colspan="1">HDMF CL</td>
        <td style="text-align: right;"><?php if($hdmfloan2<=0){ echo '0.00'; } else { echo $hdmfloan2; } ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 12px;">
        <td></td>
        <td style="text-align: left;" colspan="2">Adj</td>
        <td style="text-align: right;"><?php if($adjustment>0){echo $adjustment;} else{echo"0.00";}?></td>
        <td></td>
        <td style="text-align: left;" colspan="2">Adj</td>
        <td style="text-align: right;"><?php if($adjustment<0){ echo $adjustment; } else{echo"0.00";}?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="line-height: 20px;">
        <td></td>
        <td style="text-align: left;" colspan="2">GROSS PAY</td>
        <td style="text-align: right;"><?=$grosspay1;?> </td>
        <td></td>
        <td style="text-align: left;" colspan="2">TOTAL DED</td>
        <td style="text-align: right;"><?=$totaldeduction;?> </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: left;" colspan="5">Received By: _______________ &nbsp;&nbsp;&nbsp; Date: _______________</td>
      </tr>
      <tr style="line-height: 20px;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: left;"> NET PAY </td>
        <td colspan="2" width="96"><?=$netpay;?> </td>
        <td></td>
        <td></td>
        <td style="text-align: left;" colspan="3">Print Date: <?=date('Y-m-d');?></td>
        <td></td>
        <td></td>
      </tr>
    </table>
<?php
}
?>