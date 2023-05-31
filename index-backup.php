<?php //********************BTIC Sales & Payroll System v15.23.0531.2052********************// ?>
<!DOCTYPE html>
<html>
<head>
    <title>BTIC - Backup/Restore<?php echo " (".date('m-d-Y').")";?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/chosen.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/styles.css">
    <script type="text/javascript" src="plugins/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="plugins/bootstrap.min.js"></script>
    <script type="text/javascript" src="plugins/chosen.jquery.js"></script>
    <script>
        $(document).ready(function(){$('#options').chosen({width: "320px"});});
    </script>
</head>
<style>
.wrapper {
    text-align: center;
    margin: auto;
}
</style>
<body>
<?php
error_reporting(0);
session_start();
mysql_connect("localhost","root");
mysql_select_db("db_btic");
date_default_timezone_set('Asia/Manila');

$database=$_GET['db'];
$table=$_GET['tbl'];
if($_GET['db']!=NULL && $_GET['db']!=NULL)
{    
    $_SESSION['db']=$_GET['db'];
    $_SESSION['tbl']=$_GET['tbl'];
}

if($_GET['db']=='backup')
{
    if($_GET['backup']=='complete')
    {
        $alert=array();
        $alert[]='INITIATED: COMPLETE [database] BACKUP!!!\n\n';

        $filename="C:/dbBackup/".date("ymd-His-")."users.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM users");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [users] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [users] SUCCESSFUL!\n'; }
        
        $filename="C:/dbBackup/".date("ymd-His-")."employees.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM employees");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [employees] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [employees] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."payroll.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM payroll");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [payroll] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [payroll] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."accounts.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM accounts");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [accounts] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [accounts] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."receivables.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM receivables");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [receivables] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [receivables] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."collections.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM collections");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [collections] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [collections] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."returns.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM returns");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [returns] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [returns] SUCCESSFUL!\n'; }

        ?>
        <script type="text/javascript">
            alert("<?php echo(implode($alert));?>");
            location="index.php";
        </script>
        <?php
        die();
    }
    else if($_GET['backup']=='payroll')
    {
        $alert=array();
        $alert[]='INITIATED: FULL [payroll] BACKUP!!!\n\n';

        $filename="C:/dbBackup/".date("ymd-His-")."employees.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM employees");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [employees] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [employees] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."payroll.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM payroll");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [payroll] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [payroll] SUCCESSFUL!\n'; }

        ?>
        <script type="text/javascript">
            alert("<?php echo(implode($alert));?>");
            location="index.php";
        </script>
        <?php
        die();
    }
    else if($_GET['backup']=='sales')
    {
        $alert=array();
        $alert[]='INITIATED: FULL [sales] BACKUP!!!\n\n';

        $filename="C:/dbBackup/".date("ymd-His-")."accounts.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM accounts");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [accounts] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [accounts] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."receivables.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM receivables");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [receivables] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [receivables] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."collections.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM collections");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [collections] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [collections] SUCCESSFUL!\n'; }

        $filename="C:/dbBackup/".date("ymd-His-")."returns.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM returns");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [returns] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [returns] SUCCESSFUL!\n'; }

        ?>
        <script type="text/javascript">
            alert("<?php echo(implode($alert));?>");
            location="index.php";
        </script>
        <?php
        die();
    }
    else
    {
        $filename="C:/dbBackup/".date("ymd-His-").$table.".sql";
        $success='SUCCESS: Database BACKUP ['.$table.'] SUCCESSFUL!';
        $failed='ERROR: Database BACKUP ['.$table.'] FAILED!';
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM $table");
        if(!$retval)
        { $alert=$failed; }
        else
        { $alert=$success; }
        ?>
        <script type="text/javascript">
            alert("<?php echo($alert);?>");
            location="<?=$_SERVER['HTTP_REFERER'];?>";
        </script>
        <?php
    }
}
else if($_GET['db']=='restore')
{
?>
    <br />
    <br />
    <br />
    <div class="wrapper">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Restore Database</button>
        <a href="<?=$_SESSION['HTTP_REFERER'];?>" class="btn btn-info btn-lg">Back to Page</a>
    </div>
    <?php
    if($_SESSION['tbl']!='complete')
    {
    ?>
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Restore Database</h4>
          </div>
          <div class="modal-body">
            <form class="form-inline" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
              <div class="form-group">
                <input type="hidden" name="db" value="<?=$database;?>"/>
                <input type="hidden" name="tbl" value="<?=$table;?>"/>
                <label for="filename">Filename:</label>
                <select class="chosen-select" id="options" name="filename" data-placeholder="Select a database to restore...">
                    <?php
                        $dirname="C:/dbBackup/";
                        $handle=@opendir($dirname);
                        $files=array();
                        if(!empty($handle))
                        {
                            while(false!==($file=readdir($handle)))
                            {
                                if($file!="." && $file!=".." && strpos($file,$table)==true && strpos($file,'restorepoint')==false)
                                {
                                    if(is_file($dirname.$file))
                                    { $files[] = $file; }
                                }
                            }
                        }
                        closedir($handle);
                        $files=array_reverse($files);
                        foreach ($files as $file)
                        {
                            $tbl=ucfirst(substr($file,14,-4));
                            $date='20'.substr($file,0,2).'-'.substr($file,2,2).'-'.substr($file,4,2);
                            $time=date("g:i:s A",strtotime((substr($file,7,2).':'.substr($file,9,2).':'.substr($file,11,2))));
                            $label=$tbl.' ('.$date.' '.$time.')';
                            ?>
                            <option value="<?=htmlspecialchars($label).' | '.$file;?>"><?=htmlspecialchars($label);?></option> 
                            <?php
                        }
                        ?>
                </select>
              </div><?=$string;?>
              <input type="submit" class="btn btn-primary" name="btnSubmit" value="SELECT" onclick='return confirm("CONFIRM: Perform a Database RESTORE: [<?=$table;?>]???\n\n"+document.getElementById("options").value)'/>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <?php
    }
    else
    {
    ?>
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Restore Database</h4>
          </div>
          <div class="modal-body">
            <form class="form-inline" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
              <div class="form-group">
                <input type="hidden" name="db" value="<?=$_SESSION['db'];?>"/>
                <input type="hidden" name="tbl" value="<?=$_SESSION['tbl'];?>"/>
                <label for="username">Database:</label>
                <select class="chosen-select" id="options" name="username">
                    <?php
                    if($_SESSION['usertype']=='btic_admin')
                    {
                    ?>
                        <option value="ADMIN">Complete ADMIN Database RESTORE</option>
                    <?php
                    }
                    if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_payroll')
                    {
                    ?>
                        <option value="PAYROLL">Complete PAYROLL Database RESTORE</option>
                    <?php
                    }
                    if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_sales')
                    {
                    ?>
                        <option value="SALES">Complete SALES Database RESTORE</option>
                    <?php
                    }
                    ?>
                </select>
              </div><?=$string;?>
              <input type="submit" class="btn btn-primary" name="btnSubmit" value="SELECT" onclick='return confirm("CONFIRM: Perform a [Complete "+document.getElementById("options").value+" Database] RESTORE???")'/>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <?php
    }
    if($_SESSION['tbl']!='complete')
    {
        if(isset($_GET['btnSubmit']))
        {
            mysql_query("SELECT * FROM $table");
            $filename_backup="C:/dbBackup/".date("ymd-His-").$table."-restorepoint.sql";
            if(mysql_affected_rows()>0)
            {
                $retval=mysql_query("SELECT * INTO OUTFILE '$filename_backup' FROM $table");
                if(!$retval)
                {
                    ?>
                    <script type="text/javascript">
                        alert("<?php echo("ERROR: A problem has occurred while creating a Restore Point!!!");?>");
                        location="<?=$_SESSION['HTTP_REFERER'];?>";
                    </script>
                    <?php
                    die();
                }
            }
            $filename=str_replace('| ','',strstr($_GET['filename'],'|'));
            $filename="C:/dbBackup/".$filename;
            $success='SUCCESS: Database RESTORE ['.$table.'] SUCCESSFUL!!!\n\n'.$_GET['filename'];
            $failed='ERROR: Database RESTORE ['.$table.'] FAILED!!!\nNOTICE: An error has occurred during attempt!!! Please try again...';
            mysql_query("TRUNCATE TABLE $table");
            $retval=mysql_query("LOAD DATA INFILE '$filename' INTO TABLE $table");
            if(!$retval)
            {
                mysql_query("LOAD DATA INFILE '$filename_backup' INTO TABLE $table");
                $alert=$failed;
            }
            else
            { $alert=$success; }
            ?>
            <script type="text/javascript">
                alert("<?php echo($alert);?>");
                location="<?=$_SESSION['HTTP_REFERER'];?>";
            </script>    
            <?php
            $_SESSION['HTTP_REFERER']='index-backup.php';
        }
    }
    else
    {
        if(isset($_GET['btnSubmit']))
        {
            $alert=array();
            $alert[]='INITIATED: COMPLETE [database] RESTORE!!!\n\n';
            
            if($_GET['username']=='ADMIN')
            {
                $table='users';
                $dirname="C:/dbBackup/";
                $handle=@opendir($dirname);
                $files=array();
                if(!empty($handle))
                {
                    while(false!==($file=readdir($handle)))
                    {
                        if($file!="." && $file!=".." && strpos($file,$table)==true && strpos($file,'restorepoint')==false)
                        {
                            if(is_file($dirname.$file))
                            { $files[] = $file; }
                        }
                    }
                }
                closedir($handle);
                if(count($files) != 0){
                    $files=array_reverse($files);
                    $file=$files[0];
                    $filename="C:/dbBackup/".$file;
                    $success='SUCCESS: Database RESTORE ['.$table.'] SUCCESSFUL!!!\n';
                    $failed='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                    mysql_query("TRUNCATE TABLE $table");
                    $retval=mysql_query("LOAD DATA INFILE '$filename' INTO TABLE $table");
                    if(!$retval)
                    { $alert[]=$failed; }
                    else
                    { $alert[]=$success; }
                }
                else{
                    $alert[]='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                }
            }
            if($_GET['username']=='ADMIN' || $_GET['username']=='PAYROLL')
            {
                $table='employees';
                $dirname="C:/dbBackup/";
                $handle=@opendir($dirname);
                $files=array();
                if(!empty($handle))
                {
                    while(false!==($file=readdir($handle)))
                    {
                        if($file!="." && $file!=".." && strpos($file,$table)==true && strpos($file,'restorepoint')==false)
                        {
                            if(is_file($dirname.$file))
                            { $files[] = $file; }
                        }
                    }
                }
                closedir($handle);
                if(count($files) != 0){
                    $files=array_reverse($files);
                    $file=$files[0];
                    $filename="C:/dbBackup/".$file;
                    $success='SUCCESS: Database RESTORE ['.$table.'] SUCCESSFUL!!!\n';
                    $failed='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                    mysql_query("TRUNCATE TABLE $table");
                    $retval=mysql_query("LOAD DATA INFILE '$filename' INTO TABLE $table");
                    if(!$retval)
                    { $alert[]=$failed; }
                    else
                    { $alert[]=$success; }
                }
                else{
                    $alert[]='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                }
                
                $table='payroll';
                $dirname="C:/dbBackup/";
                $handle=@opendir($dirname);
                $files=array();
                if(!empty($handle))
                {
                    while(false!==($file=readdir($handle)))
                    {
                        if($file!="." && $file!=".." && strpos($file,$table)==true && strpos($file,'restorepoint')==false)
                        {
                            if(is_file($dirname.$file))
                            { $files[] = $file; }
                        }
                    }
                }
                closedir($handle);
                if(count($files) != 0){
                    $files=array_reverse($files);
                    $file=$files[0];
                    $filename="C:/dbBackup/".$file;
                    $success='SUCCESS: Database RESTORE ['.$table.'] SUCCESSFUL!!!\n';
                    $failed='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                    mysql_query("TRUNCATE TABLE $table");
                    $retval=mysql_query("LOAD DATA INFILE '$filename' INTO TABLE $table");
                    if(!$retval)
                    { $alert[]=$failed; }
                    else
                    { $alert[]=$success; }
                }
                else{
                    $alert[]='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                }
            }
            if($_GET['username']=='ADMIN' || $_GET['username']=='SALES')
            {
                $table='accounts';
                $dirname="C:/dbBackup/";
                $handle=@opendir($dirname);
                $files=array();
                if(!empty($handle))
                {
                    while(false!==($file=readdir($handle)))
                    {
                        if($file!="." && $file!=".." && strpos($file,$table)==true && strpos($file,'restorepoint')==false)
                        {
                            if(is_file($dirname.$file))
                            { $files[] = $file; }
                        }
                    }
                }
                closedir($handle);
                if(count($files) != 0){
                    $files=array_reverse($files);
                    $file=$files[0];
                    $filename="C:/dbBackup/".$file;
                    $success='SUCCESS: Database RESTORE ['.$table.'] SUCCESSFUL!!!\n';
                    $failed='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                    mysql_query("TRUNCATE TABLE $table");
                    $retval=mysql_query("LOAD DATA INFILE '$filename' INTO TABLE $table");
                    if(!$retval)
                    { $alert[]=$failed; }
                    else
                    { $alert[]=$success; }
                }
                else{
                    $alert[]='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                }
                
                $table='receivables';
                $dirname="C:/dbBackup/";
                $handle=@opendir($dirname);
                $files=array();
                if(!empty($handle))
                {
                    while(false!==($file=readdir($handle)))
                    {
                        if($file!="." && $file!=".." && strpos($file,$table)==true && strpos($file,'restorepoint')==false)
                        {
                            if(is_file($dirname.$file))
                            { $files[] = $file; }
                        }
                    }
                }
                closedir($handle);
                if(count($files) != 0){
                    $files=array_reverse($files);
                    $file=$files[0];
                    $filename="C:/dbBackup/".$file;
                    $success='SUCCESS: Database RESTORE ['.$table.'] SUCCESSFUL!!!\n';
                    $failed='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                    mysql_query("TRUNCATE TABLE $table");
                    $retval=mysql_query("LOAD DATA INFILE '$filename' INTO TABLE $table");
                    if(!$retval)
                    { $alert[]=$failed; }
                    else
                    { $alert[]=$success; }
                }
                else{
                    $alert[]='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                }
                
                $table='collections';
                $dirname="C:/dbBackup/";
                $handle=@opendir($dirname);
                $files=array();
                
                if(!empty($handle))
                {
                    while(false!==($file=readdir($handle)))
                    {
                        if($file!="." && $file!=".." && strpos($file,$table)==true && strpos($file,'restorepoint')==false)
                        {
                            if(is_file($dirname.$file))
                            { $files[] = $file; }
                        }
                    }
                }
                closedir($handle);
                if(count($files) != 0){
                    $files=array_reverse($files);
                    $file=$files[0];
                    $filename="C:/dbBackup/".$file;
                    $success='SUCCESS: Database RESTORE ['.$table.'] SUCCESSFUL!!!\n';
                    $failed='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                    mysql_query("TRUNCATE TABLE $table");
                    $retval=mysql_query("LOAD DATA INFILE '$filename' INTO TABLE $table");
                    if(!$retval)
                    { $alert[]=$failed; }
                    else
                    { $alert[]=$success; }
                }
                else{
                    $alert[]='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                }
                
                $table='returns';
                $dirname="C:/dbBackup/";
                $handle=@opendir($dirname);
                $files=array();
                if(!empty($handle))
                {
                    while(false!==($file=readdir($handle)))
                    {
                        if($file!="." && $file!=".." && strpos($file,$table)==true && strpos($file,'restorepoint')==false)
                        {
                            if(is_file($dirname.$file))
                            { $files[] = $file; }
                        }
                    }
                }
                closedir($handle);
                if(count($files) != 0){
                    $files=array_reverse($files);
                    $file=$files[0];
                    $filename="C:/dbBackup/".$file;
                    $success='SUCCESS: Database RESTORE ['.$table.'] SUCCESSFUL!!!\n';
                    $failed='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                    mysql_query("TRUNCATE TABLE $table");
                    $retval=mysql_query("LOAD DATA INFILE '$filename' INTO TABLE $table");
                    if(!$retval)
                    { $alert[]=$failed; }
                    else
                    { $alert[]=$success; }
                }
                else{
                    $alert[]='ERROR: Database RESTORE ['.$table.'] FAILED!!!\n';
                }
            }
            alert(implode($alert));
            navigate_page('index.php');
        }
    }
}
function alert($info)
{
?>
    <script type="text/javascript">
        alert("<?php echo($info);?>");
    </script>
<?php
}

function navigate_page($location)
{
?>
    <script type="text/javascript">location="<?=$location;?>";</script>
<?php
}
?>
</body>
</html>