<?php include_once("includes/source.php"); ?>

<body>
    <?php include_once("includes/left-menu.php"); ?>
    <header>
        <h2>Conference Mail</h2>
        <?php include_once("includes/header_right.php"); ?>
    </header>

    <div class="body_wrap">
        <div class="page_top_wrap mb-3">
            <div class="page_top_wrap_left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                         <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Conference Mail</li>
                    </ol>
                </nav>
                <h2>Manage Conference Mail</h2>
                <h6>Manage mail titles, and subjects.</h6>
            </div>
        </div>
        <div class="com_info_box_grid">
            <div class="com_info_box_inner">
                <h5 class="com_info_box_inner_sub_head">
                    <span>Mail Setting Listing</span>
                    <a class="add mi-1 popup-btn"><?php add() ?>Add Template</a>
                </h5>
                <div class="table_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th class="check_select">
                                    <label class="cus_check category_check workshop_check">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th class="sl">#</th>
                                <th>Title</th>
                                <th>Mail Subject</th>
                                <th class="action">Status</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="check_select">
                                    <label class="cus_check category_check workshop_check">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                                <td class="sl">1</td>
                                <td>Offline Conference Registration</td>
                                <td>Registration and Payment Confirmation_WBOACON 2025</td>
                                <td>
                                    <div class="action_div">
                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                    </div>
                                </td>
                                <td class="action">
                                    <div class="action_div">
                                        <a class="popup-btn icon_hover badge_secondary action-transparent br-5 w-auto" data-tab="edimailsettinglisting"><?php edit(); ?></a>
                                        <a href="#" class="icon_hover badge_danger action-transparent br-5 w-auto"><?php delete(); ?></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="list-action">
                    <select name="multiOperationSelector" id="multiOperationSelector">
                        <option value="">Choose</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <button class="submit" name="submit" type="button">Apply</button>
                </div>
            </div>
            <div class="com_info_box_inner">
                <h5 class="com_info_box_inner_sub_head">
                    <span>Exhibitor Mail Setting Listing</span>
                     <a class="add mi-1 popup-btn"><?php add() ?>Add Template</a>
                </h5>
                <div class="table_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th class="check_select">
                                    <label class="cus_check category_check workshop_check">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th class="sl">#</th>
                                <th>Title</th>
                                <th>Mail Subject</th>
                                <th class="action">Status</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="check_select">
                                    <label class="cus_check category_check workshop_check">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                                <td class="sl">1</td>
                                <td>Offline Conference Registration</td>
                                <td>Registration and Payment Confirmation_WBOACON 2025</td>
                                <td>
                                    <div class="action_div">
                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                    </div>
                                </td>
                                <td class="action">
                                    <div class="action_div">
                                        <a class="popup-btn icon_hover badge_secondary action-transparent br-5 w-auto" data-tab="ediexibitormailsettinglisting"><?php edit(); ?></a>
                                        <a href="#" class="icon_hover badge_danger action-transparent br-5 w-auto"><?php delete(); ?></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="list-action">
                    <select name="multiOperationSelector" id="multiOperationSelector">
                        <option value="">Choose</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <button class="submit" name="submit" type="button">Apply</button>
                </div>
            </div>
            <div class="com_info_box_inner">
                <h5 class="com_info_box_inner_sub_head">
                    <span>Membership Mail Setting Listing</span>
                     <a class="add mi-1 popup-btn"><?php add() ?>Add Template</a>
                </h5>
               <div class="table_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th class="check_select">
                                    <label class="cus_check category_check workshop_check">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th class="sl">#</th>
                                <th>Title</th>
                                <th>Mail Subject</th>
                                <th class="action">Status</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="check_select">
                                    <label class="cus_check category_check workshop_check">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                                <td class="sl">1</td>
                                <td>Offline Conference Registration</td>
                                <td>Registration and Payment Confirmation_WBOACON 2025</td>
                                <td>
                                    <div class="action_div">
                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                    </div>
                                </td>
                                <td class="action">
                                    <div class="action_div">
                                        <a class="popup-btn icon_hover badge_secondary action-transparent br-5 w-auto" data-tab="edimembormailsettinglistingcc"><?php edit(); ?></a>
                                        <a href="#" class="icon_hover badge_danger action-transparent br-5 w-auto"><?php delete(); ?></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="list-action">
                    <select name="multiOperationSelector" id="multiOperationSelector">
                        <option value="">Choose</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <button class="submit" name="submit" type="button">Apply</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("includes/popup.php"); ?>
</body>
<?php include_once("includes/js-source.php"); ?>


</html>