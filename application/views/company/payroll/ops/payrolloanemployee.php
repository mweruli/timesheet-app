<?php
if (empty($employeevaluesprofile)) {
    $employeevaluesprofile = array();
}
$employee = $controller->gettablecolumns('users');
$user_payments = $controller->gettablecolumns('user_payments');
$user_experience = $controller->gettablecolumns('user_experience');
$userdepartments = $controller->allselectablebytablewhere('departments', 'id', printvalues('department_id', $employeevaluesprofile));
if (!empty($userdepartments)) {
    $departments = printvalues('department', $userdepartments[0]);
} else {
    $departments = 'Update';
}
$data['departments'] = $departments;
$data['employeevaluesprofile'] = $employeevaluesprofile;
//Step One
$user_paymentsvalues = $this->session->flashdata('user_payments');
if (empty($user_paymentsvalues)) {
    $user_paymentsvalues = array();
} else {
    $user_paymentsvalues = $user_paymentsvalues[0];
}
?>
<div class="row">
    <div class="col-md-3">
        <p class="statusMsg"></p>
        <?php echo $this->load->view('company/payroll/profile/employeeprofile', $data, TRUE); ?>
    </div>
    <div class="col-md-9">
        <div class="panel-group accordion" id="accordion">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <i class="icon-arrow"></i>Payments
                        </a>
                    </h5>
                </div>
                <div id="collapse1" class="collapse in">
                    <p class="updatepersone"></p>
                    <form id="paymentpayroll" role="form" method="post" class="form-horizontal" enctype="multipart/form-data" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >
                                <input type="hidden"  id="id" name="id"  class="form-control" value="<?= printvalues('id', $employeevaluesprofile) ?>">
                                <div <?= hideorshow(array_keyvaluen($employee, 'basicpay')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Basic Pay
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Basic Pay" id="basicpay" name="basicpay" class="form-control"  value="<?= printvalues('basicpay', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'nssfamount')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        NSSF
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="NSSF AMOUNT" id="nssfamount" name="nssfamount" class="form-control"  value="<?= printvalues('nssfamount', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'houseallowance')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        House Allowance
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="House Allowance" id="houseallowance" name="houseallowance" class="form-control"  value="<?= printvalues('houseallowance', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'payfrequency_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Pay Frequency
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="payfrequency_id" id="payfrequency_id"  >
                                            <option value="">-SELECT Pay Frequency-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('paymentfrequency') as $paymentfrequency) {
                                                ?>
                                                <option value="<?= $paymentfrequency['id'] ?>"><?= $paymentfrequency['frequency'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'bank_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Bank
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="bank_id" id="bank_id"  onChange="getmebankbranch();" >
                                            <option value="">-SELECT Bank-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('banks') as $banks) {
                                                ?>
                                                <option value="<?= $banks['id'] ?>"><?= $banks['bank'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'bankbranch_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Bank Branch
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="bankbranch_id" id="bankbranch_id"  >
                                            <option value="">-SELECT Bank Branch-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'relief')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Relief
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Relief Amount" id="relief" name="relief" class="form-control"  value="<?= printvalues('relief', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'accountname')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Account Name
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Account Name" id="accountname" name="accountname" class="form-control"  value="<?= printvalues('accountname', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'voluntarynssf')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Voluntary NSSF
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="First Name" id="voluntarynssf" name="voluntarynssf" class="form-control"  value="<?= printvalues('voluntarynssf', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'accountnumber')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Account No
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Account Number" id="accountnumber" name="accountnumber" class="form-control"  value="<?= printvalues('accountnumber', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'paymentmode_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Payment Mode
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="paymentmode_id" id="paymentmode_id">
                                            <option value="">-SELECT Payment Mode-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('paymentmodes') as $paymentmodes) {
                                                ?>
                                                <option value="<?= $paymentmodes['id'] ?>"><?= $paymentmodes['paymentmode'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'currency_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Currency
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="paymentmode_id" id="paymentmode_id">
                                            <option value="">-SELECT Currency-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('currencies') as $currencies) {
                                                ?>
                                                <option value="<?= $currencies['id'] ?>"><?= $currencies['currency'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label">
                                    PAYE
                                </label>
                                <div class="col-sm-4">
                                    <div class="btn-group" id="status" data-toggle="buttons">
                                        <label class="btn btn-default btn-on <?php
                                        if (printvalues('payestate', $employeevaluesprofile) == 1) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="1" name="payestate"  <?php
                                            if (printvalues('payestate', $employeevaluesprofile) == 1) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>YES</label>
                                        <label class="btn btn-default btn-off <?php
                                        if (printvalues('payestate', $employeevaluesprofile) == 0) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="0" name="payestate" <?php
                                            if (printvalues('payestate', $employeevaluesprofile) == 0) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>NO</label>
                                    </div>
                                </div>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    NHIF
                                </label>
                                <div class="col-sm-4">
                                    <div class="btn-group" id="status" data-toggle="buttons">
                                        <label class="btn btn-default btn-on <?php
                                        if (printvalues('nhifstate', $employeevaluesprofile) == 1) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="1" name="nhifstate"  <?php
                                            if (printvalues('nhifstate', $employeevaluesprofile) == 1) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>YES</label>
                                        <label class="btn btn-default btn-off <?php
                                        if (printvalues('nhifstate', $employeevaluesprofile) == 0) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="0" name="nhifstate" <?php
                                            if (printvalues('nhifstate', $employeevaluesprofile) == 0) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>NO</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2" id="allowendeid">
                            <i class="icon-arrow"></i> Allowances
                        </a>
                    </h5>
                </div>
                <div id="collapse2" class="collapse">
                    <form id="allowancesrollform" role="form" method="post" class="form-horizontal" enctype="multipart/form-data" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >
                                <input type="hidden"  id="id" name="id"  class="form-control" value="<?= printvalues('id', $employeevaluesprofile) ?>">
                                <div <?= hideorshow(array_keyvaluen($employee, 'basicpay')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Allowance
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="allowance_id" id="allowance_id">
                                            <option value="">-SELECT Currency-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('allowances') as $allowances) {
                                                ?>
                                                <option value="<?= $allowances['id'] ?>"><?= $allowances['allowance'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'nssfamount')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Amount
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="AMOUNT" id="nssfamount" name="allowanceamount" class="form-control"  value="<?= printvalues('nssfamount', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'houseallowance')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Year
                                    </label>                   
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" data-date-format="yyyy" data-date-viewmode="years"  id="yearallowance" name="yearallowance" class="form-control date-picker">
                                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                        </div>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'houseallowance')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        MONTH
                                    </label>                   
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" data-date-format="mm" data-date-viewmode="months"  id="monthallowance" name="monthallowance" class="form-control date-picker">
                                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'bank_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Ref No.
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Refrence Number" id="refnoallowance" name="refnoallowance" class="form-control"  value="<?= printvalues('relief', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'bankbranch_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Narration
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Narration" id="narration" name="narration" class="form-control"  value="<?= printvalues('relief', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3" id="userexperience">
                            <i class="icon-arrow"></i> Loans
                        </a>
                    </h5>
                </div>
                <div id="collapse3" class="collapse">
                    <p class="updatepersone"></p>
                    <form id="loansrollform" role="form" method="post" class="form-horizontal" enctype="multipart/form-data" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >
                                <input type="hidden"  id="id" name="id"  class="form-control" value="<?= printvalues('id', $employeevaluesprofile) ?>">
                                <div <?= hideorshow(array_keyvaluen($employee, 'basicpay')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Loan Type
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="loantype_id" id="loantype_id">
                                            <option value="">-SELECT Loan Type-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('loantypes') as $allowances) {
                                                ?>
                                                <option value="<?= $allowances['id'] ?>"><?= $allowances['loantype'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'nssfamount')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Principal Deducted
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="AMOUNT" id="principaldeduc" name="principaldeduc" class="form-control"  value="<?= printvalues('nssfamount', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'houseallowance')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Year
                                    </label>                   
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" data-date-format="yyyy" data-date-viewmode="years"  id="yearsloan" name="yearsloan" class="form-control date-picker">
                                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                        </div>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'houseallowance')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        MONTH
                                    </label>                   
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" data-date-format="mm" data-date-viewmode="months"  id="monthloan" name="monthloan" class="form-control date-picker">
                                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'bank_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Monthly Deduction
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="MONTHLY DEDUC AMOUNT" id="monthdeduc" name="monthdeduc" class="form-control"  value="<?= printvalues('relief', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                            <i class="icon-arrow"></i>Commission
                        </a>
                    </h5>
                </div>
                <div id="collapse4" class="panel-collapse collapse">
                    <p class="updatepersone"></p>
                    <form id="commissionrollform" role="form" method="post" class="form-horizontal" enctype="multipart/form-data" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >
                                <input type="hidden"  id="id" name="id"  class="form-control" value="<?= printvalues('id', $employeevaluesprofile) ?>">
                                <div <?= hideorshow(array_keyvaluen($employee, 'basicpay')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Allowance
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="commissions_id" id="commissions_id">
                                            <option value="">-SELECT Allowance-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('commissions') as $allowances) {
                                                ?>
                                                <option value="<?= $allowances['id'] ?>"><?= $allowances['commission'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_payments, 'nssfamount')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Amount
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="AMOUNT" id="commisionamount" name="commisionamount" class="form-control"  value="<?= printvalues('nssfamount', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'houseallowance')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Year
                                    </label>                   
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" data-date-format="yyyy" data-date-viewmode="years"  id="yearcommision" name="yearcommision" class="form-control date-picker">
                                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                        </div>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'houseallowance')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        MONTH
                                    </label>                   
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" data-date-format="mm" data-date-viewmode="months"  id="monthcommision" name="monthcommision" class="form-control date-picker">
                                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'bank_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Ref No.
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Refrence Number" id="refnocommision" name="refnocommision" class="form-control"  value="<?= printvalues('relief', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'bankbranch_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Narration
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Narration" id="narrationcommision" name="narrationcommision" class="form-control"  value="<?= printvalues('relief', $user_paymentsvalues) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexthree">
                            <i class="icon-arrow"></i>
                            Pension
                        </a>
                    </h5>
                </div>
                <div id="collapsexthree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group" >

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexfour">
                            <i class="icon-arrow"></i> Relief
                        </a>
                    </h5>
                </div>
                <div id="collapsexfour" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group" >

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexfive">
                            <i class="icon-arrow"></i>Sacco
                        </a>
                    </h5>
                </div>
                <div id="collapsexfive" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group" >

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexsix">
                            <i class="icon-arrow"></i>Custom Parameters
                        </a>
                    </h5>
                </div>
                <div id="collapsexsix" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexone">
                            <i class="icon-arrow"></i>Non Cash Benefits
                        </a>
                    </h5>
                </div>
                <div id="collapsexone" class="collapse">
                    <form id="referencesform" role="form" method="post" class="form-horizontal" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        var useridpayroll = sessionStorage.getItem("useridpayroll");
        var useridpayrollloan = sessionStorage.getItem("useridpayrollloan");
        if (useridpayroll) {
            sessionStorage.removeItem("useridpayroll");
            var l = document.getElementById('payrollmasteridtab');
            l.click();
        } else if (useridpayrollloan) {
            sessionStorage.removeItem("useridpayrollloan");
            var l = document.getElementById('loanpayrollid');
            l.click();
        }
    };
</script>