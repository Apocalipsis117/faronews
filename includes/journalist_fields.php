<?php

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Core\Entity\Entity\EntityFormDisplay;

/**
 * Crea campos para el tipo de contenido 'journalist'.
 */
function _faronews_create_journalist_fields()
{
    // Campos para el tipo de contenido 'journalist'.
    $fields = [
        'field_journalist_firstname' => [
            'type' => 'string',
            'label' => 'Nombre',
            'description' => 'Nombre del autor.',
        ],
        'field_journalist_lastname' => [
            'type' => 'string',
            'label' => 'Apellido',
            'description' => 'Apellido del autor.',
        ],
        'field_journalist_email' => [
            'type' => 'email',
            'label' => 'Correo Electrónico',
            'description' => 'Correo electrónico del autor.',
        ],
        'field_journalist_identity' => [
            'type' => 'string',
            'label' => 'Identidad',
            'description' => 'Identidad del autor.',
        ],
        'field_journalist_phone' => [
            'type' => 'text',
            'label' => 'Teléfono',
            'description' => 'Número de teléfono del autor.',
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

        $field_instance = FieldConfig::loadByName('node', 'journalist', $field_name);
        if (!$field_instance) {
            $field_instance = FieldConfig::create([
                'field_storage' => $field_storage,
                'bundle' => 'journalist',
                'label' => $field_config['label'],
                'description' => $field_config['description'],
            ]);
            $field_instance->save();
            \Drupal::logger('faronews')->notice('Field instance @field_name creado.', ['@field_name' => $field_name]);
        }
    }

    $form_display = EntityFormDisplay::load('node.journalist.default');
    if (!$form_display) {
        $form_display = EntityFormDisplay::create([
            'targetEntityType' => 'node',
            'bundle' => 'journalist',
            'mode' => 'default',
            'status' => TRUE,
        ]);
    }
    foreach (array_keys($fields) as $field_name) {
        $form_display->setComponent($field_name, ['type' => 'string_textfield']);
    }
    $form_display->save();
    \Drupal::logger('faronews')->notice('Form display configurado para el tipo de contenido journalist.');
}

/**
 * Elimina los campos del tipo de contenido 'journalist'.
 */
function _faronews_delete_journalist_fields()
{
    $fields = [
        'field_journalist_firstname',
        'field_journalist_lastname',
        'field_journalist_email',
        'field_journalist_identity',
        'field_journalist_phone',
    ];

    foreach ($fields as $field_name) {
        $field_storage = FieldStorageConfig::loadByName('node', $field_name);
        if ($field_storage) {
            $field_storage->delete();
            \Drupal::logger('faronews')->notice('Field storage @field_name eliminado.', ['@field_name' => $field_name]);
        }
    }
}