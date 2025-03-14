<?php

use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Crea vocabularios necesarios.
 */
function _faronews_create_vocabularies()
{
    _faronews_create_vocabulary('author', 'Autor', 'Autores de las noticias.');
    _faronews_create_vocabulary('categories', 'Categorías', 'Categorías de las noticias.');
    _faronews_create_vocabulary('tags', 'Etiquetas', 'Etiquetas para las noticias.');
}

/**
 * Elimina vocabularios necesarios.
 */
function _faronews_delete_vocabularies()
{
    _faronews_delete_vocabulary('author');
    _faronews_delete_vocabulary('categories');
    _faronews_delete_vocabulary('tags');
}

/**
 * Crea un vocabulario si no existe.
 */
function _faronews_create_vocabulary($vid, $name, $description)
{
    $vocabulary = Vocabulary::load($vid);
    if (!$vocabulary) {
        $vocabulary = Vocabulary::create([
            'vid' => $vid,
            'name' => $name,
            'description' => $description,
        ]);
        $vocabulary->save();
        \Drupal::logger('faronews')->notice('Vocabulario @vid creado.', ['@vid' => $vid]);
    } else {
        \Drupal::logger('faronews')->notice('Vocabulario @vid ya existe.', ['@vid' => $vid]);
    }
}

/**
 * Elimina un vocabulario si existe.
 */
function _faronews_delete_vocabulary($vid)
{
    $vocabulary = Vocabulary::load($vid);
    if ($vocabulary) {
        $vocabulary->delete();
        \Drupal::logger('faronews')->notice('Vocabulario @vid eliminado.', ['@vid' => $vid]);
    }
}