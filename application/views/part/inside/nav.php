<ul class="main-navigation-menu">
    <?php
    $user_id = $this->session->userdata('logged_in') ['id'];
    $category = $this->session->userdata('logged_in') ['category'];
    if ($category == "admin" | $category == "suadmin") {
        ?>
        <li class="active open"><a
                href="<?= base_url('welcome/dashboard') ?>"><i class="fa fa-home"></i>
                <span class="title"> Dashboard </span>
                <?php
                if ($category == "suadmin") {
                    ?>
                    <span class="label label-default pull-right ">SUPER
                        ADMIN</span> 
                    <?php
                } elseif ($category == "admin") {
                    ?>
                    <span class="label label-info pull-right ">ADMIN</span> 
                    <?php
                }
                ?>
            </a>
        </li>
        <li class=""><a href="javascript:;"> <i
                    class="fa fa-folder-open"></i> <span class="title"> HR Management </span><i
                    class="icon-arrow"></i> <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= base_url('humanr/go/1') ?>"> <i
                            class="fa fa-th-large"></i><span class="title">Manage Employees</span>
                    </a>
                </li>
                <li>
                    <!-- base_url('company/go/1') -->
                    <a href="#"> <i
                            class="fa fa-th-large"></i><span class="title">Discipline  Cases</span>
                    </a>
                </li>
                <li>
                    <!-- base_url('company/go/1') -->
                    <a href="#"> <i
                            class="fa fa-th-large"></i><span class="title">Contracts Management</span>
                    </a>
                </li>
                <li>
                    <!-- base_url('company/go/1') -->
                    <a href="#"> <i
                            class="fa fa-th-large"></i><span class="title">HR Transfers</span>
                    </a>
                </li>
                <li>
                    <!-- base_url('company/go/1') -->
                    <a href="#"> <i
                            class="fa fa-th-large"></i><span class="title">Approve Transfers</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('company/go/1') ?>"> <i
                            class="fa fa-th-large"></i><span class="title">Events Planner</span>
                    </a>
                </li>
                <li>
                    <a href="#"> <i
                            class="fa fa-th-large"></i><span class="title">ESS Memos</span>
                    </a>
                </li>
                <li>
                    <a href="#"> <i
                            class="fa fa-th-large"></i><span class="title">HRM Circulars</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class=""><a href="javascript:;"> <i
                    class="fa fa-folder-open"></i> <span class="title"> Leave Management</span><i
                    class="icon-arrow"></i> <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= base_url('leave/go/1') ?>"> <i
                            class="fa fa-th-large"></i><span class="title">Leave Settings Plus</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class=""><a href="javascript:;"> <i
                    class="fa fa-money"></i> <span class="title">Payroll</span><i
                    class="icon-arrow"></i> <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= base_url('payroll/go/1') ?>"> <i
                            class="fa fa-circle-o-notch fa-spin"></i><span class="title">Payroll Details</span>
                    </a>
                </li>
                <li><a href="<?= base_url('payroll/go/1') ?>"> <i
                            class="fa  fa-bank"></i><span class="title">Loan Entries</span>
                    </a>
                </li>
                <li><a href="<?= base_url('payroll/go/1') ?>"> <i
                            class="fa fa-header"></i><span class="title">Process Payroll</span>
                    </a>
                </li>
                <li><a href="<?= base_url('payroll/go/1') ?>"> <i
                            class="fa fa-archive"></i><span class="title">Benefit Upload</span>
                    </a>
                </li>
                <li><a href="<?= base_url('payroll/go/1') ?>"> <i
                            class="fa fa-th-large"></i><span class="title">Close Month</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        Payroll Report <i class="icon-arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('payroll/go/2') ?>">
                                Monthly Reports
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Transaction Reports
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Master File Listing Reports
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Year And Reports
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class=""><a href="javascript:;"> <i
                    class="fa fa-cogs"></i> <span class="title"> Company Config </span><i
                    class="icon-arrow"></i> <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= base_url('company/go/1') ?>"> <i
                            class="fa fa-th-large"></i><span class="title">Company Structure</span>
                    </a>
                </li>
                <li><a href="<?= base_url('company/go/2') ?>"> <i
                            class="fa fa-xing"></i><span class="title">HR Structure</span>
                    </a>
                </li>
                <li><a href="<?= base_url('company/go/3') ?>"> <i
                            class="fa fa-send-o"></i><span class="title">Other  Settings</span>
                    </a>
                </li>
                <li><a href="<?= base_url('company/go/4') ?>"> <i
                            class="fa fa-bank"></i><span class="title">Banks  Settings</span>
                    </a>
                </li>
                <li><a href="<?= base_url('company/go/5') ?>"> <i
                            class="fa fa-cog"></i><span class="title">Payroll  Settings</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class=""><a href="javascript:;"> <i class="fa fa-folder-open"></i>
                <span class="title"> Time Attendance </span><i class="icon-arrow"></i>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li><a href="#"> <i class="fa fa-th-large"></i><span class="title">Period
                            Definitions</span>
                    </a></li>
                <li><a href="<?= base_url('welcome/dashboard/14') ?>"> <i
                            class="fa fa-th-list"></i><span class="title">Shift Definitions</span>
                    </a></li>
                <li><a href="<?= base_url('welcome/dashboard/10') ?>"> <i
                            class="fa fa-th-list"></i><span class="title">Shift Allocations</span>
                    </a></li>
                <li><a href="#"> <i class="fa fa-th-list"></i><span class="title">Shift
                            Scheduling</span>
                    </a></li>
                <li><a href="#"> <i class="fa fa-th-list"></i><span class="title">Query
                            Shifts</span>
                    </a></li>
                <li>
                    <a href="<?= base_url('welcome/dashboard/12') ?>"> <i
                            class="fa fa-th-list"></i><span class="title"> Manual Entries</span>
                    </a>
                </li>
                <li><a href="<?= base_url('welcome/dashboard/11') ?>"> <i
                            class="fa fa-folder"></i><span class="title">Attendance Reports</span>
                    </a>
                </li>
                <li><a href="<?= base_url('welcome/dashboard/13') ?>"> <i
                            class="fa fa-folder"></i><span class="title">Daily Reports</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?= base_url('welcome/dashboard/7') ?>"> <i
                    class="fa fa-user"></i><span class="title">  My Work Space</span>
            </a>
        </li>
        <?php
    } else {
        ?>
        <li class="active open">
            <a
                href="<?= base_url('welcome/dashboard') ?>"><i class="fa fa-home"></i>
                <span class="title"> Dashboard </span> <span
                    class="label label-success pull-right ">STAFF</span> 
            </a>
        </li>
        <li class=""><a href="javascript:;"> <i class="fa fa-folder-open"></i>
                <span class="title">HR Memos </span><i class="icon-arrow"></i>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= base_url('staff/go/1') ?>"> <i
                            class="fa fa-th-list"></i><span class="title">HR Memos</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('staff/go/2') ?>"> <i
                            class="fa fa-th-list"></i><span class="title">Memos</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class=""><a href="<?= base_url('staff/go/1') ?>"> <i class="fa fa-circle-o-notch fa-spin"></i>
                <span class="title">My Leaves </span>
            </a>
        </li>
        <li class=""><a href="javascript:;"> <i class="fa fa-folder-open"></i>
                <span class="title">Appraisals </span><i class="icon-arrow"></i>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= base_url('staff/go/1') ?>"> <i
                            class="fa fa-th-list"></i><span class="title">Leave Requests</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('staff/go/2') ?>"> <i
                            class="fa fa-th-list"></i><span class="title">My Leaves</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class=""><a href="javascript:;"> <i class="fa fa-folder-open"></i>
                <span class="title">Reports </span><i class="icon-arrow"></i>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= base_url('staff/go/1') ?>"> <i
                            class="fa fa-th-list"></i><span class="title">Leave Requests</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('staff/go/2') ?>"> <i
                            class="fa fa-th-list"></i><span class="title">My Leaves</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php
    }
    ?>
    <li class="active open">
        <a
            href="<?= base_url('company/message') ?>"><i class="fa fa-envelope"></i>
            <span class="title"> Messages </span> <span
                class="label label-danger pull-right ">20</span> 
        </a>
    </li>
</ul>