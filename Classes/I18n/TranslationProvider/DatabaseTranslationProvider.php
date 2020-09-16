<?php
namespace Meteko\DatabaseTranslationProvider\I18n\TranslationProvider;

use Meteko\DatabaseTranslationProvider\Domain\Model\Translation;
use Meteko\DatabaseTranslationProvider\Domain\Repository\TranslationRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\I18n\TranslationProvider\TranslationProviderInterface;
use Neos\Flow\I18n\Cldr\Reader\PluralsReader;
use Neos\Flow\I18n\Locale;
use Neos\Flow\I18n\TranslationProvider\Exception\InvalidPluralFormException;

/**
 * @Flow\Scope("singleton")
 */
class DatabaseTranslationProvider implements TranslationProviderInterface
{

    /**
     * @var TranslationRepository
     */
    protected $translationRepository;

    /**
     * @var PluralsReader
     */
    protected $pluralsReader;

    public function injectTranslationRepository(TranslationRepository $translationRepository)
    {
        $this->translationRepository = $translationRepository;
    }
    public function injectPluralsReader(PluralsReader $pluralsReader)
    {
        $this->pluralsReader = $pluralsReader;
    }

    /**
     * Returns translated label of $originalLabel from a file defined by $sourceName.
     *
     * Chooses particular form of label if available and defined in $pluralForm.
     *
     * @param string $originalLabel Label used as a key in order to find translation
     * @param Locale $locale Locale to use
     * @param string $pluralForm One of RULE constants of PluralsReader
     * @param string $sourceName A relative path to the filename with translations (labels' catalog)
     * @param string $packageKey Key of the package containing the source file
     * @return mixed Translated label or false on failure
     * @throws InvalidPluralFormException
     */
    public function getTranslationByOriginalLabel($originalLabel, Locale $locale, $pluralForm = null, $sourceName = 'Main', $packageKey = 'Neos.Flow')
    {

        return 'Not supported yet';
        if ($pluralForm !== null) {
            $pluralFormsForProvidedLocale = $this->pluralsReader->getPluralForms($locale);

            if (!in_array($pluralForm, $pluralFormsForProvidedLocale)) {
                throw new InvalidPluralFormException('There is no plural form "' . $pluralForm . '" in "' . (string)$locale . '" locale.', 1281033386);
            }
            // We need to convert plural form's string to index, as they are accessed using integers in XLIFF files
            $pluralFormIndex = (int)array_search($pluralForm, $pluralFormsForProvidedLocale);
        } else {
            $pluralFormIndex = 0;
        }

        $translation = $this->translationRepository->findByLocaleAndOriginalLabel($locale, $originalLabel);


    }

    /**
     * Returns label for a key ($labelId) from a file defined by $sourceName.
     *
     * Chooses particular form of label if available and defined in $pluralForm.
     *
     * @param string $labelId Key used to find translated label
     * @param Locale $locale Locale to use
     * @param string $pluralForm One of RULE constants of PluralsReader
     * @param string $sourceName A relative path to the filename with translations (labels' catalog)
     * @param string $packageKey Key of the package containing the source file
     * @return mixed Translated label or false on failure
     * @throws InvalidPluralFormException
     */
    public function getTranslationById($labelId, Locale $locale, $pluralForm = null, $sourceName = 'Main', $packageKey = 'Neos.Flow')
    {
        if ($pluralForm !== null) {
            $pluralFormsForProvidedLocale = $this->pluralsReader->getPluralForms($locale);

            if (!in_array($pluralForm, $pluralFormsForProvidedLocale)) {
                throw new InvalidPluralFormException('There is no plural form "' . $pluralForm . '" in "' . (string)$locale . '" locale.', 1281033387);
            }
            // We need to convert plural form's string to index, as they are accessed using integers in XLIFF files
            $pluralFormIndex = (int)array_search($pluralForm, $pluralFormsForProvidedLocale);
        } else {
            $pluralFormIndex = 0;
        }

        $translation = $this->translationRepository->findByLocaleAndId($locale, $labelId);

        return ($translation instanceof Translation) ? $translation->getLabel() : '';
    }
}
