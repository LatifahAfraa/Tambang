 <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="#" class="brand-logo">
                <img src="{{ asset('img/logos.png')}}" alt="" class="logo-abbr" viewBox="0 0 48 36">&nbsp;&nbsp;
                <span class="brand-title">RhodaJaya</span>
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                {{$title}}
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
							<li class="dropdown schedule-event-inner">
								<div class="btn btn-outline-primary btn-rounded event-btn">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="scale5 mr-0 mb-0 mr-sm-2 mb-sm-1"><path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 10H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
									<i class="fa fa-caret-right scale3 ml-2 d-none d-sm-inline-block"></i>
								</div>
							</li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
