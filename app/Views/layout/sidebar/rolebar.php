<div class="data-scrollbar" data-scroll="1">
    <div class="new-create select-dropdown input-prepend input-append">
        <div class="btn-group">
            <label data-toggle="dropdown">
                <div class="search-query selet-caption"><i class="las la-plus pr-2"></i>Create </div>
                <span class="search-replace"></span>
                <span class="caret">
                    <!--icon-->
                </span>
            </label>
            <ul class="dropdown-menu">
                <li>
                    <div class="item"><i class="ri-folder-add-line pr-3"></i>Category</div>
                </li>
                <li>
                    <div class="item"><i class="ri-file-upload-line pr-3"></i>Sub Category</div>
                </li>
                <li>
                    <div class="item"><i class="ri-folder-upload-line pr-3"></i>Type</div>
                </li>
                <li>
                    <div class="item"><i class="ri-folder-upload-line pr-3"></i>Product</div>
                </li>
                <li>
                    <div class="item"><i class="ri-folder-upload-line pr-3"></i>Add item</div>
                </li>
            </ul>
        </div>

    </div>
    <nav class="iq-sidebar-menu">

        <ul id="iq-sidebar-toggle" class="iq-menu">

            <?php if ($user_role == 1) : ?>
                <li class="<?= nav_active("admin/dashboard") ?>">
                    <a href="<?= base_url("admin/dashboard") ?>" class="">
                        <i class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                    </a>
                    <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    </ul>
                </li>
                <li class=" ">
                    <a href="#mydrive" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-hdd"></i><span>All Master</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="mydrive" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="<?= nav_active("admin/user-creation") ?>">
                            <a href="<?= base_url("admin/user-creation") ?>">
                                <i class="las la-users-cog"></i><span>User Creation</span>
                            </a>
                        </li>
                        <li class="<?= nav_active("admin/product-type") ?>">
                            <a href="<?= base_url("admin/product-type") ?>">
                                <i class="las la-share-alt "></i><span>Type</span>
                            </a>
                        </li>
                        <li class="<?= nav_active("admin/product-category") ?>">
                            <a href="<?= base_url("admin/product-category") ?>">
                                <i class="las la-vector-square "></i><span>Category</span>
                            </a>
                        </li>
                        <li class="<?= nav_active("admin/product-sub-category") ?>">
                            <a href="<?= base_url("admin/product-sub-category") ?>">
                                <i class="las la-layer-group"></i><span>Sub Category</span>
                            </a>
                        </li>

                        <li class="<?= nav_active("admin/create-product") ?>">
                            <a href="<?= base_url("admin/create-product") ?>">
                                <i class="las la-table"></i><span>Product</span>
                            </a>
                        </li>
                        <li class="<?= nav_active("admin/create-ticket-titles") ?>">
                            <a href="<?= base_url("admin/create-ticket-titles") ?>">
                                <i class="las la-paperclip"></i><span>Ticket Titles</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?= nav_active("global/inventory") ?>">
                    <a href="<?= base_url("global/inventory") ?>" class="">
                        <i class="las la-warehouse iq-arrow-left"></i><span>Inventory</span>
                    </a>
                    <ul id="page-files" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    </ul>
                </li>
                <li class=" ">
                    <a href="page-folders.html" class="">
                        <i class="las la-stopwatch iq-arrow-left"></i><span>Recent</span>
                    </a>
                    <ul id="page-folders" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    </ul>
                </li>

                <li class=" ">
                    <a href="#otherpage" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="lab la-wpforms iq-arrow-left"></i><span>other page</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="otherpage" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class=" ">
                            <a href="#user" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="las la-user-cog"></i><span>User Details</span>
                                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="user" class="iq-submenu collapse" data-parent="#otherpage">
                                <li class=" ">
                                    <a href="https://templates.iqonic.design/cloudbox/html/app/user-profile.html">
                                        <i class="las la-id-card"></i><span>User Profile</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="https://templates.iqonic.design/cloudbox/html/app/user-add.html">
                                        <i class="las la-user-plus"></i><span>User Add</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="https://templates.iqonic.design/cloudbox/html/app/user-list.html">
                                        <i class="las la-list-alt"></i><span>User List</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#ui" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="lab la-uikit iq-arrow-left"></i><span>UI Elements</span>
                                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="ui" class="iq-submenu collapse" data-parent="#otherpage">
                                <li class=" ">
                                    <a href="ui-avatars.html">
                                        <i class="las la-user-tie"></i><span>Avatars</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-alerts.html">
                                        <i class="las la-exclamation-triangle"></i><span>Alerts</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-badges.html">
                                        <i class="las la-id-badge"></i><span>Badges</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-breadcrumb.html">
                                        <i class="las la-ellipsis-h"></i><span>Breadcrumb</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-buttons.html">
                                        <i class="las la-ticket-alt"></i><span>Buttons</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-buttons-group.html">
                                        <i class="las la-object-group"></i><span>Buttons Group</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-boxshadow.html">
                                        <i class="las la-boxes"></i><span>Box Shadow</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-colors.html">
                                        <i class="las la-brush"></i><span>Colors</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-cards.html">
                                        <i class="las la-credit-card"></i><span>Cards</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-carousel.html">
                                        <i class="las la-sliders-h"></i><span>Carousel</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-grid.html">
                                        <i class="las la-th-large"></i><span>Grid</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-helper-classes.html">
                                        <i class="las la-hands-helping"></i><span>Helper classes</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-images.html">
                                        <i class="las la-image"></i><span>Images</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-list-group.html">
                                        <i class="las la-list-alt"></i><span>list Group</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-media-object.html">
                                        <i class="las la-photo-video"></i><span>Media</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-modal.html">
                                        <i class="las la-columns"></i><span>Modal</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-notifications.html">
                                        <i class="las la-bell"></i><span>Notifications</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-pagination.html">
                                        <i class="las la-ellipsis-h"></i><span>Pagination</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-popovers.html">
                                        <i class="las la-spinner"></i><span>Popovers</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-progressbars.html">
                                        <i class="las la-heading"></i><span>Progressbars</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-typography.html">
                                        <i class="las la-tablet"></i><span>Typography</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-tabs.html">
                                        <i class="las la-tablet"></i><span>Tabs</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-tooltips.html">
                                        <i class="las la-magnet"></i><span>Tooltips</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="ui-embed-video.html">
                                        <i class="las la-play-circle"></i><span>Video</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#auth" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="las la-torah iq-arrow-left"></i><span>Authentication</span>
                                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="auth" class="iq-submenu collapse" data-parent="#otherpage">
                                <li class=" ">
                                    <a href="auth-sign-in.html">
                                        <i class="las la-sign-in-alt"></i><span>Login</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="auth-sign-up.html">
                                        <i class="las la-registered"></i><span>Register</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="auth-recoverpw.html">
                                        <i class="las la-unlock-alt"></i><span>Recover Password</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="auth-confirm-mail.html">
                                        <i class="las la-envelope-square"></i><span>Confirm Mail</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="auth-lock-screen.html">
                                        <i class="las la-lock"></i><span>Lock Screen</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#pricing" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="las la-coins"></i><span>Pricing</span>
                                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="pricing" class="iq-submenu collapse" data-parent="#otherpage">
                                <li class=" ">
                                    <a href="pricing.html">
                                        <i class="las la-weight"></i><span>Pricing 1</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="pricing-2.html">
                                        <i class="las la-dna"></i><span>Pricing 2</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#pages-error" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="las la-exclamation-triangle"></i><span>Error</span>
                                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="pages-error" class="iq-submenu collapse" data-parent="#otherpage">
                                <li class=" ">
                                    <a href="pages-error.html">
                                        <i class="las la-bomb"></i><span>Error 404</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="pages-error-500.html">
                                        <i class="las la-exclamation-circle"></i><span>Error 500</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a href="pages-blank-page.html">
                                <i class="las la-pager"></i><span>Blank Page</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="pages-maintenance.html">
                                <i class="las la-cubes"></i><span>Maintenance</span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php elseif ($user_role == 2) :  ?>
                <li class="<?= nav_active("maintainer/dashboard") ?>">
                    <a href="<?= base_url("maintainer/dashboard") ?>" class="">
                        <i class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                    </a>
                    <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    </ul>
                </li>
                <li class=" ">
                    <a href="#assert" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-hdd"></i><span>Assert</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="assert" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="<?= nav_active("maintainer/my-assert") ?>">
                            <a href="<?= base_url("maintainer/my-assert") ?>">
                                <i class="las la-dumpster "></i><span>My Maintainace</span>
                            </a>
                        </li>
                        <!-- <li class="<?= nav_active("maintainer/repaired") ?>">
                            <a href="<?= base_url("maintainer/repaired") ?>">
                                <i class="las la-undo-alt"></i><span>Repaired</span>
                            </a>
                        </li>
                        <li class="<?= nav_active("maintainer/upgradable") ?>">
                            <a href="<?= base_url("maintainer/upgradable") ?>">
                                <i class="las la-tools"></i><span>Upgradable</span>
                            </a>
                        </li>
                        <li class="<?= nav_active("maintainer/damaged") ?>">
                            <a href="<?= base_url("maintainer/damaged") ?>">
                                <i class="las la-trash "></i><span>Damaged</span>
                            </a>
                        </li> -->
                    </ul>
                </li>
                <li class="<?= nav_active("maintainer/ticket") ?>">
                    <a href="<?= base_url("maintainer/ticket") ?>" class="">
                        <i class="las la-bullhorn"></i><span>Ticket</span>
                    </a>
                    <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    </ul>
                </li>
            <?php elseif ($user_role == 3) :  ?>
                <li class="<?= nav_active("staff/dashboard") ?>">
                    <a href="<?= base_url("staff/dashboard") ?>" class="">
                        <i class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                    </a>
                    <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    </ul>
                </li>
                <li class="<?= nav_active("staff/my-assert") ?>">
                    <a href="<?= base_url("staff/my-assert") ?>">
                        <i class="las la-dumpster "></i><span>My Maintainace</span>
                    </a>
                </li>
                <li class="<?= nav_active("staff/ticket") ?>">
                    <a href="<?= base_url("staff/ticket") ?>">
                        <i class="las la-bullhorn "></i><span>Ticket</span>
                    </a>
                </li>
            <?php endif; ?>
            <!-- global bar -->
            <li class="<?= nav_active("global/chat") ?>">
                <a href="<?= base_url("global/chat") ?>" class="">
                    <i class="las la-comment iq-arrow-left"></i><span>Chat</span>
                </a>
                <ul id="page-chat" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                </ul>
            </li>
        </ul>

    </nav>
    <!-- <div class="sidebar-bottom">
        <h4 class="mb-3"><i class="las la-cloud mr-2"></i>Storage</h4>
        <p>17.1 / 20 GB Used</p>
        <div class="iq-progress-bar mb-3">
            <span class="bg-primary iq-progress progress-1" data-percent="67">
            </span>
        </div>
        <p>75% Full - 3.9 GB Free</p>
        <a href="#" class="btn btn-outline-primary view-more mt-4">Buy Storage</a>
    </div> -->
    <div class="p-3"></div>
</div>