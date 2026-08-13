<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
/*
        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => '1',
                'code' => 'ad',
                'name' => 'Andorre',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'andorre',
                'rank' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'code' => 'ae',
                'name' => 'Émirats Arabes Unis',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'emirats-arabes-unis',
                'rank' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'code' => 'af',
                'name' => 'Afghanistan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'afghanistan',
                'rank' => '1',
            ),
            3 => 
            array (
                'id' => '4',
                'code' => 'ag',
                'name' => 'Antigua-et-Barbuda',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'antigua-et-barbuda',
                'rank' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'code' => 'ai',
                'name' => 'Anguilla',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'anguilla',
                'rank' => '1',
            ),
            5 => 
            array (
                'id' => '6',
                'code' => 'al',
                'name' => 'Albanie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'albanie',
                'rank' => '1',
            ),
            6 => 
            array (
                'id' => '7',
                'code' => 'am',
                'name' => 'Arménie',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'armenie',
                'rank' => '1',
            ),
            7 => 
            array (
                'id' => '8',
                'code' => 'an',
                'name' => 'Antilles Néerlandaises',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'antilles-neerlandaises',
                'rank' => '1',
            ),
            8 => 
            array (
                'id' => '9',
                'code' => 'ao',
                'name' => 'Angola',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'angola',
                'rank' => '1',
            ),
            9 => 
            array (
                'id' => '10',
                'code' => 'aq',
                'name' => 'Antarctique',
                'continent_id' => '2',
                'is_activated' => true,
                'slug' => 'antarctique',
                'rank' => '1',
            ),
            10 => 
            array (
                'id' => '11',
                'code' => 'ar',
                'name' => 'Argentine',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'argentine',
                'rank' => '1',
            ),
            11 => 
            array (
                'id' => '12',
                'code' => 'as',
                'name' => 'Samoa Américaines',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'samoa-americaines',
                'rank' => '1',
            ),
            12 => 
            array (
                'id' => '13',
                'code' => 'at',
                'name' => 'Autriche',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'autriche',
                'rank' => '1',
            ),
            13 => 
            array (
                'id' => '14',
                'code' => 'au',
                'name' => 'Australie',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'australie',
                'rank' => '1',
            ),
            14 => 
            array (
                'id' => '15',
                'code' => 'aw',
                'name' => 'Aruba',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'aruba',
                'rank' => '1',
            ),
            15 => 
            array (
                'id' => '16',
                'code' => 'ax',
                'name' => 'Îles Åland',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'iles-aland',
                'rank' => '1',
            ),
            16 => 
            array (
                'id' => '17',
                'code' => 'az',
                'name' => 'Azerbaïdjan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'azerbaidjan',
                'rank' => '1',
            ),
            17 => 
            array (
                'id' => '18',
                'code' => 'ba',
                'name' => 'Bosnie-Herzégovine',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'bosnie-herzegovine',
                'rank' => '1',
            ),
            18 => 
            array (
                'id' => '19',
                'code' => 'bb',
                'name' => 'Barbade',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'barbade',
                'rank' => '1',
            ),
            19 => 
            array (
                'id' => '20',
                'code' => 'bd',
                'name' => 'Bangladesh',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'bangladesh',
                'rank' => '1',
            ),
            20 => 
            array (
                'id' => '21',
                'code' => 'be',
                'name' => 'Belgique',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'belgique',
                'rank' => '1',
            ),
            21 => 
            array (
                'id' => '22',
                'code' => 'bf',
                'name' => 'Burkina Faso',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'burkina-faso',
                'rank' => '1',
            ),
            22 => 
            array (
                'id' => '23',
                'code' => 'bg',
                'name' => 'Bulgarie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'bulgarie',
                'rank' => '1',
            ),
            23 => 
            array (
                'id' => '24',
                'code' => 'bh',
                'name' => 'Bahreïn',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'bahrein',
                'rank' => '1',
            ),
            24 => 
            array (
                'id' => '25',
                'code' => 'bi',
                'name' => 'Burundi',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'burundi',
                'rank' => '1',
            ),
            25 => 
            array (
                'id' => '26',
                'code' => 'bj',
                'name' => 'Bénin',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'benin',
                'rank' => '1',
            ),
            26 => 
            array (
                'id' => '27',
                'code' => 'bm',
                'name' => 'Bermudes',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'bermudes',
                'rank' => '1',
            ),
            27 => 
            array (
                'id' => '28',
                'code' => 'bn',
                'name' => 'Brunéi Darussalam',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'brunei-darussalam',
                'rank' => '1',
            ),
            28 => 
            array (
                'id' => '29',
                'code' => 'bo',
                'name' => 'Bolivie',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'bolivie',
                'rank' => '1',
            ),
            29 => 
            array (
                'id' => '30',
                'code' => 'br',
                'name' => 'Brésil',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'bresil',
                'rank' => '1',
            ),
            30 => 
            array (
                'id' => '31',
                'code' => 'bs',
                'name' => 'Bahamas',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'bahamas',
                'rank' => '1',
            ),
            31 => 
            array (
                'id' => '32',
                'code' => 'bt',
                'name' => 'Bhoutan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'bhoutan',
                'rank' => '1',
            ),
            32 => 
            array (
                'id' => '33',
                'code' => 'bv',
                'name' => 'Île Bouvet',
                'continent_id' => '2',
                'is_activated' => true,
                'slug' => 'ile-bouvet',
                'rank' => '1',
            ),
            33 => 
            array (
                'id' => '34',
                'code' => 'bw',
                'name' => 'Botswana',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'botswana',
                'rank' => '1',
            ),
            34 => 
            array (
                'id' => '35',
                'code' => 'by',
                'name' => 'Bélarus',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'belarus',
                'rank' => '1',
            ),
            35 => 
            array (
                'id' => '36',
                'code' => 'bz',
                'name' => 'Belize',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'belize',
                'rank' => '1',
            ),
            36 => 
            array (
                'id' => '37',
                'code' => 'ca',
                'name' => 'Canada',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'canada',
                'rank' => '1',
            ),
            37 => 
            array (
                'id' => '38',
                'code' => 'cc',
            'name' => 'Îles Cocos (Keeling)',
                'continent_id' => '3',
                'is_activated' => true,
            'slug' => 'iles-cocos-(keeling)',
                'rank' => '1',
            ),
            38 => 
            array (
                'id' => '39',
                'code' => 'cd',
                'name' => 'République Démocratique du Congo',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'republique-democratique-du-congo',
                'rank' => '1',
            ),
            39 => 
            array (
                'id' => '40',
                'code' => 'cf',
                'name' => 'République Centrafricaine',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'republique-centrafricaine',
                'rank' => '1',
            ),
            40 => 
            array (
                'id' => '41',
                'code' => 'cg',
                'name' => 'République du Congo',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'republique-du-congo',
                'rank' => '1',
            ),
            41 => 
            array (
                'id' => '42',
                'code' => 'ch',
                'name' => 'Suisse',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'suisse',
                'rank' => '1',
            ),
            42 => 
            array (
                'id' => '43',
                'code' => 'ci',
                'name' => 'Côte d\'Ivoire',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'cote-d-ivoire',
                'rank' => '1',
            ),
            43 => 
            array (
                'id' => '44',
                'code' => 'ck',
                'name' => 'Îles Cook',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'iles-cook',
                'rank' => '1',
            ),
            44 => 
            array (
                'id' => '45',
                'code' => 'cl',
                'name' => 'Chili',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'chili',
                'rank' => '1',
            ),
            45 => 
            array (
                'id' => '46',
                'code' => 'cm',
                'name' => 'Cameroun',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'cameroun',
                'rank' => '1',
            ),
            46 => 
            array (
                'id' => '47',
                'code' => 'cn',
                'name' => 'Chine',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'chine',
                'rank' => '1',
            ),
            47 => 
            array (
                'id' => '48',
                'code' => 'co',
                'name' => 'Colombie',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'colombie',
                'rank' => '1',
            ),
            48 => 
            array (
                'id' => '49',
                'code' => 'cr',
                'name' => 'Costa Rica',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'costa-rica',
                'rank' => '1',
            ),
            49 => 
            array (
                'id' => '50',
                'code' => 'cs',
                'name' => 'Serbie-et-Monténégro',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'serbie-et-montenegro',
                'rank' => '1',
            ),
            50 => 
            array (
                'id' => '51',
                'code' => 'cu',
                'name' => 'Cuba',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'cuba',
                'rank' => '1',
            ),
            51 => 
            array (
                'id' => '52',
                'code' => 'cv',
                'name' => 'Cap-vert',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'cap-vert',
                'rank' => '1',
            ),
            52 => 
            array (
                'id' => '53',
                'code' => 'cx',
                'name' => 'Île Christmas',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'ile-christmas',
                'rank' => '1',
            ),
            53 => 
            array (
                'id' => '54',
                'code' => 'cy',
                'name' => 'Chypre',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'chypre',
                'rank' => '1',
            ),
            54 => 
            array (
                'id' => '55',
                'code' => 'cz',
                'name' => 'République Tchèque',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'republique-tcheque',
                'rank' => '1',
            ),
            55 => 
            array (
                'id' => '56',
                'code' => 'de',
                'name' => 'Allemagne',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'allemagne',
                'rank' => '1',
            ),
            56 => 
            array (
                'id' => '57',
                'code' => 'dj',
                'name' => 'Djibouti',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'djibouti',
                'rank' => '1',
            ),
            57 => 
            array (
                'id' => '58',
                'code' => 'dk',
                'name' => 'Danemark',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'danemark',
                'rank' => '1',
            ),
            58 => 
            array (
                'id' => '59',
                'code' => 'dm',
                'name' => 'Dominique',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'dominique',
                'rank' => '1',
            ),
            59 => 
            array (
                'id' => '60',
                'code' => 'do',
                'name' => 'République Dominicaine',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'republique-dominicaine',
                'rank' => '1',
            ),
            60 => 
            array (
                'id' => '61',
                'code' => 'dz',
                'name' => 'Algérie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'algerie',
                'rank' => '1',
            ),
            61 => 
            array (
                'id' => '62',
                'code' => 'ec',
                'name' => 'Équateur',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'equateur',
                'rank' => '1',
            ),
            62 => 
            array (
                'id' => '63',
                'code' => 'ee',
                'name' => 'Estonie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'estonie',
                'rank' => '1',
            ),
            63 => 
            array (
                'id' => '64',
                'code' => 'eg',
                'name' => 'Égypte',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'egypte',
                'rank' => '1',
            ),
            64 => 
            array (
                'id' => '65',
                'code' => 'eh',
                'name' => 'Sahara Occidental',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'sahara-occidental',
                'rank' => '1',
            ),
            65 => 
            array (
                'id' => '66',
                'code' => 'er',
                'name' => 'Érythrée',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'erythree',
                'rank' => '1',
            ),
            66 => 
            array (
                'id' => '67',
                'code' => 'es',
                'name' => 'Espagne',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'espagne',
                'rank' => '1',
            ),
            67 => 
            array (
                'id' => '68',
                'code' => 'et',
                'name' => 'Éthiopie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'ethiopie',
                'rank' => '1',
            ),
            68 => 
            array (
                'id' => '69',
                'code' => 'fi',
                'name' => 'Finlande',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'finlande',
                'rank' => '1',
            ),
            69 => 
            array (
                'id' => '70',
                'code' => 'fj',
                'name' => 'Fidji',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'fidji',
                'rank' => '1',
            ),
            70 => 
            array (
                'id' => '71',
                'code' => 'fk',
            'name' => 'Îles (malvinas) Falkland',
                'continent_id' => '7',
                'is_activated' => true,
            'slug' => 'iles-(malvinas)-falkland',
                'rank' => '1',
            ),
            71 => 
            array (
                'id' => '72',
                'code' => 'fm',
                'name' => 'États Fédérés de Micronésie',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'etats-federes-de-micronesie',
                'rank' => '1',
            ),
            72 => 
            array (
                'id' => '73',
                'code' => 'fo',
                'name' => 'Îles Féroé',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'iles-feroe',
                'rank' => '1',
            ),
            73 => 
            array (
                'id' => '74',
                'code' => 'fr',
                'name' => 'France',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'france',
                'rank' => '1',
            ),
            74 => 
            array (
                'id' => '75',
                'code' => 'ga',
                'name' => 'Gabon',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'gabon',
                'rank' => '1',
            ),
            75 => 
            array (
                'id' => '76',
                'code' => 'gb',
                'name' => 'Royaume-Uni',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'royaume-uni',
                'rank' => '1',
            ),
            76 => 
            array (
                'id' => '77',
                'code' => 'gd',
                'name' => 'Grenade',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'grenade',
                'rank' => '1',
            ),
            77 => 
            array (
                'id' => '78',
                'code' => 'ge',
                'name' => 'Géorgie',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'georgie',
                'rank' => '1',
            ),
            78 => 
            array (
                'id' => '79',
                'code' => 'gf',
                'name' => 'Guyane Française',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'guyane-francaise',
                'rank' => '1',
            ),
            79 => 
            array (
                'id' => '80',
                'code' => 'gh',
                'name' => 'Ghana',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'ghana',
                'rank' => '1',
            ),
            80 => 
            array (
                'id' => '81',
                'code' => 'gi',
                'name' => 'Gibraltar',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'gibraltar',
                'rank' => '1',
            ),
            81 => 
            array (
                'id' => '82',
                'code' => 'gl',
                'name' => 'Groenland',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'groenland',
                'rank' => '1',
            ),
            82 => 
            array (
                'id' => '83',
                'code' => 'gm',
                'name' => 'Gambie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'gambie',
                'rank' => '1',
            ),
            83 => 
            array (
                'id' => '84',
                'code' => 'gn',
                'name' => 'Guinée',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'guinee',
                'rank' => '1',
            ),
            84 => 
            array (
                'id' => '85',
                'code' => 'gp',
                'name' => 'Guadeloupe',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'guadeloupe',
                'rank' => '1',
            ),
            85 => 
            array (
                'id' => '86',
                'code' => 'gq',
                'name' => 'Guinée Équatoriale',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'guinee-equatoriale',
                'rank' => '1',
            ),
            86 => 
            array (
                'id' => '87',
                'code' => 'gr',
                'name' => 'Grèce',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'grece',
                'rank' => '1',
            ),
            87 => 
            array (
                'id' => '88',
                'code' => 'gs',
                'name' => 'Géorgie du Sud et les Îles Sandwich du Sud',
                'continent_id' => '2',
                'is_activated' => true,
                'slug' => 'georgie-du-sud-et-les-iles-sandwich-du-sud',
                'rank' => '1',
            ),
            88 => 
            array (
                'id' => '89',
                'code' => 'gt',
                'name' => 'Guatemala',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'guatemala',
                'rank' => '1',
            ),
            89 => 
            array (
                'id' => '90',
                'code' => 'gu',
                'name' => 'Guam',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'guam',
                'rank' => '1',
            ),
            90 => 
            array (
                'id' => '91',
                'code' => 'gw',
                'name' => 'Guinée-Bissau',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'guinee-bissau',
                'rank' => '1',
            ),
            91 => 
            array (
                'id' => '92',
                'code' => 'gy',
                'name' => 'Guyana',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'guyana',
                'rank' => '1',
            ),
            92 => 
            array (
                'id' => '93',
                'code' => 'hk',
                'name' => 'Hong-Kong',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'hong-kong',
                'rank' => '1',
            ),
            93 => 
            array (
                'id' => '94',
                'code' => 'hm',
                'name' => 'Îles Heard et Mcdonald',
                'continent_id' => '2',
                'is_activated' => true,
                'slug' => 'iles-heard-et-mcdonald',
                'rank' => '1',
            ),
            94 => 
            array (
                'id' => '95',
                'code' => 'hn',
                'name' => 'Honduras',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'honduras',
                'rank' => '1',
            ),
            95 => 
            array (
                'id' => '96',
                'code' => 'hr',
                'name' => 'Croatie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'croatie',
                'rank' => '1',
            ),
            96 => 
            array (
                'id' => '97',
                'code' => 'ht',
                'name' => 'Haïti',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'haiti',
                'rank' => '1',
            ),
            97 => 
            array (
                'id' => '98',
                'code' => 'hu',
                'name' => 'Hongrie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'hongrie',
                'rank' => '1',
            ),
            98 => 
            array (
                'id' => '99',
                'code' => 'id',
                'name' => 'Indonésie',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'indonesie',
                'rank' => '1',
            ),
            99 => 
            array (
                'id' => '100',
                'code' => 'ie',
                'name' => 'Irlande',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'irlande',
                'rank' => '1',
            ),
            100 => 
            array (
                'id' => '101',
                'code' => 'il',
                'name' => 'Israël',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'israel',
                'rank' => '1',
            ),
            101 => 
            array (
                'id' => '102',
                'code' => 'im',
                'name' => 'Île de Man',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'ile-de-man',
                'rank' => '1',
            ),
            102 => 
            array (
                'id' => '103',
                'code' => 'in',
                'name' => 'Inde',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'inde',
                'rank' => '1',
            ),
            103 => 
            array (
                'id' => '104',
                'code' => 'io',
                'name' => 'Territoire Britannique de l\'Océan Indien',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'territoire-britannique-de-l-ocean-indien',
                'rank' => '1',
            ),
            104 => 
            array (
                'id' => '105',
                'code' => 'iq',
                'name' => 'Iraq',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'iraq',
                'rank' => '1',
            ),
            105 => 
            array (
                'id' => '106',
                'code' => 'ir',
                'name' => 'République Islamique d\'Iran',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'republique-islamique-d-iran',
                'rank' => '1',
            ),
            106 => 
            array (
                'id' => '107',
                'code' => 'is',
                'name' => 'Islande',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'islande',
                'rank' => '1',
            ),
            107 => 
            array (
                'id' => '108',
                'code' => 'it',
                'name' => 'Italie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'italie',
                'rank' => '1',
            ),
            108 => 
            array (
                'id' => '109',
                'code' => 'jm',
                'name' => 'Jamaïque',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'jamaique',
                'rank' => '1',
            ),
            109 => 
            array (
                'id' => '110',
                'code' => 'jo',
                'name' => 'Jordanie',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'jordanie',
                'rank' => '1',
            ),
            110 => 
            array (
                'id' => '111',
                'code' => 'jp',
                'name' => 'Japon',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'japon',
                'rank' => '1',
            ),
            111 => 
            array (
                'id' => '112',
                'code' => 'ke',
                'name' => 'Kenya',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'kenya',
                'rank' => '1',
            ),
            112 => 
            array (
                'id' => '113',
                'code' => 'kg',
                'name' => 'Kirghizistan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'kirghizistan',
                'rank' => '1',
            ),
            113 => 
            array (
                'id' => '114',
                'code' => 'kh',
                'name' => 'Cambodge',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'cambodge',
                'rank' => '1',
            ),
            114 => 
            array (
                'id' => '115',
                'code' => 'ki',
                'name' => 'Kiribati',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'kiribati',
                'rank' => '1',
            ),
            115 => 
            array (
                'id' => '116',
                'code' => 'km',
                'name' => 'Comores',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'comores',
                'rank' => '1',
            ),
            116 => 
            array (
                'id' => '117',
                'code' => 'kn',
                'name' => 'Saint-Kitts-et-Nevis',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'saint-kitts-et-nevis',
                'rank' => '1',
            ),
            117 => 
            array (
                'id' => '118',
                'code' => 'kp',
                'name' => 'République Populaire Démocratique de Corée',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'republique-populaire-democratique-de-coree',
                'rank' => '1',
            ),
            118 => 
            array (
                'id' => '119',
                'code' => 'kr',
                'name' => 'République de Corée',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'republique-de-coree',
                'rank' => '1',
            ),
            119 => 
            array (
                'id' => '120',
                'code' => 'kw',
                'name' => 'Koweït',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'koweit',
                'rank' => '1',
            ),
            120 => 
            array (
                'id' => '121',
                'code' => 'ky',
                'name' => 'Îles Caïmanes',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'iles-caimanes',
                'rank' => '1',
            ),
            121 => 
            array (
                'id' => '122',
                'code' => 'kz',
                'name' => 'Kazakhstan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'kazakhstan',
                'rank' => '1',
            ),
            122 => 
            array (
                'id' => '123',
                'code' => 'la',
                'name' => 'République Démocratique Populaire Lao',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'republique-democratique-populaire-lao',
                'rank' => '1',
            ),
            123 => 
            array (
                'id' => '124',
                'code' => 'lb',
                'name' => 'Liban',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'liban',
                'rank' => '1',
            ),
            124 => 
            array (
                'id' => '125',
                'code' => 'lc',
                'name' => 'Sainte-Lucie',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'sainte-lucie',
                'rank' => '1',
            ),
            125 => 
            array (
                'id' => '126',
                'code' => 'li',
                'name' => 'Liechtenstein',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'liechtenstein',
                'rank' => '1',
            ),
            126 => 
            array (
                'id' => '127',
                'code' => 'lk',
                'name' => 'Sri Lanka',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'sri-lanka',
                'rank' => '1',
            ),
            127 => 
            array (
                'id' => '128',
                'code' => 'lr',
                'name' => 'Libéria',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'liberia',
                'rank' => '1',
            ),
            128 => 
            array (
                'id' => '129',
                'code' => 'ls',
                'name' => 'Lesotho',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'lesotho',
                'rank' => '1',
            ),
            129 => 
            array (
                'id' => '130',
                'code' => 'lt',
                'name' => 'Lituanie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'lituanie',
                'rank' => '1',
            ),
            130 => 
            array (
                'id' => '131',
                'code' => 'lu',
                'name' => 'Luxembourg',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'luxembourg',
                'rank' => '1',
            ),
            131 => 
            array (
                'id' => '132',
                'code' => 'lv',
                'name' => 'Lettonie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'lettonie',
                'rank' => '1',
            ),
            132 => 
            array (
                'id' => '133',
                'code' => 'ly',
                'name' => 'Jamahiriya Arabe Libyenne',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'jamahiriya-arabe-libyenne',
                'rank' => '1',
            ),
            133 => 
            array (
                'id' => '134',
                'code' => 'ma',
                'name' => 'Maroc',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'maroc',
                'rank' => '1',
            ),
            134 => 
            array (
                'id' => '135',
                'code' => 'mc',
                'name' => 'Monaco',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'monaco',
                'rank' => '1',
            ),
            135 => 
            array (
                'id' => '136',
                'code' => 'md',
                'name' => 'République de Moldova',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'republique-de-moldova',
                'rank' => '1',
            ),
            136 => 
            array (
                'id' => '137',
                'code' => 'mg',
                'name' => 'Madagascar',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'madagascar',
                'rank' => '1',
            ),
            137 => 
            array (
                'id' => '138',
                'code' => 'mh',
                'name' => 'Îles Marshall',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'iles-marshall',
                'rank' => '1',
            ),
            138 => 
            array (
                'id' => '139',
                'code' => 'mk',
                'name' => 'L\'ex-République Yougoslave de Macédoine',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'l-ex-republique-yougoslave-de-macedoine',
                'rank' => '1',
            ),
            139 => 
            array (
                'id' => '140',
                'code' => 'ml',
                'name' => 'Mali',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'mali',
                'rank' => '1',
            ),
            140 => 
            array (
                'id' => '141',
                'code' => 'mm',
                'name' => 'Myanmar',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'myanmar',
                'rank' => '1',
            ),
            141 => 
            array (
                'id' => '142',
                'code' => 'mn',
                'name' => 'Mongolie',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'mongolie',
                'rank' => '1',
            ),
            142 => 
            array (
                'id' => '143',
                'code' => 'mo',
                'name' => 'Macao',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'macao',
                'rank' => '1',
            ),
            143 => 
            array (
                'id' => '144',
                'code' => 'mp',
                'name' => 'Îles Mariannes du Nord',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'iles-mariannes-du-nord',
                'rank' => '1',
            ),
            144 => 
            array (
                'id' => '145',
                'code' => 'mq',
                'name' => 'Martinique',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'martinique',
                'rank' => '1',
            ),
            145 => 
            array (
                'id' => '146',
                'code' => 'mr',
                'name' => 'Mauritanie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'mauritanie',
                'rank' => '1',
            ),
            146 => 
            array (
                'id' => '147',
                'code' => 'ms',
                'name' => 'Montserrat',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'montserrat',
                'rank' => '1',
            ),
            147 => 
            array (
                'id' => '148',
                'code' => 'mt',
                'name' => 'Malte',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'malte',
                'rank' => '1',
            ),
            148 => 
            array (
                'id' => '149',
                'code' => 'mu',
                'name' => 'Maurice',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'maurice',
                'rank' => '1',
            ),
            149 => 
            array (
                'id' => '150',
                'code' => 'mv',
                'name' => 'Maldives',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'maldives',
                'rank' => '1',
            ),
            150 => 
            array (
                'id' => '151',
                'code' => 'mw',
                'name' => 'Malawi',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'malawi',
                'rank' => '1',
            ),
            151 => 
            array (
                'id' => '152',
                'code' => 'mx',
                'name' => 'Mexique',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'mexique',
                'rank' => '1',
            ),
            152 => 
            array (
                'id' => '153',
                'code' => 'my',
                'name' => 'Malaisie',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'malaisie',
                'rank' => '1',
            ),
            153 => 
            array (
                'id' => '154',
                'code' => 'mz',
                'name' => 'Mozambique',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'mozambique',
                'rank' => '1',
            ),
            154 => 
            array (
                'id' => '155',
                'code' => 'na',
                'name' => 'Namibie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'namibie',
                'rank' => '1',
            ),
            155 => 
            array (
                'id' => '156',
                'code' => 'nc',
                'name' => 'Nouvelle-Calédonie',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'nouvelle-caledonie',
                'rank' => '1',
            ),
            156 => 
            array (
                'id' => '157',
                'code' => 'ne',
                'name' => 'Niger',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'niger',
                'rank' => '1',
            ),
            157 => 
            array (
                'id' => '158',
                'code' => 'nf',
                'name' => 'Île Norfolk',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'ile-norfolk',
                'rank' => '1',
            ),
            158 => 
            array (
                'id' => '159',
                'code' => 'ng',
                'name' => 'Nigéria',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'nigeria',
                'rank' => '1',
            ),
            159 => 
            array (
                'id' => '160',
                'code' => 'ni',
                'name' => 'Nicaragua',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'nicaragua',
                'rank' => '1',
            ),
            160 => 
            array (
                'id' => '161',
                'code' => 'nl',
                'name' => 'Pays-Bas',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'pays-bas',
                'rank' => '1',
            ),
            161 => 
            array (
                'id' => '162',
                'code' => 'no',
                'name' => 'Norvège',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'norvege',
                'rank' => '1',
            ),
            162 => 
            array (
                'id' => '163',
                'code' => 'np',
                'name' => 'Népal',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'nepal',
                'rank' => '1',
            ),
            163 => 
            array (
                'id' => '164',
                'code' => 'nr',
                'name' => 'Nauru',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'nauru',
                'rank' => '1',
            ),
            164 => 
            array (
                'id' => '165',
                'code' => 'nu',
                'name' => 'Niué',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'niue',
                'rank' => '1',
            ),
            165 => 
            array (
                'id' => '166',
                'code' => 'nz',
                'name' => 'Nouvelle-Zélande',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'nouvelle-zelande',
                'rank' => '1',
            ),
            166 => 
            array (
                'id' => '167',
                'code' => 'om',
                'name' => 'Oman',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'oman',
                'rank' => '1',
            ),
            167 => 
            array (
                'id' => '168',
                'code' => 'pa',
                'name' => 'Panama',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'panama',
                'rank' => '1',
            ),
            168 => 
            array (
                'id' => '169',
                'code' => 'pe',
                'name' => 'Pérou',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'perou',
                'rank' => '1',
            ),
            169 => 
            array (
                'id' => '170',
                'code' => 'pf',
                'name' => 'Polynésie Française',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'polynesie-francaise',
                'rank' => '1',
            ),
            170 => 
            array (
                'id' => '171',
                'code' => 'pg',
                'name' => 'Papouasie-Nouvelle-Guinée',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'papouasie-nouvelle-guinee',
                'rank' => '1',
            ),
            171 => 
            array (
                'id' => '172',
                'code' => 'ph',
                'name' => 'Philippines',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'philippines',
                'rank' => '1',
            ),
            172 => 
            array (
                'id' => '173',
                'code' => 'pk',
                'name' => 'Pakistan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'pakistan',
                'rank' => '1',
            ),
            173 => 
            array (
                'id' => '174',
                'code' => 'pl',
                'name' => 'Pologne',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'pologne',
                'rank' => '1',
            ),
            174 => 
            array (
                'id' => '175',
                'code' => 'pm',
                'name' => 'Saint-Pierre-et-Miquelon',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'saint-pierre-et-miquelon',
                'rank' => '1',
            ),
            175 => 
            array (
                'id' => '176',
                'code' => 'pn',
                'name' => 'Pitcairn',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'pitcairn',
                'rank' => '1',
            ),
            176 => 
            array (
                'id' => '177',
                'code' => 'pr',
                'name' => 'Porto Rico',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'porto-rico',
                'rank' => '1',
            ),
            177 => 
            array (
                'id' => '178',
                'code' => 'ps',
                'name' => 'Territoire Palestinien Occupé',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'territoire-palestinien-occupe',
                'rank' => '1',
            ),
            178 => 
            array (
                'id' => '179',
                'code' => 'pt',
                'name' => 'Portugal',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'portugal',
                'rank' => '1',
            ),
            179 => 
            array (
                'id' => '180',
                'code' => 'pw',
                'name' => 'Palaos',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'palaos',
                'rank' => '1',
            ),
            180 => 
            array (
                'id' => '181',
                'code' => 'py',
                'name' => 'Paraguay',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'paraguay',
                'rank' => '1',
            ),
            181 => 
            array (
                'id' => '182',
                'code' => 'qa',
                'name' => 'Qatar',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'qatar',
                'rank' => '1',
            ),
            182 => 
            array (
                'id' => '183',
                'code' => 're',
                'name' => 'Réunion',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'reunion',
                'rank' => '1',
            ),
            183 => 
            array (
                'id' => '184',
                'code' => 'ro',
                'name' => 'Roumanie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'roumanie',
                'rank' => '1',
            ),
            184 => 
            array (
                'id' => '185',
                'code' => 'ru',
                'name' => 'Fédération de Russie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'federation-de-russie',
                'rank' => '1',
            ),
            185 => 
            array (
                'id' => '186',
                'code' => 'rw',
                'name' => 'Rwanda',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'rwanda',
                'rank' => '1',
            ),
            186 => 
            array (
                'id' => '187',
                'code' => 'sa',
                'name' => 'Arabie Saoudite',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'arabie-saoudite',
                'rank' => '1',
            ),
            187 => 
            array (
                'id' => '188',
                'code' => 'sb',
                'name' => 'Îles Salomon',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'iles-salomon',
                'rank' => '1',
            ),
            188 => 
            array (
                'id' => '189',
                'code' => 'sc',
                'name' => 'Seychelles',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'seychelles',
                'rank' => '1',
            ),
            189 => 
            array (
                'id' => '190',
                'code' => 'sd',
                'name' => 'Soudan',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'soudan',
                'rank' => '1',
            ),
            190 => 
            array (
                'id' => '191',
                'code' => 'se',
                'name' => 'Suède',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'suede',
                'rank' => '1',
            ),
            191 => 
            array (
                'id' => '192',
                'code' => 'sg',
                'name' => 'Singapour',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'singapour',
                'rank' => '1',
            ),
            192 => 
            array (
                'id' => '193',
                'code' => 'sh',
                'name' => 'Sainte-Hélène',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'sainte-helene',
                'rank' => '1',
            ),
            193 => 
            array (
                'id' => '194',
                'code' => 'si',
                'name' => 'Slovénie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'slovenie',
                'rank' => '1',
            ),
            194 => 
            array (
                'id' => '195',
                'code' => 'sj',
                'name' => 'Svalbard etÎle Jan Mayen',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'svalbard-etile-jan-mayen',
                'rank' => '1',
            ),
            195 => 
            array (
                'id' => '196',
                'code' => 'sk',
                'name' => 'Slovaquie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'slovaquie',
                'rank' => '1',
            ),
            196 => 
            array (
                'id' => '197',
                'code' => 'sl',
                'name' => 'Sierra Leone',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'sierra-leone',
                'rank' => '1',
            ),
            197 => 
            array (
                'id' => '198',
                'code' => 'sm',
                'name' => 'Saint-Marin',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'saint-marin',
                'rank' => '1',
            ),
            198 => 
            array (
                'id' => '199',
                'code' => 'sn',
                'name' => 'Sénégal',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'senegal',
                'rank' => '1',
            ),
            199 => 
            array (
                'id' => '200',
                'code' => 'so',
                'name' => 'Somalie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'somalie',
                'rank' => '1',
            ),
            200 => 
            array (
                'id' => '201',
                'code' => 'sr',
                'name' => 'Suriname',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'suriname',
                'rank' => '1',
            ),
            201 => 
            array (
                'id' => '202',
                'code' => 'st',
                'name' => 'Sao Tomé-et-Principe',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'sao-tome-et-principe',
                'rank' => '1',
            ),
            202 => 
            array (
                'id' => '203',
                'code' => 'sv',
                'name' => 'El Salvador',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'el-salvador',
                'rank' => '1',
            ),
            203 => 
            array (
                'id' => '204',
                'code' => 'sy',
                'name' => 'République Arabe Syrienne',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'republique-arabe-syrienne',
                'rank' => '1',
            ),
            204 => 
            array (
                'id' => '205',
                'code' => 'sz',
                'name' => 'Swaziland',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'swaziland',
                'rank' => '1',
            ),
            205 => 
            array (
                'id' => '206',
                'code' => 'tc',
                'name' => 'Îles Turks et Caïques',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'iles-turks-et-caiques',
                'rank' => '1',
            ),
            206 => 
            array (
                'id' => '207',
                'code' => 'td',
                'name' => 'Tchad',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'tchad',
                'rank' => '1',
            ),
            207 => 
            array (
                'id' => '208',
                'code' => 'tf',
                'name' => 'Terres Australes Françaises',
                'continent_id' => '2',
                'is_activated' => true,
                'slug' => 'terres-australes-francaises',
                'rank' => '1',
            ),
            208 => 
            array (
                'id' => '209',
                'code' => 'tg',
                'name' => 'Togo',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'togo',
                'rank' => '1',
            ),
            209 => 
            array (
                'id' => '210',
                'code' => 'th',
                'name' => 'Thaïlande',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'thailande',
                'rank' => '1',
            ),
            210 => 
            array (
                'id' => '211',
                'code' => 'tj',
                'name' => 'Tadjikistan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'tadjikistan',
                'rank' => '1',
            ),
            211 => 
            array (
                'id' => '212',
                'code' => 'tk',
                'name' => 'Tokelau',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'tokelau',
                'rank' => '1',
            ),
            212 => 
            array (
                'id' => '213',
                'code' => 'tl',
                'name' => 'Timor-Leste',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'timor-leste',
                'rank' => '1',
            ),
            213 => 
            array (
                'id' => '214',
                'code' => 'tm',
                'name' => 'Turkménistan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'turkmenistan',
                'rank' => '1',
            ),
            214 => 
            array (
                'id' => '215',
                'code' => 'tn',
                'name' => 'Tunisie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'tunisie',
                'rank' => '1',
            ),
            215 => 
            array (
                'id' => '216',
                'code' => 'to',
                'name' => 'Tonga',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'tonga',
                'rank' => '1',
            ),
            216 => 
            array (
                'id' => '217',
                'code' => 'tr',
                'name' => 'Turquie',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'turquie',
                'rank' => '1',
            ),
            217 => 
            array (
                'id' => '218',
                'code' => 'tt',
                'name' => 'Trinité-et-Tobago',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'trinite-et-tobago',
                'rank' => '1',
            ),
            218 => 
            array (
                'id' => '219',
                'code' => 'tv',
                'name' => 'Tuvalu',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'tuvalu',
                'rank' => '1',
            ),
            219 => 
            array (
                'id' => '220',
                'code' => 'tw',
                'name' => 'Taïwan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'taiwan',
                'rank' => '1',
            ),
            220 => 
            array (
                'id' => '221',
                'code' => 'tz',
                'name' => 'République-Unie de Tanzanie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'republique-unie-de-tanzanie',
                'rank' => '1',
            ),
            221 => 
            array (
                'id' => '222',
                'code' => 'ua',
                'name' => 'Ukraine',
                'continent_id' => '4',
                'is_activated' => true,
                'slug' => 'ukraine',
                'rank' => '1',
            ),
            222 => 
            array (
                'id' => '223',
                'code' => 'ug',
                'name' => 'Ouganda',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'ouganda',
                'rank' => '1',
            ),
            223 => 
            array (
                'id' => '224',
                'code' => 'um',
                'name' => 'Îles Mineures Éloignées des États-Unis',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'iles-mineures-eloignees-des-etats-unis',
                'rank' => '1',
            ),
            224 => 
            array (
                'id' => '225',
                'code' => 'us',
                'name' => 'États-Unis',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'etats-unis',
                'rank' => '10',
            ),
            225 => 
            array (
                'id' => '226',
                'code' => 'uy',
                'name' => 'Uruguay',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'uruguay',
                'rank' => '1',
            ),
            226 => 
            array (
                'id' => '227',
                'code' => 'uz',
                'name' => 'Ouzbékistan',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'ouzbekistan',
                'rank' => '1',
            ),
            227 => 
            array (
                'id' => '228',
                'code' => 'va',
            'name' => 'Saint-Siège (état de la Cité du Vatican)',
                'continent_id' => '4',
                'is_activated' => true,
            'slug' => 'saint-siege-(etat-de-la-cite-du-vatican)',
                'rank' => '1',
            ),
            228 => 
            array (
                'id' => '229',
                'code' => 'vc',
                'name' => 'Saint-Vincent-et-les Grenadines',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'saint-vincent-et-les-grenadines',
                'rank' => '1',
            ),
            229 => 
            array (
                'id' => '230',
                'code' => 've',
                'name' => 'Venezuela',
                'continent_id' => '7',
                'is_activated' => true,
                'slug' => 'venezuela',
                'rank' => '1',
            ),
            230 => 
            array (
                'id' => '231',
                'code' => 'vg',
                'name' => 'Îles Vierges Britanniques',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'iles-vierges-britanniques',
                'rank' => '1',
            ),
            231 => 
            array (
                'id' => '232',
                'code' => 'vi',
                'name' => 'Îles Vierges des États-Unis',
                'continent_id' => '5',
                'is_activated' => true,
                'slug' => 'iles-vierges-des-etats-unis',
                'rank' => '1',
            ),
            232 => 
            array (
                'id' => '233',
                'code' => 'vn',
                'name' => 'Viet Nam',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'viet-nam',
                'rank' => '1',
            ),
            233 => 
            array (
                'id' => '234',
                'code' => 'vu',
                'name' => 'Vanuatu',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'vanuatu',
                'rank' => '1',
            ),
            234 => 
            array (
                'id' => '235',
                'code' => 'wf',
                'name' => 'Wallis et Futuna',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'wallis-et-futuna',
                'rank' => '1',
            ),
            235 => 
            array (
                'id' => '236',
                'code' => 'ws',
                'name' => 'Samoa',
                'continent_id' => '6',
                'is_activated' => true,
                'slug' => 'samoa',
                'rank' => '1',
            ),
            236 => 
            array (
                'id' => '237',
                'code' => 'ye',
                'name' => 'Yémen',
                'continent_id' => '3',
                'is_activated' => true,
                'slug' => 'yemen',
                'rank' => '1',
            ),
            237 => 
            array (
                'id' => '238',
                'code' => 'yt',
                'name' => 'Mayotte',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'mayotte',
                'rank' => '1',
            ),
            238 => 
            array (
                'id' => '239',
                'code' => 'za',
                'name' => 'Afrique du Sud',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'afrique-du-sud',
                'rank' => '1',
            ),
            239 => 
            array (
                'id' => '240',
                'code' => 'zm',
                'name' => 'Zambie',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'zambie',
                'rank' => '1',
            ),
            240 => 
            array (
                'id' => '241',
                'code' => 'zw',
                'name' => 'Zimbabwe',
                'continent_id' => '1',
                'is_activated' => true,
                'slug' => 'zimbabwe',
                'rank' => '1',
            ),
        ));
        
*/        
    }
}
