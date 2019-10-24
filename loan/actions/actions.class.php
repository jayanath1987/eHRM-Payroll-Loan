<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
/**
 * Actions class for Performance module
 *
 * -------------------------------------------------------------------------------------------------------
 *  Author    - Givantha Kalansuriya
 *  On (Date) - 27 July 2011 
 *  Comments  - Loan Functions 
 *  Version   - Version 1.0
 * -------------------------------------------------------------------------------------------------------
 * */
include ('../../lib/common/LocaleUtil.php');

class loanActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    //LoanType
    public function executeLoanType(sfWebRequest $request) {//die(print_r($request->getParameter('searchValue')));

        try {
            $this->Culture = $this->getUser()->getCulture();
            $loanService = new LoanService();

            $this->sorter = new ListSorter('LoanType', 'loan', $this->getUser(), array('ln.ln_ty_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('loan/LoanType');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'ln.ln_ty_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $loanService->searchLoanType($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->LoanTypeList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveLoanType(sfWebRequest $request) {
        //Table Lock code is Open
        $encrypt = new EncryptionHandler();
        $this->userCulture = $this->getUser()->getCulture();
        try {
            if (!strlen($request->getParameter('lock'))) {
                $this->mode = 0;
            } else {
                $this->mode = $request->getParameter('lock');
            }
            $loanLockid = $encrypt->decrypt($request->getParameter('loanId'));

            if (isset($this->mode)) {
                if ($this->mode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_ln_type', array($loanLockid), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {

                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_ln_type', array($loanLockid), 1);
                    $this->mode = 0;
                }
            }
            $loanService = new LoanService();

            $loanTypeId = $request->getParameter('loanId');
            if (strlen($loanTypeId)) {
                $loanTypeId = $encrypt->decrypt($request->getParameter('loanId'));
                if (!strlen($this->mode)) {
                    $this->mode = 0;
                }
                $this->updateLoanType = $loanService->readLoanType($loanTypeId);
                if (!$this->updateLoanType) {
                    $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                    $this->redirect('loan/LoanType');
                }
            } else {
                $this->mode = 1;
            }
            $updateUser = $_SESSION['empNumber'];
            $updateDate = Date('Y-m-d');

            if ($request->isMethod('post')) {


                if (strlen($request->getParameter('txtHiddenLoanID'))) {
                    $loanType = $loanService->readLoanType($request->getParameter('txtHiddenLoanID'));
                } else {
                    $loanType = new LoanType();
                }
                if (strlen($request->getParameter('txtLoancode'))) {
                    $loanType->setLn_ty_code(trim($request->getParameter('txtLoancode')));
                } else {
                    $loanType->setLn_ty_code(null);
                }
                if (strlen($request->getParameter('txtLoanName'))) {
                    $loanType->setLn_ty_name(trim($request->getParameter('txtLoanName')));
                } else {
                    $loanType->setLn_ty_name(null);
                }
                if (strlen($request->getParameter('txtLoanNamesi'))) {
                    $loanType->setLn_ty_name_si(trim($request->getParameter('txtLoanNamesi')));
                } else {
                    $loanType->setLn_ty_name_si(null);
                }
                if (strlen($request->getParameter('txtLoanNameta'))) {
                    $loanType->setLn_ty_name_ta(trim($request->getParameter('txtLoanNameta')));
                } else {
                    $loanType->setLn_ty_name_ta(null);
                }
                if (strlen($request->getParameter('txtDescription'))) {
                    $loanType->setLn_ty_description(trim($request->getParameter('txtDescription')));
                } else {
                    $loanType->setLn_ty_description(null);
                }
                if (strlen($request->getParameter('txtDescriptionsi'))) {
                    $loanType->setLn_ty_description_si(trim($request->getParameter('txtDescriptionsi')));
                } else {
                    $loanType->setLn_ty_description_si(null);
                }
                if (strlen($request->getParameter('txtDescriptionta'))) {
                    $loanType->setLn_ty_description_ta(trim($request->getParameter('txtDescriptionta')));
                } else {
                    $loanType->setLn_ty_description_ta(null);
                }
                if (($request->getParameter('cmbCalculationMethod')) != null) {
                    $loanType->setLn_ty_entitlement_type_flg(trim($request->getParameter('cmbCalculationMethod')));
                } else {
                    $loanType->setLn_ty_entitlement_type_flg(null);
                }
                if ($updateDate != null) {
                    $loanType->setLn_ty_modified_date($updateDate);
                } else {
                    $loanType->setLn_ty_modified_date(null);
                }
                if ($updateUser != null) {
                    $loanType->setLn_ty_modified_user($updateUser);
                } else {
                    $loanType->setLn_ty_modified_user("admin");
                }
                if (($request->getParameter('txtMaxAmount')) != null) {
                    $loanType->setLn_ty_amount(trim($request->getParameter('txtMaxAmount')));
                } else {
                    $loanType->setLn_ty_amount(null);
                }
                if (($request->getParameter('txtMaxInstalment')) != null) {
                    $loanType->setLn_ty_max_installment(trim($request->getParameter('txtMaxInstalment')));
                } else {
                    $loanType->setLn_ty_max_installment(null);
                }
                if (($request->getParameter('optFixedPercentage')) != null) {
                    $loanType->setLn_ty_interest_type(trim($request->getParameter('optFixedPercentage')));
                } else {
                    $loanType->setLn_ty_interest_type(null);
                }
                if (($request->getParameter('txtInterestRate')) != null) {
                    $loanType->setLn_ty_interest_rate(trim($request->getParameter('txtInterestRate')));
                } else {
                    $loanType->setLn_ty_interest_rate(null);
                }
                if (($request->getParameter('txtFixedInterest')) != null) {
                    $loanType->setLn_ty_interest_fixed_amt(trim($request->getParameter('txtFixedInterest')));
                } else {
                    $loanType->setLn_ty_interest_fixed_amt(null);
                }
                if (($request->getParameter('chkActiveLoan')) != null) {
                    $loanType->setLn_ty_inactive_type_flg(trim($request->getParameter('chkActiveLoan')));
                } else {
                    $loanType->setLn_ty_inactive_type_flg(null);
                }
                if (($request->getParameter('chkGuarentorRequired')) != null) {
                    $loanType->setLn_ty_app_req_flg(trim($request->getParameter('chkGuarentorRequired')));
                } else {
                    $loanType->setLn_ty_app_req_flg(null);
                }
                $loanService->saveLoanType($loanType);
                if (strlen($loanTypeId)) {
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                    $this->redirect('loan/SaveLoanType?loanId=' . $loanTypeId . '&lock=0');
                } else {
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                    $this->redirect('loan/LoanType');
                }
            }
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanType');
        } catch (sfStopException $sf) {
            $this->redirect('loan/LoanType');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanType');
        }
    }

    public function executeAppliedLoan(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $loanService = new LoanService();

            $this->sorter = new ListSorter('LoanApplication', 'loan', $this->getUser(), array('la.ln_app_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('loan/AppliedLoan');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'la.ln_app_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $loanService->searchAppliedLoans($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->appliedLoanList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveApplication(sfWebRequest $request) {
        //Table Lock code is Open
        $encrypt = new EncryptionHandler();
        $this->Culture = $this->getUser()->getCulture();

        try {
            if (!strlen($request->getParameter('lock'))) {
                $this->mode = 0;
            } else {
                $this->mode = $request->getParameter('lock');
            }
            $loanLockid = $encrypt->decrypt($request->getParameter('appId'));

            if (isset($this->mode)) {
                if ($this->mode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_ln_application', array($loanLockid), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {

                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_ln_application', array($loanLockid), 1);
                    $this->mode = 0;
                }
            }

            $loanService = new LoanService();
            $this->loanTypeList = $loanService->getLoanTypeList();

            $applicationId = $request->getParameter('appId');
            if (strlen($applicationId)) {
                $applicationId = $encrypt->decrypt($request->getParameter('appId'));
                if (!strlen($this->mode)) {
                    $this->mode = 0;
                }

                $this->updateApplication = $loanService->readLoanApplication($applicationId);
                $this->loanType = $loanService->readLoanType($this->updateApplication->ln_ty_number);
                $this->appliedEmployee = $loanService->readEmployee($this->updateApplication->emp_number);
                $this->guarantorList = $loanService->getGuaranteeList($applicationId);

                if (!$this->updateApplication) {
                    $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                    $this->redirect('loan/AppliedLoan');
                }
                if($this->mode == 1){
                $ProccesedorSetteled=$loanService->getLoanDetails($this->updateApplication->emp_number,$this->updateApplication->ln_app_number,$this->updateApplication->ln_ty_number);
//                if($ProccesedorSetteled->ln_hd_installment != $ProccesedorSetteled->ln_hd_bal_installment){
//                    $this->setMessage('WARNING', array($this->getContext()->geti18n()->__("Loan can not edit processed or settled.")));
//                    $this->redirect('loan/SaveApplication?appId=' . $encrypt->encrypt($applicationId) . '&lock=0');
//                }
                    
                }
            } else {
                $this->mode = 1;
                $LoanMaxID=$loanService->getMaxLoanAppID();
                $this->LoanMaxID=$LoanMaxID[0]['MAX']+1;
            }


            if ($request->isMethod('post')) { //die(print_r($_POST));

                if (strlen($request->getParameter('txtApplicationHiddenId'))) {
                    $application = $loanService->readLoanApplication($request->getParameter('txtApplicationHiddenId'));
                } else {

                    $application = new LoanApplication();
                    if (strlen($request->getParameter('txtApplicationId'))) {
                        $application->setLn_app_number(trim($request->getParameter('txtApplicationId')));
                    } else {
                        $application->setLn_app_number(null);
                    }
                    if (strlen($request->getParameter('cmbLoantype'))) {
                        $application->setLn_ty_number(trim($request->getParameter('cmbLoantype')));
                    } else {
                        $application->setLn_ty_number(null);
                    }
                }
                
                if (strlen($request->getParameter('txtEmployeeId'))) {
                    $application->setEmp_number(trim($request->getParameter('txtEmployeeId')));
                } else {
                    $application->setEmp_number(null);
                }
                if (strlen($request->getParameter('txtInstallmentAmount'))) {
                    $application->setLn_app_install_amount(trim($request->getParameter('txtInstallmentAmount')));
                } else {
                    $application->setLn_app_install_amount(null);
                }
                if (strlen($request->getParameter('txtInstallmentAmount'))) {
                    $application->setLn_app_installment(trim($request->getParameter('txtInstallmentAmount')));
                } else {
                    $application->setLn_app_installment(null);
                }
                if (strlen($request->getParameter('txtNumOfInstallments'))) {
                    $application->setLn_app_no_of_Installments(trim($request->getParameter('txtNumOfInstallments')));
                } else {
                    $application->setLn_app_no_of_Installments(null);
                }
                if (strlen($request->getParameter('txtApplyAmount'))) {
                    $application->setLn_app_amount(trim($request->getParameter('txtApplyAmount')));
                } else {
                    $application->setLn_app_amount(null);
                }
                if (strlen($request->getParameter('txtApplyDate'))) {
                    $application->setLn_app_date(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtApplyDate')));
                } else {
                    $application->setLn_app_date(null);
                }
                if (strlen($request->getParameter('txtEffectiveDate'))) {
                    
                    $application->setLn_app_effective_date(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtEffectiveDate')));
                } else {
                    $application->setLn_app_effective_date(null);
                }
                if (strlen($request->getParameter('txtUserApplicationId'))) {
                        $application->setLn_app_user_number(trim($request->getParameter('txtUserApplicationId')));
                    } else {
                        $application->setLn_app_user_number(null);
                    }
                
                $loanService->saveLoanApplication($application);

                $lastLoanAppId = $application->ln_app_number;
                $lastLoantypeId = $application->ln_ty_number;

                $noOfGuarantor = $request->getParameter('txtNoOfGuarantor');

                //save Guarantor Details
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                for ($i = 0; $i < $noOfGuarantor; $i++) {
                    if ($_POST['guarantorId'][$i] == "-1") {
                        $guarantor = new LoanGuarantee();
                        $guarantor->setLn_app_number($lastLoanAppId);
                        $guarantor->setLn_ty_number($lastLoantypeId);
                        $guarantor->setGura_nic_no($_POST['guarantorNic'][$i]);
                        $guarantor->setLn_gura_firstname($_POST['guarantorFirstName'][$i]);
                        $guarantor->setLn_gura_surname($_POST['guarantorLastName'][$i]);
                        if ($_POST['guarantorType'][$i] == "Internal") {
                            $guarantor->setLn_gura_external_flg(0);
                        } else {
                            $guarantor->setLn_gura_external_flg(1);
                        }
                    } else {
                        $guarantor = $loanService->readGuarantee($_POST['guarantorId'][$i]);
                        $guarantor->setGura_nic_no($_POST['guarantorNic'][$i]);
                        $guarantor->setLn_gura_firstname($_POST['guarantorFirstName'][$i]);
                        $guarantor->setLn_gura_surname($_POST['guarantorLastName'][$i]);
                        if ($_POST['guarantorType'][$i] == "Internal") {
                            $guarantor->setLn_gura_external_flg(0);
                        } else if ($_POST['guarantorType'][$i] == "External") {
                            $guarantor->setLn_gura_external_flg(1);
                        }
                    }
                    $loanService->saveGuarantee($guarantor);
                }
                $conn->commit();

                if ($request->getParameter('txtApplicationHiddenId') == null) {
                    $InstallmentType = trim($request->getParameter('optInstallment'));
                  
                    //save Loan Header Details
                    $this->setLoanHeader($application);
                    //save Loane Shedule Details                                    
                    //$this->setLoanShedule($application);
///----------                    

                    $loanService = new LoanService();

                    $loanType = $loanService->readLoanType($application->ln_ty_number);
                    $loanHeader = $loanService->readLoanHeader($application->ln_app_number);

                    $noOfInstallment = $request->getParameter('txtNumOfInstallments');
                    $loanAmount = $request->getParameter('txtApplyAmount');
                    $interestRate = $request->getParameter('txtInterestRate');
                    $interestType = $loanType->ln_ty_interest_type;
                    $monthlyInstalment = $request->getParameter('txtInstallmentAmount');
                    $appLnNumber=$request->getParameter('txtApplicationId');
                    $monthlyInstalmentGap = 0;
                    $loanAmountWithInterest="";
           
               for ($t = 1; $t <= $noOfInstallment; $t++) {
                   $u = $t - 1;

                $loanShedule = new LoanSchedule();

                if ($application->emp_number != null) { 
                    $loanShedule->setEmp_number(trim($request->getParameter('txtEmployeeId')));
                } else { 
                    $loanShedule->setEmp_number(null);
                }
                
//                $loanShedule->setLn_sch_ins_no($t);
//                $loanShedule->setLn_ty_number($saveloanApplication->ln_ty_number);
//                $loanShedule->setLn_hd_sequence($loanHeader->ln_hd_sequence);
//                $loanShedule->setLn_sch_cap_amt($monthlyCapital);
//                if ($t == $noOfInstallment && $InstallmentGap != 0) {
//                    $loanShedule->setLn_sch_inst_amount(round($monthlyInstalment + $InstallmentGap, 2));
//                } else {
//                    $loanShedule->setLn_sch_inst_amount(round($monthlyInstalment, 2));
//                }
//                $loanShedule->setLn_sch_inst_rate($interestRate);
              
                $loanShedule->setLn_sch_ins_no($_POST["txtindex_{$u}"]);
                $loanShedule->setLn_ty_number($request->getParameter('txtApplicationId'));
                $loanShedule->setLn_hd_sequence($loanHeader->ln_hd_sequence);
                $loanShedule->setLn_sch_cap_amt($_POST["txtCapital_{$u}"]);
                $loanShedule->setLn_sch_inst_amount(round($_POST["txtInstallment_{$u}"], 2));
                $loanShedule->setLn_sch_inst_rate($interestRate);
                $loanShedule->setLn_starting_bal_amt($_POST["txtStratingBal_{$u}"]);///
                $loanShedule->setLn_intrest_amt($_POST["txtInterest_{$u}"]);
                $loanShedule->setLn_cum_interest_amt($_POST["txtCumInterest_{$u}"]);                        
                $loanShedule->setLn_end_bal_amt($_POST["txtEndBalance_{$u}"]);
//                if($_POST["txtComPayment_{$u}"]!= null){
//                $loanShedule->setLn_pay_by_com($_POST["txtComPayment_{$u}"]);
//                }
                if($_POST["txtUserPayAmt_{$u}"]!= null){
                $loanShedule->setLn_usr_pay_amt($_POST["txtUserPayAmt_{$u}"]);
                }
                $loanShedule->setLn_check_no($_POST["txtCheckNo_{$u}"]);
                if($_POST["txtCheckDate_{$u}"]!= null){
                $loanShedule->setLn_bal_pay_com_date($_POST["txtCheckDate_{$u}"]);
                }
                $loanShedule->setLn_pay_sch_date($_POST["txtSheduleDate_{$u}"]);
//----
  if($u == 0){ die(print_r($_POST["txtStratingBal_0"]."-".$_POST["txtComPayment_0"]));
  if($_POST["txtStratingBal_0"]!= $_POST["txtComPayment_0"]){ die("AA");
      $RealBal= $_POST["txtComPayment_0"]-$_POST["txtCapital_0"];      
      $loanShedule->setLn_end_bal_r_amt($RealBal);
  }else{die("AB");
    $loanShedule->setLn_end_bal_r_amt($_POST["txtEndReal_{$u}"]);
    $RealBal=$_POST["txtEndReal_{$u}"];
  }
  
  }else{ die("B");
      if($_POST["txtComPayment_{$u}"]!= null){
          $RealBal+= $_POST["txtComPayment_{$u}"];
      }
      
      $x= $u - 1;
      $RealBal= $_POST["txtEndReal_{$x}"]-$_POST["txtCapital_{$u}"];
      $loanShedule->setLn_end_bal_r_amt($RealBal);
  }              
//----                
///                $loanShedule->setLn_end_bal_r_amt($_POST["txtEndReal_{$u}"]);
                $loanShedule->setLn_pay_check_no($_POST["txtRCheckNo_{$u}"]);


                
                $loanShedule->setLn_st_number(null);
                $loanShedule->setLn_sch_is_processed(null);

                $loanShedule->setLn_sch_proc_to_date(null);
                $loanShedule->setLn_sch_proc_from_date(null);
                $loanShedule->setLn_app_number($appLnNumber);
                  //$loanAmountWithInterest=$loanAmountWithInterest+$monthlyInstalment;
                $loanService->saveLoanShedule($loanShedule);
                }
                    
///----------                    
                    
                }else{

                
                $this->setLoanHeader($application);
                }

               
                if (strlen($applicationId)) {
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                    $this->redirect('loan/SaveApplication?appId=' . $applicationId . '&lock=0');
                } else {
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                    $this->redirect('loan/AppliedLoan');
                }
            }
        }
        catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/AppliedLoan');
        }
        catch (sfStopException $sf) {
            //$this->redirect('loan/AppliedLoan');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/AppliedLoan');
        }
    }

    public function setLoanShedule(LoanApplication $saveloanApplication) {

        $encrypt = new EncryptionHandler();
        $this->userCulture = $this->getUser()->getCulture();
        try {
            $loanService = new LoanService();

            $loanType = $loanService->readLoanType($saveloanApplication->ln_ty_number);
            $loanHeader = $loanService->readLoanHeader($saveloanApplication->ln_app_number);

            $noOfInstallment = $saveloanApplication->ln_app_no_of_Installments;
            $loanAmount = $saveloanApplication->ln_app_amount;
            $interestRate = $loanType->ln_ty_interest_rate;
            $interestType = $loanType->ln_ty_interest_type;
            $monthlyInstalment = $saveloanApplication->ln_app_install_amount;
            $appLnNumber=$saveloanApplication->ln_app_number;
            $monthlyInstalmentGap = 0;
            $loanAmountWithInterest="";
            //check loan Type Interest Type
                 
            if ($loanType->ln_ty_interest_type == 0) {
                
                $fixedInterest = $loanType->ln_ty_interest_fixed_amt;
                
                if($loanType->ln_ty_entitlement_type_flg == 3 ){
//                    $rate = $fixedInterest;
//                    $months = $noOfInstallment;
//                    $base = $loanAmount;
//                    $FinalAmout=(($rate + ($rate / (((1+$rate)^$months)- 1))) * $base);
                    
                }else{
               
                
                //Fixed Interest Type 
                $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                $monthlyInstalment = $loanService->getFixedInstalment($monthlyCapital, $fixedInterest);
                }

            } else if ($loanType->ln_ty_interest_type == 1) {
                //Percentage Type
                if ($loanType->ln_ty_entitlement_type_flg == 2) {
                    //Calculate SimpleInstalment get Month Installment 
                    $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                    $monthlyInstalment = $loanService->getSimpleInstalment($loanAmount, $monthlyCapital, $interestRate, $noOfInstallment);
                } else if ($loanType->ln_ty_interest_type == 1) {
                    //Calculate Equal Balance Balance get Month Installment 
                    $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                    $monthlyInstalment = $loanService->getMonthlyInstalment($loanAmount, $monthlyCapital, $interestRate, $noOfInstallment);
                }
            }

            for ($t = 1; $t <= $noOfInstallment; $t++) {

                $loanShedule = new LoanSchedule();

                if ($saveloanApplication->emp_number != null) {
                    $loanShedule->setEmp_number($saveloanApplication->emp_number);
                } else {
                    $loanShedule->setEmp_number(null);
                }
                $loanShedule->setLn_sch_ins_no($t);
                $loanShedule->setLn_ty_number($saveloanApplication->ln_ty_number);
                $loanShedule->setLn_hd_sequence($loanHeader->ln_hd_sequence);
                $loanShedule->setLn_sch_cap_amt($monthlyCapital);
                if ($t == $noOfInstallment && $InstallmentGap != 0) {
                    $loanShedule->setLn_sch_inst_amount(round($monthlyInstalment + $InstallmentGap, 2));
                } else {
                    $loanShedule->setLn_sch_inst_amount(round($monthlyInstalment, 2));
                }
                $loanShedule->setLn_sch_inst_rate($interestRate);
                $loanShedule->setLn_st_number(null);
                $loanShedule->setLn_sch_is_processed(null);

                $loanShedule->setLn_sch_proc_to_date(null);
                $loanShedule->setLn_sch_proc_from_date(null);
                $loanShedule->setLn_app_number($appLnNumber);
                  $loanAmountWithInterest=$loanAmountWithInterest+$monthlyInstalment;
                $loanService->saveLoanShedule($loanShedule);
            }
//                $saveloanApplication->setLn_hd_bal_amount($loanAmountWithInterest);
//                $saveloanApplication->save();
                 
            if (strlen($loanHeaderId)) {
                $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                $this->redirect('loan/SaveLoanType?loanId=' . $loanTypeId . '&lock=0');
            } else {
                $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                $this->redirect('loan/SaveLoanApplication');
            }
//            }
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/SaveLoanApplication');
        } catch (sfStopException $sf) {
            $this->redirect('loan/SaveLoanApplication');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/SaveLoanApplication');
        }
    }

    public function setLoanHeader($saveloanApplication) {

        $encrypt = new EncryptionHandler();
        $this->userCulture = $this->getUser()->getCulture();
        try {
            $loanHeaderId = $saveloanApplication->ln_app_number;

            if (isset($this->mode)) {
                if ($this->mode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_ln_header', array($loanHeaderId), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {

                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_ln_header', array($loanHeaderId), 1);
                    $this->mode = 0;
                }
            }
            $loanService = new LoanService();

            if (strlen($loanHeaderId)) {
                if (!strlen($this->mode)) {
                    $this->mode = 0;
                }
                $this->updateLoanType = $loanService->readLoanType($loanHeaderId);
            } else {
                $this->mode = 1;
            }
            $loanType = $loanService->readLoanType($saveloanApplication->ln_ty_number);
            $fixedInterest = $loanType->ln_ty_interest_fixed_amt;
            $monthlyInstalment = $saveloanApplication->ln_app_install_amount;
            $Amount = $saveloanApplication->ln_app_amount;
            if ($InstallmentType == 0) {
                $noOfInstallment = $saveloanApplication->ln_app_no_of_Installments;
            } else {
                $noOfInstallment = round($loanService->getFixedInstalmentbyAmountNumberOfInstallment($Amount, $fixedInterest, $monthlyInstalment));
            }

            if ($saveloanApplication != null) {
                
                $loanHeader = $loanService->readLoanHeader($saveloanApplication->ln_app_number);
              
                if ($loanHeader) {
                    $loanHeader = $loanService->readLoanHeader($saveloanApplication->ln_app_number);
                } else {
                $loanHeader = new LoanHeader();
                          $lastSequencenumber=$loanService->readLastSequenceNumber($saveloanApplication->emp_number);
//
                $loanHeader->setLn_hd_sequence($lastSequencenumber[0][maxSequence]+1);
                }
// echo $loanHeader->ln_hd_effective_date; die;
               // $loanHeader->setLn_hd_effective_date($saveloanApplication->ln_app_effective_date);

                if ($saveloanApplication->ln_app_number != null) {
                    $loanHeader->setLn_app_number($saveloanApplication->ln_app_number);
                } else {
                    $loanHeader->setLn_app_number(null);
                }
                if ($saveloanApplication->ln_ty_number != null) {
                    $loanHeader->setLn_ty_number($saveloanApplication->ln_ty_number);
                } else {
                    $loanHeader->setLn_ty_number(null);
                }
                if ($saveloanApplication->emp_number != null) {
                    $loanHeader->setEmp_number($saveloanApplication->emp_number);
                } else {
                    $loanHeader->setEmp_number(null);
                }
                if ($saveloanApplication->ln_app_amount != null) {
                    $loanHeader->setLn_hd_amount($saveloanApplication->ln_app_amount);
                } else {
                    $loanHeader->setLn_hd_amount(null);
                }
                if ($saveloanApplication->ln_app_effective_date != null) {

                    $loanHeader->setLn_hd_effective_date($saveloanApplication->ln_app_effective_date);
                } else {
                    //$loanHeader->setLn_hd_effective_date('0000-00-00');
                }
                if ($saveloanApplication->ln_app_date != null) {
                    $loanHeader->setLn_hd_apply_date($saveloanApplication->ln_app_date);
                } else {
                    //$loanHeader->setLn_hd_apply_date('0000-00-00');
                }

                if ($saveloanApplication->ln_app_amount != null) {
                    $loanHeader->setLn_hd_installment($noOfInstallment);
                } else {
                    $loanHeader->setLn_hd_installment(null);
                }
                if ($saveloanApplication->ln_app_amount != null) {
                    $loanHeader->setLn_hd_bal_installment($noOfInstallment);
                } else {
                    $loanHeader->setLn_hd_bal_installment(null);
                }
                if ($saveloanApplication->ln_app_amount != null) {
                    $loanHeader->setLn_hd_bal_amount($saveloanApplication->ln_app_amount);
                } else {
                    $loanHeader->setLn_hd_bal_amount(null);
                }
               // $loanHeaderCheck = $loanService->readLoanHeader($saveloanApplication->ln_app_number);
//                 if (!$loanHeaderCheck) {
//                $lastSequencenumber=$loanService->readLastSequenceNumber($saveloanApplication->emp_number);
//
//                $loanHeader->setLn_hd_sequence($lastSequencenumber[0][maxSequence]+1);
//
//                 }
                $loanHeader->setLn_hd_is_active_flg(1);
                $loanHeader->setLn_hd_settled_flg(0);
//                $loanHeader->setApp_approved(1);

                $loanHeader->setLn_hd_lst_proc_to_date(null);
                $loanHeader->setLn_hd_inactive_period(null);
                $loanHeader->setLn_hd_install_amount(null);
                $loanHeader->setLn_hd_app_date(null);
                $loanHeader->setCancel_approved(null);

                $loanService->saveLoanHeader($loanHeader);
            }
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanType');
        } catch (sfStopException $sf) {
            $this->redirect('loan/LoanType');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanType');
        }
    }

    public function executeAjaxloadGuarantorDetails(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $id = $request->getParameter('gid');

        $loanService = new LoanService();
        $this->guarantor = $loanService->getGuarantorDetails($id);
        $arr = Array();

        foreach ($this->guarantor as $row) {

            $arr[0] = $row['emp_nic_no'];
            $firstName = "firstName_" . $Culture;
            if ($row[$firstName] == null) {
                $firstName = "firstName";
            } else {
                $firstName = "firstName_" . $Culture;
            }
            $lastName = "lastName_" . $Culture;
            if ($row[$lastName] == null) {
                $lastName = "lastName";
            } else {
                $lastName = "lastName_" . $Culture;
            }
            $displayName = "emp_display_name_" . $Culture;
            if ($row[$displayName] == null) {
                $displayName = "emp_display_name";
            } else {
                $displayName = "emp_display_name_" . $Culture;
            }
            $arr[1] = $row[$firstName];
            $arr[2] = $row[$lastName];
            $arr[3] = $row['empNumber'];
            $arr[4] = $row[$displayName];
        }
        echo json_encode($arr);
        die;
    }

    public function executeAjaxloadGuarantorDetailsUpdate(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $id = $request->getParameter('appId');

        $loanService = new LoanService();
        $this->guarantor = $loanService->getGuaranteeList($id);
        echo json_encode($this->guarantor);
        die;
    }

    public function executeAjaxLoadLoanTypeCode(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $lid = $request->getParameter('loanId');
        $loanService = new LoanService();
        $this->loanType = $loanService->getLoanTypebyID($lid);
        $arr = Array(5);
        foreach ($this->loanType as $row) {
            $arr[0] = $row['ln_ty_code'];
            $arr[1] = $row['ln_ty_max_installment'];
            $arr[2] = $row['ln_ty_interest_rate'];
            $arr[3] = $row['ln_ty_amount'];
            $arr[4] = $row['ln_ty_interest_type'];
            $arr[5] = $row['ln_ty_app_req_flg'];
        }
        echo json_encode($arr);
        die;
    }

    public function executeLoanSettlement(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $loanService = new LoanService();
            $this->LoanType=$loanService->getLoanTypeList();
            $this->sorter = new ListSorter('LoanSettlement', 'loan', $this->getUser(), array('ls.ln_ty_number ', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('loan/LoanSettlement');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'ls.ln_ty_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $loanService->searchLoanSettlement($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->loanSettlementList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function  executeLoadLoanAssignedToEmployee(sfWebRequest $request){

        $this->Culture = $this->getUser()->getCulture();
       
        $empId = $request->getParameter('empId');

        $loanService = new LoanService();
        $this->loanApplication = $loanService->LoadLoanAssignedToEmployee($empId);

        $arr = array();

        foreach ($this->loanApplication as $row) {




            $arr[$row['ln_app_number']] = $row['ln_app_number'];

            
        }

        echo json_encode($arr);
        die;
    }

    public function executeSaveLoanSettlement(sfWebRequest $request) {

        //Table Lock code is Open
        $encrypt = new EncryptionHandler();
        try {
            if (!strlen($request->getParameter('lock'))) {
                $this->mode = 0;
            } else {
                $this->mode = $request->getParameter('lock');
            }
            $settleLockid = $encrypt->decrypt($request->getParameter('setleId'));

            if (isset($this->mode)) {
                if ($this->mode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_ln_settlement', array($settleLockid), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {

                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_ln_settlement', array($settleLockid), 1);
                    $this->mode = 0;
                }
            }

            $this->userCulture = $this->getUser()->getCulture();

            $applicationId = $request->getParameter('setleId');
            $loanService = new LoanService();
            $loadLoanList=$loanService->getLoanList();
            $this->loadLoanList=$loadLoanList;
            //Settled Date set As Current Date
            $todate = date("Y-m-d", time());

            //get Loan Settled User Details
            $settleUser = $_SESSION['empNumber'];
            $this->updateApplication = $loanService->readLoanApplication($applicationId);

            if (strlen($applicationId)) {
                $applicationId = $encrypt->decrypt($request->getParameter('setleId'));
                if (!strlen($this->mode)) {
                    $this->mode = 0;
                }
                if (!$this->updateApplication) {
                    $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Record Not Found')));
                    $this->redirect('loan/LoanSettlement');
                }
            } else {
                $this->mode = 1;
            }

            // Save Loan Settlement Process
            if ($request->isMethod('post')) {

                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $loanHeader = $loanService->readLoanHeaderByEmpIdAndType($request->getParameter('txtEmployeeId'), $request->getParameter('cmdLoanType'));
                $appId = $loanHeader[0]['ln_app_number'];

                $empId = trim($request->getParameter('txtEmployeeId'));
                $hdSeq = 1;
                $tyNumber = trim($request->getParameter('cmdLoanType'));

                $lastId = $loanService->getLastLoanSettlementID();
                //get Settlement Amount
                $settlementAmount = trim($request->getParameter('txtPartSettlement'));
                //get Settlement Type Full/Part Settlement flag
                $status = trim($request->getParameter('optPartFullSettlement'));

                //Loan Settlement Process
                if ($request->getParameter('chkTask') == 1) {
                    if (strlen($request->getParameter('txtSettlementHiddenId'))) {
                        $loanSettlement = $loanService->readLoanSettlement($request->getParameter('txtSettlementHiddenId'));
                    } else {
                        $loanSettlement = new LoanSettlement();
                    }
                    if (strlen($request->getParameter('txtEmployeeId'))) {
                        $loanSettlement->setEmp_number(trim($request->getParameter('txtEmployeeId')));
                    } else {
                        $loanSettlement->setEmp_number(null);
                    }
                    if (strlen($request->getParameter('cmdLoanType'))) {
                        $loanSettlement->setLn_ty_number(trim($request->getParameter('cmdLoanType')));
                    } else {
                        $loanSettlement->setLn_ty_number(null);
                    }
                    if (strlen($request->getParameter('txtPartSettlement'))) {
                        $loanSettlement->setLn_st_amount(trim($request->getParameter('txtPartSettlement')));
                    } else {
                        $loanSettlement->setLn_st_amount(null);
                    }
                    if ($settleUser != null) {
                        $loanSettlement->setLn_st_user($settleUser);
                    } else {
                        $loanSettlement->setLn_st_user("admin");
                    }
                    $loanSettlement->setLn_st_mode((int) trim($request->getParameter('chkTask')));
                    $loanSettlement->setLn_hd_sequence(1);
                    //Read Loan Type 
                    $loanType = $loanService->readLoanType(trim($request->getParameter('cmdLoanType')));
                    if ($loanType != null) {
                        $loanSettlement->setLn_st_interest_amount($loanType->ln_ty_interest_rate);
                    } else {
                        $loanSettlement->setLn_st_interest_amount(null);
                    }
                    if (strlen($todate)) {
                        $loanSettlement->setLn_st_date($todate);
                    } else {
                        $loanSettlement->setLn_st_date(null);
                    }
                    $loanService->saveLoanSettlement($loanSettlement);

                    if ($loanHeader[0]['ln_hd_is_active_flg'] == 1) {
                        //Loan Settlement Process
                    
                        if($request->getParameter('optPartFullSettlement')){
                        $this->loanFullSettlementProcess($empId, $status, $hdSeq, $tyNumber, $lastId, $appId, $settlementAmount);
                        }else{
                        $this->loanSettlementProcess($empId, $status, $hdSeq, $tyNumber, $lastId, $appId, $settlementAmount);
                        }
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->geti18n()->__('Please Active loan Before do the settlement.')));
                        $this->redirect('loan/SaveLoanSettlement?appId=' . $appId . '&lock=0');
                    }
                }
                //Loan Inactivation Process
                if ($request->getParameter('chkTask') == 2) {
                    //get Loan Active/Inactive flag
                    $inactivationFlag = $request->getParameter('optInactivateAcitvate');
                    //get Loan Inactivation Period
                    $numberOfPeriod = $request->getParameter('txtPeriodtxt');
                    //Loan Inactivate Process
                    $this->loanInactivationProcess($inactivationFlag, $numberOfPeriod, $appId);
                }
                //Loan Reshedule Process
                if ($request->getParameter('chkTask') == 3) {
                    //Loan Reshedule Process
                    $sheduleType = $request->getParameter('optReschedule');
                    if ($sheduleType == 0) {
                        //get Reshedule Number of Installments
                        $numOfInstalment = $request->getParameter('txtNumOfInstalment');
                        //loan Reshedule By Number of Installment
                        $this->loanResheduleByNumOfInstallment($empId, $hdSeq, $tyNumber, $lastId, $appId, $numOfInstalment);
                    } else {
                        //get Reshedule Installment Amount
                        $InstalmentAmount = $request->getParameter('txtInstalmentAmount');
                        //loan Reshedule By Installment Amount
                        $this->loanResheduleByInstallmentAmount($empId, $hdSeq, $tyNumber, $lastId, $appId, $InstalmentAmount);
                    }
                }
                $conn->commit();
                if (strlen($appId)) {
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Updated')));
                    $this->redirect('loan/LoanSettlement?appId=' . $applicationId . '&lock=0');
                } else {
                    $this->setMessage('SUCCESS', array($this->getContext()->geti18n()->__('Successfully Added')));
                    $this->redirect('loan/LoanSettlement');
                }
            }
        }
        catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            if (strlen($appId)) {
            $this->redirect('loan/SaveLoanSettlement?appId=' . $appId . '&lock=0');
            }else{
            $this->redirect('loan/LoanSettlement');    
            }
        }
        catch (sfStopException $sf) {
            //$this->redirect('loan/LoanSettlement');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            if (strlen($appId)) {
            $this->redirect('loan/SaveLoanSettlement?appId=' . $appId . '&lock=0');
            }else{
            $this->redirect('loan/LoanSettlement');    
            }
        }
    }

    public function loanFullSettlementProcess($empId, $status, $hdSeq, $tyNumber, $lastId, $appId, $settlementAmount){
        $loanSubservice=new LoanSubService();
        $loanSubservice->updateHeaderforFullAmount($empId,$tyNumber);
        $loanSubservice->updateLnShdFullSettle($tyNumber);
        

    }

    private function loanResheduleByNumOfInstallment($empId, $hdSeq, $tyNumber, $lastId, $appId, $newInstallmentCount) {

        //loan Reshedule 
        $encrypt = new EncryptionHandler();
        $this->userCulture = $this->getUser()->getCulture();
        try {
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();

            $loanService = new LoanService();

            $pendingSheduleList = $loanService->readPendingSheduleList($tyNumber);
            
            foreach ($pendingSheduleList as $shedule) {
                $loanService->deleteShedule($tyNumber);
            }
            $conn->commit();
           
            $loanApplication = $loanService->readLoanApplication($tyNumber);


            $loanType = $loanService->readLoanType($loanApplication->ln_ty_number);
            $loanHeader = $loanService->readLoanHeader($loanApplication->ln_app_number);
            $noOfInstallment = $newInstallmentCount;
            $loanAmount = $loanHeader->ln_hd_bal_amount;
            $interestRate = $loanType->ln_ty_interest_rate;
            $interestType = $loanType->ln_ty_interest_type;

            //check loan Type Interest Type 
            if ($loanType->ln_ty_interest_type == 0) {
                $fixedInterest = $loanType->ln_ty_interest_fixed_amt;
                //Fixed Interest Type 
                $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                $monthlyInstalment = $loanService->getFixedInstalment($monthlyCapital, $fixedInterest);
            } else {
                //Percentage Type
                if ($loanType->ln_ty_entitlement_type_flg == 2) {
                    //Calculate SimpleInstalment get Month Installment 
                    $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                    $monthlyInstalment = $loanService->getSimpleInstalment($loanAmount, $monthlyCapital, $interestRate, $noOfInstallment);
                } else if ($loanType->ln_ty_interest_type == 1) {
                    //Calculate Equal Balance Balance get Month Installment 
                    $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                    $monthlyInstalment = $loanService->getMonthlyInstalment($loanAmount, $monthlyCapital, $interestRate, $noOfInstallment);
                }
            }

            $pendingCount = $loanHeader->ln_hd_installment - $loanHeader->ln_hd_bal_installment;

            for ($t = $pendingCount + 1; $t <= $noOfInstallment + $pendingCount; $t++) {

                $loanShedule = new LoanSchedule();

                if ($loanApplication->emp_number != null) {
                    $loanShedule->setEmp_number($loanApplication->emp_number);
                } else {
                    $loanShedule->setEmp_number(null);
                }
                $loanShedule->setLn_sch_ins_no($t);
                $loanShedule->setLn_ty_number($loanApplication->ln_ty_number);
                $loanShedule->setLn_hd_sequence($loanHeader->ln_hd_sequence);
                $loanShedule->setLn_sch_cap_amt($monthlyCapital);
                $loanShedule->setLn_sch_inst_amount(round($monthlyInstalment, 2));
                $loanShedule->setLn_sch_inst_rate($interestRate);
                $loanShedule->setLn_app_number($tyNumber);
                $loanService->saveLoanShedule($loanShedule);
            }
            //updateLoanHeader Installment Count Details
            $loanHeader->setLn_hd_installment($pendingCount + $noOfInstallment);
            $loanHeader->setLn_hd_bal_installment($noOfInstallment);
            $loanService->saveLoanHeader($loanHeader);
        }
        catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanSettlement');
        }
        catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanSettlement');
        }
    }

    //loan Inactivation Process
    public function loanInactivationProcess($inactivationFlag, $numberOfPeriod, $appId) {

        $encrypt = new EncryptionHandler();
        $this->userCulture = $this->getUser()->getCulture();
        $loanService = new LoanService();

        //get Loan Header
        $updateLoanHeader = $loanService->readLoanHeader($appId);
        $loanHeaderId = $updateLoanHeader->ln_app_number;

        try {
            if (isset($this->mode)) {
                if ($this->mode == 1) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->setTableLock('hs_ln_header', array($loanHeaderId, $appId), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {

                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_ln_header', array($loanHeaderId), 1);
                    $this->mode = 0;
                }
            }

            if ($appId != null) {

                $updateLoanHeader = $loanService->readLoanHeader($appId);

                if ($inactivationFlag == 0) {
                    //set Loan As Active
                    $updateLoanHeader->setLn_hd_inactive_period(0);
                    $updateLoanHeader->setLn_hd_is_active_flg(1);
                } else {
                    //set Loan As Inactive
                    $updateLoanHeader->setLn_hd_inactive_period($numberOfPeriod);
                    $updateLoanHeader->setLn_hd_is_active_flg(0);
                }

                $loanService->saveLoanHeader($updateLoanHeader);
            }
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/SaveLoanSettlement?appId=' . $appId . '&lock=0');
        } catch (sfStopException $sf) {
            $this->redirect('loan/SaveLoanSettlement');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/SaveLoanSettlement');
        }
    }

    private function loanResheduleByInstallmentAmount($empId, $hdSeq, $tyNumber, $lastId, $appId, $InstalmentAmount) {
        //loan Reshedule 
        $encrypt = new EncryptionHandler();
        $this->userCulture = $this->getUser()->getCulture();
        try {
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();

            $loanService = new LoanService();

            $pendingSheduleList = $loanService->readPendingSheduleList($tyNumber);
           
            foreach ($pendingSheduleList as $shedule) {
                $loanService->deleteShedule($tyNumber);
            }
            $conn->commit();

            $loanApplication = $loanService->readLoanApplication($appId);

            $loanType = $loanService->readLoanType($loanApplication->ln_ty_number);
            $loanHeader = $loanService->readLoanHeader($loanApplication->ln_app_number);
            $loanAmount = $loanHeader->ln_hd_bal_amount;
            $interestRate = $loanType->ln_ty_interest_rate;
            $interestType = $loanType->ln_ty_interest_type;

////         
//            $loanReminderValue=$loanAmount%$InstalmentAmount;
//            $roundValue=$loanAmount-$loanReminderValue;
//            $noOfRoundInstallment=$roundValue/$InstalmentAmount;
//            $installmentArr=array();
//
//            if($loanReminderValue>0){
//             $noOfRoundInstallment= $noOfRoundInstallment+1;
//            }
//            else{
//                $noOfRoundInstallment= $noOfRoundInstallment;
//            }

            


            $loanBalanceAmount = $loanHeader->ln_hd_bal_amount;
            $noOfInstallment = round($loanBalanceAmount / $InstalmentAmount);
            

            //check loan Type Interest Type 
            if ($loanType->ln_ty_interest_type == 0) {
                $fixedInterest = $loanType->ln_ty_interest_fixed_amt;
                //Fixed Interest Type 
                $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                $monthlyInstalment = $loanService->getFixedInstalment($monthlyCapital, $fixedInterest);
            } else {
                //Percentage Type
                if ($loanType->ln_ty_entitlement_type_flg == 2) {
                    //Calculate SimpleInstalment get Month Installment 
                    $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                    $monthlyInstalment = $loanService->getSimpleInstalment($loanAmount, $monthlyCapital, $interestRate, $noOfInstallment);
                } else if ($loanType->ln_ty_interest_type == 1) {
                    //Calculate Equal Balance Balance get Month Installment 
                    $monthlyCapital = $loanService->getMonthlyCapital($loanAmount, $noOfInstallment);
                    $monthlyInstalment = $loanService->getMonthlyInstalment($loanAmount, $monthlyCapital, $interestRate, $noOfInstallment);
                }
            }

            $pendingCount = $loanHeader->ln_hd_installment - $loanHeader->ln_hd_bal_installment;
//            die($monthlyCapital);
            for ($t = $pendingCount + 1; $t <= $noOfInstallment + $pendingCount; $t++) {

                $loanShedule = new LoanSchedule();

                if ($loanApplication->emp_number != null) {
                    $loanShedule->setEmp_number($loanApplication->emp_number);
                } else {
                    $loanShedule->setEmp_number(null);
                }
                $loanShedule->setLn_sch_ins_no($t);
                $loanShedule->setLn_ty_number($loanApplication->ln_ty_number);
                $loanShedule->setLn_hd_sequence($loanHeader->ln_hd_sequence);
                $loanShedule->setLn_sch_cap_amt($monthlyCapital);
                $loanShedule->setLn_sch_inst_amount(round($monthlyInstalment, 2));
                $loanShedule->setLn_sch_inst_rate($interestRate);
                $loanShedule->setLn_app_number($tyNumber);
                $loanService->saveLoanShedule($loanShedule);
            }
            //updateLoanHeader Installment Count Details
            $loanHeader->setLn_hd_installment($pendingCount + $noOfInstallment);
            $loanHeader->setLn_hd_bal_installment($noOfInstallment);
            $loanService->saveLoanHeader($loanHeader);
        }
        catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanSettlement');
        }
        catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanSettlement');
        }
    }

    public function loanSettlementProcess($empId, $status, $hdSeq, $tyNumber, $lastId, $appId, $settleAmount) {

        $encrypt = new EncryptionHandler();
        $this->userCulture = $this->getUser()->getCulture();
        $loanSubservice=new LoanSubService();
        try {

         
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            $loanService = new LoanService();
            $loanHeader = $loanService->readLoanHeader($tyNumber);
           
            //get loan Schedule List
            $updateScheduleList = $loanService->readLoanShedule1($empId, $hdSeq);
            $lastSettleId = $loanHeader->ln_hd_installment - $loanHeader->ln_hd_bal_installment;
           
            //Get Loan Header
            $loanHeader = $loanService->readLoanHeader($tyNumber);
            $currentBalInstallment = $loanHeader->ln_hd_bal_installment;
            $newBalInstallment = $currentBalInstallment - 1;

            $currentBalAmount = $loanHeader->ln_hd_bal_amount;
           
            $newBalAmount = $currentBalAmount - $settleAmount;

           $updatedSlotAmout="";
            $loanHeader->setLn_hd_bal_amount($newBalAmount);

              


            if($settleAmount>0){
                $LastSheduleSlot="";
                $LastSheduleSlot=$loanService->getLastSheduleslot($empId,$hdSeq);
               $LastSheduleSlot=$LastSheduleSlot[0][MAX];

                $tobeProcessed=$loanSubservice->getToBeProcessedSheduleslot($empId,$hdSeq);
                $tobeProcessed=$tobeProcessed[0]['tobeProcSlot'];
                
                
                $noofAvilableSlots=$loanSubservice->getNoOfAvilableSlots();
                $noofAvilableSlots=$noofAvilableSlots[0]['noOfSlots'];
                $slotAmount=array();

                $SlotInstallmentAmout=$updateScheduleList->ln_sch_inst_amount;
                $balnaceLoanAmount=$settleAmount;
                
                for($i=0;$i<$noofAvilableSlots;$i++){
//                    echo $updateScheduleList->ln_sch_inst_amount;
                   
//                    if($settleAmount>$updateScheduleList->ln_sch_inst_amount){
                         
                          
                          if($balnaceLoanAmount>$SlotInstallmentAmout){
                            
                              $slotAmount[$i]=$SlotInstallmentAmout;
                             
                              $balnaceLoanAmount=$balnaceLoanAmount-$SlotInstallmentAmout;
                               
//                               print_r($balnaceLoanAmount);die;
                          }
                          else{
                              $slotAmount[$i]=$balnaceLoanAmount;
                              break;
                          }
                          
//                    }
                    

                }

            
                for($k=0;$k<count($slotAmount);$k++){

                    //echo $slotAmount[$k];
                 
                 
                  if($SlotInstallmentAmout==$slotAmount[$k]){                     
                    $SchedulebyIds = $loanSubservice->getLoanShedulebyIds($empId, $tobeProcessed,$hdSeq);
                    
                    $SchedulebyIds->setLn_sch_inst_amount($slotAmount[$k]);
                    $SchedulebyIds->setLn_sch_is_processed(1);
                    $tobeProcessed=$tobeProcessed+1;
                    $updatedSlotAmout=$k+1;
                    $SchedulebyIds->save();
                  
                  }
                  else{
                      //get Last Possible Slot
                       
                      $lastSchedulebyIds = $loanSubservice->getLoanShedulebyIds($empId, $LastSheduleSlot,$hdSeq);
                      if($lastSchedulebyIds->ln_sch_inst_amount<=$slotAmount[$k]){
                         
                        $extraCurrentslotamount=$slotAmount[$k]-$lastSchedulebyIds->ln_sch_inst_amount;

                        $lastSchedulebyIds->setLn_sch_inst_amount($SlotInstallmentAmout);
                        $lastSchedulebyIds->setLn_sch_is_processed(1);
                        $updatedSlotAmout=$k+1;

                        $lastSchedulebyIds->save();
                        if($extraCurrentslotamount!=0){

                     $updatedSlotAmout=$k+1;
                        $LastSheduleSlot1=$LastSheduleSlot-1;
                        $beforeLastScheduleId=$loanSubservice->getLoanShedulebyIds($empId, $LastSheduleSlot1,$hdSeq);
                        if($beforeLastScheduleId==$SlotInstallmentAmout){
                            //throw Exception here

                        }
                        else{
                        
                         $temAount1=$lastSchedulebyIds->ln_sch_inst_amount-$extraCurrentslotamount;
                        $beforeLastScheduleId->setLn_sch_inst_amount($temAount1);
                        $beforeLastScheduleId->save();

                        }
                        }
                      }
                      else{

                       
                      $temAount=$lastSchedulebyIds->ln_sch_inst_amount-$slotAmount[$k];
                        $lastSchedulebyIds->setLn_sch_inst_amount($temAount);
                        $lastSchedulebyIds->save();
                      }

                  }

                }
//                die;


              
            }
            else{

//                die($noofAvilableSlots);
            }
// 

              
                   if(($loanHeader->ln_hd_bal_installment-$updatedSlotAmout)==0){
                  $loanHeader->setLn_hd_settled_flg(1);
                   }
              $loanHeader->setLn_hd_bal_installment($loanHeader->ln_hd_bal_installment-$updatedSlotAmout);
                $loanService->saveLoanHeader($loanHeader);
            $conn->commit();
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanSettlement');
        } catch (sfStopException $sf) {
            $this->redirect('loan/LoanSettlement');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanSettlement');
        }
    }

    public function updateLoanHeadder($settleAmount, $status, $sheduleId, $appId) {

        $encrypt = new EncryptionHandler();
        $this->userCulture = $this->getUser()->getCulture();
        try {
            if (isset($this->mode)) {
                if ($this->mode == 1) {

                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->setTableLock('hs_ln_header', array($loanHeaderId), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->mode = 1;
                    } else {

                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->mode = 0;
                    }
                } else if ($this->mode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_ln_header', array($loanHeaderId), 1);
                    $this->mode = 0;
                }
            }
            $loanService = new LoanService();

            if ($appId != null) {

                $updateLoanHeader = $loanService->readLoanHeader($appId);

                //update the Header Balance Amount
                $currentBalAmount = $updateLoanHeader->ln_hd_bal_amount;

                $newBalAmount = $currentBalAmount - $settleAmount;
               
                //set New Balance Amount
                $updateLoanHeader->setLn_hd_bal_amount($newBalAmount);

                //update the Balance Installment
                $currentBalInstallment = $updateLoanHeader->ln_hd_bal_installment;
                $newBalInstallment = $currentBalInstallment - 1;

                if ($status == 1) {
                    //set New Balance Installment
                    $updateLoanHeader->setLn_hd_bal_installment($newBalInstallment);
                    $updateLoanHeader->setLn_hd_settled_flg(1);
                } else {
                    //set New Balance Installment
                    $updateLoanHeader->setLn_hd_bal_installment($newBalInstallment);
                }

                $loanService->saveLoanHeader($updateLoanHeader);
            }
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanType');
        } catch (sfStopException $sf) {
            $this->redirect('loan/LoanType');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/LoanType');
        }
    }

    public function executeLoanHistoryandStatus(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();
            $loanService = new LoanService();

            $this->loanTypeList = $loanService->getLoanTypeList();

            $this->sorter = new ListSorter('LoanSettlement', 'loan', $this->getUser(), array('la.ln_app_number ', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('loan/LoanSettlement');
                }
                $this->var = 1;
            }

            if ($request->getParameter('optEmpLoan') == 0) {
                //Employee Wise"
                $this->searchMode = 'EmployeeId';
                $this->empName = ($request->getParameter('txtEmployeeName') == null) ? '' : $request->getParameter('txtEmployeeName');
                $this->searchValue2 = ($request->getParameter('txtEmployeeId') == null) ? '' : $request->getParameter('txtEmployeeId');
                $this->searchValue = ($request->getParameter('txtEmpNic') == null) ? '' : $request->getParameter('txtEmpNic');
                $this->empLoan = 'empLoan';
                $this->empLoanValue = $request->getParameter('optEmpLoan');
                if ($request->getParameter('optActiveInactivate') != null) {
                    // Active/Inactive
                    $this->activeInactive = 'activeIncative';
                    $this->activeInactiveValue = $request->getParameter('optActiveInactivate');
                }
            } else if ($request->getParameter('optEmpLoan') == 1) {
                //Loan Wise
                $this->searchMode = 'Loantype';
                $this->empName = ($request->getParameter('txtEmployeeName') == null) ? '' : $request->getParameter('txtEmployeeName');
                $this->searchValue2 = ($request->getParameter('txtEmployeeId') == null) ? '' : $request->getParameter('txtEmployeeId');
                $this->searchValue = ($request->getParameter('cmbLoantype') == null) ? '' : $request->getParameter('cmbLoantype');
                $this->empLoan = 'empLoan';
                $this->empLoanValue = $request->getParameter('optEmpLoan');
                if ($request->getParameter('optActiveInactivate') != null) {
                    //Active/Inactive
                    $this->activeInactive = 'activeIncative';
                    $this->activeInactiveValue = $request->getParameter('optActiveInactivate');
                }
            }

            $this->sort = ($request->getParameter('sort') == '') ? 'la.ln_app_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $loanService->searchLoanHistoryandStatus($this->searchMode, $this->searchValue2, $this->activeInactive, $this->activeInactiveValue, $this->empLoan, $this->empLoanValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->loanLoanHistoryList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    /**
     * List Language
     * @param sfWebRequest $request
     * @return unknown_type
     */
    public function executeSearchEmployee(sfWebRequest $request) {
        try {

            $this->userCulture = $this->getUser()->getCulture();
            $loanService = new LoanService();

            $this->type = $request->getParameter('type', isset($_SESSION["type"]) ? $_SESSION["type"] : 'single');
            $this->method = $request->getParameter('method', isset($_SESSION["method"]) ? $_SESSION["method"] : '');
            $reason = $request->getParameter('reason');
            if (strlen($reason)) {
                $this->reason = $reason;
            } else {
                $this->reason = '';
            }

            $todate = date("Y-m-d", time());
            $this->todate = (String) $todate;

            $att = $request->getParameter('att');
            if (strlen($att)) {
                $this->att = $att;
            } else {
                $this->att = '';
            }

            //payroll
            $payroll = $request->getParameter('payroll');
            if (strlen($payroll)) {
                $this->payroll = $payroll;
            } else {
                $this->payroll = '';
            }

            //Store in session to support sorting
            $_SESSION["type"] = $this->type;
            $_SESSION["method"] = $this->method;

            $this->sorter = new ListSorter('propoerty.sort', 'pim_module', $this->getUser(), array('emp_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            $this->searchMode = ($request->getParameter('cmbSearchMode') == '') ? 'all' : $request->getParameter('cmbSearchMode');
            $this->searchValue = ($request->getParameter('txtSearchValue') == '') ? '' : $request->getParameter('txtSearchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $result = $loanService->searchEmployee($this->searchMode, $this->searchValue, $this->userCulture, $request->getParameter('page'), $this->sort, $this->order, $this->type, $this->method, $this->reason, $this->att, $this->todate, $this->payroll);

            $this->listEmployee = $result['data'];
            $this->pglay = $result['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (sfStopException $sf) {
            $this->redirect('loan/searchEmployee');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('loan/searchEmployee');
        }
    }

    public function executeAjaxGetloanType(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $id = $request->getParameter('empId');

        $loanService = new LoanService();
        $this->loanType = $loanService->getEmployeeLoanType($id);
        $arrId = Array();
        $arr = array();
        foreach ($this->loanType as $row) {
            $arrId[0] = $row['ln_ty_number'];
        }
        $this->loatTypeList = $loanService->getLoanTypebyIdArray($arrId);

        foreach ($this->loatTypeList as $row) {

            $ty_name = "ln_ty_name_" . $Culture;
            if ($row[$ty_name] == null) {
                $ty_name = "ln_ty_name";
            } else {
                $ty_name = "ln_ty_name_" . $Culture;
            }
            $arr[$row['ln_ty_number']] = $row[$ty_name];
        }
        echo json_encode($arr);
        die;
    }

    public function executeAjaxLoadLoanShedule($request) {
        $this->Culture = $this->getUser()->getCulture();
        $empId = $request->getParameter('empId');
        $hdSeq = $request->getParameter('hdSeq');
        $tyNumber = $request->getParameter('tyNumber');

        $loanService = new LoanService();
        $this->loanShedule = $loanService->readLoanShedule($empId, $tyNumber);

        echo json_encode($this->loanShedule);
        die;
    }

    public function executeAjaxLoadLoanSettlement($request) {
        $this->Culture = $this->getUser()->getCulture();
        $ln_st_number = $request->getParameter('ln_st_number');
        $loanService = new LoanService();
        $this->settlement = $loanService->readLoanSettlement($ln_st_number);
        $amount = $this->settlement[0]['ln_st_amount'];
        echo json_encode($amount);
        die;
    }

    public function executeAjaxGetLoanApplicationData(sfWebRequest $request) {
        $this->Culture = $this->getUser()->getCulture();
        $typeId = $request->getParameter('typeId');
        $empId = $request->getParameter('empId');

        $loanService = new LoanService();
        $this->loanApplication = $loanService->readLoanHeaderByEmpIdAndType($empId, $typeId);
//        print_r($this->loanApplication);
        $arr = array();
        foreach ($this->loanApplication as $row) {
             
            $arr[0] = $row['ln_hd_amount'];
            $arr[1] = $row['ln_hd_installment'];
            $arr[2] = $row['ln_hd_bal_amount'];
            $arr[3] = $row['ln_hd_bal_installment'];
            $arr[4] = $row[LoanApplication][ln_app_install_amount];
            $arr[5] = $row['ln_hd_settled_flg'];
            $arr[6] = $row['ln_hd_is_active_flg'];
            $arr[7] = $row['ln_hd_inactive_period'];
        }
        echo json_encode($arr);
        die;
    }

    public function executeDeleteLoanType(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $loanService = new LoanService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');
                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_ln_type', array($ids[$i]), 1);

                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $loanService->deleteLoanType($ids[$i]);
                        $conHandler->resetTableLock('hs_ln_type', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('loan/LoanType');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('loan/LoanType');
    }

    public function executeDeleteApplication(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $loanService = new LoanService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');
                $countArr = array();
                $saveArr = array();
                $guaArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $idarr = explode("|", $ids[$i]);
                    $appid = $idarr[0];
                    $lntype = $idarr[1];
                    $isRecordLocked = $conHandler->isTableLocked('hs_ln_application', array($idarr), 1);
                    if ($isRecordLocked) {
                        $countArr = $idarr;
                    } else {
                        $saveArr = $idarr;
                        
                        $guaArr = $loanService->getGuaranteeList($appid);
                        $loanService->deleteApplication($appid, $lntype);
                        $loanService->deleteLoanHeader2($appid);
                        foreach ($guaArr as $value) {
                               $loanService->deleteGuarantee($value[ln_gura_number]);
                        }
                        $loanService->deleteLoanSchDule2($appid);
                        $conHandler->resetTableLock('hs_ln_application', array($idarr), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('loan/AppliedLoan');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('loan/AppliedLoan');
    }

     public function executeAjaxMaxLoanInstallment($typeId) {
        $this->Culture = $this->getUser()->getCulture();
        $typeId = $request->getParameter('typeId');
        $loanService = new LoanService();
        $this->type = $loanService->getMaxLoanInstallment($typeId);
        $amount = $this->type[0]['ln_st_amount'];
        echo json_encode($amount);
        die;
    }
    
        /**
     * Executes GetEmployeeId Ajax function
     *
     * @param sfRequest $request A request object
     */
    public function executeAjaxGetEmployeeId(sfWebRequest $request) {

        $transferService = new TransferService();
        $this->transferService = $transferService;

        $id = $request->getParameter('eid');
        $employee = $transferService->readGetEmployeeId($id);
        echo json_encode($employee->employeeId);
        die;
    }
    
    public function executeAjaxDeleteEmployeeGaranter(sfWebRequest $request) {

        $loanDao = new LoanDao();

        $loantype = $request->getParameter('loantype');
        $loanno = $request->getParameter('loanno');
        $nic = $request->getParameter('nic');
        
        $employee = $loanDao->deleteGaruntee($loantype,$loanno,$nic);
        echo json_encode("true");
        die;
    }
    
    
    /**
     * JBL 
     */
    
        public function executeLedgerDisplay(sfWebRequest $request) {

        $this->Noofinstallment = $request->getParameter('installment');
        $this->LoanAmount = $request->getParameter('LoanAmount');
        $this->EffectiveDate = $request->getParameter('EffectiveDate');
        $this->Loanno = $request->getParameter('Loanno');
        $this->empno=$request->getParameter('empno');
        $this->myCulture = $this->getUser()->getCulture();
        $month = $this->EffectiveDate;
        $loandao = new LoanDao();
        $loantype = $loandao->readLoanType($this->Loanno);
        $annualinterest = $loantype->ln_ty_interest_rate;
        $Lnappno= $request->getParameter('Lnappno');
        //$annualinterest = 18;
        //die(print_r($loantype));

        for($i=0; $i < $this->Noofinstallment; $i++){       
            
            $month = $this->add($month, 1);
            $month= $month->format("Y-m-d");

  
            $intpart = floor( $num );    
            $fraction = $num - $intpart;  

            
        if($loantype->ln_ty_entitlement_type_flg == 1){
           //echo "Rediucing bal";
           if($i==0){
            $StartingBalance=$this->LoanAmount-$Principle;               
           }else{
            $StartingBalance=$EndBalance;     
           }
           $Principle=($this->LoanAmount/$this->Noofinstallment);
           $IntrestAmount=(($StartingBalance *$annualinterest)/(100*12));
           $EndBalance=$StartingBalance-$Principle;
           $CumilativeIntrest=$CumilativeIntrest+$IntrestAmount;
           $installmentamount=$Principle+$IntrestAmount;
           
           $PrincipleR2=$this->roundnumber2($Principle);
           $IntrestAmountR2=$this->roundnumber2($IntrestAmount);
           $EndBalanceR2=$this->roundnumber2($EndBalance);
           $CumilativeIntrestR2=$this->roundnumber2($CumilativeIntrest);
           $installmentamountR2=$this->roundnumber2($installmentamount);
           
           $PrincipleR=$this->roundnumber($Principle);
           $IntrestAmountR=$this->roundnumber($IntrestAmount);
           $EndBalanceR=$this->roundnumber($EndBalance);
           $CumilativeIntrestR=$this->roundnumber($CumilativeIntrest);
           $installmentamountR=$this->roundnumber($installmentamount);           
           
           $PrincipleCF = $PrincipleR2 - $PrincipleR;
           $IntrestAmountCF = $IntrestAmountR2 - $IntrestAmountR;
           $EndBalanceCF = $EndBalanceR2 - $EndBalanceR;
           $CumilativeIntrestCF = $CumilativeIntrestR2 - $CumilativeIntrestR;
           $installmentamountCF = $installmentamountR2 - $installmentamountR;
           
           $DiffPrincipleCF=$this->roundnumber2($PrincipleCF);
           $DiffIntrestAmountCF=$this->roundnumber2($IntrestAmountCF);
           $DiffEndBalanceCF=$this->roundnumber2($EndBalanceCF);
           $DiffCumilativeIntrestCF=$this->roundnumber2($CumilativeIntrestCF);
           $DiffinstallmentamountCF=$this->roundnumber2($installmentamountCF);  


       
        }else if($loantype->ln_ty_entitlement_type_flg == 2){
           //echo "Simple"; 
           if($i==0){
            $StartingBalance=$this->LoanAmount-$Principle;               
           }else{
            $StartingBalance=$EndBalance;     
           }
           $Principle=($this->LoanAmount/$this->Noofinstallment);
           $IntrestAmount=($Principle*$annualinterest)/(100*12);
           $EndBalance=$StartingBalance-$Principle;
           $CumilativeIntrest=$CumilativeIntrest+$IntrestAmount;
           $installmentamount=$Principle+$IntrestAmount;
           
           $PrincipleR2=$this->roundnumber2($Principle);
           $IntrestAmountR2=$this->roundnumber2($IntrestAmount);
           $EndBalanceR2=$this->roundnumber2($EndBalance);
           $CumilativeIntrestR2=$this->roundnumber2($CumilativeIntrest);
           $installmentamountR2=$this->roundnumber2($installmentamount);
           
           $PrincipleR=$this->roundnumber($Principle);
           $IntrestAmountR=$this->roundnumber($IntrestAmount);
           $EndBalanceR=$this->roundnumber($EndBalance);
           $CumilativeIntrestR=$this->roundnumber($CumilativeIntrest);
           $installmentamountR=$this->roundnumber($installmentamount);           
           
           $PrincipleCF = $PrincipleR2 - $PrincipleR;
           $IntrestAmountCF = $IntrestAmountR2 - $IntrestAmountR;
           $EndBalanceCF = $EndBalanceR2 - $EndBalanceR;
           $CumilativeIntrestCF = $CumilativeIntrestR2 - $CumilativeIntrestR;
           $installmentamountCF = $installmentamountR2 - $installmentamountR;
           
           $DiffPrincipleCF=$this->roundnumber2($PrincipleCF);
           $DiffIntrestAmountCF=$this->roundnumber2($IntrestAmountCF);
           $DiffEndBalanceCF=$this->roundnumber2($EndBalanceCF);
           $DiffCumilativeIntrestCF=$this->roundnumber2($CumilativeIntrestCF);
           $DiffinstallmentamountCF=$this->roundnumber2($installmentamountCF);

                 
            
        }else if($loantype->ln_ty_entitlement_type_flg == 3){
           //echo "PMT"; 
           if($i==0){
            $StartingBalance=$this->LoanAmount;               
           }else{
            $StartingBalance=$EndBalance;     
           }
           
           
           $installmentamount=(($annualinterest/100/12)/(1-pow((1+$annualinterest/100/12),(-($this->Noofinstallment)))))*($this->LoanAmount);
           $IntrestAmount=(($StartingBalance*$annualinterest)/(100*12));
           $Principle=(($this->LoanAmount / (((1 - pow((1 + (($annualinterest / 100) / 12)), -($this->Noofinstallment))) / (($annualinterest / 100) / 12))))-$IntrestAmount);
           $EndBalance=$StartingBalance-$Principle;
           $CumilativeIntrest=$CumilativeIntrest+$IntrestAmount;
           
           $PrincipleR2=$this->roundnumber2($Principle);
           $IntrestAmountR2=$this->roundnumber2($IntrestAmount);
           $EndBalanceR2=$this->roundnumber2($EndBalance);
           $CumilativeIntrestR2=$this->roundnumber2($CumilativeIntrest);
           $installmentamountR2=$this->roundnumber2($installmentamount);
           
           $PrincipleR=$this->roundnumber($Principle);
           $IntrestAmountR=$this->roundnumber($IntrestAmount);
           $EndBalanceR=$this->roundnumber($EndBalance);
           $CumilativeIntrestR=$this->roundnumber($CumilativeIntrest);
           $installmentamountR=$this->roundnumber($installmentamount);           
           
           $PrincipleCF = $PrincipleR2 - $PrincipleR;
           $IntrestAmountCF = $IntrestAmountR2 - $IntrestAmountR;
           $EndBalanceCF = $EndBalanceR2 - $EndBalanceR;
           $CumilativeIntrestCF = $CumilativeIntrestR2 - $CumilativeIntrestR;
           $installmentamountCF = $installmentamountR2 - $installmentamountR;
           
           $DiffPrincipleCF=$this->roundnumber2($PrincipleCF);
           $DiffIntrestAmountCF=$this->roundnumber2($IntrestAmountCF);
           $DiffEndBalanceCF=$this->roundnumber2($EndBalanceCF);
           $DiffCumilativeIntrestCF=$this->roundnumber2($CumilativeIntrestCF);
           $DiffinstallmentamountCF=$this->roundnumber2($installmentamountCF);

        }
//        $SumPrincipleFloat+=$PrincipleFloat;
//        $SumIntrestAmountFloat+=$IntrestAmountFloat;
//        $SuminstallmentamountFloat+=$installmentamountFloat;
//        $SumCumilativeIntrestFloat+=$CumilativeIntrestFloat;
//        $SumEndBalanceFloat+=$EndBalanceFloat;

        //echo $SumPrinciple."/n";
        
        $SumPrinciple+=$PrincipleR;
        $SumIntrestAmount+=$IntrestAmountR;
        $Suminstallmentamount+=$installmentamountR;
        $SumCumilativeIntrest+=$CumilativeIntrestR;
        $SumEndBalance+=$EndBalanceR;
        
        $FinPrincipleCF+=$DiffPrincipleCF;
        $FinIntrestAmountCF+=$DiffIntrestAmountCF;
        $FinEndBalanceCF+=$DiffEndBalanceCF;
        $FinCumilativeIntrestCF+=$DiffCumilativeIntrestCF;
        $FininstallmentamountCF+=$DiffinstallmentamountCF;

        
        
        
        $grid[$i][0]=$month;
        if($this->Noofinstallment == $i+1){ 
            $lastBalance=$this->roundnumber2($StartingBalance);
            if($lastBalance < 0){
                $lastBalance=0;
            }
            $grid[$i][1]=$lastBalance;
            $lastCapital=$this->roundnumber2($Principle+$FinPrincipleCF);
            if($lastCapital < 0){
                $lastCapital=0;
            }
            $grid[$i][2]=$lastCapital;            
            $LastIntrestAmount=$this->roundnumber2($IntrestAmount+$FinIntrestAmountCF);
            if($LastIntrestAmount < 0){
                $LastIntrestAmount=0;
            }
            $grid[$i][3]=$LastIntrestAmount; 
            $lastinstallment=$this->roundnumber2($grid[$i][2]+$grid[$i][3]);
            if($lastinstallment < 0){
                $lastinstallment=0;
            }
            $grid[$i][4]=$lastinstallment; 
            $lastcumilative=$this->roundnumber2($grid[$i-1][5]+$grid[$i][3]);
            if($lastcumilative < 0){
                $lastcumilative=0;
            }
            $grid[$i][5]=$lastcumilative; 
            $lastbal=$this->roundnumber2($EndBalance);
            if($lastbal <= 0){
                $lastcumilative=0;
            }
            $grid[$i][6]=$lastcumilative; 
            
        }else{
            $grid[$i][1]=$this->roundnumber2($StartingBalance);
            $grid[$i][2]=$this->roundnumber2($Principle);
            $grid[$i][3]=$this->roundnumber2($IntrestAmount);
            $grid[$i][4]=$this->roundnumber2($installmentamount);
            $grid[$i][5]=$this->roundnumber2($CumilativeIntrest);
            $grid[$i][6]=$this->roundnumber2($EndBalance);
        }

        
//        $grid[$i][1]=$StartingBalance;
//        $grid[$i][2]=$Principle;
//        $grid[$i][3]=$IntrestAmount;
//        $grid[$i][4]=$installmentamount;
//        $grid[$i][5]=$CumilativeIntrest;
//        $grid[$i][6]=$EndBalance;
        
//        if($this->Noofinstallment == $i+1){ 
//
//        }else{
//
//        }
        
        $grid[$i][7]=$PrincipleFloat;
        $grid[$i][8]=$IntrestAmountFloat;
        $grid[$i][9]=$installmentamountFloat;
        $grid[$i][10]=$CumilativeIntrestFloat;
        $grid[$i][11]=$EndBalanceFloat;
        $grid[$i][12]=$PrincipleInt;
        $grid[$i][13]=$IntrestAmountInt;
        $grid[$i][14]=$installmentamountInt;
        $grid[$i][15]=$CumilativeIntrestInt;
        $grid[$i][16]=$EndBalanceInt;
        
//        $grid[$i][17]=$SumPrincipleFloat;
//        $grid[$i][18]=$SumIntrestAmountFloat;
//        $grid[$i][19]=$SuminstallmentamountFloat;
//        $grid[$i][20]=$SumCumilativeIntrestFloat;
//        $grid[$i][21]=$SumEndBalanceFloat;
        
        $grid[$i][17]=$FinPrincipleCF;
        $grid[$i][18]=$FinIntrestAmountCF;
        $grid[$i][19]=$FinEndBalanceCF;
        $grid[$i][20]=$FinCumilativeIntrestCF;
        $grid[$i][21]=$FininstallmentamountCF;
        
        if($i==0){
        $grid[$i][22]=null;//$StartingBalance;
        }else{
        $grid[$i][22]=$ActuallPayment;    
        }
        $grid[$i][23]=$CheckNo;
        $grid[$i][24]=$UserPaidAmount;
        
        $RealEndAmount=$grid[$i][6];
        
        $grid[$i][25]=$RealEndAmount;
        $grid[$i][26]=$CheckIssueDate;
        $grid[$i][27]=$RecoverCheckNo;
        $grid[$i][28]=$RecoverCheckDate;
        $grid[$i][29]=0;
        
        
        $this->j=$i;
        }
        
        $SavedloanShedule = $loandao->readLoanShedulewithemoapp($this->empno,$Lnappno);
        foreach($SavedloanShedule as $key => $row){ 
            $grid1[$key][0]=$row['ln_pay_sch_date'];
            $grid1[$key][1]=$row['ln_starting_bal_amt'];
            $grid1[$key][2]=$row['ln_sch_cap_amt'];
            $grid1[$key][3]=$row['ln_intrest_amt'];
            $grid1[$key][4]=$row['ln_sch_inst_amount'];
            $grid1[$key][5]=$row['ln_cum_interest_amt'];
            $grid1[$key][6]=$row['ln_end_bal_amt'];
            $grid1[$key][7]=NULL;
            $grid1[$key][8]=NULL;
            $grid1[$key][9]=NULL;
            $grid1[$key][10]=NULL;
            $grid1[$key][11]=NULL;
            $grid1[$key][12]=NULL;
            $grid1[$key][13]=NULL;
            $grid1[$key][14]=NULL;
            $grid1[$key][15]=NULL;
            $grid1[$key][16]=NULL;
            $grid1[$key][17]=NULL;
            $grid1[$key][18]=NULL;
            $grid1[$key][19]=NULL;
            $grid1[$key][20]=NULL;            
            $grid1[$key][21]=NULL;
            $grid1[$key][22]=$row['ln_pay_by_com'];
            $grid1[$key][23]=$row['ln_check_no'];
            $grid1[$key][24]=$row['ln_usr_pay_amt'];
            $grid1[$key][25]=$row['ln_end_bal_r_amt'];
            $grid1[$key][26]=$row['ln_pay_by_com_date'];
            $grid1[$key][27]=$row['ln_pay_check_no'];
            $grid1[$key][28]=$row['ln_bal_pay_com_date'];
            $grid1[$key][29]=$row['ln_sch_is_processed'];

            
        }
        
        if($grid1== null){
            echo json_encode($grid);
        }else{
            echo json_encode($grid1);
        }
        
        //$this->grid=$grid1;
        //die(print_r($grid1));
        //die(print_r($SavedloanShedule));
        //echo json_encode($grid1);
        die;

    }
    
   public function add($date_str, $months)
{
    $date = new DateTime($date_str);
    $start_day = $date->format('j');

    $date->modify("+{$months} month");
    $end_day = $date->format('j');

    if ($start_day != $end_day)
        $date->modify('last day of last month');

    return $date;
} 

   public function splitnumber($num){
           $Number[0] = floor( $num );    
           $Number[1] = $num - $Number[0]; 
           $Number[1]=$this->roundnumber2($Number[1]);
           return $Number; 
   }
   
    public function roundnumber2($num){
        $Rnum=round($num, 2);
        return $Rnum; 
   }
   
   public function roundnumber($num){
        $Rnum=round($num, 0);
        return $Rnum; 
   }
    
    
    
    /**
     * Set message
     */
    public function setMessage($messageType, $message = array()) {
        $this->getUser()->setFlash('messageType', $messageType);
        $this->getUser()->setFlash('message', $message);
    }

}
