<?php

namespace App\Http\Controllers\Admin\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project\ProjectMessage;
use App\Model\Project;
use Illuminate\Support\Facades\Auth;
use App\Library\Users\ModeratorLogs;
use Image;
use SEO;
use AdminPageData;

class MessageController extends Controller
{
	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Проекты','project');
	}

   public function all($project_id){
		$messages = ProjectMessage::where([
			['project_id',$project_id],
			['rus_lang_id',0],
		])->get();
	   $project = Project::find($project_id);
	   SEO::setTitle('Все сообщения проекта: '.$project->name);
	   AdminPageData::setPageName('Все сообщения проекта');
	   AdminPageData::addBreadcrumbLevel($project->name,'edit/'.$project->id);
	   AdminPageData::addBreadcrumbLevel('Сообщения');

		return view('admin.projects.message.all',[
			'project_id' => $project_id,
			'messages' => $messages
		]);
   }
	public function new($project_id)
	{
		$project = Project::find($project_id);

		SEO::setTitle('Новое сообщение проекта: '.$project->name);
		AdminPageData::setPageName('Новое сообщение проекта');
		AdminPageData::addBreadcrumbLevel($project->name,'edit/'.$project->id);
		AdminPageData::addBreadcrumbLevel('Новое сообщение');

		return view('admin.projects.message.new',['project' => $project]);
	}

	public function create(Request $request)
	{
		$message = new ProjectMessage();
		$this->createOrEdit($request, $message);

		ModeratorLogs::addLog("Добавил сообщение к проекту: ".$request->project_id);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_message_edit',[$message->id]);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project_message');
		}else{
			return redirect()->route('adm_project_message_new');
		}
	}

	public function edit(Request $request, $message_id)
	{
		$message = ProjectMessage::with(['project','translate'])->find($message_id);

		SEO::setTitle('Редактирование сообщения проекта: '.$message->project->name);
		AdminPageData::setPageName('Редактирование сообщения проекта');
		AdminPageData::addBreadcrumbLevel($message->project->name,'edit/'.$message->project->id);
		AdminPageData::addBreadcrumbLevel('Редактирование сообщения');

		return view('admin.projects.message.edit',[
			'message' => $message
		]);
	}

	public function save(Request $request, $message_id)
	{
		$message = ProjectMessage::find($message_id);
		$this->createOrEdit($request, $message);

		ModeratorLogs::addLog("Отредактировал сообщение к проекту: ".$message->project_id);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_message_edit',$message->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project_message');
		}else{
			return redirect()->route('adm_project_message_new');
		}
	}

	public function delete($message_id){
		ProjectMessage::destroy($message_id);
		ProjectMessage::where('rus_lang_id',$message_id)->delete();
		return "ok";
	}

	public function hide($message_id){
		$message = ProjectMessage::find($message_id);
		$message->isHide = true;
		$message->save();
		$message = ProjectMessage::where('rus_lang_id',$message_id)->first();
		$message->isHide = true;
		$message->save();
		return "ok";
	}
	public function show($message_id){
		$message = ProjectMessage::find($message_id);
		$message->isHide = false;
		$message->save();
		$message = ProjectMessage::where('rus_lang_id',$message_id)->first();
		$message->isHide = false;
		$message->save();
		return "ok";
	}

	protected function createOrEdit($request,$message){
		$message->text = $request->text;
		$message->user_id = Auth::user()->id;
		$message->project_id = $request->project_id;
		$message->isHide = ($request->submit == "save-hide");
		if($request->hasFile('images')){
			$message->images = $this->saveImageGallery($request->images);
		}
		$message->save();

		$translate = ProjectMessage::where([
			['rus_lang_id',$message->id],
			['lang','ua']
		])->first();
		if(empty($translate)){
			$translate = new ProjectMessage();
			$translate->rus_lang_id = $message->id;
			$translate->lang = 'ua';
		}

		$translate->text = $request->textUA;
		$translate->user_id = $message->user_id;
		$translate->project_id = $request->project_id;
		$translate->images = $message->images;
		$translate->isHide = ($request->submit == "save-hide");
		$translate->save();
	}

	protected function saveImageGallery($images){
		$out_images = [];
		$i = 0;
		foreach ($images as $image){
			$out_images[] = $this->saveImageWithPreview($image, $i);
			$i += 2;
		}
		return $out_images;
	}

	protected function saveImageWithPreview($image,$modificator){
		$images = [];
		$filename = time() .$modificator. '.' . $image->getClientOriginalExtension();
		Image::make($image)->save( public_path('/uploads/images/reviews/' . $filename ) );
		$images[] = $filename;

		$filename = time() .($modificator+1). '.' . $image->getClientOriginalExtension();
		Image::make($image)->fit (300, 300)->save( public_path('/uploads/images/reviews/' . $filename ) );
		$images[] = $filename;

		return $images;
	}
}
