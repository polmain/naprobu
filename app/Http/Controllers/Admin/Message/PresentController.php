<?php

namespace App\Http\Controllers\Admin\Message;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Model\User\UserPresents;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\Present;

use App\Library\Users\ModeratorLogs;
use App\Library\Users\Notification;
use App\Library\Queries\QueryBuilder;

use SEO;
use AdminPageData;

class PresentController extends Controller
{
	public function all()
	{
		SEO::setTitle('Запросы на подарки');
		AdminPageData::setPageName('Запросы на подарки');
		AdminPageData::addBreadcrumbLevel('Запросы на подарки');

		return view('admin.message.present.all');
	}

	public function all_ajax(Request $request){
		$filter = QueryBuilder::getFilter($request);
		$presents = UserPresents::where($filter);

		return datatables()->eloquent($presents)
			->addColumn('user', function (UserPresents $present) {
				return $present->user->name;
			})
			->addColumn('rang', function (UserPresents $present) {
				return $present->rang->name;
			})
			->toJson();
	}

	public function view($id)
	{
		$present = UserPresents::find($id);

		SEO::setTitle($present->user->name);
		AdminPageData::setPageName($present->user->name);
		AdminPageData::addBreadcrumbLevel('Запросы на подарки','present');
		AdminPageData::addBreadcrumbLevel($present->user->name);

		return view('admin.message.present.view',compact('present'));
	}

	public function send(Request $request, $id){
		$present = UserPresents::find($id);

		Mail::to($present->user)->send(new Present($request));
		Notification::send( 'present', $present->user, 1);

		$present->isSent = 1;
		$present->email_text = $request->text;
		$present->save();

		ModeratorLogs::addLog("Отправил подарок пользователю: ".$present->user->name);

		return redirect()->route('adm_present');
	}

	public function delete($id){
		UserPresents::destroy($id);

		return 'ok';
	}
}
