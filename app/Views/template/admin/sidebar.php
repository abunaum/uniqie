<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <?php
        // if (in_groups('admin')) {
        //     $role = 'admin';
        // } else {
        //     $role = 'seller';
        // }

        ?>
        <a href="">
            <img src="<?= base_url('images/header-logo.png'); ?>" style="width: 100%; height: auto;" alt="Abunaum" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <?= $this->include('template/admin/menu') ?>
            </ul>
        </nav>
    </div>
</aside>