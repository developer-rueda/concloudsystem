<?php include_once("includes/source.php"); ?>

<body>
    <?php include_once("includes/left-menu.php"); ?>
    <header>
        <h2>Workshop Report</h2>
        <?php include_once("includes/header_right.php"); ?>
    </header>

    <div class="body_wrap">
        <div class="page_top_wrap mb-3">
            <div class="page_top_wrap_left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Workshop</a></li>
                        <li class="breadcrumb-item">Workshop Report</li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
                <h2>Workshop Details Report</h2>
            </div>
             <div class="page_top_wrap_right">
                <p><?php user(); ?>Total: <b>2</b></p>
                <a href="workshop_report.php" class="badge_danger"><i class="fal fa-arrow-left"></i>Back</a>
            </div>
        </div>

        <div class="regi_search_wrap mb-3">
            <div class="regi_search">
                <?php search(); ?>
                <input placeholder="Search by Name, Email, Mobile, or Reg ID...">
            </div>
            <div class="regi_search_wrap_btn_box">
                <a href="javascript:void(null)" onclick="$('.filter_wrap').slideToggle(); $(this).toggleClass('active');"><?php filter(); ?>Filter</a>
            </div>
        </div>

        <div class="filter_wrap mb-3">
            <h4 class="filter_heading"><span>Advanced Filtering</span><a class="close_filter" onclick="$('.filter_wrap').slideUp();"><?php close(); ?></a></h4>
            <div class="filter_body">
                <div>
                    <label>Registration Type</label>
                    <select>
                        <option>All Types</option>
                    </select>
                </div>
                <div>
                    <label>Payment Status</label>
                    <select>
                        <option>All Status</option>
                    </select>
                </div>
                <div>
                    <label>Registration Date</label>
                    <input type="date">
                </div>
            </div>
            <div class="filter_bottom">
                <button><?php reseti(); ?></button>
                <button type="submit">Apply</button>
            </div>
        </div>

        <div class="workshop_overview_wrap mb-3">
            <h2 class="sub_head">Workshop Overview</h2>
            <ul>
                <li>Workshop Classification<span>TB & Critical Care Workshop</span></li>
                <li>Seat Limit<span>50</span></li>
                <li>Total Paid Delegate(s)<span>6</span></li>
                <li>Total Unpaid Delegate(s)<span>1</span></li>
                <li>Total Complementary Delegate(s)<span>0</span></li>
                <li>Total Reg. Delegate(s)<span>7</span></li>
                <li>Total Zero Value Delegate(s)<span>0</span></li>
                <li>Seat Left<span>44</span></li>
            </ul>
        </div>
        <div class="spot_listing">
            <div class="spot_box">
                <div class="spot_box_top">
                    <div class="spot_name d-flex align-items-start">
                        <div class="regi_img_circle">
                            <!-- <img src="" alt="" class="w-100 h-100"> -->
                            <span>AM</span>
                        </div>
                        <div>
                            <div class="regi_name">Dr. Asim Kumar Majumdar</div>
                            <div class="regi_type">
                                <span class="badge_padding badge_primary">Delegate</span>
                                <span class="badge_padding badge_secondary">Early Bird</span>
                            </div>
                            <div class="regi_contact">
                                <span>
                                    <?php call(); ?>9674833617
                                </span>
                                <span>
                                    <?php email(); ?>drasim53@gmail.com
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="spot_details">
                        <div class="spot_details_box">
                            <h5>Reg Number</h5>
                            <p>NATCON 2025-1176-0638</p>
                        </div>
                        <div class="spot_details_box">
                            <h5>Uniq Sequence</h5>
                            <h6><?php qr(); ?><b>#82680594</b></h6>
                        </div>
                        <div class="spot_details_box align-items-end">
                            <h5>Payment Status</h5>
                            <span class="pay_status badge_padding badge_success w-max-con text-uppercase"><?php paid(); ?>Paid</span>
                            <h6>INR 14,000</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spot_box">
                <div class="spot_box_top">
                    <div class="spot_name d-flex align-items-start">
                        <div class="regi_img_circle">
                            <!-- <img src="" alt="" class="w-100 h-100"> -->
                            <span>AM</span>
                        </div>
                        <div>
                            <div class="regi_name">Dr. Asim Kumar Majumdar</div>
                            <div class="regi_type">
                                <span class="badge_padding badge_primary">Delegate</span>
                                <span class="badge_padding badge_secondary">Early Bird</span>
                            </div>
                            <div class="regi_contact">
                                <span>
                                    <?php call(); ?>9674833617
                                </span>
                                <span>
                                    <?php email(); ?>drasim53@gmail.com
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="spot_details">
                        <div class="spot_details_box">
                            <h5>Reg Number</h5>
                            <p>NATCON 2025-1176-0638</p>
                        </div>
                        <div class="spot_details_box">
                            <h5>Uniq Sequence</h5>
                            <h6><?php qr(); ?><b>#82680594</b></h6>
                        </div>
                        <div class="spot_details_box align-items-end">
                            <h5>Payment Status</h5>
                            <span class="pay_status badge_padding badge_danger w-max-con text-uppercase"><?php unpaid(); ?>Unpaid</span>
                            <h6>INR 14,000</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("includes/popup.php"); ?>
</body>
<?php include_once("includes/js-source.php"); ?>

</html>