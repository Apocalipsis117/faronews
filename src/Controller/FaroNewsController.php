<?php

namespace Drupal\faronews\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class FaroNewsController extends ControllerBase
{

    /**
     * Test Author.
     */
    public function getAuthors()
    {
        $nids = \Drupal::entityQuery('node')
            ->condition('type', 'news')
            ->accessCheck(TRUE)
            ->execute();

        $nodes = Node::loadMultiple($nids);
        dd($nodes);
        $authors = [];

        foreach ($nodes as $node) {
            $authors[] = [
                'firstname' => $node->get('field_author_firstname')->value,
                'lastname' => $node->get('field_author_lastname')->value,
                'email' => $node->get('field_author_email')->value,
                'identity' => $node->get('field_author_identity')->value,
                'phone' => $node->get('field_author_phone')->value,
            ];
        }
        dd($authors);
        return $authors;
    }

    public function getAuthor($id)
    {
        $nids = \Drupal::entityQuery('node')
            ->condition('type', 'news')
            ->condition('field_author_id', $id)
            ->accessCheck(TRUE)
            ->execute();

        $nodes = Node::loadMultiple($nids);
        $author = NULL;

        if (!empty($nodes)) {
            $node = reset($nodes);
            $author = [
                'firstname' => $node->get('field_firstname')->value,
                'lastname' => $node->get('field_lastname')->value,
                'email' => $node->get('field_email')->value,
                'identity' => $node->get('field_identity')->value,
                'phone' => $node->get('field_phone')->value,
            ];
        }

        return $author;
    }
}
