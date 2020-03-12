<?php
include './connection_sql.php';
?>

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Cheque Pay Debit Modification</h3>
        </div>
        <form name= "form1" role="form" class="form-horizontal">
            <div class="box-body">

                <input type="hidden" id="tmpno" class="form-control">

                <input type="hidden" id="item_count" class="form-control">

                <div class="form-group">

                    <!--                    <a onclick="new_inv();" class="btn btn-default btn-sm">
                                            <span class="fa fa-user-plus"></span> &nbsp; New
                                        </a>-->

                    <a onclick="save_inv();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                    <!--                    <a onclick="print_inv('');" class="btn btn-default btn-sm">
                                            <span class="fa fa-print"></span> &nbsp; Print
                                        </a>
                    
                                        <a onclick="cancel_inv();" class="btn btn-danger btn-sm">
                                            <span class="fa fa-trash-o"></span> &nbsp; Cancel
                                        </a>-->

                </div>

                <div id="msg_box"  class="span12 text-center"  ></div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Entry No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Entry No" id="txt_entno" class="form-control  input-sm" disabled="">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('../serach_chq_pay_acc.php?stname=smp', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Narration</label>
                    <div class="col-sm-5">
                        <textarea name="TXT_NARA" id="TXT_NARA" cols="100" rows="5" class="form-control  input-sm"></textarea>
                    </div>
                </div>    

                <table class="table table-striped">
                    <tr class='info'>
                        <th style="width: 100px;">Acc Code</th>
                        <th>Acc Name</th>
                        <th style="width: 10px;"></th>
                        <th style="width: 400px;">Description</th>
                        <th style="width: 150px;">Amount</th>
                        <th style="width: 10px;"></th>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" placeholder="Acc Code" id="itemCode" value="" class="form-control input-sm"  disabled="">
                        </td>
                        <td>
                            <input type="text" placeholder="Acc Name" id="itemDesc" class="form-control input-sm"  disabled="">
                        </td>
                        <td>
                            <a href="" onclick="NewWindow('../search_ledger_acc.php?stname=cheque_pay_smp', 'mywin', '800', '700', 'yes', 'center');
                                    return false" onfocus="this.blur()">
                                <input type="button" name="searchcusti" id="searchcusti" value="..." class="btn btn-default btn-sm">
                            </a>
                        </td>
                        <td>
                            <input type="text" placeholder="Description" id="qty" class="form-control input-sm">
                        </td>
                        <td>
                            <input type="text" placeholder="Amount" id="itemPrice" class="form-control input-sm">
                        </td>
                        <td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                    </tr>

                </table>

                <div id="itemdetails" >

                </div>

                <table id='subtotal' class="table">
                    <tr>
                        <td></td>
                        <td></td>
                        <th>Debit Total</th>

                        <td></td>                        
                        <td style="width: 150px;"><input type="text" placeholder="Debit Total" id="subtot" class="form-control input-sm"  disabled=""></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th>Credit Total</th>
                        <td></td>                        
                        <td style="width: 150px;"><input type="text" placeholder="Credit Total" id="nbt" class="form-control input-sm"  disabled=""></td>
                    </tr>
                </table>		

            </div>
        </form>
    </div>

</section>
<script src="js/invoice.js"></script>
<script>
                            new_inv();
</script>
<?php
include 'login.php';
include './cancell.php';
?>
    