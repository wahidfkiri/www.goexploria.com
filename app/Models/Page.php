<?php

namespace App\Models;


#use App\Models\Location;
#use App\Models\Country;
use App\Models\BaseModel;


class Page extends BaseModel
{

	/** Liste des statuts disponibles */
    private static $statut = null;
    /** Liste des langues disponibles */
    private static $language = null;
    public static $logo_path = "/uploads/pagesLogo/";

    protected $table = 'pages';

    /** Récupère la valeur affichable de la visibilité*/
    public function statut() {
    	return Page::getVisibility($this->is_visible ? 1 : 0);
    }

    /** Renvoie la liste des visibilités disponibles */
    public static function statuts() {
        self::$statut = array (
            0 => "Masquée",
            1 => "Affichée"
        );
        return self::$statut;
    }

    /** Renvoie la liste des langues disponibles */
    public static function languages() {
        self::$language = array (
            'FR' => 'Fra',
            'EN' => 'Eng',
            'ES' => 'Esl',
            'DE' => 'Deu',
            'JA' => 'Jan',
            'ZH' => 'Zho',
            'PT' => 'Por',
            'HI' => 'Hin',
            'AR' => 'Ara'
        );
        return self::$language;
    }

    public function galleries() {
      return $this->hasMany("App\Models\Gallery", 'page_id');
    }

    public function parent() {
      return $this->hasOne("App\Models\Page", 'id', 'parent_id');
    }

    public function children() {
      return $this->hasMany("App\Models\Page", 'parent_id', 'id');
    }

    /** Renvoie la visibilité opposée */
    public function opposite() {
    	return Page::getVisibility($this->is_visible ? 0 : 1);
    }

    /** Renvoi la visibilité en fonction de la valeur passé en argument */
    private static function   getVisibility   ($visibility) {
    	if (array_key_exists ( $visibility, Page::statuts () )) {
            return self::$statut [$visibility];
        } else {
            return self::$statut [0];
        }
    }

    public function set($request) {
        $this->name = $request->name;
        $this->slug = str_slug($this->name, '-');
        $this->content = $request->content;
        $this->rank = $request->rank != null ? $request->rank : 1;
        $this->parent_id = $request->parent == "" || 0  ? null : $request->parent;

        if($request->hasFile("logo") ) {
          $this->processLogo($request);
        }
    }

    public static function getEntityPages($entity) {
      $table = $entity->getTable();
      $name = strtolower(class_basename($entity));
      $entity_id = $entity->id;

      $pages = Page::join($table . '_pages as tp', 'pages.id', '=', 'tp.page_id' )
      ->where("tp.". $name . '_id', $entity_id)
      ->select("pages.id","pages.name", "pages.slug", "pages.updated_at", "pages.logo_url")
      ->get();
      return $pages;
    }

    private function processLogo($request) {

      $file = $request->file('logo');
      $ext = strtolower($file->getClientOriginalExtension());
      $prefix = "menuLogo";
      $dest = public_path() . self::$logo_path;
      $filename = $prefix . '_' . $this->id . '.' . $ext;
      $fullpath = $dest . $filename;

      if (!is_dir ($dest) ) {
        mkdir($dest, 770 );
      }

      if( file_exists(  $fullpath )  ) {
        @unlink( $fullpath );
      }
      $file->move( $dest, $filename);
      $this->logo_url = $filename;
    }



}
