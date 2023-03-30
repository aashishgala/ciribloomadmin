<?php 
siteheader('Add Location'); 

function location(){

    global $error, $done, $theme, $location_data;
    $theme['name'] = 'location';

    $error = array();
    $done = array();

    if (optREQ('special_val') == 'delete') {
        // r_print($_POST);
        // echo json_encode('done');
        $del_id = optPOST('id');

        $delete = deletData('DELETE FROM `location` WHERE lid="'.$del_id.'" LIMIT 1');
        if ($delete === TRUE) {
            
            echo 'Location Delete Successfully...!';
            return true;

        }else{

            echo $delete;
            return false;
        }

    }

    if(optPOST('add_location')){

        $location = optPOST('location_name');

        if(empty($location)){
            return $error[] = 'Please Enter Location name...!';
        }

        $insert = insertData('INSERT INTO `location`(`location_name`, `status`, `date`) VALUES ("'.$location.'", "1", "'.time().'")');

        if($insert === TRUE){

            $done[] = 'Location Added Successfully...!';

        }else{

            return $error[] = 'Opps, Something Went Wrong...!';

        }

    }
    
    $location_data = selecttData('SELECT * FROM location');
    // r_print($location_data);
    return true;
}

function html_location(){

    global $sess_data, $error, $done, $location_data, $l;

    ?>
     <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-1 text-gray-800"></h1>
        <p class="mb-4">This Location will be available for users to search for home</p>

        <!-- Content Row -->
        <div class="row">
            <!-- Grow In Utility -->
            <div class="col-lg-6 offset-lg-3 offset-sm-0">
                <?php 
                    echo show_error($error);
                    echo show_success($done);
                ?>
                <div class="card position-relative">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Location</h6>
                    </div>
                    <div class="card-body">
                    <form method="POST" class="user" action="" name="addlocation_form" id="addlocation_form" autocomplete="off">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user"
                                id="location_name" name="location_name" aria-describedby="location_name"
                                placeholder="Enter Location Name">
                        </div>

                        <input type="submit" name="add_location" id="add_location" value="Add" class="btn btn-primary btn-user btn-block" />

                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Location List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Location</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($location_data)){
                                        $i = 0;
                                        foreach ($location_data as $key => $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo ++$i; ?></td>
                                                <td><?php echo $value['location_name']; ?></td>
                                                <td>
                                                    <span class="icon-sty" onclick='ajax_action("<?php echo $value["lid"]; ?>", "delete")'>
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                    <span class="icon-sty">
                                                        <i class="fas fa-pen-alt icon-sty"></i>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <tr>
                                            <td colspan="3" align="center" class="red">
                                                <?php echo $l['no_data']; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

}

function API_location(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

// value="<?php echo POSTval('location_name', '')"
?>
