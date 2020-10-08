<?php
    $notify = $db->query("SELECT * FROM messages WHERE status= 'unread' AND userID = '$_SESSION[id]' ");
    $numNot = $notify->num_rows;
?>


<div class="header-top-area">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="header-top-wraper">
                <div class="row">
                    <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                        <div class="menu-switcher-pro">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                        <div class="header-top-menu tabl-d-n">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="header-right-info">
                            <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                <li class="nav-item dropdown">
<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa fa-envelope-o adminpro-chat-pro" aria-hidden="true"></i><?php if($numNot > 0) {?><span class="indicator-ms"></span><?php }?></a>
                                    <div role="menu" class="author-message-top dropdown-menu animated zoomIn">
                                        <div class="message-single-top">
                                            <h1>Message</h1>
                                        </div>
                                        <ul class="message-menu">
                                            <?php 
                                                if($numNot  > 0)
                                                {
                                                    while($dataNot = $notify->fetch_assoc())
                                                    {
                                            ?>
                                                        <li>
                                                        <a href="mailview.php?id=<?php echo $dataNot['id']; ?>">
                                                            <div class="message-img">
                                                                <img src="img/contact/msg.png" alt="">
                                                            </div>
                                                            <div class="message-content">
                                                                <span class="message-date"><?php echo date("d M", $dataNot['created_At'])?></span>
                                                                <h2>Admin Panel</h2>
                                                                <p>Please You Have A New Message(s).</p>
                                                            </div>
                                                        </a>
                                                    </li>
                                            <?php
                                                    }
                                                }
                                            ?>

                                        </ul>
                                        <div class="message-view">
                                            <a href="mailbox.php">View All Messages</a>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                            <i class="fa fa-user adminpro-user-rounded header-riht-inf" aria-hidden="true"></i>
                                            <span class="admin-name"><?php echo $_SESSION['user']; ?></span>
                                            <i class="fa fa-angle-down adminpro-icon adminpro-down-arrow"></i>
                                        </a>
                                    <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                        <li><a href="dashboard.php#profile"><span class="fa fa-user author-log-ic"></span>My Profile</a>
                                        </li>
                                        <li><a href="logout.php"><span class="fa fa-lock author-log-ic"></span>Log Out</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Mobile Menu start -->
<div class="mobile-menu-area">
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="mobile-menu">
                <nav id="dropdown">
                    <ul class="mobile-menu-nav">
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
        </div>
    </div>
</div>
</div>


<!-- Mobile Menu end -->
<div class="breadcome-area">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="breadcome-list">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="breadcome-heading">
                            <!-- <form role="search" class="">
                                <input type="text" placeholder="Search..." class="form-control">
                                <a href=""><i class="fa fa-search"></i></a>
                            </form> -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <ul class="breadcome-menu">
                            <li><a href="dashboard.php">Dashboard</a> <span class="bread-slash">/</span>
                            </li>
                            <li><span class="bread-blod"><?php echo $theme;?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>