<div class="app-sidebar sidebar-shadow">
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
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li>
                <li class="{{ request()->is('*users*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*users*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-user"></i>
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
                {{--<li>
                    <a href="javascript:void(0);" class="{{ request()->is('*roles/*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Roles
                    </a>
                </li>--}}
                <li class="{{ request()->is('*outlet*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*outlet*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-crop"></i>
                        Outlets
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
                        <i class="metismenu-icon pe-7s-home"></i>
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
                <li class="{{ request()->is('*issue*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*issue/*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-help1"></i>
                        Nature of Issues
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
                <li class="{{ request()->is('*ticketStatus*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*ticketStatus/*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-ticket"></i>
                        Ticket Statuses
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
                <li class="{{ request()->is('*smsRecipient*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*smsRecipient/*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-mail"></i>
                        SMS Recipients
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('smsRecipient.create') }}" class="{{ request()->is('*smsRecipient/create') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('smsRecipient.index') }}" class="{{ request()->is('*smsRecipient') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="app-sidebar__heading">CRM</li>
                <li class="{{ request()->is('*complain*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="{{ request()->is('*complain*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-comment"></i>
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
                    </ul>
                </li>
                <li class="app-sidebar__heading">Rating Portal</li>
            </ul>
        </div>
    </div>
</div>
