          <div class="left-side-menu">

                <div class="h-100" data-simplebar>

                    <!-- User box -->

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="side-menu">

                            <li class="menu-title">Navigation</li>

                            <li>
                                <a href="{{ url('/') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    <span> Dashboards </span>
                                </a>
                            </li>

                
 
                            <li class="menu-title mt-2">Apps</li>

 
                            <li>
                                <a href="#sidebarMain" data-bs-toggle="collapse">
                                    <i class="fas fa-users"></i>
                                    <span>Main Section</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarMain">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('brand.index') }}">Brand Section</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('modelsection.index')}}">Modal Section</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('item.index')}}">Item Section</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>