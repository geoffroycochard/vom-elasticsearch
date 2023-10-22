<?php
declare(strict_types=1);

namespace OrleansMetropole\ElasticSearch\Model;

use DateTimeImmutable;
use JsonSerializable;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Summary of Document
 */
class Document implements DocumentInterface, JsonSerializable
{
    /**
     * Summary of id
     * @var string
     */
    private string $id;

    /**
     * Summary of type
     * @var string
     */
    private string $type;

    /**
     * Summary of type
     * @var string
     */
    private string $source;

    /**
     * Summary of theme
     * Mise en relation avec des thèmes abordés (mobilité, enfance, sports, loisirs) 
     * utiles pour recouper je pense passer en tags avec thesorus avec des constantes 
     * (petite-enfance, déchets, en-famille) m:m
     * @var array
     */
    private ?array $theme;

    /**
     * Summary of category
     * Informantion sur la typologie d'élements que l'on va retrouver derrière 
     * (je ne veux que les démarches,) m:m
     * @var array
     */
    private ?array $category;

    /**
     * Summary of city
     * concerne tel ville en code / label
     * @var array
     */
    private ?array $city;

    /**
     * Summary of area
     * concerne tel quartier en code / label
     * @var array
     */
    private ?array $area;

    /**
     * Summary of title
     * @var string
     */
    private string $title = '';

    /**
     * Summary of summary
     * @var string
     */
    private ?string $summary;

    /**
     * Summary of content
     * @var string
     */
    private ?string $content;

    /**
     * Summary of date
     * @var array
     */
    private ?array $dateEvent;

	/**
	 * Summary of createdAt
	 * @var DateTimeImmutable
	 */
	private DateTimeImmutable $createdAt;

 /**
  * Summary of updatedAt
  * @var DateTimeImmutable
  */
	private DateTimeImmutable $updatedAt;

    /**
     * Summary of image
     * @var string
     */
    private ?string $image;

    /**
     * Summary of target
     * @var array
     */
    private array $target;

    /**
     * Summary of origin
     * @var array
     */
    private array $origin;

    /**
     * Summary of authorizedOrigin
     * @var array
     */
    private array $authorizedOrigin;

      /**
       * Summary of location
       * @var string
       */
    private ?string $location;

    /**
     * Summary of __construct
     * @param string $id
     */
	public function __construct(string $id)
	{
		$this->id = $id;
	}

