<?php

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Core\Entity\Entity\EntityFormDisplay;

/**
 * Crea campos para el tipo de contenido 'news'.
 */
function _faronews_create_news_fields()
{
    // Campos para el tipo de contenido 'news'.
    $fields = [
        // 'field_new_title' => [
        //     'type' => 'string',
        //     'label' => 'Título',
        //     'description' => 'Título de la noticia.',
        // ],
        'field_new_subtitle' => [
            'type' => 'string',
            'label' => 'Subtítulo',
            'description' => 'Subtítulo de la noticia.',
        ],
        'field_new_path_name' => [
            'type' => 'string',
            'label' => 'Nombre del Camino',
            'description' => 'Nombre del camino de la noticia.',
        ],
        'field_new_is_slider' => [
            'type' => 'boolean',
            'label' => 'En el Slider',
            'description' => '¿La noticia está en el slider?',
        ],
        'field_new_is_featured' => [
            'type' => 'boolean',
            'label' => 'Destacada',
            'description' => '¿La noticia está destacada?',
        ],
        'field_new_content' => [
            'type' => 'text_with_summary',
            'label' => 'Contenido',
            'description' => 'Contenido de la noticia.',
        ],
        'field_new_url_video' => [
            'type' => 'string',
            'label' => 'Url del Video',
            'description' => 'Url de video para la noticia.',
        ],
        'field_new_image_vertical' => [
            'type' => 'image',
            'label' => 'Imagen Vertical',
            'description' => 'Imagen vertical de la noticia.',
        ],
        'field_new_image_horizontal' => [
            'type' => 'image',
            'label' => 'Imagen horizontal',
            'description' => 'Imagen horizontal de la noticia.',
        ],
        'field_new_resume' => [
            'type' => 'text',
            'label' => 'Resumen',
            'description' => 'Resumen de la noticia.',
        ],
        'field_new_publication_date' => [
            'type' => 'datetime',
            'label' => 'Fecha de Publicación',
            'description' => 'Fecha de publicación de la noticia.',
        ],
        'field_author_id' => [
            'type' => 'entity_reference',
            'label' => 'Autor',
            'description' => 'Autor de la noticia.',
            'settings' => [
                'target_type' => 'taxonomy_term',
                'handler' => 'default:taxonomy_term',
                'handler_settings' => [
                    'target_bundles' => [
                        'author' => 'author',
                    ],
                ],
            ],
        ],
        'field_category_id' => [
            'type' => 'entity_reference',
            'label' => 'Categoría',
            'description' => 'Categoría de la noticia.',
            'settings' => [
                'target_type' => 'taxonomy_term',
                'handler' => 'default:taxonomy_term',
                'handler_settings' => [
                    'target_bundles' => [
                        'categories' => 'categories',
                    ],
                ],
            ],
        ],
        'field_tag_id' => [
            'type' => 'entity_reference',
            'label' => 'Etiquetas',
            'description' => 'Etiquetas de la noticia.',
            'settings' => [
                'target_type' => 'taxonomy_term',
                'handler' => 'default:taxonomy_term',
                'handler_settings' => [
                    'target_bundles' => [
                        'tags' => 'tags',
                    ],
                ],
                'cardinality' => FieldStorageConfig::CARDINALITY_UNLIMITED,
            ],
        ],
        'field_user' => [
            'type' => 'entity_reference',
            'label' => 'Usuario',
            'description' => 'Usuario que publicó la noticia.',
            'settings' => [
                'target_type' => 'user',
                'handler' => 'default:user',
                'handler_settings' => [
                    'include_anonymous' => FALSE,
                ],
            ],
        ],
    ];

    foreach ($fields as $field_name => $field_config) {
        $field_storage = FieldStorageConfig::loadByName('node', $field_name);
        if (!$field_storage) {
            $field_storage = FieldStorageConfig::create([
                'field_name' => $field_name,
                'entity_type' => 'node',
                'type' => $field_config['type'],
                'settings' => $field_config['settings'] ?? [],
                'cardinality' => $field_config['cardinality'] ?? 1,
            ]);
            $field_storage->save();
            \Drupal::logger('faronews')->notice('Field storage @field_name creado.', ['@field_name' => $field_name]);
        }

        $field_instance = FieldConfig::loadByName('node', 'news', $field_name);
        if (!$field_instance) {
            $field_instance = FieldConfig::create([
                'field_storage' => $field_storage,
                'bundle' => 'news',
                'label' => $field_config['label'],
                'description' => $field_config['description'],
            ]);
            $field_instance->save();
            \Drupal::logger('faronews')->notice('Field instance @field_name creado.', ['@field_name' => $field_name]);
        }
    }

    $form_display = EntityFormDisplay::load('node.news.default');
    if (!$form_display) {
        $form_display = EntityFormDisplay::create([
            'targetEntityType' => 'node',
            'bundle' => 'news',
            'mode' => 'default',
            'status' => TRUE,
        ]);
    }
    foreach (array_keys($fields) as $field_name) {
        $form_display->setComponent($field_name, ['type' => 'string_textfield']);
    }
    $form_display->save();
    \Drupal::logger('faronews')->notice('Form display configurado para el tipo de contenido news.');
}

/**
 * Elimina los campos del tipo de contenido 'news'.
 */
function _faronews_delete_news_fields()
{
    $fields = [
        // 'field_new_title',
        'field_new_path_name',
        'field_new_is_slider',
        'field_new_is_featured',
        'field_new_content',
        'field_new_url_video',
        'field_new_image_vertical',
        'field_new_image_horizontal',
        'field_new_resume',
        'field_new_publication_date',
        'field_author_id',
        'field_category_id',
        'field_tag_id',
        'field_user',
    ];

    foreach ($fields as $field_name) {
        $field_storage = FieldStorageConfig::loadByName('node', $field_name);
        if ($field_storage) {
            $field_storage->delete();
            \Drupal::logger('faronews')->notice('Field storage @field_name eliminado.', ['@field_name' => $field_name]);
        }
    }
}