<?php

namespace FluentFormPro\Integrations\ConvertKit;

use FluentForm\App\Services\Integrations\IntegrationManager;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class Bootstrap extends IntegrationManager
{
    public function __construct(Application $app)
    {
        parent::__construct(
            $app,
            'ConvertKit',
            'convertkit',
            '_fluentform_convertkit_settings',
            'convertkit_feed',
            25
        );

        $this->logo = $this->app->url('public/img/integrations/convertkit.png');

        $this->description = 'Connect ConvertKit with WP Fluent Forms and create subscription forms right into WordPress and grow your list.';


        $this->registerAdminHooks();

//        add_filter('fluentform_notifying_async_convertkit', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => $this->logo,
            'menu_title'       => __('ConvertKit Settings', 'fluentformpro'),
            'menu_description' => __('ConvertKit is email marketing software for creators. Use Fluent Form to collect customer information and automatically add it as ConvertKit subscriber list.', 'fluentformpro'),
            'valid_message'    => __('Your ConvertKit API Key is valid', 'fluentformpro'),
            'invalid_message'  => __('Your ConvertKit API Key is not valid', 'fluentformpro'),
            'save_button_text' => __('Save Settings', 'fluenform'),
            'fields'           => [
                'apiKey'    => [
                    'type'        => 'text',
                    'placeholder' => 'API Key',
                    'label_tips'  => __("Enter your ConvertKit API Key, if you do not have <br>Please login to your ConvertKit account and go to<br>Profile -> Account Settings -> Account Info", 'fluentformpro'),
                    'label'       => __('ConvertKit API Key', 'fluentformpro'),
                ],
                'apiSecret' => [
                    'type'        => 'password',
                    'placeholder' => 'API Secret',
                    'label_tips'  => __("Enter your ConvertKit API Secret, if you do not have <br>Please login to your ConvertKit account and go to<br>Profile -> Account Settings -> Account Info", 'fluentformpro'),
                    'label'       => __('ConvertKit API Secret', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => 'Your ConvertKit API integration is up and running',
                'button_text'         => 'Disconnect ConvertKit',
                'data'                => [
                    'apiKey' => ''
                ],
                'show_verify'         => true
            ]
        ];
    }

    public function getGlobalSettings($settings)
    {
        $globalSettings = get_option($this->optionKey);
        if (!$globalSettings) {
            $globalSettings = [];
        }
        $defaults = [
            'apiKey'    => '',
            'apiSecret' => '',
            'status'    => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['apiKey']) {
            $integrationSettings = [
                'apiKey'    => '',
                'apiSecret' => '',
                'status'    => false
            ];
            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');
            wp_send_json_success([
                'message' => __('Your settings has been updated', 'fluentformpro'),
                'status'  => false
            ], 200);
        }

        // Verify API key now
        try {
            $integrationSettings = [
                'apiKey'    => sanitize_text_field($settings['apiKey']),
                'apiSecret' => sanitize_text_field($settings['apiSecret']),
                'status'    => false
            ];
            update_option($this->optionKey, $integrationSettings, 'no');

            $api = new API($settings['apiKey'], $settings['apiSecret']);

            $result = $api->auth_test();
            if (!empty($result['error'])) {
                throw new \Exception($result['message']);
            }
        } catch (\Exception $exception) {
            wp_send_json_error([
                'message' => $exception->getMessage()
            ], 400);
        }

        // Integration key is verified now, Proceed now

        $integrationSettings = [
            'apiKey'    => sanitize_text_field($settings['apiKey']),
            'apiSecret' => sanitize_text_field($settings['apiSecret']),
            'status'    => true
        ];

        // Update the reCaptcha details with siteKey & secretKey.
        update_option($this->optionKey, $integrationSettings, 'no');

        wp_send_json_success([
            'message' => __('Your ConvertKit api key has been verfied and successfully set', 'fluentformpro'),
            'status'  => true
        ], 200);
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title'                 => $this->title . ' Integration',
            'logo'                  => $this->logo,
            'is_active'             => $this->isConfigured(),
            'configure_title'       => 'Configration required!',
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-convertkit-settings'),
            'configure_message'     => 'ConvertKit is not configured yet! Please configure your ConvertKit api first',
            'configure_button_text' => 'Set ConvertKit API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'         => '',
            'list_id'      => '',
            'email'        => '',
            'first_name'   => '',
            'fields'       => (object)[],
            'conditionals' => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'resubscribe'  => false,
            'enabled'      => true
        ];
    }

    public function getSettingsFields($settings, $formId)
    {
        return [
            'fields'              => [
                [
                    'key'         => 'name',
                    'label'       => 'Name',
                    'required'    => true,
                    'placeholder' => 'Your Feed Name',
                    'component'   => 'text'
                ],
                [
                    'key'         => 'list_id',
                    'label'       => 'ConvertKit List',
                    'placeholder' => 'Select ConvertKit Mailing List',
                    'tips'        => 'Select the ConvertKit Mailing List you would like to add your contacts to.',
                    'component'   => 'list_ajax_options',
                    'options'     => $this->getLists(),
                ],
                [
                    'key'                => 'fields',
                    'require_list'       => true,
                    'label'              => 'Map Fields',
                    'tips'               => 'Select which Fluent Form fields pair with their<br /> respective ConvertKit fields.',
                    'component'          => 'map_fields',
                    'field_label_remote' => 'ConvertKit Field',
                    'field_label_local'  => 'Form Field',
                    'primary_fileds'     => [
                        [
                            'key'           => 'email',
                            'label'         => 'Email Address',
                            'required'      => true,
                            'input_options' => 'emails'
                        ],
                        [
                            'key'   => 'first_name',
                            'label' => 'First Name'
                        ]
                    ]
                ],
                [
                    'require_list' => true,
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logics',
                    'tips'         => 'Allow ConvertKit integration conditionally based on your submission values',
                    'component'    => 'conditional_block'
                ],
                [
                    'require_list'    => true,
                    'key'             => 'enabled',
                    'label'           => 'Status',
                    'component'       => 'checkbox-single',
                    'checkobox_label' => 'Enable This feed'
                ]
            ],
            'button_require_list' => true,
            'integration_title'   => $this->title
        ];
    }

    protected function getLists()
    {
        $api = $this->getRemoteClient();
        $lists = $api->getLists();

        $formateddLists = [];
        foreach ($lists as $list) {
            $formateddLists[$list['id']] = $list['name'];
        }
        return $formateddLists;
    }

    public function getMergeFields($list, $listId, $formId)
    {
        $api = $this->getRemoteClient();
        if (!$api) {
            return [];
        }
        $fields = $api->getCustomFields($listId);


        $formattedFields = [];

        foreach ($fields as $field) {
            $formattedFields[$field['key']] = $field['label'];
        }

        return $formattedFields;
    }


    /*
     * Form Submission Hooks Here
     */
    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];

        if (!is_email($feedData['email'])) {
            $feedData['email'] = ArrayHelper::get($formData, $feedData['email']);
        }

        if(!is_email($feedData['email'])) {
            // No Valid email found
            return;
        }

        $subscriber = [
            'email'     => $feedData['email'],
            'first_name' => ArrayHelper::get($feedData, 'first_name')
        ];

        $customFiels = [];
        foreach (ArrayHelper::get($feedData, 'fields', []) as $key => $value) {
            if (!$value) {
                continue;
            }
            $customFiels[$key] = $value;
        }

        if($customFiels) {
            $subscriber['fields'] = $customFiels;
        }

        $subscriber = array_filter($subscriber);


        $api = $this->getRemoteClient();
        $response = $api->subscribe($feedData['list_id'], $subscriber);

        if(is_wp_error($response)) {
            // it's failed
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type' => 'submission_item',
                'source_id' => $entry->id,
                'component' => $this->integrationKey,
                'status' => 'failed',
                'title' => $feed['settings']['name'],
                'description' => $response->get_error_message()
            ]);
        } else {
            // It's success
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type' => 'submission_item',
                'source_id' => $entry->id,
                'component' => $this->integrationKey,
                'status' => 'success',
                'title' => $feed['settings']['name'],
                'description' => 'ConvertKit feed has been successfully initialed and pushed data'
            ]);
        }
    }



    public function getRemoteClient()
    {
        $settings = $this->getGlobalSettings([]);
        return new API($settings['apiKey'], $settings['apiSecret']);
    }

}
