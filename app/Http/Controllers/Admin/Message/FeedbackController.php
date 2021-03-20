<?php

namespace App\Http\Controllers\Admin\Message;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Queries\QueryBuilder;
use App\Library\Users\ModeratorLogs;

use App\Model\Feedback;
use SEO;
use AdminPageData;

class FeedbackController extends Controller
{


	public function all()
	{
		SEO::setTitle('Сообщения');
		AdminPageData::setPageName('Сообщения');
		AdminPageData::addBreadcrumbLevel('Сообщения');

		return view('admin.message.feedback.all');
	}

	public function all_ajax(Request $request){
		$filter = QueryBuilder::getFilter($request);
		$feedbaks = Feedback::where($filter);

		return datatables()->eloquent($feedbaks)->toJson();
	}

	public function view($id)
	{
		$feedback = Feedback::find($id);
		$feedback->isNew = 0;
		$feedback->save();

		ModeratorLogs::addLog("Прочитал сообщение: ".$feedback->subject);

		SEO::setTitle($feedback->subject);
		AdminPageData::setPageName($feedback->subject);
		AdminPageData::addBreadcrumbLevel('Сообщения','feedback');
		AdminPageData::addBreadcrumbLevel($feedback->subject);

		return view('admin.message.feedback.view',compact('feedback'));
	}

	public function delete($id){
		Feedback::destroy($id);
		return 'ok';
	}
}
