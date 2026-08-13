<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Relations\HasManyThroughBelongsTo;

class BaseModel extends Model
{

    /** Supprime toute la hiérarchie d'un tableau */
    public function flatten(array $array) {
         $return = array();
         array_walk_recursive($array, function($a,$b) use (&$return) {
            $return[$b] = $a; });
          return $return;
    }

  public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
    {
        $model = new $related;
        $table = $model->getTable();
        $throughModel = new $through;
        $pivot = $throughModel->getTable();

        return $model
            ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
            ->select($table . '.*')
            ->where($pivot . '.' . $firstKey, '=', $this->id);
    }

    public function hasManyThroughBelongTo( $related, $through, $firstKey = null, $secondKey = null )
    {
        $through = new $through;
        $related = new $related;

        $firstKey  = $firstKey ?: $this->getForeignKey();
        $secondKey = $secondKey ?: $related->getForeignKey();

        return new HasManyThroughBelongsTo( $related->newQuery(), $this, $through, $firstKey, $secondKey );
    }

  public function freshTimestamp()
  {
    return time(); // (int) instead of '2000-00-00 00:00:00'
  }

  public function fromDateTime($value)
  {
    return $value; // Don't mutate our (int) on INSERT!
  }

  // Uncomment, if you don't want Carbon API on SELECTs
  // protected function asDateTime($value)
  // {
  //   return $value;
  // }


//Cause des bugs dans la conversion en json ou en array d'une collection
// a donc été commenté... voir si sa cause des problèmes
  // public function getDateFormat()
  // {
  //   return time(); // PHP date() Seconds since the Unix Epoch
  // }
}
