<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project;
use App\Model\Project\ProjectCategory;
use App\Model\Project\ProjectStatus;
use App\Model\Export\Xcontent144;
use Carbon\Carbon;
use Storage;

// todo delete this class
class ExportDBController extends Controller
{
	protected $projectCategory = [
			1091 => "Бытовая химия",
			1107 => "Красота и уход",
			1108 => "Еда и напитки",
			1120 => "Гигиена",
			1118 => "Техника",
			1122 => "Услуги"
		];

	protected $projectStatus = [
		381 => "Не начатый",
		382 => "Регистрация",
		383 => "Новый проект (регистрация завершена)",
		384 => "Тестирование",
		385 => "Заполнение отчёта",
		3657 => "Завершен",
		3658 => "Архив"
	];

    public function project(){
    	$olds = Xcontent144::all();
    	foreach ($olds as $old){
			$category = ProjectCategory::firstOrCreate(['name' => $this->projectCategory[$old->xcid]]);
			$status = ProjectStatus::firstOrCreate(['name' => $this->projectStatus[$old->f1226]]);
			$newProject = new Project();
			$newProject->id = $old->content_id;
			$newProject->name = $old->content_name;
			$newProject->category_id = $category->id;
			$newProject->isHide = ($old->content_del == 1);
			$newProject->text = $old->f1204;
			$newProject->short_description = $old->f1203;
			$newProject->product_name = $old->f1313;
			$newProject->rules = $old->f1285;
			$newProject->count_users = $old->f1312;
			$newProject->status_id = $status->id;
			$newProject->start_registration_time = Carbon::createFromTimestamp($old->f1237)->toDateTimeString();
			$newProject->end_registration_time = Carbon::createFromTimestamp($old->f1317)->toDateTimeString();
			$newProject->start_test_time = Carbon::createFromTimestamp($old->f1238)->toDateTimeString();
			$newProject->start_report_time = Carbon::createFromTimestamp($old->f1348)->toDateTimeString();
			$newProject->end_project_time = Carbon::createFromTimestamp($old->f1239)->toDateTimeString();
			$newProject->seo_description = $old->f1352;
			$newProject->seo_keyword = $old->f1351;


			if($old->f1202 != 0){
				$newProject->preview_image = $this->saveFile($old->f1202);
			}
			if($old->f1284 != 0){
				$newProject->main_image = $this->saveFile($old->f1284);
			}
			if($old->f1322 != 0){
				$newProject->review_image = $this->saveFile($old->f1322);
			}
			$newProject->save();
		}
	}

	private function saveFile($namefile){
		$url = "http://na-proby.com/img/content/i".(($namefile - $namefile%1000)/1000).'/'.$namefile.".gif";
		$contents = file_get_contents($url);
		$newName = time()-$namefile.".gif";
		$name = '/images/'.$newName ;
		Storage::disk("public_uploads")->put($name, $contents);
		return $newName;
	}


}
