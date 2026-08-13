<?php
namespace App\Http\Controllers;
use App;
use App\Http\Controllers;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Response;
use App\Models\Location;
use App\Models\Continent;
use App\Models\Activity;
use App\Models\Company;
use App\Models\Media;
use App\Models\Page;
use Carbon\Carbon;
const MAX_PER_PAGE = 10000;

class SitemapController extends Controller {

  private $sitemap = null;
  private $counter = 0;
  private $counter_all = 0;
  private $sitemapCounter = 0;
  private $isSubsite = false;

  /** Déclarées explicitement : les propriétés dynamiques sont dépréciées en PHP 8.2. */
  private $domain;
  private $company;

  function __construct() {
    if(!isset($_SERVER['HTTP_HOST']) )
      $host = "www.goexploria.com";
    else
      $host = $_SERVER['HTTP_HOST'];
    $this->domain = preg_replace('/(www|dev)\./i', '', $host);
    $this->company = Company::getFromDomain($this->domain);
    $this->isSubsite = $this->company ? true : false;

  }

  /* generate big sitemap */
  public function index() {

    ini_set('max_execution_time', 600);
    ini_set('memory_limit', "800M");

    $this->sitemap = App::make('sitemap');
    $this->_genHome();
    $this->isSubsite = false;
    $this->_genActivities();
    $this->_genCompanies();
    $this->_genLocations();

    $this->checkUnusedItem();
    var_dump("Nombre de fichier généré:" . $this->sitemapCounter, "Nombre d'enregistrements: " . $this->counter_all);
    // generate new sitemapindex that will contain all generated sitemaps above
    $this->sitemap->store('sitemapindex', 'sitemap', public_path() . "/sitemaps");
  }

  /* generate subsite sitemap */
  public function company() {
    if(!$this->isSubsite) {
      return redirect('/');
    }
    $this->sitemap = App::make('sitemap');
    $this->_genCompanies($this->company);
    return $this->sitemap->render('xml');
  }

  /* Generate robots.txt for subsite or base */
  public function robots() {
    $path = "http://" . $this->domain;

    if(!$this->isSubsite) {
      $path .= "/sitemaps/sitemap.xml";
    } else {
      $path .= "/sitemap.xml";
    }
    $content = view('front.robots', compact('path'));
    return response($content)->header('Content-Type', 'text/plain');
  }

  function _addLocation($item, $url) {
    $images = null;
    if( $this->counter >= MAX_PER_PAGE) {
      $this->addSitemap();
    }

    //build slug
    if(isset($item->parent_id)) {
      $slug = $item->slug;
      $current = $item;
      do {
        $current = $current->head;
        $slug = $current->slug . '/' . $slug;
      } while($current->parent_id != null);
      $url = $url . $slug;
    } else {
      $url = $url . (isset($item->slug) ? $item->slug : $item->code) . '/';
    }
    if($item->getTable() == 'continents') {
      $sorted_img = [];
      $pages = [];
      $arImg = [];
    } else {
      $sorted_img = Media::getEntityMediasByPages($item);
      $pages = Page::getEntityPages($item);
      $arImg = array_key_exists(0, $sorted_img) ? $sorted_img[0] : [];

    }

    $freq = "monthly";
    $priority = 0.5;

    if(isset($item->updated_at) && $item->updated_at->timestamp > 10000) {
      $date = $item->updated_at;
    } else {
      $date = "2018-01-01T12:30:00-05:00";
    }
    $this->addSite($this->setUrl($url), $date, $priority, $freq, $this->parseMedias($arImg), $item->name);

    foreach($pages as $page) {
      $arImg = (array_key_exists($page->id, $sorted_img)) ? $sorted_img[$page->id] : [];
      $page_url = $this->setUrl($url . "/#" . 'page' . $page->id . '-tab');
      $this->addSite($page_url, $page->updated_at, $priority, $freq, $this->parseMedias($arImg));
    }
  }

  function _parseLocations($collection, $url) {

    foreach($collection as $item) {
      $this->_addLocation($item, $url);
      if($item->getChildren()) {
        $this->_parseLocations($item->getChildren()->get(),
        $url . (isset($item->slug) ? $item->slug : $item->code) . '/');
      }
    }
  }

