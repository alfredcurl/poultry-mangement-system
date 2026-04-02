<div class="container-fluid px-4 pt-2">
    <h1 class="mt-2">Poultry Management Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    <!-- Key Metrics Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">{{ $todayEggs ?? 0 }}</h4>
                    <small>Eggs Collected Today</small>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/egg-production">View Production</a>
                    <div class="small text-white"><i class="fas fa-egg"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">UGX {{ number_format($monthSales ?? 0, 2) }}</h4>
                    <small>Sales This Month</small>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/order/order_data">View Orders</a>
                    <div class="small text-white"><i class="fas fa-dollar-sign"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">{{ $totalBirds ?? 0 }}</h4>
                    <small>Active Birds</small>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/birds">Manage Birds</a>
                    <div class="small text-white"><i class="fas fa-dove"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">{{ $monthMortality ?? 0 }}</h4>
                    <small>Mortality This Month</small>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/mortality">View Records</a>
                    <div class="small text-white"><i class="fas fa-heartbeat"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Metrics Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingOrders ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Egg Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-danger mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Low Stock Feeds</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lowStockFeeds ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-danger mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Low Stock Meds</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lowStockMeds ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pills fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-tasks me-1"></i>
                    Quick Actions
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="/egg-production/create" class="btn btn-primary btn-block w-100">
                                <i class="fas fa-plus-circle"></i> Record Egg Production
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="/birds/create" class="btn btn-info btn-block w-100">
                                <i class="fas fa-plus-circle"></i> Add Bird Batch
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="/feeds/usage/create" class="btn btn-success btn-block w-100">
                                <i class="fas fa-utensils"></i> Record Feed Usage
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="/expenses/create" class="btn btn-warning btn-block w-100">
                                <i class="fas fa-receipt"></i> Add Expense
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Egg Sales Chart (Last 7 Days)
                </div>
                <div class="card-body"><canvas id="sales_chart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Profits Chart (Last 6 Months)
                </div>
                <div class="card-body"><canvas id="profits_chart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-warehouse me-1"></i>
                    Inventory Management
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="/birds" class="list-group-item list-group-item-action">
                            <i class="fas fa-dove"></i> Bird Inventory
                        </a>
                        <a href="/feeds" class="list-group-item list-group-item-action">
                            <i class="fas fa-seedling"></i> Feed Management
                        </a>
                        <a href="/medications" class="list-group-item list-group-item-action">
                            <i class="fas fa-pills"></i> Medication Management
                        </a>
                        <a href="/product" class="list-group-item list-group-item-action">
                            <i class="fas fa-egg"></i> Egg Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Reports & Analytics
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="/egg-production/daily-report" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-day"></i> Daily Production Report
                        </a>
                        <a href="/egg-production/monthly-report" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-alt"></i> Monthly Production Report
                        </a>
                        <a href="/expenses/monthly-report" class="list-group-item list-group-item-action">
                            <i class="fas fa-money-bill-wave"></i> Monthly Expense Report
                        </a>
                        <a href="/mortality" class="list-group-item list-group-item-action">
                            <i class="fas fa-heartbeat"></i> Mortality Records
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>