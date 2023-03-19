<?php

if (!defined('ABSPATH'))
    exit;

class LFB_Core {

    /**
     * The single instance
     * @var    object
     * @access  private
     * @since    1.0.0
     */
    private static $_instance = null;

    /**
     * Settings class object
     * @var     object
     * @access  public
     * @since   1.0.0
     */
    public $settings = null;

    /**
     * The version number.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_version;

    /**
     * The token.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_token;

    /**
     * The main plugin file.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $file;

    /**
     * The main plugin directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $dir;

    /**
     * The plugin assets directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_dir;

    /**
     * The plugin assets URL.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_url;

    /**
     * Suffix for Javascripts.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $templates_url;

    /**
     * Suffix for Javascripts.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $script_suffix;

    /**
     * For menu instance
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $menu;

    /**
     * For template
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $plugin_slug;

    /*
     *  Current forms on page
     */
    public $currentForms;

    /*
     *  Is analytics loaded ?
     */
    public $checkAnalytics = false;

    /*
     *  Analytics ID
     */
    public $analyticsID = '';
    private $add_script;
    private $formToPayKey = "";
    private $formToPayID = 0;
    private $modeManageData = false;
    private $lfb_loginMan = 0;

    /**
     * Constructor function.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function __construct($file = '', $version = '1.6.0') {

        $this->_version = $version;
        $this->_token = 'lfb';
        $this->plugin_slug = 'lfb';
        $this->currentForms = array();
        $this->checkedSc = false;

        $this->file = $file;
        $this->dir = dirname($this->file);
        $this->assets_dir = trailingslashit($this->dir) . 'assets';
        $this->assets_url = esc_url(trailingslashit(plugins_url('/assets/', $this->file)));
        $this->tdgn_url = esc_url(trailingslashit(plugins_url('/includes/tdgn/', $this->file)));
        $this->templates_url = esc_url(trailingslashit(plugins_url('/templates/', $this->file)));
        $this->tmp_url = esc_url(trailingslashit(plugins_url('/export/', $this->file)));

        $this->chmodWrite = ( 0747 & ~ umask() );
        if (defined('FS_CHMOD_DIR')) {
            $this->chmodWrite = FS_CHMOD_DIR;
        }
        if ($this->chmodWrite == 0745) {
            $this->chmodWrite = 0755;
        }
        $upload_dir = wp_upload_dir();
        if (!is_dir($upload_dir['basedir'] . '/CostEstimationPayment')) {
            mkdir($upload_dir['basedir'] . '/CostEstimationPayment');
            chmod($upload_dir['basedir'] . '/CostEstimationPayment', $this->chmodWrite);
        }
        $this->uploads_dir = $upload_dir['basedir'] . '/CostEstimationPayment/';
        $this->uploads_url = $upload_dir['baseurl'] . '/CostEstimationPayment/';

        add_shortcode('estimation_form', array($this, 'wpt_shortcode'));
        add_action('wp_ajax_nopriv_lfb_cart_save', array($this, 'cart_save'));
        add_action('wp_ajax_lfb_cart_save', array($this, 'cart_save'));
        add_action('wp_ajax_nopriv_lfb_cartdd_save', array($this, 'cartdd_save'));
        add_action('wp_ajax_lfb_cartdd_save', array($this, 'cartdd_save'));
        add_action('wp_ajax_nopriv_send_email', array($this, 'send_email'));
        add_action('wp_ajax_send_email', array($this, 'send_email'));
        add_action('wp_ajax_nopriv_get_currentRef', array($this, 'get_currentRef'));
        add_action('wp_ajax_get_currentRef', array($this, 'get_currentRef'));
        add_action('wp_ajax_nopriv_lfb_upload_form', array($this, 'uploadFormFiles'));
        add_action('wp_ajax_lfb_upload_form', array($this, 'uploadFormFiles'));
        add_action('wp_ajax_nopriv_lfb_sendCt', array($this, 'sendContact'));
        add_action('wp_ajax_lfb_sendCt', array($this, 'sendContact'));
        add_action('wp_ajax_nopriv_lfb_applyCouponCode', array($this, 'applyCouponCode'));
        add_action('wp_ajax_lfb_applyCouponCode', array($this, 'applyCouponCode'));
        add_action('wp_ajax_nopriv_lfb_getFormToPay', array($this, 'getFormToPay'));
        add_action('wp_ajax_lfb_getFormToPay', array($this, 'getFormToPay'));
        add_action('wp_ajax_nopriv_lfb_validPayForm', array($this, 'validPayForm'));
        add_action('wp_ajax_lfb_validPayForm', array($this, 'validPayForm'));
        add_action('wp_ajax_nopriv_lfb_getBusyDates', array($this, 'getBusyDates'));
        add_action('wp_ajax_lfb_getBusyDates', array($this, 'getBusyDates'));
        add_action('wp_ajax_nopriv_lfb_loginManD', array($this, 'loginManD'));
        add_action('wp_ajax_lfb_loginManD', array($this, 'loginManD'));
        add_action('wp_ajax_nopriv_lfb_forgotPassManD', array($this, 'forgotPassManD'));
        add_action('wp_ajax_lfb_forgotPassManD', array($this, 'forgotPassManD'));
        add_action('wp_ajax_nopriv_lfb_downloadDataMan', array($this, 'downloadDataMan'));
        add_action('wp_ajax_lfb_downloadDataMan', array($this, 'downloadDataMan'));
        add_action('wp_ajax_nopriv_lfb_confirmModifyData', array($this, 'confirmModifyData'));
        add_action('wp_ajax_lfb_confirmModifyData', array($this, 'confirmModifyData'));
        add_action('wp_ajax_nopriv_lfb_confirmDeleteData', array($this, 'confirmDeleteData'));
        add_action('wp_ajax_lfb_confirmDeleteData', array($this, 'confirmDeleteData'));
        add_action('wp_ajax_nopriv_lfb_manSignOut', array($this, 'manSignOut'));
        add_action('wp_ajax_lfb_manSignOut', array($this, 'manSignOut'));
        add_action('wp_ajax_nopriv_lfb_makeRazorPayment', array($this, 'makeRazorPayment'));
        add_action('wp_ajax_lfb_makeRazorPayment', array($this, 'makeRazorPayment'));
        add_action('wp_ajax_nopriv_lfb_getStripePaymentIntent', array($this, 'getStripePaymentIntent'));
        add_action('wp_ajax_lfb_getStripePaymentIntent', array($this, 'getStripePaymentIntent'));
        // add_action('wp_ajax_nopriv_lfb_payWithStripe', array($this, 'payWithStripe'));
        // add_action('wp_ajax_lfb_payWithStripe', array($this, 'payWithStripe'));
        add_action('wp_ajax_nopriv_lfb_processStripeSubscription', array($this, 'processStripeSubscription'));
        add_action('wp_ajax_lfb_processStripeSubscription', array($this, 'processStripeSubscription'));
        add_action('wp_ajax_nopriv_lfb_checkEmailCustomer', array($this, 'checkEmailCustomer'));
        add_action('wp_ajax_lfb_checkEmailCustomer', array($this, 'checkEmailCustomer'));
        add_action('wp_ajax_nopriv_lfb_verificationCode', array($this, 'verificationCode'));
        add_action('wp_ajax_lfb_verificationCode', array($this, 'verificationCode'));
        add_action('wp_ajax_nopriv_lfb_verificationPass', array($this, 'verificationPass'));
        add_action('wp_ajax_lfb_verificationPass', array($this, 'verificationPass'));
        add_action('wp_ajax_nopriv_lfb_loginCustomer', array($this, 'loginCustomer'));
        add_action('wp_ajax_lfb_loginCustomer', array($this, 'loginCustomer'));
        add_action('wp_ajax_nopriv_lfb_loadCustomerOrders', array($this, 'loadCustomerOrders'));
        add_action('wp_ajax_lfb_loadCustomerOrders', array($this, 'loadCustomerOrders'));
        add_action('wp_ajax_nopriv_lfb_viewCustomerOrder', array($this, 'viewCustomerOrder'));
        add_action('wp_ajax_lfb_viewCustomerOrder', array($this, 'viewCustomerOrder'));
        add_action('wp_ajax_nopriv_lfb_downloadCustomerOrder', array($this, 'downloadCustomerOrder'));
        add_action('wp_ajax_lfb_downloadCustomerOrder', array($this, 'downloadCustomerOrder'));
        add_action('wp_ajax_nopriv_lfb_saveCustomerInfos', array($this, 'saveCustomerInfos'));
        add_action('wp_ajax_lfb_saveCustomerInfos', array($this, 'saveCustomerInfos'));
        add_action('wp_ajax_nopriv_lfb_downloadOrderPDF', array($this, 'downloadOrderPDF'));
        add_action('wp_ajax_lfb_downloadOrderPDF', array($this, 'downloadOrderPDF'));
        add_action('wp_ajax_nopriv_lfb_getComponentMenu', array($this, 'getComponentMenu'));
        add_action('wp_ajax_lfb_getComponentMenu', array($this, 'getComponentMenu'));
        add_action('wp_ajax_nopriv_lfb_getItemDom', array($this, 'getItemDom'));
        add_action('wp_ajax_lfb_getItemDom', array($this, 'getItemDom'));
        add_action('wp_ajax_nopriv_lfb_itemsSort', array($this, 'itemsSort'));
        add_action('wp_ajax_lfb_itemsSort', array($this, 'itemsSort'));

        add_action('woocommerce_add_order_item_meta', array($this, 'customDataToWooFinalOrder'), 1, 2);
        add_action('woocommerce_before_cart_item_quantity_zero', array($this, 'removeCustomDataWoo'), 1, 1);
        add_action('woocommerce_before_calculate_totals', array($this, 'wooCommerceCalculateTotal'), 99);
        add_action('wp_enqueue_scripts', array($this, 'frontend_enqueue_scripts'), 10, 1);
        add_action('wp_enqueue_scripts', array($this, 'frontend_enqueue_styles'), 10, 1);
        /* if (isset($_GET['lfb_action']) && $_GET['lfb_action'] == 'preview') {
          add_filter('template_include', array($this, 'load_lfb_template'));
          }
          add_filter('the_content', array($this, 'preview_content')); */
        add_filter('the_content', array($this, 'showCustomerManagementPage'));
        add_action('wp', array($this, 'executeCron'));
        add_action('phpmailer_init', array($this, 'lfb_iniPhpmailer'));
        add_filter('the_posts', array($this, 'conditionally_add_scripts_and_styles'));
        add_action('plugins_loaded', array($this, 'init_localization'));
        add_filter('query_vars', array($this, 'lfb_query_vars'));
        add_action('generate_rewrite_rules', array($this, 'lfb_rewrite_rules'));
        add_action('parse_request', array($this, 'lfb_parse_request'));
        add_filter('jetpack_lazy_images_blacklisted_classes', array($this, 'lfb_prevent_lazy_loading'));
        add_action('wp_head', array($this, 'customerAccount_styles'));
    }

    public function getComponentMenu() {

        if (current_user_can('manage_options')) {
            $html = '
              <div id="lfb_componentsPanel" class="lfb_lPanel lfb_lPanelLeft">
                <div class="lfb_lPanelHeader"><span class="fas fa-cube"></span><span id="lfb_lPanelHeaderTitle">' . __('Components', 'lfb') . '</span>
                    <a href="javascript:" id="lfb_componentsCloseBtn" class="btn btn-default btn-circle btn-inverse"><span class="glyphicon glyphicon-remove"></span></a>
                </div>
                <div class="lfb_lPanelBody">
                    <div id="lfb_componentsFilters">
                    <div  class="input-group">
                        <span class="input-group-addon"><span class="fas fa-search"></span></span>
                        <input class="form-control" placeholder="' . __('Search', 'lfb') . '"/>
                    </div>
                </div>
                
                <div class="lfb_lPanelBodyContent">
                
                    <div class="lfb_componentModel lfb_item" data-component="row">
                        <div class="lfb_componentTitle">' . __('Row', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                            <div class="lfb_row"></div>
                        </div>
                    </div>
                    
                    <div class="lfb_componentModel lfb_item" data-component="button">
                        <div class="lfb_componentTitle">' . __('Button', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                            <a href="javascript:" class="btn btn-primary">' . __('Button', 'lfb') . '</a>
                        </div>
                    </div>
                    
                    <div class="lfb_componentModel lfb_item" data-component="checkbox">
                        <div class="lfb_componentTitle">' . __('Checkbox', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <input type="checkbox" data-toggle="switch" />
                        </div>
                    </div>
                    
                    
                    <div class="lfb_componentModel lfb_item" data-component="colorpicker">
                        <div class="lfb_componentTitle">' . __('Color picker', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                            <div class="lfb_colorPreview "></div>
                        </div>
                    </div>
                    
                    <div class="lfb_componentModel lfb_item" data-component="picture">
                        <div class="lfb_componentTitle">' . __('Image', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <img src="' . esc_url($this->assets_url) . 'img/placeholder.png" alt="' . __('Image', 'lfb') . '"/>
                        </div>
                    </div>
                    <div class="lfb_componentModel lfb_item" data-component="datepicker">
                        <div class="lfb_componentTitle">' . __('Datepicker', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <div class="form-group">
                                <label>' . __('My item', 'lfb') . '</label>
                                <input type="date"  class="form-control lfb_datepicker" />
                             </div>
                        </div>
                    </div>
                    <div class="lfb_componentModel lfb_item" data-component="filefield">
                        <div class="lfb_componentTitle">' . __('File field', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <div class="form-group">
                                <label>' . __('My item', 'lfb') . '</label>
                                <div class="lfb_dropzone dropzone"  id="lfb_dropzone_model"  ></div>
                             </div>
                        </div>
                    </div>
                    
                    <div class="lfb_componentModel lfb_item" data-component="imageButton">
                        <div class="lfb_componentTitle">' . __('Image with button', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                        <div class="lfb_imageButtonContainer">
                            <div class="lfb_imageButtonHeader">' . __('My item', 'lfb') . '</div>
                            <img  class="lfb_imageButtonImg" src="' . esc_url($this->assets_url) . 'img/placeholder.png" data-placement="bottom"  alt="' . __('Image with button', 'lfb') . '" />
                            <div class="lfb_imageButtonDescription">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                            <a href="javascript:" class="lfb_button lfb_imageButton btn btn-primary btn-wide ">                
                                <span class="fas fa-rocket"></span> ' . __('My item', 'lfb') . '           
                            </a>
                         </div>                         

                        </div>
                    </div>
                    
                    
                    <div class="lfb_componentModel lfb_item" data-component="layeredImage">
                        <div class="lfb_componentTitle">' . __('Layered Image', 'lfb') . '</div>
                       <div class="lfb_componentPreview">
                             <img src="' . esc_url($this->assets_url) . 'img/placeholderLayers.png" alt="' . __('Layered Image', 'lfb') . '"/>
                        </div>
                    </div>

                     <div class="lfb_componentModel lfb_item" data-component="numberfield">
                        <div class="lfb_componentTitle">' . __('Number field', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <div class="form-group">
                                <label>' . __('My item', 'lfb') . '</label>
                                <input type="number"  class="form-control" />
                             </div>
                        </div>
                    </div>
                    
                    
                     <div class="lfb_componentModel lfb_item" data-component="rate">
                        <div class="lfb_componentTitle">' . __('Rate', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <div class="lfb_rate"></div>
                        </div>
                    </div>
                    
                     <div class="lfb_componentModel lfb_item" data-component="richtext">
                        <div class="lfb_componentTitle">' . __('Rich text', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus euismod orci sit amet risus eleifend, quis faucibus purus posuere.</p>
                        </div>
                    </div>
                    
                     <div class="lfb_componentModel lfb_item" data-component="select">
                        <div class="lfb_componentTitle">' . __('Select field', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <div class="form-group">
                                <label>' . __('My item', 'lfb') . '</label>
                                <select class="form-control"></select>
                             </div>
                        </div>
                    </div>
                    
                     <div class="lfb_componentModel lfb_item" data-component="shortcode">
                        <div class="lfb_componentTitle">' . __('Shortcode', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <strong>
                                [wordpress-shortcode]
                             </strong>
                        </div>
                    </div>
                    
                     <div class="lfb_componentModel lfb_item" data-component="slider">
                        <div class="lfb_componentTitle">' . __('Slider', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <div class="form-group">
                                <label>' . __('My item', 'lfb') . '</label>
                                <div data-type="slider"></div>                                
                             </div>
                        </div>
                    </div>
                    
                    
                     <div class="lfb_componentModel lfb_item" data-component="textarea">
                        <div class="lfb_componentTitle">' . __('Text area', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <div class="form-group">
                                <label>' . __('My item', 'lfb') . '</label>
                                <textarea class="form-control"></textarea>
                             </div>
                        </div>
                    </div>
                    
                    
                     <div class="lfb_componentModel lfb_item" data-component="textfield">
                        <div class="lfb_componentTitle">' . __('Text field', 'lfb') . '</div>
                        <div class="lfb_componentPreview">
                             <div class="form-group">
                                <label>' . __('My item', 'lfb') . '</label>
                                <input type="text" class="form-control" />
                             </div>
                        </div>
                    </div>
                    
                 </div>
                    
              </div>';
            $html .= '</div>';
            echo $html;
            die();
        }
    }

    public function initSession() {
        $lfb_session = $this->lfb_getSession();
        $this->lfb_updateSession('lfb_activationCode', '');
        $this->lfb_updateSession('lfb_verifiedEmail', '');
        if (isset($lfb_session['lfb_loginMan']) && intval($lfb_session['lfb_loginMan']) > 0) {
            $this->lfb_loginMan = intval($lfb_session['lfb_loginMan']);
        }
    }

    public function clearSessions() {

        global $wpdb;
        $table_nameR = $wpdb->prefix . "options";
        $optionsReq = $wpdb->get_results("SELECT * FROM $table_nameR WHERE option_name LIKE 'lfbSession_%'");
        foreach ($optionsReq as $option) {
            $optionData = json_decode($option->option_value);
            if (isset($optionData->date)) {
                $dateToday = strtotime(date('Ymd'));
                $dateSession = strtotime($optionData->date);
                $datediff = $dateToday - $dateSession;
                $datediff = round($datediff / (60 * 60 * 24));
                if ($datediff > 1) {
                    delete_option($option->option_name);
                }
            } else {
                delete_option($option->option_name);
            }
        }
    }

    private function lfb_getSession() {
        $rep = array();
        if (get_option('lfbSession_' . $this->get_client_ip())) {
            $rep = json_decode(get_option('lfbSession_' . $this->get_client_ip()), true);
        }
        return $rep;
    }

    private function lfb_updateSession($key, $value) {
        $rep = array();
        if (get_option('lfbSession_' . $this->get_client_ip())) {
            $rep = json_decode(get_option('lfbSession_' . $this->get_client_ip()), true);
        }
        $rep[$key] = $value;
        $rep['date'] = date('Ymd');
        update_option('lfbSession_' . $this->get_client_ip(), json_encode($rep));
    }

    private function lfb_destroySession() {
        delete_option('lfbSession_' . $this->get_client_ip());
    }

// adds plugin variable to allowed url variables
    public function lfb_query_vars($vars) {
        $new_vars = array('EPFormsBuilder');
        $vars = $new_vars + $vars;
        return $vars;
    }

    public function lfb_prevent_lazy_loading($classes) {
        $classes[] = 'lfb_selectableImg';
        return $classes;
    }

    public function lfb_rewrite_rules($wp_rewrite) {
        $new_rules = array('EPFormsBuilder/paypal' => 'index.php?EPFormsBuilder=paypal');
        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;

        $new_rules = array('EPFormsBuilder/downloadMyOrder' => 'index.php?EPFormsBuilder=downloadMyOrder');
        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
        return $wp_rewrite->rules;
    }

