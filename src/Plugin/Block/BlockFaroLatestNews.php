<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;

/**
 * Provides a 'BlockFaroLatestNews' Block.
 *
 * @Block(
 *   id = "block_faro_latest_news",
 *   admin_label = @Translation("Faro - Ultimas noticias"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroLatestNews extends BlockBase implements ContainerFactoryPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $latesnNews = $this->getLatestNews();

        $data = [
            "news" => $latesnNews
        ];

        return [
            '#theme' => 'block_faro_latest_news',
            '#data' => $data
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static($configuration, $plugin_id, $plugin_definition);
    }

    protected function getLatestNews($limit = 9)
    {
        $query = \Drupal::entityQuery('node')
            ->condition('type', 'news')
            ->accessCheck(TRUE)
            ->sort('created', 'DESC')
            ->range(0, $limit);
        $nids = $query->execute();

        $nodes = Node::loadMultiple($nids);

        $news = [];
        foreach ($nodes as $node) {
            $image_field = $node->get('field_new_image_horizontal')->entity;
            $image_url = $image_field ? File::load($image_field->id())->createFileUrl() : '';

            $category = '';
            if (!$node->get('field_category_id')->isEmpty()) {
                $term = $node->get('field_category_id')->entity;
                $category = $term->getName();
            }

            $news[] = [
                'title' => ['#markup' => $node->getTitle()],
                'url' => ['#markup' => $node->toUrl()->toString()],
                'subtitle' => ['#markup' => $node->get('field_new_subtitle')->value],
                'content' => ['#markup' => $node->get('field_new_content')->value],
                'date' => ['#markup' => $node->get('field_new_publication_date')->value],
                'img' => ['#markup' => $image_url],
                'category' => ['#markup' => $category],
            ];
        }

        return $news;
    }
}
