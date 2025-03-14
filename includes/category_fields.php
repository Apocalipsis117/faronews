<?php

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Core\Entity\Entity\EntityFormDisplay;

/**
 * Crea campos para el tipo de contenido 'category'.
 */
function _faronews_create_category_fields()
{
    // Campos para el tipo de contenido 'category'.
    $fields = [
        // 'field_category_name' => [
        //     'type' => 'string',
        //     'label' => 'Nombre de la Categoría',
        //     'description' => 'Nombre de la categoría.',
        // ],
        'field_category_description' => [
            'type' => 'text',
            'label' => 'Descripción de la Categoría',
            'description' => 'Descripción de la categoría.',
        ],
        'field_category_slug_url' => [
            'type' => 'string',
            'label' => 'URL Amigable de la Categoría',
            'description' => 'URL amigable de la categoría.',
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

        $field_instance = FieldConfig::loadByName('node', 'category', $field_name);
        if (!$field_instance) {
            $field_instance = FieldConfig::create([
                'field_storage' => $field_storage,
                'bundle' => 'category',
                'label' => $field_config['label'],
                'description' => $field_config['description'],
            ]);
            $field_instance->save();
            \Drupal::logger('faronews')->notice('Field instance @field_name creado.', ['@field_name' => $field_name]);
        }
    }

    $form_display = EntityFormDisplay::load('node.category.default');
    if (!$form_display) {
        $form_display = EntityFormDisplay::create([
            'targetEntityType' => 'node',
            'bundle' => 'category',
            'mode' => 'default',
            'status' => TRUE,
        ]);
    }
    foreach (array_keys($fields) as $field_name) {
        $form_display->setComponent($field_name, ['type' => 'string_textfield']);
    }
    $form_display->save();
    \Drupal::logger('faronews')->notice('Form display configurado para el tipo de contenido category.');
}

/**
 * Elimina los campos del tipo de contenido 'category'.
 */
function _faronews_delete_category_fields()
{
    $fields = [
        // 'field_category_name',
        'field_category_description',
        'field_category_slug_url',
    ];

    foreach ($fields as $field_name) {
        $field_storage = FieldStorageConfig::loadByName('node', $field_name);
        if ($field_storage) {
            $field_storage->delete();
            \Drupal::logger('faronews')->notice('Field storage @field_name eliminado.', ['@field_name' => $field_name]);
        }
    }
}