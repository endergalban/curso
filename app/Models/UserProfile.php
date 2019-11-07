<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
  protected $fillable = [
      'bio', 'twitter', 'user_id', 'profession_id'
  ];

  public function profession()
  {
      return $this->belongsTo(Profession::class)->withDefault();
  }
}
