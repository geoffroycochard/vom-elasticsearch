<?php
declare(strict_types=1);

namespace OrleansMetropole\ElasticSearch\Model;

final class Typo3Document extends Document
{
    private string $prefixId = 'typo3_';

    /**
     * Summary of __construct
     * @param string $id
     */
	public function __construct(string $id)
	{
        $id = sprintf('%s%s', $this->prefixId, $id);
        parent::__construct($id);
	}
}

