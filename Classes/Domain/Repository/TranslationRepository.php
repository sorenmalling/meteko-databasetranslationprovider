<?php

namespace Meteko\DatabaseTranslationProvider\Domain\Repository;

use Meteko\DatabaseTranslationProvider\Domain\Model\Translation;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\I18n\Locale;
use Neos\Flow\Persistence\Doctrine\Repository;
use Neos\Flow\Persistence\QueryResultInterface;

/**
 * @Flow\Scope("singleton")
 */
class TranslationRepository extends Repository
{
    public function findByLocaleAndId(Locale $locale, string $id): ?Translation
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('locale', (string) $locale),
                $query->equals('id', $id)
            )
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    public function findAllByLocale(Locale $locale): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('locale', (string) $locale)
        );
        return $query->execute();
    }

    public function findByLocaleAndOriginalLabel(Locale $locale, string $id)
    {

    }
}