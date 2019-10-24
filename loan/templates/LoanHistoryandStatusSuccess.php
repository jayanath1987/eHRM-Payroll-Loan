<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Loan History and Status") ?></h2></div>
        <?php echo message(); ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="">

            <div class="centerCol" style="padding-top: 5px;">
                <span style="padding-left: 25px;">
                    <input type="radio" name="optActiveInactivate" id="optActiveInactivate" class="optGuarantorType"  value="1" <?php
        if ($activeInactive == "activeIncative" && $activeInactiveValue == 1
        )
            echo "checked"
            ?>/><?php echo __("Active") ?>
                </span>
                <span style="padding-left: 87px;">
                    <input type="radio" name="optActiveInactivate" id="optActiveInactivate" class="optGuarantorType"  value="0" <?php
                           if ($activeInactive == "activeIncative" && $activeInactiveValue == 0
                           )
                               echo "checked"
            ?>/><?php echo __("Inactive") ?>
                    <br class="clear" />    
                </span>
                <span style="padding-left: 25px;">
                    <input type="radio" name="optEmpLoan" id="optEmpLoan" onclick="$('#emp').show() ,$('#loan').hide()" class="optGuarantorType"  value="0" <?php
                           if ($empLoan == "empLoan" && $empLoanValue == 0
                           )
                               echo "checked"
            ?>/><?php echo __("Employee Wise") ?>
                </span>
                <span style="padding-left: 35px;">
                    <input type="radio" name="optEmpLoan" id="optEmpLoan" onclick="($('#emp').hide(), $('#loan').show())" class="optGuarantorType"  value="1" <?php
                           if ($empLoan == "empLoan" && $empLoanValue == 1
                           )
                               echo "checked"
            ?>/><?php echo __("Loan Wise") ?>
                </span>
            </div>
            <br class="clear"/>    
            <input type="hidden" name="mode" value="search" />

            <div class="searchbox">
                <span id="loan"> 
                    <label for="searchMode"><?php echo __("Loan Name") ?></label>
                    <select name="cmbLoantype" id="cmbLoantype" class="" style="width: 160px;" tabindex="4">
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($loanTypeList as $LoanType) {
                            ?>
                            <option value="<?php echo $LoanType->ln_ty_number ?>" <?php
                        if ($LoanType->ln_ty_number == $searchValue) {
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
                </span>
                <span id="emp"> 
                    <label for="searchMode" style="width: 90px; " ><?php echo __("Employee NIC") ?>:</label>
                    <input type="text" size="20" style="margin-right: 10px;" readonly="true" name="txtEmpNic" id="txtEmpNic"  value="<?php
                        if ($empLoanValue != 1) {
                            echo $searchValue;
                        }
                        ?>" />
                    <input type="hidden" name="txtEmployeeId" id="txtEmployeeId" >
                    <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn"/>
                    <label for="txtSearchValue" style="margin: 0 3px 0 0;"><?php echo __("Employee Name") ?>:</label>
                    <input id="txtEmployeeName" style="margin-right: 10px;" name="txtEmployeeName" type="text" readonly="true" value="<?php
                           if ($empLoanValue != 1) {
                               echo $empName;
                           }
                        ?>" maxlength="100" />
                </span>
                <label for="txtSearchValue"></label>
                <label for="txtSearchValue"></label>
                <input type="button" class="plainbtn" id="btnSearch"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn" id="btnReset"
                       value="<?php echo __("Reset") ?>" />
                <br class="clear"/>    
            </div>
        </form>
        <div class="actionbar">
            <div class="noresultsbar"></div>
            <div class="pagingbar">
                <?php
                if (is_object($pglay)) {
                    if ($pglay->getPager()->haveToPaginate() == 1) {
                        echo $pglay->display();
                    }
                }
                ?>
            </div>

            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('admin/deleteClass') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="25">
                            <input type="checkbox" class="checkbox" name="chkAllCheck" value="" id="chkAllCheck" />
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('e.emp_nic_no', __('Loan Name'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('e.emp_display_name', __('Employee Number'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Employee Name'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Amount'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Balance Amount'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Instalment'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Balance Instalment'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Balance Interest'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Apply Date'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Effective Date'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                        <td scope="col">

                            <?php echo $sorter->sortLink('lt.ln_ty_name', __('Active'), '@LoanHistoryandStatus', ESC_RAW); ?>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $row = 0;
                    foreach ($loanLoanHistoryList as $LoanHistory) {
                        $cssClass = ($row % 2) ? 'even' : 'odd';
                        $row = $row + 1;
                        ?>
                        <tr class="<?php echo $cssClass ?>">
                            <td>
                                <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $appliedLoan->ln_app_number ?>' />
                            </td>                       
                            <td class="">
                                <?php
                                if ($Culture == 'en') {
                                    echo $LoanHistory->LoanType->ln_ty_name;
                                } elseif ($Culture == 'si') {
                                    if (($LoanHistory->LoanType->ln_ty_name_si) == null) {
                                        echo $LoanHistory->LoanType->ln_ty_name;
                                    } else {
                                        echo $LoanHistory->LoanType->ln_ty_name_si;
                                    }
                                } elseif ($Culture == 'ta') {
                                    if (($LoanHistory->LoanType->ln_ty_name_ta) == null) {
                                        echo $LoanHistory->LoanType->ln_ty_name;
                                    } else {
                                        echo $LoanHistory->LoanType->ln_ty_name_ta;
                                    }
                                }
                                ?>
                            </td>
                            <td class="">
                                <?php
                                echo $LoanHistory->Employee->employeeId;
                                ?>
                            </td>
                            <td class="">
                                <?php
                                if ($Culture == 'en') {
                                    echo $LoanHistory->Employee->emp_display_name;
                                } elseif ($Culture == 'si') {
                                    if (($LoanHistory->Employee->emp_display_name_si) == null) {
                                        echo $LoanHistory->Employee->emp_display_name;
                                    } else {
                                        echo $LoanHistory->Employee->emp_display_name_si;
                                    }
                                } elseif ($Culture == 'ta') {
                                    if (($LoanHistory->Employee->emp_display_name_ta) == null) {
                                        echo $LoanHistory->Employee->emp_display_name;
                                    } else {
                                        echo $LoanHistory->Employee->emp_display_name_ta;
                                    }
                                }
                                ?>
                            </td>
                            <td class="">
                                <?php
                                echo $LoanHistory->LoanHeader->ln_hd_amount;
                                ?>
                            </td>
                            <td class="">
                                <?php
                                echo $LoanHistory->LoanHeader->ln_hd_bal_amount;
                                ?>
                            </td>
                            <td class="">
                                <?php
                                echo $LoanHistory->LoanHeader->ln_hd_installment;
                                ?>
                            </td>
                            <td class="">
                                <?php
                                echo $LoanHistory->LoanHeader->ln_hd_bal_installment;
                                ?>
                            </td>
                            <td class="">
                                <?php
                                echo $LoanHistory->LoanType->ln_ty_interest_rate;
                                ?>                             
                            </td>
                            <td class="">
                                <?php
                                echo $LoanHistory->LoanHeader->ln_hd_apply_date;
                                ?>
                            </td>
                            <td class="">
                                <?php
                                echo $LoanHistory->LoanHeader->ln_hd_effective_date;
                                ?>
                            </td>
                            <td class="">
                                <?php
                                if ($LoanHistory->LoanHeader->ln_hd_is_active_flg == 1) {
                                    echo 'Active';
                                } else {
                                    echo 'Inactive';
                                }
                                ?>
                            </td>                           
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
         
   
    
    function SelectEmployee(data){
                               
        myArr = data.split('|');
        getEmpNic(myArr[0]);
        $('#txtEmployeeId').val(myArr[0]);
        $('#txtEmployeeName').val(myArr[1]);
        //        comDateValidation(myArr[0]);
       
                   
    }

    function getEmpNic(eid){
        //        alert(lid);
        // post(file, data, callback, type); (only "file" is required)
        $.post(

        "<?php echo url_for('loan/ajaxGetEmployeeId') ?>", //Ajax file

        { eid: eid },  // create an object will all values

        //function that is called when server returns a value.
        function(data){
            $('#txtEmpNic').val(data);
        },

        //How you want the data formated when it is returned from the server.
        "json"

    );
    }
    
    $(document).ready(function() {
       
        //load app
        $('#empRepPopBtn').click(function() {

            var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee&payroll=payroll'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
            if(!popup.opener) popup.opener=self;
            popup.focus();
        });

<?php if ($empLoanValue == 1) { ?>
            $('#emp').hide(); 
            $('#loan').show(); 
<?php } else { ?>
            $('#emp').show(); 
            $('#loan').hide(); 
<?php } ?>

            
        buttonSecurityCommon("btnAdd",null,null,"btnRemove");
        //When click add button
        $("#btnAdd").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/loan/SaveApplication')) ?>";

        });

        // When Click Main Tick box
        $("#chkAllCheck").click(function() {
            if ($('#chkAllCheck').attr('checked')){
                $('.innercheckbox').attr('checked','checked');
            }else{
                $('.innercheckbox').removeAttr('checked');
            }
        });

        $(".innercheckbox").click(function() {
            if($(this).attr('checked'))
            {

            }else
            {
                $('#chkAllCheck').removeAttr('checked');
            }
        });

        //When click remove button
        $("#btnRemove").click(function() {
            $("#mode").attr('value', 'delete');
            if($('input[name=chkLocID[]]').is(':checked')){
                answer = confirm("<?php echo __("Do you really want to delete?") ?>");
            } else {
                alert("<?php echo __("Select at least one check box to delete") ?>");
            }

            if (answer !=0 ) {
                $("#standardView").submit();
            } else {
                return false;
            }
        });

        //When click Search Button
        $("#btnSearch").click(function() {
            $("#mode").attr('value', 'save');

            var searchMode = $('#cmbSearchMode');

            if (searchMode.val() == 'all')  {
                alert('<?php echo __("Please select a field to search") ?>');
                searchMode.focus();
                return false;
            } else if ($('#txtSearchValue').val() == '')  {
                alert('<?php echo __("Please enter search value") ?>');
                searchMode.focus();
                return false;    
            } else {
                $('#frmSearchBox').submit();
                return true;
            }
        });

        //When click Save Button
        $("#btnReset").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/loan/LoanHistoryandStatus')) ?>";
        });

    });

</script>

