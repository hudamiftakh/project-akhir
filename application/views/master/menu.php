<nav class="sidebar-nav scroll-sidebar" data-simplebar>
  <ul id="sidebarnav">
    <li class="nav-small-cap">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Menu Aplikasi</span>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link sidebar-link" href="<?php echo base_url('dashboard') ?>" aria-expanded="false">
        <span class="rounded-3">
          <i class="ti ti-layout-grid"></i>
        </span>
        <span class="hide-menu"> Dashboard</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link sidebar-link" href="<?php echo base_url('kendaraan') ?>" aria-expanded="false">
        <span class="rounded-3">
          <i class="ti ti-car"></i>
        </span>
        <span class="hide-menu"> Kendaraan</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link sidebar-link" href="<?php echo base_url('sopir') ?>" aria-expanded="false">
        <span class="rounded-3">
          <i class="ti ti-users"></i>
        </span>
        <span class="hide-menu">Sopir</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link sidebar-link" href="<?php echo base_url('transaksi') ?>" aria-expanded="false">
        <span class="rounded-3">
          <i class="ti ti-file-invoice"></i>
        </span>
        <span class="hide-menu">Transaksi</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link sidebar-link" href="<?php echo base_url('laporan') ?>" aria-expanded="false">
        <span class="rounded-3">
          <i class="ti ti-file-invoice"></i>
        </span>
        <span class="hide-menu">Laporan</span>
      </a>
    </li>
    <?php
    $menu = $this->uri->segment(1);
    $submenu = $this->uri->segment(2);
    ?>
    <!-- <li class="sidebar-item">
      <a class="sidebar-link has-arrow <?php echo (in_array($menu, array('broadcast'))) ? 'active' : ''; ?>"
        href="javascript:void(0)" aria-expanded="false">
        <span class="d-flex">
          <i class="ti ti-message-dots"></i>
        </span>
        <span class="hide-menu">Broadcast</span>
      </a>
      <ul aria-expanded="false"
        class="collapse first-level <?php echo (in_array($menu, array('broadcast'))) ? 'in' : ''; ?>">
        <li class="sidebar-item">
          <a href="<?php echo base_url('broadcast/group_contact') ?>"
            class="sidebar-link <?php echo (in_array($submenu, array('group_contact', 'contact-group'))) ? 'active' : ''; ?>">
            <div class="round-16 d-flex align-items-center justify-content-center">
              <i class="ti ti-circle"></i>
            </div>
            <span class="hide-menu">Group Contact</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="<?php echo base_url('broadcast/template-message') ?>"
            class="sidebar-link <?php echo (in_array($submenu, array('template_message'))) ? 'active' : ''; ?>">
            <div class="round-16 d-flex align-items-center justify-content-center">
              <i class="ti ti-circle"></i>
            </div>
            <span class="hide-menu">Template Message</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="<?php echo base_url('broadcast/broadcast') ?>"
            class="sidebar-link <?php echo (in_array($submenu, array('broadcast','create-broadcast'))) ? 'active' : ''; ?>">
            <div class="round-16 d-flex align-items-center justify-content-center">
              <i class="ti ti-circle"></i>
            </div>
            <span class="hide-menu">Broadcast</span>
          </a>
        </li>
      </ul>
    </li> -->
    <!-- <li class="sidebar-item">
      <a class="sidebar-link sidebar-link" href="<?php echo base_url() ?>api" aria-expanded="false">
        <span class="rounded-3">
          <i class="ti ti-alert-square-rounded"></i>
        </span>
        <span class="hide-menu"> API Docs</span>
      </a>
    </li> -->
    <li class="sidebar-item">
      <a class="sidebar-link sidebar-link" href="<?php echo base_url() ?>logout" aria-expanded="false">
        <span class="rounded-3">
          <i class="ti ti-logout"></i>
        </span>
        <span class="hide-menu"> Logout</span>
      </a>
    </li>
  </ul>
  <div class="unlimited-access hide-menu bg-light-primary position-relative my-7 rounded">
    <div class="d-flex">
      <div class="unlimited-access-title">
        <h6 class="fw-semibold fs-4 mb-6 text-dark w-85" style="color: orange">Aplikasi Market dan Sopir @
          <?= date('Y'); ?>
        </h6>
        <!-- <button class="btn btn-primary fs-2 fw-semibold lh-sm">Homepage</button> -->
      </div>
      <div class="unlimited-access-img">
        <img src="<?php echo base_url(); ?>dist/images/backgrounds/rocket.png" style="width: 100%" alt=""
          class="img-fluid">
      </div>
    </div>
  </div>
</nav>