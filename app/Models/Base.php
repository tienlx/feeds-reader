<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Base.
 *
 * @mixin \Eloquent
 */
class Base extends Model
{
    /**
    * @return string
    */
    public static function getTableName()
    {
        return with(new static())->getTable();
    }

    /**
     * @return string[]
     */
    public function getEditableColumns()
    {
        return $this->fillable;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return array
     */
    public function toAPIArray()
    {
        return [];
    }

    /**
     * @return array
     */
    public function toFillableArray()
    {
        $ret = [];
        foreach ($this->fillable as $key) {
            $ret[$key] = $this->$key;
        }

        return $ret;
    }

    /**
     * @return string[]
     */
    public function getFillableColumns()
    {
        return $this->fillable;
    }

    /**
     * @return string[]
     */
    public function getDateColumns()
    {
        return $this->dates;
    }
}