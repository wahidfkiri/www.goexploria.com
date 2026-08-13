<?php

namespace App\Models;
use App\Helpers\Utils;
use \ZipArchive;
use \RecursiveIteratorIterator;
use \RecursiveDirectoryIterator;
use Illuminate\Database\Eloquent\Builder;

class Site extends BaseModel
{
  protected $table = 'sites';
  protected $primaryKey = ['company_id', 'config'];
  public $incrementing = false;


  public function config($key) {
    return $this->where('config', $key)->get();
  }


  public static function getAvailableThemes() {
    //return Site::where("config", "theme")->groupBy("value")->get();
    $path = base_path() . "/resources/views/front/site";

    $lst = scandir($path, SCANDIR_SORT_DESCENDING);

    $out = [];
    foreach($lst as $file) {
      $_file = $path . "/" . $file;
      if(is_dir($_file) && !preg_match("/\.$/", $_file)) {
        $out[] = $file;
      }
    }
    return $out;
  }

  public static function getAvailableCssFiles() {
    //return Site::where("config", "theme")->groupBy("value")->get();
    $path = base_path() . "/public/css/front/site/";

    $lst = scandir($path, SCANDIR_SORT_DESCENDING);

    $out = [];
    foreach($lst as $file) {
      $_file = $path . "/" . $file;
      if(is_file($_file) && !preg_match("/\.$/", $_file)) {
        $out[] = $file;
      }
    }
    return $out;
  }

  public static function cloneSiteTheme($theme_name, $new_theme_name) {
    /* must do
    *    : resources/views/front/site/$theme_name
    *    : resources/views/layouts/front/site/$theme_name
    *    : public/css/front/site/${theme_name}.css
    */

    $paths = [
      base_path() . "/resources/views/front/site",
      base_path() . "/resources/views/layouts/front/site",
    ];
    $css_file = base_path() . "/public/css/front/site/${theme_name}.css";
    $css_file_dest = base_path() . "/public/css/front/site/${new_theme_name}.css";

    //srcs must exists
    foreach( $paths as $path ) {
      if(!file_exists("${path}/${theme_name}")) {
        throw new Exception("SRC must exist : ${path}/${theme_name}");
      }
    }

    if(!file_exists($css_file)) {
      throw new Exception("SRC must exist : ${css_file}");
    }

    //dests must not exists
    foreach( $paths as $path ) {
      if(file_exists("${path}/${new_theme_name}")) {
        throw new Exception("DEST must not exist : ${path}/${new_theme_name}");
      }
    }
    if(file_exists($css_file_dest)) {
      throw new Exception("DEST must not exist : ${css_file_dest}");
    }

    //process copy
    foreach( $paths as $path ) {
      Utils::recurse_copy("${path}/${theme_name}", "${path}/${new_theme_name}");
    }
    copy($css_file, $css_file_dest);
    return true;
  }

  public static function downloadTheme($name) {
    $base_path = base_path();
    $paths = [
      base_path() . "/resources/views/front/site" . "/" . $name,
      base_path() . "/resources/views/layouts/front/site" . "/" . $name,
      base_path() . "/public/css/front/site" . "/" . $name . '.css',
    ];

    $zip = new ZipArchive();
    $filename = $name .'.zip';
    $zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    foreach($paths as $rootPath) {

      if(substr_compare($rootPath, ".css", -4) == 0) {
        $files = [
          new \SplFileInfo($rootPath),
        ];
      } else {
        $files = new RecursiveIteratorIterator(
          new RecursiveDirectoryIterator($rootPath),
          RecursiveIteratorIterator::LEAVES_ONLY
        );
      }

      foreach ($files as $name => $file)
      {

        if (!$file->isDir() && $file->isReadable() ) {
          $filePath = $file->getRealPath();
          $relativePath = substr($filePath, strlen($base_path) + 1);
          $zip->addFile($filePath, $relativePath);
        }
      }
    }
    $zip->close();
    return $filename;
  }

  public static function uploadTheme($filepath) {

    $paths = [
      'public/css/front/site',
      'resources/views/front/site',
      "resources/views/layouts/front/site"];
      $dest = base_path();
      $zip = new ZipArchive();
      $arNames = [];

      $zip->open($filepath);

      for($i = 0; $i < $zip->numFiles; $i++) {
        $name = $zip->getNameIndex($i, ZipArchive::FL_UNCHANGED);
        foreach($paths as $path) {

          //la vérification pourrait être plus poussé
          if(fnmatch($path . "/*.blade.php", $name) || fnmatch($path . "/*.css", $name) ) {
            $arNames[] = $name;
          }

        }

      }
      if(count_of($arNames) == 0) return false;
      return $zip->extractTo($dest, $arNames);
    }

    public static function uploadCssFile($cssfile) {
      $dest = 'css/front/site';

      $cssfile->move($dest, $cssfile->getClientOriginalName());
      return true;
    }



    /*
    public function __get($key) {

    $included = [
    'config',
  ];

  // if mutator is defined for an attribute it has precedence.
  if(array_key_exists($key, $this->attributes) && ! $this->hasGetMutator($key) && in_array($key, $included))  {
  return $this->getAttribute($key);
}

// Let everything else handle the Model class itself
return parent::__get($key);
}
*/
/*
public function set($request) {
$this->name = $request->name;
$this->slug = str_slug($this->name, '-');
$this->content = $request->content;
$this->rank = $request->rank != null ? $request->rank : 1;
}
*/


/**
* Set the keys for a save update query.
*
* @param  \Illuminate\Database\Eloquent\Builder  $query
* @return \Illuminate\Database\Eloquent\Builder
*/
protected function setKeysForSaveQuery(Builder $query)
{
  $keys = $this->getKeyName();
  if(!is_array($keys)){
    return parent::setKeysForSaveQuery($query);
  }

  foreach($keys as $keyName){
    $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
  }

  return $query;
}

/**
* Get the primary key value for a save query.
*
* @param mixed $keyName
* @return mixed
*/
protected function getKeyForSaveQuery($keyName = null)
{
  if(is_null($keyName)){
    $keyName = $this->getKeyName();
  }

  if (isset($this->original[$keyName])) {
    return $this->original[$keyName];
  }

  return $this->getAttribute($keyName);
}

}
