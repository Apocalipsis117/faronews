<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;


/**
 * Provides a 'BlockFaroNewFeactured' Block.
 *
 * @Block(
 *   id = "block_faro_new_feactured",
 *   admin_label = @Translation("Faro - Noticias recientes (Slider)"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroNewFeactured extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {

        $news_slider = $this->getSlidertNews();
        $news_outstanding = $this->getOutstandingNews();

        $data = [
            "slider" => $news_slider,
            "news" => $news_outstanding
        ];
        return [
            '#theme' => 'block_faro_new_feactured',
            '#data' => $data
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }

    protected function getSlidertNews($limit = 4)
    {
        $query = \Drupal::entityQuery('node')
            ->condition('type', 'news')
            ->condition('field_new_is_slider', 1)
            ->accessCheck(TRUE)
            ->sort('created', 'DESC')
            ->range(0, $limit);
        $nids = $query->execute();

        $nodes = Node::loadMultiple($nids);

        $nes = [];
        foreach ($nodes as $node) {
            $image_field = $node->get('field_new_image_horizontal')->entity;
            $image_url = $image_field ? File::load($image_field->id())->createFileUrl() : '';

            // Obtener la categoría del nodo.
            $category = '';
            if (!$node->get('field_category_id')->isEmpty()) {
                $term = $node->get('field_category_id')->entity;
                $category = $term->getName();
            }

            $nes[] = [
                'title' => ['#markup' => $node->getTitle()],
                'url' => ['#markup' => $node->toUrl()->toString()],
                'subtitle' => ['#markup' => $node->get('field_new_subtitle')->value],
                'content' => ['#markup' => $node->get('field_new_content')->value],
                'date' => ['#markup' => $node->get('field_new_publication_date')->value],
                'img' => ['#markup' => $image_url],
                'category' => ['#markup' => $category], // Agregar la categoría
            ];
        }
        return $nes;
    }

    protected function getOutstandingNews($limit = 4)
    {
        $query = \Drupal::entityQuery('node')
            ->condition('type', 'news')
            ->condition('field_new_is_featured', 1)
            ->accessCheck(TRUE)
            ->sort('created', 'DESC')
            ->range(0, $limit);
        $nids = $query->execute();

        $nodes = Node::loadMultiple($nids);

        $nes = [];
        foreach ($nodes as $node) {
            $image_field = $node->get('field_new_image_horizontal')->entity;
            $image_url = $image_field ? File::load($image_field->id())->createFileUrl() : '';

            // Obtener la categoría del nodo.
            $category = '';
            if (!$node->get('field_category_id')->isEmpty()) {
                $term = $node->get('field_category_id')->entity;
                $category = $term->getName();
            }

            $nes[] = [
                'title' => ['#markup' => $node->getTitle()],
                'url' => ['#markup' => $node->toUrl()->toString()],
                'subtitle' => ['#markup' => $node->get('field_new_subtitle')->value],
                'content' => ['#markup' => $node->get('field_new_content')->value],
                'date' => ['#markup' => $node->get('field_new_publication_date')->value],
                'img' => ['#markup' => $image_url],
                'category' => ['#markup' => $category], // Agregar la categoría
            ];
        }
        return $nes;
    }
}