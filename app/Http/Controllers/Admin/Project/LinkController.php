<?php

namespace App\Http\Controllers\Admin\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project\ProjectLink;
use App\Model\Project;
use Illuminate\Support\Facades\Auth;
use App\Library\Users\ModeratorLogs;
use Image;
use SEO;
use AdminPageData;

class LinkController extends Controller
{
	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Проекты','project');
	}

	public function all($project_id){
		$links = ProjectLink::where([
			['project_id',$project_id],
			['rus_lang_id',0],
		])->get();
		$project = Project::find($project_id);
		SEO::setTitle('Все ссылки проекта: '.$project->name);
		AdminPageData::setPageName('Все ссылки проекта');
		AdminPageData::addBreadcrumbLevel($project->name,'edit/'.$project->id);
		AdminPageData::addBreadcrumbLevel('Ссылки');

		return view('admin.projects.links.all',[
			'project_id' => $project_id,
			'links' => $links
		]);
	}

	public function new($project_id)
	{
		$project = Project::find($project_id);

		SEO::setTitle('Новая ссылка проекта: '.$project->name);
		AdminPageData::setPageName('Новая ссылка проекта');
		AdminPageData::addBreadcrumbLevel($project->name,'edit/'.$project->id);
		AdminPageData::addBreadcrumbLevel('Новая ссылка');

		return view('admin.projects.links.new',['project' => $project]);
	}

	public function create(Request $request)
	{
		$link = new ProjectLink();
		$this->createOrEdit($request, $link);

		ModeratorLogs::addLog("Добавил ссылку к проекту: ".$request->project_id);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_links_edit',[$link->id]);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project_links',[$link->project_id]);
		}else{
			return redirect()->route('adm_project_links_new',[$link->project_id]);
		}
	}

	public function edit(Request $request, $link_id)
	{
		$link = ProjectLink::with(['project','translate'])->find($link_id);

		SEO::setTitle('Редактирование ссылки проекта: '.$link->project->name);
		AdminPageData::setPageName('Редактирование ссылки проекта',[$link->project_id]);
		AdminPageData::addBreadcrumbLevel($link->project->name,'edit/'.$link->id);
		AdminPageData::addBreadcrumbLevel('Редактирование ссылки');

		return view('admin.projects.links.edit',[
			'link' => $link
		]);
	}

	public function save(Request $request, $link_id)
	{
		$link = ProjectLink::find($link_id);
		$this->createOrEdit($request, $link);

		ModeratorLogs::addLog("Отредактировал ссылку к проекту: ".$link->project_id);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_links_edit',$link->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project_links',[$link->project_id]);
		}else{
			return redirect()->route('adm_project_links_new',[$link->project_id]);
		}
	}

	public function delete($link_id){
		ProjectLink::destroy($link_id);
		ProjectLink::where('rus_lang_id',$link_id)->delete();
		return "ok";
	}

	public function hide($link_id){
		$link = ProjectLink::find($link_id);
		$link->isHide = true;
		$link->save();
		$link = ProjectLink::where('rus_lang_id',$link_id)->first();
		$link->isHide = true;
		$link->save();
		return "ok";
	}
	public function show($link_id){
		$link = ProjectLink::find($link_id);
		$link->isHide = false;
		$link->save();
		$link = ProjectLink::where('rus_lang_id',$link_id)->first();
		$link->isHide = false;
		$link->save();
		return "ok";
	}

	protected function createOrEdit($request,$link){
		$link->text = $request->text;
		$link->link = $request->link;
		$link->project_id = $request->project_id;
		$link->isHide = ($request->submit == "save-hide");
		$link->save();

		$translate = ProjectLink::where([
			['rus_lang_id',$link->id],
			['lang','ua']
		])->first();
		if(empty($translate)){
			$translate = new ProjectLink();
			$translate->rus_lang_id = $link->id;
			$translate->lang = 'ua';
		}

		$translate->text = $request->textUA;
		$translate->link = $request->linkUA;
		$translate->project_id = $request->project_id;
		$translate->isHide = ($request->submit == "save-hide");
		$translate->save();
	}
}
