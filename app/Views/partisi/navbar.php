<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item d-inline-flex d-md-none">
                    <a
                        class="pc-head-link dropdown-toggle arrow-none m-0"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-search"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="form-group mb-0 d-flex align-items-center">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
                            </div>
                        </form>
                    </div>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="header-search">
                        <i data-feather="search" class="icon-search"></i>
                        <input type="search" class="form-control" placeholder="Search here. . .">
                    </form>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a
                        class="pc-head-link dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-bell"></i>
                        <span class="badge bg-danger rounded-pill" id="header-notif-count" style="display: none;">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Notifikasi</h5>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
                            <div class="list-group list-group-flush w-100" id="header-notif-list">
                                <!-- Dynamic Content -->
                            </div>
                        </div>
                    </div>
                </li>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadHeaderNotifications();

    function loadHeaderNotifications() {
        fetch('/siswa/notifikasi/get')
            .then(response => response.json())
            .then(data => {
                const countBadge = document.getElementById('header-notif-count');
                const listContainer = document.getElementById('header-notif-list');
                
                // Update Badge
                if (data.unreadCount > 0) {
                    countBadge.innerText = data.unreadCount;
                    countBadge.style.display = 'inline-block';
                } else {
                    countBadge.style.display = 'none';
                }

                // Update List
                if (data.notifications && data.notifications.length > 0) {
                    listContainer.innerHTML = data.notifications.map(notif => `
                        <a href="/dashboard-siswa" class="list-group-item list-group-item-action">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="user-avtar bg-light-primary text-primary">
                                        <i class="ti ti-bell"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-1">
                                    <span class="float-end text-muted text-sm">${new Date(notif.created_at).toLocaleDateString()}</span>
                                    <p class="text-body mb-1"><b>${notif.judul}</b></p>
                                    <span class="text-muted d-block text-truncate" style="max-width: 200px;">${notif.pesan}</span>
                                </div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    listContainer.innerHTML = '<div class="p-3 text-center text-muted">Tidak ada notifikasi masuk</div>';
                }
            })
            .catch(error => console.error('Error loading notifications:', error));
    }
});
</script>
                <li class="dropdown pc-h-item header-user-profile">
                    <a
                        class="pc-head-link dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-haspopup="false"
                        data-bs-auto-close="outside"
                        aria-expanded="false">
                        <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
                        <span><?= session('nama') ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex mb-1">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1"><?= session('nama') ?></h6>
                                    <span><?= session('role') === 'admin' ? 'Administrator' : (session('kelas') ? session('kelas') : 'Siswa') ?></span>
                                </div>
                                <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></a>
                            </div>
                        </div>
                        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link active"
                                    id="drp-t1"
                                    data-bs-toggle="tab"
                                    data-bs-target="#drp-tab-1"
                                    type="button"
                                    role="tab"
                                    aria-controls="drp-tab-1"
                                    aria-selected="true"><i class="ti ti-user"></i> Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    id="drp-t2"
                                    data-bs-toggle="tab"
                                    data-bs-target="#drp-tab-2"
                                    type="button"
                                    role="tab"
                                    aria-controls="drp-tab-2"
                                    aria-selected="false"><i class="ti ti-settings"></i> Setting</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="mysrpTabContent">
                            <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
                                <?php if (session('role') === 'admin') : ?>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-edit-circle"></i>
                                    <span>Edit Profile</span>
                                </a>
                                <?php endif; ?>
                                
                                <a href="<?= url_to('logout') ?>" class="dropdown-item">
                                    <i class="ti ti-power"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                            <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-help"></i>
                                    <span>Support</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-user"></i>
                                    <span>Account Settings</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-lock"></i>
                                    <span>Privacy Center</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-messages"></i>
                                    <span>Feedback</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-list"></i>
                                    <span>History</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>