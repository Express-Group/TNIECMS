<!-- Content -->
<div class="content ">
    <div class="page-header d-md-flex justify-content-between"><div>
    <h3>Welcome back, <?php echo $this->session->userdata('username'); ?></h3>
            <p class="text-muted">This page shows an overview for your account summary.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <div id="dashboard-daterangepicker" class="btn btn-outline-light">
                <span></span>
            </div>
            <a href="#" class="btn btn-primary ml-0 ml-md-2 mt-2 mt-md-0 dropdown-toggle" data-toggle="dropdown">Actions</a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item">Download</a>
                <a href="#" class="dropdown-item">Print</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title mb-2">Monthly Financial Status</h6>
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-floating">
                                <i class="ti-reload"></i>
                            </a>
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown"
                                   class="btn btn-floating"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-more-alt"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-4">Check how you're doing financially for current month</p>
                    <div id="sales"></div>
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-primary">
                            <i class="ti-download mr-2"></i> Create Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Positive Reviews</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <div class="avatar">
                                        <span class="avatar-title bg-primary-bright text-primary rounded-pill">
                                            <i class="ti-cloud"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="font-weight-bold ml-1 font-size-30 ml-3">0.16%</div>
                            </div>
                            <p class="mb-0"><a href="#" class="link-1">See comments</a> and respond to customers' comments.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Bounce Rate</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <div class="avatar">
                                        <span class="avatar-title bg-info-bright text-info rounded-pill">
                                            <i class="ti-map"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="font-weight-bold ml-1 font-size-30 ml-3">12.87%</div>
                            </div>
                            <p class="mb-0"><a class="link-1" href="#">See visits</a> that had a higher than expected
                                bounce rate.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Active Referrals</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <div class="avatar">
                                        <span class="avatar-title bg-secondary-bright text-secondary rounded-pill">
                                            <i class="ti-email"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="font-weight-bold ml-1 font-size-30 ml-3">12.87%</div>
                            </div>
                            <p class="mb-0"><a class="link-1" href="#">See referring</a> domains that sent most visits
                                last month.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Opened Invites</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <div class="avatar">
                                        <span class="avatar-title bg-warning-bright text-warning rounded-pill">
                                            <i class="ti-dashboard"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="font-weight-bold ml-1 font-size-30 ml-3">12.87%</div>
                            </div>
                            <p class="mb-0"><a class="link-1" href="#">See clients</a> that accepted your invitation to
                                connect.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title mb-2">Report</h6>
                        <div class="dropdown">
                            <a href="#" class="btn btn-floating" data-toggle="dropdown">
                                <i class="ti-more-alt"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h5>Stats</h5>
                                    <div>Last month targets</div>
                                </div>
                                <h3 class="text-success mb-0">$1,23M</h3>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h5>Payments</h5>
                                    <div>Week's expenses</div>
                                </div>
                                <div>
                                    <h3 class="text-danger mb-0">- $58,90</h3>
                                </div>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h5>Orders</h5>
                                    <div>Total products ordered</div>
                                </div>
                                <div>
                                    <h3 class="text-info mb-0">65</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="btn btn-info">Report Detail</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title mb-2">Statistics</h6>
                        <div class="dropdown">
                            <a href="#" class="btn btn-floating" data-toggle="dropdown">
                                <i class="ti-more-alt"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h5>Reports</h5>
                                    <div>Monthly sales reports</div>
                                </div>
                                <h3 class="text-primary mb-0">421</h3>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h5>User</h5>
                                    <div>Visitors last week</div>
                                </div>
                                <div>
                                    <h3 class="text-success mb-0">+10</h3>
                                </div>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h5>Sales</h5>
                                    <div>Total average weekly report</div>
                                </div>
                                <div>
                                    <h3 class="text-primary mb-0">140</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="btn btn-warning">Statistics Detail</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="card-title mb-2 text-center">Financial year</h6>
                    <p class="mb-0 text-muted">Expenses statistics to date</p>
                    <hr>
                    <div class="font-size-40 font-weight-bold">$502,680</div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Current month</p>
                            <div>
                                <span class="font-weight-bold">$46,362</span>
                                <span class="badge bg-danger-bright text-danger ml-1">-8%</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Last year</p>
                            <div>
                                <span class="font-weight-bold">$34,546</span>
                                <span class="badge bg-success-bright text-success ml-1">-13%</span>
                            </div>
                        </div>
                    </div>
                    <p class="font-weight-bold">Monthly report</p>
                    <div id="ecommerce-activity-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="row my-3">
                        <div class="col-md-6 ml-auto mr-auto">
                            <figure>
                                <img class="img-fluid" src="http://gogi.laborasyon.com/assets/media/svg/upgrade.svg" alt="upgrade">
                            </figure>
                        </div>
                    </div>
                    <h4 class="mb-3 text-center">Get an Upgrade</h4>
                    <div class="row my-3">
                        <div class="col-md-10 ml-auto mr-auto">
                            <p class="text-muted">Get additional 500 GB space for your documents and files. Expand your storage and enjoy your business. Change plan for more space.</p>
                            <button class="btn btn-primary" data-dismiss="modal">Plan Upgrade</button>
                        </div>
                    </div>
                    <a href="#" class="align-items-center d-flex link-1 small justify-content-center" data-dismiss="modal">
                        <i class="ti-close font-size-10 mr-1"></i>Close
                    </a>
                </div>
            </div>
        </div>
    </div>
            </div>
            <!-- ./ Content -->

            
        