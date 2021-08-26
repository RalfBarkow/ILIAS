<?php declare(strict_types=1);
/* Copyright (c) 1998-2018 ILIAS open source, Extended GPL, see docs/LICENSE */

/**
 * @author  Niels Theen <ntheen@databay.de>
 */
class ilPageFormats
{
    public const DEFAULT_MARGIN_BODY_TOP = '0cm';
    public const DEFAULT_MARGIN_BODY_RIGHT = '2cm';
    public const DEFAULT_MARGIN_BODY_BOTTOM = '0cm';
    public const DEFAULT_MARGIN_BODY_LEFT = '2cm';

    private ilLanguage $language;

    public function __construct(ilLanguage $language)
    {
        $this->language = $language;
    }

    /**
     * Retrieves predefined page formats
     * @return array<string, array{name: string, value: string, width: string, height: string}>
     */
    public function fetchPageFormats() : array
    {
        return [
            'a4' => [
                'name' => $this->language->txt('certificate_a4'), // (297 mm x 210 mm)
                'value' => 'a4',
                'width' => '210mm',
                'height' => '297mm'
            ],
            'a4landscape' => [
                'name' => $this->language->txt('certificate_a4_landscape'), // (210 mm x 297 mm)',
                'value' => 'a4landscape',
                'width' => '297mm',
                'height' => '210mm'
            ],
            'a5' => [
                'name' => $this->language->txt('certificate_a5'), // (210 mm x 148.5 mm)
                'value' => 'a5',
                'width' => '148mm',
                'height' => '210mm'
            ],
            'a5landscape' => [
                'name' => $this->language->txt('certificate_a5_landscape'), // (148.5 mm x 210 mm)
                'value' => 'a5landscape',
                'width' => '210mm',
                'height' => '148mm'
            ],
            'letter' => [
                'name' => $this->language->txt('certificate_letter'), // (11 inch x 8.5 inch)
                'value' => 'letter',
                'width' => '8.5in',
                'height' => '11in'
            ],
            'letterlandscape' => [
                'name' => $this->language->txt('certificate_letter_landscape'), // (8.5 inch x 11 inch)
                'value' => 'letterlandscape',
                'width' => '11in',
                'height' => '8.5in'
            ],
            'custom' => [
                'name' => $this->language->txt('certificate_custom'),
                'value' => 'custom',
                'width' => '',
                'height' => ''
            ]
        ];
    }
}
