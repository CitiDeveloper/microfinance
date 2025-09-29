    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #0dcaf0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            --card-hover-shadow: 0 8px 15px rgba(0, 0, 0, 0.08);
        }
        
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .dashboard-header {
            padding: 1.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .card:hover {
            box-shadow: var(--card-hover-shadow);
        }
        
        .stat-card {
            padding: 1.5rem;
            border-radius: 12px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(40%, -40%);
        }
        
        .stat-card .icon-container {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            margin-bottom: 1rem;
        }
        
        .progress {
            height: 6px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .progress-bar {
            border-radius: 3px;
        }
        
        .loan-status-chart .progress {
            height: 10px;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--secondary-color);
            font-size: 0.875rem;
        }
        
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: #244a8a;
            border-color: #244a8a;
        }
        
        .chart-container {
            height: 300px;
        }
        
        .branch-item {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .branch-item:last-child {
            border-bottom: none;
        }
        
        .top-performer {
            position: relative;
        }
        
        .top-performer::after {
            content: 'TOP PERFORMER';
            position: absolute;
            top: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
        }
        
        .text-muted {
            color: #6c757d !important;
        }
    </style>
  <div class="container-fluid">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-1">Welcome back, {{ Auth::user()->name ?? 'User' }}</h1>
                    <p class="text-muted mb-0">Here's what's happening with your branches today.</p>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> New Loan
                    </button>
                </div>
            </div>
        </div>

        <!-- Key Metrics Row -->
        <div class="row">
            <!-- Main Metric Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title text-muted mb-3">Weekly Loan Disbursements</h5>
                                <h2 class="mb-2">${{ number_format($weeklyDisbursements, 2) }}</h2>
                                <p class="text-success mb-4">
                                    <i class="fas fa-caret-up me-1"></i> 
                                    <strong>{{ $disbursementGrowth }}%</strong> increase compared to last week
                                </p>
                                
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-container me-3 bg-primary bg-opacity-10 text-primary">
                                                <i class="fas fa-hand-holding-usd"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Active Loans</div>
                                                <div class="fw-bold fs-5">{{ $activeLoansCount }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-container me-3 bg-info bg-opacity-10 text-info">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Active Borrowers</div>
                                                <div class="fw-bold fs-5">{{ $activeBorrowersCount }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button class="btn btn-primary mb-2">
                                    <i class="fas fa-plus me-2"></i> New Loan Application
                                </button>
                                <p class="text-muted small">
                                    Track all loan applications and disbursements from your dashboard.
                                </p>
                            </div>
                            <div class="col-md-4 d-none d-md-block text-center">
                                <img src="assets/img/page/dashboard.svg" alt="Dashboard" class="img-fluid" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Secondary Metrics -->
            <div class="col-lg-6">
              <div class="row g-3 mb-4">
    <!-- Pending Approvals -->
    <div class="col-xl-6 col-md-6">
        <div class="card border-0 shadow-sm h-100 hover-shadow">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-3 me-3 p-2">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small">Pending Approvals</h6>
                        <h4 class="mb-0 fw-bold">{{ $pendingLoansCount }}</h4>
                    </div>
                </div>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <!-- Overdue Loans -->
    <div class="col-xl-6 col-md-6">
        <div class="card border-0 shadow-sm h-100 hover-shadow">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-3 me-3 p-2">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small">Overdue Loans</h6>
                        <h4 class="mb-0 fw-bold">{{ $overdueLoansCount }}</h4>
                    </div>
                </div>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <!-- Weekly Repayments -->
    <div class="col-xl-6 col-md-6">
        <div class="card border-0 shadow-sm h-100 hover-shadow">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-success bg-opacity-10 text-success rounded-3 me-3 p-2">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small">Weekly Repayments</h6>
                        <h4 class="mb-0 fw-bold">${{ number_format($weeklyRepayments, 0) }}</h4>
                    </div>
                </div>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <!-- Active Branches -->
    <div class="col-xl-6 col-md-6">
        <div class="card border-0 shadow-sm h-100 hover-shadow">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-info bg-opacity-10 text-info rounded-3 me-3 p-2">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small">Active Branches</h6>
                        <h4 class="mb-0 fw-bold">{{ $activeBranchesCount }}</h4>
                    </div>
                </div>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>

        <!-- Portfolio & Analytics Row -->
        <div class="row">
            <!-- Portfolio Stats -->
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">Total Borrowers</h5>
                                        <p class="text-muted small mb-0">Registered borrower accounts</p>
                                    </div>
                                    <a href="#" class="text-muted"><i class="fas fa-redo"></i></a>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <h3 class="mb-1">{{ $totalBorrowersCount }}</h3>
                                        <span class="text-success small">
                                            <i class="fas fa-caret-up me-1"></i> +{{ $borrowerGrowth }}%
                                        </span>
                                    </div>
                                    <div class="icon-container bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">Loan Products</h5>
                                        <p class="text-muted small mb-0">Active loan products</p>
                                    </div>
                                    <a href="#" class="text-muted"><i class="fas fa-redo"></i></a>
                                </div>
                                
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="icon-container bg-primary bg-opacity-10 text-primary mx-auto mb-2">
                                            <i class="fas fa-cube"></i>
                                        </div>
                                        <div class="fw-bold">{{ $activeLoanProductsCount }}</div>
                                        <div class="text-muted small">Active</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="icon-container bg-primary bg-opacity-10 text-primary mx-auto mb-2">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div class="fw-bold">{{ $mostPopularProduct->loans_count ?? 0 }}</div>
                                        <div class="text-muted small">Most Popular</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">Loan Portfolio</h5>
                                        <p class="text-muted small mb-0">Loan status distribution</p>
                                    </div>
                                    <a href="#" class="text-muted"><i class="fas fa-redo"></i></a>
                                </div>
                                
                                <div class="mb-4">
                                    <h3 class="mb-1">${{ number_format($totalPortfolioValue, 2) }}</h3>
                                    <span class="text-success small">
                                        <i class="fas fa-caret-up me-1"></i> +{{ $portfolioGrowth }}%
                                    </span>
                                </div>
                                
                                <div class="loan-status-chart mb-4">
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-primary" style="width: {{ $loanStatusDistribution['active'] }}%"></div>
                                        <div class="progress-bar bg-info" style="width: {{ $loanStatusDistribution['pending'] }}%"></div>
                                        <div class="progress-bar bg-warning" style="width: {{ $loanStatusDistribution['overdue'] }}%"></div>
                                        <div class="progress-bar bg-danger" style="width: {{ $loanStatusDistribution['closed'] }}%"></div>
                                        <div class="progress-bar bg-secondary" style="width: {{ $loanStatusDistribution['other'] }}%"></div>
                                    </div>
                                    
                                    <div class="small">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i>
                                                <span>Active Loans</span>
                                            </div>
                                            <span class="fw-bold">{{ number_format($loanStatusDistribution['active'], 1) }}%</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-circle text-info me-2" style="font-size: 8px;"></i>
                                                <span>Pending Approval</span>
                                            </div>
                                            <span class="fw-bold">{{ number_format($loanStatusDistribution['pending'], 1) }}%</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-circle text-warning me-2" style="font-size: 8px;"></i>
                                                <span>Overdue</span>
                                            </div>
                                            <span class="fw-bold">{{ number_format($loanStatusDistribution['overdue'], 1) }}%</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-circle text-danger me-2" style="font-size: 8px;"></i>
                                                <span>Closed</span>
                                            </div>
                                            <span class="fw-bold">{{ number_format($loanStatusDistribution['closed'], 1) }}%</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-circle text-secondary me-2" style="font-size: 8px;"></i>
                                                <span>Other</span>
                                            </div>
                                            <span class="fw-bold">{{ number_format($loanStatusDistribution['other'], 1) }}%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end text-muted small">
                                    <span>Updated </span>
                                    <span class="fw-bold">{{ now()->format('M j, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Chart Section -->
            <div class="col-lg-6  mb-2">
                <div class="card h-100 mb-2">
                    <div class="card-body mb-2">
                      
                        <div class="chart-container" id="loanDisbursementChart"></div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branches & Recent Activity Row -->
        <div class="row">
            <!-- Top Performing Branches -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="card-title mb-1">Top Performing Branches</h5>
                                <p class="text-muted small mb-0">Branches with highest loan portfolio</p>
                            </div>
                            <a href="#" class="text-decoration-none">See All</a>
                        </div>
                        
                        <div class="list-group list-group-flush">
                            @foreach($topBranches as $index => $branch)
                            <div class="list-group-item px-0 py-3 {{ $index == 0 ? 'top-performer' : '' }}">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-primary bg-opacity-10 text-primary me-3">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">{{ $branch->branch_name }}</div>
                                        <div class="text-muted small">{{ $branch->branch_city }}, {{ $branch->branch_country }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">${{ number_format($branch->total_portfolio, 2) }}</div>
                                        <div class="text-muted small">portfolio</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Loan Applications -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="card-title mb-1">Recent Loan Applications</h5>
                                <p class="text-muted small mb-0">Latest loan application requests</p>
                            </div>
                            <a href="#" class="text-decoration-none">See All</a>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0 ps-0">No</th>
                                        <th class="border-0">Application Details</th>
                                        <th class="border-0 text-center">Status</th>
                                        <th class="border-0 text-end pe-0">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentLoans as $index => $loan)
                                    <tr>
                                        <td class="ps-0">{{ $index + 1 }}.</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-container bg-primary bg-opacity-10 text-primary me-3">
                                                    <i class="fas fa-file-invoice-dollar"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $loan->borrower->full_name }}</div>
                                                    <div class="text-muted small">{{ $loan->loanProduct->loan_product_name ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($loan->loan_status_id == 8)
                                            <span class="badge bg-warning bg-opacity-20 text-warning">Pending</span>
                                            @elseif($loan->loan_status_id == 1)
                                            <span class="badge bg-success bg-opacity-20 text-success">Approved</span>
                                            @else
                                            <span class="badge bg-secondary bg-opacity-20 text-secondary">{{ $loan->loanStatus->status_name ?? 'Unknown' }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-0 fw-bold">${{ number_format($loan->loan_principal_amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>