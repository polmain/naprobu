<?php

namespace App\Exports;

use App\Model\Blogger\BloggerUserProject;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectBlogger implements WithTitle, FromQuery, WithMapping,WithHeadings
{
	use Exportable;
	protected $project_id;
	protected $heads;

	public function __construct($project_id)
	{
		$this->project_id = $project_id;
		$this->headGenerator();
	}


	public function title(): string
	{
		return 'Блоггеры проекта';
	}


	public function query()
	{
		$bloggers = BloggerUserProject::where('project_id', $this->project_id);

		return $bloggers;
	}
	public function map($blogger): array
	{
		$row = [];
		$row[] = $blogger->blogger->id;

		$categories= '';
		foreach ($blogger->blogger->categories as $category){
			$categories.= $category->name.', ';
		}
		$categories = substr($categories,0,-2);
		$row[] = $categories; //Категории

		$subjects = '';
		foreach ($blogger->blogger->subjects as $subject){
			$subjects.= $subject->name.', ';
		}
		$subjects = substr($subjects,0,-2);
		$row[] = $subjects; // тематики

		$row[] = $blogger->blogger->name;
		$row[] = $blogger->blogger->city->name;

		$socialnetwork = '';
		if($blogger->blogger->instagram_link){
			$socialnetwork .= $blogger->blogger->instagram_link;
		}
		if($blogger->facebook_link){
			$socialnetwork .= $blogger->blogger->facebook_link;
		}
		if($blogger->youtube_link){
			$socialnetwork .= $blogger->blogger->youtube_link;
		}

		$row[] = $socialnetwork;

		$socialnetwork = 0;
		if($blogger->blogger->instagram_subscriber){
			$socialnetwork += intval($blogger->blogger->instagram_subscriber);
		}
		if($blogger->facebook_subscriber){
			$socialnetwork += intval($blogger->blogger->facebook_subscriber);
		}
		if($blogger->youtube_subscriber){
			$socialnetwork += intval($blogger->blogger->youtube_subscriber);
		}

		$row[] = $socialnetwork;
		$row[] = $blogger->format;
		$row[] = $blogger->ohvat;
		$row[] = $blogger->prise_without_nds;
		$row[] = $blogger->link_to_post;
		$row[] = $blogger->screen_post;
		$row[] = $blogger->views;
		$row[] = $blogger->likes;
		$row[] = $blogger->comments;
		$row[] = $blogger->ohvat_fact;
		$row[] = $blogger->er;
		$row[] = $blogger->other;

		return $row;
	}
	public function headings(): array
	{
		return $this->heads;
	}

	protected function headGenerator(){

		$this->heads = [];
		$this->heads[] = '#';
		$this->heads[] = 'Категории';
		$this->heads[] = 'Тематика';
		$this->heads[] = 'Название блога';
		$this->heads[] = 'Город';
		$this->heads[] = 'Соц. сети';
		$this->heads[] = 'Подписчики (Всего)';
		$this->heads[] = 'Формат';
		$this->heads[] = 'Охват';
		$this->heads[] = 'Цена';
		$this->heads[] = 'Ссылка на пост';
		$this->heads[] = 'Ссылка на скрин';
		$this->heads[] = 'Показы';
		$this->heads[] = 'Лайки';
		$this->heads[] = 'Комментарии';
		$this->heads[] = 'Охват факт';
		$this->heads[] = 'ER';
		$this->heads[] = 'Прочая активность';
	}
}
