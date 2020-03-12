<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">INV EDIT</h3>
        </div>
        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_inv();" class="btn btn-primary">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>
					 
                    <a onclick="NewWindow('search_inv_ent.php', 'mywin', '800', '700', 'yes', 'center');
                                return false" class="btn btn-default">
                        <span class="fa fa-search"></span> &nbsp; Find
                    </a>
					 
                </div>
               <div id="msg_box"  class="span12 text-center"  ></div>
			   
                <input type="hidden" id="tmpno" class="form-control">
               

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="invno">Ref No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Ref No" id="invno" class="form-control">
                    </div>
					<label class="col-sm-2 control-label" for="sdate">Date</label>	
                    <div class="col-sm-2">
                        <input type="date" placeholder="Date" id="sdate" class="form-control dt">
                    </div>
                </div>
				
                <div class="form-group">
                    <label for="firstname_hidden" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-6">
                         <input type="text" placeholder="Description" id="decript" class="form-control">
                    </div> 
                </div>
                


                  <input type="hidden" id="tb_deb" class="form-control">
				<table class="table table-striped">
                            <tr class='success'>
                                <th colspan="2">Debit</th>

                            </tr>
				</table>			
                <div id="itemdetails" >

                </div>
				
				 <input type="hidden" id="tb_cre" class="form-control">
				<table class="table table-striped">
                            <tr class='success'>
                                <th colspan="2">Credit</th>

                            </tr>
				</table>
                <div id="itemdetails1" >

                </div>  

            </div>

    </div>

    <div  class='space' >
        <br>&nbsp;
        <br>&nbsp;
        <br>&nbsp;

    </div>

</form>
</div>

</section>

<script src="js/inv_ent.js"></script>
<script src="js/common.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.custom.js"></script>
<script src="js/common.js"></script>
<script  type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script  type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
<script>
                            new_inv();

</script>