    public function jsonSerialize(): mixed {
        // todo #10 return only filled properties @geoffroycochard
		$vars = get_object_vars($this);

		$return = [];
		foreach ($vars as $key => $value) {
			// Have to format key [Fields can only contain lowercase letters, numbers, and underscores]
			$key = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key));
			// Value DateTime
			if($value instanceof DateTimeImmutable) {
				$value = $value->setTimezone(new \DateTimeZone('Europe/Paris'))->format('c');
			}
			$return[$key] = $value;
		}

		return $return;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint(
			'id', 
			new Assert\NotBlank()
		);
        $metadata->addPropertyConstraint(
            'title',
            new Assert\NotBlank()
        );
        $metadata->addPropertyConstraint(
            'type',
            new Assert\NotBlank()
        );
        $metadata->addPropertyConstraint(
            'source',
            new Assert\NotBlank()
        );
    }

	/**
	 * Summary of id
	 * @return string
	 */
	public function getId(): string {
		return $this->id;
	}

	/**
	 * Summary of type
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}
	
	/**
	 * Summary of type
	 * @param string $type Summary of type
	 * @return self
	 */
	public function setType(string $type): self {
		$this->type = $type;
		return $this;
	}

	/**
	 * Summary of type
	 * @return string
	 */
	public function getSource(): string {
		return $this->source;
	}
	
	/**
	 * Summary of type
	 * @param string $source Summary of type
	 * @return self
	 */
	public function setSource(string $source): self {
		$this->source = $source;
		return $this;
	}

	/**
	 * Summary of theme
	 * @return 
	 */
	public function getTheme(): ?array {
		return $this->theme;
	}
	
	/**
	 * Summary of theme
	 * @param  $theme Summary of theme
	 * @return self
	 */
	public function setTheme(?array $theme): self {
		$this->theme = $theme;
		return $this;
	}

	/**
	 * Summary of category
	 * @return 
	 */
	public function getCategory(): ?array {
		return $this->category;
	}
	
	/**
	 * Summary of category
	 * @param  $category Summary of category
	 * @return self
	 */
	public function setCategory(?array $category): self {
		$this->category = $category;
		return $this;
	}

	/**
	 * Summary of city
	 * @return 
	 */
	public function getCity(): ?array {
		return $this->city;
	}
	
	/**
	 * Summary of city
	 * @param  $city Summary of city
	 * @return self
	 */
	public function setCity(?array $city): self {
		$this->city = $city;
		return $this;
	}

	/**
	 * Summary of area
	 * @return 
	 */
	public function getArea(): ?array {
		return $this->area;
	}
	
	/**
	 * Summary of area
	 * @param  $area Summary of area
	 * @return self
	 */
	public function setArea(?array $area): self {
		$this->area = $area;
		return $this;
	}

	/**
	 * Summary of title
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}
	
	/**
	 * Summary of title
	 * @param string $title Summary of title
	 * @return self
	 */
	public function setTitle(string $title): self {
		$this->title = $title;
		return $this;
	}

	/**
	 * Summary of summary
	 * @return 
	 */
	public function getSummary(): ?string {
		return $this->summary;
	}
	
	/**
	 * Summary of summary
	 * @param  $summary Summary of summary
	 * @return self
	 */
	public function setSummary(?string $summary): self {
		$this->summary = $summary;
		return $this;
	}

	/**
	 * Summary of content
	 * @return 
	 */
	public function getContent(): ?string {
		return $this->content;
	}
	
	/**
	 * Summary of content
	 * @param  $content Summary of content
	 * @return self
	 */
	public function setContent(?string $content): self {
		$this->content = $content;
		return $this;
	}

	/**
	 * Summary of date
	 * @return 
	 */
	public function getDateEvent(): ?array {
		return $this->dateEvent;
	}
	
	/**
	 * Summary of date
	 * @param  $date Summary of date
	 * @return self
	 */
	public function setDateEvent(?array $date): self {
		$this->dateEvent = $date;
		return $this;
	}

	/**
	 * Summary of image
	 * @return 
	 */
	public function getImage(): ?string {
		return $this->image;
	}
	
	/**
	 * Summary of image
	 * @param  $image Summary of image
	 * @return self
	 */
	public function setImage(?string $image): self {
		$this->image = $image;
		return $this;
	}

	/**
	 * Summary of target
	 * @return array
	 */
	public function getTarget(): array {
		return $this->target;
	}
	
	/**
	 * Summary of target
	 * @param array $target Summary of target
	 * @return self
	 */
	public function setTarget(array $target): self {
		$this->target = $target;
		return $this;
	}

	/**
	 * Summary of origin
	 * @return array
	 */
	public function getOrigin(): array {
		return $this->origin;
	}
	
	/**
	 * Summary of origin
	 * @param array $origin Summary of origin
	 * @return self
	 */
	public function setOrigin(array $origin): self {
		$this->origin = $origin;
		return $this;
	}

	/**
	 * Summary of authorizedOrigin
	 * @return array
	 */
	public function getAuthorizedOrigin(): array {
		return $this->authorizedOrigin;
	}
	
	/**
	 * Summary of authorizedOrigin
	 * @param array $authorizedOrigin Summary of authorizedOrigin
	 * @return self
	 */
	public function setAuthorizedOrigin(array $authorizedOrigin): self {
		$this->authorizedOrigin = $authorizedOrigin;
		return $this;
	}

	/**
	 * Summary of location
	 * @return 
	 */
	public function getLocation(): ?string {
		return $this->location;
	}
	
	/**
	 * Summary of location
	 * @param  $location Summary of location
	 * @return self
	 */
	public function setLocation(?string $location): self {
		$this->location = $location;
		return $this;
	}

	/**
	 * Summary of createdAt
	 * @return DateTimeImmutable
	 */
	public function getCreatedAt(): DateTimeImmutable {
		return $this->createdAt;
	}
	
	/**
	 * Summary of createdAt
	 * @param DateTimeImmutable $createdAt Summary of createdAt
	 * @return self
	 */
	public function setCreatedAt(DateTimeImmutable $createdAt): self {
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * @return DateTimeImmutable
	 */
	public function getUpdatedAt(): DateTimeImmutable {
		return $this->updatedAt;
	}
	
	/**
	 * @param DateTimeImmutable $updatedAt 
	 * @return self
	 */
	public function setUpdatedAt(DateTimeImmutable $updatedAt): self {
		$this->updatedAt = $updatedAt;
		return $this;
	}
}

