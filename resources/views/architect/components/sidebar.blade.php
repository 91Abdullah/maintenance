<div class="app-sidebar sidebar-shadow bg-midnight-bloom sidebar-text-light">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Administration</li>
                <li>
                    <a href="{{ route('index') }}" class="{{ request()->is('backend') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fas fa-rocket"></i>
                        Dashboard
                    </a>
                </li>
                @can('admin-access')
                    <li class="{{ request()->is('*settings*') ? 'mm-active' : '' }}">
                        <a href="{{ route('settings.update', App\Setting::first()->id) }}" class="{{ request()->is('*settings/*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fas fa-cogs"></i>
                            Settings
                        </a>
                    </li>
                    <li class="{{ request()->is('*users*') ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="{{ request()->is('*users*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fas fa-user-circle"></i>
                            Users
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('users.create') }}" class="{{ request()->is('*users/create') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Add
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}" class="{{ request()->is('*users') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon">
                                    </i>List
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->is('*outlet*') ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="{{ request()->is('*outlet*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fas fa-search-location"></i>
                            Locations
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('outlet.create') }}" class="{{ request()->is('*outlet/create') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Add
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('outlet.index') }}" class="{{ request()->is('*outlet') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon">
                                    </i>List
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->is('*department*') ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="{{ request()->is('*department*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fas fa-ambulance"></i>
                            Departments
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('department.create') }}" class="{{ request()->is('*department/create') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Add
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('department.index') }}" class="{{ request()->is('*department') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon">
                                    </i>List
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ request()->is('*ticketStatus*') ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="{{ request()->is('*ticketStatus/*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fas fa-tags"></i>
                            Status
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('ticketStatus.create') }}" class="{{ request()->is('*ticketStatus/create') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Add
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ticketStatus.index') }}" class="{{ request()->is('*ticketStatus') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon">
                                    </i>List
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->is('*maintenanceUsers*') ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="{{ request()->is('*maintenanceUsers/*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fas fa-user-cog"></i>
                            SMS Recipients
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('maintenanceUsers.create') }}" class="{{ request()->is('*maintenanceUsers/create') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Add
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('maintenanceUsers.index') }}" class="{{ request()->is('*maintenanceUsers') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon">
                                    </i>List
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('admin-supervisor')
                <li class="{{ request()->is('*issue*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*issue/*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fas fa-question-circle"></i>
                        Complaint Type
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('issue.create') }}" class="{{ request()->is('*issue/create') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('issue.index') }}" class="{{ request()->is('*issue') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->is('*messageRecipient*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*messageRecipient/*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fas fa-sms"></i>
                        SMS Recipients
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('messageRecipient.create') }}" class="{{ request()->is('*messageRecipient/create') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('messageRecipient.index') }}" class="{{ request()->is('*messageRecipient') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                <li class="app-sidebar__heading">Maintenance Complaints</li>
                <li class="{{ request()->is('*complain*') && !request()->is('*reports*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*complain*') && !request()->is('*reports*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fas fa-comment"></i>
                        Complaints
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('complain.create') }}" class="{{ request()->is('*complain/create') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('complain.index') }}" class="{{ request()->is('*complain') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('complain.form') }}" class="{{ request()->is('*complain/search*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon">
                                </i>Search
                            </a>
                        </li>
                    </ul>
                </li>
                {{--@if(Auth::user()->can('admin-access') || Auth::user()->can('rating-access'))
                    <li class="app-sidebar__heading">Rating SMS</li>
                    <li class="{{ request()->is('*rating*') && !request()->is('*reports*') ? 'mm-active' : '' }}">
                        <a href="javascript:void(0);" class="{{ request()->is('*rating*') && !request()->is('*reports*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fas fa-newspaper"></i>
                            Rating SMS Complains
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('rating.create') }}" class="{{ request()->is('*rating/create') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Add
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('rating.index') }}" class="{{ request()->is('*rating') ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon">
                                    </i>List
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif--}}
                @can('admin-access')
                    <li class="app-sidebar__heading">Reports</li>
                    <li>
                        <a href="{{ route('report.complain.get') }}" class="{{ request()->is('*reports/complains') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon lnr-database"></i>
                            Customer Complains
                        </a>
                        {{--<a href="{{ route('report.rating.get') }}" class="{{ request()->is('*reports/ratings') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fas fa-sticky-note"></i>
                            Rating Complains
                        </a>--}}
                        <a href="{{ route('report.activity') }}" class="{{ request()->is('*reports/activity') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon pe-7s-note2"></i>
                            Activity Logs
                        </a>
                        <a href="{{ route('report.login') }}" class="{{ request()->is('*reports/login') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon lnr-users"></i>
                            Login
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
