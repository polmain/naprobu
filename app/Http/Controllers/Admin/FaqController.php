<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Faq\FaqCategory;
use App\Model\Faq\FaqQuestion;

use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class FaqController extends Controller
{
	protected $childsId = [];

    public function categories(){
		SEO::setTitle('Все группы FAQ');
		AdminPageData::setPageName('Все группы FAQ');
		AdminPageData::addBreadcrumbLevel('FAQ');

		$faqCategories = FaqCategory::with('questions')
			->withCount('questions')
			->where('lang','ru')
			->orderBy('sort')
			->get();

		return view('admin.faq.all',[
			'faqCategories'	=>	$faqCategories
		]);
	}

	public function new(){
		SEO::setTitle('Новая группа');
		AdminPageData::setPageName('Новая группа');
		AdminPageData::addBreadcrumbLevel('Faq','faq');
		AdminPageData::addBreadcrumbLevel('Новая группа');

		return view('admin.faq.new');
	}


	public function edit($id){
		$faqCategory = FaqCategory::with(['translate','questions.translate'])->find($id);


		SEO::setTitle('Редактирование группы');
		AdminPageData::setPageName('Редактирование группы');
		AdminPageData::addBreadcrumbLevel('Faq','questionnaire');
		AdminPageData::addBreadcrumbLevel('Редактирование группы');

		return view('admin.faq.edit', [
			'faqCategory' => $faqCategory,
		]);
	}

	public function create(Request $request){
		$faqCategory = new FaqCategory();
		$translate = new FaqCategory();

		$this->createOrEdit($request, $faqCategory, $translate);

		ModeratorLogs::addLog("Добавил группу FAQ: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_faq_edit',$faqCategory->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_faq');
		}else{
			return redirect()->route('adm_faq_new');
		}
	}

	public function save(Request $request,$id){
		$faqCategory = FaqCategory::find($id);
		$translate = FaqCategory::where('rus_lang_id',$id)->first();

		$this->createOrEdit($request, $faqCategory, $translate);
		ModeratorLogs::addLog("Отредактировал группу FAQ: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_faq_edit',$faqCategory->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_faq');
		}else{
			return redirect()->route('adm_faq_new');
		}
	}


	public function delete($id){
		FaqCategory::destroy($id);
		FaqCategory::where('rus_lang_id',$id)->delete();
		FaqQuestion::where('faq_category_id',$id)->delete();
		return "ok";
	}
	public function hide($id){
		$faqCategory = FaqCategory::find($id);
		$faqCategory->isHide = true;
		$faqCategory->save();
		return "ok";
	}
	public function show($id){
		$faqCategory = FaqCategory::find($id);
		$faqCategory->isHide = false;
		$faqCategory->save();
		return "ok";
	}

	protected function createOrEdit($request,$faqCategory,$translate){
		$faqCategory->name = $request->name;
		$faqCategory->sort = $request->sort;
		$faqCategory->image = $request->image;
		$faqCategory->isHide = ($request->submit == "save-hide");
		$faqCategory->save();

		$translate->name = $request->nameUA;
		$translate->lang = 'ua';
		$translate->rus_lang_id = $faqCategory->id;
		$translate->image = $request->image;
		$translate->sort = $request->sort;
		$translate->save();

		$sort = 1;

		foreach ($request->question as $key=>$value){
			$this->createOrEditQuestion($request,$key,$sort,$faqCategory->id);
			$sort++;
		}

		$this->deleteQuestions($faqCategory->id, $request);
	}


	protected function createOrEditQuestion($request,$key,$sort,$faqCategory_id){
		$question = FaqQuestion::find($request->question[$key]);
		if(empty($question)){
			$question = new FaqQuestion();

		}
		$question->question = $request->question_name[$key];
		$question->answer = $request->question_answer[$key];
		$question->faq_category_id = $faqCategory_id;
		$question->sort = $sort;

		$question->save();
		$this->childsId[] = $question->id;


		$ruId = $question->id;
		/* UA */
		$questionUA = FaqQuestion::where('rus_lang_id',$ruId)->first();

		if(empty($questionUA))
		{
			$questionUA = new FaqQuestion();
			$questionUA->lang = 'ua';
			$questionUA->rus_lang_id = $ruId;
		}

		$questionUA->question = $request->question_name_ua[$key];
		$questionUA->answer = $request->question_answer_ua[$key];
		$questionUA->faq_category_id = $faqCategory_id;
		$questionUA->sort = $sort;

		$questionUA->save();
	}

	protected function deleteQuestions($faqCategory_id){
		$questions = FaqQuestion::where([
			['faq_category_id',$faqCategory_id],
			['rus_lang_id',0],
		])->get();

		foreach ($questions as $question){
			if(!in_array($question->id,$this->childsId)){
				FaqQuestion::where([
					['rus_lang_id',$question->id],
				])->delete();
				$question->delete();
			}
		}
	}
}
