<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
$_SESSION["brand"] = "";
if ($_SESSION["dev"] == "") {
    echo "Invalid User Session";
    exit();
}
?>

<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<style>
    * {
        box-sizing: border-box;
    }

    /* Create two equal columns that floats next to each other */
    .column {
        float: left;
        width: 50%;
        padding: 10px;
        height: 300px; /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Cheque Active</h3>
        </div>
    </div>

        <form role="form" name ="form1" class="form-horizontal">
            <div>
                <div class="row">
                    <div class="column" >

                        <div class="panel-group">
                            <div class="panel panel-info">
                                <div class="panel-heading">Insentive Cheque Active</div>
                                <div class="form-group"></div>
                                <div id="msg_box"  class="span12 text-center"  ></div>
                                <div class="form-group">
                                    <a style="margin-left: 40px;">
                                    </a>
                                    <a onclick="myFunction()" class="btn btn-default">
                                        <span class="fa fa-user-plus"></span> &nbsp; New

                                    </a>
                                    <a onclick="update_inv();" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-edit"></span> &nbsp; Update
                                    </a>
                                    <div><br></div>

                                </div>
                                


                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="invno">Cheque No</label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Cheque No" id="Cheque_No" class="form-control input-sm">
                                    </div>                       
                                    <br>
                                    <hr>
                                </div>
                            </div>            
                        </div>
                    </div>
                    
                    <div class="column" >
                        <div class="panel-group">
                            <div class="panel panel-info">
                                <div class="panel-heading">Comission Cheque Active</div>
                                <div class="form-group"></div>
                                <div id="msg_box1"  class="span12 text-center"  ></div>
                                <div class="form-group">
                                    <a style="margin-left: 40px;">
                                    </a>
                                    <a onclick="myFunction()" class="btn btn-default">
                                        <span class="fa fa-user-plus"></span> &nbsp; New

                                    </a>
                                    <a onclick="update_invcom();" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-edit"></span> &nbsp; Update
                                    </a>
                                    <div><br></div>

                                </div>
<!--                                <div id="msg_box1"  class="span12 text-center"  ></div>-->


                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="invno">Cheque No</label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Cheque No" id="Cheque_No_comm" class="form-control input-sm">
                                    </div>                       
                                    <br>
                                    <hr>
                                </div>
                            </div>            
                        </div>
                        
                        
                        
                    </div>
                </div>
                       
                






                            </form>


                            </section>

                            <script src="js/lock_release_chq.js"></script>


                            <script>
                                        function myFunction() {
                                            location.reload();
                                        }
                            </script>
