<?php
if ($mode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
$encrypt = new EncryptionHandler();
?>
<?php
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<link href="<?php echo public_path('../../images/jquerybubblepopup-theme/jquery.bubblepopup.v2.3.1.css') ?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo public_path('../../scripts/jquery/jquery.bubblepopup.v2.3.1.min.js') ?>" type="text/javascript"></script>

<?php
$sysConf = OrangeConfig::getInstance()->getSysConf();
$inputDate = $sysConf->getDateInputHint();
$dateDisplayHint = $sysConf->dateDisplayHint;
$format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<div class="formpage4col" >
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Loan Settlement") ?></h2></div>
        <?php echo message(); ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                <label for="txtEmpNic"><?php echo __("Employee NIC") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtEmpNic"  name="txtEmpNic" type="text" readonly="true" class="formInputText" value="<?php echo $updateLoanType->ln_ty_code ?>" maxlength="100" />
                <input type="hidden" name="txtEmployeeId" id="txtEmployeeId" value="<?php echo $etid; ?>">
            </div>
            <div class="centerCol" style="width: 0px;padding-top: 9px; padding-left: 2px;"><span style="padding-left: 5px;">
                    <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; ?> />
                </span>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtEmployeeName"><?php echo __("Employee Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtEmployeeName"  name="txtEmployeeName" type="text" readonly="true" class="formInputText" value="<?php echo $updateLoanType->ln_ty_name ?>" maxlength="100" />
            </div>

            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLoanName"><?php echo __("Loan Application id") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol" id="loanType" >

                <select name="cmbLoantype" id="cmbLoantype" class="formSelect" style="width: 160px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($loadLoanList as $LoanType) {
                        ?>
                        <option value="<?php echo $LoanType->ln_app_number ?>" <?php
                    if ($LoanType->ln_app_number == $updateApplication->ln_app_number) {
                        echo " selected=selected";
                    }
                        ?> ><?php
                            echo $LoanType->ln_app_number;
                        ?></option>
                    <?php } ?>
                </select>

            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLoanAmmount"><?php echo __("Loan Amount") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtLoanAmmount"  name="txtLoanAmmount" type="text" readonly="true" class="formInputText" value="<?php echo $updateLoanType->ln_ty_name ?>" maxlength="100" />
            </div>
            <div class="leftCol">
                <label for="txtInterestRate"><?php echo __("Total Instalment") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtTotalInstalment"  name="txtTotalInstalment" type="text"  readonly="true" class="formInputText" value="<?php echo $updateLoanType->ln_ty_name ?>" maxlength="100" />
            </div>

            <div class="leftCol">
                <label for="txtBalanceAmount"><?php echo __("Balance Amount") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtBalanceAmount"  name="txtBalanceAmount" type="text" readonly="true" class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_fixed_amt ?>" maxlength="100" />
            </div>

            <div class="leftCol">
                <label for="txtNumOfInstallments"><?php echo __("Balance Installments") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtBalanceInstallments" readonly="true" name="txtBalanceInstallments" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_number ?>" maxlength="100" />
            </div>

            <div class="leftCol">
                <label for="txtInstallmentAmount"><?php echo __("Installment Amount") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtInstallmentAmount" readonly="true" name="txtInstallmentAmount" type="text" class="formInputText" value="<?php echo $updateLoanType->ln_app_installment ?>" maxlength="100" />
            </div>
            <div class="centerCol">

                <input type="checkbox" name="chkActive" id="chkActiveLoan" class="formCheckbox" value="1" <?php if ($updateLoanType->ln_ty_active_flg == 1) { ?>
                           checked="yes"
                       <?php }
                       ?> />
                <label for="txtLocationCode"><?php echo __("Active") ?></label>
            </div>
            <br class="clear"/>
            <table border="0" style="float: right; padding-right: 131px;">
                <tr>
                    <td style="background-color: #FF9900; width: 14px; height: 8px;"></td>
                    <td><?php echo __("Settled") ?></td>
                    <td style="background-color: #3333FF; width: 14px; height: 8px;"></td>
                    <td><?php echo __("Processed") ?></td>
                </tr>             
            </table>
            <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 630px; height: 100%; border-style:  solid; border-color: #FAD163">
                <div style="">
                    <div class="centerCol" style='width:80px; background-color:#FAD163;'>
                        <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Installment") ?></label>
                    </div>
                    <div class="centerCol" style='width:70px; background-color:#FAD163;'>
                        <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Capital") ?></label>
                    </div>
                    <div class="centerCol" style='width:70px;  background-color:#FAD163;'>
