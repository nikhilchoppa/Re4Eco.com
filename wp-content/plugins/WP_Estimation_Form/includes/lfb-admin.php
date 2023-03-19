<?php
if (!defined('ABSPATH'))
    exit;

class LFB_admin {

    /**
     * The single instance
     * @var    object
     * @access  private
     * @since    1.0.0
     */
    private static $_instance = null;

    /**
     * The main plugin object.
     * @var    object
     * @access  public
     * @since    1.0.0
     */
    public $parent = null;

    /**
     * Prefix for plugin settings.
     * @var     string
     * @access  publicexportS
     * Delete
     * @since   1.0.0
     */
    public $base = '';

    /**
     * Available settings for plugin.
     * @var     array
     * @access  public
     * @since   1.0.0
     */
    public $settings = array();

    /**
     * Is WooCommerce activated ?
     * @var     array
     * @access  public
     * @since   1.5.0
     */
    public $isWooEnabled = false;

    public function __construct($parent) {
        $this->parent = $parent;
        $this->base = 'wpt_';
        $this->dir = dirname($this->parent->file);

        add_action('admin_menu', array($this, 'add_menu_item'));
        add_action('admin_print_scripts', array($this, 'admin_scripts'));
        add_action('admin_print_styles', array($this, 'admin_styles'));
        add_action('wp_ajax_nopriv_lfb_saveStep', array($this, 'saveStep'));
        add_action('wp_ajax_lfb_saveStep', array($this, 'saveStep'));
        add_action('wp_ajax_nopriv_lfb_addStep', array($this, 'addStep'));
        add_action('wp_ajax_lfb_addStep', array($this, 'addStep'));
        add_action('wp_ajax_nopriv_lfb_loadStep', array($this, 'loadStep'));
        add_action('wp_ajax_lfb_loadStep', array($this, 'loadStep'));
        add_action('wp_ajax_nopriv_lfb_loadLayers', array($this, 'loadLayers'));
        add_action('wp_ajax_lfb_loadLayers', array($this, 'loadLayers'));
        add_action('wp_ajax_nopriv_lfb_duplicateStep', array($this, 'duplicateStep'));
        add_action('wp_ajax_lfb_duplicateStep', array($this, 'duplicateStep'));
        add_action('wp_ajax_nopriv_lfb_removeStep', array($this, 'removeStep'));
        add_action('wp_ajax_lfb_removeStep', array($this, 'removeStep'));
        add_action('wp_ajax_nopriv_lfb_saveStepPosition', array($this, 'saveStepPosition'));
        add_action('wp_ajax_lfb_saveStepPosition', array($this, 'saveStepPosition'));
        add_action('wp_ajax_nopriv_lfb_newLink', array($this, 'newLink'));
        add_action('wp_ajax_lfb_newLink', array($this, 'newLink'));
        add_action('wp_ajax_nopriv_lfb_changePreviewHeight', array($this, 'changePreviewHeight'));
        add_action('wp_ajax_lfb_changePreviewHeight', array($this, 'changePreviewHeight'));
        add_action('wp_ajax_nopriv_lfb_saveLinks', array($this, 'saveLinks'));
        add_action('wp_ajax_lfb_saveLinks', array($this, 'saveLinks'));
        add_action('wp_ajax_nopriv_lfb_saveSettings', array($this, 'saveSettings'));
        add_action('wp_ajax_lfb_saveSettings', array($this, 'saveSettings'));
        add_action('wp_ajax_nopriv_lfb_loadSettings', array($this, 'loadSettings'));
        add_action('wp_ajax_lfb_loadSettings', array($this, 'loadSettings'));
        add_action('wp_ajax_nopriv_lfb_removeAllSteps', array($this, 'removeAllSteps'));
        add_action('wp_ajax_lfb_removeAllSteps', array($this, 'removeAllSteps'));
        add_action('wp_ajax_nopriv_lfb_addForm', array($this, 'addForm'));
        add_action('wp_ajax_lfb_addForm', array($this, 'addForm'));
        add_action('wp_ajax_nopriv_getFormSteps', array($this, 'getFormSteps'));
        add_action('wp_ajax_lfb_getFormSteps', array($this, 'getFormSteps'));
        add_action('wp_ajax_nopriv_lfb_loadForm', array($this, 'loadForm'));
        add_action('wp_ajax_lfb_loadForm', array($this, 'loadForm'));
        add_action('wp_ajax_nopriv_lfb_saveForm', array($this, 'saveForm'));
        add_action('wp_ajax_lfb_saveForm', array($this, 'saveForm'));
        add_action('wp_ajax_nopriv_lfb_removeForm', array($this, 'removeForm'));
        add_action('wp_ajax_lfb_removeForm', array($this, 'removeForm'));
        add_action('wp_ajax_nopriv_lfb_loadFields', array($this, 'loadFields'));
        add_action('wp_ajax_lfb_loadFields', array($this, 'loadFields'));
        add_action('wp_ajax_nopriv_lfb_removeRedirection', array($this, 'removeRedirection'));
        add_action('wp_ajax_lfb_removeRedirection', array($this, 'removeRedirection'));
        add_action('wp_ajax_nopriv_lfb_saveRedirection', array($this, 'saveRedirection'));
        add_action('wp_ajax_lfb_saveRedirection', array($this, 'saveRedirection'));
        add_action('wp_ajax_nopriv_lfb_saveField', array($this, 'saveField'));
        add_action('wp_ajax_lfb_saveField', array($this, 'saveField'));
        add_action('wp_ajax_nopriv_lfb_saveItem', array($this, 'saveItem'));
        add_action('wp_ajax_lfb_saveItem', array($this, 'saveItem'));
        add_action('wp_ajax_nopriv_lfb_removeItem', array($this, 'removeItem'));
        add_action('wp_ajax_lfb_removeItem', array($this, 'removeItem'));
        add_action('wp_ajax_nopriv_lfb_exportForms', array($this, 'exportForms'));
        add_action('wp_ajax_lfb_exportForms', array($this, 'exportForms'));
        add_action('wp_ajax_nopriv_lfb_importForms', array($this, 'importForms'));
        add_action('wp_ajax_lfb_importForms', array($this, 'importForms'));
        add_action('wp_ajax_nopriv_lfb_checkLicense', array($this, 'checkLicense'));
        add_action('wp_ajax_lfb_checkLicense', array($this, 'checkLicense'));
        add_action('wp_ajax_nopriv_lfb_duplicateForm', array($this, 'duplicateForm'));
        add_action('wp_ajax_lfb_duplicateForm', array($this, 'duplicateForm'));
        add_action('wp_ajax_nopriv_lfb_duplicateItem', array($this, 'duplicateItem'));
        add_action('wp_ajax_lfb_duplicateItem', array($this, 'duplicateItem'));
        add_action('wp_ajax_nopriv_lfb_removeField', array($this, 'removeField'));
        add_action('wp_ajax_lfb_removeField', array($this, 'removeField'));
        add_action('wp_ajax_nopriv_lfb_loadLogs', array($this, 'loadLogs'));
        add_action('wp_ajax_lfb_loadLogs', array($this, 'loadLogs'));
        add_action('wp_ajax_nopriv_lfb_removeLog', array($this, 'removeLog'));
        add_action('wp_ajax_lfb_removeLog', array($this, 'removeLog'));
        add_action('wp_ajax_nopriv_lfb_removeLogs', array($this, 'removeLogs'));
        add_action('wp_ajax_lfb_removeLogs', array($this, 'removeLogs'));
        add_action('wp_ajax_nopriv_lfb_loadLog', array($this, 'loadLog'));
        add_action('wp_ajax_lfb_loadLog', array($this, 'loadLog'));
        add_action('wp_ajax_nopriv_lfb_saveLog', array($this, 'saveLog'));
        add_action('wp_ajax_lfb_saveLog', array($this, 'saveLog'));
        add_action('wp_ajax_nopriv_lfb_downloadLog', array($this, 'downloadLog'));
        add_action('wp_ajax_lfb_downloadLog', array($this, 'downloadLog'));
        add_action('wp_ajax_nopriv_lfb_exportCustomersCSV', array($this, 'exportCustomersCSV'));
        add_action('wp_ajax_lfb_exportCustomersCSV', array($this, 'exportCustomersCSV'));
        add_action('wp_ajax_nopriv_lfb_exportCalendarEvents', array($this, 'exportCalendarEvents'));
        add_action('wp_ajax_lfb_exportCalendarEvents', array($this, 'exportCalendarEvents'));
        add_action('wp_ajax_nopriv_lfb_testSMTP', array($this, 'testSMTP'));
        add_action('wp_ajax_lfb_testSMTP', array($this, 'testSMTP'));
        add_action('wp_ajax_nopriv_lfb_sendOrderByEmail', array($this, 'sendOrderByEmail'));
        add_action('wp_ajax_lfb_sendOrderByEmail', array($this, 'sendOrderByEmail'));
        add_action('wp_ajax_nopriv_lfb_removeCoupon', array($this, 'removeCoupon'));
        add_action('wp_ajax_lfb_removeCoupon', array($this, 'removeCoupon'));
        add_action('wp_ajax_nopriv_lfb_removeAllCoupons', array($this, 'removeAllCoupons'));
        add_action('wp_ajax_lfb_removeAllCoupons', array($this, 'removeAllCoupons'));
        add_action('wp_ajax_nopriv_lfb_saveCoupon', array($this, 'saveCoupon'));
        add_action('wp_ajax_lfb_saveCoupon', array($this, 'saveCoupon'));
        add_action('wp_ajax_nopriv_lfb_getMailchimpLists', array($this, 'getMailchimpLists'));
        add_action('wp_ajax_lfb_getMailchimpLists', array($this, 'getMailchimpLists'));
        add_action('wp_ajax_nopriv_lfb_getMailpoetLists', array($this, 'getMailpoetLists'));
        add_action('wp_ajax_lfb_getMailpoetLists', array($this, 'getMailpoetLists'));
        add_action('wp_ajax_nopriv_lfb_getGetResponseLists', array($this, 'getGetResponseLists'));
        add_action('wp_ajax_lfb_getGetResponseLists', array($this, 'getGetResponseLists'));
        add_action('wp_ajax_nopriv_lfb_exportLogs', array($this, 'exportLogs'));
        add_action('wp_ajax_lfb_exportLogs', array($this, 'exportLogs'));
        add_action('wp_ajax_nopriv_lfb_changeItemsOrders', array($this, 'changeItemsOrders'));
        add_action('wp_ajax_lfb_changeItemsOrders', array($this, 'changeItemsOrders'));
        add_action('wp_ajax_nopriv_lfb_changeLastFieldsOrders', array($this, 'changeLastFieldsOrders'));
        add_action('wp_ajax_lfb_changeLastFieldsOrders', array($this, 'changeLastFieldsOrders'));
        add_action('wp_ajax_nopriv_lfb_changeLayersOrder', array($this, 'changeLayersOrder'));
        add_action('wp_ajax_lfb_changeLayersOrder', array($this, 'changeLayersOrder'));
        add_action('wp_ajax_nopriv_lfb_loadCharts', array($this, 'loadCharts'));
        add_action('wp_ajax_lfb_loadCharts', array($this, 'loadCharts'));
        add_action('wp_ajax_nopriv_lfb_resetReference', array($this, 'resetReference'));
        add_action('wp_ajax_lfb_resetReference', array($this, 'resetReference'));
        add_action('wp_ajax_nopriv_lfb_saveNewTotal', array($this, 'saveNewTotal'));
        add_action('wp_ajax_lfb_saveNewTotal', array($this, 'saveNewTotal'));
        add_action('wp_ajax_nopriv_tld_exportCSS', array($this, 'tld_exportCSS'));
        add_action('wp_ajax_tld_exportCSS', array($this, 'tld_exportCSS'));
        add_action('wp_ajax_nopriv_tld_saveCSS', array($this, 'tld_saveCSS'));
        add_action('wp_ajax_tld_saveCSS', array($this, 'tld_saveCSS'));
        add_action('wp_ajax_nopriv_tld_resetCSS', array($this, 'tld_resetCSS'));
        add_action('wp_ajax_tld_resetCSS', array($this, 'tld_resetCSS'));
        add_action('wp_ajax_nopriv_tld_getCSS', array($this, 'tld_getCSS'));
        add_action('wp_ajax_tld_getCSS', array($this, 'tld_getCSS'));
        add_action('wp_ajax_nopriv_tld_saveEditedCSS', array($this, 'tld_saveEditedCSS'));
        add_action('wp_ajax_tld_saveEditedCSS', array($this, 'tld_saveEditedCSS'));
        add_action('plugins_loaded', array($this, 'init_tld_localization'));
        add_action('wp_ajax_nopriv_lfb_getCalendarEvents', array($this, 'getCalendarEvents'));
        add_action('wp_ajax_lfb_getCalendarEvents', array($this, 'getCalendarEvents'));
        add_action('wp_ajax_nopriv_lfb_saveCalendarEvent', array($this, 'saveCalendarEvent'));
        add_action('wp_ajax_lfb_saveCalendarEvent', array($this, 'saveCalendarEvent'));
        add_action('wp_ajax_nopriv_lfb_updateCalendarEvent', array($this, 'updateCalendarEvent'));
        add_action('wp_ajax_lfb_updateCalendarEvent', array($this, 'updateCalendarEvent'));
        add_action('wp_ajax_nopriv_lfb_deleteCalendarEvent', array($this, 'deleteCalendarEvent'));
        add_action('wp_ajax_lfb_deleteCalendarEvent', array($this, 'deleteCalendarEvent'));
        add_action('wp_ajax_nopriv_lfb_saveCalendar', array($this, 'saveCalendar'));
        add_action('wp_ajax_lfb_saveCalendar', array($this, 'saveCalendar'));
        add_action('wp_ajax_nopriv_lfb_deleteCalendar', array($this, 'deleteCalendar'));
        add_action('wp_ajax_lfb_deleteCalendar', array($this, 'deleteCalendar'));
        add_action('wp_ajax_nopriv_lfb_saveCalendarReminder', array($this, 'saveCalendarReminder'));
        add_action('wp_ajax_lfb_saveCalendarReminder', array($this, 'saveCalendarReminder'));
        add_action('wp_ajax_nopriv_lfb_deleteCalendarReminder', array($this, 'deleteCalendarReminder'));
        add_action('wp_ajax_lfb_deleteCalendarReminder', array($this, 'deleteCalendarReminder'));
        add_action('wp_ajax_nopriv_lfb_saveCalendarCat', array($this, 'saveCalendarCat'));
        add_action('wp_ajax_lfb_saveCalendarCat', array($this, 'saveCalendarCat'));
        add_action('wp_ajax_nopriv_lfb_deleteCalendarCat', array($this, 'deleteCalendarCat'));
        add_action('wp_ajax_lfb_deleteCalendarCat', array($this, 'deleteCalendarCat'));
        add_action('wp_ajax_nopriv_lfb_saveCalendarDaysWeek', array($this, 'saveCalendarDaysWeek'));
        add_action('wp_ajax_lfb_saveCalendarDaysWeek', array($this, 'saveCalendarDaysWeek'));
        add_action('wp_ajax_nopriv_lfb_saveCalendarHoursDisabled', array($this, 'saveCalendarHoursDisabled'));
        add_action('wp_ajax_lfb_saveCalendarHoursDisabled', array($this, 'saveCalendarHoursDisabled'));
        add_action('wp_ajax_nopriv_lfb_getCalendarCategories', array($this, 'getCalendarCategories'));
        add_action('wp_ajax_lfb_getCalendarCategories', array($this, 'getCalendarCategories'));
        add_action('wp_ajax_nopriv_lfb_saveCustomerDataSettings', array($this, 'saveCustomerDataSettings'));
        add_action('wp_ajax_lfb_saveCustomerDataSettings', array($this, 'saveCustomerDataSettings'));
        add_action('wp_ajax_nopriv_lfb_getWooProductsByTerm', array($this, 'getWooProductsByTerm'));
        add_action('wp_ajax_lfb_getWooProductsByTerm', array($this, 'getWooProductsByTerm'));
        add_action('wp_ajax_nopriv_lfb_getWooProductTitle', array($this, 'getWooProductTitle'));
        add_action('wp_ajax_lfb_getWooProductTitle', array($this, 'getWooProductTitle'));
        add_action('wp_ajax_nopriv_lfb_addNewVariable', array($this, 'addNewVariable'));
        add_action('wp_ajax_lfb_addNewVariable', array($this, 'addNewVariable'));
        add_action('wp_ajax_nopriv_lfb_saveVariable', array($this, 'saveVariable'));
        add_action('wp_ajax_lfb_saveVariable', array($this, 'saveVariable'));
        add_action('wp_ajax_nopriv_lfb_deleteVariable', array($this, 'deleteVariable'));
        add_action('wp_ajax_lfb_deleteVariable', array($this, 'deleteVariable'));
        add_action('wp_ajax_nopriv_lfb_deleteCustomer', array($this, 'deleteCustomer'));
        add_action('wp_ajax_lfb_deleteCustomer', array($this, 'deleteCustomer'));
        add_action('wp_ajax_nopriv_lfb_getCustomersList', array($this, 'getCustomersList'));
        add_action('wp_ajax_lfb_getCustomersList', array($this, 'getCustomersList'));
        add_action('wp_ajax_nopriv_lfb_getCustomerDetails', array($this, 'getCustomerDetails'));
        add_action('wp_ajax_lfb_getCustomerDetails', array($this, 'getCustomerDetails'));
        add_action('wp_ajax_nopriv_lfb_saveCustomer', array($this, 'saveCustomer'));
        add_action('wp_ajax_lfb_saveCustomer', array($this, 'saveCustomer'));
        add_action('wp_ajax_nopriv_lfb_saveGlobalSettings', array($this, 'saveGlobalSettings'));
        add_action('wp_ajax_lfb_saveGlobalSettings', array($this, 'saveGlobalSettings'));
        add_action('wp_ajax_nopriv_lfb_changeOrderStatus', array($this, 'changeOrderStatus'));
        add_action('wp_ajax_lfb_changeOrderStatus', array($this, 'changeOrderStatus'));
        add_action('wp_ajax_nopriv_lfb_toggleDarkMode', array($this, 'toggleDarkMode'));
        add_action('wp_ajax_lfb_toggleDarkMode', array($this, 'toggleDarkMode'));
        add_action('wp_ajax_nopriv_lfb_getFormPreviewURL', array($this, 'getFormPreviewURL'));
        add_action('wp_ajax_lfb_getFormPreviewURL', array($this, 'getFormPreviewURL'));
        add_action('wp_ajax_nopriv_lfb_createNewItem', array($this, 'createNewItem'));
        add_action('wp_ajax_lfb_createNewItem', array($this, 'createNewItem'));
        add_action('wp_ajax_nopriv_lfb_createRowColumn', array($this, 'createRowColumn'));
        add_action('wp_ajax_lfb_createRowColumn', array($this, 'createRowColumn'));
        add_action('wp_ajax_nopriv_lfb_deleteRowColumn', array($this, 'deleteRowColumn'));
        add_action('wp_ajax_lfb_deleteRowColumn', array($this, 'deleteRowColumn'));
        add_action('wp_ajax_nopriv_lfb_editRowColumn', array($this, 'editRowColumn'));
        add_action('wp_ajax_lfb_editRowColumn', array($this, 'editRowColumn'));
        add_action('wp_ajax_nopriv_lfb_changeStepMainSettings', array($this, 'changeStepMainSettings'));
        add_action('wp_ajax_lfb_changeStepMainSettings', array($this, 'changeStepMainSettings'));



        add_filter('admin_body_class', array($this, 'setBodyClasses'));

        add_action('admin_init', array($this, 'checkAutomaticUpdates'));
        add_action('admin_init', array($this, 'checkFirstStart'));
        add_action('admin_init', array($this, 'checkActions'));

        add_action('vc_before_init', array($this, 'init_vc'));
        add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
            global $wp_version;
            if ($wp_version == '4.7' || ( (float) $wp_version < 4.7 )) {
                return $data;
            }
            $filetype = wp_check_filetype($filename, $mimes);
            return array('ext' => $filetype['ext'], 'type' => $filetype['type'], 'proper_filename' => $data['proper_filename']);
        }, 10, 4);
        add_filter('upload_mimes', array($this, 'cc_mime_types'));
    }

    public function editRowColumn() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $rowID = intval($_POST['rowID']);
            $columnID = sanitize_text_field($_POST['columnID']);
            $size = sanitize_text_field($_POST['size']);
            $table_name = $wpdb->prefix . "wpefc_items";
            $item = $wpdb->get_results($wpdb->prepare("SELECT id,columns FROM $table_name WHERE id=%s LIMIT 1", $rowID));
            if (count($item) > 0) {
                $item = $item[0];
                if ($item->columns != '') {
                    $item->columns = json_decode($item->columns, true);
                    $index = -1;
                    $i = 0;
                    foreach ($item->columns as $column) {
                        if ($column['id'] == $columnID) {
                            $item->columns[$i]['size'] = $size;
                            break;
                        }
                        $i++;
                    }
                }

                $wpdb->update($table_name, array('columns' => json_encode($item->columns)), array('id' => $rowID));
                die();
            }
        }
    }

    public function deleteRowColumn() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $rowID = intval($_POST['rowID']);
            $columnID = sanitize_text_field($_POST['columnID']);

            $table_name = $wpdb->prefix . "wpefc_items";
            $item = $wpdb->get_results($wpdb->prepare("SELECT id,columns FROM $table_name WHERE id=%s LIMIT 1", $rowID));
            if (count($item) > 0) {
                $item = $item[0];
                if ($item->columns != '') {
                    $item->columns = json_decode($item->columns, true);
                    $index = -1;
                    $i = 0;
                    foreach ($item->columns as $column) {
                        if ($column['id'] == $columnID) {
                            $index = $i;
                            break;
                        }
                        $i++;
                    }
                    if ($index > -1) {
                        unset($item->columns[$index]);
                    }
                    $wpdb->update($table_name, array('columns' => json_encode($item->columns)), array('id' => $rowID));
                }
            }
        }
        die();
    }

    public function createRowColumn() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $rowID = intval($_POST['rowID']);

            $table_name = $wpdb->prefix . "wpefc_items";
            $item = $wpdb->get_results($wpdb->prepare("SELECT id,columns FROM $table_name WHERE id=%s LIMIT 1", $rowID));
            if (count($item) > 0) {
                $item = $item[0];
                if ($item->columns == '') {
                    $item->columns = array();
                } else {
                    $item->columns = json_decode($item->columns, true);
                }
                $column = new stdClass();
                $column->size = 'medium';
                $column->id = uniqid();
                $item->columns[] = $column;
                $wpdb->update($table_name, array('columns' => json_encode($item->columns)), array('id' => $rowID));
                echo $column->id;
                die();
            }
        }
    }

    public function createNewItem() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $formID = intval($_POST['formID']);
            $stepID = sanitize_text_field($_POST['stepID']);
            $columnID = sanitize_text_field($_POST['columnID']);
            $type = sanitize_text_field($_POST['type']);
            $title = sanitize_text_field($_POST['title']);
            $index = intval($_POST['index']);

            $isFinalStep = false;
            if ($stepID == 'final' || $stepID == 0) {
                $stepID = 0;
                $isFinalStep = true;
            }

            $useRow = false;
            $columns = '';
            if ($type == 'row') {
                $useRow = true;
                $columns = array();
                $column = new stdClass();
                $column->id = uniqid();
                $column->size = 'xl';
                $columns[] = $column;
                $columns = json_encode($columns);
            }
            $color = '#1abc9c';
            $maxSize = 0;
            if ($type == 'rate') {
                $color = '#bdc3c7';
                $maxSize = 5;
            }

            $table_name = $wpdb->prefix . "wpefc_items";
            $wpdb->insert($table_name, array(
                'title' => $title,
                'type' => $type,
                'formID' => $formID,
                'stepID' => $stepID,
                'useRow' => $useRow,
                'columns' => $columns,
                'columnID' => $columnID,
                'buttonText' => 'Lorem ipsum',
                'ordersort' => $index,
                'color' => $color,
                'maxSize' => $maxSize,
                'image' => esc_url($this->parent->assets_url) . 'img/placeholder.png',
                'richtext' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam faucibus lectus ac massa dictum, rhoncus bibendum mauris volutpat.'
            ));
            $itemID = $wpdb->insert_id;

            $table_name = $wpdb->prefix . "wpefc_items";
            $item = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $itemID));
            if (count($item) > 0) {
                $item = $item[0];
            }

            $table_name = $wpdb->prefix . "wpefc_forms";
            $form = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
            if (count($form) > 0) {
                $form = $form[0];
            }

            $table_name = $wpdb->prefix . "wpefc_steps";
            $step = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $stepID));
            if (count($step) > 0) {
                $step = $step[0];
            }

            $rep = new stdClass();
            $rep->itemData = $item;
            $rep->itemDom = $this->parent->generateItemHtml($item, $form, $step, $isFinalStep);
            echo json_encode($rep);
        }
        die();
    }

    public function getFormPreviewURL() {
        if (current_user_can('manage_options')) {

            $formID = intval($_POST['formID']);
            $pageID = 0;
            $page = get_page_by_title(__('Form preview', 'lfb'));
            if (!isset($page)) {
                $page = array(
                    'post_title' => __('Form preview', 'lfb'),
                    'post_content' => '[estimation_form form_id="' . $formID . '" fullscreen="true"]',
                    'post_status' => 'private',
                    'post_author' => 1,
                    'post_category' => array(0),
                    'post_type' => 'page'
                );

                $pageID = wp_insert_post($page);
            } else {
                $pageID = $page->ID;
                $page->post_content = '[estimation_form form_id="' . $formID . '" fullscreen="true"]';
                $page->post_status = 'private';
                wp_update_post($page);
            }
            echo get_permalink($pageID);
            die();
        }
    }

    public function cc_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    public function setBodyClasses($classes) {
        $settings = $this->getSettings();
        if ($settings->useDarkMode) {
            $classes .= ' lfb_dark';
        }
        return $classes;
    }

    /*
     *  Add shortcode to VisualComposer
     */

    public function init_vc() {
        if (defined('WPB_VC_VERSION')) {
            global $wpdb;
            $formsValues = array();
            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = $wpdb->get_results("SELECT id,title FROM $table_name ORDER BY id ASC");
            foreach ($forms as $form) {
                $formsValues[] = $form->id;
            }
            vc_map(array(
                "name" => __('Estimation Form', 'lfb'),
                "base" => "estimation_form",
                "category" => 'Content',
                "icon" => 'icon_lfb_form',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Form ID", 'lfb'),
                        "param_name" => "form_id",
                        "value" => $formsValues,
                        "std" => "1",
                        "description" => __("Select a form", "lfb")
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Popup", 'lfb'),
                        "param_name" => "popup",
                        "value" => array('false', 'true'),
                        "std" => "false",
                        "description" => __("To use as popup", "lfb")
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Fullscreen", 'lfb'),
                        "param_name" => "fullscreen",
                        "value" => array('false', 'true'),
                        "std" => "false",
                        "description" => __("To use in fullscreen", "lfb")
                    )
                )
            ));
        }
    }

    /**
     * Add menu to admin
     * @return void
     */
    public function add_menu_item() {
        add_menu_page(__("E&P Form Builder", 'lfb'), __("E&P Form Builder", 'lfb'), 'manage_options', 'lfb_menu', array($this, 'view_edit_lfb'), 'dashicons-format-aside');
        add_submenu_page('lfb_menu', __('License', 'lfb'), __('License', 'lfb'), 'manage_options', 'lfb_settings', array($this, 'submenu_settings'));

        $menuSlag = 'lfb_menu';
    }

    public function getSettings() {
        global $wpdb;
        $table_name = $wpdb->prefix . "wpefc_settings";
        $settings = $wpdb->get_results("SELECT * FROM $table_name WHERE id=1 LIMIT 1");
        $rep = false;
        if (count($settings) > 0) {
            $rep = $settings[0];
        }
        return $rep;
    }

    public function getMailchimpLists() {
        if (isset($_POST['apiKey'])) {
            $apiKey = sanitize_text_field($_POST['apiKey']);
            if ($apiKey != "") {
                $MailChimp = new Mailchimp($apiKey);
                $result = $MailChimp->lists->getList();
                foreach ($result['data'] as $list) {
                    echo '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
                }
            }
        }
        die();
    }

    public function getMailpoetLists() {
        $subscription_lists = \MailPoet\API\API::MP('v1')->getLists();
        foreach ($subscription_lists as $list) {
            echo '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
        }

        die();
    }

    public function getGetResponseLists() {
        if (isset($_POST['apiKey'])) {

            $apiKey = sanitize_text_field($_POST['apiKey']);
            if ($apiKey != "") {
                $GetResponse = new GetResponseEP($apiKey);
                $result = $GetResponse->getCampaigns();
                foreach ($result as $list => $value) {
                    echo '<option value="' . $value->campaignId . '">' . $value->name . '</option>';
                }
            }
        }
        die();
    }

    public function checkActions() {
        global $wpdb;
        if (isset($_GET['lfb_action']) && $_GET['lfb_action'] == 'exportForms') {
            $target_path = plugin_dir_path(__FILE__) . '../tmp/export_estimation_form.zip';
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($target_path) . '"');
            header("Content-Transfer-Encoding: Binary");
            header("Content-length: " . filesize($target_path));
            header("Pragma: no-cache");
            header("Expires: 0");
            ob_clean();
            flush();
            readfile($target_path);
            unlink($target_path);
            exit;
        } else if (isset($_GET['lfb_action']) && isset($_GET['ref']) && $_GET['lfb_action'] == 'downloadLog') {
            $table_name = $wpdb->prefix . "wpefc_logs";
            $order = $wpdb->get_results($wpdb->prepare("SELECT ref FROM $table_name WHERE ref=%s LIMIT 1", sanitize_text_field($_GET['ref'])));
            if (count($order) > 0) {
                $order = $order[0];
                $fileName = 'exported_orders.csv';
                $target_path = plugin_dir_path(__FILE__) . '../tmp/' . $fileName;
                header('Content-type: application/csv');
                header('Content-Disposition: attachment; filename="' . basename($target_path) . '"');
                header("Content-Transfer-Encoding: Binary");
                header("Content-length: " . filesize($target_path));
                header("Pragma: no-cache");
                header("Expires: 0");
                ob_clean();
                flush();
                readfile($target_path);
                unlink($target_path);
                exit;
            }
            exit;
        } else if (isset($_GET['lfb_action']) && isset($_GET['ref']) && $_GET['lfb_action'] == 'downloadOrder') {
            $table_name = $wpdb->prefix . "wpefc_logs";
            $order = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE ref=%s LIMIT 1", sanitize_text_field($_GET['ref'])));
            if (count($order) > 0) {
                $order = $order[0];
                $fileName = $order->formTitle . '-' . sanitize_text_field($_GET['ref']) . '.pdf';
                $target_path = plugin_dir_path(__FILE__) . '../uploads/' . $fileName;
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment; filename="' . basename($target_path) . '"');
                header("Content-Transfer-Encoding: Binary");
                header("Content-length: " . filesize($target_path));
                header("Pragma: no-cache");
                header("Expires: 0");
                ob_clean();
                flush();
                readfile($target_path);
                unlink($target_path);
                exit;
            }
            exit;
        } else if (isset($_GET['lfb_action']) && $_GET['lfb_action'] == 'downloadLogs') {

            $target_path = plugin_dir_path(__FILE__) . '../tmp/exported_orders.csv';
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename="' . basename($target_path) . '"');
            header("Content-Transfer-Encoding: Binary");
            header("Content-length: " . filesize($target_path));
            header("Pragma: no-cache");
            header("Expires: 0");
            ob_clean();
            flush();
            readfile($target_path);
            unlink($target_path);
            exit;
        } else if (isset($_GET['lfb_action']) && $_GET['lfb_action'] == 'downloadCustomersCsv') {

            $target_path = plugin_dir_path(__FILE__) . '../tmp/exported_customers.csv';
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename="' . basename($target_path) . '"');
            header("Content-Transfer-Encoding: Binary");
            header("Content-length: " . filesize($target_path));
            header("Pragma: no-cache");
            header("Expires: 0");
            ob_clean();
            flush();
            readfile($target_path);
            unlink($target_path);
            exit;
        } else if (isset($_GET['lfb_action']) && $_GET['lfb_action'] == 'downloadCalendarCsv') {

            $target_path = plugin_dir_path(__FILE__) . '../tmp/exported_calendar.csv';
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename="' . basename($target_path) . '"');
            header("Content-Transfer-Encoding: Binary");
            header("Content-length: " . filesize($target_path));
            header("Pragma: no-cache");
            header("Expires: 0");
            ob_clean();
            flush();
            readfile($target_path);
            unlink($target_path);
            exit;
        }
    }

    public function submenu_settings() {
        global $wpdb;
        $settings = $this->getSettings();
        echo '<div id="lfb_loader"></div>';
        echo '<div id="lfb_bootstraped" class="lfb_bootstraped lfb_panel">';
        echo '<div id="estimation_popup" class="wpe_bootstraped">';

        echo '<div id="lfb_formWrapper" >';
        echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise">
               <span class="glyphicon  glyphicon-list-alt" style="opacity: 0;"></span><span class="lfb_iconLogo"></span>' . __('Estimation & Payment Forms', 'lfb') . '';
        echo '<div class="btn-toolbar">';
        echo '<div class="btn-group">';
        echo '<a class="btn btn-primary" href="admin.php?page=lfb_menu"  data-toggle="tooltip" title="' . __('Return to the forms list', 'lfb') . '" data-placement="left"><span class="glyphicon glyphicon-list"></span></a>';
        echo '</div>';
        echo '</div>'; // eof toolbar
        echo '</div>'; // eof lfb_winHeader
        echo '<div class="clearfix"></div>';

        echo '<div id="lfb_settings_licenseContainer">';
        if (strlen($settings->purchaseCode) > 8) {
            echo ' <p id="lfb_settings_licenseOk"><span class="glyphicon glyphicon-ok" style="font-size: 78px;"></span><br/>' . __('The license is verified', 'lfb') . '</p>';
        } else if (get_option('lfb_themeMode')) {
            if (wp_get_theme() == 'X') {
                echo ' <p id="lfb_settings_licenseTheme"><span class="glyphicon glyphicon-ok" style="font-size: 78px;"></span><br/>'
                . '<span style="font-size: 18px;margin-bottom: 0px;font-weight: bold;display: block;">Purchase not required</span><br/>'
                . '<span style="font-size: 15px; font-weight: normal; text-align: justify;">Your license of <strong>WP Cost Estimation & Payment Forms Builder</strong> is included with your X license purchase. If your X license is validated (<a href="https://community.theme.co/kb/product-validation/" target="_blank">explained here</a>), your copy of WP Cost Estimation & Payment Forms Builder will be validated as well including updates as they are made available and support directly from Themeco.<br/><a href="https://community.theme.co/kb/integrated-plugins-estimation-and-payment-forms/"  target="_blank">Find out more in this article</a></span>'
                . '</p>';
            } else {
                echo ' <p id="lfb_settings_licenseTheme"><span class="glyphicon glyphicon-ok" style="font-size: 78px;"></span><br/>' . __('The plugin is included in your theme, there is no need to check the license', 'lfb') . '</p>';
            }
        } else {
            echo '<p id="lfb_settings_licenseNo"><span class="glyphicon glyphicon-remove" style="font-size: 78px;"></span><br/>' . __('The license isn\'t verified, please fill your purchase code', 'lfb') . '</p>';
        }
        if (wp_get_theme() != 'X') {
            echo ' <div id="lfb_alertX" class="alert alert-info">
                                	<span class="glyphicon glyphicon-info-sign"></span>
                                    ' . __('Every website that uses this plugin needs a legal license', 'lfb') . '<br/>
                                        (' . __('1 license = 1 website', 'lfb') . ')<br/>
                                    ' . __('To find more information about Envato licenses', 'lfb') . ',
                                        <a href="https://codecanyon.net/licenses/standard" target="_blank">' . __('click here', 'lfb') . '</a>.<br/>
                                     ' . __('If you need to buy a new license of this plugin', 'lfb') . ', <a href="https://codecanyon.net/item/wp-flat-estimation-payment-forms-/7818230?ref=loopus" target="_blank">' . __('click here', 'lfb') . '</a>.
                                </div>';
        }

        echo '<div class="form-group"><label>' . __('Purchase Code') . ' :</label><input name="purchaseCode" type="text" value="' . $settings->purchaseCode . '" class="form-control"/><br/>'
        . '<span class="lfb_licenseHelpImgLink"><a href="https://www.wordpress-estimation-payment-forms.com/purchaseCode.gif" target="_blank">' . __('Where I can find my purchase code ?', 'lfb') . '</a></span></div>'
        . '<a href="javascript:"   class="btn btn-primary" onclick="lfb_settings_checkLicense();"><span class="glyphicon glyphicon-check"></span>' . __('Verify', 'lfb') . '</a>';


        echo '</div>';
        echo '</div>';
        echo '</div>'; //eof lfb_bootstraped
    }

    /*
     * Main view
     */

    public function view_edit_lfb() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $this->checkFields();
            $settings = $this->getSettings();


            wp_enqueue_style('thickbox');
            wp_enqueue_script('thickbox');

            echo '<div id="lfb_loader"></div>';
            echo '<div id="lfb_bootstraped" class="lfb_bootstraped lfb_panel">';
            echo '<div id="estimation_popup" class="wpe_bootstraped">';

            echo '<div id="lfb_formWrapper" >';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise">
               <span class="glyphicon  glyphicon-list-alt" style="opacity: 0;"></span><span class="lfb_iconLogo"></span>' . __('Estimation & Payment Forms', 'lfb') . '';
            echo '<div class="btn-toolbar" id="lfb_mainToolbar">';
            echo '<div class="btn-group">';
            echo '<a href="javascript:" data-action="toggleDarkMode" class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('Dark mode', 'lfb') . '" data-placement="left"><span style="left: 1px;top: 2px;" class="fas fa-low-vision"></span></a>';
            echo '<a href="javascript:" data-action="openGlobalSettings" class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('Global settings', 'lfb') . '" data-placement="left"><span style="left: 1px;top: 2px;" class="fas fa-cogs"></span></a>';
            echo '<a href="javascript:" data-action="showAllOrders" class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('Orders list', 'lfb') . '" data-placement="left"><span style="left: 1px;top: 2px;" class="glyphicon glyphicon-th-list"></span></a>';
            echo '<a href="javascript:" data-action="showCustomersPanel" class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('Customers', 'lfb') . '" data-placement="left"><span style="left: 1px;top: 2px;" class="fas fa-users"></span></a>';
            echo '<a href="javascript:" data-action="openCalendarsPanel"  class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('View calendars', 'lfb') . '" data-placement="left"><span style="left: 1px;top: 2px;" class="glyphicon glyphicon-calendar"></span></a>';
            echo '<a class="btn btn-primary" href="javascript:" onclick="lfb_closeSettings();" data-toggle="tooltip" title="' . __('Return to the forms list', 'lfb') . '" data-placement="left"><span class="glyphicon glyphicon-list"></span></a>';
            echo '</div>';
            echo '</div>'; // eof toolbar
            echo '</div>'; // eof lfb_winHeader
            echo '<div class="clearfix"></div>';



            echo '<div id="lfb_winGlobalSettings" class="modal fade lfb_modal">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">' . __('Global settings', 'lfb') . '</h4>
                              </div>
                              <div class="modal-body p-0">';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs responsive" role="tablist">
                <li role="presentation" class="active"><a href="#lfb_tabGeneralSettings" role="tab" data-toggle="tab"><span class="fas fa-cog"></span>' . __('General', 'lfb') . '</a></li>
                <li role="presentation"><a href="#lfb_tabTextsSettings" aria-controls="texts" role="tab" data-toggle="tab"><span class="fas fa-font"></span>' . __('Customer account texts', 'lfb') . '</a></li>
                <li role="presentation"><a href="#lfb_tabColorsSettings" aria-controls="texts" role="tab" data-toggle="tab"><span class="fas fa-font"></span>' . __('Main colors', 'lfb') . '</a></li>

                </ul>';

            echo '<div class="tab-content responsive">';

            echo ' <div class="tab-pane active" id="lfb_tabGeneralSettings">';
            echo '<div class="col-md-6">'
            . '<div class="form-group" style="min-height: 69px;">
                <label  style="width: auto;">' . __('Enable frontend customer account management', 'lfb') . '</label><br/>
                 <input type="checkbox" data-switch="switch"  name="enableCustomerAccount"/>
                 </div>';

            echo '<div class="form-group">
                <label>' . __('Account management page', 'lfb') . '</label>';
            wp_dropdown_pages(array(
                'class' => 'form-control',
                'name' => 'customerAccountPageID'));
            echo '<small> ' . __('The account management will be displayed in the selected page', 'lfb') . ' </small>                 
                 </div>';


            echo '<div class="form-group">
                <label  style="width: auto;">' . __('Encrypt data in the database', 'lfb') . '</label><br/>
                 <input type="checkbox" data-switch="switch"  name="encryptDB"/>
                 </div>';

            echo '<div class="form-group">
                    <label  style="width: auto;">' . __('Use steps visual builder', 'lfb') . '</label><br/>
                    <input type="checkbox" data-switch="switch"  name="useVisualBuilder"/>
                 </div>';

            echo '</div>';

            echo '<div class="col-md-6">';


            echo '<div class="form-group">
                <label style="width: auto;">' . __('Admin email', 'lfb') . '</label><br/>
                 <input type="text" class="form-control"  name="adminEmail"/>
                 </div>';
            echo '<div class="form-group">
                <label style="width: auto;">' . __('Sender name', 'lfb') . '</label><br/>
                 <input type="text" class="form-control"  name="senderName"/>
                 </div>';


            echo '<div class="form-group">
                <label  style="width: auto;">' . __('Use SMTP to send emails', 'lfb') . '</label><br/>
                 <input type="checkbox" data-switch="switch"  name="useSMTP"/>
                 </div>';

            echo '<div class="form-group">
                <label style="width: auto;">' . __('SMTP Host', 'lfb') . '</label><br/>
                 <input type="text" class="form-control"  name="smtp_host"/>
                 </div>';
            echo '<div class="form-group">
                <label style="width: auto;">' . __('SMTP Port', 'lfb') . '</label><br/>
                 <input type="number" min="0" max="9999" class="form-control"  name="smtp_port"/>
                 </div>';
            echo '<div class="form-group">
                <label style="width: auto;">' . __('SMTP Username', 'lfb') . '</label><br/>
                 <input type="text" class="form-control"  name="smtp_username"/>
                 </div>';
            echo '<div class="form-group">
                <label style="width: auto;">' . __('SMTP Password', 'lfb') . '</label><br/>
                 <input type="password" class="form-control"  name="smtp_password"/>
                 </div>';
            echo '<div class="form-group">
                <label style="width: auto;">' . __('SMTP Mode', 'lfb') . '</label><br/>
                 <select class="form-control"  name="smtp_mode">
                    <option value="ssl">SSL</value>
                    <option value="tls">TLS</value>                    
                 </select>
                 </div>';

            echo '<p><a href="javascript:" data-action="testSMTP" class="btn btn-default"><span class="fas fa-rocket"></span>' . __('Test SMTP', 'lfb') . '</a></p>';
            echo '<div id="lfb_smtpTestRep"></div>';

            echo '</div>';

            echo '<div class="clearfix"></div>';
            echo '</div>';
            echo ' <div class="tab-pane" id="lfb_tabTextsSettings">';
            echo '<div class="col-md-4">';

            echo '<div class="form-group">
                    <label>' . __('Title of the customer account page', 'lfb') . '</label>
                    <input type="text" class="form-control" name="customersAc_customerInfo"/>
                  </div>';
            echo '<div class="form-group">
                    <label>' . __('Label "Your email"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersDataLabelEmail"/>
                     </div>       
                     <div class="form-group">
                    <label>' . __('Label "Your password"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersDataLabelPass"/>
                     </div>
                     
                     <div class="form-group">
                    <label>' . __('Label "First name"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_firstName"/>
                     </div>            
                     <div class="form-group">
                    <label>' . __('Label "Last Name"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_lastName"/>
                     </div>            
                     <div class="form-group">
                    <label>' . __('Label "Email"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_email"/>
                     </div>
                     <div class="form-group">
                    <label>' . __('Label "Address"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_address"/>
                     </div>            
                        
                     <div class="form-group">
                    <label>' . __('Label "Status"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_status"/>
                     </div>      

                     <div class="form-group">
                    <label>' . __('Forgotten password link', 'lfb') . '</label>
                     <input type="text" class="form-control" name="txtCustomersDataForgotPassLink"/>
                     </div>   


                    </div>
                    <div class="col-md-4">

                     <div class="form-group">
                    <label>' . __('Label "City"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_city"/>
                     </div>                     
                     <div class="form-group">
                    <label>' . __('Label "Country"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_country"/>
                     </div>                     
                     <div class="form-group">
                    <label>' . __('Label "State"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_state"/>
                     </div>                       
                     <div class="form-group">
                    <label>' . __('Label "Postal code"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_zip"/>
                     </div>                      
                     <div class="form-group">
                    <label>' . __('Label "Phone"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_phone"/>
                     </div> 
                     <div class="form-group">
                    <label>' . __('Label "Company"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_company"/>
                     </div>                     
                     <div class="form-group">
                    <label>' . __('Label "Website"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_url"/>
                     </div>
                      <div class="form-group">
                    <label>' . __('Label "Subscription total"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_totalSub"/>
                     </div>      
                     
                     <div class="form-group">
                    <label>' . __('Password sent confirmation', 'lfb') . '</label>
                     <input type="text" class="form-control" name="txtCustomersDataForgotPassSent"/>
                     </div>    
                    ';



            echo '</div>'; // eof .col-md-4
            echo '<div class="col-md-4">';

            echo '<div class="form-group">
                    <label>' . __('Button "Login"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersDataLabelBtnLogin"/>
                     </div>';

            echo '<div class="form-group">'
            . '<label>' . __('Download button text', 'lfb') . '</label>
                    <input type="text" class="form-control" name="txtCustomersDataDownloadLink"/>
                    </div>
                   
                    <div class="form-group">
                   <label>' . __('Deletion button text', 'lfb') . '</label>
                    <input type="text" class="form-control" name="txtCustomersDataDeleteLink"/>
                    </div>
                    <div class="form-group">
                   <label>' . __('Logout button text', 'lfb') . '</label>
                    <input type="text" class="form-control" name="txtCustomersDataLeaveLink"/>
                    </div>
                    <div class="form-group">
                   <label>' . __('Title "My orders"', 'lfb') . '</label>
                    <input type="text" class="form-control" name="customersAc_myOrders"/>
                    </div>
                    <div class="form-group">
                   <label>' . __('Button "View order"', 'lfb') . '</label>
                    <input type="text" class="form-control" name="customersAc_viewOrder"/>
                    </div>
                    <div class="form-group">
                   <label>' . __('Button "Download order"', 'lfb') . '</label>
                    <input type="text" class="form-control" name="customersAc_downloadOrder"/>
                    </div>
                     <div class="form-group">
                    <label>' . __('Label "Total"', 'lfb') . '</label>
                     <input type="text" class="form-control" name="customersAc_total"/>
                     </div>      
                     <div class="form-group">
                    <label>' . __('Password email subject', 'lfb') . '</label>
                     <input type="text" class="form-control" name="txtCustomersDataForgotMailSubject"/>
                     </div>   

                    ';






            echo '</div>'; // eof .col-md-4

            echo '<div class="col-md-12">';
            echo '<h4> ' . __('Order status', 'lfb') . ' </h4 >';
            echo '</div>'; // eof .col-md-12

            echo '<div class="col-md-4">';
            echo '<div class="form-group" >
                                <label > ' . __('Pending', 'lfb') . ' </label >
                                <input type="text" name="txt_order_pending" class="form-control" />
                            </div> 
                            <div class="form-group" >
                                <label > ' . __('Canceled', 'lfb') . ' </label >
                                <input type="text" name="txt_order_canceled" class="form-control" />
                            </div> 
                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label > ' . __('Being Processed', 'lfb') . ' </label >
                                <input type="text" name="txt_order_beingProcessed" class="form-control" />
                            </div> 
                            <div class="form-group" >
                                <label > ' . __('Shipped', 'lfb') . ' </label >
                                <input type="text" name="txt_order_shipped" class="form-control" />
                            </div> 
                            </div>
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label > ' . __('Completed', 'lfb') . ' </label >
                                <input type="text" name="txt_order_completed" class="form-control" />
                            </div> ';
            echo '</div>'; // eof .col-md-4

            echo '<div class="clearfix"></div>';
            echo '<div class="col-md-3">';
            echo '<div class="form-group">
                                     <label id="txtCustomersDataWarningTextLabel">' . __('Warning text regarding data deletion', 'lfb') . '</label>
                                     <textarea class="form-control" name="txtCustomersDataWarningText" style="height: 164px;"></textarea>
                                 </div>';
            echo '</div>'; // eof .col-md-3
            echo '<div class="col-md-3">';
            echo '<div class="form-group">
                                     <label id="txtCustomersDataWarningTextLabel">' . __('Data deletion request confirmation', 'lfb') . '</label>
                                     <textarea class="form-control" name="txtCustomersDataModifyValidConfirm" style="height: 164px;"></textarea>
                                 </div>';
            echo '</div>'; // eof .col-md-3


            echo '<div class="col-md-6">';
            echo '<div class="form-group">
                                <label id="lfb_variablesCustomersPassEmailLabel">' . __('Content of the password recovery email', 'lfb') . '</label>
                               <div id="lfb_variablesCustomersPassEmail" class="palette palette-turquoise">                                    
                                    <p>
                                      <strong>[url]</strong> : ' . __('Url to the data management page', 'lfb') . '<br>
                                      <strong>[password]</strong> : ' . __("The customer's password", 'lfb') . '                                  
                                    </p>
                                </div>
                                 <textarea class="form-control" name="txtCustomersDataForgotPassMail"></textarea>
                                 </div>';
            echo '</div>'; // eof .col-md-6

            echo '<div class="clearfix"></div>';
            echo '</div>'; // eof #lfb_tabTextsSettings


            echo ' <div class="tab-pane" id="lfb_tabColorsSettings">';
            echo '<div class="col-md-4">';
            echo '<div class="form-group" >
                    <label > ' . __('Main color', 'lfb') . ' </label >
                    <input type="text" name="mainColor_primary" class="form-control colorpick" />
                </div>';
            echo '<div class="form-group" >
                    <label > ' . __('Secondary color', 'lfb') . ' </label >
                    <input type="text" name="mainColor_secondary" class="form-control colorpick" />
                </div>';
            echo '</div>'; // eof .col-md-4
            echo '<div class="col-md-4">';

            echo '<div class="form-group" >
                    <label > ' . __('Warning color', 'lfb') . ' </label >
                    <input type="text" name="mainColor_warning" class="form-control colorpick" />
                </div>';
            echo '<div class="form-group" >
                    <label > ' . __('Danger color', 'lfb') . ' </label >
                    <input type="text" name="mainColor_danger" class="form-control colorpick" />
                </div>';
            echo '</div>'; // eof .col-md-4
            echo '<div class="col-md-4">';
            echo '<div class="form-group" >
                    <label > ' . __('Login panel background color', 'lfb') . ' </label >
                    <input type="text" name="mainColor_loginPanelBg" class="form-control colorpick" />
                </div>';
            echo '<div class="form-group" >
                    <label > ' . __('Login panel text color', 'lfb') . ' </label >
                    <input type="text" name="mainColor_loginPanelTxt" class="form-control colorpick" />
                </div>';

            echo '</div>'; // eof .col-md-4
            echo '<div class="clearfix"></div>';
            echo '</div>'; // eof #lfb_tabColorsSettings

            echo '</div>';
            echo '</div>
                             
                            </div>
                             <div class="modal-footer">
                                <a href="javascript:" class="btn btn-primary" data-action="saveGlobalSettings"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->';
            echo '</div><!-- /.modal -->';

            echo '<div id="lfb_panelSettings">';
            echo '<div class="container-fluid lfb_container" >';

            echo '</div>'; // eof container
            echo '</div>'; // eof lfb_panelSettings

            echo '<div id="lfb_panelVariables">';
            echo '<div class="container-fluid lfb_container" >';
            echo '<div class="col-md-12">';

            echo '<p id="lfb_variablesToolbar">'
            . '<a href="javascript:" data-action="addNewVariable"  class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>' . __('Create a new variable', 'lfb') . '</a>'
            . '<a href="javascript:" data-action="returnToForm"  class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span>' . __('Return to the form', 'lfb') . '</a>'
            . '</p>';

            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#wpefc_variablesTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-th-list" ></span > ' . __('Variables', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="wpefc_variablesTabGeneral" >';
            echo '<div class="table-responsive" >';
            echo '<table id="lfb_variablesTable" class="table">';
            echo '<thead>';
            echo '<th>' . __('Name', 'lfb') . '</th>';
            echo '<th>' . __('Type', 'lfb') . '</th>';
            echo '<th>' . __('Default value', 'lfb') . '</th>';
            echo '<th class="lfb_actionTh">' . __('Actions', 'lfb') . '</th>';
            echo '</thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';
            echo '</div>'; // eof table-responsive

            echo '</div>'; // eof tab-content
            echo '</div>'; // eof wpefc_formsTabGeneral
            echo '</div>'; // eof tabpanel

            echo '</div>'; // eof col-md-12                     
            echo '</div>'; // eof container            
            echo '</div>'; // eof lfb_panelVariables


            echo '<div id="lfb_panelLogs">';
            echo '<div class="container-fluid lfb_container" >';
            echo '<div class="col-md-12">';

            echo '<p id="lfb_logsToolbar">'
            . '<a href="javascript:" data-action="refreshLogs"  class="btn btn-default"><span class="fa fa-sync-alt"></span>' . __('Refresh', 'lfb') . '</a>'
            . '<a href="javascript:" data-action="exportLogs" class="btn btn-default"><span class="glyphicon glyphicon-cloud-download"></span>' . __('Export as CSV', 'lfb') . '</a>'
            . '<a href="javascript:" data-action="openCharts"  class="btn btn-default"><span class="glyphicon glyphicon-stats"></span>' . __('View statistics', 'lfb') . '</a>'
            . '<a href="javascript:" data-action="returnToForm"  class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span>' . __('Return to the form', 'lfb') . '</a>'
            . '</p>';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#wpefc_formsTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-th-list" ></span > ' . __('Orders List', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="wpefc_formsTabGeneral" >';
            //  echo '<div class="table-responsive" >';
            echo '<table id="lfb_logsTable" class="table">';
            echo '<thead>';
            echo '<th></th>';
            echo '<th>' . __('Date', 'lfb') . '</th>';
            echo '<th>' . __('Reference', 'lfb') . '</th>';
            echo '<th>' . __('Name', 'lfb') . '</th>';
            echo '<th>' . __('Email', 'lfb') . '</th>';
            echo '<th>' . __('Verified payment', 'lfb') . '</th>';
            echo '<th>' . __('Total Subscription', 'lfb') . '</th>';
            echo '<th>' . __('Total', 'lfb') . '</th>';
            echo '<th>' . __('Status', 'lfb') . '</th>';
            echo '<th>' . __('Actions', 'lfb') . '</th>';
            echo '</thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';
            // echo '</div>'; // eof table-responsive
            echo '<p id="lfb_panelFooterBtns" style="">'
            . '<a href="javascript:" id="lfb_btnExportOrdersSelection" class="btn btn-default" onclick="lfb_exportOrdersSelection();"><span class="glyphicon glyphicon-cloud-download"></span>' . __('Export the selection', 'lfb') . '</a>'
            . '<a href="javascript:" id="lfb_btnDeleteOrdersSelection" class="btn btn-danger" onclick="lfb_deleteOrdersSelection();"><span class="glyphicon glyphicon-trash"></span>' . __('Delete the selection', 'lfb') . '</a>'
            . '</p>';

            echo '</div>'; // eof tab-content
            echo '</div>'; // eof wpefc_formsTabGeneral
            echo '</div>'; // eof tabpanel

            echo '</div>'; // eof col-md-12"
            echo '</div>'; // eof lfb_container

            echo '</div>'; // eof lfb_panelLogs



            echo '<div id="lfb_panelCharts">';
            echo '<div class="container-fluid lfb_container">';
            echo '<div class="col-md-12">';
            echo '<p style="float: right; margin-bottom:0px;">'
            . '<a href="javascript:"  onclick="lfb_loadLogs(jQuery(\'#lfb_panelCharts\').attr(\'data-formid\'));"  style="margin-right: 12px;"  class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span>' . __('View orders', 'lfb') . '</a>'
            . '<a href="javascript:" onclick="lfb_closeCharts();" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span>' . __('Return to the form', 'lfb') . '</a>'
            . '</p>';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_chartsTab" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-th-list" ></span > ' . __('Statistics', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_chartsTab" >';
            echo '<div id="lfb_chartsMenu">';
            echo '<div class="form-group">';
            echo '<label>' . __('Type of chart', 'lfb') . '</label>';
            echo '<select id="lfb_chartsTypeSelect" class="form-control">';
            echo '<option value="month">' . __('Month', 'lfb') . '</option>';
            echo '<option value="year" selected>' . __('Year', 'lfb') . '</option>';
            echo '<option value="all">' . __('All years', 'lfb') . '</option>';
            echo '</select>';
            echo '<select id="lfb_chartsMonth" class="form-control">';

            $table_name = $wpdb->prefix . "wpefc_logs";
            $logs = $wpdb->get_results("SELECT * FROM $table_name ORDER BY dateLog ASC LIMIT 1");
            $yearMin = date('Y');
            $monthMin = 1;
            $currentYear = date('Y');
            if (count($logs) > 0) {
                $log = $logs[0];
                $yearMin = substr($log->dateLog, 0, 4);
                $monthMin = substr($log->dateLog, 6, 2);
            }
            for ($a = $yearMin; $a <= $currentYear; $a++) {
                for ($i = 1; $i <= 12; $i++) {
                    $month = $i;
                    if ($month < 10) {
                        $month = '0' . $month;
                    }
                    $sel = '';
                    if ($month == date('m')) {
                        $sel = 'selected';
                    }
                    echo '<option value="' . $a . '-' . $month . '" ' . $sel . '>' . $a . '-' . $month . '</option>';
                }
                $monthMin = 1;
            }
            echo '</select>';
            echo '<select id="lfb_chartsYear" class="form-control">';


            $table_name = $wpdb->prefix . "wpefc_logs";
            $logs = $wpdb->get_results("SELECT * FROM $table_name ORDER BY dateLog ASC LIMIT 1");
            $yearMin = date('Y');
            $currentYear = date('Y');
            if (count($logs) > 0) {
                $log = $logs[0];
                $yearMin = substr($log->dateLog, 0, 4);
            }
            for ($i = $yearMin; $i <= $currentYear; $i++) {
                $sel = '';
                if ($i == $currentYear) {
                    $sel = 'selected';
                }
                echo '<option value="' . $i . '" ' . $sel . '>' . $i . '</option>';
            }
            echo '</select>';
            echo '</div>';

            echo '</div>'; // eof lfb_chartsMenu
            echo '<div id="lfb_charts"></div>';

            echo '</div>'; // eof tab-content
            echo '</div>'; // eof wpefc_formsTabGeneral
            echo '</div>'; // eof tabpanel

            echo '</div>'; // eof col-md-12"
            echo '</div>'; // eof lfb_container
            echo '</div>'; // eof lfb_panelCharts


            echo '<div class="clearfix"></div>';

            echo '<div id="lfb_panelFormsList">';
            echo '<div class="container-fluid lfb_container"';
            echo '<div class="col-md-12">';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#wpefc_formsTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-th-list" ></span > ' . __('Forms List', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="wpefc_formsTabGeneral" style="margin-top:0px; display: block !important;" >';

            echo '<p style="text-align: right;">
            <a href="javascript:" style="margin-right: 12px;" onclick="lfb_addForm();" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>' . __('Add a new Form', 'lfb') . ' </a>
            <a href="javascript:" style="margin-right: 12px;" onclick=" jQuery(\'#lfb_winImport\').modal(\'show\');" class="btn btn-warning"><span class="glyphicon glyphicon-import"></span>' . __('Import forms', 'lfb') . ' </a>
            <a href="javascript:" onclick="lfb_exportForms();" class="btn btn-default"><span class="glyphicon glyphicon-export"></span>' . __('Export all forms', 'lfb') . ' </a>
         </p>';
            echo '<table class="table">';
            echo '<thead>';
            echo '<th>' . __('Form title', 'lfb') . '</th>';
            echo '<th>' . __('Shortcode', 'lfb') . '</th>';
            echo '<th  style="width: 368px;">' . __('Actions', 'lfb') . '</th>';
            echo '</thead>';
            echo '<tbody>';
            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
            foreach ($forms as $form) {
                echo '<tr data-formid="' . $form->id . '">';
                echo '<td><a href="javascript:" class="lfb_formListTitle" onclick="lfb_loadForm(' . $form->id . ');">' . $form->title . '</a></td>';
                echo '<td><a href="javascript:" onclick="lfb_showShortcodeWin(' . $form->id . ');" class="btn btn-info btn-circle "><span class="glyphicon glyphicon-info-sign"></span></a><code>[estimation_form form_id="' . $form->id . '"]</code></td>';
                echo '<td>';
                echo '<a href="javascript:" onclick="lfb_loadForm(' . $form->id . ');" class="btn btn-primary btn-circle " data-toggle="tooltip" title="' . __('Edit this form', 'lfb') . '" data-placement="bottom"><span class="glyphicon glyphicon-pencil"></span></a>';
                echo '<a href="javascript:" onclick="lfb_openFormPreview(' . $form->id . ');" class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('Preview this form', 'lfb') . '" data-placement="bottom"><span class="glyphicon glyphicon-eye-open"></span></a>';
                echo '<a href="javascript:" onclick="lfb_loadLogs(' . $form->id . ');" class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('View orders', 'lfb') . '" data-placement="bottom"><span class="glyphicon glyphicon-list-alt"></span></a>';
                echo '<a href="javascript:"  onclick="lfb_openCharts(' . $form->id . ');"  class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('View statistics', 'lfb') . '" data-placement="bottom"><span class="glyphicon glyphicon-stats"></span></a>';
                echo '<a href="javascript:" onclick="lfb_duplicateForm(' . $form->id . ');" class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('Duplicate this form', 'lfb') . '" data-placement="bottom"><span class="glyphicon glyphicon-duplicate"></span></a>';
                echo '<a href="javascript:" onclick="lfb_data.designForm=' . $form->id . ';lfb_loadForm(' . $form->id . ');" class="btn btn-default btn-circle " data-toggle="tooltip" title="' . __('Form Designer', 'lfb') . '" data-placement="bottom"><span class="fa fa-magic"></span></a>';

                echo '<a href="javascript:" onclick="lfb_askDeleteForm(' . $form->id . ');" class="btn btn-danger btn-circle " data-toggle="tooltip" title="' . __('Delete this form', 'lfb') . '" data-placement="bottom"><span class="glyphicon glyphicon-trash"></span></a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';

            echo '</div>'; // eof tab-content
            echo '</div>'; // eof wpefc_formsTabGeneral
            echo '</div>'; // eof tabpanel


            echo '</div>'; // eof col-md-12
            echo '</div>'; // eof container
            echo '</div>'; // eof lfb_panelFormsList


            echo '<div id="lfb_customerDetailsPanel">';
            echo '<div class="container-fluid lfb_container">';
            echo '<div class="col-md-12">';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_customersDetails" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-th-list" ></span > ' . __('Customer details', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_customersDetails" style="margin-top:0px;" >';

            echo '<div class="container-fluid">';

            echo '<div class="col-md-12"><h6>' . __('Customer information', 'lfb') . '</h6></div>';

            echo '<div class="col-md-3">';

            echo '<div class="form-group">'
            . '<label>' . __('First name', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user-tie"></i></span>
                     <input type="text" name="firstName" class="form-control " tabindex="0"/>
                  </div>
              </div>'; // eof form-group  

            echo '<div class="form-group">'
            . '<label>' . __('Email', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                     <input type="text" name="email" class="form-control "  tabindex="4"/>
                  </div>
              </div>'; // eof form-group  

            echo '<div class="form-group">'
            . '<label>' . __('Address', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-map-marker-alt"></i></span>
                     <input type="text" name="address" class="form-control "  tabindex="8"/>
                  </div>
              </div>'; // eof form-group  


            echo '<div class="form-group">'
            . '<label>' . __('State', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-map-marked-alt"></i></span>
                     <input type="text" name="state" class="form-control "  tabindex="12"/>
                  </div>
              </div>'; // eof form-group  


            echo '</div>'; // eof col-md-3

            echo '<div class="col-md-3">';

            echo '<div class="form-group">'
            . '<label>' . __('Last name', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user-tie"></i></span>
                     <input type="text" name="lastName" class="form-control "  tabindex="1"/>
                  </div>
              </div>'; // eof form-group  


            echo '<div class="form-group">'
            . '<label>' . __('Phone', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-phone"></i></span>
                     <input type="tel" name="phone" class="form-control "  tabindex="5"/>
                  </div>
              </div>'; // eof form-group  

            echo '<div class="form-group">'
            . '<label>' . __('Zip code', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-map-marked-alt"></i>   </span>
                     <input type="text" name="zip" class="form-control "  tabindex="9"/>
                  </div>
              </div>'; // eof form-group  

            echo '<div class="form-group">'
            . '<label>' . __('Inscription', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                     <input type="text" name="inscriptionDate" class="form-control " readonly="true" tabindex="99"/>
                  </div>
              </div>'; // eof form-group  

            echo '</div>'; // eof col-md-3

            echo '<div class="col-md-3">';


            echo '<div class="form-group">'
            . '<label>' . __('Company', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-building"></i></span>
                     <input type="text" name="company" class="form-control " tabindex="2"/>
                  </div>
              </div>'; // eof form-group  


            echo '<div class="form-group">'
            . '<label>' . __('Job phone', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-phone"></i></span>
                     <input type="tel" name="phoneJob" class="form-control "  tabindex="6"/>
                  </div>
              </div>'; // eof form-group  



            echo '<div class="form-group">'
            . '<label>' . __('City', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-city"></i></span>
                     <input type="text" name="city" class="form-control "  tabindex="10"/>
                  </div>
              </div>'; // eof form-group  



            echo '</div>'; // eof col-md-3

            echo '<div class="col-md-3">';

            echo '<div class="form-group">'
            . '<label>' . __('Job', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-briefcase"></i></span>
                     <input type="text" name="job" class="form-control "  tabindex="3"/>
                  </div>
              </div>'; // eof form-group  

            echo '<div class="form-group">'
            . '<label>' . __('Website', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-link"></i></span>
                     <input type="url" name="url" class="form-control "  tabindex="7"/>
                  </div>
              </div>'; // eof form-group  

            echo '<div class="form-group">'
            . '<label>' . __('Country', 'lfb') . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-flag"></i></span>
                     <input type="text" name="country" class="form-control "  tabindex="11"/>
                  </div>
              </div>'; // eof form-group  



            echo '</div>'; // eof col-md-3
            echo '<div class="clearfix"></div>';
            echo '<p id="lfb_customerDetailsBtns" class="text-center"><a href="javascript:" data-action="saveCustomer" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a></p>';

            echo '<div class="col-md-12"><h6>' . __('Past orders', 'lfb') . '</h6></div>';
            echo '<div id="lfb_customerOrders" class="col-md-12">';

            echo '<table id="lfb_customerOrdersTable" class="table">';
            echo '<thead>';
            echo '<th>' . __('Date', 'lfb') . '</th>';
            echo '<th>' . __('Reference', 'lfb') . '</th>';
            echo '<th>' . __('Verified payment', 'lfb') . '</th>';
            echo '<th>' . __('Total', 'lfb') . '</th>';
            echo '<th>' . __('Subscription total', 'lfb') . '</th>';
            echo '<th>' . __('Order status', 'lfb') . '</th>';
            echo '<th class="lfb_actionTh">' . __('Actions', 'lfb') . '</th>';
            echo '</thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';
            echo '<div class="clearfix"></div>';

            echo '</div>';
            echo '<div class="clearfix"></div>';
            echo '</div>'; // eof container-fluid


            echo '</div>'; // eof tab-content
            echo '</div>'; // eof lfb_customersDetails
            echo '</div>'; // eof tabpanel

            echo '</div>'; // eof col-md-12
            echo '</div>'; // eof container
            echo '</div>'; // eof lfb_customerDetailsPanel            



            echo '<div id="lfb_customersPanel">';
            echo '<div class="container-fluid lfb_container">';
            echo '<div class="col-md-12">';
            echo '<p id="lfb_logsToolbar">
            <a href="javascript:" data-action="exportCustomersCsv" class="btn btn-default"><span class="glyphicon glyphicon-cloud-download"></span>' . __('Export as CSV', 'lfb') . ' </a>
            <a href="javascript:" data-action="addCustomer" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>' . __('Add a new customer', 'lfb') . ' </a>
              </p>';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_customersList" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-th-list" ></span > ' . __('Customers List', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_customersList" style="margin-top:0px;" >';


            echo '<table class="table" id="lfb_customersTable">';
            echo '<thead>';
            echo '<th>' . __('Email', 'lfb') . '</th>';
            echo '<th>' . __('Name', 'lfb') . '</th>';
            echo '<th>' . __('Phone', 'lfb') . '</th>';
            echo '<th>' . __('Last order', 'lfb') . '</th>';
            echo '<th>' . __('Inscription', 'lfb') . '</th>';
            echo '<th  class="lfb_actionTh">' . __('Actions', 'lfb') . '</th>';
            echo '</thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';
            echo '<div class="clearfix"></div>';
            echo '</div>'; // eof tab-content
            echo '</div>'; // eof lfb_customersList
            echo '</div>'; // eof tabpanel

            echo '</div>'; // eof col-md-12
            echo '</div>'; // eof container
            echo '</div>'; // eof lfb_customersPanel
            //   echo '</div>'; 

            echo '<div id="lfb_panelPreview">';
            echo '<div class="clearfix"></div>';
            $tdgnAction = 'lfb_openFormDesigner();';

            echo '<div id="lfb_formTopbtns">
                <p class="text-right">
                 <a href="javascript:" data-action="addFormStep"  class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>' . __("Add a step", 'lfb') . '</a>
                <a href="javascript:" data-action="previewForm" id="lfb_btnPreview"  class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span>' . __("View the form", 'lfb') . '</a>
                <a href="javascript:" data-action="shortcodesInfos"   class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span>' . __('Shortcode', 'lfb') . '</a>
                <a href="javascript:"  data-action="viewFormLogs" id="lfb_logsBtn" data-formid="0"   class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span>' . __('View orders', 'lfb') . '</a>
                <a href="javascript:" data-action="viewFormCharts" id="lfb_chartsBtn" data-formid="0"   class="btn btn-default"><span class="glyphicon glyphicon-stats"></span>' . __('View statistics', 'lfb') . '</a>
                <a href="javascript:"  data-action="viewFormVariables" id="lfb_variablesBtn" data-formid="0"  class="btn btn-default"><span class="fas fa-calculator"></span>' . __('Variables', 'lfb') . '</a>';

            if ($settings->purchaseCode != "" || !get_option('lfb_themeMode')) {
                echo '<a href="javascript:" id="lfb_formDesignerBtn" data-formid="0" onclick="' . $tdgnAction . '"  style="margin-left: 12px;"  class="btn btn-default"><span class="fa fa-magic"></span>' . __('Form Designer', 'lfb') . '</a>';
            }
            echo '<a href="javascript:" style="margin-left: 12px;"  data-toggle="modal" data-target="#modal_removeAllSteps" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>' . __("Remove all steps", 'lfb') . '</a>
                </p>
                <div class="clearfix"></div>
            </div>
        ';



            echo '
        <!-- Modal -->
        <div class="modal fade" id="modal_removeAllSteps" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">' . __('Remove all steps', 'lfb') . '</h4>
              </div>
              <div class="modal-body">
                ' . __('Are you sure you want to delete all steps ?', 'lfb') . '
              </div>
              <div class="modal-footer">
                <a href="javascript:" class="btn btn-default" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span>' . __('No', 'lfb') . '</a>
                <a href="javascript:" class="btn btn-danger" data-dismiss="modal"  onclick="lfb_removeAllSteps();" ><span class="glyphicon glyphicon-trash"></span>' . __('Yes', 'lfb') . '</a>
              </div>
            </div>
          </div>
        </div>';

            echo '<div id="lfb_stepsManagerHeader"><span class="fa fa-eye"></span>' . __('Steps manager', 'lfb') . '</div>';
            echo '<div id="lfb_stepsOverflow">';
            echo '<div id="lfb_stepsContainer">';
            echo '<canvas id="lfb_stepsCanvas"></canvas>';
            echo '</div>';
            echo '</div>';


            echo '<div id="lfb_formFields" style="max-width: 90%;margin: 0 auto;margin-top: 18px;" >              
            <div role="tabpanel" >
              <!--Nav tabs-->
              <ul class="nav nav-tabs responsive" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_tabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('General', 'lfb') . ' </a ></li >
                <li role="presentation" ><a href="#lfb_tabTexts" aria-controls="texts" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-edit" ></span > ' . __('Texts', 'lfb') . ' </a ></li >
                <li role="presentation" ><a href="#lfb_tabEmail" onclick="lfb_openEmailTab();" aria-controls="email" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-envelope" ></span > ' . __('Email', 'lfb') . ' </a ></li >
                <li role="presentation" ><a href="#lfb_tabLastStep" aria-controls="last step" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-list" ></span > ' . __('Last Step', 'lfb') . ' </a ></li >
                <li role="presentation" ><a href="#lfb_tabPayment" aria-controls="payment" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-credit-card" ></span > ' . __('Payment', 'lfb') . ' </a ></li >
                <li role="presentation" ><a href="#lfb_tabSummary" aria-controls="summary" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-shopping-cart" ></span > ' . __('Summary', 'lfb') . ' </a ></li >
                <li role="presentation" ><a href="#lfb_tabCoupons" aria-controls="coupons" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-gift" ></span > ' . __('Discount coupons', 'lfb') . ' </a ></li >
                <li role="presentation" ><a href="#lfb_tabGDPR" aria-controls="coupons" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-lock" ></span > ' . __('GDPR', 'lfb') . ' </a ></li >
                <li role="presentation" ><a href="#lfb_tabDesign" onclick="setTimeout(function(){lfb_editorCustomCSS.refresh();},100);" aria-controls="design" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-tint" ></span > ' . __('Design', 'lfb') . ' </a ></li >
                <!--<li role="presentation" ><a href="javascript:" onclick="lfb_openFormDesigner();"  ><span class="fa fa-magic" ></span > ' . __('Form Designer', 'lfb') . ' </a ></li >-->

</ul >

              <!--Tab panes-->
              <div class="tab-content responsive" >
                <div  class="tab-pane active" id="lfb_tabGeneral" >
                    <div class="row-fluid" >
                        <div class="col-md-6" >
                         <div class="form-group" >
                                <label > ' . __('Title', 'lfb') . ' </label >
                                <input type="text" name="title" class="form-control" />
                                <small> ' . __('The form title', 'lfb') . ' </small>
                            </div>
                        <div class="form-group" >
                                <label > ' . __('Order reference prefix', 'lfb') . ' </label >
                                <input type="text" name="ref_root" class="form-control" />
                                <small> ' . __('Enter a prefix for the order reference', 'lfb') . ' </small>
                                 <a href="javascript:" id="lfb_btnResetRef" onclick="lfb_resetReference();" data-toggle="tooltip" title="' . __('Reset the index to 0', 'lfb') . '"  class="btn btn-default btn-circle"><span class="glyphicon glyphicon-refresh"></span></a>

                            </div>
                            <div class="form-group" >
                                <label > ' . __('Google Analytics ID', 'lfb') . ' </label >
                                <input type="text" name="analyticsID" class="form-control" />
                                <small> ' . __('By filling this field, you can track user actions in your form', 'lfb') . ' </small>
                                <a href="https://support.google.com/analytics/answer/1032385?hl=en" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-info-sign"></span></a>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Google Maps browser key', 'lfb') . ' </label >
                                <input type="text" name="gmap_key" class="form-control" />
                                <small> ' . __('By filling this field, you can use distance calculations', 'lfb') . ' </small>
                                <a href="https://developers.google.com/maps/documentation/javascript/get-api-key?hl=en" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-info-sign"></span></a>
                            </div>
                            
                           <div class="form-group" >
                                <label > ' . __('Distances calculation mode', 'lfb') . ' </label >
                                <select  name="distancesMode" class="form-control" />
                                    <option value="route" > ' . __('Route', 'lfb') . ' </option >
                                    <option value="direct" > ' . __('Direct', 'lfb') . ' </option >
                                </select >
                                <small> ' . __('The progress bar can show the price or step number', 'lfb') . ' </small>
                            </div>     
                            <div class="form-group" >
                                <label > ' . __('Progress bar', 'lfb') . ' </label >
                                <select  name="showSteps" class="form-control" />
                                    <option value="0" > ' . __('Price', 'lfb') . ' </option>
                                    <option value="1" > ' . __('Step number', 'lfb') . ' </option>
                                    <option value="3" > ' . __('All steps', 'lfb') . ' </option>
                                    <option value="2" > ' . __('No progress bar', 'lfb') . ' </option>
                                </select >
                                <small> ' . __('The progress bar can show the price or step number', 'lfb') . ' </small>
                            </div>                            
                            
                           
                            
                            <div class="form-group" >
                                <label > ' . __('Currency', 'lfb') . ' </label >
                                <input type="text"  name="currency" class="form-control" />
                                <small> ' . __('$, € , £ ...', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Currency Position', 'lfb') . ' </label >
                                <select  name="currencyPosition" class="form-control" />
                                    <option value="right" > ' . __('Right', 'lfb') . ' </option >
                                    <option value="left" > ' . __('Left', 'lfb') . ' </option >
                                </select >
                                <small> ' . __('Sets the currency position in the price', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Ajax navigation support', 'lfb') . ' </label >
                                <input type="checkbox"  name="loadAllPages" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __('Activate this option if your theme uses ajax navigation to display pages', 'lfb') . ' </small>
                            </div>             
                                                  
                            <div class="form-group" >
                                <label > ' . __('Disable steps manager links animation', 'lfb') . ' </label >
                                <input type="checkbox"  name="disableLinksAnim" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __('Activate this option if the backend encounters slowdowns', 'lfb') . ' </small>
                            </div>                               

                            
                            <div class="form-group" >
                                <label > ' . __('Custom JS', 'lfb') . ' </label >                               
                               <textarea name="customJS" class="form-control" ></textarea>
                                <small> ' . __('You can paste your own js code here', 'lfb') . ' </small>
                            </div>
                        </div>
                        <div class="col-md-6" >                            
                             <div class="form-group" >
                                <label > ' . __('Initial price', 'lfb') . ' </label >
                                <input type="number" step="any" name="initial_price" class="form-control" />
                                <small> ' . __('Starting price', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Maximum progress bar price', 'lfb') . ' </label >
                                <input type="number" step="any"  name="max_price" class="form-control" />
                                <small> ' . __('Leave blank for automatic calculation', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Hide initial price in the progress bar ? ', 'lfb') . ' </label >
                                <input type="checkbox"  name="show_initialPrice" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"class=""   />
                                <small> ' . __('Display or hide the initial price from progress bar', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label> ' . __('Hide tooltips on touch devices', 'lfb') . ' </label >
                                <input type="checkbox"  name="disableTipMobile" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                
                            </div>
                            
                            <div class="form-group" >
                                <label > ' . __('Automatic next step', 'lfb') . ' </label >
                                <input type="checkbox"  name="groupAutoClick" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __('Automatically go to the next step when selecting if only one product is selectable and step is required', 'lfb') . ' </small>
                            </div>         
                            <div class="form-group" >
                                <label > ' . __('Datepicker language', 'lfb') . ' </label >
                                <select  name="datepickerLang" class="form-control" />
                                    <option value="">en</option >
                                    <option value="ar">ar</option >
                                    <option value="az">az</option >
                                    <option value="bg">bg</option >
                                    <option value="bn">bn</option >
                                    <option value="ca">ca</option >
                                    <option value="cs">cs</option >
                                    <option value="da">da</option >
                                    <option value="de">de</option >
                                    <option value="ee">ee</option >
                                    <option value="el">el</option >
                                    <option value="es">es</option >
                                    <option value="fi">fi</option >
                                    <option value="fr">fr</option >
                                    <option value="he">he</option >
                                    <option value="hr">hr</option >
                                    <option value="hu">hu</option >
                                    <option value="hy">hy</option >
                                    <option value="id">id</option >
                                    <option value="is">is</option >
                                    <option value="it">it</option >
                                    <option value="ja">ja</option >
                                    <option value="ka">ka</option >
                                    <option value="ko">ko</option >
                                    <option value="lt">lt</option >
                                    <option value="lv">lv</option >
                                    <option value="ms">ms</option >
                                    <option value="nb">nb</option >
                                    <option value="nl">nl</option >
                                    <option value="no">no</option >
                                    <option value="pl">pl</option >
                                    <option value="pt">pt</option >
                                    <option value="ro">ro</option >
                                    <option value="rs">rs</option >
                                    <option value="rs-latin">latin</option >
                                    <option value="ru">ru</option >
                                    <option value="sk">sk</option >
                                    <option value="sl">sl</option >
                                    <option value="sv">sv</option >
                                    <option value="sw">sw</option >
                                    <option value="th">th</option >
                                    <option value="tr">tr</option >
                                    <option value="ua">ua</option >
                                    <option value="uk">uk</option >
                                    <option value="zh-CN">zh-CN</option >
                                    <option value="zh-TW">zh-TW</option >
                                </select >
                                <small> ' . __('Select your language code', 'lfb') . ' </small>
                            </div>                            
                            
                            <div class="form-group" >
                                <label > ' . __('Use 12 hours time mode ?', 'lfb') . ' </label >
                                <input type="checkbox"  name="timeModeAM" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"class=""   />
                                <small> ' . __('Disable it to use 24 hours time mode on time pickers', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Decimals separator', 'lfb') . ' </label >
                                <input type="text"  name="decimalsSeparator" class="form-control" />
                                <small> ' . __('Enter a separator or leave empty', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Thousands separator', 'lfb') . ' </label >
                                <input type="text"  name="thousandsSeparator" class="form-control" />
                                <small> ' . __('Enter a separator or leave empty', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Millions separator', 'lfb') . ' </label >
                                <input type="text"  name="millionSeparator" class="form-control" />
                                <small> ' . __('Enter a separator or leave empty', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Billions separator', 'lfb') . ' </label >
                                <input type="text"  name="billionsSeparator" class="form-control" />
                                <small> ' . __('Enter a separator or leave empty', 'lfb') . ' </small>
                            </div>
                                                  
                            <div class="form-group" >
                                <label > ' . __('Add a button "Save form to finish later"', 'lfb') . ' </label >
                                <input type="checkbox"  name="enableSaveForLaterBtn" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __('Activate this option to allow the users to save their current selection to finish later', 'lfb') . ' </small>
                            </div>
                            
                                <div class="form-group" >
                                    <label > ' . __('Default order status', 'lfb') . ' </label >
                                    <select name="defaultStatus" class="form-control" />
                                        <option value="canceled">' . __('Canceled', 'lfb') . '</option>
                                        <option value="pending">' . __('Pending', 'lfb') . '</option>
                                        <option value="beingProcessed">' . __('Being processed', 'lfb') . '</option>
                                        <option value="shipped">' . __('Shipped', 'lfb') . '</option>                                            
                                        <option value="completed">' . __('Completed', 'lfb') . '</option>
                                    </select>
                                </div>';



            echo' <div class="form-group" >
                                    <label> ' . __('Save for later button icon', 'lfb') . ' </label>
           <input type="text" class="form-control" name="saveForLaterIcon"  data-iconfield="1" />
           <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank"  class="btn btn-default btn-circle"><span class="glyphicon glyphicon-search"></span></a>
        </div>';

            echo' </div>
                    </div>
                    <div class="clearfix" ></div>
                </div>

                <div role="tabpanel" class="tab-pane" id="lfb_tabTexts" >
                    <div class="row-fluid" >
                        <div class="col-md-4" >
                            <h4 > ' . __('General', 'lfb') . ' </h4 >                           
                            <div class="form-group" >
                                <label > ' . __('Selection required', 'lfb') . ' </label >
                                <input type="text" name="errorMessage" class="form-control" />
                                <small> ' . __('Something like "You need to select an item to continue"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Button "next step"', 'lfb') . ' </label >
                                <input type="text" name="btn_step" class="form-control" />
                                <small> ' . __('Something like "NEXT STEP"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Link "previous step"', 'lfb') . ' </label >
                                <input type="text" name="previous_step" class="form-control" />
                                <small> ' . __('Something like "return to previous step"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Label "Description"', 'lfb') . ' </label >
                                <input type="text" name="summary_description" class="form-control" />
                                <small> ' . __('Something like "Description"', 'lfb') . ' </small>
                            </div>                             
                            <div class="form-group" >
                                <label > ' . __('Label "Quantity"', 'lfb') . ' </label >
                                <input type="text" name="summary_quantity" class="form-control" />
                                <small> ' . __('Something like "Quantity"', 'lfb') . ' </small>
                            </div>                             
                            <div class="form-group" >
                                <label > ' . __('Label "Information"', 'lfb') . ' </label >
                                <input type="text" name="summary_value" class="form-control" />
                                <small> ' . __('Something like "Information"', 'lfb') . ' </small>
                            </div>                                   
                            <div class="form-group" >
                                <label > ' . __('Label "Price"', 'lfb') . ' </label >
                                <input type="text" name="summary_price" class="form-control" />
                                <small> ' . __('Something like "Price"', 'lfb') . ' </small>
                            </div>                  
                            <div class="form-group" >
                                <label > ' . __('Label "Total"', 'lfb') . ' </label >
                                <input type="text" name="summary_total" class="form-control" />
                                <small> ' . __('Something like "Total :"', 'lfb') . ' </small>
                            </div>        
                            <div class="form-group" >
                                <label > ' . __('Label "Discount"', 'lfb') . ' </label >
                                <input type="text" name="summary_discount" class="form-control" />
                                <small> ' . __('Something like "Discount :"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Label of files fields', 'lfb') . ' </label >
                                <input type="text" name="filesUpload_text" class="form-control" />
                                <small> ' . __('Something like "Drop files here to upload"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Size error for files fields', 'lfb') . ' </label >
                                <input type="text" name="filesUploadSize_text" class="form-control" />
                                <small> ' . __('Something like "File is too big (max size: {{maxFilesize}}MB)"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('File type error for files fields', 'lfb') . ' </label >
                                <input type="text" name="filesUploadType_text" class="form-control" />
                                <small> ' . __('Something like "Invalid file type"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Limit error for files fields', 'lfb') . ' </label >
                                <input type="text" name="filesUploadLimit_text" class="form-control" />
                                <small> ' . __('Something like "You can not upload any more files"', 'lfb') . ' </small>
                            </div>   
                            <div class="form-group" >
                                <label > ' . __('Distance calculation error', 'lfb') . ' </label >
                                <input type="text" name="txtDistanceError" class="form-control" />
                                <small> ' . __('Something like "Calculating the distance could not be performed, please verify the input addresses"', 'lfb') . ' </small>
                            </div>   
                            
                            
                            
                        </div>
                        <div class="col-md-4" >
                        <h4>&nbsp;</h4>
                        <div class="form-group" >
                                <label > ' . __('Label "Between"', 'lfb') . ' </label >
                                <input type="text" name="labelRangeBetween" class="form-control" />
                                <small> ' . __('Something like "between"', 'lfb') . ' </small>
                            </div>   
                            <div class="form-group" >
                                <label > ' . __('Label "And"', 'lfb') . ' </label >
                                <input type="text" name="labelRangeAnd" class="form-control" />
                                <small> ' . __('Something like "and"', 'lfb') . ' </small>
                            </div>   
                            <div class="form-group" >
                                <label > ' . __('Invoice', 'lfb') . ' </label >
                                <input type="text" name="txt_invoice" class="form-control" />
                            </div>  
                            <div class="form-group" >
                                <label > ' . __('Quotation', 'lfb') . ' </label >
                                <input type="text" name="txt_quotation" class="form-control" />
                            </div>     
                            <div class="form-group" >
                                <label > ' . __('Save for later', 'lfb') . ' </label >
                                <input type="text" name="saveForLaterLabel" class="form-control" />
                            </div>       
                              
                            <div class="form-group" >
                                <label > ' . __('Delete the backup', 'lfb') . ' </label >
                                <input type="text" name="saveForLaterDelLabel" class="form-control" />
                            </div> 
                            <div class="form-group" >
                                <label > ' . __('Field "Activation code"', 'lfb') . ' </label >
                                <input type="text" name="txt_emailActivationCode" class="form-control" />
                            </div> 
                            <div class="form-group" >
                                <label > ' . __('Email verification info', 'lfb') . ' </label >
                                <input type="text" name="txt_emailActivationInfo" class="form-control" />
                            </div> 
                            
                            <h4> ' . __('Email', 'lfb') . ' </h4>                                   
                             <div class="form-group" >
                                <label > ' . __('Text of the payment link', 'lfb') . ' </label >
                                <input type="text" name="enableEmailPaymentText" class="form-control" />
                                <small> ' . __('Something like "I validate this order and proceed to the payment"', 'lfb') . ' </small>
                            </div>    
                            
<h4> ' . __('Stripe payment', 'lfb') . ' </h4>             
                             <div class="form-group" >
                                <label > ' . __('Stripe payment modal title', 'lfb') . ' </label >
                                <input type="text" name="txt_stripe_title" class="form-control" />
                                <small> ' . __('Something like "Make a payment"', 'lfb') . ' </small>
                            </div>                                   
                             <div class="form-group" >
                                <label > ' . __('Label of the payment button', 'lfb') . ' </label >
                                <input type="text" name="txt_stripe_btnPay" class="form-control" />
                                <small> ' . __('Something like "Pay now"', 'lfb') . ' </small>
                            </div>                               
                             <div class="form-group" >
                                <label > ' . __('Label of the total amount', 'lfb') . ' </label >
                                <input type="text" name="txt_stripe_totalTxt" class="form-control" />
                                <small> ' . __('Something like "Total to pay"', 'lfb') . ' </small>
                            </div>                       
                             <div class="form-group" >
                                <label > ' . __('Label of the card owner field', 'lfb') . ' </label >
                                <input type="text" name="txt_stripe_cardOwnerLabel" class="form-control" />
                                <small> ' . __('Something like "Card owner name"', 'lfb') . ' </small>
                            </div>          
                             <div class="form-group" >
                                <label > ' . __('Error of payment title', 'lfb') . ' </label >
                                <input type="text" name="txt_stripe_paymentFail" class="form-control" />
                                <small> ' . __('Something like "Payment could not be made"', 'lfb') . ' </small>
                            </div>    
                           
                            
                        </div>
                        <div class="col-md-4" >
                         <h4 > ' . __('Introduction', 'lfb') . ' </h4 >
                            <div class="form-group" >
                                <label> ' . __('Enable Introduction ? ', 'lfb') . ' </label >
                                <input type="checkbox"  name="intro_enabled" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                <small> ' . __('Is Introduction enabled ? ', 'lfb') . ' </small>
                            </div>
                             <div class="form-group" >
                                <label > ' . __('Introduction title', 'lfb') . ' </label >
                                <input type="text" name="intro_title" class="form-control" />
                                <small> ' . __('Something like "HOW MUCH TO MAKE MY WEBSITE ?"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Introduction text', 'lfb') . ' </label >
                                <input type="text" name="intro_text" class="form-control" />
                                <small> ' . __('Something like "Estimate the cost of a website easily using this awesome tool."', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Introduction image', 'lfb') . ' </label >
                                <input type="text" name="intro_image" class="form-control" style="width: 226px;" />
                                <a href="javascript:" class="imageBtn btn btn-default btn-circle" style=" display: inline-block;" ><span class="glyphicon glyphicon-cloud-upload"></span></a>
                                <small> ' . __('This image will be displayed above the title"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Introduction button', 'lfb') . ' </label >
                                <input type="text" name="intro_btn" class="form-control" />
                                <small> ' . __('Something like "GET STARTED"', 'lfb') . ' </small>
                            </div>';

            echo' <div class="form-group" >
                                    <label> ' . __('Introduction button icon', 'lfb') . ' </label>
           <input type="text" class="form-control" name="introButtonIcon" placeholder="fa fa-rocket" data-iconfield="1" style="width: 226px;" />
           <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" style="margin-left: 8px;" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-search"></span></a>
        </div>';


            echo' <h4> ' . __('Last Step', 'lfb') . ' </h4>
                             <div class="form-group" >
                                <label > ' . __('Last step title', 'lfb') . ' </label >
                                <input type="text" name="last_title" class="form-control" />
                                <small> ' . __('Something like "Final cost", "Result" ...', 'lfb') . ' </small>
                            </div>
                             <div class="form-group" >
                                <label > ' . __('Last step text', 'lfb') . ' </label >
                                <input type="text" name="last_text" class="form-control" />
                                <small> ' . __('Something like "The final estimated price is :"', 'lfb') . ' </small>
                            </div>
                             <div class="form-group" >
                                <label > ' . __('Last step button', 'lfb') . ' </label >
                                <input type="text" name="last_btn" class="form-control" />
                                <small> ' . __('Something like "ORDER MY WEBSITE"', 'lfb') . ' </small>
                            </div>
                             <div class="form-group" >
                                <label > ' . __('Succeed text', 'lfb') . ' </label >
                                <input type="text" name="succeed_text" class="form-control" />
                                <small> ' . __('Something like "Thanks, we will contact you soon"', 'lfb') . ' </small>
                            </div>                             
                            <div class="form-group" >
                                <label > ' . __('Final text for deferred payment', 'lfb') . ' </label >
                                <input type="text" name="txt_payFormFinalTxt" class="form-control" />
                            </div>                            
                            <div class="form-group" >
                                <label > ' . __('Button for Paypal payment', 'lfb') . ' </label >
                                <input type="text" name="txt_btnPaypal" class="form-control" />
                            </div>                   
                            <div class="form-group" >
                                <label > ' . __('Button for Stripe payment', 'lfb') . ' </label >
                                <input type="text" name="txt_btnStripe" class="form-control" />
                            </div>                     
                            <div class="form-group" >
                                <label > ' . __('Forgotten password link', 'lfb') . ' </label >
                                <input type="text" name="txtForgotPassLink" class="form-control" />
                            </div>                  
                            <div class="form-group" >
                                <label > ' . __('Password sent confirmation', 'lfb') . ' </label >
                                <input type="text" name="txtForgotPassSent" class="form-control" />
                            </div>       
                            <div class="form-group">
                                <label>' . __('Signature text', 'lfb') . '</label>
                                 <input type="text" class="form-control" name="txtSignature"/>
                            </div>      

                            
                        </div>
                        
                    </div>
                    <div class="clearfix" ></div>
                </div>

                <div role="tabpanel" class="tab-pane" id="lfb_tabEmail" >
                    <div class="row-fluid" >
                        <div class="col-md-6" >
                            <h4> ' . __('Admin email', 'lfb') . ' </h4 >
                            <div class="form-group" >
                                <label > ' . __('Admin email', 'lfb') . ' </label >
                                <input type="text" name="email" class="form-control" />
                                <small> ' . __('Email that will receive requests', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Sender name', 'lfb') . ' </label >
                                <input type="text" name="email_name" class="form-control" />
                                <small> ' . __('Freely change the email sender name', 'lfb') . ' </small>
                            </div>
                            
                             <div class="form-group" >
                                <label > ' . __('Admin email subject', 'lfb') . ' </label >
                                <input type="text" name="email_subject" class="form-control" />
                                <small> ' . __('Something like "New order from your website"', 'lfb') . ' </small>
                            </div>

                            <div class="form-group" >
                               <!-- <label> ' . __('Admin email content', 'lfb') . ' </label> -->
                                <div id="lfb_emailTemplateAdmin" class="palette palette-turquoise" >
                                    <p><i> ' . __('Variables', 'lfb') . ' :</i></p>
                                    <p>
                                      <strong>[project_content]</strong> : ' . __('Selected items list', 'lfb') . ' <br/>
                                        <strong>[information_content]</strong> : ' . __('Last step form values', 'lfb') . ' <br/>
                                        <strong>[total_price]</strong> : ' . __('Total price', 'lfb') . ' <br/>
                                        <strong>[ref]</strong> : ' . __('Order reference', 'lfb') . ' <br/>
                                        <strong>[date]</strong> : ' . __('Date of the day', 'lfb') . ' <br/>
                                        <strong>[order_type]</strong> : ' . __('It will return "Invoice" if payment has been made, or "Quotation" if not', 'lfb') . ' <br/>                                        
                                        &nbsp;<br/>
                                    </p>
                                    <a href="javascript:" id="lfb_btnAddEmailValue" onclick="lfb_addEmailValue(0);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a dynamic value', 'lfb') . '</a>

                                </div>
                                <div id="email_adminContent_editor" >
                                <div id="email_adminContent"></div>
                             </div>
                            </div>
                            
                            <div class="form-group" >
                                <label > ' . __('Send the order as pdf', 'lfb') . ' </label >
                                <input type="checkbox"  name="sendPdfAdmin" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __('A pdf file will be generated and sent as attachment', 'lfb') . ' </small>
                            </div>
                             <div class="form-group" id="lfb_pdfTemplateAdminContainer" >
                               <h4> ' . __('Admin pdf content', 'h4') . ' </h4> 
                                <div id="lfb_pdfTemplateAdmin" class="palette palette-turquoise" >
                                    <p><i> ' . __('Variables', 'lfb') . ' :</i></p>
                                    <p>
                                      <strong>[project_content]</strong> : ' . __('Selected items list', 'lfb') . ' <br/>
                                        <strong>[information_content]</strong> : ' . __('Last step form values', 'lfb') . ' <br/>
                                        <strong>[total_price]</strong> : ' . __('Total price', 'lfb') . ' <br/>
                                        <strong>[ref]</strong> : ' . __('Order reference', 'lfb') . ' <br/>
                                        <strong>[date]</strong> : ' . __('Date of the day', 'lfb') . ' <br/>
                                        <strong>[order_type]</strong> : ' . __('It will return "Invoice" if payment has been made, or "Quotation" if not', 'lfb') . ' <br/>                                        
                                        &nbsp;<br/>
                                    </p>
                                    <a href="javascript:" id="lfb_btnAddPdfValue" onclick="lfb_addEmailValue(3);" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span>' . __('Add a dynamic value', 'lfb') . '</a>

                                </div>
                                <div id="pdf_adminContent_editor" >
                                <div id="pdf_adminContent"></div>
                             </div>
                            </div>

                        </div>
                             <div class="col-md-6" >
                            <h4> ' . __('Customer email', 'lfb') . ' </h4>
                             <div class="form-group" >
                                <label > ' . __('Send email to the customer ? ', 'lfb') . ' </label >
                                <input type="checkbox"  name="email_toUser" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                <small> ' . __('If true, the user will receive a confirmation email', 'lfb') . ' </small>
                            </div>
                            <div id="lfb_formEmailUser" >
                            
                             <div class="form-group" >
                                <label > ' . __('Customer email subject', 'lfb') . ' </label >
                                <input type="text" name="email_userSubject" class="form-control" />
                                <small> ' . __('Something like "Order confirmation"', 'lfb') . ' </small>
                            </div>
                             <div class="form-group" id="lfb_emailCustomerLinksCt">
                                <label>' . __('Show uploaded files links in summary', 'lfb') . ' </label>
                                <input type="checkbox"  name="emailCustomerLinks" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __('If disabled, only the names of the uploaded files will be displayed', 'lfb') . ' </small>
                            </div>                                                        
                            
                            <div class="form-group" >
                                <div  id="lfb_emailTemplateCustomer" class="palette palette-turquoise" >
                                    <p><i> ' . __('Variables', 'lfb') . ' :</i></p>
                                    <p>
                                        <strong>[project_content]</strong> : ' . __('Selected items list', 'lfb') . ' <br/>
                                        <strong>[information_content]</strong> : ' . __('Last step form values', 'lfb') . ' <br/>
                                        <strong>[total_price]</strong> : ' . __('Total price', 'lfb') . ' <br/>
                                        <strong>[ref]</strong> : ' . __('Order reference', 'lfb') . ' <br/>'
            . ' <strong>[date]</strong> : ' . __('Date of the day', 'lfb') . ' <br/>
                                        <strong>[order_type]</strong> : ' . __('It will return "Invoice" if payment has been made, or "Quotation" if not', 'lfb') . ' <br/>
                                        <strong>[payment_link]</strong> : ' . __('It will show the payment link here if the payment is placed in the email', 'lfb') . ' <br/>
                                        <strong>[customer_link]</strong> : ' . __('If the customer account management option is activated, it will show the link to the defined page', 'lfb') . ' <br/>
                                    </p>
                                    <a href="javascript:" id="lfb_btnAddEmailValueCustomer" onclick="lfb_addEmailValue(1);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a dynamic value', 'lfb') . '</a>
                                </div>';

            echo'  <div id="email_userContent_editor" >
                                   <div id="email_userContent"></div>';
            echo '</div>
                            </div>
                            
                            <div class="form-group" >
                                <label > ' . __('Send the order as pdf', 'lfb') . ' </label >
                                <input type="checkbox"  name="sendPdfCustomer" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __('A pdf file will be generated and sent as attachment', 'lfb') . ' </small>
                            </div>

                               <div class="form-group" id="lfb_pdfTemplateUserContainer" >
                               <h4> ' . __('Customer pdf content', 'lfb') . ' </h4> 
                                <div id="lfb_pdfTemplateUser" class="palette palette-turquoise" >
                                    <p><i> ' . __('Variables', 'lfb') . ' :</i></p>
                                    <p>
                                      <strong>[project_content]</strong> : ' . __('Selected items list', 'lfb') . ' <br/>
                                        <strong>[information_content]</strong> : ' . __('Last step form values', 'lfb') . ' <br/>
                                        <strong>[total_price]</strong> : ' . __('Total price', 'lfb') . ' <br/>
                                        <strong>[ref]</strong> : ' . __('Order reference', 'lfb') . ' <br/>
                                        <strong>[date]</strong> : ' . __('Date of the day', 'lfb') . ' <br/>
                                        <strong>[order_type]</strong> : ' . __('It will return "Invoice" if payment has been made, or "Quotation" if not', 'lfb') . ' <br/>                                        
                                        &nbsp;<br/>
                                    </p>
                                    <a href="javascript:" id="lfb_btnAddPdfValueCustomer" onclick="lfb_addEmailValue(4);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a dynamic value', 'lfb') . '</a>

                                </div>
                                <div id="pdf_userContent_editor" >
                                <div id="pdf_userContent"></div>
                             </div>
                            </div>

                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="col-md-6">
                            <h4 class="lfb_noMarginBottom">' . __('Mailing list', 'lfb') . '</h4>
                        </div>
                        <div class="col-md-6"></div>
                    <div class="clearfix"></div>
                        <div class="col-md-6">';
            echo '<div class="form-group">'
            . '<label>' . __('Send contact to Mailchimp ?', 'lfb') . '</label>'
            . '<input type="checkbox" data-switch="switch"  name="useMailchimp"/>'
            . '</div>';
            echo '<div class="form-group">'
            . '<label>' . __('Mailchimp API key', 'lfb') . ' :</label>'
            . '<input type="text" class="form-control" name="mailchimpKey"/>'
            . '<a href="https://kb.mailchimp.com/accounts/management/about-api-keys" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-info-sign"></span></a>'
            . '</div>';
            echo '<div class="form-group">'
            . '<label>' . __('Mailchimp list', 'lfb') . ' :</label>'
            . '<select class="form-control" name="mailchimpList"></select>'
            . '</div>';
            echo '<div class="form-group">'
            . '<label>' . __('Confirmation by email required ?', 'lfb') . '</label>'
            . '<input type="checkbox" data-switch="switch"  name="mailchimpOptin"/>'
            . '</div>';
            echo '<div class="form-group">'
            . '<label>' . __('Send contact to MailPoet ?', 'lfb') . '</label>'
            . '<input type="checkbox" data-switch="switch"  name="useMailpoet"/>'
            . '</div>';
            echo '<div class="form-group">'
            . '<label>' . __('Mailpoet list', 'lfb') . ' :</label>'
            . '<select class="form-control" name="mailPoetList"></select>'
            . '</div>';
            echo '</div>';
            echo '<div class="col-md-6">';


            echo '<div class="form-group">'
            . '<label>' . __('Send contact to GetResponse ?', 'lfb') . '</label>'
            . '<input type="checkbox" data-switch="switch"  name="useGetResponse"/>'
            . '</div>';
            echo '<div class="form-group">'
            . '<label>' . __('GetResponse API key', 'lfb') . ' :</label>'
            . '<input type="text" class="form-control" name="getResponseKey"/>'
            . '<a href="https://support.getresponse.com/faq/where-i-find-api-key" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-info-sign"></span></a>'
            . '</div>';
            echo '<div class="form-group">'
            . '<label>' . __('GetResponse list', 'lfb') . ' :</label>'
            . '<select class="form-control" name="getResponseList"></select>'
            . '</div>';
            echo '<div class="form-group">'
            . '<label>' . __('Send contact as soon the email field is filled ?', 'lfb') . '</label>'
            . '<input type="checkbox" data-switch="switch"  name="sendContactASAP"/>'
            . '<small> ' . __('If checked, the contact will be send at end of the step containing the email field', 'lfb') . ' </small>'
            . '</div>';
            echo '</div>
                    </div>
                    
                     <div class="clearfix"></div>
                </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="lfb_tabLastStep" >
                    <div class="row-fluid" >
                                <div id="lfb_finalStepVisualBtn">
                            <div><a href="javascript:" id="lfb_editFinalStepVisual" class="btn btn-default btn-lg" ><span class="fas fa-pencil-alt" ></span>' . __('Edit final step content', 'lfb') . ' </a></div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-6" >
                         <div class="form-group" >
                                <label> ' . __('Open a page at end', 'lfb') . ' </label >
                                <input type="text" name="close_url" class="form-control" />
                                <small> ' . __('Complete this field if you want to call a specific url on close . Otherwise leave it empty.', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label> ' . __('Send values as GET variables', 'lfb') . ' </label >
                                <input  type="checkbox"  name="sendUrlVariables" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>

                                <small> ' . __('The values of the selected items will be sent as GET variables to the target page', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Conditions on redirection ?', 'lfb') . ' </label >
                                <input  type="checkbox"  name="useRedirectionConditions" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Activate it to create different possible redirections', 'lfb') . ' </small>
                            </div>
                            
                            <div id="lfb_redirConditionsContainer">
                            <p class="text-right"><a href="javascript:" id="lfb_addRedirBtn" onclick="lfb_editRedirection(0);" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> ' . __('Add a redirection', 'lfb') . '</a></p>
                            <table id="lfb_redirsTable" class="table">
                            <thead>
                                <tr>
                                    <th>' . __('URL', 'lfb') . '</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                          </div>
                          
                            <div class="form-group" >
                                <label > ' . __('Delay before the redirection', 'lfb') . ' </label >
                                <input type="numberfield" name="redirectionDelay" class="form-control" />
                                <small> ' . __('Enter the wanted delay in seconds', 'lfb') . ' </small>
                            </div>
                            
                            <div class="form-group" >
                                <label > ' . __('Use e-signature', 'lfb') . ' </label >
                                <input type="checkbox" name="useSignature"  data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('An electronic signature will be asked in the last step', 'lfb') . ' </small>
                            </div>
                            
                        </div>
                        <div class="col-md-6" >
                         
                            <div class="form-group" >
                                    <label > ' . __('Hide the final price ?', 'lfb') . ' </label >
                                    <input  type="checkbox"  name="hideFinalPrice" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                    <small> ' . __('Set on true to hide the price on the last step.', 'lfb') . ' </small>
                                </div>
                                <div class="form-group" >
                                    <label > ' . __('Use reCaptcha ?', 'lfb') . ' </label >
                                    <input  type="checkbox"  name="useCaptcha" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                </div>
                                                                
            <div class="form-group">
            <label>' . __('reCaptcha 3 Public Key', 'lfb') . ' :</label>
            <input type="text" class="form-control" name="recaptcha3Key"/>
            <a href="https://www.google.com/recaptcha/admin/create" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-info-sign"></span></a>
            </div>                         
            <div class="form-group">
            <label>' . __('reCaptcha 3 Secret Key', 'lfb') . ' :</label>
            <input type="text" class="form-control" name="recaptcha3KeySecret"/>
            <a href="https://www.google.com/recaptcha/admin/create" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-info-sign"></span></a>
            </div>
                
                                <div class="form-group" >
                                    <label > ' . __('Send email automatically on last step', 'lfb') . ' </label >
                                    <input  type="checkbox"  name="sendEmailLastStep" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                    <small> ' . __('If there is no payment and no field on the last step, the order will be sent automatically when the user will arrive on this step', 'lfb') . ' </small>
                                </div>    
                                
                               <div class="form-group" >
                                    <label > ' . __('Download order as PDF', 'lfb') . ' </label >
                                    <input  type="checkbox"  name="enablePdfDownload" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                </div>
                               <div class="form-group" >
                                    <label > ' . __('PDF file name', 'lfb') . ' </label >
                                    <input  type="text"  name="pdfDownloadFilename" class="form-control"/>
                                </div>
                                
                                
                                <div id="lfb_emailVerificationContent_editor" >
                                <div id="lfb_emailVerificationContent"></div>
                             </div>

                        </div>
                   </div>
                   <div class="clearfix" ></div>
                    <div class="row-fluid" >
                        <div class="col-md-6" >';




            if (is_plugin_active('gravityforms/gravityforms.php')) {
                echo ' <h4>' . __('Gravity Form', 'lfb') . ' </h4>
                                 <div class="form-group" >
                                <label> ' . __('Assign a Gravity Form to the last step', 'lfb') . ' </label>
                                <select name="gravityFormID" class="form-control" />
                                    <option value="0" > ' . __('None', 'lfb') . ' </option> ';
                $formsG = RGFormsModel::get_forms(null, "title");
                foreach ($formsG as $formG) {
                    echo '<option value="' . $formG->id . '" > ' . $formG->title . '</option > ';
                }
                echo '
                                </select>
                                <small> ' . __('If true, the user will be redirected on the payment page', 'lfb') . ' </small>
                            </div>
    ';
            }


            echo'   <h4> ' . __('Legal notice', 'lfb') . ' </h4 >
                          <div>
                               <div class="form-group" >
                                   <label > ' . __('Enable legal notice ?', 'lfb') . ' </label >
                                   <input type="checkbox"  name="legalNoticeEnable" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                   <small> ' . __('If true, the user must accept the notice before submitting the form', 'lfb') . ' </small>
                               </div>
                               <div class="form-group" >
                                  <label > ' . __('Sentence of acceptance', 'lfb') . ' </label >
                                  <input type="text" name="legalNoticeTitle" class="form-control" />
                                  <small> ' . __('Something like "I certify I completely read and I accept the legal notice by validating this form"', 'lfb') . ' </small>
                              </div>
                              <div class="form-group" >
                                 <label > ' . __('Content of the legal notice', 'lfb') . ' </label >
                                  <div id="lfb_legalNoticeContent"></div>
                                 <small> ' . __('Write your legal notice here', 'lfb') . ' </small>
                             </div>
                        </div>';

            echo '</div>
               <div class="col-md-6" >';

            if (is_plugin_active('woocommerce/woocommerce.php')) {
                $disp = '';
            } else {
                $disp = 'class="lfb_hidden"';
            }
            echo ' <div ' . $disp . ' ><h4 class="lfb_wooOption" > ' . __('Woo Commerce', 'lfb') . ' </h4 >
                            <div class="form-group lfb_wooOption"  >
                                    <label > ' . __('Add selected items to cart', 'lfb') . ' </label >
                                    <input type="checkbox"  name="save_to_cart" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                    <small> ' . __('If true, all items with price must beings products of the woo catalog', 'lfb') . ' </small>
                                </div>
                                <div class="form-group lfb_wooOption"  >
                                    <label > ' . __('Empty cart before adding products ?', 'lfb') . ' </label >
                                    <input type="checkbox"  name="emptyWooCart" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                    <small> ' . __('All the existing products in the cart will be removed before adding the selected ones', 'lfb') . ' </small>
                                </div>
                                <div class="form-group lfb_wooOption"  >
                                    <label > ' . __('Show items titles in the cart ?', 'lfb') . ' </label >
                                    <input type="checkbox"  name="wooShowFormTitles" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                    <small> ' . __('If this option is enabled, the names of the products in the woo cart will be the titles defined in the form', 'lfb') . ' </small>
                                </div>
                                
                        </div>';

            if (is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')) {
                $disp = '';
            } else {
                $disp = 'class="lfb_hidden"';
            }
            echo ' <div ' . $disp . ' ><h4 class="lfb_eddOption" > ' . __('Easy Digital Downloads', 'lfb') . ' </h4 >
                            <div class="form-group lfb_eddOption"  >
                                    <label > ' . __('Add selected items to cart', 'lfb') . ' </label >
                                    <input type="checkbox"  name="save_to_cart_edd" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                    <small> ' . __('If true, all items with price must beings products of the Easy Digital Downloads catalog', 'lfb') . ' </small>
                                </div>
                        </div>';

            echo '<h4 style="margin-top: 18px;"> ' . __('Zapier', 'lfb') . ' </h4>';

            echo ' <div class="form-group "  >
                <label > ' . __('Send values to Zapier', 'lfb') . ' </label >
                <input type="checkbox"  name="enableZapier" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                <small> ' . __('The prices and values of the selected items will be sent to the defined webhook', 'lfb') . ' </small>
            </div>';
            echo '<div class="form-group" >
                    <label > ' . __('Webhook URL', 'lfb') . ' </label >
                    <input type="text" name="zapierWebHook" class="form-control" />
                    <small> ' . __('Create a new webhook from your Zapier dashboard then fill its URL here', 'lfb') . ' </small>
                </div>
                    
                            
                            
                        </div>
                        </div>
                  
            <div class="clearfix"></div>
            <div class="col-md-12" id="lfb_finalStepFields" >
            <div id="lfb_finalStepItemsList">
              
<div class="clearfix"></div>
                                <a href="javascript:" id="lfb_addFieldBtn" onclick="lfb_editItem(0);" class="btn btn-primary" style="float: right;" ><span class="glyphicon glyphicon-plus" ></span>' . __('Add a new Item', 'lfb') . ' </a>

                            <h4> ' . __('Fields of the final step', 'lfb') . ' </h4 >
                            <table class="table table-striped table-bordered" >
                                <thead >
                                    <tr >
                                        <th > ' . __('Label', 'lfb') . ' </th>
                                        <th > ' . __('Type', 'lfb') . ' </th>
                                        <th > ' . __('Group', 'lfb') . ' </th>
                                        <th class="lfb_actionTh"> ' . __('Actions', 'lfb') . ' </th>
                                    </tr >
                                </thead >
                                <tbody >
                                </tbody >
                            </table >

                        </div>

                        </div>
                    <div class="clearfix" ></div>
                  <!--    <div class="clearfix" ></div>
               </div> -->
        </div>
        

                    <div role="tabpanel" class="tab-pane" id="lfb_tabPayment" >
                        <div class="row-fluid" >
                        <div class="col-md-6" >
                            
                                 
                            <div class="form-group " >
                                <label > ' . __('Use subscription ?', 'lfb') . ' </label >
                                <input type="checkbox"  name="isSubscription" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                <small> ' . __('Enable this option to be able to give a recurring price to some items', 'lfb') . ' </small>                            
                            </div>     
                             <div class="form-group" >
                                <label > ' . __('Show a price range as result', 'lfb') . ' </label >
                                <input type="checkbox"  name="totalIsRange" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                <small> ' . __('Activating this option, the result will be a price range', 'lfb') . ' </small>                            
                            </div>
                            
 <div class="form-group " style="display:none;">
                                <label > ' . __('Where does the payment take place ?', 'lfb') . ' </label >
                                <select name="paymentType" class="form-control"  />
                                    <option value="form">' . __('At end of the form', 'lfb') . '</option>
                                    <option value="email">' . __('From a link in the email', 'lfb') . '</option>
                                </select>

                                <small> ' . __('Choose where the user can pay', 'lfb') . ' </small>                            
                            </div>
                            
                            <div class="form-group" >
                                <label > ' . __('Type of payment link in the email', 'lfb') . ' </label >
                                <select  name="emailPaymentType" class="form-control" />
                                    <option value="checkbox" > ' . __('Checkbox', 'lfb') . ' </option >
                                    <option value="button" > ' . __('Button', 'lfb') . ' </option >
                                    <option value="link" > ' . __('Link', 'lfb') . ' </option >
                                </select >
                            </div>
                             
                           </div>
                           <div class="col-md-6">
                            <div class="form-group" >
                                <label > ' . __('Text after price', 'lfb') . ' </label >
                                <input type="text" name="subscription_text" class="form-control" maxlength="11" />
                                <small> ' . __('Something like "/month"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Progress bar follows', 'lfb') . ' </label >
                                 <select name="progressBarPriceType" class="form-control" />
                                    <option value="single">' . __('Single cost total amount', 'lfb') . '</option>
                                    <option value="">' . __('Subscription total amount', 'lfb') . '</option>
                                </select>
                                <small> ' . __('The main progress bar progression will follow the selected total amount type', 'lfb') . ' </small>
                            </div>
                       
                            <div class="form-group " >
                                <label > ' . __('Type of price range', 'lfb') . ' </label >
                                <select name="totalRangeMode" class="form-control" />
                                    <option value="percent">' . __('Percentage of the total price', 'lfb') . '</option>
                                    <option value="">' . __('Fixed range', 'lfb') . '</option>
                                </select>
                            </div>
                            
                            <div class="form-group" >
                                <label id="lfb_totalRangeLabelFixed"> ' . __('Price range', 'lfb') . ' </label>
                                <label id="lfb_totalRangeLabelPercent"> ' . __('Percentage range', 'lfb') . ' </label>
                                <input type="numberfield"  name="totalRange" class="form-control"   />
                                <small> ' . __('Defines the range applied to the total price', 'lfb') . ' </small>                            
                            </div>
                            
                                    
                            </div>';

            echo'<div class="clearfix"></div> 
                         <div class="col-md-4">
                         <div id="paypalFieldsCt"><div class="lfb_paymentOption">   
                            
                            <div class="form-group" >
                                <label > ' . __('Use Paypal payment', 'lfb') . ' </label >
                                <input type="checkbox"  name="use_paypal" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                            </div>
                            
                            
                            <div id="lfb_formPaypal" >
                             <div class="form-group" >
                                <label > ' . __('Paypal email', 'lfb') . ' </label >
                                <input type="text" name="paypal_email" class="form-control" />
                                <small> ' . __('Enter your paypal email', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Frequency of subscription', 'lfb') . ' </label >
                                <select name="paypal_subsFrequency" class="form-control" />
                                    <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                </select>
                                <select name="paypal_subsFrequencyType" class="form-control"  />
                                    <option value="D">' . __('day(s)', 'lfb') . '</option>
                                    <option value="W">' . __('week(s)', 'lfb') . '</option>
                                    <option value="M">' . __('month(s)', 'lfb') . '</option>
                                    <option value="Y">' . __('year(s)', 'lfb') . '</option>
                                </select>
                                <small> ' . __('Payment will be renewed every ... ?', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('How many payments ?') . ' </label >
                                <select name="paypal_subsMaxPayments" class="form-control" />
                                    <option value="0">' . __('Unlimited', 'lfb') . '</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                </select>
                                <small> ' . __('The subscription ends after how many payments ?', 'lfb') . ' </small>
                            </div>        
                            <div class="form-group" >
                                <label > ' . __('Amount to pay', 'lfb') . ' </label >
                                <select name="paypal_payMode" class="form-control" />
                                    <option value="">' . __('Full amount', 'lfb') . '</option>
                                    <option value="percent">' . __('Percentage of the total price', 'lfb') . '</option>
                                    <option value="fixed">' . __('Fixed amount', 'lfb') . '</option>
                                </select>
                                <small> ' . __('Choose if the user will pay the full price or not', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Percentage of the total price to pay', 'lfb') . ' </label >
                                <input type="number" step="0.10" name="percentToPay" class="form-control" />
                                <small> ' . __('Only this percentage will be paid by paypal', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Fixed amount to pay', 'lfb') . ' </label >
                                <input type="number" step="0.10" name="paypal_fixedToPay" class="form-control" />
                                <small> ' . __('Only this fixed amount will be paid', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Currency', 'lfb') . ' </label >
                                <select name="paypal_currency" class="form-control" />
                                    <option value="AUD" > AUD</option >
                                    <option value="CAD" > CAD</option >
                                    <option value="CZK" > CZK</option >
                                    <option value="DKK" > DKK</option >
                                    <option value="EUR" > EUR</option >
                                    <option value="HKD" > HKD</option >
                                    <option value="HUF" > HUF</option >
                                    <option value="INR" > INR</option >
                                    <option value="JPY" > JPY</option >
                                    <option value="NOK" > NOK</option >
                                    <option value="MXN" > MXN </option >
                                    <option value="NZD" > NZD</option >
                                    <option value="PLN" > PLN</option >
                                    <option value="GBP" > GBP</option >
                                    <option value="SGD" > SGD</option >
                                    <option value="SEK" > SEK</option >
                                    <option value="CHF" > CHF</option >
                                    <option value="USD" > USD</option >
                                    <option value="RUB" > RUB</option >
                                    <option value="PHP" > PHP</option >
                                    <option value="ILS" > ILS</option >
                                    <option value="BRL" > BRL</option >
                                    <option value="THB" > THB</option >                                    
                                    <option value="MYR" > MYR</option >                                    
                                </select >
                                <small> ' . __('Choose a currency', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Payment page language', 'lfb') . ' </label >
                                <select name="paypal_languagePayment" class="form-control" />
                                    <option value="" > ' . __('Automatic', 'lfb') . '</option>
                                    <option value="EG">EG</option>
                                    <option value="DK">DK</option>
                                    <option value="DE">DE</option>   
                                    <option value="US">US</option>     
                                    <option value="ES">ES</option>    
                                    <option value="FR">FR</option>      
                                    <option value="ID">ID</option>     
                                    <option value="IT">IT</option>     
                                    <option value="RU">RU</option>     
                                    <option value="CN">CN</option>    
                                    <option value="TW">TW</option>                                    
                                </select >
                                <small> ' . __('The payment page will be displayed in the selected language', 'lfb') . ' </small>
                            </div>
                            
                            <div class="form-group" >
                                <label > ' . __('Use paypal IPN', 'lfb') . ' </label >
                                <input type="checkbox"  name="paypal_useIpn" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                <small> ' . __('Email will be send only if the payment has been done and verified', 'lfb') . ' </small> 
                                <p id="lfb_infoIpn" class="alert alert-info" >
                                    ' . sprintf(__('IPN requires a PayPal Business or Premier account and IPN must be configured on that account.<br/>See the <a %1$s>PayPal IPN Integration Guide</a> to learn how to set up IPN.<br/>The IPN listener URL you will need is : %2$s', 'lfb'), 'href="https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNSetup/" target="_blank"', '<br/><strong>' . get_site_url() . '/?EPFormsBuilder=paypal</strong>') . '
                                </p>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Use paypal Sandbox', 'lfb') . ' </label >
                                <input type="checkbox"  name="paypal_useSandbox" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                <small> ' . __('Enable Sandbox only to test with fake payments', 'lfb') . ' </small> 
                            </div>
                            </div> </div></div>';

            echo '</div><div class="col-md-4">';
            echo '<div id="stripeFieldsCt"><div class="form-group" >
                                <label > ' . __('Use Stripe payment', 'lfb') . ' </label >
                                <input type="checkbox"  name="use_stripe" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                            </div>
                            <div class="form-group lfb_stripeField" >
                                <label > ' . __('Stripe publishable key', 'lfb') . ' </label >
                                <input type="text" name="stripe_publishKey" class="form-control" />
                                <small> ' . __('Enter your stripe publishable key', 'lfb') . ' </small>
                            </div>
                            <div class="form-group lfb_stripeField" >
                                <label > ' . __('Stripe secret key', 'lfb') . ' </label >
                                <input type="text" name="stripe_secretKey" class="form-control" />
                                <small> ' . __('Enter your stripe secret key', 'lfb') . ' </small>
                            </div>
                             <div class="form-group" >
                                <label > ' . __('Frequency of subscription', 'lfb') . ' </label >
                                    
                                <select name="stripe_subsFrequency" class="form-control" />
                                    <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                </select>
                                <select name="stripe_subsFrequencyType" class="form-control"/>
                                    <option value="day">' . __('day(s)', 'lfb') . '</option>
                                    <option value="week">' . __('week(s)', 'lfb') . '</option>
                                    <option value="month">' . __('month(s)', 'lfb') . '</option>
                                    <option value="year">' . __('year(s)', 'lfb') . '</option>
                                </select>
                                <small> ' . __('Payment will be renewed every ... ?', 'lfb') . ' </small>
                            </div>     
                            
                             <div class="form-group lfb_stripeField" >
                                <label > ' . __('Currency', 'lfb') . ' </label >
                                <select name="stripe_currency" class="form-control" />
                                    <option value="AED">United Arab Emirates Dirham
                                    </option>
                                    <option value="ALL">Albanian Lek
                                    </option>
                                    <option value="ANG">Netherlands Antillean Gulden
                                    </option>
                                    <option value="ARS">Argentine Peso
                                    </option>
                                    <option value="AUD">Australian Dollar
                                    </option>
                                    <option value="AWG">Aruban Florin
                                    </option>
                                    <option value="BBD">Barbadian Dollar
                                    </option>
                                    <option value="BDT">Bangladeshi Taka
                                    </option>
                                    <option value="BIF">Burundian Franc
                                    </option>
                                    <option value="BMD">Bermudian Dollar
                                    </option>
                                    <option value="BND">Brunei Dollar
                                    </option>
                                    <option value="BOB">Bolivian Boliviano
                                    </option>
                                    <option value="BRL">Brazilian Real
                                    </option>
                                    <option value="BSD">Bahamian Dollar
                                    </option>
                                    <option value="BWP">Botswana Pula
                                    </option>
                                    <option value="BZD">Belize Dollar
                                    </option>
                                    <option value="CAD">Canadian Dollar
                                    </option>
                                    <option value="CHF">Swiss Franc
                                    </option>
                                    <option value="CLP">Chilean Peso
                                    </option>
                                    <option value="CNY">Chinese Renminbi Yuan
                                    </option>
                                    <option value="COP">Colombian Peso
                                    </option>
                                    <option value="CRC">Costa Rican Colón
                                    </option>
                                    <option value="CVE">Cape Verdean Escudo
                                    </option>
                                    <option value="CZK">Czech Koruna
                                    </option>
                                    <option value="DJF">Djiboutian Franc
                                    </option>
                                    <option value="DKK">Danish Krone
                                    </option>
                                    <option value="DOP">Dominican Peso
                                    </option>
                                    <option value="DZD">Algerian Dinar
                                    </option>
                                    <option value="EGP">Egyptian Pound
                                    </option>
                                    <option value="ETB">Ethiopian Birr
                                    </option>
                                    <option value="EUR">Euro
                                    </option>
                                    <option value="FJD">Fijian Dollar
                                    </option>
                                    <option value="FKP">Falkland Islands Pound
                                    </option>
                                    <option value="GBP">British Pound
                                    </option>
                                    <option value="GIP">Gibraltar Pound
                                    </option>
                                    <option value="GMD">Gambian Dalasi
                                    </option>
                                    <option value="GNF">Guinean Franc
                                    </option>
                                    <option value="GTQ">Guatemalan Quetzal
                                    </option>
                                    <option value="GYD">Guyanese Dollar
                                    </option>
                                    <option value="HKD">Hong Kong Dollar
                                    </option>
                                    <option value="HNL">Honduran Lempira
                                    </option>
                                    <option value="HRK">Croatian Kuna
                                    </option>
                                    <option value="HTG">Haitian Gourde
                                    </option>
                                    <option value="HUF">Hungarian Forint
                                    </option>
                                    <option value="IDR">Indonesian Rupiah
                                    </option>
                                    <option value="ILS">Israeli New Sheqel
                                    </option>
                                    <option value="INR">Indian Rupee
                                    </option>
                                    <option value="ISK">Icelandic Króna
                                    </option>
                                    <option value="JMD">Jamaican Dollar
                                    </option>
                                    <option value="JPY">Japanese Yen
                                    </option>
                                    <option value="KES">Kenyan Shilling
                                    </option>
                                    <option value="KHR">Cambodian Riel
                                    </option>
                                    <option value="KMF">Comorian Franc
                                    </option>
                                    <option value="KRW">South Korean Won
                                    </option>
                                    <option value="KYD">Cayman Islands Dollar
                                    </option>
                                    <option value="KZT">Kazakhstani Tenge
                                    </option>
                                    <option value="LAK">Lao Kip
                                    </option>
                                    <option value="LBP">Lebanese Pound
                                    </option>
                                    <option value="LKR">Sri Lankan Rupee
                                    </option>
                                    <option value="LRD">Liberian Dollar
                                    </option>
                                    <option value="MAD">Moroccan Dirham
                                    </option>
                                    <option value="MDL">Moldovan Leu
                                    </option>
                                    <option value="MNT">Mongolian Tögrög
                                    </option>
                                    <option value="MOP">Macanese Pataca
                                    </option>
                                    <option value="MRO">Mauritanian Ouguiya
                                    </option>
                                    <option value="MUR">Mauritian Rupee
                                    </option>
                                    <option value="MVR">Maldivian Rufiyaa
                                    </option>
                                    <option value="MWK">Malawian Kwacha
                                    </option>
                                    <option value="MXN">Mexican Peso
                                    </option>
                                    <option value="MYR">Malaysian Ringgit
                                    </option>
                                    <option value="NAD">Namibian Dollar
                                    </option>
                                    <option value="NGN">Nigerian Naira
                                    </option>
                                    <option value="NIO">Nicaraguan Córdoba
                                    </option>
                                    <option value="NOK">Norwegian Krone
                                    </option>
                                    <option value="NPR">Nepalese Rupee
                                    </option>
                                    <option value="NZD">New Zealand Dollar
                                    </option>
                                    <option value="PAB">Panamanian Balboa
                                    </option>
                                    <option value="PEN">Peruvian Nuevo Sol
                                    </option>
                                    <option value="PGK">Papua New Guinean Kina
                                    </option>
                                    <option value="PHP">Philippine Peso
                                    </option>
                                    <option value="PKR">Pakistani Rupee
                                    </option>
                                    <option value="PLN">Polish Złoty
                                    </option>
                                    <option value="PYG">Paraguayan Guaraní
                                    </option>
                                    <option value="QAR">Qatari Riyal
                                    </option>
                                    <option value="RUB">Russian Ruble
                                    </option>
                                    <option value="SAR">Saudi Riyal
                                    </option>
                                    <option value="SBD">Solomon Islands Dollar
                                    </option>
                                    <option value="SCR">Seychellois Rupee
                                    </option>
                                    <option value="SEK">Swedish Krona
                                    </option>
                                    <option value="SGD">Singapore Dollar
                                    </option>
                                    <option value="SHP">Saint Helenian Pound
                                    </option>
                                    <option value="SLL">Sierra Leonean Leone
                                    </option>
                                    <option value="SOS">Somali Shilling
                                    </option>
                                    <option value="STD">São Tomé and Príncipe Dobra
                                    </option>
                                    <option value="SVC">Salvadoran Colón
                                    </option>
                                    <option value="SZL">Swazi Lilangeni
                                    </option>
                                    <option value="THB">Thai Baht
                                    </option>
                                    <option value="TOP">Tongan Paʻanga
                                    </option>
                                    <option value="TTD">Trinidad and Tobago Dollar
                                    </option>
                                    <option value="TWD">New Taiwan Dollar
                                    </option>
                                    <option value="TZS">Tanzanian Shilling
                                    </option>
                                    <option value="UAH">Ukrainian Hryvnia
                                    </option>
                                    <option value="UGX">Ugandan Shilling
                                    </option>
                                    <option value="USD">United States Dollar
                                    </option>
                                    <option value="UYU">Uruguayan Peso
                                    </option>
                                    <option value="UZS">Uzbekistani Som
                                    </option>
                                    <option value="VND">Vietnamese Đồng
                                    </option>
                                    <option value="VUV">Vanuatu Vatu
                                    </option>
                                    <option value="WST">Samoan Tala
                                    </option>
                                    <option value="XAF">Central African Cfa Franc
                                    </option>
                                    <option value="XOF">West African Cfa Franc
                                    </option>
                                    <option value="XPF">Cfp Franc
                                    </option>
                                    <option value="YER">Yemeni Rial
                                    </option>
                                    <option value="ZAR">South African Rand
                                    </option>
                                </select >
                                <small> ' . __('Choose a currency', 'lfb') . ' </small>
                            </div>
                             <div class="form-group lfb_stripeField">
                                <label class="lfb_imgFieldLabel"> ' . __('Stripe logo image', 'lfb') . ' </label >
                                <input type="text" name="stripe_logoImg" class="form-control lfb_fieldImg"  />
                                <a class="btn btn-default btn-circle imageBtn"  data-toggle="tooltip" title="' . __('Upload Image', 'lfb') . '"><span class="fas fa-cloud-upload-alt"></span></a>
                                <small display: block;> ' . __('Select an image', 'lfb') . ' </small>
                            </div> 
                                                        
                            <div class="form-group " >
                                <label > ' . __('Amount to pay', 'lfb') . ' </label >
                                <select name="stripe_payMode" class="form-control" />
                                    <option value="">' . __('Full amount', 'lfb') . '</option>
                                    <option value="percent">' . __('Percentage of the total price', 'lfb') . '</option>
                                    <option value="fixed">' . __('Fixed amount', 'lfb') . '</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label > ' . __('Percentage of the total price to pay', 'lfb') . ' </label >
                                <input type="number" step="0.10" name="stripe_percentToPay" class="form-control" />
                                <small> ' . __('Only this percentage will be paid by stripe', 'lfb') . ' </small>
                            </div>       
                            <div class="form-group">
                                <label > ' . __('Fixed amount to pay', 'lfb') . ' </label >
                                <input type="number" step="0.10" name="stripe_fixedToPay" class="form-control" />
                                <small> ' . __('Only this fixed amount will be paid', 'lfb') . ' </small>
                            </div>                             
                        </div> ';


            echo ' </div>';


            echo '<div class="col-md-4">';
            echo '<div id="razorpayFieldsCt"><div class="form-group" >
                                <label > ' . __('Use Razorpay payment', 'lfb') . ' </label >
                                <input type="checkbox"  name="use_razorpay" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                            </div>
                            <div class="form-group lfb_razorpayField" >
                                <label > ' . __('Razorpay key ID', 'lfb') . ' </label>
                                <input type="text" name="razorpay_publishKey" class="form-control" />
                                <small> ' . __('Enter your Razorpay key ID', 'lfb') . ' </small>
                            </div>
                            <div class="form-group lfb_razorpayField" >
                                <label > ' . __('Razorpay secret key', 'lfb') . ' </label >
                                <input type="text" name="razorpay_secretKey" class="form-control" />
                                <small> ' . __('Enter your Razorpay secret key', 'lfb') . ' </small>
                            </div>
                             <div class="form-group " >
                                <label > ' . __('Frequency of subscription', 'lfb') . ' </label >
                                    
                                <select name="razorpay_subsFrequency" class="form-control"  />
                                    <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                </select>
                                <select name="razorpay_subsFrequencyType" class="form-control"/>
                                    <option value="daily">' . __('day(s)', 'lfb') . '</option>
                                    <option value="weekly">' . __('week(s)', 'lfb') . '</option>
                                    <option value="monthly">' . __('month(s)', 'lfb') . '</option>
                                    <option value="yearly">' . __('year(s)', 'lfb') . '</option>
                                </select>
                                <small> ' . __('Payment will be renewed every ... ?', 'lfb') . ' </small>
                            </div>     
                            
                             <div class="form-group lfb_razorpayField" >
                                <label > ' . __('Currency', 'lfb') . ' </label >
                                <select name="razorpay_currency" class="form-control" />
                                    <option value="AED">United Arab Emirates Dirham
                                    </option>
                                    <option value="ALL">Albanian Lek
                                    </option>                                    
                                    <option value="ARS">Argentine Peso
                                    </option>
                                    <option value="AUD">Australian Dollar
                                    </option>
                                    <option value="AWG">Aruban Florin
                                    </option>
                                    <option value="BBD">Barbadian Dollar
                                    </option>
                                    <option value="BDT">Bangladeshi Taka
                                    </option>
                                    <option value="BMD">Bermudian Dollar
                                    </option>
                                    <option value="BND">Brunei Dollar
                                    </option>
                                    <option value="BOB">Bolivian Boliviano
                                    </option>
                                    <option value="BWP">Botswana Pula
                                    </option>
                                    <option value="BZD">Belize Dollar
                                    </option>
                                    <option value="CAD">Canadian Dollar
                                    </option>
                                    <option value="CHF">Swiss Franc
                                    </option>
                                    <option value="CNY">Chinese Renminbi Yuan
                                    </option>
                                    <option value="COP">Colombian Peso
                                    </option>
                                    <option value="CRC">Costa Rican Colón
                                    </option>
                                    <option value="CUP">Cuban peso
                                    </option>
                                    <option value="CZK">Czech Koruna
                                    </option>
                                    <option value="DKK">Danish Krone
                                    </option>
                                    <option value="DOP">Dominican Peso
                                    </option>
                                    <option value="DZD">Algerian Dinar
                                    </option>
                                    <option value="EGP">Egyptian Pound
                                    </option>
                                    <option value="ETB">Ethiopian Birr
                                    </option>
                                    <option value="EUR">Euro
                                    </option>
                                    <option value="FJD">Fijian Dollar
                                    </option>
                                    <option value="GBP">British Pound
                                    </option>
                                    <option value="GIP">Gibraltar Pound
                                    </option>
                                    <option value="GMD">Gambian Dalasi
                                    </option>
                                    <option value="GTQ">Guatemalan Quetzal
                                    </option>
                                    <option value="GYD">Guyanese Dollar
                                    </option>
                                    <option value="HKD">Hong Kong Dollar
                                    </option>
                                    <option value="HNL">Honduran Lempira
                                    </option>
                                    <option value="HRK">Croatian Kuna
                                    </option>
                                    <option value="HTG">Haitian Gourde
                                    </option>
                                    <option value="HUF">Hungarian Forint
                                    </option>
                                    <option value="IDR">Indonesian Rupiah
                                    </option>
                                    <option value="ILS">Israeli New Sheqel
                                    </option>
                                    <option value="INR">Indian Rupee
                                    </option>
                                    <option value="JMD">Jamaican Dollar
                                    </option>                                    
                                    <option value="KES">Kenyan Shilling
                                    </option>
                                    <option value="KHR">Cambodian Riel
                                    </option>
                                    <option value="KYD">Cayman Islands Dollar
                                    </option>
                                    <option value="KZT">Kazakhstani Tenge
                                    </option>
                                    <option value="LAK">Lao Kip
                                    </option>
                                    <option value="LBP">Lebanese Pound
                                    </option>
                                    <option value="LKR">Sri Lankan Rupee
                                    </option>
                                    <option value="LRD">Liberian Dollar
                                    </option>
                                    <option value="LSL">Lesotho loti
                                    </option>
                                    <option value="MAD">Moroccan Dirham
                                    </option>
                                    <option value="MDL">Moldovan Leu
                                    </option>
                                    <option value="MKD">Macedonian denar	
                                    </option>
                                    <option value="MNT">Mongolian Tögrög
                                    </option>
                                    <option value="MMK">Myanmar kyat	
                                    </option>
                                    <option value="MOP">Macanese Pataca
                                    </option>
                                    <option value="MUR">Mauritian Rupee
                                    </option>
                                    <option value="MVR">Maldivian Rufiyaa
                                    </option>
                                    <option value="MWK">Malawian Kwacha
                                    </option>
                                    <option value="MXN">Mexican Peso
                                    </option>
                                    <option value="MYR">Malaysian Ringgit
                                    </option>
                                    <option value="NAD">Namibian Dollar
                                    </option>
                                    <option value="NGN">Nigerian Naira
                                    </option>
                                    <option value="NIO">Nicaraguan Córdoba
                                    </option>
                                    <option value="NOK">Norwegian Krone
                                    </option>
                                    <option value="NPR">Nepalese Rupee
                                    </option>
                                    <option value="NZD">New Zealand Dollar
                                    </option>
                                    <option value="PEN">Peruvian Nuevo Sol
                                    </option>
                                    <option value="PGK">Papua New Guinean Kina
                                    </option>
                                    <option value="PHP">Philippine Peso
                                    </option>
                                    <option value="PKR">Pakistani Rupee
                                    </option>
                                    <option value="QAR">Qatari Riyal
                                    </option>
                                    <option value="RUB">Russian Ruble
                                    </option>
                                    <option value="SAR">Saudi Riyal
                                    </option>
                                    <option value="SCR">Seychellois Rupee
                                    </option>
                                    <option value="SEK">Swedish Krona
                                    </option>
                                    <option value="SGD">Singapore Dollar
                                    </option>
                                    <option value="SLL">Sierra Leonean Leone
                                    </option>
                                    <option value="SOS">Somali Shilling
                                    </option>
                                    <option value="SSP">South Sudanese pound	
                                    </option>
                                    <option value="SVC">Salvadoran Colón
                                    </option>
                                    <option value="SZL">Swazi Lilangeni
                                    </option>
                                    <option value="THB">Thai Baht
                                    </option>
                                    <option value="TTD">Trinidad and Tobago Dollar
                                    </option>
                                    <option value="TZS">Tanzanian Shilling
                                    </option>
                                    <option value="USD">United States Dollar
                                    </option>
                                    <option value="UYU">Uruguayan Peso
                                    </option>
                                    <option value="UZS">Uzbekistani Som
                                    </option>
                                    <option value="YER">Yemeni Rial
                                    </option>
                                    <option value="ZAR">South African Rand
                                    </option>
                                </select >
                                <small> ' . __('Choose a currency', 'lfb') . ' </small>
                            </div>
                                                   

                             <div class="form-group lfb_razorpayField"  >
                                <label  class="lfb_imgFieldLabel"> ' . __('Logo image', 'lfb') . ' </label >
                                <input type="text" name="razorpay_logoImg" class="form-control lfb_fieldImg"   />    
                                
                                <a class="btn btn-default btn-circle imageBtn"  data-toggle="tooltip" title="' . __('Upload Image', 'lfb') . '"><span class="fas fa-cloud-upload-alt"></span></a>
                                <small display: block;> ' . __('Select an image', 'lfb') . ' </small>
                            </div> 
                            
                            <div class="form-group lfb_razorpayField" >
                                <label > ' . __('Amount to pay', 'lfb') . ' </label >
                                <select name="razorpay_payMode" class="form-control" />
                                    <option value="">' . __('Full amount', 'lfb') . '</option>
                                    <option value="percent">' . __('Percentage of the total price', 'lfb') . '</option>
                                    <option value="fixed">' . __('Fixed amount', 'lfb') . '</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label > ' . __('Percentage of the total price to pay', 'lfb') . ' </label >
                                <input type="number" step="0.10" name="razorpay_percentToPay" class="form-control" />
                                <small> ' . __('Only this percentage will be paid by stripe', 'lfb') . ' </small>
                            </div>       
                            <div class="form-group ">
                                <label > ' . __('Fixed amount to pay', 'lfb') . ' </label >
                                <input type="number" step="0.10" name="razorpay_fixedToPay" class="form-control" />
                                <small> ' . __('Only this fixed amount will be paid', 'lfb') . ' </small>
                            </div>                             
                        </div> ';
            echo '</div> </div>  </div>';
            echo '<div>
                        <div class="clearfix"></div>
                    </div>
         
                    <div role="tabpanel" class="tab-pane" id="lfb_tabSummary" >
                    <div class="row-fluid" >               
                        <div class="col-md-4">
                        <div class="form-group" >
                                <label > ' . __('Show a summary in the last step ?', 'lfb') . ' </label >
                                <input  type="checkbox"  name="useSummary" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to show a summary on last step ?', 'lfb') . ' </small>
                            </div>                                
                            <div class="form-group" >
                                <label > ' . __('Summary title', 'lfb') . ' </label >
                                <input type="text" name="summary_title" class="form-control" />
                                <small> ' . __('Something like "Summary"', 'lfb') . ' </small>
                            </div>      
                            
                            <div class="form-group" >
                                <label > ' . __('Can steps cells be clicked ?', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_stepsClickable" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('The user will return to the corresponding step when a step cell is clicked', 'lfb') . ' </small>
                            </div>   
                            <div class="form-group" >
                                <label > ' . __('Hide quantity column', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_hideQt" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to hide the column of quantities ?', 'lfb') . ' </small>
                            </div>   
                            <div class="form-group" >
                                <label > ' . __('Hide zero prices', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_hideZero" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to hide zero prices ?', 'lfb') . ' </small>
                            </div> 
                            <div class="form-group" >
                                <label > ' . __('Hide zero quantities', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_hideZeroQt" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to hide zero quantities ?', 'lfb') . ' </small>
                            </div> 
                            <div class="form-group" >
                                <label > ' . __('Hide decimals', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_noDecimals" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                            </div>                     
                        </div>                     
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label > ' . __('Hide all prices', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_hidePrices" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to hide all prices ?', 'lfb') . ' </small>
                            </div>  
                            <div class="form-group" >
                                <label > ' . __('Always show all prices in the email', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_showAllPricesEmail" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('The prices will be displayed in the email even if they are disabled in the form', 'lfb') . ' </small>
                            </div>         
                            <div class="form-group" >
                                <label > ' . __('Hide the final step', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_hideFinalStep" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to hide the final step ?', 'lfb') . ' </small>
                            </div>    
                            <div class="form-group" >
                                <label > ' . __('Hide total row', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_hideTotal" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to hide the total row ?', 'lfb') . ' </small>
                            </div>  
                            <div class="form-group" >
                                <label > ' . __('Hide steps rows', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_hideStepsRows" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to hide the steps rows ?', 'lfb') . ' </small>
                            </div>  
                            
                            <div class="form-group" >
                                <label > ' . __('Show items descriptions', 'lfb') . ' </label >
                                <input  type="checkbox"  name="summary_showDescriptions" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('Do you want to show the descriptions under the item titles ?', 'lfb') . ' </small>
                            </div>  
                            

                        </div>
                        <div class="col-md-4">
                                   
                            <div class="form-group" >
                                <label > ' . __('Enable summary as bubble', 'lfb') . ' </label >
                                <input  type="checkbox"  name="enableFloatingSummary" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                <small> ' . __('It will show a summary that can be viewed from any step of the form', 'lfb') . ' </small>
                            </div>         
                            
                             <div class="form-group" >
                                <label> ' . __('Bubble summary icon', 'lfb') . ' </label>
                                <input type="text" class="form-control" name="floatSummary_icon" placeholder="fa fa-rocket" data-iconfield="1" />
                                <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-search"></span></a>
                            </div>';

            echo '<div class="form-group" >
                                <label> ' . __('Bubble summary label', 'lfb') . ' </label >
                                <input type="text" name="floatSummary_label" class="form-control" />
                                <small> ' . __('Something like "View selection"', 'lfb') . ' </small>
                            </div>
                            <div class="form-group" >
                                <label > ' . __('Add numbers to the steps in the bubble summary', 'lfb') . ' </label >
                                <input  type="checkbox"  name="floatSummary_numSteps" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                            </div> 
                            <div class="form-group" >
                                <label > ' . __('Hide prices from the bubble summary', 'lfb') . ' </label >
                                <input  type="checkbox"  name="floatSummary_hidePrices" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                            </div> 
                            
                        </div>
                    <div class="clearfix"></div>
                    </div>
                    </div>';

            echo '<div role="tabpanel" class="tab-pane" id="lfb_tabDesign" >
                    <div class="row-fluid" >                       
                            <div class="col-md-4">
                             <div class="form-group" >
                                    <label > ' . __('Main color', 'lfb') . ' </label >
                                    <input type="text" name="colorA" class="form-control colorpick" />
                                    <small> ' . __('ex : #1abc9c', 'lfb') . '</small>
                                </div>
                                <div class="form-group" >
                                    <label > ' . __('Secondary color', 'lfb') . ' </label >
                                    <input type="text" name="colorSecondary" class="form-control colorpick" />
                                    <small> ' . __('ex : #bdc3c7', 'lfb') . '</small>
                                </div>
                                <div class="form-group" >
                                    <label > ' . __('Selected switchbox circle color', 'lfb') . ' </label >
                                    <input type="text" name="colorCbCircleOn" class="form-control colorpick" />
                                    <small> ' . __('ex: #1abc9c', 'lfb') . ' : #bdc3c7</small>
                                </div>     
                            </div>              
                            
                            <div class="col-md-4" >
                                
                                <div class="form-group" >
                                    <label > ' . __('Background color', 'lfb') . ' </label >
                                    <input type="text" name="colorPageBg" class="form-control colorpick" />
                                    <small> ' . __('ex: #ffffff', 'lfb') . ' : #ffffff</small>
                                </div>         
                                 <div class="form-group" >
                                      <label > ' . __('Texts color', 'lfb') . ' </label >
                                      <input type="text" name="colorC" class="form-control colorpick" />
                                      <small> ' . __('ex : #bdc3c7', 'lfb') . '</small>
                                  </div>                                  
                                <div class="form-group" >
                                    <label > ' . __('Secondary texts color', 'lfb') . ' </label >
                                    <input type="text" name="colorSecondaryTxt" class="form-control colorpick" />
                                    <small> ' . __('ex : #ffffff', 'lfb') . '</small>
                                </div>
                                                            
                                </div>
                            <div class="col-md-4">
                               
                                <div class="form-group" >
                                    <label > ' . __('Deselected switchbox circle color', 'lfb') . ' </label >
                                    <input type="text" name="colorCbCircle" class="form-control colorpick" />
                                    <small> ' . __('ex: #bdc3c7', 'lfb') . ' : #7f8c9a</small>
                                </div>        
                                    <div class="form-group" >
                                        <label > ' . __('Steps background color', 'lfb') . ' </label >
                                        <input type="text" name="colorBg" class="form-control colorpick" />
                                        <small> ' . __('ex : #ecf0f1', 'lfb') . '</small>
                                    </div> 
                                <div class="form-group" >
                                    <label > ' . __('Intro title & tooltips color', 'lfb') . ' </label >
                                    <input type="text" name="colorB" class="form-control colorpick" />
                                    <small> ' . __('ex : #34495e', 'lfb') . '</small>
                                </div>     
                                
                            </div>
                            
                    </div>
                    <div class="row-fluid">
                    <div class="col-md-4">
                                <div class="form-group">
                                    <label>' . __('Use Google font ?', 'lfb') . '</label>
                                    <input type="checkbox"  name="useGoogleFont" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />   
                                    <small>' . __('If disabled, the default theme font will be used', 'lfb') . '</small>
                                </div>
                                <div class="form-group" >
                                       <label> ' . __('Google font name', 'lfb') . ' </label>
                                       <input type="text" name="googleFontName" style="width:226px;"  class="form-control"/>
                                       <small> ' . __('ex : Lato', 'lfb') . '</small>
                                   <a href="https://www.google.com/fonts" target="_blank"  data-toggle="tooltip" title="' . __('See Google fonts', 'lfb') . '" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-list"></span></a>
 
                               </div>
                               <div class="form-group" >
                                <label> ' . __('Quantity selection style', 'lfb') . ' </label >
                                <select  name="qtType" class="form-control">
                                    <option value="0" > ' . __('Buttons', 'lfb') . ' </option >
                                    <option value="1" > ' . __('Field', 'lfb') . ' </option >
                                    <option value="2" > ' . __('Slider', 'lfb') . ' </option >
                                </select >
                                <small> ' . __('If "field", tooltip will be positionned on top', 'lfb') . ' </small>
                            </div>
                              <div class="form-group" >
                                    <label> ' . __('Image selection style', 'lfb') . ' </label >
                                     <select name="imgIconStyle" class="form-control" >
                                        <option value="circle">' . __('Circle', 'lfb') . '</option>
                                        <option value="zoom">' . __('Zoom', 'lfb') . '</option>
                                     </select>
                                </div>
                                 <div class="form-group" >
                                    <label> ' . __('Style of fields', 'lfb') . ' </label >
                                     <select name="fieldsPreset" class="form-control">
                                        <option value="">' . __('Flat', 'lfb') . '</option>
                                        <option value="light">' . __('Light', 'lfb') . '</option>
                                     </select>
                                </div>        
                                 <div class="form-group" >
                                    <label> ' . __('Style of image titles', 'lfb') . ' </label >
                                     <select  name="imgTitlesStyle" class="form-control">
                                        <option value="">' . __('Tooltip', 'lfb') . '</option>
                                        <option value="static">' . __('Static', 'lfb') . '</option>
                                     </select>
                                </div>   
                                
                            <div class="form-group" >
                                <label > ' . __('Animations speed', 'lfb') . ' </label >
                                     <select name="animationsSpeed" class="form-control" >
                                        <option value="0">' . __('Immediate', 'lfb') . '</option>
                                        <option value="0.1">' . __('Very fast', 'lfb') . '</option>
                                        <option value="0.2">' . __('Fast', 'lfb') . '</option>
                                        <option value="0.3">' . __('Default', 'lfb') . '</option>
                                        <option value="0.5">' . __('Slow', 'lfb') . '</option>
                                        <option value="0.7">' . __('Very slow', 'lfb') . '</option>
                                     </select>
                                <small> ' . __('This option sets the speed of the form animations', 'lfb') . ' </small>
                            </div>   
                            
                              <div class="form-group" >
                                <label > ' . __('Main title html tag', 'lfb') . ' </label >
                                     <select name="mainTitleTag" class="form-control" >
                                        <option value="h1">h1</option>
                                        <option value="h2">h2</option>
                                        <option value="h3">h3</option>
                                        <option value="div">div</option>
                                     </select>
                            </div>                          

                                
                                 <div class="form-group" >
                                <label > ' . __('Step titles html tag', 'lfb') . ' </label >
                                     <select name="stepTitleTag" class="form-control">
                                        <option value="h1">h1</option>
                                        <option value="h2">h2</option>
                                        <option value="h3">h3</option>
                                        <option value="div">div</option>
                                     </select>
                            </div>            
                              </div>
                              <div class="col-md-4">         
                              

                                <div class="form-group" >
                                    <label > ' . __('Background image', 'lfb') . ' </label >
                                    <input type="text" name="backgroundImg" class="form-control lfb_fieldImg" />                   
                                     <a class="btn btn-default btn-circle imageBtn"  data-toggle="tooltip" title="' . __('Upload Image', 'lfb') . '"><span class="fas fa-cloud-upload-alt"></span></a>
                                    <small display: block;> ' . __('Select an image', 'lfb') . ' </small>
                                </div>
                                <div class="form-group" >
                                    <label > ' . __('Show labels inline', 'lfb') . ' </label >
                                    <input name="inlineLabels" type="checkbox"  data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                    <small> ' . __('Activating this option, the labels will be displayed at left of the fields', 'lfb') . '</small>
                                </div>
                                

                             <div class="form-group" >
                                    <label> ' . __('Next step icon', 'lfb') . ' </label>
                                <input type="text" class="form-control" name="nextStepButtonIcon" placeholder="fa fa-rocket" data-iconfield="1"  />
                                <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-search"></span></a>
                            </div>';

            echo '
                              <div class="form-group" >
                                    <label > ' . __('Scroll to the top of the page on new step ?', 'lfb') . ' </label >
                                    <input name="scrollTopPage" type="checkbox"  data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />

                                    <small> ' . __('By default, the page scrolls at the top of the form at each step. By activating this option the scroll will go to the beginning of the page', 'lfb') . '</small>
                                </div>
                             <div class="form-group" >
                                    <label > ' . __('Scroll margin', 'lfb') . ' </label >
                                    <input type="number" name="scrollTopMargin" class="form-control" />
                                    <small> ' . __('Increase this value if your theme uses a fixed header', 'lfb') . '</small>
                                </div> 
                                <div class="form-group" >
                                    <label > ' . __('Columns width', 'lfb') . ' </label >
                                    <input type="number" name="columnsWidth" class="form-control" />
                                    <small> ' . __('Set 0 to use automatic widths', 'lfb') . '</small>
                                </div>
                                     <div class="form-group" >
                                    <label > ' . __('Images size', 'lfb') . ' </label >
                                    <input type="number" name="item_pictures_size" class="form-control" />
                                    <small> ' . __('Enter a size in pixels(ex : 64)', 'lfb') . ' </small>
                                </div>  
                                 <div class="form-group" >
                                    <label > ' . __('Show total price at bottom ?', 'lfb') . ' </label >
                                    <input type="checkbox"  name="showTotalBottom" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"class=""   />
                                    <small> ' . __('Display or hide the total price at bottom of each step', 'lfb') . ' </small>
                                </div>
                                
                                     <div class="form-group" >
                                    <label > ' . __('Tooltips width', 'lfb') . ' </label >
                                    <input type="number" name="tooltip_width" class="form-control" />
                                    <small> ' . __('Enter a size in pixels', 'lfb') . ' </small>
                                </div>       
                               
                                
                              </div>
                              <div class="col-md-4">
                              
                            <div class="form-group">
                                    <label>' . __('Flip effect on images ?', 'lfb') . '</label>
                                    <input type="checkbox"  name="enableFlipFX" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />   
                                    <small>' . __('A flip animation will be shown when an image is selected', 'lfb') . '</small>
                                </div>   
                                
                            <div class="form-group">
                                    <label>' . __('Shining effect on buttons', 'lfb') . '</label>
                                    <input type="checkbox"  name="enableShineFxBtn" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />   
                                    <small>' . __('It will apply a shining effect on the buttons', 'lfb') . '</small>
                                </div>   
                                                                
                            <div class="form-group">
                                    <label>' . __('Disable gray effect', 'lfb') . '</label>
                                    <input type="checkbox"  name="disableGrayFx" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />   
                                    <small>' . __('It will remove the grey tint when an image is selected', 'lfb') . '</small>
                                </div> 
                                
                            <div class="form-group">
                                    <label>' . __('Inverse gray effect', 'lfb') . '</label>
                                    <input type="checkbox"  name="inverseGrayFx" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />   
                                    <small>' . __('Apply the gray effect on unselected items ?', 'lfb') . '</small>
                                </div>   
                                
                                <div class="form-group" >
                                    <label > ' . __('Previous step link as button', 'lfb') . ' </label >
                                        
                                    <input name="previousStepBtn" type="checkbox"  data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  />
                                    <small> ' . __('It will show the revious step link as button', 'lfb') . '</small>
                                </div>
                                
                             <div class="form-group" >
                                    <label> ' . __('Previous step icon', 'lfb') . ' </label>
                                <input type="text" class="form-control" name="previousStepButtonIcon" placeholder="fa fa-rocket" data-iconfield="1"  />
                                <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-search"></span></a>
                            </div>';



            echo' <div class="form-group" >
                                    <label> ' . __('Final button icon', 'lfb') . ' </label>
                                <input type="text" class="form-control" name="finalButtonIcon" placeholder="fa fa-rocket" data-iconfield="1" />
                                <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-search"></span></a>
                            </div>';

            echo'  <div class="form-group" >
                                    <label > ' . __('Align the form to the left', 'lfb') . ' </label >
                                    <input  name="alignLeft" type="checkbox"  data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"/>
                                    <small> ' . __('It will align all elements to the left', 'lfb') . '</small>
                                </div> 
                                 
                                                  
                            <div class="form-group" >
                                <label > ' . __('Use default dropdowns', 'lfb') . ' </label >
                                <input type="checkbox"  name="disableDropdowns" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __("Activate this option if your select items don't work correctly", "lfb") . ' </small>
                            </div>
                                                         
                              </div>
                            </div>
                            
                            <div class="col-md-12">

                            <div class="form-group" >';
            echo '<a href="javascript:" id="lfb_openFormDesignBtn" onclick="lfb_openFormDesigner();" class="btn btn-default"><span class="fa fa-magic"></span>' . __('Form Designer', 'lfb') . '</a>';

            echo '<div class="clearfix"></div>';

            echo' <label style="margin-bottom: 18px;"> ' . __('Custom CSS rules', 'lfb') . ' </label >
                                <textarea name="customCss" class="form-control" ></textarea>
                                <small> ' . __('Enter your custom css code here', 'lfb') . '</small>
                            </div>
                            </div>
                              
                            
                    

                    <div class="clearfix" ></div>

                </div>
                
                <div role="tabpanel" class="tab-pane" id="lfb_tabCoupons" >
                    <div class="row-fluid">
                        <div class="col-md-6" >
                            <div class="form-group">
                                <label>' . __('Use discount coupons', 'lfb') . '</label>
                                <input type="checkbox"  name="useCoupons" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />   
                                <small>' . __('If you enable this option, a discount coupon field will be displayed at end of the form', 'lfb') . '</small>
                            </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="lfb_couponsContainer">
                                <div class="form-group">
                                   <label>' . __('Label of the coupon field', 'lfb') . '</label>
                                   <input type="text"  name="couponText" class="form-control" />   
                               </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="lfb_couponsContainer">
                                <p id="lfb_couponsTableBtns">
                                    <a href="javascript:" onclick="lfb_editCoupon(0);" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>' . __('Add a new coupon', 'lfb') . '</a>
                                    <a href="javascript:" onclick="lfb_removeAllCoupons();" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>' . __('Remove all coupons', 'lfb') . '</a>
                                </p>
                                <table id="lfb_couponsTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>' . __('Coupon code', 'lfb') . '</th>
                                            <th>' . __('Max uses', 'lfb') . '</th>
                                            <th>' . __('Number of uses', 'lfb') . '</th>                                                
                                            <th>' . __('Reduction', 'lfb') . '</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix" ></div>

                </div>


              ';


            echo' <div role="tabpanel" class="tab-pane" id="lfb_tabGDPR" >
            
                        <div class="row-fluid">
                        <div class="col-md-6">
                            <h4 class="lfb_noMarginBottom">' . __('GDPR compliance', 'lfb') . '</h4>
                                 <div class="form-group">
                           <label style="width: auto;">' . __('Allow users to manage their data ?', 'lfb') . '</label>
                            <input type="checkbox" data-switch="switch"  name="enableCustomersData"/>
                            
                                    <small> ' . __('The option "Enable customers account" must be activated in the global settings to use this option', 'lfb') . ' </small>
                            </div>                               
                            <div id="alertCustomerData" class="alert alert-info">
                                <p>' . __("A password will be generated and a link will be added at end of the customer's email to allow him to download his data, as well as giving him the possibility to make a deletion or modification request", 'lfb') . '</p>
                                <p style="text-align: center;margin-top: 12px;">
                                   <a href="javascript:" onclick="lfb_editCustomerDataSettings();" class="btn btn-default"><span style="margin-right: 6px;" class="fas fa-font"></span>' . __('Edit global texts', 'lfb') . '</a>
                                </p>                            
                            </div>  
                        </div>
                        
                        <div class="col-md-6">
 <div class="form-group" id="lfb_gdprDataLinkCt">
                           <label>' . __('Text to show at bottom of the customer email', 'lfb') . '</label>
                               <div id="lfb_variablesCustomersDataLink" class="palette palette-turquoise">                                    
                                    <p>
                                      <strong>[url]</strong> : ' . __('Url to the data management page', 'lfb') . '<br>                         
                                    </p>
                                </div>
                            <textarea class="form-control" name="customersDataEmailLink"></textarea>
                            </div>      
                        </div>
                        </div>
                        
                    
                        </div>
                    <div class="clearfix" ></div>
                    <div class="row-fluid">
                        <div class="col-md-6">                            
                           
                       </div>
                        <div class="col-md-6">   
                        
                        
                        </div>
                    <div class="clearfix" ></div>
                    </div>
                    <div class="row-fluid" id="lfb_gdprSettings">
                        <div class="col-md-6">
                            <h4 class="lfb_noMarginBottom">' . __('Data management page settings', 'lfb') . '</h4>
                        </div>
                        <div class="col-md-6"></div>
                    <div class="clearfix" ></div>
                        <div class="row-fluid">
                           <div class="alert alert-info">
                            <p class="text-center">
                            ' . __('These global settings are common to all forms', 'lfb') . '.<br/>
                             ' . __('These texts will be used on the page that allows the customer to manage his informations', 'lfb') . '   
                            </p>
                            </div>
                           
                           <div class="clearfix"></div>                    

                </div>
                </div>
                </div>
                </div>

		<p id="lfb_btnSaveFormCt"><a href="javascript:" onclick="lfb_saveForm();" class="btn btn-lg btn-primary" ><span class="glyphicon glyphicon-floppy-disk" ></span > ' . __('Save', 'lfb') . ' </a ></p >

            </div> ';
            echo '<div class="clearfix" ></div>';


            echo '<div role="tabpanel" class="tab-pane" id="lfb_tabDesigner" >
                    <div class="row-fluid">
                    </div>
                </div>
                <div class="clearfix"></div>
                
                ';

            echo '</div> ';


            // echo '</div> ';
            echo ' <div id="lfb_emailValueBubble" class="container-fluid" >
                <div>
                <div class="col-md-12" >
                    <div class="form-group" id="lfb_emailValueType">
                        <label > ' . __('Type of value', 'lfb') . ' </label >
                        <select name="valueType" class="form-control" />
                            <option value="">' . __('Item of the form', 'lfb') . '</option>
                            <option value="variable">' . __('Variable', 'lfb') . '</option>
                        
                        </select >
                    </div>
                    <div class="form-group" id="lfb_emailValueItemIDCt">
                        <label > ' . __('Select an item', 'lfb') . ' </label >
                        <select name="itemID" class="form-control" />
                        </select >
                    </div>
                    <div class="form-group" >
                        <label > ' . __('Select an attribute', 'lfb') . ' </label >
                        <select name="element" class="form-control" />
                            <option value="">' . __('Price', 'lfb') . '</option>
                            <option value="quantity">' . __('Quantity', 'lfb') . '</option>
                            <option value="title">' . __('Title', 'lfb') . '</option>
                            <option value="value">' . __('Value', 'lfb') . '</option>
                            <option value="image">' . __('Image', 'lfb') . '</option>
                        </select >
                    </div>
                    <div class="form-group" >
                        <label > ' . __('Variable', 'lfb') . ' </label >
                        <select name="variableID" class="form-control" />
                        </select >
                    </div>
                    <p class="text-center">
                        <a href="javascript:" class="btn btn-primary"  onclick="lfb_saveEmailValue();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Insert', 'lfb') . '</a>
                    </p>
                </div>
                </div> ';
            echo '</div>'; // eof win lfb_emailValueBubble


            echo '<div id="lfb_winLink" class="lfb_window container-fluid"> ';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise" ><span class="glyphicon glyphicon-pencil" ></span > ' . __('Edit a link', 'lfb');

            echo ' <div class="btn-toolbar"> ';
            echo '<div class="btn-group" > ';
            echo '<a class="btn btn-primary" href="javascript:" ><span class="glyphicon glyphicon-remove lfb_btnWinClose" ></span ></a > ';
            echo '</div> ';
            echo '</div> '; // eof toolbar
            echo '</div> '; // eof header

            echo '<div class="clearfix"></div><div class="container-fluid lfb_container" > ';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_linkTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Link conditions', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_linkTabGeneral" >';

            echo '<div id="lfb_linkInteractions" > ';
            echo '<div id="lfb_linkStepsPreview">
                <div id="lfb_linkOriginStep" class="lfb_stepBloc "><div class="lfb_stepBlocWrapper"><h4 id="lfb_linkOriginTitle"></h4></div> </div>
                <div id="lfb_linkStepArrow"></div>
                <div id="lfb_linkDestinationStep" class="lfb_stepBloc  "><div class="lfb_stepBlocWrapper"><h4 id="lfb_linkDestinationTitle"></h4></div></div>
              </div>';
            echo '<p>'
            . '<select id="lfb_linkOperator" class="form-control">'
            . '<option value="">' . __('All conditions must be filled', 'lfb') . '</option>'
            . '<option value="OR">' . __('One of the conditions must be filled', 'lfb') . '</option>'
            . '</select>'
            . '<a href="javascript:" class="btn btn-primary" onclick="lfb_addLinkInteraction();" ><span class="glyphicon glyphicon-plus" ></span > ' . __('Add a condition', 'lfb') . ' </a></p> ';
            echo '<table id="lfb_conditionsTable" class="table">
                <thead>
                    <tr>
                        <th>' . __('Element', 'lfb') . '</th>
                        <th>' . __('Condition', 'lfb') . '</th>
                        <th>' . __('Value', 'lfb') . '</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>';

            echo '<div class="row" ><div class="col-md-12" ><p id="lfb_winLinkBtnsCt" >'
            . '   <a href="javascript:" onclick="lfb_linkSave();" class="btn btn-primary" ><span class="glyphicon glyphicon-ok" ></span > ' . __('Save', 'lfb') . ' </a >
              <a href="javascript:" onclick="lfb_linkDel();" class="btn btn-danger"  ><span class="glyphicon glyphicon-trash" ></span > ' . __('Delete', 'lfb') . ' </a ></p ></div></div> ';

            echo '<div class="clearfix"></div>';
            echo '</div> '; // eof row
            echo '</div> '; // eof lfb_linkInteractions
            echo '</div> '; // eof tabpanel
            echo '</div> '; // eof tab-content
            echo '</div> '; // eof lfb_container

            echo '</div> '; //eof lfb_winLink
            // echo '</div> ';
            //  echo '</div> ';
            // echo '</div> ';// eof lfb_winLink



            echo '<div id="lfb_winRedirection" class="lfb_window container-fluid"> ';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise" ><span class="glyphicon glyphicon-pencil" ></span > ' . __('Edit a redirection', 'lfb');

            echo ' <div class="btn-toolbar"> ';
            echo '<div class="btn-group" > ';
            echo '<a class="btn btn-primary" href="javascript:" ><span class="glyphicon glyphicon-remove lfb_btnWinClose" ></span ></a > ';
            echo '</div> ';
            echo '</div> '; // eof toolbar
            echo '</div> '; // eof header

            echo '<div class="clearfix"></div><div class="container-fluid lfb_container" > ';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_redirTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Link conditions', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_redirTabGeneral" >';

            echo '<div id="lfb_redirInteractions" > ';
            echo '<div id="lfb_redirStepsPreview">
                <div id="lfb_showIcon"></div>
              </div>';
            echo '<p>'
            . '<div class="form-group">'
            . '<label>' . __('URL', 'lfb') . ' : </label>'
            . '<input type="text" id="lfb_redirUrl" class="form-control"/>'
            . '</div>'
            . '</p>';
            echo '<p>'
            . '<select id="lfb_redirOperator" class="form-control">'
            . '<option value="">' . __('All conditions must be filled', 'lfb') . '</option>'
            . '<option value="OR">' . __('One of the conditions must be filled', 'lfb') . '</option>'
            . '</select>'
            . '<a href="javascript:" class="btn btn-primary" onclick="lfb_addRedirInteraction();" ><span class="glyphicon glyphicon-plus" ></span > ' . __('Add a condition', 'lfb') . ' </a></p> ';
            echo '<table id="lfb_redirConditionsTable" class="table">
                <thead>
                    <tr>
                        <th>' . __('Element', 'lfb') . '</th>
                        <th>' . __('Condition', 'lfb') . '</th>
                        <th>' . __('Value', 'lfb') . '</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>';

            echo '<div class="row" ><div class="col-md-12" ><p id="lfb_redirSaveBtnCt">'
            . '   <a href="javascript:" onclick="lfb_redirSave();" class="btn btn-primary"><span class="glyphicon glyphicon-ok" ></span > ' . __('Save', 'lfb') . ' </a ></p ></div></div> ';

            echo '<div class="clearfix"></div>';
            echo '</div> '; // eof row
            echo '</div> '; // eof lfb_linkInteractions
            echo '</div> '; // eof tabpanel
            echo '</div> '; // eof tab-content
            echo '</div> '; // eof lfb_container

            echo '</div> '; //eof lfb_winRedirection


            echo '<div id="lfb_winCalculationConditions" class="lfb_window container-fluid"> ';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise" ><span class="glyphicon glyphicon-pencil" ></span > ' . __('Add a condition', 'lfb');

            echo ' <div class="btn-toolbar"> ';
            echo '<div class="btn-group" > ';
            echo '<a class="btn btn-primary" href="javascript:" ><span class="glyphicon glyphicon-remove lfb_btnWinClose" ></span ></a > ';
            echo '</div> ';
            echo '</div> '; // eof toolbar
            echo '</div> '; // eof header

            echo '<div class="clearfix"></div><div class="container-fluid lfb_container"   style="max-width: 90%;margin: 0 auto;margin-top: 18px;"> ';
            //echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_calcTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Conditions', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_calcTabGeneral" >';

            echo '<div id="lfb_calcInteractions" > ';
            echo '<div id="lfb_calcStepsPreview">
                <div id="lfb_calcIcon"></div>
              </div>';
            echo '<p>'
            . '<select id="lfb_calcOperator" class="form-control">'
            . '<option value="">' . __('All conditions must be filled', 'lfb') . '</option>'
            . '<option value="OR">' . __('One of the conditions must be filled', 'lfb') . '</option>'
            . '</select>'
            . '<a href="javascript:" class="btn btn-primary" onclick="lfb_addCalcInteraction();" ><span class="glyphicon glyphicon-plus" ></span > ' . __('Add a condition', 'lfb') . ' </a></p> ';
            echo '<table id="lfb_calcConditionsTable" class="table">
                <thead>
                    <tr>
                        <th>' . __('Element', 'lfb') . '</th>
                        <th>' . __('Condition', 'lfb') . '</th>
                        <th>' . __('Value', 'lfb') . '</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>';

            echo '<div class="row" ><div class="col-md-12" ><p style="padding-left: 16px;padding-right: 16px; text-align: center;">'
            . '   <a href="javascript:" onclick="lfb_calcConditionSave();" class="btn btn-primary" style="margin-top: 24px; margin-right: 8px; margin-top: 18px;" ><span class="glyphicon glyphicon-ok" ></span > ' . __('Save', 'lfb') . ' </a>';
            echo '<div class="clearfix"></div>';
            echo '</div> '; // eof row
            echo '<div class="clearfix"></div>';
            echo '</div> '; // eof lfb_calcInteractions
            echo '</div> '; // eof lfb_calcTabGeneral
            echo '</div> '; // eof tabpanel
            echo '</div> '; // eof tab-content
            echo '</div> '; // eof lfb_container
            echo '</div> '; // eof lfb_winCalculationConditions



            echo '<div id="lfb_winLayerShowConditions" class="lfb_window container-fluid"> ';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise" ><span class="glyphicon glyphicon-pencil" ></span > ' . __('Add a condition', 'lfb');

            echo ' <div class="btn-toolbar"> ';
            echo '<div class="btn-group" > ';
            echo '<a class="btn btn-primary" href="javascript:" ><span class="glyphicon glyphicon-remove lfb_btnWinClose" ></span ></a > ';
            echo '</div> ';
            echo '</div> '; // eof toolbar
            echo '</div> '; // eof header

            echo '<div class="clearfix"></div><div class="container-fluid lfb_container"   style="max-width: 90%;margin: 0 auto;margin-top: 18px;"> ';
            //echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_showTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Conditions', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_showTabGeneral" >';

            echo '<div id="lfb_showInteractions" > ';
            echo '<div id="lfb_showStepsPreview">
                <div id="lfb_showIcon"></div>
              </div>';
            echo '<p>'
            . '<select id="lfb_showLayerOperator" class="form-control">'
            . '<option value="">' . __('All conditions must be filled', 'lfb') . '</option>'
            . '<option value="OR">' . __('One of the conditions must be filled', 'lfb') . '</option>'
            . '</select>'
            . '<a href="javascript:" class="btn btn-primary" onclick="lfb_addShowLayerInteraction();" ><span class="glyphicon glyphicon-plus" ></span > ' . __('Add a condition', 'lfb') . ' </a></p> ';
            echo '<table id="lfb_showLayerConditionsTable" class="table">
                <thead>
                    <tr>
                        <th>' . __('Element', 'lfb') . '</th>
                        <th>' . __('Condition', 'lfb') . '</th>
                        <th>' . __('Value', 'lfb') . '</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>';

            echo '<div class="row" ><div class="col-md-12" ><p style="padding-left: 16px;padding-right: 16px; text-align: center;">'
            . '   <a href="javascript:" onclick="lfb_showLayerConditionSave();" class="btn btn-primary" style="margin-top: 24px; margin-right: 8px;" ><span class="glyphicon glyphicon-ok" ></span > ' . __('Save', 'lfb') . ' </a >';
            echo '<div class="clearfix"></div>';
            echo '</div> '; // eof row
            echo '</div> '; // eof lfb_calcInteractions
            echo '</div> '; // eof lfb_calcTabGeneral
            echo '</div> '; // eof tabpanel
            echo '</div> '; // eof tab-content
            echo '</div> '; // eof lfb_container
            echo '</div> '; // eof lfb_winLayerShowConditions


            echo '<div id="lfb_winShowConditions" class="lfb_window container-fluid"> ';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise" ><span class="glyphicon glyphicon-pencil" ></span > ' . __('Add a condition', 'lfb');

            echo ' <div class="btn-toolbar"> ';
            echo '<div class="btn-group" > ';
            echo '<a class="btn btn-primary" href="javascript:" ><span class="glyphicon glyphicon-remove lfb_btnWinClose" ></span ></a > ';
            echo '</div> ';
            echo '</div> '; // eof toolbar
            echo '</div> '; // eof header

            echo '<div class="clearfix"></div><div class="container-fluid lfb_container"   style="max-width: 90%;margin: 0 auto;margin-top: 18px;"> ';
            //echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_showTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Conditions', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_showTabGeneral" >';

            echo '<div id="lfb_showInteractions" > ';
            echo '<div id="lfb_showStepsPreview">
                <div id="lfb_showIcon"></div>
              </div>';
            echo '<p>'
            . '<select id="lfb_showOperator" class="form-control">'
            . '<option value="">' . __('All conditions must be filled', 'lfb') . '</option>'
            . '<option value="OR">' . __('One of the conditions must be filled', 'lfb') . '</option>'
            . '</select>'
            . '<a href="javascript:" class="btn btn-primary" onclick="lfb_addShowInteraction();" ><span class="glyphicon glyphicon-plus" ></span > ' . __('Add a condition', 'lfb') . ' </a></p> ';
            echo '<table id="lfb_showConditionsTable" class="table">
                <thead>
                    <tr>
                        <th>' . __('Element', 'lfb') . '</th>
                        <th>' . __('Condition', 'lfb') . '</th>
                        <th>' . __('Value', 'lfb') . '</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>';

            echo '<div class="row" ><div class="col-md-12" ><p style="padding-left: 16px;padding-right: 16px; text-align: center;">'
            . '   <a href="javascript:" onclick="lfb_showConditionSave();" class="btn btn-primary" style="margin-top: 24px; margin-right: 8px;" ><span class="glyphicon glyphicon-ok" ></span > ' . __('Save', 'lfb') . ' </a >';
            echo '<div class="clearfix"></div>';
            echo '</div> '; // eof row
            echo '</div> '; // eof lfb_calcInteractions
            echo '</div> '; // eof lfb_calcTabGeneral
            echo '</div> '; // eof tabpanel
            echo '</div> '; // eof tab-content
            echo '</div> '; // eof lfb_container
            echo '</div> '; // eof lfb_winShowConditions


            echo '<div id="lfb_winShowStepConditions" class="lfb_window container-fluid"> ';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise" ><span class="glyphicon glyphicon-pencil" ></span > ' . __('Add a condition', 'lfb');

            echo ' <div class="btn-toolbar"> ';
            echo '<div class="btn-group" > ';
            echo '<a class="btn btn-primary" href="javascript:" ><span class="glyphicon glyphicon-remove lfb_btnWinClose" ></span ></a > ';
            echo '</div> ';
            echo '</div> '; // eof toolbar
            echo '</div> '; // eof header

            echo '<div class="clearfix"></div><div class="container-fluid lfb_container"   style="max-width: 90%;margin: 0 auto;margin-top: 18px;"> ';
            //echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_showStepTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Conditions', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_showStepTabGeneral" >';

            echo '<div id="lfb_showStepInteractions" > ';
            echo '<div id="lfb_showStepStepsPreview">
                <div id="lfb_showIcon"></div>
              </div>';
            echo '<p>'
            . '<select id="lfb_showStepOperator" class="form-control">'
            . '<option value="">' . __('All conditions must be filled', 'lfb') . '</option>'
            . '<option value="OR">' . __('One of the conditions must be filled', 'lfb') . '</option>'
            . '</select>'
            . '<a href="javascript:" class="btn btn-primary" onclick="lfb_addShowStepInteraction();" ><span class="glyphicon glyphicon-plus" ></span > ' . __('Add a condition', 'lfb') . ' </a></p> ';
            echo '<table id="lfb_showStepConditionsTable" class="table">
                <thead>
                    <tr>
                        <th>' . __('Element', 'lfb') . '</th>
                        <th>' . __('Condition', 'lfb') . '</th>
                        <th>' . __('Value', 'lfb') . '</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>';

            echo '<div class="row" ><div class="col-md-12" ><p style="padding-left: 16px;padding-right: 16px; text-align: center;">'
            . '   <a href="javascript:" onclick="lfb_showStepConditionSave();" class="btn btn-primary" style="margin-top: 24px; margin-right: 8px;" ><span class="glyphicon glyphicon-ok" ></span > ' . __('Save', 'lfb') . ' </a >';
            echo '<div class="clearfix"></div>';
            echo '</div> '; // eof row
            echo '</div> '; // eof lfb_calcInteractions
            echo '</div> '; // eof lfb_calcTabGeneral
            echo '</div> '; // eof tabpanel
            echo '</div> '; // eof tab-content
            echo '</div> '; // eof lfb_container
            echo '</div> '; // eof lfb_winShowConditions

            echo '<div id="lfb_winCalendars" class="lfb_window container-fluid">';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise"><span class="fa fa-calendar"></span>' . __('View calendars', 'lfb');
            echo '<div class="btn-toolbar">';
            echo '<div class="btn-group">';
            echo '<a class="btn btn-primary" href="javascript:" data-action="closeCalendar"><span class="glyphicon glyphicon-remove lfb_btnWinClose"></span></a>';
            echo '</div>';
            echo '</div>'; // eof toolbar
            echo '</div>'; // eof header

            echo '<div id="lfb_winCalendarTopMenu">';
            echo '<div id="lfb_winCalendarTopMenuleft">';

            echo '<label>' . __('Calendar', 'lfb') . ' :</label>';
            echo '<select class="form-control" id="lfb_selectCalendar">';

            $table_name = $wpdb->prefix . "wpefc_calendars";
            $calendars = $wpdb->get_results("SELECT * FROM $table_name  ORDER BY title ASC");
            foreach ($calendars as $value) {
                echo '<option value="' . $value->id . '">' . $value->title . '</option>';
            }
            echo '</select>';
            echo '<a href="javascript:" onclick="lfb_addNewCalendar();" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-plus"></span></a>';
            echo '<a href="javascript:" id="lfb_btnDeleteCalendar" onclick="lfb_askDeleteCalendar();" class="btn btn-danger btn-circle" disabled><span class="glyphicon glyphicon-trash"></span></a>';

            echo '</div>'; // eof lfb_winCalendarTopMenuleft

            echo '<a href="javascript:" data-action="openCalEventsCats" class="btn btn-circle btn-default" data-toggle="tooltip" title="' . __('Events categories', 'lfb') . '" data-placement="left"><span class="fa fa-tags"></span></a>';
            echo '<a href="javascript:"  data-action="openCalDefReminders"   class="btn btn-circle btn-default" data-toggle="tooltip" title="' . __('Default reminders', 'lfb') . '" data-placement="left"><span class="fa fa-bell"></span></a>';
            echo '<a href="javascript:" data-action="openCalDaysWeek"  class="btn btn-circle btn-default" data-toggle="tooltip" title="' . __('Available days of week', 'lfb') . '" data-placement="left"><span class="fa fa-calendar-check"></span></a>';
            echo '<a href="javascript:" data-action="openCalHours" class="btn btn-circle btn-default" data-toggle="tooltip" title="' . __('Available hours', 'lfb') . '" data-placement="left"><span class="fa fa-clock"></span></a>';
            echo '<a href="javascript:" data-action="exportCalCsv" class="btn btn-circle btn-default" data-toggle="tooltip" title="' . __('Export events', 'lfb') . '" data-placement="left"><span class="fas fa-cloud-download-alt"></span></a>';



            echo '</div>'; // eof lfb_winCalendarTopMenu

            echo '<div class="clearfix"></div>';


            echo '<div id="lfb_calendarEventsCategories" class="lfb_lPanel lfb_lPanelLeft">';
            echo '<div class="lfb_lPanelHeader">'
            . '<span class="fa fa-calendar-tags"></span><span id="lfb_lPanelHeaderTitle">' . __('Events categories', 'lfb') . '</span>
                <a href="javascript:" id="lfb_lPanelHeaderCloseBtn" onclick="lfb_closeEventsCategories();" class="btn btn-default btn-circle btn-inverse"><span class="glyphicon glyphicon-remove"></span></a>
              </div>';
            echo '<div class="lfb_lPanelBody">';
            echo '<table id="lfb_calendarEventsCatsTable" class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>' . __('Title', 'lfb') . '</th>';
            echo '<th>' . __('Color', 'lfb') . '</th>';
            echo '<th class="lfb_calReminderActionTd"><a href="javascript:" onclick="lfb_editCalendarCat(0);" style="float: right;" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-plus"></span></a></th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';  // eof lfb_calendarEventsCatsTable      

            echo '</div>';  // eof lfb_lPanelBody       
            echo '</div>'; // eof lfb_calendarEventsCategories

            echo '<div id="lfb_calendarHoursEnabled" class="lfb_lPanel lfb_lPanelLeft">';
            echo '<div class="lfb_lPanelHeader">'
            . '<span class="fa fa-clock-o"></span><span id="lfb_lPanelHeaderTitle">' . __('Available hours', 'lfb') . '</span>
                <a href="javascript:" id="lfb_lPanelHeaderCloseBtn" onclick="lfb_closeLeftPanel(\'lfb_calendarHoursEnabled\');" class="btn btn-default btn-circle btn-inverse"><span class="glyphicon glyphicon-remove"></span></a>
              </div>';
            echo '<div class="lfb_lPanelBody">';

            echo '<table id="lfb_calendarHoursEnabledTable" class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>' . __('Hour', 'lfb') . '</th>';
            echo '<th>' . __('Available', 'lfb') . '</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            for ($i = 0; $i < 24; $i++) {
                echo '<tr data-hour="' . $i . '">';
                $hour = $i;
                if (strpos(strtolower(get_option('date_format')), 'g') > -1) {
                    if ($hour > 12) {
                        $hour = ($hour - 12) . ' PM';
                    } else {
                        $hour .= ' AM';
                    }
                }
                echo '<td>' . $hour . '</th>';
                echo '<td><input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="available" /></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';

            echo '<p style="margin-top: 20px;"><a href="javascript:" onclick="lfb_saveCalendarHoursDisabled();" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a></p>';

            echo '</div>';  // eof lfb_lPanelBody       
            echo '</div>'; // eof lfb_calendarDaysWeek

            echo '<div id="lfb_calendarDaysWeek" class="lfb_lPanel lfb_lPanelLeft">';
            echo '<div class="lfb_lPanelHeader">'
            . '<span class="fa fa-calendar-times-o"></span><span id="lfb_lPanelHeaderTitle">' . __('Available days of week', 'lfb') . '</span>
                <a href="javascript:" id="lfb_lPanelHeaderCloseBtn" onclick="lfb_closeLeftPanel(\'lfb_calendarDaysWeek\');" class="btn btn-default btn-circle btn-inverse"><span class="glyphicon glyphicon-remove"></span></a>
              </div>';
            echo '<div class="lfb_lPanelBody">';

            echo '<table id="lfb_calendarDaysWeekTable" class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>' . __('Day', 'lfb') . '</th>';
            echo '<th>' . __('Available', 'lfb') . '</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            echo '<tr data-day="0">';
            echo '<td>Sunday</th>';
            echo '<td><input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="available" /></td>';
            echo '</tr>';
            echo '<tr data-day="1">';
            echo '<td>Monday</th>';
            echo '<td><input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="available" /></td>';
            echo '</tr>';
            echo '<tr data-day="2">';
            echo '<td>Tuesday</th>';
            echo '<td><input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="available" /></td>';
            echo '</tr>';
            echo '<tr data-day="3">';
            echo '<td>Wednesday</th>';
            echo '<td><input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="available" /></td>';
            echo '</tr>';
            echo '<tr data-day="4">';
            echo '<td>Thursday</th>';
            echo '<td><input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="available" /></td>';
            echo '</tr>';
            echo '<tr data-day="5">';
            echo '<td>Friday</th>';
            echo '<td><input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="available" /></td>';
            echo '</tr>';
            echo '<tr data-day="6">';
            echo '<td>Saturday</th>';
            echo '<td><input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="available" /></td>';
            echo '</tr>';

            echo '</tbody>';
            echo '</table>';

            echo '<p style="margin-top: 20px;"><a href="javascript:" onclick="lfb_saveCalendarDaysWeek();" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a></p>';

            echo '</div>';  // eof lfb_lPanelBody       
            echo '</div>'; // eof lfb_calendarDaysWeek


            echo '<div id="lfb_calendarDefaultReminders" class="lfb_lPanel lfb_lPanelLeft">';
            echo '<div class="lfb_lPanelHeader">'
            . '<span class="fa fa-bell"></span><span id="lfb_lPanelHeaderTitle">' . __('Default reminders', 'lfb') . '</span>
                <a href="javascript:" id="lfb_lPanelHeaderCloseBtn" onclick="lfb_closeLeftPanel(\'lfb_calendarDefaultReminders\');" class="btn btn-default btn-circle btn-inverse"><span class="glyphicon glyphicon-remove"></span></a>
              </div>';
            echo '<div class="lfb_lPanelBody">';

            echo '<div class="alert alert-info">';
            echo '<p>' . __('These reminders will be automatically applied to the new events generated by orders', 'lfb') . '</p>';
            echo '</div>';

            echo '<div class="form-group" style="margin-top: 18px;">';
            echo '<table id="lfb_calEventRemindersTableDefault" class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>' . __('Reminders', 'lfb') . '</th>';
            echo '<th><a href="javascript:" onclick="lfb_editCalendarReminder(0);" style="float: right;" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-plus"></span></a></th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<tr><td colspan="2">' . __('There is no reminders yet', 'lfb') . '</td>';
            echo '</body>';
            echo '</table>';
            echo '</div>';

            echo '</div>';  // eof lfb_lPanelBody       
            echo '</div>'; // eof lfb_calendarDefaultReminders

            echo '<div id="lfb_calendarLeftMenu" class="lfb_lPanel lfb_lPanelLeft">';
            echo '<div class="lfb_lPanelHeader">'
            . '<span class="fa fa-calendar-check-o"></span><span id="lfb_lPanelHeaderTitle">' . __('Edit an event', 'lfb') . '</span>
                <a href="javascript:" id="lfb_lPanelHeaderCloseBtn" onclick="lfb_closeLeftPanel(\'lfb_calendarLeftMenu\');" class="btn btn-default btn-circle btn-inverse"><span class="glyphicon glyphicon-remove"></span></a>
              </div>';
            echo '<div class="lfb_lPanelBody">';
            echo '<div class="form-group">';
            echo '<label>' . __('Title', 'lfb') . '</label>';
            echo '<input type="text" class="form-control" name="title" />';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label>' . __('Category', 'lfb') . '</label>';
            echo '<select class="form-control" name="categoryID">';
            $table_name = $wpdb->prefix . "wpefc_calendarCategories";
            $cats = $wpdb->get_results("SELECT * FROM $table_name ORDER BY title ASC");
            foreach ($cats as $cat) {
                echo '<option value="' . $cat->id . '">' . $cat->title . '</option>';
            }
            echo '</select>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label>' . __('Start date', 'lfb') . '</label>';
            echo '<input type="text" class="form-control lfb_datetimepicker" name="start" />';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label>' . __('End date', 'lfb') . '</label>';
            echo '<input type="text" class="form-control lfb_datetimepicker" name="end" />';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label>' . __('Full day', 'lfb') . '</label>';
            echo '<input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="allDay" />';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label>' . __('Busy date', 'lfb') . '</label>';
            echo '<input type="checkbox"  data-toggle="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="isBusy" />';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label>' . __('Corresponding order', 'lfb') . '</label>';
            echo '<select class="form-control" name="orderID">';
            echo '<option value="0">' . __('Nothing', 'lfb') . '</option>';

            $table_name = $wpdb->prefix . "wpefc_forms";
            $formsCal = $wpdb->get_results("SELECT id FROM $table_name ORDER BY id DESC");
            foreach ($formsCal as $formCal) {
                $logs = $wpdb->get_results($wpdb->prepare("SELECT id,formID,checked,ref,customerID FROM " . $wpdb->prefix . "wpefc_logs WHERE formID=%s AND checked=1 ORDER BY id DESC", $formCal->id));
                foreach ($logs as $log) {
                    echo '<option value="' . $log->id . '" data-customerid="' . $log->customerID . '">' . $form->title . ' : ' . $log->ref . '</option>';
                }
            }
            echo '</select>';
            echo '<a href="javascript:" style="margin-top:0px;" onclick="lfb_btnCalEventViewOrderClick();" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-eye-open"></span></a>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label>' . __('Customer', 'lfb') . '</label>';
            echo '<select class="form-control" name="customerID">';
            echo '<option value="0">' . __('Nothing', 'lfb') . '</option>';

            $table_name = $wpdb->prefix . "wpefc_customers";
            $customers = $wpdb->get_results("SELECT id,firstName,lastName,email FROM $table_name ORDER BY firstName ASC");
            foreach ($customers as $customer) {
                echo '<option value="' . $customer->id . '">' . $this->parent->stringDecode($customer->firstName, $settings->encryptDB) . ' ' . $this->parent->stringDecode($customer->lastName, $settings->encryptDB) . ' (' . $this->parent->stringDecode($customer->email, $settings->encryptDB) . ') </option>';
            }
            echo '</select>';
            echo '<a href="javascript:" style="margin-top:0px;" onclick="lfb_btnCalEventViewCustomerClick();" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-eye-open"></span></a>';
            echo '</div>';



            echo '<div class="form-group">';
            echo '<label>' . __('Address', 'lfb') . '</label>';
            echo '<input type="text" class="form-control" name="customerAddress" />';
            echo '<a href="javascript:"  onclick="lfb_calendarEventViewGmap();" style="margin-top:-2px;" class="btn btn-default btn-circle"><span class="fa fa-map-marker"></span></a>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label>' . __('Customer email', 'lfb') . '</label>';
            echo '<input type="email" class="form-control" name="customerEmail" />';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label>' . __('Notes', 'lfb') . '</label>';
            echo '<textarea class="form-control" name="notes"></textarea>';
            echo '</div>';

            echo '<div class="form-group" style="margin-top: 18px;">';
            echo '<table id="lfb_calEventRemindersTable" class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>' . __('Reminders', 'lfb') . '</th>';
            echo '<th><a href="javascript:" onclick="lfb_editCalendarReminder(0);" style="float: right;" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-plus"></span></a></th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<tr><td colspan="2">' . __('There is no reminders yet', 'lfb') . '</td>';
            echo '</body>';
            echo '</table>';
            echo '</div>';

            echo '<p style="margin-top: 20px;"><a href="javascript:" onclick="lfb_saveCalendarEvent();" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a></p>';
            echo '<p><a href="javascript:" onclick="lfb_deleteCalendarEvent();" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a></p>';

            echo '</div>';  // eof lfb_lPanelBody
            echo '</div>'; // eof lfb_calendarleftMenu
            echo '<div id="lfb_calendar" class="lfb_lPanel lfb_lPanelMain"></div>';

            echo '</div>'; // eof lfb_winCalendars

            echo '<div id="lfb_winLog" class="lfb_window container-fluid">';

            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise"><span class="glyphicon glyphicon-pencil"></span>' . __('View orders of this form', 'lfb');

            echo '<div class="btn-toolbar">';
            echo '<div class="btn-group">';
            echo '<a onclick="lfb_closeLog();" class="btn btn-primary" href="javascript:"><span class="glyphicon glyphicon-remove lfb_btnWinClose"></span></a>';
            echo '</div>';
            echo '</div>'; // eof toolbar
            echo '</div>'; // eof header

            echo '<div class="clearfix"></div>';
            echo '<div class="lfb_menuBar">';
            echo '<div id="lfb_orderStatusCt"><label>' . __('Order status', 'lfb') . '</label><select name="orderStatus" class="form-control">'
            . ' <option value="canceled">' . __('Canceled', 'lfb') . '</option>
                <option value="pending">' . __('Pending', 'lfb') . '</option>
                <option value="beingProcessed">' . __('Being processed', 'lfb') . '</option>
                <option value="shipped">' . __('Shipped', 'lfb') . '</option>                                            
                <option value="completed">' . __('Completed', 'lfb') . '</option>'
            . '</select></div>';
            echo '<a href="javascript:" class="btn btn-primary" data-action="editOrder" ><span class="glyphicon glyphicon-pencil"></span>' . __('Edit', 'lfb') . '</a>';
            echo '<a href="javascript:" class="btn btn-primary" data-action="sendOrderByEmail"><span class="fa fa-envelope"></span>' . __('Send by email', 'lfb') . '</a>';
            echo '<a href="javascript:" class="btn btn-primary" data-action="downloadOrder"><span class="glyphicon glyphicon-cloud-download"></span>' . __('Download as PDF', 'lfb') . '</a>';
            echo '<a href="javascript:" class="btn btn-primary" data-action="returnOrders"><span class="glyphicon glyphicon-arrow-left"></span>' . __('Return', 'lfb') . '</a>';


            echo '</div>'; // eof .lfb_menuBar        

            echo '<div class="clearfix"></div>';
            echo '<div class="container-fluid  lfb_container"  style="max-width: 90%;margin: 0 auto;margin-top: 18px;">';
            echo '<div class="lfb_logContainer">';

            echo '</div>'; // eof .lfb_logContainer

            echo '<div class="lfb_logEditorContainer">'
            . '<div id="lfb_editorLog"></div>'
            . '<p style="text-align: left;" class="lfb_editorLogBtns">'
            . '<a href="javascript:" class="btn btn-default" onclick="lfb_orderAddRow();"><span class="glyphicon glyphicon-plus"></span>' . __('Add a row to the summary', 'lfb') . '</a>'
            . '<a href="javascript:" class="btn btn-default" onclick="lfb_orderAddStepRow();"><span class="glyphicon glyphicon-plus"></span>' . __('Add a step row to the summary', 'lfb') . '</a>'
            . '<a href="javascript:" class="btn btn-default" onclick="lfb_openWinModifyTotal();"><span class="glyphicon glyphicon-usd"></span>' . __('Modify the total', 'lfb') . '</a>'
            . '<a href="javascript:" style="float:right;" class="btn btn-primary" onclick="lfb_saveLog(false);"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a>'
            . '</p>'
            . '</div>';
            echo '</div>'; // eof .lfb_container

            echo' </div>'; // eof #lfb_winLog

            echo '<div id="lfb_winSaveBeforeSendOrder" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">' . __('Save modifications before sending ?', 'lfb') . '</h4>
                        </div>
                        <div class="modal-body">
                            <p>' . __('Do you want to save the modifications before sending this order ?', 'lfb') . '</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" onclick="lfb_saveLog(true);" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>' . __('Yes', 'lfb') . '</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="lfb_orderModified=false;lfb_openWinSendOrderEmail();"><span class="glyphicon glyphicon-remove"></span>' . __('No', 'lfb') . '</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->';


            echo '<div id="lfb_winSendOrberByEmail" class="modal fade ">
                         <div class="modal-dialog">
                           <div class="modal-content">
                             <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               <h4 class="modal-title">' . __('Send an order', 'lfb') . '</h4>
                            </div>
                            <div class="modal-body" style="padding-bottom: 0px;">
                                <div class="form-group">
                                    <label>' . __('Recipients', 'lfb') . '</label>
                                    <textarea name="recipients" class="form-control" style="height: 64px;"></textarea>
                                    <small>' . __('Enter the recipients emails separated by commas', 'lfb') . '</small>
                                </div>
                                 <div class="form-group">
                                    <label>' . __('Customer email subject', 'lfb') . '</label>
                                    <input name="subject" class="form-control"/>
                                    <small>' . __('Something like "Order confirmation"', 'lfb') . '</small>
                                </div>
                                <div class="form-group">
                                    <label style="margin-right: 24px;">' . __('Send the order as pdf', 'lfb') . '</label>'
            . '<input type="checkbox"  name="generatePdf" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
 <small>' . __('A pdf file will be generated and sent as attachment', 'lfb') . '</small>
                                </div>
                                
                            <div class="form-group" >
                                <label style="margin-right: 24px;"> ' . __('Add payment link', 'lfb') . ' </label >
                                <input type="checkbox"  name="addPaymentLink" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                                <small> ' . __('A link will be added to allow the customer to pay for this order', 'lfb') . ' </small>
                            </div>
                            
                            </div>
                            <div class="modal-footer" style="text-align: center;">
                                 <a href="javascript:" class="btn btn-primary"  onclick="lfb_sendOrderByEmail();"><span class="fa fa-envelope"></span>' . __('Send by email', 'lfb') . '</a>

                            </div>
                           </div><!-- /.modal-content -->
                         </div><!-- /.modal-dialog -->
                       </div><!-- /.modal -->';

            echo $this->renderStepVisualBuilder();

            echo '<div id="lfb_winStep" class="lfb_window container-fluid">';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise"><span class="glyphicon glyphicon-pencil"></span>' . __('Edit a step', 'lfb');

            echo '<div class="btn-toolbar">';
            echo '<div class="btn-group">';
            echo '<a class="btn btn-primary" href="javascript:"><span class="glyphicon glyphicon-remove lfb_btnWinClose"></span></a>';
            echo '</div>';
            echo '</div>'; // eof toolbar
            echo '</div>'; // eof header
            echo '<div class="clearfix"></div>';
            echo '<div class="container-fluid  lfb_container"  style="max-width: 90%;margin: 0 auto;margin-top: 18px;">';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_stepTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Step', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_stepTabGeneral" >';
            echo '<h4 style="padding-left: 14px; padding-right: 14px;">' . __('Step options', 'lfb') . ' </h4>';
            echo '<div class="col-md-3">';
            echo '<div class="form-group" >
                    <label> ' . __('Title', 'lfb') . ' </label >
                    <input type="text" name="title" class="form-control" maxlength="120" />
                    <small> ' . __('This is the step name', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Description', 'lfb') . ' </label >
                    <input type="text" name="description" class="form-control" />
                    <small> ' . __('A facultative description', 'lfb') . ' </small>
                </div>';

            echo '</div>'; // eof col-md-4
            echo '<div class="col-md-3">';

            echo '<div class="form-group" >
                    <label> ' . __('Max items per row', 'lfb') . ' </label >
                     <input type="number" name="itemsPerRow" class="form-control" min="0" />
                    <small> ' . __('Leave 0 to fill the full width', 'lfb') . ' </small>
                </div>
                ';

            echo '<div class="form-group" style="height: top: -18px;" >
                    <label> ' . __('Images size', 'lfb') . ' </label ><br/>
                    <input type="number" name="imagesSize" class="form-control" min="0" />
                    <small> ' . __('Enter a size in pixels(ex : 64)', 'lfb') . ' </small>
                </div>';
            echo '<div class="">
                    <label></label >
                    <textarea name="showConditions" style="display: none;"></textarea>
                    <input type="hidden" name="showConditionsOperator" style="display: none;"/>
                </div>';


            echo '</div>'; // eof col-md-4
            echo '<div class="col-md-3">';
            echo '<div class="form-group" style="height: 86px;" >
                    <label> ' . __('Show it depending on conditions ?', 'lfb') . ' </label ><br/>
                    <input type="checkbox"  name="useShowConditions" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    
                    <a href="javascript:" id="showConditionsStepBtn" onclick="lfb_editShowStepConditions();" class="btn btn-primary btn-circle" style="margin-left: 8px;"><span class="glyphicon glyphicon-pencil"></span></a>
                    <small> ' . __('This step will be displayed only if the conditions are filled', 'lfb') . ' </small>
                </div>
                <div class="form-group" style="height: 86px; margin-bottom: 0px;  top: -18px;" >
                    <label> ' . __('Show in email/summary ?', 'lfb') . ' </label ><br/>
                    <input type="checkbox"  name="showInSummary" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />

                    <!-- <select name="showInSummary" class="form-control" >
                        <option value="0" > ' . __('No', 'lfb') . ' </option >
                        <option value="1" > ' . __('Yes', 'lfb') . ' </option >
                    </select>-->
                    <small> ' . __('This step will be displayed in the summary', 'lfb') . ' </small>
                </div>';


            echo '</div>'; // eof col-md-3
            echo '<div class="col-md-3">';

            echo '<div class="form-group" style="height: 86px; margin-bottom: 0px; ">
                    <label> ' . __('Selection required', 'lfb') . ' </label ><br/>
                    <input type="checkbox"  name="itemRequired" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    
                    <small> ' . __('If true, the user must select at least one item to continue', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" style="height: 86px; margin-bottom: 34px;" >
                    <label> ' . __('Hide the next step button ?', 'lfb') . ' </label ><br/>
                    <input type="checkbox"  name="hideNextStepBtn" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                </div>';

            echo '</div>'; // eof col-md-3
            echo '<div class="col-md-12" style="padding-left: 14px; padding-right: 14px;">';
            echo '<p style="text-align:center;"><a href="javascript:" class="btn btn-primary" onclick="lfb_saveStep();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a></p>';
            echo '</div>'; // eof col-md-12
            echo '<div class="clearfix"></div>';


            echo '<div role="tabpanel" id="lfb_itemsList" style="margin-top: 24px;padding-left: 14px; padding-right: 14px;">';
            echo '<h4>' . __('Items List', 'lfb') . ' </h4>';
            echo '<div id="lfb_itemTab" >';
            echo '<div class="col-md-12" style="padding: 0px;">';
            echo '<p style="padding-top: 16px;"><a href="javascript:" onclick="lfb_editItem(0);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a new Item', 'lfb') . '</a></p>';
            echo '<table id="lfb_itemsTable" class="table">';
            echo '<thead>
                <th>' . __('Title', 'lfb') . '</th>
                <th>' . __('Type', 'lfb') . '</th>
                <th>' . __('Group', 'lfb') . '</th>
                <th class="lfb_actionTh">' . __('Actions', 'lfb') . '</th>
            </thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';
            echo '</div>'; // eof col-md-12
            echo '<div class="clearfix"></div>';
            echo '</div>'; // eof lfb_itemTab
            echo '</div>'; // eof tabpanel

            echo '</div>'; // eof lfb_stepTabGeneral
            echo '</div>'; // eof tab-content
            echo '</div>'; // eof tabpanel

            echo '</div>'; // eof lfb_container
            echo '</div>'; // eof win step


            echo '<div id="lfb_winItem" class="lfb_window container-fluid">';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise"><span class="glyphicon glyphicon-pencil"></span>' . __('Edit an item', 'lfb');

            echo '<div class="btn-toolbar">';
            echo '<div class="btn-group">';
            echo '<a class="btn btn-primary" href="javascript:" onclick="lfb_closeItemWin();"><span class="glyphicon glyphicon-remove lfb_btnWinClose"></span></a>';
            echo '</div>';
            echo '</div>'; // eof toolbar
            echo '</div>'; // eof header
            echo '<div class="clearfix"></div>';
            echo '<div class="container-fluid  lfb_container"  style="max-width: 90%;margin: 0 auto;margin-top: 18px;">';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_itemTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Item options', 'lfb') . ' </a ></li >
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_itemTabGeneral" >';
            echo '<div class="col-md-6">';
            echo '<div class="form-group" >
                    <label> ' . __('Title', 'lfb') . ' </label >
                    <input type="text" name="title" class="form-control"   maxlength="120" />
                    <small> ' . __('This is the item name', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Step', 'lfb') . ' </label >
                    <select name="stepID" class="form-control">
                    </select>
                    <small> ' . __('The step that contains this element', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Type', 'lfb') . ' </label >
                    <select name="type" class="form-control">

                        <option value="button">' . __('Button', 'lfb') . '</option>
                        <option value="checkbox">' . __('Checkbox', 'lfb') . '</option>        
                        <option value="colorpicker" >' . __('Color picker', 'lfb') . '</option>   
                        <option value="datepicker">' . __('Date picker', 'lfb') . '</option>   
                        <option value="filefield">' . __('File field', 'lfb') . '</option> 
                        <option value="picture">' . __('Image', 'lfb') . '</option>
                        <option value="imageButton">' . __('Image with button', 'lfb') . '</option>                            
                        <option value="layeredImage">' . __('Layered image', 'lfb') . '</option>                                
                        <option value="numberfield">' . __('Number field', 'lfb') . '</option>
                        <option value="rate">' . __('Rate', 'lfb') . '</option>
                        <option value="richtext">' . __('Rich Text', 'lfb') . '</option>
                        <option value="select">' . __('Select field', 'lfb') . '</option>
                        <option value="separator">' . __('Separator', 'lfb') . '</option>  
                        <option value="shortcode">' . __('Shortcode', 'lfb') . '</option>   
                        <option value="slider">' . __('Slider', 'lfb') . '</option>
                        <option value="textarea">' . __('Text area', 'lfb') . '</option>
                        <option value="textfield">' . __('Text field', 'lfb') . '</option>       
                    </select>
                    <small> ' . __('Select a type of item', 'lfb') . ' </small>
                </div>';


            if (is_plugin_active('woocommerce/woocommerce.php')) {
                $disp = '';
            } else {
                $disp = 'style="display:none !important;"';
            }
            echo '<div class="form-group" ' . $disp . '>
                    <label ' . $disp . '> ' . __('Woocommerce product', 'lfb') . ' </label>
                        
                   <input name="wooVariation" class="form-control" type="hidden" />
                   <input name="wooProductID" class="form-control" type="hidden" />
                   <input ' . $disp . ' id="wooProductSelect" class="form-control" type="text" />
                        ';
            echo '       <small> ' . __('You can select a product from your catalog', 'lfb') . ' </small>
                </div>';

            if (is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')) {
                $dispEd = '';
            } else {
                $dispEd = 'style="display:none;"';
            }
            echo '<div ' . $dispEd . '> <div class="form-group" >
                    <label> ' . __('Easy Digital Product', 'lfb') . ' </label>
                   <select name="eddProductID" class="form-control">';

            echo '<option value="0"> ' . __('None', 'lfb') . '</option>';
            if (is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')) {
                $args = array(
                    'fields' => 'ids',
                    'post_type' => 'download',
                    'posts_per_page' => -1
                );


                $downloads = get_posts($args);
                foreach ($downloads as $key => $download_id) {
                    $download = new EDD_Download($download_id);
                    $argsI = array('post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $productI->ID);
                    $attachments = get_posts($argsI);
                    if ($attachments[0]) {
                        $imgDom = wp_get_attachment_image($attachments[count($attachments) - 1]->ID, 'thumbnail');
                        $img = substr($imgDom, strpos($imgDom, 'src="') + 5, strpos($imgDom, '"', stripos($imgDom, 'src="') + 6) - (strpos($imgDom, 'src="') + 5));

                        $dataImg = 'data-img="' . $img . '"';
                    }
                    if (count($download->prices) > 0) {
                        foreach ($download->prices as $key => $price) {
                            echo '<option value="' . $download_id . '" ' . $dataImg . ' data-title="' . $download->post_title . '" data-eddvariation="' . $key . '">' . $download->post_title . ' - ' . $price['name'] . '</option>';
                        }
                    } else {
                        echo '<option value="' . $download_id . '" ' . $dataImg . ' data-title="' . $download->post_title . '">' . $download->post_title . '</option>';
                    }
                }
            }

            echo '</select>'
            . ' <small> ' . __('You can select a product from your catalog', 'lfb') . ' </small>
                </div></div>';

            echo '<div class="form-group" >
                    <label style="vertical-align: sub;"> ' . __('Small description', 'lfb') . ' </label >
                    <textarea name="description" class="form-control" style="height: 42px;" ></textarea>
                    <small> ' . __('Item small description. You can leave it empty.', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label style="vertical-align: sub;"> ' . __('Notes', 'lfb') . ' </label >
                    <textarea name="notes" class="form-control" style="height: 58px;" ></textarea>
                    <small> ' . __('These notes are visible only by administrators', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Button text', 'lfb') . ' </label >
                    <input type="text" name="buttonText" class="form-control" />
                    <small> ' . __('The text displayed on the button', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Checkbox style', 'lfb') . ' </label >
                    <select name="checkboxStyle" class="form-control">
                        <option value="checkbox">' . __('Checkbox', 'lfb') . '</option>
                        <option value="switchbox">' . __('Switchbox', 'lfb') . '</option>
                    </select>
                    <small> ' . __('Choose the style of this checkbox', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Tooltip text', 'lfb') . ' </label >
                    <input type="text" name="tooltipText" class="form-control" />
                    <small> ' . __('A facultative tooltip', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group lfb_imageField" >
                    <label > ' . __('Tooltip image', 'lfb') . ' </label >
                    <input type="text" name="tooltipImage" class="form-control lfb_fieldImg" />                   
                     <a class="btn btn-default btn-circle imageBtn"  data-toggle="tooltip" title="' . __('Upload Image', 'lfb') . '"><span class="fas fa-cloud-upload-alt"></span></a>
                    <small display: block;> ' . __('Select an image', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Date type', 'lfb') . ' </label >
                    <select name="dateType" class="form-control">
                        <option value="date">' . __('Date', 'lfb') . '</option>
                        <option value="time">' . __('Time', 'lfb') . '</option>
                        <option value="dateTime">' . __('Date & Time', 'lfb') . '</option>
                    </select>
                    <small> ' . __('Defines the type of date selectable', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Disable minutes', 'lfb') . ' </label >
                    <input type="checkbox"  name="disableMinutes" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Calendar', 'lfb') . ' </label >
                    <select name="calendarID" class="form-control">';
            $table_name = $wpdb->prefix . "wpefc_calendars";
            $calendars = $wpdb->get_results("SELECT * FROM $table_name  ORDER BY title ASC");
            echo '<option value="0">' . __('Nothing', 'lfb') . '</option>';
            foreach ($calendars as $value) {
                echo '<option value="' . $value->id . '">' . $value->title . '</option>';
            }
            echo '</select>
            <a href="javascript:" style="margin-top:0px;" onclick="lfb_openCalendarPanelFromItem();" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <small> ' . __('The busy dates will be unavailable in the datepicker and an event will be stored in the calendar on each new order', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Register a new event ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="registerEvent" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('It will add a new event in the selected calendar', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Category of the event', 'lfb') . ' </label >
                    <select name="eventCategory" class="form-control"></select>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Event title', 'lfb') . ' </label >
                    <input type="text" name="eventTitle" class="form-control" />
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Set date as busy ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="eventBusy" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Max events at same time', 'lfb') . ' </label >
                    <input type="number" name="maxEvents" class="form-control" />
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Use as start date of a date range', 'lfb') . ' </label >
                    <input type="checkbox"  name="useAsDateRange" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Activate this option then select the datepicker that defines the end date to use as date range', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Datepicker that defines the end date', 'lfb') . ' </label >
                    <select name="endDaterangeID" class="form-control"></select>
                    <small> ' . __('Select the datepicker that defines the end date of the date range', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Event duration', 'lfb') . ' </label >
                    <input type="number" name="eventDuration" min="1" class="form-control" style="width: 80px; display: inline-block;" />
                    <select name="eventDurationType" class="form-control" style="width: 196px; display: inline-block;">
                        <option value="mins">' . __('Minutes', 'lfb') . '</option>
                        <option value="hours">' . __('Hours', 'lfb') . '</option>
                        <option value="days">' . __('Days', 'lfb') . '</option>
                    </select>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Group name', 'lfb') . ' </label >
                    <input type="text" name="groupitems" class="form-control" />
                    <small> ' . __('Only one of the items of a same group can be selected', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Minimum time', 'lfb') . ' </label >
                    <input type="text" name="minTime" class="form-control lfb_timepicker" />
                    <small> ' . __('Leave it empty to allow any selection', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Maximum time', 'lfb') . ' </label >
                    <input type="text" name="maxTime" class="form-control lfb_timepicker" />
                    <small> ' . __('Leave it empty to allow any selection', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Type of information', 'lfb') . ' </label >
                    <select name="fieldType" class="form-control">
                        <option value="">' . __('Other', 'lfb') . '</option>    
                        <option value="address">' . __('Address', 'lfb') . '</option>    
                        <option value="city">' . __('City', 'lfb') . '</option>       
                        <option value="company">' . __('Company', 'lfb') . '</option>   
                        <option value="country">' . __('Country', 'lfb') . '</option>      
                        <option value="email">' . __('Email', 'lfb') . '</option>      
                        <option value="firstName">' . __('First name', 'lfb') . '</option>  
                        <option value="job">' . __('Job', 'lfb') . '</option>      
                        <option value="phoneJob">' . __('Job phone', 'lfb') . '</option>      
                        <option value="lastName">' . __('Last name', 'lfb') . '</option>  
                        <option value="phone">' . __('Phone', 'lfb') . '</option>                          
                        <option value="state">' . __('State', 'lfb') . '</option>    
                        <option value="url">' . __('Website', 'lfb') . '</option>      
                        <option value="zip">' . __('Zip code', 'lfb') . '</option>                           
                    </select>
                    <small> ' . __('It will allow the plugin to recover this information', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Autocomplete', 'lfb') . ' </label >
                    <input type="checkbox" name="autocomplete" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('This option will activate the auto-completion of the address', 'lfb') . ' </small>
                
                    <div class="alert alert-info" style="margin-bottom: 0px; margin-top: 14px;">
                        <p style="text-align: center">' . __('To use the autocomplete option, you need to activate the Google Places API Web Service from your Google API console', 'lfb') . ': <br/><a href="https://developers.google.com/maps/documentation/javascript/places-autocomplete?hl=en" target="_blank">' . __('click here', 'lfb') . '</a>.</p>
                    </div>
                </div>';

            echo '<div class="form-group " >
                    <label> ' . __('Min size', 'lfb') . ' </label >
                    <input type="number" name="minSize" class="form-control" />
                    <small> ' . __('Fill this field to limit the minimum value allowed', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group " >
                    <label> ' . __('Max size', 'lfb') . ' </label >
                    <input type="number" name="maxSize" class="form-control" />
                    <small> ' . __('Fill this field to limit the maximum value allowed', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group " >
                    <label> ' . __('Value', 'lfb') . ' </label >
                    <input type="number" name="numValue" class="form-control" />
                    <small> ' . __('Defines the default value of this field', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group " >
                    <label> ' . __('Interval', 'lfb') . ' </label >
                    <input type="number" name="sliderStep" class="form-control" min="1" />
                    <small> ' . __('It defines the interval between each values of the element', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group " >
                    <label> ' . __('Country selection', 'lfb') . ' </label >
                    <input type="checkbox"  data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '"  name="isCountryList"  />
                    <small> ' . __('This select field will show all countries as options', 'lfb') . ' </small>
                </div>';


            echo '<div id="lfb_itemOptionsValuesPanel"><table id="lfb_itemOptionsValues" class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="3">' . __('Options of select field', 'lfb') . '</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<tr class="static">';
            echo '<td><div class="form-group" style="top: 10px;"><input type="text" id="option_new_value" class="form-control" value="" placeholder="' . __('Option value', 'lfb') . '"></div></td>'
            . '<td><div class="form-group" style="top: 10px;"><input type="number" id="option_new_price" step="any" class="form-control" value="0" placeholder="' . __('Option price', 'lfb') . '"></div></td>';
            echo '<td style="width: 200px;"><a href="javascript:" onclick="lfb_add_option();" class="btn btn-default"><span class="glyphicon glyphicon-plus" style="margin-right:8px;"></span>' . __('Add this option', 'lfb') . '</a></td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table></div>';



            echo '<div class="form-group picOnly lfb_imageField" >
                    <label > ' . __('Image', 'lfb') . ' </label >
                    <input type="text" name="image" class="form-control lfb_fieldImg"/>
                     <a class="btn btn-default btn-circle imageBtn"  data-toggle="tooltip" title="' . __('Upload Image', 'lfb') . '"><span class="fas fa-cloud-upload-alt"></span></a>
                    <small display: block;> ' . __('Select an image', 'lfb') . ' </small>
                </div>';
            echo '<input type="hidden" name="imageDes"/>';
            echo '<div class="form-group picOnly" >
                    <label> ' . __('Tint image ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="imageTint" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Automatically fill the picture with the main color', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group picOnly" >
                    <label> ' . __('Shadow effect', 'lfb') . ' </label >
                    <input type="checkbox"  name="shadowFX" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Use this option only on images without transparent background', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group " >
                    <label> ' . __('Open url on click ?', 'lfb') . ' </label >
                    <input type="text"  name="urlTarget" class="form-control" placeholder="http://..."  />
                    <small> ' . __('If you fill an url, it will be opened in a new tab on selection', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group " >
                    <label> ' . __('Calling method of the url', 'lfb') . ' </label >
                    <select name="urlTargetMode" class="form-control">
                        <option value="_blank">' . __('New tab', 'lfb') . '</option>   
                        <option value="_self">' . __('Same tab', 'lfb') . '</option>                                 
                    </select>
                    <small> ' . __('Choose if the page will be opened in a new tab or not', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                <label > ' . __('Main color', 'lfb') . ' </label >
                <input type="text" name="color" class="form-control colorpick" style="max-width: 100px;" />
                <small> ' . __('ex : #1abc9c', 'lfb') . '</small>
            </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Call next step on click ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="callNextStep" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('The next step will be called when this item will be clicked', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Display price in title ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="showPrice" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Shows the price in the item title', 'lfb') . ' </small>
                </div>';
            echo '<div><div class="form-group" >
                    <label> ' . __('Use column or row ?', 'lfb') . ' </label >
                    <select name="useRow" class="form-control">
                        <option value="0">' . __('Column', 'lfb') . '</option>
                        <option value="1">' . __('Row', 'lfb') . '</option>
                    </select>
                    <small> ' . __('The item will be displayed as column or full row', 'lfb') . ' </small>
                </div></div>';


            echo '<div class="form-group" >
                    <label> ' . __('Show it depending on conditions ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="useShowConditions" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('This item will be displayed only if the conditions are filled', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label></label >
                    <textarea name="showConditions" style="display: none;"></textarea>
                    <input type="hidden" name="showConditionsOperator" style="display: none;"/>
                    <a href="javascript:" onclick="lfb_editShowConditions();" class="btn btn-primary"><span class="glyphicon glyphicon-question-sign"></span> ' . __('Edit conditions', 'lfb') . '</a>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Keep the tooltip displayed', 'lfb') . ' </label >
                    <input type="checkbox"  name="visibleTooltip" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('The slider tooltip will always be open', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Disable first option selection', 'lfb') . ' </label >
                    <input type="checkbox"  name="firstValueDisabled" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __("The first option can't be selected", 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Use payment only if selected', 'lfb') . ' </label >
                    <input type="checkbox"  name="usePaypalIfChecked" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Payment will be used only if this item is selected', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __("Don't use payment if selected", 'lfb') . ' </label >
                    <input type="checkbox"  name="dontUsePaypalIfChecked" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Payment will be not be used if this item is selected', 'lfb') . ' </small>
                </div>';

            echo '</div>'; // eof col-md-6
            echo '<div class="col-md-6">';


            echo '<div class="form-group" >
                    <label> ' . __('Price mode', 'lfb') . ' </label>
                    <select name="priceMode" class="form-control" >
                        <option value="">' . __('Single cost', 'lfb') . '</option>
                        <option value="sub">' . __('Subscription cost', 'lfb') . '</option>
                    </select> 
                    <small> ' . __('Defines if the price of this item is a part of the subscription or not', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Price', 'lfb') . ' </label><label style="display: none;">' . __('Percentage', 'lfb') . '</label>
                    <input type="number" name="price" step="any" class="form-control" />
                    <small> ' . __('Sets the item price', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                   <label> ' . __('Price calculation', 'lfb') . ' </label >
                   <input type="checkbox"  name="useCalculation" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('If checked, the price will be replaced by a calculation', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group " >
                    <label> ' . __('Max width', 'lfb') . ' </label >
                    <input type="number" name="maxWidth" class="form-control" />
                    <small> ' . __('It defines the maximum size of this item', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group " >
                    <label> ' . __('Max height', 'lfb') . ' </label >
                    <input type="number" name="maxHeight" class="form-control" />
                    <small> ' . __('It defines the maximum size of this item', 'lfb') . ' </small>
                </div>';



            echo '<div class="form-group" >
                   <label> ' . __('Use value as quantity ?', 'lfb') . ' </label >
                   <input type="checkbox"  name="useValueAsQt" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('If checked, the value will define the selected quantity', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <div class="lfb_calculationToolbar">
                        <a href="javascript:" onclick="lfb_calculationModeQt=false;lfb_addCalculationValue(this);" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span>' . __('Add a value', 'lfb') . '</a>
                        <a href="javascript:" onclick="lfb_calculationModeQt=false;lfb_addCalculationCondition();" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a condition', 'lfb') . '</a>
                        <a href="javascript:" id="lfb_addDistanceBtn" onclick="lfb_calculationModeQt=false;lfb_editDistanceValue(false);" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span>' . __('Add a distance', 'lfb') . '</a>
                        <a href="javascript:" id="lfb_addDateDiffBtn" onclick="lfb_calculationModeQt=false;lfb_addDateDiffValue(this);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a date difference', 'lfb') . '</a><br/>
                    </div>
                    <textarea name="calculation" class="form-control" style="max-width: 100%; width: 100%;" ></textarea>
                    <small> ' . __('Use the buttons to easily create your calculation', 'lfb') . ' </small>
                    <div class="alert alert-info" style="margin-top: 18px;">
                        <p>' . __('Example of calculation', 'lfb') . ' :</p>
                        <pre>10
if([item-3_quantity] >5) {
	[price] = ([item-3_price]/2)*[item-1_quantity]
} </pre>
                    <p style="font-size: 12px;">' . __('Here, the default price of the item will be $10. If the item #3 is selected, the price of the current item will be the half of the item #3 calculated price multiplied by the selected quantity of the item #1.', 'lfb') . '</p>
                    </div>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Operator', 'lfb') . ' </label >
                    <select name="operation" class="form-control">
                        <option value="+">' . __('+', 'lfb') . '</option>
                        <option value="-">' . __('-', 'lfb') . '</option>
                        <option value="x">' . __('x', 'lfb') . '</option>
                        <option value="/">' . __('/', 'lfb') . '</option>
                    </select>
                    <small> ' . __('+ and - allow you to add or remove the price of the total price, * and / allow you to add or remove a percentage from the total price', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                   <label> ' . __("Don't add price to total", 'lfb') . ' </label >
                   <input type="checkbox"  name="dontAddToTotal" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('If checked, the price of this item will not change the total price', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                   <label> ' . __('Is selected ?', 'lfb') . ' </label >
                   <input type="checkbox"  name="ischecked" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Is the item selected by default ?', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                   <label> ' . __('Is hidden ?', 'lfb') . ' </label >
                   <input type="checkbox"  name="isHidden" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Item will be used in the calculation, but will not be displayed', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Is required ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="isRequired" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Is the item required to continue ?', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Show in email/summary ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="showInSummary" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('This item will be displayed in the summary if the user selects it', 'lfb') . ' </small>
                </div>';



            echo '<div class="form-group" >
                    <label> ' . __('Hide price in summary ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="hidePriceSummary" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('The price of this item will be hidden in the summary', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Hide quantity in summary ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="hideQtSummary" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('The quantity of this item will be hidden in the summary', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Hide in summary if zero price', 'lfb') . ' </label >
                    <input type="checkbox"  name="hideInSummaryIfNull" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('This item will be hidden in the summary if its price is equal to zero', 'lfb') . ' </small>
                </div>';



            echo '<div class="form-group" >
                    <label> ' . __('Shortcode', 'lfb') . ' </label >
                    <input type="text"  class="form-control"   name="shortcode" placeholder="[your-shortcode-here]"/>
                    <small> ' . __('Fill your shortcode here', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group lfb_onlyDatefield" >
                    <label> ' . __('Allow selection of a past date', 'lfb') . ' </label >
                    <input type="checkbox" name="date_allowPast"  data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Disable it to allow only dates from the current day', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Start date after X days', 'lfb') . ' </label>
                    <input type="number" name="startDateDays" step="any" class="form-control" />
                    <small> ' . __('The minimum selectable date will start after the number of days defined here', 'lfb') . ' </small>
                </div>';

            echo' <div class="form-group" >
                    <label> ' . __('Icon', 'lfb') . ' </label >
           <input type="text" class="form-control lfb_fieldWithBtn" name="icon" placeholder="fa fa-rocket" data-iconfield="1" />
           <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" style="margin-left: 8px;" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-search"></span></a>
         <small> ' . __('Add an icon to this field', 'lfb') . ' </small>      
        </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Icon position', 'lfb') . ' </label >
                    <select name="iconPosition" class="form-control">
                        <option value="0">' . __('Left', 'lfb') . '</option>
                        <option value="1">' . __('Right', 'lfb') . '</option>
                    </select>
                    <small> ' . __('Select the position of the icon', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Default value', 'lfb') . ' </label >
                    <input type="text" name="defaultValue" class="form-control" />
                    <small> ' . __('Defines the default value of this field', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Placeholder', 'lfb') . ' </label >
                    <input type="text" name="placeholder" class="form-control" />
                    <small> ' . __('This text will be displayed as placeholder', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Validation', 'lfb') . ' </label >
                    <select name="validation" class="form-control">
                        <option value="">' . __('None', 'lfb') . '</option>
                        <option value="phone">' . __('Number', 'lfb') . '</option>
                        <option value="email">' . __('Email', 'lfb') . '</option>
                        <option value="fill">' . __('Must be filled', 'lfb') . '</option>
                        <option value="custom">' . __('Custom', 'lfb') . '</option>
                        <option value="mask">' . __('Mask', 'lfb') . '</option>
                    </select>
                    <small> ' . __('Select a validation method', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Validation mask', 'lfb') . ' </label >
                    <input type="text" name="mask" class="form-control" />
                    <small> ' . __('Examples', 'lfb') . ':<br/>' . __('Phone', 'lfb') . ':(000) 000-0000<br/>' . __('Zip code', 'lfb') . ': SS-0000<br/>' . __('Text only', 'lfb') . ': SSSSS </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Characters required for validation', 'lfb') . ' </label >
                    <input type="text" name="validationCaracts" class="form-control" />
                    <small> ' . __('Fill the required characters separated by commas', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Min length', 'lfb') . ' </label >
                    <input type="number" name="validationMin" class="form-control" />
                    <small> ' . __('Enter the minimum required length', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Max length', 'lfb') . ' </label >
                    <input type="number" name="validationMax" class="form-control" />
                    <small> ' . __('Enter the maximum required length', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Max files', 'lfb') . ' </label >
                    <input type="number" name="maxFiles" class="form-control" />
                    <small> ' . __('Maximum number of files the user can upload', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Maximum file size (MB)', 'lfb') . ' </label >
                    <input type="number" min="2" name="fileSize" class="form-control" />
                    <small> ' . __('Something like 25', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('Allowed files', 'lfb') . ' </label >
                    <textarea name="allowedFiles" class="form-control" ></textarea>
                    <small> ' . __('Enter the allowed extensions separated by commas', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >
                    <label> ' . __('Enable quantity choice ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="quantity_enabled" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Can the user select a quantity for this item ?', 'lfb') . ' </small>
                </div>';

            echo '<div id="efp_itemQuantity">';

            //
            echo '<div class="form-group" >
                    <label> ' . __('Define quantity by calculation', 'lfb') . ' </label >
                   <input type="checkbox"  name="useCalculationQt" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('The selected quantity will be automatically defined by the custom calculation', 'lfb') . ' </small>
                </div>';


            echo '<div class="form-group" >                 
                    <div class="lfb_calculationToolbar">                    
                    <a href="javascript:" onclick="lfb_calculationModeQt=true;lfb_addCalculationValue(this);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a value', 'lfb') . '</a>
                    <a href="javascript:" onclick="lfb_calculationModeQt=true;lfb_addCalculationCondition();" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span>' . __('Add a condition', 'lfb') . '</a>
                    <a href="javascript:" id="lfb_addDistanceBtn" onclick="lfb_calculationModeQt=true;lfb_editDistanceValue(false);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a distance', 'lfb') . '</a>
                    <a href="javascript:" id="lfb_addDateDiffBtn" onclick="lfb_calculationModeQt=true;lfb_addDateDiffValue(this);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a date difference', 'lfb') . '</a><br/>
                    </div>
                    <textarea name="calculationQt" class="form-control" style="max-width: 100%; width: 100%;" ></textarea>
                    <small> ' . __('Use the buttons to easily create your calculation', 'lfb') . ' </small>
                    <div class="alert alert-info" style="margin-top: 18px;">
                        <p>' . __('Example of calculation', 'lfb') . ' :</p>
                        <pre>10
if([item-3_quantity] >5) {
	[quantity] = ([item-3_price]/2)*[item-1_quantity]
} </pre>
                    <p style="font-size: 12px;">' . __('Here, the default quantity of the item will be 10. If the item #3 is selected, the quantity of the current item will be the half of the item #3 calculated price multiplied by the selected quantity of the item #1.', 'lfb') . '</p>
                    </div>
                </div>';



            echo '<div class="form-group" >
                    <label> ' . __('Min quantity', 'lfb') . ' </label >
                    <input type="number" name="quantity_min" class="form-control" />
                    <small> ' . __('Sets the minimum quantity that can be selected', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Max quantity', 'lfb') . ' </label >
                    <input type="number" name="quantity_max" class="form-control" />
                    <small> ' . __('Sets the maximum quantity that can be selected', 'lfb') . ' </small>
                </div>';
            echo '<div class="form-group" >
                    <label> ' . __('Apply reductions on quantities ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="reduc_enabled" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Apply reductions on quantities ?', 'lfb') . ' </small>
                </div>';
            echo '<div style="display:none!important;"><div class="form-group" >
                    <label> ' . __('Use distance as quantity ?', 'lfb') . ' </label >
                    <input type="checkbox"  name="useDistanceAsQt" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('Use distance as quantity ?', 'lfb') . ' </small>
                </div>
                <input type="hidden" name="distanceQt"/>
                <div id="lfb_distanceQtContainer" class="form-group" >
                    <label></label >
                    <a href="javascript:" onclick="lfb_editDistanceValue(9);" class="btn btn-default"> ' . __('Configure the distance', 'lfb') . ' </a>
                </div></div>             
                ';

            echo '<table id="lfb_itemPricesGrid" class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>' . __('If quantity >= than', 'lfb') . '</th>';
            echo '<th>' . __('Item price becomes', 'lfb') . '</th>';
            echo '<th></th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<tr class="static">';
            echo '<td><input type="number" style="width: 100%;" class="form-control" id="reduc_new_qt" value="" placeholder="' . __('Quantity', 'lfb') . '"></td>';
            echo '<td><input type="number"  style="width: 100%;" class="form-control"  id="reduc_new_price" value="" placeholder="' . __('Price', 'lfb') . '"></td>';
            echo '<td><a href="javascript:" onclick="lfb_add_reduc();" class="btn btn-default"><span class="glyphicon glyphicon-plus" style="margin-right:8px;"></span>' . __('Add a new reduction', 'lfb') . '</a></td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            echo '</div>'; // eof efp_itemQuantity




            echo '<div class="form-group" >
                    <label> ' . __('Modify a variable', 'lfb') . ' </label >
                    <select name="modifiedVariableID" class="form-control">
                        <option value="0">' . __('No', 'lfb') . '</option>
                    </select>
                </div>';

            echo '<div class="form-group" >
                    <div class="lfb_calculationToolbar">
                        <a href="javascript:" onclick="lfb_calculationModeQt=2;lfb_addCalculationValue(this);" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span>' . __('Add a value', 'lfb') . '</a>
                        <a href="javascript:" onclick="lfb_calculationModeQt=2;lfb_addCalculationCondition();" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a condition', 'lfb') . '</a>
                        <a href="javascript:" id="lfb_addDistanceBtn" onclick="lfb_calculationModeQt=2;lfb_editDistanceValue(false);" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span>' . __('Add a distance', 'lfb') . '</a>
                        <a href="javascript:" id="lfb_addDateDiffBtn" onclick="lfb_calculationModeQt=2;lfb_addDateDiffValue(this);" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>' . __('Add a date difference', 'lfb') . '</a><br/>
                    </div>
                   
                    <textarea name="variableCalculation" class="form-control" style="max-width: 100%; width: 100%;" ></textarea>
                    <small> ' . __('Use the buttons to easily create your calculation', 'lfb') . ' </small> 
                        <div class="alert alert-info" style="margin-top: 18px;">
                        <p>' . __('Example of calculation', 'lfb') . ' :</p>
                        <pre>10
if([item-3_quantity] >5) {
	[variable] = ([item-3_price]/2)*[item-1_quantity]
} </pre>
                    <p style="font-size: 12px;">' . __('Here, the variable value will be 10. If the item #3 is selected, the value of the selected variable will be the half of the item #3 calculated price multiplied by the selected quantity of the item #1.', 'lfb') . '</p>
                    </div>
                </div>';



            echo '<div class="form-group" >
                    <label> ' . __('Send as GET variable', 'lfb') . ' </label >
                    <input type="checkbox"  name="sendAsUrlVariable" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                    <small> ' . __('The value of this item will be sent as variable to the final redirection page', 'lfb') . ' </small>
                </div>';

            echo '<div class="form-group" >
                    <label> ' . __('GET variable name', 'lfb') . ' </label >
                    <input type="text" name="variableName" class="form-control" />
                </div>';

            echo '</div>'; // eof col-md-6

            echo '<div class="col-md-12">';
            echo '<div id="lfb_itemRichTextContainer">';
            echo '<p style="text-align: right; margin: 0px;"><a href="javascript:" id="lfb_btnAddRichtextValue" onclick="lfb_addEmailValue(2);" class="btn btn-default" style="margin-bottom: 8px;"><span class="glyphicon glyphicon-plus"></span>' . __('Add a dynamic value', 'lfb') . '</a></p>';
            echo '<div id="lfb_itemRichText"></div>';
            echo '</div>';
            echo '<div id="lfb_imageLayersTableContainer">';
            echo '<p style="text-align: right;"><a href="javascript:" onclick="lfb_newLayerImg();" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>' . __('Add a new layer', 'lfb') . '</a></p>';
            echo '<table id="lfb_imageLayersTable" class="table" style="display: table;">'
            . '<thead>'
            . '<tr>'
            . '<th>' . __('Title', 'lfb') . '</th><th>' . __('Image', 'lfb') . '</th><th></th>'
            . '</tr>'
            . '</thead>'
            . '<tbody></tbody>'
            . '</table>';
            echo '</div>';
            echo '<p style="padding-left: 14px; padding-right: 14px;text-align:center;"><a href="javascript:" class="btn btn-primary" onclick="lfb_saveItem();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a></p>';
            echo '</div>'; // eof col-md-12
            echo '<div class="clearfix"></div>';

            echo '</div>'; // eof lfb_stepTabGeneral
            echo '</div>'; // eof tab-content
            echo '</div>'; // eof tabpanel

            echo '</div>'; // eof lfb_container
            echo '</div>'; // eof lfb_winItem



            echo ' <div id="lfb_calculationValueBubble" class="container-fluid" >
                <div>
                <div class="col-md-12" >
                   <div class="form-group" id="lfb_emailValueType">
                        <label > ' . __('Type of value', 'lfb') . ' </label >
                        <select name="valueType" class="form-control" />
                            <option value="">' . __('Item of the form', 'lfb') . '</option>
                            <option value="variable">' . __('Variable', 'lfb') . '</option>
                        
                        </select >
                    </div>
                    <div class="form-group" id="lfb_emailValueItemIDCt">
                        <label > ' . __('Select an item', 'lfb') . ' </label >
                        <select name="itemID" class="form-control" />
                        </select >
                    </div>
                    <div class="form-group" >
                        <label > ' . __('Select an attribute', 'lfb') . ' </label >
                        <select name="element" class="form-control" />
                            <option value="">' . __('Price', 'lfb') . '</option>
                            <option value="quantity">' . __('Quantity', 'lfb') . '</option>
                            <option value="title">' . __('Title', 'lfb') . '</option>
                            <option value="value">' . __('Value', 'lfb') . '</option>
                        </select >
                    </div>
                    <div class="form-group" >
                        <label > ' . __('Variable', 'lfb') . ' </label >
                        <select name="variableID" class="form-control" />
                        </select >
                    </div>
                    <p style="text-align: center;">
                        <a href="javascript:" class="btn btn-primary"  onclick="lfb_saveCalculationValue();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Insert', 'lfb') . '</a>
                    </p>
                </div>
                </div> ';
            echo '</div>'; // eof win lfb_calculationValueBubble


            echo ' <div id="lfb_calculationDatesDiffBubble" class="container-fluid" >
                <div>
                <div class="col-md-12" >
                    <div class="form-group" >
                        <label > ' . __('Start date', 'lfb') . ' </label >
                        <select name="startDate" class="form-control" />
                            <option data-static="true" value="currentDate" selected="selected">' . __('Current date', 'lfb') . '</option>
                        </select >
                    </div>
                    <div class="form-group" >
                        <label > ' . __('End date', 'lfb') . ' </label >
                        <select name="endDate" class="form-control" />
                            <option data-static="true" value="currentDate"  selected="selected">' . __('Current date', 'lfb') . '</option>
                        </select >
                    </div>
                    <p>' . __('The result will be the number of days between the two datepickers', 'lfb') . '</p>
                    </div>
                    <p style="text-align: center;">
                        <a href="javascript:" class="btn btn-primary"  onclick="lfb_saveCalculationDatesDiff();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Insert', 'lfb') . '</a>
                    </p>
                </div>
                </div> ';
            echo '</div>'; // eof win lfb_calculationDatesDiffBubble


            echo '<div id="lfb_winDistance" class="lfb_window container-fluid"> ';
            echo '<div class="lfb_winHeader col-md-12 palette palette-turquoise" ><span class="glyphicon glyphicon-pencil" ></span > ' . __('Distance calculation', 'lfb');

            echo ' <div class="btn-toolbar"> ';
            echo '<div class="btn-group" > ';
            echo '<a class="btn btn-primary" href="javascript:" ><span class="glyphicon glyphicon-remove lfb_btnWinClose" ></span ></a > ';
            echo '</div> ';
            echo '</div> '; // eof toolbar
            echo '</div> '; // eof header

            echo '<div class="clearfix"></div><div class="container-fluid lfb_container"   style="max-width: 90%;margin: 0 auto;margin-top: 18px;"> ';
            echo '<div role="tabpanel">';
            echo '<ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" ><a href="#lfb_distanceTabGeneral" aria-controls="general" role="tab" data-toggle="tab" ><span class="glyphicon glyphicon-cog" ></span > ' . __('Distance calculation', 'lfb') . ' </a ></li>
                </ul >';
            echo '<div class="tab-content" >';
            echo '<div role="tabpanel" class="tab-pane active" id="lfb_distanceTabGeneral" >';

            echo '<div id="lfb_calcStepsPreview">
                    <div id="lfb_mapIcon"></div>
                  </div>';
            echo '<div class="col-md-6" >
                    <h4>' . __('Departure address', 'lfb') . '</h4>
                    <table id="lfb_departTable" class="table table-striped">
                    <thead>
                        <th>' . __('Type', 'lfb') . '</th>
                        <th>' . __('Item', 'lfb') . '</th>
                    </thead>
                    <tbody>
                        <tr>
                        <td>' . __('Address', 'lfb') . '</td>
                        <td>
                            <select id="lfb_departAdressItem" class="form-control">
                            </select>
                        </td>
                        </tr>
                        <tr>
                        <td>' . __('City', 'lfb') . '</td>
                        <td>
                            <select id="lfb_departCityItem" class="form-control">
                            </select>
                        </td>
                        </tr>
                        <tr>
                        <td>' . __('Zip code', 'lfb') . '</td>
                        <td>
                            <select id="lfb_departZipItem" class="form-control">
                            </select>
                        </td>
                        </tr>
                        <tr>
                        <td>' . __('Country', 'lfb') . '</td>
                        <td>
                            <select id="lfb_departCountryItem" class="form-control">
                            </select>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="col-md-6" >
                    <h4>' . __('Arrival address', 'lfb') . '</h4>
                        <table id="lfb_arrivalTable" class="table table-striped">
                    <thead>
                        <th>' . __('Type', 'lfb') . '</th>
                        <th>' . __('Item', 'lfb') . '</th>
                    </thead>
                    <tbody>
                        <tr>
                        <td>' . __('Address', 'lfb') . '</td>
                        <td>
                            <select id="lfb_arrivalAdressItem" class="form-control">
                            </select>
                        </td>
                        </tr>
                        <tr>
                        <td>' . __('City', 'lfb') . '</td>
                        <td>
                            <select id="lfb_arrivalCityItem" class="form-control">
                            </select>
                        </td>
                        </tr>
                        <tr>
                        <td>' . __('Zip code', 'lfb') . '</td>
                        <td>
                            <select id="lfb_arrivalZipItem" class="form-control">
                            </select>
                        </td>
                        </tr>
                        <tr>
                        <td>' . __('Country', 'lfb') . '</td>
                        <td>
                            <select id="lfb_arrivalCountryItem" class="form-control">
                            </select>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="clearfix"></div>
                    <p style="text-align: center;">
                        ' . __('The result will be the', 'lfb') . '
                         <select class="form-control" id="lfb_distanceDuration" style="max-width: 280px;display: inline-block;margin-left: 8px;">
                            <option value="distance">' . __('Distance', 'lfb') . '</option>
                            <option value="duration">' . __('Travel duration', 'lfb') . '</option>
                         </select>
                        ' . __('between the two addresses in', 'lfb') . '
                         <select class="form-control" id="lfb_distanceType" style="max-width: 280px;display: inline-block;margin-left: 8px;margin-top: 8px; margin-bottom: 8px;">
                            <option value="km">' . __('km', 'lfb') . '</option>
                            <option value="miles">' . __('miles', 'lfb') . '</option>
                         </select>
                         <select class="form-control" id="lfb_durationType" style="max-width: 280px;display: none;margin-left: 8px;margin-top: 8px; margin-bottom: 8px;">
                            <option value="mins">' . __('Minutes', 'lfb') . '</option>
                            <option value="hours">' . __('Hours', 'lfb') . '</option>
                         </select>
                    </p>
                    <p style="text-align: center;">
                        <a href="javascript:" class="btn btn-primary" style="margin-top:18px;"  onclick="lfb_saveDistanceValue();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Insert', 'lfb') . '</a>
                    </p>
                ';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>'; // eof lfb_winRedirection



            echo ' <div id="lfb_distanceValueBubble" class="container-fluid" >
                
                </div> '; // eof win lfb_distanceValueBubble

            echo '<div id="lfb_winEditCoupon" class="modal fade ">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><span class="fas fa-pencil-alt"></span>' . __('Edit a coupon', 'lfb') . '</h4>
                    </div>
                    <div class="modal-body" style="padding-bottom:0px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>' . __('Coupon code', 'lfb') . '</label>
                                <input type="text" class="form-control" name="couponCode"/>
                            </div>
                        </div>                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>' . __('Reduction type', 'lfb') . '</label>
                                <select class="form-control" name="reductionType">
                                    <option value="">' . __('Price', 'lfb') . '</option>
                                    <option value="percentage">' . __('Percentage', 'lfb') . '</option>
                                </select>
                            </div>
                        </div>       
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>' . __('Reduction', 'lfb') . '</label>
                                <input type="number" step="any" class="form-control" name="reduction"/>
                            </div>
                        </div>                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>' . __('Max uses', 'lfb') . '</label>
                                <input type="number" class="form-control" name="useMax" min="0" /><br/>
                                <small>' . __('Set 0 for an infinite use', 'lfb') . '</small>
                            </div> 
                        </div>
                    <div class="clearfix" ></div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <a href="javascript:" class="btn btn-primary"  onclick="lfb_saveCoupon();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a>
                    </div><!-- /.modal-footer -->
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->';

            echo '<div id="lfb_winNewTotal" class="modal fade ">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><span class="fas fa-pencil-alt"></span>' . __('Modify the total', 'lfb') . '</h4>
                    </div>
                    <div class="modal-body">
                       <div class="form-group">
                           <label>' . __('Total price', 'lfb') . '</label>
                           <input class="form-control" name="lfb_modifyTotalField" type="number" />
                       </div>
                       <div class="form-group">
                           <label>' . __('Subscription price', 'lfb') . '</label>
                           <input class="form-control" name="lfb_modifySubTotalField" type="number" />
                       </div>
                    </div><!-- /.modal-body -->
                    <div class="modal-footer" style="text-align: center;">
                           <a href="javascript:"  onclick="lfb_confirmModifyTotal();" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span><span class="lfb_text">' . __('Save', 'lfb') . '</span></a>
                     </div><!-- /.modal-footer -->
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->';

            echo '<div id="lfb_winShortcode" class="modal fade ">
                         <div class="modal-dialog">
                           <div class="modal-content">
                             <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               <h4 class="modal-title"><span class="fas fa-info-circle"></span>' . __('Generate a shortcode', 'lfb') . '</h4>
                             </div>
                             <div class="modal-body">';

            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label>' . __('Displaying', 'lfb') . '</label>';
            echo '<select name="display" class="form-control">';
            echo '<option value="">' . __('In the page', 'lfb') . '</option>';
            echo '<option value="fullscreen">' . __('Fullscreen', 'lfb') . '</option>';
            echo '<option value="popup">' . __('Popup', 'lfb') . '</option>';
            echo '</select>';
            echo '</div>';
            echo '</div>';
            echo '<div class="col-md-6">';

            echo '<div class="form-group">';
            echo '<label>' . __('Start step', 'lfb') . '</label>';
            echo '<select name="startStep" class="form-control"></select>';
            echo '</div>';
            echo '</div>';

            echo '<div class="col-md-12">';
            echo '<div class="shortcodeCt">';
            echo '<input id="lfb_shortcodeField" readonly class="lfb_shortcodeInput"/>';
            echo '</div>';

            echo '<div data-display="popup" class="alert alert-info">';
            echo '<p style="margin-bottom: 0px;">To open the popup, simply use the css class "<b>open-estimation-form form-<span data-displayid="1" style="font-weight: bold;">1</span></b>".</p>';
            echo '<input id="lfb_shortcodePopup" readonly class="lfb_shortcodeInput" value="&lt;a href=' . "&quot;" . '#' . "&quot;" . ' class=' . "&quot;" . 'open-estimation-form form-1' . "&quot;" . '&gt;Open Form&lt;/a&gt;">';

            echo '</div>';
            echo '</div>';
            echo '<div class="clearfix"></div>';
            echo '</div>
                           </div><!-- /.modal-content -->
                         </div><!-- /.modal-dialog -->
                       </div><!-- /.modal -->';

            echo '<div id="lfb_winStepSettings" class="modal fade">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><span class="fas fa-cogs"></span>' . __('Step settings', 'lfb') . '</h4>
                              </div>
                              <div class="modal-body">
                             
                                <div class="container-fluid">
                                
                                    <div class="col-md-4">';

            echo '<div class = "form-group" >
                                    <label> ' . __('Title', 'lfb') . ' </label >
                                    <input type = "text" name = "title" class = "form-control" maxlength = "120" />
                                    <small> ' . __('This is the step name', 'lfb') . ' </small>
                                    </div>';
            echo '<div class = "form-group" style=" margin-bottom: 0px;"" >
                                    <label> ' . __('Description', 'lfb') . ' </label >
                                    <input type = "text" name = "description" class = "form-control" />
                                    <small> ' . __('A facultative description', 'lfb') . ' </small>
                                    </div> ';

            echo '</div> ';

            echo '<div class="col-md-4">';
            echo '<div class="form-group" style="height: 86px;" >
                                    <label> ' . __('Show it depending on conditions ?', 'lfb') . ' </label ><br/>
                                    <input type="checkbox"  name="useShowConditions" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />

                                    <a href="javascript:" id="showConditionsStepBtn" onclick="lfb_editShowStepConditions();" class="btn btn-primary btn-circle" style="margin-left: 8px;"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <small> ' . __('This step will be displayed only if the conditions are filled', 'lfb') . ' </small>
                                </div>
                                <div class="form-group" style="height: 86px; margin-bottom: 0px;" >
                                    <label> ' . __('Show in email/summary ?', 'lfb') . ' </label ><br/>
                                    <input type="checkbox"  name="showInSummary" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />

                                    <small> ' . __('This step will be displayed in the summary', 'lfb') . ' </small>
                                </div>';
            echo '<div class="">
                                    <label></label >
                                    <textarea name="showConditions" style="display: none;"></textarea>
                                    <input type="hidden" name="showConditionsOperator" style="display: none;"/>
                                </div>';

            echo '</div> ';

            echo '<div class="col-md-4">';
            echo '<div class="form-group" style="height: 86px; ">
                                    <label> ' . __('Selection required', 'lfb') . ' </label ><br/>
                                    <input type="checkbox"  name="itemRequired" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />

                                    <small> ' . __('If true, the user must select at least one item to continue', 'lfb') . ' </small>
                                </div>';

            echo '<div class="form-group" style="height: 86px; margin-bottom: 0px;" >
                                    <label> ' . __('Hide the next step button ?', 'lfb') . ' </label ><br/>
                                    <input type="checkbox"  name="hideNextStepBtn" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" />
                                </div>';
            echo '</div> ';

            echo'
                                </div>';
            echo '<div class="clearfix"></div>';

            echo'  </div>
                              <div class="modal-footer">
                                <a href="javascript:" class="btn btn-primary" data-action="saveStepSettings"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a>
                            </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->';

            echo '<div id="lfb_winImport" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><span class="fas fa-cloud-upload-alt"></span>' . __('Import data', 'lfb') . '</h4>
                              </div>
                              <div class="modal-body">
                               <div class="alert alert-danger text-center"><p>' . __('Be carreful : all existing forms and steps will be erased importing new data.', 'lfb') . '</p></div>
                                   <form id="lfb_winImportForm" method="post" enctype="multipart/form-data">
                                       <div class="form-group">
                                        <input type="hidden" name="action" value="lfb_importForms"/>
                                        <label>' . __('Select the .zip data file', 'lfb') . '</label><input name="importFile" type="file" class="" />
                                       </div>
                                  </form>
                              </div>
                              <div class="modal-footer">
                                <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                                <a href="javascript:" class="btn btn-primary" onclick="lfb_importForms();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Import', 'lfb') . '</a>
                            </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->';

            echo '<div id="lfb_winDeleteForm" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete this form', 'lfb') . '</h4>
                              </div>
                              <div class="modal-body">
                               <div class="alert alert-danger"><p style="text-align: center;">' . __('Are you sure you want to delete the form', 'lfb') . '<br/> <strong id="lfb_deleteFormTitle"></strong> ?</p></div>
                                  
                              </div>
                              <div class="modal-footer">
                                <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                                <a href="javascript:" class="btn btn-danger" onclick="lfb_confirmDeleteForm();"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a>
                            </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->';

            echo '<div id="lfb_winAskDeleteCustomer" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete this customer', 'lfb') . '</h4>
                              </div>
                              <div class="modal-body">
                               <div class="alert alert-danger"><p style="text-align: center;">' . __('Are you sure you want to delete this customer and all his orders ?', 'lfb') . '</p></div>
                                  
                              </div>
                              <div class="modal-footer">
                                <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                                <a href="javascript:" class="btn btn-danger" data-action="confirmDeleteCustomer"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a>
                            </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->';

            echo '<div id="lfb_winDeleteStep" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete this step', 'lfb') . '</h4>
                              </div>
                              <div class="modal-body">
                               <div class="alert alert-danger"><p style="text-align: center;">' . __('Are you sure you want to delete this step ?', 'lfb') . '</p></div>
                                  
                              </div>
                              <div class="modal-footer">
                                <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                                <a href="javascript:" class="btn btn-danger" onclick="lfb_confirmDeleteStep();"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a>
                            </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->';

            echo '<div id="lfb_winDeleteItem" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete an element', 'lfb') . '</h4>
                              </div>
                              <div class="modal-body">
                               <div class="alert alert-danger"><p style="text-align: center;">' . __('Are you sure you want to delete this element ?', 'lfb') . '</p></div>
                                  
                              </div>
                              <div class="modal-footer">
                                <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                                <a href="javascript:" class="btn btn-danger" onclick="lfb_confirmDeleteItem();"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a>
                            </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->';


            echo '<div id="lfb_winDeleteOrder" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete this order', 'lfb') . '</h4>
                              </div>
                              <div class="modal-body">
                               <div class="alert alert-danger"><p style="text-align: center;">' . __('Are you sure you want to delete this order ?', 'lfb') . '</p></div>
                                  
                                <div class="form-group" style="margin-bottom: 2px;">
                                <label style="margin-right: 10px;">' . __('Delete all orders of this customer ?', 'lfb') . '</label>
                                <input type="checkbox" name="allOrders" data-toggle="tooltip" title="' . __("All the orders that have the same customer email will be deleted", 'lfb') . '" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                           
                                </div>
                              </div>
                              <div class="modal-footer">
                                <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                                <a href="javascript:" class="btn btn-danger" onclick="lfb_confirmRemoveLog();"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a>
                            </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->';

            echo '
        <!-- Modal -->
        <div class="modal fade" id="modal_editVariable" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span class="fas fa-pencil-alt"></span>' . __('Edit a variable', 'lfb') . '</h4>
              </div>
              <div class="modal-body">
                 <div class="container-fluid">
                 <div class="col-md-4">
                    <div class="form-group" >
                        <label > ' . __('Title', 'lfb') . ' </label >
                        <input type="text" name="title" class="form-control" />
                    </div>
                 </div>
                 <div class="col-md-4">
                    <div class="form-group" >
                        <label > ' . __('Type', 'lfb') . ' </label >
                        <select name="type" class="form-control">
                            <option value="integer">' . __('Integer', 'lfb') . '</option>
                            <option value="float">' . __('Float', 'lfb') . '</option>
                        </select>
                    </div>
                 </div>
                 <div class="col-md-4">
                    <div class="form-group" >
                        <label > ' . __('Default value', 'lfb') . ' </label >
                        <input type="text" name="defaultValue" class="form-control" />
                    </div>
                 </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="modal-footer">
                <a href="javascript:" class="btn btn-primary" data-action="saveVariable" ><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a>
              </div>
            </div>
          </div>
        </div>';


            echo '<div id="lfb_winDeleteCalendarCat" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete this category', 'lfb') . '</h4>
                    </div>
                    <div class="modal-body">
                     <div class="alert alert-danger"><p style="text-align: center;">' . __('Are you sure you want to delete this category ?', 'lfb') . '</p></div>
                    </div>
                    <div class="modal-footer">
                      <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                      <a href="javascript:" class="btn btn-danger" onclick="lfb_confirmDeleteCalendarCat();"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a>
                  </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->';

            echo '<div id="lfb_winDeleteCalendarEvent" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete this event', 'lfb') . '</h4>
                    </div>
                    <div class="modal-body">
                     <div class="alert alert-danger"><p style="text-align: center;">' . __('Are you sure you want to delete this event ?', 'lfb') . '</p></div>
                    </div>
                    <div class="modal-footer">
                      <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                      <a href="javascript:" class="btn btn-danger" onclick="lfb_confirmDeleteCalendarEvent();"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a>
                  </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->';

            echo '<div id="lfb_winDeleteCalendar" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete this calendar', 'lfb') . '</h4>
                    </div>
                    <div class="modal-body">
                     <div class="alert alert-danger"><p style="text-align: center;">' . __('Are you sure you want to delete this calendar ?', 'lfb') . '</p></div>
                    </div>
                    <div class="modal-footer">
                      <a href="javascript:" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>' . __('Cancel', 'lfb') . '</a>
                      <a href="javascript:" class="btn btn-danger" onclick="lfb_deleteCalendar();"><span class="glyphicon glyphicon-trash"></span>' . __('Delete', 'lfb') . '</a>
                  </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->';


            echo '<div id="lfb_winEditCalendar" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><span class="fas fa-pencil-alt"></span>' . __('Add a calendar', 'lfb') . '</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>' . __('Title', 'lfb') . '</label>
                            <input type="text" class="form-control" name="title" />
                        </div>
                    </div>
                    <div class="modal-footer">
                      <a href="javascript:" class="btn btn-primary" onclick="lfb_saveCalendar();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a>
                  </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->';

            echo '<div id="lfb_winEditCalendarCat" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><span class="fas fa-pencil-alt"></span>' . __('Add a category', 'lfb') . '</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>' . __('Title', 'lfb') . '</label>
                            <input type="text" class="form-control" name="title" />
                        </div>
                        <div class="form-group">
                            <label>' . __('Color', 'lfb') . '</label>
                            <input type="text" class="form-control colorpick" name="color" />
                        </div>
                    </div><!-- /.modal-body -->
                    <div class="modal-footer">
                      <a href="javascript:" class="btn btn-primary" onclick="lfb_saveCalendarCat();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a>
                  </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->';



            echo '<div id="lfb_winEditReminder" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><span class="fas fa-pencil-alt"></span>' . __('Add a reminder', 'lfb') . '</h4>
                    </div>
                    <div class="modal-body">
                      
                        <div class="form-group">
                            <label>' . __('Notify me', 'lfb') . ' :</label>
                                <input name="delayValue" class="form-control" type="number"/>
                                <select name="delayType" class="form-control">
                                    <option value="hours">' . __('Hours', 'lfb') . '</option>
                                    <option value="days">' . __('Days', 'lfb') . '</option>
                                    <option value="weeks">' . __('Weeks', 'lfb') . '</option>
                                    <option value="months">' . __('Months', 'lfb') . '</option>                                    
                                </select>
                            <label style="margin-right: 0px; width: auto;">' . __('before the event', 'lfb') . '</label>  
                        </div>
                        
                        <div class="form-group">
                            <label>' . __('Email', 'lfb') . ' :</label>
                            <input name="email" type="email" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>' . __('Subject', 'lfb') . ' :</label>
                            <input name="title" type="text" class="form-control" />
                        </div>
                            <label>' . __('Text', 'lfb') . ' :</label>
                            <div class="palette palette-turquoise" >
                            <p><i> ' . __('Variables', 'lfb') . ' :</i></p>
                            <p>
                                <strong>[ref]</strong> : ' . __('Order reference', 'lfb') . ' <br/>
                                <strong>[date]</strong> : ' . __('Date of the event', 'lfb') . ' <br/>  
                                <strong>[time]</strong> : ' . __('Time of the event', 'lfb') . ' <br/>  
                                <strong>[customerEmail]</strong> : ' . __('Customer email', 'lfb') . ' <br/>  
                                <strong>[customerAddress]</strong> : ' . __('Address', 'lfb') . ' 
                            </p>
                        </div>
                        <div class="form-group">
                            <div id="calEventContent_editor" >
                                <div id="calEventContent"></div>
                         </div>
                           <div class="alert alert-info">
                            <p>' . __('To allow the plugin to send the reminders, you need to configure a CRON task on your server, executed every hour, that calls this url', 'lfb') . ' :<br/><strong>' . get_site_url() . '/?EPFormsBuilder=executeCron</strong></p>
                            </div>
                          </div>
                    </div>
                    <div class="modal-footer">
                      <a href="javascript:" class="btn btn-primary" onclick="lfb_saveCalendarReminder();"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Save', 'lfb') . '</a>
                  </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->';


            echo '
        <!-- Modal -->
        <div class="modal fade" id="modal_deleteVariable" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span class="fas fa-trash"></span>' . __('Delete a variable', 'lfb') . '</h4>
              </div>
              <div class="modal-body">
                ' . __('Are you sure you want to delete the variable [variableName] ?', 'lfb') . '
              </div>
              <div class="modal-footer">
                <a href="javascript:" class="btn btn-default" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span>' . __('No', 'lfb') . '</a>
                <a href="javascript:" class="btn btn-danger" data-dismiss="modal"  data-action="deleteVariable" ><span class="glyphicon glyphicon-trash"></span>' . __('Yes', 'lfb') . '</a>
              </div>
            </div>
          </div>
        </div>';


            echo '<div id="lfb_winExport" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><span class="fas fa-cloud-upload-alt"></span>' . __('Export data', 'lfb') . '</h4>
                      </div>
                      <div class="modal-body">
                        <div style="text-align: center;">
                            <div class="form-group" style="margin-bottom: 2px;">
                                <label style="margin-right: 10px;">' . __('Include stored orders', 'lfb') . '</label>
                                <input type="checkbox" name="exportLogs" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                            </div>
                             <div class="form-group">
                                <label style="margin-right: 10px;">' . __('Include discount coupons', 'lfb') . '</label>
                                <input type="checkbox" name="exportCoupons" data-switch="switch" data-on-label="' . __('Yes', 'lfb') . '" data-off-label="' . __('No', 'lfb') . '" class=""   />
                            </div>
                        </div>
                        <p style="text-align: center;"><a href="admin.php?page=lfb_menu&lfb_action=exportForms" target="_blank" onclick="jQuery(\'#lfb_winExport\').modal(\'hide\');" class="btn btn-primary btn-lg" id="lfb_exportLink"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Download the exported data', 'lfb') . '</a></p>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->';

            echo '<div id="lfb_winDownloadOrder" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><span class="fas fa-cloud-download-alt"></span>' . __('Download the order', 'lfb') . '</h4>
                      </div>
                      <div class="modal-body">
                        <p style="text-align: center;"><a href="admin.php?page=lfb_menu&lfb_action=downloadLog" target="_blank" onclick="jQuery(\'#lfb_winDownloadOrder\').modal(\'hide\');" class="btn btn-primary btn-lg" id="lfb_downloadOrderLink"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Download the order', 'lfb') . '</a></p>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->';

            echo '<div id="lfb_winExportCustomersCsv" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><span class="fas fa-cloud-download-alt"></span>' . __('Download the customers list', 'lfb') . '</h4>
                      </div>
                      <div class="modal-body">
                        <p style="text-align: center;"><a href="javascript:" target="_blank" onclick="jQuery(\'#lfb_winExportCustomersCsv\').modal(\'hide\');" class="btn btn-primary btn-lg" id="lfb_exportCustomerCsvLink"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Download', 'lfb') . '</a></p>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->';


            echo '<div id="lfb_winCalendarCsv" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><span class="fas fa-cloud-download-alt"></span>' . __('Download the calendar events', 'lfb') . '</h4>
                      </div>
                      <div class="modal-body">
                        <p style="text-align: center;"><a href="javascript:" target="_blank" onclick="jQuery(\'#lfb_winCalendarCsv\').modal(\'hide\');" class="btn btn-primary btn-lg" id="lfb_exportCalendarCsvLink"><span class="glyphicon glyphicon-floppy-disk"></span>' . __('Download', 'lfb') . '</a></p>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->';

            echo '</div></div> </div><!-- /wpe_bootstraped -->';

            $this->tdgn_showFormDesigner();
        }
    }

    function sendOrderByEmail() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            
                        global $_currentFormID;
                        global $_currentOrderID;
                        
            $settings = $this->getSettings();
            $logID = sanitize_text_field($_POST['logID']);
            $subject = sanitize_text_field($_POST['subject']);
            $recipients = sanitize_text_field($_POST['recipients']);
            $recipients = preg_replace('/\s+/', '', $recipients);
            $generatePDF = sanitize_text_field($_POST['generatePDF']);
            $addPayLink = sanitize_text_field($_POST['addPayLink']);
            $emailsArray = array();

            $table_name = $wpdb->prefix . "wpefc_logs";
            $logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $logID));
            if (count($logs) > 0) {
                $order = $logs[0];
                // $order->content = $this->parent->stringDecode($order->content, $settings->encryptDB);
                // $order->contentUser = $this->parent->stringDecode($order->contentUser, $settings->encryptDB);

                if (strpos($order->contentUser, 'style') === false && $settings->encryptDB) {
                    $order->contentUser = $this->parent->stringDecode($order->contentUser, $settings->encryptDB);
                }
                if (strpos($order->content, 'style') === false && $settings->encryptDB) {
                    $order->content = $this->parent->stringDecode($order->content, $settings->encryptDB);
                }

                $lastPos = 0;
                $positions = array();
                $toReplaceDefault = array();
                $toReplaceBy = array();
                while (($lastPos = strpos($order->contentUser, '<span class="lfb_value">', $lastPos)) !== false) {
                    $positions[] = $lastPos;
                    $lastPos = $lastPos + strlen('<span class="lfb_value">');
                    $fileStartPos = $lastPos;
                    $lastSpan = strpos($order->contentUser, '</span>', $fileStartPos);
                    $value = substr($order->contentUser, $fileStartPos, $lastSpan - $fileStartPos);
                    $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
                    $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringDecode($value, $settings->encryptDB) . '</span>';
                }
                foreach ($toReplaceBy as $key => $value) {
                    $order->contentUser = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->contentUser);
                }


                $lastPos = 0;
                $positions = array();
                $toReplaceDefault = array();
                $toReplaceBy = array();
                while (($lastPos = strpos($order->content, '<span class="lfb_value">', $lastPos)) !== false) {
                    $positions[] = $lastPos;
                    $lastPos = $lastPos + strlen('<span class="lfb_value">');
                    $fileStartPos = $lastPos;
                    $lastSpan = strpos($order->content, '</span>', $fileStartPos);
                    $value = substr($order->content, $fileStartPos, $lastSpan - $fileStartPos);
                    $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
                    $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringDecode($value, $settings->encryptDB) . '</span>';
                }
                foreach ($toReplaceBy as $key => $value) {
                    $order->content = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->content);
                }



                $table_name = $wpdb->prefix . "wpefc_forms";
                $form = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $order->formID));
                if (count($form) > 0) {
                    $form = $form[0];

                    $replyTo = "";
                    if (strpos($recipients, ',') > 0) {
                        $emailsArray = explode(',', $recipients);
                        $replyTo = $emailsArray[0];
                    } else {
                        $emailsArray = $recipients;
                        $replyTo = $recipients;
                    }
                    $order->content = str_replace("[payment_link]", "", $order->content);

                    $txt_orderType = $form->txt_invoice;
                    if (!$order->paid) {
                        $txt_orderType = $form->txt_quotation;
                    }
                    $order->content = str_replace("[order_type]", $txt_orderType, $order->content);
                    $order->contentUser = str_replace("[order_type]", $txt_orderType, $order->contentUser);


                    if ($addPayLink == 1 && ($order->totalPrice > 0 || $order->totalSubscription > 0)) {
                        $paymentLink = '';
                        $paymentUrl = get_site_url() . '/?EPFormsBuilder=payOrder&h=' . $order->paymentKey;

                        if ($form->emailPaymentType == 'button') {
                            $paymentLink = '<p><a href="' . $paymentUrl . '" style="padding: 14px;border-radius: 4px; background-color: ' . $form->colorA . ';color: #fff; text-decoration:none;">' . $form->enableEmailPaymentText . '</a></p>';
                        } else if ($form->emailPaymentType == 'link') {
                            $paymentLink = '<p><a href="' . $paymentUrl . '">' . $form->enableEmailPaymentText . '</a></p>';
                        } else {
                            $paymentLink = '<p><a href="' . $paymentUrl . '">' . $form->enableEmailPaymentText . '<input type="checkbox" style="vertical-align:middle;" /></a></p>';
                        }
                        $order->content .= '<div style="text-align: center;">' . $paymentLink . '</div>';
                    }

                    if ($form->email_name != "") {
                        $_currentFormID = $form->id;
                        add_filter('wp_mail_from_name', array($this, 'wpb_sender_name'));
                    }
                    $_currentFormID = $form->id;
                    $_currentOrderID = 0;
                    add_filter('wp_mail_from', array($this, 'wpb_sender_email'));


                    add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                    $headers = "";
                    if ($order->email != "") {
                        $headers .= "Reply-to: " . $order->email . "\n";
                    } else {                        
                        $headers .= "Reply-to: " . $order->email . "\n";
                        
                    }
                    $attachments = array();
                    if ($generatePDF == '1') {
                        try {
                            $attachments[] = $this->lfb_generatePdfCustomer($order);
                        } catch (Exception $ex) {
                            
                        }
                    }
                    if (wp_mail($emailsArray, $subject, $order->content, $headers, $attachments)) {
                        if (count($attachments) > 0) {
                            unlink($attachments[0]);
                        }
                    }
                }
            }

            die();
        }
    }

    function downloadLog() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $settings = $this->getSettings();
            $logID = sanitize_text_field($_POST['logID']);
            $table_name = $wpdb->prefix . "wpefc_logs";
            $logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $logID));
            if (count($logs) > 0) {
                $order = $logs[0];

                if (strpos($order->contentUser, 'style') === false && $settings->encryptDB) {
                    $order->contentUser = $this->parent->stringDecode($order->contentUser, $settings->encryptDB);
                }
                if (strpos($order->content, 'style') === false && $settings->encryptDB) {
                    $order->content = $this->parent->stringDecode($order->content, $settings->encryptDB);
                }

                $table_name = $wpdb->prefix . "wpefc_forms";
                $form = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $order->formID));
                if (count($form) > 0) {
                    $form = $form[0];

                    $txt_orderType = $form->txt_invoice;
                    if (!$order->paid) {
                        $txt_orderType = $form->txt_quotation;
                    }
                    $order->content = str_replace("[order_type]", $txt_orderType, $order->content);
                    $order->contentUser = str_replace("[order_type]", $txt_orderType, $order->contentUser);
                    $order->content = str_replace("[payment_link]", "", $order->content);
                    $order->contentUser = str_replace("[payment_link]", "", $order->contentUser);

                    $filePdf = $this->lfb_generatePdfCustomer($order);
                    echo $order->ref;
                }
            } else {
                
            }
        }
        die();
    }

    private function lfb_generatePdfCustomer($order) {

        $order->contentUser = $order->content;

        if (strpos($order->contentUser, 'style') === false && $settings->encryptDB) {
            $order->contentUser = $this->parent->stringDecode($order->contentUser, $settings->encryptDB);
        }
        $settings = $this->getSettings();
        $lastPos = 0;
        $positions = array();
        $toReplaceDefault = array();
        $toReplaceBy = array();
        while (($lastPos = strpos($order->contentUser, '<span class="lfb_value">', $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen('<span class="lfb_value">');
            $fileStartPos = $lastPos;
            $lastSpan = strpos($order->contentUser, '</span>', $fileStartPos);
            $value = substr($order->contentUser, $fileStartPos, $lastSpan - $fileStartPos);
            $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
            $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringDecode($value, $settings->encryptDB) . '</span>';
        }
        foreach ($toReplaceBy as $key => $value) {
            $order->contentUser = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->contentUser);
        }

        $contentPdf = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>body,*{font-family: "dejavu sans" !important; } hr{color: #ddd; border-color: #ddd;} table{width: 100% !important; line-height: 18px;} table td, table th{width: auto!important; border: 1px solid #ddd; line-height: 16px;overflow-wrap: break-word;}table td,table tbody th  {padding-top: 2px !important; padding-bottom: 6px !important} table thead th {padding: 8px;line-height: 18px;}tbody:before, tbody:after { display: none; }</style></head><body>' . ($order->contentUser) . '</body></html>';

        $contentPdf = mb_convert_encoding($contentPdf, 'HTML-ENTITIES', 'UTF-8');
        $contentPdf = str_replace('border="1"', '', $contentPdf);
        $upDir = wp_upload_dir();
        $contentPdf = str_replace('src="' . get_site_url() . '/wp-content/uploads/', 'src="' . $upDir['basedir'] . '/', $contentPdf);


        require_once("dompdf/autoload.inc.php");
        $dompdf = new Dompdf\Dompdf();
        $dompdf->load_html(utf8_decode($contentPdf), 'UTF-8');
        $dompdf->set_paper('a4', 'portrait');
        $dompdf->render();
        $fileName = $order->formTitle . '-' . $order->ref . '.pdf';
        $output = $dompdf->output();
        file_put_contents($this->parent->dir . '/uploads/' . $fileName, $output);
        return ($this->parent->dir . '/uploads/' . $fileName);
    }

    function saveLog() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $settings = $this->getSettings();
            $formID = sanitize_text_field($_POST['formID']);
            $logID = sanitize_text_field($_POST['logID']);
            $total = sanitize_text_field($_POST['total']);
            $subTotal = sanitize_text_field($_POST['subTotal']);
            $content = stripslashes($_POST['content']);
            $settings = $this->getSettings();

            $lastPos = 0;
            $positions = array();

            $toReplaceDefault = array();
            $toReplaceBy = array();
            // $content = stripslashes($content);
            while (($lastPos = strpos($content, '<span class="lfb_value">', $lastPos)) !== false) {
                $positions[] = $lastPos;
                $lastPos = $lastPos + strlen('<span class="lfb_value">');
                $fileStartPos = $lastPos;
                $lastSpan = strpos($content, '</span>', $fileStartPos);
                $value = substr($content, $fileStartPos, $lastSpan - $fileStartPos);
                $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
                $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringEncode($value, $settings->encryptDB) . '</span>';
            }
            foreach ($toReplaceBy as $key => $value) {
                $content = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $content);
            }

            $table_name = $wpdb->prefix . "wpefc_logs";
            $wpdb->update($table_name, array('content' => $content, 'contentUser' => $content, 'totalPrice' => $total, 'totalSubscription' => $subTotal), array('id' => $logID));

            // $wpdb->update($table_name, array('content' => $this->parent->stringEncode($content, $settings->encryptDB), 'contentUser' => $this->parent->stringEncode($content, $settings->encryptDB), 'totalPrice' => $total, 'totalSubscription' => $subTotal), array('id' => $logID));
            die();
        }
    }

    /* Load Logs */

    public function loadLogs() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $settings = $this->getSettings();
            $formID = intval($_POST['formID']);
            $rep = "";


            $ordersData = array();

            $table_name = $wpdb->prefix . "wpefc_logs";
            if ($formID == 0) {
                $logs = $wpdb->get_results("SELECT * FROM $table_name WHERE checked=1 ORDER BY id DESC");
            } else {
                $logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND checked=1 ORDER BY id DESC", $formID));
            }

            foreach ($logs as $log) {
                $verifiedPayment = __('No', 'lfb');
                if ($log->paid) {
                    $verifiedPayment = __('Yes', 'lfb');
                }
                $statusText = '';
                if ($log->status == 'pending') {
                    $statusText = __('Pending', 'lfb');
                } else if ($log->status == 'canceled') {
                    $statusText = __('Canceled', 'lfb');
                } else if ($log->status == 'beingProcessed') {
                    $statusText = __('Being processed', 'lfb');
                } else if ($log->status == 'shipped') {
                    $statusText = __('Shipped', 'lfb');
                } else if ($log->status == 'completed') {
                    $statusText = __('Completed', 'lfb');
                }
                $orderData = new stdClass();
                $orderData->id = $log->id;
                $orderData->formID = $log->formID;
                $orderData->customerID = $log->customerID;
                $orderData->ref = $log->ref;
                $orderData->verifiedPayment = $verifiedPayment;
                $orderData->statusText = $statusText;
                $orderData->totalSubscription = $log->totalSubscription;
                $orderData->totalPrice = $log->totalPrice;
                $orderData->currency = $log->currency;
                $orderData->currencyPosition = $log->currencyPosition;
                $orderData->decimalsSeparator = $log->decimalsSeparator;
                $orderData->thousandsSeparator = $log->thousandsSeparator;
                $orderData->millionSeparator = $log->millionSeparator;
                $orderData->billionsSeparator = $log->billionsSeparator;

                $orderData->dateLog = date(get_option('date_format'), strtotime($log->dateLog));
                $orderData->email = $this->parent->stringDecode($log->email, $settings->encryptDB);
                $orderData->firstName = $this->parent->stringDecode($log->firstName, $settings->encryptDB);
                $orderData->lastName = $this->parent->stringDecode($log->lastName, $settings->encryptDB);
                $ordersData[] = $orderData;
            }

            //  echo $rep;
            echo json_encode($ordersData);
            die();
        }
    }

    /* Load Log */

    function loadLog() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $settings = $this->getSettings();
            $logID = sanitize_text_field($_POST['logID']);
            $rep = "";
            $table_name = $wpdb->prefix . "wpefc_logs";
            $log = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s", $logID));
            if (count($log) > 0) {
                $log = $log[0];

                $table_name = $wpdb->prefix . "wpefc_forms";
                $form = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $log->formID));
                if (count($form) > 0) {
                    $form = $form[0];

                    $txt_orderType = $form->txt_invoice;
                    if (!$log->paid) {
                        $txt_orderType = $form->txt_quotation;
                    }

                    if (strpos($log->content, 'style') === false && $settings->encryptDB) {
                        $log->content = $this->parent->stringDecode($log->content, $settings->encryptDB);
                    }

                    $lastPos = 0;
                    $positions = array();
                    $toReplaceDefault = array();
                    $toReplaceBy = array();
                    while (($lastPos = strpos($log->content, '<span class="lfb_value">', $lastPos)) !== false) {
                        $positions[] = $lastPos;
                        $lastPos = $lastPos + strlen('<span class="lfb_value">');
                        $fileStartPos = $lastPos;
                        $lastSpan = strpos($log->content, '</span>', $fileStartPos);
                        $value = substr($log->content, $fileStartPos, $lastSpan - $fileStartPos);
                        $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
                        $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringDecode($value, $settings->encryptDB) . '</span>';
                    }
                    foreach ($toReplaceBy as $key => $value) {
                        $log->content = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $log->content);
                    }

                    $log->content = str_replace("[order_type]", $txt_orderType, $log->content);
                    $log->content .= '<div id="lfb_logTotal" style="display: none;">' . $log->totalPrice . '</div>';
                    $log->content .= '<div id="lfb_logSubTotal" style="display: none;">' . $log->totalSubscription . '</div>';
                    $log->content .= '<div id="lfb_logCurrency" style="display: none;">' . $form->currency . '</div>';
                    $log->content .= '<div id="lfb_logCurrencyPosition" style="display: none;">' . $form->currencyPosition . '</div>';
                    $log->content .= '<div id="lfb_logDecSep" style="display: none;">' . $form->decimalsSeparator . '</div>';
                    $log->content .= '<div id="lfb_logThousSep" style="display: none;">' . $form->thousandsSeparator . '</div>';
                    $log->content .= '<div id="lfb_logMilSep" style="display: none;">' . $form->millionSeparator . '</div>';
                    $log->content .= '<div id="lfb_logSubTxt" style="display: none;">' . $form->subscription_text . '</div>';
                    $log->content .= '<div id="lfb_currentLogUseSub" style="display: none;">' . $form->isSubscription . '</div>';
                    $log->content .= '<div id="lfb_currentLogIsPaid" style="display: none;">' . $log->paid . '</div>';
                    $log->content .= '<div id="lfb_currentLogStatus" style="display: none;">' . $log->status . '</div>';
                    $canPay = 0;
                    if ($form->use_stripe || ($form->use_paypal && $form->paypal_useIpn)) {
                        $canPay = 1;
                    }
                    $log->content .= '<div id="lfb_logCanPay" style="display: none;">' . $canPay . '</div>';



                    $rep = $log->content;
                }
            }
            echo $rep;
            die();
        }
    }

    public function removeLog() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $logID = intval($_POST['logID']);
            $allOrders = sanitize_text_field($_POST['allOrders']);
            $table_name = $wpdb->prefix . "wpefc_logs";

            $log = $wpdb->get_results($wpdb->prepare("SELECT id,email,customerID,sessionF,formID FROM $table_name WHERE id=%s", $logID));
            if (count($log) > 0) {
                $log = $log[0];
                $customerID = $log->customerID;
                $table_nameF = $wpdb->prefix . "wpefc_forms";
                $form = $wpdb->get_results($wpdb->prepare("SELECT id,randomSeed FROM $table_nameF WHERE id=%s", $log->formID));
                if (count($form) > 0) {
                    $form = $form[0];
                    if (is_dir($this->parent->uploads_dir . $log->sessionF . $form->randomSeed)) {
                        $files = glob($this->parent->uploads_dir . $log->sessionF . $form->randomSeed . "/" . '*', GLOB_MARK);
                        foreach ($files as $file) {
                            if (is_file($file))
                                unlink($file);
                        }
                        rmdir($this->parent->uploads_dir . $log->sessionF . $form->randomSeed);
                    }
                }

                if ($allOrders == 1) {
                    $wpdb->delete($table_name, array('customerID' => $log->customerID));
                    $table_nameCalEv = $wpdb->prefix . "wpefc_calendarEvents";
                    $wpdb->delete($table_nameCalEv, array('customerID' => $log->customerID));
                } else {
                    $wpdb->delete($table_name, array('id' => $logID));
                    $table_nameCalEv = $wpdb->prefix . "wpefc_calendarEvents";
                    $wpdb->delete($table_nameCalEv, array('orderID' => $logID));
                }




                $logs = $wpdb->get_results($wpdb->prepare("SELECT id,customerID FROM $table_name WHERE customerID=%s LIMIT 1", $customerID));
                if (count($logs) == 0) {
                    $table_nameC = $wpdb->prefix . "wpefc_customers";
                    $wpdb->delete($table_name, array('customerID' => $customerID));
                }
                //}
            }
        }
        die();
    }

    public function removeLogs() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $logsIDs = sanitize_text_field($_POST['logsIDs']);
            $logsIDs = explode(',', $logsIDs);
            foreach ($logsIDs as $logID) {
                $table_name = $wpdb->prefix . "wpefc_logs";

                $log = $wpdb->get_results($wpdb->prepare("SELECT id,email,customerID,sessionF,formID FROM $table_name WHERE id=%s", $logID));
                if (count($log) > 0) {
                    $log = $log[0];
                    $customerID = $log->customerID;
                    $table_nameF = $wpdb->prefix . "wpefc_forms";
                    $form = $wpdb->get_results($wpdb->prepare("SELECT id,randomSeed FROM $table_nameF WHERE id=%s", $log->formID));
                    if (count($form) > 0) {
                        $form = $form[0];
                        if (is_dir($this->parent->uploads_dir . $log->sessionF . $form->randomSeed)) {
                            $files = glob($this->parent->uploads_dir . $log->sessionF . $form->randomSeed . "/" . '*', GLOB_MARK);
                            foreach ($files as $file) {
                                if (is_file($file))
                                    unlink($file);
                            }
                            rmdir($this->parent->uploads_dir . $log->sessionF . $form->randomSeed);
                        }
                    }

                    if ($allOrders == 1) {
                        $wpdb->delete($table_name, array('email' => $log->email));
                    } else {
                        $wpdb->delete($table_name, array('id' => $logID));
                    }

                    $logs = $wpdb->get_results($wpdb->prepare("SELECT id,customerID FROM $table_name WHERE customerID=%s LIMIT 1", $customerID));
                    if (count($logs) == 0) {
                        $table_nameC = $wpdb->prefix . "wpefc_customers";
                        $wpdb->delete($table_name, array('customerID' => $customerID));
                    }
                    //}
                }
                //   $wpdb->delete($table_name, array('id' => $logID));
            }
        }
        die();
    }

    /*
     * Load admin styles
     */

    function admin_styles() {
        if (isset($_GET['page']) && strpos($_GET['page'], 'lfb_') === 0) {
            $settings = $this->getSettings();
            wp_register_style($this->parent->_token . '-reset', esc_url($this->parent->assets_url) . 'css/reset.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-jqueryui', esc_url($this->parent->assets_url) . 'css/jquery-ui-theme/jquery-ui.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-bootstrap', esc_url($this->parent->assets_url) . 'css/bootstrap.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-bootstrap-timepicker', esc_url($this->parent->assets_url) . 'css/bootstrap-datetimepicker.min.css', array(), $this->parent->_version);

            wp_register_style($this->parent->_token . '-bootstrap-select', esc_url($this->parent->assets_url) . 'css/bootstrap-select.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-flat-uiA', esc_url($this->parent->assets_url) . 'css/flat-ui_admin.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-colpick', esc_url($this->parent->assets_url) . 'css/colpick.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-lfb-admin', esc_url($this->parent->assets_url) . 'css/lfb_admin.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-fontawesome', esc_url($this->parent->assets_url) . 'css/font-awesome.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-fullcalendar', esc_url($this->parent->assets_url) . 'css/fullcalendar.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-editor', esc_url($this->parent->assets_url) . 'css/summernote.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-editorB3', esc_url($this->parent->assets_url) . 'css/summernote-bs3.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-codemirror', esc_url($this->parent->assets_url) . 'css/codemirror.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-codemirrorTheme', esc_url($this->parent->assets_url) . 'css/codemirror-xq-light.min.css', array(), $this->parent->_version);
            wp_register_style($this->parent->_token . '-datetimepicker', esc_url($this->parent->assets_url) . 'css/bootstrap-datetimepicker.min.css', array(), $this->parent->_version);



            wp_enqueue_style($this->parent->_token . '-reset');
            wp_enqueue_style($this->parent->_token . '-jqueryui');
            wp_enqueue_style($this->parent->_token . '-bootstrap');
            wp_enqueue_style($this->parent->_token . '-bootstrap-reponsiveTabs');
            wp_enqueue_style($this->parent->_token . '-bootstrap-select');
            //   wp_enqueue_style($this->parent->_token . '-bootstrap-timepicker');
            wp_enqueue_style($this->parent->_token . '-flat-uiA');
            wp_enqueue_style($this->parent->_token . '-colpick');
            wp_enqueue_style($this->parent->_token . '-fontawesome');
            wp_enqueue_style($this->parent->_token . '-editor');
            wp_enqueue_style($this->parent->_token . '-editorB3');
            wp_enqueue_style($this->parent->_token . '-fullcalendar');
            wp_enqueue_style($this->parent->_token . '-codemirror');
            wp_enqueue_style($this->parent->_token . '-codemirrorTheme');
            wp_enqueue_style($this->parent->_token . '-datetimepicker');
            wp_register_style($this->parent->_token . '-lfb-designer', esc_url($this->parent->assets_url) . 'css/lfb_formDesigner.min.css', array(), $this->parent->_version);
            wp_enqueue_style($this->parent->_token . '-lfb-designer');

            wp_enqueue_style($this->parent->_token . '-lfb-admin');
            wp_enqueue_style($this->parent->_token . '-core-components');
        }
        wp_register_style($this->parent->_token . '-lfb-adminGlobal', esc_url($this->parent->assets_url) . 'css/lfb_admin_global.css', array(), $this->parent->_version);
        wp_enqueue_style($this->parent->_token . '-lfb-adminGlobal');
    }

    /*
     * Load admin scripts
     */

    function admin_scripts() {
        if (isset($_GET['page']) && strpos($_GET['page'], 'lfb_') === 0) {
            $settings = $this->getSettings();
            $this->parent->clearSessions();

            if (!is_dir(plugin_dir_path(__FILE__) . '../export')) {
                mkdir(plugin_dir_path(__FILE__) . '../export');
                chmod(plugin_dir_path(__FILE__) . '../export', $this->parent->chmodWrite);
            }

            wp_register_script($this->parent->_token . '-bootstrap', esc_url($this->parent->assets_url) . 'js/bootstrap.min.js', array('jquery', "jquery-ui-core"), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-bootstrap');
            wp_register_script($this->parent->_token . '-bootstrap-select', esc_url($this->parent->assets_url) . 'js/bootstrap-select.min.js', array($this->parent->_token . '-bootstrap'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-bootstrap-select');
            wp_register_script($this->parent->_token . '-bootstrap-timepicker', esc_url($this->parent->assets_url) . 'js/bootstrap-datetimepicker.min.js', array($this->parent->_token . '-bootstrap'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-bootstrap-timepicker');
            wp_register_script($this->parent->_token . '-datatable', esc_url($this->parent->assets_url) . 'js/jquery.dataTables.min.js', array($this->parent->_token . '-bootstrap'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-datatable');
            wp_register_script($this->parent->_token . '-bootstrap-datatable', esc_url($this->parent->assets_url) . 'js/dataTables.bootstrap.min.js', array($this->parent->_token . '-datatable'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-bootstrap-datatable');
            wp_register_script($this->parent->_token . '-bootstrap-switch', esc_url($this->parent->assets_url) . 'js/bootstrap-switch.js', array('jquery', "jquery-ui-core"), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-bootstrap-switch');
            wp_register_script($this->parent->_token . '-colpick', esc_url($this->parent->assets_url) . 'js/colpick.js', array('jquery'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-colpick');
            wp_register_script($this->parent->_token . '-editor', esc_url($this->parent->assets_url) . 'js/summernote.min.js', array('jquery', "jquery-ui-core", $this->parent->_token . '-bootstrap'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-editor');
            wp_register_script($this->parent->_token . '-moment', esc_url($this->parent->assets_url) . 'js/moment.min.js', array(), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-moment');
            wp_register_script($this->parent->_token . '-mask', esc_url($this->parent->assets_url) . 'js/jquery.mask.min.js', array(), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-mask');
            wp_register_script($this->parent->_token . '-fullcalendar', esc_url($this->parent->assets_url) . 'js/fullcalendar.min.js', array($this->parent->_token . '-bootstrap', $this->parent->_token . '-moment'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-fullcalendar');
            wp_register_script($this->parent->_token . '-nicescroll', esc_url($this->parent->assets_url) . 'js/jquery.nicescroll.min.js', 'jquery', $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-nicescroll');
            wp_register_script($this->parent->_token . '-googleCharts', 'https://www.gstatic.com/charts/loader.js', array('jquery'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-googleCharts');
            wp_register_script($this->parent->_token . '-codemirror', esc_url($this->parent->assets_url) . 'js/codemirror.min.js', array(), $this->parent->_version, true);
            wp_enqueue_script($this->parent->_token . '-codemirror');
            wp_register_script($this->parent->_token . '-codemirrorJS', esc_url($this->parent->assets_url) . 'js/codemirror-javascript.min.js', array(), $this->parent->_version, true);
            wp_enqueue_script($this->parent->_token . '-codemirrorJS');
            wp_register_script($this->parent->_token . '-codemirrorCSS', esc_url($this->parent->assets_url) . 'js/codemirror-css.min.js', array(), $this->parent->_version, true);
            wp_enqueue_script($this->parent->_token . '-codemirrorCSS');



            $locale = get_locale();
            if (strpos($locale, '_') > -1) {
                $locale = substr($locale, 0, strpos($locale, '_'));
            }
            if (file_exists($this->parent->assets_dir . '/js/calendarLocale/' . $locale . '.js')) {
                wp_register_script($this->parent->_token . '-calendarLocale', esc_url($this->parent->assets_url) . 'js/calendarLocale/' . $locale . '.js', array('jquery'), $this->parent->_version);
                wp_enqueue_script($this->parent->_token . '-calendarLocale');
            } else {
                $locale = 'en';
            }
            wp_register_script($this->parent->_token . '-datetimepicker', esc_url($this->parent->assets_url) . 'js/bootstrap-datetimepicker.min.js', array('jquery'), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-datetimepicker');

            if (file_exists($this->parent->assets_dir . '/js/datepickerLocale/bootstrap-datetimepicker.' . $locale . '.js')) {
                wp_register_script($this->parent->_token . '-datepickerLocale', esc_url($this->parent->assets_url) . 'js/datepickerLocale/bootstrap-datetimepicker.' . $locale . '.js', array('jquery'), $this->parent->_version);
                wp_enqueue_script($this->parent->_token . '-datepickerLocale');
            }

            wp_register_script($this->parent->_token . '-lfb-designer', esc_url($this->parent->assets_url) . 'js/lfb_formDesigner.min.js', array('jquery', "jquery-ui-slider", "jquery-ui-resizable"), $this->parent->_version);
            wp_enqueue_script($this->parent->_token . '-lfb-designer');

            wp_register_script($this->parent->_token . '-lfb-admin', esc_url($this->parent->assets_url) . 'js/lfb_admin.min.js', array("jquery-ui-autocomplete", "jquery-ui-draggable", "jquery-ui-droppable", "jquery-ui-resizable", "jquery-ui-sortable", "jquery-ui-datepicker", "jquery-ui-slider", $this->parent->_token . '-bootstrap-switch', $this->parent->_token . '-editor'), $this->parent->_version, true);
            wp_enqueue_script($this->parent->_token . '-lfb-admin');

            $lscVerified = 0;
            if (strlen($settings->purchaseCode) > 8 || get_option('lfb_themeMode')) {
                $lscVerified = 1;
            }
            $designForm = 0;
            if (isset($_GET['lfb_formDesign'])) {
                $designForm = sanitize_text_field($_GET['lfb_formDesign']);
            }
            $showMeridian = 0;
            if (strpos(strtolower(get_option('time_format')), 'g') > -1) {
                $showMeridian = 1;
            }
            $js_data[] = array(
                'assetsUrl' => esc_url($this->parent->assets_url),
                'websiteUrl' => esc_url(get_site_url()),
                'exportUrl' => esc_url(trailingslashit(plugins_url('/export/', $this->parent->file))),
                'designForm' => $designForm,
                'dateFormat' => stripslashes($this->parent->dateFormatToDatePickerFormat(get_option('date_format'))),
                'timeFormat' => $this->parent->timeFormatToDatePickerFormat(get_option('time_format')),
                'timeFormatCal' => $this->parent->timeFormatToCalendarFormat(get_option('time_format')),
                'timeFormatMoment' => $this->parent->timeFormatToMomentFormat(get_option('time_format')),
                'dateMeridian' => $showMeridian,
                'lscV' => $lscVerified,
                'locale' => $locale,
                'texts' => array(
                    'tip_flagStep' => __('Click the flag icon to set this step at first step', 'lfb'),
                    'tip_linkStep' => __('Start a link to another step', 'lfb'),
                    'tip_delStep' => __('Remove this step', 'lfb'),
                    'tip_duplicateStep' => __('Duplicate this step', 'lfb'),
                    'tip_editStep' => __('Edit this step', 'lfb'),
                    'tip_editLink' => __('Edit a link', 'lfb'),
                    'isSelected' => __('Is selected', 'lfb'),
                    'isUnselected' => __('Is unselected', 'lfb'),
                    'isPriceSuperior' => __('Is price superior to', 'lfb'),
                    'isPriceInferior' => __('Is price inferior to', 'lfb'),
                    'isPriceEqual' => __('Is price equal to', 'lfb'),
                    'isntPriceEqual' => __("Is price different than", 'lfb'),
                    'isSuperior' => __('Is superior to', 'lfb'),
                    'isInferior' => __('Is inferior to', 'lfb'),
                    'isEqual' => __('Is equal to', 'lfb'),
                    'isntEqual' => __("Is different than", 'lfb'),
                    'isQuantitySuperior' => __('Quantity selected is superior to', 'lfb'),
                    'isQuantityInferior' => __('Quantity selected is inferior to', 'lfb'),
                    'isQuantityEqual' => __('Quantity is equal to', 'lfb'),
                    'isntQuantityEqual' => __("Quantity is different than", 'lfb'),
                    'totalPrice' => __('Total price', 'lfb'),
                    'totalQuantity' => __('Total quantity', 'lfb'),
                    'isFilled' => __('Is Filled', 'lfb'),
                    'errorExport' => __('An error occurred during the exportation. Please verify that your server supports the ZipArchive php library ', 'lfb'),
                    'errorImport' => __('An error occurred during the importation. Please verify that your server supports the ZipArchive php library ', 'lfb'),
                    'Yes' => __('Yes', 'lfb'),
                    'No' => __('No', 'lfb'),
                    'days' => __('Days', 'lfb'),
                    'hours' => __('Hours', 'lfb'),
                    'weeks' => __('Weeks', 'lfb'),
                    'months' => __('Months', 'lfb'),
                    'years' => __('Years', 'lfb'),
                    'amountOrders' => __('Amount of orders', 'lfb'),
                    'oneTimePayment' => __('One time payments or estimates', 'lfb'),
                    'subscriptions' => __('Subscriptions', 'lfb'),
                    'lastStep' => __('Last Step', 'lfb'),
                    'Nothing' => __('Nothing', 'lfb'),
                    'selectAnElement' => __('Select an element of your website', 'tld'),
                    'stopSelection' => __('Stop the selection', 'tld'),
                    'stylesApplied' => __('The styles are applied', 'tld'),
                    'modifsSaved' => __('Styles are now applied to the website', 'tld'),
                    'My step' => __('My step', 'lfb'),
                    'value' => __('Value', 'lfb'),
                    'quantity' => __('Quantity', 'lfb'),
                    'price' => __('Price', 'lfb'),
                    'myNewLayer' => __('My new Layer', 'lfb'),
                    'edit' => __('Edit', 'lfb'),
                    'style' => __('Style', 'lfb'),
                    'editConditions' => __('Edit the visibility conditions', 'lfb'),
                    'duplicate' => __('Duplicate', 'lfb'),
                    'remove' => __('Remove', 'lfb'),
                    'display' => __('Display', 'lfb'),
                    'search' => __('Search', 'lfb'),
                    'showingPage' => sprintf(__('Showing page %1$s of %2$s', 'lfb'), '_PAGE_', '_PAGES_'),
                    'filteredFrom' => sprintf(__('- filtered from %1$s documents', 'lfb'), '_MAX_'),
                    'noRecords' => __('No documents to display', 'lfb'),
                    'minSizeTip' => __('Fill this field to limit the minimum number of characters', 'lfb'),
                    'maxSizeTip' => __('Fill this field to limit the maximum number of characters', 'lfb'),
                    'newEventContent' => __('An event will take place on [date], at [time] !', 'lfb'),
                    'newEventSubject' => __('New event !', 'lfb'),
                    'noReminders' => __('There is no reminders yet', 'lfb'),
                    'noCategories' => __('There is no categories yet', 'lfb'),
                    'newEvent' => __('New event', 'lfb'),
                    'userEmailTip' => __('If true, the user will receive a confirmation email', 'lfb'),
                    'userEmailTipDisabled' => __('You need to disable the GDPR option to be able to disable this option', 'lfb'),
                    'Currency' => __('Currency', 'lfb'),
                    'Integer' => __('Integer', 'lfb'),
                    'Float' => __('Float', 'lfb'),
                    'My Variable' => __('My Variable', 'lfb'),
                    'View this order' => __('View this order', 'lfb'),
                    'Download the order' => __('Download the order', 'lfb'),
                    'Delete this order' => __('Delete this order', 'lfb'),
                    'Customer information' => __('Customer information', 'lfb'),
                    'Total price of the form' => __('Total price of the form', 'lfb'),
                    'Total selected quantity in the form' => __('Total selected quantity in the form', 'lfb'),
                    'Price of the item [item]' => __('Price of the item [item]', 'lfb'),
                    'Quantity of the item [item]' => __('Quantity of the item [item]', 'lfb'),
                    'Value of the item [item]' => __('Value of the item [item]', 'lfb'),
                    'Title of the item [item]' => __('Title of the item [item]', 'lfb'),
                    'Total quantity of the step [step]' => __('Total quantity of the step [step]', 'lfb'),
                    'Total price of the step [step]' => __('Total price of the step [step]', 'lfb'),
                    'Title of the step [step]' => __('Title of the step [step]', 'lfb'),
                    'Variable' => __('Variable', 'lfb'),
                    'Automatic' => __('Automatic', 'lfb')
                )
            );
            wp_localize_script($this->parent->_token . '-lfb-admin', 'lfb_data', $js_data);
        }
    }

    private function jsonRemoveUnicodeSequences($struct) {
        return json_encode($struct);
    }

    public function resetReference() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $formID = sanitize_text_field($_POST['formID']);
            $table_name = $wpdb->prefix . "wpefc_forms";
            $wpdb->update($table_name, array('current_ref' => 0), array('id' => $formID));
        }
        die();
    }

    public function loadCharts() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $formID = sanitize_text_field($_POST['formID']);
            $mode = sanitize_text_field($_POST['mode']);
            $rep = '';
            $conditionChecked = '';
            $table_name = $wpdb->prefix . "wpefc_forms";
            $form = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
            if (count($form) > 0) {
                if ($mode == 'all') {
                    $table_name = $wpdb->prefix . "wpefc_logs";
                    $logs = $wpdb->get_results("SELECT * FROM $table_name ORDER BY dateLog ASC LIMIT 1");
                    $yearMin = date('Y');
                    $currentYear = date('Y');
                    if (count($logs) > 0) {
                        $log = $logs[0];
                        $yearMin = substr($log->dateLog, 0, 4);
                    }
                    $rep .= ($yearMin - 1) . ';0;0|';
                    for ($a = $yearMin; $a <= $currentYear; $a++) {
                        $table_name = $wpdb->prefix . "wpefc_logs";
                        $logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND dateLog LIKE '" . $a . "-%' ORDER BY dateLog ASC", $formID));
                        $valuePrice = 0;
                        $valueSubs = 0;
                        foreach ($logs as $log) {
                            $valuePrice += $log->totalPrice;
                            $valueSubs += $log->totalSubscription;
                        }
                        $rep .= $a . ';' . $valuePrice . ';' . $valueSubs . '|';
                    }
                } else if ($mode == 'month') {
                    $yearMonth = sanitize_text_field($_POST['yearMonth']);
                    $year = substr($yearMonth, 0, 4);
                    $month = substr($yearMonth, 6, 2);
                    $nbDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                    for ($i = 1; $i <= $nbDays; $i++) {
                        $table_name = $wpdb->prefix . "wpefc_logs";
                        $logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND dateLog LIKE '" . $yearMonth . '-' . $i . "' ORDER BY dateLog ASC", $formID));
                        $valuePrice = 0;
                        $valueSubs = 0;
                        foreach ($logs as $log) {
                            $valuePrice += $log->totalPrice;
                            $valueSubs += $log->totalSubscription;
                        }
                        $rep .= $i . ';' . $valuePrice . ';' . $valueSubs . '|';
                    }
                } else {
                    $year = sanitize_text_field($_POST['year']);
                    for ($i = 1; $i <= 12; $i++) {
                        $month = $i;
                        if ($month < 10) {
                            $month = '0' . $month;
                        }
                        $yearMonth = $year . '-' . $month;

                        $table_name = $wpdb->prefix . "wpefc_logs";
                        $yearMonth = $yearMonth . '%';
                        $logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND dateLog LIKE '%s' ORDER BY dateLog ASC", $formID, $yearMonth));
                        $valuePrice = 0;
                        $valueSubs = 0;
                        foreach ($logs as $log) {
                            $valuePrice += $log->totalPrice;
                            $valueSubs += $log->totalSubscription;
                        }
                        $rep .= $month . ';' . $valuePrice . ';' . $valueSubs . '|';
                    }
                    if (strlen($rep) > 0) {
                        $rep = substr($rep, 0, -1);
                    } else {
                        $rep = '0;0;0|';
                    }
                }
            }
            echo $rep;
            die();
        }
    }

    /*
     * Plugin init localization Tld
     */

    public function init_tld_localization() {
        $settings = $this->getSettings();
        $moFiles = scandir(trailingslashit($this->dir) . 'languages/tdgn/');
        if (get_locale() == "") {
            load_textdomain('lfb', trailingslashit($this->dir) . 'languages/tdgn/WP_FormDesigner.mo');
            return;
        }
        foreach ($moFiles as $moFile) {
            if (strlen($moFile) > 3 && substr($moFile, -3) == '.mo' && strpos($moFile, get_locale()) > -1) {
                load_textdomain('tld', trailingslashit($this->dir) . 'languages/tdgn/' . $moFile);
            }
        }
    }

    public function addForm() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $randSeed = $this->generateRandomString(5);
            $table_name = $wpdb->prefix . "wpefc_forms";
            $wpdb->insert($table_name, array('title' => 'My new Form', 'btn_step' => "NEXT STEP", 'previous_step' => "return to previous step", 'intro_title' => "HOW MUCH TO MAKE MY WEBSITE ?", 'intro_text' => "Estimate the cost of a website easily using this awesome tool.", 'intro_btn' => "GET STARTED", 'last_title' => "Final cost", 'last_text' => "The final estimated price is : ", 'last_btn' => "ORDER MY WEBSITE", 'last_msg_label' => "Do you want to write a message ? ", 'succeed_text' => "Thanks, we will contact you soon", 'initial_price' => 0, 'email' => 'your@email.com', 'email_subject' => 'New order from your website', 'currency' => '$', 'currencyPosition' => 'left', 'errorMessage' => 'You need to select an item to continue', 'intro_enabled' => 0, 'email_userSubject' => 'Order confirmation',
                'ref_root' => $this->generateRandomString(2) . '0000',
                'email_name' => get_bloginfo('name'),
                'pdf_adminContent' => '<p style="text-align:right;"><strong>[order_type]</strong></p><p style="text-align:right;">Ref: <strong>[ref]</strong></p><h2 style="color: #008080;">Information</h2><hr/><span style="color: #444444;">[information_content]</span><span style="color: #444444;"> </span><hr/><h2 style="color: #008080;">Project</h2><hr/>[project_content]',
                'pdf_userContent' => '<p style="text-align:right;"><strong>[order_type]</strong></p><p style="text-align:right;">Ref: <strong>[ref]</strong></p><h2 style="color: #008080;">Information</h2><hr/><span style="color: #444444;">[information_content]</span><span style="color: #444444;"> </span><hr/><h2 style="color: #008080;">Project</h2><hr/>[project_content]<hr/><p><span style="font-style:italic;">Thank you for your confidence.</span></p>',
                'email_adminContent' => '<p style="text-align:right;"><strong>[order_type]</strong></p><p style="text-align:right;">Ref: <strong>[ref]</strong></p><h2 style="color: #008080;">Information</h2><hr/><span style="color: #444444;">[information_content]</span><span style="color: #444444;"> </span><hr/><h2 style="color: #008080;">Project</h2><hr/>[project_content]',
                'email_userContent' => '<p style="text-align:right;"><strong>[order_type]</strong></p><p style="text-align:right;">Ref: <strong>[ref]</strong></p><h2 style="color: #008080;">Information</h2><hr/><span style="color: #444444;">[information_content]</span><span style="color: #444444;"> </span><hr/><h2 style="color: #008080;">Project</h2><hr/>[project_content]<hr/><p><span style="font-style:italic;">Thank you for your confidence.</span></p>',
                'colorA' => '#1abc9c', 'colorB' => '#34495e', 'colorC' => '#bdc3c7',
                'colorSecondary' => '#bdc3c7', 'colorSecondaryTxt' => '#ffffff', 'colorCbCircle' => '#7f8c9a', 'colorCbCircleOn' => '#bdc3c7',
                'item_pictures_size' => 128, 'colorBg' => '#ecf0f1', 'summary_title' => 'Summary', 'summary_description' => 'Description', 'summary_quantity' => 'Quantity', 'summary_price' => 'Price', 'summary_value' => 'Information', 'summary_total' => 'Total :', 'legalNoticeTitle' => 'I certify I completely read and I accept the legal notice by validating this form',
                'legalNoticeContent' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam faucibus lectus ac massa dictum, rhoncus bibendum mauris volutpat. Aenean venenatis mi porta gravida dignissim. Mauris eu ipsum convallis, semper massa sed, bibendum justo. Pellentesque porta suscipit aliquet. Integer quis odio tempus nibh cursus sollicitudin. Vivamus at rutrum dui. Proin sit amet porta neque, ac hendrerit purus.',
                'decimalsSeparator' => '.', 'thousandsSeparator' => ',', 'stripe_label_creditCard' => 'Credit card number', 'stripe_label_cvc' => 'CVC',
                'stripe_label_expiration' => 'Expiration date', 'stripe_currency' => 'USD', 'stripe_subsFrequencyType' => 'month',
                'redirectionDelay' => 5, 'useRedirectionConditions' => 0, 'txtDistanceError' => 'Calculating the distance could not be performed, please verify the input addresses',
                'nextStepButtonIcon' => 'fa-check', 'previousStepButtonIcon' => 'fa-arrow-left', 'nextStepButtonIcon' => 'fa-check', 'introButtonIcon' => 'fa-check', 'imgIconStyle' => 'circle',
                'enableEmailPaymentText' => 'I validate this order and proceed to the payment',
                'saveForLaterDelLabel' => 'Delete backup',
                'saveForLaterIcon' => 'fas fa-save',
                'animationsSpeed' => 0.3, 'mainTitleTag' => 'h1', 'stepTitleTag' => 'h2',
                'paymentType' => 'form', 'emailPaymentType' => 'checkbox', 'enableEmailPaymentText' => 'I validate this order and proceed to the payment',
                'enableCustomersData' => 0, 'customersDataEmailLink' => 'According to the GDPR law, you can consult your data and delete them from this page: [url]',
                'stripe_logoImg' => esc_url(trailingslashit(plugins_url('/assets/', $this->parent->file))) . 'img/powered_by_stripe@2x.png',
                'razorpay_logoImg' => esc_url(trailingslashit(plugins_url('/assets/', $this->parent->file))) . 'img/creditCard@2x.png',
                'randomSeed' => $randSeed,
                'razorpay_currency' => 'USD', 'razorpay_subsFrequencyType' => 'monthly', 'razorpay_percentToPay' => 100,
                'txt_btnRazorpay' => 'Pay with Razorpay',
                'txt_stripe_title' => 'Make a payment',
                'txt_stripe_btnPay' => 'Pay now',
                'txt_stripe_totalTxt' => 'Total to pay',
                'txt_stripe_paymentFail' => 'Payment could not be made',
                'txt_stripe_cardOwnerLabel' => 'Card owner name',
                'emailVerificationSubject' => 'Here is your email verification code',
                'txt_emailActivationInfo' => 'A unique verification code has just been sent to you by email, please copy it in the field below to validate your email address.',
                'emailVerificationContent' => '<p>Here is the verification code to fill in the form to confirm your email :</p><h1>[code]</h1>',
                'txt_emailActivationCode' => 'Fill your verifiation code here',
                'txtSignature' => 'Signature'
            ));




            $formID = $wpdb->insert_id;
            $table_name = $wpdb->prefix . "wpefc_items";
            $wpdb->insert($table_name, array('formID' => $formID, 'stepID' => 0, 'title' => __("Enter your email", 'lfb'), 'isRequired' => 1, 'type' => 'textfield', 'useRow' => 1, 'fieldType' => 'email', 'validation' => 'email', 'icon' => 'fas fa-envelope'));
            $wpdb->insert($table_name, array('formID' => $formID, 'stepID' => 0, 'title' => __("Message", 'lfb'), 'isRequired' => 0, 'type' => 'textarea', 'useRow' => 1));

            echo $formID;
            die();
        }
    }

    public function duplicateStep() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $table_name = $wpdb->prefix . "wpefc_steps";
            $stepID = sanitize_text_field($_POST['stepID']);
            $steps = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s", $stepID));
            $step = $steps[0];
            $step->title = $step->title . ' (1)';
            $step->start = 0;
            unset($step->id);

            $content = json_decode($step->content);
            $content->previewPosX += 40;
            $content->previewPosY += 40;
            $content->start = 0;
            $step->content = stripslashes($this->jsonRemoveUnicodeSequences($content));

            $wpdb->insert($table_name, (array) $step);
            $newID = $wpdb->insert_id;

            $table_name = $wpdb->prefix . "wpefc_items";
            $items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE stepID=%s", $stepID));
            foreach ($items as $item) {
                $item->stepID = $newID;
                $lastItemID = $item->id;
                unset($item->id);
                $wpdb->insert($table_name, (array) $item);

                $newItemID = $wpdb->insert_id;
                $table_nameL = $wpdb->prefix . "wpefc_layeredImages";
                $layers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameL WHERE itemID=%s", $lastItemID));
                foreach ($layers as $layer) {
                    unset($layer->id);
                    $layer->itemID = $newItemID;
                    $wpdb->insert($table_nameL, (array) $layer);
                }
            }
            die();
        }
    }

    public function duplicateItem() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $table_name = $wpdb->prefix . "wpefc_items";
            $itemID = sanitize_text_field($_POST['itemID']);
            $items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s", $itemID));
            $item = $items[0];
            $item->title = $item->title . ' (1)';
            $lastItemID = $item->id;
            unset($item->id);
            $wpdb->insert($table_name, (array) $item);

            $newItemID = $wpdb->insert_id;
            $table_name = $wpdb->prefix . "wpefc_layeredImages";
            $layers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE itemID=%s", $lastItemID));
            foreach ($layers as $layer) {
                $layer->itemID = $newItemID;
                unset($layer->id);
                $wpdb->insert($table_name, (array) $layer);
            }
            echo $newItemID;
        }
        die();
    }

    public function saveNewTotal() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $orderID = sanitize_text_field($_POST['orderID']);
            $total = sanitize_text_field($_POST['total']);
            $subTotal = sanitize_text_field($_POST['subTotal']);

            $table_name = $wpdb->prefix . "wpefc_logs";
            $wpdb->update($table_name, array('totalPrice' => $total, 'totalSubscription' => $subTotal), array('id' => $orderID));
        }
        die();
    }

    public function changeItemsOrders() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $items = sanitize_text_field($_POST['items']);
            $items = explode(',', $items);
            $table_name = $wpdb->prefix . "wpefc_items";
            foreach ($items as $key => $value) {
                $wpdb->update($table_name, array('ordersort' => $key), array('id' => $value));
            }
        }
        die();
    }

    public function addNewLayerImg() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $itemID = sanitize_text_field($_POST['itemID']);
            $formID = sanitize_text_field($_POST['formID']);

            $table_name = $wpdb->prefix . "wpefc_layeredImages";
            $wpdb->insert($table_name, array('itemID' => $itemID, 'formID' => $formID, 'title' => __('My new layer', 'lfb')));

            $layers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s", $wpdb->insert_id));
            //$rep->layers = $layers;
            echo($this->jsonRemoveUnicodeSequences($layers[0]));
        }
        die();
    }

    public function changeLayersOrder() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $layers = sanitize_text_field($_POST['layers']);
            $layers = explode(',', $layers);
            $table_name = $wpdb->prefix . "wpefc_layeredImages";
            foreach ($layers as $key => $value) {
                $wpdb->update($table_name, array('ordersort' => $key), array('id' => $value));
            }
        }
        die();
    }

    public function changeLastFieldsOrders() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $fields = sanitize_text_field($_POST['fields']);
            $fields = explode(',', $fields);
            $table_name = $wpdb->prefix . "wpefc_items";
            foreach ($fields as $key => $value) {
                $wpdb->update($table_name, array('ordersort' => $key), array('id' => $value));
            }
        }
        die();
    }

    /*
     * Check for  updates
     */

    public function checkAutomaticUpdates() {

        if (current_user_can('manage_options')) {
            $settings = $this->getSettings();
            if ($settings && $settings->purchaseCode != "") {
                require_once('plugin_update_check.php');
                $updateChecker = new PluginUpdateChecker_2_0(
                        'https://kernl.us/api/v1/updates/56af639d99c6c1732b9284ce/', $this->parent->file, 'lfb', 1
                );
                $updateChecker->purchaseCode = $settings->purchaseCode;
            }
        }
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function duplicateForm() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_forms";
            $formID = sanitize_text_field($_POST['formID']);

            $table_forms = $wpdb->prefix . "wpefc_forms";
            $table_steps = $wpdb->prefix . "wpefc_steps";
            $table_items = $wpdb->prefix . "wpefc_items";
            $table_links = $wpdb->prefix . "wpefc_links";
            $table_coupons = $wpdb->prefix . "wpefc_coupons";
            $table_redirections = $wpdb->prefix . "wpefc_redirConditions";
            $table_variables = $wpdb->prefix . "wpefc_variables";


            $forms = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_forms WHERE id=%s LIMIT 1", $formID));
            $form = $forms[0];
            unset($form->id);
            $form->title = $form->title . ' (1)';
            $form->current_ref = 1;
            $wpdb->insert($table_forms, (array) $form);
            $newFormID = $wpdb->insert_id;
            $stepsReplacement = array();
            $itemsReplacement = array();
            $variablesReplacement = array();
            $stepsReplacement[0] = 0;

            $form->formStyles = str_replace('[data-form="' . $formID . '"]', '[data-form="' . $newFormID . '"]', $form->formStyles);
            $form->customCss = str_replace('[data-form="' . $formID . '"]', '[data-form="' . $newFormID . '"]', $form->customCss);
            $form->ref_root = $this->generateRandomString(2) . '0000';
            //$wpdb->update($table_forms, array('formStyles' => $form->formStyles,'customCss'=>$form->customCss), array('id' => $newFormID));

            $variables = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_variables WHERE formID=%s", $formID));
            foreach ($variables as $variable) {
                $varID = $variable->id;
                unset($variable->id);
                $variable->formID = $newFormID;
                $wpdb->insert($table_variables, (array) $variable);
                $newVarID = $wpdb->insert_id;
                $variablesReplacement[$varID] = $newVarID;
            }


            $steps = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_steps WHERE formID=%s", $formID));
            foreach ($steps as $step) {
                $step->formID = $newFormID;
                $stepID = $step->id;
                unset($step->id);

                $wpdb->insert($table_steps, (array) $step);
                $newStepID = $wpdb->insert_id;
                $stepsReplacement[$stepID] = $newStepID;

                $form->formStyles = str_replace('[data-stepid="' . $stepID . '"]', '[data-stepid="' . $newStepID . '"]', $form->formStyles);
                $form->customCss = str_replace('[data-stepid="' . $stepID . '"]', '[data-stepid="' . $newStepID . '"]', $form->customCss);

                $items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_items WHERE stepID=%s", $stepID));
                foreach ($items as $item) {
                    $itemID = $item->id;
                    $lastItemID = $item->id;
                    unset($item->id);
                    $item->stepID = $newStepID;
                    $item->formID = $newFormID;
                    $wpdb->insert($table_items, (array) $item);
                    $newItemID = $wpdb->insert_id;

                    $table_name = $wpdb->prefix . "wpefc_layeredImages";
                    $layers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE itemID=%s", $lastItemID));
                    foreach ($layers as $layer) {
                        $layer->itemID = $newItemID;
                        unset($layer->id);
                        $wpdb->insert($table_name, (array) $layer);
                    }

                    $itemsReplacement[$itemID] = $newItemID;


                    $form->formStyles = str_replace('[data-itemid="' . $itemID . '"]', '[data-itemid="' . $newItemID . '"]', $form->formStyles);
                    $form->customCss = str_replace('[data-itemid="' . $itemID . '"]', '[data-itemid="' . $newItemID . '"]', $form->customCss);
                }
            }

            $itemsLast = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_items WHERE stepID=0 AND formID=%s", $formID));
            foreach ($itemsLast as $item) {
                $itemID = $item->id;
                unset($item->id);
                $item->stepID = 0;
                $item->formID = $newFormID;
                $wpdb->insert($table_items, (array) $item);
                $newItemID = $wpdb->insert_id;

                $itemsReplacement[$itemID] = $newItemID;
                $form->formStyles = str_replace('[data-itemid="' . $itemID . '"]', '[data-itemid="' . $newItemID . '"]', $form->formStyles);
                $form->customCss = str_replace('[data-itemid="' . $itemID . '"]', '[data-itemid="' . $newItemID . '"]', $form->customCss);
            }


            $lastPos = 0;
            $toReplace = array();
            $replaceBy = array();
            while (($lastPos = strpos($form->email_userContent, 'item-', $lastPos)) !== false) {
                $oldItem = substr($form->email_userContent, $lastPos + 5, (strpos($form->email_userContent, '_', $lastPos) - ($lastPos + 5)));
                $toReplace[] = '[item-' . $oldItem;
                $replaceBy[] = '[item-' . $itemsReplacement[$oldItem];
                $lastPos = $lastPos + 5;
            }
            $newContent = $form->email_userContent;
            $i = 0;
            foreach ($replaceBy as $value) {
                $newContent = str_replace($toReplace[$i], $replaceBy[$i], $newContent);
                $i++;
            }
            $form->email_userContent = $newContent;


            $lastPos = 0;
            $toReplace = array();
            $replaceBy = array();
            while (($lastPos = strpos($form->email_adminContent, 'item-', $lastPos)) !== false) {
                $oldItem = substr($form->email_adminContent, $lastPos + 5, (strpos($form->email_adminContent, '_', $lastPos) - ($lastPos + 5)));

                $toReplace[] = '[item-' . $oldItem;
                $replaceBy[] = '[item-' . $itemsReplacement[$oldItem];
                $lastPos = $lastPos + 5;
            }
            $newContent = $form->email_adminContent;
            $i = 0;
            foreach ($replaceBy as $value) {
                $newContent = str_replace($toReplace[$i], $replaceBy[$i], $newContent);
                $i++;
            }
            $form->email_adminContent = $newContent;



            $stepsNew = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_steps WHERE formID=%s", $newFormID));
            foreach ($stepsNew as $step) {
                if ($step->showConditions != "") {
                    $conditions = json_decode($step->showConditions);
                    foreach ($conditions as $condition) {
                        if (strpos($condition->interaction, 'v_') !== FALSE) {
                            $oldVar = substr($condition->interaction, strpos($condition->interaction, '_') + 1);
                            $condition->interaction = 'v_' . $variablesReplacement[$oldVar];
                        } else if (strpos($condition->interaction, '_') !== FALSE) {
                            $oldStep = substr($condition->interaction, 0, strpos($condition->interaction, '_'));
                            $oldItem = substr($condition->interaction, strpos($condition->interaction, '_') + 1);
                            $condition->interaction = $stepsReplacement[$oldStep] . '_' . $itemsReplacement[$oldItem];
                        }

                        if (strpos($condition->value, 'v_') !== FALSE) {
                            $oldVar = substr($condition->value, strpos($condition->value, '_') + 1, (strpos($condition->value, '-') - 1) - strpos($condition->value, '_') + 1);

                            if (substr($oldVar, -1) == '-') {
                                $oldVar = substr($oldVar, 0, -1);
                                $condition->value = 'v_' . $variablesReplacement[$oldVar] . '-';
                            } else {
                                $condition->value = 'v_' . $variablesReplacement[$oldVar];
                            }
                        } else if (strpos($condition->value, '_') !== FALSE) {
                            $oldStep = substr($condition->value, 0, strpos($condition->value, '_'));
                            $oldItem = substr($condition->value, strpos($condition->value, '_') + 1);
                            $condition->value = $stepsReplacement[$oldStep] . '_' . $itemsReplacement[$oldItem];
                        }
                    }

                    $wpdb->update($table_steps, array('showConditions' => $this->jsonRemoveUnicodeSequences($conditions)), array('id' => $step->id));
                }
            }
            $itemsNew = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_items WHERE formID=%s", $newFormID));
            foreach ($itemsNew as $item) {
                if ($item->showConditions != "") {
                    $conditions = json_decode($item->showConditions);
                    foreach ($conditions as $condition) {
                        if (strpos($condition->interaction, 'v_') !== FALSE) {
                            $oldVar = substr($condition->interaction, strpos($condition->interaction, '_') + 1);
                            $condition->interaction = 'v_' . $variablesReplacement[$oldVar];
                        } else if (strpos($condition->interaction, '_') !== FALSE) {
                            $oldStep = substr($condition->interaction, 0, strpos($condition->interaction, '_'));
                            $oldItem = substr($condition->interaction, strpos($condition->interaction, '_') + 1);
                            $condition->interaction = $stepsReplacement[$oldStep] . '_' . $itemsReplacement[$oldItem];
                        }

                        if (isset($condition->value) && strpos($condition->value, 'v_') !== FALSE) {
                            $oldVar = substr($condition->value, strpos($condition->value, '_') + 1, (strpos($condition->value, '-') - 1) - strpos($condition->value, '_') + 1);

                            if (substr($oldVar, -1) == '-') {
                                $oldVar = substr($oldVar, 0, -1);
                                $condition->value = 'v_' . $variablesReplacement[$oldVar] . '-';
                            } else {
                                $condition->value = 'v_' . $variablesReplacement[$oldVar];
                            }
                        } else if (isset($condition->value) && strpos($condition->value, '_') !== FALSE) {
                            $oldStep = substr($condition->value, 0, strpos($condition->value, '_'));
                            $oldItem = substr($condition->value, strpos($condition->value, '_') + 1);
                            $condition->value = $stepsReplacement[$oldStep] . '_' . $itemsReplacement[$oldItem];
                        }
                    }
                    $wpdb->update($table_items, array('showConditions' => $this->jsonRemoveUnicodeSequences($conditions)), array('id' => $item->id));
                }

                if ($item->distanceQt != "") {
                    $lastPosDist = 0;
                    $toReplace = array();
                    $replaceBy = array();

                    while (($lastPosDist = strpos($item->distanceQt, '[distance_', $lastPosDist)) !== false) {
                        $firstSepPos = strpos($item->distanceQt, '_', $lastPosDist + 11);
                        $distitemsA = substr($item->distanceQt, $lastPosDist + 10, $firstSepPos - ($lastPosDist + 10));
                        $distitemsB = substr($item->distanceQt, $firstSepPos + 1, strpos($item->distanceQt, '_', $firstSepPos + 1) - ($firstSepPos + 1));
                        $distType = substr($item->distanceQt, strpos($item->distanceQt, '_', $firstSepPos + 1) + 1, strpos($item->distanceQt, ']', strpos($item->distanceQt, '_', $firstSepPos + 1)) - (strpos($item->distanceQt, '_', $firstSepPos + 1)));
                        $distType = substr($distType, 0, -1);
                        $distitemsA = explode('-', $distitemsA);
                        $distitemsB = explode('-', $distitemsB);
                        $newDistitemsA = array();
                        $newDistitemsB = array();
                        foreach ($distitemsA as $distItemID) {
                            $newDistitemsA[] = $itemsReplacement[$distItemID];
                        }
                        foreach ($distitemsB as $distItemID) {
                            $newDistitemsB[] = $itemsReplacement[$distItemID];
                        }
                        $newDistitemsA = implode('-', $newDistitemsA);
                        $newDistitemsB = implode('-', $newDistitemsB);

                        $toReplace[] = substr($item->distanceQt, $lastPosDist, (strpos($item->distanceQt, ']', $lastPosDist)) - $lastPosDist);
                        $replaceBy[] = '[distance_' . $newDistitemsA . '_' . $newDistitemsB . '_' . $distType;
                        $lastPosDist = $lastPosDist + 11;
                    }

                    $i = 0;
                    $newDistanceQT = $item->distanceQt;
                    $currentIndex = 0;
                    foreach ($replaceBy as $value) {
                        $newDistanceQT = str_replace($toReplace[$i], $replaceBy[$i], $newDistanceQT);
                        $i++;
                    }
                    $wpdb->update($table_items, array('distanceQt' => $newDistanceQT), array('id' => $item->id));
                }
                if ($item->richtext != "") {
                    $lastPos = 0;
                    $lastPosDist = 0;
                    $toReplace = array();
                    $replaceBy = array();
                    while (($lastPos = strpos($item->richtext, 'item-', $lastPos)) !== false) {
                        $oldItem = substr($item->richtext, $lastPos + 5, (strpos($item->richtext, '_', $lastPos) - ($lastPos + 5)));
                        $toReplace[] = $oldItem;
                        $replaceBy[] = $itemsReplacement[$oldItem];
                        $lastPos = $lastPos + 5;
                    }

                    while (($lastPosDist = strpos($item->richtext, '[distance_', $lastPosDist)) !== false) {
                        $firstSepPos = strpos($item->richtext, '_', $lastPosDist + 11);
                        $distitemsA = substr($item->richtext, $lastPosDist + 10, $firstSepPos - ($lastPosDist + 10));
                        $distitemsB = substr($item->richtext, $firstSepPos + 1, strpos($item->richtext, '_', $firstSepPos + 1) - ($firstSepPos + 1));
                        $distType = substr($item->richtext, strpos($item->richtext, '_', $firstSepPos + 1) + 1, strpos($item->richtext, ']', strpos($item->richtext, '_', $firstSepPos + 1)) - (strpos($item->richtext, '_', $firstSepPos + 1)));
                        $distType = substr($distType, 0, -1);
                        $distitemsA = explode('-', $distitemsA);
                        $distitemsB = explode('-', $distitemsB);
                        $newDistitemsA = array();
                        $newDistitemsB = array();
                        foreach ($distitemsA as $distItemID) {
                            $newDistitemsA[] = $itemsReplacement[$distItemID];
                        }
                        foreach ($distitemsB as $distItemID) {
                            $newDistitemsB[] = $itemsReplacement[$distItemID];
                        }
                        $newDistitemsA = implode('-', $newDistitemsA);
                        $newDistitemsB = implode('-', $newDistitemsB);

                        $toReplace[] = substr($item->richtext, $lastPosDist, (strpos($item->richtext, ']', $lastPosDist)) - $lastPosDist);
                        $replaceBy[] = '[distance_' . $newDistitemsA . '_' . $newDistitemsB . '_' . $distType;
                        $lastPosDist = $lastPosDist + 11;
                    }

                    $i = 0;
                    $newCalculation = $item->richtext;
                    $currentIndex = 0;
                    foreach ($replaceBy as $value) {
                        $newCalculation = str_replace($toReplace[$i], $replaceBy[$i], $newCalculation);
                        $i++;
                    }
                    $wpdb->update($table_items, array('richtext' => $newCalculation), array('id' => $item->id));
                }
                if ($item->calculation != "") {
                    $lastPos = 0;
                    $lastPosDist = 0;
                    $toReplace = array();
                    $replaceBy = array();
                    while (($lastPos = strpos($item->calculation, 'item-', $lastPos)) !== false) {
                        $oldItem = substr($item->calculation, $lastPos + 5, (strpos($item->calculation, '_', $lastPos) - ($lastPos + 5)));
                        $toReplace[] = $oldItem;
                        $replaceBy[] = $itemsReplacement[$oldItem];
                        $lastPos = $lastPos + 5;
                    }

                    $lastPos = 0;
                    while (($lastPos = strpos($item->calculation, '[dateDifference-', $lastPos)) !== false) {
                        $firstSepPos = strpos($item->calculation, '_', $lastPos + 16);
                        $dateItem1 = substr($item->calculation, $lastPos + 16, $firstSepPos - ($lastPos + 16));
                        $dateItem2 = substr($item->calculation, $firstSepPos + 1, strpos($item->calculation, ']', $firstSepPos + 1) - ($firstSepPos + 1));

                        if ($dateItem1 != 'currentDate') {
                            $toReplace[] = $dateItem1;
                            $replaceBy[] = $itemsReplacement[$dateItem1];
                        }
                        if ($dateItem2 != 'currentDate') {
                            $toReplace[] = $dateItem2;
                            $replaceBy[] = $itemsReplacement[$dateItem2];
                        }
                        $lastPos = $lastPos + 16;
                    }

                    $lastPos = 0;
                    $lastPosDist = 0;

                    while (($lastPosDist = strpos($item->calculation, '[distance_', $lastPosDist)) !== false) {
                        $firstSepPos = strpos($item->calculation, '_', $lastPosDist + 11);
                        $distitemsA = substr($item->calculation, $lastPosDist + 10, $firstSepPos - ($lastPosDist + 10));
                        $distitemsB = substr($item->calculation, $firstSepPos + 1, strpos($item->calculation, '_', $firstSepPos + 1) - ($firstSepPos + 1));
                        $distType = substr($item->calculation, strpos($item->calculation, '_', $firstSepPos + 1) + 1, strpos($item->calculation, ']', strpos($item->calculation, '_', $firstSepPos + 1)) - (strpos($item->calculation, '_', $firstSepPos + 1)));
                        $distType = substr($distType, 0, -1);
                        $distitemsA = explode('-', $distitemsA);
                        $distitemsB = explode('-', $distitemsB);
                        $newDistitemsA = array();
                        $newDistitemsB = array();
                        foreach ($distitemsA as $distItemID) {
                            $newDistitemsA[] = $itemsReplacement[$distItemID];
                        }
                        foreach ($distitemsB as $distItemID) {
                            $newDistitemsB[] = $itemsReplacement[$distItemID];
                        }
                        $newDistitemsA = implode('-', $newDistitemsA);
                        $newDistitemsB = implode('-', $newDistitemsB);

                        $toReplace[] = substr($item->calculation, $lastPosDist, (strpos($item->calculation, ']', $lastPosDist)) - $lastPosDist);
                        $replaceBy[] = '[distance_' . $newDistitemsA . '_' . $newDistitemsB . '_' . $distType;
                        $lastPosDist = $lastPosDist + 11;
                    }

                    $i = 0;
                    $newCalculation = $item->calculation;
                    $currentIndex = 0;
                    foreach ($replaceBy as $value) {
                        $newCalculation = str_replace($toReplace[$i], $replaceBy[$i], $newCalculation);
                        $i++;
                    }
                    $wpdb->update($table_items, array('calculation' => $newCalculation), array('id' => $item->id));
                }


                if ($item->calculationQt != "") {
                    $lastPos = 0;
                    $lastPosDist = 0;
                    $toReplace = array();
                    $replaceBy = array();
                    while (($lastPos = strpos($item->calculationQt, 'item-', $lastPos)) !== false) {
                        $oldItem = substr($item->calculationQt, $lastPos + 5, (strpos($item->calculationQt, '_', $lastPos) - ($lastPos + 5)));
                        $toReplace[] = $oldItem;
                        $replaceBy[] = $itemsReplacement[$oldItem];
                        $lastPos = $lastPos + 5;
                    }

                    while (($lastPosDist = strpos($item->calculationQt, '[distance_', $lastPosDist)) !== false) {
                        $firstSepPos = strpos($item->calculationQt, '_', $lastPosDist + 11);
                        $distitemsA = substr($item->calculationQt, $lastPosDist + 10, $firstSepPos - ($lastPosDist + 10));
                        $distitemsB = substr($item->calculationQt, $firstSepPos + 1, strpos($item->calculationQt, '_', $firstSepPos + 1) - ($firstSepPos + 1));
                        $distType = substr($item->calculationQt, strpos($item->calculationQt, '_', $firstSepPos + 1) + 1, strpos($item->calculationQt, ']', strpos($item->calculationQt, '_', $firstSepPos + 1)) - (strpos($item->calculationQt, '_', $firstSepPos + 1)));
                        $distType = substr($distType, 0, -1);
                        $distitemsA = explode('-', $distitemsA);
                        $distitemsB = explode('-', $distitemsB);
                        $newDistitemsA = array();
                        $newDistitemsB = array();
                        foreach ($distitemsA as $distItemID) {
                            $newDistitemsA[] = $itemsReplacement[$distItemID];
                        }
                        foreach ($distitemsB as $distItemID) {
                            $newDistitemsB[] = $itemsReplacement[$distItemID];
                        }
                        $newDistitemsA = implode('-', $newDistitemsA);
                        $newDistitemsB = implode('-', $newDistitemsB);

                        $toReplace[] = substr($item->calculationQt, $lastPosDist, (strpos($item->calculationQt, ']', $lastPosDist)) - $lastPosDist);
                        $replaceBy[] = '[distance_' . $newDistitemsA . '_' . $newDistitemsB . '_' . $distType;
                        $lastPosDist = $lastPosDist + 11;
                    }

                    $i = 0;
                    $newCalculation = $item->calculationQt;
                    $currentIndex = 0;
                    foreach ($replaceBy as $value) {
                        $newCalculation = str_replace($toReplace[$i], $replaceBy[$i], $newCalculation);
                        $i++;
                    }
                    $wpdb->update($table_items, array('calculationQt' => $newCalculation), array('id' => $item->id));
                }
            }



            $links = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_links WHERE formID=%s", $formID));
            foreach ($links as $link) {
                unset($link->id);
                $link->originID = $stepsReplacement[$link->originID];
                $link->destinationID = $stepsReplacement[$link->destinationID];
                $link->formID = $newFormID;

                $conditions = json_decode($link->conditions);
                foreach ($conditions as $condition) {

                    if (strpos($condition->interaction, 'v_') !== FALSE) {
                        $oldVar = substr($condition->interaction, strpos($condition->interaction, '_') + 1);
                        $condition->interaction = 'v_' . $variablesReplacement[$oldVar];
                    } else if (strpos($condition->interaction, '_') !== FALSE) {
                        $oldStep = substr($condition->interaction, 0, strpos($condition->interaction, '_'));
                        $oldItem = substr($condition->interaction, strpos($condition->interaction, '_') + 1);
                        $condition->interaction = $stepsReplacement[$oldStep] . '_' . $itemsReplacement[$oldItem];
                    }

                    if (isset($condition->value) && strpos($condition->value, 'v_') !== FALSE) {
                        $oldVar = substr($condition->value, strpos($condition->value, '_') + 1, (strpos($condition->value, '-') - 1) - strpos($condition->value, '_') + 1);

                        if (substr($oldVar, -1) == '-') {
                            $oldVar = substr($oldVar, 0, -1);
                            $condition->value = 'v_' . $variablesReplacement[$oldVar] . '-';
                        } else {
                            $condition->value = 'v_' . $variablesReplacement[$oldVar];
                        }
                    } else if (isset($condition->value) && strpos($condition->value, '_') !== FALSE) {
                        $oldStep = substr($condition->value, 0, strpos($condition->value, '_'));
                        $oldItem = substr($condition->value, strpos($condition->value, '_') + 1);
                        $condition->value = $stepsReplacement[$oldStep] . '_' . $itemsReplacement[$oldItem];
                    }
                }
                $wpdb->insert($table_links, array('operator' => $link->operator, 'conditions' => $this->jsonRemoveUnicodeSequences($conditions), 'originID' => $link->originID, 'destinationID' => $link->destinationID, 'formID' => $newFormID));
            }

            $discounts = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_coupons WHERE formID=%s", $formID));
            foreach ($discounts as $discount) {
                unset($discount->id);
                $discount->formID = $newFormID;
                $wpdb->insert($table_coupons, (array) $discount);
            }

            $redirections = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_redirections WHERE formID=%s", $formID));
            foreach ($redirections as $redirection) {
                unset($redirection->id);
                $redirection->formID = $newFormID;

                $wpdb->insert($table_redirections, (array) $redirection);
            }



            $wpdb->update($table_forms, array('formStyles' => $form->formStyles, 'customCss' => $form->customCss, 'ref_root' => $form->ref_root, 'email_adminContent' => $form->email_adminContent, 'email_userContent' => $form->email_userContent), array('id' => $newFormID));
        }

        die();
    }

    public function tld_exportCSS() {
        global $wpdb;
        if (!is_dir(plugin_dir_path(__FILE__) . '../export')) {
            mkdir(plugin_dir_path(__FILE__) . '../export');
            chmod(plugin_dir_path(__FILE__) . '../export', $this->parent->chmodWrite);
        }
        $settings = $this->getSettings();
        $styles = json_decode(stripslashes($_POST['styles']));
        $formID = (stripslashes($_POST['formID']));
        $gfonts = (stripslashes($_POST['gfonts']));
        $gfonts = explode(',', $gfonts);
        $filename = 'export_css_' . $formID . '.css';
        $existingContent = "";
        $table_name = $wpdb->prefix . "wpefc_forms";
        $formReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
        if (count($formReq) > 0) {
            $existingContent = $formReq[0]->formStyles;
        }
        $css = $this->tdgn_generateCSS($styles, $formID, $gfonts, $existingContent);
        $file = file_put_contents(plugin_dir_path(__FILE__) . '../export/' . $filename, $css . PHP_EOL);
        chmod(plugin_dir_path(__FILE__) . '../export/' . $filename, 0745);

        echo $filename . '?tmp=' . rand(0, 1000) . date('Hmis');
        die();
    }

    public function tld_resetCSS() {
        global $wpdb;
        if (!is_dir(plugin_dir_path(__FILE__) . '../export')) {
            mkdir(plugin_dir_path(__FILE__) . '../export');
            chmod(plugin_dir_path(__FILE__) . '../export', $this->parent->chmodWrite);
        }
        $settings = $this->getSettings();
        $styles = json_decode(stripslashes($_POST['styles']));
        $formID = (stripslashes($_POST['formID']));
        $table_name = $wpdb->prefix . "wpefc_forms";
        $wpdb->update($table_name, array('formStyles' => ''), array('id' => $formID));
        die();
    }

    public function tld_saveCSS() {
        global $wpdb;
        if (!is_dir(plugin_dir_path(__FILE__) . '../export')) {
            mkdir(plugin_dir_path(__FILE__) . '../export');
            chmod(plugin_dir_path(__FILE__) . '../export', $this->parent->chmodWrite);
        }
        $settings = $this->getSettings();
        $styles = (json_decode(stripslashes($_POST['styles'])));
        $formID = sanitize_text_field($_POST['formID']);
        $gfonts = (stripslashes($_POST['gfonts']));
        $gfonts = explode(',', $gfonts);
        $filename = 'formStyles_' . $formID . '.css';
        $existingContent = "";
        $table_name = $wpdb->prefix . "wpefc_forms";
        $formReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
        if (count($formReq) > 0) {
            $existingContent = $formReq[0]->formStyles;
        }
        $css = $this->tdgn_generateCSS($styles, $formID, $gfonts, $existingContent);
        $table_name = $wpdb->prefix . "wpefc_forms";
        $wpdb->update($table_name, array('formStyles' => $css), array('id' => $formID));

        die();
    }

    public function tld_getCSS() {
        global $wpdb;
        $settings = $this->getSettings();
        $formID = sanitize_text_field($_POST['formID']);
        $rep = "";
        $table_name = $wpdb->prefix . "wpefc_forms";
        $formReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
        if (count($formReq) > 0) {
            $rep = $formReq[0]->formStyles;
        }
        echo $rep;
        die();
    }

    public function tld_saveEditedCSS() {
        global $wpdb;
        if (!is_dir(plugin_dir_path(__FILE__) . '../export')) {
            mkdir(plugin_dir_path(__FILE__) . '../export');
            chmod(plugin_dir_path(__FILE__) . '../export', $this->parent->chmodWrite);
        }
        $settings = $this->getSettings();
        $formID = sanitize_text_field($_POST['formID']);
        $css = stripcslashes($_POST['css']);
        $table_name = $wpdb->prefix . "wpefc_forms";
        $wpdb->update($table_name, array('formStyles' => $css), array('id' => $formID));

        die();
    }

    function tdgn_showFormDesigner() {

        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');

        echo '<div id="lfb_bootstraped" class="lfb_bootstraped tld_panel tld_tdgnBootstrap">';
        ?>
        <div id="tld_tdgnContainer">

            <div id="tld_winSaveDialog" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></a>
                            <h4 class="modal-title"><?php echo __('Do you want to save before leaving ?', 'tld'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <p><?php echo __('Do you want to save the modifications you did before leaving ?', 'tld'); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="tld_toggleSavePanel();" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span><?php echo __('Yes', 'tld'); ?></button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="tld_leaveConfirm();"><span class="glyphicon glyphicon-remove"></span><?php echo __('No', 'tld'); ?></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="tld_winSaveApplyDialog" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></a>
                            <h4 class="modal-title"><?php echo __('Apply styles to the current element ?', 'tld'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <p><?php echo __('Do you want to apply the modified styles to the current element before saving ?', 'tld'); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" onclick="tld_saveCurrentElement();
                                            setTimeout(tld_confirmSaveStyles, 500);" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span><?php echo __('Yes', 'tld'); ?></button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="tld_confirmSaveStyles();"><span class="glyphicon glyphicon-remove"></span><?php echo __('No', 'tld'); ?></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="tld_winSaveBeforeEditDialog" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></a>
                            <h4 class="modal-title"><?php echo __('Save styles before editing ?', 'tld'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <p><?php echo __('Do you want to save the modified styles before editing the css code ?', 'tld'); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" onclick="tld_confirmSaveStylesBeforeEdit();" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span><?php echo __('Yes', 'tld'); ?></button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="tld_editCSS();"><span class="glyphicon glyphicon-remove"></span><?php echo __('No', 'tld'); ?></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="tld_winResetStylesDialog" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></a>
                            <h4 class="modal-title"><?php echo __('Reset the styles', 'tld'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <p><?php echo __('Do you want to remove only the styles modified since the last save, or all styles that were created with this tool until now ?', 'tld'); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" onclick="tld_resetSessionStyles();" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span><?php echo __('Only this session', 'tld'); ?></button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="tld_resetAllStyles();"><span class="glyphicon glyphicon-remove"></span><?php echo __('All styles from the beginning', 'tld'); ?></button>
                            <button type="button" style="display: none;" class="btn btn-default" data-dismiss="modal" onclick=""><span class="glyphicon glyphicon-remove"></span><?php echo __('Cancel', 'lfb'); ?></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            <div id="tld_winEditCSSDialog" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></a>
                            <h4 class="modal-title"><?php echo __('Edit the generated CSS code', 'tld'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <textarea id="tld_editCssField"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" onclick="tld_saveEditedCSS();" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span><?php echo __('Save', 'tld'); ?></button>
                            <button type="button" style="display: none;"  class="btn btn-default" data-dismiss="modal" onclick=""><span class="glyphicon glyphicon-remove"></span><?php echo __('Cancel', 'lfb'); ?></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="tld_savePanel" class="tld_collapsed">
                <div id="tld_savePanelHeader">
                    <a href="javascript:" id="tld_savePanelToggleBtn" data-toggle="tooltip" data-placement="left" title="<?php echo __('Save the modifications', 'tld') ?>" onclick="tld_toggleSavePanel();" class="btn btn-circle btn-inverse">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                    </a>
                    <a href="javascript:" id="tld_savePanelExportBtn" data-toggle="tooltip" data-placement="left" title="<?php echo __('Edit the generated CSS code', 'tld') ?>" onclick="tld_openSaveBeforeEditDialog();" class="btn btn-circle btn-inverse">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <a href="javascript:" id="tld_savePanelResetBtn" onclick="tld_resetStyles();" data-toggle="tooltip" data-placement="left" title="<?php echo __('Reset styles', 'tld') ?>"  class="btn btn-circle btn-inverse">
                        <span class="glyphicon glyphicon-trash" style="margin-left:-2px;"></span>
                    </a>
                    <a href="javascript:" data-dismiss="modal" id="tld_leaveBtn" onclick="tld_leave();" data-toggle="tooltip" data-placement="left" title="<?php echo __('Return to the form management', 'tld') ?>"  class="btn btn-circle btn-inverse">
                        <span class="glyphicon glyphicon-remove"  style="margin-left:1px;"></span>
                    </a>

                </div>
                <div id="tld_savePanelBody">
                </div>
            </div>
            <div id="tld_tdgnPanel">
                <div id="tld_tdgnPanelHeader">
                    <span class="fa fa-magic"></span><span id="tld_tdgnPanelHeaderTitle"><?php echo __('Form designer', 'tld'); ?></span>
                    <a href="javascript:" id="tld_tdgnPanelToggleBtn" onclick="tld_tdgn_toggleTdgnPanel();" class="btn btn-circle btn-inverse"><span class="glyphicon glyphicon-chevron-left"></span></a>
                </div>
                <div id="tld_tdgnPanelBody" class="tld_scroll">
                    <a href="javascript:"  onclick="tld_prepareSelectElement();" id="tld_tdgn_selectElementBtn" class="btn btn-lg btn-primary">
                        <span class="glyphicon glyphicon-hand-up"></span>
                        <?php echo __('Select an element', 'tld'); ?>
                    </a>
                    <div class="tld_tdgn_section" data-title="<?php echo __('Selection', 'tld'); ?>">
                        <div class="tld_tdgn_sectionBody">
                            <div class="form-group">
                                <label for="tld_tdgn_selectedElement">
                                    <?php echo __('Selected element', 'tld'); ?> :
                                </label>
                                <div id="tld_tdgn_selectedElement"></div>
                            </div>
                            <div class="form-group">
                                <label for="tld_tdgn_applyModifsTo">
                                    <?php echo __('Apply modifications to', 'tld'); ?> :
                                </label>
                                <select id="tld_tdgn_applyModifsTo" name="applyModifsTo" class="tld_selectpicker form-control">
                                    <option value="onlyThis"><?php echo __('Only this element', 'tld'); ?></option>
                                    <option value="cssClasses"><?php echo __('All elements having CSS classes', 'tld'); ?></option>
                                </select>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="tld_tdgn_applyToClasses"><?php echo __('Enter the target CSS classes separated by spaces', 'tld'); ?></label>
                                <input type="text" id="tld_tdgn_applyToClasses"  class="form-control" />
                            </div>
                            <div class="form-group"  style="display: none;">
                                <label for="tld_tdgn_applyScope">
                                    <?php echo __('Limit modifications to', 'tld'); ?> :
                                </label>
                                <select id="tld_tdgn_applyScope" class="form-control tld_selectpicker">
                                    <option value="all"><?php echo __('All pages', 'tld'); ?></option>
                                    <option value="page"><?php echo __('This page only', 'tld'); ?></option>
                                    <option value="container"><?php echo __('The container having the css class', 'tld'); ?></option>
                                </select>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="tld_tdgn_scopeContainerClass"><?php echo __('Enter the target CSS class', 'tld'); ?></label>
                                <input type="text" id="tld_tdgn_scopeContainerClass"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="tld_tdgn_section" data-title="<?php echo __('Styles', 'tld'); ?>">
                        <div class="tld_tdgn_sectionBar">
                            <a href="javascript:" class="tld_active" onclick="tld_changeDeviceMode('all');" data-devicebtn="all"
                               data-toggle="tooltip" data-placement="top" title="<?php echo __('All devices', 'tld') ?>" >
                                <span class="fa fa-desktop"></span>
                                <span class="fa fa-tablet-alt"></span>
                                <span class="fa fa-mobile-alt"></span>
                            </a>
                            <a href="javascript:" onclick="tld_changeDeviceMode('desktop');"  data-devicebtn="desktop"
                               data-toggle="tooltip" data-placement="top" title="<?php echo __('Desktop only', 'tld') ?>">
                                <span class="fa fa-desktop"></span>
                            </a>
                            <a href="javascript:" onclick="tld_changeDeviceMode('desktopTablet');"  data-devicebtn="desktopTablet"
                               data-toggle="tooltip" data-placement="top" title="<?php echo __('Desktop & Tablets', 'tld') ?>">
                                <span class="fa fa-desktop"></span>
                                <span class="fa fa-tablet-alt"></span>
                            </a>
                            <a href="javascript:" onclick="tld_changeDeviceMode('tabletPhone');"  data-devicebtn="tabletPhone"
                               data-toggle="tooltip" data-placement="top" title="<?php echo __('Tablets & Phones', 'tld') ?>">
                                <span class="fa fa-tablet-alt"></span>
                                <span class="fa fa-mobile-alt"></span>
                            </a>
                            <a href="javascript:" onclick="tld_changeDeviceMode('tablet');"  data-devicebtn="tablet" 
                               data-toggle="tooltip" data-placement="top" title="<?php echo __('Tablets only', 'tld') ?>">
                                <span class="fa fa-tablet-alt"></span>
                            </a>
                            <a href="javascript:" onclick="tld_changeDeviceMode('phone');"  data-devicebtn="phone" 
                               data-toggle="tooltip" data-placement="top" title="<?php echo __('Phones only', 'tld') ?>">
                                <span class="fa fa-mobile-alt"></span>
                            </a>
                            <p style="text-align: center;margin-bottom: 0px; margin-top: 5px;">
                                <select id="tld_stateSelect" class="form-group tld_selectpicker">
                                    <option value="default"><?php echo __('Default state', 'tld'); ?></option>
                                    <option value="hover"><?php echo __('Mouse over state', 'tld'); ?></option>
                                    <option value="focus"><?php echo __('Focus state', 'tld'); ?></option>
                                </select>
                            </p>
                        </div>
                        <div class="tld_tdgn_sectionBody" style="padding-top: 4px;">
                            <div class="panel-group">
                                <div class="panel panel-default" data-style="background">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-background"><?php echo __('Background', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-background" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label><?php echo __('Background type', 'tld'); ?></label>
                                                <select id="tld_styleBackgroundType" class="form-control tld_selectpicker">
                                                    <option value=""><?php echo __('Nothing', 'tld'); ?></option>
                                                    <option value="color"><?php echo __('Color', 'tld'); ?></option>
                                                    <option value="image"><?php echo __('Image', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div id="tld_styleBackgroundType_colorToggle" data-dependson="backgroundType">   
                                                <div class="form-group">                                             
                                                    <label><?php echo __('Background color', 'tld'); ?></label>
                                                    <input type="text" id="tld_styleBackgroundType_color" class="form-control tld_colorpick" />
                                                </div>
                                                <div class="form-group">                                             
                                                    <label><?php echo __('Background opacity', 'tld'); ?></label>
                                                    <div id="tld_styleBackgroundType_colorAlpha" class="tld_slider" data-min="0" data-max="1" data-step="0.1"></div>
                                                </div>
                                            </div>
                                            <div id="tld_styleBackgroundType_imageToggle" data-dependson="backgroundType" style="display: none;">   
                                                <div class="form-group">                                             
                                                    <label><?php echo __('Image url', 'tld'); ?></label>
                                                    <input type="text" id="tld_styleBackgroundType_imageUrl" class="form-control" style="width: 137px; display: inline-block;"/>
                                                    <a href="javascript:" class="wos_imageBtn btn btn-default" ><span class="glyphicon glyphicon-cloud-download"></span></a>
                                                </div>  
                                                <div class="form-group">                                             
                                                    <label><?php echo __('Image size', 'tld'); ?></label>
                                                    <select id="tld_styleBackgroundType_imageSize" class="form-control tld_selectpicker" >
                                                        <option value="initial"><?php echo __('Initial', 'tld'); ?></option>
                                                        <option value="contain"><?php echo __('Contain', 'tld'); ?></option>
                                                        <option value="cover"><?php echo __('Cover', 'tld'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-style="background">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-borders"><?php echo __('Borders', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-borders" class="panel-collapse collapse">
                                        <div class="panel-body">                                            
                                            <div class="form-group">                                             
                                                <label><?php echo __('Border size', 'tld'); ?></label>
                                                <div id="tld_style_borderSize" class="tld_slider tld_sliderHasField" data-min="0" data-max="32" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Border style', 'tld'); ?></label>
                                                <select id="tld_style_borderStyle" class="form-control tld_selectpicker" >
                                                    <option value="none"><?php echo __('None', 'tld'); ?></option>
                                                    <option value="solid"><?php echo __('Solid', 'tld'); ?></option>
                                                    <option value="dashed"><?php echo __('Dashed', 'tld'); ?></option>
                                                    <option value="dotted"><?php echo __('Dotted', 'tld'); ?></option>
                                                    <option value="double"><?php echo __('Double', 'tld'); ?></option>
                                                    <option value="inset"><?php echo __('Inset', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Border color', 'tld'); ?></label>
                                                <input type="text" id="tld_style_borderColor" class="form-control tld_colorpick" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Top left radius', 'tld'); ?></label>
                                                <div id="tld_style_borderRadiusTopLeft" class="tld_slider tld_sliderHasField" data-min="0" data-max="64" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Top right radius', 'tld'); ?></label>
                                                <div id="tld_style_borderRadiusTopRight" class="tld_slider tld_sliderHasField" data-min="0" data-max="64" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Bottom left radius', 'tld'); ?></label>
                                                <div id="tld_style_borderRadiusBottomLeft" class="tld_slider tld_sliderHasField" data-min="0" data-max="64" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Bottom right radius', 'tld'); ?></label>
                                                <div id="tld_style_borderRadiusBottomRight" class="tld_slider tld_sliderHasField" data-min="0" data-max="64" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>                           



                                <div class="panel panel-default" data-style="size">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-margins"><?php echo __('Margins', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-margins" class="panel-collapse collapse">
                                        <div class="panel-body"> 

                                            <div class="form-group">                                             
                                                <label><?php echo __('Margin top', 'tld'); ?></label>
                                                <select id="tld_style_marginTypeTop" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Top', 'tld'); ?></label>
                                                <div id="tld_style_marginTop" class="tld_slider tld_sliderHasField" data-min="0" data-max="800"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Top', 'tld'); ?></label>
                                                <div id="tld_style_marginTopFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>     

                                            <div class="form-group">                                             
                                                <label><?php echo __('Margin bottom', 'tld'); ?></label>
                                                <select id="tld_style_marginTypeBottom" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>   
                                            <div class="form-group">                                             
                                                <label><?php echo __('Bottom', 'tld'); ?></label>
                                                <div id="tld_style_marginBottom" class="tld_slider tld_sliderHasField" data-min="0" data-max="800"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Bottom', 'tld'); ?></label>
                                                <div id="tld_style_marginBottomFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Margin left', 'tld'); ?></label>
                                                <select id="tld_style_marginTypeLeft" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Left', 'tld'); ?></label>
                                                <div id="tld_style_marginLeft" class="tld_slider tld_sliderHasField" data-min="0" data-max="800"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Left', 'tld'); ?></label>
                                                <div id="tld_style_marginLeftFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>


                                            <div class="form-group">                                             
                                                <label><?php echo __('Margin right', 'tld'); ?></label>
                                                <select id="tld_style_marginTypeRight" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Right', 'tld'); ?></label>
                                                <div id="tld_style_marginRight" class="tld_slider tld_sliderHasField" data-min="0" data-max="800"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Right', 'tld'); ?></label>
                                                <div id="tld_style_marginRightFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-style="size">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-paddings"><?php echo __('Paddings', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-paddings" class="panel-collapse collapse">
                                        <div class="panel-body"> 

                                            <div class="form-group">                                             
                                                <label><?php echo __('Padding top', 'tld'); ?></label>
                                                <select id="tld_style_paddingTypeTop" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Top', 'tld'); ?></label>
                                                <div id="tld_style_paddingTop" class="tld_slider tld_sliderHasField" data-min="0" data-max="400"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Top', 'tld'); ?></label>
                                                <div id="tld_style_paddingTopFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>     

                                            <div class="form-group">                                             
                                                <label><?php echo __('Padding bottom', 'tld'); ?></label>
                                                <select id="tld_style_paddingTypeBottom" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>   
                                            <div class="form-group">                                             
                                                <label><?php echo __('Bottom', 'tld'); ?></label>
                                                <div id="tld_style_paddingBottom" class="tld_slider tld_sliderHasField" data-min="0" data-max="400"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Bottom', 'tld'); ?></label>
                                                <div id="tld_style_paddingBottomFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Padding left', 'tld'); ?></label>
                                                <select id="tld_style_paddingTypeLeft" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Left', 'tld'); ?></label>
                                                <div id="tld_style_paddingLeft" class="tld_slider tld_sliderHasField" data-min="0" data-max="400"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Left', 'tld'); ?></label>
                                                <div id="tld_style_paddingLeftFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>


                                            <div class="form-group">                                             
                                                <label><?php echo __('Padding right', 'tld'); ?></label>
                                                <select id="tld_style_paddingTypeRight" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Right', 'tld'); ?></label>
                                                <div id="tld_style_paddingRight" class="tld_slider tld_sliderHasField" data-min="0" data-max="400"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Right', 'tld'); ?></label>
                                                <div id="tld_style_paddingRightFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-style="size">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-position"><?php echo __('Position', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-position" class="panel-collapse collapse">
                                        <div class="panel-body">  
                                            <div class="form-group">                                             
                                                <label><?php echo __('Display mode', 'tld'); ?></label>
                                                <select id="tld_style_display" class="form-control tld_selectpicker" >
                                                    <option value="inherit"><?php echo __('Default', 'tld'); ?></option>  
                                                    <option value="block"><?php echo __('Block', 'tld'); ?></option> 
                                                    <option value="inline"><?php echo __('Inline', 'tld'); ?></option>
                                                    <option value="inline-block"><?php echo __('Inline block', 'tld'); ?></option>      
                                                    <option value="none"><?php echo __('None', 'tld'); ?></option>                                                
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Float', 'tld'); ?></label>
                                                <select id="tld_style_float" class="form-control tld_selectpicker" >
                                                    <option value="none"><?php echo __('None', 'tld'); ?></option>  
                                                    <option value="left"><?php echo __('Left', 'tld'); ?></option>
                                                    <option value="right"><?php echo __('Right', 'tld'); ?></option>                                        
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Clear', 'tld'); ?></label>
                                                <select id="tld_style_clear" class="form-control tld_selectpicker" >
                                                    <option value="none"><?php echo __('None', 'tld'); ?></option>  
                                                    <option value="both"><?php echo __('Both', 'tld'); ?></option>
                                                    <option value="left"><?php echo __('Left', 'tld'); ?></option>
                                                    <option value="right"><?php echo __('Right', 'tld'); ?></option>                                        
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Position type', 'tld'); ?></label>
                                                <select id="tld_style_position" class="form-control tld_selectpicker" >
                                                    <option value="absolute"><?php echo __('Absolute', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="relative"><?php echo __('Relative', 'tld'); ?></option>
                                                    <option value="static"><?php echo __('Static', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Position left', 'tld'); ?></label>
                                                <select id="tld_style_positionLeft" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Left', 'tld'); ?></label>
                                                <div id="tld_style_left" class="tld_slider tld_sliderHasField" data-min="-1920" data-max="1920"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Left', 'tld'); ?></label>
                                                <div id="tld_style_leftFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Position top', 'tld'); ?></label>
                                                <select id="tld_style_positionTop" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Top', 'tld'); ?></label>
                                                <div id="tld_style_top" class="tld_slider tld_sliderHasField" data-min="-1080" data-max="1080"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Top', 'tld'); ?></label>
                                                <div id="tld_style_topFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Position bottom', 'tld'); ?></label>
                                                <select id="tld_style_positionBottom" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Bottom', 'tld'); ?></label>
                                                <div id="tld_style_bottom" class="tld_slider tld_sliderHasField" data-min="-1080" data-max="1080"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Bottom', 'tld'); ?></label>
                                                <div id="tld_style_bottomFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Position right', 'tld'); ?></label>
                                                <select id="tld_style_positionRight" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Right', 'tld'); ?></label>
                                                <div id="tld_style_right" class="tld_slider tld_sliderHasField" data-min="-1920" data-max="1920"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Right', 'tld'); ?></label>
                                                <div id="tld_style_rightFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100"></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-style="size">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-size"><?php echo __('Size', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-size" class="panel-collapse collapse">
                                        <div class="panel-body">     
                                            <div class="form-group">                                             
                                                <label><?php echo __('Width type', 'tld'); ?></label>
                                                <select id="tld_style_widthType" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Width', 'tld'); ?></label>
                                                <div id="tld_style_width" class="tld_slider tld_sliderHasField" data-min="0" data-max="1920" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Width', 'tld'); ?></label>
                                                <div id="tld_style_widthFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Height type', 'tld'); ?></label>
                                                <select id="tld_style_heightType" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Height', 'tld'); ?></label>
                                                <div id="tld_style_height" class="tld_slider tld_sliderHasField" data-min="0" data-max="1080" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Height', 'tld'); ?></label>
                                                <div id="tld_style_heightFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-style="size">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-visibility"><?php echo __('Scroll & Visibility', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-visibility" class="panel-collapse collapse">
                                        <div class="panel-body"> 

                                            <div class="form-group">                                             
                                                <label><?php echo __('Scroll X', 'tld'); ?></label>
                                                <select id="tld_style_scrollX" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="hidden"><?php echo __('Hidden', 'tld'); ?></option>
                                                    <option value="initial"><?php echo __('Initial', 'tld'); ?></option>
                                                    <option value="overlay"><?php echo __('Overlay', 'tld'); ?></option>
                                                    <option value="scroll"><?php echo __('Scroll', 'tld'); ?></option>
                                                    <option value="visible"><?php echo __('Visible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Scroll Y', 'tld'); ?></label>
                                                <select id="tld_style_scrollY" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="hidden"><?php echo __('Hidden', 'tld'); ?></option>
                                                    <option value="initial"><?php echo __('Initial', 'tld'); ?></option>
                                                    <option value="overlay"><?php echo __('Overlay', 'tld'); ?></option>
                                                    <option value="scroll"><?php echo __('Scroll', 'tld'); ?></option>
                                                    <option value="visible"><?php echo __('Visible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Visibility', 'tld'); ?></label>
                                                <select id="tld_style_visibility" class="form-control tld_selectpicker" >
                                                    <option value="hidden"><?php echo __('Hidden', 'tld'); ?></option>
                                                    <option value="initial"><?php echo __('Initial', 'tld'); ?></option>
                                                    <option value="visible"><?php echo __('Visible', 'tld'); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Opacity', 'tld'); ?></label>
                                                <div id="tld_style_opacity" class="tld_slider tld_sliderHasField" data-min="0" data-max="1" data-step="0.1" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-style="shadow">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-shadow"><?php echo __('Shadow', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-shadow" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <div class="form-group">                                             
                                                <label><?php echo __('Shadow type', 'tld'); ?></label>
                                                <select id="tld_style_shadowType" class="form-control tld_selectpicker" >
                                                    <option value="inside"><?php echo __('Inside', 'tld'); ?></option>
                                                    <option value="none"><?php echo __('None', 'tld'); ?></option>
                                                    <option value="outside"><?php echo __('Outside', 'tld'); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Size', 'tld'); ?></label>
                                                <div id="tld_style_shadowSize" class="tld_slider tld_sliderHasField" data-min="1" data-max="40" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Distance X', 'tld'); ?></label>
                                                <div id="tld_style_shadowX" class="tld_slider tld_sliderHasField" data-min="-40" data-max="40" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Distance Y', 'tld'); ?></label>
                                                <div id="tld_style_shadowY" class="tld_slider tld_sliderHasField" data-min="-40" data-max="40" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Color', 'tld'); ?></label>
                                                <input type="text" id="tld_style_shadowColor" class="form-control tld_colorpick" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Opacity', 'tld'); ?></label>
                                                <div id="tld_style_shadowAlpha" class="tld_slider tld_sliderHasField" data-min="0" data-max="1" data-step="0.1" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-style="background">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-text"><?php echo __('Text', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-text" class="panel-collapse collapse">
                                        <div class="panel-body">     
                                            <div class="form-group">                                             
                                                <label><?php echo __('Text color', 'tld'); ?></label>
                                                <input type="text" id="tld_style_fontColor" class="form-control tld_colorpick" />
                                            </div>
                                            <div class="form-group">                                                            
                                                <label></label>
                                                <select id="tld_style_fontFamily" class="form-control tld_selectpicker"><option data-default="true" value="Georgia, serif" data-fontname="georgia" >Georgia</option><option value="Helvetica Neue" data-default="true" data-fontname="helveticaneue">Helvetica Neue</option><option data-default="true" value="'Times New Roman', Times, serif" data-fontname="timesnewroman">Times New Roman</option><option value="Arial, Helvetica, sans-serif" data-default="true" data-fontname="arial">Arial</option><option value="'Arial Black', Gadget, sans-serif" data-default="true" data-fontname="arialblack">Arial Black</option><option data-default="true" value="Impact, Charcoal, sans-serif" data-fontname="impact">Impact</option><option data-default="true" value="Tahoma, Geneva, sans-serif" data-fontname="tahoma">Tahoma</option><option value="Verdana, Geneva, sans-serif" data-fontname="verdana">Verdana</option></select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Font size', 'tld'); ?></label>
                                                <div id="tld_style_fontSize" class="tld_slider tld_sliderHasField" data-min="1" data-max="128" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Alignment', 'tld'); ?></label>
                                                <select id="tld_style_textAlign" class="form-control tld_selectpicker" >
                                                    <option value="auto"><?php echo __('Auto', 'tld'); ?></option>
                                                    <option value="center"><?php echo __('Center', 'tld'); ?></option>
                                                    <option value="left"><?php echo __('Left', 'tld'); ?></option>
                                                    <option value="right"><?php echo __('Right', 'tld'); ?></option>
                                                    <option value="justify"><?php echo __('Justify', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Line height type', 'tld'); ?></label>
                                                <select id="tld_style_lineHeightType" class="form-control tld_selectpicker" >
                                                    <option value="fixed"><?php echo __('Fixed', 'tld'); ?></option>
                                                    <option value="flexible"><?php echo __('Flexible', 'tld'); ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Line height', 'tld'); ?></label>
                                                <div id="tld_style_lineHeight" class="tld_slider tld_sliderHasField" data-min="0" data-max="128" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Line height', 'tld'); ?></label>
                                                <div id="tld_style_lineHeightFlex" class="tld_slider tld_sliderHasField" data-min="0" data-max="100" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>

                                            <div class="form-group">                                             
                                                <label><?php echo __('Text style', 'tld'); ?></label>
                                                <select id="tld_style_fontStyle" class="form-control tld_selectpicker" multiple>
                                                    <option value="bold"><?php echo __('Bold', 'tld'); ?></option>
                                                    <option value="italic"><?php echo __('Italic', 'tld'); ?></option>
                                                    <option value="underline"><?php echo __('Underline', 'tld'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>              


                                <div class="panel panel-default" data-style="shadow">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tdgn-style-textShadow"><?php echo __('Text shadow', 'tld'); ?></a>
                                        </h4>
                                    </div>
                                    <div id="tdgn-style-textShadow" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <div class="form-group">                                             
                                                <label><?php echo __('Color', 'tld'); ?></label>
                                                <input type="text" id="tld_style_textShadowColor" class="form-control tld_colorpick" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Distance X', 'tld'); ?></label>
                                                <div id="tld_style_textShadowX" class="tld_slider tld_sliderHasField" data-min="0" data-max="40" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Distance Y', 'tld'); ?></label>
                                                <div id="tld_style_textShadowY" class="tld_slider tld_sliderHasField" data-min="0" data-max="40" ></div>
                                                <input type="number" class="tld_sliderField form-control" />
                                            </div>
                                            <div class="form-group">                                             
                                                <label><?php echo __('Opacity', 'tld'); ?></label>
                                                <div id="tld_style_textShadowAlpha" class="tld_slider tld_sliderHasField" data-min="0" data-max="1" data-step="0.1" ></div>
                                                <input type="number" class="tld_sliderField form-control" step="0.1" />
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                   <!-- <a href="javascript:" onclick="tld_saveCurrentElement();" data-toggle="tooltip" data-placement="right" title="<?php echo __('Apply these styles to the current element', 'tld'); ?>" id="tld_confirmStylesBtn" class="btn btn-lg btn-primary">
                        <span class="glyphicon glyphicon-ok"></span>
                    <?php echo __('Apply', 'tld'); ?>
                    </a>-->
                </div>
            </div>
            <iframe src="about:blank" id="tld_tdgnFrame"></iframe>

            <div id="tld_tdgnInspector" class="tld_collapsed">
                <div id="tld_tdgnInspectorHeader">
                    <span class="glyphicon glyphicon-eye-open"></span><span id="tld_tdgnInspectorHeaderTitle"><?php echo __('Inspector', 'tld'); ?></span>
                    <a href="javascript:" id="tld_tdgnInspectorToggleBtn" onclick="tld_tdgn_toggleInspector();" class="btn btn-circle"><span class="glyphicon glyphicon-chevron-up"></span></a>
                </div>
                <div id="tld_tdgnInspectorBody" class="tld_scroll">

                </div>
            </div>
        </div>
        <?php
        echo '</div>';
    }

    private function tdgn_generateCSS($styles, $formID, $gfonts, $existingContent) {
        $css = $existingContent;
        $endMediaQuery = '';

        foreach ($gfonts as $font) {
            if ($font != '') {
                $font = str_replace('"', '', $font);
                $css = '@import url("https://fonts.googleapis.com/css?family=' . $font . '");' . "\n" . $css;
            }
        }

        foreach ($styles as $deviceData) {
            $endMediaQuery = '';
            if ($deviceData->device == 'desktop') {
                if (count($deviceData->elements) > 0) {
                    $css .= '@media (min-width:780px) {' . "\n";
                    $endMediaQuery = '}';
                }
            } else if ($deviceData->device == 'desktopTablet') {
                if (count($deviceData->elements) > 0) {
                    $css .= '@media (min-width:480px){' . "\n";
                    $endMediaQuery = '}';
                }
            } else if ($deviceData->device == 'tablet') {
                if (count($deviceData->elements) > 0) {
                    $css .= '@media (min-width:480px) and (max-width:780px) {' . "\n";
                    $endMediaQuery = '}';
                }
            } else if ($deviceData->device == 'tabletPhone') {
                if (count($deviceData->elements) > 0) {
                    $css .= '@media (max-width:780px) {' . "\n";
                    $endMediaQuery = '}';
                }
            } else if ($deviceData->device == 'phone') {
                if (count($deviceData->elements) > 0) {
                    $css .= '@media (max-width:480px) {' . "\n";
                    $endMediaQuery = '}';
                }
            }
            foreach ($deviceData->elements as $elementData) {
                $css .= 'body #estimation_popup.wpe_bootstraped[data-form="' . $formID . '"] ' . $elementData->domSelector . ' {' . "\n";
                $style = str_replace(";", ";\n   ", $elementData->style);
                if (substr($style, -3) == "  ") {
                    $style = substr($style, 0, -3);
                }
                $css .= "   " . $style;
                $css .= '}' . "\n";

                if (isset($elementData->hoverStyle) && $elementData->hoverStyle != "") {
                    $css .= 'body #estimation_popup.wpe_bootstraped[data-form="' . $formID . '"] ' . $elementData->domSelector . ':hover {' . "\n";
                    $style = str_replace(";", ";\n   ", $elementData->hoverStyle);
                    if (substr($style, -3) == "  ") {
                        $style = substr($style, 0, -3);
                    }
                    $css .= "   " . $style . "\n";
                    $css .= '}' . "\n";
                }

                if (isset($elementData->focusStyle) && $elementData->focusStyle != "") {
                    $css .= 'body #estimation_popup.wpe_bootstraped[data-form="' . $formID . '"] ' . $elementData->domSelector . ':focus {' . "\n";
                    $style = str_replace(";", ";\n   ", $elementData->focusStyle);
                    if (substr($style, -3) == "  ") {
                        $style = substr($style, 0, -3);
                    }
                    $css .= "   " . $style . "\n";
                    $css .= '}' . "\n";
                }
            }
            $css = str_replace("   }", "}", $css);

            if ($endMediaQuery != '') {
                $css .= $endMediaQuery . "\n";
            }
        }

        return $css;
    }

    public function saveForm() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $table_name = $wpdb->prefix . "wpefc_forms";
            $formID = sanitize_text_field($_POST['formID']);
            $sqlDatas = array();
            $globalData = "";
            foreach ($_POST as $key => $value) {
                if ($key == 'globalData') {
                    $globalData = json_decode(stripslashes($value), true);
                } else {
                    if ($key != 'action' && $key != 'encryptDB' && $key != 'id' && $key != 'pll_ajax_backend' && $key != "undefined" && $key != "formID" && $key != "files" && $key != 'ip-geo-block-auth-nonce' && $key != "client_action" && $key != "purchaseCode") {
                        if ($key == 'email_adminContent') {
                            $value = str_replace("../wp-content/", get_home_url() . '/wp-content/', $value);
                            $value = str_replace("../", get_home_url() . '/', $value);
                        }
                        if ($key == 'email_userContent') {
                            $value = str_replace("../wp-content/", get_home_url() . '/wp-content/', $value);
                            $value = str_replace("../", get_home_url() . '/', $value);
                        }
                        if ($key == 'percentToPay' && ($value == 0 /* || $value > 100 */)) {
                            $value = 100;
                        }

                        $sqlDatas[$key] = (stripslashes($value));
                    }
                }
            }
            if ($formID > 0) {
                $wpdb->update($table_name, $sqlDatas, array('id' => $formID));
                if ($wpdb->last_error !== '') {
                    echo $wpdb->last_error;
                }
                $response = $formID;
            } else {
                if (isset($_POST['title'])) {
                    $wpdb->insert($table_name, $sqlDatas);
                    $lastid = $wpdb->insert_id;
                    $response = $lastid;
                }
            }

            echo $response;
        }
        die();
    }

    public function removeForm() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $table_name = $wpdb->prefix . "wpefc_forms";
            $wpdb->delete($table_name, array('id' => $formID));
            $table_name = $wpdb->prefix . "wpefc_steps";
            $wpdb->delete($table_name, array('formID' => $formID));
            $table_name = $wpdb->prefix . "wpefc_fields";
            $wpdb->delete($table_name, array('formID' => $formID));
            $table_name = $wpdb->prefix . "wpefc_items";
            $wpdb->delete($table_name, array('formID' => $formID));
            $table_name = $wpdb->prefix . "wpefc_coupons";
            $wpdb->delete($table_name, array('formID' => $formID));
            $table_name = $wpdb->prefix . "wpefc_links";
            $wpdb->delete($table_name, array('formID' => $formID));
            $table_name = $wpdb->prefix . "wpefc_variables";
            $wpdb->delete($table_name, array('formID' => $formID));

            $formCustomers = array();
            $table_name = $wpdb->prefix . "wpefc_logs";
            $logs = $wpdb->get_results($wpdb->prepare("SELECT customerID,formID FROM $table_name WHERE formID=%s GROUP BY customerID", $formID));
            foreach ($logs as $log) {
                $formCustomers[] = $log->customerID;
            }
            $table_name = $wpdb->prefix . "wpefc_logs";
            $wpdb->delete($table_name, array('formID' => $formID));

            foreach ($formCustomers as $customerID) {
                $table_name = $wpdb->prefix . "wpefc_logs";
                $logsC = $wpdb->get_results($wpdb->prepare("SELECT id,customerID FROM $table_name WHERE customerID=%s LIMIT 1", $customerID));
                if (count($logsC) == 0) {
                    $table_nameC = $wpdb->prefix . "wpefc_customers";
                    $wpdb->delete($table_nameC, array('id' => $customerID));
                }
            }
        }
        die();
    }

    public function checkFields() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = $wpdb->get_results("SELECT * FROM $table_name");
            foreach ($forms as $form) {
                $table_nameI = $wpdb->prefix . "wpefc_items";
                $items = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $table_nameI . ' WHERE formID=%s AND type="textfield"', $form->id));
                $chkF = false;
                foreach ($items as $item) {
                    if ($item->fieldType == "email") {
                        $chkF = true;
                    }
                }
                if (!$chkF && !$form->save_to_cart) {
                    $wpdb->update($wpdb->prefix . "wpefc_forms", array('sendEmailLastStep' => 0), array('id' => $form->id));
                    $wpdb->insert($table_nameI, array('formID' => $form->id, 'stepID' => 0, 'title' => __("Enter your email", 'lfb'), 'isRequired' => 1, 'type' => 'textfield', 'useRow' => 1, 'fieldType' => 'email'));
                }
            }
        }
    }

    public function checkLicense() {
        if (current_user_can('manage_options')) {
            $this->checkLicenseCall();
        }
        die();
    }

    private function checkLicenseCall() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            try {

                $url = 'http://www.loopus-plugins.com/updates/update.php?checkCode=7818230&code=' . sanitize_text_field($_POST['code']);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $rep = curl_exec($ch);
                if ($rep != '0410') {
                    $table_name = $wpdb->prefix . "wpefc_settings";
                    $wpdb->update($table_name, array('purchaseCode' => sanitize_text_field($_POST['code'])), array('id' => 1));
                } else {
                    $table_name = $wpdb->prefix . "wpefc_settings";
                    $wpdb->update($table_name, array('purchaseCode' => ''), array('id' => 1));
                    echo '1';
                }
            } catch (Throwable $t) {
                $table_name = $wpdb->prefix . "wpefc_settings";
                $wpdb->update($table_name, array('purchaseCode' => sanitize_text_field($_POST['code'])), array('id' => 1));
            } catch (Exception $e) {
                $table_name = $wpdb->prefix . "wpefc_settings";
                $wpdb->update($table_name, array('purchaseCode' => sanitize_text_field($_POST['code'])), array('id' => 1));
            }
        }
    }

    public function loadSettings() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_settings";
            $settings = $wpdb->get_results("SELECT * FROM $table_name WHERE id=1 LIMIT 1");
            $rep = array();
            if (count($settings) > 0) {
                $rep = $settings[0];
                $rep->smtp_password = $this->parent->stringDecode($rep->smtp_password, true);
            }
            echo json_encode($rep);
        }
        die();
    }

    public function saveStepPosition() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $stepID = sanitize_text_field($_POST['stepID']);
            $posX = sanitize_text_field($_POST['posX']);
            $posY = sanitize_text_field($_POST['posY']);
            $table_name = $wpdb->prefix . "wpefc_steps";
            $step = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id=%s LIMIT 1', $stepID));
            $step = $step[0];
            $content = json_decode($step->content);

            if (!isset($content) || !is_object($content)) {
                $content = new stdClass();
                $content->start = 0;
                $content->actions = array();
                $content->id = $stepID;
            }
            $content->previewPosX = $posX;
            $content->previewPosY = $posY;
            if (stripslashes($this->jsonRemoveUnicodeSequences($content)) != "") {
                $wpdb->update($table_name, array('content' => stripslashes($this->jsonRemoveUnicodeSequences($content))), array('id' => $stepID));
            }
        }
        die();
    }

    public function newLink() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $originID = sanitize_text_field($_POST['originStepID']);
            $destinationID = sanitize_text_field($_POST['destinationStepID']);
            $table_name = $wpdb->prefix . "wpefc_links";
            $wpdb->insert($table_name, array('originID' => $originID, 'destinationID' => $destinationID, 'conditions' => '[]', 'formID' => $formID));
            echo $wpdb->insert_id;
        }
        die();
    }

    public function getFormSteps() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $rep = array();
            $table_nameS = $wpdb->prefix . "wpefc_steps";
            $steps = $wpdb->get_results($wpdb->prepare("SELECT id,title,start FROM $table_nameS WHERE formID=%s", $formID));
            foreach ($steps as $step) {
                $stepRep = new stdClass();
                $stepRep->id = $step->id;
                $stepRep->title = $step->title;
                $stepRep->start = $step->start;
                $rep[] = $stepRep;
            }
            echo($this->jsonRemoveUnicodeSequences($rep));
            die();
        }
    }

    public function loadForm() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $rep = new stdClass();
            $rep->steps = array();

            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s", $formID));
            $rep->form = $forms[0];
            if (!$rep->form->colorBg || $rep->form->colorBg == "") {
                $rep->form->colorBg = "#ecf0f1";
            }
            if (!$rep->form->imgIconStyle || $rep->form->imgIconStyle == "") {
                $rep->form->imgIconStyle = "circle";
            }

            $table_name = $wpdb->prefix . "wpefc_settings";
            $params = $wpdb->get_results("SELECT * FROM $table_name");
            $rep->params = $params[0];

            $table_nameS = $wpdb->prefix . "wpefc_steps";
            $steps = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameS WHERE formID=%s", $formID));
            foreach ($steps as $step) {
                $table_name = $wpdb->prefix . "wpefc_items";
                $items = $wpdb->get_results("SELECT * FROM $table_name WHERE stepID=" . $step->id . " ORDER BY ordersort ASC, id ASC");
                $step->items = $items;

                if (substr($step->content, 0, 3) == '\"{' || strpos($step->content, '\\') !== false) {
                    $step->content = str_replace('\"{', "{", $step->content);
                    $step->content = str_replace('}\"', "}", $step->content);
                    $step->content = str_replace('\"', '"', $step->content);
                    $step->content = str_replace('\\\\', '\\', $step->content);
                    $step->content = str_replace('\\\\', '\\', $step->content);
                    $wpdb->update($table_nameS, array('content' => $step->content), array('id' => $step->id));
                }
                $rep->steps[] = $step;
            }
            
            $rep->links = array();
            $table_name = $wpdb->prefix . "wpefc_links";
            $links = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s", $formID));
            foreach ($links as $link) {
                $chkExist = false;
                foreach ($rep->links as $exLink) {
                    if($exLink->originID == $link->originID && $exLink->destinationID == $link->destinationID){
                        $chkExist = true;
                    }
                }
                if(!$chkExist){
                    $rep->links[] = $link;
                }
            }
            //$rep->links = $links;

            $table_name = $wpdb->prefix . "wpefc_layeredImages";
            $wpdb->delete($table_name, array('id' => 0, 'formID' => $formID));
            $layers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s ORDER BY ordersort ASC", $formID));
            $rep->layers = $layers;

            $table_name = $wpdb->prefix . "wpefc_items";
            $fields = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND stepID=0  ORDER BY ordersort ASC", $formID));
            $rep->fields = $fields;

            $table_name = $wpdb->prefix . "wpefc_coupons";
            $coupons = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s", $formID));
            $rep->coupons = $coupons;

            $table_name = $wpdb->prefix . "wpefc_redirConditions";
            $redirections = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s", $formID));
            $rep->redirections = $redirections;

            $table_name = $wpdb->prefix . "wpefc_variables";
            $variables = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s ORDER BY title ASC", $formID));
            $rep->variables = $variables;



            echo($this->jsonRemoveUnicodeSequences($rep));
        }
        die();
    }

    public function loadFields() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $table_name = $wpdb->prefix . "wpefc_items";
            $fields = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND stepID=0 ORDER BY ordersort ASC, id ASC", $formID));

            echo($this->jsonRemoveUnicodeSequences($fields));
        }
        die();
    }

    public function removeField() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_fields";
            $fieldID = sanitize_text_field($_POST['fieldID']);
            $wpdb->delete($table_name, array('id' => $fieldID));
        }
        die();
    }

    public function saveField() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_fields";
            $fieldID = sanitize_text_field($_POST['id']);
            $formID = sanitize_text_field($_POST['formID']);
            $sqlDatas = array();
            foreach ($_POST as $key => $value) {
                if ($key != 'action' && $key != 'id' && $key != 'pll_ajax_backend' && $key != "undefined" && $key != "formID" && $key != "files" && $key != 'ip-geo-block-auth-nonce' && $key != "client_action" && $key != "purchaseCode") {
                    $sqlDatas[$key] = sanitize_text_field(stripslashes($value));
                }
            }
            if ($fieldID > 0) {
                $wpdb->update($table_name, $sqlDatas, array('id' => $fieldID));
                $response = $_POST['id'];
            } else {
                $sqlDatas['formID'] = $formID;
                $wpdb->insert($table_name, $sqlDatas);
                $lastid = $wpdb->insert_id;
                $response = $lastid;
            }
            echo $response;
        }
        die();
    }

    public function saveRedirection() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_redirs = $wpdb->prefix . "wpefc_redirConditions";
            $id = sanitize_text_field($_POST['id']);
            $formID = sanitize_text_field($_POST['formID']);
            $conditions = sanitize_text_field($_POST['conditions']);
            $url = sanitize_text_field($_POST['url']);
            $conditionsOperator = sanitize_text_field($_POST['operator']);
            $table_name = $wpdb->prefix . "wpefc_redirections";

            $data = array('formID' => $formID, 'conditions' => $conditions, 'conditionsOperator' => $conditionsOperator, 'url' => $url);
            if ($id > 0) {
                $wpdb->update($table_redirs, $data, array('id' => $id));
            } else {
                $wpdb->insert($table_redirs, $data);
                echo $wpdb->insert_id;
            }
        }
        die();
    }

    public function removeRedirection() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_redirs = $wpdb->prefix . "wpefc_redirConditions";
            $id = sanitize_text_field($_POST['id']);
            $wpdb->delete($table_redirs, array('id' => $id));
        }
        die();
    }

    public function removeAllSteps() {
        global $wpdb;

        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);

            $table_name = $wpdb->prefix . "wpefc_steps";
            $steps = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s", $formID));
            foreach ($steps as $step) {
                $table_nameL = $wpdb->prefix . "wpefc_links";
                $wpdb->delete($table_nameL, array('originID' => $step->id));
                $wpdb->delete($table_nameL, array('destinationID' => $step->id));
                $table_nameI = $wpdb->prefix . "wpefc_items";
                $wpdb->delete($table_nameI, array('stepID' => $step->id));
            }

            $wpdb->delete($table_name, array('formID' => $formID));
        }
        die();
    }

    public function removeItem() {
        global $wpdb;

        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $stepID = sanitize_text_field($_POST['stepID']);
            $itemID = sanitize_text_field($_POST['itemID']);

            $table_name = $wpdb->prefix . "wpefc_items";
            $items = $wpdb->get_results($wpdb->prepare("SELECT id,type,columns FROM $table_name WHERE id=%s LIMIT 1", $itemID));
            if (count($items) > 0) {
                $item = $items[0];
                if ($item->type == 'row') {
                    $item->columns = json_decode($item->columns, true);
                    foreach ($item->columns as $column) {
                        $wpdb->delete($table_name, array('columnID' => $column['id'],'stepID'=>$stepID));
                    }
                }
            }


            $wpdb->delete($table_name, array('id' => $itemID));



            $table_name = $wpdb->prefix . "wpefc_layeredImages";
            $wpdb->query("DELETE FROM $table_name WHERE itemID=" . $itemID);

            $table_links = $wpdb->prefix . "wpefc_links";
            $links = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_links WHERE formID=%s", $formID));
            foreach ($links as $link) {
                $conditions = json_decode($link->conditions);
                $newConditions = array();

                foreach ($conditions as $condition) {
                    $oldStep = substr($condition->interaction, 0, strpos($condition->interaction, '_'));
                    $oldItem = substr($condition->interaction, strpos($condition->interaction, '_') + 1);
                    if ($oldStep == $stepID && $oldItem == $itemID) {
                        
                    } else {
                        $newConditions[] = $condition;
                    }
                }
                $wpdb->update($table_links, array('conditions' => $this->jsonRemoveUnicodeSequences($newConditions)), array('id' => $link->id));
            }
        }
        die();
    }

    public function removeStep() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_steps";

            $wpdb->delete($table_name, array('id' => sanitize_text_field($_POST['stepID'])));
            $table_name = $wpdb->prefix . "wpefc_links";
            $wpdb->delete($table_name, array('originID' => sanitize_text_field($_POST['stepID'])));
            $wpdb->delete($table_name, array('destinationID' => sanitize_text_field($_POST['stepID'])));

            $table_name = $wpdb->prefix . "wpefc_items";
            $items = $wpdb->get_results("SELECT * FROM $table_name WHERE stepID=" . sanitize_text_field($_POST['stepID']));
            foreach ($items as $item) {
                $table_nameL = $wpdb->prefix . "wpefc_layeredImages";
                $wpdb->query("DELETE FROM $table_nameL WHERE itemID=" . $item->id);
            }
            $wpdb->query("DELETE FROM $table_name WHERE stepID=" . sanitize_text_field($_POST['stepID']));
        }
        die();
    }

    public function addStep() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_steps";
            $formID = sanitize_text_field($_POST['formID']);

            $data = new stdClass();
            $data->start = sanitize_text_field($_POST['start']);

            $stepsStart = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND start=1", $formID));
            if (count($stepsStart) == 0) {
                $data->start = 1;
            }

            if ($data->start == 1) {
                $steps = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND start=1", $formID));
                foreach ($steps as $step) {
                    $dataContent = json_decode($step->content);
                    $dataContent->start = 0;
                    $wpdb->update($table_name, array('content' => $this->jsonRemoveUnicodeSequences($dataContent), 'start' => 0), array('id' => $data->id));
                }
            }
            $data->previewPosX = sanitize_text_field($_POST['previewPosX']);
            $data->previewPosY = sanitize_text_field($_POST['previewPosY']);
            $data->actions = array();



            $wpdb->insert($table_name, array('content' => $this->jsonRemoveUnicodeSequences($data), 'title' => __('My Step', 'lfb'), 'formID' => $formID, 'start' => $data->start));
            $data->id = $wpdb->insert_id;
            $wpdb->update($table_name, array('content' => $this->jsonRemoveUnicodeSequences($data), 'formID' => $formID), array('id' => $data->id));
            echo json_encode((array) $data);
        }
        die();
    }

    public function loadLayers() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $table_name = $wpdb->prefix . "wpefc_layeredImages";
            $wpdb->delete($table_name, array('id' => 0, 'formID' => $formID));
            $layers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s ORDER BY ordersort ASC", $formID));
            echo json_encode((array) $layers);
        }
        die();
    }

    public function loadStep() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $rep = new stdClass();
            $table_name = $wpdb->prefix . "wpefc_steps";
            $step = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", sanitize_text_field($_POST['stepID'])));
            $rep->step = $step[0];
            $table_name = $wpdb->prefix . "wpefc_items";
            $items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE stepID=%s ORDER BY ordersort ASC", sanitize_text_field($_POST['stepID'])));
            $rep->items = $items;
            echo $this->jsonRemoveUnicodeSequences((array) $rep);
        }
        die();
    }

    public function saveItem() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $stepID = sanitize_text_field($_POST['stepID']);
            $itemID = sanitize_text_field($_POST['id']);
            $defaultStepID = sanitize_text_field($_POST['defaultStepID']);

            if ($stepID != $defaultStepID) {
                $table_name = $wpdb->prefix . "wpefc_links";
                $links = $wpdb->get_results("SELECT * FROM $table_name WHERE formID=" . $formID);
                foreach ($links as $link) {
                    $conditions = json_decode($link->conditions);
                    $chkChange = false;
                    foreach ($conditions as $condition) {
                        if ($condition->interaction == $defaultStepID . '_' . $itemID) {
                            $chkChange = true;
                            $condition->interaction = $stepID . '_' . $itemID;
                        }
                    }
                    if ($chkChange) {
                        $wpdb->update($table_name, array('conditions' => $this->jsonRemoveUnicodeSequences($conditions)), array('id' => $link->id));
                    }
                }
                $table_name = $wpdb->prefix . "wpefc_items";
                $items = $wpdb->get_results('SELECT showConditions,formID,id FROM ' . $table_name . ' WHERE formID=' . $formID . ' AND showConditions!=""');
                foreach ($items as $item) {
                    $conditions = json_decode($item->showConditions);
                    $chkChange = false;
                    foreach ($conditions as $condition) {
                        if ($condition->interaction == $defaultStepID . '_' . $itemID) {
                            $chkChange = true;
                            $condition->interaction = $stepID . '_' . $itemID;
                        }
                    }
                    if ($chkChange) {
                        $wpdb->update($table_name, array('showConditions' => $this->jsonRemoveUnicodeSequences($conditions)), array('id' => $item->id));
                    }
                }
                $table_name = $wpdb->prefix . "wpefc_layeredImages";
                $layers = $wpdb->get_results('SELECT showConditions,formID,id FROM ' . $table_name . ' WHERE formID=' . $formID . ' AND showConditions!=""');
                foreach ($layers as $layer) {
                    $conditions = json_decode($layer->showConditions);
                    $chkChange = false;
                    foreach ($conditions as $condition) {
                        if ($condition->interaction == $defaultStepID . '_' . $itemID) {
                            $chkChange = true;
                            $condition->interaction = $stepID . '_' . $itemID;
                        }
                    }
                    if ($chkChange) {
                        $wpdb->update($table_name, array('showConditions' => $this->jsonRemoveUnicodeSequences($conditions)), array('id' => $layer->id));
                    }
                }
                
                $table_name = $wpdb->prefix . "wpefc_steps";
                $steps = $wpdb->get_results('SELECT showConditions,formID,id FROM ' . $table_name . ' WHERE formID=' . $formID . ' AND showConditions!=""');
                foreach ($steps as $step) {
                    $conditions = json_decode($step->showConditions);
                    $chkChange = false;
                    foreach ($conditions as $condition) {
                        if ($condition->interaction == $defaultStepID . '_' . $itemID) {
                            $chkChange = true;
                            $condition->interaction = $stepID . '_' . $itemID;
                        }
                    }
                    if ($chkChange) {
                        $wpdb->update($table_name, array('showConditions' => $this->jsonRemoveUnicodeSequences($conditions)), array('id' => $step->id));
                    }
                }
            }

            $table_name = $wpdb->prefix . "wpefc_items";
            $sqlDatas = array();
            foreach ($_POST as $key => $value) {
                if ($key != 'action' && $key != 'id' && $key != 'pll_ajax_backend' && $key != "undefined" && $key != "formID" && $key != "files" && $key != 'ip-geo-block-auth-nonce' && $key != "client_action" && $key != "purchaseCode" && $key != "layers" && $key != "defaultStepID") {
                    $sqlDatas[$key] = stripslashes($value);
                }
            }
            $sqlDatas['title'] = str_replace('""', "''", $sqlDatas['title']);
            if ($itemID > 0) {
                $wpdb->update($table_name, $sqlDatas, array('id' => $itemID));
                $response = $_POST['id'];
            } else {
                $sqlDatas['formID'] = $formID;
                $sqlDatas['stepID'] = $stepID;
                $wpdb->insert($table_name, $sqlDatas);
                $itemID = $wpdb->insert_id;
            }
            echo $itemID;

            $table_name = $wpdb->prefix . "wpefc_layeredImages";
            $wpdb->query("DELETE FROM $table_name WHERE formID=" . $formID . " AND itemID=" . $itemID);

            if (isset($_POST['layers'])) {
                $i = 0;
                $table_name = $wpdb->prefix . "wpefc_layeredImages";
                foreach ($_POST['layers'] as $key => $value) {
                    $wpdb->insert($table_name, array('ordersort' => $i, 'formID' => $formID, 'itemID' => $itemID, 'title' => stripslashes($value['title']), 'image' => $value['image'],
                        'showConditions' => stripslashes($value['showConditions']), 'showConditionsOperator' => stripslashes($value['showConditionsOperator'])));
                    $i++;
                }
            }
        }
        die();
    }

    public function changeStepMainSettings() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $stepID = intval($_POST['stepID']);
            $title = sanitize_text_field($_POST['title']);
            $maxWidth = intval($_POST['maxWidth']);
            if ($stepID > 0) {
                $table_name = $wpdb->prefix . "wpefc_steps";
                $wpdb->update($table_name, array('title' => stripslashes($title), 'maxWidth' => $maxWidth), array('id' => $stepID));
            }
            die();
        }
    }

    public function saveStep() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $stepID = sanitize_text_field($_POST['id']);
            $table_name = $wpdb->prefix . "wpefc_steps";

            $sqlDatas = array();
            foreach ($_POST as $key => $value) {
                if ($key != 'action' && $key != 'id' && $key != 'pll_ajax_backend' && $key != "undefined" && $key != "formID" && $key != "files" && $key != 'ip-geo-block-auth-nonce' && $key != "client_action" && $key != "purchaseCode") {
                    $sqlDatas[$key] = (stripslashes($value));
                }
            }

            if ($stepID > 0) {
                $wpdb->update($table_name, $sqlDatas, array('id' => $stepID));
                $response = sanitize_text_field($_POST['id']);
            } else {
                $sqlDatas['formID'] = $formID;
                $wpdb->insert($table_name, $sqlDatas);
                $stepID = $wpdb->insert_id;
            }
            echo $stepID;
        }
        die();
    }

    public function exportCalendarEvents() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $settings = $this->getSettings();

            $calendarID = intval($_POST['calendarID']);

            if (!is_dir(plugin_dir_path(__FILE__) . '../tmp')) {
                mkdir(plugin_dir_path(__FILE__) . '../tmp');
                chmod(plugin_dir_path(__FILE__) . '../tmp', $this->parent->chmodWrite);
            }
            $filename = 'exported_calendar.csv';
            $target_path = plugin_dir_path(__FILE__) . '../tmp/' . $filename;
            $file = fopen($target_path, "w");

            $content = 'Subject,Start Date,Start Time,End Date,End Time,All Day Event,Description';

            fwrite($file, $content . "\n");

            $table_name = $wpdb->prefix . "wpefc_calendarEvents";
            $events = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE calendarID=%s ORDER BY startDate ASC", $calendarID));
            foreach ($events as $event) {

                $startDate = new DateTime($event->startDate);
                $startDate_date = $startDate->format('m/d/Y');
                $startDate_time = $startDate->format('h:i A');

                $endDate = new DateTime($event->endDate);
                $endDate_date = $endDate->format('m/d/Y');
                $endDate_time = $endDate->format('h:i A');

                $content = '"' . $event->title . '",';
                $content .= '"' . $startDate_date . '",';
                $content .= '"' . $startDate_time . '",';
                $content .= '"' . $endDate_date . '",';
                $content .= '"' . $endDate_time . '",';
                if ($event->fullDay) {
                    $content .= 'TRUE,';
                } else {
                    $content .= 'FALSE,';
                }
                $content .= '"' . $event->notes . '"';
                fwrite($file, $content . "\n");
            }
            fclose($file);
            echo $this->parent->assets_url . '../tmp/' . $filename;
            die();
        }
    }

    public function exportCustomersCSV() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $settings = $this->getSettings();

            if (!is_dir(plugin_dir_path(__FILE__) . '../tmp')) {
                mkdir(plugin_dir_path(__FILE__) . '../tmp');
                chmod(plugin_dir_path(__FILE__) . '../tmp', $this->parent->chmodWrite);
            }
            $filename = 'exported_customers.csv';
            $target_path = plugin_dir_path(__FILE__) . '../tmp/' . $filename;
            $file = fopen($target_path, "w");

            $table_name = $wpdb->prefix . "wpefc_customers";
            $customers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
            $content = __('Inscription', 'lfb') . ';' .
                    __('First name', 'lfb') . ';' .
                    __('Last name', 'lfb') . ';' .
                    __('Company', 'lfb') . ';' .
                    __('Job', 'lfb') . ';' .
                    __('Email', 'lfb') . ';' .
                    __('Phone', 'lfb') . ';' .
                    __('Job phone', 'lfb') . ';' .
                    __('Address', 'lfb') . ';' .
                    __('Zip code', 'lfb') . ';' .
                    __('City', 'lfb') . ';' .
                    __('State', 'lfb') . ';' .
                    __('Country', 'lfb') . ';' .
                    __('Website', 'lfb') . ';';

            fwrite($file, $content . "\n");

            foreach ($customers as $customer) {
                $content = $customer->inscriptionDate . ';'
                        . $this->parent->stringDecode($customer->firstName, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->lastName, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->company, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->job, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->email, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->phone, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->phoneJob, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->address, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->zip, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->city, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->state, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->country, $settings->encryptDB) . ';'
                        . $this->parent->stringDecode($customer->website, $settings->encryptDB) . ';';

                fwrite($file, $content . "\n");
            }
            fclose($file);
            echo $this->parent->assets_url . '../tmp/' . $filename;
            die();
        }
    }

    public function exportLogs() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $settings = $this->getSettings();
            $formID = sanitize_text_field($_POST['formID']);
            $table_name = $wpdb->prefix . "wpefc_logs";
            $logsIDs = array();
            if (isset($_POST['logsIDs'])) {
                $logsIDs = sanitize_text_field($_POST['logsIDs']);
                $logsIDs = explode(',', $logsIDs);
            }

            if ($formID > 0) {
                $logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s ORDER BY id ASC", $formID));
            } else {
                $logs = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
            }
            if (!is_dir(plugin_dir_path(__FILE__) . '../tmp')) {
                mkdir(plugin_dir_path(__FILE__) . '../tmp');
                chmod(plugin_dir_path(__FILE__) . '../tmp', $this->parent->chmodWrite);
            }
            $filename = 'exported_orders.csv';
            $target_path = plugin_dir_path(__FILE__) . '../tmp/' . $filename;
            $file = fopen($target_path, "w");

            $content = __('Date', 'lfb') . ';' .
                    __('Form', 'lfb') . ';' .
                    __('Total price', 'lfb') . ';' .
                    __('Total Subscription', 'lfb') . ';' .
                    __('Frequency of subscription', 'lfb') . ';' .
                    __('Reference', 'lfb') . ';' .
                    __('Order', 'lfb') . ';' .
                    __('Email', 'lfb') . ';' .
                    __('First name', 'lfb') . ';' .
                    __('Last name', 'lfb') . ';' .
                    __('Country', 'lfb') . ';' .
                    __('State', 'lfb') . ';' .
                    __('City', 'lfb') . ';' .
                    __('Zip code', 'lfb') . ';' .
                    __('Address', 'lfb') . ';';

            fwrite($file, $content . "\n");

            foreach ($logs as $log) {

                if (count($logsIDs) == 0 || in_array($log->id, $logsIDs)) {

                    $verifiedPayment = __('No', 'lfb');
                    if ($log->checked) {
                        $verifiedPayment = __('Yes', 'lfb');
                    }
                    $contentTxt = str_replace('[n]', "\r\n", $this->parent->stringDecode($log->contentTxt, $settings->encryptDB));
                    $contentTxt = "\"$contentTxt\"";
                    $content = $log->dateLog . ';' . $log->formTitle . ';' . number_format($log->totalPrice, 2) . ';' . number_format($log->totalSubscription, 2) . ';' . $log->subscriptionFrequency . ';' .
                            $log->ref . ';' .
                            $contentTxt . ';' .
                            $this->parent->stringDecode($log->email, $settings->encryptDB) . ';' .
                            $this->parent->stringDecode($log->firstName, $settings->encryptDB) . ';' .
                            $this->parent->stringDecode($log->lastName, $settings->encryptDB) . ';' .
                            $this->parent->stringDecode($log->country, $settings->encryptDB) . ';' .
                            $this->parent->stringDecode($log->state, $settings->encryptDB) . ';' .
                            $this->parent->stringDecode($log->city, $settings->encryptDB) . ';' .
                            $this->parent->stringDecode($log->zip, $settings->encryptDB) . ';' .
                            $this->parent->stringDecode($log->address, $settings->encryptDB) . ';';
                    fwrite($file, $content . "\n");
                }
            }
            fclose($file);
            echo $this->parent->assets_url . '../tmp/' . $filename;
            die();
        }
    }

    public function changePreviewHeight() {
        global $wpdb;
        $height = sanitize_text_field($_POST['height']);
        $table_name = $wpdb->prefix . "wpefc_settings";
        $wpdb->update($table_name, array('previewHeight' => $height), array('id' => 1));
        die();
    }

    public function saveLinks() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $formID = sanitize_text_field($_POST['formID']);
            $table_name = $wpdb->prefix . "wpefc_links";
            if (substr(sanitize_text_field($_POST['links']), 0, 1) == '[' && $formID != "") {
                $links = json_decode(stripslashes($_POST['links']));

                $existingLinks = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s", $formID));
                if (count($existingLinks) > 1 && count($links) == 0) {
                    
                } else {
                    $wpdb->query("DELETE FROM $table_name WHERE formID=" . $formID . " AND id>0");

                    foreach ($links as $link) {
                        if (!is_null($link->originID)) {
                            if (isset($link->destinationID) && $link->destinationID > 0) {
                                $wpdb->insert($table_name, array('formID' => $formID, 'operator' => $link->operator, 'originID' => $link->originID, 'destinationID' => $link->destinationID, 'conditions' => $this->jsonRemoveUnicodeSequences($link->conditions)));
                            }
                        }
                    }
                }
            }
            echo '1';
            die();
        }
    }

    public function importForms() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $displayForm = true;
            $settings = $this->getSettings();
            $code = $settings->purchaseCode;
            if (isset($_FILES['importFile'])) {
                $error = false;
                if (!is_dir(plugin_dir_path(__FILE__) . '../tmp')) {
                    mkdir(plugin_dir_path(__FILE__) . '../tmp');
                    chmod(plugin_dir_path(__FILE__) . '../tmp', $this->parent->chmodWrite);
                }
                if (!is_dir(plugin_dir_path(__FILE__) . '../export')) {
                    mkdir(plugin_dir_path(__FILE__) . '../export');
                    chmod(plugin_dir_path(__FILE__) . '../export', $this->parent->chmodWrite);
                }
                $target_path = plugin_dir_path(__FILE__) . '../tmp/export_estimation_form.zip';
                if (@move_uploaded_file($_FILES['importFile']['tmp_name'], $target_path)) {


                    $upload_dir = wp_upload_dir();
                    if (!is_dir($upload_dir['path'])) {
                        mkdir($upload_dir['path']);
                    }

                    $zip = new ZipArchive;
                    $res = $zip->open($target_path);
                    if ($res === TRUE) {
                        $zip->extractTo(plugin_dir_path(__FILE__) . '../tmp/');
                        $zip->close();

                        $formsData = array();

                        $jsonfilename = 'export_estimation_form.json';
                        if (!file_exists(plugin_dir_path(__FILE__) . '../tmp/export_estimation_form.json')) {
                            $jsonfilename = 'export_estimation_form';
                        }

                        $file = file_get_contents(plugin_dir_path(__FILE__) . '../tmp/' . $jsonfilename);
                        $dataJson = json_decode($file, true);

                        $chkEnc = false;

                        $version = 0;
                        $encryptDB = 1;

                        $table_name = $wpdb->prefix . "wpefc_settings";
                        foreach ($dataJson['settings'] as $key => $value) {
                            if ($value['id'] == 1) {
                                if (!array_key_exists('encryptDB', $value)) {
                                    $encryptDB = 1;
                                } else {
                                    $encryptDB = $value['encryptDB'];
                                }
                                if (!array_key_exists('txtCustomersDataEditLink', $value)) {
                                    $value['txtCustomersDataEditLink'] = 'Modify my data';
                                    $value['customerDataAdminEmail'] = 'your@email.here';
                                    $value['txtCustomersDataWarningText'] = 'I understand and agree that deleting my data may result in the inability to process your order properly.';
                                    $value['txtCustomersDataDownloadLink'] = 'Download my data';
                                    $value['txtCustomersDataDeleteLink'] = 'Delete all my data';
                                    $value['txtCustomersDataLeaveLink'] = 'Sign out';
                                    $value['customersDataDeleteDelay'] = 3;
                                    $value['txtCustomersDataTitle'] = 'Manage my data';
                                    $value['customersDataLabelEmail'] = 'Your email';
                                    $value['customersDataLabelPass'] = 'Your password';
                                    $value['customersDataLabelModify'] = 'What data do you want to edit ?';
                                    $value['txtCustomersDataForgotPassLink'] = 'Send me my password';
                                    $value['txtCustomersDataForgotPassSent'] = 'Your password has been sent by email';
                                    $value['txtCustomersDataForgotMailSubject'] = 'Here is your password';
                                    $value['txtCustomersDataForgotPassMail'] = "Hello,\nHere is your password :\nPassword: [password]\nYou can manage your acount from : [url]";
                                    $value['txtCustomersDataModifyValidConfirm'] = 'Your request has been sent and will be processed as soon as possible';
                                    $value['txtCustomersDataModifyMailSubject'] = 'Data modification request from a customer';
                                    $value['txtCustomersDataDeleteMailSubject'] = 'Data deletion request from a customer';
                                } else {
                                    $chkEnc = true;
                                }
                                foreach ($value as $keyV => $valueV) {
                                    if ($keyV == 'sk') {
                                        update_option('lfbK', $valueV);
                                    }
                                    if ($keyV == 'version') {
                                        $version = $valueV;
                                    }

                                    if ($keyV != 'id' && $keyV != 'purchaseCode' && $keyV != 'tdgn_enabled' && $keyV != 'firstStart' && $keyV != 'sk' && $keyV != 'version') {

                                        $wpdb->update($table_name, array($keyV => $valueV), array('id' => 1));
                                    }
                                }
                            }
                        }
                        if ($version > 0) {
                            $chkEnc = false;
                        }

                        $table_name = $wpdb->prefix . "wpefc_forms";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('forms', $dataJson)) {
                            foreach ($dataJson['forms'] as $key => $value) {
                                if (!array_key_exists('email_adminContent', $value)) {
                                    $value['email_adminContent'] = '<p>Ref: <strong>[ref]</strong></p><h2 style="color: #008080;">Information</h2><hr/><span style="font-weight: 600; color: #444444;">[information_content]</span><span style="color: #444444;"> </span><hr/><h2 style="color: #008080;">Project</h2><hr/>[project_content]<hr/><h4>Total: <strong><span style="color: #444444;">[total_price]</span></strong></h4>';
                                    $value['email_userContent'] = '<p>Ref: <strong>[ref]</strong></p><h2 style="color: #008080;">Information</h2><hr/><span style="font-weight: 600; color: #444444;">[information_content]</span><span style="color: #444444;"> </span><hr/><h2 style="color: #008080;">Project</h2><hr/>[project_content]<hr/><h4>Total: <strong><span style="color: #444444;">[total_price]</span></strong></h4>';
                                }
                                if ($value['summary_hideQt'] == null) {
                                    $value['summary_hideQt'] = 0;
                                }
                                if ($value['summary_hideZero'] == null) {
                                    $value['summary_hideZero'] = 0;
                                }
                                if ($value['summary_hidePrices'] == null) {
                                    $value['summary_hidePrices'] = 0;
                                }
                                if ($value['groupAutoClick'] == null) {
                                    $value['groupAutoClick'] = 0;
                                }
                                if ($value['summary_hideTotal'] == null) {
                                    $value['summary_hideTotal'] = 0;
                                }
                                if ($value['pdf_adminContent'] == null) {
                                    $value['pdf_adminContent'] = $value['email_adminContent'];
                                }
                                if ($value['pdf_userContent'] == null) {
                                    $value['pdf_userContent'] = $value['email_userContent'];
                                }
                                if ($value['mainTitleTag'] == null) {
                                    $value['mainTitleTag'] = 'h1';
                                }

                                if ($value['use_stripe'] == null) {
                                    $value['paypal_useSandbox'] = 0;
                                }
                                if ($value['paypal_useSandbox'] == null) {
                                    $value['paypal_useSandbox'] = 0;
                                }
                                if ($value['stripe_useSandbox'] == null) {
                                    $value['stripe_useSandbox'] = 0;
                                }

                                if ($value['zapierWebHook'] == null) {
                                    $value['zapierWebHook'] = '';
                                }
                                if ($value['enableZapier'] == null) {
                                    $value['enableZapier'] = 0;
                                }
                                if ($value['randomSeed'] == null) {
                                    $value['randomSeed'] = $this->generateRandomString(5);
                                }

                                if ($value['paypal_useIpn'] == null) {
                                    $value['paypal_useIpn'] = 0;
                                }
                                if ($value['stepTitleTag'] == null) {
                                    $value['stepTitleTag'] = 'h2';
                                }

                                if (!array_key_exists('emailVerificationContent', $value)) {
                                    $value['emailVerificationContent'] = '<p>Here is the verification code to fill in the form to confirm your email :</p><h1>[code]</h1>';
                                    $value['emailVerificationSubject'] = 'Here is your email verification code';
                                    $value['txt_emailActivationCode'] = 'Fill your verifiation code here';
                                    $value['txt_emailActivationInfo'] = 'A unique verification code has just been sent to you by email, please copy it in the field below to validate your email address.';
                                }

                                if ($value['randomSeed'] == null || $value['randomSeed'] == '') {
                                    $value['randomSeed'] = $this->generateRandomString(5);
                                }

                                if (!array_key_exists('txtSignature', $value)) {
                                    $value['txtSignature'] = 'Signature';
                                }

                                if (!array_key_exists('enableCustomersData', $value)) {
                                    $value['enableCustomersData'] = 0;
                                    $value['customersDataEmailLink'] = 'According to the GDPR law, you can consult your data and delete them from this page: [url]';
                                }
                                if (!array_key_exists('txt_stripe_title', $value)) {
                                    $value['txt_stripe_title'] = 'Make a payment';
                                    $value['txt_stripe_btnPay'] = 'Pay now';
                                    $value['txt_stripe_totalTxt'] = 'Total to pay';
                                    $value['txt_stripe_paymentFail'] = 'Payment could not be made';
                                    $value['txt_stripe_cardOwnerLabel'] = 'Card owner name';
                                }

                                if ($value['usedCssFile'] != null && $value['usedCssFile'] != "") {
                                    if (is_file(plugin_dir_path(__FILE__) . '../tmp/' . $value['usedCssFile'])) {
                                        copy(plugin_dir_path(__FILE__) . '../tmp/' . $value['usedCssFile'], plugin_dir_path(__FILE__) . '../export/' . $value['usedCssFile']);
                                    }
                                }

                                if (!array_key_exists('colorSecondary', $value)) {
                                    $value['colorSecondary'] = '#bdc3c7';
                                    $value['colorSecondaryTxt'] = '#ffffff';
                                    $value['colorCbCircle'] = '#7f8c9a';
                                    $value['colorCbCircleOn'] = '#bdc3c7';
                                }

                                if ($value['useRedirectionConditions'] == null) {
                                    $value['useRedirectionConditions'] = 0;
                                }
                                if ($value['redirectionDelay'] == null) {
                                    $value['redirectionDelay'] = 5;
                                }
                                if (!array_key_exists('txt_btnRazorpay', $value)) {
                                    $value['txt_btnRazorpay'] = 'Pay with Razorpay';
                                    $value['razorpay_percentToPay'] = 100;
                                    $value['razorpay_subsFrequencyType'] = 'monthly';
                                    $value['razorpay_subsFrequency'] = 1;
                                    $value['razorpay_currency'] = 'USD';
                                }

                                if (!array_key_exists('txtForgotPassSent', $value)) {
                                    $value['txtForgotPassSent'] = 'Your password has been sent by email';
                                    $value['txtForgotPassLink'] = 'Send me my password';
                                }


                                if (array_key_exists('form_page_id', $value)) {
                                    unset($value['form_page_id']);
                                }

                                if ($value['intro_image'] && $value['intro_image'] != "") {
                                    $img_name = substr($value['intro_image'], strrpos($value['intro_image'], '/') + 1);
                                    $imagePath = substr($value['intro_image'], 0, strrpos($value['intro_image'], '/'));
                                    if (!file_exists(site_url() . '/' . $value['intro_image'])) {
                                        if (!is_dir($imagePath)) {
                                            $imagePath = wp_upload_dir();
                                        }
                                        if (strrpos($value['intro_image'], "uploads") === false) {
                                            $value['intro_image'] = 'uploads' . $value['intro_image'];
                                        }
                                        if (is_file(plugin_dir_path(__FILE__) . '../tmp/' . $img_name)) {
                                            copy(plugin_dir_path(__FILE__) . '../tmp/' . $img_name, $imagePath['basedir'] . $imagePath['subdir'] . '/' . $img_name);
                                        }
                                    }
                                    $value['intro_image'] = $imagePath['url'] . '/' . $img_name;
                                }

                                if (isset($value['stripe_logoImg']) && $value['stripe_logoImg'] != "") {
                                    $img_name = substr($value['stripe_logoImg'], strrpos($value['stripe_logoImg'], '/') + 1);
                                    $imagePath = substr($value['stripe_logoImg'], 0, strrpos($value['stripe_logoImg'], '/'));
                                    if (!file_exists(site_url() . '/' . $value['stripe_logoImg'])) {
                                        if (!is_dir($imagePath)) {
                                            $imagePath = wp_upload_dir();
                                        }
                                        if (strrpos($value['stripe_logoImg'], "uploads") === false) {
                                            $value['stripe_logoImg'] = 'uploads' . $value['stripe_logoImg'];
                                        }
                                        if (is_file(plugin_dir_path(__FILE__) . '../tmp/' . $img_name)) {
                                            copy(plugin_dir_path(__FILE__) . '../tmp/' . $img_name, $imagePath['basedir'] . $imagePath['subdir'] . '/' . $img_name);
                                        }
                                    }
                                    $value['stripe_logoImg'] = $imagePath['url'] . '/' . $img_name;
                                }

                                if (isset($value['razorpay_logoImg']) && $value['razorpay_logoImg'] != "") {
                                    $img_name = substr($value['razorpay_logoImg'], strrpos($value['razorpay_logoImg'], '/') + 1);
                                    $imagePath = substr($value['razorpay_logoImg'], 0, strrpos($value['razorpay_logoImg'], '/'));
                                    if (!file_exists(site_url() . '/' . $value['razorpay_logoImg'])) {
                                        if (!is_dir($imagePath)) {
                                            $imagePath = wp_upload_dir();
                                        }
                                        if (strrpos($value['razorpay_logoImg'], "uploads") === false) {
                                            $value['razorpay_logoImg'] = 'uploads' . $value['razorpay_logoImg'];
                                        }
                                        if (is_file(plugin_dir_path(__FILE__) . '../tmp/' . $img_name)) {
                                            copy(plugin_dir_path(__FILE__) . '../tmp/' . $img_name, $imagePath['basedir'] . $imagePath['subdir'] . '/' . $img_name);
                                        }
                                    }
                                    $value['razorpay_logoImg'] = $imagePath['url'] . '/' . $img_name;
                                } else {
                                    $value['razorpay_logoImg'] = esc_url(trailingslashit(plugins_url('/assets/', $this->parent->file))) . 'img/creditCard@2x.png';
                                }

                                $wpdb->insert($table_name, $value);
                            }
                        }

                        $table_name = $wpdb->prefix . "wpefc_customers";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('customers', $dataJson)) {
                            foreach ($dataJson['customers'] as $key => $value) {
                                if (!$chkEnc) {
                                    $value['email'] = $this->parent->stringEncode($value['email'], $encryptDB);
                                }
                                $wpdb->insert($table_name, $value);
                            }
                        }

                        $table_name = $wpdb->prefix . "wpefc_variables";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('variables', $dataJson)) {
                            foreach ($dataJson['variables'] as $key => $value) {
                                $wpdb->insert($table_name, $value);
                            }
                        }


                        $table_name = $wpdb->prefix . "wpefc_steps";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        $prevPosX = 40;
                        $firstStep = false;
                        foreach ($dataJson['steps'] as $key => $value) {
                            if (!array_key_exists('formID', $value)) {
                                $value['formID'] = 1;
                            }
                            if (!array_key_exists('showInSummary', $value)) {
                                $value['showInSummary'] = 1;
                            }
                            if (!array_key_exists('content', $value) || $value['content'] == "") {
                                $start = 0;
                                $value['content'] = '{"start":"' . $start . '","previewPosX":"' . $prevPosX . '","previewPosY":"140","actions":[],"id":' . $value['id'] . '}';
                                $prevPosX += 200;
                            }
                            $wpdb->insert($table_name, $value);
                        }

                        $table_name = $wpdb->prefix . "wpefc_fields";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('fields', $dataJson)) {
                            foreach ($dataJson['fields'] as $key => $value) {
                                if (!array_key_exists('validation', $value) && $value['id'] == '1') {
                                    $value['validation'] = 'email';
                                }
                                if (array_key_exists('height', $value)) {
                                    unset($value['height']);
                                }

                                $wpdb->insert($table_name, $value);
                            }
                        }


                        $table_name = $wpdb->prefix . "wpefc_layeredImages";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('layeredImages', $dataJson)) {
                            foreach ($dataJson['layeredImages'] as $key => $value) {
                                if ($value['image'] && $value['image'] != "") {
                                    $img_name = substr($value['image'], strrpos($value['image'], '/') + 1);
                                    $imagePath = substr($value['image'], 0, strrpos($value['image'], '/'));
                                    if (!file_exists(site_url() . '/' . $value['image'])) {
                                        if (!is_dir($imagePath)) {
                                            $imagePath = wp_upload_dir();
                                        }
                                        if (strrpos($value['image'], "uploads") === false) {
                                            $value['image'] = 'uploads' . $value['image'];
                                        }
                                        if (is_file(plugin_dir_path(__FILE__) . '../tmp/' . $img_name)) {
                                            copy(plugin_dir_path(__FILE__) . '../tmp/' . $img_name, $imagePath['basedir'] . $imagePath['subdir'] . '/' . $img_name);
                                        }
                                    }
                                    $value['image'] = $imagePath['url'] . '/' . $img_name;
                                }

                                $wpdb->insert($table_name, $value);
                            }
                        }

                        $table_name = $wpdb->prefix . "wpefc_links";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('links', $dataJson)) {
                            foreach ($dataJson['links'] as $key => $value) {
                                $wpdb->insert($table_name, $value);
                            }
                        }

                        $table_name = $wpdb->prefix . "wpefc_logs";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('logs', $dataJson)) {
                            foreach ($dataJson['logs'] as $key => $value) {

                                if (!$chkEnc) {
                                    $value['email'] = $this->parent->stringEncode($value['email'], $encryptDB);
                                    $value['phone'] = $this->parent->stringEncode($value['phone'], $encryptDB);
                                    $value['firstName'] = $this->parent->stringEncode($value['firstName'], $encryptDB);
                                    $value['lastName'] = $this->parent->stringEncode($value['lastName'], $encryptDB);
                                    $value['address'] = $this->parent->stringEncode($value['address'], $encryptDB);
                                    $value['city'] = $this->parent->stringEncode($value['city'], $encryptDB);
                                    $value['country'] = $this->parent->stringEncode($value['country'], $encryptDB);
                                    $value['state'] = $this->parent->stringEncode($value['state'], $encryptDB);
                                    $value['zip'] = $this->parent->stringEncode($value['zip'], $encryptDB);
                                    $value['contentTxt'] = $this->parent->stringEncode($value['contentTxt'], $encryptDB);
                                    /*   $value['content'] = $this->parent->stringEncode($value['content'], $encryptDB);
                                      $value['contentUser'] = $this->parent->stringEncode($value['contentUser'], $encryptDB);
                                      $value['pdfContent'] = $this->parent->stringEncode($value['pdfContent'], $encryptDB);
                                      $value['pdfContentUser'] = $this->parent->stringEncode($value['pdfContentUser'], $encryptDB); */


                                    $lastPos = 0;
                                    $positions = array();
                                    $toReplaceDefault = array();
                                    $toReplaceBy = array();
                                    while (($lastPos = strpos($value['content'], '<span class="lfb_value">', $lastPos)) !== false) {
                                        $positions[] = $lastPos;
                                        $lastPos = $lastPos + strlen('<span class="lfb_value">');
                                        $fileStartPos = $lastPos;
                                        $lastSpan = strpos($value['content'], '</span>', $fileStartPos);
                                        $valueC = substr($value['content'], $fileStartPos, $lastSpan - $fileStartPos);
                                        $toReplaceDefault[] = '<span class="lfb_value">' . $valueC . '</span>';
                                        $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringDecode($valueC, $settings->encryptDB) . '</span>';
                                    }
                                    foreach ($toReplaceBy as $key => $valueC) {
                                        $value['content'] = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $value['content']);
                                    }

                                    $lastPos = 0;
                                    $positions = array();
                                    $toReplaceDefault = array();
                                    $toReplaceBy = array();
                                    while (($lastPos = strpos($value['contentUser'], '<span class="lfb_value">', $lastPos)) !== false) {
                                        $positions[] = $lastPos;
                                        $lastPos = $lastPos + strlen('<span class="lfb_value">');
                                        $fileStartPos = $lastPos;
                                        $lastSpan = strpos($value['contentUser'], '</span>', $fileStartPos);
                                        $valueC = substr($value['contentUser'], $fileStartPos, $lastSpan - $fileStartPos);
                                        $toReplaceDefault[] = '<span class="lfb_value">' . $valueC . '</span>';
                                        $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringDecode($valueC, $settings->encryptDB) . '</span>';
                                    }
                                    foreach ($toReplaceBy as $key => $valueC) {
                                        $value['contentUser'] = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $value['contentUser']);
                                    }



                                    $lastPos = 0;
                                    $positions = array();
                                    $toReplaceDefault = array();
                                    $toReplaceBy = array();
                                    while (($lastPos = strpos($value['pdfContentUser'], '<span class="lfb_value">', $lastPos)) !== false) {
                                        $positions[] = $lastPos;
                                        $lastPos = $lastPos + strlen('<span class="lfb_value">');
                                        $fileStartPos = $lastPos;
                                        $lastSpan = strpos($value['pdfContentUser'], '</span>', $fileStartPos);
                                        $valueC = substr($value['pdfContentUser'], $fileStartPos, $lastSpan - $fileStartPos);
                                        $toReplaceDefault[] = '<span class="lfb_value">' . $valueC . '</span>';
                                        $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringDecode($valueC, $settings->encryptDB) . '</span>';
                                    }
                                    foreach ($toReplaceBy as $key => $valueC) {
                                        $value['pdfContentUser'] = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $value['pdfContentUser']);
                                    }


                                    $lastPos = 0;
                                    $positions = array();
                                    $toReplaceDefault = array();
                                    $toReplaceBy = array();
                                    while (($lastPos = strpos($value['pdfContent'], '<span class="lfb_value">', $lastPos)) !== false) {
                                        $positions[] = $lastPos;
                                        $lastPos = $lastPos + strlen('<span class="lfb_value">');
                                        $fileStartPos = $lastPos;
                                        $lastSpan = strpos($value['pdfContent'], '</span>', $fileStartPos);
                                        $valueC = substr($value['pdfContent'], $fileStartPos, $lastSpan - $fileStartPos);
                                        $toReplaceDefault[] = '<span class="lfb_value">' . $valueC . '</span>';
                                        $toReplaceBy[] = '<span class="lfb_value">' . $this->parent->stringDecode($valueC, $settings->encryptDB) . '</span>';
                                    }
                                    foreach ($toReplaceBy as $key => $valueC) {
                                        $value['pdfContent'] = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $value['pdfContent']);
                                    }
                                }
                                $wpdb->insert($table_name, $value);
                            }
                        }


                        $table_name = $wpdb->prefix . "wpefc_coupons";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('coupons', $dataJson)) {
                            foreach ($dataJson['coupons'] as $key => $value) {
                                $wpdb->insert($table_name, $value);
                            }
                        }

                        $table_name = $wpdb->prefix . "wpefc_redirConditions";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('redirections', $dataJson)) {
                            foreach ($dataJson['redirections'] as $key => $value) {
                                $wpdb->insert($table_name, $value);
                            }
                        }

                        // check customers
                        $table_name = $wpdb->prefix . "wpefc_logs";
                        $logs = $wpdb->get_results("SELECT * FROM $table_name  GROUP BY(email)");
                        foreach ($logs as $log) {
                            if ($log->customerID == 0) {
                                $table_nameC = $wpdb->prefix . "wpefc_customers";
                                $customerData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameC WHERE email=%s LIMIT 1", $log->email));
                                $customerID = 0;
                                if (count($customerData) > 0) {
                                    $customerID = $customerData[0]->id;
                                } else {
                                    $pass = $this->parent->generatePassword();
                                    $wpdb->insert($table_nameC, array('email' => $this->parent->stringEncode($log->email, $encryptDB), 'password' => $this->parent->stringEncode($pass, true)));
                                    $customerID = $wpdb->insert_id;
                                }
                                $wpdb->update($table_name, array('customerID' => $customerID), array('email' => $this->parent->stringEncode($log->email, $encryptDB)));
                            }
                        }

                        // Check links
                        $table_name = $wpdb->prefix . "wpefc_forms";
                        $forms = $wpdb->get_results("SELECT * FROM $table_name");
                        foreach ($forms as $form) {
                            $table_name = $wpdb->prefix . "wpefc_links";
                            $links = $wpdb->get_results("SELECT * FROM $table_name WHERE formID=" . $form->id);
                            if (count($links) == 0) {

                                $stepStartID = 0;
                                $stepStart = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wpefc_steps WHERE start=1 AND formID=" . $form->id);
                                if (count($stepStart) > 0) {
                                    $stepStart = $stepStart[0];
                                    $stepStartID = $stepStart->id;
                                }
                                $steps = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wpefc_steps WHERE formID=" . $form->id . " AND start=0 ORDER BY ordersort ASC, id ASC");
                                $i = 0;
                                $prevStepID = 0;
                                foreach ($steps as $step) {
                                    if ($i == 0 && $stepStartID > 0) {
                                        $wpdb->insert($wpdb->prefix . "wpefc_links", array('originID' => $stepStartID, 'destinationID' => $step->id, 'formID' => $form->id, 'conditions' => '[]'));
                                    } else if ($i > 0 && $prevStepID > 0) {
                                        $wpdb->insert($wpdb->prefix . "wpefc_links", array('originID' => $prevStepID, 'destinationID' => $step->id, 'formID' => $form->id, 'conditions' => '[]'));
                                    }
                                    $prevStepID = $step->id;
                                    $i++;
                                }
                            }
                        }

                        $table_name = $wpdb->prefix . "wpefc_items";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        foreach ($dataJson['items'] as $key => $value) {

                            if ($value['type'] == 'timepicker') {
                                $value['type'] = 'datepicker';
                                $value['dateType'] = 'time';
                            }

                            if (!array_key_exists('priceMode', $value) && $value['isSinglePrice'] == 0) {
                                // if ($value['priceMode'] == null && $value['isSinglePrice'] == 0) {
                                $formData = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "wpefc_forms WHERE id=%s LIMIT 1", $value['formID']));
                                if (count($formData) > 0) {
                                    $formData = $formData[0];
                                    if ($formData->isSubscription) {
                                        $value['priceMode'] = 'sub';
                                    }
                                }
                            }

                            if ($value['image'] && $value['image'] != "") {
                                $img_name = substr($value['image'], strrpos($value['image'], '/') + 1);
                                $imagePath = substr($value['image'], 0, strrpos($value['image'], '/'));
                                if (!file_exists(site_url() . '/' . $value['image'])) {
                                    if (!is_dir($imagePath)) {
                                        $imagePath = wp_upload_dir();
                                    }
                                    if (strrpos($value['image'], "uploads") === false) {
                                        $value['image'] = 'uploads' . $value['image'];
                                    }
                                    if (is_file(plugin_dir_path(__FILE__) . '../tmp/' . $img_name)) {
                                        copy(plugin_dir_path(__FILE__) . '../tmp/' . $img_name, $imagePath['basedir'] . $imagePath['subdir'] . '/' . $img_name);
                                    }
                                }
                                $value['image'] = $imagePath['url'] . '/' . $img_name;
                            }
                            if (array_key_exists('reduc_qt', $value)) {
                                unset($value['reduc_qt']);
                                unset($value['reduc_value']);
                            }


                            if ($value['quantity_enabled'] == null) {
                                $value['quantity_enabled'] = 0;
                            }
                            if ($value['isWooLinked'] == null) {
                                $value['isWooLinked'] = 0;
                            }
                            if ($value['ischecked'] == null) {
                                $value['ischecked'] = 0;
                            }

                            if ($value['imageTint'] == null) {
                                $value['imageTint'] = 0;
                            }

                            if (!array_key_exists('checkboxStyle', $value) || $value['checkboxStyle'] == null) {
                                $value['checkboxStyle'] = 'switchbox';
                            }
                            $wpdb->insert($table_name, $value);
                        }


                        $table_name = $wpdb->prefix . "wpefc_fields";
                        $table_nameI = $wpdb->prefix . "wpefc_items";
                        $table_nameF = $wpdb->prefix . "wpefc_forms";
                        $fields = $wpdb->get_results("SELECT * FROM $table_name ORDER BY ordersort ASC,id ASC");
                        foreach ($fields as $field) {
                            $addToCss = '';
                            $type = 'textfield';
                            if ($field->typefield == 'textarea') {
                                $type = 'textarea';
                            }
                            $useShowConditions = 0;
                            $showConditions = '';
                            if ($field->visibility == 'toggle') {

                                $chkExistSql = $wpdb->get_results("SELECT * FROM $table_nameI WHERE formID=formID AND title='$field->label' AND type='checkbox' ");
                                if (count($chkExistSql) == 0) {

                                    $chechboxToggle = $wpdb->insert($table_nameI, array('formID' => $field->formID, 'stepID' => 0, 'title' => $field->label, 'type' => 'checkbox', 'ordersort' => $field->ordersort, 'showInSummary' => 0, 'useRow' => 1));
                                    $lastid = $wpdb->insert_id;
                                    $useShowConditions = 1;
                                    $showConditions = '[{"interaction":"0_' . $lastid . '","action":"clicked"}]';
                                }
                            }
                            $isRequired = 0;
                            if ($field->validation != "") {
                                $isRequired = 1;
                            }
                            if ($field->validation == 'email') {
                                $field->fieldType = 'email';
                            }

                            $chkExistSql = $wpdb->get_results("SELECT * FROM $table_nameI WHERE formID=formID AND title='$field->label' AND type='$type' ");
                            if (count($chkExistSql) == 0) {

                                $newItem = $wpdb->insert($table_nameI, array('formID' => $field->formID, 'stepID' => 0,
                                    'title' => $field->label,
                                    'type' => $type,
                                    'showConditions' => $showConditions,
                                    'useShowConditions' => $useShowConditions,
                                    'isRequired' => $isRequired,
                                    'fieldType' => $field->fieldType,
                                    'useRow' => 1,
                                    'ordersort' => $field->ordersort
                                ));
                                $newItemID = $wpdb->insert_id;
                                if ($field->visibility == 'toggle') {
                                    //   $addToCss .= '#estimation_popup[data-form="' . $field->formID . '"] #mainPanel .lfb_item.lfb_itemContainer_' . $newItemID . ' textarea {margin-top:-22px}' . "\n";
                                    $addToCss .= '#estimation_popup[data-form="' . $field->formID . '"] #mainPanel .lfb_item.lfb_itemContainer_' . $newItemID . ' :not(.switch-animate)>  label {display:none !important;}' . "\n";

                                    $form = $wpdb->get_results("SELECT * FROM $table_nameF WHERE id='" . $field->formID . "' LIMIT 1");
                                    if (count($form) > 0) {
                                        $form = $form[0];
                                        $wpdb->update($table_nameF, array('customCss' => $form->customCss . "\n" . $addToCss), array('id' => $form->id));
                                    }
                                }
                            }
                        }
                        $table_name = $wpdb->prefix . "wpefc_fields";
                        $wpdb->query("TRUNCATE TABLE $table_name");

                        $table_name = $wpdb->prefix . "wpefc_calendars";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('calendars', $dataJson)) {
                            foreach ($dataJson['calendars'] as $key => $value) {
                                $wpdb->insert($table_name, $value);
                            }
                        }
                        $table_name = $wpdb->prefix . "wpefc_calendarEvents";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('calendarEvents', $dataJson)) {
                            foreach ($dataJson['calendarEvents'] as $key => $value) {

                                if (!$chkEnc) {
                                    $value['customerEmail'] = $this->parent->stringEncode($value['customerEmail'], $encryptDB);
                                    $value['customerAddress'] = $this->parent->stringEncode($value['customerAddress'], $encryptDB);
                                }

                                $wpdb->insert($table_name, $value);
                            }
                        }
                        $table_name = $wpdb->prefix . "wpefc_calendarReminders";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('calendarReminders', $dataJson)) {
                            foreach ($dataJson['calendarReminders'] as $key => $value) {
                                $wpdb->insert($table_name, $value);
                            }
                        }
                        $table_name = $wpdb->prefix . "wpefc_calendarCategories";
                        $wpdb->query("TRUNCATE TABLE $table_name");
                        if (array_key_exists('calendarCategories', $dataJson)) {
                            foreach ($dataJson['calendarCategories'] as $key => $value) {
                                $wpdb->insert($table_name, $value);
                            }
                        }

                        // check if calendar exists
                        $table_name = $wpdb->prefix . "wpefc_calendars";
                        $calendars = $wpdb->get_results("SELECT * FROM $table_name LIMIT 1");
                        if (!$calendars || count($calendars) == 0) {
                            $wpdb->insert($table_name, array('title' => 'Default', 'unavailableDays' => '', 'unavailableHours' => ''));
                            $wpdb->insert($wpdb->prefix . "wpefc_calendarCategories", array('title' => 'Default', 'color' => '#1abc9c', 'calendarID' => 1));
                        }

                        // check if form exists
                        $table_name = $wpdb->prefix . "wpefc_forms";
                        $forms = $wpdb->get_results("SELECT * FROM $table_name LIMIT 1");
                        if (!$forms || count($forms) == 0) {
                            $formsData['title'] = 'My Estimation Form';
                            $wpdb->insert($table_name, $formsData);
                        }


                        $files = glob(plugin_dir_path(__FILE__) . '../tmp/*');
                        foreach ($files as $file) {
                            if (is_file($file))
                                unlink($file);
                        }
                    } else {
                        $error = true;
                    }
                } else {
                    $error = true;
                }
                if ($error) {
                    echo __('An error occurred during the transfer', 'lfb');
                    die();
                } else {
                    $displayForm = false;
                    echo 1;
                    die();
                }
            }
        }
    }

    public function exportForms() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            if (!is_dir(plugin_dir_path(__FILE__) . '../tmp')) {
                mkdir(plugin_dir_path(__FILE__) . '../tmp');
                chmod(plugin_dir_path(__FILE__) . '../tmp', $this->parent->chmodWrite);
            }
            $withLogs = sanitize_text_field($_POST['withLogs']);
            $withCoupons = sanitize_text_field($_POST['withCoupons']);


            $destination = plugin_dir_path(__FILE__) . '../tmp/export_estimation_form.zip';
            if (file_exists($destination)) {
                unlink($destination);
            }
            $zip = new ZipArchive();
            if ($zip->open($destination, ZipArchive::CREATE) !== true) {
                return false;
            }

            $jsonExport = array();
            $table_name = $wpdb->prefix . "wpefc_settings";
            $settings = $this->getSettings();
            $settings->purchaseCode = "";
            $settings->tdgn_enabled = "";
            $settings->sk = get_option('lfbK');
            $settings->version = $this->parent->_version;

            $jsonExport['settings'] = array();
            $jsonExport['settings'][] = $settings;


            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $row->analyticsID = '';
                if ($row->usedCssFile != "" && file_exists(plugin_dir_path(__FILE__) . '../export/' . $row->usedCssFile)) {
                    $zip->addfile(plugin_dir_path(__FILE__) . '../export/' . $row->usedCssFile, $row->usedCssFile);
                }

                if ($row->intro_image != "") {
                    $original_image = $row->intro_image;
                    $upload_dir = wp_upload_dir();
                    $pos1 = strrpos($original_image, '/');
                    $pos2 = strrpos($row->intro_image, '/', 0 - (strlen($row->intro_image) - $pos1) - 1);
                    $pos3 = strrpos($row->intro_image, '/', 0 - (strlen($row->intro_image) - $pos2) - 1);
                    if (strpos($row->intro_image, site_url()) !== false) {
                        $row->intro_image = substr($row->intro_image, strlen(site_url()) + 1);
                    }
                    if (strrpos($row->intro_image, "wp-content") > -1) {
                        $row->intro_image = substr($row->intro_image, strrpos($row->intro_image, "wp-content") + 11);
                    }
                    if (substr($row->intro_image, 0, 17) == '/uploads/uploads/') {
                        $row->intro_image = substr($row->intro_image, 9);
                    }
                    if (file_exists($this->dir . "/../../" . $row->intro_image)) {
                        $zip->addfile($this->dir . "/../../" . $row->intro_image, substr($original_image, $pos1 + 1));
                    }
                }
                if ($row->stripe_logoImg != "") {
                    $original_image = $row->stripe_logoImg;
                    $upload_dir = wp_upload_dir();
                    $pos1 = strrpos($original_image, '/');
                    $pos2 = strrpos($row->stripe_logoImg, '/', 0 - (strlen($row->stripe_logoImg) - $pos1) - 1);
                    $pos3 = strrpos($row->stripe_logoImg, '/', 0 - (strlen($row->stripe_logoImg) - $pos2) - 1);
                    if (strpos($row->stripe_logoImg, site_url()) !== false) {
                        $row->stripe_logoImg = substr($row->stripe_logoImg, strlen(site_url()) + 1);
                    }
                    if (strrpos($row->stripe_logoImg, "wp-content") > -1) {
                        $row->stripe_logoImg = substr($row->stripe_logoImg, strrpos($row->stripe_logoImg, "wp-content") + 11);
                    }
                    if (substr($row->stripe_logoImg, 0, 17) == '/uploads/uploads/') {
                        $row->stripe_logoImg = substr($row->stripe_logoImg, 9);
                    }
                    if (file_exists($this->dir . "/../../" . $row->stripe_logoImg)) {
                        $zip->addfile($this->dir . "/../../" . $row->stripe_logoImg, substr($original_image, $pos1 + 1));
                    }
                }

                if ($row->razorpay_logoImg != "") {
                    $original_image = $row->razorpay_logoImg;
                    $upload_dir = wp_upload_dir();
                    $pos1 = strrpos($original_image, '/');
                    $pos2 = strrpos($row->razorpay_logoImg, '/', 0 - (strlen($row->razorpay_logoImg) - $pos1) - 1);
                    $pos3 = strrpos($row->razorpay_logoImg, '/', 0 - (strlen($row->razorpay_logoImg) - $pos2) - 1);
                    if (strpos($row->razorpay_logoImg, site_url()) !== false) {
                        $row->razorpay_logoImg = substr($row->razorpay_logoImg, strlen(site_url()) + 1);
                    }
                    if (strrpos($row->razorpay_logoImg, "wp-content") > -1) {
                        $row->razorpay_logoImg = substr($row->razorpay_logoImg, strrpos($row->razorpay_logoImg, "wp-content") + 11);
                    }
                    if (substr($row->razorpay_logoImg, 0, 17) == '/uploads/uploads/') {
                        $row->razorpay_logoImg = substr($row->razorpay_logoImg, 9);
                    }

                    if (file_exists($this->dir . "/../../" . $row->razorpay_logoImg)) {
                        $zip->addfile($this->dir . "/../../" . $row->razorpay_logoImg, substr($original_image, $pos1 + 1));
                    }
                }


                $forms[] = $row;
            }
            $jsonExport['forms'] = $forms;



            if ($withLogs == 1) {
                $table_name = $wpdb->prefix . "wpefc_logs";
                $logs = array();
                foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                    $row->email = $this->parent->stringDecode($row->email, $settings->encryptDB);
                    $row->firstName = $this->parent->stringDecode($row->firstName, $settings->encryptDB);
                    $row->lastName = $this->parent->stringDecode($row->lastName, $settings->encryptDB);
                    $row->country = $this->parent->stringDecode($row->country, $settings->encryptDB);
                    $row->state = $this->parent->stringDecode($row->state, $settings->encryptDB);
                    $row->city = $this->parent->stringDecode($row->city, $settings->encryptDB);
                    $row->phone = $this->parent->stringDecode($row->phone, $settings->encryptDB);
                    $row->zip = $this->parent->stringDecode($row->zip, $settings->encryptDB);
                    $row->address = $this->parent->stringDecode($row->address, $settings->encryptDB);
                    $row->contentTxt = $this->parent->stringDecode($row->contentTxt, $settings->encryptDB);

                    $logs[] = $row;
                }
                $jsonExport['logs'] = $logs;
            } else {
                $jsonExport['logs'] = array();
            }

            if ($withCoupons == 1) {
                $table_name = $wpdb->prefix . "wpefc_coupons";
                $coupons = array();
                foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                    $coupons[] = $row;
                }
                $jsonExport['coupons'] = $coupons;
            } else {
                $jsonExport['coupons'] = array();
            }

            $table_name = $wpdb->prefix . "wpefc_steps";
            $steps = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $steps[] = $row;
            }
            $jsonExport['steps'] = $steps;


            $table_name = $wpdb->prefix . "wpefc_variables";
            $variables = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $variables[] = $row;
            }
            $jsonExport['variables'] = $variables;



            $table_name = $wpdb->prefix . "wpefc_layeredImages";
            $layers = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $layers[] = $row;
                if ($row->image != "") {
                    $original_image = $row->image;
                    $upload_dir = wp_upload_dir();
                    $pos1 = strrpos($original_image, '/');
                    $pos2 = strrpos($row->image, '/', 0 - (strlen($row->image) - $pos1) - 1);
                    $pos3 = strrpos($row->image, '/', 0 - (strlen($row->image) - $pos2) - 1);
                    if (strpos($row->image, site_url()) !== false) {
                        $row->image = substr($row->image, strlen(site_url()) + 1);
                    }
                    if (strrpos($row->image, "wp-content") > -1) {
                        $row->image = substr($row->image, strrpos($row->image, "wp-content") + 11);
                    }
                    if (substr($row->image, 0, 17) == '/uploads/uploads/') {
                        $row->image = substr($row->image, 9);
                    }
                    if (file_exists($this->dir . "/../../" . $row->image)) {
                        $zip->addfile($this->dir . "/../../" . $row->image, substr($original_image, $pos1 + 1));
                    }
                }
            }
            $jsonExport['layeredImages'] = $layers;

            $table_name = $wpdb->prefix . "wpefc_links";
            $steps = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $steps[] = $row;
            }
            $jsonExport['links'] = $steps;

            if ($withLogs == 1) {
                $table_name = $wpdb->prefix . "wpefc_customers";
                $customers = array();
                foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                    $row->email = $this->parent->stringDecode($row->email, $settings->encryptDB);
                    $customers[] = $row;
                }
                $jsonExport['customers'] = $customers;
            } else {
                $jsonExport['customers'] = array();
            }

            $table_name = $wpdb->prefix . "wpefc_redirConditions";
            $redirs = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $steps[] = $row;
            }
            $jsonExport['redirections'] = $redirs;

            $table_name = $wpdb->prefix . "wpefc_items";
            $items = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $items[] = $row;
                if ($row->image != "") {
                    $original_image = $row->image;
                    $upload_dir = wp_upload_dir();
                    $pos1 = strrpos($original_image, '/');
                    $pos2 = strrpos($row->image, '/', 0 - (strlen($row->image) - $pos1) - 1);
                    $pos3 = strrpos($row->image, '/', 0 - (strlen($row->image) - $pos2) - 1);
                    if (strpos($row->image, site_url()) !== false) {
                        $row->image = substr($row->image, strlen(site_url()) + 1);
                    }
                    if (strrpos($row->image, "wp-content") > -1) {
                        $row->image = substr($row->image, strrpos($row->image, "wp-content") + 11);
                    }
                    if (substr($row->image, 0, 17) == '/uploads/uploads/') {
                        $row->image = substr($row->image, 9);
                    }
                    if (file_exists($this->dir . "/../../" . $row->image)) {
                        $zip->addfile($this->dir . "/../../" . $row->image, substr($original_image, $pos1 + 1));
                    }
                }
            }


            $table_name = $wpdb->prefix . "wpefc_calendars";
            $calendars = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $calendars[] = $row;
            }
            $jsonExport['calendars'] = $calendars;

            $table_name = $wpdb->prefix . "wpefc_calendarEvents";
            $calendarEvents = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $row->customerEmail = $this->parent->stringDecode($row->customerEmail, $settings->encryptDB);
                $row->customerAddress = $this->parent->stringDecode($row->customerAddress, $settings->encryptDB);
                $calendarEvents[] = $row;
            }
            $jsonExport['calendarEvents'] = $calendarEvents;

            $table_name = $wpdb->prefix . "wpefc_calendarReminders";
            $calendarReminders = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {


                $calendarReminders[] = $row;
            }
            $jsonExport['calendarReminders'] = $calendarReminders;


            $table_name = $wpdb->prefix . "wpefc_calendarCategories";
            $calendarCategories = array();
            foreach ($wpdb->get_results("SELECT * FROM $table_name") as $key => $row) {
                $calendarCategories[] = $row;
            }
            $jsonExport['calendarCategories'] = $calendarCategories;

            $jsonExport['items'] = $items;
            $fp = fopen(plugin_dir_path(__FILE__) . '../tmp/export_estimation_form.json', 'w');
            fwrite($fp, json_encode($jsonExport));
            fclose($fp);

            $zip->addfile(plugin_dir_path(__FILE__) . '../tmp/export_estimation_form.json', 'export_estimation_form.json');
            $zip->close();
            echo '1';
            die();
        }
    }

    public function removeAllCoupons() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $formID = sanitize_text_field($_POST['formID']);
            $table_name = $wpdb->prefix . "wpefc_coupons";
            $wpdb->delete($table_name, array('formID' => $formID));
        }
        die();
    }

    public function removeCoupon() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $couponID = sanitize_text_field($_POST['couponID']);
            $formID = sanitize_text_field($_POST['formID']);
            $table_name = $wpdb->prefix . "wpefc_coupons";
            $wpdb->delete($table_name, array('id' => $couponID));
        }
        die();
    }

    public function saveCoupon() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $table_name = $wpdb->prefix . "wpefc_coupons";
            $couponID = sanitize_text_field($_POST['couponID']);
            $formID = sanitize_text_field($_POST['formID']);
            $couponCode = sanitize_text_field($_POST['couponCode']);
            $useMax = sanitize_text_field($_POST['useMax']);
            $reduction = sanitize_text_field($_POST['reduction']);
            $reductionType = sanitize_text_field($_POST['reductionType']);

            if ($couponID > 0) {
                $wpdb->update($table_name, array('couponCode' => $couponCode, 'useMax' => $useMax, 'reduction' => $reduction, 'reductionType' => $reductionType), array('id' => $couponID));
                echo $couponID;
            } else {
                $wpdb->insert($table_name, array('couponCode' => $couponCode, 'useMax' => $useMax, 'reduction' => $reduction, 'reductionType' => $reductionType, 'formID' => $formID));
                echo $wpdb->insert_id;
            }
        }
        die();
    }

    public function checkFirstStart() {
        global $wpdb;
        $settings = $this->getSettings();
        if ($settings->firstStart) {
            $table_name = $wpdb->prefix . "wpefc_settings";
            $wpdb->update($table_name, array('firstStart' => 0), array('id' => 1));



            $formsData = array();

            $jsonfilename = 'export_estimation_form.json';
            if (!file_exists(plugin_dir_path(__FILE__) . '../tmp/export_estimation_form.json')) {
                $jsonfilename = 'export_estimation_form';
            }

            $file = file_get_contents(plugin_dir_path(__FILE__) . '../tmp/' . $jsonfilename);
            $dataJson = json_decode($file, true);

            $table_name = $wpdb->prefix . "wpefc_forms";
            $wpdb->query("TRUNCATE TABLE $table_name");
            if (array_key_exists('forms', $dataJson)) {
                foreach ($dataJson['forms'] as $key => $value) {
                    if (!array_key_exists('email_adminContent', $value)) {
                        $value['email_adminContent'] = '<p>Ref: <strong>[ref]</strong></p><h2 style="color: #008080;">Information</h2><hr/><span style="font-weight: 600; color: #444444;">[information_content]</span><span style="color: #444444;"> </span><hr/><h2 style="color: #008080;">Project</h2><hr/>[project_content]<hr/><h4>Total: <strong><span style="color: #444444;">[total_price]</span></strong></h4>';
                        $value['email_userContent'] = '<p>Ref: <strong>[ref]</strong></p><h2 style="color: #008080;">Information</h2><hr/><span style="font-weight: 600; color: #444444;">[information_content]</span><span style="color: #444444;"> </span><hr/><h2 style="color: #008080;">Project</h2><hr/>[project_content]<hr/><h4>Total: <strong><span style="color: #444444;">[total_price]</span></strong></h4>';
                    }
                    if ($value['summary_hideQt'] == null) {
                        $value['summary_hideQt'] = 0;
                    }
                    if ($value['summary_hideZero'] == null) {
                        $value['summary_hideZero'] = 0;
                    }
                    if ($value['summary_hidePrices'] == null) {
                        $value['summary_hidePrices'] = 0;
                    }
                    if ($value['groupAutoClick'] == null) {
                        $value['groupAutoClick'] = 0;
                    }
                    if ($value['randomSeed'] == null || $value['randomSeed'] == '') {
                        $value['randomSeed'] = $this->generateRandomString(5);
                    }
                    if (!array_key_exists('colorSecondary', $value)) {
                        $value['colorSecondary'] = '#bdc3c7';
                        $value['colorSecondaryTxt'] = '#ffffff';
                        $value['colorCbCircle'] = '#7f8c9a';
                        $value['colorCbCircleOn'] = '#bdc3c7';
                    }

                    if ($value['useRedirectionConditions'] == null) {
                        $value['useRedirectionConditions'] = 0;
                    }
                    if ($value['redirectionDelay'] == null) {
                        $value['redirectionDelay'] = 5;
                    }

                    if (array_key_exists('form_page_id', $value)) {
                        unset($value['form_page_id']);
                    }

                    if (!array_key_exists('emailVerificationContent', $value)) {
                        $value['emailVerificationContent'] = '<p>Here is the verification code to fill in the form to confirm your email :</p><h1>[code]</h1>';
                        $value['emailVerificationSubject'] = 'Here is your email verification code';
                        $value['txt_emailActivationCode'] = 'Fill your verifiation code here';
                        $value['txt_emailActivationInfo'] = 'A unique verification code has just been sent to you by email, please copy it in the field below to validate your email address.';
                    }
                    if (!array_key_exists('txtForgotPassSent', $value)) {
                        $value['txtForgotPassSent'] = 'Your password has been sent by email';
                        $value['txtForgotPassLink'] = 'Send me my password';
                    }

                    $wpdb->insert($table_name, $value);
                }
            }


            $table_name = $wpdb->prefix . "wpefc_steps";
            $wpdb->query("TRUNCATE TABLE $table_name");
            $prevPosX = 40;
            $firstStep = false;
            foreach ($dataJson['steps'] as $key => $value) {
                if (!array_key_exists('formID', $value)) {
                    $value['formID'] = 1;
                }
                if (!array_key_exists('showInSummary', $value)) {
                    $value['showInSummary'] = 1;
                }
                if (!array_key_exists('content', $value)) {
                    $start = 0;
                    if (!$firstStep && $value['ordersort'] == 0) {
                        $start = 1;
                        $value['start'] = 1;
                        $firstStep = true;
                    }
                    $value['content'] = '{"start":"' . $start . '","previewPosX":"' . $prevPosX . '","previewPosY":"140","actions":[],"id":' . $value['id'] . '}';
                    $prevPosX += 200;
                }
                $wpdb->insert($table_name, $value);
            }

            $table_name = $wpdb->prefix . "wpefc_fields";
            $wpdb->query("TRUNCATE TABLE $table_name");
            if (array_key_exists('fields', $dataJson)) {
                foreach ($dataJson['fields'] as $key => $value) {
                    if (!array_key_exists('validation', $value) && $value['id'] == '1') {
                        $value['validation'] = 'email';
                    }
                    if (array_key_exists('height', $value)) {
                        unset($value['height']);
                    }
                    $wpdb->insert($table_name, $value);
                }
            }

            $table_name = $wpdb->prefix . "wpefc_links";
            $wpdb->query("TRUNCATE TABLE $table_name");
            if (array_key_exists('links', $dataJson)) {
                foreach ($dataJson['links'] as $key => $value) {
                    $wpdb->insert($table_name, $value);
                }
            }

            $table_name = $wpdb->prefix . "wpefc_logs";
            $wpdb->query("TRUNCATE TABLE $table_name");
            if (array_key_exists('logs', $dataJson)) {
                foreach ($dataJson['logs'] as $key => $value) {
                    $wpdb->insert($table_name, $value);
                }
            }


            $table_name = $wpdb->prefix . "wpefc_coupons";
            $wpdb->query("TRUNCATE TABLE $table_name");
            if (array_key_exists('coupons', $dataJson)) {
                foreach ($dataJson['coupons'] as $key => $value) {
                    $wpdb->insert($table_name, $value);
                }
            }

            $table_name = $wpdb->prefix . "wpefc_redirConditions";
            $wpdb->query("TRUNCATE TABLE $table_name");
            if (array_key_exists('redirections', $dataJson)) {
                foreach ($dataJson['redirections'] as $key => $value) {
                    $wpdb->insert($table_name, $value);
                }
            }



            // Check links
            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = $wpdb->get_results("SELECT * FROM $table_name");
            foreach ($forms as $form) {
                $table_name = $wpdb->prefix . "wpefc_links";
                $links = $wpdb->get_results("SELECT * FROM $table_name WHERE formID=" . $form->id);
                if (count($links) == 0) {

                    $stepStartID = 0;
                    $stepStart = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wpefc_steps WHERE start=1 AND formID=" . $form->id);
                    if (count($stepStart) > 0) {
                        $stepStart = $stepStart[0];
                        $stepStartID = $stepStart->id;
                    }
                    $steps = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wpefc_steps WHERE formID=" . $form->id . " AND start=0 ORDER BY ordersort ASC, id ASC");
                    $i = 0;
                    $prevStepID = 0;
                    foreach ($steps as $step) {
                        if ($i == 0 && $stepStartID > 0) {
                            $wpdb->insert($wpdb->prefix . "wpefc_links", array('originID' => $stepStartID, 'destinationID' => $step->id, 'formID' => $form->id, 'conditions' => '[]'));
                        } else if ($i > 0 && $prevStepID > 0) {
                            $wpdb->insert($wpdb->prefix . "wpefc_links", array('originID' => $prevStepID, 'destinationID' => $step->id, 'formID' => $form->id, 'conditions' => '[]'));
                        }
                        $prevStepID = $step->id;
                        $i++;
                    }
                }
            }



            $table_name = $wpdb->prefix . "wpefc_items";
            $wpdb->query("TRUNCATE TABLE $table_name");
            foreach ($dataJson['items'] as $key => $value) {

                if ($value['image'] && $value['image'] != "") {
                    $img_name = substr($value['image'], strrpos($value['image'], '/') + 1);
                    $imagePath = substr($value['image'], 0, strrpos($value['image'], '/'));
                    if (!file_exists(site_url() . '/' . $value['image'])) {
                        if (!is_dir($imagePath)) {
                            $imagePath = wp_upload_dir();
                            // mkdir($imagePath, 0747, true);
                        }
                        if (strrpos($value['image'], "uploads") === false) {
                            $value['image'] = 'uploads' . $value['image'];
                        }
                        if (is_file(plugin_dir_path(__FILE__) . '../tmp/' . $img_name)) {
                            copy(plugin_dir_path(__FILE__) . '../tmp/' . $img_name, $imagePath['basedir'] . $imagePath['subdir'] . '/' . $img_name);
                        }
                    }
                    $value['image'] = $imagePath['url'] . '/' . $img_name;
                }
                if (array_key_exists('reduc_qt', $value)) {
                    unset($value['reduc_qt']);
                    unset($value['reduc_value']);
                }

                $wpdb->insert($table_name, $value);
            }


            // check if form exists
            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = $wpdb->get_results("SELECT * FROM $table_name LIMIT 1");
            if (!$forms || count($forms) == 0) {
                $formsData['title'] = 'My Estimation Form';
                $wpdb->insert($table_name, $formsData);
            }

            $files = glob(plugin_dir_path(__FILE__) . '../tmp/*');
            foreach ($files as $file) {
                if (is_file($file))
                    unlink($file);
            }
        }
    }

    public function saveCalendarEvent() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $settings = $this->getSettings();
            $calendarID = sanitize_text_field($_POST['calendarID']);
            $eventID = sanitize_text_field($_POST['eventID']);
            $title = sanitize_text_field($_POST['title']);
            $start = sanitize_text_field($_POST['start']);
            $end = sanitize_text_field($_POST['end']);
            $fullDay = sanitize_text_field($_POST['allDay']);
            $orderID = sanitize_text_field($_POST['orderID']);
            $customerAddress = sanitize_text_field($_POST['customerAddress']);
            $customerEmail = sanitize_text_field($_POST['customerEmail']);
            $categoryID = sanitize_text_field($_POST['categoryID']);
            $isBusy = sanitize_text_field($_POST['isBusy']);
            $notes = sanitize_text_field($_POST['notes']);

            $table_name = $wpdb->prefix . "wpefc_calendarEvents";
            $data = array(
                'calendarID' => $calendarID,
                'title' => $title,
                'fullDay' => $fullDay,
                'startDate' => $start,
                'orderID' => $orderID,
                'endDate' => $end,
                'customerAddress' => $this->parent->stringEncode($customerAddress, $settings->encryptDB),
                'customerEmail' => $this->parent->stringEncode($customerEmail, $settings->encryptDB),
                'categoryID' => $categoryID,
                'isBusy' => $isBusy,
                'notes' => $notes
            );
            if ($eventID > 0) {
                $wpdb->update($table_name, $data, array('id' => $eventID));
                echo $eventID;
            } else {
                $wpdb->insert($table_name, $data);
                $eventID = $wpdb->insert_id;

                $table_nameR = $wpdb->prefix . "wpefc_calendarReminders";
                $remindersData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameR WHERE eventID=0 AND calendarID=%s", $calendarID));
                foreach ($remindersData as $reminder) {
                    $reminder->eventID = $eventID;
                    unset($reminder->id);
                    $wpdb->insert($table_nameR, (array) $reminder);
                }
                echo $eventID;
            }
        }
        die();
    }

    public function getCalendarEvents() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $settings = $this->getSettings();

            $formID = sanitize_text_field($_POST['formID']);
            $calendarID = sanitize_text_field($_POST['calendarID']);

            $start = sanitize_text_field($_POST['start']);
            $end = sanitize_text_field($_POST['end']);

            $table_name = $wpdb->prefix . "wpefc_calendarEvents";
            $eventsData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE calendarID=%s", $calendarID));

            $rep = new stdClass();

            $rep->events = array();
            foreach ($eventsData as $value) {
                $eventObj = new stdClass();
                $eventObj->id = $value->id;
                $eventObj->start = $value->startDate;
                if ($value->fullDay == 0) {
                    $eventObj->end = $value->endDate;
                }
                $eventObj->title = $value->title;
                $eventObj->allDay = $value->fullDay;
                $eventObj->isBusy = $value->isBusy;
                $eventObj->orderID = $value->orderID;
                $eventObj->customerID = $value->customerID;
                $eventObj->reminders = array();
                $eventObj->customerEmail = $this->parent->stringDecode($value->customerEmail, $settings->encryptDB);
                $eventObj->customerAddress = $this->parent->stringDecode($value->customerAddress, $settings->encryptDB);
                $eventObj->categoryID = $value->categoryID;
                $eventObj->color = '#1abc9c';
                $eventObj->notes = $value->notes;

                $table_nameC = $wpdb->prefix . "wpefc_calendarCategories";
                $catData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameC WHERE id=%s LIMIT 1", $value->categoryID));
                if (count($catData) > 0) {
                    $catData = $catData[0];
                    $eventObj->color = $catData->color;
                }

                $table_nameR = $wpdb->prefix . "wpefc_calendarReminders";
                $remindersData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameR WHERE eventID=%s", $eventObj->id));

                foreach ($remindersData as $reminder) {
                    $eventObj->reminders[] = $reminder;
                }

                $rep->events[] = $eventObj;
            }
            $table_nameR = $wpdb->prefix . "wpefc_calendarReminders";
            $rep->reminders = array();
            $remindersData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameR WHERE eventID=0 AND calendarID=%s", $calendarID));
            if (count($remindersData) > 0) {
                $rep->reminders = $remindersData;
            }

            $table_nameC = $wpdb->prefix . "wpefc_calendarCategories";
            $rep->categories = array();
            $catsData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameC WHERE calendarID=%s", $calendarID));
            if (count($catsData) > 0) {
                $rep->categories = $catsData;
            }


            $table_nameCl = $wpdb->prefix . "wpefc_calendars";
            $calData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameCl WHERE id=%s LIMIT 1", $calendarID));
            $calData = $calData[0];
            if ($calData->unavailableDays != '') {
                $rep->daysWeek = explode(',', $calData->unavailableDays);
            } else {
                $rep->daysWeek = array();
            }
            if ($calData->unavailableHours != '') {
                $rep->disabledHours = explode(',', $calData->unavailableHours);
            } else {
                $rep->disabledHours = array();
            }



            $rep->orders = array();
            $table_name = $wpdb->prefix . "wpefc_logs";
            $logs = $wpdb->get_results("SELECT checked,id,dateLog,formID,ref,customerID FROM $table_name WHERE checked=1 ORDER BY dateLog DESC");
            if (count($logs) > 0) {
                foreach ($logs as $log) {
                    $table_nameF = $wpdb->prefix . "wpefc_forms";
                    $formData = $wpdb->get_results($wpdb->prepare("SELECT id,title FROM $table_nameF WHERE id=%s LIMIT 1", $log->formID));
                    if (count($formData) > 0) {
                        $formData = $formData[0];
                        $logObj = new stdClass();
                        $logObj->id = $log->id;
                        $logObj->customerID = $log->customerID;
                        $logObj->title = $formData->title . ' : ' . $log->ref;
                        $rep->orders[] = $logObj;
                    }
                }
            }
            echo json_encode($rep);
        }
        die();
    }

    public function updateCalendarEvent() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);
            $calendarID = sanitize_text_field($_POST['calendarID']);
            $eventID = sanitize_text_field($_POST['eventID']);
            $start = sanitize_text_field($_POST['start']);
            $end = sanitize_text_field($_POST['end']);
            echo $start;

            if ($eventID > 0) {
                $table_name = $wpdb->prefix . "wpefc_calendarEvents";
                $wpdb->update($table_name, array('startDate' => $start, 'endDate' => $end), array('id' => $eventID));
                echo $eventID;
            }
        }
        die();
    }

    public function deleteCalendarEvent() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $eventID = sanitize_text_field($_POST['eventID']);
            $table_name = $wpdb->prefix . "wpefc_calendarEvents";
            $wpdb->delete($table_name, array('id' => $eventID));
            $table_name = $wpdb->prefix . "wpefc_calendarReminders";
            $wpdb->delete($table_name, array('eventID' => $eventID));
        }
        die();
    }

    public function saveCalendar() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $calendarID = sanitize_text_field($_POST['calendarID']);
            $title = sanitize_text_field($_POST['title']);
            $table_name = $wpdb->prefix . "wpefc_calendars";
            if ($calendarID > 0) {
                $wpdb->update($table_name, array('title' => $title), array('id' => $calendarID));
                echo $calendarID;
            } else {
                $wpdb->insert($table_name, array('title' => $title));
                $calendarID = $wpdb->insert_id;
                echo $calendarID;

                $table_name = $wpdb->prefix . "wpefc_calendarCategories";
                $rows_affected = $wpdb->insert($table_name, array('title' => 'Default', 'calendarID' => $calendarID, 'color' => '#1abc9c'));
            }
        }
        die();
    }

    public function deleteCalendar() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $calendarID = sanitize_text_field($_POST['calendarID']);
            if ($calendarID > 1) {
                $table_name = $wpdb->prefix . "wpefc_calendars";
                $wpdb->delete($table_name, array('id' => $calendarID));

                $table_name = $wpdb->prefix . "wpefc_calendarEvents";
                $wpdb->delete($table_name, array('calendarID' => $calendarID));

                $table_name = $wpdb->prefix . "wpefc_calendarCategories";
                $wpdb->delete($table_name, array('calendarID' => $calendarID));

                $table_name = $wpdb->prefix . "wpefc_calendarReminders";
                $wpdb->delete($table_name, array('calendarID' => $calendarID));
            }
        }
        die();
    }

    public function saveCalendarReminder() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $data = array();

            $data['eventID'] = sanitize_text_field($_POST['eventID']);
            $data['calendarID'] = sanitize_text_field($_POST['calendarID']);
            $reminderID = sanitize_text_field($_POST['reminderID']);
            $data['delayValue'] = sanitize_text_field($_POST['delayValue']);
            $data['delayType'] = sanitize_text_field($_POST['delayType']);
            $data['title'] = sanitize_text_field($_POST['title']);
            $data['content'] = stripslashes($_POST['content']);
            $data['email'] = sanitize_text_field($_POST['email']);
            $data['isSent'] = 0;

            $table_name = $wpdb->prefix . "wpefc_calendarReminders";
            if ($reminderID > 0) {
                $wpdb->update($table_name, $data, array('id' => $reminderID));
                echo $reminderID;
            } else {
                $wpdb->insert($table_name, $data);
                echo $wpdb->insert_id;
            }
        }
        die();
    }

    public function deleteCalendarReminder() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $reminderID = sanitize_text_field($_POST['reminderID']);
            $table_name = $wpdb->prefix . "wpefc_calendarReminders";
            $wpdb->delete($table_name, array('id' => $reminderID));
        }
        die();
    }

    public function saveCalendarCat() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $catID = sanitize_text_field($_POST['catID']);
            $data = array();
            $data['title'] = sanitize_text_field($_POST['title']);
            $data['color'] = sanitize_text_field($_POST['color']);
            $data['calendarID'] = sanitize_text_field($_POST['calendarID']);
            $table_name = $wpdb->prefix . "wpefc_calendarCategories";

            if ($catID > 0) {
                $wpdb->update($table_name, $data, array('id' => $catID));
                echo $catID;
            } else {
                $wpdb->insert($table_name, $data);
                echo $wpdb->insert_id;
            }
        }
        die();
    }

    public function deleteCalendarCat() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $catID = sanitize_text_field($_POST['catID']);
            $table_name = $wpdb->prefix . "wpefc_calendarCategories";
            $wpdb->delete($table_name, array('id' => $catID));

            $table_name = $wpdb->prefix . "wpefc_calendarEvents";
            $eventsData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE categoryID=%s", $catID));
            foreach ($eventsData as $eventData) {
                $wpdb->update($table_name, array('categoryID', 1), array('id' => $eventData->id));
            }

            $table_name = $wpdb->prefix . "wpefc_items";
            $itemsData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE eventCategoryID=%s", $catID));
            foreach ($itemsData as $itemData) {
                $wpdb->update($table_name, array('eventCategoryID', 1), array('id' => $itemData->id));
            }
        }

        die();
    }

    public function saveCalendarHoursDisabled() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $calendarID = sanitize_text_field($_POST['calendarID']);
            $hours = sanitize_text_field($_POST['hours']);

            $table_name = $wpdb->prefix . "wpefc_calendars";
            $wpdb->update($table_name, array('unavailableHours' => $hours), array('id' => $calendarID));
        }
        die();
    }

    public function saveCalendarDaysWeek() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $calendarID = sanitize_text_field($_POST['calendarID']);
            $days = sanitize_text_field($_POST['days']);

            $table_name = $wpdb->prefix . "wpefc_calendars";
            $wpdb->update($table_name, array('unavailableDays' => $days), array('id' => $calendarID));
        }
        die();
    }

    public function getCalendarCategories() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $calendarID = sanitize_text_field($_POST['calendarID']);

            $table_name = $wpdb->prefix . "wpefc_calendarCategories";
            $catsData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE calendarID=%s ORDER BY title ASC", $calendarID));

            $rep = array();
            if (count($catsData) > 0) {
                $rep = $catsData;
            }
            echo json_encode($rep);
        }
        die();
    }

    public function saveCustomerDataSettings() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_settings";
            $sqlDatas = array();
            foreach ($_POST as $key => $value) {
                if ($key != 'action' && $key != 'id' && $key != 'pll_ajax_backend' && $key != "undefined" && $key != "formID" && $key != "files" && $key != 'ip-geo-block-auth-nonce' && $key != "client_action" && $key != "purchaseCode" && $key != "layers") {
                    $sqlDatas[$key] = stripslashes($value);
                }
            }
            $wpdb->update($table_name, $sqlDatas, array('id' => 1));
        }
        die();
    }

    public function wpb_sender_name($name) {
        global $wpdb;
        global $_currentFormID;
        if ($_currentFormID > 0) {
            $table_name = $wpdb->prefix . "wpefc_forms";
            $rows = $wpdb->get_results("SELECT id,email_name FROM $table_name WHERE id=$_currentFormID LIMIT 1");
            $form = $rows[0];
            return $form->email_name;
        } else {
            return $name;
        }
    }

    public function wpb_sender_email($name) {
        global $wpdb;
        global $_currentFormID;
        global $_currentOrderID;
        $settings = $this->getSettings();

        $chkMail = false;

        if ($_currentOrderID > 0) {
            $table_name = $wpdb->prefix . "wpefc_logs";
            $rows = $wpdb->get_results("SELECT id,email FROM $table_name WHERE id=$_currentOrderID LIMIT 1");
            if (count($rows) > 0) {
                $order = $rows[0];
                if ($order->email != '') {
                    $chkMail = true;
                    $email = $this->parent->stringDecode($order->email, $settings->encryptDB);
                    return $email;
                }
            }
        }
        if (!$chkMail && $_currentFormID > 0) {
            $table_name = $wpdb->prefix . "wpefc_forms";
            $rows = $wpdb->get_results("SELECT id,email FROM $table_name WHERE id=$_currentFormID LIMIT 1");
            $form = $rows[0];
            $email = $form->email;
            if (strpos($email, ',') !== false) {
                $emails = explode(',', $email);
                $email = $emails[0];
            }
            return $email;
        } else {
            return $name;
        }
    }

    public function getWooProductTitle() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $productID = sanitize_text_field($_POST['productID']);
            $targetPost = get_post($productID);
            if ($targetPost && $targetPost !== null) {
                echo $targetPost->post_title;
            }
        }
        die();
    }

    public function getWooProductsByTerm() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $searched = sanitize_text_field($_POST['term']);
            $rep = array();

            if (is_plugin_active('woocommerce/woocommerce.php')) {

                $search_query = 'SELECT ID FROM ' . $wpdb->prefix . 'posts
                  WHERE post_type = "product"
                  AND post_title LIKE %s';

                $like = '%' . $searched . '%';
                $results = $wpdb->get_results($wpdb->prepare($search_query, $like), ARRAY_N);
                foreach ($results as $key => $array) {
                    $quote_ids[] = $array[0];
                }

                $products = get_posts(array('post_type' => 'product', 'orderby' => 'category', 'order' => 'ASC', 'post__in' => $quote_ids, 'posts_per_page' => 200));

                foreach ($products as $productI) {

                    $product = wc_get_product($productI->ID);
                    $cat = '';
                    $cats = wc_get_product_category_list(',');
                    $cats = explode(',', $cats);
                    foreach ($cats as $catI) {
                        $cat = $cat . $catI . ' > ';
                    }
                    $sel = '';
                    $dataMax = '';
                    $dataImg = '';
                    if ($product->is_type('simple') || $product->is_type('subscription')) {
                        if ($product->get_stock_quantity() && $product->get_stock_quantity() > 0) {
                            if ($product->get_stock_quantity() > 5) {
                                $dataMax = 'data-max="5"';
                            } else {
                                $dataMax = 'data-max="' . $product->get_stock_quantity() . '"';
                            }
                        }
                        // check image
                        $img = '';
                        $argsI = array('post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $productI->ID);
                        $attachments = get_posts($argsI);
                        if (count($attachments) > 0) {
                            $imgDom = wp_get_attachment_image($attachments[count($attachments) - 1]->ID, 'thumbnail');
                            $img = substr($imgDom, strpos($imgDom, 'src="') + 5, strpos($imgDom, '"', stripos($imgDom, 'src="') + 6) - (strpos($imgDom, 'src="') + 5));

                            $dataImg = 'data-img="' . $img . '"';
                        }
                        if ($img == '') {
                            $img = $product->get_image(128);
                            if ($img != '' && strpos($img, 'src') !== FALSE) {
                                $img = substr($img, strpos($img, 'src="') + 5, strpos($img, '"', stripos($img, 'src="') + 6) - (strpos($img, 'src="') + 5));

                                $dataImg = 'data-img="' . $img . '"';
                            }
                        }
                        $jsonObj = new stdClass();
                        $jsonObj->id = $productI->ID;
                        $jsonObj->label = $cat . $productI->post_title;
                        $jsonObj->value = $jsonObj->label;
                        $jsonObj->price = $product->get_price();
                        $jsonObj->type = $product->get_type();
                        $jsonObj->max = $product->get_stock_quantity();
                        $jsonObj->image = $img;
                        $jsonObj->woovariation = 0;
                        $rep[] = $jsonObj;
                    } else if ($product->is_type('variable') || $product->is_type('variable-subscription')) {
                        $available_variations = $product->get_available_variations();
                        $price = 5;
                        foreach ($available_variations as $variation) {
                            $variable_product = new WC_Product_Variation($variation['variation_id']);
                            if ($variable_product->get_stock_quantity() && $variable_product->get_stock_quantity() > 0) {
                                if ($variable_product->get_stock_quantity() > 5) {
                                    $dataMax = 'data-max="5"';
                                } else {
                                    $dataMax = 'data-max="' . $variable_product->get_stock_quantity() . '"';
                                }
                            }
                            $price = $variable_product->get_price();
                            // check image
                            $argsI = array('post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $productI->ID);
                            $attachments = get_posts($argsI);
                            $img = '';
                            if (count($attachments) > 0 && $attachments[0]) {
                                $imgDom = wp_get_attachment_image($attachments[count($attachments) - 1]->ID, 'thumbnail');
                                $img = substr($imgDom, strpos($imgDom, 'src="') + 5, strpos($imgDom, '"', stripos($imgDom, 'src="') + 6) - (strpos($imgDom, 'src="') + 5));

                                $dataImg = 'data-img="' . $img . '"';
                            }
                            $jsonObj = new stdClass();
                            $jsonObj->id = $productI->ID;
                            //  $jsonObj->value = $productI->ID;
                            $jsonObj->label = $cat . $productI->post_title . ' - ' . $variation['sku'];
                            $jsonObj->value = $jsonObj->label;
                            $jsonObj->price = $price;
                            $jsonObj->type = $product->get_type();
                            $jsonObj->max = $product->get_stock_quantity();
                            $jsonObj->image = $img;
                            $jsonObj->woovariation = $variation['variation_id'];

                            $rep[] = $jsonObj;
                        }
                    }
                }
            }
            echo json_encode($rep);
            die();
        }
    }

    public function addNewVariable() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $formID = sanitize_text_field($_POST['formID']);

            $table_name = $wpdb->prefix . "wpefc_variables";
            $wpdb->insert($table_name, array(
                'title' => __('My Variable', 'lfb'),
                'formID' => $formID,
                'type' => 'integer',
                'defaultValue' => 0
            ));
            echo $wpdb->insert_id;
        }
        die();
    }

    public function deleteVariable() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $variableID = sanitize_text_field($_POST['variableID']);
            $table_name = $wpdb->prefix . "wpefc_variables";
            $wpdb->query("DELETE FROM $table_name WHERE id=" . $variableID);
        }
        die();
    }

    public function deleteCustomer() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $customerID = sanitize_text_field($_POST['customerID']);
            $table_name = $wpdb->prefix . "wpefc_customers";
            $wpdb->query("DELETE FROM $table_name WHERE id=" . $customerID);

            $table_name = $wpdb->prefix . "wpefc_logs";
            $wpdb->query("DELETE FROM $table_name WHERE customerID=" . $customerID);
        }
        die();
    }

    public function getCustomersList() {
        global $wpdb;
        $settings = $this->getSettings();
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_customers";
            $customers = $wpdb->get_results("SELECT id,firstName,lastName,email,inscriptionDate,phone,company FROM $table_name ORDER BY id DESC");
            foreach ($customers as $customer) {
                $customer->firstName = $this->parent->stringDecode($customer->firstName, $settings->encryptDB);
                $customer->company = $this->parent->stringDecode($customer->company, $settings->encryptDB);
                $customer->lastName = $this->parent->stringDecode($customer->lastName, $settings->encryptDB);
                $customer->email = $this->parent->stringDecode($customer->email, $settings->encryptDB);
                $customer->phone = $this->parent->stringDecode($customer->phone, $settings->encryptDB);
                $customer->address = $this->parent->stringDecode($customer->address, $settings->encryptDB);
                $customer->phoneJob = $this->parent->stringDecode($customer->phoneJob, $settings->encryptDB);
                $customer->job = $this->parent->stringDecode($customer->job, $settings->encryptDB);
                $customer->url = $this->parent->stringDecode($customer->url, $settings->encryptDB);
                $customer->zip = $this->parent->stringDecode($customer->zip, $settings->encryptDB);
                $customer->city = $this->parent->stringDecode($customer->city, $settings->encryptDB);
                $customer->country = $this->parent->stringDecode($customer->country, $settings->encryptDB);
                $customer->state = $this->parent->stringDecode($customer->state, $settings->encryptDB);
                $customer->inscriptionDate = date(get_option('date_format'), strtotime($customer->inscriptionDate));
                $customer->lastOrderDate = '';

                $table_nameLogs = $wpdb->prefix . "wpefc_logs";
                $orders = $wpdb->get_results("SELECT dateLog,customerID,checked FROM $table_nameLogs WHERE checked=1 AND customerID=" . $customer->id . " LIMIT 1");
                if (count($orders) > 0) {
                    $customer->lastOrderDate = date(get_option('date_format'), strtotime($orders[0]->dateLog));
                }
            }
            echo json_encode((array) $customers);
        }
        die();
    }

    public function getCustomerDetails() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $settings = $this->getSettings();
            $customerID = sanitize_text_field($_POST['customerID']);
            $table_name = $wpdb->prefix . "wpefc_customers";
            $customers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $customerID));
            if (count($customers) > 0) {
                $customer = $customers[0];
                unset($customer->password);
                $customer->firstName = $this->parent->stringDecode($customer->firstName, $settings->encryptDB);
                $customer->lastName = $this->parent->stringDecode($customer->lastName, $settings->encryptDB);
                $customer->email = $this->parent->stringDecode($customer->email, $settings->encryptDB);
                $customer->phone = $this->parent->stringDecode($customer->phone, $settings->encryptDB);
                $customer->zip = $this->parent->stringDecode($customer->zip, $settings->encryptDB);
                $customer->city = $this->parent->stringDecode($customer->city, $settings->encryptDB);
                $customer->country = $this->parent->stringDecode($customer->country, $settings->encryptDB);
                $customer->state = $this->parent->stringDecode($customer->state, $settings->encryptDB);
                $customer->phoneJob = $this->parent->stringDecode($customer->phoneJob, $settings->encryptDB);
                $customer->url = $this->parent->stringDecode($customer->url, $settings->encryptDB);
                $customer->company = $this->parent->stringDecode($customer->company, $settings->encryptDB);
                $customer->address = $this->parent->stringDecode($customer->address, $settings->encryptDB);

                $customer->inscriptionDate = date(get_option('date_format'), strtotime($customer->inscriptionDate));

                $customer->orders = array();

                $table_nameLogs = $wpdb->prefix . "wpefc_logs";
                $orders = $wpdb->get_results("SELECT id,ref,dateLog,totalPrice,totalSubscription,paid,status,formID,currency,currencyPosition,thousandsSeparator,decimalsSeparator,millionSeparator,billionsSeparator,customerID,checked FROM $table_nameLogs WHERE checked=1 AND customerID=" . $customer->id);
                foreach ($orders as $order) {
                    $order->dateLog = date(get_option('date_format'), strtotime($order->dateLog));

                    $statusText = '';
                    if ($order->status == 'pending') {
                        $statusText = __('Pending', 'lfb');
                    } else if ($order->status == 'canceled') {
                        $statusText = __('Canceled', 'lfb');
                    } else if ($order->status == 'beingProcessed') {
                        $statusText = __('Being processed', 'lfb');
                    } else if ($order->status == 'shipped') {
                        $statusText = __('Shipped', 'lfb');
                    } else if ($order->status == 'completed') {
                        $statusText = __('Completed', 'lfb');
                    }
                    $order->statusText = $statusText;
                    $customer->orders[] = $order;
                }


                echo json_encode($customer);
            }
        }
        die();
    }

    public function saveVariable() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $variableID = sanitize_text_field($_POST['variableID']);
            $title = sanitize_text_field($_POST['title']);
            $type = sanitize_text_field($_POST['type']);
            $defaultValue = sanitize_text_field($_POST['defaultValue']);

            $table_name = $wpdb->prefix . "wpefc_variables";
            $wpdb->update($table_name, array(
                'title' => $title,
                'type' => $type,
                'defaultValue' => $defaultValue
                    ), array('id' => $variableID));
        }
        die();
    }

    public function saveCustomer() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $settings = $this->getSettings();
            $customerID = sanitize_text_field($_POST['customerID']);
            $firstName = $this->parent->stringEncode(sanitize_text_field($_POST['firstName']), $settings->encryptDB);
            $lastName = $this->parent->stringEncode(sanitize_text_field($_POST['lastName']), $settings->encryptDB);
            $phone = $this->parent->stringEncode(sanitize_text_field($_POST['phone']), $settings->encryptDB);
            $phoneJob = $this->parent->stringEncode(sanitize_text_field($_POST['phoneJob']), $settings->encryptDB);
            $job = $this->parent->stringEncode(sanitize_text_field($_POST['job']), $settings->encryptDB);
            $company = $this->parent->stringEncode(sanitize_text_field($_POST['company']), $settings->encryptDB);
            $zip = $this->parent->stringEncode(sanitize_text_field($_POST['zip']), $settings->encryptDB);
            $state = $this->parent->stringEncode(sanitize_text_field($_POST['state']), $settings->encryptDB);
            $country = $this->parent->stringEncode(sanitize_text_field($_POST['country']), $settings->encryptDB);
            $city = $this->parent->stringEncode(sanitize_text_field($_POST['city']), $settings->encryptDB);
            $address = $this->parent->stringEncode(sanitize_text_field($_POST['address']), $settings->encryptDB);
            $url = $this->parent->stringEncode(sanitize_text_field($_POST['url']), $settings->encryptDB);
            $email = $this->parent->stringEncode(sanitize_text_field($_POST['email']), $settings->encryptDB);


            $table_name = $wpdb->prefix . "wpefc_customers";

            $sqlData = array(
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'phoneJob' => $phoneJob,
                'job' => $job,
                'company' => $company,
                'zip' => $zip,
                'country' => $country,
                'city' => $city,
                'address' => $address,
                'url' => $url,
                'state' => $state,
            );
            // print_r($sqlData);
            if ($customerID > 0) {
                $wpdb->update($table_name, $sqlData, array('id' => $customerID));
            } else {
                $sqlData['password'] = $this->parent->stringEncode($this->parent->generatePassword(), true);
                $sqlData['inscriptionDate'] = date('Y-m-d');
                $wpdb->insert($table_name, $sqlData);
            }
        }
        die();
    }

    public function saveGlobalSettings() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $table_name = $wpdb->prefix . "wpefc_settings";
            $settings = $wpdb->get_results("SELECT id,encryptDB FROM $table_name WHERE id=1 LIMIT 1");
            $settings = $settings[0];
            if ($settings->encryptDB == 0 && $_POST['encryptDB'] == 1) {
                $table_nameL = $wpdb->prefix . "wpefc_logs";
                $logs = $wpdb->get_results("SELECT * FROM $table_nameL ORDER BY id ASC");
                foreach ($logs as $log) {
                    $log->email = $this->parent->stringEncode($log->email, true);
                    $log->phone = $this->parent->stringEncode($log->phone, true);
                    $log->firstName = $this->parent->stringEncode($log->firstName, true);
                    $log->lastName = $this->parent->stringEncode($log->lastName, true);
                    $log->address = $this->parent->stringEncode($log->address, true);
                    $log->city = $this->parent->stringEncode($log->city, true);
                    $log->country = $this->parent->stringEncode($log->country, true);
                    $log->state = $this->parent->stringEncode($log->state, true);
                    $log->zip = $this->parent->stringEncode($log->zip, true);
                    $log->pdfContent = $this->parent->stringEncode($log->pdfContent, true);
                    $log->pdfContentUser = $this->parent->stringEncode($log->pdfContentUser, true);
                    $log->contentTxt = $this->parent->stringEncode($log->contentTxt, true);
                    $log->content = $this->parent->stringEncode($log->content, true);
                    $log->contentUser = $this->parent->stringEncode($log->contentUser, true);
                    $wpdb->update($table_nameL, (array) $log, array('id' => $log->id));
                }

                $table_nameR = $wpdb->prefix . "wpefc_calendarEvents";
                $calEvents = $wpdb->get_results("SELECT * FROM $table_nameR ORDER BY id ASC");
                foreach ($calEvents as $calEvent) {
                    $calEvent->customerEmail = $this->parent->stringEncode($calEvent->customerEmail, true);
                    $calEvent->customerAddress = $this->parent->stringEncode($calEvent->customerAddress, true);
                    $wpdb->update($table_nameR, (array) $calEvent, array('id' => $calEvent->id));
                }
                $table_nameC = $wpdb->prefix . "wpefc_customers";
                $customers = $wpdb->get_results("SELECT * FROM $table_nameC ORDER BY id ASC");
                foreach ($customers as $customer) {
                    $customer->email = $this->parent->stringEncode($customer->email, true);
                    $customer->firstName = $this->parent->stringEncode($customer->firstName, true);
                    $customer->lastName = $this->parent->stringEncode($customer->lastName, true);
                    $customer->company = $this->parent->stringEncode($customer->company, true);
                    $customer->job = $this->parent->stringEncode($customer->job, true);
                    $customer->phone = $this->parent->stringEncode($customer->phone, true);
                    $customer->phoneJob = $this->parent->stringEncode($customer->phoneJob, true);
                    $customer->url = $this->parent->stringEncode($customer->url, true);
                    $customer->address = $this->parent->stringEncode($customer->address, true);
                    $customer->zip = $this->parent->stringEncode($customer->zip, true);
                    $customer->city = $this->parent->stringEncode($customer->city, true);
                    $customer->country = $this->parent->stringEncode($customer->country, true);
                    $customer->state = $this->parent->stringEncode($customer->state, true);
                    $wpdb->update($table_nameC, (array) $customer, array('id' => $customer->id));
                }
            } else if ($settings->encryptDB == 1 && $_POST['encryptDB'] == 0) {
                $table_nameL = $wpdb->prefix . "wpefc_logs";
                $logs = $wpdb->get_results("SELECT * FROM $table_nameL ORDER BY id ASC");
                foreach ($logs as $log) {
                    $log->email = $this->parent->stringDecode($log->email, true);
                    $log->phone = $this->parent->stringDecode($log->phone, true);
                    $log->firstName = $this->parent->stringDecode($log->firstName, true);
                    $log->lastName = $this->parent->stringDecode($log->lastName, true);
                    $log->address = $this->parent->stringDecode($log->address, true);
                    $log->city = $this->parent->stringDecode($log->city, true);
                    $log->country = $this->parent->stringDecode($log->country, true);
                    $log->state = $this->parent->stringDecode($log->state, true);
                    $log->zip = $this->parent->stringDecode($log->zip, true);
                    $log->pdfContent = $this->parent->stringDecode($log->pdfContent, true);
                    $log->pdfContentUser = $this->parent->stringDecode($log->pdfContentUser, true);
                    $log->contentTxt = $this->parent->stringDecode($log->contentTxt, true);
                    $log->content = $this->parent->stringDecode($log->content, true);
                    $log->contentUser = $this->parent->stringDecode($log->contentUser, true);

                    $wpdb->update($table_nameL, (array) $log, array('id' => $log->id));
                }

                $table_nameR = $wpdb->prefix . "wpefc_calendarEvents";
                $calEvents = $wpdb->get_results("SELECT * FROM $table_nameR ORDER BY id ASC");
                foreach ($calEvents as $calEvent) {
                    $calEvent->customerEmail = $this->parent->stringDecode($calEvent->customerEmail, true);
                    $calEvent->customerAddress = $this->parent->stringDecode($calEvent->customerAddress, true);
                    $wpdb->update($table_nameR, (array) $calEvent, array('id' => $calEvent->id));
                }
                $table_nameC = $wpdb->prefix . "wpefc_customers";
                $customers = $wpdb->get_results("SELECT * FROM $table_nameC ORDER BY id ASC");
                foreach ($customers as $customer) {
                    $customer->email = $this->parent->stringDecode($customer->email, true);
                    $customer->firstName = $this->parent->stringDecode($customer->firstName, true);
                    $customer->lastName = $this->parent->stringDecode($customer->lastName, true);
                    $customer->company = $this->parent->stringDecode($customer->company, true);
                    $customer->job = $this->parent->stringDecode($customer->job, true);
                    $customer->phone = $this->parent->stringDecode($customer->phone, true);
                    $customer->phoneJob = $this->parent->stringDecode($customer->phoneJob, true);
                    $customer->url = $this->parent->stringDecode($customer->url, true);
                    $customer->address = $this->parent->stringDecode($customer->address, true);
                    $customer->zip = $this->parent->stringDecode($customer->zip, true);
                    $customer->city = $this->parent->stringDecode($customer->city, true);
                    $customer->country = $this->parent->stringDecode($customer->country, true);
                    $customer->state = $this->parent->stringDecode($customer->state, true);
                    $wpdb->update($table_nameC, (array) $customer, array('id' => $customer->id));
                }
            }
            $sqlDatas = array();
            foreach ($_POST as $key => $value) {
                if ($key != 'action' && $key != 'id' && $key != 'pll_ajax_backend' && $key != "undefined" && $key != "formID" && $key != "files" && $key != 'ip-geo-block-auth-nonce' && $key != "client_action" && $key != "purchaseCode" && $key != "layers" && $key != "defaultStepID") {
                    if ($key == 'smtp_password') {
                        $value = $this->parent->stringEncode($value, true);
                    }
                    $sqlDatas[$key] = stripslashes($value);
                }
            }
            $wpdb->update($table_name, $sqlDatas, array('id' => 1));
        }
        die();
    }

    public function testSMTP() {
        if (current_user_can('manage_options')) {
            $adminEmail = sanitize_text_field($_POST['email']);
            $senderName = sanitize_text_field($_POST['senderName']);
            $settings = $this->getSettings();

            if (version_compare(PHP_VERSION, '7.2.0') >= 0) {
                add_filter('wp_mail_content_type', function() {
                    return "text/html";
                });
                if ($settings->senderName != "") {
                    add_filter('wp_mail_from_name', function() {
                        return $this->getSettings()->senderName;
                    });
                }

                if ($settings->adminEmail != "") {
                    add_filter('wp_mail_from', function() {
                        return $this->getSettings()->adminEmail;
                    });
                }
            } else {
                add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                if ($settings->senderName != "") {
                    add_filter('wp_mail_from_name', create_function('', 'return "' . $this->getSettings()->senderName . '"; '));
                }
                if ($settings->adminEmail != "") {
                    add_filter('wp_mail_from', create_function('', 'return "' . $this->getSettings()->adminEmail . '"; '));
                }
            }

            if (wp_mail($adminEmail, __('A simple test email', 'lfb'), __('This is a test email sent by SMTP from E&P Forms Builder', 'lfb'))) {
                echo '1|' . __('The message was correctly sent', 'lfb');
            } else {
                echo '0|' . __('The message can not be sent', 'lfb');
            }
        }
        die();
    }

    private function renderStepVisualBuilder() {

        $html = '<div id="lfb_winEditStepVisual" class="lfb_window container-fluid" >
                <div class="lfb_winHeader col-md-12 palette palette-turquoise">
                <span class="glyphicon glyphicon-pencil"></span>' . __('Edit a step', 'lfb');
        $html .= '<div class="btn-toolbar">';
        $html .= '<div class="btn-group">';
        $html .= '<a class="btn btn-primary" href="javascript:" data-action="closeEditStep"><span class="glyphicon glyphicon-remove lfb_btnWinClose"></span></a>';
        $html .= '</div>';
        $html .= '</div>'; // eof toolbar
        $html .= '  </div>';

        $html .= '<div class="lfb_lPanelMenu">
                <div class="lfb_alignLeft">
                <a href="javascript:"  data-toggle="tooltip" title="' . __('Add a component', 'lfb') . '" data-placement="right" data-action="openComponents" class="btn btn-primary btn-circle"><span class="fas fa-plus"></span></a>
                <a href="javascript:"  data-toggle="tooltip" title="' . __('Step settings', 'lfb') . '" data-placement="right" data-action="openStepSettings" class="btn btn-primary btn-circle"><span class="fas fa-cogs"></span></a>

                </div>
                <div class="lfb_alignRight">
                
                
                    <div class="form-group" >
                        <label> ' . __('Max width', 'lfb') . ': </label >
                        <div id="lfb_stepMaxWidth"></div>
                    </div>
                    <div class="form-group" >
                        <label> ' . __('Title', 'lfb') . ': </label >
                        <input data-toggle="tooltip" title="' . __('This is the step name', 'lfb') . '" data-placement="left" type="text" id="lfb_stepTitle" name="title" class="form-control" maxlength="120" />
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

              <div id="lfb_componentsPanel" class="lfb_lPanel lfb_lPanelLeft">
                <div class="lfb_lPanelHeader"><span class="fa fa-clock-o"></span><span id="lfb_lPanelHeaderTitle">' . __('Components', 'lfb') . '</span>
                    <a href="javascript:" id="lfb_lPanelHeaderCloseBtn" class="btn btn-default btn-circle btn-inverse"><span class="glyphicon glyphicon-remove"></span></a>
                </div>
                <div class="lfb_lPanelBody">
                
                    <div class="lfb_componentModel" data-component="row">
                        <div class="lfb_componentPreview">
                            <div class="lfb_row"></div>
                        </div>
                        <div class="lfb_componentTitle">' . __('Row', 'lfb') . '</div>
                    </div>
                    
                    <div class="lfb_componentModel" data-component="button">
                        <div class="lfb_componentPreview">
                            <a href="javascript:" class="btn btn-primary">' . __('Button', 'lfb') . '</a>
                        </div>
                        <div class="lfb_componentTitle">' . __('Button', 'lfb') . '</div>
                    </div>
                    
                    <div class="lfb_componentModel" data-component="checkbox">
                        <div class="lfb_componentPreview">
                             <input type="checkbox" data-switch="switch" />
                        </div>
                        <div class="lfb_componentTitle">' . __('Checkbox', 'lfb') . '</div>
                    </div>
                    
                    <div class="lfb_componentModel" data-component="checkbox">
                        <div class="lfb_componentPreview">
                            <div class="lfb_colorPreview "></div>
                        </div>
                        <div class="lfb_componentTitle">' . __('Color picker', 'lfb') . '</div>
                    </div>
                    
                </div>
              </div>
              
              <div class="lfb_lPanel lfb_lPanelMain">
                <div class="lfb_lPanelBody p-0">
                   <iframe id="lfb_stepFrame" src="about:blank" ></iframe>
                </div>
              </div>';
        $html .= '</div>';

        return $html;
    }

    public function changeOrderStatus() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $orderID = sanitize_text_field($_POST['orderID']);
            $status = sanitize_text_field($_POST['status']);

            $table_name = $wpdb->prefix . "wpefc_logs";
            $wpdb->update($table_name, array('status' => $status), array('id' => $orderID));
            die();
        }
    }

    public function toggleDarkMode() {
        global $wpdb;
        if (current_user_can('manage_options')) {
            $darkMode = sanitize_text_field($_POST['darkMode']);
            $table_name = $wpdb->prefix . "wpefc_settings";
            $wpdb->update($table_name, array('useDarkMode' => $darkMode), array('id' => 1));
        }
        die();
    }

    /**
     * Main Instance
     *
     *
     * @since 1.0.0
     * @static
     * @return Main instance
     */
    public
    static function instance($parent) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($parent);
        }
        return self::$_instance;
    }

    // End instance()

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone() {
        _doing_it_wrong(__FUNCTION__, '', $this->parent->_version);
    }

// End __clone()

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup() {
        _doing_it_wrong(__FUNCTION__, '', $this->parent->_version);
    }

// End __wakeup()
}
