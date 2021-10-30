<?php

namespace App\Model;

use App\Entity\Collection\CountryCollection;
use App\Entity\Country;
use App\Entity\ProjectAudienceEnum;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $casts = [
        'review_images' => 'array',
    ];

	public function category()
	{
		return $this->hasOne('App\Model\Project\ProjectCategory','id','category_id');
	}

	public function status()
	{
		return $this->hasOne('App\Model\Project\ProjectStatus','id','status_id');
	}

	public function translate(){
		return $this->hasMany('App\Model\Project', 'rus_lang_id');
	}

	public function base(){
		return $this->hasOne('App\Model\Project', 'id','rus_lang_id');
	}

	public function messages(){
		return $this->hasMany('App\Model\Project\ProjectMessage', 'project_id');
	}

	public function subpages(){
		return $this->hasMany('App\Model\Project\Subpage', 'project_id')->where('isHide',0);
	}

	public function requests(){
		return $this->hasMany('App\Model\Project\ProjectRequest', 'project_id');
	}

	public function questionnaires(){
		return $this->hasMany('App\Model\Questionnaire', 'project_id')->where('isHide',0);
	}

	public function blocks(){
		return $this->hasMany('App\Model\Project\ProjectBlock', 'project_id')->where('lang','ru');
	}

	public function links(){
		return $this->hasMany('App\Model\Project\ProjectLink', 'project_id')->where('isHide',0);
	}

	public function bloggers(){
		return $this->hasMany('App\Model\Blogger\BloggerUserProject','project_id');
	}

	public function blogger_posts(){
		return $this->hasMany('App\Model\Project\ProjectBloggerPost','project_id')->where('isHide',0);
	}

	public function bloggersView(){
		$likes = 0;
		foreach ($this->bloggers->toArray() as $blogger){
			$likes += $blogger['views'];
		}
		return $likes;
	}

	public function bloggersLike(){
		$likes = 0;
		foreach ($this->bloggers->toArray() as $blogger){
			$likes += $blogger['likes'];
		}
		return $likes;
	}

	public function bloggersComment(){
		$likes = 0;
		foreach ($this->bloggers->toArray() as $blogger){
			$likes += $blogger['comments'];
		}
		return $likes;
	}

    public function getAudienceAttribute($value): ProjectAudienceEnum
    {
        return ProjectAudienceEnum::getInstance($value);
    }

    public function getCountryAttribute($value): ?Country
    {
        $countryCollection = CountryCollection::getInstance();

        return $countryCollection->getFirstByCode($value);
    }
}
