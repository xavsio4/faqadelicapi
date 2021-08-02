<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use  HasApiTokens, Notifiable, HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'name',
    'email',
    'password',
    ];
    
    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
    'password',
    'remember_token',
    ];
    
    /**
    * Relation to bookmarks
    */
  /*  public function bookmarks()
    {
        return $this->hasMany('App\Models\Bookmark');
    } */
    
    /**
    * Relation to bookmarks
    */
  /*  public function collections()
    {
        return $this->hasMany('App\Models\Collection');
    } */
    
    /**
    * Relation to bookmarks_collections
    */
  /*  public function collectionBookmark()
    {
        return $this->hasMany('App\Models\CollectionBookmark','user_id');
    } */
    
    public function OauthAccessToken()
    {
        return $this->hasMany('App\Models\OauthAccessToken');
    }

    public function Faqs()
    {
      return $this->hasMany('App\Models\Faq');
    }

    public function Groups()
    {
      return $this->hasMany('App\Models\Group');
    }

    public function Groupfaqs()
    {
      return $this->hasMany('App\Models\GroupFaq');
    }
    
    
    
    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
    'email_verified_at' => 'datetime',
    ];
}