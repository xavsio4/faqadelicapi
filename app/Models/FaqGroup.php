<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqGroup extends Model
{

   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faq_group';

    /**
    * Relation to faq
    */
    public function faqs()
    {
        return $this->hasMany(Faq::Class,'id','faq_id');
    }
    
    /**
    * Relation to group
    */
    public function groups()
    {
        return $this->hasMany('App\Models\Group');
    }

}