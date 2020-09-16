<?php

namespace Meteko\DatabaseTranslationProvider\Command;

use Neos\Flow\Annotations as Flow;
use Meteko\DatabaseTranslationProvider\Domain\Model\Translation;
use Meteko\DatabaseTranslationProvider\Domain\Repository\TranslationRepository;
use Neos\Flow\Cli\CommandController;
use Neos\Flow\I18n\Locale;
use Neos\Flow\I18n\Translator;

class TranslationCommandController extends CommandController
{
    /**
     * @Flow\Inject
     * @var TranslationRepository
     */
    protected $translationRepository;

    /**
     * @Flow\Inject
     * @var Translator
     */
    protected $translator;

    public function seedCommand()
    {
        $locales = ['en', 'de', 'da'];
        $labels = [
            'en' => [
                'hello' => 'Hello',
                'world' => 'World',
                'how_old' => 'How old are you?',
                'tell_age_with_argument' => 'I am {0} years old!'
            ],
            'da' => [
                'hello' => 'Hej',
                'world' => 'verden',
                'how_old' => 'Hvor gammel er du?',
                'tell_age_with_argument' => 'Jeg er {0} år gammel!'
            ],
            'de' => [
                'hello' => 'Hallo',
                'world' => 'Welt',
                'how_old' => 'Wie alt bist du?',
                'tell_age_with_argument' => 'Ich bin {0} Jahre alt!'
            ]
        ];
        foreach ($locales as $locale) {
            foreach ($labels[$locale] as $id => $label) {
                $translation = Translation::create(new Locale($locale), $id, $label);
                $this->translationRepository->add($translation);
            }
        }
    }

    public function listCommand(Locale $locale)
    {
        $translations = $this->translationRepository->findAllByLocale($locale);

        $this->output->outputTable(
            /** @var Translation $translation */
            array_map(function($translation) {
                return [
                    $translation->getId(),
                    $translation->getLabel()
                ];
            }, $translations->toArray()
            ),
            [
                'Id',
                'Label'
            ]
        );
    }

    public function printCommand(Locale $locale, string $id, string $arguments = null)
    {
        $arguments = ($arguments !== null) ? explode(',', $arguments) : null;
        $quantity = null;
        $translation = $this->translator->translateById($id, $arguments, $quantity, $locale);

        $this->output->outputTable(
            [
                [
                    (string) $locale,
                    $id,
                    $translation
                ]
            ],
            [
                'Locale',
                'Id',
                'Label'
            ]
        );
    }
}