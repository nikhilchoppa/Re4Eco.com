<?php

namespace FluentFormPro\Components\Post\Components;

class DynamicTaxonomies
{
    protected $taxonomyObjects = null;

    public function __construct($taxonomyObjects)
    {
        $this->taxonomyObjects = $taxonomyObjects;
    }

    public function registerEditorTaxonomyFields($components)
    {
        $index = 0;

        $dynamicTags = [];

        foreach ($this->taxonomyObjects as $object) {
            $isHi = $object->hierarchical;
            $dynamicTags[] = $object->name;
            $taxonomy = [
                'index' => $index,
                'element' => 'taxonomy',
                'attributes' => [
                    'name' => $object->name,
                    'value' => '',
                    'id' => '',
                    'class' => '',
                    'type' => 'text',
                ],
                'taxonomy_settings' => [
                    'name' => $object->name,
                    'hierarchical' => $isHi
                ],
                'settings' => [
                    'label' => __($object->label, 'fluentform'),
                    'admin_field_label' => '',
                    'help_message' => '',
                    'container_class' => '',
                    'label_placement' => '',
                    'placeholder' => $isHi ? '- Select -' : 'Type...',
                    'advanced_options' => [],
                    'validation_rules' => [
                        'required' => [
                            'value'   => false,
                            'message' => __('This field is required', 'fluentform'),
                        ],
                    ],
                    'conditional_logics' => [],
                ],
                'editor_options' => [
                    'title' => __($object->label, 'fluentform'),
                    'icon_class' => $isHi ? 'dashicons dashicons-category' : 'dashicons dashicons-tag',
                    'template' => 'taxonomy'
                ]
            ];

            if ($isHi) {
                $taxonomy['settings']['field_type'] = 'select_single';

                $terms = get_terms([
                    'order' => 'ASC',
                    'hide_empty' => false,
                    'taxonomy' => $object->name
                ]);

                foreach ($terms as $term) {
                    $taxonomy['settings']['options'][$term->term_id] = $term->name;
                }
            }

            $components['taxonomy'][] = $taxonomy;

            $index++;
        }

        return $components;
    }
}