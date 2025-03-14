<?php

use Drupal\node\Entity\NodeType;

/**
 * Crea tipos de contenido necesarios.
 */
function _faronews_create_content_types()
{
    _faronews_create_content_type('news', 'Noticias', 'Tipo de contenido para noticias.');
    _faronews_create_content_type('journalist', 'Periodista', 'Tipo de contenido para periodistas.');
    _faronews_create_content_type('category', 'Categoría', 'Tipo de contenido para categorías.');
    _faronews_create_content_type('tag', 'Etiqueta', 'Tipo de contenido para etiquetas.');
}

/**
 * Elimina tipos de contenido necesarios.
 */
function _faronews_delete_content_types()
{
    _faronews_delete_content_type('news');
    _faronews_delete_content_type('journalist');
    _faronews_delete_content_type('category');
    _faronews_delete_content_type('tag');
}

/**
 * Crea un tipo de contenido si no existe.
 */
function _faronews_create_content_type($type, $name, $description)
{
    $node_type = NodeType::load($type);
    if (!$node_type) {
        $node_type = NodeType::create([
            'type' => $type,
            'name' => $name,
            'description' => $description,
        ]);
        $node_type->save();
        \Drupal::logger('faronews')->notice('Tipo de contenido @type creado.', ['@type' => $type]);
    } else {
        \Drupal::logger('faronews')->notice('Tipo de contenido @type ya existe.', ['@type' => $type]);
    }
}

/**
 * Elimina un tipo de contenido si existe.
 */
function _faronews_delete_content_type($type)
{
    $node_type = NodeType::load($type);
    if ($node_type) {
        $node_type->delete();
        \Drupal::logger('faronews')->notice('Tipo de contenido @type eliminado.', ['@type' => $type]);
    }
}