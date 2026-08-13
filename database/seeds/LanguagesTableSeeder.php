<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'Anglais',
                'locale' => 'en',
                'name_en' => 'English',
                'statut' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'Afar',
                'locale' => 'aa',
                'name_en' => 'Afar',
                'statut' => '0',
            ),
            2 => 
            array (
                'id' => '3',
                'name' => 'Abkhaze',
                'locale' => 'ab',
                'name_en' => 'Abkhazian',
                'statut' => '0',
            ),
            3 => 
            array (
                'id' => '4',
                'name' => 'Afrikaans',
                'locale' => 'af',
                'name_en' => 'Afrikaans',
                'statut' => '0',
            ),
            4 => 
            array (
                'id' => '5',
                'name' => 'Amharique',
                'locale' => 'am',
                'name_en' => 'Amharic',
                'statut' => '0',
            ),
            5 => 
            array (
                'id' => '6',
                'name' => 'Arabe',
                'locale' => 'ar',
                'name_en' => 'Arabic',
                'statut' => '0',
            ),
            6 => 
            array (
                'id' => '7',
                'name' => 'Assamais ',
                'locale' => 'as',
                'name_en' => 'Assamese',
                'statut' => '0',
            ),
            7 => 
            array (
                'id' => '8',
                'name' => 'Aymara',
                'locale' => 'ay',
                'name_en' => 'Aymara',
                'statut' => '0',
            ),
            8 => 
            array (
                'id' => '9',
                'name' => 'Azerbaïdjanais ',
                'locale' => 'az',
                'name_en' => 'Azerbaijani',
                'statut' => '0',
            ),
            9 => 
            array (
                'id' => '10',
                'name' => 'Bashkir',
                'locale' => 'ba',
                'name_en' => 'Bashkir',
                'statut' => '0',
            ),
            10 => 
            array (
                'id' => '11',
                'name' => 'Biélorusse',
                'locale' => 'be',
                'name_en' => 'Belarusian',
                'statut' => '0',
            ),
            11 => 
            array (
                'id' => '12',
                'name' => 'Bulgare',
                'locale' => 'bg',
                'name_en' => 'Bulgarian',
                'statut' => '0',
            ),
            12 => 
            array (
                'id' => '13',
                'name' => 'Bihari',
                'locale' => 'bh',
                'name_en' => 'Bihari',
                'statut' => '0',
            ),
            13 => 
            array (
                'id' => '14',
                'name' => 'Bichlamar',
                'locale' => 'bi',
                'name_en' => 'Bislama',
                'statut' => '0',
            ),
            14 => 
            array (
                'id' => '15',
                'name' => 'Bengali/Bangla',
                'locale' => 'bn',
                'name_en' => 'Bengali/Bangla',
                'statut' => '0',
            ),
            15 => 
            array (
                'id' => '16',
                'name' => 'Tibétain',
                'locale' => 'bo',
                'name_en' => 'Tibetan',
                'statut' => '0',
            ),
            16 => 
            array (
                'id' => '17',
                'name' => 'Breton',
                'locale' => 'br',
                'name_en' => 'Breton',
                'statut' => '0',
            ),
            17 => 
            array (
                'id' => '18',
                'name' => 'Catalan',
                'locale' => 'ca',
                'name_en' => 'Catalan',
                'statut' => '0',
            ),
            18 => 
            array (
                'id' => '19',
                'name' => 'Corse',
                'locale' => 'co',
                'name_en' => 'Corsican',
                'statut' => '0',
            ),
            19 => 
            array (
                'id' => '20',
                'name' => 'Tchèque',
                'locale' => 'cs',
                'name_en' => 'Czech',
                'statut' => '0',
            ),
            20 => 
            array (
                'id' => '21',
                'name' => 'Gallois',
                'locale' => 'cy',
                'name_en' => 'Welsh',
                'statut' => '0',
            ),
            21 => 
            array (
                'id' => '22',
                'name' => 'Danois',
                'locale' => 'da',
                'name_en' => 'Danish',
                'statut' => '0',
            ),
            22 => 
            array (
                'id' => '23',
                'name' => 'Allemand',
                'locale' => 'de',
                'name_en' => 'German',
                'statut' => '0',
            ),
            23 => 
            array (
                'id' => '24',
                'name' => 'Dzongkha',
                'locale' => 'dz',
                'name_en' => 'Bhutani',
                'statut' => '0',
            ),
            24 => 
            array (
                'id' => '25',
                'name' => 'Grec',
                'locale' => 'el',
                'name_en' => 'Greek',
                'statut' => '0',
            ),
            25 => 
            array (
                'id' => '26',
                'name' => 'Esperanto',
                'locale' => 'eo',
                'name_en' => 'Esperanto',
                'statut' => '0',
            ),
            26 => 
            array (
                'id' => '27',
                'name' => 'Espagnol',
                'locale' => 'es',
                'name_en' => 'Spanish',
                'statut' => '0',
            ),
            27 => 
            array (
                'id' => '28',
                'name' => 'Estonien',
                'locale' => 'et',
                'name_en' => 'Estonian',
                'statut' => '0',
            ),
            28 => 
            array (
                'id' => '29',
                'name' => 'Basque',
                'locale' => 'eu',
                'name_en' => 'Basque',
                'statut' => '0',
            ),
            29 => 
            array (
                'id' => '30',
                'name' => 'Perse',
                'locale' => 'fa',
                'name_en' => 'Persian',
                'statut' => '0',
            ),
            30 => 
            array (
                'id' => '31',
                'name' => 'Finlandais',
                'locale' => 'fi',
                'name_en' => 'Finnish',
                'statut' => '0',
            ),
            31 => 
            array (
                'id' => '32',
                'name' => 'Fidjien',
                'locale' => 'fj',
                'name_en' => 'Fiji',
                'statut' => '0',
            ),
            32 => 
            array (
                'id' => '33',
                'name' => 'Féroïen',
                'locale' => 'fo',
                'name_en' => 'Faroese',
                'statut' => '0',
            ),
            33 => 
            array (
                'id' => '34',
                'name' => 'Français',
                'locale' => 'fr',
                'name_en' => 'French',
                'statut' => '1',
            ),
            34 => 
            array (
                'id' => '35',
                'name' => 'Frisons',
                'locale' => 'fy',
                'name_en' => 'Frisian',
                'statut' => '0',
            ),
            35 => 
            array (
                'id' => '36',
                'name' => 'Irlandais',
                'locale' => 'ga',
                'name_en' => 'Irish',
                'statut' => '0',
            ),
            36 => 
            array (
                'id' => '37',
                'name' => 'Gaélique',
                'locale' => 'gd',
                'name_en' => 'Gaelic',
                'statut' => '0',
            ),
            37 => 
            array (
                'id' => '38',
                'name' => 'Galicien',
                'locale' => 'gl',
                'name_en' => 'Galician',
                'statut' => '0',
            ),
            38 => 
            array (
                'id' => '39',
                'name' => 'Guarani',
                'locale' => 'gn',
                'name_en' => 'Guarani',
                'statut' => '0',
            ),
            39 => 
            array (
                'id' => '40',
                'name' => 'Gujarati',
                'locale' => 'gu',
                'name_en' => 'Gujarati',
                'statut' => '0',
            ),
            40 => 
            array (
                'id' => '41',
                'name' => 'Haoussa',
                'locale' => 'ha',
                'name_en' => 'Hausa',
                'statut' => '0',
            ),
            41 => 
            array (
                'id' => '42',
                'name' => 'Hindi',
                'locale' => 'hi',
                'name_en' => 'Hindi',
                'statut' => '0',
            ),
            42 => 
            array (
                'id' => '43',
                'name' => 'Croate',
                'locale' => 'hr',
                'name_en' => 'Croatian',
                'statut' => '0',
            ),
            43 => 
            array (
                'id' => '44',
                'name' => 'Hongrois',
                'locale' => 'hu',
                'name_en' => 'Hungarian',
                'statut' => '0',
            ),
            44 => 
            array (
                'id' => '45',
                'name' => 'Arménien',
                'locale' => 'hy',
                'name_en' => 'Armenian',
                'statut' => '0',
            ),
            45 => 
            array (
                'id' => '46',
                'name' => 'Interlingua',
                'locale' => 'ia',
                'name_en' => 'Interlingua',
                'statut' => '0',
            ),
            46 => 
            array (
                'id' => '47',
                'name' => 'Interlingue',
                'locale' => 'ie',
                'name_en' => 'Interlingue',
                'statut' => '0',
            ),
            47 => 
            array (
                'id' => '48',
                'name' => 'Inupiaq',
                'locale' => 'ik',
                'name_en' => 'Inupiak',
                'statut' => '0',
            ),
            48 => 
            array (
                'id' => '49',
                'name' => 'Indonésien',
                'locale' => 'in',
                'name_en' => 'Indonesian',
                'statut' => '0',
            ),
            49 => 
            array (
                'id' => '50',
                'name' => 'Islandais',
                'locale' => 'is',
                'name_en' => 'Icelandic',
                'statut' => '0',
            ),
            50 => 
            array (
                'id' => '51',
                'name' => 'Italien',
                'locale' => 'it',
                'name_en' => 'Italian',
                'statut' => '0',
            ),
            51 => 
            array (
                'id' => '52',
                'name' => 'H ébreu',
                'locale' => 'iw',
                'name_en' => 'Hebrew',
                'statut' => '0',
            ),
            52 => 
            array (
                'id' => '53',
                'name' => 'Japonnais',
                'locale' => 'ja',
                'name_en' => 'Japanese',
                'statut' => '0',
            ),
            53 => 
            array (
                'id' => '54',
                'name' => 'Yiddish',
                'locale' => 'ji',
                'name_en' => 'Yiddish',
                'statut' => '0',
            ),
            54 => 
            array (
                'id' => '55',
                'name' => 'Javanais',
                'locale' => 'jw',
                'name_en' => 'Javanese',
                'statut' => '0',
            ),
            55 => 
            array (
                'id' => '56',
                'name' => 'Géorgien',
                'locale' => 'ka',
                'name_en' => 'Georgian',
                'statut' => '0',
            ),
            56 => 
            array (
                'id' => '57',
                'name' => 'Kazakh',
                'locale' => 'kk',
                'name_en' => 'Kazakh',
                'statut' => '0',
            ),
            57 => 
            array (
                'id' => '58',
                'name' => 'Groenlandais',
                'locale' => 'kl',
                'name_en' => 'Greenlandic',
                'statut' => '0',
            ),
            58 => 
            array (
                'id' => '59',
                'name' => 'Cambodgien',
                'locale' => 'km',
                'name_en' => 'Cambodian',
                'statut' => '0',
            ),
            59 => 
            array (
                'id' => '60',
                'name' => 'Kannada',
                'locale' => 'kn',
                'name_en' => 'Kannada',
                'statut' => '0',
            ),
            60 => 
            array (
                'id' => '61',
                'name' => 'Coréen',
                'locale' => 'ko',
                'name_en' => 'Korean',
                'statut' => '0',
            ),
            61 => 
            array (
                'id' => '62',
                'name' => 'Cachemiri',
                'locale' => 'ks',
                'name_en' => 'Kashmiri',
                'statut' => '0',
            ),
            62 => 
            array (
                'id' => '63',
                'name' => 'Kurde',
                'locale' => 'ku',
                'name_en' => 'Kurdish',
                'statut' => '0',
            ),
            63 => 
            array (
                'id' => '64',
                'name' => 'kirghize',
                'locale' => 'ky',
                'name_en' => 'Kirghiz',
                'statut' => '0',
            ),
            64 => 
            array (
                'id' => '65',
                'name' => 'Latin',
                'locale' => 'la',
                'name_en' => 'Latin',
                'statut' => '0',
            ),
            65 => 
            array (
                'id' => '66',
                'name' => 'Lingala',
                'locale' => 'ln',
                'name_en' => 'Lingala',
                'statut' => '0',
            ),
            66 => 
            array (
                'id' => '67',
                'name' => 'Laotien',
                'locale' => 'lo',
                'name_en' => 'Laothian',
                'statut' => '0',
            ),
            67 => 
            array (
                'id' => '68',
                'name' => 'Lituanien',
                'locale' => 'lt',
                'name_en' => 'Lithuanian',
                'statut' => '0',
            ),
            68 => 
            array (
                'id' => '69',
                'name' => 'Letton',
                'locale' => 'lv',
                'name_en' => 'Latvian/Lettish',
                'statut' => '0',
            ),
            69 => 
            array (
                'id' => '70',
                'name' => 'Malgache',
                'locale' => 'mg',
                'name_en' => 'Malagasy',
                'statut' => '0',
            ),
            70 => 
            array (
                'id' => '71',
                'name' => 'Maori',
                'locale' => 'mi',
                'name_en' => 'Maori',
                'statut' => '0',
            ),
            71 => 
            array (
                'id' => '72',
                'name' => 'Macédonien',
                'locale' => 'mk',
                'name_en' => 'Macedonian',
                'statut' => '0',
            ),
            72 => 
            array (
                'id' => '73',
                'name' => 'Malayalam',
                'locale' => 'ml',
                'name_en' => 'Malayalam',
                'statut' => '0',
            ),
            73 => 
            array (
                'id' => '74',
                'name' => 'Mongol',
                'locale' => 'mn',
                'name_en' => 'Mongolian',
                'statut' => '0',
            ),
            74 => 
            array (
                'id' => '75',
                'name' => 'Moldave',
                'locale' => 'mo',
                'name_en' => 'Moldavian',
                'statut' => '0',
            ),
            75 => 
            array (
                'id' => '76',
                'name' => 'Marathi',
                'locale' => 'mr',
                'name_en' => 'Marathi',
                'statut' => '0',
            ),
            76 => 
            array (
                'id' => '77',
                'name' => 'Malais',
                'locale' => 'ms',
                'name_en' => 'Malay',
                'statut' => '0',
            ),
            77 => 
            array (
                'id' => '78',
                'name' => 'Maltais',
                'locale' => 'mt',
                'name_en' => 'Maltese',
                'statut' => '0',
            ),
            78 => 
            array (
                'id' => '79',
                'name' => 'Birman',
                'locale' => 'my',
                'name_en' => 'Burmese',
                'statut' => '0',
            ),
            79 => 
            array (
                'id' => '80',
                'name' => 'Nauruan',
                'locale' => 'na',
                'name_en' => 'Nauru',
                'statut' => '0',
            ),
            80 => 
            array (
                'id' => '81',
                'name' => 'Népalais',
                'locale' => 'ne',
                'name_en' => 'Nepali',
                'statut' => '0',
            ),
            81 => 
            array (
                'id' => '82',
                'name' => 'Hollandais',
                'locale' => 'nl',
                'name_en' => 'Dutch',
                'statut' => '0',
            ),
            82 => 
            array (
                'id' => '83',
                'name' => 'Norvégien',
                'locale' => 'no',
                'name_en' => 'Norwegian',
                'statut' => '0',
            ),
            83 => 
            array (
                'id' => '84',
                'name' => 'Occitan',
                'locale' => 'oc',
                'name_en' => 'Occitan',
                'statut' => '0',
            ),
            84 => 
            array (
                'id' => '85',
                'name' => 'Odia',
                'locale' => 'om',
                'name_en' => 'Oriya',
                'statut' => '0',
            ),
            85 => 
            array (
                'id' => '86',
                'name' => 'Pendjabi',
                'locale' => 'pa',
                'name_en' => 'Punjabi',
                'statut' => '0',
            ),
            86 => 
            array (
                'id' => '87',
                'name' => 'Polonais',
                'locale' => 'pl',
                'name_en' => 'Polish',
                'statut' => '0',
            ),
            87 => 
            array (
                'id' => '88',
                'name' => 'pachto',
                'locale' => 'ps',
                'name_en' => 'Pashto/Pushto',
                'statut' => '0',
            ),
            88 => 
            array (
                'id' => '89',
                'name' => 'Portugais',
                'locale' => 'pt',
                'name_en' => 'Portuguese',
                'statut' => '0',
            ),
            89 => 
            array (
                'id' => '90',
                'name' => 'Quechua',
                'locale' => 'qu',
                'name_en' => 'Quechua',
                'statut' => '0',
            ),
            90 => 
            array (
                'id' => '91',
                'name' => 'Rhèto-roman',
                'locale' => 'rm',
                'name_en' => 'Rhaeto-Romance',
                'statut' => '0',
            ),
            91 => 
            array (
                'id' => '92',
                'name' => 'Kirundi',
                'locale' => 'rn',
                'name_en' => 'Kirundi',
                'statut' => '0',
            ),
            92 => 
            array (
                'id' => '93',
                'name' => 'Roumain',
                'locale' => 'ro',
                'name_en' => 'Romanian',
                'statut' => '0',
            ),
            93 => 
            array (
                'id' => '94',
                'name' => 'Russe',
                'locale' => 'ru',
                'name_en' => 'Russian',
                'statut' => '0',
            ),
            94 => 
            array (
                'id' => '95',
                'name' => 'Kinyarwanda',
                'locale' => 'rw',
                'name_en' => 'Kinyarwanda',
                'statut' => '0',
            ),
            95 => 
            array (
                'id' => '96',
                'name' => 'Sanskrit',
                'locale' => 'sa',
                'name_en' => 'Sanskrit',
                'statut' => '0',
            ),
            96 => 
            array (
                'id' => '97',
                'name' => 'Sindhi',
                'locale' => 'sd',
                'name_en' => 'Sindhi',
                'statut' => '0',
            ),
            97 => 
            array (
                'id' => '98',
                'name' => 'Sango',
                'locale' => 'sg',
                'name_en' => ' Sango ',
                'statut' => '0',
            ),
            98 => 
            array (
                'id' => '99',
                'name' => 'Serbo-croate',
                'locale' => 'sh',
                'name_en' => 'Serbo-Croatian',
                'statut' => '0',
            ),
            99 => 
            array (
                'id' => '100',
                'name' => 'Cingalais',
                'locale' => 'si',
                'name_en' => 'Singhalese',
                'statut' => '0',
            ),
            100 => 
            array (
                'id' => '101',
                'name' => 'Slovaque',
                'locale' => 'sk',
                'name_en' => 'Slovak',
                'statut' => '0',
            ),
            101 => 
            array (
                'id' => '102',
                'name' => 'Slovène',
                'locale' => 'sl',
                'name_en' => 'Slovenian',
                'statut' => '0',
            ),
            102 => 
            array (
                'id' => '103',
                'name' => 'Samoan',
                'locale' => 'sm',
                'name_en' => 'Samoan',
                'statut' => '0',
            ),
            103 => 
            array (
                'id' => '104',
                'name' => 'Shona',
                'locale' => 'sn',
                'name_en' => 'Shona',
                'statut' => '0',
            ),
            104 => 
            array (
                'id' => '105',
                'name' => 'Somalien',
                'locale' => 'so',
                'name_en' => 'Somali',
                'statut' => '0',
            ),
            105 => 
            array (
                'id' => '106',
                'name' => 'Albanais',
                'locale' => 'sq',
                'name_en' => 'Albanian',
                'statut' => '0',
            ),
            106 => 
            array (
                'id' => '107',
                'name' => 'Serbe',
                'locale' => 'sr',
                'name_en' => 'Serbian',
                'statut' => '0',
            ),
            107 => 
            array (
                'id' => '108',
                'name' => 'swati',
                'locale' => 'ss',
                'name_en' => 'Siswati',
                'statut' => '0',
            ),
            108 => 
            array (
                'id' => '109',
                'name' => 'Sesotho',
                'locale' => 'st',
                'name_en' => 'Sesotho',
                'statut' => '0',
            ),
            109 => 
            array (
                'id' => '110',
                'name' => 'Soundanais',
                'locale' => 'su',
                'name_en' => 'Sundanese',
                'statut' => '0',
            ),
            110 => 
            array (
                'id' => '111',
                'name' => 'Suédois',
                'locale' => 'sv',
                'name_en' => 'Swedish',
                'statut' => '0',
            ),
            111 => 
            array (
                'id' => '112',
                'name' => 'Swahili',
                'locale' => 'sw',
                'name_en' => 'Swahili',
                'statut' => '0',
            ),
            112 => 
            array (
                'id' => '113',
                'name' => 'Tamil',
                'locale' => 'ta',
                'name_en' => 'Tamil',
                'statut' => '0',
            ),
            113 => 
            array (
                'id' => '114',
                'name' => 'Télougou',
                'locale' => 'te',
                'name_en' => 'Telugu',
                'statut' => '0',
            ),
            114 => 
            array (
                'id' => '115',
                'name' => 'Tadjik',
                'locale' => 'tg',
                'name_en' => 'Tajik',
                'statut' => '0',
            ),
            115 => 
            array (
                'id' => '116',
                'name' => 'thaï',
                'locale' => 'th',
                'name_en' => 'Thai',
                'statut' => '0',
            ),
            116 => 
            array (
                'id' => '117',
                'name' => 'Tigrigna',
                'locale' => 'ti',
                'name_en' => 'Tigrinya',
                'statut' => '0',
            ),
            117 => 
            array (
                'id' => '118',
                'name' => 'Turkmène',
                'locale' => 'tk',
                'name_en' => 'Turkmen',
                'statut' => '0',
            ),
            118 => 
            array (
                'id' => '119',
                'name' => 'Tagalog',
                'locale' => 'tl',
                'name_en' => 'Tagalog',
                'statut' => '0',
            ),
            119 => 
            array (
                'id' => '120',
                'name' => 'Tswana',
                'locale' => 'tn',
                'name_en' => 'Setswana',
                'statut' => '0',
            ),
            120 => 
            array (
                'id' => '121',
                'name' => 'Tongien',
                'locale' => 'to',
                'name_en' => 'Tonga',
                'statut' => '0',
            ),
            121 => 
            array (
                'id' => '122',
                'name' => 'Turc',
                'locale' => 'tr',
                'name_en' => 'Turkish',
                'statut' => '0',
            ),
            122 => 
            array (
                'id' => '123',
                'name' => 'Tsonga',
                'locale' => 'ts',
                'name_en' => 'Tsonga',
                'statut' => '0',
            ),
            123 => 
            array (
                'id' => '124',
                'name' => 'Tatar',
                'locale' => 'tt',
                'name_en' => 'Tatar',
                'statut' => '0',
            ),
            124 => 
            array (
                'id' => '125',
                'name' => 'Twi',
                'locale' => 'tw',
                'name_en' => 'Twi',
                'statut' => '0',
            ),
            125 => 
            array (
                'id' => '126',
                'name' => 'Ukrainien',
                'locale' => 'uk',
                'name_en' => 'Ukrainian',
                'statut' => '0',
            ),
            126 => 
            array (
                'id' => '127',
                'name' => 'Ourdou',
                'locale' => 'ur',
                'name_en' => 'Urdu',
                'statut' => '0',
            ),
            127 => 
            array (
                'id' => '128',
                'name' => 'Ouzbek',
                'locale' => 'uz',
                'name_en' => 'Uzbek',
                'statut' => '0',
            ),
            128 => 
            array (
                'id' => '129',
                'name' => 'Vietnamien',
                'locale' => 'vi',
                'name_en' => 'Vietnamese',
                'statut' => '0',
            ),
            129 => 
            array (
                'id' => '130',
                'name' => 'Volapük',
                'locale' => 'vo',
                'name_en' => 'Volapuk',
                'statut' => '0',
            ),
            130 => 
            array (
                'id' => '131',
                'name' => 'Wolof',
                'locale' => 'wo',
                'name_en' => 'Wolof',
                'statut' => '0',
            ),
            131 => 
            array (
                'id' => '132',
                'name' => 'Xhosa',
                'locale' => 'xh',
                'name_en' => 'Xhosa',
                'statut' => '0',
            ),
            132 => 
            array (
                'id' => '133',
                'name' => 'Yoruba',
                'locale' => 'yo',
                'name_en' => 'Yoruba',
                'statut' => '0',
            ),
            133 => 
            array (
                'id' => '134',
                'name' => 'Chinois',
                'locale' => 'zh',
                'name_en' => 'Chinese',
                'statut' => '0',
            ),
            134 => 
            array (
                'id' => '135',
                'name' => 'Zoulou',
                'locale' => 'zu',
                'name_en' => 'Zulu',
                'statut' => '0',
            ),
        ));
        
        
    }
}
