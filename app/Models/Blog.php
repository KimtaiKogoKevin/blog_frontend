<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'post' , 'post_excerpt','slug','user_id','featuredImage','metaDescription','views','jsonData'];

    public function setslugAttribute($title)
    {
        $this->attributes['slug']= $this->uniqueSlug($title);
        
    }
    private function uniqueSlug($title){
         
        $slug = Str::slug($title,'-');
        $count = Blog::where('slug','LIKE',"{$slug}%")->count();
        $newcount=$count > 0 ? ++$count : '';
        return $newcount > 0 ? "$slug-$newcount" : $slug;
    }

    public function tag()
    {
    return $this->belongsToMany('App\Models\Tag','blogtags');
    }

    public function cat()
    {
    return $this->belongsToMany('App\Models\Category','blogcategories');
        
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->select('id' , 'fullName' , 'profilepicture');
    }

}
