<?php include_once("includes/source.php"); ?>

<body>
    <?php include_once("includes/left-menu.php"); ?>
    <header>
        <h2>Settings</h2>
        <?php include_once("includes/header_right.php"); ?>
    </header>

    <div class="body_wrap">
        <div class="page_top_wrap mb-3">
            <div class="page_top_wrap_left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Architecture</li>
                    </ol>
                </nav>
                <h2>Architecture</h2>
                <h6>Manage section, modul & page details.</h6>
            </div>
        </div>
        <div class="regi_search_wrap mb-3">
            <div class="regi_search">
                <?php search(); ?>
                <input placeholder="Search by Name, Email, Mobile, or Reg ID...">
            </div>
            <div class="regi_search_wrap_btn_box">
                <a href="javascript:void(null)" class="popup-btn add" data-tab="addsection"><?php add(); ?>New Section</a>
            </div>
        </div>
        <ul class="architc_wrap">
            <li class="architec_section_wrap">
                <div class="architec_section_box accm_top">
                    <div class="spot_name d-flex align-items-center">
                        <div class="regi_img_circle">
                            <img src="" alt="" class="w-100 h-100">
                        </div>
                        <div>
                            <div class="regi_name">Settings</div>
                        </div>
                    </div>
                    <div class="accm_details">
                        <div class="accm_details_box">
                            <h5>Section Code</h5>
                            <h6>#SET</h6>
                        </div>
                        <div class="accm_details_box">
                            <h5>Path</h5>
                            <h6>section_configuration/</h6>
                        </div>
                        <div class="accm_details_box action" style="flex:unset;">
                            <a href="#" class="drp open_module_btn">1 Module<i class="fal fa-angle-down"></i></a>
                        </div>
                    </div>
                    <div class="accm_details d-none">
                        <div class="accm_details_box">
                            <h5>Ref. No.</h5>
                            <h6>004</h6>
                        </div>
                        <div class="accm_details_box">
                            <h5>File Name</h5>
                            <h6>page.php?show=add</h6>
                        </div>
                        <div class="accm_details_box">
                            <h5>Page Info</h5>
                            <h6>page.php?show=add</h6>
                        </div>
                    </div>
                </div>
                <ul class="architec_section_inner">
                    <li class="architec_module_wrap">
                        <div class="architec_module_box accm_top">
                            <div class="spot_name">
                                <div>
                                    <div class="regi_name">Architecture</div>
                                </div>
                            </div>
                            <div class="accm_details">
                                <div class="accm_details_box">
                                    <h5>Ref. No.</h5>
                                    <h6>001</h6>
                                </div>
                                <div class="accm_details_box action" style="flex:unset;">
                                    <a href="#" class="drp open_page_btn">1 Page<i class="fal fa-angle-down"></i></a>
                                </div>

                            </div>
                        </div>
                        <ul class="architec_module_inner">
                            <li class="architec_page_wrap">
                                <div class="architec_page_box accm_top">
                                    <div class="spot_name d-flex">
                                        <div>
                                            <div class="regi_name">Add Page</div>
                                        </div>
                                    </div>
                                    <div class="accm_details">
                                        <div class="accm_details_box">
                                            <h5>Ref. No.</h5>
                                            <h6>004</h6>
                                        </div>
                                        <div class="accm_details_box">
                                            <h5>File Name</h5>
                                            <h6>page.php?show=add</h6>
                                        </div>
                                        <div class="accm_details_box">
                                            <h5>Page Info</h5>
                                            <h6>page.php?show=add</h6>
                                        </div>
                                        <div class="accm_details_box action" style="flex:unset;">
                                            <a href="#" class="drp open_subpage_btn">1 Sub-page<i class="fal fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="architec_sub_page_inner">
                                    <li class="architec_page_wrap">
                                        <div class="architec_page_box accm_top">
                                            <div class="spot_name d-flex">
                                                <div>
                                                    <div class="regi_name">Add Sub Page</div>
                                                </div>
                                            </div>
                                            <div class="accm_details">
                                                <div class="accm_details_box">
                                                    <h5>Ref. No.</h5>
                                                    <h6>004</h6>
                                                </div>
                                                <div class="accm_details_box">
                                                    <h5>File Name</h5>
                                                    <h6>page.php?show=add</h6>
                                                </div>
                                                <div class="accm_details_box">
                                                    <h5>Page Info</h5>
                                                    <h6>page.php?show=add</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="architec_page_wrap">
                                <div class="architec_page_box accm_top">
                                    <div class="spot_name d-flex">
                                        <div>
                                            <div class="regi_name">Add Page</div>
                                        </div>
                                    </div>
                                    <div class="accm_details">
                                        <div class="accm_details_box">
                                            <h5>Ref. No.</h5>
                                            <h6>004</h6>
                                        </div>
                                        <div class="accm_details_box">
                                            <h5>File Name</h5>
                                            <h6>page.php?show=add</h6>
                                        </div>
                                        <div class="accm_details_box">
                                            <h5>Page Info</h5>
                                            <h6>page.php?show=add</h6>
                                        </div>

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
                <div class="spot_box_bottom">

                    <div class="spot_box_bottom_right">
                        <a href="#" class="popup-btn icon_hover badge_secondary action-transparent"><?php edit() ?>Edit</a>
                    </div>
                </div>
            </li>

        </ul>
    </div>
    <?php include_once("includes/popup.php"); ?>
</body>
<?php include_once("includes/js-source.php"); ?>
<script>
    $('.open_module_btn').click(function() {
        if ($(this).hasClass("active")) {
            $(".open_module_btn").removeClass('active');
            $(".architec_section_inner").slideUp();
            $(".open_page_btn").removeClass('active');
            $(".architec_module_inner").slideUp();
            $(".open_subpage_btn").removeClass('active');
            $(".architec_sub_page_inner").slideUp();
        } else {
            $(".open_module_btn").removeClass('active');
            $(".architec_section_inner").slideUp();
            $(".open_page_btn").removeClass('active');
            $(".architec_module_inner").slideUp();
            $(".open_subpage_btn").removeClass('active');
            $(".architec_sub_page_inner").slideUp();
            $(this).parent().parent().parent().parent().find('.architec_section_inner').slideToggle();
            $(this).toggleClass('active');
        }
    });
    $('.open_page_btn').click(function() {
        if ($(this).hasClass("active")) {
            $(".open_page_btn").removeClass('active');
            $(".architec_module_inner").slideUp();
        } else {
            $(".open_page_btn").removeClass('active');
            $(".architec_module_inner").slideUp();
            $(this).parent().parent().parent().parent().find('.architec_module_inner').slideToggle();
            $(this).toggleClass('active');
        }
    });
    $('.open_subpage_btn').click(function() {
        if ($(this).hasClass("active")) {
            $(".open_subpage_btn").removeClass('active');
            $(".architec_sub_page_inner").slideUp();
        } else {
            $(".open_subpage_btn").removeClass('active');
            $(".architec_sub_page_inner").slideUp();
            $(this).parent().parent().parent().parent().find('.architec_sub_page_inner').slideToggle();
            $(this).toggleClass('active');
        }
    });
</script>

</html>