// execute url variables
    public function lfb_parse_request($wp) {
        if (array_key_exists('EPFormsBuilder', $wp->query_vars) && $wp->query_vars['EPFormsBuilder'] == 'paypal') {
            $this->cbb_proccess_paypal_ipn($wp);
        }
        if (array_key_exists('EPFormsBuilder', $wp->query_vars) && $wp->query_vars['EPFormsBuilder'] == 'payOrder') {
            $this->lfb_payForm($wp);
        }
        if (array_key_exists('EPFormsBuilder', $wp->query_vars) && $wp->query_vars['EPFormsBuilder'] == 'checkMyData') {
            $this->lfb_manageCustomerDatas($wp);
            return $wp;
        }
        if (array_key_exists('EPFormsBuilder', $wp->query_vars) && $wp->query_vars['EPFormsBuilder'] == 'downloadMyOrder') {
            $this->downloadMyOrder($wp);
            return $wp;
        }
    }

    public function lfb_iniPhpmailer($phpmailer) {
        $settings = $this->getSettings();

        if (current_user_can('manage_options') && isset($_POST['action']) && $_POST['action'] == 'lfb_testSMTP') {
            $phpmailer->isSMTP();
            $host = ($_POST['host']);
            $port = ($_POST['port']);
            $username = ($_POST['username']);
            $password = ($_POST['pass']);
            $mode = ($_POST['mode']);

            $phpmailer->Host = $host;
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = $port;
            $phpmailer->Username = $username;
            $phpmailer->Password = $password;
            $phpmailer->SMTPSecure = $mode;
        } else if ($settings->useSMTP) {
            $phpmailer->isSMTP();
            $phpmailer->Host = $settings->smtp_host;
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = $settings->smtp_port;
            $phpmailer->Username = $settings->smtp_username;
            $phpmailer->Password = $this->stringDecode($settings->smtp_password, true);
            $phpmailer->SMTPSecure = $settings->smtp_mode;
        }
    }

    public function executeCron() {
        global $wpdb;
        $settings = $this->getSettings();
        $initialTimezone = date_default_timezone_get();
        if (in_array(get_option('timezone_string'), timezone_identifiers_list())) {
            date_default_timezone_set(get_option('timezone_string'));
        }

        $table_nameR = $wpdb->prefix . "wpefc_calendarReminders";
        $remindersData = $wpdb->get_results("SELECT * FROM $table_nameR WHERE isSent=0");
        foreach ($remindersData as $reminder) {
            $table_nameE = $wpdb->prefix . "wpefc_calendarEvents";
            $event = $wpdb->get_results("SELECT * FROM $table_nameE WHERE id=" . $reminder->eventID . " LIMIT 1");
            if (count($event) > 0) {
                $event = $event[0];

                $startDate = new DateTime($event->startDate);
                $hours = $reminder->delayValue;
                if ($reminder->delayType == 'days') {
                    $hours *= 24;
                } else if ($reminder->delayType == 'weeks') {
                    $hours *= (24 * 7);
                } else if ($reminder->delayType == 'month') {
                    $hours *= (24 * 30);
                }

                $alertDate = new DateTime(date("Y-m-d H:i:s", strtotime($event->startDate)));
                $alertDate->modify('-' . $hours . ' hours');
                if ($alertDate->format('Y-m-d H:i:s') < date('Y-m-d H:i:s')) {
                    $content = $reminder->content;
                    $chkLog = false;
                    if ($event->orderID > 0) {
                        $table_nameL = $wpdb->prefix . 'wpefc_logs';
                        $log = $wpdb->get_results('SELECT * FROM ' . $table_nameL . ' WHERE id=' . $event->orderID . ' LIMIT 1');
                        if (count($log) > 0) {
                            $chkLog = true;
                            $log = $log[0];
                            $log->email = $this->stringDecode($log->email, $settings->encryptDB);
                            $content = str_replace('[ref]', $log->ref, $content);
                            $content = str_replace('[customer_email]', $log->email, $content);
                        }
                    }
                    if (!$chkLog) {
                        $content = str_replace('[ref]', '', $content);
                        $content = str_replace('[customer_email]', '', $content);
                    }
                    $content = str_replace('[customerAddress]', $this->stringDecode($event->customerAddress, $settings->encryptDB), $content);
                    $content = str_replace('[customerEmail]', $this->stringDecode($event->customerEmail, $settings->encryptDB), $content);
                    if ($event->fullDay == 0) {
                        $content = str_replace('[time]', date(get_option('time_format'), strtotime($event->startDate)), $content);
                    } else {
                        $content = str_replace('[time]', '', $content);
                    }
                    $content = str_replace('[date]', date_i18n(get_option('date_format'), strtotime($event->startDate)), $content);

                    if (version_compare(PHP_VERSION, '7.2.0') >= 0) {
                        add_filter('wp_mail_content_type', function() {
                            return "text/html";
                        });
                    } else {
                        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                    }

                    if (wp_mail($reminder->email, $reminder->title, $content)) {
                        $wpdb->update($table_nameR, array('isSent' => 1), array('id' => $reminder->id));
                    }
                }
            }
        }
        date_default_timezone_set($initialTimezone);
    }

    public function lfb_payForm($wp) {
        global $wpdb;
        $this->formToPayKey = sanitize_text_field($_GET['h']);
        $table_name = $wpdb->prefix . "wpefc_logs";
        $logReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE paymentKey='%s' LIMIT 1", $this->formToPayKey));
        if (count($logReq) > 0) {
            $log = $logReq[0];
            $this->formToPayID = $log->formID;
        }
    }

    public function lfb_manageCustomerDatas($wp) {
        global $wpdb;
        $this->modeManageData = true;
    }

    public function validPayForm() {

        global $wpdb;
        $settings = $this->getSettings();
        $formID = sanitize_text_field($_POST['formID']);
        $orderKey = sanitize_text_field($_POST['orderKey']);
        $stripeToken = sanitize_text_field($_POST['stripeToken']);
        //  $stripeTokenB = sanitize_text_field($_POST['stripeTokenB']);
        $razorpayReady = sanitize_text_field($_POST['razorpayReady']);
        $stripeCustomerID = sanitize_text_field($_POST['stripeCustomerID']);
        $stripeSrc = sanitize_text_field($_POST['stripeSrc']);

        $table_name = $wpdb->prefix . "wpefc_forms";
        $formReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id='%s' LIMIT 1", $formID));
        if (count($formReq) > 0) {
            $form = $formReq[0];
            $table_name = $wpdb->prefix . "wpefc_logs";
            $logReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE paymentKey='%s' LIMIT 1", $orderKey));
            if (count($logReq) > 0) {
                $log = $logReq[0];

                $chkStripe = false;
                $useStripe = false;
                if ($stripeToken != "" && $form->use_stripe) {
                    $useStripe = true;
                    $chkStripe = true;
                    //$chkStripe = $this->validStripePayment($form, $log, $stripeToken);
                    // $chkStripe = $this->validStripePayment($form, $log->ref, $log->totalPrice, $log->totalSubscription, $stripeSrc, $stripeCustomerID);
                    // $chkStripe = $this->doStripePayment($log->id, $stripeToken, $stripeTokenB);
                } else if ($razorpayReady) {

                    $table_nameL = $wpdb->prefix . "wpefc_logs";
                    $wpdb->update($table_nameL, array('paid' => 1), array('id' => $log->id));
                }
            }
        }
        die();
    }

    public function getFormToPay() {
        global $wpdb;
        $settings = $this->getSettings();

        $logKey = sanitize_text_field($_POST['key']);
        $table_name = $wpdb->prefix . "wpefc_logs";
        $logReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE paymentKey='%s' LIMIT 1", $logKey));
        if (count($logReq) > 0) {
            $log = $logReq[0];
            $settings = $this->getSettings();

            $log->email = $this->stringDecode($log->email, $settings->encryptDB);
            //  $log->content = $this->stringDecode($log->content, $settings->encryptDB);
            // $log->contentUser = $this->stringDecode($log->contentUser, $settings->encryptDB);

            $lastPos = 0;
            $positions = array();
            $toReplaceDefault = array();
            $toReplaceBy = array();
            while (($lastPos = strpos($log->contentUser, '<span class="lfb_value">', $lastPos)) !== false) {
                $positions[] = $lastPos;
                $lastPos = $lastPos + strlen('<span class="lfb_value">');
                $fileStartPos = $lastPos;
                $lastSpan = strpos($log->contentUser, '</span>', $fileStartPos);
                $value = substr($log->contentUser, $fileStartPos, $lastSpan - $fileStartPos);
                $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
                $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
            }
            foreach ($toReplaceBy as $key => $value) {
                $log->contentUser = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $log->contentUser);
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
                $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
            }
            foreach ($toReplaceBy as $key => $value) {
                $log->content = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $log->content);
            }

            if ($log->paid == 0) {
                $this->currentForms[] = $log->formID;


                $table_name = $wpdb->prefix . "wpefc_forms";
                $formReq = $wpdb->get_results("SELECT * FROM $table_name WHERE id=" . $log->formID . " LIMIT 1");
                if (count($formReq) > 0) {
                    $form = $formReq[0];

                    if ($form->use_razorpay || $form->use_stripe || ($form->use_paypal && $form->paypal_useIpn)) {

                        $this->options_custom_styles();
                        $txt_orderType = $form->txt_invoice;
                        if (!$log->paid) {
                            $txt_orderType = $form->txt_quotation;
                        }

                        $log->contentUser = str_replace("[order_type]", $txt_orderType, $log->contentUser);
                        $log->contentUser = str_replace("[payment_link]", "", $log->contentUser);
                        $log->contentUser = str_replace("[gdpr_link]", "", $log->contentUser);


                        $response = '<div style="text-align: center;">';

                        if (($form->use_paypal && $form->use_stripe) ||
                                ($form->use_paypal && $form->use_razorpay) ||
                                ($form->use_razorpay && $form->use_stripe)) {
                            $response .= '<div id="lfb_paymentMethodBtns">';
                            if ($form->use_paypal) {
                                $response .= '<a href="javascript:" data-payment="paypal" class="btn btn-wide btn-secondary"><span class="fab fa-paypal"></span><span>' . $form->txt_btnPaypal . '</span></a>';
                            }
                            if ($form->use_stripe) {
                                $response .= '<a href="javascript:" data-payment="stripe" class="btn btn-wide btn-secondary"><span class="fab fa-stripe-s"></span><span>' . $form->txt_btnStripe . '</span></a>';
                            }
                            if ($form->use_razorpay) {
                                $response .= '<a href="javascript:" data-payment="razorpay" class="btn btn-wide btn-secondary"><span class="fas fa-money-check-alt"></span><span>' . $form->txt_btnRazorpay . '</span></a>';
                            }
                            $response .= '</div>';
                        }

                        if ($form->use_razorpay) {
                            $response .= '<div id="lfb_razorPayCt"><a href="javascript:" id="btnOrderRazorpay" class="btn btn-wide btn-primary">' . $form->last_btn . '</a></div>';
                        }
                        if ($form->use_stripe) {

                            // $response .= '<p style="margin-top: 38px; margin-bottom: -28px;" class="lfb_btnNextContainer"><input type="submit" value="' . $form->last_btn . '"  id="wpe_btnOrderStripe"  class="btn btn-wide btn-primary"/></p>';
                            $response .= '<p style="margin-top: 38px; " class="lfb_btnNextContainer"><a href="javascript:" id="lfb_btnPayStripe"  class="btn btn-wide btn-primary">' . $form->last_btn . '</a></p>';
                        }
                        if ($form->use_paypal) {
                            if ($form->paypal_useSandbox == 1) {
                                $response .= '<form id="wtmt_paypalForm" action="https://www.sandbox.paypal.com/cgi-bin/webscr" data-useipn="1" method="post">';
                            } else {
                                $response .= '<form id="wtmt_paypalForm" action="https://www.paypal.com/cgi-bin/webscr"  data-useipn="1" method="post">';
                            }

                            $response .= '<p style="" class="text-center lfb_btnNextContainer">'
                                    . '<a href="javascript:" id="btnOrderPaypal" class="btn btn-wide btn-primary">' . $finalIcon . $form->last_btn . '</a>';

                            $response .= '</p>
                            <input type="submit" style="display: none;" name="submit"/>
                            <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">';
                            if ($log->totalSubscription > 0) {
                                $response .= '<input type="hidden" name="cmd" value="_xclick-subscriptions">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="src" value="1">
                            <input type="hidden" name="a3" value="15.00">
                            <input type="hidden" name="p3" value="' . $form->paypal_subsFrequency . '">
                            <input type="hidden" name="t3" value="' . $form->paypal_subsFrequencyType . '">
                            <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest">';
                            } else {
                                $response .= '<input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="amount" value="1">';
                            }
                            $lang = '';
                            if ($form->paypal_languagePayment != "") {
                                $lang = '<input type="hidden" name="lc" value="' . $form->paypal_languagePayment . '"><input type="hidden" name="country" value="' . $form->paypal_languagePayment . '">';
                            }
                            $response .= '<input type="hidden" name="business" value="' . $form->paypal_email . '">
                            <input type="hidden" name="business_cs_email" value="' . $form->paypal_email . '">
                            <input type="hidden" name="item_name" value="' . $form->title . '">
                            <input type="hidden" name="item_number" value="A00001">
                            <input type="hidden" name="charset" value="utf-8">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="cn" value="Message">
                            <input type="hidden" name="custom" value="Form content">
                            <input type="hidden" name="currency_code" value="' . $form->paypal_currency . '">
                            <input type="hidden" name="return" value="' . $form->close_url . '">
                                ' . $lang . '
                        </form>';
                        }
                        $response .= '</div>';

                        $log->contentUser .= $response;
                        echo $log->contentUser;
                    }
                }
            }
        }
        die();
    }

    public function cbb_proccess_paypal_ipn($wp) {
        global $wpdb;
        require_once ('IpnListener.php');
        if (isset($_POST['item_number'])) {
            $item_number = sanitize_text_field($_POST['item_number']);
            $table_name = $wpdb->prefix . "wpefc_logs";


            $logReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE ref='%s' LIMIT 1", $item_number));
            if (count($logReq) > 0) {
                $log = $logReq[0];

                $table_name = $wpdb->prefix . "wpefc_forms";
                $formReq = $wpdb->get_results("SELECT * FROM $table_name WHERE id=" . $log->formID . " LIMIT 1");
                $form = $formReq[0];
                $listener = new IpnListener();
                if ($form->paypal_useSandbox) {
                    $listener->use_sandbox = true;
                }
                if ($verified = $listener->processIpn()) {
                    
                } else {

                    $transactionData = $listener->getPostData();
                    if ($_POST['payment_status'] == 'Completed') {

                        $table_name = $wpdb->prefix . "wpefc_logs";
                        $wpdb->update($table_name, array('paid' => 1), array('ref' => $item_number));
                        if (!$log->checked) {
                            $this->sendOrderEmail($item_number, $log->formID);
                        }
                    }
                }
            }
        }
    }

    public function getBusyDates() {
        global $wpdb;
        $formID = sanitize_text_field($_POST['formID']);
        $calendarIDs = $_POST['calendarsIDs'];

        $rep = new stdClass();
        $rep->calendars = array();


        foreach ($_POST['calendarsIDs'] as $calendarID) {
            $calendar = new stdClass();
            $calendar->id = $calendarID;
            $table_name = $wpdb->prefix . "wpefc_calendarEvents";
            $calendar->events = $wpdb->get_results($wpdb->prepare("SELECT calendarID,isBusy,startDate,endDate,fullDay FROM $table_name WHERE calendarID=%s AND isBusy=1", $calendarID));

            $rep->calendars[] = $calendar;
        }
        echo json_encode($rep);
        die();
    }

    private function getKeyS() {
        if (get_option('lfbK') !== false) {
            $key = get_option('lfbK');
        } else {
            $key = md5(uniqid(rand(), true));
            update_option('lfbK', $key);
        }
        return $key;
    }

    public function stringEncode($value, $enableCrypt) {
        if (!$enableCrypt) {
            $text = $value;
        } else {
            if ($value != "") {
                //  $value = strval($value);
                $iv = openssl_random_pseudo_bytes(16);
                $text = openssl_encrypt($value, 'aes128', $this->getKeyS(), null, $iv);
                $text = $this->safe_b64encode($text . '::' . $iv);
            } else {
                $text = "";
            }
        }
        return $text;
    }

    public function stringDecode($value, $enableCrypt) {
        if (!$enableCrypt) {
            $text = $value;
        } else {
            if ($value != "") {
                $encrypted_data = "";
                $iv = "";
                list($encrypted_data, $iv) = explode('::', $this->safe_b64decode($value), 2);
                $text = openssl_decrypt($encrypted_data, 'aes128', $this->getKeyS(), null, $iv);
            } else {
                $text = "";
            }
        }
        return $text;
    }

    public function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function loginManD() {
        global $wpdb;
        $settings = $this->getSettings();
        $email = sanitize_text_field($_POST['email']);
        $pass = sanitize_text_field($_POST['pass']);
        $table_name = $wpdb->prefix . "wpefc_customers";
        $customersData = $wpdb->get_results("SELECT * FROM $table_name");
        foreach ($customersData as $customerData) {
            if ($this->stringDecode($customerData->email, $settings->encryptDB) == $email) {
                if ($this->stringDecode($customerData->password, true) == $pass) {
                    $rep = 1;
                    $lfb_session = $this->lfb_getSession();

                    $this->lfb_updateSession('lfb_loginMan', $customerData->id);
                    //$lfb_session['lfb_loginMan'] = $customerData->id;
                }
            }
        }

        echo $rep;
        die();
    }

    public function forgotPassManD() {
        global $wpdb;
        $settings = $this->getSettings();
        $email = sanitize_text_field($_POST['email']);

        $lfb_session = $this->lfb_getSession();
        if (!isset($lfb_session['lfb_lastPassSent']) || $lfb_session['lfb_lastPassSent'] != $email) {
            $this->lfb_updateSession('lfb_lastPassSent', $email);

            $table_name = $wpdb->prefix . "wpefc_customers";
            $chkEmail = false;
            $rep = 0;

            $customersData = $wpdb->get_results("SELECT * FROM $table_name");
            foreach ($customersData as $customerData) {
                if ($this->stringDecode($customerData->email, $settings->encryptDB) == $email) {
                    $pass = $this->generatePassword();
                    $wpdb->update($table_name, array('password' => $this->stringEncode($pass, true)), array('id' => $customerData->id));
                    $chkEmail = true;
                }
            }
            if ($chkEmail) {
                $customersDataUrl = '';
                if ($settings->enableCustomerAccount && $settings->customerAccountPageID > 0) {
                    $customersDataUrl = get_page_link($settings->customerAccountPageID);
                }


                $txtMail = nl2br($settings->txtCustomersDataForgotPassMail);
                $txtMail = str_replace('[url]', '<a href="' . $customersDataUrl . '">' . $customersDataUrl . '</a>', $txtMail);
                $txtMail = str_replace("[password]", '<strong>' . $pass . '</strong>', $txtMail);

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
                if (wp_mail($email, $settings->txtCustomersDataForgotMailSubject, $txtMail)) {
                    
                }
                $rep = 1;
            }
        } else {
            $rep = 1;
        }
        echo $rep;
        die();
    }

    public function manSignOut() {

        $this->lfb_destroySession();
        die();
    }

    public function confirmModifyData() {

        $lfb_session = $this->lfb_getSession();
        if (isset($lfb_session['lfb_loginMan']) && isset($_POST['details'])) {
            global $wpdb;
            $details = sanitize_text_field($_POST['details']);
            $custID = $lfb_session['lfb_loginMan'];
            $table_name = $wpdb->prefix . "wpefc_customers";
            $customerData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $custID));
            if (count($customerData) > 0) {
                $settings = $this->getSettings();
                $customerData = $customerData[0];
                $customerData->email = $this->stringDecode($customerData->email, $settings->encryptDB);
                $settings = $this->getSettings();

                $mailContent = '<p>' . $settings->txtCustomersDataModifyMailSubject . ' <strong>' . $customerData->email . '</strong> :</p>';
                $mailContent .= '<p>' . nl2br($details) . '</p>';
                $linkAdmin = get_site_url() . '/wp-admin/admin.php?page=lfb_menu';
                $mailContent .= '<p><a href="' . $linkAdmin . '">' . $linkAdmin . '</a></p>';

                if (version_compare(PHP_VERSION, '7.2.0') >= 0) {
                    add_filter('wp_mail_content_type', function() {
                        return "text/html";
                    });
                } else {
                    add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                }
                if (wp_mail($settings->customerDataAdminEmail, $settings->txtCustomersDataModifyMailSubject, $mailContent)) {
                    
                }
            }
        }
        die();
    }

    public function confirmDeleteData() {
        $lfb_session = $this->lfb_getSession();
        if (isset($lfb_session['lfb_loginMan'])) {
            global $wpdb;
            $custID = $lfb_session['lfb_loginMan'];
            $table_name = $wpdb->prefix . "wpefc_customers";
            $customerData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $custID));
            if (count($customerData) > 0) {
                $settings = $this->getSettings();
                $customerData = $customerData[0];
                $customerData->email = $this->stringDecode($customerData->email, $settings->encryptDB);

                $mailContent = '<p>' . $settings->txtCustomersDataDeleteMailSubject . ' : <strong>' . $customerData->email . '</strong></p>';
                $linkAdmin = get_site_url() . '/wp-admin/admin.php?page=lfb_menu';
                $mailContent .= '<p><a href="' . $linkAdmin . '">' . $linkAdmin . '</a></p>';
                $headers = "";
                if (version_compare(PHP_VERSION, '7.2.0') >= 0) {
                    add_filter('wp_mail_content_type', function() {
                        return "text/html";
                    });
                } else {
                    add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                }
                if (wp_mail($settings->adminEmail, $settings->txtCustomersDataDeleteMailSubject, $mailContent)) {
                    echo 1;
                }
            }
        }
        die();
    }

    public function downloadDataMan() {
        $lfb_session = $this->lfb_getSession();
        if (isset($lfb_session['lfb_loginMan'])) {
            global $wpdb;
            $jsonData = new stdClass();
            $custID = $lfb_session['lfb_loginMan'];
            $table_name = $wpdb->prefix . "wpefc_customers";
            $customerData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $custID));
            if (count($customerData) > 0) {
                $settings = $this->getSettings();
                $customerData = $customerData[0];
                $jsonData->email = $this->stringDecode($customerData->email, $settings->encryptDB);
                $jsonData->orders = array();

                $table_nameL = $wpdb->prefix . "wpefc_logs";
                $logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameL WHERE customerID=%s AND checked=1 ORDER BY id ASC", $custID));
                foreach ($logs as $log) {
                    $order = new stdClass();
                    $order->date = $log->dateLog;
                    $order->reference = $log->ref;
                    $order->content = str_replace('[n]', '\n', $this->stringDecode($log->contentTxt, $settings->encryptDB));
                    $order->firstName = $this->stringDecode($log->firstName, $settings->encryptDB);
                    $order->lastName = $this->stringDecode($log->lastName, $settings->encryptDB);
                    $order->phone = $this->stringDecode($log->phone, $settings->encryptDB);
                    $order->address = $this->stringDecode($log->address, $settings->encryptDB);
                    $order->city = $this->stringDecode($log->city, $settings->encryptDB);
                    $order->country = $this->stringDecode($log->country, $settings->encryptDB);
                    $order->city = $this->stringDecode($log->city, $settings->encryptDB);
                    $order->state = $this->stringDecode($log->state, $settings->encryptDB);
                    $order->zip = $this->stringDecode($log->zip, $settings->encryptDB);

                    $order->totalPrice = $log->totalPrice;
                    $order->totalSubscription = $log->totalSubscription;
                    $jsonData->orders[] = $order;
                }
            }
            echo json_encode($jsonData);
        }
        die();
    }

    /**
     * Load popup template.
     * @access  public
     * @since   1.0.0
     * @return void
     */
    public function load_lfb_template($template) {
        $file = plugin_dir_path(__FILE__) . '../templates/lfb-preview.php';
        if (file_exists($file) && current_user_can('manage_options')) {
            return $file;
        }
    }

    /*
     * Plugin init localization
     */

    public function init_localization() {
        $moFiles = scandir(trailingslashit($this->dir) . 'languages/');
        if (get_locale() == "") {
            load_textdomain('lfb', trailingslashit($this->dir) . 'languages/WP_Estimation_Form.mo');
            return;
        }
        foreach ($moFiles as $moFile) {
            if (strlen($moFile) > 3 && substr($moFile, -3) == '.mo' && strpos($moFile, get_locale()) > -1) {
                load_textdomain('lfb', trailingslashit($this->dir) . 'languages/' . $moFile);
            }
        }
    }

    public function preview_content($content) {
        if (isset($_GET['lfb_action']) && $_GET['lfb_action'] == 'preview' && current_user_can('manage_options')) {
            $content = do_shortcode('[estimation_form form_id="' . sanitize_text_field($_GET['form']) . '" fullscreen="true"]');
        }
        return $content;
    }

    public function showCustomerManagementPage($pageContent) {
        $lfb_session = $this->lfb_getSession();
        $settings = $this->getSettings();
        $chkCustomer = false;
        if ($settings->enableCustomerAccount && get_the_ID() == $settings->customerAccountPageID) {
            $pageContent = '<div id="lfb_bootstraped" class="lfb_bootstraped"><div id="estimation_popup" class="wpe_bootstraped lfb_customerAccount">';
            if (isset($lfb_session['lfb_loginMan']) && $lfb_session['lfb_loginMan'] != '0') {
                $customerID = intval($lfb_session['lfb_loginMan']);
                global $wpdb;

                $table_name = $wpdb->prefix . "wpefc_customers";
                $customerData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $customerID));
                if (count($customerData) > 0) {
                    $chkCustomer = true;
                    $customerData = $customerData[0];

                    $pageContent .= '<div id="lfb_custAccountPanel">';
                    $pageContent .= '<div id="lfb_viewFormModal" class="modal" data-backdrop="true">'
                            . '<div class="modal-dialog modal-lg">'
                            . '<div class="modal-content">'
                            . '<a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span class="fas fa-times"></span></a>';
                    $pageContent .= '<div id="lfb_viewFormPanel"></div>';
                    $pageContent .= '</div>'
                            . '</div>'
                            . '</div>';
                    $pageContent .= '<div id="lfb_accountInfosPanel">';
                    $pageContent .= '<div class="text-right"><a href="javascript:" class="btn btn-warning" data-action="leaveAccount"><span class="fas fa-sign-out-alt"></span>' . $settings->txtCustomersDataLeaveLink . '</a></div>';

                    $pageContent .= '<h5>' . $settings->customersAc_customerInfo . '</h5>';

                    $pageContent .= '<div class="col-md-6">';

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_firstName . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user-tie"></i></span>
                     <input type="text" name="firstName" class="form-control " value="' . $this->stringDecode($customerData->firstName, $settings->encryptDB) . '"/>
                  </div>
              </div>'; // eof form-group  

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_email . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                     <input type="text" name="email" class="form-control " value="' . $this->stringDecode($customerData->email, $settings->encryptDB) . '"/>
                  </div>
              </div>'; // eof form-group  

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_address . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-map-marker-alt"></i></span>
                     <input type="text" name="address" class="form-control " value="' . $this->stringDecode($customerData->address, $settings->encryptDB) . '"/>
                  </div>
              </div>'; // eof form-group  

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_state . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-map-marked-alt"></i></span>
                     <input type="text" name="state" class="form-control " value="' . $this->stringDecode($customerData->state, $settings->encryptDB) . '"/>
                  </div>
              </div>'; // eof form-group  


                    $pageContent .= '</div>'; // eof col-md-6

                    $pageContent .= '<div class="col-md-6">';

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_lastName . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user-tie"></i></span>
                     <input type="text" name="lastName" class="form-control " value="' . $this->stringDecode($customerData->lastName, $settings->encryptDB) . '"/>
                  </div>
              </div>'; // eof form-group  


                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_phone . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-phone"></i></span>
                     <input type="tel" name="phone" class="form-control " value="' . $this->stringDecode($customerData->phone, $settings->encryptDB) . '"/>
                  </div>
              </div>'; // eof form-group  

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_zip . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-map-marked-alt"></i>   </span>
                     <input type="text" name="zip" class="form-control " value="' . $this->stringDecode($customerData->zip, $settings->encryptDB) . '"/>
                  </div>
              </div>'; // eof form-group  

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_inscription . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                     <input type="text" readonly="true" name="inscriptionDate" class="form-control" value="' . date_i18n(get_option('date_format'), strtotime($customerData->inscriptionDate)) . '"/>
                  </div>
              </div>'; // eof form-group  

                    $pageContent .= '</div>'; // eof col-md-6

                    $pageContent .= '<div class="col-md-6">';



                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_company . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-building"></i></span>
                     <input type="text" name="company" class="form-control "/>
                  </div>
              </div>'; // eof form-group  


                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_phoneJob . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-phone"></i></span>
                     <input type="tel" name="phoneJob" class="form-control "/>
                  </div>
              </div>'; // eof form-group  



                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_city . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-city"></i></span>
                     <input type="text" name="city" class="form-control "/>
                  </div>
              </div>'; // eof form-group  



                    $pageContent .= '</div>'; // eof col-md-6

                    $pageContent .= '<div class="col-md-6">';

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_job . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-briefcase"></i></span>
                     <input type="text" name="job" class="form-control "/>
                  </div>
              </div>'; // eof form-group  

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_country . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-flag"></i></span>
                     <input type="text" name="country" class="form-control "/>
                  </div>
              </div>'; // eof form-group  

                    $pageContent .= '<div class="form-group">'
                            . '<label>' . $settings->customersAc_url . '</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-link"></i></span>
                     <input type="url" name="url" class="form-control "/>
                  </div>
              </div>'; // eof form-group  


                    $pageContent .= '</div>'; // eof col-md-6
                    $pageContent .= '<div class="clearfix"></div>';



                    $pageContent .= '<div class="col-md-12 text-right" id="lfb_accountInfosBtnsContainer">'
                            . '<div id="lfb_accountBtnsLeft">'
                            . '<a href="javascript:" data-action="deleteCustomerData">' . $settings->txtCustomersDataDeleteLink . '</a> - '
                            . '<a href="javascript:" data-action="downloadCustomerData">' . $settings->txtCustomersDataDownloadLink . '</a>'
                            . '</div>'
                            . '<a href="javascript:" data-action="saveCustomerInfos" class="btn btn-primary"><span class="fas fa-save"></span>' . $settings->customersAc_save . '</a>'
                            . '</div>';

                    $pageContent .= '<div class="clearfix"></div>';
                    $pageContent .= '<div id="lfb_delDataForm">'
                            . '<div class="alert alert-warning">' . $settings->txtCustomersDataWarningText . '</div>'
                            . '<a href="javascript:" data-action="confirmDeleteCustomerData" class="btn btn-danger"><span class="glyphicon glyphicon-send"></span>' . $settings->txtCustomersDataDeleteLink . '</a>'
                            . '</div>';

                    $pageContent .= '<div id="lfb_customerOrders">';
                    $pageContent .= '<h5>' . $settings->customersAc_myOrders . '</h5>';

                    $pageContent .= '<div class="table-responsive">';
                    $pageContent .= '<table id="lfb_customerOrdersTable" class="table table-striped">'
                            . '<thead>'
                            . '<tr>'
                            . '<th>' . $settings->customersAc_date . '</th>'
                            . '<th class="text-right">' . $settings->customersAc_totalSub . '</th>'
                            . '<th class="text-right">' . $settings->customersAc_total . '</th>'
                            . '<th class="">' . $settings->customersAc_status . '</th>'
                            . '<th class="lfb_actionTh"></th>'
                            . '</tr>'
                            . '</thead>'
                            . '<tbody></tbody>'
                            . '</table>';
                    $pageContent .= '</div>'; // eof .table-responsive

                    $pageContent .= '</div>'; // eof #lfb_customerOrders
                    $pageContent .= '</div>'; // eof #lfb_accountInfosPanel
                    $pageContent .= '</div>'; // eof #lfb_custAccountPanel
                }
            }
            if (!$chkCustomer) {
                $pageContent .= '<div id="lfb_custAccountLoginPanel">';
                $pageContent .= '<div class="form-group">';
                $pageContent .= '<label for="lfb_custAccountLoginEmail">' . $settings->customersDataLabelEmail . '</label>';
                $pageContent .= '<input class="form-control" type="email" name="email" id="lfb_custAccountLoginEmail" />';
                $pageContent .= '</div>';
                $pageContent .= '<div class="form-group">';
                $pageContent .= '<label for="lfb_custAccountLoginPass">' . $settings->customersDataLabelPass . '</label>';
                $pageContent .= '<input class="form-control" type="password" name="pass" id="lfb_custAccountLoginPass" />';
                $pageContent .= '<div><a href="javascript:" id="lfb_custAccountForgotPassLink">' . $settings->txtCustomersDataForgotPassLink . '</a></div>';

                $pageContent .= '</div>';

                $pageContent .= '<p class="text-center"><a href="javascript:" data-action="loginCustAccount" class="btn btn-primary"><span class="fas fa-check"></span>' . $settings->customersDataLabelBtnLogin . '</a></p>';

                $pageContent .= '</div>';
            }
            $pageContent .= '</div></div>';
        }
        return $pageContent;
    }

    public function frontend_enqueue_styles($hook = '') {
        $settings = $this->getSettings();

        if ($settings->enableCustomerAccount) {
            $this->initSession();
        }
        global $post;
        if (isset($post->post_title) && $post->post_title == __('Form preview', 'lfb')) {
            global $wp_styles;
            wp_register_style($this->_token . '-designerFrontend', esc_url($this->assets_url) . 'css/lfb_formDesigner_frontend.min.css', array(), $this->_version);
            wp_enqueue_style($this->_token . '-designerFrontend');


            wp_register_style($this->_token . '-visualFrontend', esc_url($this->assets_url) . 'css/lfb_visualFrontend.min.css', array(), $this->_version);
            wp_enqueue_style($this->_token . '-visualFrontend');
        }

        if ($this->formToPayKey != "" || $this->modeManageData || ($settings->enableCustomerAccount && get_the_ID() == $settings->customerAccountPageID)) {

            wp_register_style($this->_token . '-reset', esc_url($this->assets_url) . 'css/reset.min.css', array(), $this->_version);
            wp_register_style($this->_token . '-bootstrap', esc_url($this->assets_url) . 'css/bootstrap.min.css', array(), $this->_version);
            wp_register_style($this->_token . '-bootstrap-select', esc_url($this->assets_url) . 'css/bootstrap-select.min.css', array(), $this->_version);
            wp_register_style($this->_token . '-flat-ui', esc_url($this->assets_url) . 'css/flat-ui_frontend.min.css', array(), $this->_version);
            wp_register_style($this->_token . '-dropzone', esc_url($this->assets_url) . 'css/dropzone.min.css', array(), $this->_version);
            wp_register_style($this->_token . '-colpick', esc_url($this->assets_url) . 'css/colpick.min.css', array(), $this->_version);
            wp_register_style($this->_token . '-fontawesome', esc_url($this->assets_url) . 'css/font-awesome.min.css', array(), $this->_version);
            wp_register_style($this->_token . '-estimationpopup', esc_url($this->assets_url) . 'css/lfb_forms.min.css', array(), $this->_version);
            wp_enqueue_style($this->_token . '-reset');
            wp_enqueue_style($this->_token . '-bootstrap');
            wp_enqueue_style($this->_token . '-bootstrap-select');
            wp_enqueue_style($this->_token . '-flat-ui');
            wp_enqueue_style($this->_token . '-dropzone');
            wp_enqueue_style($this->_token . '-colpick');
            wp_enqueue_style($this->_token . '-fontawesome');
            wp_enqueue_style($this->_token . '-estimationpopup');
        }

        if ($settings->enableCustomerAccount && get_the_ID() == $settings->customerAccountPageID) {
            wp_register_style($this->_token . '-accountManagement', esc_url($this->assets_url) . 'css/lfb_accountManagement.min.css', array(), $this->_version);
            wp_enqueue_style($this->_token . '-accountManagement');
        }

        if ($this->modeManageData) {
            wp_register_style($this->_token . '-manageDatas', esc_url($this->assets_url) . 'css/lfb_manageDatas.min.css', array(), $this->_version);
            wp_enqueue_style($this->_token . '-manageDatas');
        }
    }

    private function jsonRemoveUnicodeSequences($struct) {
        return json_encode($struct, JSON_UNESCAPED_UNICODE);
//return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
    }

    public function conditionally_add_scripts_and_styles($posts) {
        if (empty($posts))
            return $posts;
        global $wpdb;
        if (!$this->checkedSc) {
            $shortcode_found = false;
            $form_id = 0;
            $this->currentForms[] = array();

            foreach ($posts as $post) {
                $lastPos = 0;
                $post_content = $post->post_content;

                while (($lastPos = strpos($post_content, '[estimation_form', $lastPos)) !== false) {
                    $shortcode_found = true;
                    $this->checkedSc = true;
                    $pos_start = strpos($post_content, 'form_id="', $lastPos + 16) + 9;
                    // $pos_start = strpos($post->post_content, 'form_id="', $lastPos + 16) + 9;
// $pos_end=strpos($post->post_content, '"', strpos($post->post_content, 'form_id="', strpos($post->post_content, '[estimation_form') + 16) + 10)-1;
                    $pos_end = strpos($post_content, '"', $pos_start);
                    $form_id = substr($post_content, $pos_start, $pos_end - $pos_start);
                    if ($form_id && $form_id > 0 && !is_array($form_id)) {
                        $this->currentForms[] = $form_id;
                    } else {
                        $table_name = $wpdb->prefix . "wpefc_forms";
                        $formReq = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC LIMIT 1");
                        if (count($formReq) > 0) {
                            $form = $formReq[0];
                            if (!in_array($form->id, $this->currentForms)) {
                                $this->currentForms[] = $form->id;
                            }
                        }
                    }
                    $lastPos = $lastPos + 16;
                }

                $detectedCSFormsIDs = apply_filters('cost_estimation_get_ids', $post);
                if (is_array($detectedCSFormsIDs) && count($detectedCSFormsIDs) > 0) {
                    $shortcode_found = true;
                    foreach ($detectedCSFormsIDs as $formID) {
                        if (!in_array($formID, $this->currentForms)) {
                            $this->currentForms[] = $formID;
                        }
                    }
                }
            }

            if (!is_admin() && isset($_SERVER['HTTP_REFERER'])) {
                wp_register_style($this->_token . '-reset', esc_url($this->assets_url) . 'css/reset.min.css', array(), $this->_version);
                wp_register_style($this->_token . '-bootstrap', esc_url($this->assets_url) . 'css/bootstrap.min.css', array(), $this->_version);
                wp_register_style($this->_token . '-bootstrap-select', esc_url($this->assets_url) . 'css/bootstrap-select.min.css', array(), $this->_version);
                wp_register_style($this->_token . '-flat-ui', esc_url($this->assets_url) . 'css/flat-ui_frontend.min.css', array(), $this->_version);
                wp_register_style($this->_token . '-dropzone', esc_url($this->assets_url) . 'css/dropzone.min.css', array(), $this->_version);
                wp_register_style($this->_token . '-colpick', esc_url($this->assets_url) . 'css/colpick.min.css', array(), $this->_version);
                wp_register_style($this->_token . '-fontawesome', esc_url($this->assets_url) . 'css/font-awesome.min.css', array(), $this->_version);
                wp_register_style($this->_token . '-estimationpopup', esc_url($this->assets_url) . 'css/lfb_forms.min.css', array(), $this->_version);
                wp_enqueue_style($this->_token . '-reset');
                wp_enqueue_style($this->_token . '-bootstrap');
                wp_enqueue_style($this->_token . '-bootstrap-select');
                wp_enqueue_style($this->_token . '-flat-ui');
                wp_enqueue_style($this->_token . '-dropzone');
                wp_enqueue_style($this->_token . '-colpick');
                wp_enqueue_style($this->_token . '-fontawesome');
                wp_enqueue_style($this->_token . '-estimationpopup');
            } else if (!is_admin() && !$shortcode_found && defined('CNR_DEV')) {
                $table_name = $wpdb->prefix . "wpefc_forms";
                $formReq = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
                if (count($formReq) > 0) {
                    $shortcode_found = true;
                    $this->checkedSc = true;
                    foreach ($formReq as $form) {
                        if (!in_array($form->id, $this->currentForms)) {
                            $this->currentForms[] = $form->id;
                        }
                    }
                }
            }

            //loadAllPages
            $table_name = $wpdb->prefix . "wpefc_forms";
            $formReq = $wpdb->get_results("SELECT * FROM $table_name WHERE loadAllPages=1 ORDER BY id ASC");
            if (count($formReq) > 0) {
                $shortcode_found = true;
                $this->checkedSc = true;
                foreach ($formReq as $form) {
                    if (!in_array($form->id, $this->currentForms)) {
                        $this->currentForms[] = $form->id;
                    }
                }
            }
            global $post;
            if (isset($post->post_title) && $post->post_title == __('Form preview', 'lfb')) {
                $shortcode_found = true;
                if (!in_array(sanitize_text_field($_GET['form']), $this->currentForms)) {
                    $this->currentForms[] = sanitize_text_field($_GET['form']);
                }
            }

            if ($shortcode_found && count($this->currentForms) > 0 && !is_admin()) {
                $settings = $this->getSettings();

                // styles                             
                wp_register_style($this->_token . '-frontend-libs', esc_url($this->assets_url) . 'css/lfb_frontendPackedLibs.min.css', array(), $this->_version);
                wp_enqueue_style($this->_token . '-frontend-libs');
                wp_register_style($this->_token . '-estimationpopup', esc_url($this->assets_url) . 'css/lfb_forms.min.css', array($this->_token . '-frontend-libs'), $this->_version);
                wp_enqueue_style($this->_token . '-estimationpopup');

                // scripts            
                wp_register_script($this->_token . '-frontend-libs', esc_url($this->assets_url) . 'js/lfb_frontendPackedLibs.min.js', array("jquery-ui-core", "jquery-ui-tooltip", "jquery-ui-slider", "jquery-ui-position", "jquery-ui-datepicker"), $this->_version);
                wp_enqueue_script($this->_token . '-frontend-libs');
                wp_register_script('touchpunch', esc_url($this->assets_url) . 'js/jquery.ui.touch-punch.min.js', array($this->_token . '-frontend-libs'), $this->_version);
                wp_enqueue_script('touchpunch');
                wp_register_script($this->_token . '-estimationpopup', esc_url($this->assets_url) . 'js/lfb_form.min.js', array($this->_token . '-frontend-libs', 'touchpunch'), $this->_version);


                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                $js_data = array();
                $formsDone = array();

                foreach ($this->currentForms as $formID) {

                    if ($formID > 0 && !is_array($formID)) {
                        if (!in_array($formID, $formsDone)) {
                            $formsDone[] = $formID;
                            $form = $this->getFormDatas($formID);

                            if ($form) {

                                if ($form->gmap_key != "") {
                                    $chkMap = false;

                                    $table_name = $wpdb->prefix . "wpefc_items";
                                    $itemsQt = $wpdb->get_results("SELECT * FROM $table_name WHERE formID=$formID AND useDistanceAsQt=1 ORDER BY id ASC");
                                    if (count($itemsQt) > 0) {
                                        $chkMap = true;
                                    }
                                    if (!$chkMap) {
                                        $itemsCalcul = $wpdb->get_results("SELECT * FROM $table_name WHERE useCalculation=1 AND formID=$formID ORDER BY id ASC");
                                        foreach ($itemsCalcul as $itemCalcul) {
                                            $lastPos = 0;
                                            while (($lastPos = strpos($itemCalcul->calculation, 'distance_', $lastPos)) !== false) {
                                                $chkMap = true;
                                                $lastPos += 9;
                                            }
                                        }
                                    }
                                    if (!$chkMap) {
                                        $itemsCalcul = $wpdb->get_results("SELECT * FROM $table_name WHERE useCalculationQt=1 AND formID=$formID ORDER BY id ASC");
                                        foreach ($itemsCalcul as $itemCalcul) {
                                            $lastPos = 0;
                                            while (($lastPos = strpos($itemCalcul->calculationQt, 'distance_', $lastPos)) !== false) {
                                                $chkMap = true;
                                                $lastPos += 9;
                                            }
                                        }
                                    }

                                    $libPlace = '';
                                    $itemsTxt = $wpdb->get_results("SELECT * FROM $table_name WHERE formID=$formID AND type='textfield' AND autocomplete=1 ORDER BY id ASC");
                                    if (count($itemsTxt) > 0) {
                                        $chkMap = true;
                                        $libPlace = ',places';
                                    }

                                    if ($chkMap) {
                                        wp_register_script($this->_token . '-gmap', '//maps.googleapis.com/maps/api/js?key=' . $form->gmap_key . '&libraries=geometry' . $libPlace . '', array());
                                        wp_enqueue_script($this->_token . '-gmap');
                                    }
                                }


                                if ($form->analyticsID != "") {
                                    $this->analyticsID = $form->analyticsID;
                                    add_action('wp_footer', array($this, 'add_googleanalytics'));
                                }
                                if (is_plugin_active('gravityforms/gravityforms.php') && $form->gravityFormID > 0 && !$this->is_enqueued_script($this->_token . '-estimationpopup')) {
                                    gravity_form_enqueue_scripts($form->gravityFormID, true);
                                    if (is_plugin_active('gravityformssignature/signature.php')) {
                                        wp_register_script('gforms_signature', esc_url($this->assets_url) . '../../gravityformssignature/super_signature/ss.js', array("gform_gravityforms"), $this->_version);
                                        wp_enqueue_script('gforms_signature');
                                    }
                                }
                                if ($form->use_stripe) {
                                    wp_enqueue_script($this->_token . '-stripe', 'https://js.stripe.com/v3/', true, 3);
                                }
                                if ($form->useCaptcha) {
                                    wp_enqueue_script($this->_token . '-recaptcha3', 'https://www.google.com/recaptcha/api.js?render=' . $form->recaptcha3Key, true, 3);
                                }
                                if ($form->use_razorpay) {
                                    wp_enqueue_script($this->_token . '-razorpay', 'https://checkout.razorpay.com/v1/checkout.js', true, 3);
                                }

                                if ($form->useSignature) {
                                    wp_register_script($this->_token . '-signature', esc_url($this->assets_url) . 'js/jquery.signature.min.js', array(), $this->_version);
                                    wp_enqueue_script($this->_token . '-signature');
                                }


                                if ($form->datepickerLang != "" && is_file($this->assets_dir . '/js/datepickerLocale/bootstrap-datetimepicker.' . $form->datepickerLang . '.js')) {

                                    wp_register_script($this->_token . '-datetimepicker-locale-' . $form->datepickerLang, esc_url($this->assets_url) . 'js/datepickerLocale/bootstrap-datetimepicker.' . $form->datepickerLang . '.js', array(), $this->_version);
                                    wp_enqueue_script($this->_token . '-datetimepicker-locale-' . $form->datepickerLang);
                                }

                                $table_name = $wpdb->prefix . "wpefc_links";

                                $links = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s", $formID));

                                $table_name = $wpdb->prefix . "wpefc_redirConditions";
                                $redirections = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s", $formID));

                                if ($form->decimalsSeparator == "") {
                                    $form->decimalsSeparator = '.';
                                }
                                $usePdf = 0;
                                if ($form->sendPdfCustomer || $form->sendPdfAdmin) {
                                    $usePdf = 1;
                                }
                                $form->fixedToPay = $form->paypal_fixedToPay;
                                $form->payMode = $form->paypal_payMode;
                                if ($form->use_stripe) {
                                    $form->percentToPay = $form->stripe_percentToPay;
                                    $form->fixedToPay = $form->stripe_fixedToPay;
                                    $form->payMode = $form->stripe_payMode;
                                }


                                $table_name = $wpdb->prefix . "wpefc_variables";
                                $variables = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s", $formID));

                                $pdfDownloadFilename = 'my-order';
                                if ($form->pdfDownloadFilename != '') {
                                    $pdfDownloadFilename = $form->pdfDownloadFilename;
                                }
                                $js_data[] = array(
                                    'currentRef' => 0,
                                    'refVarName' => 'ref',
                                    'homeUrl' => get_site_url(),
                                    'ajaxurl' => admin_url('admin-ajax.php'),
                                    'initialPrice' => $form->initial_price,
                                    'max_price' => $form->max_price,
                                    'percentToPay' => $form->percentToPay,
                                    'fixedToPay' => $form->fixedToPay,
                                    'payMode' => $form->payMode,
                                    'currency' => $form->currency,
                                    'currencyPosition' => $form->currencyPosition,
                                    'intro_enabled' => $form->intro_enabled,
                                    'save_to_cart' => $form->save_to_cart,
                                    'save_to_cart_edd' => $form->save_to_cart_edd,
                                    'colorA' => $form->colorA,
                                    'animationsSpeed' => $form->animationsSpeed,
                                    'email_toUser' => $form->email_toUser,
                                    'showSteps' => $form->showSteps,
                                    'formID' => $form->id,
                                    'gravityFormID' => $form->gravityFormID,
                                    'showInitialPrice' => $form->show_initialPrice,
                                    'disableTipMobile' => $form->disableTipMobile,
                                    'legalNoticeEnable' => $form->legalNoticeEnable,
                                    'links' => $links,
                                    'close_url' => $form->close_url,
                                    'redirections' => $redirections,
                                    'useRedirectionConditions' => $form->useRedirectionConditions,
                                    'usePdf' => $usePdf,
                                    'txt_yes' => __('Yes', 'lfb'),
                                    'txt_no' => __('No', 'lfb'),
                                    'txt_lastBtn' => $form->last_btn,
                                    'txt_btnStep' => $form->btn_step,
                                    'dateFormat' => stripslashes($this->dateFormatToDatePickerFormat(get_option('date_format'))),
                                    'datePickerLanguage' => $form->datepickerLang,
                                    'thousandsSeparator' => $form->thousandsSeparator,
                                    'decimalsSeparator' => $form->decimalsSeparator,
                                    'millionSeparator' => $form->millionSeparator,
                                    'billionsSeparator' => $form->billionsSeparator,
                                    'summary_hideQt' => $form->summary_hideQt,
                                    'summary_hideZero' => $form->summary_hideZero,
                                    'summary_hideZeroQt' => $form->summary_hideZeroQt,
                                    'summary_hidePrices' => $form->summary_hidePrices,
                                    'groupAutoClick' => $form->groupAutoClick,
                                    'filesUpload_text' => $form->filesUpload_text,
                                    'filesUploadSize_text' => $form->filesUploadSize_text,
                                    'filesUploadType_text' => $form->filesUploadType_text,
                                    'filesUploadLimit_text' => $form->filesUploadLimit_text,
                                    'sendContactASAP' => $form->sendContactASAP,
                                    'showTotalBottom' => $form->showTotalBottom,
                                    'stripePubKey' => $form->stripe_publishKey,
                                    'scrollTopMargin' => $form->scrollTopMargin,
                                    'redirectionDelay' => $form->redirectionDelay,
                                    'gmap_key' => $form->gmap_key,
                                    'txtDistanceError' => $form->txtDistanceError,
                                    'captchaUrl' => esc_url(trailingslashit(plugins_url('/includes/captcha/', $this->file))) . 'get_captcha.php',
                                    'summary_noDecimals' => $form->summary_noDecimals,
                                    'scrollTopPage' => $form->scrollTopPage,
                                    'disableDropdowns' => $form->disableDropdowns,
                                    'imgIconStyle' => $form->imgIconStyle,
                                    'summary_hideFinalStep' => $form->summary_hideFinalStep,
                                    'timeModeAM' => $form->timeModeAM,
                                    'enableShineFxBtn' => $form->enableShineFxBtn,
                                    'summary_showAllPricesEmail' => $form->summary_showAllPricesEmail,
                                    'imgTitlesStyle' => $form->imgTitlesStyle,
                                    'lastS' => $form->lastSave,
                                    'emptyWooCart' => $form->emptyWooCart,
                                    'sendUrlVariables' => $form->sendUrlVariables,
                                    'sendVariablesMethod' => $form->sendVariablesMethod,
                                    'enableZapier' => $form->enableZapier,
                                    'zapierWebHook' => $form->zapierWebHook,
                                    'summary_showDescriptions' => $form->summary_showDescriptions,
                                    'imgPreview' => esc_url($this->assets_url) . 'img/file-3-128.png',
                                    'progressBarPriceType' => $form->progressBarPriceType,
                                    'razorpay_publishKey' => $form->razorpay_publishKey,
                                    'razorpay_logoImg' => $form->razorpay_logoImg,
                                    'variables' => $variables,
                                    'useEmailVerification' => $form->useEmailVerification,
                                    'txt_emailActivationCode' => $form->txt_emailActivationCode,
                                    'txt_emailActivationInfo' => $form->txt_emailActivationInfo,
                                    'useCaptcha' => $form->useCaptcha,
                                    'recaptcha3Key' => $form->recaptcha3Key,
                                    'distancesMode' => $form->distancesMode,
                                    'enableCustomerAccount' => $settings->enableCustomerAccount,
                                    'txtCustomersDataForgotPassSent' => $form->txtForgotPassSent,
                                    'txtCustomersDataForgotPassLink' => $form->txtForgotPassLink,
                                    'emailCustomerLinks' => $form->emailCustomerLinks,
                                    'enablePdfDownload' => $form->enablePdfDownload,
                                    'useSignature' => $form->useSignature
                                );
                            }
                        }
                    }
                }
                wp_enqueue_script($this->_token . '-estimationpopup');
                wp_localize_script($this->_token . '-estimationpopup', 'wpe_forms', $js_data);

                add_action('wp_head', array($this, 'options_custom_styles'));
            }
        }


        return $posts;
    }

    private function is_enqueued_script($script) {
        return isset($GLOBALS['wp_scripts']->registered[$script]);
    }

    public function dateFormatToDatePickerFormat($dateFormat) {
        $chars = array(
            'd' => 'dd', 'j' => 'd', 'l' => 'DD', 'D' => 'D',
            'm' => 'mm', 'n' => 'm', 'F' => 'MM', 'M' => 'M',
            'Y' => 'yyyy', 'y' => 'y', 'S' => ''
        );
        if (strpos('F', $dateFormat) > -1) {
            $rep = 'YYYY-MM-DD';
        } else {
            $rep = strtr((string) $dateFormat, $chars);
        }
        return stripslashes($rep);
    }

    public function timeFormatToDatePickerFormat($timeFormat) {
        $chars = array(
            'G' => 'H', 'g' => 'H', 'h' => 'hh', 'H' => 'hh',
            'a' => 'p', 'A' => 'P', 'i' => 'ii'
        );
        if ($timeFormat == '') {
            $rep = 'hh:mm';
        } else {
            $rep = strtr((string) $timeFormat, $chars);
        }
        return stripslashes($rep);
    }

    public function timeFormatToCalendarFormat($timeFormat) {
        $chars = array(
            'G' => 'H', 'g' => 'H', 'h' => 'hh', 'H' => 'HH',
            /* 'a' => 't', 'A' => 't', */ 'i' => 'mm'
        );
        if ($timeFormat == '') {
            $rep = 'hh:mm';
        } else {
            $rep = strtr((string) $timeFormat, $chars);
        }
        return stripslashes($rep);
    }

    public function timeFormatToMomentFormat($timeFormat) {
        $chars = array(
            'G' => 'H', 'g' => 'H', 'h' => 'hh', 'H' => 'hh',
            'i' => 'mm'
        );
        if ($timeFormat == '') {
            $rep = 'hh:mm';
        } else {
            $rep = strtr((string) $timeFormat, $chars);
        }
        return stripslashes($rep);
    }

    public function add_googleanalytics() {
        if (!$this->checkAnalytics) {
            $this->checkAnalytics = true;
            echo "<script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', '" . $this->analyticsID . "', 'auto');
            ga('send', 'pageview');
          </script>";
        }
    }

    public function itemsSort() {
        if (current_user_can('manage_options')) {
            global $wpdb;
            $formID = intval($_POST['formID']);
            $stepID = intval($_POST['stepID']);

            $i = 0;
            $table_name = $wpdb->prefix . "wpefc_items";
            foreach ($_POST['itemsIDs'] as $itemID) {
                $wpdb->update($table_name, array('ordersort' => intval($_POST['indexes'][$i]), 'columnID' => sanitize_text_field($_POST['columnsIDs'][$i])), array('id' => $itemID));

                $i++;
            }
        }
    }

    public function getItemDom() {
        if (current_user_can('manage_options')) {
            global $wpdb;

            $itemID = intval($_POST['itemID']);
            $stepID = intval($_POST['stepID']);
            $formID = intval($_POST['formID']);


            $stepData = false;
            $isFinalStep = true;
            if ($stepID > 0) {
                $isFinalStep = false;
                $table_name = $wpdb->prefix . "wpefc_steps";
                $steps = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $stepID));
                if (count($steps) > 0) {
                    $stepData = $steps[0];
                }
            }

            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
            if (count($forms) > 0) {
                $form = $forms[0];
            }


            $table_name = $wpdb->prefix . "wpefc_items";
            if ($itemID == 0) {
                $sqlReq = "SELECT * FROM $table_name WHERE stepID=%s AND formID=%s AND columnID='' ORDER BY ordersort ASC";
                $items = $wpdb->get_results($wpdb->prepare($sqlReq, $stepID, $formID));
            } else {
                $sqlReq = "SELECT * FROM $table_name WHERE id=%s LIMIT 1";
                $items = $wpdb->get_results($wpdb->prepare($sqlReq, $itemID));
            }

            foreach ($items as $item) {
                echo $this->generateItemHtml($item, $form, $stepData, $isFinalStep);
            }
        }
        die();
    }

    public function generateItemHtml($dataItem, $form, $stepData, $isFinalStep) {
        global $wpdb;

        $settings = $this->getSettings();

        $response = '';
        $chkDisplay = true;
        $hiddenClass = '';
        $checked = '';
        $checkedCb = '';
        $prodID = 0;
        $wooVar = $dataItem->wooVariation;
        $eddVar = $dataItem->eddVariation;
        $itemRequired = '';
        $showInSummary = '';
        $useCalculation = '';
        $calculation = '';
        $useCalculationQt = '';
        $calculationQt = '';
        $useCalculationVar = '';
        $calculationVar = '';
        $useShowConditions = '';
        $useShowConditionsCt = '';
        $showConditionsOperator = '';
        $showConditions = '';
        $hideQtSummary = '';
        $hideZeroPriceSummary = '';

        $hidePriceSummary = '';
        $defaultValue = '';
        $activatePaypal = '';
        $cssWidth = '';

        $stepTitleTag = 'h2';
        if ($form->stepTitleTag != '') {
            $stepTitleTag = $form->stepTitleTag;
        }

        $conditionalWrapStart = '';
        $conditionalWrapEnd = '';
        if ($dataItem->icon != "") {
            if (strpos($dataItem->icon, ' ') === false) {
                $dataItem->icon = 'fa ' . $dataItem->icon;
            }
            $conditionalWrapStart = '<div class="input-group">';
            $conditionalWrapEnd = '</div>';
            if ($dataItem->iconPosition) {
                $conditionalWrapEnd = '<span class="input-group-addon" id="basic-addon1"><span class="fa ' . $dataItem->icon . '"></span></span>' . $conditionalWrapEnd;
            } else {
                $conditionalWrapStart = $conditionalWrapStart . '<span class="input-group-addon" id="basic-addon1"><span class="' . $dataItem->icon . '"></span></span>';
            }
        }

        if ($dataItem->defaultValue != "") {
            $defaultValue = 'value="' . $dataItem->defaultValue . '"';
        }

        if ($dataItem->hideQtSummary) {
            $hideQtSummary = 'data-hideqtsum="true"';
        }
        if ($dataItem->hidePriceSummary) {
            $hidePriceSummary = 'data-hidepricesum="true"';
        }
        if ($dataItem->hideInSummaryIfNull) {
            $hideZeroPriceSummary = 'data-hidezeropricesum="true"';
        }

        if ($dataItem->dontAddToTotal) {
            $dataItem->dontAddToTotal = 'no';
        }

        if ($dataItem->useShowConditions) {
            $useShowConditionsCt = 'lfb_disabled';
            $useShowConditions = 'data-useshowconditions="true"';
            $dataItem->showConditions = str_replace('"', "'", $dataItem->showConditions);
            $showConditions = 'data-showconditions="' . addslashes($dataItem->showConditions) . '"';
            $showConditionsOperator = 'data-showconditionsoperator="' . $dataItem->showConditionsOperator . '"';
        }

        if ($dataItem->useCalculation) {
            $useCalculation = 'data-usecalculation="true"';
            $calculation = 'data-calculation="' . addslashes($dataItem->calculation) . '"';
        }
        if ($dataItem->useCalculationQt) {
            $useCalculationQt = 'data-usecalculationqt="true"';
            $calculationQt = 'data-calculationqt="' . addslashes($dataItem->calculationQt) . '"';
        }
        if ($dataItem->modifiedVariableID > 0) {
            $useCalculationVar = 'data-usecalculationvar="' . $dataItem->modifiedVariableID . '"';
            $calculationVar = 'data-calculationvar="' . addslashes($dataItem->variableCalculation) . '"';
        }


        if ($dataItem->isRequired) {
            $itemRequired = 'data-required="true"';
        }
        if ($dataItem->ischecked == 1) {
            $checked = 'prechecked';
            $checkedCb = 'checked';
        }
        if ($dataItem->isHidden == 1) {
            $hiddenClass = 'lfb-hidden';
        }

        if ($dataItem->showInSummary == 1) {
            $showInSummary = 'data-showinsummary="true"';
        }
        if (is_plugin_active('woocommerce/woocommerce.php')) {
            if ($dataItem->wooProductID > 0) {
                $prodID = $dataItem->wooProductID;
                // $dataItem->dontAddToTotal = 0;

                try {
                    $product = new WC_Product($dataItem->wooProductID);

                    if (!$product->exists()) {
                        $chkDisplay = false;
                    } else {
                        if ($dataItem->wooVariation == 0) {
                            if ($dataItem->price == 0) {
                                $dataItem->price = $product->get_price();
                            }
                            if ($dataItem->type == 'slider') {
                                if ($product->get_stock_quantity() && $product->get_stock_quantity() < $dataItem->maxSize) {
                                    $dataItem->maxSize = $product->get_stock_quantity();
                                }
                            } else {
                                if ($product->get_stock_quantity() && $product->get_stock_quantity() < $dataItem->quantity_max) {
                                    $dataItem->quantity_max = $product->get_stock_quantity();
                                }
                            }
                            if (!$product->is_in_stock()) {
                                $chkDisplay = false;
                            }
                        } else {
                            $variable_product = new WC_Product_Variation($dataItem->wooVariation);

                            if ($dataItem->price == 0) {
                                $dataItem->price = $variable_product->get_price();
                            }
                            if ($dataItem->type == 'slider') {
                                if ($variable_product->get_stock_quantity() && $variable_product->get_stock_quantity() < $dataItem->maxSize) {
                                    $dataItem->maxSize = $product->get_stock_quantity();
                                }
                            } else {
                                if ($variable_product->get_stock_quantity() && $variable_product->get_stock_quantity() < $dataItem->quantity_max) {
                                    $dataItem->quantity_max = $variable_product->get_stock_quantity();
                                }
                            }
                            if (!$variable_product->is_in_stock()) {
                                $chkDisplay = false;
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $chkDisplay = false;
                }
            } else if ($form->save_to_cart) {
// $dataItem->price = 0;
            }
        }
        if ($dataItem->eddProductID > 0 && is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')) {
            $download = new EDD_Download($dataItem->eddProductID);
            $prodID = $dataItem->eddProductID;
            $dataItem->price = $download->price;
            //$dataItem->dontAddToTotal = 0;
            if ($dataItem->eddVariation > 0) {
                if (count($download->prices) > 0) {
                    $dataItem->price = $download->prices[$dataItem->eddVariation]['amount'];
                }
            }
        } else if ($form->save_to_cart_edd) {
            $dataItem->price = 0;
        }
        $dataItem->title = str_replace('"', "''", $dataItem->title);
        $originalTitle = $dataItem->title;
        $originaLabel = $dataItem->title;
        if ($dataItem->tooltipText != "" && $form->imgTitlesStyle == '') {
            $originalTitle = $dataItem->tooltipText;
        }
        $dataShowPrice = "";
        if ($dataItem->showPrice) {
            $dataShowPrice = 'data-showprice="1"';
            if (!$dataItem->useCalculation) {
                if ($form->currencyPosition == 'right') {
                    if ($dataItem->operation == "+") {
                        $dataItem->title = $dataItem->title . " : <strong>" . $this->getFormatedPrice($dataItem->price, $form) . $form->currency . '</strong>';
                    }
                    if ($dataItem->operation == "-") {
                        $dataItem->title = $dataItem->title . " : <strong>-" . $this->getFormatedPrice($dataItem->price, $form) . $form->currency . '</strong>';
                    }
                    if ($dataItem->operation == "x") {
                        $dataItem->title = $dataItem->title . " : <strong>+" . $this->getFormatedPrice($dataItem->price, $form) . '%' . '</strong>';
                    }
                    if ($dataItem->operation == "/") {
                        $dataItem->title = $dataItem->title . " : <strong>-" . $this->getFormatedPrice($dataItem->price, $form) . '%' . '</strong>';
                    }
                } else {
                    if ($dataItem->operation == "+") {
                        $dataItem->title = $dataItem->title . " : <strong>" . $form->currency . $this->getFormatedPrice($dataItem->price, $form) . '</strong>';
                    }
                    if ($dataItem->operation == "-") {
                        $dataItem->title = $dataItem->title . " : <strong>-" . $form->currency . $this->getFormatedPrice($dataItem->price, $form) . '</strong>';
                    }
                    if ($dataItem->operation == "x") {
                        $dataItem->title = $dataItem->title . " : <strong>+" . $this->getFormatedPrice($dataItem->price, $form) . '%' . '</strong>';
                    }
                    if ($dataItem->operation == "/") {
                        $dataItem->title = $dataItem->title . " : <strong>-" . $this->getFormatedPrice($dataItem->price, $form) . '%' . '</strong>';
                    }
                }
            }
        }
        $urlTag = "";
        if ($dataItem->urlTarget != "") {
            $urlTag .= 'data-urltarget="' . $dataItem->urlTarget . '" data-urltargetmode="' . $dataItem->urlTargetMode . '"';
        }
        $isSinglePrice = '';
        if ($form->isSubscription && $dataItem->priceMode == '') {
            $isSinglePrice = 'data-singleprice="true"';
        }


        if (!$settings->useVisualBuilder && $dataItem->type == 'row') {
            $chkDisplay = false;
        }


        if ($chkDisplay) {

            if ($settings->useVisualBuilder && $dataItem->columnID != '') {
                $colClass = $hiddenClass . ' lfb_item';
            } else {
                $colClass = 'col-md-2' . ' ' . $hiddenClass . ' lfb_item';
                if ($dataItem->useRow) {
                    $form->itemIndex = 0;
                    $colClass = 'col-md-12' . ' ' . $hiddenClass . ' lfb_item';
                } else {

                    if ($dataItem->isHidden == 0) {
                        if (!isset($form->itemIndex)) {
                            $form->itemIndex = 0;
                        } else {
                            $form->itemIndex++;
                        }
                    }
                    if ($stepData && $stepData->itemsPerRow > 0 && $form->itemIndex - 1 == $stepData->itemsPerRow) {
                        $form->itemIndex = 1;
                        $response .= '<br/>';
                    }
                }
            }
            $colClass .= ' lfb_itemContainer_' . $dataItem->id;
            $colClass .= ' ' . $useShowConditionsCt;
            $distanceQt = '';
            if ($dataItem->useDistanceAsQt && $dataItem->distanceQt != "") {
                $distanceQt = 'data-distanceqt="' . $dataItem->distanceQt . '"';
            }

            $activatePaypal = '';
            if ($dataItem->usePaypalIfChecked) {
                $activatePaypal = 'data-activatepaypal="true"';
            }
            $dontActivatePaypal = '';
            if ($dataItem->dontUsePaypalIfChecked) {
                $dontActivatePaypal = 'data-dontactivatepaypal="true"';
            }

            if ($dataItem->type == 'row') {


                $dataColumns = str_replace('"', "&quot;", $dataItem->columns);
                $response .= '<div class="itemBloc ' . $colClass . ' lfb_row row" data-id="' . $dataItem->id . '" data-columns="' . $dataColumns . '" data-itemtype="' . $dataItem->type . '">';
                $jsonColumns = json_decode($dataItem->columns);
                foreach ($jsonColumns as $column) {
                    $size = 'col';
                    if ($column->size == 'small') {
                        $size = 'col-md-2';
                    } else if ($column->size == 'medium') {
                        $size = 'col-md-4';
                    } else if ($column->size == 'large') {
                        $size = 'col-md-6';
                    } else if ($column->size == 'xl') {
                        $size = 'col-md-8';
                    } else if ($column->size == 'fullWidth') {
                        $size = 'col-md-12';
                    }
                    $response .= '<div class="lfb_column lfb_sortable ' . $size . '" data-columnid="' . $column->id . '">';



                    $table_nameItems = $wpdb->prefix . "wpefc_items";
                    $stepID = 0;
                    if ($isFinalStep) {
                        $stepID = 0;
                    } else if ($stepData) {
                        $stepID = $stepData->id;
                    }
                    $columnItems = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameItems WHERE formID=%s AND stepID=%s AND columnID='%s' ORDER BY ordersort ASC, id ASC", $form->id, $stepID, $column->id));
                    foreach ($columnItems as $columnItem) {
                        $response .= $this->generateItemHtml($columnItem, $form, $stepData, false);
                    }

                    $response .= '</div>';
                }
                $response .= '</div>';
            } else if ($dataItem->type == 'picture') {

                $response .= '<div class="itemBloc ' . $colClass . ' lfb_picRow" data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $group = '';
                if ($dataItem->groupitems != "") {
                    $group = 'data-group="' . $dataItem->groupitems . '"';
                }
                $tooltipPosition = 'bottom';
                if ($form->qtType == 1) {
                    $tooltipPosition = 'top';
                }
                $svgClass = strtolower(substr($dataItem->image, -4));
                if (strtolower(substr($dataItem->image, -4)) == '.svg') {
                    $svgClass = 'lfb_imgSvg';
                }
                $tooltipAttr = 'data-toggle="tooltip"';

                if ($form->imgTitlesStyle == "static") {
                    $tooltipAttr = '';
                }
                $response .= '<div data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" data-shadowfx="' . $dataItem->shadowFX . '" data-html="true"  class="selectable  ' . $checked . '" ' . $itemRequired . ' ' . $useCalculationQt . ' ' . $calculationQt . '  ' . $useCalculationVar . ' ' . $calculationVar . ' ' . $useCalculation . ' ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . ' ' . $calculation . ' ' . $distanceQt . ' ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . ' ' . $isSinglePrice . ' ' . $dataShowPrice . ' ' . $urlTag . ' ' . $showInSummary . ' data-woovar="' . $wooVar . '" data-eddvar="' . $eddVar . '" data-reduc="' . $dataItem->reduc_enabled . '" data-reducqt="' . $dataItem->reducsQt . '"  data-operation="' . $dataItem->operation . '" data-itemid="' . $dataItem->id . '"  ' . $group . '  data-prodid="' . $prodID . '" data-title="' . $dataItem->title . '" ' . $tooltipAttr . ' title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '" data-originallabel="' . $originaLabel . '" data-placement="' . $tooltipPosition . '" data-price="' . $dataItem->price . '" '
                        . 'data-addtototal="' . $dataItem->dontAddToTotal . '" data-iconstyle="' . $form->imgIconStyle . '" data-flipfx="' . $form->enableFlipFX . '"'
                        . ' data-quantityenabled="' . $dataItem->quantity_enabled . '" ' . $activatePaypal . ' ' . $dontActivatePaypal . '>';
                $tint = 'false';
                if ($dataItem->imageTint) {
                    $tint = 'true';
                }

                $styles = '';
                if ($dataItem->maxWidth > 0) {
                    $styles = 'max-width:' . $dataItem->maxWidth . 'px;';
                }
                if ($dataItem->maxHeight > 0) {
                    $styles .= 'max-height:' . $dataItem->maxHeight . 'px;';
                }

                $response .= '<img data-no-lazy="1" style="' . $styles . '" data-tint="' . $tint . '" src="' . $dataItem->image . '" alt="' . $dataItem->imageDes . '" class="lfb_selectableImg img ' . $svgClass . '" />';

                $defaultSelectorClass = 'fui-cross';
                $selectorFxClass = '';
                if ($form->imgIconStyle == 'zoom') {
                    $defaultSelectorClass = 'fui-check';
                    $selectorFxClass = 'lfb_fxZoom';
                }
                $response .= '<span class="palette-clouds ' . $defaultSelectorClass . ' ' . $selectorFxClass . ' icon_select"></span>';
                if ($dataItem->quantity_enabled) {
                    if (!$dataItem->useDistanceAsQt && $form->qtType == 1) {
                        $qtMax = '';
                        if ($dataItem->quantity_max > 0) {
                            $qtMax = 'max="' . $dataItem->quantity_max . '"';
                        } else {
                            $qtMax = 'max="999999999"';
                        }
                        if ($dataItem->quantity_min > 0) {
                            $qtMin = $dataItem->quantity_min . '"';
                        } else {
                            $qtMin = '1';
                        }
                        $response .= '<div class="form-group wpe_itemQtField">';
                        $response .= ' <input class="wpe_qtfield form-control" min="' . $qtMin . '" ' . $qtMax . ' type="number" value="' . $qtMin . '" /> ';

                        $response .= '</div>';
                    } else if (!$dataItem->useDistanceAsQt && $form->qtType == 2) {

                        $valMin = 1;
                        if ($dataItem->quantity_min > 0) {
                            $valMin = $dataItem->quantity_min;
                        }
                        if ($dataItem->sliderStep > 1) {
                            $dataItem->quantity_min = $dataItem->sliderStep;
                            $valMin = $dataItem->quantity_min;
                        }
                        $response .= '<div class="quantityBtns wpe_sliderQtContainer" data-stepslider="' . $dataItem->sliderStep . '" data-max="' . $dataItem->quantity_max . '" data-min="' . $dataItem->quantity_min . '">
                                                     <div class="wpe_sliderQt"></div>
                                                 </div>';
                        $response .= '<span class="palette-turquoise icon_quantity wpe_hidden">' . $valMin . '</span>';
                    } else {
                        $response .= '<div class="quantityBtns" data-max="' . $dataItem->quantity_max . '" data-min="' . $dataItem->quantity_min . '">
                                                <a href="javascript:" data-btn="less">-</a>
                                                <a href="javascript:" data-btn="more">+</a>
                                                </div>';
                        $valMin = 1;
                        if ($dataItem->quantity_min > 0) {
                            $valMin = $dataItem->quantity_min;
                        }
                        $response .= '<span class="palette-turquoise icon_quantity">' . $valMin . '</span>';
                    }
                }
                $response .= '</div>';
                if ($form->imgTitlesStyle == "static") {
                    $cssWidth = '';
                    if ($dataItem->useRow) {
                        $cssWidth = 'max-width: 100%;';
                    }
                    $response .= '<p class="lfb_imgTitle" style="' . $cssWidth . '">' . $dataItem->title . '</p>';
                }
                if ($dataItem->description != "") {
                    $cssWidth = '';
                    if ($dataItem->useRow) {
                        $cssWidth = 'max-width: 100%;';
                    }
                    $response .= '<p class="itemDes" style="' . $cssWidth . '">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
            } else if ($dataItem->type == 'imageButton') {
                $dataTooltip = '';
                if ($dataItem->tooltipText != "") {
                    $dataTooltip = 'data-toggle="tooltip"  data-placement="bottom" data-tooltiptext="' . $dataItem->tooltipText . '" data-tooltipimg="' . $dataItem->tooltipImage . '"';
                }

                $response .= '<div class="itemBloc ' . $colClass . ' lfb_picRow"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $group = '';
                if ($dataItem->groupitems != "") {
                    $group = 'data-group="' . $dataItem->groupitems . '"';
                }
                $tooltipPosition = 'bottom';
                $svgClass = strtolower(substr($dataItem->image, -4));
                if (strtolower(substr($dataItem->image, -4)) == '.svg') {
                    $svgClass = 'lfb_imgSvg';
                }
                $color = '';
                if ($dataItem->color != '') {
                    $color = 'style="background-color: ' . $dataItem->color . ';"';
                }
                $callNextstep = '';
                if ($dataItem->callNextStep) {
                    $callNextstep = 'data-callnextstep="1"';
                }

                $response .= '<div class="lfb_imageButtonContainer">';
                $response .= '<div class="lfb_imageButtonHeader">' . $dataItem->title . '</div>';
                $response .= '<img  class="lfb_imageButtonImg ' . $svgClass . '" src="' . $dataItem->image . '" data-placement="bottom" title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '"   alt="' . $dataItem->imageDes . '" />';
                //if($dataItem->description != ''){
                $response .= '<div class="lfb_imageButtonDescription">' . $dataItem->description . '</div>';
                //  }
                $response .= '<a  ' . $dataTooltip . '  ' . $activatePaypal . ' ' . $dontActivatePaypal . '  data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" class="lfb_button lfb_imageButton btn btn-primary btn-wide ' . $checked . '" ' . $callNextstep . ' ' . $color . ' ' . $itemRequired . ' ' . $useCalculationQt . ' ' . $calculationQt . ' ' . $useCalculationVar . ' ' . $calculationVar . ' ' . $useCalculation . ' ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . '  ' . $calculation . ' ' . $distanceQt . ' ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . ' ' . $isSinglePrice . ' ' . $dataShowPrice . ' ' . $urlTag . ' ' . $showInSummary . ' data-woovar="' . $wooVar . '" data-eddvar="' . $eddVar . '" data-operation="' . $dataItem->operation . '" data-itemid="' . $dataItem->id . '"  ' . $group . '  data-prodid="' . $prodID . '" data-title="' . $dataItem->title . '"  title="' . $dataItem->title . '"  data-originallabel="' . $originaLabel . '"  data-originaltitle="' . $originalTitle . '"  data-price="' . $dataItem->price . '" data-addtototal="' . $dataItem->dontAddToTotal . '">';
                if ($dataItem->icon != "" && $dataItem->iconPosition == 0) {
                    $response .= '<span class="fa ' . $dataItem->icon . '"></span>';
                }
                $response .= $dataItem->buttonText;
                if ($dataItem->icon != "" && $dataItem->iconPosition == 1) {
                    $response .= '<span class="fa ' . $dataItem->icon . ' lfb_iconRight"></span>';
                }
                $response .= '</a>';

                $response .= '</div>';


                $response .= '</div>';
            } else if ($dataItem->type == 'datepicker') {

                $daysWeek = '';
                $hoursDisabled = '';
                if ($dataItem->calendarID > 0) {
                    $table_name = $wpdb->prefix . "wpefc_calendars";
                    $calendarData = $wpdb->get_results("SELECT * FROM $table_name WHERE id=" . $dataItem->calendarID . " LIMIT 1");
                    if (count($calendarData) > 0) {
                        $calendarData = $calendarData[0];
                        $daysWeek = $calendarData->unavailableDays;
                        $hoursDisabled = $calendarData->unavailableHours;
                    }
                }


                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div class="form-group">';
                if ($dataItem->useAsDateRange) {
                    $dataItem->eventDuration = 0;
                }
                $response .= '<label>' . $dataItem->title . '</label>
                        ' . $conditionalWrapStart . '<input data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" readonly="true" type="text"  placeholder="' . $dataItem->placeholder . '" data-itemid="' . $dataItem->id . '"  ' . $showInSummary . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . ' ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . '  class="form-control lfb_datepicker" ' . $itemRequired . ' data-title="' . $dataItem->title . '"  data-originallabel="' . $originaLabel . '"  data-originaltitle="' . $originalTitle . '"  ' . $urlTag .
                        ' data-maxevents="' . $dataItem->maxEvents . '" data-startdays="' . $dataItem->startDateDays . '" data-allowpast="' . $dataItem->date_allowPast . '" data-showmonths="' . $dataItem->date_showMonths . '" data-showyears="' . $dataItem->date_showYears . '"'
                        . 'data-datetype="' . $dataItem->dateType . '" data-calendarid="' . $dataItem->calendarID . '" data-daysweek="' . $daysWeek . '" data-hoursdisabled="' . $hoursDisabled . '" '
                        . 'data-eventduration="' . $dataItem->eventDuration . '" data-eventdurationtype="' . $dataItem->eventDurationType . '" data-eventcategory="' . $dataItem->eventCategory . '" data-registerevent="' . $dataItem->registerEvent . '" data-eventbusy="' . $dataItem->eventBusy . '" '
                        . 'data-eventtitle="' . $dataItem->eventTitle . '" data-useasdaterange="' . $dataItem->useAsDateRange . '" data-enddaterangeid="' . $dataItem->endDaterangeID . '" data-disableminutes="' . $dataItem->disableMinutes . '" />' . $conditionalWrapEnd . '
                         ';

                $cssWidth = '';
                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . '">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
                $response .= '</div>';
            } else if ($dataItem->type == 'timepicker') {
                $dataTooltip = '';
                if ($dataItem->tooltipText != "") {
                    $dataTooltip = 'data-toggle="tooltip"  data-placement="bottom" data-tooltiptext="' . $dataItem->tooltipText . '"  data-tooltipimg="' . $dataItem->tooltipImage . '"';
                }
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div class="form-group">';
                $response .= '<label>' . $dataItem->title . '</label>
                ' . $conditionalWrapStart . '<input data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" type="text" ' . $dataTooltip . ' data-mintime="' . $dataItem->minTime . '"  placeholder="' . $dataItem->placeholder . '" data-maxtime="' . $dataItem->maxTime . '" data-itemid="' . $dataItem->id . '"  ' . $showInSummary . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . ' ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . '  class="form-control lfb_timepicker" ' . $itemRequired . ' data-title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '"  ' . $urlTag . '/>' . $conditionalWrapEnd;

                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . '">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
                $response .= '</div>';
            } else if ($dataItem->type == 'filefield_') {
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                if ($dataItem->fileSize == 0) {
                    $dataItem->fileSize = 25;
                }
                $response .= '<div class="form-group">
                            <label>' . $dataItem->title . '</label>
                            ' . $conditionalWrapStart . '<input type="file" ' . $itemRequired . ' data-filesize="' . $dataItem->fileSize . '"  ' . $showInSummary . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . ' ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . ' class="lfb_filefield"  name="file_' . $dataItem->id . '" data-itemid="' . $dataItem->id . '" data-title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '"  ' . $urlTag . '  />' . $conditionalWrapEnd . '
                            </div>
                            ';
                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . '">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
            } else if ($dataItem->type == 'filefield') {
                if ($dataItem->fileSize == 0) {
                    $dataItem->fileSize = 25;
                }
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '"  data-itemtype="' . $dataItem->type . '">';
                $response .= '<label>' . $dataItem->title . '</label>';
                $response .= '<div class="lfb_dropzone dropzone"  data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" data-filesize="' . $dataItem->fileSize . '" ' . $itemRequired . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . ' ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . ' ' . $showInSummary . ' data-allowedfiles="' . $dataItem->allowedFiles . '" data-maxfiles="' . $dataItem->maxFiles . '" id="lfb_dropzone_' . $dataItem->id . '" data-itemid="' . $dataItem->id . '" data-title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '" ></div>';

                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . '; margin-top: 6px !important;">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
            } else if ($dataItem->type == 'qtfield') {
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div class="form-group">';
                $response .= '<label>' . $dataItem->title . '</label>';
                $qtMax = '';
                if ($qtMax > 0) {
                    $qtMax = 'max="' . $dataItem->quantity_max . '"';
                }
                $response .= ' <input  ' . $urlTag . '  ' . $showInSummary . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . ' ' . $useShowConditions . ' ' . $showConditions . '  ' . $isSinglePrice . '  class="wpe_qtfield form-control" min="0" ' . $qtMax . ' ' . $dataShowPrice . ' type="number" value="0" data-reduc="' . $dataItem->reduc_enabled . '" data-price="' . $dataItem->price . '"  data-addtototal="' . $dataItem->dontAddToTotal . '" data-reducqt="' . $dataItem->reducsQt . '" data-operation="' . $dataItem->operation . '" data-itemid="' . $dataItem->id . '" class="form-control" data-title="' . $dataItem->title . '" /> ';
                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
                $response .= '</div>';
            } else if ($dataItem->type == 'textarea') {
                $dataTooltip = '';
                if ($dataItem->tooltipText != "") {
                    $dataTooltip = 'data-toggle="tooltip"  data-placement="bottom" data-tooltiptext="' . $dataItem->tooltipText . '"  data-tooltipimg="' . $dataItem->tooltipImage . '"';
                }
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div class="form-group">';
                $response .= '<label>' . $dataItem->title . '</label>
                 <textarea ' . $dataTooltip . '  data-urlvariable="' . $dataItem->sendAsUrlVariable . '"  data-variablename="' . $dataItem->variableName . '" placeholder="' . $dataItem->placeholder . '"  data-type="' . $dataItem->type . '" data-itemid="' . $dataItem->id . '"  ' . $useShowConditions . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . '  ' . $showConditions . ' ' . $showConditionsOperator . ' ' . $showInSummary . ' ' . $urlTag . ' class="form-control" ' . $itemRequired . ' data-title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '" >' . $dataItem->defaultValue . '</textarea>';
                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
                $response .= '</div>';
            } else if ($dataItem->type == 'select') {
                $dataTooltip = '';

                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $dropClass = "lfb_selectpicker";
                if ($form->disableDropdowns) {
                    $dropClass = "";
                }
                $firstVDisabled = '';
                if ($dataItem->firstValueDisabled) {
                    $firstVDisabled = 'data-firstvaluedisabled="true"';
                }
                if ($form->disableDropdowns == 0) {
                    $conditionalWrapStart = '';
                    $conditionalWrapEnd = '';
                }
                $response .= '
                    <div class="form-group">
                    <label>' . $dataItem->title . '</label>';
                if ($dataItem->tooltipText != "") {
                    $originalTitle = $dataItem->tooltipText;
                    $dataTooltip = 'data-toggle="tooltip"   data-placement="bottom" data-tooltiptext="' . $dataItem->tooltipText . '" data-tooltipimg="' . $dataItem->tooltipImage . '"';
                }
                $response .= $conditionalWrapStart . '<select ' . $dataTooltip . ' data-fieldtype="' . $dataItem->fieldType . '"  data-prodid="' . $prodID . '"  data-woovar="' . $wooVar . '" data-eddvar="' . $eddVar . '" data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" data-addtototal="' . $dataItem->dontAddToTotal . '" class="form-control ' . $dropClass . ' " ' . $itemRequired . ' ' . $firstVDisabled . ' ' . $useShowConditions . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . '  ' . $showConditions . ' ' . $showConditionsOperator . ' ' . $showInSummary . ' ' . $isSinglePrice . '  data-operation="' . $dataItem->operation . '"  data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '"   ' . $urlTag . '  data-itemid="' . $dataItem->id . '"  data-title="' . $dataItem->title . '" >';

                if ($dataItem->isCountryList) {
                    $response .= '<option value="Afghanistan">Afghanistan</option>
                <option value="Åland Islands">Åland Islands</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                <option value="Brunei Darussalam">Brunei Darussalam</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote D\'ivoire">Cote D\'ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Territories">French Southern Territories</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guernsey">Guernsey</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-bissau">Guinea-bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Isle of Man">Isle of Man</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jersey">Jersey</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Korea">Korea</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Lao People\'s Democratic Republic">Lao People\'s Democratic Republic</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macao">Macao</option>
                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                <option value="Moldova, Republic of">Moldova, Republic of</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Netherlands Antilles">Netherlands Antilles</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn">Pitcairn</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russian Federation">Russian Federation</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia">Serbia</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-leste">Timor-leste</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viet Nam">Viet Nam</option>
                <option value="Virgin Islands, British">Virgin Islands, British</option>
                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>';
                } else {
                    $optionsArray = explode('|', $dataItem->optionsValues);
                    foreach ($optionsArray as $option) {
                        if ($option != "") {
                            $value = $option;
                            $price = 0;
                            if (strpos($option, ";;") > 0) {
                                $optionArr = explode(";;", $option);
                                $value = $optionArr[0];
                                $price = $optionArr[1];
                            }
                            $response .= '<option value="' . $value . '"  data-price="' . $price . '" >' . $value . '</option>';
                        }
                    }
                }
                $response .= '</select>' . $conditionalWrapEnd . '</div>';
                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
            } else if ($dataItem->type == 'rate') {
                $maxLength = 'data-max="5"';
                if ($dataItem->maxSize > 0) {
                    $maxLength = 'data-max="' . $dataItem->maxSize . '"';
                }
                $itemDescription = '';
                if ($dataItem->description != "") {
                    $itemDescription .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '<div class="itemBloc  ' . $colClass . '" title="' . $dataItem->title . '" data-interval="' . $dataItem->sliderStep . '" ' . $showInSummary . ' ' . $maxLength . ' data-color="' . $dataItem->color . '" data-value="' . $dataItem->numValue . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '" data-itemid="' . $dataItem->id . '" data-title="' . $dataItem->title . '"  ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . '>'
                        . '<label>' . $dataItem->title . '</label>'
                        . '<div class="lfb_rate"></div>'
                        . $itemDescription
                        . '</div>';
            } else if ($dataItem->type == 'richtext') {
                $response .= '<div class="itemBloc lfb_richtext  ' . $colClass . '" ' . $showInSummary . '  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '" data-itemid="' . $dataItem->id . '" data-title="' . $dataItem->title . '"  ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . '>' . do_shortcode($dataItem->richtext) . '</div>';
            } else if ($dataItem->type == 'shortcode') {
                $response .= '<div class="itemBloc lfb_richtext lfb_shortcode ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '" data-itemid="' . $dataItem->id . '" data-title="' . $dataItem->title . '"  ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . '>' . do_shortcode($dataItem->shortcode) . '</div>';
            } else if ($dataItem->type == 'separator') {
                $response .= '<div data-itemid="' . $dataItem->id . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '" ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . '></div>';
            } else if ($dataItem->type == 'layeredImage') {
                $styles = '';
                if ($dataItem->maxWidth > 0) {
                    $styles = 'max-width:' . $dataItem->maxWidth . 'px;';
                }
                if ($dataItem->maxHeight > 0) {
                    $styles .= 'max-height:' . $dataItem->maxHeight . 'px;';
                }
                $response .= '<div class="clearfix"></div>';

                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div style="' . $styles . '" class=" lfb_layeredImage" data-itemid="' . $dataItem->id . '" data-title="' . $dataItem->title . '" ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . '>';

                $response .= '<img src="' . $dataItem->image . '" style="' . $styles . '" class="lfb_baseLayer"  alt="' . $dataItem->title . '" />';
                global $wpdb;
                $table_name = $wpdb->prefix . "wpefc_layeredImages";
                $layers = $wpdb->get_results("SELECT * FROM $table_name WHERE formID=$form->id AND itemID=$dataItem->id ORDER BY ordersort ASC");
                $i = 0;
                foreach ($layers as $layer) {
                    $conditions = str_replace('"', "'", $layer->showConditions);
                    $response .= '<img src="' . $layer->image . '" alt="' . $dataItem->title . '" data-showconditions="' . $conditions . '" data-showconditionsoperator="' . $layer->showConditionsOperator . '" />';
                    $i++;
                }
                $response .= '</div>';
                $response .= '</div>';
                $response .= '<div class="clearfix"></div>';
            } else if ($dataItem->type == 'checkbox') {
                $group = '';
                if ($dataItem->groupitems != "") {
                    $group = 'data-group="' . $dataItem->groupitems . '"';
                }
                $dataTooltip = '';
                if ($dataItem->tooltipText != "") {
                    $dataTooltip = 'data-toggle="tooltip"  data-placement="bottom" data-tooltiptext="' . $dataItem->tooltipText . '" data-tooltipimg="' . $dataItem->tooltipImage . '"';
                }
                $classCt = '';
                $checkboxStyle = 'data-checkboxstyle="switch"';
                if ($dataItem->checkboxStyle == 'checkbox') {
                    $classCt = 'class="checkboxCt  checkboxCt-primary"';
                    $checkboxStyle = 'data-checkboxstyle="checkbox"';
                } else if ($dataItem->checkboxStyle == 'radiobox') {
                    $classCt = 'class="radioCt radioCt-primary"';
                    $checkboxStyle = 'data-checkboxstyle="radiobox"';
                }

                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div ' . $dataTooltip . ' ' . $classCt . '>';
                if ($dataItem->checkboxStyle == 'switchbox') {
                    $response .= '<label for="cb_' . $dataItem->id . '">' . $dataItem->title . '</label>';
                }
                if (!$form->inlineLabels && $dataItem->checkboxStyle == 'switchbox') {
                    $response .= '<br/>';
                }

                $response .= '<input id="cb_' . $dataItem->id . '" data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" type="checkbox"  ' . $hideQtSummary . ' ' . $hidePriceSummary . '  ' . $hideZeroPriceSummary . ' ' . $group . ' ' . $useCalculationQt . ' ' . $calculationQt . ' ' . $useCalculationVar . ' ' . $calculationVar . ' ' . $useCalculation . ' ' . $activatePaypal . ' ' . $dontActivatePaypal . ' ' . $calculation . '  ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . ' ' . $showInSummary . ' ' . $isSinglePrice . '  class="' . $checked . '" ' . $urlTag . ' ' . $dataShowPrice . ' data-operation="' . $dataItem->operation . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '"  data-itemid="' . $dataItem->id . '" data-prodid="' . $prodID . '"  data-woovar="' . $wooVar . '" data-eddvar="' . $eddVar . '" ' . $itemRequired . '  data-toggle="switch" ' . $checkboxStyle . ' ' . $checkedCb . ' data-price="' . $dataItem->price . '"  data-addtototal="' . $dataItem->dontAddToTotal . '" data-title="' . $dataItem->title . '" />';

                if ($dataItem->checkboxStyle != 'switchbox') {
                    $response .= '<label for="cb_' . $dataItem->id . '">' . $dataItem->title . '</label>';
                }
                $response .= ' </div>';
                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
            } else if ($dataItem->type == 'button') {

                $dataTooltip = '';
                if ($dataItem->tooltipText != "") {
                    $dataTooltip = 'data-toggle="tooltip"  data-placement="bottom" data-tooltiptext="' . $dataItem->tooltipText . '" data-tooltipimg="' . $dataItem->tooltipImage . '"';
                }
                $response .= '<div class="itemBloc ' . $colClass . ' lfb_btnContainer"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $group = '';
                if ($dataItem->groupitems != "") {
                    $group = 'data-group="' . $dataItem->groupitems . '"';
                }
                $tooltipPosition = 'bottom';
                if ($form->qtType == 1) {
                    $tooltipPosition = 'top';
                }
                $svgClass = strtolower(substr($dataItem->image, -4));
                if (strtolower(substr($dataItem->image, -4)) == '.svg') {
                    $svgClass = 'lfb_imgSvg';
                }
                $color = '';
                if ($dataItem->color != '') {
                    $color = 'style="background-color: ' . $dataItem->color . ';"';
                }
                $callNextstep = '';
                if ($dataItem->callNextStep) {
                    $callNextstep = 'data-callnextstep="1"';
                }
                $response .= '<a  ' . $dataTooltip . ' ' . $activatePaypal . ' ' . $dontActivatePaypal . '  data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" class="lfb_button btn btn-primary btn-wide ' . $checked . '" ' . $callNextstep . ' ' . $color . ' ' . $itemRequired . ' ' . $useCalculationQt . ' ' . $calculationQt . ' ' . $useCalculationVar . ' ' . $calculationVar . ' ' . $useCalculation . ' ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . ' ' . $calculation . ' ' . $distanceQt . ' ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . ' ' . $isSinglePrice . ' ' . $dataShowPrice . ' ' . $urlTag . ' ' . $showInSummary . ' data-woovar="' . $wooVar . '" data-eddvar="' . $eddVar . '" data-operation="' . $dataItem->operation . '" data-itemid="' . $dataItem->id . '"  ' . $group . '  data-prodid="' . $prodID . '" data-title="' . $dataItem->title . '"  title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '"  data-price="' . $dataItem->price . '" data-addtototal="' . $dataItem->dontAddToTotal . '">';
                if ($dataItem->icon != "" && $dataItem->iconPosition == 0) {
                    $response .= '<span class="fa ' . $dataItem->icon . '"></span>';
                }
                $response .= $dataItem->title;
                if ($dataItem->icon != "" && $dataItem->iconPosition == 1) {
                    $response .= '<span class="fa ' . $dataItem->icon . ' lfb_iconRight"></span>';
                }
                $response .= '</a>';
                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
            } else if ($dataItem->type == 'colorpicker') {
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" style="background-color: ' . $form->colorA . ';"  ' . $useShowConditions . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . '  ' . $showConditions . ' ' . $showConditionsOperator . ' class="lfb_colorPreview checked" data-itemid="' . $dataItem->id . '"  ' . $urlTag . ' ' . $showInSummary . ' data-toggle="tooltip"  ' . $itemRequired . ' data-placement="bottom" data-title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '" ></div>'
                        . '<input type="text" value="' . $form->colorA . '" class="lfb_colorpicker" />'
                        . '<label class="lfb-hidden">' . $dataItem->title . '</label>';

                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto;' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
            } else if ($dataItem->type == 'numberfield') {
                $dataTooltip = '';
                if ($dataItem->tooltipText != "") {
                    $dataTooltip = 'data-toggle="tooltip"  data-placement="bottom" data-tooltiptext="' . $dataItem->tooltipText . '" data-tooltipimg="' . $dataItem->tooltipImage . '"';
                }
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div class="form-group">';
                $minLength = '';
                $maxLength = '';
//  if ($dataItem->minSize > 0) {
                $minLength = 'min="' . $dataItem->minSize . '"';
//  }
                if ($dataItem->maxSize > 0) {
                    $maxLength = 'max="' . $dataItem->maxSize . '"';
                }
                $response .= '<label>' . $dataItem->title . '</label>
                     ' . $conditionalWrapStart . '<input  data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" ' . $dataTooltip . ' data-type="' . $dataItem->type . '" type="number" ' . $useCalculationQt . ' ' . $calculationQt . ' ' . $useCalculationVar . ' ' . $calculationVar . ' data-reduc="' . $dataItem->reduc_enabled . '" data-reducqt="' . $dataItem->reducsQt . '"  data-price="' . $dataItem->price . '" ' . $isSinglePrice . '  data-operation="' . $dataItem->operation . '" data-addtototal="' . $dataItem->dontAddToTotal . '" ' . $useCalculation . ' ' . $calculation . ' data-valueasqt="' . $dataItem->useValueAsQt . '" placeholder="' . $dataItem->placeholder . '" ' . $useShowConditions . ' ' . $showConditions . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . '  ' . $showConditionsOperator . ' data-itemid="' . $dataItem->id . '" ' . $minLength . ' ' . $maxLength . ' ' . $showInSummary . ' ' . $urlTag . ' ' . $defaultValue . ' class="form-control" ' . $itemRequired . ' data-title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '"  />' . $conditionalWrapEnd . '
                  ';

                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
                $response .= '</div>';
            } else if ($dataItem->type == 'slider') {
                $dataShowPrice = '';
                if ($dataItem->showPrice) {
                    $dataShowPrice = 'data-showprice="1"';
                }
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $minLength = 'data-min="0"';
                $maxLength = 'data-max="30"';
                if ($dataItem->maxSize < $dataItem->minSize) {
                    $dataItem->minSize = $dataItem->maxSize;
                }
                if ($dataItem->minSize > 0) {
                    $minLength = 'data-min="' . $dataItem->minSize . '"';
                }
                if ($dataItem->sliderStep > 1 && $dataItem->minSize < $dataItem->sliderStep) {
                    $dataItem->minSize = $dataItem->sliderStep;
                }
                if ($dataItem->maxSize > 0) {
                    $maxLength = 'data-max="' . $dataItem->maxSize . '"';
                }


                $response .= '<label>' . $dataItem->title . '</label>
                    <div data-type="slider"  data-keeptooltip="' . $dataItem->visibleTooltip . '" data-urlvariable="' . $dataItem->sendAsUrlVariable . '" data-variablename="' . $dataItem->variableName . '" data-stepslider="' . $dataItem->sliderStep . '" ' . $distanceQt . '  ' . $dataShowPrice . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . ' ' . $hideZeroPriceSummary . '  ' . $isSinglePrice . '  data-reducqt="' . $dataItem->reducsQt . '" data-operation="' . $dataItem->operation . '" data-reduc="' . $dataItem->reduc_enabled . '" data-price="' . $dataItem->price . '"  data-addtototal="' . $dataItem->dontAddToTotal . '"  ' . $useCalculationQt . ' ' . $calculationQt . ' ' . $useCalculationVar . ' ' . $calculationVar . ' ' . $useCalculation . ' ' . $calculation . '  ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . ' data-itemid="' . $dataItem->id . '" ' . $minLength . ' ' . $maxLength . ' ' . $showInSummary . ' class="" data-title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '" data-prodid="' . $prodID . '"  data-eddvar="' . $eddVar . '" data-woovar="' . $wooVar . '"></div>
                    ';

                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
            } else {
                $dataTooltip = '';
                if ($dataItem->tooltipText != "") {
                    $dataTooltip = 'data-toggle="tooltip"  data-placement="bottom" data-tooltiptext="' . $dataItem->tooltipText . '" data-tooltipimg="' . $dataItem->tooltipImage . '"';
                }
                $response .= '<div class="itemBloc ' . $colClass . '"  data-id="' . $dataItem->id . '" data-itemtype="' . $dataItem->type . '">';
                $response .= '<div class="form-group">';
                $minLength = '';
                $maxLength = '';
                $autocomp = '';

                if ($dataItem->validation == 'custom') {
                    if ($dataItem->minSize > 0) {
                        $minLength = 'minlength="' . $dataItem->minSize . '"';
                    }
                    if ($dataItem->maxSize > 0) {
                        $maxLength = 'maxlength="' . $dataItem->maxSize . '"';
                    }
                }
                if ($dataItem->fieldType == 'email') {
                    $autocomp = 'autocomplete="on" name="email" ';
                }
                $validation = '';
                if ($dataItem->validation != '') {
                    $validation = 'data-validation="' . $dataItem->validation . '"';
                    if ($dataItem->validation == 'custom') {
                        $validation .= ' data-validmin="' . $dataItem->validationMin . '"';
                        $validation .= ' data-validmax="' . $dataItem->validationMax . '"';
                        $validation .= ' data-validcar="' . $dataItem->validationCaracts . '"';
                    }
                }
                if (strlen($form->gmap_key) < 3) {
                    $dataItem->autocomplete = 0;
                }
                $dataMask = '';
                if ($dataItem->validation == 'mask') {
                    $dataMask = 'data-mask="' . $dataItem->mask . '" ';
                }
                $response .= '<label>' . $dataItem->title . '</label>
                 ' . $conditionalWrapStart . '<input data-urlvariable="' . $dataItem->sendAsUrlVariable . '" ' . $dataMask . ' data-variablename="' . $dataItem->variableName . '" ' . $dataTooltip . ' data-type="' . $dataItem->type . '" type="text" ' . $validation . ' data-autocomplete="' . $dataItem->autocomplete . '" placeholder="' . $dataItem->placeholder . '" data-fieldtype="' . $dataItem->fieldType . '" ' . $defaultValue . '  ' . $hideQtSummary . ' ' . $hidePriceSummary . '  ' . $hideZeroPriceSummary . ' ' . $autocomp . ' ' . $useShowConditions . ' ' . $showConditions . ' ' . $showConditionsOperator . ' data-itemid="' . $dataItem->id . '" ' . $minLength . ' ' . $maxLength . ' ' . $showInSummary . ' ' . $urlTag . ' class="form-control" ' . $itemRequired . ' data-title="' . $dataItem->title . '" data-originaltitle="' . $originalTitle . '"  data-originallabel="' . $originaLabel . '"  />' . $conditionalWrapEnd . '
                ';
                if ($dataItem->useRow) {
                    $cssWidth = 'max-width: 90%;';
                }
                if ($dataItem->description != "") {
                    $response .= '<p class="itemDes" style="margin: 0 auto; ' . $cssWidth . ';">' . $dataItem->description . '</p>';
                }
                $response .= '</div>';
                $response .= '</div>';
            }
        }
        return $response;
    }

    /*
     * Shortcode to integrate a form in a page
     */

    public function wpt_shortcode($attributes, $content = null) {
        global $wpdb;
        $response = "";
        $popup = false;
        $fullscreen = false;
        extract(shortcode_atts(array(
            'form' => 0,
            'height' => 1000,
            'popup' => false,
            'step' => false,
            'fullscreen' => false,
            'form_id' => 0), $attributes));
        if (is_numeric($height)) {
            $height .= 'px';
        }
        if ($form_id == 0) {
            $table_name = $wpdb->prefix . "wpefc_forms";
            $formReq = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC LIMIT 1");
            $form = $formReq[0];
            $form_id = $form->id;
        }
        if ($form_id != "" && $form_id > 0 && !is_array($form_id)) {
            $startStep = $step;
            $table_name = $wpdb->prefix . "wpefc_forms";
            $forms = array();
            $formReq = $wpdb->get_results("SELECT * FROM $table_name WHERE id=" . $form_id . " LIMIT 1");
            if (count($formReq) > 0) {
                $form = $formReq[0];
                $settings = $this->getSettings();
                $fields = $this->getFieldDatas($form->id);
                $steps = $this->getStepsData($form->id);
                $items = $this->getItemsData($form->id);

                if (!$form->save_to_cart) {
                    $form->save_to_cart = '0';
                }
                $popupCss = '';
                $fullscreenCss = '';
                if ($popup) {
                    $popupCss = 'wpe_popup';
                }
                if ($fullscreen) {
                    $fullscreenCss = 'wpe_fullscreen';
                }
                $formSession = uniqid();
                $priceSubs = '';
                $priceSubsClass = '';
                $dataSubs = '';
                $dataIsSubs = '';
                if ($form->isSubscription) {
                    $dataIsSubs = 'data-isSubs="true"';
                }
                if ($form->isSubscription && $form->showSteps == 0) {
                    $priceSubsClass = 'lfb_subsPrice';
                    $priceSubs = '<span>' . $form->subscription_text . '</span>';
                    $dataSubs = $form->subscription_text;
                }
                $priceSubBottom = '';
                if ($form->isSubscription) {
                    $priceSubBottom = '<span class="lfb_subTxtBottom">' . $form->subscription_text . '</span>';
                }
                $dispIntro = '';
                if (!$form->intro_enabled) {
                    $dispIntro = 'display:none !important;';
                }
                $progressBarHide = '';
                if ($form->showSteps == 2) {
                    $progressBarHide = 'style="display: none !important;"';
                }
                $dataInlineLabels = '';
                if ($form->inlineLabels) {
                    $dataInlineLabels = 'data-inlinelabels="true"';
                }
                $dataAlignLeft = '';
                if ($form->alignLeft) {
                    $dataAlignLeft = 'data-alignleft="true"';
                }
                $dataPreviousStepBtn = '';
                if ($form->previousStepBtn) {
                    $dataPreviousStepBtn = 'data-previousstepbtn="true"';
                }
                $dataTotalRange = '';
                if ($form->totalIsRange) {
                    $dataTotalRange = 'data-totalrange="' . $form->totalRange . '" data-rangelabelbetween="' . $form->labelRangeBetween . '" data-rangelabeland="' . $form->labelRangeAnd . '" data-rangemode="' . $form->totalRangeMode . '"';
                }
                $datashowsteps = '';
                if ($form->showSteps) {
                    $datashowsteps = 'data-showsteps="true"';
                }
                $finalIcon = '';
                if ($form->finalButtonIcon != "") {
                    if (strpos($form->finalButtonIcon, ' ') === false) {
                        $form->finalButtonIcon = 'fa ' . $form->finalButtonIcon;
                    }
                    $finalIcon = '<span class="' . $form->finalButtonIcon . '"></span>';
                }
                $nextStepIcon = '';
                if ($form->nextStepButtonIcon != "") {
                    if (strpos($form->nextStepButtonIcon, ' ') === false) {
                        $form->nextStepButtonIcon = 'fa ' . $form->nextStepButtonIcon;
                    }
                    $nextStepIcon = '<span class="' . $form->nextStepButtonIcon . '"></span>';
                }
                $previousIcon = '';
                if ($form->previousStepButtonIcon != "") {
                    if (strpos($form->previousStepButtonIcon, ' ') === false) {
                        $form->previousStepButtonIcon = 'fa ' . $form->previousStepButtonIcon;
                    }
                    $previousIcon = '<span class="' . $form->previousStepButtonIcon . '"></span>';
                }
                $mainTitleTag = 'h1';
                if ($form->mainTitleTag != '') {
                    $mainTitleTag = $form->mainTitleTag;
                }
                $stepTitleTag = 'h2';
                if ($form->stepTitleTag != '') {
                    $stepTitleTag = $form->stepTitleTag;
                }

                $useVisual = false;


                $response .= '<div id="lfb_bootstraped" class="lfb_bootstraped"><div id="estimation_popup" data-usevisual="' . $settings->useVisualBuilder . '" data-progressbar="' . $form->showSteps . '" data-qttype="' . $form->qtType . '" data-imgtitlesstyle="' . $form->imgTitlesStyle . '" data-emaillaststep="' . $form->sendEmailLastStep . '" ' . $datashowsteps . ' ' . $dataTotalRange . ' ' . $dataIsSubs . ' ' . $dataInlineLabels . ' ' . $dataAlignLeft . ' ' . $dataPreviousStepBtn . ' data-formtitle="' . $form->title . '" data-formsession="' . $formSession . '" data-autoclick="' . $form->groupAutoClick . '"  data-subs="' . $dataSubs . '" data-form="' . $form_id . '" class="wpe_bootstraped ' . $popupCss . ' ' . $fullscreenCss . '" data-stylefields="' . $form->fieldsPreset . '" data-animspeed="' . $form->animationsSpeed . '" data-sumstepsclick="' . $form->summary_stepsClickable . '" data-sumhidesteps="' . $form->summary_hideStepsRows . '">
                <div id="lfb_loader"><div class="lfb_spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div></div>';


                $response .= '<div id="lfb_passModal" class="modal" data-backdrop="">'
                        . '<div class="modal-dialog">'
                        . '<div class="modal-content">'
                        . '<div class="modal-header">'
                        . '<span class="fas fa-lock"></span><span>' . $form->txtForgotPassLink . '</span>'
                        . '<a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span class="fas fa-times"></span></a>'
                        . '</div>'
                        . ' <div class="modal-body p-0">' . $form->txtForgotPassSent
                        . '</div>'   // eof .modal-body
                        . '<div class="modal-footer">'
                        . '<a href="javascript:"  data-dismiss="modal" class="btn btn-primary btn-circle"><span class="fas fa-check"></span></a>'
                        . '</div>' // eof.modal-footer
                        . '</div>'  // eof .modal-content
                        . '</div>'  // eof .modal-dialog
                        . '</div>'; // eof lfb_passModal

                $stripeImg = $this->assets_url . 'img/powered_by_stripe@2x.png';
                if ($form->stripe_logoImg != '') {
                    $stripeImg = $form->stripe_logoImg;
                }
                $response .= '<div id="lfb_stripeModal" class="modal" data-backdrop="">'
                        . '<div class="modal-dialog">'
                        . '<div class="modal-content">'
                        . '<div class="modal-header">'
                        . '<span class="fab fa-cc-stripe"></span><span>' . $form->txt_stripe_title . '</span>'
                        . '<a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span class="fas fa-times"></span></a>'
                        . '</div>'
                        . ' <div class="modal-body p-0">'
                        . '<div data-panel="form" class="p-2">'
                        . '<div class="lfb_amountTextContainer" class="p-2 mb-3 "><div class="m-0 lfb_amountText text-center pb-2">' . $form->txt_stripe_btnPay . ' :<br/> <strong data-info="amount">$5</strong></div></div>'
                        . '<form method="post" id="lfb_stripePaymentForm" class="pl-4 pr-4 pt-3" >'
                        . '<div class="form-group"><div id="lfb_stripe_card-element" class="form-control"></div></div>'
                        . '<div id="lfb_stripe_card-error"></div>'
                        . '<div class="form-group"><input placeholder="' . $form->txt_stripe_cardOwnerLabel . '" name="ownerName" class="form-control" type="text"/></div>'
                        . '</form>'
                        . '<div class="text-center lfb_stripeLogoContainer"><img class="lfb_stripeLogo" src="' . $stripeImg . '" alt="Powered by Stripe" /></div>'
                        . '</div>'   // eof [data-panel="form"]
                        . '<div data-panel="loading">'
                        . '<div class=" text-center">'
                        . '<span class="fas fa-hourglass-half big"></span>'
                        . '</div>'   // eof .bg-success
                        . '</div>'   // eof [data-panel="success"]
                        . '<div data-panel="fail">'
                        . '<div class="text-center">'
                        . '<p><span class="fas fa-times big"></span></p>'
                        . '<div>' . $form->txt_stripe_paymentFail . '</div>'
                        . '<div data-info="error" class="text-center"></div>'
                        . '</div>'   // eof .bg-danger
                        . '</div>'   // eof [data-panel="danger"]
                        . '</div>'   // eof .modal-body
                        . '<div class="modal-footer">'
                        . '<a href="javascript:" data-action="pay"  class="btn btn-primary"><span class="fas fa-check"></span>' . $form->txt_stripe_btnPay . '</a>'
                        . '</div>' // eof.modal-footer
                        . '</div>'  // eof .modal-content
                        . '</div>'  // eof .modal-dialog
                        . '</div>'; // eof lfb_stripeModal

                if ($form->enableFloatingSummary || $form->enableSaveForLaterBtn) {
                    $response .= '<div class="lfb_floatingSummaryBtnCtWrapper">';
                    $response .= '<div class="lfb_floatingSummaryBtnCt">';

                    if ($form->enableSaveForLaterBtn) {
                        $margRight = '0px';
                        if ($form->enableFloatingSummary) {
                            $margRight = '8px';
                        }
                        $btnCircleClass = '';
                        if ($form->saveForLaterIcon != "" && $form->saveForLaterLabel == "") {
                            $btnCircleClass = 'btn-circle';
                        }
                        if (strpos($form->saveForLaterIcon, ' ') === false) {
                            $form->saveForLaterIcon = 'fa ' . $form->saveForLaterIcon;
                        }

                        $response .= '<a href="javascript:" data-defaulttext="' . $form->saveForLaterLabel . '" data-deltext="' . $form->saveForLaterDelLabel . '" style="margin-right:' . $margRight . '" onclick="lfb_saveForLater(' . $form->id . ');" data-originalicon="' . $form->saveForLaterIcon . '" class="lfb_btnSaveForm btn btn-default ' . $btnCircleClass . '">';
                        if ($form->saveForLaterIcon != "") {
                            $response .= '<span class="' . $form->saveForLaterIcon . '"></span>';
                        }
                        $response .= '<span>' . $form->saveForLaterLabel . '</span>';
                        $response .= '</a>';
                    }


                    if ($form->enableFloatingSummary) {
                        $btnCircleClass = '';
                        if ($form->floatSummary_icon != "" && $form->floatSummary_label == "") {
                            $btnCircleClass = 'btn-circle';
                        }
                        $response .= '<a href="javascript:" onclick="lfb_toggleFloatingSummary(' . $form->id . ');" class="lfb_btnFloatingSummary btn btn-default ' . $btnCircleClass . ' disabled">';
                        if ($form->floatSummary_icon != "") {
                            if (strpos($form->floatSummary_icon, ' ') === false) {
                                $form->floatSummary_icon = 'fa ' . $form->floatSummary_icon;
                            }
                            $response .= '<span class="' . $form->floatSummary_icon . '"></span>';
                        }
                        $response .= $form->floatSummary_label;
                        $response .= '</a>';

                        $response .= '</div>';
                        $response .= '<div id="lfb_floatingSummary" data-numberstep="' . $form->floatSummary_numSteps . '" data-hideprices="' . $form->floatSummary_hidePrices . '"><div id="lfb_floatingSummaryInner"></div></div>';
                    } else {
                        $response .= '</div>';
                    }
                    $response .= '</div>';
                }

                $response .= '<a id="wpe_close_btn" href="javascript:"><span class="fui-cross"></span></a>
                <div id="wpe_panel">
                <div class="container-fluid">
                    <div class="row">
                        <div class="" >';
                if ($form->intro_enabled) {
                    $response .= '<div id="startInfos" style="' . $dispIntro . '">';
                    if ($form->intro_image != "") {
                        $response .= '<p style="text-align: center;"><img src="' . $form->intro_image . '" id="lfb_introImage" alt="' . $form->intro_title . '" /></p>';
                    }
                    $response .= '<' . $mainTitleTag . ' id="lfb_mainFormTitle">' . $form->intro_title . '</' . $mainTitleTag . '>
                        <p>' . $form->intro_text . '</p>
                            </div>';
                }

                $introIcon = '';
                if ($form->introButtonIcon != "") {
                    if (strpos($form->introButtonIcon, ' ') === false) {
                        $form->introButtonIcon = 'fa ' . $form->introButtonIcon;
                    }
                    $introIcon = '<span class="' . $form->introButtonIcon . '"></span>';
                }
                $response .= '<p class="lfb_startBtnContainer" style="' . $dispIntro . '">
                                <a href="javascript:" onclick="lfb_startFormIntro(' . $form->id . ');" class="btn btn-large btn-primary" id="btnStart">' . $introIcon . $form->intro_btn . '</a>
                            </p>';

                if ($form->showSteps != 3) {
                    $response .= ' <div id="genPrice" class="genPrice" ' . $progressBarHide . '>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 0%;">
                                        <div class="progress-bar-price ' . $priceSubsClass . '">
                                            <span>0$</span>
                                            ' . $priceSubs . '
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /genPrice -->';
                }
                $response .= '<' . $stepTitleTag . ' id="finalText" class="stepTitle">' . $form->succeed_text . '</' . $stepTitleTag . '>
                        </div>
                        <!-- /col -->
                    </div>
                    <!-- /row -->
                <div id="mainPanel" class="palette-clouds" data-savecart="' . $form->save_to_cart . '">';
                if ($form->showSteps == 3) {
                    $response .= ' <div id="lfb_stepper"><div id="lfb_stepperBar"></div></div>';
                }

                $response .= ' <input type="hidden" name="action" value="lfb_upload_form"/>
                <input type="hidden" id="lfb_formSession" name="formSession" value="' . $formSession . '"/>';
                $i = 0;

                foreach ($steps as $stepData) {
                    if ($stepData->formID == $form->id) {
                        $dataContent = json_decode($stepData->content);
                        if (!empty($dataContent) && isset($dataContent->start)) {

                            $required = '';
                            if ($stepData->itemRequired > 0) {
                                $required = 'data-required="true"';
                            }
                            if ($startStep) {
                                if ($startStep == $stepData->id) {
                                    $dataContent->start = 1;
                                } else {
                                    $dataContent->start = 0;
                                }
                            }
                            $useShowStepConditions = '';
                            $showStepConditionsOperator = '';
                            $showStepConditions = '';
                            if ($stepData->useShowConditions) {
                                $useShowStepConditions = 'data-useshowconditions="true"';
                                $stepData->showConditions = str_replace('"', "'", $stepData->showConditions);
                                $showStepConditions = 'data-showconditions="' . addslashes($stepData->showConditions) . '"';
                                $showStepConditionsOperator = 'data-showconditionsoperator="' . $stepData->showConditionsOperator . '"';
                            }

                            $stepWidth = '';
                            if ($stepData->maxWidth > 0) {
                                $stepWidth = 'max-width:' . $stepData->maxWidth . 'px';
                            }
                            $response .= '<div class="genSlide" style=" ' . $stepWidth . '" data-start="' . $dataContent->start . '" ' . $useShowStepConditions . ' ' . $showStepConditions . ' ' . $showStepConditionsOperator . ' data-showstepsum="' . $stepData->showInSummary . '" data-stepid="' . $stepData->id . '" data-title="' . $stepData->title . '" ' . $required . ' data-dependitem="' . $stepData->itemDepend . '">';
                            $response .= '	<' . $stepTitleTag . ' class="stepTitle">' . stripslashes($stepData->title) . '</' . $stepTitleTag . '>';
                            $contentNoDes = 'lfb_noDes';
                            if ($stepData->description != "") {
                                $response .= '	<p class="lfb_stepDescription">' . $stepData->description . '</p>';
                                $contentNoDes = '';
                            }
                            $response .= '	<div class="genContent container-fluid ' . $contentNoDes . '" >';
                            $response .= '		<div class="row lfb_row  lfb_sortable">';
                            $form->itemIndex = 0;

                            if ($settings->useVisualBuilder) {


                                $table_name = $wpdb->prefix . "wpefc_items";
                                $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE stepID=%s  AND columnID='' ORDER BY ordersort ASC, id ASC", $stepData->id));

                                foreach ($rows as $dataItem) {
                                    $response .= $this->generateItemHtml($dataItem, $form, $stepData, false);
                                }
                            } else {

                                foreach ($items as $dataItem) {

                                    if ($dataItem->stepID == $stepData->id) {
                                        $response .= $this->generateItemHtml($dataItem, $form, $stepData, false);
                                    }
                                }
                            }

                            $response .= ' </div>';
                            $response .= ' </div>';
                            if ($form->showTotalBottom) {
                                $response .= '<div class="lfb_totalBottomContainer ' . $priceSubsClass . '"><hr/><h3 class="lfb_totalBottom">
                                <span>0$</span>' . $priceSubBottom . '</h3></div>';
                            }
                            $response .= '<div class="errorMsg alert alert-danger">' . $form->errorMessage . '</div>';
                            // $response .= '<p style="margin-top: 22px; position: absolute; width: 100%;" class="text-center lfb_btnNextContainer">';
                            $response .= '<p class="text-center lfb_btnNextContainer">';
                            $hideNtxStepBtn = '';
                            if ($stepData->hideNextStepBtn) {
                                $hideNtxStepBtn = 'lfb-hidden lfb-btnNext-hidden';
                            }
                            $shineCanvas = '';
                            $response .= '<a href="javascript:" id="lfb_btnNext_' . $stepData->id . '" class="btn btn-wide btn-primary btn-next ' . $hideNtxStepBtn . '">' . $nextStepIcon . $form->btn_step . '</a>';

                            if ($dataContent->start == 0) {
                                $response .= '<br/><div class="lfb_linkPreviousCt"><a href="javascript:"  class="linkPrevious">' . $previousIcon . $form->previous_step . '</a></div>';
                            }
                            $response .= '</p>';

                            $response .= '</div>';
                            $i++;
                        }
                    }
                }

                $response .= '<div class="genSlide" id="finalSlide" data-stepid="final" data-title="' . $form->last_title . '">
                <' . $stepTitleTag . ' class="stepTitle">' . $form->last_title . '</' . $stepTitleTag . '>
                <div class="genContent">
                    <div class="row lfb_row genContentSlide active  lfb_sortable">
                        ';
                $dispFinalPrice = '';
                if ($form->hideFinalPrice == 1) {
                    $dispFinalPrice = "display:none;";
                }
                $response .= '<p id="lfb_finalLabel" style="' . $dispFinalPrice . '">' . $form->last_text . '</p>';
                $subTxt = '';
                if ($form->isSubscription == 1) {
                    $subTxt = '<span>' . $form->subscription_text . '</span>';
                }
                $response .= '<h3 id="finalPrice" style="' . $dispFinalPrice . '"><span></span>' . $subTxt . '</h3>';

                $response .= '<div id="lfb_subTxtValue" style="display: none;">' . $priceSubs . '</div>';


                if ($form->gravityFormID > 0) {
                    gravity_form($form->gravityFormID, $display_title = false, $display_description = true, $display_inactive = false, $field_values = null, $ajax = true);
                } else {
                    $fieldIndex = 0;
                    if ($settings->useVisualBuilder) {


                        $table_name = $wpdb->prefix . "wpefc_items";
                        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE stepID=0 AND formID=%s AND columnID='' ORDER BY ordersort ASC, id ASC", $form->id));

                        foreach ($rows as $dataItem) {
                            $response .= $this->generateItemHtml($dataItem, $form, null, false);
                        }
                    } else {

                        foreach ($fields as $field) {
                            if ($field->type != "row") {
                                $response .= $this->generateItemHtml($field, $form, null, true, $fieldIndex);
                                $fieldIndex++;
                            }
                        }
                    }
                }
                if ($form->useCoupons) {
                    $response .= '<div id="lfb_couponContainer" class="form-group">'
                            . '<input type="text" placeholder="' . $form->couponText . '" id="lfb_couponField" class="form-control"/>'
                            . '<a href="javascript:" id="lfb_couponBtn" onclick="lfb_applyCouponCode(' . $form->id . ');" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span></a>'
                            . '</div>';
                }

                $cssSum = '';
                $cssQtCol = '';
                if (!$form->useSummary) {
                    $cssSum = 'lfb-hidden';
                }
                if ($form->summary_hideQt) {
                    $cssQtCol = 'lfb-hidden';
                }
                $subTxt = '';
                if ($form->isSubscription == 1) {
                    $subTxt = '<span class="lfb_subTxt">' . $form->subscription_text . '</span>';
                }
                $priceHiddenClass = '';
                if ($form->summary_hidePrices == 1) {
                    $priceHiddenClass = 'lfb-hidden lfb_hidePrice';
                }
                $totalHiddenClass = '';
                if ($form->summary_hideTotal == 1) {
                    $totalHiddenClass = 'lfb-hidden lfb_hidePrice';
                }
                $response .= '
                   <div id="lfb_summary" class="table-responsive ' . $cssSum . '">
                        <h4>' . $form->summary_title . '</h4>
                        <table class="table table-bordered">
                            <thead>
                                <th>' . $form->summary_description . '</th>
                                <th class="lfb_valueTh">' . $form->summary_value . '</th>
                                <th class="lfb_quantityTh ' . $cssQtCol . '">' . $form->summary_quantity . '</th>
                                <th class="lfb_priceTh ' . $priceHiddenClass . '">' . $form->summary_price . '</th>
                            </thead>
                            <tbody>
                                <tr id="lfb_summaryDiscountTr" class="lfb_static ' . $priceHiddenClass . '"><th colspan="3">' . $form->summary_discount . '</th><th id="lfb_summaryDiscount"><span></span></th></tr>
                                <tr id="sfb_summaryTotalTr" class="lfb_static ' . $totalHiddenClass . '"><th colspan="3">' . $form->summary_total . '</th><th id="lfb_summaryTotal"><span></span>' . $subTxt . '</th></tr>
                            </tbody>
                        </table>
                    </div>';


                if ($form->legalNoticeEnable) {
                    $response .= '
                    <div id="lfb_legalNoticeContent">' . nl2br($form->legalNoticeContent) . '</div>
                    <div class="form-group" style=" margin-top: 14px;">
                      <label for="lfb_legalCheckbox">' . $form->legalNoticeTitle . '</label>
                      <input type="checkbox" data-toggle="switch" id="lfb_legalCheckbox" data-checkboxstyle="switch" class="form-control"/>
                    </div>';
                }
                $response .= '<div id="lfb_lastStepDown"></div>';
                if ($form->useSignature) {
                    $response .= '<div id="lfb_signatureContainer"><h4>' . $form->txtSignature . '</h4><div id="lfb_signature" class="form-control"><a href="javascript:" id="lfb_resetSignature"><i class="fas fa-undo"></i></a></div></div>';
                }

                if ($form->paymentType != "email") {

                    if (($form->use_paypal && $form->use_stripe) ||
                            ($form->use_paypal && $form->use_razorpay) ||
                            ($form->use_razorpay && $form->use_stripe)) {
                        $response .= '<div id="lfb_paymentMethodBtns">';
                        if ($form->use_paypal) {
                            $response .= '<a href="javascript:" data-payment="paypal" class="btn btn-wide btn-secondary"><span class="fab fa-paypal"></span><span>' . $form->txt_btnPaypal . '</span></a>';
                        }
                        if ($form->use_stripe) {
                            $response .= '<a href="javascript:" data-payment="stripe" class="btn btn-wide btn-secondary"><span class="fab fa-stripe-s"></span><span>' . $form->txt_btnStripe . '</span></a>';
                        }
                        if ($form->use_razorpay) {
                            $response .= '<a href="javascript:" data-payment="razorpay" class="btn btn-wide btn-secondary"><span class="fas fa-money-check-alt"></span><span>' . $form->txt_btnRazorpay . '</span></a>';
                        }
                        $response .= '</div>';
                    }
                }

                if ($form->use_razorpay && $form->paymentType != "email") {
                    $response .= '<div id="lfb_razorPayCt">'
                            . '<a href="javascript:" id="btnOrderRazorpay" class="btn btn-wide btn-primary">' . $finalIcon . $form->last_btn . '</a>'
                            . '<br/><!--<div class="lfb_linkPreviousCt"><a href="javascript:"  class="linkPrevious">' . $previousIcon . $form->previous_step . '</a>--></div>'
                            . '</div>';
                }

                if ($form->use_paypal && $form->paymentType != "email") {
                    $useIPN = '';
                    if ($form->paypal_useIpn == 1) {
                        $useIPN = 'data-useipn="1"';
                    }
                    if ($form->paypal_useSandbox == 1) {
                        $response .= '<form id="wtmt_paypalForm" action="https://www.sandbox.paypal.com/cgi-bin/webscr" ' . $useIPN . ' method="post">';
                    } else {
                        $response .= '<form id="wtmt_paypalForm" action="https://www.paypal.com/cgi-bin/webscr" ' . $useIPN . ' method="post">';
                    }
                    $response .= '<p style="" class="text-center lfb_btnNextContainer">'
                            . '<a href="javascript:" id="btnOrderPaypal" class="btn btn-wide btn-primary">' . $finalIcon . $form->last_btn . '</a>';

                    $response .= '</p>
                            <input type="submit" style="display: none;" name="submit"/>
                            <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">';
                    if ($form->isSubscription == 1) {
                        $response .= '<input type="hidden" name="cmd" value="_xclick-subscriptions">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="src" value="1">';

                        $response .= '<input type="hidden" name="a3" value="15.00">
                            <input type="hidden" name="p3" value="' . $form->paypal_subsFrequency . '">
                            <input type="hidden" name="t3" value="' . $form->paypal_subsFrequencyType . '">
                            <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest">';
                    } else {
                        $response .= '<input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="amount" value="1">';
                    }
                    $lang = '';
                    if ($form->paypal_languagePayment != "") {
                        $lang = '<input type="hidden" name="lc" value="' . $form->paypal_languagePayment . '"><input type="hidden" name="country" value="' . $form->paypal_languagePayment . '">';
                    }
                    $response .= '<input type="hidden" name="business" value="' . $form->paypal_email . '">
                            <input type="hidden" name="business_cs_email" value="' . $form->paypal_email . '">
                            <input type="hidden" name="item_name" value="' . $form->title . '">
                            <input type="hidden" name="item_number" value="A00001">
                            <input type="hidden" name="charset" value="utf-8">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="cn" value="Message">
                            <input type="hidden" name="custom" value="Form content">
                            <input type="hidden" name="currency_code" value="' . $form->paypal_currency . '">
                            <input type="hidden" name="return" value="' . $form->close_url . '">
                                ' . $lang . '
                        </form>';
                }
                if ($form->gravityFormID == 0) {
                    $response .= '<p class="text-center lfb_btnNextContainer">'
                            . '<a href="javascript:" id="wpe_btnOrder" class="btn btn-wide btn-primary">' . $finalIcon . $form->last_btn . '</a>';

                    $response .= '</p>';
                }



                if ($form->use_stripe && $form->paymentType != "email") {

                    $response .= '<p style="margin-top: 38px;" class="lfb_btnNextContainerStripe">';
                    $response .= '<a href="javascript:" class="btn btn-primary btn-wide" id="lfb_btnPayStripe">' . $finalIcon . $form->last_btn . '</a>';

                    $response .= '</p>';
                }


                // $response .= '</p>';
                if (count($steps) > 0) {
                    $response .= '<div class="lfb_linkPreviousCt"><a href="javascript:" class="linkPrevious">' . $previousIcon . $form->previous_step . '</a></div>';
                }
            }
            $response .= '<div class="clearfix" data-tldinit="true"></div>';
            $response .= '</div>';
            $response .= '</div>';
            $response .= '</div>';
            $response .= '</div>';
            $response .= '</div>';


            $response .= '</div>';
            $response .= '</div>';
            $response .= '</div>';
        }
        /* end */


        return $response;
    }

    private function getFormatedPrice($price, $form) {
        $formatedPrice = $price;
        $priceNoDecimals = $formatedPrice;
        $decimals = "";
        if (strpos($formatedPrice, '.') > 0) {
            $formatedPrice = number_format($formatedPrice, 2, ".", "");
            $priceNoDecimals = substr($formatedPrice, 0, strpos($formatedPrice, '.'));
            $decimals = substr($formatedPrice, strpos($formatedPrice, '.') + 1, 2);
            $formatedPrice = str_replace(".", $form->decimalsSeparator, $formatedPrice);
            if (strlen($decimals) == 1) {
                
            }
            if (strlen($priceNoDecimals) > 9) {
                $formatedPrice = substr($priceNoDecimals, 0, -9) . $form->billionsSeparator . substr($priceNoDecimals, 0, -6) . $form->millionSeparator . substr($priceNoDecimals, 0, -3) . $form->thousandsSeparator . substr($priceNoDecimals, -3) . $form->decimalsSeparator . $decimals;
            } else if (strlen($priceNoDecimals) > 6) {
                $formatedPrice = substr($priceNoDecimals, 0, -6) . $form->millionSeparator . substr($priceNoDecimals, -6, -3) . $form->thousandsSeparator . substr($priceNoDecimals, -3) . $form->decimalsSeparator . $decimals;
            } else if (strlen($priceNoDecimals) > 3) {
                $formatedPrice = substr($priceNoDecimals, 0, -3) . $form->thousandsSeparator . substr($priceNoDecimals, -3) . $form->decimalsSeparator . $decimals;
            }
        } else {
            if (strlen($priceNoDecimals) > 9) {
                $formatedPrice = substr($priceNoDecimals, 0, -9) . $form->billionsSeparator . substr($priceNoDecimals, -9, -6) . $form->millionSeparator . substr($priceNoDecimals, -6, -3) . $form->thousandsSeparator . substr($priceNoDecimals, -3);
            } else if (strlen($priceNoDecimals) > 6) {
                $formatedPrice = substr($priceNoDecimals, 0, -6) . $form->millionSeparator . substr($priceNoDecimals, -6, -3) . $form->thousandsSeparator . substr($priceNoDecimals, -3);
            } else if (strlen($priceNoDecimals) > 3) {
                $formatedPrice = substr($priceNoDecimals, 0, -3) . $form->thousandsSeparator . substr($priceNoDecimals, -3);
            }
        }


        return $formatedPrice;
    }

    public function customerAccount_styles() {
        $settings = $this->getSettings();
        $output = '';

        if (($settings->enableCustomerAccount && $settings->customerAccountPageID > 0 && get_the_ID() == $settings->customerAccountPageID)) {

            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount #lfb_custAccountLoginPanel {';
            $output .= ' background-color:' . $settings->mainColor_loginPanelBg . '; ';
            $output .= ' color:' . $settings->mainColor_loginPanelTxt . '; ';
            $output .= '}';
            $output .= "\n";

            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount .form-control{';
            $output .= ' color:' . $settings->mainColor_secondary . '; ';
            $output .= ' border-color:' . $settings->mainColor_secondary . '; ';
            $output .= '}';
            $output .= "\n";
            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount .form-control:focus {';
            $output .= ' border-color:' . $settings->mainColor_primary . '; ';
            $output .= '}';
            $output .= "\n";

            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount a:not(.btn):not(.close) {';
            $output .= ' color:' . $settings->mainColor_primary . '!important; ';
            $output .= '}';
            $output .= "\n";
            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount .btn-primary, #estimation_popup.wpe_bootstraped.lfb_customerAccount .modal-header {';
            $output .= ' background-color:' . $settings->mainColor_primary . '!important; ';
            $output .= '}';
            $output .= "\n";
            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount .btn-secondary {';
            $output .= ' background-color:' . $settings->mainColor_secondary . '!important; ';
            $output .= '}';
            $output .= "\n";
            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount .btn-warning {';
            $output .= ' background-color:' . $settings->mainColor_warning . '!important; ';
            $output .= '}';
            $output .= "\n";
            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount .btn-danger {';
            $output .= ' background-color:' . $settings->mainColor_danger . '!important; ';
            $output .= '}';
            $output .= "\n";
            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount .lfb_text-mainColor,#estimation_popup.wpe_bootstraped #lfb_passLostConfirmation {';
            $output .= ' color:' . $settings->mainColor_primary . '!important; ';
            $output .= '}';
            $output .= "\n";


            $output .= '#estimation_popup.wpe_bootstraped.lfb_customerAccount h1,'
                    . ' #estimation_popup.wpe_bootstraped.lfb_customerAccount h2,'
                    . ' #estimation_popup.wpe_bootstraped.lfb_customerAccount h3,'
                    . ' #estimation_popup.wpe_bootstraped.lfb_customerAccount h4,'
                    . ' #estimation_popup.wpe_bootstraped.lfb_customerAccount h5 {';
            $output .= ' color:' . $settings->mainColor_secondary . '; ';
            $output .= '}';
            $output .= "\n";

            if ($output != '') {
                $output = "\n<style id=\"tve_global_variablesLfbAc\">\n" . $output . "</style>\n";
                echo $output;
            }
        }
    }

    /*
     * Styles integration
     */

    public function options_custom_styles() {

        global $wpdb;

        $settings = $this->getSettings();
        $output = '';
        $outputJS = '';

        foreach ($this->currentForms as $currentForm) {
            if ($currentForm > 0 && !is_array($currentForm)) {
                $form = $this->getFormDatas($currentForm);
                if ($form) {
                    if (!$form->item_pictures_size || $form->item_pictures_size == "") {
                        $form->item_pictures_size = 64;
                    }

                    if ($form->useGoogleFont && $form->googleFontName != "") {
                        $fontname = str_replace(' ', '+', $form->googleFontName);
                        $output .= '@import url(https://fonts.googleapis.com/css?family=' . $fontname . ':400,700);';

                        $output .= 'body:not(.wp-admin) #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"], html body .lfb_datepickerContainer{';
                        $output .= ' font-family:"' . $form->googleFontName . '"; ';
                        $output .= '}';
                    }



                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_stepper,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_stepper .lfb_stepperPoint  {';
                    $output .= ' background-color:' . $form->colorSecondary . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_stepper .lfb_stepperPoint.lfb_currentPoint,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_stepper #lfb_stepperBar  {';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  {';
                    if ($form->backgroundImg != '') {
                        $output .= ' background-image:url(' . $form->backgroundImg . '); ';
                        $output .= ' background-size:cover; ';
                    }
                    $output .= ' background-color:' . $form->colorPageBg . '; ';
                    $output .= ' color:' . $form->colorB . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker {';
                    $output .= ' background-color:' . $form->colorB . '; ';
                    $output .= ' color:' . $form->colorSecondaryTxt . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td span.active:active,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td span.active:hover:active, '
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td span.active.disabled:active,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .datetimepicker table tr td span.active.disabled:hover:active, '
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td span.active.active, '
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td span.active:hover.active, #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td span.active.disabled.active,'
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td span.active.disabled:hover.active, '
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active:active,'
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active:hover, '
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active:hover:active, '
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active.disabled:active, '
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active.disabled:hover:active,'
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active.active, '
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active:hover.active,'
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active.disabled.active,'
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker table tr td.active.disabled:hover.active,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .datetimepicker table tr td.day:hover,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .datetimepicker table tr th.day:hover,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .datetimepicker table tr td span:hover,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .datetimepicker table tr th span:hover {';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .datetimepicker thead tr:first-child th:hover {';
                    $output .= ' background-color:' . $form->colorA . ' !important; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_stripeModal [data-panel="loading"] {';
                    $output .= ' background-color:' . $form->colorA . ' !important; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_stripeModal .lfb_amountText [data-info="amount"]{';
                    $output .= ' color:' . $form->colorA . ' !important; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_emailActivationContainer .alert {';
                    $output .= ' background-color:' . $form->colorA . ' !important; ';
                    $output .= '}';
                    $output .= "\n";


                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] > .tooltip > .tooltip-inner{';
                    $output .= ' width:' . $form->tooltip_width . 'px; ';
                    $output .= ' max-width:' . $form->tooltip_width . 'px; ';
                    $output .= '}';
                    $output .= "\n";


                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .radioCt-primary input[type="radio"] + label::after,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .radioCt-primary input[type="radio"]:checked + label::after{';
                    $output .= ' background-color:' . $form->colorA . ' !important; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .radioCt-primary input[type="radio"]:checked + label::before {';
                    $output .= ' border-color:' . $form->colorA . ' !important; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .checkboxCt-primary input[type="checkbox"]:checked + label::before {';
                    $output .= ' background-color:' . $form->colorA . ' !important; ';
                    $output .= ' border-color:' . $form->colorA . ' !important; ';
                    $output .= '}';
                    $output .= "\n";


                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .modal .modal-header {';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";


                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_paymentMethodBtns .btn.btn-secondary{';
                    $output .= ' background-color:' . $form->colorSecondary . ' !important; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel {';
                    if ($form->backgroundImg != '') {
                        $output .= ' background-color:transparent; ';
                    } else {
                        $output .= ' background-color:' . $form->colorBg . '; ';
                    }
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_loader {';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .genSlide .lfb_imgTitle  {';
                    $output .= ' color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .genSlide .lfb_totalBottomContainer hr  {';
                    $output .= ' border-color:' . $form->colorC . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide .genContent div.selectable span.icon_select.lfb_fxZoom  {';
                    $output .= ' text-shadow: -2px 0px ' . $form->colorBg . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#lfb_bootstraped #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_stripeContainer {';
                    $output .= ' border-color: ' . $form->colorSecondary . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel #lfb_payFormFinalTxt {';
                    $output .= ' color: ' . $form->colorB . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#lfb_bootstraped #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_floatingSummary:before {';
                    $output .= '  border-color: transparent transparent ' . $form->colorA . ' transparent; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#lfb_bootstraped #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_floatingSummaryInner {';
                    $output .= '  border-color: ' . $form->colorA . ';';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#lfb_bootstraped #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_imageButtonContainer {';
                    $output .= '  border-color: ' . $form->colorSecondary . ';';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#lfb_bootstraped #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_imageButtonContainer .lfb_imageButtonHeader {';
                    $output .= '  background-color: ' . $form->colorSecondary . ';';
                    $output .= '}';
                    $output .= "\n";

                    $fieldsColor = $form->colorC;
                    if (strtolower($fieldsColor) == '#ffffff') {
                        $fieldsColor = '#bdc3c7';
                    }
                    $output .= 'body #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .form-control,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel ,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] p,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_summary tbody td,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_summary tbody #sfb_summaryTotalTr th:not(#lfb_summaryTotal) {';
                    $output .= ' color:' . $fieldsColor . '; ';
                    $output .= '}';
                    $output .= "\n";


                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .tooltip .tooltip-inner,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   #mainPanel .genSlide .genContent div.selectable span.icon_quantity,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .dropdown-inverse {';
                    $output .= ' background-color:' . $form->colorB . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .tooltip.top .tooltip-arrow {';
                    $output .= ' border-top-color:' . $form->colorB . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .tooltip.bottom .tooltip-arrow {';
                    $output .= ' border-bottom-color:' . $form->colorB . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .btn-primary,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .gform_button,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .btn-primary:hover,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .btn-primary:active,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .genPrice .progress .progress-bar-price,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .progress-bar,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .quantityBtns a,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .btn-primary:active,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .btn-primary.active,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .open .dropdown-toggle.btn-primary,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .dropdown-inverse li.active > a,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .dropdown-inverse li.selected > a,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .btn-primary:active,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]
                    .btn-primary.active,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .open .dropdown-toggle.btn-primary,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .btn-primary:hover,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .btn-primary:focus,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .btn-primary:active,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .btn-primary.active,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .open .dropdown-toggle.btn-primary {';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .form-group.lfb_focus .form-control, #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_dropzone:focus,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .has-switch > div.switch-on label,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .form-group.focus .form-control,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .form-control:focus {';
                    $output .= ' border-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] a:not(.btn),#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   a:not(.btn):hover,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   a:not(.btn):active,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   #mainPanel .genSlide .genContent div.selectable.checked span.icon_select,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   #mainPanel #finalPrice,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .ginput_product_price,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .checkbox.checked,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .radio.checked,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .checkbox.checked .second-icon,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]    .radio.checked .second-icon {';
                    $output .= ' color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   #mainPanel .genSlide .genContent div.selectable .img {';
                    $output .= ' max-width:' . $form->item_pictures_size . 'px; ';
                    $output .= ' max-height:' . $form->item_pictures_size . 'px; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   #mainPanel .genSlide .genContent div.selectable .img.lfb_imgSvg {';
                    $output .= ' min-width:' . $form->item_pictures_size . 'px; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   #mainPanel,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .form-control {';
                    $output .= ' color:' . $form->colorC . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   .form-control,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_dropzone  {';
                    $output .= ' color:' . $form->colorC . '; ';
                    $output .= ' border-color:' . $form->colorSecondary . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .input-group-addon {';
                    $output .= ' background-color:' . $form->colorSecondary . '; ';
                    $output .= 'color:' . $form->colorSecondaryTxt . '; ';
                    $output .= ' border-color:' . $form->colorSecondary . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"][data-stylefields="light"]  .input-group-addon,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"][data-stylefields="light"] .form-control {';
                    $output .= ' background-color:transparent; ';
                    $output .= 'color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  .lfb_dropzone .dz-preview .dz-remove {';
                    $output .= ' color:' . $form->colorC . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .btn-default,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .has-switch span.switch-right,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .bootstrap-datetimepicker-widget .has-switch span.switch-right,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .dropdown-menu:not(.datetimepicker) {';
                    $output .= ' background-color:' . $form->colorSecondary . '; ';
                    $output .= ' color:' . $form->colorSecondaryTxt . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_bootstrap-select.btn-group .dropdown-menu li a{';
                    $output .= ' color:' . $form->colorSecondaryTxt . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_bootstrap-select.btn-group .dropdown-menu li.selected> a,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_bootstrap-select.btn-group .dropdown-menu li.selected> a:hover{';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .has-switch>div.switch-off label{';
                    $output .= ' border-color:' . $form->colorSecondary . '; ';
                    $output .= ' background-color:' . $form->colorCbCircle . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .has-switch>div.switch-on label{';
                    $output .= ' background-color:' . $form->colorCbCircleOn . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .btn-default .bs-caret > .caret {';
                    $output .= '  border-bottom-color:' . $form->colorSecondaryTxt . '; ';
                    $output .= '  border-top-color:' . $form->colorSecondaryTxt . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .genPrice .progress .progress-bar-price  {';
                    $output .= ' font-size:' . $form->priceFontSize . 'px; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide .genContent div.selectable .wpe_itemQtField  {';
                    $output .= ' width:' . ($form->item_pictures_size) . 'px; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide .genContent div.selectable .wpe_itemQtField .wpe_qtfield  {';
                    $output .= ' margin-left:' . (0 - (100 - ($form->item_pictures_size)) / 2) . 'px; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= 'body .lfb_datepickerContainer .ui-datepicker-title { ';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= 'body .lfb_datepickerContainer td a {';
                    $output .= ' color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= 'body .lfb_datepickerContainer  td.ui-datepicker-today a {';
                    $output .= ' color:' . $form->colorB . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .has-switch span.switch-left {';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel #lfb_summary table thead,'
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]  #lfb_floatingSummaryContent table thead{';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel #lfb_summary table th.sfb_summaryStep,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_floatingSummaryContent table th.sfb_summaryStep {';
                    $output .= ' background-color:' . $fieldsColor . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel #lfb_summary table #lfb_summaryTotal,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #lfb_floatingSummaryContent table #lfb_summaryTotal  {';
                    $output .= ' color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]:not([data-stylefields="light"]) .form-group.lfb_focus .input-group-addon, #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .form-group.focus .input-group-addon,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .bootstrap-datetimepicker-widget .form-group.focus .input-group-addon,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]:not([data-stylefields="light"]) .input-group.focus .input-group-addon,.bootstrap-datetimepicker-widget .input-group.focus .input-group-addon {';
                    $output .= ' background-color:' . $form->colorA . '; ';
                    $output .= ' border-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";

                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"][data-stylefields="light"] .form-group.lfb_focus .input-group-addon,#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"][data-stylefields="light"] .form-group .focus .input-group-addon {';
                    $output .= ' color:' . $form->colorA . '; ';
                    $output .= ' border-color:' . $form->colorA . '; ';
                    $output .= '}';
                    $output .= "\n";


                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .wpe_sliderQt {';
                    $output .= ' background-color:' . $form->colorC . '; ';
                    $output .= '}';
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel [data-type="slider"] {';
                    $output .= ' background-color:' . $form->colorC . '; ';
                    $output .= '}';
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .wpe_sliderQt .ui-slider-range,'
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .wpe_sliderQt .ui-slider-handle, '
                            . ' #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel [data-type="slider"] .ui-slider-range,'
                            . '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel [data-type="slider"] .ui-slider-handle {';
                    $output .= ' background-color:' . $form->colorA . ' ; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel #finalPrice span:nth-child(2) {';
                    $output .= ' color:' . $form->colorC . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] .lfb_colorPreview {';
                    $output .= ' border-color:' . $form->colorC . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#lfb_bootstraped.lfb_bootstraped[data-form="' . $form->id . '"] #estimation_popup[data-previousstepbtn="true"] .linkPrevious {';
                    $output .= ' background-color:' . $form->colorSecondary . '; ';
                    $output .= ' color:' . $form->colorSecondaryTxt . '; ';
                    $output .= '}';
                    $output .= "\n";


                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] > .bootstrap-timepicker-widget  {';
                    $output .= ' color:' . $form->colorSecondaryTxt . '; ';
                    $output .= ' background-color:' . $form->colorSecondary . '; ';
                    $output .= '}';
                    $output .= "\n";
                    $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] [class*="datetimepicker-dropdown"]:before,'
                            . '#lfb_bootstraped.lfb_bootstraped [class*=" datetimepicker-dropdown"]:after {';
                    $output .= ' border-bottom-color:' . $form->colorB . '; ';
                    $output .= '}';
                    $output .= "\n";

                    if ($form->qtType == '1') {
                        $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide .genContent div.selectable[data-quantityenabled="1"] {';
                        $output .= '    margin-bottom: 64px;';
                        $output .= '}';
                        $output .= "\n";
                    }

                    if ($form->columnsWidth > 0) {
                        $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide .genContent .col-md-2{';
                        $output .= ' width:' . $form->columnsWidth . 'px; ';
                        $output .= '}';
                        $output .= "\n";
                    }

                    if ($form->disableGrayFx) {
                        $output .= 'body #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide div.selectable .img {
                            -webkit-filter: none !important;
                            -moz-filter: none !important;
                            -ms-filter: none !important;
                            -o-filter: none !important;
                            filter: none !important;
                        }';
                        $output .= "\n";
                    } else {
                        if ($form->inverseGrayFx) {
                            $output .= 'body #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide div.selectable:not(.checked) .img {
                            -webkit-filter: grayscale(100%);
                            -moz-filter: grayscale(100%);
                            -ms-filter: grayscale(100%);
                            -o-filter: grayscale(100%);
                            filter: grayscale(100%);
                            filter: gray;
                        }
                        body #estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide div.selectable.checked .img {
                                -webkit-filter: grayscale(0%);
                            -moz-filter: grayscale(0%);
                            -ms-filter: grayscale(0%);
                            -o-filter: grayscale(0%);
                            filter: grayscale(0%);
                            filter: none;
                        }';
                        }
                    }

                    if ($form->columnsWidth == 0) {
                        $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide .genContent .itemDes{';
                        $output .= ' max-width: 240px; ';
                        $output .= '}';
                        $output .= "\n";
                    }


                    $table_name = $wpdb->prefix . "wpefc_steps";
                    $steps = $wpdb->get_results($wpdb->prepare("SELECT formID,imagesSize,id FROM $table_name WHERE formID=%s", $form->id));
                    foreach ($steps as $step) {
                        if ($step->imagesSize > 0) {
                            $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   #mainPanel .genSlide[data-stepid="' . $step->id . '"] .genContent div.selectable .img {';
                            $output .= ' max-width:' . $step->imagesSize . 'px; ';
                            $output .= ' max-height:' . $step->imagesSize . 'px; ';
                            $output .= '}';
                            $output .= "\n";
                            $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"]   #mainPanel .genSlide[data-stepid="' . $step->id . '"] .genContent div.selectable .img.lfb_imgSvg {';
                            $output .= ' min-width:' . $step->imagesSize . 'px; ';
                            $output .= '}';
                            $output .= "\n";

                            $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide[data-stepid="' . $step->id . '"] .genContent div.selectable .wpe_itemQtField  {';
                            $output .= ' width:' . ($step->imagesSize) . 'px; ';
                            $output .= '}';
                            $output .= "\n";
                            $output .= '#estimation_popup.wpe_bootstraped[data-form="' . $form->id . '"] #mainPanel .genSlide[data-stepid="' . $step->id . '"] .genContent div.selectable .wpe_itemQtField .wpe_qtfield  {';
                            $output .= ' margin-left:' . (0 - (100 - ($step->imagesSize)) / 2) . 'px; ';
                            $output .= '}';
                            $output .= "\n";
                        }
                    }

                    if ($form->customCss != "") {
                        $output .= $form->customCss;
                        $output .= "\n";
                    }
                    if ($form->formStyles != '') {
                        $output .= $form->formStyles;
                        $output .= "\n";
                    }


                    if ($form->customJS != "" && !isset($_POST['action'])) {
                        $outputJS = "\n<script>\n" . $form->customJS . "</script>\n";
                    }
                }
            }
        }
        if ($output != '') {
            $output = "\n<style id=\"tve_global_variablesLfb\">\n" . $output . "</style>\n";
            echo $output;
        }
        if ($outputJS != '') {
            echo $outputJS;
        }
    }

    private function isUpdated() {
        $settings = $this->getSettings();
        if ($settings->updated) {
            return false;
        } else {
            return true;
        }
    }

    public function frontend_enqueue_scripts($hook = '') {
        $settings = $this->getSettings();
        $lfb_session = $this->lfb_getSession();

        wp_register_script($this->_token . '-frontend', esc_url($this->assets_url) . 'js/lfb_frontend.min.js', array('jquery'), $this->_version);
        wp_enqueue_script($this->_token . '-frontend');
        global $post;
        if (isset($post->post_title) && $post->post_title == __('Form preview', 'lfb')) {

            wp_register_script($this->_token . '-designerFrontend', esc_url($this->assets_url) . 'js/lfb_formDesigner_frontend.min.js', array('jquery', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-resizable', 'jquery-ui-sortable'), $this->_version);
            wp_enqueue_script($this->_token . '-designerFrontend');

            wp_register_script($this->_token . '-visualFrontend', esc_url($this->assets_url) . 'js/lfb_visualFrontend.min.js', array('jquery', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-resizable', 'jquery-ui-sortable'), $this->_version);
            wp_enqueue_script($this->_token . '-visualFrontend');

            wp_localize_script($this->_token . '-visualFrontend', 'lfb_data', array(
                'homeUrl' => get_site_url(),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'texts' => array(
                    'Item' => __('Item', 'lfb'),
                    'move' => __('Move', 'lfb'),
                    'duplicate' => __('Duplicate', 'lfb'),
                    'remove' => __('Remove', 'lfb'),
                    'edit' => __('Edit', 'lfb'),
                    'Size' => __('Size', 'lfb'),
                    'My item' => __('My item', 'lfb'),
                    'Row settings' => __('Row settings', 'lfb'),
                    'Columns' => __('Columns', 'lfb'),
                    'Add a column' => __('Add a column', 'lfb'),
                    'Automatic' => __('Automatic', 'lfb'),
                    'Small' => __('Small', 'lfb'),
                    'Medium' => __('Medium', 'lfb'),
                    'Large' => __('Large', 'lfb'),
                    'XL' => __('XL', 'lfb'),
                    'Full width' => __('Full width', 'lfb')
                )
            ));
        }
        if (($settings->enableCustomerAccount && $settings->customerAccountPageID > 0 && get_the_ID() == $settings->customerAccountPageID)) {

            global $wpdb;
            wp_register_script($this->_token . '-frontend-libs', esc_url($this->assets_url) . 'js/lfb_frontendPackedLibs.min.js', array("jquery-ui-core", "jquery-ui-tooltip", "jquery-ui-slider", "jquery-ui-position", "jquery-ui-datepicker"), $this->_version);
            wp_enqueue_script($this->_token . '-frontend-libs');
            wp_register_script($this->_token . '-accountManagement', esc_url($this->assets_url) . 'js/lfb_accountManagement.min.js', array('jquery'), $this->_version);
            wp_enqueue_script($this->_token . '-accountManagement');
            $customerID = 0;

            if (isset($lfb_session['lfb_loginMan']) && $lfb_session['lfb_loginMan'] != 0) {
                $chkCustomerID = intval($lfb_session['lfb_loginMan']);
                $table_nameC = $wpdb->prefix . "wpefc_customers";
                $customerData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameC WHERE id=%s LIMIT 1", $chkCustomerID));
                if (count($customerData) > 0) {
                    $customerID = $chkCustomerID;
                }
            }
            wp_localize_script($this->_token . '-accountManagement', 'lfb_dataCust', array(
                'homeUrl' => get_site_url(),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'customerID' => $customerID,
                'txtCustomersDataForgotPassSent' => $settings->txtCustomersDataForgotPassSent,
                'txtCustomersDataForgotPassLink' => $settings->txtCustomersDataForgotPassLink,
                'txtCustomersDataDeleteLink' => $settings->txtCustomersDataDeleteLink,
                'txtCustomersDataDownloadLink' => $settings->txtCustomersDataDownloadLink,
                'txtCustomersDataWarningText' => $settings->txtCustomersDataWarningText,
                'txtCustomersDataModifyValidConfirm' => $settings->txtCustomersDataModifyValidConfirm,
                'customersDataLabelEmail' => $settings->customersDataLabelEmail,
                'customersAc_sendPass' => $settings->txtCustomersDataForgotPassLink,
                'customersAc_viewOrder' => $settings->customersAc_viewOrder,
                'customersAc_downloadOrder' => $settings->customersAc_downloadOrder
            ));
        }

        if ($this->modeManageData) {

            wp_register_script($this->_token . '-frontend-libs', esc_url($this->assets_url) . 'js/lfb_frontendPackedLibs.min.js', array("jquery-ui-core", "jquery-ui-tooltip", "jquery-ui-slider", "jquery-ui-position", "jquery-ui-datepicker"), $this->_version);
            wp_enqueue_script($this->_token . '-frontend-libs');

            wp_register_script($this->_token . '-manageDatas', esc_url($this->assets_url) . 'js/lfb_manageDatas.min.js', array('jquery'), $this->_version);
            wp_enqueue_script($this->_token . '-manageDatas');
            wp_localize_script($this->_token . '-manageDatas', 'lfb_dataMan', array(
                'homeUrl' => get_site_url(),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'txtCustomersDataDownloadLink' => $settings->txtCustomersDataDownloadLink,
                'txtCustomersDataDeleteLink' => $settings->txtCustomersDataDeleteLink,
                'txtCustomersDataWarningText' => $settings->txtCustomersDataWarningText,
                'txtCustomersDataModifyValidConfirm' => $settings->txtCustomersDataModifyValidConfirm,
                'txtCustomersDataLeaveLink' => $settings->txtCustomersDataLeaveLink,
                'customersDataDeleteDelay' => $settings->customersDataDeleteDelay,
                'customersDataLabelPass' => $settings->customersDataLabelPass,
                'customersDataLabelModify' => $settings->customersDataLabelModify,
                'txtCustomersDataTitle' => $settings->txtCustomersDataTitle,
                'txtCustomersDataEditLink' => $settings->txtCustomersDataEditLink,
                'customersDataLabelEmail' => $settings->customersDataLabelEmail,
                'customersDataLabelPass' => $settings->customersDataLabelPass,
                'txtCustomersDataForgotPassLink' => $settings->txtCustomersDataForgotPassLink,
                'txtCustomersDataForgotPassSent' => $settings->txtCustomersDataForgotPassSent,
            ));
        }
        if ($this->formToPayKey != "") {

            global $wpdb;
            $table_name = $wpdb->prefix . "wpefc_forms";
            $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE id=$this->formToPayID LIMIT 1");
            if (count($rows) > 0) {
                $form = $rows[0];

                $table_name = $wpdb->prefix . "wpefc_logs";
                $logs = $wpdb->get_results("SELECT * FROM $table_name WHERE paymentKey='$this->formToPayKey' LIMIT 1");
                if (count($logs) > 0) {
                    $log = $logs[0];

                    if ($form->use_razorpay) {
                        wp_enqueue_script($this->_token . '-razorpay', 'https://checkout.razorpay.com/v1/checkout.js', true, 3);
                    }
                    if ($form->use_stripe) {
                        wp_enqueue_script($this->_token . '-stripe', 'https://js.stripe.com/v3/', true, 3);
                    }

                    if ($form->useCaptcha) {
                        wp_enqueue_script($this->_token . '-recaptcha3', 'https://www.google.com/recaptcha/api.js?render=' . $form->recaptcha3Key, true, 3);
                    }

                    $contactInformations = array();
                    $contactInformations['email'] = $this->stringDecode($log->email, $settings->encryptDB);
                    $contactInformations['phone'] = $this->stringDecode($log->phone, $settings->encryptDB);
                    $contactInformations['city'] = $this->stringDecode($log->city, $settings->encryptDB);
                    $contactInformations['address'] = $this->stringDecode($log->address, $settings->encryptDB);
                    $contactInformations['zip'] = $this->stringDecode($log->zip, $settings->encryptDB);
                    $contactInformations['country'] = $this->stringDecode($log->country, $settings->encryptDB);
                    $contactInformations['state'] = $this->stringDecode($log->state, $settings->encryptDB);

                    $form->fixedToPay = $form->paypal_fixedToPay;
                    $form->payMode = $form->paypal_payMode;
                    if ($form->use_stripe) {
                        $form->percentToPay = $form->stripe_percentToPay;
                        $form->fixedToPay = $form->stripe_fixedToPay;
                        $form->payMode = $form->stripe_payMode;
                    }

                    wp_register_script($this->_token . '-bootstrap', esc_url($this->assets_url) . 'js/bootstrap.min.js', array('jquery', "jquery-ui-core"), $this->_version);
                    wp_enqueue_script($this->_token . '-bootstrap');
                    wp_register_script($this->_token . '-payForm', esc_url($this->assets_url) . 'js/lfb_payForm.min.js', array('jquery'), $this->_version);
                    wp_enqueue_script($this->_token . '-payForm');
                    wp_localize_script($this->_token . '-payForm', 'lfb_dataPay', array(
                        'homeUrl' => get_site_url(),
                        'key' => $this->formToPayKey,
                        'colorA' => $form->colorA,
                        'formTitle' => $form->title,
                        'assets_url' => $this->assets_url,
                        'ajaxurl' => admin_url('admin-ajax.php'), 'formID' => $this->formToPayID,
                        'razorpay_publishKey' => $form->razorpay_publishKey,
                        'stripePubKey' => $form->stripe_publishKey,
                        'finalText' => $form->txt_payFormFinalTxt,
                        'finalUrl' => $log->finalUrl,
                        'redirectionDelay' => $form->redirectionDelay,
                        'total' => $log->totalPrice,
                        'totalSub' => $log->totalSubscription,
                        'totalText' => $log->totalText,
                        'ref' => $log->ref,
                        'email' => $this->stringDecode($log->email, $settings->encryptDB),
                        'razorpay_publishKey' => $form->razorpay_publishKey,
                        'razorpay_logoImg' => $form->razorpay_logoImg,
                        'customerName' => $this->stringDecode($log->firstName, $settings->encryptDB) . ' ' . $this->stringDecode($log->lastName, $settings->encryptDB),
                        'contactInformations' => $contactInformations,
                        'txt_stripe_title' => $form->txt_stripe_title,
                        'txt_stripe_btnPay' => $form->txt_stripe_btnPay,
                        'txt_stripe_totalTxt' => $form->txt_stripe_totalTxt,
                        'txt_stripe_paymentFail' => $form->txt_stripe_paymentFail,
                        'txt_stripe_cardOwnerLabel' => $form->txt_stripe_cardOwnerLabel,
                        'percentToPay' => $form->percentToPay,
                        'fixedToPay' => $form->fixedToPay,
                        'payMode' => $form->payMode,
                        'summary_noDecimals' => $form->summary_noDecimals,
                        'decimalsSeparator' => $form->decimalsSeparator,
                        'thousandsSeparator' => $form->thousandsSeparator,
                        'millionSeparator' => $form->millionSeparator,
                        'billionsSeparator' => $form->billionsSeparator,
                        'summary_noDecimals' => $form->summary_noDecimals,
                        'summary_noDecimals' => $form->summary_noDecimals,
                        'currencyPosition' => $form->currencyPosition,
                        'currency' => $form->currency));
                }
            }
        }
    }

    /* Ajax : get Current ref */

    public function get_currentRef() {
        $rep = false;
        $settings = $this->getSettings();
        if (isset($_POST['formID']) && !is_array($_POST['formID'])) {
            $formID = sanitize_text_field($_POST['formID']);

            global $wpdb;
            $table_name = $wpdb->prefix . "wpefc_forms";
            $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s", $formID));
            if (count($rows) > 0) {
                $form = $rows[0];
                $current_ref = $form->current_ref + 1;
                $wpdb->update($table_name, array('current_ref' => $current_ref), array('id' => $form->id));
                $rep = $form->ref_root . $current_ref;
            }
        }
        echo $rep;
        die();
    }

    private function lfb_sanitizeFilename($filename) {
        $filename = preg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
        $filename = preg_replace("([\.]{2,})", '', $filename);
        return $filename;
    }

    private function lfb_generatePdfAdmin($order, $form) {
        $settings = $this->getSettings();

        $lastPos = 0;
        $positions = array();
        $toReplaceDefault = array();
        $toReplaceBy = array();
        while (($lastPos = strpos($order->pdfContent, '<span class="lfb_value">', $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen('<span class="lfb_value">');
            $fileStartPos = $lastPos;
            $lastSpan = strpos($order->pdfContent, '</span>', $fileStartPos);
            $value = substr($order->pdfContent, $fileStartPos, $lastSpan - $fileStartPos);
            $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
            $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
        }
        foreach ($toReplaceBy as $key => $value) {
            $order->pdfContent = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->pdfContent);
        }


        $contentPdf = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>body,*{font-family: "dejavu sans" !important; } hr{color: #ddd; border-color: #ddd;} table{width: 100% !important; line-height: 18px;} table td, table th{width: auto!important; border: 1px solid #ddd; line-height: 16px; overflow-wrap: break-word;}table td,table tbody th  {padding-top: 2px !important; padding-bottom: 6px !important} table thead th {padding: 8px;line-height: 18px;}tbody:before, tbody:after { display: none; }</style></head><body>' . $order->pdfContent . '</body></html>';
        $contentPdf = str_replace('border="1"', '', $contentPdf);
        $upDir = wp_upload_dir();
        $contentPdf = str_replace('src="' . get_site_url() . '/wp-content/uploads/', 'src="' . $upDir['basedir'] . '/', $contentPdf);

        if (!$order->paid) {
            $txt_orderType = $form->txt_quotation;
        }
        $contentPdf = str_replace("[order_type]", $txt_orderType, $contentPdf);

        $contentPdf = mb_convert_encoding($contentPdf, 'HTML-ENTITIES', 'UTF-8');
        require_once("dompdf/autoload.inc.php");
        $dompdf = new Dompdf\Dompdf();
        $dompdf->load_html($contentPdf, 'UTF-8');
        $dompdf->set_paper('a4', 'portrait');
        $dompdf->render();
        $fileName = $this->lfb_sanitizeFilename($form->title) . '-' . $order->ref . '.pdf';
        $output = $dompdf->output();
        file_put_contents($this->dir . '/uploads/' . $fileName, $output);
        return ($this->dir . '/uploads/' . $fileName);
    }

    private function lfb_generatePdfCustomer($order, $form, $fromCustomer) {
        $settings = $this->getSettings();
        if ($fromCustomer) {
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
                $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
            }
            foreach ($toReplaceBy as $key => $value) {
                $order->contentUser = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->contentUser);
            }

            $contentPdf = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>body,*{font-family: "dejavu sans" !important; } hr{color: #ddd; border-color: #ddd;} table{width: 100% !important; line-height: 18px;} table td, table th{width: auto!important; border: 1px solid #ddd; line-height: 16px;overflow-wrap: break-word;}table td,table tbody th  {padding-top: 2px !important; padding-bottom: 6px !important} table thead th {padding: 8px;line-height: 18px;} thead:before, thead:after { display: none; }tbody:before, tbody:after { display: none; }</style></head><body>' . $order->contentUser . '</body></html>';
        } else {
            $lastPos = 0;
            $positions = array();
            $toReplaceDefault = array();
            $toReplaceBy = array();
            while (($lastPos = strpos($order->pdfContentUser, '<span class="lfb_value">', $lastPos)) !== false) {
                $positions[] = $lastPos;
                $lastPos = $lastPos + strlen('<span class="lfb_value">');
                $fileStartPos = $lastPos;
                $lastSpan = strpos($order->pdfContentUser, '</span>', $fileStartPos);
                $value = substr($order->pdfContentUser, $fileStartPos, $lastSpan - $fileStartPos);
                $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
                $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
            }
            foreach ($toReplaceBy as $key => $value) {
                $order->pdfContentUser = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->pdfContentUser);
            }

            $contentPdf = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>body,*{font-family: "dejavu sans" !important; } hr{color: #ddd; border-color: #ddd;} table{width: 100% !important; line-height: 18px;} table td, table th{width: auto!important; border: 1px solid #ddd; line-height: 16px;overflow-wrap: break-word;}table td,table tbody th  {padding-top: 2px !important; padding-bottom: 6px !important} table thead th {padding: 8px;line-height: 18px;} thead:before, thead:after { display: none; }tbody:before, tbody:after { display: none; }</style></head><body>' . $order->pdfContentUser . '</body></html>';
        }

        $contentPdf = str_replace('border="1"', '', $contentPdf);
        $upDir = wp_upload_dir();
        $contentPdf = str_replace('src="' . get_site_url() . '/wp-content/uploads/', 'src="' . $upDir['basedir'] . '/', $contentPdf);
        $txt_orderType = '';
        if ($form && !$order->paid) {
            $txt_orderType = $form->txt_quotation;
        }
        $contentPdf = str_replace("[order_type]", $txt_orderType, $contentPdf);
        $contentPdf = mb_convert_encoding($contentPdf, 'HTML-ENTITIES', 'UTF-8');


        require_once("dompdf/autoload.inc.php");
        $dompdf = new Dompdf\Dompdf();
        // $dompdf->load_html(utf8_decode($contentPdf), 'UTF-8');
        $dompdf->load_html($contentPdf, 'UTF-8');
        $dompdf->set_paper('a4', 'portrait');
        $dompdf->render();
        if ($form) {
            $fileName = $this->lfb_sanitizeFilename($form->title) . '-' . $order->ref . '.pdf';
        } else {
            $lfb_session = $this->lfb_getSession();
            $uniqueID = $this->generateRandomString(8);

            $this->lfb_updateSession('orderToDownload', $uniqueID);
            $this->lfb_updateSession('orderTitle', $order->ref);
            $fileName = $uniqueID . '.pdf';
        }
        $output = $dompdf->output();
        file_put_contents($this->dir . '/uploads/' . $fileName, $output);
        return ($this->dir . '/uploads/' . $fileName);
    }

// Send email to admin & customer
    private function sendOrderEmail($orderRef, $formID) {
        global $wpdb;
        global $_currentFormID;
        global $_currentOrderID;

        $table_name = $wpdb->prefix . "wpefc_logs";
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE ref=%s AND $formID=%s  LIMIT 1", $orderRef, $formID));
        if (count($rows) > 0) {

            $settings = $this->getSettings();

            $order = $rows[0];
            $order->email = $this->stringDecode($order->email, $settings->encryptDB);
            $order->address = $this->stringDecode($order->address, $settings->encryptDB);
            $order->zip = $this->stringDecode($order->zip, $settings->encryptDB);
            $order->city = $this->stringDecode($order->city, $settings->encryptDB);
            $order->country = $this->stringDecode($order->country, $settings->encryptDB);


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
                $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
            }
            foreach ($toReplaceBy as $key => $value) {
                $order->content = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->content);
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
                $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
            }
            foreach ($toReplaceBy as $key => $value) {
                $order->contentUser = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->contentUser);
            }


            $table_name = $wpdb->prefix . "wpefc_forms";
            $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE id=$order->formID LIMIT 1");
            $form = $rows[0];
            if (strlen($order->eventsData) > 2) {
                $eventsData = json_decode($order->eventsData);
                foreach ($eventsData as $eventData) {
                    $customerAddress = $order->address . ' ' . $order->zip . ' ' . $order->city . ' , ' . $order->country;
                    if (strlen(str_replace(' ', '', $customerAddress)) < 3) {
                        $customerAddress = '';
                    }

                    if (is_null($eventData->fullDay)) {
                        $eventData->fullDay = 0;
                    }

                    $table_nameEv = $wpdb->prefix . "wpefc_calendarEvents";
                    $wpdb->insert($table_nameEv, array(
                        'calendarID' => $eventData->calendarID,
                        'title' => $eventData->title,
                        'startDate' => $eventData->startDate,
                        'endDate' => $eventData->endDate,
                        'fullDay' => $eventData->fullDay,
                        'orderID' => $order->id,
                        'isBusy' => $eventData->isBusy,
                        'categoryID' => $eventData->categoryID,
                        'customerID' => $order->customerID,
                        'customerEmail' => $this->stringEncode($order->email, $settings->encryptDB),
                        'customerAddress' => $this->stringEncode($customerAddress, $settings->encryptDB)
                    ));
                    $eventID = $wpdb->insert_id;
                    $table_nameR = $wpdb->prefix . "wpefc_calendarReminders";
                    $remindersData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_nameR WHERE eventID=0 AND calendarID=%s", $eventData->calendarID));
                    foreach ($remindersData as $reminder) {
                        $reminder->eventID = $eventID;
                        unset($reminder->id);
                        $wpdb->insert($table_nameR, (array) $reminder);
                    }
                }
            }


            $txt_orderType = $form->txt_invoice;
            if (!$order->paid) {
                $txt_orderType = $form->txt_quotation;
            }
            $order->content = str_replace("[order_type]", $txt_orderType, $order->content);
            $order->contentUser = str_replace("[order_type]", $txt_orderType, $order->contentUser);
            if ($settings->enableCustomerAccount && $settings->customerAccountPageID > 0) {
                if (strpos($order->contentUser, '[gdpr_link]') === false && strpos($order->contentUser, '[customer_link]') === false) {
                    $customersDataEmailLink = '<hr/><p style="color:#bdc3c7;font-style: italic; font-size: 11px;">' . $form->customersDataEmailLink . '</p>';
                    $customersDataUrl = get_page_link($settings->customerAccountPageID);
                    $customersDataEmailLink = str_replace("[url]", '<a href="' . $customersDataUrl . '" style="color: #bdc3c7;">' . $customersDataUrl . '</a>', $customersDataEmailLink);
                    $order->contentUser .= '<div>' . $customersDataEmailLink . '</div>';
                }
                $customersDataUrl = get_page_link($settings->customerAccountPageID);
                $order->contentUser = str_replace("[gdpr_link]", get_page_link($settings->customerAccountPageID), $order->contentUser);
                $order->contentUser = str_replace("[customer_link]", get_page_link($settings->customerAccountPageID), $order->contentUser);


                $table_nameCust = $wpdb->prefix . "wpefc_customers";
                $customers = $wpdb->get_results("SELECT id,email,password FROM $table_nameCust WHERE id=" . $order->customerID);
                if (count($customers) > 0) {
                    $customer = $customers[0];
                    $order->contentUser = str_replace("[customer_pass]", $this->stringDecode($customer->password, true), $order->contentUser);
                    $order->contentUser = str_replace("[customer_email]", $this->stringDecode($customer->email, $settings->encryptDB), $order->contentUser);
                }
            }
            $order->content = str_replace("[gdpr_link]", '', $order->content);
            $order->content = str_replace("[customer_link]", '', $order->content);
            $order->content = str_replace("[customer_pass]", '', $order->content);
            $order->content = str_replace("[customer_email]", '', $order->content);


            if (version_compare(PHP_VERSION, '7.2.0') >= 0) {
                add_filter('wp_mail_content_type', function() {
                    return "text/html";
                });
            } else {
                add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
            }


            $headers = "";
            if ($order->email != "") {
                $headers = array('Reply-To: ' . $order->email);
            }
            if (strpos($form->email, ',') > 0) {
                $emailsArr = explode(',', $form->email);
                $form->email = $emailsArr;
            }


            if (!$order->paid && $form->paymentType == "email" && ($order->totalPrice > 0 || $order->totalSubscription > 0)) {
                $paymentLink = '';
                $paymentUrl = get_site_url() . '/?EPFormsBuilder=payOrder&h=' . $order->paymentKey;
                if ($form->emailPaymentType == 'checkbox') {
                    $paymentLink = '<p><a href="' . $paymentUrl . '">' . $form->enableEmailPaymentText . '   <input type="checkbox" style="vertical-align:middle;"  /></a></p>';
                } else if ($form->emailPaymentType == 'button') {
                    $paymentLink = '<p><a href="' . $paymentUrl . '" style="padding: 14px;border-radius: 4px; background-color: ' . $form->colorA . ';color: #fff; text-decoration:none;">' . $form->enableEmailPaymentText . '</a></p>';
                } else if ($form->emailPaymentType == 'link') {
                    $paymentLink = '<p><a href="' . $paymentUrl . '">' . $form->enableEmailPaymentText . '</a></p>';
                }
                $paymentLink = '<div style="text-align:center;margin-bottom: 28px;">' . $paymentLink . '</div>';

                if (strpos($order->contentUser, '[payment_link]') !== false) {
                    $order->contentUser = str_replace("[payment_link]", $paymentLink, $order->contentUser);
                } else {
                    $order->contentUser .= $paymentLink;
                }
            } else {
                $order->contentUser = str_replace("[payment_link]", "", $order->contentUser);
            }

            $content = str_replace("[payment_link]", "", $order->content);

            $attachmentAdmin = array();
            if ($form->sendPdfAdmin) {

                try {
                    $attachmentAdmin[] = $this->lfb_generatePdfAdmin($order, $form);
                } catch (Exception $ex) {
                    
                }
            }
            if ($form->email_name != "") {
                $_currentFormID = $formID;
                $_currentOrderID = $order->id;
                add_filter('wp_mail_from_name', array($this, 'wpb_sender_name_cust'));
            }

            $_currentFormID = $formID;
            $_currentOrderID = $order->id;
            //add_filter('wp_mail_from', array($this, 'wpb_sender_email'));
            $emailContent = '<html><body>' . $order->content . '</body></html>';

            $adminEmailSubject = $form->email_subject . ' - ' . $order->ref;
            if ($order->adminEmailSubject != '' && $order->adminEmailSubject != $form->email_subject) {
                $adminEmailSubject = $order->adminEmailSubject;
            }
            $adminEmailSubject = str_replace("[ref]", $order->ref, $adminEmailSubject);

            if (wp_mail($form->email, $adminEmailSubject, $emailContent, $headers, $attachmentAdmin)) {
                if (count($attachmentAdmin) > 0) {
                    unlink($attachmentAdmin[0]);
                }
            }

            $pdfOrderName = '';

            if ($order->sendToUser && $order->email != '') {
                $attachmentCustomer = array();
                if ($form->sendPdfCustomer) {
                    try {
                        $attachmentCustomer[] = $this->lfb_generatePdfCustomer($order, $form, false);
                    } catch (Exception $ex) {
                        
                    }
                }
                $headers = "";
                if ($form->email_name != "") {
                    global $_currentFormID;
                    global $_currentOrderID;
                    $_currentFormID = $formID;
                    add_filter('wp_mail_from_name', array($this, 'wpb_sender_name'));
                }
                $_currentFormID = $formID;
                $_currentOrderID = 0;
                add_filter('wp_mail_from', array($this, 'wpb_sender_email'));

                if (version_compare(PHP_VERSION, '7.2.0') >= 0) {
                    add_filter('wp_mail_content_type', function() {
                        return "text/html";
                    });
                } else {
                    add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                }
                $emailContent = '<html><body>' . $order->contentUser . '</body></html>';

                $userEmailSubject = $form->email_userSubject;
                $userEmailSubject = str_replace("[ref]", $order->ref, $userEmailSubject);

                if ($order->userEmailSubject != '' && $order->userEmailSubject != $form->email_userSubject) {
                    $userEmailSubject = $order->userEmailSubject;
                }

                if (wp_mail($order->email, $userEmailSubject, $emailContent, $headers, $attachmentCustomer)) {
                    if (count($attachmentCustomer) > 0) {
                        unlink($attachmentCustomer[0]);
                    }
                }
            }

            $table_name = $wpdb->prefix . "wpefc_logs";
            $wpdb->update($table_name, array('checked' => true), array('id' => $order->id));
        }
    }

    public function customDataToWooOrder($product_name, $values, $cart_item_key) {
        if (count($values['lfbRef']) > 0) {
            $return_string = $product_name . "</a><dl class='variation'>";
            $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
            $return_string .= "<tr><td>" . __('Form ref', 'lfb') . ' : ' . $values['lfbRef'] . "</td></tr>";
            $return_string .= "</table></dl>";
            return $return_string;
        } else {
            return $product_name;
        }
    }

    public function customDataToWooFinalOrder($item_id, $values) {
        global $woocommerce, $wpdb;
        $user_custom_values = $values['lfbRef'];
        if (!empty($user_custom_values)) {
            wc_add_order_item_meta($item_id, __('Form ref', 'lfb'), $user_custom_values);
        }
    }

    public function removeCustomDataWoo($cart_item_key) {
        global $woocommerce;
// Get cart
        $cart = $woocommerce->cart->get_cart();
// For each item in cart, if item is upsell of deleted product, delete it
        foreach ($cart as $key => $values) {
            if ($values['lfbRef'] == $cart_item_key)
                unset($woocommerce->cart->cart_contents[$key]);
        }
    }

    public function wpb_sender_name_cust($name) {
        global $wpdb;
        global $_currentFormID;
        global $_currentOrderID;
        $settings = $this->getSettings();
        $rep = '';
        if ($_currentOrderID > 0) {
            $table_name = $wpdb->prefix . "wpefc_logs";
            $rows = $wpdb->get_results("SELECT id,firstName,lastName FROM $table_name WHERE id=$_currentOrderID LIMIT 1");
            if (count($rows) > 0) {
                $order = $rows[0];
                if ($order->firstName != '' || $order->lastName != '') {
                    $chkMail = true;
                    $rep = $this->stringDecode($order->firstName, $settings->encryptDB) . ' ' . $this->stringDecode($order->lastName, $settings->encryptDB);
                }
            }
        }
        return $rep;
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
                    $email = $this->stringDecode($order->email, $settings->encryptDB);
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

    private function verifyCaptchaThen($form, $formID,
            $formSession,
            // $phone,
            $email,
            $contentTxt,
            $contactSent,
            $activatePaypal,
            $finalUrl,
            $customerInfos,
            $total,
            $totalSub,
            $subFrequency,
            $formTitle,
            $stripeToken,
            $captcha,
            $events,
            $variables,
            $razorpayReady,
            $stripeCustomerID,
            $stripeSrc,
            $verifiedEmail,
            $itemsArray,
            $usePaypalIpn,
            $sendUser,
            $discountCode,
            $summary,
            $summaryA,
            $informations,
            $emailToUser,
            $totalTxt,
            $useRtl,
            $fieldsLast,
            $gravity, $signature, $totalText, $callBack) {
        if ($form->useCaptcha && $form->recaptcha3KeySecret != '') {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array('secret' => $form->recaptcha3KeySecret, 'response' => $captcha);

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $responseKeys = json_decode($response, true);
            if ($responseKeys["success"]) {
                $callBack($form, $formID,
                        $formSession,
                        $email,
                        $contentTxt,
                        $contactSent,
                        $activatePaypal,
                        $finalUrl,
                        $customerInfos,
                        $total,
                        $totalSub,
                        $subFrequency,
                        $formTitle,
                        $stripeToken,
                        $captcha,
                        $events,
                        $variables,
                        $razorpayReady,
                        $stripeCustomerID,
                        $stripeSrc,
                        $verifiedEmail,
                        $itemsArray,
                        $usePaypalIpn,
                        $sendUser,
                        $discountCode,
                        $summary,
                        $summaryA,
                        $informations,
                        $emailToUser,
                        $totalTxt,
                        $useRtl,
                        $fieldsLast,
                        $gravity,
                        $signature, $totalText);
            } else {
                
            }
        } else {
            $callBack($form, $formID,
                    $formSession,
                    $email,
                    $contentTxt,
                    $contactSent,
                    $activatePaypal,
                    $finalUrl,
                    $customerInfos,
                    $total,
                    $totalSub,
                    $subFrequency,
                    $formTitle,
                    $stripeToken,
                    $captcha,
                    $events,
                    $variables,
                    $razorpayReady,
                    $stripeCustomerID,
                    $stripeSrc,
                    $verifiedEmail,
                    $itemsArray,
                    $usePaypalIpn,
                    $sendUser,
                    $discountCode,
                    $summary,
                    $summaryA,
                    $informations,
                    $emailToUser,
                    $totalTxt,
                    $useRtl,
                    $fieldsLast,
                    $gravity,
                    $signature, $totalText);
        }
    }

    public function downloadOrderPDF() {

        global $wpdb;
        $settings = $this->getSettings();
        $formID = sanitize_text_field($_POST['formID']);
        $formSession = sanitize_text_field(($_POST['formSession']));
        $email = sanitize_text_field($_POST['email']);
        $customerInfos = ($_POST['customerInfos']);
        $summary = ($_POST['summary']);
        $informations = $_POST['informations'];
        $totalTxt = sanitize_text_field($_POST['totalTxt']);
        $variables = json_decode(stripslashes($_POST['variables']));

        $table_name = $wpdb->prefix . "wpefc_forms";
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
        if (count($rows) > 0) {
            $form = $rows[0];

            $txt_orderType = $form->txt_quotation;
            $orderPdfContent = $form->pdf_userContent;
            $orderPdfContent = str_replace("[order_type]", $txt_orderType, $orderPdfContent);
            $orderPdfContent = str_replace("[ref]", '', $orderPdfContent);

            $contentUserPdf = $this->prepareOrderContent($orderPdfContent, $form, $informations, $email, $summary, $form->emailCustomerLinks, $totalTxt, $formSession, $variables, $itemsArray, false, $current_ref);

            $lastPos = 0;
            $positions = array();
            $toReplaceDefault = array();
            $toReplaceBy = array();
            while (($lastPos = strpos($contentUserPdf, '<span class="lfb_value">', $lastPos)) !== false) {
                $positions[] = $lastPos;
                $lastPos = $lastPos + strlen('<span class="lfb_value">');
                $fileStartPos = $lastPos;
                $lastSpan = strpos($contentUserPdf, '</span>', $fileStartPos);
                $value = substr($contentUserPdf, $fileStartPos, $lastSpan - $fileStartPos);
                $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
                $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
            }
            foreach ($toReplaceBy as $key => $value) {
                $contentUserPdf = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $contentUserPdf);
            }

            $contentPdf = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>body,*{font-family: "dejavu sans" !important; } hr{color: #ddd; border-color: #ddd;} table{width: 100% !important; line-height: 18px;} table td, table th{width: auto!important; border: 1px solid #ddd; line-height: 16px; overflow-wrap: break-word;}table td,table tbody th  {padding-top: 2px !important; padding-bottom: 6px !important} table thead th {padding: 8px;line-height: 18px;}tbody:before, tbody:after { display: none; }</style></head><body>' . $contentUserPdf . '</body></html>';
            $contentPdf = str_replace('border="1"', '', $contentPdf);
            $upDir = wp_upload_dir();
            $contentPdf = str_replace('src="' . get_site_url() . '/wp-content/uploads/', 'src="' . $upDir['basedir'] . '/', $contentPdf);


            $contentPdf = mb_convert_encoding($contentPdf, 'HTML-ENTITIES', 'UTF-8');

            // echo $contentPdf;


            require_once("dompdf/autoload.inc.php");
            $dompdf = new Dompdf\Dompdf();
            $dompdf->load_html($contentPdf, 'UTF-8');
            $dompdf->set_paper('a4', 'portrait');
            $dompdf->render();
            $lfb_session = $this->lfb_getSession();
            $uniqueID = $this->generateRandomString(8);

            $this->lfb_updateSession('orderToDownload', $uniqueID);
            $this->lfb_updateSession('orderTitle', $form->pdfDownloadFilename);
            $fileName = $uniqueID . '.pdf';

            $output = $dompdf->output();
            file_put_contents($this->dir . '/uploads/' . $fileName, $output);

            die();
        }
    }

    private function prepareOrderContent($content, $form, $informations, $email, $summary, $showFilesLinks, $totalTxt, $formSession, $variables, $itemsArray, $noSpan, $current_ref) {

        $settings = $this->getSettings();

        add_filter('safe_style_css', function($styles) {
            $styles[] = 'border-color';
            $styles[] = 'background-color';
            $styles[] = 'font-size';
            $styles[] = 'padding';
            $styles[] = 'color';
            $styles[] = 'text-align';
            $styles[] = 'line-height';
            $styles[] = 'margin';
            $styles[] = 'direction';
            $styles[] = 'word-break';
            $styles[] = 'word-wrap';
            $styles[] = 'table-layout';
            $styles[] = 'display';
            $styles[] = 'width';
            $styles[] = 'min-width';
            $styles[] = 'max-width';
            return $styles;
        });

        $summary = wp_kses($summary, array(
            'br' => array(),
            'u' => array(),
            'p' => array(),
            'b' => array(),
            'a' => array('href' => true, 'class' => true),
            'span' => array('style' => true, 'class' => true),
            'strong' => array('style' => true),
            'div' => array('style' => true),
            'td' => array('style' => true, 'align' => true, 'colspan' => true, 'bgcolor' => true, 'color' => true, 'width' => true, 'nowrap' => true),
            'thead' => array('style' => true, 'bgcolor' => true),
            'th' => array('style' => true, 'align' => true, 'colspan' => true, 'bgcolor' => true, 'color' => true, 'width' => true, 'id' => true, 'nowrap' => true),
            'table' => array('style' => true, 'cellspacing' => true, 'cellpadding' => true, 'border' => true, 'width' => true, 'bordercolor' => true, 'bgcolor' => true),
            'tbody' => array('style' => true),
            'tr' => array('style' => true, 'id' => true),
            'img' => array('style' => true)
        ));


        $lastPos = 0;
        $positions = array();

        $toReplaceDefault = array();
        $toReplaceBy = array();
        $informations = stripslashes($informations);
        while (($lastPos = strpos($informations, '<span class="lfb_value">', $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen('<span class="lfb_value">');
            $fileStartPos = $lastPos;
            $lastSpan = strpos($informations, '</span>', $fileStartPos);
            $value = substr($informations, $fileStartPos, $lastSpan - $fileStartPos);
            $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
            $toReplaceBy[] = '<span class="lfb_value">' . $this->stringEncode($value, $settings->encryptDB) . '</span>';
        }
        foreach ($toReplaceBy as $key => $value) {
            $informations = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $informations);
        }

        $informations = wp_kses($informations, array(
            'br' => array(),
            'u' => array(),
            'p' => array(),
            'b' => array(),
            'span' => array('style' => true, 'class' => true),
            'strong' => array(),
        ));


        $projectCustomer = stripslashes($summary);

        $lastPos = 0;
        $positions = array();

        $toReplaceDefault = array();
        $toReplaceBy = array();

        while (($lastPos = strpos($projectCustomer, '<span class="lfb_value">', $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen('<span class="lfb_value">');
            $fileStartPos = $lastPos;
            $lastSpan = strpos($projectCustomer, '</span>', $fileStartPos);
            $value = substr($projectCustomer, $fileStartPos, $lastSpan - $fileStartPos);
            $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
            $toReplaceBy[] = '<span class="lfb_value">' . $this->stringEncode($value, $settings->encryptDB) . '</span>';
        }
        foreach ($toReplaceBy as $key => $value) {
            $projectCustomer = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $projectCustomer);
        }


        if ($showFilesLinks) {
            $toReplaceDefault = array();
            $toReplaceBy = array();
            while (($lastPos = strpos($projectCustomer, 'class="lfb_file">', $lastPos)) !== false) {
                $positions[] = $lastPos;
                $lastPos = $lastPos + 17;
                $fileStartPos = $lastPos;
                $lastSpan = strpos($projectCustomer, '</span>', $fileStartPos);
                $file = substr($projectCustomer, $fileStartPos, $lastSpan - $fileStartPos);
                if (!in_array($file, $toReplaceDefault)) {
                    $toReplaceDefault[] = $file;
                    $filename = $file;
                    if (strlen($filename) > 48) {
                        $filename = substr($filename, 0, 45) . '...';
                    }
                    $toReplaceBy[] = '<a href="' . $this->uploads_url . $formSession . $form->randomSeed . '/' . $file . '">' . $filename . '</a>';
                }
            }
            foreach ($toReplaceBy as $key => $value) {
                $projectCustomer = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $projectCustomer);
            }
        }

        $content = str_replace("[customer_email]", $email, $content);
        $content = str_replace("[project_content]", $projectCustomer, $content);
        $content = str_replace("[information_content]", stripslashes($informations), $content);
        $content = str_replace("[total]", stripslashes(sanitize_text_field($totalTxt)), $content);
        $content = str_replace("[total_price]", stripslashes(sanitize_text_field($totalTxt)), $content);
        $content = str_replace("[ref]", $form->ref_root . $current_ref, $content);
        $content = str_replace("[date]", date_i18n(get_option('date_format')), $content);
        $content = str_replace("[ip]", $this->get_client_ip(), $content);

        $content = $this->prepareEmailContent($content, $form, $formSession, $variables, $itemsArray, $noSpan);

        return $content;
    }

    /*
     * Ajax : send email
     */

    public function send_email() {
        global $wpdb;
        $settings = $this->getSettings();


        $formID = sanitize_text_field($_POST['formID']);
        $table_name = $wpdb->prefix . "wpefc_forms";

        $formSession = sanitize_text_field(($_POST['formSession']));
        // $phone = sanitize_text_field($_POST['phone']);
        $email = sanitize_text_field($_POST['email']);
        $contentTxt = sanitize_text_field($_POST['contentTxt']);
        $contactSent = $_POST['contactSent'];
        $activatePaypal = $_POST['activatePaypal'];
        $finalUrl = sanitize_text_field($_POST['finalUrl']);
        $customerInfos = ($_POST['customerInfos']);

        $total = sanitize_text_field($_POST['total']);
        $totalSub = sanitize_text_field($_POST['totalSub']);
        $subFrequency = sanitize_text_field($_POST['subFrequency']);
        $formTitle = sanitize_text_field($_POST['formTitle']);
        $totalText = sanitize_text_field($_POST['totalText']);
        $signature = ($_POST['signature']);
        $signature = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $signature);

        $stripeToken = false;
        if (isset($_POST['stripeToken'])) {
            $stripeToken = sanitize_text_field($_POST['stripeToken']);
        }
        $captcha = '';
        if (isset($_POST['captcha'])) {
            $captcha = sanitize_text_field($_POST['captcha']);
        }
        $events = stripslashes($_POST['eventsData']);
        $variables = json_decode(stripslashes($_POST['variables']));

        $razorpayReady = sanitize_text_field($_POST['razorpayReady']);
        $stripeCustomerID = false;
        if (isset($_POST['stripeCustomerID'])) {
            $stripeCustomerID = sanitize_text_field($_POST['stripeCustomerID']);
        }
        $stripeSrc = false;
        if (isset($_POST['stripeSrc'])) {
            $stripeSrc = sanitize_text_field($_POST['stripeSrc']);
        }
        $verifiedEmail = false;
        if (isset($_POST['verifiedEmail'])) {
            $verifiedEmail = sanitize_text_field($_POST['verifiedEmail']);
        }
        $itemsArray = $_POST['items'];

        $usePaypalIpn = false;
        if (isset($_POST['usePaypalIpn']) && $_POST['usePaypalIpn'] == '1') {
            $usePaypalIpn = true;
        }
        if ($total == 0 && $totalSub == 0) {
            $usePaypalIpn = false;
        }

        $sendUser = 0;
        $discountCode = sanitize_text_field($_POST['discountCode']);

        $summary = ($_POST['summary']);
        $summaryA = ($_POST['summary']);
        $summary = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $summary);
        $summaryA = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $summaryA);
        $informations = $_POST['informations'];
        $emailToUser = $_POST['email_toUser'];
        $totalTxt = $_POST['totalTxt'];
        $useRtl = $_POST['useRtl'];
        $fieldsLast = $_POST['fieldsLast'];
        $gravity = 0;

        if (isset($_POST['gravity'])) {
            $gravity = $_POST['gravity'];
        }

        $table_name = $wpdb->prefix . "wpefc_forms";
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
        $form = $rows[0];
        $this->verifyCaptchaThen($form,
                $formID,
                $formSession,
                // $phone,
                $email,
                $contentTxt,
                $contactSent,
                $activatePaypal,
                $finalUrl,
                $customerInfos,
                $total,
                $totalSub,
                $subFrequency,
                $formTitle,
                $stripeToken,
                $captcha,
                $events,
                $variables,
                $razorpayReady,
                $stripeCustomerID,
                $stripeSrc,
                $verifiedEmail,
                $itemsArray,
                $usePaypalIpn,
                $sendUser,
                $discountCode,
                $summary,
                $summaryA,
                $informations,
                $emailToUser,
                $totalTxt,
                $useRtl,
                $fieldsLast,
                $gravity,
                $signature,
                $totalText,
                function($form, $formID,
                $formSession,
                // $phone,
                $email,
                $contentTxt,
                $contactSent,
                $activatePaypal,
                $finalUrl,
                $customerInfos,
                $total,
                $totalSub,
                $subFrequency,
                $formTitle,
                $stripeToken,
                $captcha,
                $events,
                $variables,
                $razorpayReady,
                $stripeCustomerID,
                $stripeSrc,
                $verifiedEmail,
                $itemsArray,
                $usePaypalIpn,
                $sendUser,
                $discountCode,
                $summary,
                $summaryA,
                $informations,
                $emailToUser,
                $totalTxt,
                $useRtl,
                $fieldsLast,
                $gravity,
                $signature,
                $totalText) {
            global $wpdb;
            $settings = $this->getSettings();
            if ($discountCode != "") {
                $table_name = $wpdb->prefix . "wpefc_coupons";
                $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND couponCode='%s' LIMIT 1", $formID, $discountCode));
                if (count($rows) > 0) {
                    $coupon = $rows[0];
                    $coupon->currentUses++;
                    if ($coupon->useMax > 0 && $coupon->currentUses >= $coupon->useMax) {
                        $wpdb->delete($table_name, array('id' => $coupon->id));
                    } else {
                        $wpdb->update($table_name, array('currentUses' => $coupon->currentUses), array('id' => $coupon->id));
                    }
                }
            }

            $lfb_session = $this->lfb_getSession();
            $chkEmail = true;
            if ($settings->enableCustomerAccount) {
                $chkEmail = true;

                $table_name = $wpdb->prefix . "wpefc_customers";
                $rows = $wpdb->get_results("SELECT id,email FROM $table_name");
                foreach ($rows as $exCustomer) {
                    if ($this->stringDecode($exCustomer->email, $settings->encryptDB) == $email) {
                        $chkEmail = false;
                    }
                }
                if (!$chkEmail && isset($lfb_session['lfb_verifiedEmail']) && $lfb_session['lfb_verifiedEmail'] == $verifiedEmail) {
                    $chkEmail = true;
                }
            }
            if ($chkEmail) {


                $contentUser = '';
                $contentUserPdf = '';
                $contentAdmin = '';
                $contentAdminPdf = '';

                $table_name = $wpdb->prefix . "wpefc_forms";
                $current_ref = $form->current_ref + 1;
                $wpdb->update($table_name, array('current_ref' => $current_ref), array('id' => $form->id));
                $rep = $form->ref_root . $current_ref;
                $userSubject = '';
                if (!isset($gravity) || $gravity == 0) {

                    if ($emailToUser == '1') {
                        $sendUser = 1;

                        $projectCustomer = stripslashes($summary);

                        $contentUser = $this->prepareOrderContent($form->email_userContent, $form, $informations, $email, $summary, $form->emailCustomerLinks, $totalTxt, $formSession, $variables, $itemsArray, false, $current_ref);
                        $contentUserPdf = $this->prepareOrderContent($form->pdf_userContent, $form, $informations, $email, $summary, $form->emailCustomerLinks, $totalTxt, $formSession, $variables, $itemsArray, false, $current_ref);

                        if ($signature != '' && $form->useSignature) {
                            $contentUser .= '<p style="text-align: right"><img src="' . ($signature) . '"  /></p>';
                            $contentUserPdf .= '<p style="text-align: right"><img src="' . ($signature) . '"  /></p>';
                        }

                        $userSubject = $form->email_userSubject;
                        $userSubject = $this->prepareEmailContent($userSubject, $form, $formSession, $variables, $itemsArray, true);
                    }

                    $adminSubject = $form->email_subject;
                    $adminSubject = $this->prepareEmailContent($adminSubject, $form, $formSession, $variables, $itemsArray, true);

                    $projectAdmin = stripslashes($summaryA);
                    $contentAdmin = $this->prepareOrderContent($form->email_adminContent, $form, $informations, $email, $summary, true, $totalTxt, $formSession, $variables, $itemsArray, false, $current_ref);
                    $contentAdminPdf = $this->prepareOrderContent($form->pdf_adminContent, $form, $informations, $email, $summary, true, $totalTxt, $formSession, $variables, $itemsArray, false, $current_ref);

                    if ($signature != '' && $form->useSignature) {
                        $contentAdmin .= '<p style="text-align: right"><img src="' . ($signature) . '"  /></p>';
                        $contentAdminPdf .= '<p style="text-align: right"><img src="' . ($signature) . '"   /></p>';
                    }

                    if (isset($email) && $contactSent == 0) {
                        if ($form->useMailchimp && $form->mailchimpList != "") {
                            try {
                                if ($customerInfos['address'] == '') {
                                    $customerInfos['address'] = '_';
                                }
                                if ($customerInfos['city'] == '') {
                                    $customerInfos['city'] = '_';
                                }
                                if ($customerInfos['state'] == '') {
                                    $customerInfos['state'] = '_';
                                }
                                if ($customerInfos['zip'] == '') {
                                    $customerInfos['zip'] = '_';
                                }
                                if ($customerInfos['country'] == '') {
                                    $customerInfos['country'] = '_';
                                }
                                $MailChimp = new Mailchimp($form->mailchimpKey);
                                $merge_vars = array('FNAME' => $customerInfos['firstName'], 'LNAME' => $customerInfos['lastName'], 'phone' => $customerInfos['phone'],
                                     'company' => $customerInfos['company'],
                                     'job' => $customerInfos['job'],
                                     'phoneJob' => $customerInfos['phoneJob'],
                                    'ADDRESS' => array('addr1' => $customerInfos['address'], 'city' => $customerInfos['city'], 'state' => $customerInfos['state'], 'zip' => $customerInfos['zip'], 'country' => $customerInfos['country']));

                                $MailChimp->lists->subscribe($form->mailchimpList, array('email' => $email), $merge_vars, 'html', $form->mailchimpOptin);
                            } catch (Throwable $t) {
                                
                            } catch (Exception $e) {
                                
                            }
                        }
                        if ($form->useMailpoet) {
                            try {
                                $subscriber = \MailPoet\API\API::MP('v1')->addSubscriber(
                                        array(
                                            'email' => $email,
                                            'first_name' => $customerInfos['firstName'],
                                            'last_name' => $customerInfos['lastName']
                                        ), array($form->mailPoetList));
                            } catch (Exception $exception) {
                                echo $exception->getMessage();
                            }
                        }
                        if ($form->useGetResponse) {
                            require_once 'getResponse/GetresponseClientFactory.php';
                            require_once 'getResponse/OperationVersionTrait.php';
                            require_once 'getResponse/Client/GetresponseClient.php';
                            require_once 'getResponse/Client/Operation/OperationVersionable.php';
                            require_once 'getResponse/Client/Operation/Operation.php';
                            require_once 'getResponse/Client/Operation/OperationResponseFactory.php';
                            require_once 'getResponse/Client/Operation/OperationResponse.php';
                            require_once 'getResponse/Client/Operation/FailedOperationResponse.php';
                            require_once 'getResponse/Client/Operation/SuccessfulOperationResponse.php';

                            require_once 'getResponse/Client/Operation/CommandOperation.php';
                            require_once 'getResponse/Operation/Contacts/CreateContact/CreateContact.php';
                            require_once 'getResponse/Client/Operation/BaseModel.php';
                            require_once 'getResponse/Operation/Model/CampaignReference.php';
                            require_once 'getResponse/Operation/Model/NewContact.php';
                            require_once 'getResponse/Psr/Log/LoggerInterface.php';
                            require_once 'getResponse/Psr/Log/AbstractLogger.php';
                            require_once 'getResponse/Psr/Log/NullLogger.php';
                            require_once 'getResponse/Client/Debugger/Logger.php';
                            require_once 'getResponse/Client/Handler/RequestHandler.php';
                            require_once 'getResponse/Client/Handler/CurlCallInfoFactory.php';
                            require_once 'getResponse/Client/UAResolver.php';
                            require_once 'getResponse/Client/Version.php';
                            require_once 'getResponse/Version.php';
                            require_once 'getResponse/Psr/MessageInterface.php';
                            require_once 'getResponse/Psr/RequestInterface.php';
                            require_once 'getResponse/Psr/StreamInterface.php';
                            require_once 'getResponse/Psr/ResponseInterface.php';
                            require_once 'getResponse/Psr/Log/LogLevel.php';
                            require_once 'getResponse/Psr/UriInterface.php';
                            require_once 'getResponse/psr7/Stream.php';
                            require_once 'getResponse/psr7/functions.php';
                            require_once 'getResponse/psr7/MessageTrait.php';
                            require_once 'getResponse/psr7/Response.php';
                            require_once 'getResponse/psr7/Request.php';
                            require_once 'getResponse/psr7/Uri.php';
                            require_once 'getResponse/psr7/Rfc7230.php';
                            require_once 'getResponse/Client/Handler/Call/Call.php';
                            require_once 'getResponse/Client/Handler/Call/CallInfo.php';
                            require_once 'getResponse/Client/Handler/Call/CallRegistry.php';
                            require_once 'getResponse/Client/Authentication/AuthenticationProvider.php';
                            require_once 'getResponse/Client/Environment/Environment.php';
                            require_once 'getResponse/Environment/GetResponse.php';
                            require_once 'getResponse/Client/Handler/CurlRequestHandler.php';
                            require_once 'getResponse/Client/Debugger/Logger.php';
                            require_once 'getResponse/Authentication/ApiKey.php';



                            $createContact = new Getresponse\Sdk\Operation\Model\NewContact(
                                    new Getresponse\Sdk\Operation\Model\CampaignReference($form->getResponseList),
                                    $email
                            );
                            $createContact->setName($customerInfos['firstName'] . ' ' . $customerInfos['lastName']);

                            $createContactOperation = new Getresponse\Sdk\Operation\Contacts\CreateContact\CreateContact($createContact);
                            $client = $client = Getresponse\Sdk\GetresponseClientFactory::createWithApiKey($form->getResponseKey);
                            $response = $client->call($createContactOperation);

                            if ($response->isSuccess()) {
                                
                            }
                        }
                    }
                    $table_name = $wpdb->prefix . "wpefc_customers";
                    $rows = $wpdb->get_results("SELECT id,email,password,verifiedEmail FROM $table_name");
                    $customerID = 0;
                    $pass = "";
                    foreach ($rows as $exCustomer) {
                        if ($this->stringDecode($exCustomer->email, $settings->encryptDB) == $email) {
                            $customerID = $exCustomer->id;
                            $pass = $this->stringDecode($exCustomer->password, true);
                            if ($form->useEmailVerification || !$exCustomer->verifiedEmail) {

                                $updateData = array();
                                foreach ($customerInfos as $key => $value) {
                                    if ($value != '' && $key != 'email') {
                                        $updateData[$key] = $this->stringEncode($value, $settings->encryptDB);
                                    }
                                }
                                if (count($updateData) > 0) {
                                    $wpdb->update($table_name, $updateData, array('id' => $customerID));
                                }
                            }
                            break;
                        }
                    }
                    if ($customerID == 0) {
                        $pass = $this->generatePassword();
                        $table_name = $wpdb->prefix . "wpefc_customers";
                        $wpdb->insert($table_name, array(
                            'email' => $this->stringEncode($email, $settings->encryptDB),
                            'password' => $this->stringEncode($pass, true),
                            'phone' => $this->stringEncode($customerInfos['phone'], $settings->encryptDB),
                            'firstName' => $this->stringEncode($customerInfos['firstName'], $settings->encryptDB), 'lastName' => $this->stringEncode($customerInfos['lastName'], $settings->encryptDB),
                            'address' => $this->stringEncode($customerInfos['address'], $settings->encryptDB), 'city' => $this->stringEncode($customerInfos['city'], $settings->encryptDB), 'country' => $this->stringEncode($customerInfos['country'], $settings->encryptDB),
                            'state' => $this->stringEncode($customerInfos['state'], $settings->encryptDB), 'zip' => $this->stringEncode($customerInfos['zip'], $settings->encryptDB),
                            'job' => $this->stringEncode($customerInfos['job'], $settings->encryptDB),
                            'phoneJob' => $this->stringEncode($customerInfos['phoneJob'], $settings->encryptDB),
                            'url' => $this->stringEncode($customerInfos['url'], $settings->encryptDB),
                            'company' => $this->stringEncode($customerInfos['company'], $settings->encryptDB),
                            'verifiedEmail' => $form->useEmailVerification,
                            'inscriptionDate' => date("Y-m-d H:i:s")
                                )
                        );
                        $customerID = $wpdb->insert_id;
                    }

                    $table_name = $wpdb->prefix . "wpefc_logs";
                    $checked = false;
                    if ($useRtl == 'true') {
                        $contentAdmin = '<div style="direction: rtl;">' . $contentAdmin . '</div>';
                        $contentUser = '<div style="direction: rtl;">' . $contentUser . '</div>';
                    }

                    if ($form->enablePdfDownload) {

                        $orderPdfContent = $form->pdf_userContent;
                        $txt_orderType = $form->txt_quotation;

                        $orderPdfContent = str_replace("[order_type]", $txt_orderType, $orderPdfContent);
                        $orderPdfContent = str_replace("[ref]", $form->ref_root . $current_ref, $orderPdfContent);

                        $contentUserPdfDw = $this->prepareOrderContent($orderPdfContent, $form, $informations, $email, $summary, $form->emailCustomerLinks, $totalTxt, $formSession, $variables, $itemsArray, false, $current_ref);

                        $lastPos = 0;
                        $positions = array();
                        $toReplaceDefault = array();
                        $toReplaceBy = array();
                        while (($lastPos = strpos($contentUserPdfDw, '<span class="lfb_value">', $lastPos)) !== false) {
                            $positions[] = $lastPos;
                            $lastPos = $lastPos + strlen('<span class="lfb_value">');
                            $fileStartPos = $lastPos;
                            $lastSpan = strpos($contentUserPdfDw, '</span>', $fileStartPos);
                            $value = substr($contentUserPdfDw, $fileStartPos, $lastSpan - $fileStartPos);
                            $toReplaceDefault[] = '<span class="lfb_value">' . $value . '</span>';
                            $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
                        }
                        foreach ($toReplaceBy as $key => $value) {
                            $contentUserPdfDw = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $contentUserPdfDw);
                        }
                        $contentPdf = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>body,*{font-family: "dejavu sans" !important; } hr{color: #ddd; border-color: #ddd;} table{width: 100% !important; line-height: 18px;} table td, table th{width: auto!important; border: 1px solid #ddd; line-height: 16px; overflow-wrap: break-word;}table td,table tbody th  {padding-top: 2px !important; padding-bottom: 6px !important} table thead th {padding: 8px;line-height: 18px;}tbody:before, tbody:after { display: none; }</style></head><body>' . $contentUserPdfDw . '</body></html>';
                        $contentPdf = str_replace('border="1"', '', $contentPdf);
                        $upDir = wp_upload_dir();
                        $contentPdf = str_replace('src="' . get_site_url() . '/wp-content/uploads/', 'src="' . $upDir['basedir'] . '/', $contentPdf);
                        $contentPdf = mb_convert_encoding($contentPdf, 'HTML-ENTITIES', 'UTF-8');

                        require_once("dompdf/autoload.inc.php");
                        $dompdf = new Dompdf\Dompdf();
                        $dompdf->load_html($contentPdf, 'UTF-8');
                        $dompdf->set_paper('a4', 'portrait');
                        $dompdf->render();
                        $lfb_session = $this->lfb_getSession();
                        $uniqueID = $this->generateRandomString(8);

                        $this->lfb_updateSession('orderToDownload', $uniqueID);
                        $this->lfb_updateSession('orderTitle', $form->pdfDownloadFilename);
                        $fileName = $uniqueID . '.pdf';

                        $output = $dompdf->output();
                        file_put_contents($this->dir . '/uploads/' . $fileName, $output);
                    }


                    $paymentKey = md5(uniqid());
                    $paid = 0;
                    $useRazor = false;
                    if ($razorpayReady == 1) {
                        $paid = 1;
                        $useRazor = true;
                    }
                    if ($stripeToken != "" && $form->use_stripe) {
                        $paid = 1;
                    }
                    $wpdb->insert($table_name, array('ref' => $form->ref_root . $current_ref, 'email' => $this->stringEncode($email, $settings->encryptDB), 'phone' => $this->stringEncode($customerInfos['phone'], $settings->encryptDB), 'firstName' => $this->stringEncode($customerInfos['firstName'], $settings->encryptDB), 'lastName' => $this->stringEncode($customerInfos['lastName'], $settings->encryptDB),
                        'address' => $this->stringEncode($customerInfos['address'], $settings->encryptDB), 'city' => $this->stringEncode($customerInfos['city'], $settings->encryptDB), 'country' => $this->stringEncode($customerInfos['country'], $settings->encryptDB), 'state' => $this->stringEncode($customerInfos['state'], $settings->encryptDB), 'zip' => $this->stringEncode($customerInfos['zip'], $settings->encryptDB),
                        'formID' => $formID, 'dateLog' => date('Y-m-d'), 'content' => $contentAdmin, 'contentUser' => $contentUser,
                        'pdfContent' => $contentAdminPdf, 'pdfContentUser' => $contentUserPdf,
                        'sendToUser' => $sendUser,
                        'totalPrice' => $total, 'totalSubscription' => $totalSub, 'subscriptionFrequency' => $subFrequency, 'formTitle' => $formTitle, 'contentTxt' => $this->stringEncode($contentTxt, $settings->encryptDB),
                        'paymentKey' => $paymentKey, 'finalUrl' => $finalUrl, 'eventsData' => $events, 'customerID' => $customerID, 'sessionF' => $formSession, 'paid' => $paid,
                        'currency' => $form->currency,
                        'currencyPosition' => $form->currencyPosition,
                        'thousandsSeparator' => $form->thousandsSeparator,
                        'decimalsSeparator' => $form->decimalsSeparator,
                        'millionSeparator' => $form->millionSeparator,
                        'billionsSeparator' => $form->billionsSeparator,
                        'userEmailSubject' => sanitize_text_field($userSubject),
                        'adminEmailSubject' => sanitize_text_field($adminSubject),
                        'totalText' => $totalText,
                        'status' => $form->defaultStatus));

                    $orderID = $wpdb->insert_id;
                    $chkStripe = false;
                    $useStripe = false;
                    if ($stripeToken != "" && $form->use_stripe) {
                        $useStripe = true;
                        $chkStripe = true;
                    }
                    if ((!$usePaypalIpn || $activatePaypal == "false") || ($useStripe) || $useRazor) {
                        $this->sendOrderEmail($form->ref_root . $current_ref, $form->id);
                    } else if ($useStripe && !$chkStripe) {
                        $rep = '';
                    }
                }
                echo $rep;
                $this->lfb_destroySession();
            }
        });

        die();
    }

    public function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    private function getVariableByID($variables, $variableID) {
        $rep = false;
        foreach ($variables as $variable) {
            if ($variable->id == $variableID) {
                $rep = $variable;
            }
        }
        return $rep;
    }

    private function prepareEmailContent($content, $form, $formSession, $variables, $itemsArray, $noSpan) {
        $settings = $this->getSettings();

        $lastPos = 0;
        while (($lastPos = strpos($content, '[variable-', $lastPos)) !== false) {
            $variableID = substr($content, $lastPos + 10, (strpos($content, ']', $lastPos) - ($lastPos + 10)));
            $variable = $this->getVariableByID($variables, $variableID);
            $newValue = '';
            if ($variable) {
                $newValue = $variable->value;
            }

            $newContent = substr($content, 0, $lastPos);
            $newContent .= $newValue;
            $newContent .= substr($content, strpos($content, ']', $lastPos) + 1);
            $content = $newContent;

            $lastPos += 10;
        }

        $lastPos = 0;
        $titleItem = '';
        while (($lastPos = strpos($content, '[item-', $lastPos)) !== false) {
            $itemID = substr($content, $lastPos + 6, (strpos($content, '_', $lastPos) - ($lastPos + 6)));

            $attribute = substr($content, strpos($content, '_', $lastPos) + 1, ((strpos($content, ']', $lastPos)) - strpos($content, '_', $lastPos)) - 1);
            if ($attribute == 'title') {
                $attribute = 'label';
            }
            $newContent = substr($content, 0, $lastPos);
            $newValue = '';
            $itemFound = false;
            if (isset($value['label'])) {
                $titleItem = $value['label'];
            }
            if (substr($itemID, 0, 1) != 'f') {
                foreach ($itemsArray as $key => $value) {
                    if ($value['itemid'] == $itemID) {
                        if ($value[$attribute]) {
                            $newValue = stripslashes($value[$attribute]);
                            if ($attribute == 'value') {
                                if (!$noSpan) {
                                    $newValue = '<span class="lfb_value">' . $this->stringEncode($newValue, $settings->encryptDB) . '</span>';
                                }
                            }
                            if (isset($value['isFile']) && $value['isFile'] == 'true' && $attribute == 'value') {
                                $newValue = stripslashes($value[$attribute]);
                                $i_lastPos = 0;
                                while (($i_lastPos = strpos($newValue, 'class="lfb_file">', $i_lastPos)) !== false) {
                                    $positions[] = $i_lastPos;
                                    $i_lastPos = $i_lastPos + 17;
                                    $fileStartPos = $i_lastPos;
                                    $lastSpan = strpos($newValue, '</span>', $fileStartPos);
                                    $file = substr($newValue, $fileStartPos, $lastSpan - $fileStartPos);
                                    if (!$noSpan) {
                                        $newValue = str_replace($file, '<a href="' . $this->uploads_url . $formSession . $form->randomSeed . '/' . $file . '">' . $file . '</a>', $newValue);
                                    } else {
                                        $newValue = $file;
                                    }
                                }
                            }
                            $itemFound = true;
                        }
                    }
                }
            } else {
                foreach ($fieldsLast as $key => $value) {
                    if ($value['fieldID'] == substr($itemID, 1)) {
                        $newValue = stripslashes($value['value']);
                        if ($attribute == 'value') {
                            if (!$noSpan) {
                                $newValue = '<span class="lfb_value">' . $this->stringEncode($newValue, $settings->encryptDB) . '</span>';
                            }
                        }
                        if ($value['isFile'] == 'true' && $attribute == 'value') {
                            $i_lastPos = 0;
                            while (($i_lastPos = strpos($newValue, 'class="lfb_file">', $i_lastPos)) !== false) {
                                $positions[] = $i_lastPos;
                                $i_lastPos = $i_lastPos + 17;
                                $fileStartPos = $i_lastPos;
                                $lastSpan = strpos($newValue, '</span>', $fileStartPos);
                                $file = substr($newValue, $fileStartPos, $lastSpan - $fileStartPos);
                                if (!$noSpan) {
                                    $newValue = str_replace($file, '<a href="' . $this->uploads_url . $formSession . $form->randomSeed . '/' . $file . '">' . $file . '</a>', $newValue);
                                } else {
                                    $newValue = $file;
                                }
                            }
                        }
                        $itemFound = true;
                    }
                }
            }
            if ($attribute == 'price') {
                $newValue = $this->getFormatedPrice((float) $newValue, $form);
                if ($form->currencyPosition == 'right') {
                    $newValue = $newValue . $form->currency;
                } else {
                    $newValue = $form->currency . $newValue;
                }
            } else if ($attribute == 'image') {
                $newValue = '<img src="' . $newValue . '" alt="' . $titleItem . '" />';
            }
            $newContent .= stripslashes(nl2br($newValue));
            $newContent .= substr($content, strpos($content, ']', $lastPos) + 1);
            $content = $newContent;

            if ($itemFound) {
                $lastPos += 6;
            } else {
                $lastPos += 1;
            }
        }
        return $content;
    }

    private function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function sendContact() {
        global $wpdb;
        $phone = sanitize_text_field($_POST['phone']);
        $firstName = sanitize_text_field($_POST['firstName']);
        $lastName = sanitize_text_field($_POST['lastName']);
        $address = sanitize_text_field($_POST['address']);
        $city = sanitize_text_field($_POST['city']);
        $country = sanitize_text_field($_POST['country']);
        $state = sanitize_text_field($_POST['state']);
        $zip = sanitize_text_field($_POST['zip']);
        $email = sanitize_text_field($_POST['email']);
        $formID = sanitize_text_field($_POST['formID']);

        $table_name = $wpdb->prefix . "wpefc_forms";
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
        if (count($rows) > 0) {
            $form = $rows[0];

            if (isset($_POST['email'])) {
                if ($form->useMailchimp && $form->mailchimpList != "") {
                    try {

                        if ($address == '') {
                            $address = '_';
                        }
                        if ($country == '') {
                            $country = '_';
                        }
                        if ($state == '') {
                            $state = '_';
                        }
                        if ($zip == '') {
                            $zip = '_';
                        }
                        if ($country == '') {
                            $country = '_';
                        }

                        $MailChimp = new Mailchimp($form->mailchimpKey);
                        $merge_vars = array('FNAME' => $firstName, 'LNAME' => $lastName, 'phone' => $phone,
                            'ADDRESS' => array('addr1' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip, 'country' => $country));

                        $MailChimp->lists->subscribe($form->mailchimpList, array('email' => $email), $merge_vars, 'html', $form->mailchimpOptin);
                    } catch (Throwable $t) {
                        
                    } catch (Exception $e) {
                        
                    }
                }
                if ($form->useMailpoet) {
                    try {
                        $subscriber = \MailPoet\API\API::MP('v1')->addSubscriber(
                                array(
                                    'email' => $email,
                                    'first_name' => $firstName,
                                    'last_name' => $lastName
                                ), array($form->mailPoetList));
                    } catch (Exception $exception) {
                        echo $exception->getMessage();
                    }
                }
                if ($form->useGetResponse) {

                    require_once 'getResponse/GetresponseClientFactory.php';
                    require_once 'getResponse/OperationVersionTrait.php';
                    require_once 'getResponse/Client/GetresponseClient.php';
                    require_once 'getResponse/Client/Operation/OperationVersionable.php';
                    require_once 'getResponse/Client/Operation/Operation.php';
                    require_once 'getResponse/Client/Operation/OperationResponseFactory.php';
                    require_once 'getResponse/Client/Operation/OperationResponse.php';
                    require_once 'getResponse/Client/Operation/FailedOperationResponse.php';
                    require_once 'getResponse/Client/Operation/SuccessfulOperationResponse.php';
                    require_once 'getResponse/Client/Operation/CommandOperation.php';
                    require_once 'getResponse/Operation/Contacts/CreateContact/CreateContact.php';
                    require_once 'getResponse/Client/Operation/BaseModel.php';
                    require_once 'getResponse/Operation/Model/CampaignReference.php';
                    require_once 'getResponse/Operation/Model/NewContact.php';
                    require_once 'getResponse/Psr/Log/LoggerInterface.php';
                    require_once 'getResponse/Psr/Log/AbstractLogger.php';
                    require_once 'getResponse/Psr/Log/NullLogger.php';
                    require_once 'getResponse/Client/Debugger/Logger.php';
                    require_once 'getResponse/Client/Handler/RequestHandler.php';
                    require_once 'getResponse/Client/Handler/CurlCallInfoFactory.php';
                    require_once 'getResponse/Client/UAResolver.php';
                    require_once 'getResponse/Client/Version.php';
                    require_once 'getResponse/Version.php';
                    require_once 'getResponse/Psr/MessageInterface.php';
                    require_once 'getResponse/Psr/RequestInterface.php';
                    require_once 'getResponse/Psr/StreamInterface.php';
                    require_once 'getResponse/Psr/ResponseInterface.php';
                    require_once 'getResponse/Psr/Log/LogLevel.php';
                    require_once 'getResponse/Psr/UriInterface.php';
                    require_once 'getResponse/psr7/Stream.php';
                    require_once 'getResponse/psr7/functions.php';
                    require_once 'getResponse/psr7/MessageTrait.php';
                    require_once 'getResponse/psr7/Response.php';
                    require_once 'getResponse/psr7/Request.php';
                    require_once 'getResponse/psr7/Uri.php';
                    require_once 'getResponse/psr7/Rfc7230.php';
                    require_once 'getResponse/Client/Handler/Call/Call.php';
                    require_once 'getResponse/Client/Handler/Call/CallInfo.php';
                    require_once 'getResponse/Client/Handler/Call/CallRegistry.php';
                    require_once 'getResponse/Client/Authentication/AuthenticationProvider.php';
                    require_once 'getResponse/Client/Environment/Environment.php';
                    require_once 'getResponse/Environment/GetResponse.php';
                    require_once 'getResponse/Client/Handler/CurlRequestHandler.php';
                    require_once 'getResponse/Client/Debugger/Logger.php';
                    require_once 'getResponse/Authentication/ApiKey.php';



                    $createContact = new Getresponse\Sdk\Operation\Model\NewContact(
                            new Getresponse\Sdk\Operation\Model\CampaignReference($form->getResponseList),
                            $email
                    );
                    $createContact->setName($firstName . ' ' . $lastName);

                    $createContactOperation = new Getresponse\Sdk\Operation\Contacts\CreateContact\CreateContact($createContact);
                    $client = $client = Getresponse\Sdk\GetresponseClientFactory::createWithApiKey($form->getResponseKey);
                    $response = $client->call($createContactOperation);
                    if ($response->isSuccess()) {
                        
                    }
                }
            }
        }
        die();
    }

    public function applyCouponCode() {
        global $wpdb;
        $rep = '';
        $table_name = $wpdb->prefix . "wpefc_coupons";
        $formID = sanitize_text_field($_POST['formID']);
        $code = sanitize_text_field($_POST['code']);
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name  WHERE couponCode='%s' AND formID=%s LIMIT 1", $code, $formID));
        $chk = false;
        if (count($rows) > 0) {
            $coupon = $rows[0];
            if ($coupon->reductionType == 'percentage') {
                $rep = $coupon->reduction . '%';
            } else {
                $rep = $coupon->reduction;
            }
        }
        echo $rep;
        die();
    }

    function custom_wp_mail_from($email) {
        return sanitize_text_field($_POST['email']);
    }

    /**
     * Get  fields datas
     * @since   1.6.0
     * @return object
     */
    public function getFieldsData() {
        global $wpdb;
        $table_name = $wpdb->prefix . "wpefc_fields";
        $rows = $wpdb->get_results("SELECT * FROM $table_name  ORDER BY ordersort ASC");
        return $rows;
    }

    /**
     * Get  fields from specific form
     * @since   1.6.0
     * @return object
     */
    public function getFieldDatas($form_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . "wpefc_items";
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s AND stepID=0 AND type!='row' ORDER BY ordersort ASC, id ASC", $form_id));
        return $rows;
    }

    /**
     * Get  form by pageID
     * @since   1.6.0
     * @return object
     */
    public function getFormByPageID($pageID) {
        global $wpdb;
        $table_name = $wpdb->prefix . "wpefc_forms";
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE form_page_id=%s LIMIT 1", $pageID));
        if ($rows) {
            return $rows[0];
        } else {
            return null;
        }
    }

    /**
     * Get Forms datas
     * @return Array
     */
    private function getFormsData() {
        global $wpdb;
        $table_name = $wpdb->prefix . "wpefc_forms";
        $rows = $wpdb->get_results("SELECT * FROM $table_name");
        return $rows;
    }

    /**
     * Get specific Form datas
     * @return object
     */
    public function getFormDatas($form_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . "wpefc_forms";
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $form_id));
        if (count($rows) > 0) {
            return $rows[0];
        } else {
            return null;
        }
    }

    private function get_extension($file) {
        $tmp = explode('.', $file);
        $extension = end($tmp);
        return $extension ? $extension : false;
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

    /**
     * Recover uploaded files from the form
     * @access  public
     * @since   1.0.0
     * @return  object
     */
    public function uploadFormFiles() {
        global $wpdb;
        $formSession = sanitize_text_field($_POST['formSession']);
        $itemID = sanitize_text_field($_POST['itemID']);
        $formID = sanitize_text_field($_GET['form']);

        if (!preg_match("/[^A-Za-z0-9]/", $formSession)) {

            $table_name = $wpdb->prefix . "wpefc_forms";
            $formReq = $wpdb->get_results($wpdb->prepare("SELECT id,randomSeed,emailCustomerLinks FROM $table_name WHERE id='%s' LIMIT 1", $formID));
            if (count($formReq) > 0) {
                $form = $formReq[0];

                $table_name = $wpdb->prefix . "wpefc_items";
                $rows = $wpdb->get_results($wpdb->prepare("SELECT id,fileSize,allowedFiles FROM $table_name WHERE id=%s LIMIT 1", $itemID));
                $maxSize = 25;
                if (count($rows) > 0) {
                    $item = $rows[0];
                    $maxSize = $item->fileSize;
                    if ($maxSize == 0) {
                        $maxSize = 25;
                    }
                    $maxSize = $maxSize * pow(1024, 2);
                    foreach ($_FILES as $key => $value) {
                        if ($value["error"] > 0) {
                            echo "error";
                        } else {
                            if (strlen($value["name"]) > 4 &&
                                    $value['size'] < $maxSize &&
                                    strpos(strtolower($value["name"]), '.php') === false &&
                                    strpos(strtolower($value["name"]), '.js') === false &&
                                    strpos(strtolower($value["name"]), '.html') === false &&
                                    strpos(strtolower($value["name"]), '.phtml') === false &&
                                    strpos(strtolower($value["name"]), '.pl') === false &&
                                    strpos(strtolower($value["name"]), '.py') === false &&
                                    strpos(strtolower($value["name"]), '.jsp') === false &&
                                    strpos(strtolower($value["name"]), '.asp') === false &&
                                    strpos(strtolower($value["name"]), '.htm') === false &&
                                    strpos(strtolower($value["name"]), '.shtml') === false &&
                                    strpos(strtolower($value["name"]), '.sh') === false &&
                                    strpos(strtolower($value["name"]), '.cgi') === false &&
                                    strpos(strtolower($value["name"]), '.htaccess') === false &&
                                    strpos(strtolower($value["name"]), '..') === false &&
                                    strpos(strtolower($value["name"]), '/') === false
                            ) {
                                $fileName = str_replace('..', '', $value["name"]);
                                $fileName = str_replace('/', '', $fileName);
                                $fileName = str_replace(' ', '_', $fileName);
                                $fileName = str_replace("'", '_', $fileName);
                                $fileName = str_replace('"', '_', $fileName);
                                $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '', $fileName);

                                if ($form->randomSeed == '') {
                                    $form->randomSeed = $this->generateRandomString(5);
                                    $table_forms = $wpdb->prefix . "wpefc_forms";
                                    $wpdb->update($table_forms, array('randomSeed' => $form->randomSeed), array('id' => $form->id));
                                }

                                $ext = $this->get_extension($value["name"]);
                                if ($item->allowedFiles == 'image/*') {
                                    $allowedFiles = array('.jpg', '.jpeg', '.png', '.gif');
                                } else {
                                    $allowedFiles = explode(",", $item->allowedFiles);
                                }
                                if (in_array('.' . strtolower($ext), $allowedFiles) || $item->allowedFiles = '') {
                                    if (!is_dir($this->uploads_dir . $formSession . $form->randomSeed)) {
                                        mkdir($this->uploads_dir . $formSession . $form->randomSeed);
                                        chmod($this->uploads_dir . $formSession . $form->randomSeed, $this->chmodWrite);
                                        $fp = fopen($this->uploads_dir . $formSession . $form->randomSeed . '/.htaccess', 'w');
                                        fwrite($fp, '<FilesMatch "\.(htaccess|htpasswd|ini|phps?|fla|psd|log|sh|zip|exe|pl|jsp|asp|htm|pht|phar|sh|cgi|py|php|php\.)$">' . "\n");
                                        fwrite($fp, 'Order Allow,Deny' . "\n");
                                        fwrite($fp, 'Deny from all' . "\n");
                                        fwrite($fp, '</FilesMatch>');
                                        fclose($fp);
                                    }
                                    $randomS = rand(1, 10000);
                                    move_uploaded_file($value["tmp_name"], $this->uploads_dir . $formSession . $form->randomSeed . '/' . $randomS . '_' . $fileName);
                                    chmod($this->uploads_dir . $formSession . $form->randomSeed . '/' . $fileName, 0644);
                                    if ($form->emailCustomerLinks == 1) {
                                        echo $this->uploads_url . $formSession . $form->randomSeed . '/' . $randomS . '_' . $fileName;
                                        echo '||';
                                    }
                                    echo $randomS;
                                }
                            }
                        }
                    }
                }
            }
        }

        die();
    }

    /**
     * Return steps data.
     * @access  public
     * @since   1.0.0
     * @return  object
     */
    public function getStepsData($form_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . "wpefc_steps";
        $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s ORDER BY ordersort", $form_id));
        return $rows;
    }

    /**
     * Return items data.
     * @access  public
     * @since   1.0.0
     * @return  object
     */
    public function getItemsData($form_id) {
        global $wpdb;
        $results = array();
        $table_name = $wpdb->prefix . "wpefc_steps";
        $steps = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE formID=%s ORDER BY ordersort", $form_id));
        foreach ($steps as $step) {
            $table_name = $wpdb->prefix . "wpefc_items";
            $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE stepID=%s ORDER BY ordersort", $step->id));
            foreach ($rows as $row) {
                $results[] = $row;
            }
        }
        return $results;
    }

// End getItemsData()

    /**
     * Save form datas to cart (woocommerce only)
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function cart_save() {
        global $woocommerce;
        global $wpdb;
        $formID = sanitize_text_field($_POST['formID']);
        $products = $_POST['products'];

        $table_name = $wpdb->prefix . "wpefc_forms";
        $formReq = $wpdb->get_results($wpdb->prepare("SELECT id,wooShowFormTitles FROM $table_name WHERE id='%s' LIMIT 1", $formID));
        if (count($formReq) > 0) {
            $form = $formReq[0];

            if (isset($_POST['emptyWooCart']) && $_POST['emptyWooCart'] == '1') {
                $woocommerce->cart->empty_cart();
            }

            foreach ($products as $product) {
//variation
                $productWoo = new WC_Product($product['product_id']);
                if ($product['variation'] != 0) {
                    $productWoo = new WC_Product_Variation($product['variation']);
                }
                $existInCart = false;
                $productData = array();
                $productData['lfbRef'] = sanitize_text_field($_POST['ref']);
                $productData['custom_price'] = ($product['price']);

                if ($form->wooShowFormTitles) {
                    $productData['custom_title'] = sanitize_text_field($product['title']);
                } else {
                    $productData['custom_title'] = '';
                }

                if ($product['variation'] == '0') {
                    $woocommerce->cart->add_to_cart($product['product_id'], $product['quantity'], null, null, $productData);
                } else {
                    $variation = new WC_Product_Variation($product['variation']);
                    $attributes = $productWoo->get_variation_attributes();
                    $woocommerce->cart->add_to_cart($product['product_id'], $product['quantity'], $product['variation'], $attributes, $productData);
                }
            }
        }
        die();
    }

    public function wooCommerceCalculateTotal($cart_object) {
        if (!WC()->session->__isset("reload_checkout")) {
            foreach ($cart_object->cart_contents as $key => $value) {
                if (isset($value["custom_price"])) {
                    $value['data']->set_price($value["custom_price"]);
                    if ($value["custom_title"] != '') {
                        $value['data']->set_name($value["custom_title"]);
                    }
                }
            }
        }
    }

    public function cartdd_save() {
        $products = $_POST['products'];
        foreach ($products as $product) {
            $download = new EDD_Download($product['product_id']);
            $arg = array();
            if ($product['variation'] > 0) {
                $arg['price_id'] = $product['variation'];
            }
            for ($i = 0; $i < $product['quantity']; $i++) {
                $result = edd_add_to_cart($product['product_id'], $arg);
                echo $result;
            }
        }
        die();
    }

    private function encodeCalculation($calculation) {
        $chars = [
            '1' => '7',
            '2' => '4',
            '3' => '1',
            '4' => '6',
            '5' => '2',
            '6' => '5',
            '7' => '9',
            '8' => '3',
            '9' => '0',
            '0' => '8'
        ];
        $encrypted = '';
        $calculation = trim(preg_replace('/\s+/', ' ', $calculation));
        for ($i = 0; $i < strlen($calculation); $i++) {
            $encrypted .= array_key_exists($calculation[$i], $chars) ? $chars[$calculation[$i]] : $calculation[$i];
        }


        return $encrypted;
    }

    public function makeRazorPayment() {
        global $wpdb;
        require_once('razorpay-php/Razorpay.php');
        $formID = sanitize_text_field($_POST['formID']);
        $singleCost = sanitize_text_field($_POST['singleCost']);
        $subCost = sanitize_text_field($_POST['subCost']);
        $ref = sanitize_text_field($_POST['ref']);
        $email = sanitize_text_field($_POST['email']);

        $rep = 0;
        $settings = $this->getSettings();
        $form = $this->getFormDatas($formID);

        $api = new Razorpay\Api\Api($form->razorpay_publishKey, $form->razorpay_secretKey);

        if ($subCost > 0) {
            $interval = $form->razorpay_subsFrequencyType;
            $intervalFreq = $form->razorpay_subsFrequency;
            $price = $subCost;
            if ($form->razorpay_currency == "JPY") {
                $price = number_format((int) $price, 0, '', '');
            } else {
                $price = number_format((float) $price, 2, '', '');
            }

            try {
                $trialDays = 0;

                $plan = $api->plan->create(
                        array('period' => $interval,
                            'interval' => $intervalFreq,
                            'item' => array('name' => $form->title . ' - ' . $order->ref, 'amount' => $price, 'currency' => ($form->razorpay_currency)))
                );
                $maxCount = 120;
                if ($intervalFreq == 'yearly') {
                    $maxCount = 10;
                } else if ($intervalFreq == 'weekly') {
                    $maxCount = 520;
                } else if ($intervalFreq == 'daily') {
                    $maxCount = 456;
                }
                $subData = array('plan_id' => $plan->id, 'notes' => array('email' => $email), 'total_count' => $maxCount);

                if ($singleCost > 0) {
                    $trialDays = 30 * $intervalFreq;
                    if ($interval == 'day') {
                        $trialDays = 1 * $intervalFreq;
                    }
                    if ($interval == 'week') {
                        $trialDays = 7 * $intervalFreq;
                    }
                    if ($interval == 'year') {
                        $trialDays = 365 * $intervalFreq;
                    }
                    $todayDate = date();
                    $startSubDate = date('Y-m-d', strtotime($todayDate . ' + ' . $trialDays . ' days'));

                    if ($form->razorpay_payMode == "percent") {
                        if ($form->razorpay_percentToPay != 100) {
                            $singleCost = ($singleCost * $form->razorpay_percentToPay) / 100;
                        }
                    } else if ($form->razorpay_payMode == "fixed") {
                        $singleCost = $form->razorpay_fixedToPay;
                    }

                    if ($form->razorpay_currency == "JPY") {
                        $singlePrice = number_format((int) $singleCost, 0, '', '');
                    } else {
                        $singlePrice = number_format((float) $singleCost, 2, '', '');
                    }
                    $subData['start_at'] = strtotime($startSubDate);
                    $subData['addons'] = array(array('item' => array('name' => $form->title . ' - ' . $order->ref, 'amount' => $singlePrice, 'currency' => $form->razorpay_currency)));
                }


                $sub = $api->subscription->create(
                        $subData
                );

                $rep = $sub->id;
            } catch (Throwable $t) {
                echo 'error:' . $t->getMessage();
            } catch (Exception $e) {
                echo 'error:' . $t->getMessage();
            }
        } else if ($singleCost > 0) {
            if ($form->razorpay_payMode == "percent") {
                if ($form->razorpay_percentToPay != 100) {
                    $singleCost = ($singleCost * $form->razorpay_percentToPay) / 100;
                }
            } else if ($form->razorpay_payMode == "fixed") {
                $singleCost = $form->razorpay_fixedToPay;
            }

            if ($form->razorpay_currency == "JPY") {
                $price = number_format((int) $singleCost, 0, '', '');
            } else {
                $price = number_format((float) $singleCost, 2, '', '');
            }
            try {
                $orderData = [
                    'receipt' => $order->ref,
                    'amount' => $price,
                    'currency' => $form->razorpay_currency,
                    'payment_capture' => 0
                ];
                $razorpayOrder = $api->order->create($orderData);
                $rep = $razorpayOrder['id'];
            } catch (Throwable $t) {
                echo 'error: ' . $t->getMessage();
            }
        }
        echo $rep;
        die();
    }

    function getStripePaymentIntent() {
        global $wpdb;
        $formID = sanitize_text_field($_POST['formID']);
        $singleTotal = sanitize_text_field($_POST['singleTotal']);
        $subTotal = sanitize_text_field($_POST['subTotal']);
        $customerInfos = ($_POST['customerInfos']);



        $table_name = $wpdb->prefix . "wpefc_forms";
        $formReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s LIMIT 1", $formID));
        if (count($formReq) > 0) {
            $form = $formReq[0];

            $total = $singleTotal;
            if ($subTotal > 0 && $singleTotal == 0) {
                $total = $subTotal;
            }


            if ($total > 0) {
                // $total = number_format((float) $total, 2, '.', '');
                // $total *= 100;
                if ($form->stripe_currency == "JPY") {
                    $total = number_format((int) $total, 0, '', '');
                } else {
                    $total = number_format((float) $total, 2, '.', '');
                    $total *= 100;
                }


                $pubKey = $form->stripe_publishKey;
                $secretKey = $form->stripe_secretKey;

                require_once('stripe-php-6.38.0/init.php');
                if ($secretKey != '') {
                    \Stripe\Stripe::setApiKey($secretKey);

                    $address = array();
                    $address['line1'] = ' ';
                    $address['city'] = '';
                    $address['country'] = '';
                    $address['postal_code'] = '';
                    $address['state'] = '';

                    if (isset($customerInfos['address']) && $customerInfos['address'] != '') {
                        $address['line1'] = $customerInfos['address'];
                    } else {
                        $address['line1'] = ' ';
                    }
                    if (isset($customerInfos['city'])) {
                        $address['city'] = $customerInfos['city'];
                    }
                    if (isset($customerInfos['country'])) {
                        $address['country'] = $customerInfos['country'];
                    }
                    if (isset($customerInfos['zip'])) {
                        $address['postal_code'] = $customerInfos['zip'];
                    }
                    if (isset($customerInfos['state'])) {
                        $address['state'] = $customerInfos['state'];
                    }

                    $customerName = '';
                    if (isset($customerInfos['lastName']) && $customerInfos['lastName'] != '') {
                        $customerName = $customerInfos['firstName'] . ' ' . $customerInfos['lastName'];
                    }

                    $existingCustomer = false;
                    if ($customerInfos['email'] != '') {
                        $last_customer = NULL;
                        while (true) {
                            $customers = \Stripe\Customer::all(array("limit" => 100, "starting_after" => $last_customer, "email" => $customerInfos['email']));
                            foreach ($customers->autoPagingIterator() as $exCustomer) {
                                if ($customerInfos['email'] == $exCustomer->email) {
                                    $existingCustomer = $exCustomer;
                                    break 2;
                                }
                            }
                            if (!$customers->has_more) {
                                break;
                            }
                            $last_customer = end($customers->data);
                        }
                    }
                    if ($existingCustomer && $existingCustomer != null) {
                        $customer = $existingCustomer;
                    } else {

                        $customer = \Stripe\Customer::create([
                                    "description" => $customerInfos['email'],
                                    "email" => $customerInfos['email'],
                                    "name" => $customerName,
                                    "phone" => $customerInfos['phone'],
                                    "address" => $address
                        ]);
                    }

                    $intent = \Stripe\PaymentIntent::create([
                                'amount' => $total,
                                'description' => $form->title . ' - ' . $customerInfos['email'],
                                'customer' => $customer->id,
                                'payment_method_types' => ['card'],
                                'currency' => strtolower($form->stripe_currency)
                    ]);
                    echo '{"token":"' . $intent->client_secret . '","customerID":"' . $customer->id . '"}';
                }
            }
        }
        die();
    }

    private function getWebName($text) {
        $text = trim(ucwords($text));
        $text = preg_replace("/[^a-zA-Z0-9]+/", "", $text);
        return $text;
    }

    private function validStripePayment($form, $orderRef, $totalSingle, $totalSub, $stripeSrc, $customerID) {
        global $wpdb;
        $rep = false;
        $settings = $this->getSettings();

        require_once('stripe-php-6.38.0/init.php');
        if ($form->stripe_secretKey != '') {
            \Stripe\Stripe::setApiKey($form->stripe_secretKey);


            \Stripe\Customer::update(
                    $customerID, [
                'source' => $stripeSrc,
                'metadata' => ['order_id' => $orderRef],
                    ]
            );


            if ($totalSub > 0) {
                $interval = $form->stripe_subsFrequencyType;
                $intervalFreq = $form->stripe_subsFrequency;
                $price = $totalSub;


                if ($form->stripe_currency == "JPY") {
                    $price = number_format((int) $price, 0, '', '');
                } else {
                    $price *= 100;
                }

                $planID = $this->getWebName($form->title) . '-' . date('Y-m-d-H:i:s u');

                try {
                    $trialDays = 0;

                    if ($totalSingle > 0) {
                        $trialDays = 30 * $intervalFreq;
                        if ($interval == 'day') {
                            $trialDays = 1 * $intervalFreq;
                        }
                        if ($interval == 'week') {
                            $trialDays = 7 * $intervalFreq;
                        }
                        if ($interval == 'year') {
                            $trialDays = 365 * $intervalFreq;
                        }
                    }

                    $plan = \Stripe\Plan::create([
                                "amount" => $price,
                                "interval" => $form->stripe_subsFrequencyType,
                                "interval_count" => $form->stripe_subsFrequency,
                                "product" => [
                                    "name" => $form->title
                                ],
                                "currency" => strtolower($form->stripe_currency),
                                "id" => $planID,
                                "trial_period_days" => $trialDays
                    ]);
                } catch (Throwable $t) {
                    echo 'stripeError:' . $t->getMessage();
                }
                try {

                    $sub = \Stripe\Subscription::create([
                                "customer" => $customerID,
                                "items" => [
                                    [
                                        "plan" => $plan->id,
                                    ],
                                ]
                    ]);
                    echo '1';
                } catch (Throwable $t) {
                    echo 'stripeError:' . $t->getMessage();
                }
            }
        }
    }

    public function processStripeSubscription() {
        global $wpdb;
        $rep = false;
        $settings = $this->getSettings();


        $formID = sanitize_text_field($_POST['formID']);
        $singleTotal = sanitize_text_field($_POST['singleTotal']);
        $totalSub = sanitize_text_field($_POST['subTotal']);
        $stripeSrc = sanitize_text_field($_POST['stripeSrc']);
        $customerID = sanitize_text_field($_POST['customerID']);

        $table_name = $wpdb->prefix . "wpefc_forms";
        $formReq = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id='%s' LIMIT 1", $formID));
        if (count($formReq) > 0) {
            $form = $formReq[0];

            require_once('stripe-php-6.38.0/init.php');
            if ($form->stripe_secretKey != '') {
                \Stripe\Stripe::setApiKey($form->stripe_secretKey);


                \Stripe\Customer::update(
                        $customerID, [
                    'source' => $stripeSrc,
                        //  'metadata' => ['order_id' => $orderRef],
                        ]
                );

                if ($totalSub > 0) {
                    $interval = $form->stripe_subsFrequencyType;
                    $intervalFreq = $form->stripe_subsFrequency;
                    $price = $totalSub;

                    $price *= 100;

                    $planID = $this->getWebName($form->title) . '-' . date('Y-m-d-H-i-s-u');

                    try {
                        $trialDays = 0;

                        if ($singleTotal > 0) {
                            $trialDays = 30 * $intervalFreq;
                            if ($interval == 'day') {
                                $trialDays = 1 * $intervalFreq;
                            }
                            if ($interval == 'week') {
                                $trialDays = 7 * $intervalFreq;
                            }
                            if ($interval == 'year') {
                                $trialDays = 365 * $intervalFreq;
                            }
                        }

                        $plan = \Stripe\Plan::create([
                                    "amount" => $price,
                                    "interval" => $form->stripe_subsFrequencyType,
                                    "interval_count" => $form->stripe_subsFrequency,
                                    "product" => [
                                        "name" => $form->title
                                    ],
                                    "currency" => strtolower($form->stripe_currency),
                                    "id" => $planID,
                                    "trial_period_days" => $trialDays
                        ]);
                    } catch (Throwable $t) {
                        echo 'stripeError:' . $t->getMessage();
                    }
                    try {

                        $sub = \Stripe\Subscription::create([
                                    "customer" => $customerID,
                                    "trial_period_days" => $trialDays,
                                    "items" => [
                                        [
                                            "plan" => $plan->id,
                                        ]
                                    ]
                        ]);
                        if ($sub->status == 'incomplete') {
                            $invoice = \Stripe\Invoice::retrieve($sub->latest_invoice);
                            $intent = \Stripe\PaymentIntent::retrieve($invoice->payment_intent);
                            echo $intent->client_secret;
                        } else {
                            echo '1';
                        }
                    } catch (Throwable $t) {
                        echo 'stripeError:' . $t->getMessage();
                    }
                }
            }
        }
        die();
    }

    public function checkEmailCustomer() {
        global $wpdb;
        $formID = sanitize_text_field($_POST['formID']);
        $email = sanitize_text_field($_POST['email']);

        $lfb_session = $this->lfb_getSession();
        $settings = $this->getSettings();
        $table_name = $wpdb->prefix . "wpefc_customers";
        $customersData = $wpdb->get_results("SELECT email FROM $table_name");
        foreach ($customersData as $customerData) {
            if ($this->stringDecode($customerData->email, $settings->encryptDB) == $email) {

                $this->lfb_updateSession('lfb_proposedEmail', $email);
                echo 1;
                break;
            }
        }
        die();
    }

    public function verificationPass() {
        global $wpdb;
        $formID = sanitize_text_field($_POST['formID']);
        $pass = sanitize_text_field($_POST['pass']);
        $lfb_session = $this->lfb_getSession();
        if (isset($lfb_session['lfb_proposedEmail'])) {
            $email = $lfb_session['lfb_proposedEmail'];
            $settings = $this->getSettings();

            $table_name = $wpdb->prefix . "wpefc_customers";
            $customersData = $wpdb->get_results("SELECT email,password FROM $table_name");
            foreach ($customersData as $customerData) {
                if ($this->stringDecode($customerData->email, $settings->encryptDB) == $email && $this->stringDecode($customerData->password, true) == $pass) {
                    echo 1;
                    $this->lfb_updateSession('lfb_verifiedEmail', $email);
                    break;
                }
            }
        }
        die();
    }

    public function verificationCode() {
        $formID = sanitize_text_field($_POST['formID']);
        $code = sanitize_text_field($_POST['code']);
        $lfb_session = $this->lfb_getSession();
        if (isset($lfb_session['lfb_activationCode']) && $lfb_session['lfb_activationCode'] == $code) {
            echo 1;
        }
        die();
    }

    public function loginCustomer() {
        global $wpdb;
        $settings = $this->getSettings();
        $email = sanitize_text_field($_POST['email']);
        $pass = sanitize_text_field($_POST['pass']);

        $table_name = $wpdb->prefix . "wpefc_customers";
        $customersData = $wpdb->get_results("SELECT email,password,id FROM $table_name");
        foreach ($customersData as $customerData) {
            if ($this->stringDecode($customerData->email, $settings->encryptDB) == $email) {

                if ($this->stringDecode($customerData->password, true) == $pass) {

                    $lfb_session = $this->lfb_getSession();
                    $this->lfb_updateSession('lfb_loginMan', $customerData->id);
                    echo 1;
                }
            }
        }
        die();
    }

    public function loadCustomerOrders() {
        global $wpdb;
        $settings = $this->getSettings();

        $lfb_session = $this->lfb_getSession();
        if (isset($lfb_session['lfb_loginMan']) && intval($lfb_session['lfb_loginMan']) > 0) {
            $customerID = intval($lfb_session['lfb_loginMan']);
            $table_name = $wpdb->prefix . "wpefc_logs";
            $ordersData = array();
            $orders = $wpdb->get_results($wpdb->prepare("SELECT id,status,contentUser,checked,ref,dateLog,totalPrice,totalSubscription,paid,formID,currency,currencyPosition,thousandsSeparator,decimalsSeparator,millionSeparator,billionsSeparator FROM $table_name WHERE checked=1 AND customerID=%s ORDER BY id DESC", $customerID));
            foreach ($orders as $order) {
                if ($order->contentUser != '') {
                    $order->contentUser = 1;
                } else {
                    $order->contentUser = 0;
                }
                $statusText = '';
                if ($order->status == 'pending') {
                    $statusText = $settings->txt_order_pending;
                } else if ($order->status == 'canceled') {
                    $statusText = $settings->txt_order_canceled;
                } else if ($order->status == 'beingProcessed') {
                    $statusText = $settings->txt_order_beingProcessed;
                } else if ($order->status == 'shipped') {
                    $statusText = $settings->txt_order_shipped;
                } else if ($order->status == 'completed') {
                    $statusText = $settings->txt_order_completed;
                }
                $order->statusText = $statusText;
                $ordersData[] = $order;
            }
            echo json_encode($orders);
        }
        die();
    }

    public function viewCustomerOrder() {
        global $wpdb;
        $lfb_session = $this->lfb_getSession();
        $settings = $this->getSettings();
        if (isset($lfb_session['lfb_loginMan']) && intval($lfb_session['lfb_loginMan']) > 0) {
            $customerID = intval($lfb_session['lfb_loginMan']);
            $orderID = sanitize_text_field($_POST['orderID']);
            $table_name = $wpdb->prefix . "wpefc_logs";

            $orders = $wpdb->get_results($wpdb->prepare("SELECT id,checked,contentUser,customerID FROM $table_name WHERE customerID=%s AND id=%s LIMIT 1", $customerID, $orderID));
            if (count($orders) > 0) {

                $order = $orders[0];
                if (strpos($order->contentUser, 'style') === false && $settings->encryptDB) {
                    $order->contentUser = $this->stringDecode($order->contentUser, $settings->encryptDB);
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
                    $toReplaceBy[] = '<span class="lfb_value">' . $this->stringDecode($value, $settings->encryptDB) . '</span>';
                }
                foreach ($toReplaceBy as $key => $value) {
                    $order->contentUser = str_replace($toReplaceDefault[$key], $toReplaceBy[$key], $order->contentUser);
                }

                $txt_orderType = '';
                $order->contentUser = str_replace("[order_type]", $txt_orderType, $order->contentUser);


                echo $order->contentUser;
            }
        }
        die();
    }

    public function saveCustomerInfos() {
        global $wpdb;
        $lfb_session = $this->lfb_getSession();
        $settings = $this->getSettings();
        if (isset($lfb_session['lfb_loginMan']) && intval($lfb_session['lfb_loginMan']) > 0) {
            $customerID = intval($lfb_session['lfb_loginMan']);
            $sqlData = array(
                'email' => $this->stringEncode(sanitize_text_field($_POST['email']), $settings->encryptDB),
                'firstName' => $this->stringEncode(sanitize_text_field($_POST['firstName']), $settings->encryptDB),
                'lastName' => $this->stringEncode(sanitize_text_field($_POST['lastName']), $settings->encryptDB),
                'phone' => $this->stringEncode(sanitize_text_field($_POST['phone']), $settings->encryptDB),
                'phoneJob' => $this->stringEncode(sanitize_text_field($_POST['phoneJob']), $settings->encryptDB),
                'job' => $this->stringEncode(sanitize_text_field($_POST['job']), $settings->encryptDB),
                'company' => $this->stringEncode(sanitize_text_field($_POST['company']), $settings->encryptDB),
                'url' => $this->stringEncode(sanitize_text_field($_POST['url']), $settings->encryptDB),
                'address' => $this->stringEncode(sanitize_text_field($_POST['address']), $settings->encryptDB),
                'city' => $this->stringEncode(sanitize_text_field($_POST['city']), $settings->encryptDB),
                'state' => $this->stringEncode(sanitize_text_field($_POST['state']), $settings->encryptDB),
                'zip' => $this->stringEncode(sanitize_text_field($_POST['zip']), $settings->encryptDB)
            );

            $table_name = $wpdb->prefix . "wpefc_customers";
            $wpdb->update($table_name, $sqlData, array('id' => $customerID));
        }
        die();
    }

    public function downloadCustomerOrder() {
        global $wpdb;
        $lfb_session = $this->lfb_getSession();
        if (isset($lfb_session['lfb_loginMan']) && intval($lfb_session['lfb_loginMan']) > 0) {
            $settings = $this->getSettings();
            $customerID = intval($lfb_session['lfb_loginMan']);
            $orderID = sanitize_text_field($_POST['orderID']);
            $table_name = $wpdb->prefix . "wpefc_logs";

            $orders = $wpdb->get_results($wpdb->prepare("SELECT id,contentUser,ref FROM $table_name WHERE checked=1 AND customerID=%s AND id=%s LIMIT 1", $customerID, $orderID));
            if (count($orders) > 0) {
                $order = $orders[0];

                if (strpos($order->contentUser, 'style') === false && $settings->encryptDB) {
                    $order->contentUser = $this->stringDecode($order->contentUser, $settings->encryptDB);
                }


                if ($order->contentUser != '') {
                    $file = $this->lfb_generatePdfCustomer($order, false, true);
                    echo 1;
                }
            }
        }
        die();
    }

    public function downloadMyOrder() {
        $lfb_session = $this->lfb_getSession();
        if (isset($lfb_session['orderToDownload']) && isset($lfb_session['orderTitle'])) {
            if (file_exists($this->dir . '/uploads/' . $lfb_session['orderToDownload'] . '.pdf')) {

                $fileName = $lfb_session['orderToDownload'] . '.pdf';
                $target_path = plugin_dir_path(__FILE__) . '../uploads/' . $fileName;
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $lfb_session['orderTitle'] . '.pdf"');
                header("Content-Transfer-Encoding: Binary");
                header("Content-length: " . filesize($target_path));
                header("Pragma: no-cache");
                header("Expires: 0");
                ob_clean();
                flush();
                readfile($target_path);
                unlink($target_path);
            }
        }
        die();
    }

    /**
     * Main LFB_Core Instance
     *
     *
     * @since 1.0.0
     * @static
     * @see BSS_Core()
     * @return Main LFB_Core instance
     */
    public static function instance($file = '', $version = '1.0.0') {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file, $version);
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
        
    }

// End __clone()

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup() {
//  _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
    }

// End __wakeup()

    /**
     * Return settings.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
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

// End getSettings()

    /**
     * Log the plugin version number.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    private function _log_version_number() {
        update_option($this->_token . '_version', $this->_version);
    }

}
