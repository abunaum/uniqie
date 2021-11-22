<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <div class="form-header"></div>
                <div class="header-button">
                    <div class="noti-wrap">
                        <div class="noti__item">
                            <a href="<?= base_url('admin/notifikasi') ?>" class="nav-link">
                                <i class="zmdi zmdi-notifications"></i>
                            </a>
                        </div>
                    </div>
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="<?= user()->profile; ?>" class="rounded-circle img-thumbnail" />
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#"><?= user()->name; ?></a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <img src="<?= user()->profile; ?>" />
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <?= user()->name; ?>
                                        </h5>
                                        <span class="email"><?= user()->email; ?></span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="<?= base_url('admin/profile'); ?>">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-money-box"></i>Billing</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="<?= base_url('logout'); ?>">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>