<?php //********************BTIC Sales & Payroll System v15.24.0709.1718********************//
error_reporting(0);
session_start();
mysql_connect("localhost","root");
mysql_select_db("db_btic");
date_default_timezone_set('Asia/Manila');

function html_start($title,$tab)
{
?>
    <!DOCTYPE html>
    <html lang="en" style="height: auto;">
    <head>
    <title>BTIC<?php echo $title." (".date('m-d-Y').")";?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="plugins/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/chosen.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/styles.css">
    <script type="text/javascript" src="plugins/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="plugins/datatables.min.js"></script>
    <script type="text/javascript" src="plugins/dataTables.fixedColumns.min.js"></script>
    <script type="text/javascript" src="plugins/bootstrap.min.js"></script>
    <script type="text/javascript" src="plugins/chosen.jquery.js"></script>
    <script>
        $(document).ready(function(){
            $('#users').DataTable({
                "dom":'lfrtip',
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "columnDefs":[{"targets":[2],"visible":false,"searchable":false}]
            });
        });
        $(document).ready(function(){
            $('#accounts').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',exportOptions:{columns:[1,3,4]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "columnDefs":[{"targets":[2],"visible":false,"searchable":false}]
            });
        });
        $(document).ready(function(){
            $('#employees').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',exportOptions:{columns:[1,3,4,5,6,7,8,9,10,11,12]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "columnDefs":[{"targets":[2],"visible":false,"searchable":false}]
            });
        });
        $(document).ready(function(){
            $('#employees_form').DataTable({
                "dom":'t',
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":-1,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]]
            });
        });
        $(document).ready(function(){
            $('#payroll_form').DataTable({
                "dom":'ft',
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":-1,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "fixedColumns":{leftColumns:2}
            });
        });
        $(document).ready(function(){
            $('#payroll').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "fixedColumns":{leftColumns:6},
                "columnDefs":[{render:function(data,type,full,meta){
                    return "<div class='text-wrap width-500'>"+data+"</div>";},targets:[42]}]
            });
        });
        $(document).ready(function(){
            $('#payroll_report').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                }
            });
        });
        $(document).ready(function(){
            $('#optimize_payroll_report').DataTable({
                "ajax":"data/reports-payroll.json",
                "columns":[
                    {"data":"startdate"},
                    {"data":"enddate"},
                    {"data":"cutoff"},
                    {"data":"employeetype"},
                    {"data":"employeenumber"},
                    {"data":"fullname"},
                    {"data":"totalregular"},
                    {"data":"basicpay1"},
                    {"data":"regularovertime"},
                    {"data":"regularotpay"},
                    {"data":"totalspecialot"},
                    {"data":"specialotpay"},
                    {"data":"totalnightdiff"},
                    {"data":"nighttimepay"},
                    {"data":"holiday"},
                    {"data":"holidaypay"},
                    {"data":"vacation"},
                    {"data":"vacationpay"},
                    {"data":"grosspay1"},
                    {"data":"adjustment"},
                    {"data":"sssloan"},
                    {"data":"sssloan2"},
                    {"data":"hdmfloan"},
                    {"data":"hdmfloan2"},
                    {"data":"sss"},
                    {"data":"phic"},
                    {"data":"hdmf"},
                    {"data":"totaldeduction"},
                    {"data":"netpay"}
                ],
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                }
            });
        });
        $(document).ready(function(){
            $('#payroll_report2').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[0,1,2,3,4,5,6,7,8,9,10,11,12,13]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "fixedColumns":{leftColumns:1},
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                }
            });
        });
        $(document).ready(function(){
            $('#tblReceivables').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[2,3,4,5,6]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                },
                "columnDefs":[{render:function(data,type,full,meta){
                    return "<div class='text-wrap width-500'>"+data+"</div>";},targets:[3,4,7]}]
            });
        });
        $(document).ready(function(){
            $('#tblCollections').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[2,3,4,5,6,7,8,9,10,11,12,13,14,15]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                },
                "columnDefs":[{render:function(data,type,full,meta){
                    return "<div class='text-wrap width-500'>"+data+"</div>";},targets:[3,4,16]}]
            });
        });
        $(document).ready(function(){
            $('#optimize_receivables').DataTable({
                "ajax":"data/transaction-receivables.json",
                "columns":[
                    {"data":"date1"},
                    {"data":"customer"},
                    {"data":"sinum"},
                    {"data":"invoiceamt"},
                    {"data":"ponum"},
                    {"data":"comment"}
                ],
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[0,1,2,3,4]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                },
                "columnDefs":[{render:function(data,type,full,meta){
                    return "<div class='text-wrap width-500'>"+data+"</div>";},targets:[1,2,5]}]
            });
        });
        $(document).ready(function(){
            $('#optimize_collections').DataTable({
                "ajax":"data/transaction-collections.json",
                "columns":[
                    {"data":"date1"},
                    {"data":"customer"},
                    {"data":"sinum"},
                    {"data":"invoiceamt"},
                    {"data":"ponum"},
                    {"data":"ewt"},
                    {"data":"returns"},
                    {"data":"miscellaneous"},
                    {"data":"totalbill"},
                    {"data":"date2"},
                    {"data":"checknum"},
                    {"data":"checkamt"},
                    {"data":"ornum"},
                    {"data":"balance"},
                    {"data":"comment"}
                ],
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[0,1,2,3,4,5,6,7,8,9,10,11,12,13]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                },
                "columnDefs":[{render:function(data,type,full,meta){
                    return "<div class='text-wrap width-500'>"+data+"</div>";},targets:[1,2,14]}]
            });
        });
        $(document).ready(function(){
            $('#optimize_summary').DataTable({
                "ajax":"data/transaction-summary.json",
                "columns":[
                    {"data":"date1"},
                    {"data":"customer"},
                    {"data":"sinum"},
                    {"data":"invoiceamt"},
                    {"data":"ponum"},
                    {"data":"ewt"},
                    {"data":"returns"},
                    {"data":"miscellaneous"},
                    {"data":"totalbill"},
                    {"data":"date2"},
                    {"data":"checknum"},
                    {"data":"checkamt"},
                    {"data":"ornum"},
                    {"data":"balance"},
                    {"data":"comment"}
                ],
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[0,1,2,3,4,5,6,7,8,9,10,11,12,13]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                },
                "columnDefs":[{render:function(data,type,full,meta){
                    return "<div class='text-wrap width-500'>"+data+"</div>";},targets:[1,2,14]}]
            });
        });
        $(document).ready(function(){
            $('#total_returns').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[2,3,4,5,6,7]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                }
            });
        });
        $(document).ready(function(){
            $('#optimize_returns').DataTable({
                "ajax":"data/transaction-returns.json",
                "columns":[
                    {"data":"date"},
                    {"data":"customer"},
                    {"data":"rtvnum"},
                    {"data":"accrec"},
                    {"data":"outputvat"},
                    {"data":"sales"}
                ],
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[0,1,2,3,4,5]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "footerCallback":function(row,data,start,end,display){
                    var api=this.api(),data;
                    var intVal=function(i){
                        return typeof i==='string'?
                            i.replace(/[\$,]/g,'')*1:
                            typeof i==='number'?
                                i:0;
                    };
                    api.columns('.sum',{page:'all'}).every(function(){
                      var sum=this
                        .data()
                        .reduce(function(a,b){
                            return intVal(a)+intVal(b);
                        },0);
                        sum=Number(sum).toFixed(2);
                        sum=sum.toString();
                        var pattern=/(-?\d+)(\d{3})/;
                        while(pattern.test(sum))
                        sum=sum.replace(pattern,"$1,$2");
                      this.footer().innerHTML=sum;
                    });
                }
            });
        });
        $(document).ready(function(){
            $('#report').DataTable({
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[2,3,4,5,6]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "columnDefs":[{render:function(data,type,full,meta){
                    return "<div class='text-wrap width-500'>"+data+"</div>";},targets:[3,4,6]}]
            });
        });
        $(document).ready(function(){
            $('#optimize_report').DataTable({
                "ajax":"data/reports-receivables.json",
                "columns":[
                    {"data":"date1"},
                    {"data":"customer"},
                    {"data":"sinum"},
                    {"data":"invoiceamt"},
                    {"data":"comment"}
                ],
                "dom":'Blfrtip',
                "buttons":[{extend:'excel',footer:true,exportOptions:{columns:[0,1,2,3,4]}}],
                "scrollX":true,
                "scrollY":"360px",
                "autoWidth":false,
                "iDisplayLength":50,
                "aLengthMenu":[[10,25,50,100,500,1000,-1], [10,25,50,100,500,1000,"All"]],
                "columnDefs":[{render:function(data,type,full,meta){
                    return "<div class='text-wrap width-500'>"+data+"</div>";},targets:[1,2,4]}]
            });
        });
        $(document).ready(function(){$('.chosen-select').chosen({max_selected_options:100});});
        $(document).ready(function(){$('#backtotop').click(function(){$('html, body').animate({scrollTop:0},1000);return false;});});
        $(document).ready(function(){$('#toggle-head').click(function(){$('#toggle-body, #toggle-subform').slideToggle('slow');});});
        $(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});
        $(document).ready(function(){$('#show_more').click(function(){$('#btnReset').show();$('#show_more').hide();});});
    </script>
    </head>
    
    <body>
    <nav style="z-index: 2000" class="navbar navbar-default fixed-top">
    <div class="container-fluid">
        <header>
            <a style="color: #8B008B; text-decoration: none;" href="index.php" data-toggle="tooltip" data-placement="bottom" title="Home Page">
                Better Than Ice Cream, Inc.
            </a>
            <span id="backtotop" style="background-color: #86609d;" class="badge" data-toggle="tooltip" data-placement="bottom" title="Go back to top of page.">
                v15.24.0709.1718
            </span>
        </header>
    </div>
    <?php
    if(count($tab)>0)
    {
    ?>
        <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <strong>MAINTENANCE</strong>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                <?php
                if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_payroll')
                {
                ?>
                    <li><a href="maintenance-employees.php">Employees</a></li>
                <?php
                }
                if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_sales')
                {
                ?>
                    <li><a href="maintenance-accounts.php">Accounts</a></li>
                <?php
                }
                ?>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <strong>TRANSACTIONS</strong>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                <?php
                if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_payroll')
                {
                ?>
                    <li><a href="transactions-payroll.php">Payroll</a></li>
                <?php
                }
                if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_sales')
                {
                ?>
                    <li><a href="transactions-receivables.php">Receivables</a></li>
                    <li><a href="transactions-collections.php">Collections</a></li>
                    <li><a href="transactions-returns.php">Returns</a></li>
                <?php
                }
                ?>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <strong>REPORTS</strong>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                <?php
                if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_payroll')
                {
                ?>
                    <li><a href="reports-payroll.php">Payroll</a></li>
                <?php
                }
                if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_sales')
                {
                ?>
                    <li><a href="reports-summary.php">Summary</a></li>
                <?php
                }
                ?>
                </ul>
            </li>
            <?php
            if($_SESSION['usertype']=='btic_admin')
            {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <strong>UTILITIES</strong>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="utilities-users.php">Users</a></li>
                </ul>
            </li>
            <?php
            }
            ?>
        </ul>
        <?php
        if($_SESSION['usertype'] == 'btic_admin')
        {
            $db_color='label-danger';
            $db_badge='ADMIN';
        }
        else if($_SESSION['usertype'] == 'btic_payroll')
        {
            $db_color='label-primary';
            $db_badge='PAYROLL';
        }
        else if($_SESSION['usertype'] == 'btic_sales')
        {
            $db_color='label-success';
            $db_badge='SALES';
        }
        else
        {
            $db_color=NULL;
            $db_badge=NULL;
        }
        ?>
        <ul class="nav navbar-nav navbar-right">
            <?php
            if($_SESSION['formtype']!=NULL)
            {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <strong><?=ucwords($_SESSION['formtype']);?></strong>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index-backup.php?db=backup&amp;tbl=<?=$_SESSION['formtype'];?>" onclick="return confirm('CONFIRM: Perform a Database BACKUP: [<?=$_SESSION['formtype'];?>]???')">Backup Database</a></li>
                    <li><a href="index-backup.php?db=restore&amp;tbl=<?=$_SESSION['formtype'];?>">Restore Database</a></li>
                </ul>
            </li>
            <?php
            }
            else
            {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <strong>Database</strong>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php
                    if($_SESSION['usertype']=='btic_admin')
                    {
                    ?>
                    <li><a href="index-backup.php?db=backup&amp;backup=complete" onclick="return confirm('CONFIRM: Do you really want to perform a [Complete DATABASE Backup]???')"><strong>Complete Database Backup</strong></a></li>
                    <?php
                    }
                    if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_payroll')
                    {
                    ?>
                    <li><a href="index-backup.php?db=backup&amp;backup=payroll" onclick="return confirm('CONFIRM: Do you really want to perform a [Full PAYROLL Backup]???')"><strong>Full Payroll Backup</strong><br />(Employees &amp; Payroll)</a></li>
                    <?php
                    }
                    if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_sales')
                    {
                    ?>
                    <li><a href="index-backup.php?db=backup&amp;backup=sales" onclick="return confirm('CONFIRM: Do you really want to perform a [Full SALES Backup]???')"><strong>Full Sales Backup</strong><br />(Accounts, Receivables, <br />Collections, &amp; Returns)</a></li>
                    <?php
                    }
                    ?>
                    <li><a href="index-backup.php?db=restore&amp;tbl=complete"><strong>Restore Latest Database</strong></a></li>
                </ul>
            </li>
            <?php
            }
            ?>
            <li>
                <a><span style="font-size: 12px;" class="label <?=$db_color;?>"><?=$db_badge;?></span></a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <strong><?php echo($_SESSION['fullname']);?></strong>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index-logout.php">Log Out</a></li>
                </ul>
            </li>
        </ul> 
        </div>
        <ul class="panel panel-primary nav nav-pills">
        <?php foreach($tab as $url=>$name)
        {
        ?>
            <li><a href="<?php echo($url);?>"><?php echo($name);?></a></li>
        <?php
        }
        ?>
        </ul>
    <?php
    }
    ?>
    </nav>
    <div class="container main">
    <br />
    <br />
