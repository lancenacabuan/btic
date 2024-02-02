<?php //********************BTIC Sales & Payroll System v15.24.0202.1730********************//
include('functions.php');
php_security();
if($_SESSION['usertype']!='btic_admin' && $_SESSION['usertype']!='btic_payroll')
{ redirect_home(); }
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
    reload_page();
}
$table='payroll';
$_SESSION['formtype']=$table;
$_SESSION['HTTP_REFERER']='transactions-payroll.php';
$colwidth=array();
$thname=array();
$colname=array();
$component=NULL;
$title=' - Payroll';
$tab=array('transactions-payroll.php'=>'Payroll');
html_start($title,$tab);
btn_visibility();
?>
<script>
$(document).ready(function(){
    $('.dataTables_filter input').on('input',function(){
        if($(this).val!=null){
            $('#btnSave').hide(),
            $('#btnConfirm').show();
        }
    })
});
$(document).ready(function(){
    $('#btnConfirm').click(function(){
        $('#btnSave').show(),
        $('#btnConfirm').hide(),
        $('.dataTables_filter input').val(''),
        $('#payroll').dataTable().fnFilter(''),
        $('#payroll_form').dataTable().fnFilter('');
    })
});
</script>
<?php

if($_SESSION['visibility']=='hidden')
{ $where=""; }
else
{ $where="WHERE NOT status='hidden' "; }

if($_POST['id']==NULL)
{ $form='Payroll Form'; }
else
{ $form=$_POST['fullname']; }
$new='transactions-payroll.php';
?>
<form class="form-inline" method="post" role="form">
    <a href="reports-payroll.php" class="btn btn-info" role="button" style="position: fixed; top: 105px; left: 120px; right: 0px; z-index: 1000; width: 150px; box-shadow: 5px 5px 5px grey;" data-toggle="tooltip" data-placement="bottom" title="[Reports] - Payroll section">SHOW REPORTS</a>
</form>
<a href="<?php echo($new);?>">
    <button id="new" type="button" data-toggle="tooltip" data-placement="right" title="Create new record.">+</button>
</a>
<div class="panel panel-default">
<div class="panel-heading" style="font-size: 20px;"><?=$form;?></div>
<?php
if($_POST['id']!=NULL)
{
?>
<form class="form-inline" method="post" role="form" action="<?=$new;?>">
<br />
<input name="id" type="hidden" value="<?=$_POST['id'];?>"/>
<input name="employeenumber" type="hidden" value="<?=$_POST['employeenumber'];?>"/>
<input name="category" type="hidden" value="<?=$_POST['category'];?>"/>
<?php
if(strpos($_POST['sssbracket'],'new')!==false)
{
    $checked1='checked';
    $checked2=NULL;
}
else
{
    $checked1=NULL;
    $checked2='checked';
}
?>
<div class="form-group" style="display: none;">
    <label>S.S.S. Contribution Bracket</label><br />
    <label class="radio-inline">
        <input type="radio" name="sssbracket" value="new" <?=$checked1;?> required><span style="font-size: 12px;" class="label label-success">Current / New</span>
    </label>
    <label class="radio-inline">
        <input type="radio" name="sssbracket" value="old" <?=$checked2;?>><span style="font-size: 12px;" class="label label-danger">Previous / Old</span>
    </label>
</div>
<div class="form-group">
    <label>Pay Year</label>
    <input style="width: 100px;" class="form-control" type="number" name="payyear" min="2000" max="2999" step="1" value="<?php if($_POST['payyear']==NULL) { echo date("Y"); } else { echo $_POST['payyear']; }?>" required>
</div>
<div class="form-group">
    <label>Pay Month</label>
    <select style="width: 200px; text-align-last: center;" class="form-control" name="paymonth" required>
        <option value="" disabled<?php if($_POST['paymonth']==NULL) echo 'selected'; ?>>---required--- (Month)</option>
        <option value="JANUARY" <?php if($_POST['paymonth']=='JANUARY') echo 'selected'; ?>>JANUARY</option>
        <option value="FEBRUARY" <?php if($_POST['paymonth']=='FEBRUARY') echo 'selected'; ?>>FEBRUARY</option>
        <option value="MARCH" <?php if($_POST['paymonth']=='MARCH') echo 'selected'; ?>>MARCH</option>
        <option value="APRIL" <?php if($_POST['paymonth']=='APRIL') echo 'selected'; ?>>APRIL</option>
        <option value="MAY" <?php if($_POST['paymonth']=='MAY') echo 'selected'; ?>>MAY</option>
        <option value="JUNE" <?php if($_POST['paymonth']=='JUNE') echo 'selected'; ?>>JUNE</option>
        <option value="JULY" <?php if($_POST['paymonth']=='JULY') echo 'selected'; ?>>JULY</option>
        <option value="AUGUST" <?php if($_POST['paymonth']=='AUGUST') echo 'selected'; ?>>AUGUST</option>
        <option value="SEPTEMBER" <?php if($_POST['paymonth']=='SEPTEMBER') echo 'selected'; ?>>SEPTEMBER</option>
        <option value="OCTOBER" <?php if($_POST['paymonth']=='OCTOBER') echo 'selected'; ?>>OCTOBER</option>
        <option value="NOVEMBER" <?php if($_POST['paymonth']=='NOVEMBER') echo 'selected'; ?>>NOVEMBER</option>
        <option value="DECEMBER" <?php if($_POST['paymonth']=='DECEMBER') echo 'selected'; ?>>DECEMBER</option>
    </select>
</div>
<div class="form-group">
    <label>Start Date</label>
    <input class="form-control" name="startdate" type="date" value="<?=$_POST['startdate'];?>" required>
</div>
<div class="form-group">
    <label>End Date</label>
    <input class="form-control" name="enddate" type="date" value="<?=$_POST['enddate'];?>" required>
</div>
<br />
<?php
if($_POST['cutoff']=='1st')
{
    $checked1='checked';
    $checked2=NULL;
}
else if($_POST['cutoff']=='2nd')
{
    $checked1=NULL;
    $checked2='checked';
}
if($_POST['paid']!='0.00')
{
    $checked3='checked';
}
if(strpos($_POST['sssbracket'],'no')!==false)
{
    $checked4='checked';
}
?>
<div class="form-group" style="padding-top: 6px;">
    <label class="radio-inline"><input type="radio" name="cutoff" value="1st" <?=$checked1;?> required>1st Cut-Off</label>
    <label class="radio-inline"><input type="radio" name="cutoff" value="2nd" <?=$checked2;?>>2nd Cut-Off</label>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="checkbox-inline" style="padding-top: 6px;">
    <input type="checkbox" name="chkUpdate" value="yes"><strong style="margin-left: 5px;">Update Rate / Loan Changes</strong>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="checkbox-inline" style="padding-top: 6px;">
    <input type="checkbox" name="nodeductions" value="no" <?=$checked4;?>><strong style="margin-left: 5px;">Remove Deductions</strong>
</div>
<br />
<br />
<center>
<table border="0">
<tr>
    <td><label>Rate</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="rate" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['rate']);?>">&nbsp;</td>
    <td><label>Week 1</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="week1" type="number" min="0" step="0.01" value="<?=str_replace(',','',number_format((str_replace(',','',$_POST['regular1'])-str_replace(',','',$_POST['paid'])-str_replace(',','',$_POST['oldhrs'])),2));?>">&nbsp;</td>
    <td><label>Week 2</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="week2" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['regular2']);?>">&nbsp;</td>
    <td><label>Week 3</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="week3" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['regular3']);?>">&nbsp;</td>
</tr>
<tr>
    <td><label>Old Rate</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="oldrate" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['oldrate']);?>">&nbsp;</td>
    <td><label>(0.25) 1</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="overtime1" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['overtime1'])-str_replace(',','',$_POST['oldOT1']);?>">&nbsp;</td>
    <td><label>(0.25) 2</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="overtime2" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['overtime2']);?>">&nbsp;</td>
    <td><label>(0.25) 3</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="overtime3" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['overtime3']);?>">&nbsp;</td>
