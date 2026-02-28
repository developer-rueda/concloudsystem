<?php include_once("includes/source.php"); ?>

<body>
    <?php include_once("includes/left-menu.php"); ?>
    <header>
        <h2>Abstract Registration</h2>
        <?php include_once("includes/header_right.php"); ?>
    </header>
    <div class="body_wrap">
        <div class="page_top_wrap mb-3">
            <div class="page_top_wrap_left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Abstract Registration</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Abstract Master</a></li>
                    </ol>
                </nav>
                <h2>Abstract Master</h2>
                <h6>Manage tariff, dates, packages, and classifications.</h6>
            </div>
        </div>

        <div class="com_info_wrap">
            <div class="com_info_left">
                <h6>Master Menu</h6>
                <button data-tab="abstopic" class="com_info_left_click icon_hover badge_primary active"><i class="fal fa-school"></i>Topic</button>
                <button data-tab="abscategory" class="com_info_left_click icon_hover badge_secondary action-transparent"><?php rupee() ?>Category</button>
                <button data-tab="abssubmission" class="com_info_left_click icon_hover badge_success action-transparent"><?php user() ?>Submission List</button>
                <button data-tab="abspresentation" class="com_info_left_click icon_hover badge_info action-transparent"><?php workshop() ?>Presentation List</button>
                <button data-tab="absfields" class="com_info_left_click icon_hover badge_danger action-transparent"><?php hotel() ?>Fields</button>
            </div>
            <div class="com_info_right">
                <div class="com_info_box active" id="abstopic">
                    <div class="com_info_box_grid">
                        <div class="com_info_box_grid_box">
                            <h5 class="com_info_box_head">
                                <n><span class="text_primary"><?php credit() ?></span> Topic</n>
                                <a class="add mi-1 popup-btn" data-tab="newabstopic"><?php add() ?>Add Topic</a>
                            </h5>
                            <div class="com_info_box_inner">
                                <!-- <h4 class="com_info_box_inner_sub_head"><span>Manage Lunch Dates</span><a class="add mi-1"><?php add(); ?>Add Date</a></h4> -->
                                <div class="table_wrap">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="sl">#</th>
                                                <th>Topic</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th class="action text-right">Status</th>
                                                <th class="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="sl">1</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="action">
                                                    <div class="action_div">
                                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                                    </div>
                                                </td>
                                                <td class="action">
                                                    <div class="action_div dropdown" role="menu" aria-label="Actions for ${item.name}">
                                                        <button class="icon_hover badge_dark action-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open actions menu for ${item.name}"><?php ellips(); ?></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(null)" data-tab="editabstopic" class="popup-btn icon_hover badge_secondary action-transparent"><?php edit(); ?>Edit Details</a>
                                                            <a href="#" class="icon_hover badge_danger action-transparent"><?php delete(); ?>Delete</a>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="com_info_box" id="abscategory">
                    <div class="com_info_box_grid">
                        <div class="com_info_box_grid_box">
                            <h5 class="com_info_box_head">
                                <n><span class="text_secondary"><?php conregi() ?></span> Category</n>
                                <a class="add mi-1 popup-btn" data-tab="newabscategory"><?php add() ?>Add Category</a>
                            </h5>
                            <div class="com_info_box_inner">
                                <!-- <h4 class="com_info_box_inner_sub_head"><span>Manage Lunch Dates</span><a class="add mi-1"><?php add(); ?>Add Date</a></h4> -->
                                <div class="table_wrap">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="sl">#</th>
                                                <th>Category</th>
                                                <th>Fields</th>
                                                <th class="action text-right">Status</th>
                                                <th class="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="sl">1</td>
                                                <td></td>
                                                <td>
                                                    <n class="badge_padding badge_dark mx-1">Field 1</n>
                                                    <n class="badge_padding badge_dark mx-1">Field 2</n>
                                                </td>
                                                <td class="action">
                                                    <div class="action_div">
                                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                                    </div>
                                                </td>
                                                <td class="action">
                                                    <div class="action_div dropdown" role="menu" aria-label="Actions for ${item.name}">
                                                        <button class="icon_hover badge_dark action-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open actions menu for ${item.name}"><?php ellips(); ?></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(null)" data-tab="editabscategory" class="popup-btn icon_hover badge_secondary action-transparent"><?php edit(); ?>Edit Details</a>
                                                            <a href="#" class="icon_hover badge_danger action-transparent"><?php delete(); ?>Delete</a>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="com_info_box" id="abssubmission">
                    <div class="com_info_box_grid">
                        <div class="com_info_box_grid_box">
                            <h5 class="com_info_box_head">
                                <n><span class="text_success"><?php conregi() ?></span> Submission List</n>
                                <a class="add mi-1 popup-btn" data-tab="newabssubmission"><?php add() ?>Add Submission</a>
                            </h5>
                            <div class="com_info_box_inner">
                                <!-- <h4 class="com_info_box_inner_sub_head"><span>Manage Lunch Dates</span><a class="add mi-1"><?php add(); ?>Add Date</a></h4> -->
                                <div class="table_wrap">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="sl">#</th>
                                                <th>Submission Name</th>
                                                <th>Category</th>
                                                <th class="action text-right">Status</th>
                                                <th class="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="sl">1</td>
                                                <td></td>
                                                <td></td>
                                                <td class="action">
                                                    <div class="action_div">
                                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                                    </div>
                                                </td>
                                                <td class="action">
                                                    <div class="action_div dropdown" role="menu" aria-label="Actions for ${item.name}">
                                                        <button class="icon_hover badge_dark action-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open actions menu for ${item.name}"><?php ellips(); ?></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(null)" data-tab="editabssubmission" class="popup-btn icon_hover badge_secondary action-transparent"><?php edit(); ?>Edit Details</a>
                                                            <a href="#" class="icon_hover badge_danger action-transparent"><?php delete(); ?>Delete</a>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="com_info_box" id="abspresentation">
                    <div class="com_info_box_grid">
                        <div class="com_info_box_grid_box">
                            <h5 class="com_info_box_head">
                                <n><span class="text_info"><?php workshop() ?></span> Presentation List</n>
                                <a class="add mi-1 popup-btn" data-tab="newabspresentation"><?php add() ?>Add Presentation</a>
                            </h5>
                            <div class="com_info_box_inner">
                                <!-- <h4 class="com_info_box_inner_sub_head"><span>Manage Lunch Dates</span><a class="add mi-1"><?php add(); ?>Add Date</a></h4> -->
                                <div class="table_wrap">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="sl">#</th>
                                                <th>Presentation Name</th>
                                                <th>Category</th>
                                                <th class="action text-right">Status</th>
                                                <th class="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="sl">1</td>
                                                <td></td>
                                                <td></td>
                                                <td class="action">
                                                    <div class="action_div">
                                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                                    </div>
                                                </td>
                                                <td class="action">
                                                    <div class="action_div dropdown" role="menu" aria-label="Actions for ${item.name}">
                                                        <button class="icon_hover badge_dark action-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open actions menu for ${item.name}"><?php ellips(); ?></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(null)" data-tab="editabspresentation" class="popup-btn icon_hover badge_secondary action-transparent"><?php edit(); ?>Edit Details</a>
                                                            <a href="#" class="icon_hover badge_danger action-transparent"><?php delete(); ?>Delete</a>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="com_info_box" id="absfields">
                    <div class="com_info_box_grid">
                        <div class="com_info_box_grid_box">
                            <h5 class="com_info_box_head">
                                <n><span class="text_danger"><?php hotel() ?></span> Fields</n>
                                 <a class="add mi-1 popup-btn" data-tab="newabsfield"><?php add() ?>Add Field</a>
                            </h5>
                            <div class="com_info_box_inner">
                                <!-- <h4 class="com_info_box_inner_sub_head"><span>Manage Lunch Dates</span><a class="add mi-1"><?php add(); ?>Add Date</a></h4> -->
                                <div class="table_wrap">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="sl">#</th>
                                                <th>Field Name</th>
                                                <th class="action text-right">Status</th>
                                                <th class="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="sl">1</td>
                                                <td></td>
                                                <td></td>
                                                <td class="action">
                                                    <div class="action_div">
                                                        <span class="badge_padding badge_success w-max-con text-uppercase">Active</span>
                                                        <span class="badge_padding badge_danger w-max-con text-uppercase">Inactive</span>
                                                    </div>
                                                </td>
                                                <td class="action">
                                                    <div class="action_div dropdown" role="menu" aria-label="Actions for ${item.name}">
                                                        <button class="icon_hover badge_dark action-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open actions menu for ${item.name}"><?php ellips(); ?></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(null)" data-tab="editabsfield" class="popup-btn icon_hover badge_secondary action-transparent"><?php edit(); ?>Edit Details</a>
                                                            <a href="#" class="icon_hover badge_danger action-transparent"><?php delete(); ?>Delete</a>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("includes/popup.php"); ?>
</body>
<?php include_once("includes/js-source.php"); ?>
<script>
    $('.com_info_left_click').click(function() {
        var tabId = $(this).attr('data-tab');
        $(".com_info_box").removeClass("active");
        $(".com_info_left_click").removeClass("active").addClass('action-transparent');
        $('#' + tabId).addClass("active");
        $(this).addClass("active").removeClass('action-transparent');
    });
    $('.com_info_box_content_sec_left_click').click(function() {
        var tabId = $(this).attr('data-tab');
        $(".com_info_box_content_sec_right_box").removeClass("active");
        $(".com_info_box_content_sec_left_click").removeClass("active").addClass('action-transparent');
        $('#' + tabId).addClass("active");
        $(this).addClass("active").removeClass('action-transparent');
    });
</script>

</html>