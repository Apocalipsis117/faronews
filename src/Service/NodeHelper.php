<?php

namespace Drupal\faronews\Service;

use Drupal\path_alias\AliasManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;

class NodeHelper
{

    protected $aliasManager;
    protected $entityTypeManager;

    public function __construct(AliasManagerInterface $alias_manager, EntityTypeManagerInterface $entity_type_manager)
    {
        $this->aliasManager = $alias_manager;
        $this->entityTypeManager = $entity_type_manager;
    }

    /**
     * Obtiene un nodo por su alias de URL.
     *
     * @param string $alias
     *   El alias de la URL del nodo.
     *
     * @return \Drupal\node\Entity\Node|null
     *   El nodo correspondiente o NULL si no se encuentra.
     */
    public function getNodeByAlias($alias)
    {
        $path = $this->aliasManager->getPathByAlias($alias);
        if (strpos($path, '/node/') === 0) {
            $nid = str_replace('/node/', '', $path);
            return $this->entityTypeManager->getStorage('node')->load($nid);
        }
        return NULL;
    }
}
