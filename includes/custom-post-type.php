<?php

add_action( 'init', 'jsgen_schema_init' );
/**
 * Register a Schema post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function jsgen_schema_init() {
	$labels = array(
		'name'               => _x( 'Schemas', 'post type general name', 'jsgen' ),
		'singular_name'      => _x( 'Schema', 'post type singular name', 'jsgen' ),
		'menu_name'          => _x( 'Schemas', 'admin menu', 'jsgen' ),
		'name_admin_bar'     => _x( 'Schema', 'add new on admin bar', 'jsgen' ),
		'add_new'            => _x( 'Add New', 'schema', 'jsgen' ),
		'add_new_item'       => __( 'Add New Schema', 'jsgen' ),
		'new_item'           => __( 'New Schema', 'jsgen' ),
		'edit_item'          => __( 'Edit Schema', 'jsgen' ),
		'view_item'          => __( 'View Schema', 'jsgen' ),
		'all_items'          => __( 'All Schemas', 'jsgen' ),
		'search_items'       => __( 'Search Schemas', 'jsgen' ),
		'parent_item_colon'  => __( 'Parent Schemas:', 'jsgen' ),
		'not_found'          => __( 'No Schemas found.', 'jsgen' ),
		'not_found_in_trash' => __( 'No Schemas found in Trash.', 'jsgen' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
                'menu_icon'          => 'dashicons-editor-code',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title' )
	);

	register_post_type( 'json_schema', $args );
}



/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function jsgen_add_meta_box() {

	$screens = array('json_schema' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'jsgen_fields',
			__( 'JSON Schema', 'jsgen' ),
			'jsgen_meta_box_callback',
			$screen
		);

		add_meta_box(
			'jsgen_add_to',
			__( 'Schema Settings', 'jsgen' ),
			'jsgen_add_this_callback',
			$screen,
                        'side'
		);
	}
}
add_action( 'add_meta_boxes_json_schema', 'jsgen_add_meta_box' );


function jsgen_add_this_callback( $post ){
    
        // Add a nonce field so we can check for it later.
	wp_nonce_field( 'jsgen_meta_box', 'jsgen_meta_box_nonce' );
        
        $genAddTo         = get_post_meta( $post->ID, 'genAddTo', true );
        $gen_page_ids     = maybe_unserialize(get_post_meta( $post->ID, 'gen_page_ids', true));
        
        ?>
                <table class="form-table">
                    <tr>
                        <th><label for="genAddTo">Add this Schema To:</label> </th>
                        <td>
                            <select name="genAddTo" id="genAddTo"> 
                                <option value="all" <?php echo ($genAddTo == '' || $genAddTo == 'all') ? 'Selected="Selected"' : ''; ?>>All Pages</option> 
                                <option value="selected" <?php echo ($genAddTo == 'selected') ? 'Selected="Selected"' : ''; ?>>Selected Pages</option> 
                            </select>
                        </td>
                    </tr>
                </table>
                <table class="form-table" id="gen_page_ids_ctn"<?php echo ($genAddTo == 'all' || $genAddTo == '') ? ' style="display: none;"' : ''; ?>>
                    <tr>
                        <td>
                            <?php
                            
        //var_dump($gen_page_ids);
                            
                             $pages = get_pages(); 
                                foreach ( $pages as $page ) {
                            ?>
                            <fieldset>
                                <label for="<?php echo $page->post_name; ?>">
                                    <input name="gen_page_ids[]" type="checkbox" id="<?php echo $page->post_name; ?>" value="<?php echo $page->ID; ?>" <?php echo (!empty($gen_page_ids) && in_array($page->ID, $gen_page_ids)) ? ' checked="checked"' : ''; ?> />
                                        <span><?php echo $page->post_title; ?></span>
                                </label>
                            </fieldset>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
        <?php
    
}


/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function jsgen_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'jsgen_meta_box', 'jsgen_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$genType         = get_post_meta( $post->ID, 'genType', true );
	$genURL          = get_post_meta( $post->ID, 'genURL', true );
	$genMapURL       = get_post_meta( $post->ID, 'genMapURL', true );
	$genEmail        = get_post_meta( $post->ID, 'genEmail', true );
	$genStreet       = get_post_meta( $post->ID, 'genStreet', true );
	$genCity         = get_post_meta( $post->ID, 'genCity', true );
	$genState        = get_post_meta( $post->ID, 'genState', true );
	$genZip          = get_post_meta( $post->ID, 'genZip', true );
	$genDescription  = get_post_meta( $post->ID, 'genDescription', true );
	$genName         = get_post_meta( $post->ID, 'genName', true );
	$genTelephone    = get_post_meta( $post->ID, 'genTelephone', true );
	$genDayMo        = get_post_meta( $post->ID, 'genDayMo', true );
	$genDayTu        = get_post_meta( $post->ID, 'genDayTu', true );
	$genDayWe        = get_post_meta( $post->ID, 'genDayWe', true );
	$genDayTh        = get_post_meta( $post->ID, 'genDayTh', true );
	$genDayFr        = get_post_meta( $post->ID, 'genDayFr', true );
	$genDaySa        = get_post_meta( $post->ID, 'genDaySa', true );
	$genDaySu        = get_post_meta( $post->ID, 'genDaySu', true );
	$genOPHours        = get_post_meta( $post->ID, 'genOPHours', true );
	$genCLHours        = get_post_meta( $post->ID, 'genCLHours', true );
	$genLat        = get_post_meta( $post->ID, 'genLat', true );
	$genLon        = get_post_meta( $post->ID, 'genLon', true );
	$genGPlus        = get_post_meta( $post->ID, 'genGPlus', true );
/*
	echo '<label for="myplugin_new_field">';
	_e( 'Description for this field', 'myplugin_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="' . esc_attr( $value ) . '" size="25" />';
        */
        
        
        
        //echo $gen_code;
        
        ?>
