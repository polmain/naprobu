<?php

namespace App\Http\Controllers;

use App\Services\LanguageServices\AlternativeUrlService;
use Illuminate\Http\Request;
use Auth;
use App;
use App\Model\Page;
use App\Model\Project;
use App\Model\Project\ProjectRequest;
use App\Model\Questionnaire;
use App\Model\Questionnaire\Question;
use App\Model\Questionnaire\Answer;
use App\User;
use App\Library\Users\UserRating;
use App\Mail\BrifNotificationMail;
use Illuminate\Support\Facades\Mail;
use SEO;
use SEOMeta;
use OpenGraph;

class QuestionnaireController extends Controller
{
	public function questionnaire(Request $request,$id){
		$locale = App::getLocale();
		$user = Auth::user();

		$base = Questionnaire::with(['translate','project','type'])->findOrFail($id);

		if(!$base){
			abort(404);
		}elseif($base->type_id == 1){
			abort(404);
		}


		if(!$user->hasRole("expert") || !$user->new_form_status){
			return redirect()->route('user.cabinet');
		}
		$project = Project::with(['base','category'])->find($base->project_id);
		$projectRequest = ProjectRequest::where([
				['user_id',$user->id],
				['project_id',$base->project_id],
			])->first();

		switch ($base->type_id){
			case 2:
				if(isset($projectRequest)){
					return view("message",[
						'message' => trans("questionnaire.already_submitted_project")
					]);
				}else{
					if($project->status_id != 2){
						return view("message",[
							'message' => trans("questionnaire.registration_completed")
						]);
					}
				}
				break;
			case 3:
				if(isset($projectRequest)){
					if($projectRequest->status_id != 7 && $projectRequest->status_id != 9 ){
						return view("message",[
							'message' => trans("questionnaire.not_admitted_project")
						]);
					}elseif ($projectRequest->status_id == 9){
                        return view("message",[
                            'message' => trans("questionnaire.fill_this_questionnaire")
                        ]);
                    }
				}else{
					return view("message",[
						'message' => trans("questionnaire.not_participate_project")
					]);
				}
				break;
			case 4:
				if(isset($projectRequest)){
					if($projectRequest->status_id != 9){
						return view("message",[
							'message' => trans("questionnaire.not_fill_main_report")
						]);
					}
				}else{
					return view("message",[
						'message' => trans("questionnaire.not_participate_project")
					]);
				}
				break;
		}


		$questionnaire = null;
		$questions = Question::with(['translate','options.translate'])->where([
			['isHide', 0],
			['lang', 'ru'],
			['parent', 0],
			['questionnaire_id', $base->id],
		])->orderBy('sort')->get();

		if($locale == "ru"){
			$questionnaire = $base;
		}
		else
		{
			$project = Project::with(['base','category'])->where([
				['lang', $locale],
				['rus_lang_id', $base->project_id],
			])->first();
			$questionnaire = Questionnaire::where([
			    'rus_lang_id'=>$base->id,
                'lang' => $locale
            ])->first();

            if(!$questionnaire || !$project){
                abort(404);
            }
		}

		$title = str_replace(':page_name:',$questionnaire->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = str_replace(':page_name:',$questionnaire->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $project->preview_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

        $routes = AlternativeUrlService::generateReplyRoutes('projects/questionnaire/'.$id.'/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);


		return view('project.subpage.questionnaire',[
			'questionnaire' => $questionnaire,
			'project' => $project,
			'base' => $base,
			'questions' => $questions,
			'locale' => $locale,
			'alternativeUrls' => $alternativeUrls
		]);
	}

	public function questionnaireSend(Request $request, $questionnaire_id){
		$user_id = Auth::user()->id;

		if(!Auth::user()->hasRole("expert")){
			$responce = [
				'status' => 'error',
				'text' => trans('questionnaire.not_allow'),
			];

			return \Response::json($responce);
		}

		$questionnaire = Questionnaire::find($questionnaire_id);
		$questions = Question::with(['options'])->where([
			['isHide', 0],
			['lang', 'ru'],
			['parent', 0],
			['questionnaire_id', $questionnaire->id],
		])->orderBy('sort')->get();

		$projectRequest = ProjectRequest::where([
			['user_id',$user_id],
			['project_id',$questionnaire->project_id],
		])->first();
		if($questionnaire->type_id == 2){
			if(isset($projectRequest)){
				$responce = [
					'status' => 'error',
					'text' => trans('questionnaire.already_submitted_project'),
				];

				return \Response::json($responce);
			}

			$projectRequest = new ProjectRequest();
			$projectRequest->user_id = $user_id;
			$projectRequest->status_id = 1;
			$projectRequest->project_id = $questionnaire->project_id;
			$projectRequest->save();
		}elseif($questionnaire->type_id == 3){
			if ($projectRequest->status_id == 9){
				$responce = [
					'status' => 'error',
					'text' =>  trans('questionnaire.fill_this_questionnaire'),
				];

				return \Response::json($responce);
			}
		}elseif($questionnaire->type_id == 4){
			if ($projectRequest->status_id == 11){
				$responce = [
					'status' => 'error',
					'text' => trans('questionnaire.fill_this_questionnaire'),
				];

				return \Response::json($responce);
			}
		}
		$projectRequestStatus = $projectRequest->status_id;
		if ($projectRequestStatus == 7){

			$projectRequest->status_id = 9;
			$projectRequest->save();

			UserRating::addAction('send_report',Auth::user());

		}elseif ($projectRequestStatus == 9){

			$projectRequest->status_id = 11;
			$projectRequest->save();

			UserRating::addAction('send_report',Auth::user());
		}

		foreach ($questions as $question){
			switch ($question->type_id){
				case 1:
				case 2:
				case 8:
				case 10:
					if($request->input('question_'.$question->id) != "")
					{
						$answer = new Answer();
						$answer->answer = $request->input('question_' . $question->id);
						$answer->question_id = $question->id;
						$answer->project_request_id = $projectRequest->id;
						$answer->save();
					}
					break;
				case 3:
				case 5:
					if($request->has('question_'.$question->id)){
						if($request->input('question_'.$question->id) != ""){
							$answer = new Answer();
							$value = $request->input('question_'.$question->id);
							if($question->options->where('id',$value)->first()->type_id == 9){
								$answer->answer = $request->input('question_'.$value);
							}
							$answer->question_id = $value;
							$answer->project_request_id = $projectRequest->id;
							$answer->save();
						}
					}
					break;
				case 4:{
					if($request->has('question_'.$question->id))
					foreach ($request->input('question_'.$question->id) as $key => $value){
						$answer = new Answer();
						$val = $request->input('question_'.$question->id)[$key];
						if($question->options->where('id',$val)->first()->type_id == 9){
							$answer->answer = $request->input('question_'.$val);
						}
						$answer->question_id = $val;
						$answer->project_request_id = $projectRequest->id;
						$answer->save();
					}
					break;
				}

			}
		}

		if ($projectRequestStatus == 7){

			$responce = [
				'status' => 'ok',
				'route' => route('project.questionnaire.thank.report'),
			];

			return \Response::json($responce);

		}elseif ($projectRequestStatus == 9){

			$responce = [
				'status' => 'ok',
				'route' => route('project.questionnaire.thank.report'),
			];

			return \Response::json($responce);
		}

		//UserRating::addAction('project_request',Auth::user());

		$responce = [
			'status' => 'ok',
			'route' => route('project.questionnaire.thank.regiter'),
		];

		return \Response::json($responce);
	}

	public function thank_regiter(){
		$locale = App::getLocale();

        $routes = AlternativeUrlService::generateReplyRoutes('thank-you-registration/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view("message",[
			'header' => trans("questionnaire.thank_you_regiter_header"),
			'message' => trans("questionnaire.thank_you_regiter_message"),
			'alternativeUrls' => $alternativeUrls
		]);
	}
	public function thank_report(){
		$locale = App::getLocale();

        $routes = AlternativeUrlService::generateReplyRoutes('thank-you-write-report/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view("message",[
			'header' => trans("questionnaire.thank_you_report_header"),
			'message' => trans("questionnaire.thank_you_report_message"),
			'alternativeUrls' => $alternativeUrls
		]);
	}

	public function brif(Request $request)
	{
		$locale = App::getLocale();

        $questionnaire = Questionnaire::where([
            ['lang', $locale],
            ['type_id',5]
        ])->first();

		$base = Questionnaire::where([
			['lang', 'ru'],
			['type_id',5]
		])->first();

		if(empty($questionnaire)){
			abort(404);
		}

        $questions = Question::with(['translate','options.translate'])->where([
            ['isHide', 0],
            ['lang', 'ru'],
            ['parent', 0],
            ['questionnaire_id', $base->id],
        ])->orderBy('sort')->get();

		$title = str_replace(':page_name:',$questionnaire->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = str_replace(':page_name:',$questionnaire->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $project->preview_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

        $routes = AlternativeUrlService::generateReplyRoutes('partner/brif/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('questionnaire.brif',[
			'questionnaire' => $questionnaire,
			'base' => $base,
			'questions' => $questions,
			'locale' => $locale,
			'alternativeUrls' => $alternativeUrls
		]);
	}

    public function brifSend(Request $request)
    {
        $base = Questionnaire::where([
            ['lang', 'ru'],
            ['type_id',5]
        ])->first();

        $questions = Question::with(['options'])->where([
            ['isHide', 0],
            ['lang', 'ru'],
            ['parent', 0],
            ['questionnaire_id', $base->id],
        ])->orderBy('sort')->get();

        $answers = "";

        foreach ($questions as $question){
            switch ($question->type_id){
                case 1:
                case 2:
                case 8:
                case 10:
                    if($request->input('question_'.$question->id) != "")
                    {
                        $answers.= "<strong>$question->name:</strong> ".$request->input('question_' . $question->id)."<br>";
                    }
                    break;
                case 3:
                case 5:
                    if($request->has('question_'.$question->id)){
                        if($request->input('question_'.$question->id) != ""){
                            $answers.= "<strong>$question->name:</strong> ";

                            $currentQuestion = $question->options->where('id',$request->input('question_'.$question->id))->first();
                            if($currentQuestion->type_id == 9){
                                $answers.= $request->input('question_'.$currentQuestion->id);
                            }else{
                                $answers.= $currentQuestion->name;
                            }

                            $answers.= "<br>";
                        }
                    }
                    break;
                case 4:{
                    if($request->has('question_'.$question->id))
                        $answers.= "<strong>$question->name:</strong> ";
                        $i = 0;
                        foreach ($request->input('question_'.$question->id) as $key => $value){
                            if($i > 0){
                                $answers.= ", ";
                            }

                            $i++;

                            $val = $request->input('question_'.$question->id)[$key];
                            $currentQuestion = $question->options->where('id',$val)->first();
                            if($currentQuestion->type_id == 9){
                                $answers.= $request->input('question_'.$currentQuestion->id);
                            }else{
                                $answers.= $currentQuestion->name;
                            }

                        }
                    $answers.= "<br>";
                    break;
                }

            }
        }

        Mail::to("influence@burda.ua")->send(new BrifNotificationMail($answers));

        $responce = [
            'status' => 'ok',
            'route' => route('partner.brif_thanks'),
        ];

        return \Response::json($responce);
	}


    public function thanksBrif(){
        $locale = App::getLocale();

        $routes = AlternativeUrlService::generateReplyRoutes('partner/brif/thanks/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

        return view("message",[
            'header' => trans("page_message.brif_header"),
            'message' => trans("page_message.brif_message"),
            'alternativeUrls' => $alternativeUrls
        ]);
    }
}
