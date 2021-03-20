<?php

namespace App\Exports;

use App\Model\Blogger\BloggerUser;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SelectionBlogger implements WithTitle, FromQuery, WithMapping,WithHeadings
{
	use Exportable;
	protected $filters;
	protected $heads;

	public function __construct($request)
	{
		$this->filters = $request;
		$this->headGenerator();
	}


	public function title(): string
	{
		return 'Блоггеры';
	}


	public function query()
	{
		$filters = $this->filters;

		$blogger_ids = [];
		$blogger_arr = [];
		$cities = [];
		$categories = [];
		$subjects = [];
		$social = [];

		if($filters->has('blogger_id')){
			foreach ( $filters->input('blogger_id') as $key => $item){
				$blogger_ids[] = (int)$filters->input('blogger_id')[$key];
			}
		}
		if($filters->has('bloggers')){
			foreach ( $filters->input('bloggers') as $key => $item){
				$blogger_arr[] = (int)$filters->input('bloggers')[$key];
			}
		}
		if($filters->has('cities')){

			foreach ( $filters->input('cities') as $key => $item){
				$cities[] = (int)$filters->input('cities')[$key];
			}
		}
		if($filters->has('categories')){
			foreach ( $filters->input('categories') as $key => $item){
				$categories[] = (int)$filters->input('categories')[$key];
			}
		}
		if($filters->has('subjects')){
			$subjects = [];
			foreach ( $filters->input('subjects') as $key => $item){
				$subjects[] = (int)$filters->input('subjects')[$key];
			}
		}
		if($filters->social){
			$social[] = [
				$filters->input('social'),'<>',null
			];
		}

		$bloggers = BloggerUser::with(['city','categories','subjects','subjectsID','categoriesID'])
			->when($filters->has('blogger_id'), function ($query) use ($blogger_ids){
				$query->whereIn('id', $blogger_ids);
			})
			->when($filters->has('bloggers'), function ($query) use ($blogger_arr){
				$query->whereIn('id', $blogger_arr);
			})
			->when($filters->has('cities'), function ($query) use ($cities){
				$query->whereIn('city_id', $cities);
			})
			->when($filters->has('categories'), function ($query) use ($categories){
				$query->whereHas('categoriesId', function ($category) use ($categories){
					$category->whereIn('category_id', $categories);
				});
			})
			->when($filters->has('subjects'), function ($query) use ($subjects){
				$query->whereHas('subjectsId', function ($subject) use ($subjects){
					$subject->whereIn('subject_id', $subjects);
				});
			})
			->when($filters->has('social'), function ($query) use ($social){
				$query->where($social);
			});

		return $bloggers;
	}
	public function map($blogger): array
	{
		$row = [];
		$row[] = $blogger->id;

		$categories= '';
		foreach ($blogger->categories as $category){
			$categories.= $category->name.', ';
		}
		$categories = substr($categories,0,-2);
		$row[] = $categories; //Категории

		$subjects = '';
		foreach ($blogger->subjects as $subject){
			$subjects.= $subject->name.', ';
		}
		$subjects = substr($subjects,0,-2);
		$row[] = $subjects; // тематики

		$row[] = $blogger->name;
		$row[] = $blogger->fio;
		$row[] = $blogger->link;
		$row[] = $blogger->site;
		$row[] = $blogger->instagram_link;
		$row[] = $blogger->instagram_subscriber;
		$row[] = $blogger->facebook_link;
		$row[] = $blogger->facebook_subscriber;
		$row[] = $blogger->youtube_link;
		$row[] = $blogger->youtube_subscriber;
		$row[] = $blogger->youtube_avg_views;
		$row[] = $blogger->other_network;
		$row[] = $blogger->contacts;
		$row[] = $blogger->city->name;
		$row[] = $blogger->nova_poshta;
		$row[] = $blogger->phone;
		$row[] = $blogger->description;
		$row[] = $blogger->children;
		$row[] = $blogger->price;
		$row[] = $blogger->note;
		$row[] = $blogger->old_member_in_project;

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
		$this->heads[] = 'Блогер (ФИО)';
		$this->heads[] = 'Link (самая крупная площадка)';
		$this->heads[] = 'сайт-блог (ссылка) - если есть';
		$this->heads[] = 'Instagram - Link';
		$this->heads[] = 'Instagram - Подписчики';
		$this->heads[] = 'Facebook - Link';
		$this->heads[] = 'Facebook - Подписчики';
		$this->heads[] = 'YouTube - Link';
		$this->heads[] = 'YouTube - Подписчики';
		$this->heads[] = 'YouTube - среднее к-во просмотров (от-до)';
		$this->heads[] = 'Другие соц.сети';
		$this->heads[] = 'Контакты (адрес, e-mail)';
		$this->heads[] = 'Город';
		$this->heads[] = 'Нова Пошта';
		$this->heads[] = 'Телефон';
		$this->heads[] = 'Описание блога';
		$this->heads[] = 'Дети (дата рождения, к-во, пол)';
		$this->heads[] = 'Стоимость размещений';
		$this->heads[] = 'Заметки';
		$this->heads[] = 'Участвовал в проектах';

	}
}
