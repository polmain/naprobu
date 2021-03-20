<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	public function translate(){
		return $this->hasOne('App\Model\Post', 'rus_lang_id');
	}

	public function base(){
		return $this->hasOne('App\Model\Post', 'id', 'rus_lang_id');
	}

	public function comments(){
		return $this->hasMany('App\Model\Post\PostComment','post_id');
	}
	public function visible_comments(){
		return $this->hasMany('App\Model\Post\PostComment','post_id')
			->whereIn('status_id',[1,2])
			->where([
				['isHide',0],
			])->orderBy('id');
	}

	public function tags(){
		return $this->belongsToMany('App\Model\Post\PostTagList','post_tags', 'post_id', 'tag_id');
	}

	public function project(){
		return $this->hasOne('App\Model\Project','id', 'project_id');
	}

	public function makeTags($tags){
		$this->tags()->detach();
		$this->tags()->attach($tags);
	}

	public function author(){
		return $this->hasOne('App\User', 'id', 'author_id');
	}
}