<?php
}

function html_end()
{
?>
    </div>
    </body>
    </html>
<?php
}

function form_login_start($action)
{
?>
    <div class="panel panel-primary" id="panel" align="center" style="padding-top: 50px; padding-bottom: 50px;">
    <form id="form" method="post" role="form" <?php echo($action);?>>
<?php
}

function form_login_end($index)
{
?>
    <table border="0">
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <input class="form-control btn btn-primary" name="<?php echo($index[0]);?>" type="submit" value="<?php echo($index[1]);?>">
        </td></tr>
        <tr><td><a href="<?php echo($index[2]);?>?forgot=password" class="btn btn-link"><?php echo($index[3]);?></a></td></tr>
    </table>
    </form>
    </div>
<?php
}

function welcome($fullname)
{
    $employees=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS total FROM employees"));
    $employees=$employees['total'];
    $accounts=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS total FROM accounts"));
    $accounts=$accounts['total'];
    $payroll=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS total FROM payroll"));
    $payroll=$payroll['total'];
    $receivables=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS total FROM receivables"));
    $receivables=$receivables['total'];
    $collections=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS total FROM collections"));
    $collections=$collections['total'];
    $returns=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS total FROM returns"));
    $returns=$returns['total'];
    ?>
    <div class="panel panel-primary">
    <h1>Welcome, <?php echo($fullname);?>!<br /><br /><br /></h1>
    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>MAINTENANCE</th>
                <th>TRANSACTIONS</th>
                <th>REPORTS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_payroll')
            {
            ?>
            <tr>
                <td><a href="maintenance-employees.php" class="btn btn-link" role="button">Employees
                    <span class="badge"><?=$employees;?></span></a></td>
                <td><a href="transactions-payroll.php" class="btn btn-link" role="button">Payroll
                    <span class="badge"><?=$payroll;?></span></a></td>
                <td><a href="reports-payroll.php" class="btn btn-link" role="button">Payroll
                    <span class="badge"><?=$payroll;?></span></a></td>
            </tr>
            <?php
            }
            if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_sales')
            {
            ?>
            <tr>
                <td><a href="maintenance-accounts.php" class="btn btn-link" role="button">Accounts
                    <span class="badge"><?=$accounts;?></span></a></td>
                <td><a href="transactions-receivables.php" class="btn btn-link" role="button">Receivables
                    <span class="badge"><?=$receivables;?></span></a></td>
                <td><a href="reports-summary.php" class="btn btn-link" role="button">Summary
                    <span class="badge"><?=$receivables+$collections;?></span></a></td>
            </tr>
            <tr>
                <td></td>
                <td><a href="transactions-collections.php" class="btn btn-link" role="button">Collections
                    <span class="badge"><?=$collections;?></span></a></td>
                <?php
                if($_SESSION['usertype']=='btic_admin')
                {
                ?>
                <td>&nbsp;</td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td></td>
                <td><a href="transactions-returns.php" class="btn btn-link" role="button">Returns
                    <span class="badge"><?=$returns;?></span></a></td>
                <?php
                if($_SESSION['usertype']=='btic_admin')
                {
                ?>
                <td>&nbsp;</td>
                <?php
                }
                ?>
            </tr>
            <?php
            }
            ?>
        </tbody>
        </table>
    </div>
    </div>
<?php
}

function form_start($form,$new)
{
?>
    <a href="<?php echo($new);?>">
    <button id="new" type="button" data-toggle="tooltip" data-placement="right" title="Create new record.">+</button>
    </a>
    <div class="panel-heading" id="toggle-head" data-toggle="tooltip" title="Click to hide/show form."><?php echo($form);?></div>
    <div class="panel panel-body" id="toggle-body" align="center">
    <form id="form" method="post" role="form">
<?php
}

function form_end()
{
?>
    </form>
	</div>
<?php
}

function btn_visibility($new)
{
    if($_SESSION['visibility']=='hidden')
    {
        $title='Click to show ONLY Current Record/s.';
        if(strpos($_SERVER['REQUEST_URI'],'maintenance-employees.php'))
        { $visibility='Hidden Only'; }
        else
        { $visibility='Current & Hidden'; }
        
    }
    else
    {
        $visibility='Current Only';
        if(strpos($_SERVER['REQUEST_URI'],'maintenance-employees.php'))
        { $title='Click to show ONLY Hidden Record/s.'; }
        else
        { $title='Click to show ALL Current and Hidden Record/s.'; }
    }
    ?>
    <form method="post" role="form" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <button class="btn btn-default" type="submit" name="btnVisibility" style="position: fixed; top: 105px; right: 30px; z-index: 1500; box-shadow: 5px 5px 5px grey; width: 200px;" data-toggle="tooltip" data-placement="bottom" title="<?=$title;?>">VISIBILITY <span class="label label-default"><?=$visibility;?></span></button>
    </form>
<?php
}

function input_hidden($name,$value)
{
?>
    <input id="<?php echo($name);?>" name="<?php echo($name);?>" type="hidden" value="<?php echo($value);?>" />
<?php
}

function input_text($label,$name,$maxlength,$placeholder,$attribute,$value)
{
?>
    <div class="form-group">
    <label for="<?php echo($name);?>"><?php echo($label);?></label>
    <input class="form-control" id="<?php echo($name);?>" name="<?php echo($name);?>" type="text" value="<?php echo($value);?>" maxlength="<?php echo($maxlength);?>" placeholder="<?php echo($placeholder);?>" <?php echo($attribute);?> />
    </div>
<?php
}

function input_password($label,$name,$maxlength,$placeholder,$attribute,$value)
{
?>
    <div class="form-group">
    <label for="<?php echo($name);?>"><?php echo($label);?></label>
    <input class="form-control" id="<?php echo($name);?>" name="<?php echo($name);?>" type="password" value="<?php echo($value);?>" maxlength="<?php echo($maxlength);?>" placeholder="<?php echo($placeholder);?>" <?php echo($attribute);?> />
    </div>
<?php
}

function input_number($label,$name,$min,$max,$step,$placeholder,$attribute,$value)
{
?>
    <div class="form-group">
    <label for="<?php echo($name);?>"><?php echo($label);?></label>
    <input class="form-control" id="<?php echo($name);?>" name="<?php echo($name);?>" type="number" min="<?php echo($min);?>" max="<?php echo($max);?>" step="<?php echo($step);?>" value="<?php echo($value);?>" placeholder="<?php echo($placeholder);?>" <?php echo($attribute);?> />
    </div>
<?php
}

function input_contact_number($label,$name,$title,$pattern,$maxlength,$placeholder,$attribute,$value)
{
?>
    <div class="form-group">
    <label for="<?php echo($name);?>"><?php echo($label);?></label>
    <input class="form-control" id="<?php echo($name);?>" name="<?php echo($name);?>" type="text" title="<?php echo($title);?>" pattern="<?php echo($pattern);?>" maxlength="<?php echo($maxlength);?>" placeholder="<?php echo($placeholder);?>" value="<?php echo($value);?>" <?php echo($attribute);?> />
    </div>
<?php
}

function input_date($label,$name,$attribute,$value)
{
?>
    <div class="form-group">
    <label for="<?php echo($name);?>"><?php echo($label);?></label>
    <input class="form-control" id="<?php echo($name);?>" name="<?php echo($name);?>" type="date" value="<?php echo($value);?>" <?php echo($attribute);?> />
    </div>
<?php
}

function input_textarea($label,$name,$maxlength,$placeholder,$attribute,$value)
{
?>
    <div class="form-group">
    <label for="<?php echo($name);?>"><?php echo($label);?></label>
    <textarea class="form-control" id="<?php echo($name);?>" name="<?php echo($name);?>" maxlength="<?php echo($maxlength);?>" rows="5" placeholder="<?php echo($placeholder);?>" <?php echo($attribute);?>><?php echo($value);?></textarea>
    </div>
<?php
}

function select_option($label,$name,$attribute,$selection,$placeholder,$array,$query,$index)
{
?>
    <div class="form-group">
    <label for="<?php echo($name);?>"><?php echo($label);?></label>
    <select style="width: 450px;" class="form-control chosen-select" id="<?php echo($name);?>" name="<?php echo($name);?>" data-placeholder="<?php echo($placeholder);?>" <?php echo($attribute);?>>
    <option></option>
    <?php
    if($array==NULL)
    {
        $selection=validate($selection);
        $content=mysql_query($query);
        $total=mysql_affected_rows();
        for($x=0; $x<=$total-1; $x++)
        {
            $rows=mysql_fetch_array($content);
            $value=$rows[$index];
            if($selection==$value)
            { $selected='selected'; }
            else if($selection==NULL)
            { $selected=NULL; }
            else
            { $selected=NULL; }
            ?>
            <option title="<?php echo($value);?>" <?php echo($selected);?>><?php echo($value);?></option>
        <?php
        }
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
    </select>
    </div>
<?php
}

function form_button($name,$text,$message)
{
?>
    <table border="0">
    <tr><td>&nbsp;</td></tr>
    <tr><td>
    <input class="form-control btn btn-primary" id="<?php echo($name);?>" name="<?php echo($name);?>" type="submit" value="<?php echo($text);?>" onclick="<?php confirm($message);?>" />
    </td></tr>
    <tr><td>&nbsp;</td></tr>
    </table>
<?php
}

function form_button_group($ID)
{
?>
    <?php
    if($ID==NULL)
    {
    ?>
        <input class="form-control btn btn-primary" id="btnSave" name="btnSave" type="submit" value="SAVE RECORD" data-toggle="tooltip" data-placement="right" title="SAVE as new record." onclick="<?php confirm('save');?>" />
        <?php
        if($_SESSION['formtype']=='employees')
        {
        ?>
            <button style="font-weight: normal;" class="btn btn-link" id="show_more" type="button">Show More...</button>
            <input style="display: none;" class="form-control btn btn-warning" id="btnReset" name="btnReset" type="submit" value="RESET TOTAL VACATION" data-toggle="tooltip" data-placement="right" title="RESET all records of total vacation." formnovalidate="formnovalidate" onclick="<?php confirm('reset');?>" />
        <?php    
        }
    }
    else if($ID!=NULL)
    {
        if($_SESSION['formtype']=='receivables' || $_SESSION['formtype']=='collections')
        {
            if($_SESSION['formtype']=='receivables')
            {
            ?>
                <input style="height: 75px;" class="form-control btn btn-lg btn-primary" id="btnPaid" name="btnPaid" type="submit" value="PAID RECORD" data-toggle="tooltip" data-placement="right" title="Transfer record to COLLECTIONS." onclick="<?php confirm('paid');?>" />
            <?php
            }
            else if($_SESSION['formtype']=='collections')
            {
            ?>
                <input style="height: 75px;" class="form-control btn btn-lg btn-info" id="btnUnpaid" name="btnUnpaid" type="submit" value="UNPAID RECORD" data-toggle="tooltip" data-placement="right" title="Transfer record to RECEIVABLES." onclick="<?php confirm('unpaid');?>" />
            <?php
            }
        }
        ?>
        <input class="form-control btn btn-success" name="btnUpdate" type="submit" value="UPDATE RECORD" data-toggle="tooltip" data-placement="right" title="UPDATE record details." onclick="<?php confirm('update');?>" />
        <?php
        if($_SESSION['formtype']=='employees')
        {
            if($_SESSION['visibility']!='hidden')
            {
            ?>
                <input class="form-control btn btn-warning" id="btnHide" name="btnHide" type="submit" value="HIDE RECORD" data-toggle="tooltip" data-placement="right" title="HIDE record visibility." onclick="<?php confirm('hide');?>" />
            <?php
            }
            else
            {
            ?>
                <input class="form-control btn btn-info" id="btnUnhide" name="btnUnhide" type="submit" value="UNHIDE RECORD" data-toggle="tooltip" data-placement="right" title="UNHIDE record visibility." onclick="<?php confirm('unhide');?>" />
            <?php
            }
        }
        ?>
        <input class="form-control btn btn-danger" name="btnDelete" type="submit" value="DELETE RECORD" data-toggle="tooltip" data-placement="right" title="DELETE record permanently." onclick="<?php confirm('delete');?>" />
        <?php
    }
    ?>
<?php
}

function sql_execute_query($new,$select,$id,$insert,$update,$delete,$table,$colwidth,$thname,$colname,$component)
{
    if(!isset($_POST['btnSave']) && !isset($_POST['btnReset']) && !isset($_POST['btnPaid']) && !isset($_POST['btnUnpaid']) && !isset($_POST['btnUpdate']) && !isset($_POST['btnHide']) && !isset($_POST['btnUnhide']) && !isset($_POST['btnDelete']))
    {
        $content=mysql_query($select);
        if($colwidth!=NULL || $thname!=NULL || $colname!=NULL || $component!=NULL)
        { show_table($table,$content,$colwidth,$thname,$colname,$component); }
    }

    else
    {
        if(isset($_POST['btnSave']))
        {
            if($_SESSION['formtype']=='receivables' || $_SESSION['formtype']=='collections')
            {
                mysql_query("SELECT * FROM receivables WHERE sinum LIKE '%".$_POST['sinum']."%'");
                $mysql_affected_rows1=mysql_affected_rows();
                mysql_query("SELECT * FROM collections WHERE sinum LIKE '%".$_POST['sinum']."%'");
                $mysql_affected_rows2=mysql_affected_rows();
                
                if($mysql_affected_rows1>0)
                {
                    alert("ERROR: Unable to save record. Sales Invoice Number already exists in RECEIVABLES!");
                    navigate_page($new);
                    die();
                }
                if($mysql_affected_rows2>0)
                {
                    alert("ERROR: Unable to save record. Sales Invoice Number already exists in COLLECTIONS!");
                    navigate_page($new);
                    die();
                }
            }
            else if($_SESSION['formtype']=='returns')
            {
                mysql_query("SELECT * FROM ".$_SESSION['formtype']." WHERE rtvnum=".$_POST['rtvnum']."");
                if(mysql_affected_rows()>0)
                {
                    alert("ERROR: Unable to save record. Returns Transaction Vendor Number already exists!");
                    navigate_page($new);
                    die();
                }
            }
            else if($_SESSION['formtype']=='employees')
            {
                mysql_query("SELECT * FROM ".$_SESSION['formtype']." WHERE employeenumber=".$_POST['employeenumber']."");
                if(mysql_affected_rows()>0)
                {
                    alert("ERROR: Unable to save record. Employee Number already exists!");
                    navigate_page($new);
                    die();
                }
            }
            else if($_SESSION['formtype']=='users')
            {
                mysql_query("SELECT * FROM ".$_SESSION['formtype']." WHERE username=".$_POST['username']."");
                if(mysql_affected_rows()>0)
                {
                    alert("ERROR: Unable to save record. Username already exists!");
                    navigate_page($new);
                    die();
                }
            }
            $query=$insert;
            mysql_attempt($query);
            if(mysql_affected_rows()>0)
            { $info='SUCCESS: Record has been saved.'; }
            else
            { $info='ERROR: Unable to save record.'; }
        }

        if(isset($_POST['btnReset']))
        {
            $query="UPDATE employees SET totalvacation='12.00'";
            mysql_attempt($query);
            if(mysql_affected_rows()>0)
            { $info='SUCCESS: Records have been reset.'; }
            else
            { $info='ERROR: Unable to reset records.'; }
        }

        if(isset($_POST['btnPaid']))
        {
            if(strpos($insert,'receivables')!==false)
            { $insert=str_replace('receivables','collections',$insert); }
            $query=$insert;
            mysql_attempt($query);
            
            $query=$delete;
            mysql_attempt($query);
            
            if(mysql_affected_rows()>0)
            { $info='SUCCESS: Record has been transferred to COLLECTIONS.'; }
            else
            { $info='ERROR: Unable to transfer record.'; }
        }

        if(isset($_POST['btnUnpaid']))
        {
            if(strpos($insert,'collections')!==false)
            { $insert=str_replace('collections','receivables',$insert); }
            $query=$insert;
            mysql_attempt($query);
            
            $query=$delete;
            mysql_attempt($query);
            
            if(mysql_affected_rows()>0)
            { $info='SUCCESS: Record has been transferred to RECEIVABLES.'; }
            else
            { $info='ERROR: Unable to transfer record.'; }
        }

        if(isset($_POST['btnUpdate']))
        {
            $query=$update;
            mysql_attempt($query);
            if(mysql_affected_rows()>0)
            { $info='SUCCESS: Record has been updated.'; }
            else
            { $info='ERROR: Unable to update record.'; }
            
            if($table=='employees')
            {
                $query=$_SESSION['query'];
                mysql_attempt($query);
                $mysql_affected_rows=mysql_affected_rows();
                $_SESSION['query']=NULL;
                if($mysql_affected_rows>0)
                { $info2='SUCCESS: '.$mysql_affected_rows.' Payroll record/s have been updated.'; }
            }
        }

        if(isset($_POST['btnHide']))
        {
            $query="UPDATE employees SET status='hidden' WHERE id='".$id."'";
            mysql_attempt($query);
            if(mysql_affected_rows()>0)
            { $info='SUCCESS: Record has been hidden.'; }
            else
            { $info='ERROR: Unable to hide record.'; }
        }

        if(isset($_POST['btnUnhide']))
        {
            $query="UPDATE employees SET status='' WHERE id='".$id."'";
            mysql_attempt($query);
            if(mysql_affected_rows()>0)
            { $info='SUCCESS: Record has been unhidden.'; }
            else
            { $info='ERROR: Unable to unhide record.'; }
        }

        if(isset($_POST['btnDelete']))
        {
            $query=$delete;
            mysql_attempt($query);
            if(mysql_affected_rows()>0)
            { $info='SUCCESS: Record has been deleted.'; }
            else
            { $info='ERROR: Unable to delete record.'; }
        }
        alert($info);
        if($info2!=NULL)
        { alert($info2); }
        navigate_page($new);
    }
}

function show_table($table,$content,$colwidth,$thname,$colname,$component)
{
?>
    <br />
    <div class="panel">
    <table id="<?php echo($table);?>" class="display nowrap">
    <colgroup>
    <?php
    $arrlength=count($colwidth);
    for($x=0; $x<$arrlength; $x++)
    {
    ?>
        <col span="1" style="width: <?php echo($colwidth[$x]);?>;">
    <?php
    }
    ?>
    </colgroup>
    <thead style="background-color: white;">
    <?php
    $arrlength=count($thname);
    for($x=0; $x<$arrlength; $x++)
    {
    ?>
        <th><?php echo($thname[$x]);?></th>
    <?php
    }
    ?>
    </thead>
    <tbody>
    <?php
    $total=mysql_affected_rows();
    $ctr=0;
    for($a=0; $a<$total; $a++)
    {
    ?>
        <tr>
        <form id="this_form<?=$a;?>" method="post">
        <?php
        $rows=mysql_fetch_array($content);
        $ctr=$ctr+1;
        $arrlength=count($colname);
        if($component=='select')
        {
            $value[0]=$rows[$colname[0]];
            ?>
            <input name="<?php echo($colname[0]);?>" type="hidden" value="<?php echo($value[0]);?>" />
            <td><input class="btn btn-primary btn-s" form="this_form<?=$a;?>" type="submit" value="SELECT" /></td>
            <?php
        }
        else if($component=='number')
        {
            $value[0]=$rows[$colname[0]];
            ?>
            <td><input id="<?php echo($value[0]);?>" type="number" min="0" max="999" step="1" value="0" /></td>
            <?php
        }
        for($x=0; $x<$arrlength; $x++)
        {
            $value=array();
            $value[$x]=$rows[$colname[$x]];
            $value[0]=$ctr;
            if($colname[$x]=='password' || $colname[$x]=='answer')
            {
            ?>
                <td align="center"><?php echo('**********');?></td>
            <?php
            }
            else
            {
            ?>
                <td align="center"><?php echo($value[$x]);?></td>
            <?php
            }
            ?>
            <input name="<?php echo($colname[$x]);?>" type="hidden" value="<?php echo($value[$x]);?>" />
            <?php
        }
        ?>
        </form>
        </tr>
    <?php
    }
    ?>
    </tbody>
    </table>
    </div>
<?php
}

function total_column($table,$column)
{
    $content=mysql_query("SELECT SUM(replace($column,',','')) AS total_column FROM $table");
    $rows=mysql_fetch_assoc($content);
    $total_column=number_format($rows['total_column'],2);
    return $total_column;
}

function confirm($action)
{
    if($action=='save')
    { echo("return confirm('SAVE: Do you really want to SAVE this record?');"); }

    else if($action=='reset')
    { echo("return confirm('RESET: All records of total vacation will be reset to 12. Continue?');"); }

    else if($action=='paid')
    { echo("return confirm('PAID: This record will be transferred to COLLECTIONS. Continue?');"); }

    else if($action=='unpaid')
    { echo("return confirm('UNPAID: This record will be transferred to RECEIVABLES. Continue?');"); }

    else if($action=='update')
    { echo("return confirm('UPDATE: Do you really want to UPDATE this record?');"); }

    else if($action=='hide')
    { echo("return confirm('HIDE: Do you really want to HIDE this record?');"); }

    else if($action=='unhide')
    { echo("return confirm('UNHIDE: Do you really want to UNHIDE this record?');"); }

    else if($action=='delete')
    { echo("return confirm('DELETE: Do you really want to PERMANENTLY DELETE this record?');"); }
}

function backup()
{
    $alert=array();
    $alert[]='INITIATED: COMPLETE [database] BACKUP!!!\n\n';

    if($_SESSION['usertype']=='btic_admin')
    {
        $filename="C:/dbBackup/".date("ymd-His-")."users.sql";
        $retval=mysql_query("SELECT * INTO OUTFILE '$filename' FROM users");
        if(!$retval)
        { $alert[]='ERROR: Database BACKUP [users] FAILED!\n'; }
        else
        { $alert[]='SUCCESS: Database BACKUP [users] SUCCESSFUL!\n'; }
    }
    
    if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_payroll')
    {
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
    }

    if($_SESSION['usertype']=='btic_admin' || $_SESSION['usertype']=='btic_sales')
    {
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
    }
    alert(implode($alert));
}

function alert($info)
{
?>
    <script type="text/javascript">
        alert("<?php echo($info);?>");
    </script>
<?php
}

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

function mysql_attempt($query)
{
    do
    {
        mysql_query($query);
        $attempt++;
    }
    while(mysql_affected_rows()<=0 && $attempt!=10);
    $attempt=0;
}

function reload_page()
{
?>
    <script type="text/javascript">window.location=self.location;</script>
<?php
}

function navigate_page($location)
{
?>
    <script type="text/javascript">location="<?=$location;?>";</script>
<?php
}

function redirect_home()
{
    alert('ERROR: UNAUTHORIZED ACCESS');
    ?>
    <script type="text/javascript">window.location="index.php";</script>
    <?php
}

function redirect_page()
{
    session_unset();
    session_destroy();
    ?>
    <script type="text/javascript">window.location="index.php";</script>
    <?php
}

function php_security()
{
    if($_SESSION['username']==NULL)
    {
        redirect_page();
    }
}

function sss($payyear, $tg){
    if($payyear >= 2025){        
        if ($tg < 5250.00) {
            $sss = 250.00;
        } else if ($tg < 5750.00) {
            $sss = 275.00;
        } else if ($tg < 6250.00) {
            $sss = 300.00;
        } else if ($tg < 6750.00) {
            $sss = 325.00;
        } else if ($tg < 7250.00) {
            $sss = 350.00;
        } else if ($tg < 7750.00) {
            $sss = 375.00;
        } else if ($tg < 8250.00) {
            $sss = 400.00;
        } else if ($tg < 8750.00) {
            $sss = 425.00;
        } else if ($tg < 9250.00) {
            $sss = 450.00;
        } else if ($tg < 9750.00) {
            $sss = 475.00;
        } else if ($tg < 10250.00) {
            $sss = 500.00;
        } else if ($tg < 10750.00) {
            $sss = 525.00;
        } else if ($tg < 11250.00) {
            $sss = 550.00;
        } else if ($tg < 11750.00) {
            $sss = 575.00;
        } else if ($tg < 12250.00) {
            $sss = 600.00;
        } else if ($tg < 12750.00) {
            $sss = 625.00;
        } else if ($tg < 13250.00) {
            $sss = 650.00;
        } else if ($tg < 13750.00) {
            $sss = 675.00;
        } else if ($tg < 14250.00) {
            $sss = 700.00;
        } else if ($tg < 14750.00) {
            $sss = 725.00;
        } else if ($tg < 15250.00) {
            $sss = 750.00;
        } else if ($tg < 15750.00) {
            $sss = 775.00;
        } else if ($tg < 16250.00) {
            $sss = 800.00;
        } else if ($tg < 16750.00) {
            $sss = 825.00;
        } else if ($tg < 17250.00) {
            $sss = 850.00;
        } else if ($tg < 17750.00) {
            $sss = 875.00;
        } else if ($tg < 18250.00) {
            $sss = 900.00;
        } else if ($tg < 18750.00) {
            $sss = 925.00;
        } else if ($tg < 19250.00) {
            $sss = 950.00;
        } else if ($tg < 19750.00) {
            $sss = 975.00;
        } else {
            $sss = 1000.00;
        }
    }
    return $sss;
}
?>
