<?php

declare(strict_types=1);

namespace OrleansMetropole\ElasticSearch\Model;

final class DrupalDocument extends Document
{
    private string $prefixId = 'drupal';

    /**
     * Summary of __construct
     * @param string $id
     */
    public function __construct(string $id, string $type)
    {
        $id = sprintf('%s_%s_%s', $this->prefixId, $type, $id);
        parent::__construct($id);
    }
}
