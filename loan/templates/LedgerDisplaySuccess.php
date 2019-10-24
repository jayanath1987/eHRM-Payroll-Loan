<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<div class="formpage4col"  >
<div class="outerbox" style="width: 1100px">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Applied Loan Summary") ?></h2></div>
        <?php echo message(); ?>
           <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform();">
           
             <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 1050px; border-style:  solid; border-color: #FAD163; ">
                    <div style="">
                        <div class="centerCol" style='width:40px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:40px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("No") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Date") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Strating Balance") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Capital") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px; background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Interest") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Installment") ?></label>
                        </div>
                        <div class="centerCol" style='width:110px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Cumilative Interest") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("End Balance") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Payment") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Chech No") ?></label>
                        </div>
                        <div class="centerCol" style='width:100px;   background-color:#FAD163;'>
                            <label class="languageBar" style="width:100px; height: 25px; padding-left: 0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Paid Amount") ?></label>
                        </div>

                    </div>
                        <br class="clear"/>           
                    <div id="tohide">
                       <?php
                       $i = 0;
               foreach($grid as $row){
                   //echo $EffectiveDate;
                   ?>
                  <div id="row_<?php echo $i; ?>" style='padding-top:0px;'>
                    <div class='centerCol' id='master' style='width:40px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:40px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $i+1; ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>      
                    <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[0] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                    <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[1] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                      <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[2] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                      <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[3] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                      <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[4] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                      <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[5] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                      <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[6] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                      <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[22] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                      <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[23] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                    <div class='centerCol' id='master' style='width:100px;'>
                    <div id='employeename' style='height:25px; padding-left:3px;'>
                        <input type='text' calss='GridText' style='width:90px; color:#444444;' name='txtGrade_<?php echo $i; ?>' id='txtGrade_<?php echo $i; ?>' value='<?php echo $row[24] ?>' <?php echo $disabled; ?>
                        maxlength='10' /></div></div>
                  </div>
                   <?php     
                   $i++;
               }
               
               ?>
<?php echo " Principle -> ".$grid[$j][17]." Interest -> ".$grid[$j][18]." Installment -> ".$grid[$j][19]." CumilativeIntrest -> ".$grid[$j][20]." EndBalance -> ".$grid[$j][21]; ?>
                    </div>
                    <br class="clear"/>
                </div>
    
               

        </form>
        <br class="clear"/>
    </div>
</div>
</div>    
<script type="text/javascript">
    $(document).ready(function() {

        });

</script>

