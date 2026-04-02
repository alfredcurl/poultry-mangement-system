<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            @can("is_admin")
            <div class="sb-sidenav-menu-heading">Administrator</div>
            <a class="nav-link" href="/home">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <a class="nav-link" href="/home/customers">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-solid fa-users"></i></div>
                Customers
            </a>
            
            <!-- Poultry Management Section -->
            <div class="sb-sidenav-menu-heading">Poultry Management</div>
            
            <a class="nav-link" href="/birds">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-dove"></i></div>
                Bird Inventory
            </a>
            
            <a class="nav-link" href="/mortality">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-heartbeat"></i></div>
                Mortality Records
            </a>
            
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProduction"
              aria-expanded="false" aria-controls="collapseProduction">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-egg"></i></div>
                Egg Production
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-fw fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseProduction" aria-labelledby="headingProduction" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="/egg-production">Production Records</a>
                    <a class="nav-link" href="/egg-production/create">Record Production</a>
                    <a class="nav-link" href="/egg-production/daily-report">Daily Report</a>
                    <a class="nav-link" href="/egg-production/monthly-report">Monthly Report</a>
                </nav>
            </div>
            
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFeeds"
              aria-expanded="false" aria-controls="collapseFeeds">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-seedling"></i></div>
                Feed Management
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-fw fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseFeeds" aria-labelledby="headingFeeds" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="/feeds">Feed Inventory</a>
                    <a class="nav-link" href="/feeds/create">Add Feed Stock</a>
                    <a class="nav-link" href="/feeds/usage">Usage History</a>
                    <a class="nav-link" href="/feeds/usage/create">Record Usage</a>
                </nav>
            </div>
            
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMeds"
              aria-expanded="false" aria-controls="collapseMeds">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-pills"></i></div>
                Medications
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-fw fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseMeds" aria-labelledby="headingMeds" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="/medications">Medication Inventory</a>
                    <a class="nav-link" href="/medications/create">Add Medication</a>
                    <a class="nav-link" href="/medications/usage">Usage History</a>
                    <a class="nav-link" href="/medications/usage/create">Record Usage</a>
                </nav>
            </div>
            
            <a class="nav-link" href="/expenses">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-receipt"></i></div>
                Expenses
            </a>
            
            <a class="nav-link" href="/transaction">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-fw fa-dollar-sign"></i></div>
                Transactions
            </a>
            @else
            <div class="sb-sidenav-menu-heading">Customer</div>
            <a class="nav-link" href="/home">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-home-alt"></i></div>
                Home
            </a>
            <a class="nav-link" href="/point/user_point">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-fw fa-paw"></i></div>
                My Point
            </a>
            @endcan

            <div class="sb-sidenav-menu-heading">Shop</div>
            <a class="nav-link" href="/product">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-fw fa-egg"></i></div>
                Egg Products
            </a>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
              aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-fw fa-columns"></i></div>
                Orders
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-fw fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="/order/order_data">Order Data</a>
                    <a class="nav-link" href="/order/order_history">Order History</a>
                </nav>
            </div>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Currently logged in as:</div>
        {{ auth()->user()->role->role_name }}
    </div>
</nav>