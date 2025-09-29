<div id="sidebar" class="app-sidebar">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-header">Navigation</div>
            <div class="menu-item active">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-laptop"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </div>

            <!-- Organization Management -->
            <div class="menu-header">Organization</div>
            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-code-branch"></i></span>
                    <span class="menu-text">Branches</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('branches.index') }}" class="menu-link">
                            <span class="menu-text">Manage Branches</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('branches.create') }}" class="menu-link">
                            <span class="menu-text">Add Branch</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-users"></i></span>
                    <span class="menu-text">Staff Management</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('staff.index') }}" class="menu-link">
                            <span class="menu-text">All Staff</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('staff.create') }}" class="menu-link">
                            <span class="menu-text">Add Staff</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('payroll.index') }}" class="menu-link">
                            <span class="menu-text">Payroll</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Loan Management -->
            <div class="menu-header">Loan Management</div>
            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-file-invoice-dollar"></i></span>
                    <span class="menu-text">Loan Products</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('loan-products.index') }}" class="menu-link">
                            <span class="menu-text">All Products</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('loan-products.create') }}" class="menu-link">
                            <span class="menu-text">Add Product</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-user-friends"></i></span>
                    <span class="menu-text">Borrowers</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('borrowers.index') }}" class="menu-link">
                            <span class="menu-text">All Borrowers</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('borrowers.create') }}" class="menu-link">
                            <span class="menu-text">Add Borrower</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('borrowers.groups') }}" class="menu-link">
                            <span class="menu-text">Borrower Groups</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-hand-holding-usd"></i></span>
                    <span class="menu-text">Loans</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('loans.index') }}" class="menu-link">
                            <span class="menu-text">All Loans</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('loans.create') }}" class="menu-link">
                            <span class="menu-text">New Loan</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('loans.pending') }}" class="menu-link">
                            <span class="menu-text">Pending Approval</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('loans.active') }}" class="menu-link">
                            <span class="menu-text">Active Loans</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('loans.overdue') }}" class="menu-link">
                            <span class="menu-text">Overdue Loans</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-cash-register"></i></span>
                    <span class="menu-text">Repayments</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('repayments.index') }}" class="menu-link">
                            <span class="menu-text">All Repayments</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('repayments.due') }}" class="menu-link">
                            <span class="menu-text">Due Repayments</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('repayments.create') }}" class="menu-link">
                            <span class="menu-text">Record Payment</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item">
                <a href="{{ route('collateral.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-landmark"></i></span>
                    <span class="menu-text">Collateral Register</span>
                </a>
            </div>

            <!-- Savings Management -->
            <div class="menu-header">Savings Management</div>
            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-piggy-bank"></i></span>
                    <span class="menu-text">Savings Accounts</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('savings.index') }}" class="menu-link">
                            <span class="menu-text">All Accounts</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('savings.create') }}" class="menu-link">
                            <span class="menu-text">Open Account</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item">
                <a href="{{ route('savings-transactions.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-exchange-alt"></i></span>
                    <span class="menu-text">Savings Transactions</span>
                </a>
            </div>

            <!-- Financial Management -->
            <div class="menu-header">Financial Management</div>
            <div class="menu-item">
                <a href="{{ route('investors.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-user-tie"></i></span>
                    <span class="menu-text">Investors</span>
                </a>
            </div>

            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-receipt"></i></span>
                    <span class="menu-text">Expenses</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('expenses.index') }}" class="menu-link">
                            <span class="menu-text">All Expenses</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('expenses.create') }}" class="menu-link">
                            <span class="menu-text">Record Expense</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('expenses.categories') }}" class="menu-link">
                            <span class="menu-text">Expense Categories</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item">
                <a href="{{ route('other-income.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-money-bill-wave"></i></span>
                    <span class="menu-text">Other Income</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="{{ route('assets.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-laptop-house"></i></span>
                    <span class="menu-text">Asset Management</span>
                </a>
            </div>

            <!-- Operations -->
            <div class="menu-header">Operations</div>
            <div class="menu-item">
                <a href="{{ route('calendar.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-calendar"></i></span>
                    <span class="menu-text">Calendar</span>
                </a>
            </div>

            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-clipboard-list"></i></span>
                    <span class="menu-text">Collection Sheets</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('collection-sheets.index') }}" class="menu-link">
                            <span class="menu-text">All Sheets</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('collection-sheets.create') }}" class="menu-link">
                            <span class="menu-text">New Collection Sheet</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('collection-sheets.daily') }}" class="menu-link">
                            <span class="menu-text">Daily Collection</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('collection-sheets.missed') }}" class="menu-link">
                            <span class="menu-text">Missed Repayments</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('collection-sheets.past-maturity') }}" class="menu-link">
                            <span class="menu-text">Past Maturity</span>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Reports & Accounting -->
            <div class="menu-header">Reports & Accounting</div>
            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-chart-bar"></i></span>
                    <span class="menu-text">Reports</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('reports.loan-portfolio') }}" class="menu-link">
                            <span class="menu-text">Loan Portfolio</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('reports.financial') }}" class="menu-link">
                            <span class="menu-text">Financial Reports</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('reports.savings') }}" class="menu-link">
                            <span class="menu-text">Savings Reports</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('reports.collection') }}" class="menu-link">
                            <span class="menu-text">Collection Reports</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('reports.performance') }}" class="menu-link">
                            <span class="menu-text">Performance Reports</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-balance-scale"></i></span>
                    <span class="menu-text">Accounting</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('accounting.chart-of-accounts') }}" class="menu-link">
                            <span class="menu-text">Chart of Accounts</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('accounting.journal-entries') }}" class="menu-link">
                            <span class="menu-text">Journal Entries</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('accounting.trial-balance') }}" class="menu-link">
                            <span class="menu-text">Trial Balance</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('accounting.balance-sheet') }}" class="menu-link">
                            <span class="menu-text">Balance Sheet</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('accounting.income-statement') }}" class="menu-link">
                            <span class="menu-text">Income Statement</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- System -->
            <div class="menu-header">System</div>
            <div class="menu-item">
                <a href="{{ route('system-settings.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-cogs"></i></span>
                    <span class="menu-text">System Settings</span>
                </a>
            </div>

            <!-- User Menu -->
            <div class="menu-divider"></div>
            <div class="menu-header">User</div>
            <div class="menu-item">
                <a href="{{ route('profile') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-user-circle"></i></span>
                    <span class="menu-text">Profile</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('settings') }}" class="menu-link">
                    <span class="menu-icon"><i class="fa fa-cog"></i></span>
                    <span class="menu-text">Settings</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('logout') }}" class="menu-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="menu-icon"><i class="fa fa-sign-out-alt"></i></span>
                    <span class="menu-text">Logout</span>
                </a>
            </div>
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->

    <!-- BEGIN mobile-sidebar-backdrop -->
    <button class="app-sidebar-mobile-backdrop" data-dismiss="sidebar-mobile"></button>
    <!-- END mobile-sidebar-backdrop -->
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
