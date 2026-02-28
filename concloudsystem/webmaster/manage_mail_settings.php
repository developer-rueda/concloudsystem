<?php include_once("includes/source.php"); ?>

<body>
    <?php include_once("includes/left-menu.php"); ?>
    <header>
        <h2>Mail Settings</h2>
        <?php include_once("includes/header_right.php"); ?>
    </header>

    <div class="body_wrap">
        <div class="page_top_wrap mb-3">
            <div class="page_top_wrap_left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                         <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Mail Settings</li>
                    </ol>
                </nav>
                <h2>Manage Mail Settings</h2>
                <h6>Manage mail header, footer, and sidebar images.</h6>
            </div>
        </div>
        <div class="com_info_box_grid">
            <div class="com_info_box_inner">
                <h5 class="com_info_box_inner_sub_head">
                    <span>Documents Header/ Footer</span>
                </h5>
                <div class="table_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Document Header</th>
                                <th>Document Footer</th>
                                <th>Mailer Logo</th>
                                <th>Site logo</th>
                                <th class="action">Status</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td>
                                    <div class="action_div">
                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                    </div>
                                </td>
                                <td class="action">
                                    <div class="action_div">
                                        <a class="popup-btn icon_hover badge_secondary action-transparent br-5 w-auto" data-tab="editdocheaderfooter"><?php edit(); ?></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="com_info_box_inner">
                <h5 class="com_info_box_inner_sub_head">
                    <span>Scientific Section Mailer Setting</span>
                </h5>
                <div class="table_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Sidebar</th>
                                <th>Header Image</th>
                                <th>Footer Image</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td class="action">
                                    <div class="action_div">
                                        <a class="popup-btn icon_hover badge_secondary action-transparent br-5 w-auto" data-tab="editscisectionmailer"><?php edit(); ?></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="com_info_box_inner">
                <h5 class="com_info_box_inner_sub_head">
                    <span>Exhibitor Mailer Setting</span>
                </h5>
                <div class="table_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Sidebar</th>
                                <th>Header Image</th>
                                <th>Footer Image</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td>
                                    <img class="header_img" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                                </td>
                                <td class="action">
                                    <div class="action_div">
                                        <a class="popup-btn icon_hover badge_secondary action-transparent br-5 w-auto" data-tab="editexibitorimage"><?php edit(); ?></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("includes/popup.php"); ?>
</body>
<?php include_once("includes/js-source.php"); ?>


</html>