<?php session_start(); ?>
<?php
date_default_timezone_set('Asia/Colombo');
$_SESSION["txt_stat"] = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="imagetoolbar" content="no" />
        <title>Cheque Pay</title>
        <link media="screen" rel="stylesheet" type="text/css" href="css/admin.css"  />
        <!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-ie.css" /><![endif]-->
        <script type="text/javascript" src="js/css.js"></script>
        <script type="text/javascript" src="js/behaviour.js"></script>

        <script language="JavaScript" src="js/cheque_pay_acc.js"></script>
        <?php
        $_SESSION["tmp_no_cashrec"] = "";
        ?>
    </head>

    <body>
        <!--[if !IE]>start wrapper<![endif]-->
        <div id="wrapper">
            <!--[if !IE]>start head<![endif]-->
            <div id="head">



                <!--[if !IE]>end logo end user details<![endif]-->



                <!--[if !IE]>start menus_wrapper<![endif]-->

                <!--[if !IE]>end menus_wrapper<![endif]-->



            </div>
            <!--[if !IE]>end head<![endif]-->

            <!--[if !IE]>start content<![endif]-->
            <div id="content">





                <!--[if !IE]>start page<![endif]-->
                <div id="page">
                    <div class="inner">

                        <div class="section">
                            <!--[if !IE]>start title wrapper<![endif]-->
                            <div class="title_wrapper">
                                <h2>Cheque Pay -  

                                    <?php
                                    if ($_SESSION['company'] == "TH") {
                                        echo " Tyre House Trading ";
                                    }

                                    if ($_SESSION['company'] == "BE") {
                                        echo " Benedictsons ";
                                    }

                                    if ($_SESSION['company'] == "EF") {
                                        echo " E-Friendly ";
                                    }
                                    ?>
                                </h2>
                                <span class="title_wrapper_left"></span>
                                <span class="title_wrapper_right"></span>
                            </div>
                            <!--[if !IE]>end title wrapper<![endif]-->
                            <!--[if !IE]>start section content<![endif]-->
                            <div class="section_content">
                                <!--[if !IE]>start section content top<![endif]-->
                                <div class="sct">
                                    <div class="sct_left">
                                        <div class="sct_right">
                                            <div class="sct_left">
                                                <div class="sct_right">
                                                    <!--[if !IE]>start dashboard menu<![endif]-->
                                                    <ul class="dashboard_menu">
                                                        <li><a class="d2" onClick="new_inv();" ><span>New</span></a></li>

                                                        <li><a class="d4" onClick="save_crec();"><span>Save</span></a></li>
                                                        <li><a class="d5" onClick="edit_rec();" ><span>Edit</span></a></li>
                                                        <?php
                                                        session_start();
                                                        require_once("config.inc.php");
                                                        require_once("DBConnector.php");
                                                        $db = new DBConnector();
                                                        $sql = "select * from user_mast where user_name='" . $_SESSION["UserName"] . "' and cancel = '1'";
                                                        $result = $db->RunQuery($sql);
                                                        if ($row = mysql_fetch_array($result)) {
                                                            ?>	
                                                            <li><a class="d5" onClick="delete_rec();" ><span>Cancel</span></a></li>
                                                            <?php
                                                        }
                                                        ?>
                                                        <li><a class="d6" onClick="chq_print_las();"><span>Prn Chq</span></a></li>
                                                        <li><a class="d6" onClick="vou_print_las();"><span>Prn Vou</span></a></li>
                                                        <li><a class="d8" onclick="close_form();"><span>Close</span></a></li>


                                                    </ul>
                                                    <!--[if !IE]>end dashboard menu<![endif]-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--[if !IE]>end section content top<![endif]-->
                                <!--[if !IE]>start section content bottom<![endif]-->
                                <span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
                                <!--[if !IE]>end section content bottom<![endif]-->

                            </div>
                            <!--[if !IE]>end section content<![endif]-->
                        </div>				

                        <!--[if !IE]>start section<![endif]-->	
                        <div class="section">
                            <!--[if !IE]>start title wrapper<![endif]-->
                            <!--[if !IE]>end title wrapper<![endif]-->
                            <!--[if !IE]>start section content<![endif]-->

                            <!--[if !IE]>end section<![endif]-->


                            <!--[if !IE]>start section<![endif]-->	




                            <!--[if !IE]>start section<![endif]-->	
                            <div class="section">
                                <!--[if !IE]>start title wrapper<![endif]-->
                                <div class="title_wrapper1">

                                </div>
                                <!--[if !IE]>end title wrapper<![endif]-->
                                <!--[if !IE]>start section content<![endif]-->
                                <div class="section_content">
                                    <!--[if !IE]>start section content top<![endif]-->
                                    <div class="sct">
                                        <div class="sct_left">
                                            <div class="sct_right">
                                                <div class="sct_left">
                                                    <div class="sct_right">




                                                        <!--[if !IE]>start fieldset<![endif]-->

                                                        <!--[if !IE]>start forms<![endif]-->



                                                        <?php
                                                        include('cheque_pay_details_acc.php');
                                                        ?>




                                                        <!--[if !IE]>end forms<![endif]-->


                                                        <!--[if !IE]>end fieldset<![endif]-->





                                                        <!--[if !IE]>end forms<![endif]-->	

                                                        <!--[if !IE]>start system messages<![endif]-->												<!--[if !IE]>end system messages<![endif]-->




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--[if !IE]>end section content top<![endif]-->
                                    <!--[if !IE]>start section content bottom<![endif]-->
                                    <span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
                                    <!--[if !IE]>end section content bottom<![endif]-->

                                </div>
                                <!--[if !IE]>end section content<![endif]-->
                            </div>
                            <!--[if !IE]>end section<![endif]-->




                            <!--[if !IE]>start section<![endif]-->	





                        </div>
                    </div>
                    <!--[if !IE]>end page<![endif]-->
                    <!--[if !IE]>start sidebar<![endif]--><!--[if !IE]>end sidebar<![endif]-->




                </div>
                <!--[if !IE]>end content<![endif]-->

            </div>
            <!--[if !IE]>end wrapper<![endif]-->

            <!--[if !IE]>start footer<![endif]-->

            <!--[if !IE]>end footer<![endif]-->

    </body>
</html>
