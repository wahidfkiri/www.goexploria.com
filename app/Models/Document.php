<?php

namespace App\Models;

use App\Models\BaseModel;

class Document extends BaseModel
{
  public static $PUBLIC_DOCUMENT_PATH = "/uploads/documents";
  public static $PRIVATE_DOCUMENT_PATH = "/documents";


  public function set($request) {
    $file = $request->file;
    $this->name = $request->name;
    $this->description = $request->description;
    $isPrivate = $request->isPrivate == 'on';

    if($file) {
      $this->filename = $file->getClientOriginalName();
      $this->type = strtolower($file->getClientOriginalExtension());
      $this->isPrivate = $isPrivate;
    }

    if( $this->isPrivate !== null && $isPrivate != $this->isPrivate ) {
      //changement de dossier de destination a effectué lors d'un update
      $from = $this->getFilePath();
      $this->isPrivate = $isPrivate;
      $dest = dirname($this->getFilePath());
      $rename = true;
    } else {
      $rename = false;
      $dest = dirname($this->getFilePath());
    }

    if( !is_dir ($dest) ) {
      mkdir($dest, 0770, true);
    }

    if($file) {
      $file->move($dest, $this->filename);
    } else if($rename) {
      rename($from, $dest . '/' . $this->filename);
    }
  }

  public function setForeign($tablename, $id) {
    $this->foreign_table = $tablename;
    $this->foreign_id = $id;
  }

  /**
  * Return foreign path part based on foreign_table and foreign_id
  */
  private function getForeign() {
    $foreign = '/';
    if( $this->foreign_table != NULL && $this->foreign_id != NULL ) {
      $foreign = $this->foreign_table . '/' . $this->foreign_id . '/';
    }
    return $foreign;
  }

  private function getBasePath() {
    $base_path = public_path() .  self::$PUBLIC_DOCUMENT_PATH;
    if($this->isPrivate) {
      $base_path = storage_path() . '/documents';
    }
    return $base_path;
  }

  public function getUrl() {
    if($this->isPrivate) {
      return false;
    }
    return self::$PUBLIC_DOCUMENT_PATH . "/" . $this->getForeign() . $this->type . "/" . $this->filename;
  }


  public function isImage() {
    return $this->type == "jpg" || $this->type == "png" || $this->type == "gif" || $this->type == "svg";
  }

  public function getFilePath() {
    $base_path = $this->getBasePath();
    $foreign = $this->getForeign();

    return $base_path . '/' . $foreign . $this->type . '/' . $this->filename;
  }


////Solution cheap pour le problème de conversion de la collection en array ou en json
////+ la fonction BaseModel.getDateFormat() à été commenté et cela a réglé le problèmes
////+ possible que sa cause des bogues ailleurs
//   public function getDates()
// {
//
//  return array();
// }


  // public function update(array $attributes = Array, array $options = Array) {
  //
  // }
  //
  // public function delete() {
  //
  // }

}
