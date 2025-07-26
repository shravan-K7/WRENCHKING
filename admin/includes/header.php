<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
        <a href="index.php"></a>
    </div>
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right ms-auto">
            <!-- Use ms-auto for right alignment -->
            <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                    <div class="navbar-profile d-flex align-items-center">
                        <!-- Align image & text -->
                        <?php if ($profile['sp_profile_picture'] == "" || $profile['sp_profile_picture'] == "uploads/") { ?>
                            <img class="img-xs" src="assets/images/faces/face15.jpg" alt="">
                        <?php } else { ?>
                            <img class="img-xs" src="./controllers/<?php echo $profile['sp_profile_picture']; ?>" alt="">
                        <?php } ?>
                        <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $profile['sp_name']; ?></p>
                        <i class="mdi mdi-menu-down d-none d-sm-block ms-1"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="profileDropdown">
                    <a href="./settings.php" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a onclick="return confirm('Are you sure, want to logout?')"
                        href="./controllers/auth.php?action=logout" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Log out</p>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>