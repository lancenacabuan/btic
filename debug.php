<?php //********************BTIC Invoicing & Payroll System v15.22.0831.1140********************//
error_reporting(0);
session_start();
mysql_connect("localhost","root");
mysql_select_db("db_btic");
date_default_timezone_set('Asia/Manila');
$debug=$_GET['debug'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>BTIC - Debug<?php echo " (".date('m-d-Y').")";?></title>
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
<body bgcolor="lavender">
<?php
//******************************[DEBUG PAYROLL - Cut-Off Reset Patch]******************************//
if($debug=='cutoff')
{
    mysql_query("UPDATE payroll SET sssbracket='new' WHERE sss LIKE '%0.00'");
    $total=mysql_affected_rows();
    alert('UPDATED '.$total.' RECORDS IN PAYROLL INTO NEW!!!');
    
    mysql_query("UPDATE payroll SET sssbracket='old' WHERE sss NOT LIKE '%0.00'");
    $total=mysql_affected_rows();
    alert('UPDATED '.$total.' RECORDS IN PAYROLL INTO OLD!!!');
}
//******************************[DEBUG PAYROLL - Cut-Off Reset Patch]******************************//

//******************************[DEBUG INVOICE - S.I. Number Issue Bug Fix]******************************//
if($debug=='sinum')
{    
    mysql_query("DELETE t1 FROM receivables t1 JOIN collections t2 ON t1.sinum = t2.sinum;");
    $alert1=$alert1+mysql_affected_rows();
    $alert1=number_format($alert1);
    alert('DELETED '.$alert1.' RECORDS IN RECEIVABLES FROM SINGLE INVOICES!!!');
    
    $content=mysql_query("SELECT * FROM collections");
    $total=mysql_affected_rows();
    $pool=array();
    for($a=0; $a<$total; $a++)
    {
        $rows=mysql_fetch_array($content);
        $pool[]=$rows['sinum'];
    }

    $string=preg_replace('/[\s]+/mu', ' ',implode(", ",$pool));

    $content=mysql_query("SELECT * FROM receivables");
    $total=mysql_affected_rows();
    for($a=0; $a<$total; $a++)
    {
        $rows=mysql_fetch_array($content);
        $id=$rows['id'];
        $sinum=$rows['sinum'];
        if(strpos($string,$sinum)!==false)
        {
            mysql_query("DELETE FROM receivables WHERE id=$id");
            $alert2=$alert2+mysql_affected_rows();
        }
    }
    $alert2=number_format($alert2);
    alert('DELETED '.$alert2.' RECORDS IN RECEIVABLES FROM MULTIPLE INVOICES!!!');
}
//******************************[DEBUG INVOICE - S.I. Number Issue Bug Fix]******************************//
function validate($data)
{
    while($data!=NULL)
    {
        $remove=array("'",'"',";","=");
        $data=mysql_real_escape_string($data);
        $data=trim($data);
        $data=preg_replace('/\s+/',' ',$data);
        $data=str_replace($remove,'',$data);
        $data=htmlspecialchars($data);
        return $data;
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
?>
</body>
</html>