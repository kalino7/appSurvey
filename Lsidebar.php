
<nav id="sidebar" class="">
<div class="sidebar-header">
    <a href="dashboard.php"><img class="main-logo" src="img/logo/logo.png" alt="" /></a>
    <strong><img src="img/logo/logo.png" alt="" /></strong>
</div>
<div class="left-custom-menu-adp-wrap comment-scrollbar">
    <nav class="sidebar-nav left-sidebar-menu-pro">
        <ul class="metismenu" id="menu1">
            <li <?php echo ($curpage == 'dashboard') ? 'class=active' : ''; ?> >
                <a class="has-arrow" href="dashboard.php">
                       <i class="fa big-icon fa-home icon-wrap"></i>
                       <span class="mini-click-non">Dashboard</span>
                    </a>
                <ul class="submenu-angle" aria-expanded="true">
                    <li><a title="Dashboard" href="dashboard.php"><i class="fa fa-bullseye sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Dashboard </span></a></li>
                </ul>
            </li>
            <li <?php echo (($curpage == 'create')||($curpage == 'set')||($curpage == 'criteria')||($curpage == 'viewAns')) ? 'class=active' : ''; ?> >
                <a class="has-arrow" href="#" aria-expanded="false"><i class="fa big-icon fa-bar-chart-o icon-wrap"></i> <span class="mini-click-non">Surveys</span></a>
                <ul class="submenu-angle" aria-expanded="false">
                    <li><a title="Bar Charts" href="create.php"><i class="fa fa-line-chart sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Create Forms</span></a></li>
                    <li><a title="Line Charts" href="set.php"><i class="fa fa-area-chart sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Survey Criteria</span></a></li>
                </ul>
            </li>

            <li <?php echo ($curpage == 'transacHistory') ? 'class=active' : ''; ?>>
                <a class="has-arrow" href="#" aria-expanded="false"><i class="fa big-icon fa-desktop icon-wrap"></i> <span class="mini-click-non">History</span></a>
                <ul class="submenu-angle" aria-expanded="false">
                    <li><a title="View Mail" href="transacHistory.php"><i class="fa fa-television sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Transaction History </span></a></li>
                </ul>
            </li>

            <li <?php echo (($curpage == 'mailbox') || ($curpage == 'mailview')) ? 'class=active' : ''; ?>>
                <a class="has-arrow" href="#" aria-expanded="false"><i class="fa big-icon fa-envelope icon-wrap"></i> <span class="mini-click-non">Mailbox</span></a>
                <ul class="submenu-angle" aria-expanded="false">
                    <li><a title="Inbox" href="mailbox.php"><i class="fa fa-inbox sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Inbox</span></a></li>
                    <!-- <li><a title="Compose Mail" href="mailbox-compose.php"><i class="fa fa-paper-plane sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Compose Mail</span></a></li> -->
                </ul>
            </li>

            <li id="removable">
                <a class="has-arrow" href="#" aria-expanded="false"><i class="fa big-icon fa-files-o icon-wrap"></i> <span class="mini-click-non">Leave</span></a>
                <ul class="submenu-angle" aria-expanded="false">
                <li><a title="Password Recovery" href="logout.php"><i class="fa fa-wheelchair sub-icon-mg" aria-hidden="true"></i><span class="mini-sub-pro">Log out</span></a></li>
                    <!-- <li><a title="Password Recovery" href="password-recovery.html"><i class="fa fa-wheelchair sub-icon-mg" aria-hidden="true"></i><span class="mini-sub-pro">Password Recovery</span></a></li> -->
                </ul>
            </li>

        </ul>
    </nav>
</div>
</nav>