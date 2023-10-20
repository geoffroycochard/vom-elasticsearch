<?php

declare(strict_types=1);

namespace OrleansMetropole\ElasticSearch\Model;

final class Typo3Document extends Document
{
    private string $prefixId = 'typo3';

    /**
     * Summary of __construct
     * @param string $id
     */
    public function __construct(string $id, string $type)
    {
        $id = sprintf('%s-%s-%s', $this->prefixId, $type, $id);
        parent::__construct($id);
    }
}