</tr>
<tr>
    <td><label>Reg. Hrs. (Old Rate)</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="oldhrs" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['oldhrs']);?>">&nbsp;</td>
    <td><label>(0.30) 1</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="specialovertime1" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['specialovertime1']);?>">&nbsp;</td>
    <td><label>(0.30) 2</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="specialovertime2" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['specialovertime2']);?>">&nbsp;</td>
    <td><label>(0.30) 3</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="specialovertime3" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['specialovertime3']);?>">&nbsp;</td>
</tr>
<tr>
    <td><label>OT Hrs. 0.25 (Old Rate)</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="oldOT1" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['oldOT1']);?>">&nbsp;</td>
    <td><label>Night Diff. 1</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="nightdifferential1" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['nightdifferential1'])-str_replace(',','',$_POST['oldND1']);?>">&nbsp;</td>
    <td><label>Night Diff. 2</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="nightdifferential2" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['nightdifferential2']);?>">&nbsp;</td>
    <td><label>Night Diff. 3</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="nightdifferential3" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['nightdifferential3']);?>">&nbsp;</td>
</tr>
<tr>
    <td><label>Night Diff. Hrs. (Old Rate)</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="oldND1" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['oldND1']);?>">&nbsp;</td>
    <td><label>Holiday</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="holiday" type="number" min="0" step="1" value="<?=str_replace(',','',$_POST['holiday']);?>">&nbsp;</td>
    <td><label>Vacation</label></td>
    <td>&nbsp;<input style="width: 100px;" class="form-control" name="vacation" type="number" min="0" max="12" step="1" value="<?=str_replace(',','',$_POST['vacation']);?>">&nbsp;</td>
    <td><label>Adjustment</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="adjustment" type="number" step="0.01" value="<?=str_replace(',','',$_POST['adjustment']);?>">&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><label>Comment</label></td>
    <td colspan="5"><input style="width: 420px;" class="form-control" name="comment" type="text" maxlength="80" value="<?=validate($_POST['comment']);?>">&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><label>S.S.S. SL</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="sssloan" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['sssloan']);?>">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><label>H.D.M.F. STL</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="hdmfloan" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['hdmfloan']);?>">&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><label>S.S.S. CL</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="sssloan2" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['sssloan2']);?>">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><label>H.D.M.F. CL</label></td>
    <td>&nbsp;<input style="width: 150px;" class="form-control" name="hdmfloan2" type="number" min="0" step="0.01" value="<?=str_replace(',','',$_POST['hdmfloan2']);?>">&nbsp;</td>
</tr>
</table>
<table align="center" border="0" width="500">
    <tr><td><br /><h2 align="left" style="vertical-align: middle; padding-bottom: 20px; width: 250;">BASIC PAY:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;₱</h2></td><td><h2 align="right" style="vertical-align: middle; width: 250"><?=$_POST['basicpay1'];?></h2></td></tr>
    <tr><td><br /><h2 align="left" style="vertical-align: middle; padding-bottom: 20px;">GROSS PAY:</h2></td><td><h2 align="right" style="vertical-align: middle;"><?=$_POST['grosspay1'];?></h2></td></tr>
    <tr><td><br /><h2 align="left" style="vertical-align: middle; padding-bottom: 20px;">NET PAY:</h2></td><td><h2 align="right" style="vertical-align: middle;"><?=$_POST['netpay'];?></h2></td></tr>
