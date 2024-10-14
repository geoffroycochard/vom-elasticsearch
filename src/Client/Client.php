<?php
declare(strict_types=1);

namespace OrleansMetropole\ElasticSearch\Client;

use Elastic\EnterpriseSearch\AppSearch\Schema\PaginationResponseObject;
use OrleansMetropole\ElasticSearch\Model\Document;
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

		$documentsToIndex = [];
		$documentsToDelete = [];
			
		foreach ($documents as $document) {
			if ($document->toDelete()) {
				$documentsToDelete[] = $document->getId();
			} else {
				$errors = $validator->validate($document);
				if (count($errors) > 0) {
					throw new \Exception($errors->__toString());
				}
				$documentsToIndex[] = $document;
			}
		}

		if (count($documentsToDelete) > 0) {
			$return[] = $this->appSearch()->deleteDocuments(
				new Request\DeleteDocuments($this->engineName, $documentsToDelete)
			);
		}

		if (count($documentsToIndex) > 0) {
			$return[] = $this->appSearch()->indexDocuments(
				new Request\IndexDocuments($this->engineName, $documentsToIndex)
			);
		}

		$mergedResponse = null;
		
		foreach ($return as $response) {
			if ($response instanceof Response) {
				if ($mergedResponse === null) {
					$mergedResponse = $response;
				} else {
					$mergedResponseData = $mergedResponse->asArray();
					$currentResponseData = $response->asArray();
					
					foreach ($currentResponseData as $key => $value) {
						if (isset($mergedResponseData[$key]) && is_array($mergedResponseData[$key])) {
							$mergedResponseData[$key] = array_merge($mergedResponseData[$key], $value);
						} else {
							$mergedResponseData[$key] = $value;
						}
					}
					
					$mergedResponse = new Response(
						$response->getResponse()->withBody(
							\GuzzleHttp\Psr7\Utils::streamFor(json_encode($mergedResponseData))
						)
					);
				}
			}
		}
		
		return $mergedResponse ?? new Response(
			new \GuzzleHttp\Psr7\Response(200, [], '{}')
		);
	}

    public function deleteDocument(Document $document): Response
    {
        return $this->appSearch()->deleteDocuments(
            new Request\DeleteDocuments($this->engineName, [$document->getId()])
        );
	}

	public function search($keyword, $current = 1, $size = 10, $fields = ['title', 'summary'], $site = false)
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

		// Paginate
		$pagination = new PaginationResponseObject();
		$pagination->size = $size;
		$pagination->current = $current;
		$search->page = $pagination;

		// filter
		if ($site) {
			$filter = new Schema\SimpleObject();
			$filter->origin = $site;
			$search->filters = $filter;
		}

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

