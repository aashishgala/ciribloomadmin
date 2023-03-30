<?php 
siteheader('Assign Course To Teacher'); 

function student_marks(){

    global $theme, $arr_cid_name, $sess_data, $course_list, $module_list, $assign_list, $student_data, $table_header, $error, $done, $number_of_page, $page, $globals, $number_of_result, $results_per_page, $module_color;
    $theme['name'] = 'student_marks';

    if($sess_data['logged_in_as'] != 'admin'){
        $_tid = $sess_data['uid'];
    }
    
    $error = array();
    $done = array();
    $module_list = array();
    $arr_cid_name = array();

    $search_by_course = '';
    $where_course = '';
    $where_stu_name = '';

    // Search By Student Name
    if(optPOST('search_data')){

        $search_data = optPOST('search_data');

        $where_stu_name = ' AND ( first_name LIKE \'%'.$search_data.'%\' OR last_name LIKE \'%'.$search_data.'%\' OR middle_name LIKE \'%'.$search_data.'%\' )';

    }

    // Show Selected Course only
    if(optPOST('search_by_course')){
        $search_by_course = optPOST('search_by_course');
        $where_course = ' AND course = '.$search_by_course;
    }

    $where = ' status = 1';

    // Course Master
    $sql = executeQuery('SELECT * FROM course');
    while($row = fetchData($sql)){
        $arr_cid_name[$row['cid']] = $row['course_name'];
    }

    // Module Master
    $sql = executeQuery('SELECT * FROM module WHERE '.$where);
    while($row = fetchData($sql)){
        $module_list[$row['mid']] = $row['modulename'];
        $module_color[$row['mid']] = $row['modcolor'];
    }

    // Assignment Master
    $sql = executeQuery('SELECT * FROM assignment WHERE '.$where);
    while($row = fetchData($sql)){
        $assign_list[$row['aid']] = $row['assignname'];
        $table_header[$row['cid']][$row['mid']][] = $row['aid'];
    }

    // Assign Course Master
    if($sess_data['logged_in_as'] == 'admin'){
        $condi = '';
    }else{
        $_tid = $sess_data['uid'];
        $condi = ' AND tid = "'.$_tid.'"';
    }
    
    $sql = executeQuery('SELECT * FROM assign_course WHERE status = 1'.$condi);
    while($row = fetchData($sql))
    {
        $course_name = $arr_cid_name[$row['cid']];
        $course_list[$row['cid']] = $course_name;
    }

    if (!optGET('page')) {  
        $page = 1;  
    } else {  
        $page = optGET('page');
    }  

    // By default value in globals
    $results_per_page = $globals['data_per_page'];
    if(optPOST('record_per_page')){
        $results_per_page = optPOST('record_per_page');
    }

    // $results_per_page = 2; // for testing

    $page_first_result = ($page-1) * $results_per_page;

    $all_condi = $where_course.' '.$where_stu_name;

    // Student Marks Master
    $student_data = array();
    // Total Record Count
    $number_of_result = get_val('SELECT COUNT(*) AS TotalData FROM student_marks WHERE status = 1 '.$condi.' '.$all_condi);
    $number_of_page = ceil ($number_of_result['TotalData'] / $results_per_page);

    // Query with limit num of record
    $query = 'SELECT * FROM student_marks WHERE status = 1 '.$condi.' '.$all_condi.' ORDER BY course LIMIT ' . $page_first_result . ',' . $results_per_page;
    $sql = executeQuery($query);
    while($row = fetchData($sql)){

        $decode_data = json_decode($row['marks_json'], true);

        $student_data[$row['course']][$row['markid']] = $row;
        $student_data[$row['course']][$row['markid']]['marks_json'] = $decode_data;
        $student_data[$row['course']][$row['markid']]['tid'] = $row['tid'];
    }
    // r_print($student_data); die();
}

