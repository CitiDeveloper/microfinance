<!-- Dashboard Header -->
<h1 class="page-header mb-3">
    Hi, {{ Auth::user()->name ?? 'User' }}. <small>here's what's happening with your branches today.</small>
</h1>

<!-- BEGIN row -->
<div class="row">
    <!-- BEGIN col-6 -->
    <div class="col-xl-6 mb-3">
        <!-- BEGIN card -->
        <div class="card h-100 overflow-hidden">
            <!-- BEGIN card-img-overlay -->
            <div class="card-img-overlay d-block d-lg-none bg-blue rounded"></div>
            <!-- END card-img-overlay -->
            
            <!-- BEGIN card-img-overlay -->
            <div class="card-img-overlay d-none d-md-block bg-blue rounded mb-n1 mx-n1" style="background-image: url(assets/img/bg/wave-bg.png); background-position: right bottom; background-repeat: no-repeat; background-size: 100%;"></div>
            <!-- END card-img-overlay -->
            
            <!-- BEGIN card-img-overlay -->
            <div class="card-img-overlay d-none d-md-block bottom-0 top-auto">
                <div class="row">
                    <div class="col-md-8 col-xl-6"></div>
                    <div class="col-md-4 col-xl-6 mb-n2">
                        <img src="assets/img/page/dashboard.svg" alt="" class="d-block ms-n3 mb-5" style="max-height: 310px">
                    </div>
                </div>
            </div>
            <!-- END card-img-overlay -->
            
            <!-- BEGIN card-body -->
            <div class="card-body position-relative text-white text-opacity-70">
                <!-- BEGIN row -->
                <div class="row">
                    <!-- BEGIN col-8 -->
                    <div class="col-md-8">
                        <!-- stat-top -->
                        <div class="d-flex">
                            <div class="me-auto">
                                <h5 class="text-white text-opacity-80 mb-3">Weekly Loan Disbursements</h5>
                                <h3 class="text-white mt-n1 mb-1">${{ number_format($weeklyDisbursements, 2) }}</h3>
                                <p class="mb-1 text-white text-opacity-60 text-truncate">
                                    <i class="fa fa-caret-up"></i> <b>{{ $disbursementGrowth }}%</b> increase compared to last week
                                </p>
                            </div>
                        </div>
                        
                        <hr class="bg-white bg-opacity-75 mt-3 mb-3">
                        
                        <!-- stat-bottom -->
                        <div class="row">
                            <div class="col-6 col-lg-5">
                                <div class="mt-1">
                                    <i class="fa fa-fw fa-hand-holding-usd fs-28px text-black text-opacity-50"></i>
                                </div>
                                <div class="mt-1">
                                    <div>Active Loans</div>
                                    <div class="fw-600 text-white">{{ $activeLoansCount }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-5">
                                <div class="mt-1">
                                    <i class="fa fa-fw fa-users fs-28px text-black text-opacity-50"></i>
                                </div>
                                <div class="mt-1">
                                    <div>Active Borrowers</div>
                                    <div class="fw-600 text-white">{{ $activeBorrowersCount }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="bg-white bg-opacity-75 mt-3 mb-3">
                        
                        <div class="mt-3 mb-2">
                            <a href="{{ route('loans.create') }}" class="btn btn-yellow btn-rounded btn-sm ps-5 pe-5 pt-2 pb-2 fs-14px fw-600"><i class="fa fa-plus me-2 ms-n2"></i> New Loan</a>
                        </div>
                        <p class="fs-12px">
                            Track all loan applications and disbursements from your dashboard.
                        </p>
                    </div>
                    <!-- END col-8 -->
                    
                    <!-- BEGIN col-4 -->
                    <div class="col-md-4 d-none d-md-block" style="min-height: 380px;"></div>
                    <!-- END col-4 -->
                </div>
                <!-- END row -->
            </div>
            <!-- END card-body -->
        </div>
        <!-- END card -->
    </div>
    <!-- END col-6 -->
    
    <!-- BEGIN col-6 -->
    <div class="col-xl-6">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-sm-6">
                <!-- BEGIN card -->
                <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-orange" style="min-height: 199px;">
                    <!-- BEGIN card-img-overlay -->
                    <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                        <img src="assets/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 105px">
                    </div>
                    <!-- END card-img-overlay -->
                    
                    <!-- BEGIN card-body -->
                    <div class="card-body position-relative">
                        <h5 class="text-white text-opacity-80 mb-3 fs-16px">Pending Approvals</h5>
                        <h3 class="text-white mt-n1">{{ $pendingLoansCount }}</h3>
                        <div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
                            <div class="progrss-bar progress-bar-striped bg-white" style="width: {{ min($pendingLoansCount / max($totalLoansCount, 1) * 100, 100) }}%"></div>
                        </div>
                        <div class="text-white text-opacity-80 mb-4"><i class="fa fa-clock"></i> {{ $pendingLoansCount }} loans awaiting <br>review and approval</div>
                        <div><a href="{{ route('loans.index', ['status' => 'pending']) }}" class="text-white d-flex align-items-center text-decoration-none">View pending <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
                    </div>
                    <!-- BEGIN card-body -->
                </div>
                <!-- END card -->
                
                <!-- BEGIN card -->
                <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-teal" style="min-height: 199px;">
                    <!-- BEGIN card-img-overlay -->
                    <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                        <img src="assets/img/icon/visitor.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 105px">
                    </div>
                    <!-- END card-img-overlay -->
                    
                    <!-- BEGIN card-body -->
                    <div class="card-body position-relative">
                        <h5 class="text-white text-opacity-80 mb-3 fs-16px">Overdue Loans</h5>
                        <h3 class="text-white mt-n1">{{ $overdueLoansCount }}</h3>
                        <div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
                            <div class="progrss-bar progress-bar-striped bg-white" style="width: {{ min($overdueLoansCount / max($activeLoansCount, 1) * 100, 100) }}%"></div>
                        </div>
                        <div class="text-white text-opacity-80 mb-4"><i class="fa fa-exclamation-triangle"></i> {{ $overdueAmount }} total <br>overdue amount</div>
                        <div><a href="{{ route('loans.index', ['status' => 'overdue']) }}" class="text-white d-flex align-items-center text-decoration-none">View overdue <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
                    </div>
                    <!-- END card-body -->
                </div>
                <!-- END card -->
            </div>
            <!-- END col-6 -->
            
            <!-- BEGIN col-6 -->
            <div class="col-sm-6">
                <!-- BEGIN card -->
                <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-pink" style="min-height: 199px;">
                    <!-- BEGIN card-img-overlay -->
                    <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                        <img src="assets/img/icon/email.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 105px">
                    </div>
                    <!-- END card-img-overlay -->
                    
                    <!-- BEGIN card-body -->
                    <div class="card-body position-relative">
                        <h5 class="text-white text-opacity-80 mb-3 fs-16px">Weekly Repayments</h5>
                        <h3 class="text-white mt-n1">${{ number_format($weeklyRepayments, 2) }}</h3>
                        <div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
                            <div class="progrss-bar progress-bar-striped bg-white" style="width: {{ min($weeklyRepayments / max($weeklyDisbursements, 1) * 100, 100) }}%"></div>
                        </div>
                        <div class="text-white text-opacity-80 mb-4"><i class="fa fa-caret-up"></i> {{ $repaymentGrowth }}% increase <br>compared to last week</div>
                        <div><a href="{{ route('repayments.index') }}" class="text-white d-flex align-items-center text-decoration-none">View repayments <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
                    </div>
                    <!-- END card-body -->
                </div>
                <!-- END card -->
                
                <!-- BEGIN card -->
                <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-indigo" style="min-height: 199px;">
                    <!-- BEGIN card-img-overlay -->
                    <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                        <img src="assets/img/icon/browser.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 105px">
                    </div>
                    <!-- end card-img-overlay -->
                    
                    <!-- BEGIN card-body -->
                    <div class="card-body position-relative">
                        <h5 class="text-white text-opacity-80 mb-3 fs-16px">Active Branches</h5>
                        <h3 class="text-white mt-n1">{{ $activeBranchesCount }}</h3>
                        <div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
                            <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                        </div>
                        <div class="text-white text-opacity-80 mb-4"><i class="fa fa-building"></i> All branches <br>operational</div>
                        <div><a href="{{ route('branches.index') }}" class="text-white d-flex align-items-center text-decoration-none">Manage branches <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
                    </div>
                    <!-- END card-body -->
                </div>
                <!-- END card -->
            </div>
            <!-- BEGIN col-6 -->
        </div>
        <!-- END row -->
    </div>
    <!-- END col-6 -->
</div>
<!-- END row -->

<!-- BEGIN row -->
<div class="row">
    <!-- BEGIN col-6 -->
    <div class="col-xl-6">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-sm-6 mb-3 d-flex flex-column">
                <!-- BEGIN card -->
                <div class="card mb-3 flex-1">
                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">Total Borrowers</h5>
                                <div>Registered borrower accounts</div>
                            </div>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        </div>
                        
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">{{ $totalBorrowersCount }}</h3>
                                <div class="text-success fw-600 fs-13px">
                                    <i class="fa fa-caret-up"></i> +{{ $borrowerGrowth }}%
                                </div>
                            </div>
                            <div class="w-50px h-50px bg-primary bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fa fa-users fa-lg text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <!-- END card-body -->
                </div>
                <!-- END card -->
                
                <!-- BEGIN card -->
                <div class="card">
                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">Loan Products</h5>
                                <div>Active loan products</div>
                            </div>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        </div>
                        
                        <!-- BEGIN row -->
                        <div class="row">
                            <!-- BEGIN col-6 -->
                            <div class="col-6 text-center">
                                <div class="w-50px h-50px bg-primary bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center mb-2 ms-auto me-auto">
                                    <i class="fa fa-cube fa-lg text-primary"></i>
                                </div>
                                <div class="fw-600 text-body">{{ $activeLoanProductsCount }}</div>
                                <div class="fs-13px">Active</div>
                            </div>
                            <!-- END col-6 -->
                            
                            <!-- BEGIN col-6 -->
                            <div class="col-6 text-center">
                                <div class="w-50px h-50px bg-primary bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center mb-2 ms-auto me-auto">
                                    <i class="fa fa-chart-line fa-lg text-primary"></i>
                                </div>
                                <div class="fw-600 text-body">{{ $mostPopularProduct->loans_count ?? 0 }}</div>
                                <div class="fs-13px">Most Popular</div>
                            </div>
                            <!-- END col-6 -->
                        </div>
                        <!-- END row -->
                    </div>
                    <!-- END card-body -->
                </div>
                <!-- END card -->
            </div>
            <!-- END col-6 -->
            
            <!-- BEGIN col-6 -->
            <div class="col-sm-6 mb-3">
                <!-- BEGIN card -->
                <div class="card h-100">	
                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">Loan Portfolio</h5>
                                <div class="fs-13px">Loan status distribution</div>
                            </div>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="mb-1">${{ number_format($totalPortfolioValue, 2) }}</h3>
                            <div class="text-success fs-13px fw-600">
                                <i class="fa fa-caret-up"></i> +{{ $portfolioGrowth }}%
                            </div>
                        </div>
                        
                        <div class="progress mb-4" style="height: 10px;">
                            <div class="progress-bar bg-primary" style="width: {{ $loanStatusDistribution['active'] }}%"></div>
                            <div class="progress-bar bg-teal" style="width: {{ $loanStatusDistribution['pending'] }}%"></div>
                            <div class="progress-bar bg-yellow" style="width: {{ $loanStatusDistribution['overdue'] }}%"></div>
                            <div class="progress-bar bg-pink" style="width: {{ $loanStatusDistribution['closed'] }}%"></div>
                            <div class="progress-bar bg-gray-200" style="width: {{ $loanStatusDistribution['other'] }}%"></div>
                        </div>
                        
                        <div class="fs-13px">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="fa fa-circle fs-9px fa-fw text-primary me-2"></i> Active Loans
                                </div>
                                <div class="fw-600 text-body">{{ number_format($loanStatusDistribution['active'], 1) }}%</div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="fa fa-circle fs-9px fa-fw text-teal me-2"></i> Pending Approval
                                </div>
                                <div class="fw-600 text-body">{{ number_format($loanStatusDistribution['pending'], 1) }}%</div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="fa fa-circle fs-9px fa-fw text-warning me-2"></i> Overdue
                                </div>
                                <div class="fw-600 text-body">{{ number_format($loanStatusDistribution['overdue'], 1) }}%</div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="fa fa-circle fs-9px fa-fw text-danger me-2"></i> Closed
                                </div>
                                <div class="fw-600 text-body">{{ number_format($loanStatusDistribution['closed'], 1) }}%</div>
                            </div>
                            <div class="d-flex align-items-center mb-15px">
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="fa fa-circle fs-9px fa-fw text-gray-200 me-2"></i> Other
                                </div>
                                <div class="fw-600 text-body">{{ number_format($loanStatusDistribution['other'], 1) }}%</div>
                            </div>
                            <div class="fs-12px text-end">
                                <span class="fs-10px">updated </span>
                                <span class="d-inline-flex fw-600">
                                    {{ now()->format('M j, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- END card-body -->
                </div>
                <!-- END card -->
            </div>
            <!-- END col-6 -->
        </div>
        <!-- END row -->
    </div>
    <!-- END col-6 -->
    
    <!-- BEGIN col-6 -->
    <!-- BEGIN col-6 -->
<div class="col-xl-6 mb-3">
    <!-- BEGIN card -->
    <div class="card h-100">
        <!-- BEGIN card-body -->
        <div class="card-body">
       
            <div id="loanDisbursementChart" style="min-height: 300px;"></div>
        </div>
        <!-- END card-body -->
    </div>
    <!-- END card -->
</div>	
    <!-- END col-6 -->
</div>
<!-- END row -->

<!-- BEGIN row -->
<div class="row">
    <!-- BEGIN col-6 -->
    <div class="col-xl-6 mb-3">
        <!-- BEGIN card -->
        <div class="card h-100">
            <!-- BEGIN card-body -->
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Top Performing Branches</h5>
                        <div class="fs-13px">Branches with highest loan portfolio</div>
                    </div>
                    <a href="{{ route('branches.index') }}" class="text-decoration-none">See All</a>
                </div>
                
                @foreach($topBranches as $index => $branch)
                <!-- branch-1 -->
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center me-3 w-50px h-50px bg-white p-3px rounded">
                        <i class="fa fa-building fa-lg text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div>
                            @if($index == 0)
                            <div class="text-primary fs-10px fw-600">TOP PERFORMER</div>
                            @endif
                            <div class="text-body fw-600">{{ $branch->branch_name }}</div>
                            <div class="fs-13px">{{ $branch->branch_city }}, {{ $branch->branch_country }}</div>
                        </div>
                    </div>
                    <div class="ps-3 text-center">
                        <div class="text-body fw-600">${{ number_format($branch->total_portfolio, 2) }}</div>
                        <div class="fs-13px">portfolio</div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- END card-body -->
        </div>
        <!-- END card -->
    </div>
    <!-- END col-6 -->
    
    <!-- BEGIN col-6 -->
    <div class="col-xl-6 mb-3">
        <!-- BEGIN card -->
        <div class="card h-100">
            <!-- BEGIN card-body -->
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Recent Loan Applications</h5>
                        <div class="fs-13px">Latest loan application requests</div>
                    </div>
                    <a href="{{ route('loans.index') }}" class="text-decoration-none">See All</a>
                </div>
                
                <!-- BEGIN table-responsive -->
                <div class="table-responsive mb-n2">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr class="text-body">
                                <th class="ps-0">No</th>
                                <th>Application Details</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-0">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentLoans as $index => $loan)
                            <tr>
                                <td class="ps-0">{{ $index + 1 }}.</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="w-40px h-40px">
                                            <i class="fa fa-file-invoice-dollar fa-2x text-primary"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="fw-600 text-body">{{ $loan->borrower->full_name }}</div>
                                            <div class="fs-13px">{{ $loan->loanProduct->loan_product_name ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($loan->loan_status_id == 8)
                                    <span class="badge bg-warning bg-opacity-20 text-warning" style="min-width: 60px;">Pending</span>
                                    @elseif($loan->loan_status_id == 1)
                                    <span class="badge bg-success bg-opacity-20 text-success" style="min-width: 60px;">Approved</span>
                                    @else
                                    <span class="badge bg-secondary bg-opacity-20 text-secondary" style="min-width: 60px;">{{ $loan->loanStatus->status_name ?? 'Unknown' }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-0">${{ number_format($loan->loan_principal_amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- END table-responsive -->
            </div>
            <!-- END card-body -->
        </div>
        <!-- END card -->
    </div>
    <!-- END col-6 -->
</div>
<!-- END row -->