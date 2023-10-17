<?php
declare(strict_types=1);

namespace OrleansMetropole\ElasticSearch\Client;

use Symfony\Component\Validator\Validation;
use Elastic\EnterpriseSearch\AppSearch\Request;
use Elastic\EnterpriseSearch\Response\Response;

final class Client extends \Elastic\EnterpriseSearch\Client
{
    private string $engineName;

	/**
	 * @return string
	 */
	public function getEngineName(): string {
		return $this->engineName;
	}
	
	/**
	 * @param string $engineName 
	 * @return self
	 */
	public function setEngineName(string $engineName): self {
		$this->engineName = $engineName;
		return $this;
	}

    public function indexDocuments(array $documents): Response
    {
		// todo #9 Validate document with symfony/validate @geoffroycochard
		$validator = Validation::createValidatorBuilder()
			->addMethodMapping('loadValidatorMetadata')
			->getValidator()
		;
			
		foreach ($documents as $document) {
			$errors = $validator->validate($document);
			if (count($errors) > 0) {
				throw new \Exception($errors->__toString());
				
			}
		}

        $appSearch = $this->appSearch();
        return $appSearch->indexDocuments(
            new Request\IndexDocuments($this->engineName, $documents)
        );
	}
}

