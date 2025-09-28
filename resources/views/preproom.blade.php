    <section class="content">
        <div class="box box-info">
            <form action="/admin/add_loan_product.php" class="form-horizontal" method="post" enctype="multipart/form-data"
                onSubmit="return selectAll()" id="form">
                <input type="hidden" name="back_url" value="https://x.loandisk.com/admin/view_loan_products.php">
                <input type="hidden" name="add_loan_product" value="1">
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="panel-body bg-gray text-bold">Required Field:</div>
                    </div>
                    <div class="form-group">

                        <label for="inputName" class="col-sm-3 control-label">Loan Product Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="loan_product_name" class="form-control" id="inputName"
                                placeholder="Loan Product Name" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputBranch" class="col-sm-3 control-label">Access to Branch</label>
                        <div class="col-sm-9">
                            <select data-placeholder="Select Branches" class="form-control branches_select"
                                id="BranchSelect" name="branches[]" multiple>
                                <option value="78560"> Branch #1</option>
                            </select>
                            <div class="callout callout-danger">
                                <p><b>Warning:</b> Click in the box above to select multiple branches. If you do not
                                    select any branch, then this loan product will not be available to any branch.</p>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(function() {
                            //Initialize Select2 Elements
                            $(".branches_select").select2({
                                placeholder: "Select a branch"

                                    ,
                                allowClear: true
                            });

                        });
                    </script>
                    <div class="row row-grid">
                        <div id="pre_loader_loan_product" style="display: none;">
                            <div style="text-align:center; font-weight:bold;font-style:italic;"><i
                                    class='fa fa-spinner fa-spin '></i> Loading Loan Details. Please Wait..<br><br>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body bg-gray text-bold">Advance Settings (optional):</div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5 margin">
                            <label class="text-bold text-blue">
                                <h4><input type="checkbox" name="loan_enable_parameters" value="Show"
                                        class="show_hide"> <b>Enable Below Parameters</b></h4>
                            </label>
                        </div>
                    </div>
                    <div class="well well-sm">Please note that all of the below fields are optional. You can leave the
                        fields empty if you do not want to place any restriction.</div>
                    <div class="slidingDiv">
                        <hr>
                        <p class="text-red margin"><b>Loan Release Date:</b></p>
                        <div class="form-group">

                            <label for="inputDefaultLoanReleasedDate" class="col-sm-3 control-label">Set Loan Released
                                Date to Today's date</label>
                            <div class="col-sm-5">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="default_loan_released_date"
                                            id="inputDefaultLoanReleasedDateNo" value="0" checked> No

                                    </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="default_loan_released_date"
                                            id="inputDefaultLoanReleasedDateYes" value="1"> Yes

                                    </label>
                                </div>
                                If you select Yes, the Loan Released Date on the Add Loan page will be auto-filled with
                                today's date.
                            </div>
                        </div>

                        <hr>
                        <p class="text-red margin"><b>Principal Amount:</b></p>

                        <div class="form-group">
                            <label for="inputDisbursedById" class="col-sm-3 control-label">Disbursed By</label>
                            <div class="col-sm-5">
                                <div class="checkbox">
                                    <label>
                                        <input class="inputDisbursedById" type="checkbox" name="loan_disbursed_by_id[]"
                                            value="1"> Cash
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="inputDisbursedById" type="checkbox" name="loan_disbursed_by_id[]"
                                            value="2"> M-pesa
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="inputDisbursedById" type="checkbox" name="loan_disbursed_by_id[]"
                                            value="3"> Wire Transfer
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="inputDisbursedById" type="checkbox" name="loan_disbursed_by_id[]"
                                            value="4"> Online Transfer
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="inputMinLoanPrincipalAmount" class="col-sm-3 control-label">Minimum Principal
                                Amount</label>
                            <div class="col-sm-5">
                                <input type="text" name="min_loan_principal_amount" class="form-control numeral"
                                    id="inputMinLoanPrincipalAmount" placeholder="Minimum Amount" value="">
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputDefaultLoanPrincipalAmount" class="col-sm-3 control-label">Default
                                Principal Amount</label>
                            <div class="col-sm-5">
                                <input type="text" name="default_loan_principal_amount"
                                    class="form-control numeral" id="inputDefaultLoanPrincipalAmount"
                                    placeholder="Default Amount" value="">
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputMaxLoanPrincipalAmount" class="col-sm-3 control-label">Maximum Principal
                                Amount</label>
                            <div class="col-sm-5">
                                <input type="text" name="max_loan_principal_amount" class="form-control numeral"
                                    id="inputMaxLoanPrincipalAmount" placeholder="Maximum Amount" value="">
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Interest:</b></p>
                        <div class="form-group">
                            <label for="inputLoanInterestMethod" class="col-sm-3 control-label">Interest
                                Method</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="loan_interest_method" id="inputLoanInterestMethod"
                                    onChange="enableDisableMethod();">
                                    <option value=""></option>
                                    <option value="flat_rate"> Flat Rate</option>
                                    <option value="reducing_rate_equal_installments">Reducing Balance - Equal
                                        Installments</option>
                                    <option value="reducing_rate_equal_principal">Reducing Balance - Equal Principal
                                    </option>
                                    <option value="interest_only">Interest-Only</option>
                                    <option value="compound_interest_new">Compound Interest - Accrued</option>
                                    <option value="compound_interest">Compound Interest - Equal Installments</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanInterestType" class="col-sm-3 control-label">Interest Type</label>
                            <div class="col-sm-5">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="loan_interest_type"
                                            id="inputInterestTypePercentage" value="percentage" checked> I want
                                        Interest to be percentage % based

                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="loan_interest_type" id="inputInterestTypeFixed"
                                            value="fixed"> I want Interest to be a fixed amount Per Cycle

                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanInterestPeriod" id="inputLoanInterestLabel"
                                class="col-sm-3 control-label">Loan Interest Period</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="loan_interest_period" id="inputLoanInterestPeriod"
                                    onChange="setInterestPeriod();">
                                    <option value=""></option>
                                    <option value="Day">Per Day</option>
                                    <option value="Week">Per Week</option>
                                    <option value="Month">Per Month</option>
                                    <option value="Year">Per Year</option>
                                    <option value="Loan">Per Loan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMinLoanInterest" id="inputMinLoanInterestLabel"
                                class="col-sm-3 control-label">Minimum Loan Interest</label>
                            <div class="col-sm-2">
                                <input type="text" name="min_loan_interest" class="form-control decimal-4-places"
                                    id="inputMinLoanInterest" placeholder="" value="">
                            </div>
                            <div class="col-sm-3">
                                <div id="inputMinInterestPeriod" class="margin">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDefaultLoanInterest" id="inputDefaultLoanInterestLabel"
                                class="col-sm-3 control-label">Default Loan Interest</label>
                            <div class="col-sm-2">
                                <input type="text" name="default_loan_interest"
                                    class="form-control decimal-4-places" id="inputDefaultLoanInterest"
                                    placeholder="" value="">
                            </div>
                            <div class="col-sm-3">
                                <div id="inputDefaultInterestPeriod" class="margin">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMaxLoanInterest" id="inputMaxLoanInterestLabel"
                                class="col-sm-3 control-label">Maximum Loan Interest</label>
                            <div class="col-sm-2">
                                <input type="text" name="max_loan_interest" class="form-control decimal-4-places"
                                    id="inputMaxLoanInterest" placeholder="" value="">
                            </div>
                            <div class="col-sm-3">
                                <div id="inputMaxInterestPeriod" class="margin">

                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Duration:</b></p>
                        <div class="form-group">

                            <label for="inputLoanDurationPeriod" class="col-sm-3 control-label">Loan Duration
                                Period</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="loan_duration_period" id="inputLoanDurationPeriod"
                                    onChange="setLoanDurationPeriod()">
                                    <option value=""></option>
                                    <option value="Days">Days</option>
                                    <option value="Weeks">Weeks</option>
                                    <option value="Months">Months</option>
                                    <option value="Years">Years</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputMinLoanDuration" class="col-sm-3 control-label">Minimum Loan
                                Duration</label>

                            <div class="col-sm-2">
                                // get from repayment_durations table model in database, recrecte the section
                                dynamically
                                <select class="form-control" name="min_loan_duration" id="inputMinLoanDuration">
                                    <option value="">Any</option>
                                    <option value="1">1</option>

                                </select>

                            </div>
                            <div class="col-sm-3">
                                <div id="inputMinLoanDurationPeriod" class="margin">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputDefaultLoanDuration" class="col-sm-3 control-label">Default Loan
                                Duration</label>
                            <div class="col-sm-2">
                                // get from repayment_durations table model in database, recrecte the section
                                dynamically
                                <select class="form-control" name="default_loan_duration"
                                    id="inputDefaultLoanDuration">
                                    <option value="">Any</option>
                                    <option value="1">1</option>

                                </select>

                            </div>
                            <div class="col-sm-3">
                                <div id="inputDefaultLoanDurationPeriod" class="margin">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputMaxLoanDuration" class="col-sm-3 control-label">Maximum Loan
                                Duration</label>
                            <div class="col-sm-2">
                                // get from repayment_durations table model in database, recrecte the section
                                dynamically
                                <select class="form-control" name="max_loan_duration" id="inputMaxLoanDuration"
                                    onChange="setMaxLoanDurationPeriod()">
                                    <option value="">Any</option>
                                    <option value="1">1</option>

                                </select>

                            </div>
                            <div class="col-sm-3">
                                <div id="inputMaxLoanDurationPeriod" class="margin">

                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Repayments:</b></p>
                        <div class="form-group">
                            <label for="inputLoanPaymentSchemeId" class="col-sm-3 control-label">Repayment
                                Cycle</label>
                            //get from repayment_durations table model in database, recrecte the section dynamically
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="6"> Daily
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="4"> Weekly
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="9"> Biweekly
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="3"> Monthly
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="12"> Bimonthly
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="13"> Quarterly
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="781"> Every 4 Months
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="14"> Semi-Annual
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="1943"> Every 9 Months
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="11"> Yearly
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="classLoanPaymentSchemeId" type="checkbox"
                                            name="loan_payment_scheme_id[]" value="10"> Lump-Sum
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputMinLoanNumOfRepayments" class="col-sm-3 control-label">Minimum Number of
                                Repayments</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="min_loan_num_of_repayments"
                                    id="inputMinLoanNumOfRepayments" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDefaultLoanNumOfRepayments" class="col-sm-3 control-label">Default Number
                                of Repayments</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="default_loan_num_of_repayments"
                                    id="inputDefaultLoanNumOfRepayments" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMaxLoanNumOfRepayments" class="col-sm-3 control-label">Maximum Number of
                                Repayments</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="max_loan_num_of_repayments"
                                    id="inputMaxLoanNumOfRepayments" value="">
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Loan Due and Loan Schedule Amounts:</b></p>
                        <div class="well">
                            If Loan Due amount and/or Schedule amounts are in decimals for example $100.33333, the
                            system will convert them based on below option.
                        </div>
                        <div class="form-group">
                            <label for="inputLoanDecimalPlaces" class="col-sm-3 control-label">Decimal Places</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="loan_decimal_places" id="inputLoanDecimalPlaces">
                                    <option value=""></option>
                                    <option value="round_off_to_two_decimal">Round Off to 2 Decimal Places</option>
                                    <option value="round_off_to_integer">Round Off to Integer</option>
                                    <option value="round_down_to_integer">Round Down to Integer</option>
                                    <option value="round_up_to_integer">Round Up to Integer</option>
                                    <option value="round_off_to_one_decimal">Round Off to 1 Decimal Place</option>
                                    <option value="round_up_to_one_decimal">Round Up to 1 Decimal Place</option>
                                    <option value="round_up_to_five">Round Off to Nearest 5</option>
                                    <option value="round_up_to_ten">Round Up to Nearest 10</option>
                                    <option value="round_off_to_hundred">Round Off to Nearest 100</option>
                                </select>
                            </div>
                            <div class="col-sm-offset-3 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="inputLoanDecimalPlacesAdjustEachReaypment"
                                            name="loan_decimal_places_adjust_each_interest" value="1"> Round
                                        Up/Off Interest for all repayments in the loan schedule even if it exceeds total
                                        interest of loan.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Repayment Order:</b></p>
                        <div class="well">
                            The order in which repayments are allocated. For example let's say you receive payment of
                            $100 and order is <b>Fees</b>, <b>Principal</b>, <b>Interest</b>, <b>Penalty</b>. Based on
                            the loan schedule, the system will allocate the amount to <b>Fees</b> first and remaining
                            amount to <b>Principal</b> and then <b>Interest</b> and then <b>Penalty</b>.
                        </div>

                        <div class="form-group">
                            <label for="inputLoanRepaymentOrder" class="col-sm-3 control-label">Repayment
                                Order</label>
                            <div class="col-xs-6">
                                <select multiple id="to" size="7" name="repayment_order[]">
                                    <option value="Penalty">Penalty</option>
                                    <option value="Fees">Fees</option>
                                    <option value="Interest">Interest</option>
                                    <option value="Principal">Principal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <input type="button" value="Up" onclick="up()">
                            <input type="button" value="Down" onclick="down()">
                        </div>
                        <br><br>
                        <div class="col-sm-offset-3 col-sm-9">
                            <b>Please note:</b> If you change the above order, all Open loans will be updated with the
                            new Repayment Order and Fee Order
                        </div>
                        <br><br>
                        <hr>
                        <p class="text-red margin"><b>Automated Payments:</b></p>
                        <div class="well">
                            If you select <b>Yes</b> below, the system will automatically add due payments on the
                            schedule dates for loans added in this loan product. This is useful if you expect to receive
                            payments <u>on time</u> for the loans. For example, you may have a direct deposit or payroll
                            system which automatically deducts payment from the borrower on the scheduled dates. This
                            will save you time from having to manually add payments on Loandisk on the scheduled dates.
                        </div>
                        <div class="form-group">
                            <label for="inputAutomaticPayments" class="col-sm-3 control-label">Add Automatic
                                Payments</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="automatic_payments" id="inputAutomaticPaymentsNo"
                                            value="0" checked> No

                                    </label>

                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="automatic_payments"
                                            id="inputAutomaticPaymentsYes" value="1"> Yes

                                    </label>
                                </div>
                                If you select Yes, the system will automatically add the due payments on every repayment
                                cycle based on the scheduled dates.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPaymentPostingPeriod" class="col-sm-3 control-label">Time to Post
                                between</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="payment_posting_period"
                                    id="inputPaymentPostingPeriod">
                                    <option value="0" selected>
                                    <option value="1">12.01am - 04.00am</option>
                                    <option value="2">04.01am - 08.00am</option>
                                    <option value="3">08.01am - 12.00pm</option>
                                    <option value="4">12.01pm - 04.00pm</option>
                                    <option value="5">04.01pm - 08.00pm</option>
                                    <option value="6">08.01pm - 11.59pm</option>
                                </select>
                                The payment will be added between the above selected times. If you change <b>Add
                                    Automatic Payments</b> to <b>No</b> before this time on the scheduled date, the
                                system will not add the payment.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAutomaticPaymentsDeaCashBankAccount"
                                class="col-sm-3 control-label">Cash/Bank</label>
                            <div class="col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="automated_payments_dea_cash_bank_account[]"
                                            value="0"> Cash
                                    </label>
                                </div>
                                <small><a
                                        href="https://x.loandisk.com/accounting/dea/bank_accounts/view_bank_accounts.php"
                                        target="_blank">Add/Edit Bank Accounts</a></small>
                                <br>Select the bank account where the money will be received. This will allow the system
                                to make the proper journal entry.
                            </div>
                        </div>
                        <hr>
                        <hr>
                        <p class="text-red margin"><b>Fees:</b> <a class="btn btn-primary btn-xs pull-right"
                                data-toggle="collapse" data-target="#loan_fee_schedule">Help</a></p>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div id="loan_fee_schedule" class="collapse panel panel-default">
                                    <div class="panel-heading">There are 2 types of Loan Fees:</div>
                                    <div class="panel-body">
                                        <ul>
                                            <li><strong>Non Deductable Fees</strong>
                                                <br>The loan fee will be added to the total loan due (Principal Amount +
                                                Interest + Penalty) and the borrower will have to pay back this fee. You
                                                will see a <u>schedule box</u> next to <strong>Non Deductable
                                                    Fees</strong> on how the fees should be shown in the loan schedule.
                                                You can select from:<br>

                                                <ul>
                                                    <li><strong>Don't add to schedule - I'll edit the schedule and enter
                                                            fees manually</strong>
                                                        <br>The fee will not be included in the loan schedule. You will
                                                        have to manually edit the loan schedule and add the fee.
                                                        <br>
                                                        <br>
                                                    </li>
                                                    <li><strong>Distribute Fee Evenly Among All Repayments</strong>
                                                        <br>For example, if the fee entered is 1,000 and there are 10
                                                        due repayments in the loan schedule, each repayment will have
                                                        100 fee added to it (1,000/10).
                                                        <br>
                                                        <br>
                                                    </li>
                                                    <li><strong>Charge Fee on the Released Date<br></strong>For example,
                                                        if the fee entered is 1,000, a due repayment of 1,000 will be
                                                        added in the loan schedule on the loan released date.
                                                        <br>
                                                        <br>
                                                    </li>
                                                    <li><strong>Charge Fee on the First Repayment<br></strong>For
                                                        example, if the fee entered is 1,000, the first repayment in the
                                                        loan schedule will have 1,000 fee added to it.
                                                        <br>
                                                        <br>
                                                    </li>
                                                    <li><strong>Charge Fee on the Last Repayment<br></strong>For
                                                        example, if the fee entered is 1,000, the last repayment in the
                                                        loan schedule will have 1,000 fee added to it.
                                                        <br>
                                                        <br>
                                                    </li>
                                                    <li><strong>Charge Same Fee on All Repayments<br></strong>For
                                                        example, if the fee entered is 1,000 and there are 10 due
                                                        repayments in the loan schedule, each repayment will have 1,000
                                                        fee added to it. Hence the total fee will be 10,000 (1,000 x
                                                        10).
                                                        <br>
                                                        <br>
                                                    </li>
                                                    <li><strong>Used for Lump-Sum Loans<br></strong>This option can only
                                                        be used if you have selected <b>Lump-Sum</b> in <b>Repayment
                                                            Cycle</b>. Let's say you have a lump-sum loan for 3 months
                                                        duration. So in the <b>Loan Duration</b> field, you will select
                                                        3 months. The loan will only have 1 repayment cycle at end of 3
                                                        months but you want the fee to be calculated for each duration
                                                        and then the total should be added at end of 3 months. So if the
                                                        fee is 1000, a total of 3000(1000 x 3 months) will be added at
                                                        end of 3 months with this option.
                                                        <br>
                                                        <br>
                                                    </li>
                                                    <li>
                                                        If you have selected <b>percentage</b> based fees, you will see
                                                        the following option:<br><br>
                                                        <b>Useful for Tax Calculations:</b><br>
                                                        You can charge fees for each repayment based on the amount due
                                                        in that repayment. Let's assume that $100 Principal is due on
                                                        first installment and $50 Principal is due on second installment
                                                        and fee is 10%. In this case, $10 (10% of $100) will be added
                                                        for first installment and $5 (10% of $50) will be added for
                                                        second installment.<br>
                                                        <ul>
                                                            <li>Charge Fee Each Repayment on the Due Principal Amount
                                                            </li>
                                                            <li>Charge Fee Each Repayment on the Due Interest Amount
                                                            </li>
                                                            <li>Charge Fee Each Repayment on the Due Principal and
                                                                Interest Amount</li>
                                                        </ul>
                                                        <br>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><strong>Deductable Fees</strong>

                                                <ul>
                                                    <li>The loan fee will <u><strong>NOT</strong></u> be added to the
                                                        loan due. It is assumed that the borrower has already paid back
                                                        this fee. Many cooperative lending companies use deducable fees.
                                                    </li>
                                                    <li>For example, if you give a loan for $1000 and the deductable fee
                                                        is $10. Then the actual principal amount that is given to
                                                        borrower would be $1000 - $10 = <u>$990</u>. But the borrower
                                                        still has to pay back <u>$1000</u>. So even though you only gave
                                                        $990 to the borrower, he/she has to pay back $1000.</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p><b>You don't have any fees.</b> <a href="https://x.loandisk.com/admin/view_loan_fees.php"
                                target="_blank">Click here to setup fees.</a></p>
                        <p class="text-red margin"><b>Extend Loan After Maturity Until Fully Paid:</b></p>

                        <div class="well">If you select <b>Yes</b> below, the system will automatically add interest
                            after the maturity date if the loan is not fully paid.</div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Extend Loan After Maturity</label>
                            <div class="col-sm-5">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="after_maturity_extend_loan" value="0"
                                            id="inputExtendLoanNo" checked>No
                                    </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="after_maturity_extend_loan" value="1"
                                            id="inputExtendLoanYes">Yes
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Interest Type</label>
                            <div class="col-sm-7">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="after_maturity_percentage_or_fixed"
                                            id="inputAmPercentage" value="percentage" checked>
                                        I want Interest to be percentage % based
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="after_maturity_percentage_or_fixed"
                                            id="inputAmFixed" value="fixed"> I want Interest to be a fixed amount

                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" id="inputAMCalculateInterestOnLabel"
                                class="col-sm-3 control-label">Calculate Interest on</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="after_maturity_calculate_interest_on"
                                    id="inputAmCalculateInterestOn">

                                    <option value="0" selected></option>
                                    <option value="1">Overdue Principal Amount</option>
                                    <option value="7">Overdue Interest Amount</option>
                                    <option value="2">Overdue (Principal + Interest) Amount</option>
                                    <option value="3">Overdue (Principal + Interest + Fees) Amount</option>
                                    <option value="6">Overdue (Principal + Interest + Penalty) Amount</option>
                                    <option value="4">Overdue (Principal + Interest + Fees + Penalty) Amount
                                    </option>
                                    <option value="8">Overdue (Interest + Fees) Amount</option>
                                    <option value="5">Total Principal Amount Released</option>
                                    <option value="9">Total Principal Balance Amount</option>
                                    <option value="10">Maturity Date Installment Only - Overdue Principal Amount
                                    </option>
                                    <option value="11">Maturity Date Installment Only - Overdue Interest Amount
                                    </option>
                                    <option value="12">Maturity Date Installment Only - Overdue (Principal +
                                        Interest) Amount</option>
                                    <option value="13">Maturity Date Installment Only - Overdue (Principal +
                                        Interest + Fees) Amount</option>
                                    <option value="14">Maturity Date Installment Only - Overdue (Principal +
                                        Interest + Fees + Penalty) Amount</option>
                                    <option value="15">Maturity Date Installment Only - Overdue (Interest + Fees)
                                        Amount</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAmInterest" id="inputAMInterestOrFixedLabel"
                                class="col-sm-3 control-label">Loan Interest Rate After Maturity %</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control decimal-4-places"
                                    name="after_maturity_loan_interest" id="inputAmInterest"
                                    placeholder="Numbers or decimal only" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAmRecurringPeriod" class="col-sm-3 control-label">Recurring Period After
                                Maturity</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="after_maturity_recurring_period_num"
                                    id="inputAmRecurringPeriod" value="">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="after_maturity_recurring_period_payment_scheme_id"
                                    id="inputAmLoanPaymentSchemeId">
                                    //get from after_maturity_interest_options table model in database
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAmNumOfRepayments" class="col-sm-3 control-label">Number of Repayments
                                After Maturity</label>
                            <div class="col-sm-3">
                                <input class="form-control positive-integer" name="after_maturity_num_of_repayments"
                                    id="inputAmNumOfRepayments" value="" type="text" min="1"
                                    max="2000">
                                Leave the above empty or enter 0 for unlimited number of repayments
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Include Fees After Maturity</label>

                            <div class="col-sm-9">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="after_maturity_include_fees" value="0"
                                            checked>No
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="after_maturity_include_fees" value="1">Yes
                                    </label>
                                </div>
                                Only Loan Fees that are selected as <b>Charge Same Fee on All Repayments (fixed)</b> or
                                <b>Charge Fee Each Repayment on the Due ... Amount</b> will be added.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Keep the loan status as Past Maturity
                                even after loan is extended</label>

                            <div class="col-sm-9">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="after_maturity_past_maturity_status"
                                            value="0" checked>No
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="after_maturity_past_maturity_status"
                                            value="1">Yes
                                    </label>
                                </div>
                                If you select <b>Yes</b>, the system will keep the loan status as <b>Past Maturity</b>
                                even after loan has been extended. If you select <b>No</b>, the loan will never be
                                marked as <b>Past Maturity</b> since it is constantly being extended once maturity date
                                is reached.
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Advance settings:</b></p>

                        <div class="well">Below, you can see the Advance Settings that are used on the <a
                                href="https://x.loandisk.com"/loans/add_loan.php" target="_blank">Add Loan</a> page.
                            You can see these fields by clicking on <b>Advance Settings: Show</b> on the <b>Add Loan</b>
                            page.</div>

                        <div class="form-group">
                            <label for="inputFirstRepaymentAmount" class="col-sm-3 control-label">First Repayment
                                Amount</label>
                            <div class="col-sm-6">
                                <input type="text" name="first_repayment_amount" class="form-control numeral"
                                    id="inputFirstRepaymentAmount" placeholder="First Repayment Amount"
                                    value="">
                                (Valid for Flat-Rate only)
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#first_repayment_amount">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="first_repayment_amount" class="collapse">
                                    <p><u><strong>First Repayment Amount (optional)</strong></u></p>

                                    <p>This is an optional field. Only valid for <strong>Flat-Rate</strong> interest
                                        method. You can type an amount that will be charged on the first repayment. If
                                        you leave this field empty, the first repayment amount would be calculated based
                                        on the <strong>Loan Interest</strong> and <strong>Loan Duration</strong> fields
                                        above.</p>

                                    <p>Some lending companies charge a higher amount on the first repayment to reduce
                                        risk. If you do type an amount here, the <strong>First Repayment Amount</strong>
                                        will be subtracted from the total loan due amount and the remaining amount will
                                        be divided in the repayment cycle as per the <strong>Interest Method</strong>
                                        above.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputLastRepaymentAmount" class="col-sm-3 control-label">Last Repayment
                                Amount</label>
                            <div class="col-sm-6">
                                <input type="text" name="last_repayment_amount" class="form-control numeral"
                                    id="inputLastRepaymentAmount" placeholder="Last Repayment Amount" value="">
                                (Valid for Flat-Rate only)
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#last_repayment_amount">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="last_repayment_amount" class="collapse">
                                    <p><u><strong>Last Repayment Amount (optional)</strong></u></p>

                                    <p>This is an optional field. Only valid for <strong>Flat-Rate</strong> interest
                                        method. You can type an amount that will be charged on the last repayment. If
                                        you leave this field empty, the last repayment amount would be calculated based
                                        on the <strong>Loan Interest</strong> and <strong>Loan Duration</strong> fields
                                        above.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputOverrideEachRepaymentAmount" class="col-sm-3 control-label">Override Each
                                Repayment Amount to</label>
                            <div class="col-sm-6">
                                <input type="text" name="override_each_repayment_amount"
                                    class="form-control numeral" id="inputOverrideEachRepaymentAmount"
                                    placeholder="Repayment Amount" value="">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#override_each_repayment_amount">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="override_each_repayment_amount" class="collapse">
                                    <p><strong><u>Override Each Repayment Amount to</u></strong>
                                        <br>This is an optional field. You can specify the total amount for each
                                        repayment cycle. If you leave this field empty, the system will calculate
                                        repayment amount as per the <strong>Repayment Cycle</strong> selected above.
                                    </p>
                                    <p>Some lending companies don't calculate the exact interest amount for each
                                        repayment cycle. Consider a scenario where you give a borrower $5000 for 24
                                        weeks and agree to a total repayment of $288.75 for each week. If you multiply
                                        $288.75 by 24 weeks, you get $6930. So the total interest charged is $6930-$5000
                                        = $1930. If you divide $1930 by 24 weeks, you get 80.416666666666 interest for
                                        each repayment cycle. If you enter that in <strong>Loan Interest</strong> field
                                        above (such as 80.41 or 80.42), the due amount for each repayment would not all
                                        be the same due to the rounding off error. Hence for this type of loan, you can
                                        put $288.75 in <strong>Override Each Repayment Amount to</strong> and the system
                                        will automatically calculate the interest for each repayment and do the proper
                                        rounding off. In this case, you can put 0 in <strong>Loan Interest</strong>
                                        above.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputInterestEachRepaymentProRata" class="col-sm-3 control-label">Calculate
                                Interest in Each Repayment on Pro-Rata Basis?</label>
                            <div class="col-sm-6">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="loan_interest_each_repayment_pro_rata"
                                            id="inputInterestEachRepaymentProRataNo" value="0" checked> No

                                    </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="loan_interest_each_repayment_pro_rata"
                                            id="inputInterestEachRepaymentProRataYes" value="1"> Yes
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#loan_interest_each_repayment_pro_rata">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_interest_each_repayment_pro_rata" class="collapse">
                                    <strong><u>Calculate Interest in Each Repayment on Pro-Rata Basis?</u></strong>
                                    <br>This is an optional field. If you select <b>Yes</b>, the system will calculate
                                    the interest in each repayment on pro-rata basis based on the number of days between
                                    repayment dates.<br><br>
                                    For <i>Monthly/BiMonthly/Quarterly/Every 4 Months/Semi-Annual/Every 9 Months</i>
                                    loans, the system will look at the <b>Days in a Month for Loan Interest
                                        Calculation</b> field in <a
                                        href="https://x.loandisk.com/admin/account_settings.php"
                                        target="_blank">Account Settings</a>. For <i>Yearly</i> loans, it will look at
                                    the <b>Days in a Year for Loan Interest Calculation</b> field. Then, it will
                                    calculate the daily interest by dividing the amount due by the days figure in <a
                                        href="https://x.loandisk.com/admin/account_settings.php"
                                        target="_blank">Account Settings</a>. The daily interest will then be
                                    multiplied with the number of days between repayment dates to calculate the pro-rata
                                    interest amount.<br><br>
                                    Let's assume we have a monthly cycle loan released on 1st January and the first
                                    repayment is due on 1st February for $300. Firstly, the system will divide $300/30
                                    days(<b>Days in a Month for Loan Interest Calculation</b> field in <a
                                        href="https://x.loandisk.com/admin/account_settings.php"
                                        target="_blank">Account Settings</a>) = <b>$10/day</b>. Secondly, there are
                                    <b>31 days</b> between 1st January and 1st February. To get the pro-rata amount for
                                    the first repayment, it is <b>31 days</b> x <b>$10/day</b> = $310.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanInterestSchedule" class="col-sm-3 control-label">How should Interest
                                be charged in Loan Schedule?</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="loan_interest_schedule"
                                    id="inputLoanInterestSchedule">
                                    <option value="charge_interest_normally">Include interest normally as per Interest
                                        Method</option>
                                    <option value="charge_interest_on_released_date">Charge All Interest on the
                                        Released Date</option>
                                    <option value="charge_interest_on_first_repayment">Charge All Interest on the First
                                        Repayment</option>
                                    <option value="charge_interest_on_last_repayment">Charge All Interest on the Last
                                        Repayment</option>
                                    <option value="do_not_charge_interest_on_last_repayment">Do Not Charge Interest on
                                        the Last Repayment</option>
                                    <option value="1">Do Not Charge Interest on the First 1 Repayment</option>
                                    <option value="2">Do Not Charge Interest on the First 2 Repayments</option>
                                    <option value="3">Do Not Charge Interest on the First 3 Repayments</option>
                                    <option value="4">Do Not Charge Interest on the First 4 Repayments</option>
                                    <option value="5">Do Not Charge Interest on the First 5 Repayments</option>
                                    <option value="6">Do Not Charge Interest on the First 6 Repayments</option>
                                    <option value="7">Do Not Charge Interest on the First 7 Repayments</option>
                                    <option value="8">Do Not Charge Interest on the First 8 Repayments</option>
                                    <option value="9">Do Not Charge Interest on the First 9 Repayments</option>
                                    <option value="10">Do Not Charge Interest on the First 10 Repayments</option>
                                    <option value="11">Do Not Charge Interest on the First 11 Repayments</option>
                                    <option value="12">Do Not Charge Interest on the First 12 Repayments</option>
                                    <option value="13">Do Not Charge Interest on the First 13 Repayments</option>
                                    <option value="14">Do Not Charge Interest on the First 14 Repayments</option>
                                    <option value="15">Do Not Charge Interest on the First 15 Repayments</option>
                                    <option value="16">Do Not Charge Interest on the First 16 Repayments</option>
                                    <option value="17">Do Not Charge Interest on the First 17 Repayments</option>
                                    <option value="18">Do Not Charge Interest on the First 18 Repayments</option>
                                    <option value="19">Do Not Charge Interest on the First 19 Repayments</option>
                                    <option value="20">Do Not Charge Interest on the First 20 Repayments</option>
                                    <option value="21">Do Not Charge Interest on the First 21 Repayments</option>
                                    <option value="22">Do Not Charge Interest on the First 22 Repayments</option>
                                    <option value="23">Do Not Charge Interest on the First 23 Repayments</option>
                                    <option value="24">Do Not Charge Interest on the First 24 Repayments</option>
                                    <option value="25">Do Not Charge Interest on the First 25 Repayments</option>
                                    <option value="26">Do Not Charge Interest on the First 26 Repayments</option>
                                    <option value="27">Do Not Charge Interest on the First 27 Repayments</option>
                                    <option value="28">Do Not Charge Interest on the First 28 Repayments</option>
                                    <option value="29">Do Not Charge Interest on the First 29 Repayments</option>
                                    <option value="30">Do Not Charge Interest on the First 30 Repayments</option>
                                    <option value="31">Do Not Charge Interest on the First 31 Repayments</option>
                                    <option value="32">Do Not Charge Interest on the First 32 Repayments</option>
                                    <option value="33">Do Not Charge Interest on the First 33 Repayments</option>
                                    <option value="34">Do Not Charge Interest on the First 34 Repayments</option>
                                    <option value="35">Do Not Charge Interest on the First 35 Repayments</option>
                                    <option value="36">Do Not Charge Interest on the First 36 Repayments</option>
                                    <option value="37">Do Not Charge Interest on the First 37 Repayments</option>
                                    <option value="38">Do Not Charge Interest on the First 38 Repayments</option>
                                    <option value="39">Do Not Charge Interest on the First 39 Repayments</option>
                                    <option value="40">Do Not Charge Interest on the First 40 Repayments</option>
                                    <option value="41">Do Not Charge Interest on the First 41 Repayments</option>
                                    <option value="42">Do Not Charge Interest on the First 42 Repayments</option>
                                    <option value="43">Do Not Charge Interest on the First 43 Repayments</option>
                                    <option value="44">Do Not Charge Interest on the First 44 Repayments</option>
                                    <option value="45">Do Not Charge Interest on the First 45 Repayments</option>
                                    <option value="46">Do Not Charge Interest on the First 46 Repayments</option>
                                    <option value="47">Do Not Charge Interest on the First 47 Repayments</option>
                                    <option value="48">Do Not Charge Interest on the First 48 Repayments</option>
                                    <option value="49">Do Not Charge Interest on the First 49 Repayments</option>
                                    <option value="50">Do Not Charge Interest on the First 50 Repayments</option>
                                    <option value="51">Do Not Charge Interest on the First 51 Repayments</option>
                                    <option value="52">Do Not Charge Interest on the First 52 Repayments</option>
                                    <option value="53">Do Not Charge Interest on the First 53 Repayments</option>
                                    <option value="54">Do Not Charge Interest on the First 54 Repayments</option>
                                    <option value="55">Do Not Charge Interest on the First 55 Repayments</option>
                                    <option value="56">Do Not Charge Interest on the First 56 Repayments</option>
                                    <option value="57">Do Not Charge Interest on the First 57 Repayments</option>
                                    <option value="58">Do Not Charge Interest on the First 58 Repayments</option>
                                    <option value="59">Do Not Charge Interest on the First 59 Repayments</option>
                                    <option value="60">Do Not Charge Interest on the First 60 Repayments</option>
                                    <option value="61">Do Not Charge Interest on the First 61 Repayments</option>
                                    <option value="62">Do Not Charge Interest on the First 62 Repayments</option>
                                    <option value="63">Do Not Charge Interest on the First 63 Repayments</option>
                                    <option value="64">Do Not Charge Interest on the First 64 Repayments</option>
                                    <option value="65">Do Not Charge Interest on the First 65 Repayments</option>
                                    <option value="66">Do Not Charge Interest on the First 66 Repayments</option>
                                    <option value="67">Do Not Charge Interest on the First 67 Repayments</option>
                                    <option value="68">Do Not Charge Interest on the First 68 Repayments</option>
                                    <option value="69">Do Not Charge Interest on the First 69 Repayments</option>
                                    <option value="70">Do Not Charge Interest on the First 70 Repayments</option>
                                    <option value="71">Do Not Charge Interest on the First 71 Repayments</option>
                                    <option value="72">Do Not Charge Interest on the First 72 Repayments</option>
                                    <option value="73">Do Not Charge Interest on the First 73 Repayments</option>
                                    <option value="74">Do Not Charge Interest on the First 74 Repayments</option>
                                    <option value="75">Do Not Charge Interest on the First 75 Repayments</option>
                                    <option value="76">Do Not Charge Interest on the First 76 Repayments</option>
                                    <option value="77">Do Not Charge Interest on the First 77 Repayments</option>
                                    <option value="78">Do Not Charge Interest on the First 78 Repayments</option>
                                    <option value="79">Do Not Charge Interest on the First 79 Repayments</option>
                                    <option value="80">Do Not Charge Interest on the First 80 Repayments</option>
                                    <option value="81">Do Not Charge Interest on the First 81 Repayments</option>
                                    <option value="82">Do Not Charge Interest on the First 82 Repayments</option>
                                    <option value="83">Do Not Charge Interest on the First 83 Repayments</option>
                                    <option value="84">Do Not Charge Interest on the First 84 Repayments</option>
                                    <option value="85">Do Not Charge Interest on the First 85 Repayments</option>
                                    <option value="86">Do Not Charge Interest on the First 86 Repayments</option>
                                    <option value="87">Do Not Charge Interest on the First 87 Repayments</option>
                                    <option value="88">Do Not Charge Interest on the First 88 Repayments</option>
                                    <option value="89">Do Not Charge Interest on the First 89 Repayments</option>
                                    <option value="90">Do Not Charge Interest on the First 90 Repayments</option>
                                    <option value="91">Do Not Charge Interest on the First 91 Repayments</option>
                                    <option value="92">Do Not Charge Interest on the First 92 Repayments</option>
                                    <option value="93">Do Not Charge Interest on the First 93 Repayments</option>
                                    <option value="94">Do Not Charge Interest on the First 94 Repayments</option>
                                    <option value="95">Do Not Charge Interest on the First 95 Repayments</option>
                                    <option value="96">Do Not Charge Interest on the First 96 Repayments</option>
                                    <option value="97">Do Not Charge Interest on the First 97 Repayments</option>
                                    <option value="98">Do Not Charge Interest on the First 98 Repayments</option>
                                    <option value="99">Do Not Charge Interest on the First 99 Repayments</option>
                                    <option value="100">Do Not Charge Interest on the First 100 Repayments</option>
                                    <option value="101">Do Not Charge Interest on the First 101 Repayments</option>
                                    <option value="102">Do Not Charge Interest on the First 102 Repayments</option>
                                    <option value="103">Do Not Charge Interest on the First 103 Repayments</option>
                                    <option value="104">Do Not Charge Interest on the First 104 Repayments</option>
                                    <option value="105">Do Not Charge Interest on the First 105 Repayments</option>
                                    <option value="106">Do Not Charge Interest on the First 106 Repayments</option>
                                    <option value="107">Do Not Charge Interest on the First 107 Repayments</option>
                                    <option value="108">Do Not Charge Interest on the First 108 Repayments</option>
                                    <option value="109">Do Not Charge Interest on the First 109 Repayments</option>
                                    <option value="110">Do Not Charge Interest on the First 110 Repayments</option>
                                    <option value="111">Do Not Charge Interest on the First 111 Repayments</option>
                                    <option value="112">Do Not Charge Interest on the First 112 Repayments</option>
                                    <option value="113">Do Not Charge Interest on the First 113 Repayments</option>
                                    <option value="114">Do Not Charge Interest on the First 114 Repayments</option>
                                    <option value="115">Do Not Charge Interest on the First 115 Repayments</option>
                                    <option value="116">Do Not Charge Interest on the First 116 Repayments</option>
                                    <option value="117">Do Not Charge Interest on the First 117 Repayments</option>
                                    <option value="118">Do Not Charge Interest on the First 118 Repayments</option>
                                    <option value="119">Do Not Charge Interest on the First 119 Repayments</option>
                                    <option value="120">Do Not Charge Interest on the First 120 Repayments</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#loan_interest_schedule">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_interest_schedule" class="collapse">
                                    <p><strong><u>How should Interest be charged in Loan Schedule?</u></strong>
                                        <br>This is an optional field. Select how the total interest should be charged
                                        in the loan schedule. You can select from
                                    </p>

                                    <ul>
                                        <li><strong>Include interest normally as per Interest Method</strong>
                                            <br>- The interest will be shown as per the <strong>Interest Method</strong>
                                            above.
                                        </li>
                                        <li><strong>Charge All Interest on the Released Date</strong>
                                            <br>- All the interest will be charged on the released date.
                                        </li>
                                        <li><strong>Charge All Interest on the First Repayment</strong>
                                            <br>- All interest will be charged on the first repayment date as per the
                                            schedule.
                                        </li>
                                        <li><strong>Charge All Interest on the Last Repayment</strong>
                                            <br>- All interest will be charged on the last repayment date as per the
                                            schedule.
                                        </li>
                                        <li><strong>Do Not Charge Interest on the Last Repayment</strong>
                                            <br>- Interest will not be charged on the last repayment date. If you give
                                            bullet loans where you only want to collect the principal on the last
                                            repayment, then this option is for you.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanPrincipalSchedule" class="col-sm-3 control-label">How should
                                Principal be charged in Loan Schedule?</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="loan_principal_schedule"
                                    id="inputLoanPrincipalSchedule">
                                    <option value="charge_principal_normally">Include principal normally as per
                                        Interest Method</option>
                                    <option value="charge_principal_on_released_date">Charge All Principal on the
                                        Released Date</option>
                                    <option value="charge_principal_on_first_repayment">Charge All Principal on the
                                        First Repayment</option>
                                    <option value="charge_principal_on_last_repayment">Charge All Principal on the Last
                                        Repayment</option>
                                    <option value="do_not_charge_principal_on_last_repayment">Do Not Charge Principal
                                        on the Last Repayment</option>
                                    <option value="1">Do Not Charge Principal on the First 1 Repayment</option>
                                    <option value="2">Do Not Charge Principal on the First 2 Repayments</option>
                                    <option value="3">Do Not Charge Principal on the First 3 Repayments</option>
                                    <option value="4">Do Not Charge Principal on the First 4 Repayments</option>
                                    <option value="5">Do Not Charge Principal on the First 5 Repayments</option>
                                    <option value="6">Do Not Charge Principal on the First 6 Repayments</option>
                                    <option value="7">Do Not Charge Principal on the First 7 Repayments</option>
                                    <option value="8">Do Not Charge Principal on the First 8 Repayments</option>
                                    <option value="9">Do Not Charge Principal on the First 9 Repayments</option>
                                    <option value="10">Do Not Charge Principal on the First 10 Repayments</option>
                                    <option value="11">Do Not Charge Principal on the First 11 Repayments</option>
                                    <option value="12">Do Not Charge Principal on the First 12 Repayments</option>
                                    <option value="13">Do Not Charge Principal on the First 13 Repayments</option>
                                    <option value="14">Do Not Charge Principal on the First 14 Repayments</option>
                                    <option value="15">Do Not Charge Principal on the First 15 Repayments</option>
                                    <option value="16">Do Not Charge Principal on the First 16 Repayments</option>
                                    <option value="17">Do Not Charge Principal on the First 17 Repayments</option>
                                    <option value="18">Do Not Charge Principal on the First 18 Repayments</option>
                                    <option value="19">Do Not Charge Principal on the First 19 Repayments</option>
                                    <option value="20">Do Not Charge Principal on the First 20 Repayments</option>
                                    <option value="21">Do Not Charge Principal on the First 21 Repayments</option>
                                    <option value="22">Do Not Charge Principal on the First 22 Repayments</option>
                                    <option value="23">Do Not Charge Principal on the First 23 Repayments</option>
                                    <option value="24">Do Not Charge Principal on the First 24 Repayments</option>
                                    <option value="25">Do Not Charge Principal on the First 25 Repayments</option>
                                    <option value="26">Do Not Charge Principal on the First 26 Repayments</option>
                                    <option value="27">Do Not Charge Principal on the First 27 Repayments</option>
                                    <option value="28">Do Not Charge Principal on the First 28 Repayments</option>
                                    <option value="29">Do Not Charge Principal on the First 29 Repayments</option>
                                    <option value="30">Do Not Charge Principal on the First 30 Repayments</option>
                                    <option value="31">Do Not Charge Principal on the First 31 Repayments</option>
                                    <option value="32">Do Not Charge Principal on the First 32 Repayments</option>
                                    <option value="33">Do Not Charge Principal on the First 33 Repayments</option>
                                    <option value="34">Do Not Charge Principal on the First 34 Repayments</option>
                                    <option value="35">Do Not Charge Principal on the First 35 Repayments</option>
                                    <option value="36">Do Not Charge Principal on the First 36 Repayments</option>
                                    <option value="37">Do Not Charge Principal on the First 37 Repayments</option>
                                    <option value="38">Do Not Charge Principal on the First 38 Repayments</option>
                                    <option value="39">Do Not Charge Principal on the First 39 Repayments</option>
                                    <option value="40">Do Not Charge Principal on the First 40 Repayments</option>
                                    <option value="41">Do Not Charge Principal on the First 41 Repayments</option>
                                    <option value="42">Do Not Charge Principal on the First 42 Repayments</option>
                                    <option value="43">Do Not Charge Principal on the First 43 Repayments</option>
                                    <option value="44">Do Not Charge Principal on the First 44 Repayments</option>
                                    <option value="45">Do Not Charge Principal on the First 45 Repayments</option>
                                    <option value="46">Do Not Charge Principal on the First 46 Repayments</option>
                                    <option value="47">Do Not Charge Principal on the First 47 Repayments</option>
                                    <option value="48">Do Not Charge Principal on the First 48 Repayments</option>
                                    <option value="49">Do Not Charge Principal on the First 49 Repayments</option>
                                    <option value="50">Do Not Charge Principal on the First 50 Repayments</option>
                                    <option value="51">Do Not Charge Principal on the First 51 Repayments</option>
                                    <option value="52">Do Not Charge Principal on the First 52 Repayments</option>
                                    <option value="53">Do Not Charge Principal on the First 53 Repayments</option>
                                    <option value="54">Do Not Charge Principal on the First 54 Repayments</option>
                                    <option value="55">Do Not Charge Principal on the First 55 Repayments</option>
                                    <option value="56">Do Not Charge Principal on the First 56 Repayments</option>
                                    <option value="57">Do Not Charge Principal on the First 57 Repayments</option>
                                    <option value="58">Do Not Charge Principal on the First 58 Repayments</option>
                                    <option value="59">Do Not Charge Principal on the First 59 Repayments</option>
                                    <option value="60">Do Not Charge Principal on the First 60 Repayments</option>
                                    <option value="61">Do Not Charge Principal on the First 61 Repayments</option>
                                    <option value="62">Do Not Charge Principal on the First 62 Repayments</option>
                                    <option value="63">Do Not Charge Principal on the First 63 Repayments</option>
                                    <option value="64">Do Not Charge Principal on the First 64 Repayments</option>
                                    <option value="65">Do Not Charge Principal on the First 65 Repayments</option>
                                    <option value="66">Do Not Charge Principal on the First 66 Repayments</option>
                                    <option value="67">Do Not Charge Principal on the First 67 Repayments</option>
                                    <option value="68">Do Not Charge Principal on the First 68 Repayments</option>
                                    <option value="69">Do Not Charge Principal on the First 69 Repayments</option>
                                    <option value="70">Do Not Charge Principal on the First 70 Repayments</option>
                                    <option value="71">Do Not Charge Principal on the First 71 Repayments</option>
                                    <option value="72">Do Not Charge Principal on the First 72 Repayments</option>
                                    <option value="73">Do Not Charge Principal on the First 73 Repayments</option>
                                    <option value="74">Do Not Charge Principal on the First 74 Repayments</option>
                                    <option value="75">Do Not Charge Principal on the First 75 Repayments</option>
                                    <option value="76">Do Not Charge Principal on the First 76 Repayments</option>
                                    <option value="77">Do Not Charge Principal on the First 77 Repayments</option>
                                    <option value="78">Do Not Charge Principal on the First 78 Repayments</option>
                                    <option value="79">Do Not Charge Principal on the First 79 Repayments</option>
                                    <option value="80">Do Not Charge Principal on the First 80 Repayments</option>
                                    <option value="81">Do Not Charge Principal on the First 81 Repayments</option>
                                    <option value="82">Do Not Charge Principal on the First 82 Repayments</option>
                                    <option value="83">Do Not Charge Principal on the First 83 Repayments</option>
                                    <option value="84">Do Not Charge Principal on the First 84 Repayments</option>
                                    <option value="85">Do Not Charge Principal on the First 85 Repayments</option>
                                    <option value="86">Do Not Charge Principal on the First 86 Repayments</option>
                                    <option value="87">Do Not Charge Principal on the First 87 Repayments</option>
                                    <option value="88">Do Not Charge Principal on the First 88 Repayments</option>
                                    <option value="89">Do Not Charge Principal on the First 89 Repayments</option>
                                    <option value="90">Do Not Charge Principal on the First 90 Repayments</option>
                                    <option value="91">Do Not Charge Principal on the First 91 Repayments</option>
                                    <option value="92">Do Not Charge Principal on the First 92 Repayments</option>
                                    <option value="93">Do Not Charge Principal on the First 93 Repayments</option>
                                    <option value="94">Do Not Charge Principal on the First 94 Repayments</option>
                                    <option value="95">Do Not Charge Principal on the First 95 Repayments</option>
                                    <option value="96">Do Not Charge Principal on the First 96 Repayments</option>
                                    <option value="97">Do Not Charge Principal on the First 97 Repayments</option>
                                    <option value="98">Do Not Charge Principal on the First 98 Repayments</option>
                                    <option value="99">Do Not Charge Principal on the First 99 Repayments</option>
                                    <option value="100">Do Not Charge Principal on the First 100 Repayments</option>
                                    <option value="101">Do Not Charge Principal on the First 101 Repayments</option>
                                    <option value="102">Do Not Charge Principal on the First 102 Repayments</option>
                                    <option value="103">Do Not Charge Principal on the First 103 Repayments</option>
                                    <option value="104">Do Not Charge Principal on the First 104 Repayments</option>
                                    <option value="105">Do Not Charge Principal on the First 105 Repayments</option>
                                    <option value="106">Do Not Charge Principal on the First 106 Repayments</option>
                                    <option value="107">Do Not Charge Principal on the First 107 Repayments</option>
                                    <option value="108">Do Not Charge Principal on the First 108 Repayments</option>
                                    <option value="109">Do Not Charge Principal on the First 109 Repayments</option>
                                    <option value="110">Do Not Charge Principal on the First 110 Repayments</option>
                                    <option value="111">Do Not Charge Principal on the First 111 Repayments</option>
                                    <option value="112">Do Not Charge Principal on the First 112 Repayments</option>
                                    <option value="113">Do Not Charge Principal on the First 113 Repayments</option>
                                    <option value="114">Do Not Charge Principal on the First 114 Repayments</option>
                                    <option value="115">Do Not Charge Principal on the First 115 Repayments</option>
                                    <option value="116">Do Not Charge Principal on the First 116 Repayments</option>
                                    <option value="117">Do Not Charge Principal on the First 117 Repayments</option>
                                    <option value="118">Do Not Charge Principal on the First 118 Repayments</option>
                                    <option value="119">Do Not Charge Principal on the First 119 Repayments</option>
                                    <option value="120">Do Not Charge Principal on the First 120 Repayments</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#loan_principal_schedule">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_principal_schedule" class="collapse">
                                    <p><strong><u>How should Principal be charged in Loan Schedule?</u></strong>
                                        <br>This is an optional field. Select how the total principal should be charged
                                        in the loan schedule. You can select from
                                    </p>

                                    <ul>
                                        <li><strong>Include principal normally as per Interest Method</strong>
                                            <br>- The principal will be shown as per the <strong>Interest
                                                Method</strong> above.
                                        </li>
                                        <li><strong>Charge All Principal on the Released Date</strong>
                                            <br>- All the principal will be charged on the released date.
                                        </li>
                                        <li><strong>Charge All Principal on the First Repayment</strong>
                                            <br>- All principal will be charged on the first repayment date as per the
                                            schedule.
                                        </li>
                                        <li><strong>Charge All Principal on the Last Repayment</strong>
                                            <br>- All principal will be charged on the last repayment date as per the
                                            schedule.
                                        </li>
                                        <li><strong>Do Not Charge Principal on the Last Repayment</strong>
                                            <br>- Principal will not be charged on the last repayment date.
                                        </li>
                                        <li><strong>Do Not Charge Principal on the First [n] Repayment(s)</strong>
                                            <br>- Principal will not be charged for the first [n] repayment(s). For
                                            example if you select Do Not Charge Principal on the First 2 Repayments, the
                                            system will start charging principal from the 3rd repayment.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputBalloonRepaymentAmount" class="col-sm-3 control-label">Balloon Repayment
                                Amount</label>
                            <div class="col-sm-6">
                                <input type="text" name="loan_balloon_repayment_amount"
                                    class="form-control numeral" id="inputBalloonRepaymentAmount"
                                    placeholder="Baloon Repayment Amount" value="" disabled>
                                (Valid for Reducing Balance - Equal Installments only)
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#loan_balloon_repayment_amount">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_balloon_repayment_amount" class="collapse">
                                    <p><strong><u>Balloon Repayment Amount</u></strong>
                                    <p>This is an optional field. Only valid for <strong>Reducing Balance - Equal
                                            Installments</strong> interest method. You can put a balloon payment on the
                                        last repayment cycle. This will reduce the repayment amount but will increase
                                        the total interest. On the last repayment, the repayment amount + balloon
                                        payment will be charged.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputLoanMoveFirstRepaymentDateDays" class="col-sm-3 control-label">Move First
                                Repayment Date if number of days from Loan Released Date is less than:</label>
                            <div class="col-sm-6">
                                <input class="form-control positive-integer"
                                    name="loan_move_first_repayment_date_days"
                                    id="inputLoanMoveFirstRepaymentDateDays" value="" type="text"
                                    min="1" max="2000">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#loan_move_first_repayment_date_days">Help</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_move_first_repayment_date_days" class="collapse">
                                    <p><strong><u>Move First Repayment Date if number of days from Loan Released Date is
                                                less than</u></strong>
                                    <p>This is an optional field. This is useful if the <b>First Repayment Date</b> is
                                        very close to the <b>Loan Released/Interest Start Date</b> and you would like to
                                        shift the entire loan schedule so the <b>First Repayment Date</b> is moved to
                                        the <b>Second Repayment Date</b> and the <b>Second Repayment Date</b> is moved
                                        to the <b>Third Repayment Date</b> and so on... The system looks at the days
                                        between the <b>Loan Released Date</b> and the <b>First Repayment Date</b>. If
                                        the days are less than the above value, the system will move the <b>First
                                            Repayment Date</b>.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanScheduleDescription" class="col-sm-3 control-label">Loan Schedule
                                Description</label>
                            <div class="col-sm-6">
                                <input type="text" name="loan_schedule_description" class="form-control"
                                    id="inputLoanScheduleDescription" placeholder="Loan Schedule Description"
                                    value="">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                    data-target="#loan_schedule_description">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_schedule_description" class="collapse">
                                    <p><strong><u>Loan Schedule Description</u></strong>
                                    <p>You can specify the description for each repayment installment in the loan
                                        schedule. If you leave this empty, the word <b>Repayment</b> will be added as
                                        description for each installment.</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Loan Status:</b></p>

                        <div class="well">Below, you can choose the <b>Loan Status</b> option that should be
                            auto-selected on the <b>Add Loan</b> page. If you leave the below empty, the <b>Open</b>
                            status will be selected by default for a new loan. But you may want another status such as
                            the <b>Processing</b> status to be auto-selected for new loans.</div>
                        <div class="form-group">
                            <label for="inputStatusId" class="col-sm-3 control-label">Loan Status</label>
                            <div class="col-sm-4">
                                //get records from the loan_statuses table
                                <select class="form-control" name="loan_status_id" id="inputStatusId">
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Accounting:</b></p>
                        <div class="well">
                            When you add a loan and have disbursed the <b>Principal Amount</b> to the borrower and the
                            <b>Loan Status</b> is set to Open, you can select where the funds came from. This will allow
                            the system to make the proper journal entry. If you select a bank account below, it will
                            auto populate for this loan product when adding a loan.
                        </div>
                        <div class="form-group">
                            <label for="inputDeaCashBankAccount" class="col-sm-3 control-label">Source of Funds for
                                Principal Amount</label>
                            <div class="col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input class="inputDeaCashBankAccount" type="checkbox"
                                            name="dea_cash_bank_account[]" value="0"> Cash
                                    </label>
                                </div>
                                <small><a
                                        href="https://x.loandisk.com/accounting/dea/bank_accounts/view_bank_accounts.php"
                                        target="_blank">Add/Edit Bank Accounts</a></small>
                            </div>
                        </div>
                        <hr>
                        <p class="text-red margin"><b>Duplicate Repayments:</b></p>
                        <div class="well">If you select Yes below, you can not add duplicate payments on the same
                            loan. This is useful for error checking. Let's say you enter a payment of $100 on 12th March
                            2023 to a specific loan. If you try to enter another payment for $100 on 12th March 2023 on
                            the same loan, the system will give you an error.</div>
                        <div class="form-group">
                            <label for="inputDuplicate" class="col-sm-3 control-label">Stop Duplicate Repayments
                                with same date and amount?</label>
                            <div class="col-sm-8">
                                <div class="radio">

                                    <label>
                                        <input type="radio" name="stop_loan_duplicate_repayments"
                                            id="inputDuplicateNo" value="0" checked> No
                                    </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="stop_loan_duplicate_repayments"
                                            id="inputDuplicateYes" value="1"> Yes

                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-default"
                        onClick="parent.location='https://x.loandisk.com/admin/view_loan_products.php'">Back</button>
                    <button type="submit" class="btn btn-info pull-right"
                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait">Submit</button>
                </div><!-- /.box-footer -->
            </form>
