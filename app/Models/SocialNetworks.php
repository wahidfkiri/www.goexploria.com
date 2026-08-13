<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetworks extends Model
{
    protected $table = 'companies_social_networks';
    protected $networks = [
      "facebook",
      "twitter",
      "google-plus",
      "linkedin",
      "instagram",
      "youtube",
      "pinterest",
      "reddit",
    ];
    protected $networks_icon = [
      "fa-facebook-official",
      "fa-twitter-square",
      "fa-google-plus-square",
      "fa-linkedin-square",
      "fa-instagram",
      "fa-youtube-square",
      "fa-pinterest-square",
      "fa-reddit-square"
    ];

    public function company() {
      return $this->belongsTo("App\Models\Company");
    }

    public function hasNetworks() {
      foreach( $this->networks as $network) {
        if($this[$network] != null)
          return true;
      }
      return false;
    }

    public function hasNetwork($network) {
      if($this[$network] != null) {
        return true;
      }
      return false;
    }

    public function getNetworks() {
      return array_reduce( array_map(null, $this->networks, $this->networks_icon ), function($carry, $net) {
        if($this[$net[0]] != null) {
          $carry[] = $net;
        }
        return $carry;
      }, []);
    }
}