  private function _genLocations() {
    $continents =  Continent::all();
    $this->_parseLocations($continents, "/location/");
  }

  private function _genHome() {
    $url = "/";
    $date = (new \DateTime())->format('Y-m-d');
    $priority = 1;
    $freq = "daily";
    $this->addSite($this->setUrl($url), $date, $priority, $freq);
  }

  private function _genActivities() {
    $activities = Activity::all();
    foreach($activities as $activity) {
      if($this->counter >= MAX_PER_PAGE){
        $this->addSitemap();
      }
      $url = "/activity/". $activity->id . "/" . $activity->slug;
      $date = $activity->updated_at;
      $priority = 0.6;
      $freq = "monthly";
      $this->addSite($this->setUrl($url), $date, $priority, $freq);

    }
  }

  private function _genCompanies($_company=null) {
    if($_company) {
      $companies = [$_company];
    } else {
      // cursor() au lieu de all() : la table compte plus de 130 000 lignes et
      // les charger d'un bloc épuisait la limite mémoire de 800 Mo.
      $companies = Company::cursor();
    }

    foreach($companies as $company) {
      if($this->counter >= MAX_PER_PAGE) {
        $this->addSitemap();
      }

      $date = $company->updated_at;
      $freq = "monthly";
      $priority = 1;
      $sorted_img = Media::getEntityMediasByPages($company);
      $pages = Page::getEntityPages($company);

      if($this->isSubsite) {
        $url = $company->slug;
      } else  {
        $url = "/company" . "/" . $company->id . "/" . $company->slug;
      }


      //Page racine
      $arImg = array_key_exists(0, $sorted_img) ? $sorted_img[0] : [];
      $this->addSite($this->setUrl($url), $date, $priority, $freq, $this->parseMedias($arImg));

      foreach($pages as $page) {
        $priority = 1;
        $freq = "monthly";
        $arImg = (array_key_exists($page->id, $sorted_img)) ? $sorted_img[$page->id] : [];
        $page_url = $this->setUrl($url . "/#" . ($this->isSubsite ? $page->slug : 'page' . $page->id . '-tab'));
        $this->addSite($page_url, $page->updated_at, $priority, $freq, $this->parseMedias($arImg));
      }
    }
  }
  /**
   * @return formated media array
   */
  private function parseMedias($medias) {
    return array_map(function($item) {
      if(strstr($item['slug'], 'http')) {
        $url = $item["slug"];
      } else {
        $url = 'uploads/galleries/' . $item['gallery_id'] . '/' . $item["slug"];
      }
      return [
        'url' => $this->setUrl($url),
        'title' => $item["name"],
        'caption' => $item["content"]
      ];
    }, $medias);
  }

  /* wrapper to add new record to sitemap */
  private function addSite($url, $date=null, $priority=null, $freq=null, $images=[], $title=null) {
    $this->sitemap->add($url, $date, $priority, $freq, $images, $title);
    $this->counter++;
    $this->counter_all++;
  }

  /* create a new sitemap file*/
  private function addSitemap() {
    $this->sitemap->store('xml', 'sitemap-' . $this->sitemapCounter, public_path() . "/sitemaps");
    // add the file to the sitemaps array
    $this->sitemap->addSitemap(secure_url('sitemaps/sitemap-' . $this->sitemapCounter . '.xml'));
    // reset items array (clear memory)
    $this->sitemap->model->resetItems();
    // reset the counter
    $this->counter = 0;
    // count generated sitemap
    $this->sitemapCounter++;
  }

  /* add records not already added to a new sitemap file */
  private function checkUnusedItem() {
    // you need to check for unused items
    if (!empty($this->sitemap->model->getItems())) {
      // generate sitemap with last items
      $this->sitemap->store('xml', 'sitemap-' . $this->sitemapCounter, public_path() . "/sitemaps");
      // add sitemap to sitemaps array
      $this->sitemap->addSitemap(secure_url('/sitemaps/sitemap-' . $this->sitemapCounter . '.xml'));
      // reset items array
      $this->sitemap->model->resetItems();
    }
  }

  /* wrapper to create url for subsite or main site */
  private function setUrl($url=null) {
    if($this->isSubsite) {
      return "http://" . $this->domain . "/" . $url;
    } else
    return URL::to($url);
  }


}
