Orleans Métrople / ElasticSearch
=================================

This library is used in ElasticSearch integration to OrleansMetropole projects.

* Model definition
* Custom client
* Index documents
* Delete Documents

Example integration typo3 Command
--------------------

First create OmEk Service with config

```yaml
  # todo #8 How to pass configuration from settings.php to argument @fredewill
  OrleansMetropole\ElasticSearch\Client\Client:
    arguments:
      $config:
        host: 'https://orleans-metropole.ent.westeurope.azure.elastic-cloud.com'
        app-search:
          token: 'private-kr7rcwcq29iw1btyrb5jfkem'
```

```php
  use OrleansMetropole\ElasticSearch\Client\Client;
  public function __construct(
      private readonly PageRepository $pageRepository,
      private readonly Client $ekClient,
      private readonly ConnectionPool $connectionPool
  )
  {}

  $engineName = 'orleans-search';

  // use OrleansMetropole\ElasticSearch\Client\Client ekClient
  // Import as service in Typo3 Context
  $this->ekClient->setEngineName($engineName);

  // Index Document ----------------------------------------------
  $doc = new Typo3Document($uid);
  $doc->setTitle('a title');
  $doc->setSummary($page['abstract']);
  $doc->setContent('lorem sss');
  
  $result = $this->ekClient->indexDocuments([$doc]);
```

Model 
------

Different document to manage `id` and custom validator

* Base model `OrleansMetropole\ElasticSearch\Model\Document`
* Typo3 model `OrleansMetropole\ElasticSearch\Model\Typo3Document`
* Typo3 model `OrleansMetropole\ElasticSearch\Model\DrupalDocument`

Enumeration
-----------

Provided by `orleans-metropole/metadata`
