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
                        <li class="breadcrumb-item active" aria-current="page">Workshop Report</li>
                    </ol>
                </nav>
                <h2>Breakfast Workshops Overall Report</h2>
                <h6>View attendance and payment details for all workshop sessions.</h6>
            </div>
        </div>

        <div class="regi_search_wrap mb-3">
            <div class="regi_search">
                <?php search(); ?>
                <input placeholder="Search by Name, Email, Mobile, or Reg ID...">
            </div>
            <div class="regi_search_wrap_btn_box">
                <a href="javascript:void(null)" onclick="$('.filter_wrap').slideToggle(); $(this).toggleClass('active');"><?php filter(); ?>Filter</a>
                <a href="javascript:void(null)"><?php export(); ?>Export Excel</a>
                <a href="javascript:void(null)"><?php export(); ?>Export CSV</a>
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
                        <th class="sl">Sl No</th>
                        <th>Breakfast Session Category</th>
                        <th>Workshop Date</th>
                        <th>Seat Limit</th>
                        <th>Total Applicant(s)</th>
                        <th>Total Paid Delegate(s)</th>
                        <th>Total Zero Val. Delegate(s)</th>
                        <th>Total Unpaid Delegate(s)</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tlisting">
                        <td class="sl">1</td>
                        <td>TB &amp; Critical Care Workshop</td>
                        <td>18 Dec 2025</td>
                        <td align="center">50</td>
                        <td align="center">7 </td>
                        <td align="center">6 </td>
                        <td align="center">0 </td>
                        <td align="center">1 </td>
                        <td class="action">
                            <div class="action_div dropdown" role="menu" aria-label="Actions for ${item.name}">
                                <button class="icon_hover badge_dark action-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open actions menu for ${item.name}"><?php ellips(); ?></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="workshop_report_view.php" data-tab="profile" class="icon_hover badge_primary action-transparent"><?php view(); ?>View</a>
                                </ul>
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