<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasMeta;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    use HasFactory;
    use HasMeta;

    public function child_pages() {
        return $this->hasMany('App\Models\Page', 'parent_id');
    }

    public function parent_page() {
        return $this->belongsTo('App\Models\Page', 'parent_id');
    }

    public function aliasOf() {
        return $this->belongsTo('App\Models\Page', 'alias_of');
    }

    public function hasAlias() {
        return $this->hasMany('App\Models\Page', 'alias_of');
    }

    public function parse($text){
        preg_match_all('#==(.*?)==#', $text, $macroCommand);
        return $macroCommand[1];
    }
 
    public function preorderTraversal($obj, $title, $lang) {
        if ( $obj->parent_id == $obj->id) {
            return $title;
        }
        $parent = Page::find($obj->parent_id);
        if ( $lang == 'eng') {
            $title = $parent->title_eng . ' / ' . $title;
        } else {
            $title = $parent->title_rus . ' / ' . $title;
        }
        return $this->preorderTraversal($parent, $title, $lang);
    }

    // public function preorderTraversalList($obj) {
    //     $str = "<ul>";
    //     $arr = $obj->child_pages;
    //     foreach ($arr as $value) {
    //         $str = $str . "<li>" . $value->title_eng;
    //         if (count($value->child_pages) > 0) {
    //             $str = $str . $value->preorderTraversalList($value);
    //         }
    //         $str = $str . "</li>";
    //     }
    //     $str = $str . "</ul>";
    //     return $str;
    // }

}
