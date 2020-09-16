<?php

namespace Meteko\DatabaseTranslationProvider\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\I18n\Locale;

/**
 * @Flow\Entity
 * @ORM\Table(
 *  indexes={
 *      @ORM\Index(name="locale",columns={"locale"})
 *  },
 *  uniqueConstraints={
 *      @ORM\UniqueConstraint(name="locale_id",columns={"locale", "id"})
 *  }
 * )
 */
class Translation
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $label;

    /**
     * @param Locale $locale
     * @param string $id
     * @param string $label
     */
    protected function __construct(Locale $locale, string $id, string $label)
    {
        if (!preg_match(Locale::PATTERN_MATCH_LOCALEIDENTIFIER, (string) $locale)) {
            throw new \InvalidArgumentException('$locale must be a valid I18N Locale identifier');
        }
        $this->locale = $locale;
        $this->id = $id;
        $this->label = $label;
    }

    public static function create(Locale $locale, string $id, string $label): self
    {
        return new static($locale, $id, $label);
    }

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return new Locale($this->locale);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}