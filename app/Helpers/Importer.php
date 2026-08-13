<?php

namespace App\Helpers;

use App\Models\Company;
use App\Models\Coordinate;

class Importer {
	public static function Companies($file, $location, $activities) {
		$count = 0;

        $raw = file_get_contents($file);

        $xml = simplexml_load_string($raw);

        foreach($xml->Table as $element) {
            $coordinate = new Coordinate;

            if (isset($element->Site_Internet) && !empty($element->Site_Internet)) {
                $coordinate->website = $element->Site_Internet;
            }

            if (isset($element->Email) && !empty($element->Email)) {
                $coordinate->mail = $element->Email;
            }

            if (isset($element->{'Tél._n_1'}) && !empty($element->{'Tél._n_1'})) {
                $coordinate->tel = $element->{'Tél._n_1'};
            }

            if (isset($element->{'Tél._n_2'}) && !empty($element->{'Tél._n_2'})) {
                $coordinate->fax = $element->{'Tél._n_2'};
            }

            if (isset($element->{'C.P.'}) && !empty($element->{'C.P.'})) {
                $coordinate->code_postal = $element->{'C.P.'};
            }

            if (isset($element->Adresse) && !empty($element->Adresse)) {
                $coordinate->adresse = $element->Adresse;
            }

            $coordinate->location_id = $location;

            $coordinate->save();

            $company = new Company;

            if (isset($element->{'Société'}) && !empty($element->{'Société'})) {
                $company->name = $element->{'Société'};
                $company->slug = str_slug($element->{'Société'});
            }

            if (isset($coordinate->mail) && !empty($coordinate->mail)) {
                $company->mail_news = $coordinate->email;
            } else {
                $company->mail_news = 'info@explorezlequebec.com';
            }

            $company->coordinate_id = $coordinate->id;

            $company->save();

            if (is_array($activities)) {
                foreach($activities as $activity) {
                    if (trim(is_numeric($activity))) {
                        $company->activities()->attach($activity);
                    }
                }
            }

            $count++;
        }

        return $count;
	}
}