function html_student_marks(){

    global $error, $done, $l, $arr_cid_name, $course_list, $module_list, $assign_list, $student_data, $table_header, $number_of_page, $page, $number_of_result, $results_per_page, $module_color;

    ?>
    <div class="container-fluid">
    <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=student_marks" name="search_data" id="search_data">
    <div class="row">
        <div class="col-lg-4 col-md-6 d-none">
            <div class="form-group">
                <label>Course</label>
                <select class="form-control chosen select" id="search_by_course" name="search_by_course" onchange="form.submit()">
                    <option value="">Select Course</option>
                    <?php
                    foreach ($course_list as $cid => $cname) {
                        ?>
                        <option value="<?php echo $cid; ?>" <?php echo (POSTval('search_by_course', '') == $cid ? 'selected' : '' ); ?> >
                            <?php echo $cname; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="form-group">
                <label>Search</label>
                <input type="text" class="form-control" name="search_data" id="search_data" style="height: 28px;" placeholder="Search By Student Name" value="<?php echo POSTval('search_data', ''); ?>">
            </div>
        </div>
        
        <div class="col-lg-2 col-md-2">
            <input type="submit" name="submit_search" id="submit_search" value="Search" class="btn btn-primary btn-sm w-100" style="margin-top: 28px">
        </div>
        
        <div class="col-lg-2 col-md-2">
            <a href="index.php?act=student_marks" class="btn btn-primary btn-sm w-100" style="margin-top: 28px">Clear Filter</a>
        </div>
        
        <div class="col-lg-2 col-md-2 float-right">
            <div class="form-group">
                <label>Per-Page</label>
                <select class="form-control chosen select" name="record_per_page" id="record_per_page" onchange="form.submit();">
                    <option value="10" selected>10</option>
                    <option value="50" <?php echo (POSTval('record_per_page', '') == 50 ? 'selected' : '' ); ?> >50</option>
                    <option value="100" <?php echo (POSTval('record_per_page', '') == 100 ? 'selected' : '' ); ?> >100</option>
                </select>
            </div>
        </div>
    </div>
    </form>
    <div class="row mt-4">
    <div class="col-md-12">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Student Marks
                <span style="float: right;">
                    Total Record - <?php echo $number_of_result['TotalData']; ?>
                </span>
            </h6>
        </div>

        <div class="card-body">
            <!-- Pagination div -->
            <div> <?php get_pagination(); ?> </div>

            <!-- Marks List Start -->
            <div class="row bg-primary text-light pt-2">
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <p class="text-center font-weight-bold h6">Sr. No.</p>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <p class="text-center font-weight-bold h6">Date</p>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <p class="font-weight-bold h6">Student Name</p>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <p class="text-center font-weight-bold h6">Total</p>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-3">
                    <p class="text-center font-weight-bold h6">Action</p>
                </div>
            </div>

            <div class="accordion" id="accordionMarks">
            <?php
            $i = 1;
            foreach ($student_data as $kcid => $arr_marks) 
            {
                foreach ($arr_marks as $kmid => $mdata) 
                {
                    $stu_name = ucwords($mdata['first_name']).' '.ucwords($mdata['middle_name']).' '.ucwords($mdata['last_name']);

                    $date = date("d-m-Y", strtotime(substr($mdata['date'], 0, 10)));

                    $marks = $mdata['marks_json']['marks'];
                    $total = $mdata['marks_json']['total'];

                    if(!empty($mdata['marks_json']['portfolio'])){
                        $portfolio = $mdata['marks_json']['portfolio'];
                    }
                    
                    $_tid = $mdata['tid'];
                    ?>

                    <div class="row mt-3 cursor-pointer mark-row" data-toggle="collapse" data-target="#mid<?php echo $kmid; ?>" aria-expanded="true" aria-controls="mid<?php echo $kmid; ?>">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <p class="text-center font-weight-bold h6"><?php echo $i; ?></p>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <p class="text-center font-weight-bold h6"><?php echo $date; ?></p>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <p class="font-weight-bold h6"><?php echo $stu_name; ?></p>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <p class="text-center font-weight-bold h6"><?php echo $total; ?></p>
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-3 text-center">
                            <span class="icon-sty">
                                <a href="?act=assign_course_list&mid=<?php echo base64_encode($kmid); ?>&mode=edit_mark&tid=<?php echo base64_encode($_tid); ?>"><i class="fas fa-edit icon-sty"></i></a>
                            </span>
                        </div>
                        <!-- <div class="col-md-2 col-sm-2 col-xs-2">
                            <a type="button" data-toggle="collapse" data-target="#mid<?php //echo $kmid; ?>" aria-expanded="true" aria-controls="mid<?php //echo $kmid; ?>">
                            Marks
                            </a>
                        </div> -->
                    </div>
            
                    <!-- Marks panel Body -->
                    <div class="card">
                        <div id="mid<?php echo $kmid; ?>" class="collapse" aria-labelledby="heading<?php echo $kmid; ?>" data-parent="#accordionMarks">
                        <div class="card-body">
                            <?php
                            foreach($marks as $kmid => $arr_assign)
                            {
                                // $col_div = round(12/count($arr_assign));
                                // if($col_div == '12'){
                                //     $col_div = '4';
                                // }
                                $col_div = 3;

                                ?>
                                <div class="row module_row">
                                    <div class="col-lg-12 alert modul_div text-light font-weight-bold" style="background:<?php echo $module_color[$kmid]; ?>">
                                        <?php echo $module_list[$kmid]; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                    foreach($arr_assign as $kaid => $assign)
                                    {
                                        ?>
                                        <div class="asign_div col-lg-<?php echo $col_div; ?>">
                                            <?php
                                            echo '<span class="text-primary font-weight-bold font-italic">'.$assign_list[$kaid].'</span> :- ';
                                            echo $assign; 
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        
                            // Portfolio Table
                            if(!empty($portfolio) && sizeof($portfolio) >0){ 
                                ?>
                                <div class="row mb-4">
                                    <div class="col-lg-12 alert alert-primary">Portfolio</div>
                                    <?php
                                    foreach ($portfolio as $key => $portmask) {
                                        ?>
                                        <div class="col-lg-<?php echo $col_div; ?> mt-2">
                                        <?php echo '<span class="text-primary font-weight-bold font-italic">Assignment '.$key .' :- </span> '. $portmask; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }

                            $i++;
                            ?>
                        </div>
                        </div>
                    </div>
                    <!-- Marks panel Body end -->

                    <?php
                }
            }
            ?>
            </div>
            <!-- Marks List End -->

            <div> <?php get_pagination(); ?> </div>
            <!-- Pagination div -->
        </div>
    </div>
    </div>
    </div>
    </div>
    <?php
}


function API_student_marks(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

function get_pagination(){

    global $page, $number_of_page;
    
    //How many adjacent pages should be shown on each side?
    $adjacents = 2;
    /* Setup vars for query. */

    $targetpage = "?act=student_marks";     
    //your file name  (the name of this file)

    $limit = 1;                                 
    //how many items to show per page

    if($page)
    $start = ($page - 1) * $limit;             
    //first item to display on this page
    else
    $start = 0;  


    /* Setup page vars for display. */
    if ($page == 0) 
    $page = 1;                   
     //if no page var is given, default to 1.
    $prev = $page - 1;                           
     //previous page is page - 1
    $next = $page + 1;                            
    //next page is page + 1
    $lastpage = ceil($number_of_page/$limit);        
    //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;                        
    //last page minus 1
    
        /* 
        Now we apply our rules and draw the pagination object. 
        We're actually saving the code to a variable in case we want to draw it more than once.
        */
        $pagination = "";
        if($lastpage > 1)
        {    
            $pagiCondi = "";
					
        $pagination .= "<div class=\"pagination\">";
        //previous button
        if ($page > 1) 
        $pagination.= "<a href=\"$targetpage&page=$prev$pagiCondi\" class=\"btn\"> previous </a>";
        else
        $pagination.= "<span class=\"disabled btn\"> previous </span>";    

        //pages    
        if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
        {    
        for ($counter = 1; $counter <= $lastpage; $counter++)
        {
        if ($counter == $page)
        $pagination.= "<span class=\"current\"> $counter </span>";
        else
        $pagination.= "<a href=\"$targetpage&page=$counter$pagiCondi\"> $counter </a>";                    
        }
        }
        elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
        {
        //close to beginning; only hide later pages
        if($page < 1 + ($adjacents * 2))        
        {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
        {
        if ($counter == $page)
        $pagination.= "<span class=\"current\">  $counter </span>";
        else
        $pagination.= "<a href=\"$targetpage&page=$counter$pagiCondi\">  $counter</a>";                    
        }
        $pagination.= "...";
        $pagination.= "<a href=\"$targetpage&page=$lpm1$pagiCondi\">$lpm1</a>";
        $pagination.= "<a href=\"$targetpage&page=$lastpage$pagiCondi\">$lastpage</a>";        
        }
        //in middle; hide some front and some back
        elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
        {
        $pagination.= "<a href=\"$targetpage&page=1$pagiCondi\"> 1 </a>";
        $pagination.= "<a href=\"$targetpage&page=2$pagiCondi\"> 2 </a>";
        $pagination.= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
        {
        if ($counter == $page)
        $pagination.= "<span class=\"current\">  $counter </span>";
        else
        $pagination.= "<a href=\"$targetpage&page=$counter$pagiCondi\">  $counter</a>";                    
        }
        $pagination.= "...";
        $pagination.= "<a href=\"$targetpage&page=$lpm1$pagiCondi\"> $lpm1 </a>";
        $pagination.= "<a href=\"$targetpage&page=$lastpage$pagiCondi\"> $lastpage </a>";        
        }
        //close to end; only hide early pages
        else
        {
        $pagination.= "<a href=\"$targetpage&page=1$pagiCondi\"> 1 </a>";
        $pagination.= "<a href=\"$targetpage&page=2$pagiCondi\"> 2 </a>";
        $pagination.= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
        {
        if ($counter == $page)
        $pagination.= "<span class=\"current\">  $counter</span>";
        else
        $pagination.= "<a href=\"$targetpage&page=$counter$pagiCondi\">  $counter</a>";                    
        }
        }
        }

        //next button
        if ($page < $counter - 1) 
        $pagination.= "<a href=\"$targetpage&page=$next$pagiCondi\" class=\"btn\">&nbsp; next </a>";
        else
        $pagination.= "<span class=\"disabled btn\"> next </span>";
        $pagination.= "</div>\n";        
        }

        echo $pagination;
}

function extra_code(){
    ?>
   
    <!-- Table Start -->
    <div class="table-responsive">
        <?php
        get_pagination();
        ?>
        <table class="table table-bordered marks_table_parent mb-4" id="studentmarks" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="font-size: 16px;"width="5%" class="text-center">Sr.No</th>
                <th style="font-size: 16px;"width="15%" class="text-center">Date</th>
                <th style="font-size: 16px;"width="30%">Student Name</th>
                <th style="font-size: 16px;"width="30%" class="text-center">Total Marks</th>
            </tr>
        </thead>
        <?php
        if(empty($student_data)){
            ?>
            <tr>
                <td colspan="4" align="center" class="red">
                    <?php echo $l['no_data']; ?>
                </td>
            </tr>
            <?php
        }
        else
        {
            if(!optGET('page')){  
                $i = 1;  
            }else{  
                $i = $results_per_page * ( $page - 1) + 1;
            }

            // $i = 1;

            foreach ($student_data as $kcid => $arr_marks) 
            {
                foreach ($arr_marks as $kmid => $mdata) 
                {
                    $stu_name = ucwords($mdata['first_name']).' '.ucwords($mdata['middle_name']).' '.ucwords($mdata['last_name']);

                    $date = substr($mdata['date'], 0, 10);

                    $marks = $mdata['marks_json']['marks'];
                    $total = $mdata['marks_json']['total'];

                    if(!empty($mdata['marks_json']['portfolio'])){
                        $portfolio = $mdata['marks_json']['portfolio'];
                    }

                    ?>
                    <tr class="">
                        <td class="text-center font-weight-bold h5"><?php echo $i; ?></td>
                        <td class="text-center font-weight-bold h5"><?php echo $date; ?></td>
                        <td class="font-weight-bold h5"><?php echo $stu_name; ?></td>
                        <td class="align-middle text-center font-weight-bold h5">
                            <?php echo $total; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="marks_row">
                            <!-- <table class="table marks_table"> -->
                            <?php
                                foreach($marks as $kmid => $arr_assign)
                                {
                                    ?>
                                    <div class="table-responsive">
                                    <table class="table marks_table">
                                    <?php
                                    $colspan_assign = count($arr_assign);
                                    ?>
                                    <tr>
                                        <td class="alert modul_div font-weight-bold text-light" colspan="<?php echo $colspan_assign?>" style="background:<?php echo $module_color[$kmid]; ?>">
                                            <?php echo $module_list[$kmid]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    <?php
                                    foreach($arr_assign as $kaid => $assign)
                                    {
                                        ?>
                                        <td>
                                            <?php
                                            echo '<span class="text-primary font-weight-bold font-italic">'.$assign_list[$kaid].'</span> :- ';
                                            echo $assign; 
                                            ?>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                    </tr>
                                    <?php
                                    ?>
                                    </table>
                                    </div>
                                    <?php
                                }
                            ?>
                            <!-- </table> -->
                        </td>
                    </tr>
                    <?php
                    // Portfolio Table
                    if(!empty($portfolio) && sizeof($portfolio) >0){ ?>
                        <tr>
                            <td colspan="10" class="marks_row">
                            <table class="table marks_table">
                                <tr>
                                <td class="modul_div font-weight-bold">Portfolio</td>
                                </tr>
                                <tr>
                                <?php
                                foreach($portfolio AS $key => $portmask){
                                    ?>
                                    <td class="marks_row">
                                            
                                        <?php echo '<span class="text-primary font-weight-bold font-italic">Assignment '.$key .' </span> <br> '. $portmask; ?>
                                    </td>    
                                    <?php
                                }
                                ?></tr>
                            </table>
                            </td>
                        </tr>
                        <?php
                    }
                    $i++;
                }
            }
        }
        ?>
        </table>
        <?php get_pagination(); ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php
            $i = 1;
            foreach ($student_data as $kcid => $arr_marks) 
            {
                ?>
                <table class="table table-striped" id="dataTable<?php echo $kcid; ?>" width="100%" cellspacing="0">
                <caption>Course : <?php echo $course_list[$kcid]; ?></caption>
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">Sr.No</th>
                            <th width="15%">Date</th>
                            <th width="30%">Student Name</th>
                            <?php
                            $j = 1;
                            foreach($table_header[$kcid] AS $key_mid => $module_arr){
                                $colspan = count($module_arr);
                                echo '<th width="10%" colspan="'.$colspan.'" class="text-center colorheader'.$j.'">'.$module_list[$key_mid].'</th>';
                                $j++;
                            }
                            ?>
                            <th width="10%" class="text-center ">Total Marks</th>
                        </tr>
                        <tr>
                            <?php
                            echo '<th colspan="3" class="text-center"></th>';
                            foreach($table_header[$kcid] AS $key_mid => $module_arr){
                                foreach ($module_arr as $key_aid => $asign_arr) {
                                    echo '<th class="text-center" >'.$assign_list[$asign_arr].'</th>';
                                }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($arr_marks as $kmid => $mdata) 
                        {
                            $stu_name = ucwords($mdata['first_name']).' '.ucwords($mdata['middle_name']).' '.ucwords($mdata['last_name']);

                            $date = substr($mdata['date'], 0, 10);

                            $marks = $mdata['marks_json']['marks'];
                            $total = $mdata['marks_json']['total'];
                                // r_print($marks);
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $stu_name; ?></td>

                                <?php
                                    foreach($marks as $kmid => $arr_assign)
                                    {
                                        foreach($arr_assign as $kaid => $assign)
                                        {
                                            ?>
                                            <td class="text-center">
                                                <?php
                                                echo $assign; 
                                                ?>
                                            </td>
                                            <?php
                                        }
                                    }
                                ?>

                                <td class="text-center align-middle">
                                    <?php echo $total; ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    $i = 1;
    foreach ($student_data as $kcid => $arr_marks) 
    {
        foreach ($arr_marks as $kmid => $mdata) 
        {
            $stu_name = ucwords($mdata['first_name']).' '.ucwords($mdata['middle_name']).' '.ucwords($mdata['last_name']);

            $date = substr($mdata['date'], 0, 10);

            $marks = $mdata['marks_json']['marks'];
            $total = $mdata['marks_json']['total'];
                // r_print($marks);
            ?>
            <div class="row mt-4 mb-4 text-light bg-dark">
                <div class="col-lg-3">
                    <?php echo $i; ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $date; ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $stu_name; ?>
                </div>
                <div class="col-lg-3">
                        Total Marks: <?php echo $total; ?>
                </div>
            </div>
            <?php
            foreach($marks as $kmid => $arr_assign)
            {
                $col_div = round(12/count($arr_assign));
                if($col_div == '12'){
                    $col_div = '4';
                }
                ?>
                <div class="row mt-4 mb-4">
                    <div class="col-lg-6 bg-info text-light">
                        <?php echo $module_list[$kmid]; ?>
                    </div>
                </div>
                <div class="row mt-4 mb-4">
                    <?php
                        foreach($arr_assign as $kaid => $assign)
                        {
                            ?>
                            <div class="col-lg-<?php echo $col_div; ?>">
                                <input type="hidden" name="combi[]" value="<?php echo $kmid; ?>_<?php echo $kaid; ?>">
    
                                <input class="form-control" type="number" id="asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>" name="asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>" placeholder="<?php echo $assign; ?>">
                            </div>
                            <?php
                        }
                    ?>
                    <?php
                    ?>
                </div>
                <?php
            }
        }
    }
}