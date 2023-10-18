<?php
declare(strict_types=1);

namespace OrleansMetropole\ElasticSearch\Client;

use Symfony\Component\Validator\Validation;
use Elastic\EnterpriseSearch\AppSearch\Request;
use Elastic\EnterpriseSearch\Response\Response;
use Elastic\EnterpriseSearch\AppSearch\Schema;

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

	public function search($keyword, $fields = ['title', 'summary'])
	{
		$search = new Schema\SearchRequestParams($keyword);

		// Result fields
		$result_fields = new Schema\SimpleObject();
		foreach ($fields as $field) {
			$result_fields->{$field} = [
				'raw' => new Schema\SimpleObject()
			];
		}

		$search->result_fields = $result_fields;

		return $this->appSearch()->search(
			new Request\Search($this->engineName, $search)
		);
	}

	public function listDocuments(): Response
	{
        return $this->appSearch()->listDocuments(
            new Request\ListDocuments($this->engineName)
        );
	}

	public function deleteDocuments(array $ids): Response
	{
        return $this->appSearch()->deleteDocuments(
			new Request\DeleteDocuments($this->engineName, $ids)
		);
	}
}

