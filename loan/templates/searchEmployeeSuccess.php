<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Employee Search") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="">
            <input type="hidden" name="mode" value="search" />
            <div class="searchbox">
                <label for="cmbSearchMode"><?php echo __("Search By") ?></label>
                <select name="cmbSearchMode" id="cmbSearchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="id" <?php
        if ($searchMode == 'id') {
            echo "selected";
        }
        ?>><?php echo __("Employee ID") ?></option>
                    <option value="firstname" <?php
                    if ($searchMode == 'firstname') {
                        echo "selected";
                    }
        ?>><?php echo __("First Name") ?></option>
                    <option value="lastname" <?php
                            if ($searchMode == 'lastname') {
                                echo "selected";
                            }
        ?>><?php echo __("Last Name") ?></option>
                    <option value="designation" <?php
                            if ($searchMode == 'designation') {
                                echo "selected";
                            }
        ?>><?php echo __("Designation") ?></option>
                    <option value="service" <?php
                            if ($searchMode == 'service') {
                                echo "selected";
                            }
        ?>><?php echo __("Service") ?></option>
                    <option value="division" <?php
                            if ($searchMode == 'division') {
                                echo "selected";
                            }
        ?>><?php echo __("Division") ?></option>
                </select>

                <label for="txtSearchValue"><?php echo __("Search For:") ?></label>
                <input type="text" size="20" name="txtSearchValue" id="txtSearchValue" value="<?php echo $searchValue ?>" />
                <input type="button" class="plainbtn" id="btnSearch"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn" id="btnReset"
                       value="<?php echo __("Reset") ?>" />
                <br class="clear"/>
            </div>
        </form>
        <div class="actionbar">
                <?php if ($type == 'multiple') {
                    ?>
                <div class="actionbuttons">
                    <input type="button" class="plainbtn" id="btnSubmit"
                           value="<?php echo __("Submit") ?>" />
                </div>
<?php } ?>
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
        <form name="standardView" id="standardView" method="post" action="">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                            <?php if ($type == 'multiple') { ?>
                            <td width="50">
                                <input type="checkbox" class="checkbox" name="chkAllCheck" value="" id="chkAllCheck" />
                            </td>
<?php } ?>
                        <td scope="col">
                            <?php echo $sorter->sortLink('e.emp_number', __('Employee ID'), '@employee_search_loan', ESC_RAW); ?>
                        </td>
                        <td scope="col">
<?php echo $sorter->sortLink('e.emp_display_name', __('Employee Name'), '@employee_search_loan', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                    <?php echo $sorter->sortLink('j.name', __('Designation'), '@employee_search_loan', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                    <?php echo $sorter->sortLink('s.service_name', __('Service'), '@employee_search_loan', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                    <?php echo $sorter->sortLink('d.title', __('Division'), '@employee_search_loan', ESC_RAW); ?>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $row = 0;
                    foreach ($listEmployee as $employee) {
                        $cssClass = ($row % 2) ? 'even' : 'odd';
                        $row = $row + 1;

                        //Define data columns according culture
                        $employeeNameCol = ($userCulture == "en") ? "emp_display_name" : "emp_display_name_" . $userCulture;
                        $employeeName = $employee->Employee->$employeeNameCol == "" ? $employee->Employee->emp_display_name : $employee->Employee->$employeeNameCol;

                        $designationCol = ($userCulture == "en") ? "name" : "name_" . $userCulture;
                        $designation = $employee->Employee->jobTitle->$designationCol == "" ? $employee->Employee->jobTitle->name : $employee->Employee->jobTitle->$designationCol;

                        $serviceCol = ($userCulture == "en") ? "service_name" : "service_name_" . $userCulture;
                        $service = $employee->Employee->ServiceDetails->$serviceCol == "" ? $employee->Employee->ServiceDetails->service_name : $employee->Employee->ServiceDetails->$serviceCol;

                        $divisionCol = ($userCulture == "en") ? "title" : "title_" . $userCulture;
                        $division = $employee->Employee->subDivision->$divisionCol == "" ? $employee->Employee->subDivision->title : $employee->Employee->subDivision->$divisionCol;

                        $onclick = "empSelection(" . trim($employee->Employee->empNumber) . ", '" . $employeeName . "');";
                        ?>

                        <tr class="<?php echo $cssClass ?>">
    <?php if ($type == 'multiple') { ?>
                                <td >
                                    <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $employee->empNumber ?>' />
                                </td>
    <?php } ?>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $employee->Employee->employeeId ?></a>
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $employeeName ?></a>
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $designation ?></a>
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $service ?></a>
                            </td>
                            <td class="">
                                <a href="#" onclick="<?php echo $onclick; ?>"><?php echo $division ?></a>
                            </td>
                        </tr>
<?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">

    function empSelection(empNumber, empName) {
        var method = '<?php echo $method; ?>';
        data = empNumber + '|' + empName;

        eval('window.opener.' + method + '("' + data + '");');
        window.close();
    }

    $(document).ready(function() {

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

        //When click submit button
        $("#btnSubmit").click(function() {
            var method = '<?php echo $method; ?>';
        
            var values = new Array();
            $.each($("input[name='chkLocID[]']:checked"), function() {
                values.push($(this).val());
            });

            data = values.join("|");
            eval('window.opener.' + method + '("' + data + '");');
            
            if(values.length==0){
                alert("<?php echo __('Please Select at least one employee') ?>");
                return false;
            }else{
                window.close();
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
            } else {
                $('#frmSearchBox').submit();
                return true;
            }
        });

        //When click Reset Button
        $("#btnReset").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/pim/searchEmployee')) ?>";
        });


    });

</script>

<?php if ($type == 'single') {
    ?>
    <script type="text/javascript">
        $('a').click(function() {
            valueString = $(this).parent().children('input').filter(':hidden').val();
            data = valueString.split('|');

            var method = '<?php echo $method; ?>';
            eval('window.opener.' + method + '("' + data[0] + '","' + data[16] + '");');
            window.close();
        });

    </script>
<?php } ?>




