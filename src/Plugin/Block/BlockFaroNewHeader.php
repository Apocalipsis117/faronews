<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroNewHeader' Block.
 *
 * @Block(
 *   id = "block_faro_new_header",
 *   admin_label = @Translation("Faro - Noticia titulo y encabezado"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroNewHeader extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $data = [
            "new" => null,
            'share' => ['facebook', 'twitter', 'whatsapp']
        ];
        return [
            '#theme' => 'block_faro_new_header',
            '#data' => $data,
            '#title' => $this->t('Noticia titulo y encabezado')
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}