<table style="width: 100%;">
    <tr valign="top">
        <td>
                <table class="form-table" id="generator-form">
                    <tr>
                        <th><label for="genType">Type</label> </th>
                        <td>
                            <select name="genType" id="genType"> 
                                <option>-- select --</option> 
                                <option value="Organization" <?php echo ($genType == 'Organization') ? 'SELECTED="SELECTED"' : ''; ?>>General</option> 
                                <option value="Corporation" <?php echo ($genType == 'Corporation') ? 'SELECTED="SELECTED"' : ''; ?>>Corporation</option> 
                                <option value="School" <?php echo ($genType == 'School') ? 'SELECTED="SELECTED"' : ''; ?>>School</option> 
                                <option value="Government" <?php echo ($genType == 'Government') ? 'SELECTED="SELECTED"' : ''; ?>>Government</option> 
                                <option value="LocalBusiness" <?php echo ($genType == 'LocalBusiness') ? 'SELECTED="SELECTED"' : ''; ?>>Local Business</option> 
                            </select>
                        </td>

                    </tr>
                    
                    <tr>
                        <th><label for="genURL">Website URL</label></th>
                        <td><input style="width: 100%" type="text" name="genURL" id="genURL" value="<?php echo esc_attr( $genURL ); ?>"></td>
                    </tr>
                    
                    <tr>
                        <th><label for="genMapURL">Map URL</label></th>
                        <td><input style="width: 100%" type="text" name="genMapURL" id="genMapURL" value="<?php echo esc_attr( $genMapURL ); ?>"></td>
                    </tr> 
                    
                    <tr> 
                        <th><label for="genEmail">Email</label></th> 
                        <td><input style="width: 100%" type="text" name="genEmail" id="genEmail" value="<?php echo esc_attr( $genEmail ); ?>"></td> 
                    </tr> 
                    
                    <tr>
                        <th>Address</th>
                    </tr>
                    
                    <tr> 
                    
                        <th><label for="genStreet">Street Address</label></th> 
                        <td><input style="width: 100%" type="text" name="genStreet" id="genStreet" value="<?php echo esc_attr( $genStreet ); ?>"></td> 
                    </tr> 
                    
                    <tr> 
                        <th><label for="genCity">City</label> </th>
                        <td><input style="width: 100%" type="text" name="genCity" id="genCity" value="<?php echo esc_attr( $genCity ); ?>"> </td>
                    </tr> 
                    
                    <tr> 
                        <th><label for="genState">State</label> </th>
                        <td><input style="width: 100%" type="text" name="genState" id="genState" value="<?php echo esc_attr( $genState ); ?>"> </td>
                    </tr>
                    
                    <tr> 
                        <th><label for="genZip">ZIP</label></th> 
                        <td><input style="width: 100%" type="text" name="genZip" id="genZip" value="<?php echo esc_attr( $genZip ); ?>"></td> 
                    </tr> 
                    
                    <tr> 
                        <th><label for="genDescription">Description</label> </th>
                        <td><textarea style="width: 100%" id="genDescription" rows="4" name="genDescription"><?php echo esc_attr( $genDescription ); ?></textarea> </td>
                    </tr>
                    
                    <tr> 
                        <th><label for="genName">Name</label></th>
                        <td><input style="width: 100%" type="text" name="genName" id="genName" value="<?php echo esc_attr( $genName ); ?>"></td> 
                    </tr>
                    
                    <tr> 
                        <th><label for="genTelephone">Telephone</label></th> 
                        <td><input style="width: 100%" type="text" name="genTelephone" id="genTelephone" value="<?php echo esc_attr( $genTelephone ); ?>"></td> 
                    </tr> 
                    
                    <tr> 
                        <th><label for="genWorkDays">Work days</label></th>
                        <td id="genWorkDays">
                            <label for="genDayMo">Mo</label> <input name="genDayMo" type="checkbox" value="Mo" id="genDayMo"<?php echo ($genDayMo == 'Mo') ? ' checked="checked"' : ''; ?>> &nbsp;&nbsp; 
                            <label for="genDayTu">Tu</label> <input name="genDayTu" type="checkbox" value="Tu" id="genDayTu"<?php echo ($genDayTu == 'Tu') ? ' checked="checked"' : ''; ?>> &nbsp;&nbsp; 
                            <label for="genDayWe">We</label> <input name="genDayWe" type="checkbox" value="We" id="genDayWe"<?php echo ($genDayWe == 'We') ? ' checked="checked"' : ''; ?>> &nbsp;&nbsp; 
                            <label for="genDayTh">Th</label> <input name="genDayTh" type="checkbox" value="Th" id="genDayTh"<?php echo ($genDayTh == 'Th') ? ' checked="checked"' : ''; ?>> &nbsp;&nbsp; 
                            <label for="genDayFr">Fr</label> <input name="genDayFr" type="checkbox" value="Fr" id="genDayFr"<?php echo ($genDayFr == 'Fr') ? ' checked="checked"' : ''; ?>> &nbsp;&nbsp; 
                            <label for="genDaySa">Sa</label> <input name="genDaySa" type="checkbox" value="Sa" id="genDaySa"<?php echo ($genDaySa == 'Sa') ? ' checked="checked"' : ''; ?>> &nbsp;&nbsp; 
                            <label for="genDaySu">Su</label> <input name="genDaySu" type="checkbox" value="Su" id="genDaySu"<?php echo ($genDaySu == 'Su') ? ' checked="checked"' : ''; ?>> 
                        </td>
                    </tr> 
                    
                    <tr> 
                        <th> <label for="genOPHours">Opening hours</label></th> 
                            <td><select name="genOPHours" id="genOPHours"> 
                                    <option>-- select --</option> 
                                    <option value="01:00" <?php echo ($genOPHours == '01:00') ? 'Selected="Selected"' : ''; ?>>01:00</option> 
                                    <option value="01:30" <?php echo ($genOPHours == '01:30') ? 'Selected="Selected"' : ''; ?>>01:30</option> 
                                    <option value="02:00" <?php echo ($genOPHours == '02:00') ? 'Selected="Selected"' : ''; ?>>02:00</option> 
                                    <option value="02:30" <?php echo ($genOPHours == '02:30') ? 'Selected="Selected"' : ''; ?>>02:30</option> 
                                    <option value="03:00" <?php echo ($genOPHours == '03:00') ? 'Selected="Selected"' : ''; ?>>03:00</option> 
                                    <option value="03:30" <?php echo ($genOPHours == '03:30') ? 'Selected="Selected"' : ''; ?>>03:30</option> 
                                    <option value="04:00" <?php echo ($genOPHours == '04:00') ? 'Selected="Selected"' : ''; ?>>04:00</option> 
                                    <option value="04:30" <?php echo ($genOPHours == '04:30') ? 'Selected="Selected"' : ''; ?>>04:30</option> 
                                    <option value="05:00" <?php echo ($genOPHours == '05:00') ? 'Selected="Selected"' : ''; ?>>05:00</option> 
                                    <option value="05:30" <?php echo ($genOPHours == '05:30') ? 'Selected="Selected"' : ''; ?>>05:30</option> 
                                    <option value="06:00" <?php echo ($genOPHours == '06:00') ? 'Selected="Selected"' : ''; ?>>06:00</option> 
                                    <option value="06:30" <?php echo ($genOPHours == '06:30') ? 'Selected="Selected"' : ''; ?>>06:30</option> 
                                    <option value="07:00" <?php echo ($genOPHours == '07:00') ? 'Selected="Selected"' : ''; ?>>07:00</option> 
                                    <option value="07:30" <?php echo ($genOPHours == '07:30') ? 'Selected="Selected"' : ''; ?>>07:30</option> 
                                    <option value="08:00" <?php echo ($genOPHours == '08:00') ? 'Selected="Selected"' : ''; ?>>08:00</option> 
                                    <option value="08:30" <?php echo ($genOPHours == '08:30') ? 'Selected="Selected"' : ''; ?>>08:30</option> 
                                    <option value="09:00" <?php echo ($genOPHours == '09:00') ? 'Selected="Selected"' : ''; ?>>09:00</option> 
                                    <option value="09:30" <?php echo ($genOPHours == '09:30') ? 'Selected="Selected"' : ''; ?>>09:30</option> 
                                    <option value="10:00" <?php echo ($genOPHours == '10:00') ? 'Selected="Selected"' : ''; ?>>10:00</option> 
                                    <option value="10:30" <?php echo ($genOPHours == '10:30') ? 'Selected="Selected"' : ''; ?>>10:30</option> 
                                    <option value="11:00" <?php echo ($genOPHours == '11:00') ? 'Selected="Selected"' : ''; ?>>11:00</option> 
                                    <option value="11:30" <?php echo ($genOPHours == '11:30') ? 'Selected="Selected"' : ''; ?>>11:30</option> 
                                    <option value="12:00" <?php echo ($genOPHours == '12:00') ? 'Selected="Selected"' : ''; ?>>12:00</option> 
                                    <option value="12:30" <?php echo ($genOPHours == '12:30') ? 'Selected="Selected"' : ''; ?>>12:30</option> 
                                    <option value="13:00" <?php echo ($genOPHours == '13:00') ? 'Selected="Selected"' : ''; ?>>13:00</option> 
                                    <option value="13:30" <?php echo ($genOPHours == '13:30') ? 'Selected="Selected"' : ''; ?>>13:30</option> 
                                    <option value="14:00" <?php echo ($genOPHours == '14:00') ? 'Selected="Selected"' : ''; ?>>14:00</option> 
                                    <option value="14:30" <?php echo ($genOPHours == '14:30') ? 'Selected="Selected"' : ''; ?>>14:30</option> 
                                    <option value="15:00" <?php echo ($genOPHours == '15:00') ? 'Selected="Selected"' : ''; ?>>15:00</option> 
                                    <option value="15:30" <?php echo ($genOPHours == '15:30') ? 'Selected="Selected"' : ''; ?>>15:30</option> 
                                    <option value="16:00" <?php echo ($genOPHours == '16:00') ? 'Selected="Selected"' : ''; ?>>16:00</option> 
                                    <option value="16:30" <?php echo ($genOPHours == '16:30') ? 'Selected="Selected"' : ''; ?>>16:30</option> 
                                    <option value="17:00" <?php echo ($genOPHours == '17:00') ? 'Selected="Selected"' : ''; ?>>17:00</option> 
                                    <option value="17:30" <?php echo ($genOPHours == '17:30') ? 'Selected="Selected"' : ''; ?>>17:30</option> 
                                    <option value="18:00" <?php echo ($genOPHours == '18:00') ? 'Selected="Selected"' : ''; ?>>18:00</option> 
                                    <option value="18:30" <?php echo ($genOPHours == '18:30') ? 'Selected="Selected"' : ''; ?>>18:30</option> 
                                    <option value="19:00" <?php echo ($genOPHours == '19:00') ? 'Selected="Selected"' : ''; ?>>19:00</option> 
                                    <option value="19:30" <?php echo ($genOPHours == '19:30') ? 'Selected="Selected"' : ''; ?>>19:30</option> 
                                    <option value="20:00" <?php echo ($genOPHours == '20:00') ? 'Selected="Selected"' : ''; ?>>20:00</option> 
                                    <option value="20:30" <?php echo ($genOPHours == '20:30') ? 'Selected="Selected"' : ''; ?>>20:30</option> 
                                    <option value="21:00" <?php echo ($genOPHours == '21:00') ? 'Selected="Selected"' : ''; ?>>21:00</option> 
                                    <option value="21:30" <?php echo ($genOPHours == '21:30') ? 'Selected="Selected"' : ''; ?>>21:30</option> 
                                    <option value="22:00" <?php echo ($genOPHours == '22:00') ? 'Selected="Selected"' : ''; ?>>22:00</option> 
                                    <option value="22:30" <?php echo ($genOPHours == '22:30') ? 'Selected="Selected"' : ''; ?>>22:30</option> 
                                    <option value="23:00" <?php echo ($genOPHours == '23:00') ? 'Selected="Selected"' : ''; ?>>23:00</option> 
                                    <option value="23:30" <?php echo ($genOPHours == '23:30') ? 'Selected="Selected"' : ''; ?>>23:30</option> 
                                    <option value="00:00" <?php echo ($genOPHours == '00:00') ? 'Selected="Selected"' : ''; ?>>00:00</option> 
                                    <option value="00:30" <?php echo ($genOPHours == '00:30') ? 'Selected="Selected"' : ''; ?>>00:30</option> 
                                </select> 
                            </td> 
                            
                        </tr>
                        <tr>
                            <th>
                                <label for="genCLHours">Closing hours</label></th>
                            <td>
                                <select name="genCLHours" id="genCLHours">
                                    <option>-- select --</option>
                                    <option value="01:00" <?php echo ($genCLHours == '01:00') ? 'Selected="Selected"' : ''; ?>>01:00</option> 
                                    <option value="01:30" <?php echo ($genCLHours == '01:30') ? 'Selected="Selected"' : ''; ?>>01:30</option> 
                                    <option value="02:00" <?php echo ($genCLHours == '02:00') ? 'Selected="Selected"' : ''; ?>>02:00</option> 
                                    <option value="02:30" <?php echo ($genCLHours == '02:30') ? 'Selected="Selected"' : ''; ?>>02:30</option> 
                                    <option value="03:00" <?php echo ($genCLHours == '03:00') ? 'Selected="Selected"' : ''; ?>>03:00</option> 
                                    <option value="03:30" <?php echo ($genCLHours == '03:30') ? 'Selected="Selected"' : ''; ?>>03:30</option> 
                                    <option value="04:00" <?php echo ($genCLHours == '04:00') ? 'Selected="Selected"' : ''; ?>>04:00</option> 
                                    <option value="04:30" <?php echo ($genCLHours == '04:30') ? 'Selected="Selected"' : ''; ?>>04:30</option> 
                                    <option value="05:00" <?php echo ($genCLHours == '05:00') ? 'Selected="Selected"' : ''; ?>>05:00</option> 
                                    <option value="05:30" <?php echo ($genCLHours == '05:30') ? 'Selected="Selected"' : ''; ?>>05:30</option> 
                                    <option value="06:00" <?php echo ($genCLHours == '06:00') ? 'Selected="Selected"' : ''; ?>>06:00</option> 
                                    <option value="06:30" <?php echo ($genCLHours == '06:30') ? 'Selected="Selected"' : ''; ?>>06:30</option> 
                                    <option value="07:00" <?php echo ($genCLHours == '07:00') ? 'Selected="Selected"' : ''; ?>>07:00</option> 
                                    <option value="07:30" <?php echo ($genCLHours == '07:30') ? 'Selected="Selected"' : ''; ?>>07:30</option> 
                                    <option value="08:00" <?php echo ($genCLHours == '08:00') ? 'Selected="Selected"' : ''; ?>>08:00</option> 
                                    <option value="08:30" <?php echo ($genCLHours == '08:30') ? 'Selected="Selected"' : ''; ?>>08:30</option> 
                                    <option value="09:00" <?php echo ($genCLHours == '09:00') ? 'Selected="Selected"' : ''; ?>>09:00</option> 
                                    <option value="09:30" <?php echo ($genCLHours == '09:30') ? 'Selected="Selected"' : ''; ?>>09:30</option> 
                                    <option value="10:00" <?php echo ($genCLHours == '10:00') ? 'Selected="Selected"' : ''; ?>>10:00</option> 
                                    <option value="10:30" <?php echo ($genCLHours == '10:30') ? 'Selected="Selected"' : ''; ?>>10:30</option> 
                                    <option value="11:00" <?php echo ($genCLHours == '11:00') ? 'Selected="Selected"' : ''; ?>>11:00</option> 
                                    <option value="11:30" <?php echo ($genCLHours == '11:30') ? 'Selected="Selected"' : ''; ?>>11:30</option> 
                                    <option value="12:00" <?php echo ($genCLHours == '12:00') ? 'Selected="Selected"' : ''; ?>>12:00</option> 
                                    <option value="12:30" <?php echo ($genCLHours == '12:30') ? 'Selected="Selected"' : ''; ?>>12:30</option> 
                                    <option value="13:00" <?php echo ($genCLHours == '13:00') ? 'Selected="Selected"' : ''; ?>>13:00</option> 
                                    <option value="13:30" <?php echo ($genCLHours == '13:30') ? 'Selected="Selected"' : ''; ?>>13:30</option> 
                                    <option value="14:00" <?php echo ($genCLHours == '14:00') ? 'Selected="Selected"' : ''; ?>>14:00</option> 
                                    <option value="14:30" <?php echo ($genCLHours == '14:30') ? 'Selected="Selected"' : ''; ?>>14:30</option> 
                                    <option value="15:00" <?php echo ($genCLHours == '15:00') ? 'Selected="Selected"' : ''; ?>>15:00</option> 
                                    <option value="15:30" <?php echo ($genCLHours == '15:30') ? 'Selected="Selected"' : ''; ?>>15:30</option> 
                                    <option value="16:00" <?php echo ($genCLHours == '16:00') ? 'Selected="Selected"' : ''; ?>>16:00</option> 
                                    <option value="16:30" <?php echo ($genCLHours == '16:30') ? 'Selected="Selected"' : ''; ?>>16:30</option> 
                                    <option value="17:00" <?php echo ($genCLHours == '17:00') ? 'Selected="Selected"' : ''; ?>>17:00</option> 
                                    <option value="17:30" <?php echo ($genCLHours == '17:30') ? 'Selected="Selected"' : ''; ?>>17:30</option> 
                                    <option value="18:00" <?php echo ($genCLHours == '18:00') ? 'Selected="Selected"' : ''; ?>>18:00</option> 
                                    <option value="18:30" <?php echo ($genCLHours == '18:30') ? 'Selected="Selected"' : ''; ?>>18:30</option> 
                                    <option value="19:00" <?php echo ($genCLHours == '19:00') ? 'Selected="Selected"' : ''; ?>>19:00</option> 
                                    <option value="19:30" <?php echo ($genCLHours == '19:30') ? 'Selected="Selected"' : ''; ?>>19:30</option> 
                                    <option value="20:00" <?php echo ($genCLHours == '20:00') ? 'Selected="Selected"' : ''; ?>>20:00</option> 
                                    <option value="20:30" <?php echo ($genCLHours == '20:30') ? 'Selected="Selected"' : ''; ?>>20:30</option> 
                                    <option value="21:00" <?php echo ($genCLHours == '21:00') ? 'Selected="Selected"' : ''; ?>>21:00</option> 
                                    <option value="21:30" <?php echo ($genCLHours == '21:30') ? 'Selected="Selected"' : ''; ?>>21:30</option> 
                                    <option value="22:00" <?php echo ($genCLHours == '22:00') ? 'Selected="Selected"' : ''; ?>>22:00</option> 
                                    <option value="22:30" <?php echo ($genCLHours == '22:30') ? 'Selected="Selected"' : ''; ?>>22:30</option> 
                                    <option value="23:00" <?php echo ($genCLHours == '23:00') ? 'Selected="Selected"' : ''; ?>>23:00</option> 
                                    <option value="23:30" <?php echo ($genCLHours == '23:30') ? 'Selected="Selected"' : ''; ?>>23:30</option> 
                                    <option value="00:00" <?php echo ($genCLHours == '00:00') ? 'Selected="Selected"' : ''; ?>>00:00</option> 
                                    <option value="00:30" <?php echo ($genCLHours == '00:30') ? 'Selected="Selected"' : ''; ?>>00:30</option> 
                                </select> 
                            </td> 
                        </tr>
              
                    
                    <tr> 
                        <th><label for="genLat">Latitude</label></th> 
                        <td><input style="width: 100%" type="text" name="genLat" id="genLat" value="<?php echo esc_attr( $genLat ); ?>"></td>
                    </tr> 
                    <tr> 
                        <th><label for="genLon">Longitude</label></th> 
                        <td><input style="width: 100%" type="text" id="genLon" name="genLon" value="<?php echo esc_attr( $genLon ); ?>"></td> 
                    </tr> 
                    <tr> 
                        <th><label for="genGPlus">Google + URL</label></th> 
                        <td><input style="width: 100%" type="text" id="genGPlus" name="genGPlus" value="<?php echo esc_attr( $genGPlus ); ?>"></td> 
                    </tr>

            </table>
            
        </td>
        
        <td>
            <h2>How to Use:</h2>
            <p><b>#1 -</b> Fill out the fields to the left</p>
            <p><b>#2 -</b> Select your Schema Setting on the right</p>
            <p><b>#3 -</b> Publish</p>
            <p><b>#4 -</b> Validate - <a href="https://developers.google.com/structured-data/testing-tool/" target="_blank">Click here</a> and enter page URL</p>
            <p><b>Note:</b> Please make sure your theme is using <a href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head" target="_blank">wp_head()</a> function</p>
        </td>
    </tr>
    <tr>
        <td>
            <div id="genOutput"> &lt;!-- JSON Schema Generator created by www.51blocks.com.--&gt; <br> &lt;script type="application/ld+json"&gt; <div class="json-bounds">{</div> <div class="variable">"@context": "https://schema.org"<span class="hidden">,</span></div> <div data-varno="0" class="variable hidden">"@type": "<span></span>"<span>,</span></div> <div data-varno="1" class="variable hidden">"url": "<span></span>"<span>,</span></div> <div data-varno="2" class="variable hidden">"hasMap": "<span></span>"<span>,</span></div> <div data-varno="3" class="variable hidden">"email": "mailto:<span></span>"<span>,</span></div> <div class="variable hidden"> <div class="json-bounds">"address": {</div> "@type": "PostalAddress", <div data-varno="5" class="variable hidden">"addressLocality": "<span></span>"<span>,</span></div> <div data-varno="6" class="variable hidden">"addressRegion": "<span></span>"<span>,</span></div> <div data-varno="7" class="variable hidden">"postalCode":"<span></span>"<span>,</span></div> <div data-varno="4" class="variable hidden">"streetAddress": "<span></span>"<span></span></div> <div class="json-bounds">}</div><span>,</span> </div> <div data-varno="8" class="variable hidden">"description": "<span></span>"<span>,</span></div> <div data-varno="9" class="variable hidden">"name": "<span></span>"<span>,</span></div> <div data-varno="10" class="variable hidden">"telephone": "<span></span>"<span>,</span></div> <div class="variable hidden">"openingHours": "<div data-varno="11" class="variable variable-inline"><p style="display: inline;"></p><span></span><span></span></div>-<div data-varno="12" class="variable variable-inline"><span></span><span></span></div>" <span>,</span> </div> <div class="variable hidden"> <div class="json-bounds">"geo": {</div> "@type": "GeoCoordinates", <div data-varno="13" class="variable hidden">"latitude":"<span></span>"<span>,</span></div> <div data-varno="14" class="variable hidden">"longitude": "<span></span>"<span></span></div> <div class="json-bounds">}</div><span>,</span> </div> <div data-varno="15" class="variable hidden">"sameAs": [ "<span></span>" ]<span>,</span></div> <div class="json-bounds">}</div> &lt;/script&gt; </div>
        </td>
    </tr>
        
