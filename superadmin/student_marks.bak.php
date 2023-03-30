<?php 
siteheader('Assign Course To Teacher'); 

function student_marks(){

    global $theme, $arr_cid_name, $sess_data, $course_list, $module_list, $assign_list, $student_data, $table_header, $error, $done, $number_of_page, $page;
    $theme['name'] = 'student_marks';

    $_tid = $sess_data['uid'];

    $error = array();
    $done = array();
    $module_list = array();
    $arr_cid_name = array();

    $search_by_course = '';
    $where_course = '';
    if(optPOST('search_by_course')){
        $search_by_course = optPOST('search_by_course');
        $where_course = ' AND course = '.$search_by_course.'';
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
    }

    // Assignment Master
    $sql = executeQuery('SELECT * FROM assignment WHERE '.$where);
    while($row = fetchData($sql)){
        $assign_list[$row['aid']] = $row['assignname'];
        $table_header[$row['cid']][$row['mid']][] = $row['aid'];
    }

    // Assign Course Master
    $sql = executeQuery('SELECT * FROM assign_course WHERE tid = "'.$_tid.'"');
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

    $results_per_page = 10;  
    $page_first_result = ($page-1) * $results_per_page;  

    // Student Marks Master
    $student_data = array();
    $number_of_result = get_val('SELECT COUNT(*) AS TotalData FROM student_marks WHERE  tid = '.$_tid.' '.$where_course);
    $number_of_page = ceil ($number_of_result['TotalData'] / $results_per_page);

    $query = 'SELECT * FROM student_marks WHERE  tid = '.$_tid.' '.$where_course.' ORDER BY course LIMIT ' . $page_first_result . ',' . $results_per_page;
    $sql = executeQuery($query);
    while($row = fetchData($sql)){

        $decode_data = json_decode($row['marks_json'], true);

        $student_data[$row['course']][$row['markid']] = $row;
        $student_data[$row['course']][$row['markid']]['marks_json'] = $decode_data;
    }

}

function html_student_marks(){

    global $error, $done, $l, $arr_cid_name, $course_list, $module_list, $assign_list, $student_data, $table_header, $number_of_page, $page;

    ?>
    <div class="container-fluid">
    <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=student_marks" name="search_data" id="search_data">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                <label>Course</label>
                <select class="form-control chosen select" id="search_by_course" name="search_by_course" onchange="form.submit();">
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
    </div>
    </form>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Student Marks</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <?php
                        $i = 1;
                        foreach ($student_data as $kcid => $arr_marks) 
                        {
                            ?>
                            <table class="table table-bordered marks_table_parent" id="dataTable<?php echo $kcid; ?>" width="100%" cellspacing="0">
                            <caption>Course : <?php echo $course_list[$kcid]; ?></caption>
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">Sr.No</th>
                                    <th width="15%" class="text-center">Date</th>
                                    <th width="30%">Student Name</th>
                                    <th width="30%" class="text-center">Total Marks</th>
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
                                    <tr class="text-light bg-dark">
                                        <td class="text-center"><?php echo $i; ?></td>
                                        <td class="text-center"><?php echo $date; ?></td>
                                        <td><?php echo $stu_name; ?></td>
                                        <td class="align-middle text-center">
                                            <?php echo $total; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="marks_row">
                                            <table class="table marks_table">
                                            <?php
                                                foreach($marks as $kmid => $arr_assign)
                                                {
                                                    $colspan_assign = count($arr_assign);
                                                    ?>
                                                    <tr>
                                                        <td class="modul_td font-weight-bold" colspan="<?php echo $colspan_assign?>">
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
                                                }
                                            ?>
                                            </table>
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
                        get_pagination();
                        ?>
                    </div>
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

    $limit = 2;                                 
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
    echo "->".$lastpage = ceil($number_of_page/$limit);        
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