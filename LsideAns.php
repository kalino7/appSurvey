
<nav id="sidebar" class="">
<div class="sidebar-header">
    <a href="<?php echo htmlspecialchars('answer.php?tok='.$token); ?>"><img class="main-logo" src="img/logo/logo.png" alt="" /></a>
    <strong><img src="img/logo/logosn.png" alt="" /></strong>
</div>
<div class="left-custom-menu-adp-wrap comment-scrollbar">
    <nav class="sidebar-nav left-sidebar-menu-pro">
        <ul class="metismenu" id="menu1">
            <li class="active">
                <a class="has-arrow" href="<?php echo htmlspecialchars('answer.php?tok='.$token); ?>">
                       <i class="fa big-icon fa-files-o icon-wrap"></i>
                       <span class="mini-click-non">Survey</span>
                    </a>
                <ul class="submenu-angle" aria-expanded="true">
                    <li><a title="survey" href="<?php echo htmlspecialchars('answer.php?tok='.$token); ?>"><i class="fa fa-bullseye sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro"> Questions </span></a></li>
                </ul>
            </li>
            <li id="removable">
                <a class="has-arrow" href="#" aria-expanded="false"><i class="fa big-icon fa-pie-chart icon-wrap"></i> <span class="mini-click-non">Leave</span></a>
                <ul class="submenu-angle" aria-expanded="false">
                    <li><a title="Password Recovery" href="logout.php"><i class="fa fa-wheelchair sub-icon-mg" aria-hidden="true"></i><span class="mini-sub-pro">Log out</span></a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
</nav>