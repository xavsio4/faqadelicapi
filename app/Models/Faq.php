<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{

    protected $fillable = [
    'question',
    'answer',
    'orderby',
    ];

   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    public function groups()
    {
        return $this->belongsToMany('App\Models\Group');
    }

}