</table>
</center>
<br />
<input style="height: 50px; width: 100%;" class="form-control btn btn-lg btn-success" name="btnUpdate" type="submit" value="UPDATE RECORD" onclick="return confirm('UPDATE: Do you really want to UPDATE this record?');" />
<input style="height: 50px; width: 100%;" class="form-control btn btn-lg btn-danger" name="btnDelete" type="submit" value="DELETE RECORD" onclick="return confirm('WARNING: This action cannot be undone!\nDELETE: Do you really want to DELETE this record?');" />
</form>    
<?php
}
else
{
?>
<form class="form-inline" method="post" role="form" action="<?=$new;?>">
<div style="zoom: 95%;">
<br />
<div class="form-group" style="display: none;">
    <label>S.S.S. Contribution Bracket</label><br />
    <label class="radio-inline">
        <input type="radio" name="sssbracket" value="new" checked required><span style="font-size: 12px;" class="label label-success">Current / New</span>
    </label>
    <label class="radio-inline">
        <input type="radio" name="sssbracket" value="old"><span style="font-size: 12px;" class="label label-danger">Previous / Old</span>
    </label>
</div>
<div class="form-group">
    <label>Pay Year</label>
    <input style="width: 100px;" class="form-control" type="number" name="payyear" min="2000" max="2999" step="1" value="<?php echo date("Y"); ?>" required>
</div>
<div class="form-group">
    <label>Pay Month</label>
    <select style="width: 200px; text-align-last: center;" class="form-control" name="paymonth" required>
        <option value="" disabled selected>---required--- (Month)</option>
        <option value="JANUARY">JANUARY</option>
        <option value="FEBRUARY">FEBRUARY</option>
        <option value="MARCH">MARCH</option>
        <option value="APRIL">APRIL</option>
        <option value="MAY">MAY</option>
        <option value="JUNE">JUNE</option>
        <option value="JULY">JULY</option>
        <option value="AUGUST">AUGUST</option>
        <option value="SEPTEMBER">SEPTEMBER</option>
        <option value="OCTOBER">OCTOBER</option>
        <option value="NOVEMBER">NOVEMBER</option>
        <option value="DECEMBER">DECEMBER</option>
    </select>
</div>
<div class="form-group">
    <label>Start Date</label>
    <input class="form-control" name="startdate" type="date" required>
</div>
<div class="form-group">
    <label>End Date</label>
    <input class="form-control" name="enddate" type="date" required>
</div>
<br />
<div class="form-group">
    <label class="radio-inline"><input type="radio" name="cutoff" value="1st" required>1st Cut-Off</label>
    <label class="radio-inline"><input type="radio" name="cutoff" value="2nd">2nd Cut-Off</label>
</div>
<div class="form-group">
    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Holiday</label>
    <input style="width: 100px;" class="form-control" name="holiday" type="number" min="0" step="1">
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="checkbox-inline" style="padding-bottom: 4px;">
    <input type="checkbox" name="chkUpdate" value="yes"><strong style="margin-left: 5px;">Update Rate / Loan Changes</strong>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="checkbox-inline" style="padding-bottom: 4px;">
    <input type="checkbox" name="nodeductions" value="no"><strong style="margin-left: 5px;">Remove Deductions</strong>
</div>
<br />
<table id="payroll_form" class="table-striped nowrap">
<thead style="background-color: white;">
    <tr>
    <th>Employee Type</th>
    <th>Employee Name</th>
    <th>Rate</th>
    <th>Old Rate</th>
    <th>Reg. Hrs. (Old Rate)</th>
    <th>Week 1</th>
    <th>Week 2</th>
    <th>Week 3</th>
    <th>OT Hrs. 0.25 (Old Rate)</th>
    <th>(0.25) 1</th>
    <th>(0.25) 2</th>
    <th>(0.25) 3</th>
    <th>(0.30) 1</th>
    <th>(0.30) 2</th>
    <th>(0.30) 3</th>
    <th>Night Diff. Hrs. (Old Rate)</th>
    <th>Night Diff. 1</th>
    <th>Night Diff. 2</th>
    <th>Night Diff. 3</th>
    <th>Vacation</th>
    <th>Adjustment</th>
    <th>Comment</th>
    <th>S.S.S. SL</th>
    <th>S.S.S. CL</th>
    <th>H.D.M.F. STL</th>
    <th>H.D.M.F. CL</th>
    </tr>
</thead>
<tbody>
<?php
$content=mysql_query("SELECT * FROM employees ".$where."ORDER BY employeetype ASC, lastname ASC");
$total=mysql_affected_rows();
for($x=0; $x<=$total-1; $x++)
{
    $rows=mysql_fetch_array($content);
    $employeenumber=$rows['employeenumber'];
    $employeetype=$rows['employeetype'];
    $fullname=$rows['lastname'].', '.$rows['firstname'];
    $totalvacation=str_replace('.00','',$rows['totalvacation']);
    ?>
        <tr>
        <td><?=$employeetype;?></td>
        <input name="employeenumber[]" type="hidden" value="<?=$employeenumber;?>">
        <input name="employeetype[]" type="hidden" value="<?=$employeetype;?>">
        <input name="fullname[]" type="hidden" value="<?=$fullname;?>">
        <input name="totalvacation[]" type="hidden" value="<?=$totalvacation;?>">
        <td style="text-align: left;"><?=$fullname;?></td>
        <td><input style="width: 120px;" class="form-control" name="rate[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['rate']);?>"></td>
        <td><input style="width: 120px; background-color: gray; color: white; cursor: pointer;" class="form-control" name="oldrate[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px; background-color: gray; color: white; cursor: pointer;" class="form-control" name="oldhrs[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="week1[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="week2[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="week3[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px; background-color: gray; color: white; cursor: pointer;" class="form-control" name="oldOT1[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="overtime1[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="overtime2[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="overtime3[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="specialovertime1[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="specialovertime2[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="specialovertime3[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px; background-color: gray; color: white; cursor: pointer;" class="form-control" name="oldND1[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="nightdifferential1[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="nightdifferential2[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="nightdifferential3[]" type="number" min="0" step="0.01"></td>
        <td><input style="width: 100px;" class="form-control" name="vacation[]" type="number" min="0" max="<?=$totalvacation;?>" step="1" placeholder="Left: <?=$totalvacation;?>"></td>
        <td><input style="width: 120px;" class="form-control" name="adjustment[]" type="number" step="0.01"></td>
        <td><input style="width: 300px;" class="form-control" name="comment[]" type="text" maxlength="80"></td>
        <td><input style="width: 120px;" class="form-control" name="sssloan[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['sssloan']);?>"></td>
        <td><input style="width: 120px;" class="form-control" name="sssloan2[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['sssloan2']);?>"></td>
        <td><input style="width: 120px;" class="form-control" name="hdmfloan[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['hdmfloan']);?>"></td>
        <td><input style="width: 120px;" class="form-control" name="hdmfloan2[]" type="number" min="0" step="0.01" value="<?=str_replace(',','',$rows['hdmfloan2']);?>"></td>
        </tr>
    <?php
}
?>
</tbody>
</table>
</div>
<br />
<input class="form-control btn btn-primary" id="btnSave" name="btnSave" type="submit" value="SAVE RECORD" onclick="return confirm('SAVE: Do you really want to SAVE this record?');" style="position: fixed; top: 105px; right: 240px; z-index: 1000; box-shadow: 5px 5px 5px grey; width: 150px;"/>
</form>
<button id="btnConfirm" class="btn btn-basic" style="position: fixed; top: 105px; right: 240px; z-index: 1000; box-shadow: 5px 5px 5px grey; width: 150px; display: none;">CONFIRM RECORD</button>
<?php
}
?>
</div>
<?php
if(isset($_POST['btnSave']))
{
    $successful=array();
    $unsuccessful=array();
    $negative=array();
    $duplicate=array();
    for($x=0; $x<=$total-1; $x++)
    {
        $sssbracket=validate($_POST['sssbracket']);
        $payyear=validate($_POST['payyear']);
        $paymonth=validate($_POST['paymonth']);
        $startdate=validate($_POST['startdate']);
        $enddate=validate($_POST['enddate']);
        $cutoff=validate($_POST['cutoff']);
        $creditlast=validate($_POST['creditlast']);
        
        mysql_query("SELECT * FROM payroll WHERE startdate>'$startdate'");
        if(mysql_affected_rows()<=0)
        { $payslip='latest'; }
        
        $employeenumber=$_POST['employeenumber'][$x];
        $employeetype=$_POST['employeetype'][$x];
        if($employeetype=='OFFICE' || $employeetype=='PRODUCTION')
        { $category='Direct Labor'; }
        else
        { $category='Salaries and Wages'; }
        $fullname=$_POST['fullname'][$x];
        $rate=number_format(validate($_POST['rate'][$x]),2);
        $rateperhour=number_format((str_replace(',','',$rate)/8),6);
        $oldrate=number_format(validate($_POST['oldrate'][$x]),2);
        $oldrateperhour=number_format((str_replace(',','',$oldrate)/8),6);
        
        if($cutoff=='1st' && $creditlast=='yes')
        {
            $year=substr($startdate,0,4);
            $month=substr($startdate,5,2);
            $day=substr($startdate,8,2);
            if($day>=16 && $day<=31)
            {
                $temp=true;
            }
            else
            {
                if($month=='01')
                {
                    $year=$year-1;
                    $month=12;
                }
                else
                {
                    if($month!=10 && $month!=11 && $month!=12)
                    {
                        $month=substr($month,1,1);
                        $month='0'.($month-1);
                    }
                    else if($month==11 || $month==12)
                    {
                        $month=$month-1;
                    }
                    else if($month==10)
                    {
                       $month='09';
                    }
                }
            }
            $lastcutoff=$year.'-'.$month;
            $content1=mysql_query("SELECT * FROM payroll WHERE fullname='".$fullname."' AND startdate LIKE '".$lastcutoff."%' AND cutoff='2nd'");
            $total1=mysql_affected_rows();
            for($y=0; $y<=$total1-1; $y++)
            {
                $rows1=mysql_fetch_array($content1);
                $paid=str_replace(',','',$rows1['week3']);
            }
        }
        else
        {
            $year=substr($startdate,0,4);
            $month=substr($startdate,5,2);
            $day=substr($startdate,8,2);
            $lastcutoff=$year.'-'.$month;
            $content1=mysql_query("SELECT * FROM payroll WHERE fullname='".$fullname."' AND enddate LIKE '".$lastcutoff."%' AND cutoff='1st'");
            $total1=mysql_affected_rows();
            for($y=0; $y<=$total1-1; $y++)
            {
                $rows1=mysql_fetch_array($content1);
                if($creditlast=='yes')
                { $paid=str_replace(',','',$rows1['week3']); }
                $basicpay2=$rows1['basicpay1'];
                $grosspay2=$rows1['grosspay1'];
                $sss2=str_replace(',','',$rows1['sss']);
            }
        }
        
        $oldhrs=str_replace(',','',validate($_POST['oldhrs'][$x]));
        $week1=$paid+str_replace(',','',validate($_POST['week1'][$x]));
        $regular1=$week1-$paid;
        $overtime1=str_replace(',','',validate($_POST['overtime1'][$x]));
        $oldOT1=str_replace(',','',validate($_POST['oldOT1'][$x]));
        
        $week2=str_replace(',','',validate($_POST['week2'][$x]));
        $regular2=$week2;
        $overtime2=str_replace(',','',validate($_POST['overtime2'][$x]));
        
        $week3=str_replace(',','',validate($_POST['week3'][$x]));
        $regular3=$week3;
        $overtime3=str_replace(',','',validate($_POST['overtime3'][$x]));
        
        $totalregular=number_format(($regular1+$regular2+$regular3),2);
        $totalregular1=number_format(($regular1+$regular2+$regular3+$oldhrs),2);
        $basicpay1=number_format((str_replace(',','',$totalregular)*str_replace(',','',$rateperhour)) + (str_replace(',','',$oldhrs)*str_replace(',','',$oldrateperhour)) ,2);
        $totalregular=$totalregular1;
        
        $regularovertime=number_format(($overtime1+$overtime2+$overtime3),2);
        $regularovertime1=number_format(($overtime1+$overtime2+$overtime3+$oldOT1),2);
        $regularotpay=number_format(((str_replace(',','',$regularovertime)*str_replace(',','',$rateperhour))*1.25) + ((str_replace(',','',$oldOT1)*str_replace(',','',$oldrateperhour))*1.25),2);
        $regularovertime=$regularovertime1;
        
        $specialovertime1=validate($_POST['specialovertime1'][$x]);
        $specialovertime2=validate($_POST['specialovertime2'][$x]);
        $specialovertime3=validate($_POST['specialovertime3'][$x]);
        $totalspecialot=$specialovertime1+$specialovertime2+$specialovertime3;
        $specialotpay=number_format((($totalspecialot*str_replace(',','',$rateperhour))*1.3),2);
        
        $oldND1=validate($_POST['oldND1'][$x]);
        $nightdifferential1=validate($_POST['nightdifferential1'][$x]);
        $nightdifferential2=validate($_POST['nightdifferential2'][$x]);
        $nightdifferential3=validate($_POST['nightdifferential3'][$x]);
        $totalnightdiff=$nightdifferential1+$nightdifferential2+$nightdifferential3;
        $totalnightdiff1=$nightdifferential1+$nightdifferential2+$nightdifferential3+$oldND1;
        $nighttimepay=number_format((($totalnightdiff*str_replace(',','',$rateperhour))*1.1) + (($oldND1*str_replace(',','',$oldrateperhour))*1.1),2);
        $totalnightdiff=$totalnightdiff1;
        
        $week1=$regular1+$overtime1+$nightdifferential1+$oldhrs+$oldOT1+$oldND1;
        $week2=$regular2+$overtime2+$nightdifferential2;
        $week3=$regular3+$overtime3+$nightdifferential3;
        $overalltotal=$week1+$week2+$week3;
        
        $paid=number_format($paid,2);
        $oldhrs=number_format($oldhrs,2);
        $week1=number_format($week1,2);
        $week2=number_format($week2,2);
        $week3=number_format($week3,2);
        $overalltotal=number_format($overalltotal,2);
        $regular1=number_format($regular1+$oldhrs,2);
        $regular2=number_format($regular2,2);
        $regular3=number_format($regular3,2);
        $oldOT1=number_format($oldOT1,2);
        $overtime1=number_format($overtime1+$oldOT1,2);
        $overtime2=number_format($overtime2,2);
        $overtime3=number_format($overtime3,2);
        $specialovertime1=number_format($specialovertime1,2);
        $specialovertime2=number_format($specialovertime2,2);
        $specialovertime3=number_format($specialovertime3,2);
        $totalspecialot=number_format($totalspecialot,2);
        $oldND1=number_format($oldND1,2);
        $nightdifferential1=number_format($nightdifferential1+$oldND1,2);
        $nightdifferential2=number_format($nightdifferential2,2);
        $nightdifferential3=number_format($nightdifferential3,2);
        $totalnightdiff=number_format($totalnightdiff,2);
        
        if($overtime1==NULL)
        { $overtime1='0.00'; }
        if($overtime2==NULL)
        { $overtime2='0.00'; }
        if($overtime3==NULL)
        { $overtime3='0.00'; }
        
        $holiday=validate($_POST['holiday']);
        $holidaypay=number_format(($holiday*str_replace(',','',$rate)),2);
        $vacation=validate($_POST['vacation'][$x]);
        if($vacation>=str_replace(',','',$_POST['totalvacation'][$x]) && $vacation>0 && $vacation!=NULL)
        {
            $xvacation=str_replace(',','',$_POST['totalvacation'][$x]);
            $totalvacation='0.00';
            $vacationpay=number_format(($xvacation*str_replace(',','',$rate)),2);
            alert('NOTICE: '.$fullname.' has no remaining vacation/s left.\n'.number_format($xvacation,2).' out of '.number_format($vacation,2).' vacation/s were credited.');
            $vacation=$xvacation;
        }
        else
        {
            $totalvacation=number_format((str_replace(',','',$_POST['totalvacation'][$x])-$vacation),2);
            $vacationpay=number_format(($vacation*str_replace(',','',$rate)),2);
        }
        if($payyear=='2018' || ($payyear=='2019' && $paymonth=='JANUARY') || ($payyear=='2019' && $paymonth=='FEBRUARY') || ($payyear=='2019' && $paymonth=='MARCH') || ($payyear=='2019' && $paymonth=='APRIL'))
        { $totalvacation='N/A'; }
        
        $holiday=number_format($holiday,2);
        $vacation=number_format($vacation,2);
        $adjust=validate($_POST['adjustment'][$x]);
        $adjustment=number_format($adjust,2);
        
        $x1=str_replace(',','',$basicpay1);
        $x2=str_replace(',','',$regularotpay);
        $x3=str_replace(',','',$specialotpay);
        $x4=str_replace(',','',$nighttimepay);
        $x5=str_replace(',','',$holidaypay);
        $x6=str_replace(',','',$vacationpay);
        $grosspay1=$x1+$x2+$x3+$x4+$x5+$x6;
        if($adjust>0)
        { $grosspay1=$grosspay1+$adjust; }
        $grosspay1=number_format($grosspay1,2);
        
        $comment=ucfirst(validate($_POST['comment'][$x]));
        $sssloan=number_format((validate($_POST['sssloan'][$x])),2);
        $sssloan2=number_format((validate($_POST['sssloan2'][$x])),2);
        $hdmfloan=number_format((validate($_POST['hdmfloan'][$x])),2);
        $hdmfloan2=number_format((validate($_POST['hdmfloan2'][$x])),2);
        
        if($cutoff=='1st')
        {
            if($payyear>=2023)
            {
                $grosspay2='0.00';
                $totalgrosspay=$grosspay1;
                $tg=str_replace(',','',$totalgrosspay);
                do
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
                while($sss<180.00 || $sss>900.00);
                $sss=number_format($sss,2);
                $basicpay2='0.00';
                $totalbasicpay=$basicpay1;
                $phic='0.00';
                $hdmf=$payyear < 2024 ? '150.00' : '200.00';
            }
            else if($payyear>=2021)
            {
                $grosspay2='0.00';
                $totalgrosspay=$grosspay1;
                $tg=str_replace(',','',$totalgrosspay);
                do
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
                while($sss<135.00 || $sss>900.00);
                $sss=number_format($sss,2);
                $basicpay2='0.00';
                $totalbasicpay=$basicpay1;
                $phic='0.00';
                $hdmf=$payyear < 2024 ? '150.00' : '200.00';
            }
            else
            {
                if(strpos($sssbracket,'new')!==false)
                {
                    $grosspay2='0.00';
                    $totalgrosspay=$grosspay1;
                    $tg=str_replace(',','',$totalgrosspay);
                    do
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
                    while($sss<80.00 || $sss>800.00);
                    $sss=number_format($sss,2);
                    $basicpay2='0.00';
                    $totalbasicpay=$basicpay1;
                    $phic='0.00';
                    $hdmf=$payyear < 2024 ? '150.00' : '200.00';
                }
                else
                {
                    $grosspay2='0.00';
                    $totalgrosspay=$grosspay1;
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
                    $sss=number_format($sss,2);
                    $basicpay2='0.00';
                    $totalbasicpay=$basicpay1;
                    $phic='0.00';
                    $hdmf=$payyear < 2024 ? '150.00' : '200.00';
                }
            }
        }
        else
        {
            if($payyear>=2023)
            {
                $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                $tg=str_replace(',','',$totalgrosspay);
                do
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
                while($sss<180.00 || $sss>900.00);
                $sss=number_format(($sss-$sss2),2);
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
                else if($tb>=10000.01 && $tb<=39999.99)
                { $phic=number_format((($tb*$phic2)/2),2); }
                $hdmf='0.00';
                if($basicpay2==NULL)
                { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
            }
            else if($payyear>=2021)
            {
                $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                $tg=str_replace(',','',$totalgrosspay);
                do
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
                while($sss<135.00 || $sss>900.00);
                $sss=number_format(($sss-$sss2),2);
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
                else if($tb>=10000.01 && $tb<=39999.99)
                { $phic=number_format((($tb*$phic2)/2),2); }
                $hdmf='0.00';
                if($basicpay2==NULL)
                { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
            }
            else
            {
                if(strpos($sssbracket,'new')!==false)
                {
                    $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                    $tg=str_replace(',','',$totalgrosspay);
                    do
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
                    while($sss<80.00 || $sss>800.00);
                    $sss=number_format(($sss-$sss2),2);
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
                    else if($tb>=10000.01 && $tb<=39999.99)
                    { $phic=number_format((($tb*$phic2)/2),2); }
                    $hdmf='0.00';
                    if($basicpay2==NULL)
                    { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
                }
                else
                {
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
                    $sss=number_format(($sss-$sss2),2);
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
                    else if($tb>=10000.01 && $tb<=39999.99)
                    { $phic=number_format((($tb*$phic2)/2),2); }
                    $hdmf='0.00';
                    if($basicpay2==NULL)
                    { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
                }
            }
        }
                
        if($basicpay1=='0.00' && $grosspay1=='0.00')
        {
            $adjustment='0.00';
            $sssloan='0.00';
            $sssloan2='0.00';
            $hdmfloan='0.00';
            $hdmfloan2='0.00';
            $sss='0.00';
            $phic='0.00';
            $hdmf='0.00';
        }
        
        if($_POST['nodeductions']=='no' || ($payyear=='2020' && $paymonth=='APRIL') || ($payyear=='2020' && $paymonth=='MAY' && $category!='Direct Labor'))
        {
            $sssloan='0.00';
            $sssloan2='0.00';
            $hdmfloan='0.00';
            $hdmfloan2='0.00';
            $sss='0.00';
            $phic='0.00';
            $hdmf='0.00';
        }
        $sssbracket=$sssbracket.' '.$_POST['nodeductions'];
        
        $y1=str_replace(',','',$sssloan);
        $y2=str_replace(',','',$sssloan2);
        $y3=str_replace(',','',$hdmfloan);
        $y4=str_replace(',','',$hdmfloan2);
        $y5=str_replace(',','',$sss);
        $y6=str_replace(',','',$phic);
        $y7=str_replace(',','',$hdmf);
        $totaldeduction=$y1+$y2+$y3+$y4+$y5+$y6+$y7;
        if($adjust<0)
        { $totaldeduction=$totaldeduction-$adjust; }
        $totaldeduction=number_format($totaldeduction,2);
        
        $netpay=number_format((str_replace(',','',$grosspay1))-(str_replace(',','',$totaldeduction)),2);
        
        if(str_replace(',','',$netpay)<0.00)
        {
            $unsaved=$unsaved+1;
            $negative[]='<br />'.$fullname;
        }
        
        if(str_replace(',','',$netpay)>0.00)
        {
            mysql_query("SELECT * FROM ".$table." WHERE employeenumber='".$employeenumber."' AND payyear='".$payyear."' AND paymonth='".$paymonth."' AND cutoff='".$cutoff."'");
            if(mysql_affected_rows()<=0)
            {
                do
                {
                    mysql_query("INSERT INTO ".$table." VALUES (DEFAULT,'".$payyear."','".$paymonth."','".$startdate."','".$enddate."','".$cutoff."','".$employeetype."','".$employeenumber."','".$fullname."','".$oldrate."','".$oldrateperhour."','".$oldhrs."','".$oldOT1."','".$oldND1."','".$rate."','".$rateperhour."','".$overalltotal."','".$week1."','".$paid."','".$regular1."','".$overtime1."','".$week2."','".$regular2."','".$overtime2."','".$week3."','".$regular3."','".$overtime3."','".$totalregular."','".$basicpay1."','".$basicpay2."','".$totalbasicpay."','".$regularovertime."','".$regularotpay."','".$specialovertime1."','".$specialovertime2."','".$specialovertime3."','".$totalspecialot."','".$specialotpay."','".$nightdifferential1."','".$nightdifferential2."','".$nightdifferential3."','".$totalnightdiff."','".$nighttimepay."','".$holiday."','".$holidaypay."','".$vacation."','".$vacationpay."','".$totalvacation."','".$grosspay1."','".$grosspay2."','".$totalgrosspay."','".$adjustment."','".$comment."','".$sssloan."','".$sssloan2."','".$hdmfloan."','".$hdmfloan2."','".$sss."','".$phic."','".$hdmf."','".$totaldeduction."','".$netpay."','".$category."','".$sssbracket."')");
                }
                while(mysql_affected_rows()!=1);
                $check_query=mysql_affected_rows();
                if($check_query<=0)
                {
                    $unsaved=$unsaved+1;
                    $unsuccessful[]='<br />'.$fullname;
                }
                else
                { $successful[]='<br />'.$fullname; }
                $mysql_affected_rows=$mysql_affected_rows+$check_query;
                
                if($check_query>0)
                {
                    if($totalvacation!='N/A' && $payslip=='latest')
                    { mysql_query("UPDATE employees SET totalvacation='".$totalvacation."' WHERE employeenumber='".$employeenumber."'"); }
                }
            }
            else
            {
                $unsaved=$unsaved+1;
                $duplicate[]='<br />'.$fullname;
            }
            
            if($check_query>0)
            {
                if($_POST['chkUpdate']=='yes')
                {
                    $contentu=mysql_query("SELECT * FROM employees WHERE employeenumber='".$employeenumber."'");
                    $totalu=mysql_affected_rows();
                    for($u=0; $u<=$totalu-1; $u++)
                    {
                        $rowsu=mysql_fetch_array($contentu);
                        $rateu=$rowsu['rate'];
                        $sssloanu=$rowsu['sssloan'];
                        $sssloanu2=$rowsu['sssloan2'];
                        $hdmfloanu=$rowsu['hdmfloan'];
                        $hdmfloanu2=$rowsu['hdmfloan2'];
                    }
                    if($rate!=$rateu || $sssloan!=$sssloanu || $sssloan2!=$sssloanu2 || $hdmfloan!=$hdmfloanu || $hdmfloan2!=$hdmfloanu2)
                    {
                        mysql_query("UPDATE employees SET rate='".$rate."',sssloan='".$sssloan."',sssloan2='".$sssloan2."',hdmfloan='".$hdmfloan."',hdmfloan2='".$hdmfloan2."' WHERE employeenumber='".$employeenumber."'");
                        $check_queryu=mysql_affected_rows();
                        $mysql_affected_rowsu=$mysql_affected_rowsu+$check_queryu;
                    }
                }

                if($cutoff=='1st')
                {
                    $contentc=mysql_query("SELECT * FROM payroll WHERE employeenumber='".$employeenumber."' AND payyear='".$payyear."' AND paymonth='".$paymonth."' AND cutoff='2nd'");
                    $totalc=mysql_affected_rows();
                    if($totalc==1)
                    {
                        for($c=0; $c<=$totalc-1; $c++)
                        {
                            $rowsc=mysql_fetch_array($contentc);
                        }
                        $basicpay2=$rowsc['basicpay1'];
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
                        else if($tb>=10000.01 && $tb<=39999.99)
                        { $phic=number_format((($tb*$phic2)/2),2); }
                        $hdmf='0.00';
                        if(strpos($sssbracket,'new')!==false)
                        {
                            $prevsss=$sss;
                            $grosspay2=$rowsc['grosspay1'];
                            $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                            $tg=str_replace(',','',$totalgrosspay);
                            
                            do
                            {
                                if($payyear>=2023)
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
                            $sss=number_format(($sss-(str_replace(',','',$prevsss))),2);
                        }
                        else
                        {
                            $prevsss=$sss;
                            $grosspay2=$rowsc['grosspay1'];
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
                            $sss=number_format(($sss-(str_replace(',','',$prevsss))),2);
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
                        $y1=str_replace(',','',$rowsc['sssloan']);
                        $y2=str_replace(',','',$rowsc['sssloan2']);
                        $y3=str_replace(',','',$rowsc['hdmfloan']);
                        $y4=str_replace(',','',$rowsc['hdmfloan2']);
                        $y5=str_replace(',','',$sss);
                        $y6=str_replace(',','',$phic);
                        $y7=str_replace(',','',$rowsc['hdmf']);
                        $totaldeduction=$y1+$y2+$y3+$y4+$y5+$y6+$y7;
                        $adjust=str_replace(',','',$rowsc['adjustment']);
                        if($adjust<0)
                        { $totaldeduction=$totaldeduction-$adjust; }
                        $totaldeduction=number_format($totaldeduction,2);
                        $netpay=number_format((str_replace(',','',$rowsc['grosspay1']))-(str_replace(',','',$totaldeduction)),2);
                        mysql_query("UPDATE ".$table." SET basicpay1='".$basicpay2."',basicpay2='".$basicpay1."',totalbasicpay='".$totalbasicpay."',grosspay1='".$grosspay2."',grosspay2='".$grosspay1."',totalgrosspay='".$totalgrosspay."',sss='".$sss."',phic='".$phic."',hdmf='".$hdmf."',totaldeduction='".$totaldeduction."',netpay='".$netpay."' WHERE id='".$rowsc['id']."'");
                    }
                }
            }
        }
    }
    if($mysql_affected_rows>0)
    { alert('SUCCESS: '.$mysql_affected_rows.' Payroll record/s have been saved.'); }
    if($unsaved>0)
    { alert('FAILED: '.$unsaved.' Payroll record/s are not saved.'); }
    if($mysql_affected_rowsu>0)
    { alert('SUCCESS: '.$mysql_affected_rowsu.' Employee record/s have been updated.'); }
    ?>
    <div style="margin-top: 110px; z-index: 5000;" class="modal show" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">PAYROLL NOTICE - <?php echo $paymonth." ".$payyear." (".$cutoff." Cut-Off)"; ?></h4>
          </div>
          <div style="max-height: calc(50vh - 100px); overflow-y: auto;" class="modal-body">
            <p>
            <?php
                if(count($successful)>0)
                {
                    echo "SUCCESS: <strong>".count($successful)." Payroll record/s have been SAVED</strong>:".implode($successful)."<br /><br />";
                }
                if(count($unsuccessful)>0)
                {
                    echo "ERROR: <strong>".count($unsuccessful)." FAILED ATTEMPT</strong> Payroll record/s are <strong>NOT</strong> saved:".implode($unsuccessful)."<br /><br />";
                }
                if(count($negative)>0)
                {
                    echo "FAILED: <strong>".count($negative)." NEGATIVE NET PAY</strong> Payroll record/s are <strong>NOT</strong> saved:".implode($negative)."<br /><br />";
                }
                if(count($duplicate)>0)
                {
                    echo "FAILED: <strong>".count($duplicate)." DUPLICATE</strong> Payroll record/s are <strong>NOT</strong> saved:".implode($duplicate)."<br /><br />";
                }
            ?>
            </p>
          </div>
          <div class="modal-footer">
            <a href="reports-payroll.php" class="btn btn-info" style="width: 150px;">SHOW REPORTS</a>
            <a href="transactions-payroll.php" class="btn btn-default">Close</a>
          </div>
        </div>
      </div>
    </div>
    <?php
}
if(isset($_POST['btnUpdate']))
{
    $id=$_POST['id'];
    $content=mysql_query("SELECT * FROM payroll WHERE id='".$id."'");
    $total=mysql_affected_rows();
    for($x=0; $x<=$total-1; $x++)
    {
        $rows=mysql_fetch_array($content);
        $category=validate($_POST['category']);
        $sssbracket=validate($_POST['sssbracket']);
        $payyear=validate($_POST['payyear']);
        $paymonth=validate($_POST['paymonth']);
        $startdate=validate($_POST['startdate']);
        $enddate=validate($_POST['enddate']);
        $cutoff=validate($_POST['cutoff']);
        $creditlast=validate($_POST['creditlast']);
        
        mysql_query("SELECT * FROM payroll WHERE startdate>'$startdate'");
        if(mysql_affected_rows()<=0)
        { $payslip='latest'; }
        
        $employeenumber=$rows['employeenumber'];
        $fullname=$rows['fullname'];
        $rate=number_format(validate($_POST['rate']),2);
        $rateperhour=number_format((str_replace(',','',$rate)/8),6);
        $oldrate=number_format(validate($_POST['oldrate']),2);
        $oldrateperhour=number_format((str_replace(',','',$oldrate)/8),6);
        
        if($cutoff=='1st' && $creditlast=='yes')
        {
            $year=substr($startdate,0,4);
            $month=substr($startdate,5,2);
            $day=substr($startdate,8,2);
            if($day>=16 && $day<=31)
            {
                $temp=true;
            }
            else
            {
                if($month=='01')
                {
                    $year=$year-1;
                    $month=12;
                }
                else
                {
                    if($month!=10 && $month!=11 && $month!=12)
                    {
                        $month=substr($month,1,1);
                        $month='0'.($month-1);
                    }
                    else if($month==11 || $month==12)
                    {
                        $month=$month-1;
                    }
                    else if($month==10)
                    {
                       $month='09';
                    }
                }
            }
            $lastcutoff=$year.'-'.$month;
            $content1=mysql_query("SELECT * FROM payroll WHERE fullname='".$fullname."' AND startdate LIKE '".$lastcutoff."%' AND cutoff='2nd'");
            $total1=mysql_affected_rows();
            for($y=0; $y<=$total1-1; $y++)
            {
                $rows1=mysql_fetch_array($content1);
                $paid=str_replace(',','',$rows1['week3']);
            }
        }
        else
        {
            $year=substr($startdate,0,4);
            $month=substr($startdate,5,2);
            $day=substr($startdate,8,2);
            $lastcutoff=$year.'-'.$month;
            $content1=mysql_query("SELECT * FROM payroll WHERE fullname='".$fullname."' AND enddate LIKE '".$lastcutoff."%' AND cutoff='1st'");
            $total1=mysql_affected_rows();
            for($y=0; $y<=$total1-1; $y++)
            {
                $rows1=mysql_fetch_array($content1);
                if($creditlast=='yes')
                { $paid=str_replace(',','',$rows1['week3']); }
                $basicpay2=$rows1['basicpay1'];
                $grosspay2=$rows1['grosspay1'];
                $sss2=str_replace(',','',$rows1['sss']);
            }
        }
        
        $oldhrs=str_replace(',','',validate($_POST['oldhrs']));
        $week1=$paid+str_replace(',','',validate($_POST['week1']));
        $regular1=$week1-$paid;
        $overtime1=str_replace(',','',validate($_POST['overtime1']));
        $oldOT1=str_replace(',','',validate($_POST['oldOT1']));
        
        $week2=str_replace(',','',validate($_POST['week2']));
        $regular2=$week2;
        $overtime2=str_replace(',','',validate($_POST['overtime2']));
        
        $week3=str_replace(',','',validate($_POST['week3']));
        $regular3=$week3;
        $overtime3=str_replace(',','',validate($_POST['overtime3']));
        
        $totalregular=number_format(($regular1+$regular2+$regular3),2);
        $totalregular1=number_format(($regular1+$regular2+$regular3+$oldhrs),2);
        $basicpay1=number_format((str_replace(',','',$totalregular)*str_replace(',','',$rateperhour)) + (str_replace(',','',$oldhrs)*str_replace(',','',$oldrateperhour)) ,2);
        $totalregular=$totalregular1;
        
        $regularovertime=number_format(($overtime1+$overtime2+$overtime3),2);
        $regularovertime1=number_format(($overtime1+$overtime2+$overtime3+$oldOT1),2);
        $regularotpay=number_format(((str_replace(',','',$regularovertime)*str_replace(',','',$rateperhour))*1.25) + ((str_replace(',','',$oldOT1)*str_replace(',','',$oldrateperhour))*1.25),2);
        $regularovertime=$regularovertime1;
        
        $specialovertime1=validate($_POST['specialovertime1']);
        $specialovertime2=validate($_POST['specialovertime2']);
        $specialovertime3=validate($_POST['specialovertime3']);
        $totalspecialot=$specialovertime1+$specialovertime2+$specialovertime3;
        $specialotpay=number_format((($totalspecialot*str_replace(',','',$rateperhour))*1.3),2);
        
        $oldND1=validate($_POST['oldND1'][$x]);
        $nightdifferential1=validate($_POST['nightdifferential1']);
        $nightdifferential2=validate($_POST['nightdifferential2']);
        $nightdifferential3=validate($_POST['nightdifferential3']);
        $totalnightdiff=$nightdifferential1+$nightdifferential2+$nightdifferential3;
        $totalnightdiff1=$nightdifferential1+$nightdifferential2+$nightdifferential3+$oldND1;
        $nighttimepay=number_format((($totalnightdiff*str_replace(',','',$rateperhour))*1.1) + (($oldND1*str_replace(',','',$oldrateperhour))*1.1),2);
        $totalnightdiff=$totalnightdiff1;
        
        $week1=$regular1+$overtime1+$nightdifferential1+$oldhrs+$oldOT1+$oldND1;
        $week2=$regular2+$overtime2+$nightdifferential2;
        $week3=$regular3+$overtime3+$nightdifferential3;
        $overalltotal=$week1+$week2+$week3;
        
        $paid=number_format($paid,2);
        $oldhrs=number_format($oldhrs,2);
        $week1=number_format($week1,2);
        $week2=number_format($week2,2);
        $week3=number_format($week3,2);
        $overalltotal=number_format($overalltotal,2);
        $regular1=number_format($regular1+$oldhrs,2);
        $regular2=number_format($regular2,2);
        $regular3=number_format($regular3,2);
        $oldOT1=number_format($oldOT1,2);
        $overtime1=number_format($overtime1+$oldOT1,2);
        $overtime2=number_format($overtime2,2);
        $overtime3=number_format($overtime3,2);
        $specialovertime1=number_format($specialovertime1,2);
        $specialovertime2=number_format($specialovertime2,2);
        $specialovertime3=number_format($specialovertime3,2);
        $totalspecialot=number_format($totalspecialot,2);
        $oldND1=number_format($oldND1,2);
        $nightdifferential1=number_format($nightdifferential1+$oldND1,2);
        $nightdifferential2=number_format($nightdifferential2,2);
        $nightdifferential3=number_format($nightdifferential3,2);
        $totalnightdiff=number_format($totalnightdiff,2);
        
        if($overtime1==NULL)
        { $overtime1='0.00'; }
        if($overtime2==NULL)
        { $overtime2='0.00'; }
        if($overtime3==NULL)
        { $overtime3='0.00'; }
        
        $holiday=validate($_POST['holiday']);
        $holidaypay=number_format(($holiday*str_replace(',','',$rate)),2);
        
        $vacation=validate($_POST['vacation']);
        $content2=mysql_query("SELECT * FROM payroll WHERE id='".$id."'");
        $total2=mysql_affected_rows();
        for($z=0; $z<=$total2-1; $z++)
        {
            $rows2=mysql_fetch_array($content2);
            $existingvacation=str_replace(',','',$rows2['vacation']);
            $updatedvacation=$vacation-$existingvacation;
        }
        $content3=mysql_query("SELECT * FROM employees WHERE employeenumber='".$employeenumber."'");
        $total3=mysql_affected_rows();
        for($i=0; $i<=$total3-1; $i++)
        {
            $rows3=mysql_fetch_array($content3);
            if($updatedvacation>=str_replace(',','',$rows3['totalvacation']) && $updatedvacation>0)
            {
                $xvacation=str_replace(',','',$rows3['totalvacation'])+$existingvacation;
                $totalvacation='0.00';
                $vacationpay=number_format(($xvacation*str_replace(',','',$rate)),2);
                alert('NOTICE: '.$fullname.' has no remaining vacation/s left.\n'.number_format($xvacation,2).' out of '.number_format($vacation,2).' vacation/s were credited.');
                $vacation=$xvacation;
            }
            else
            {
                $totalvacation=number_format((str_replace(',','',$rows3['totalvacation'])-$updatedvacation),2);
                $vacationpay=number_format(($vacation*str_replace(',','',$rate)),2);
            }
        }
        if($payyear=='2018' || ($payyear=='2019' && $paymonth=='JANUARY') || ($payyear=='2019' && $paymonth=='FEBRUARY') || ($payyear=='2019' && $paymonth=='MARCH') || ($payyear=='2019' && $paymonth=='APRIL'))
        { $totalvacation='N/A'; }
        
        $holiday=number_format($holiday,2);
        $vacation=number_format($vacation,2);
        $adjust=validate($_POST['adjustment']);
        $adjustment=number_format($adjust,2);
        
        $x1=str_replace(',','',$basicpay1);
        $x2=str_replace(',','',$regularotpay);
        $x3=str_replace(',','',$specialotpay);
        $x4=str_replace(',','',$nighttimepay);
        $x5=str_replace(',','',$holidaypay);
        $x6=str_replace(',','',$vacationpay);
        $grosspay1=$x1+$x2+$x3+$x4+$x5+$x6;
        if($adjust>0)
        { $grosspay1=$grosspay1+$adjust; }
        $grosspay1=number_format($grosspay1,2);
        
        $comment=ucfirst(validate($_POST['comment']));
        $sssloan=number_format(validate($_POST['sssloan']),2);
        $sssloan2=number_format(validate($_POST['sssloan2']),2);
        $hdmfloan=number_format(validate($_POST['hdmfloan']),2);
        $hdmfloan2=number_format(validate($_POST['hdmfloan2']),2);
        
        if($cutoff=='1st')
        {
            if($payyear>=2023)
            {
                $grosspay2='0.00';
                $totalgrosspay=$grosspay1;
                $tg=str_replace(',','',$totalgrosspay);
                do
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
                while($sss<180.00 || $sss>900.00);
                $sss=number_format($sss,2);
                $basicpay2='0.00';
                $totalbasicpay=$basicpay1;
                $phic='0.00';
                $hdmf=$payyear < 2024 ? '150.00' : '200.00';
            }
            else if($payyear>=2021)
            {
                $grosspay2='0.00';
                $totalgrosspay=$grosspay1;
                $tg=str_replace(',','',$totalgrosspay);
                do
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
                while($sss<135.00 || $sss>900.00);
                $sss=number_format($sss,2);
                $basicpay2='0.00';
                $totalbasicpay=$basicpay1;
                $phic='0.00';
                $hdmf=$payyear < 2024 ? '150.00' : '200.00';
            }
            else
            {
                if(strpos($sssbracket,'new')!==false)
                {
                    $grosspay2='0.00';
                    $totalgrosspay=$grosspay1;
                    $tg=str_replace(',','',$totalgrosspay);
                    do
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
                    while($sss<80.00 || $sss>800.00);
                    $sss=number_format($sss,2);
                    $basicpay2='0.00';
                    $totalbasicpay=$basicpay1;
                    $phic='0.00';
                    $hdmf=$payyear < 2024 ? '150.00' : '200.00';
                }
                else
                {
                    $grosspay2='0.00';
                    $totalgrosspay=$grosspay1;
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
                    $sss=number_format($sss,2);
                    $basicpay2='0.00';
                    $totalbasicpay=$basicpay1;
                    $phic='0.00';
                    $hdmf=$payyear < 2024 ? '150.00' : '200.00';
                }
            }
        }
        else
        {
            if($payyear>=2023)
            {
                $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                $tg=str_replace(',','',$totalgrosspay);
                do
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
                while($sss<180.00 || $sss>900.00);
                $sss=number_format(($sss-$sss2),2);
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
                else if($tb>=10000.01 && $tb<=39999.99)
                { $phic=number_format((($tb*$phic2)/2),2); }
                $hdmf='0.00';
                if($basicpay2==NULL)
                { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
            }
            else if($payyear>=2021)
            {
                $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                $tg=str_replace(',','',$totalgrosspay);
                do
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
                while($sss<135.00 || $sss>900.00);
                $sss=number_format(($sss-$sss2),2);
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
                else if($tb>=10000.01 && $tb<=39999.99)
                { $phic=number_format((($tb*$phic2)/2),2); }
                $hdmf='0.00';
                if($basicpay2==NULL)
                { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
            }
            else
            {
                if(strpos($sssbracket,'new')!==false)
                {
                    $totalgrosspay=number_format((str_replace(',','',$grosspay1))+(str_replace(',','',$grosspay2)),2);
                    $tg=str_replace(',','',$totalgrosspay);
                    do
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
                    while($sss<80.00 || $sss>800.00);
                    $sss=number_format(($sss-$sss2),2);
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
                    else if($tb>=10000.01 && $tb<=39999.99)
                    { $phic=number_format((($tb*$phic2)/2),2); }
                    $hdmf='0.00';
                    if($basicpay2==NULL)
                    { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
                }
                else
                {
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
                    $sss=number_format(($sss-$sss2),2);
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
                    else if($tb>=10000.01 && $tb<=39999.99)
                    { $phic=number_format((($tb*$phic2)/2),2); }
                    $hdmf='0.00';
                    if($basicpay2==NULL)
                    { $hdmf=$payyear < 2024 ? '150.00' : '200.00'; }
                }
            }
        }
                
        if($basicpay1=='0.00' && $grosspay1=='0.00')
        {
            $adjustment='0.00';
            $sssloan='0.00';
            $sssloan2='0.00';
            $hdmfloan='0.00';
            $hdmfloan2='0.00';
            $sss='0.00';
            $phic='0.00';
            $hdmf='0.00';
        }
        
        if($_POST['nodeductions']=='no' || ($payyear=='2020' && $paymonth=='APRIL') || ($payyear=='2020' && $paymonth=='MAY' && $category!='Direct Labor'))
        {
            $sssloan='0.00';
            $sssloan2='0.00';
            $hdmfloan='0.00';
            $hdmfloan2='0.00';
            $sss='0.00';
            $phic='0.00';
            $hdmf='0.00';
        }
        $sssbracket=$sssbracket.' '.$_POST['nodeductions'];
        
        $y1=str_replace(',','',$sssloan);
        $y2=str_replace(',','',$sssloan2);
        $y3=str_replace(',','',$hdmfloan);
        $y4=str_replace(',','',$hdmfloan2);
        $y5=str_replace(',','',$sss);
        $y6=str_replace(',','',$phic);
        $y7=str_replace(',','',$hdmf);
        $totaldeduction=$y1+$y2+$y3+$y4+$y5+$y6+$y7;
        if($adjust<0)
        { $totaldeduction=$totaldeduction-$adjust; }
        $totaldeduction=number_format($totaldeduction,2);
        
        $netpay=number_format((str_replace(',','',$grosspay1))-(str_replace(',','',$totaldeduction)),2);
        
        mysql_query("SELECT * FROM ".$table." WHERE employeenumber='".$employeenumber."' AND payyear='".$payyear."' AND paymonth='".$paymonth."' AND cutoff='".$cutoff."' AND id!='".$id."'");
        if(mysql_affected_rows()<=0)
        {
            mysql_query("UPDATE ".$table." SET payyear='".$payyear."',paymonth='".$paymonth."',startdate='".$startdate."',enddate='".$enddate."',cutoff='".$cutoff."',oldrate='".$oldrate."',oldrateperhour='".$oldrateperhour."',oldhrs='".$oldhrs."',oldOT1='".$oldOT1."',oldND1='".$oldND1."',overalltotal='".$overalltotal."',week1='".$week1."',paid='".$paid."',regular1='".$regular1."',overtime1='".$overtime1."',week2='".$week2."',regular2='".$regular2."',overtime2='".$overtime2."',week3='".$week3."',regular3='".$regular3."',overtime3='".$overtime3."',totalregular='".$totalregular."',basicpay1='".$basicpay1."',basicpay2='".$basicpay2."',totalbasicpay='".$totalbasicpay."',regularovertime='".$regularovertime."',regularotpay='".$regularotpay."',specialovertime1='".$specialovertime1."',specialovertime2='".$specialovertime2."',specialovertime3='".$specialovertime3."',totalspecialot='".$totalspecialot."',specialotpay='".$specialotpay."',nightdifferential1='".$nightdifferential1."',nightdifferential2='".$nightdifferential2."',nightdifferential3='".$nightdifferential3."',totalnightdiff='".$totalnightdiff."',nighttimepay='".$nighttimepay."',holiday='".$holiday."',holidaypay='".$holidaypay."',vacation='".$vacation."',vacationpay='".$vacationpay."',totalvacation='".$totalvacation."',grosspay1='".$grosspay1."',grosspay2='".$grosspay2."',totalgrosspay='".$totalgrosspay."',adjustment='".$adjustment."',comment='".$comment."',sssloan='".$sssloan."',sssloan2='".$sssloan2."',hdmfloan='".$hdmfloan."',hdmfloan2='".$hdmfloan2."',sss='".$sss."',phic='".$phic."',hdmf='".$hdmf."',totaldeduction='".$totaldeduction."',netpay='".$netpay."',sssbracket='".$sssbracket."' WHERE id='".$id."'");
            if(mysql_affected_rows()>0)
            {
                alert('SUCCESS: Payroll record has been updated.');
                
                if($totalvacation!='N/A' && $payslip=='latest')
                { mysql_query("UPDATE employees SET totalvacation='".$totalvacation."' WHERE employeenumber='".$employeenumber."'"); }

                if($_POST['chkUpdate']=='yes')
                {
                    $contentu=mysql_query("SELECT * FROM employees WHERE employeenumber='".$employeenumber."'");
                    $totalu=mysql_affected_rows();
                    for($u=0; $u<=$totalu-1; $u++)
                    {
                        $rowsu=mysql_fetch_array($contentu);
                        $rateu=$rowsu['rate'];
                        $sssloanu=$rowsu['sssloan'];
                        $sssloanu2=$rowsu['sssloan2'];
                        $hdmfloanu=$rowsu['hdmfloan'];
                        $hdmfloanu2=$rowsu['hdmfloan2'];
                    }
                    if($rate!=$rateu || $sssloan!=$sssloanu || $sssloan2!=$sssloanu2 || $hdmfloan!=$hdmfloanu || $hdmfloan2!=$hdmfloanu2)
                    {
                        mysql_query("UPDATE employees SET rate='".$rate."',sssloan='".$sssloan."',sssloan2='".$sssloan2."',hdmfloan='".$hdmfloan."',hdmfloan2='".$hdmfloan2."' WHERE employeenumber='".$employeenumber."'");
                        $check_queryu=mysql_affected_rows();
                        $mysql_affected_rowsu=$mysql_affected_rowsu+$check_queryu;
                    }
                    if($mysql_affected_rowsu>0)
                    { alert('SUCCESS: '.$mysql_affected_rowsu.' Employee record has been updated.'); }
                }
            }
            else
            { alert('ERROR: Unable to update Payroll record.'); }   
        }
        else
        {
            alert("ERROR: Duplicate record! There is already an existing record of ".$fullname." from the ".$cutoff." Cut-Off of ".$paymonth." ".$payyear.".");
            alert('ERROR: Unable to update Payroll record. Try checking the payslip date details...');
        }
    }
    navigate_page("reports-payroll.php");
}
if(isset($_POST['btnDelete']))
{
    $id=$_POST['id'];
    $employeenumber=$_POST['employeenumber'];
    $startdate=$_POST['startdate'];
    mysql_query("SELECT * FROM payroll WHERE startdate>'$startdate'");
    if(mysql_affected_rows()<=0)
    { $payslip='latest'; }
    
    $vacation=str_replace(',','',validate($_POST['vacation']));
    $content5=mysql_query("SELECT * FROM payroll WHERE id='".$id."'");
    $total5=mysql_affected_rows();
    for($k=0; $k<=$total5-1; $k++)
    {
        $rows5=mysql_fetch_array($content5);
        $totalvacation=$rows5['totalvacation'];
    }
    if($totalvacation!='N/A' && $payslip=='latest')
    {
        $content4=mysql_query("SELECT * FROM employees WHERE employeenumber='".$employeenumber."'");
        $total4=mysql_affected_rows();
        for($j=0; $j<=$total4-1; $j++)
        {
            $rows4=mysql_fetch_array($content4);
            $totalvacation=number_format((str_replace(',','',$rows4['totalvacation'])+$vacation),2);
        }
        mysql_query("UPDATE employees SET totalvacation='".$totalvacation."' WHERE employeenumber='".$employeenumber."'");
    }
    
    mysql_query("DELETE FROM ".$table." WHERE id='$id'");
    if(mysql_affected_rows()>0)
    { alert('SUCCESS: Record has been deleted.'); }
    else
    { alert('ERROR: Unable to delete record.'); }
    navigate_page("reports-payroll.php");
}
html_end();
?>