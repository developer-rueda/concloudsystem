<?php 
include_once("includes/source.php");
include_once("includes/source.php"); 
include_once("includes/source.php");
include_once('includes/init.php');
include_once('includes/function.workshop.php');
// $cfg['SECTION_BASE_URL'] = "https://ruedakolkata.com/natcon_25/conference_registration/webmaster/";
?>

<body>
    <?php include_once("includes/left-menu.php"); ?>
    <header>
        <h2>General Registration</h2>
       <?php include_once("includes/header_right.php"); ?>
    </header>

    <div class="body_wrap">
        <div class="page_top_wrap mb-3">
            <div class="page_top_wrap_left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accomdation</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Booking Manager</li>
                    </ol>
                </nav>
                <h2>Hotel & Room Allotment</h2>
                <h6>Manage hotel inventories and delegate room assignments.</h6>
            </div>
            

        </div>
        <ul class="regi_data_grid_ul accm_data_grid_ul mb-3">
            <li>
                <span class="badge_primary"><?php hotel(); ?></span>
                <g>5 Star</g>
                <div>
                    <h4>The Westin Kolkata</h4>
                    <h6 class="text-muted">Kolkata, West Bengal</h6>
                </div>
                <div class="progress-bar-wrap">
                    <div class="progress-value">Occupancy<n>0%</n>
                    </div>
                    <div class="progress">
                        <div class="progress-done bg_primary" data-progress="40"></div>
                    </div>
                </div>
                <ol>
                    <li><i>Total</i>200</li>
                    <li><i>Booked</i>200</li>
                    <li style="color: var(--success2);"><i>Avail</i>200</li>
                </ol>
            </li>
            <li>
                <span class="badge_secondary"><?php hotel(); ?></span>
                <g>5 Star</g>
                <div>
                    <h4>JW Marriott</h4>
                    <h6 class="text-muted">Kolkata, West Bengal</h6>
                </div>
                <div class="progress-bar-wrap">
                    <div class="progress-value">Occupancy<n>0%</n>
                    </div>
                    <div class="progress">
                        <div class="progress-done bg_secondary" data-progress="30"></div>
                    </div>
                </div>
                <ol>
                    <li><i>Total</i>200</li>
                    <li><i>Booked</i>200</li>
                    <li style="color: var(--success2);"><i>Avail</i>200</li>
                </ol>
            </li>
            <li>
                <span class="badge_info"><?php hotel(); ?></span>
                <g>5 Star</g>
                <div>
                    <h4>ITC Royal Bengal</h4>
                    <h6 class="text-muted">Kolkata, West Bengal</h6>
                </div>
                <div class="progress-bar-wrap">
                    <div class="progress-value">Occupancy<n>0%</n>
                    </div>
                    <div class="progress">
                        <div class="progress-done bg_info" data-progress="20"></div>
                    </div>
                </div>
                <ol>
                    <li><i>Total</i>200</li>
                    <li><i>Booked</i>200</li>
                    <li style="color: var(--success2);"><i>Avail</i>200</li>
                </ol>
            </li>
        </ul>

        <div class="regi_search_wrap mb-3">
            <div class="regi_search">
                <?php search(); ?>
                <input placeholder="Search by Name, Email, Mobile, or Reg ID...">
            </div>
            <div class="regi_search_wrap_btn_box">
                <a href="javascript:void(null)" onclick="$('.filter_wrap').slideToggle(); $(this).toggleClass('active');"><?php filter(); ?>Filter</a>
                <a href="javascript:void(null)"><?php export(); ?>Export</a>
                <a href="javascript:void(null)" class="popup-btn add" data-tab="newbooking"><?php add(); ?>New Booking</a>
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

        <div class="table_wrap">
            <table>
                <thead>
                    <tr>
                        <th>Guest Name</th>
                        <th>Hotel & Room</th>
                        <th>Stay Dates</th>
                        <th>Occupancy</th>
                        <th class="action">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-start">
                                <div class="regi_img_circle">
                                    <!-- <img src="" alt="" class="w-100 h-100"> -->
                                    <span>AM</span>
                                </div>
                                <div>
                                    <div class="regi_name">Dr. Asim Kumar Majumdar</div>
                                    <div class="regi_contact mt-0">
                                        <span>NATCON 2025-1176-0638</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div>
                                    <div class="regi_name">The Westin Kolkata</div>
                                    <div class="regi_contact mt-0">
                                        <span><i class="fal fa-bed-alt"></i>Double</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php calendar(); ?>
                            <n class="badge_padding badge_dark mx-1">12/18</n>
                            <i class="fal fa-long-arrow-right"></i>
                            <n class="badge_padding badge_dark ml-1">12/18</n>
                        </td>

                        <td>
                            Adult: 2<br>
                            <small class="text_primary">In Any</small>
                        </td>

                        <td class="action">
                            <div class="action_div dropdown" role="menu" aria-label="Actions for ${item.name}">
                                <span class="badge_padding badge_success w-max-con text-uppercase">Confirmed</span>
                            </div>
                        </td>
                    </tr>
  <tr>
                        <td>
                            <div class="d-flex align-items-start">
                                <div class="regi_img_circle">
                                    <!-- <img src="" alt="" class="w-100 h-100"> -->
                                    <span>AM</span>
                                </div>
                                <div>
                                    <div class="regi_name">Dr. Asim Kumar Majumdar</div>
                                    <div class="regi_contact mt-0">
                                        <span>NATCON 2025-1176-0638</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div>
                                    <div class="regi_name">The Westin Kolkata</div>
                                    <div class="regi_contact mt-0">
                                        <span><i class="fal fa-bed-alt"></i>Double</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php calendar(); ?>
                            <n class="badge_padding badge_dark mx-1">12/18</n>
                            <i class="fal fa-long-arrow-right"></i>
                            <n class="badge_padding badge_dark ml-1">12/18</n>
                        </td>

                        <td>
                            Adult: 2<br>
                            <small class="text_primary">In Any</small>
                        </td>

                        <td class="action">
                            <div class="action_div dropdown" role="menu" aria-label="Actions for ${item.name}">
                                <span class="badge_padding badge_secondary w-max-con text-uppercase">Pending</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bbp-pagination">
            <div class="bbp-pagination-count">Showing 1 to 10 of 150 entries</div>
            <span class="paginationDisplay">
                <div class="pagination"><a>1 of 15 Pages</a><a class="selected">1</a><a href="/natcon_2025/webmaster/section_registration/registration.php?_pgnR001_=1">2</a><a href="/natcon_2025/webmaster/section_registration/registration.php?_pgnR001_=2">3</a><a href="/natcon_2025/webmaster/section_registration/registration.php?_pgnR001_=1">&gt;&gt;</a> <a href="/natcon_2025/webmaster/section_registration/registration.php?_pgnR001_=14">Last</a></div>
            </span>
        </div>
    </div>
    <?php include_once("includes/popup.php"); ?>
</body>
<?php include_once("includes/js-source.php"); ?>

</html>