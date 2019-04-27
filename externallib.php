<?php

/**
 *
 * @package    localuploadpdf
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir . "/externallib.php");
require_once($CFG->libdir . "/filelib.php");

class local_uploadpdf_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function up_parameters() {
        return new external_function_parameters(
		array('rid' => new external_value(PARAM_TEXT, 'The resource id.', VALUE_DEFAULT, 3))
        );
    }
   
    /**
     * Upload files to given resource (identified by id)
     * @return string OK
     */
    public static function up($rid) {
	$params = self::validate_parameters(self::up_parameters(), array('rid'=>$rid));
	$fs = get_file_storage();
	$cm = get_coursemodule_from_id('resource', $params["rid"]);
	$context = context_module::instance($cm->id);

	$files = $fs->get_area_files($context->id, 'mod_resource', 'content', 0, 'sortorder DESC, id ASC', false);
	$fileinfo=array();
	foreach ($files as $file) {

		$fileinfo = array(
        		'component' => $file->get_component(),
        		'filearea' => $file->get_filearea(),
        		'itemid' => $file->get_itemid(),
        		'contextid' => $file->get_contextid(),
			'filepath' => '/',
        		'timecreated' => time(),
        		'timemodified' => time()
		);
		$file->delete();
	}
	$numFiles = count($_FILES);  
	if($numFiles > 0){
	 
		foreach ($_FILES as $fieldname=>$uploaded_file) {
                		// check upload errors
                		if (!empty($_FILES[$fieldname]['error'])) {     

                    			switch ($_FILES[$fieldname]['error']) {
                    				case UPLOAD_ERR_INI_SIZE:
                        				throw new moodle_exception('upload_error_ini_size', 'repository_upload');
                        				break;
                    				case UPLOAD_ERR_FORM_SIZE:
                        				throw new moodle_exception('upload_error_form_size', 'repository_upload');
                        				break;
                    				case UPLOAD_ERR_PARTIAL:
                        				throw new moodle_exception('upload_error_partial', 'repository_upload');
                        				break;
                    				case UPLOAD_ERR_NO_FILE:
                        				throw new moodle_exception('upload_error_no_file', 'repository_upload');
                        				break;
                    				case UPLOAD_ERR_NO_TMP_DIR:
                        				throw new moodle_exception('upload_error_no_tmp_dir', 'repository_upload');
                        				break;
                    				case UPLOAD_ERR_CANT_WRITE:
                        				throw new moodle_exception('upload_error_cant_write', 'repository_upload');
                        				break;
                    				case UPLOAD_ERR_EXTENSION:
                        				throw new moodle_exception('upload_error_extension', 'repository_upload');
                        				break;
                    				default:
                        				throw new moodle_exception('nofile');
                    				}
                			}
					$filename = $_FILES[$fieldname]['name'];
					$fileinfo['filename']=$filename;
					$filepath = $_FILES[$fieldname]['tmp_name'];
					$fileinfo['itemid'] = 0;
					$fs->create_file_from_pathname($fileinfo, $filepath);
				}	
	}

        return "OK";
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function up_returns() {
        return new external_value(PARAM_TEXT, 'OK if succeed');
    }



}
