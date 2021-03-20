<?php

namespace App\Imports;

use App\Model\Blogger\BloggerUser;
use App\Model\Blogger\BloggerCity;
use App\Model\Blogger\BloggerCategory;
use App\Model\Blogger\BloggerUserCategory;
use App\Model\Blogger\BloggerSubject;
use App\Model\Blogger\BloggerUserSubject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BloggerImport implements ToCollection
{
	public function collection(Collection $rows)
	{
		foreach ($rows as $row)
		{
			$user = new BloggerUser();

			if(count($row) < 3){
				continue;
			}
			$user->name = $row[2];
			$user->fio = $row[3];
			$user->link = $row[4];
			$user->site = $row[5];
			$user->instagram_link = $row[6];
			$user->instagram_subscriber = $row[7];
			$user->facebook_link = $row[8];
			$user->facebook_subscriber = $row[9];
			$user->youtube_link = $row[10];
			$user->youtube_subscriber = $row[11];
			$user->youtube_avg_views = $row[12];
			$user->other_network = $row[13];
			$user->contacts = $row[14];

			$user->city_id =  $this->firstOrNewCity($row[15]);

			$user->nova_poshta = $row[16];
			$user->phone = $row[17];
			$user->description = $row[18];
			$user->children = $row[19];
			$user->price = $row[20];
			$user->note = $row[21];
			$user->old_member_in_project = $row[22];

			$user->save();

			$this->setCategories($user->id,$row[0]);
			$this->setSubject($user->id,$row[1]);
		}
	}

	protected function firstOrNewCity($city){
		if(isset($city)){
			return BloggerCity::firstOrCreate(['name'=>$city])->id;
		}
		return 1;
	}

	protected function setCategories($user_id, $categories_str){
		$categories = explode(',',$categories_str);
		foreach ($categories as $category){
			$category_id = BloggerCategory::firstOrCreate(['name'=>$category])->id;
			BloggerUserCategory::create([
				'blogger_id' => $user_id,
				'category_id' => $category_id
			]);
		}
	}

	protected function setSubject($user_id, $subjects_str){
		$subjects = explode(',',$subjects_str);
		foreach ($subjects as $subject){
			$subject_id = BloggerSubject::firstOrCreate(['name'=>$subject])->id;
			BloggerUserSubject::create([
				'blogger_id' => $user_id,
				'subject_id' => $subject_id
			]);
		}
	}
}