<!--                        <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Interest") ?></label>-->
                    </div>
                    <div class="centerCol" style='width:90px;  background-color:#FAD163;'>
                        <label class="languageBar" style="width:100px; padding-left:6px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Proceed Date") ?></label>
                    </div>
                    <div class="centerCol" style='width:120px;   background-color:#FAD163;'>
                        <label class="languageBar" style="width:100px; padding-left:28px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Settled Amount") ?></label>
                    </div>
                    <div class="centerCol" style='width:120px;   background-color:#FAD163;'>
                        <label class="languageBar" style="width:100px; padding-left:30px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Last Settled No") ?></label>
                    </div>
                    <div class="centerCol" style='width:150px;  background-color:#FAD163;'>
                        <label class="languageBar" style="width:72px; padding-left:25px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Settled Date") ?></label>
                    </div>
                </div>
                <br class="clear"/>

                <div id="tohide">
                    <?php
                    if (strlen($childDiv)) {

                        echo $sf_data->getRaw('childDiv');
                    }
                    ?>


                </div>
                <br class="clear"/>
            </div>
            <br class="clear"/>



            <br class="clear"/>
            <br class="clear"/>
            <div class="centerCol" style="padding-left: 50px;">
                <input type="radio" name="chkTask" id="chkTaskSettlement" onclick="showDiv('Settlement')" class="chkTask"  value="1" /> <?php echo __("Settlement") ?>
            </div>
            <div class="centerCol">
                <input type="radio" name="chkTask" id="chkTaskInactivation" onclick="showDiv('Inactivation')" class="chkTask"  value="2" /> <?php echo __("Inactivation") ?>
            </div>
            <div class="centerCol">
                <input type="radio" name="chkTask" id="chkTaskReschedule" onclick="showDiv('Reschedule')" class="chkTask"  value="3" /> <?php echo __("Reschedule") ?>
            </div>

            <div class="centerCol" id="settlement" hidden="true" style="margin-left:10px; margin-top: 8px; width: 600px; border-style:  solid; border-color: #FAD163">
                <div class="centerCol" style='width:600px; background-color:#FAD163;'>
                    <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; width: 250px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Settlement Details") ?></label>
                </div>
                <br class="clear"/>
                <div class="centerCol" style="padding-top: 7px; padding-left: 163px;">
                    <input type="radio" id="optPartSettlement" name="optPartFullSettlement" onclick="selectPartSettlement(0)" class="optGuarantorType"  value="0" <?php
                    ?>/> <?php echo __("Part Settlement") ?>
                </div>

                <div class="centerCol" style="padding-top: 7px; padding-left: 22px;">
                    <input type="radio" id="optFullSettlement" name="optPartFullSettlement" onclick="selectPartSettlement(1)" class="optGuarantorType"  value="1" <?php
                    ?>/><?php echo __("Full Settlement") ?>
                </div>

                <br class="clear"/>

                <div class="leftCol">
                    <label id="labPartSettlement" for="labPartSettlement"><?php echo __("Amount") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtPartSettlement"  name="txtPartSettlement" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_fixed_amt ?>" maxlength="100" />
                </div>
                <br class="clear"/>
            </div>

            <div class="centerCol" id="inactivation"  hidden="true" style="margin-left:10px; margin-top: 8px; width: 600px; border-style:  solid; border-color: #FAD163">
                <div class="centerCol" style='width:600px; background-color:#FAD163;'>
                    <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; width: 250px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Inactivation Details") ?></label>
                </div>

                <br class="clear"/>
                <div class="centerCol" style="padding-top: 7px; padding-left: 163px;">
                    <input type="radio" name="optInactivateAcitvate" id="optAcitvate" onclick="" onchange="showPeriodtxt(0)" class="optActivateType"  value="0" <?php
                           if ($updateLoanType->ln_ty_interest_type == 0
                           )
                               echo "checked"
                        ?>/> <?php echo __("Activate") ?>
                </div>

                <div class="centerCol" style="padding-top: 7px; padding-left: 2px;">
                    <input type="radio" name="optInactivateAcitvate" id="optInactivate" onclick="" onchange="showPeriodtxt(1)" class="optInactivateType"  value="1" <?php
                           if ($updateLoanType->ln_ty_interest_type == 1
                           )
                               echo "checked"
                        ?>/><?php echo __("Inactivate") ?>
                </div>

                <br class="clear"/>

                <div class="leftCol">
                    <label id="txtPeriod" for="txtPeriod"><?php echo __("Pay Period") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtPeriodtxt"  name="txtPeriodtxt" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_fixed_amt ?>" maxlength="100" />
                </div>
                <br class="clear"/>
            </div>

            <div class="centerCol" id="reschedule" hidden="true" style="margin-left:10px; margin-top: 8px; width: 600px; border-style:  solid; border-color: #FAD163">
                <div class="centerCol" style='width:600px; background-color:#FAD163;'>
                    <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; width: 250px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Reschedule Details") ?></label>
                </div>

                <br class="clear"/>
                <div class="centerCol" style="padding-top: 7px; padding-left: 163px;">
                    <input type="radio" name="optReschedule" id="optByInstallment" onclick="guarantorDivHide(0)" onchange="optOption(this.id)" class="optGuarantorType"  value="0" <?php
                           if ($updateLoanType->ln_ty_interest_type == 0
                           )
                               echo "checked"
                        ?>/> <?php echo __("By Installment") ?>
                </div>

                <div class="centerCol" style="padding-top: 7px; padding-left: 2px;">
                    <input type="radio" name="optReschedule" id="optByAmount" onclick="guarantorDivHide(1)" onchange="optOption(this.id)" class="optGuarantorType"  value="1" <?php
                           if ($updateLoanType->ln_ty_interest_type == 1
                           )
                               echo "checked"
                        ?>/><?php echo __("By Amount") ?>
                </div>

                <br class="clear"/>

                <div class="leftCol">
                    <label for="txtNumOfInstalment"><?php echo __("Number of Installment") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtNumOfInstalment"  name="txtNumOfInstalment" type="text" class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_fixed_amt ?>" maxlength="100" />
                </div>
                <br class="clear"/>

                <div class="leftCol">
                    <label for="txtInstalmentAmount"><?php echo __("Installment Amount") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtInstalmentAmount"  name="txtInstalmentAmount" type="text" class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_fixed_amt ?>" maxlength="100" />
                </div>
                <br class="clear"/>
                <input type="hidden" name="txtSettlementHiddenId" id="txtSettlementHiddenId" value="<?php $updateApplication->ln_app_number ?>"/>&nbsp;
                <br class="clear"/>
            </div>
            <br class="clear"/>
            <div class="formbuttons">
                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                       value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />
                <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">
    
    function showPeriodtxt(id){
        if(id == 0){
            $('#txtPeriod').hide();           
            $('#txtPeriodtxt').hide();       
        }
        else{
            $('#txtPeriod').show();
            $('#txtPeriodtxt').show();
        }
    }
    
    //InterestRate and FixedInterest enabel disable option
    function optOption(val){

        if(val == "optByInstallment"){
            $('#txtNumOfInstalment').removeAttr('disabled');
            $('#txtInstalmentAmount').attr('disabled', true);
            $('#txtInstalmentAmount').val("");
        }
        else if(val == "optByAmount"){
            $('#txtNumOfInstalment').attr('disabled', true);
            $('#txtInstalmentAmount').removeAttr('disabled');
            $('#txtNumOfInstalment').val("");
        }else{
            $('#txtInterestRate').attr('disabled', true);
            $('#txtFixedInterest').attr('disabled', true);
        }
        
    }
    
    // total Number of Guarantors
    var noOfGuarantors = 0;  
    var index = 0;
    var guarantors = new Array();
   
    // Show and Hide Guarantor Details
    function guarantorDivHide(val){
        //        resetField();
        switch (val.toString())
        {
            case '0':
                $("#internal").show();
                $("#external").hide();
                break;
            case '1':
                $("#internal").hide();
                $("#external").show();
                break;
        }
    }

    //loadEmployee to grid
    function setLoanTypeNumber(loanId){
        $.post(

        "<?php echo url_for('loan/ajaxLoadLoanTypeCode') ?>", //Ajax file



        { 'loanId' : loanId },  // create an object will all values

        //function that is called when server returns a value.
        function(data){
            
            $("#txtLoanTypeCode").val(data[0]);
            $("#txtMaxInstalment").val(data[1]);
            $("#txtInterestRate").val(data[2]);
            $("#txtMaxLoanAmmount").val(data[3]);
            $("#txtGuarantorflg").val(data[8]);
            if(data[4] == 0){
                $("#txtInterestType").val("Fixed");               
            }else{
                $("#txtInterestType").val("Percentage");    
            }
        },
        //How you want the data formated when it is returned from the server.
        "json"

    );
    }   
     
    function showDiv(type){
        if(type == "Settlement"){
            $("#inactivation").hide();
            $("#settlement").show();
            $("#reschedule").hide();    
        }else if(type == "Inactivation"){
            $("#inactivation").show();
            $("#settlement").hide();
            $("#reschedule").hide();  
        }else{
            $("#inactivation").hide();
            $("#settlement").hide();
            $("#reschedule").show();
        }
    }
        
    function resetField(){
        $("#txtIGuarantorNic").val("");
        $("#txtIGuarantorId").val("");
        $("#txtIFirstName").val("");
        $("#txtILastName").val("");
        $("#txtEGuarantorNic").val("");
        $("#txtEGuarantorId").val("");
        $("#txtEFirstName").val("");
        $("#txtELastName").val("");
    }    
    
    //show Part Settlement
    function selectPartSettlement(id){
        if(id == 0){
            $("#txtPartSettlement").show();
            $("#labPartSettlement").show();
        }else{
            $("#txtPartSettlement").hide(); 
            $("#labPartSettlement").hide();
        }
    }hidden="true"
    
    function setDataToGrid(data)
    { 

        //total Number of Guarantors increment by one
        noOfGuarantors++;
        $("#txtNoOfGuarantor").val(noOfGuarantors);
        //        var i = Math.floor(Math.random()*101);
        index++;
      
        if(data[7] == "1"){ 
            childdiv="<div id='row_"+i+"' style='padding-top:0px; font-size 13px; '>";
            childdiv+="<div class='centerCol' id='master' style='width:70px;'>";
            childdiv+="<div id='guarantorType' style='color:#444444; height:25px; padding-left:10px;'><input type='text' readonly='readonly' style='border:white; width:50px; color:#FF9900; font-weight:bold;' name='guarantorType_"+index+"' id='guarantorType_"+[index]+"' value='"+data[0]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:70px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444; height:25px; padding-left:8px;'><input type='text' readonly='readonly' style='border:white; width:70px; color:#FF9900; font-weight:bold;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[1]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:20px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  height:25px; padding-left:8px;'><input type='text' readonly='readonly' style='border:white; width:70px; color:#FF9900; font-weight:bold;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value=''/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:90px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  height:25px; padding-left:0.8px;'><input type='text' readonly='readonly' style='border:white; width:70px; color:#FF9900; font-weight:bold;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[2] + "'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  height:25px; padding-left:25px;'><input type='text' readonly='readonly' style='border:white; width:70px; color:#FF9900; font-weight:bold;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[4]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  height:25px; padding-left:25px;'><input type='text' readonly='readonly' style='border:white; width:70px; color:#FF9900; font-weight:bold;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[5]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444; height:25px; font-size 13px; padding-left:34px;'><input type='text' readonly='readonly' style='border:white; width:70px; font-size 13px; color:#FF9900; font-weight:bold;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[6]+"'/></div>";
            childdiv+="</div>";
            childdiv+="</div>";
        }
        else{
            childdiv="<div id='row_"+i+"' style='padding-top:0px;'>";
            childdiv+="<div class='centerCol' id='master' style='width:70px;'>";
            childdiv+="<div id='guarantorType' style='color:#444444; height:25px; padding-left:10px;'><input type='text' readonly='readonly' style='font-weight:bold; border:white; width:50px; color:#3333FF;' name='guarantorType_"+index+"' id='guarantorType_"+[index]+"' value='"+data[0]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:70px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444; height:25px; padding-left:8px;'><input type='text' readonly='readonly' style='font-weight:bold; border:white; width:70px; color:#3333FF;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[1]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:20px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  height:25px; padding-left:8px;'><input type='text' readonly='readonly' style='font-weight:bold; border:white; width:70px; color:#3333FF;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value=''/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:90px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  height:25px; padding-left:0.8px;'><input type='text' readonly='readonly' style='font-weight:bold; border:white; width:70px; color:#3333FF;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[3]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  height:25px; padding-left:25px;'><input type='text' readonly='readonly' style='font-weight:bold; border:white; width:70px; color:#3333FF;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[4]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:110px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  height:25px; padding-left:25px;'><input type='text' readonly='readonly' style='font-weight:bold; border:white; width:70px; color:#3333FF;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[5]+"'/></div>";
            childdiv+="</div>";
            childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
            childdiv+="<div id='guarantorFirstName' style='color:#444444;  font-size 13px; height:25px; padding-left:34px;'><input type='text' readonly='readonly' style=' font-weight:bold; border:white; width:70px; font-size 13px; color:#3333FF;' name='guarantorFirstName_"+index+"' id='guarantorFirstName_"+[index]+"' value='"+data[6]+"'/></div>";
            childdiv+="</div>";
            childdiv+="</div>";
        }
        $('#tohide').append(childdiv);
        resetField();
    }    
                     
    function validateYear(type) {        
        $(type).change(function() {
           
            if(this.value < <?php echo date("Y"); ?> ){
                alert("Please enter valied year.");  
            }
       
            if(this.value )
            {
                  
            }
            if(isNaN(this.value)){
                $(this).val("");
                alert("Please Enter Numeric Values");
                return false;
            }
        });
    }
    
    //call to Employee Data method
    function SelectEmployee(data){ 
        myArr = data.split('|');         
        getGuarantorData(myArr[0]);    
    }
    
    //call to Guarantor Data method
    function SelectGuarantor(data){ 
        myArr = data.split('|'); 
        getGuarantorData(myArr[0],"gra");      

    }
    
    function getGuarantorData(gid){
        // post(file, data, callback, type); (only "file" is required)
        $.post(

        "<?php echo url_for('loan/ajaxloadGuarantorDetails') ?>", //Ajax file
        
        { gid: gid },  // create an object will all values

        //function that is called when server returns a value.
        function(data){          
           
            $("#txtEmpNic").val(data[0]);
            $("#txtEmployeeId").val(data[3]);
            $("#txtEmployeeName").val(data[1] + data[2]);       
            selectLoanType(data[3]);
        },
        //How you want the data formated when it is returned from the server.
        "json"

    );
    }
    
    function selectLoanType(empId){
        $('#tohide').empty();  
        $.post(

        "<?php echo url_for('loan/LoadLoanAssignedToEmployee') ?>", //Ajax file
        
        { empId: empId },  // create an object will all values

        //function that is called when server returns a value.
        function(data){     

            var selectbox="<select name='cmdLoanType' id='cmdLoanType' class='formSelect' style='width: 160px;' tabindex='4' onchange='getLoanDetails(this.value,"+$('#txtEmployeeId').val()+")'  >";
            selectbox=selectbox +"<option value=''><?php echo __('--Select--') ?></option>";
            $.each(data, function(key, value) {
                
                selectbox=selectbox +"<option value="+key+">"+value+"</option>";
                 
            });
            selectbox=selectbox +"</select>";
            $('#loanType').html(selectbox);
        },

        //How you want the data formated when it is returned from the server.
        "json"

    );
    }
   
    
    function getLoanDetails(typeId, empId){

        $.post(

        "<?php echo url_for('loan/ajaxGetLoanApplicationData') ?>", //Ajax file
        
        { typeId: typeId, empId : empId},  // create an object will all values

        //function that is called when server returns a value.
        function(data){     

            $('#txtLoanAmmount').val(data[0]);
            $('#txtTotalInstalment').val(data[1]);           
            $('#txtBalanceAmount').val(data[2]);
            $('#txtBalanceInstallments').val(data[3]);
            $('#txtInstallmentAmount').val(data[4]);
            if(data[5] == "1"){
                alert("Loan Settled.");
                $('#chkTaskSettlement').attr('disabled', true);
                $('#chkTaskInactivation').attr('disabled', true);
                $('#chkTaskReschedule').attr('disabled', true);                     
            }
            if(data[6] == 1){             
                $('#chkActiveLoan').attr('checked','checked');
                $('#optActivate').attr('checked','checked');
            }else {
                $('#optInactivate').attr('checked','checked');            
                $("#txtPeriodtxt").val(data[7]);
                $("#txtPeriod").show();
                $("#txtPeriodtxt").show();
            }
            setLoadLoanShedule(empId,typeId); 
        },

        //How you want the data formated when it is returned from the server.
        "json"

    );
    }
    
    
    //LoanShedule to grid
    function setLoadLoanShedule(empId, tyNumber){
        $('#tohide').empty();
        $.post(

        "<?php echo url_for('loan/ajaxLoadLoanShedule') ?>", //Ajax file


        { 'empId' : empId ,'tyNumber' : tyNumber },  // create an object will all values

        //function that is c    alled when server returns a value.
        function(data){
            
            for(j=0; j < data.length; j++){
                // you have the data in the client for your array
                var data2 = new Array();

                data2[0]=data[j]['ln_sch_ins_no'];
                data2[1]=data[j]['ln_sch_cap_amt'];          
                //data2[2]=data[j]['ln_sch_inst_amount'];
                if(data[j]['ln_sch_proc_from_date'] == null){
                    data2[2]='<?php echo __("  -") ?>';
                }
                else
                { 
                    data2[2]=data[j]['ln_sch_proc_from_date'];
                }                
                $('#txtInstallmentAmount').val(data[1]['ln_sch_inst_amount']);
                if(data[j]['ln_sch_proc_from_date'] == null){
                    data2[3]='<?php echo __("  -") ?>';
                }
                else
                { 
                    data2[3]=data[j]['ln_sch_proc_from_date'];
                }
//                if(data[j]['ln_sch_is_processed'] == 1){
                            data2[4]=data[j]['ln_sch_inst_amount'];
//                }
//                else{
//                       data2[4]='<?php echo __(" -") ?>';
//                }
                
                if(data[j]['ln_st_number'] == null){
                    data2[5]='<?php echo __("  -") ?>';
                }
                else
                { 
                    data2[5]=data[j]['ln_st_number'];  
                } 
                if(data[j]['ln_sch_proc_to_date'] == null){
                    data2[6]='<?php echo __("  -") ?>';
                }
                else
                { 
                    data2[6]=data[j]['ln_sch_proc_to_date'];
                }             
                data2[7]=data[j]['ln_sch_is_processed'];  
                
                setDataToGrid(data2);
                        
            }
     
            $("#txtLoanTypeCode").val(data[0]);
            $("#txtMaxInstalment").val(data[1]);
            $("#txtInterestRate").val(data[2]);
            $("#txtMaxLoanAmmount").val(data[3]);
            if(data[4] == 0){
                $("#txtInterestType").val("Fixed");               
            }else{
                $("#txtInterestType").val("Percentage");               
            }
        },
        //How you want the data formated when it is returned from the server.
        "json"

    );
    }   
    
    function getSettledAmount(ln_st_number){
        var amount;  
        $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('loan/ajaxLoadLoanSettlement') ?>",
            data: {'ln_st_number' : ln_st_number },
            dataType: "json",
            beforeSend: function(){


            },
            success: function(data){
                amount = data;
            }
        });
        return amount; 
    }
    
    $(document).ready(function() {

        $("#inactivation").hide();
            $("#settlement").hide();
            $("#reschedule").hide();
       
       selectPartSettlement("1");
       
        $("#txtPGridartSettlement").hide(); 
        $("#labPartSettlement").hide();
            
        //Inactive PeriodText hide
        $('#txtPeriod').hide();           
        $('#txtPeriodtxt').hide();    
        
        $('#txtNumOfInstalment').removeAttr('disabled');
        $('#txtInstalmentAmount').attr('disabled', true);

        $("#txtApplyDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
        $("#txtEffectiveDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });


            
        validateYear('input[name="cmbYear"]');

        //load app
        $('#empRepPopBtn').click(function() {

            var popup=window.open("<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee') ?>" + "?type=multiple&method=SelectEmployee&payroll=payroll&locationWise=1",'Locations','height=450,width=800,resizable=1,scrollbars=1');
            //var popup=window.open('<?php echo public_path('../../symfony/web/index.php/loan/searchEmployee?type=single&method=SelectEmployee&payroll=payroll'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
            if(!popup.opener) popup.opener=self;
            popup.focus();
        });
        
        //load app
        $('#empRepPopBtn2').click(function() {

            var popup=window.open('<?php echo public_path('../../symfony/web/index.php/loan/searchEmployee?type=single&method=SelectGuarantor&payroll=payroll'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
            if(!popup.opener) popup.opener=self;
            popup.focus();
        });

        buttonSecurityCommon(null,"editBtn",null,null);    
<?php if ($mode == 0) { ?>
                        $('#editBtn').show();
                        buttonSecurityCommon(null,null,"editBtn",null);

                        $('#frmSave :input').attr('disabled', true);
                        $('#editBtn').removeAttr('disabled');
                        $('#btnBack').removeAttr('disabled');
<?php } ?>

        //Validate the form
        $("#frmSave").validate({

            rules: {
                txtEmpNic: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtEmployeeName: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                cmbLoantype: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtLoanAmmount: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtBalanceAmount: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtInstallmentAmount: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtTotalInstalment: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtBalanceInstallments:{required: true,maxlength:50},
                chkActiveLoan: {noSpecialCharsOnly: false, maxlength:50 }              
            },
            messages: {
                txtEmpNic:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtEmployeeName:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                cmbLoantype:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},   
                txtLoanAmmount:{required:"<?php echo __("This field is required.") ?>"},
                txtBalanceAmount:{required:"<?php echo __("This field is required.") ?>"},
                txtInstallmentAmount:{required:"<?php echo __("This field is required.") ?>"},
                txtTotalInstalment:{required:"<?php echo __("This field is required.") ?>"},
                txtBalanceInstallments:{required:"<?php echo __("This field is required.") ?>"},
                chkActiveLoan:{required:"<?php echo __("This field is required.") ?>"}          
                            
            },submitHandler: function(form) {
           
                $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                form.submit();    
            }
        });


        // When click edit button
        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

        // When click edit button
        $("#editBtn").click(function() {
           
            var editMode = $("#frmSave").data('edit');
            if (editMode == 1) {
                // Set lock = 1 when requesting a table lock

                location.href="<?php echo url_for('loan/SaveLoanSettlement?setleId=' . $encrypt->encrypt($updateLoanType->ln_ty_number) . '&lock=1') ?>";
            }
            else {
                //if($("#cmdLoanType").val() != 0){
                //getMaxInstallment($("#cmdLoanType").val())
                //}
                if($("#txtApplyDate").val() > $("#txtEffectiveDate").val()){
                    alert("<?php echo __('Invalid Effective Date') ?>");
                    return false;
                }               
                else if($('input[id="chkTaskSettlement"]').is(':checked')){
                    if($('input[id="optPartSettlement"]').is(':checked'))
                    {
                        if($('input[id="txtPartSettlement"]').val() == ""){
                            alert("Settlement amount can't be empty.");
                        }
                        else if(isNaN($("#txtPartSettlement").val())) {
                            alert("Settlement amount can't be letter.");
                            return false;   
                   
                        }else{
                            $('#frmSave').submit();
                        }
                    }
                    else if($('input[id="optFullSettlement"]').is(':checked')){
                          $('#frmSave').submit();
                    }
                    else{
                        alert("please select settlement offtion.");
                        return false;  
                    }       
                }else if($('input[id="chkTaskReschedule"]').is(':checked')){
                    if($('input[id="optByInstallment"]').is(':checked'))
                    {
                        if($('input[id="txtNumOfInstalment"]').val() == ""){
                            alert("number Of Instalment can't be empty.");
                        }
                        else if(isNaN($("#txtNumOfInstalment").val())) {
                            alert("number Of Instalment can't be letter.");
                            return false;   
                       
                        }else{
                            $('#frmSave').submit();
                        }
                    }else if($('input[id="optByAmount"]').is(':checked')){
                        if($('input[id="txtInstalmentAmount"]').val() == ""){
                            alert("Reschedule amount can't be empty.");
                        }
                        else if(isNaN($("#txtInstalmentAmount").val())) {
                            alert("Reschedule amount can't be letter.");
                            return false;   
                   
                        }else{
                            $('#frmSave').submit();
                        }
                    }else{
                        alert("please select settlement offtion.");
                        return false;  
                    }
                  
                } else {
                    $('#frmSave').submit();
                }
            }
        });

        //When click reset buton
        $("#btnClear").click(function() {
            if($("#frmSave").data('edit') != 1){
                          location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/loan/SaveLoanSettlement')) ?>";

            }else{
                document.forms[0].reset('');
            }
        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/loan/LoanSettlement')) ?>";
        });
        
        //When Click Add to Grid button
        $("#btnGrid").click(function() {
            var guarantorType = $('input:radio[name=optGuarantorType]:checked').val();
            if(guarantorType == 0)
            {  
                if($("#txtIGuarantorNic").val() != ""){
                    var data = new Array(2);
                    data[0]="Internal";
                    data[1]=$("#txtIGuarantorNic").val();
                    data[2]=$("#txtIFirstName").val();
                    data[3]=$("#txtILastName").val();
                    setDataToGrid(data);
                }else{
                    alert("Please select Guaranter");
                }
            }
            else{
                if($("#txtEGuarantorNic").val() == ""){
                    alert("Please Enter Guaranter NIC Number");                                     
                } 
                else if($("#txtEFirstName").val() == ""){
                    alert("Please Enter Guaranter Frist Name");                                     

                }
                else if($("#txtELastName").val() == ""){
                    alert("Please Enter Guaranter Last Name");                                     

                }
                else {
                    var data = new Array(2);
                    data[0]="External";
                    data[1]=$("#txtEGuarantorNic").val();
                    data[2]=$("#txtEFirstName").val();
                    data[3]=$("#txtELastName").val()
                    setDataToGrid(data);
                }
            }
        });
    });
</script>
