<?php 
siteheader('Add Location'); 

function property(){

    global $theme, $conf;

    $theme['name'] = 'property';

    $conf_file = './conf/prop_conf.json';

    if(optPOST('save')){
        
        $area = optPOST_r('prop_area');
        $type = optPOST_r('prop_type');

        if(empty($area) && empty($type)){

            echo '0|Please Select Value...!';
            return false;

        }

        $json_data['area'] = $area;
        $json_data['type'] = $type;

        if (!file_exists('./conf')) {
            mkdir($conf_path, 0777);
        }

        $is_written = writedata($conf_file, $json_data);

        echo $is_written.'|Property Setting Saved Successfully...!';
        return true;

    }
    
    $conf = loaddata($conf_file);

    return true;

}

function html_property(){

    global $sess_data, $conf, $l;
    
    $prop_conf = get_property_conf();
    
    ?>
     <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-1 text-gray-800"></h1>
        <p class="mb-4">Different Property Related Settings</p>

        <form method="POST" class="user" action="" name="prop_conf_form" id="prop_conf_form" autocomplete="off">
        <!-- Content Row -->
        <div class="row">
            <!-- Grow In Utility -->
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Property Setting</h6>
                    </div>
                </div>
            </div>

            <!-- Area -->
            <div class="col-lg-4 mt-3">
                <div class="card position-relative">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Area</h6>
                        <button type="button" class="btn btn-sm btn-primary selectall" value="selectall" data-id="area"> Select All </button>
                    </div>
                </div>
                <div class="card position-relative">
                    <div class="card-body">
                            <?php
                            foreach ($prop_conf['area'] as $key => $value) 
                            {
                                (in_array($value, $conf['area'])) ? $check = 'checked' : $check = '';

                                ?>
                                <div class="form-group">
                                    <input class="area" type="checkbox" name="prop_area[]" id="prop_area<?php echo $key; ?>" value="<?php echo $value; ?>" <?php echo $check; ?>> <?php echo $value; ?>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
            </div>

            <!-- Type -->
            <div class="col-lg-4 mt-3">
                <div class="card position-relative">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Type</h6>
                        <button type="button" class="btn btn-sm btn-primary selectall" value="selectall" data-id="type"> Select All </button>
                    </div>
                </div>
                <div class="card position-relative">
                    <div class="card-body">
                        <?php
                        foreach ($prop_conf['type'] as $key => $value) 
                        {
                            (in_array($value, $conf['type'])) ? $check = 'checked' : $check = '';

                            ?>
                            <div class="form-group">
                                <input class="type" type="checkbox" name="prop_type[]" id="prop_type<?php echo $key; ?>" value="<?php echo $value; ?>" <?php echo $check; ?>> <?php echo $value; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="row">
            <div class="col-lg-2 mt-4">
                <input type="button" name="save" id="save" value="Save" class="btn btn-primary btn-user btn-block" onclick="submitit(this, 'prop_conf_form')"/>
            </div>
        </div>
        </form>
    </div>

    <script>
        $(".selectall").click(function(){
            let selbtn = $(this).val();
            let data = $(this).data('id');
            
            if(selbtn == "selectall"){
                $(this).val("deselectall");
                $(this).html("Deselect All");
                $("."+data).prop("checked", true);
            }else{
                $(this).val("selectall");
                $(this).html("Select All");
                $("."+data).prop("checked", false);
            }
        });
    </script>
    <?php

}

function API_property(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

function get_property_conf()
{

    $prop_conf = array(
        'area' => array(
            '1 RK',
            '1 BHK',
            '2 BHK',
            '3 BHK',
            '4 BHK',
        ),
        'type' => array(
            'Apartment',
            'Builder Floor',
            'Villa',
            'Residential Plot',
            'Independent House',
            'Studio Apartment',
        )
    );

    return $prop_conf;

}
?>
