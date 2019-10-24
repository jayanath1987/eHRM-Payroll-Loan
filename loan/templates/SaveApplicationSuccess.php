<?php
if ($mode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    //$disabled = 'disabled="disabled"';
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
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.simplemodal.js') ?>"></script>
    <?php
$sysConf = OrangeConfig::getInstance()->getSysConf();
$inputDate = $sysConf->getDateInputHint();
$dateDisplayHint = $sysConf->dateDisplayHint;
$format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<!--<style type="text/css">
 
    .GridText {
         display: none;
     }

        
  </style>-->
<!--<div id="dialog" title="<?php echo __("Loan Shedule"); ?>">
    <div id="test">


    </div>

</div>-->

<div class="formpage4col">
    <div class="outerbox" >
        <div class="mainHeading"><h2><?php echo __("Apply Loan") ?></h2></div>
        <?php echo message(); ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div id="dialog" title="<?php echo __("Loan Shedule"); ?>">
    <div id="test">


    </div>

</div>
            <div class="leftCol">
                <label for="txtApplicationId"><?php echo __("Application ID") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtUserApplicationId"   name="txtUserApplicationId" type="text"  class="formInputText" value="<?php if($updateApplication->ln_app_user_number!= null){ echo $updateApplication->ln_app_user_number; } ?>" maxlength="100"/>
                <input id="txtApplicationId"   name="txtApplicationId" type="hidden"  class="formInputText" value="<?php if($updateApplication->ln_app_number){ echo $updateApplication->ln_app_number; }else{ echo $LoanMaxID; } ?>" maxlength="100"/>
            </div>
            <div class="leftCol">
                <label for="lblEmpNic"><?php echo __("Employee NIC") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtEmpNic"  name="txtEmpNic" type="text" readonly="true" class="formInputText" value="<?php echo $appliedEmployee->emp_nic_no ?>" maxlength="100" />
                <input type="hidden" name="txtEmployeeId" id="txtEmployeeId" value="<?php echo $updateApplication->emp_number; ?>">
            </div>
            <div class="centerCol" style="width: 0px;padding-top: 9px; padding-left: 2px;"><span style="padding-left: 5px;">
                    <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; ?> />
                </span>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLoanName"><?php echo __("Loan Name") ?> <span class="required">*</span></label>
            </div>

            <div class="centerCol">

                <select name="cmbLoantype" id="cmbLoantype" class="formSelect" onchange="setLoanTypeNumber(this.value);" style="width: 160px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($loanTypeList as $LoanType) {
                        ?>
                        <option value="<?php echo $LoanType->ln_ty_number ?>" <?php
                    if ($LoanType->ln_ty_number == $updateApplication->ln_ty_number) {
                        echo " selected=selected";
                    }
                        ?> ><?php
                            if ($Culture == 'en') {
                                echo $LoanType->ln_ty_name;
                            } elseif ($Culture == 'si') {
                                if (($LoanType->ln_ty_name_si) == null) {
                                    echo $LoanType->ln_ty_name;
                                } else {
                                    echo $LoanType->ln_ty_name_si;
                                }
                            } elseif ($Culture == 'ta') {
                                if (($LoanType->ln_ty_name_ta) == null) {
                                    echo $LoanType->ln_ty_name;
                                } else {
                                    echo $LoanType->ln_ty_name_ta;
                                }
                            }
                        ?></option>

                    <?php } ?>
                </select>
            </div>


            <div class="leftCol">
                <label for="txtEmployeeName"><?php echo __("Employee Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtEmployeeName"  name="txtEmployeeName" type="text" readonly="true" class="formInputText" value="<?php echo $appliedEmployee->emp_display_name ?>" maxlength="100" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLoanTypeCode"><?php echo __("Loan Type Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtLoanTypeCode"  name="txtLoanTypeCode" type="text" readonly="true" class="formInputText" value="<?php echo $loanType->ln_ty_code ?>" maxlength="100" />
            </div>
            <div class="leftCol">
                <label for="txtInterestType"><?php echo __("Interest Type") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtInterestType"  name="txtInterestType" type="text" readonly="true" class="formInputText" value="<?php
                    if ($loanType->ln_ty_interest_type == 0) {
                        echo "Fixed";
                    } else {
                        echo "Percentage";
                    }
                    ?>" maxlength="100" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtMaxLoanAmmount"><?php echo __("Max Loan Amount") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtMaxLoanAmmount"  name="txtMaxLoanAmmount" type="text" readonly="true" class="formInputText" value="<?php echo $loanType->ln_ty_amount ?>" maxlength="100" />      
            </div>
            <div class="leftCol">
                <label for="txtInterestRate"><?php echo __("Interest Rate/Amount %") ?></label>
            </div>
            <div class="centerCol">
                <input id="txtInterestRate"  name="txtInterestRate" type="text"  readonly="true" class="formInputText" value="<?php echo $loanType->ln_ty_interest_rate ?>" maxlength="100" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtMaxInstalment"><?php echo __("Maximum Installment") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtMaxInstalment"  name="txtMaxInstalment" type="text" readonly="true" class="formInputText" value="<?php echo $loanType->ln_ty_max_installment ?>" maxlength="100" />
                <input type="hidden" name="txtGuarantorflg" id="txtGuarantorflg" value="<?php echo $LoanType->ln_ty_app_req_flg; ?>">
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtNumOfInstallments"><?php echo __("No Of Installment") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtNumOfInstallments"  name="txtNumOfInstallments" type="text"  class="formInputText" value="<?php echo $updateApplication->ln_app_no_of_Installments ?>" maxlength="100" />
            </div>
            <div class="leftCol">
                <label for="txtInstallmentAmount"><?php echo __("Installment Amount") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtInstallmentAmount"  name="txtInstallmentAmount" type="text" class="formInputText" value="<?php echo $updateApplication->ln_app_install_amount ?>" maxlength="100" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtApplyAmount"><?php echo __("Apply Amount") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtApplyAmount"  name="txtApplyAmount" type="text"  class="formInputText" value="<?php echo $updateApplication->ln_app_amount ?>" maxlength="100" />
            </div>

            <br class="clear"/>

            <div class="leftCol">
                <label class="controlLabel" for="txtApplyDate"><?php echo __("Apply Date") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtApplyDate" id="txtApplyDate" value="<?php echo LocaleUtil::getInstance()->formatDate($updateApplication->ln_app_date) ?>" />

            </div>
            <div class="leftCol">
                <label class="controlLabel" for="txtEffectiveDate"><?php echo __("Effective Date") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" class="formInputText" name="txtEffectiveDate" id="txtEffectiveDate" value="<?php echo LocaleUtil::getInstance()->formatDate($updateApplication->ln_app_effective_date) ?>" />
            </div>
            <div class="leftCol">
                <label for="txtEmpNic"><?php echo __("Ledger") ?> </label>
            </div>
<!--            <div class="centerCol">
                <input id="txtEmpNic"  name="txtEmpNic" type="text" readonly="true" class="formInputText" value="<?php //echo $appliedEmployee->emp_nic_no ?>" maxlength="100" />
                <input type="hidden" name="txtEmployeeId" id="txtEmployeeId" value="<?php// echo $updateApplication->emp_number; ?>">
            </div>-->
            <div class="centerCol" style="width: 0px;padding-top: 9px; padding-left: 2px;"><span style="padding-left: 5px;">
                    <input class="button" type="button" value="..." id="btnLedger" name="btnLedger" <?php //echo $disabled; ?> />
                </span>
            </div>
<!--            <br class="clear"/>-->
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtGuarantorDetails"><?php echo __("Guarantor Details") ?> <span class="required">*</span></label>
            </div>

            <div class="centerCol" style="padding-top: 7px; padding-left: 3px;">
                <input type="radio" name="optGuarantorType" id="optInternal" onclick="guarantorDivHide(0)" class="optGuarantorType"  value="0" <?php
                       echo "checked"
                    ?>/> <?php echo __("Internal Guarantor") ?>
            </div>
            <div class="centerCol" style="padding-top: 7px; padding-left: 3px;">
                <input type="radio" name="optGuarantorType" id="optExternal" onclick="guarantorDivHide(1)" class="optGuarantorType"  value="1" <?php ?>/><?php echo __("External Guarantor") ?>
            </div>
            <br class="clear"/>

            <div id="internal" style="margin-right:10px; margin-top: 8px; width: 750px; border-style:  solid; border-color: #FAD163">
                <div style="">
                    <div class="centerCol" style='width:750px; background-color:#FAD163;'>
                        <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Internal Guarantor Details") ?></label>
                    </div>
                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtGuarantorNic"><?php echo __("Guarantor NIC Number") ?><span class="required">*</span></label>
                </div>
                <div>
                    <input type="text" value=""  style="width:250px;" class="formInputText" name="txtIGuarantorNic" id="txtIGuarantorNic" readonly="readonly"/> 
                    <input type="hidden" name="txtIGuarantorId" id="txtGuarantorId" value="<?php echo $etid; ?>">
                </div>

                <div class="centerCol" style="width: 250px;padding-top: 9px; padding-left: 20px;"><span style="padding-left: 5px;">
                        <input class="button" type="button" value="..." id="empRepPopBtn2" name="empRepPopBtn2" <?php echo $disabled; ?> />
                    </span>
                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtIFirstName"><?php echo __("First Name") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtIFirstName"  name="txtIFirstName" type="text" style="width: 250px;" readonly="readonly" class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_fixed_amt ?>" maxlength="100" />
                </div>

                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtILastName"><?php echo __("Last Name") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtILastName"  name="txtILastName" type="text" style="width: 250px; "readonly="readonly" class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_fixed_amt ?>" maxlength="100" />
                </div>
                <br class="clear"/>

            </div> 

            <div id="external" style="margin-left:10px; margin-top: 8px; width: 750px; border-style:  solid; border-color: #FAD163">
                <div style="">
                    <div class="centerCol" style='width:750px; background-color:#FAD163;'>
                        <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; width:180px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("External Guarantor Details") ?></label>
                    </div>
                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtGuarantorNic"><?php echo __("Guarantor NIC Number") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtEGuarantorNic"  style="width:250px;" name="txtEGuarantorNic" type="text" class="formInputText" value="<?php ?>" maxlength="10" />
                    <input type="hidden" name="txtEGuarantorId" id="txtEGuarantorId" value="<?php echo $etid; ?>">
                </div>

                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtEFirstName"><?php echo __("First Name") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtEFirstName"  name="txtEFirstName" type="text" style="width: 250px;" class="formInputText" value="" maxlength="100" />
                </div>

                <br class="clear"/>
                <div class="leftCol">
                    <label for="txtELastName"><?php echo __("Last Name") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input id="txtELastName"  name="txtELastName" type="text" style="width: 250px;" class="formInputText" value="<?php ?>" maxlength="100" />
                </div>
                <br class="clear"/>

            </div> 

            <br class="clear"/>
            <div class="leftCol" style="padding-left: 470px;">
                <input type="button" class="backbutton" id="btnGrid"
                       value="<?php echo __("Add Guarantor to Grid") ?>" tabindex="10" />
            </div>
            <br class="clear"/>
            <div id="employeeGrid" class="leftCol" style="margin-left:10px; margin-top: 8px; width: 590px; border-style:  solid; border-color: #FAD163">
                <div style="">
                    <div class="centerCol" style='width:150px; background-color:#FAD163;'>
                        <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Guarantor Type") ?></label>
                    </div>
                    <div class="centerCol" style='width:200px;  background-color:#FAD163;'>
                        <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444;"><?php echo __("Guarantor Name") ?></label>
                    </div>
                    <div class="centerCol" style='width:240px;  background-color:#FAD163;'>
                        <label class="languageBar" style="width:75px; padding-left:150px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>
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
            <div class="leftCol">
                <label for="txtNoOfGuarantor"><?php echo __("No of Guarantor") ?> </label>
            </div>
            <div class="centerCol" >
                <input id="txtNoOfGuarantor" name="txtNoOfGuarantor" type="text" readonly="true" style="width: 40px;" class="formInputText" value="" maxlength="100" />
            </div>
            <br class="clear"/>
            <input type="hidden" name="txtApplicationHiddenId" id="txtApplicationHiddenId" value="<?php echo $updateApplication->ln_app_number ?>"/>&nbsp;

            <br class="clear"/>
<!--            </form>-->
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
    jQuery("#dialog").dialog({

                        bgiframe: true, autoOpen: false, position: 'top', minWidth:1200, maxWidth:1200, modal: true
                    });
    // total Number of Guarantors
    var noOfGuarantors = 0;  
    var index = 0;
    //    var guarantors = new Array();
        
    function calclick(id){
        //alert($('.test').html());
        var form1Content = document.getElementById("frmledger").innerHTML;
          $("#frmSave").append(form1Content);
        document.getElementById('frmSave').submit();





        //$('#dialog').dialog('close');
    }       
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
           
           
    //    function setLoanTypeNumber(loanId){
    //        //        alert(loanId);
    //        $("#txtLoanTypeCode").val(loanId);
    //    }
    //   
           
    //loadEmployee to grid
    function setLoanTypeNumber(loanId){
        $.post(

        "<?php echo url_for('loan/ajaxLoadLoanTypeCode') ?>", //Ajax file



        { 'loanId' : loanId },  // create an object will all values

        //function that is c    alled when server returns a value.
        function(data){
            $("#txtLoanTypeCode").val(data[0]);
            $("#txtMaxInstalment").val(data[1]);
            $("#txtInterestRate").val(data[2]);
            $("#txtMaxLoanAmmount").val(data[3]);
            $("#txtGuarantorflg").val(data[5]);
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
    function setDataToGrid(data)
    { 
        //total Number of Guarantors increment by one
        noOfGuarantors++;
        $("#txtNoOfGuarantor").val(noOfGuarantors);
        //        var i = Math.floor(Math.random()*101);
        index++;
              
        childdiv="<div name='row' id='row_"+index+"' style='padding-top:0px; width:590px;'>";
        childdiv+="<div class='centerCol' id='master' style='width:150px;'>";
        childdiv+="<div id='guarantorType' style='color:#444444; height:25px; padding-left:3px;'><input type='text' readonly='readonly' style='border:white;  color:#444444;' name='guarantorType[]' id='guarantorType_"+[index]+"' value='"+data[0]+"'/></div>";
        childdiv+="</div>";
        childdiv+="<div class='centerCol' id='master' style='width:200px;'>";
        if(data[3] == null){
            childdiv+="<div id='guarantorFirstName' style='color:#444444; width:200px; height:25px; padding-left:3px;'><input type='text' readonly='readonly' style='border:white; width:150px; color:#444444;' name='guarantorFirstName[]' id='guarantorFirstName_"+[index]+"' value='"+data[2] + "'/></div>";   
        }else{
            childdiv+="<div id='guarantorFirstName' style='color:#444444; width:200px; height:25px; padding-left:3px;'><input type='text' readonly='readonly' style='border:white; width:150px; color:#444444;' name='guarantorFirstName[]' id='guarantorFirstName_"+[index]+"' value='"+data[2] + " "+ data[3]+"'/></div>";
        }childdiv+="</div>";
        childdiv+="<input type='hidden' style='border:white; color:#444444;' name='guarantorNic[]' id='guarantorNic_"+[index]+"' value='"+data[1]+"'/>";
        childdiv+="<input type='hidden' readonly='readonly' style='border:white; color:#444444;' name='guarantorId[]' id='guarantorId[]' value='"+data[4]+"'/>";
        //childdiv+="</div>";
        childdiv+="<div class='centerCol' id='master' style='width:240px;'>";
        var nic=data[1];
        childdiv+="<div name='delete_' id='delete_"+index+"' style='height:25px; padding-left:150px;'><a href='#' style='width:50px;' disa onclick='deleteCRow("+index+");'><?php  echo __("Delete");  ?></a></div>";

        childdiv+="</div>";
        childdiv+="</div>";
        //childdiv+="</div>";
                
        $('#employeeGrid').append(childdiv);
        resetField();
    }    
    //Delete GuarantorDetails From Grid View
    function deleteCRow(id){
<?php if ($mode == 1) { ?>       
            answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

            if (answer !=0)
            {
                var loanno="<?php echo $updateApplication->ln_app_number; ?>";
                var loantype=$("#cmbLoantype").val();
                var nic=$("#guarantorNic_"+id).val();

                if(loanno!= "" && loantype!= "" && nic!= ""){ 
                
                 $.ajax({
                     type: "POST",
                     async:false,
                     url: "<?php echo url_for('loan/AjaxDeleteEmployeeGaranter') ?>",
                     data: { loantype : loantype ,loanno : loanno, nic : nic },
                     dataType: "json",
                     success: function(data){ 
                     }
                });
                }
                $("#row_"+id).remove();
                //total Number of Guarantors decrement by one
                noOfGuarantors--;
                $("#txtNoOfGuarantor").val(noOfGuarantors);
                
               
            }
            else{
                return false;
            } 

<?php } ?>
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
        getGuarantorData(myArr[0],"emp");      

    }
            
    //call to Guarantor Data method
    function SelectGuarantor(data){ 
        myArr = data.split('|');       
        getGuarantorData(myArr[0],"gra");      

    }
            
    function getGuarantorData(gid,type){
        // post(file, data, callback, type); (only "file" is required)
        $.post(

        "<?php echo url_for('loan/ajaxloadGuarantorDetails') ?>", //Ajax file
                
        { gid: gid },  // create an object will all values

        //function that is called when server returns a value.
        function(data){                      
            if(type == "emp"){
                $("#txtEmpNic").val(data[0]);
                $("#txtEmployeeId").val(data[3]);
                $("#txtEmployeeName").val(data[4]);
            }
            else if(type == "gra")
            {
                $("#txtIGuarantorNic").val(data[0]);
                $("#txtIGuarantorId").val(data[3]);
                $("#txtIFirstName").val(data[1]);
                $("#txtILastName").val(data[2]);
            }
        },
        //How you want the data formated when it is returned from the server.
        "json"

    );
    }
            
    function getGuarantorUpdateData(appId){
        // post(file, data, callback, type); (only "file" is required)
        $.post(
        
        "<?php echo url_for('loan/ajaxloadGuarantorDetailsUpdate') ?>", //Ajax file
                
        { appId: appId },  // create an object will all values

        //function that is called when server returns a value.
        function(data){         
   
            for(j=0; j < data.length; j++){
                // you have the data in the client for your array
                var data2 = new Array();
                if(data[j]['ln_gura_external_flg'] == "0"){
                    data2[0]='<? echo __("Internal") ?>';
                }
                else
                { 
                    data2[0]='<? echo __("External") ?>';
                }           

                data2[1]=data[j]['gura_nic_no'];
                data2[2]=data[j]['ln_gura_firstname'];
                data2[3]=data[j]['ln_gura_surname'];  
                data2[4]=data[j]['ln_gura_number'];
                setDataToGrid(data2);
                        
            }

        },
        //How you want the data formated when it is returned from the server.
        "json"

    );
    }
            
    function validateApplyAmouont(){
        //    alert($("#txtMaxLoanAmmount").val());
        //    alert($("#txtApplyAmount").val());
        if( $("#txtApplyAmount").val() > $("#txtMaxLoanAmmount").val())
        {
            return true;
        }
        else{
            return false;
        }
    }         
    
    function validateNIC(NIC){
        var NIC = NIC;
        var datalength=NIC.length;
        var user=new Array();
        for(var i=0; i<datalength; i++){
            user[i]=NIC[i]; 
        }
                
        var error2=0;
        for(var k=0; k<9; k++){
            if(isNaN(user[k])){
                error2++;
            }
        }
        if(error2 > 0){
            alert("<?php echo __("Invalid NIC") ?>");
            return false; 
        }
        if(user[9]!="X" && user[9]!="V" ){
            alert("<?php echo __("Invalid NIC") ?>");
            return false; 
        }
        return true; 
    }
    
    function validateGuarantorRequired(){
        if( $("#txtGuarantorflg").val() == 1)
        {
            return true;
        }
    }  
            
    $(document).ready(function() {
        $('#main-content1').width(1200);
        $('#dialog').hide();
        getGuarantorUpdateData($("#txtApplicationId").val());

        //Show and Hide Guarantor Details page Loading
        $("#internal").show();
        $("#external").hide();
         
        $("#txtApplyDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
        $("#txtEffectiveDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });

        validateYear('input[name="cmbYear"]');

        //load app
        $('#empRepPopBtn').click(function() {

            var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee&payroll=payroll'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
            if(!popup.opener) popup.opener=self;
            popup.focus();
        });
                
        //load app
        $('#empRepPopBtn2').click(function() {

            var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectGuarantor&payroll='); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
            if(!popup.opener) popup.opener=self;
            popup.focus();
        });
        
//        $('#frmledger').submit(function() {
//            submitTwoForms();
//            return false;
//        });

        
        
         $('#btnLedger').click(function() {
            if($("#txtNumOfInstallments").val()==""){
               alert("<?php echo "No Of Installment Can not Blank"; ?>");
            }else if($("#txtApplyAmount").val()==""){
               alert("<?php echo "Apply Amount Can not Blank"; ?>");
            }else if($("#txtEffectiveDate").val()==""){
               alert("<?php echo "Effective Date Can not Blank"; ?>");
            }else if($("#cmbLoantype").val()==""){
               alert("<?php echo "Loan Type Can not Blank"; ?>");
            }else if($("#txtEmployeeId").val()==""){
               alert("<?php echo "Please Select an Employee"; ?>");
            }else{
            var installment=$("#txtNumOfInstallments").val();
            var LoanAmount=$("#txtApplyAmount").val();
            var EffectiveDate=$("#txtEffectiveDate").val();
            var Loanno=$("#cmbLoantype").val();
            var empno=$("#txtEmployeeId").val();
            var Lnappno= $("#txtApplicationId").val();
            
//            var path = "<?php //echo public_path("../../symfony/web/index.php/loan/LedgerDisplay"); ?>"+"?installment="+installment+"&LoanAmount="+LoanAmount+"&EffectiveDate="+EffectiveDate+"&Loanno="+Loanno;
//            var popup=window.open(path,'Locations height=450,width=800,resizable=1,scrollbars=1');
//            if(!popup.opener) popup.opener=self;
//            popup.focus();
            
            var dhtml="";
            dhtml+="<div class='formpage4col' >";
            dhtml+="<div class='outerbox' style='width: 1150px'>";
            dhtml+="<div class='maincontent'>";
                   dhtml+="<form name='frmledger' id='frmledger' method='post' action='<?php echo url_for('loan/SaveApplication') ?>'>";           
                   dhtml+="<div id='employeeGrid' class='centerCol' style='margin-left:10px; margin-top: 8px; width: 1100px; border-style:  solid; border-color: #FAD163; '>";
                   dhtml+="<div style=''>";
                   dhtml+="<div class='centerCol' style='width:40px; background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:40px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;'><?php echo __("No") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px; background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;'><?php echo __("Date") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px; background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;'><?php echo __("Strating Balance") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px; background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;'><?php echo __("Capital") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px; background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;'><?php echo __("Interest") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;  background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Installment") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;  background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Cumilative Interest") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;   background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("End Balance") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;  background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Balance(R)") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;  background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Actual Payment") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;  background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Pay Chech No") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;  background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Pay Chech Date") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;  background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Recover Chech No") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:75px;  background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Recover Chech Date") ?></label>";
                   dhtml+="</div>";
                   dhtml+="<div class='centerCol' style='width:85px;   background-color:#FAD163;'>";
                   dhtml+="<label class='languageBar' style='width:75px; height: 25px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit'><?php echo __("Recover Amount") ?></label>";
                   dhtml+="</div>";

                   dhtml+="</div>";
                   dhtml+="<br class='clear'/>";           
                   dhtml+="<div id='tohide'>"; 
                   var i=0;
                   var j=0;
            $.ajax({
            type: "POST",
            async:false,
            url: "<?php echo url_for('loan/LedgerDisplay') ?>",
            data: { installment : installment,LoanAmount:LoanAmount, EffectiveDate : EffectiveDate, Loanno : Loanno , empno : empno, Lnappno : Lnappno},
            dataType: "json",
            success: function(data){
                $.each(data, function(key,value) { 
                    j=j+1;
                   
                                var strval=new String(value);
                                var word = new Array();
                                word=strval.split(",");
                                //console.log(word);
                                
                                if(j==1){
                                    $("#txtInstallmentAmount").val(word[4]);
                                }

                   dhtml+="<div id='row_"+i+"' style='padding-top:0px;'>";
                   dhtml+="<div class='centerCol' id='master' style='width:40px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:40px; color:#444444;' name='txtindex_"+i+"' id='txtindex_"+i+">' value='"+j+"'";
                   if(word[29]=="1"){ 
                       dhtml+="readonly='readonly'";
                      }
                   dhtml+="maxlength='10' /></div></div>";      
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtSheduleDate_"+i+"' id='txtSheduleDate_"+i+"' value='"+word[0]+"' <?php echo $disabled; ?>";
                   if(word[29]=="1"){ 
                       dhtml+="readonly='readonly'";
                      }
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtStratingBal_"+i+"' id='txtStratingBal_"+i+"' value='"+word[1]+"' <?php echo $disabled; ?>";
                   if(word[29]=="1"){ 
                       dhtml+="readonly='readonly'";
                      }
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtCapital_"+i+"' id='txtCapital_"+i+"' value='"+word[2]+"' <?php echo $disabled; ?>";
                   if(word[29]=="1"){ 
                       dhtml+="readonly='readonly'";
                      }
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtInterest_"+i+"' id='txtInterest_"+i+"' value='"+word[3]+"' <?php echo $disabled; ?>";
                   if(word[29]=="1"){ 
                       dhtml+="readonly='readonly'";
                      }
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtInstallment_"+i+"' id='txtInstallment_"+i+"' value='"+word[4]+"' <?php echo $disabled; ?>";
                   if(word[29]=="1"){ 
                       dhtml+="readonly='readonly'";
                      }
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtCumInterest_"+i+"' id='txtCumInterest_"+i+"' value='"+word[5]+"' <?php echo $disabled; ?>";
                   if(word[29]=="1"){ 
                       dhtml+="readonly='readonly'";
                      }
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtEndBalance_"+i+"' id='txtEndBalance_"+i+"' value='"+word[6]+"' <?php echo $disabled; ?>";
                   if(word[29]=="1"){ 
                       dhtml+="readonly='readonly'";
                      }
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtEndReal_"+i+"' id='txtEndReal_"+i+"' value='"+word[25]+"' <?php echo $disabled; ?>";
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtComPayment_"+i+"' id='txtComPayment_"+i+"' value='"+word[22]+"' <?php echo $disabled; ?>";
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtCheckNo_"+i+"' id='txtCheckNo_"+i+"' value='"+word[23]+"' <?php echo $disabled; ?>";
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtCheckDate_"+i+"' id='txtCheckDate_"+i+"' value='"+word[26]+"' <?php echo $disabled; ?>";
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtRCheckNo_"+i+"' id='txtRCheckNo_"+i+"' value='"+word[27]+"' <?php echo $disabled; ?>";
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtRCheckDate_"+i+"' id='txtRCheckDate_"+i+"' value='"+word[28]+"' <?php echo $disabled; ?>";
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="<div class='centerCol' id='master' style='width:75px;'>";
                   dhtml+="<div id='employeename' style='height:25px; padding-left:3px;'>";
                   dhtml+="<input type='text' calss='GridText' style='width:65px; color:#444444;' name='txtUserPayAmt_"+i+"' id='txtUserPayAmt_"+i+"' value='"+word[24]+"' <?php echo $disabled; ?>";
                   dhtml+="maxlength='10' /></div></div>";
                   dhtml+="</div>";
                   i=i+1;
                   
                   });
                   
                   
                dhtml+="<br> <input type='button' class='backbutton' id='btncal'value='<?php echo __("OK") ?>' onclick='calclick("+j+")'>";   
                dhtml+="</div>";
                dhtml+="</form>"; 
                   $('#test').html(dhtml);
            }
            });

              jQuery('#dialog').dialog('open');
            }
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
                txtUserApplicationId:{required: true,noSpecialCharsOnly: true,digits:true,maxlength:10},
                txtEmpNic: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtLoanName: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                cmbLoantype: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtEmployeeName: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtLoanTypeCode: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtInterestType: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtMaxLoanAmmount: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtMaxInstalment: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtNumOfInstallments: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtInstallmentAmount: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtApplyAmount: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtApplyDate:{required: true},
                txtEffectiveDate:{required: true}
                //                txtNoOfGuarantor: {required: true,noSpecialCharsOnly: false, maxlength:50 }
            },
            messages: {
                txtUserApplicationId:{required:"<?php echo __("This field is required.") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>",digits:"<?php echo __("This field contains invalid characters.") ?>",maxlength:"<?php echo __("Maximum 10 Characters") ?>"},
                txtEmpNic:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtLoanName:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                cmbLoantype:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtEmployeeName:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtLoanTypeCode:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtInterestType:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtMaxLoanAmmount:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtMaxInstalment:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtNumOfInstallments:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtInstallmentAmount:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtApplyAmount:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtApplyDate:{required:"<?php echo __("This field is required.") ?>"},
                txtEffectiveDate:{required:"<?php echo __("This field is required.") ?>"}


                //                txtNoOfGuarantor:{maxlength:"<?php echo __("Maximum 50 Characters") ?>"}                                       
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

                location.href="<?php echo url_for('loan/SaveApplication?appId=' . $encrypt->encrypt($updateApplication->ln_app_number) . '&lock=1') ?>";
            }
            else {
                if($("#txtApplyDate").val() > $("#txtEffectiveDate").val()){
                    alert("<?php echo __('Invalid Effective Date') ?>");
                    return false;
                }
                else if(Number($("#txtApplyAmount").val()) > Number($("#txtMaxLoanAmmount").val())){
           
                    alert("<?php echo __('Apply Amount shoud be less than or equal to Max Loan Amount.') ?>");
                    return false;
                }
                else if(Number($("#txtNumOfInstallments").val()) > Number($("#txtMaxInstalment").val())){
           
                    alert("<?php echo __('Number of Installment shoud be less than or equal to Max Installment.') ?>");
                    return false;
                }
                else if(($("#txtNoOfGuarantor").val().length == 0) && ($("#txtGuarantorflg").val() == "1")){
                 
                    alert("Please Add Guarantor Details.");
                }
                else{

                    $('#frmSave').submit();
                }
            }
        });

        //When click reset buton
        $("#btnClear").click(function() {
            if($("#frmSave").data('edit') != 1){
                location.href="<?php echo url_for('loan/SaveApplication') ?>";
            }else{
                document.forms[0].reset('');
            }
        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/loan/AppliedLoan')) ?>";
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
                    data[4]= -1;
                    setDataToGrid(data);
                }else{
                    alert("Please select Guaranter");
                }
            }
            else {             
                if(validateNIC($("#txtEGuarantorNic").val())){
                    if($("#txtEFirstName").val() == ""){
                        alert("Please Enter Guaranter Frist Name");                                     

                    }
                    else if(!isNaN($("#txtEFirstName").val())){
                        alert('Frist Name contains invalid characters.');
                    }      
                    else if($("#txtELastName").val() == ""){
                        alert("Please Enter Guaranter Last Name");                                     
                    }
                    else if(!isNaN($("#txtELastName").val())){
                        alert('Last Name contains invalid characters.');
                    }            
                    else {
                        var data = new Array(2);
                        data[0]="External";
                        data[1]=$("#txtEGuarantorNic").val();
                        data[2]=$("#txtEFirstName").val();
                        data[3]=$("#txtELastName").val()
                        data[4]= -1;
                        setDataToGrid(data);
                    }
                }             
            }
        });
    });
</script>
