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

<div class="formpage4col" >
    <style type="text/css">
        div.formpage4col input[type="text"]{
            width: 180px;
        }
    </style>    
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Loan Type") ?></h2></div>
        <?php echo message(); ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("English") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Sinhala") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Tamil") ?></label>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLoancode"><?php echo __("Loan Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtLoancode"  name="txtLoancode" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_code ?>" maxlength="100" />
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLoanName"><?php echo __("Loan Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtLoanName"  name="txtLoanName" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_name ?>" maxlength="100" />
            </div>
            <div class="centerCol">
                <input id="txtLoanNamesi"  name="txtLoanNamesi" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_name_si ?>" maxlength="100" />
            </div>
            <div class="centerCol">
                <input id="txtLoanNameta"  name="txtLoanNameta" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_name_ta ?>" maxlength="100" />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtDescription"><?php echo __("Description") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id='txtDescription' name='txtDescription'  class="formTextArea"
                          rows="3" cols="20" tabindex="3" ><?php echo $updateLoanType->ln_ty_description ?></textarea>
            </div>
            <div class="centerCol">
                <textarea id='txtDescriptionSi' name='txtDescriptionsi'  class="formTextArea"
                          rows="3" cols="20" tabindex="3" ><?php echo $updateLoanType->ln_ty_description_si ?></textarea>
            </div>
            <div class="centerCol">
                <textarea id='txtDescriptionTa' name='txtDescriptionta'  class="formTextArea"
                          rows="3" cols="20" tabindex="3" ><?php echo $updateLoanType->ln_ty_description_ta ?></textarea>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Interest Calculation");?><br> <?php echo __("Method") ?> </label><span class="required">*</span>
            </div>
            <div class="centerCol">
                <select id='cmbCalculationMethod' name='cmbCalculationMethod'  class="formSelect" tabindex="4">
                    <option value=""<?php if ($updateLoanType->ln_ty_entitlement_type_flg == "0")
            echo "selected" ?> ><?php echo __("-----Select-----") ?></option>
                    <option value="1" <?php if ($updateLoanType->ln_ty_entitlement_type_flg == "1")
                                echo "selected" ?>><?php
                        echo __("Reducing Balance Equal Installments");
        ?></option>
                    <option value="2" <?php if ($updateLoanType->ln_ty_entitlement_type_flg == "2")
                            echo "selected" ?>><?php
                        echo __("Simple Interest");
        ?></option>
         <option value="3" <?php if ($updateLoanType->ln_ty_entitlement_type_flg == "3")
                            echo "selected" ?>><?php
                        echo __("PMT");
        ?></option>           
                </select>
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtMaxAmount"><?php echo __("Maximum Amount") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtMaxAmount"  name="txtMaxAmount" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_amount ?>" maxlength="100" />
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtMaxInstalment"><?php echo __("Maximum Installment") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtMaxInstalment"  name="txtMaxInstalment" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_max_installment ?>" maxlength="100" />
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label for="txtInterestType"><?php echo __("Interest Type") ?> <span class="required">*</span></label>
            </div>

            <div class="centerCol" style="padding-top: 7px; padding-left: 3px;">
                <input type="radio" name="optFixedPercentage" id="optFixed" onchange="optOption(this.id)" value="0" <?php
                        if ($updateLoanType->ln_ty_interest_type == 0
                        )
                            echo "checked"
            ?>/> <?php echo __("Fixed") ?>
            </div>
            <div class="centerCol" style="padding-top: 7px; padding-left: 3px;">
                <input type="radio" name="optFixedPercentage" id="optPercentage" onchange="optOption(this.id)"  value="1" <?php
                       if ($updateLoanType->ln_ty_interest_type == 1
                       )
                           echo "checked"
            ?>/><?php echo __("Percentage") ?>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Interest Rate %") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtInterestRate"  name="txtInterestRate" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_rate ?>" maxlength="100" />
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtFixedInterest"><?php echo __("Fixed Interest") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtFixedInterest"  name="txtFixedInterest" type="text"  class="formInputText" value="<?php echo $updateLoanType->ln_ty_interest_fixed_amt ?>" maxlength="100" />
            </div>

            <br class="clear"/>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("") ?></label>
            </div>
            <br class="clear"/>
            <div class="leftCol">               
                <label for="txtLocationCode"><?php echo __("Active Loan") ?><span class="required">*</span></label>
            </div>

            <div class="centerCol">
                <input type="checkbox" name="chkActiveLoan" id="chkActiveLoan" class="formCheckbox" value="1" <?php if ($updateLoanType->ln_ty_inactive_type_flg == 1) { ?>
                           checked="yes"
                       <?php } ?> />
            </div>
            <div class="centerCol">
                <label for="txtLocationCode"><?php echo __("Guarantor Required") ?></label>
                <input type="checkbox" name="chkGuarentorRequired" id="chkGuarentorRequired" class="formCheckbox" value="1" <?php if ($updateLoanType->ln_ty_app_req_flg == 1) { ?>
                           checked="yes"
                       <?php }
                       ?> />
            </div>
            <input type="hidden" name="txtHiddenLoanID" id="txtEmpId" value="<?php echo $updateLoanType->ln_ty_number ?>"/>&nbsp;

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
    function optOption(val){
     
        if(val == "optFixed"){
            $('#txtInterestRate').attr('disabled', true);
            $('#txtFixedInterest').removeAttr('disabled');
            $('#txtInterestRate').val("");
            //        }
            //        else if(val == "optPercentage"){
            //            $('#txtInterestRate').removeAttr('disabled');
            //            $('#txtFixedInterest').attr('disabled', true);
        }else{
            $('#txtInterestRate').removeAttr('disabled');
            $('#txtFixedInterest').attr('disabled', true);
            $('#txtFixedInterest').val("");
        }  
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
    
    $(document).ready(function() {

        $('#txtInterestRate').attr('disabled', true);
        $('#txtFixedInterest').removeAttr('disabled');
        
        validateYear('input[name="cmbYear"]');

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
                txtLoancode:{required: true,noSpecialCharsOnly: true,maxlength:50},
                txtLoanName: {required: true,noSpecialCharsOnly: true,  maxlength:50 },
                txtLoanNameSi: {noSpecialCharsOnly: false,noSpecialCharsOnly: true,  maxlength:50 },
                txtLoanNameTa: {noSpecialCharsOnly: false,noSpecialCharsOnly: true,  maxlength:50 },
                txtDescription: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtDescriptionSi: {noSpecialCharsOnly: false, maxlength:50 },
                txtDescriptionTa: {noSpecialCharsOnly: false, maxlength:50 },
                cmbCalculationMethod: {required: true , maxlength:50},
                txtMaxAmount: {required: true,noSpecialCharsOnly: false, maxlength:50, digits:true},
                txtMaxInstalment: {required: true,noSpecialCharsOnly: false,digits:true, maxlength:50 },
                optFixed: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                optPercentage: {required: true,noSpecialCharsOnly: false, maxlength:50 },
                txtInterestRate: {required: true, maxlength:50 ,number:true},
                txtFixedInterest: {required: true, maxlength:50 ,number:true },
                chkActiveLoan: {required: true,noSpecialCharsOnly: false, maxlength:50 }
                
                
            },
            messages: {
                txtLoancode:{required:"<?php echo __("This field is required.") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtLoanName:{required:"<?php echo __("This field is required.") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtLoanNameSi:{maxlength:"<?php echo __("Maximum 50 Characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtLoanNameTa:{maxlength:"<?php echo __("Maximum 50 Characters") ?>",noSpecialCharsOnly: "<?php echo __('This field contains invalid characters.') ?>"},
                txtDescription:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtDescriptionSi:{maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtDescriptionTa:{maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                cmbCalculationMethod:{required:"<?php echo __("This field is required.") ?>"},
                required:{required:"<?php echo __("This field is required.") ?>"},                
                txtMaxAmount:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>",digits:"<?php echo __("This field contains invalid Amount.") ?>"},
                txtMaxInstalment:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>",digits:"<?php echo __("This field contains invalid Instalment.") ?>"},
                optFixed:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                optPercentage:{required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>"},
                txtInterestRate:{required:"<?php echo __("This field is required.") ?>",number:"<?php echo __("This field contains invalid rate.") ?>"},
                txtFixedInterest:{required:"<?php echo __("This field is required.") ?>",number:"<?php echo __("This field contains fixed invalid Interest.") ?>"},
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

                location.href="<?php echo url_for('loan/SaveLoanType?loanId=' . $encrypt->encrypt($updateLoanType->ln_ty_number) . '&lock=1') ?>";
            }
            else {
                $('#frmSave').submit();
            }
        });

        //When click reset buton
        $("#btnClear").click(function() {
       
            if($("#frmSave").data('edit') != 1){
                location.href="<?php echo url_for('loan/SaveLoanType') ?>";
            }else{
                document.forms[0].reset('');
            }
        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/loan/LoanType')) ?>";
        });

    });
</script>