</table>
            <?php
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function jsgen_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['jsgen_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['jsgen_meta_box_nonce'], 'jsgen_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( isset( $_POST['genType'] ) ) {

                $genType = sanitize_text_field( $_POST['genType'] );
                update_post_meta( $post_id, 'genType', $genType );

                
                $genURL = sanitize_text_field( $_POST['genURL'] );
                update_post_meta( $post_id, 'genURL', $genURL );

                
                $genMapURL = sanitize_text_field( $_POST['genMapURL'] );
                update_post_meta( $post_id, 'genMapURL', $genMapURL );

                
                $genEmail = sanitize_text_field( $_POST['genEmail'] );
                update_post_meta( $post_id, 'genEmail', $genEmail );

                
                $genStreet = sanitize_text_field( $_POST['genStreet'] );
                update_post_meta( $post_id, 'genStreet', $genStreet );

                
                $genCity = sanitize_text_field( $_POST['genCity'] );
                update_post_meta( $post_id, 'genCity', $genCity );

                
                $genState = sanitize_text_field( $_POST['genState'] );
                update_post_meta( $post_id, 'genState', $genState );

                
                $genZip = sanitize_text_field( $_POST['genZip'] );
                update_post_meta( $post_id, 'genZip', $genZip );

                
                $genDescription = sanitize_text_field( $_POST['genDescription'] );
                update_post_meta( $post_id, 'genDescription', $genDescription );

                
                $genName = sanitize_text_field( $_POST['genName'] );
                update_post_meta( $post_id, 'genName', $genName );

                
                $genTelephone = sanitize_text_field( $_POST['genTelephone'] );
                update_post_meta( $post_id, 'genTelephone', $genTelephone );

                
                $genDayMo = sanitize_text_field( $_POST['genDayMo'] );
                update_post_meta( $post_id, 'genDayMo', $genDayMo );

                
                $genDayTu = sanitize_text_field( $_POST['genDayTu'] );
                update_post_meta( $post_id, 'genDayTu', $genDayTu );

                
                $genDayWe = sanitize_text_field( $_POST['genDayWe'] );
                update_post_meta( $post_id, 'genDayWe', $genDayWe );

                
                $genDayTh = sanitize_text_field( $_POST['genDayTh'] );
                update_post_meta( $post_id, 'genDayTh', $genDayTh );

                
                $genDayFr = sanitize_text_field( $_POST['genDayFr'] );
                update_post_meta( $post_id, 'genDayFr', $genDayFr );

                
                $genDaySa = sanitize_text_field( $_POST['genDaySa'] );
                update_post_meta( $post_id, 'genDaySa', $genDaySa );

                
                $genDaySu = sanitize_text_field( $_POST['genDaySu'] );
                update_post_meta( $post_id, 'genDaySu', $genDaySu );

                
                $genOPHours = sanitize_text_field( $_POST['genOPHours'] );
                update_post_meta( $post_id, 'genOPHours', $genOPHours );

                
                $genCLHours = sanitize_text_field( $_POST['genCLHours'] );
                update_post_meta( $post_id, 'genCLHours', $genCLHours );

                
                $genLat = sanitize_text_field( $_POST['genLat'] );
                update_post_meta( $post_id, 'genLat', $genLat );
                
                
                $genLon = sanitize_text_field( $_POST['genLon'] );
                update_post_meta( $post_id, 'genLon', $genLon );
                
                
                $genGPlus = sanitize_text_field( $_POST['genGPlus'] );
                update_post_meta( $post_id, 'genGPlus', $genGPlus );
                
                $genAddTo = sanitize_text_field( $_POST['genAddTo'] );
                update_post_meta( $post_id, 'genAddTo', $genAddTo );
                
                //if ($genAddTo == 'selected') {
                    
                $gen_page_ids = $_POST['gen_page_ids'];
                update_post_meta( $post_id, 'gen_page_ids', $gen_page_ids );
                    
                //}
                
                
                $gen_code = '';
        
                $gen_code = '{
                                "@context": "https://schema.org"';

                $gen_code .= ($genType) ? ',"@type": "'.$genType.'"' : '';

                $gen_code .= ($genURL) ? ',"url": "'.$genURL.'"' : '';

                $gen_code .= ($genMapURL) ? ',"hasMap": "'.$genMapURL.'"' : '';

                $gen_code .= ($genEmail) ? ',"email": "mailto:'.$genEmail.'"' : '';

                if ($genStreet != '' && $genCity != '' && $genState != '' && $genZip != '') {

                    $gen_code .= ',"address": {
                                    "@type": "PostalAddress"';
                    $gen_code .= ($genCity)     ? ',"addressLocality": "'.$genCity.'"'  : '';
                    $gen_code .= ($genState)    ? ',"addressRegion": "'.$genState.'"'   : '';
                    $gen_code .= ($genZip)      ? ',"postalCode":"'.$genZip.'"'         : '';
                    $gen_code .= ($genStreet)   ? ',"streetAddress": "'.$genStreet.'"'  : '';

                    $gen_code .= '}';

                }

                $gen_code .= ($genDescription) ? ',"description": "'.$genDescription.'"' : '';

                $gen_code .= ($genName) ? ',"name": "'.$genName.'"' : '';

                $gen_code .= ($genTelephone) ? ',"telephone": "'.$genTelephone.'"' : '';

                $days_array = array();

                if ( $genDayMo != '' ) {
                    $days_array[] = $genDayMo;
                }

                if ( $genDayTu != '' ) {
                    $days_array[] = $genDayTu;
                }

                if ( $genDayWe != '' ) {
                    $days_array[] = $genDayWe;
                }

                if ( $genDayTh != '' ) {
                    $days_array[] = $genDayTh;
                }

                if ( $genDayFr != '' ) {
                    $days_array[] = $genDayFr;
                }

                if ( $genDaySa != '' ) {
                    $days_array[] = $genDaySa;
                }

                if ( $genDaySu != '' ) {
                    $days_array[] = $genDaySu;
                }

                $days = implode(',', $days_array);

                $gen_code .= ($genCLHours != '' && $genOPHours != '') ? ',"openingHours": "'.$days.' '.$genOPHours.'-'.$genCLHours.'"' : '';

                $gen_code .= ',"geo": {
                    "@type": "GeoCoordinates",
                    "latitude":"'.$genLat.'",
                    "longitude": "'.$genLon.'"
                }';

                $gen_code .= ',"sameAs": [ "'.$genGPlus.'" ]';

                $gen_code .= '}';
                
                
                update_post_meta( $post_id, 'jsgen_code', $gen_code );
                
                
	}

	
}
add_action( 'save_post', 'jsgen_save_meta_box_data' );