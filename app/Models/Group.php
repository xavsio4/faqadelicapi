<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Group extends Model
{

   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

     protected $fillable = [
    'title',
    'description',
    'orderby',
    'key',
    'displayed',
    'counter',
    'lang'
    ];

    /*public function groufaq()
    {
        return $this->belongsToMany('App\Models\GroupFaq');
    }*/

    public function faqs()
    {
        return $this->belongsToMany('App\Models\Faq');
    }

}