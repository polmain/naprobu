<?php
//Artisan::call('config:cache');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* Auth routes*/




/* End Auth */

Route::group(['prefix'=>'admin','middleware'=>['admin.auth','admin.notifications']],function (){

		Route::group(['middleware'=>'role:admin'],function(){
			/* Users pages */
			Route::get('/users/moderator/', 'Admin\UsersController@moderators')->name('adm_users_moderators');
			Route::get('/users/moderator/{user_id}/log/', 'Admin\UsersController@moderatorLogs');
			Route::get('/users/new/', 'Admin\UsersController@new')->name('adm_users_new');
			Route::post('/users/new/', 'Admin\UsersController@createUser')->name('adm_users_new_create');
			Route::get('/users/hide/{user_id}/', 'Admin\UsersController@hide');
			Route::get('/users/show/{user_id}/', 'Admin\UsersController@show');

			Route::get('/users/export/', 'Admin\UsersController@export')->name('adm_users_export');
			Route::get('/users/export_table/', 'Admin\UsersController@exportTable')->name('adm_users_export_table');
			Route::post('/users/export/', 'Admin\UsersController@exportGenerate')->name('adm_users_export_generate');
			/* End User Pages */

			/* Projects pages */
			Route::get('/project/', 'Admin\Project\ProjectController@all')->name('adm_project');
			Route::get('/project/new/', 'Admin\Project\ProjectController@new')->name('adm_project_new');
			Route::post('/project/new/', 'Admin\Project\ProjectController@create')->name('adm_project_create');
			Route::get('/project/edit/{project_id}/', 'Admin\Project\ProjectController@edit')->name('adm_project_edit');
			Route::post('/project/edit/{project_id}/', 'Admin\Project\ProjectController@save')->name('adm_project_save');
			Route::get('/project/delete/{project_id}/', 'Admin\Project\ProjectController@delete')->name('adm_project_delete');
			Route::get('/project/hide/{project_id}/', 'Admin\Project\ProjectController@hide');
			Route::get('/project/show/{project_id}/', 'Admin\Project\ProjectController@show');

			Route::get('/project/pdf/{project_id}/', 'Admin\Project\ProjectController@pdf')->name('adm_project_pdf');

			Route::get('/project/valid-url/{project_id}/', 'Admin\Project\ProjectController@validURL')->name('adm_project_valid_url');
			/* End Projects pages */

			/* Bloggers project pages */

			Route::get('/project/blogger/', 'Admin\Project\BloggerController@all')->name('adm_project_blogger');
			Route::get('/project/blogger/{project_id}/add-member/', 'Admin\Project\BloggerController@findMembers')->name('adm_project_blogger_add_member');
			Route::get('/project/blogger/find-bloggers/', 'Admin\Project\BloggerController@findBloggers')->name('adm_project_blogger_find_bloggers');
			Route::post('/project/blogger/{project_id}/add-member/', 'Admin\Project\BloggerController@addMember')->name('adm_project_blogger_save_add_member');
			Route::get('/project/blogger/{project_id}/view-member/', 'Admin\Project\BloggerController@viewMembers')->name('adm_project_blogger_view_member');
			Route::post('/project/blogger/{project_id}/export-member/', 'Admin\Project\BloggerController@exportMembers')->name('adm_project_blogger_export_member');
			Route::post('/project/blogger/edit-member/{member_id}/', 'Admin\Project\BloggerController@editMembers')->name('adm_project_blogger_edit_member');


			Route::get('/project/blogger/{project_id}/post/', 'Admin\Project\BloggerPostController@all')->name('adm_project_blogger_post');
			Route::post('/project/blogger/{project_id}/post/create/', 'Admin\Project\BloggerPostController@create')->name('adm_project_blogger_post_create');

			Route::get('/project/post/delete/{post_id}/', 'Admin\Project\BloggerPostController@delete')->name('adm_project_blogger_post_delete');
			Route::get('/project/post/hide/{post_id}/', 'Admin\Project\BloggerPostController@hide');
			Route::get('/project/post/show/{post_id}/', 'Admin\Project\BloggerPostController@show');

			/* End Bloggers project pages */

			/* Project Subpages */

			Route::get('/project/subpages/', 'Admin\Project\SubpageController@all')->name('adm_project_subpage');
			Route::get('/project/subpages/new/', 'Admin\Project\SubpageController@new')->name('adm_project_subpage_new');
			Route::post('/project/subpages/new/', 'Admin\Project\SubpageController@create')->name('adm_project_subpage_create');
			Route::get('/project/subpages/edit/{subpage_id}/', 'Admin\Project\SubpageController@edit')->name('adm_project_subpage_edit');
			Route::post('/project/subpages/edit/{subpage_id}/', 'Admin\Project\SubpageController@save')->name('adm_project_subpage_save');
			Route::get('/project/subpages/delete/{subpage_id}/', 'Admin\Project\SubpageController@delete')->name('adm_project_subpage_delete');
			Route::get('/project/subpages/hide/{subpage_id}/', 'Admin\Project\SubpageController@hide');
			Route::get('/project/subpages/show/{subpage_id}/', 'Admin\Project\SubpageController@show');

			Route::get('/project/{project_id}/subpages', 'Admin\Project\SubpageController@project')->where(['project_id' => '[0-9]+'])->name('adm_project_subpage_project');

			Route::get('/project/subpages/valid-url/{subpage_id}/', 'Admin\Project\SubpageController@validURL')->name('adm_project_subpage_valid_url');
			/* End Project Subpages */

			/* Project Category */
			Route::get('/project/category/', 'Admin\Project\CategoryController@all')->name('adm_project_category');
			Route::get('/project/category/new', 'Admin\Project\CategoryController@new')->name('adm_project_category_new');
			Route::post('/project/category/new', 'Admin\Project\CategoryController@create')->name('adm_project_category_create');
			Route::get('/project/category/edit/{project_category_id}/', 'Admin\Project\CategoryController@edit')->name('adm_project_category_edit');
			Route::post('/project/category/edit/{project_category_id}/', 'Admin\Project\CategoryController@save')->name('adm_project_category_save');
			Route::get('/project/category/delete/{project_category_id}/', 'Admin\Project\CategoryController@delete')->name('adm_project_category_delete');
			Route::get('/project/category/hide/{project_category_id}/', 'Admin\Project\CategoryController@hide');
			Route::get('/project/category/show/{project_category_id}/', 'Admin\Project\CategoryController@show');

			Route::get('/project/{category_id}/', 'Admin\Project\ProjectController@category')->where(['category_id' => '[0-9]+'])->name('adm_project_allCategory');
			/* End Project Category */

			/* Project Messages */

			Route::get('/project/{project_id}/messages', 'Admin\Project\MessageController@all')->where(['project_id' => '[0-9]+'])->name('adm_project_message');
			Route::get('/project/{project_id}/messages/new/', 'Admin\Project\MessageController@new')->where(['project_id' => '[0-9]+'])->name('adm_project_message_new');
			Route::post('/project/messages/new/', 'Admin\Project\MessageController@create')->name('adm_project_message_create');
			Route::get('/project/messages/edit/{subpage_id}/', 'Admin\Project\MessageController@edit')->name('adm_project_message_edit');
			Route::post('/project/messages/edit/{subpage_id}/', 'Admin\Project\MessageController@save')->name('adm_project_message_save');
			Route::get('/project/messages/delete/{subpage_id}/', 'Admin\Project\MessageController@delete')->name('adm_project_message_delete');
			Route::get('/project/messages/hide/{subpage_id}/', 'Admin\Project\MessageController@hide');
			Route::get('/project/messages/show/{subpage_id}/', 'Admin\Project\MessageController@show');

			/* End Project Messages */

			/* Project Links */

			Route::get('/project/{project_id}/links', 'Admin\Project\LinkController@all')->where(['project_id' => '[0-9]+'])->name('adm_project_links');
			Route::get('/project/{project_id}/links/new/', 'Admin\Project\LinkController@new')->where(['project_id' => '[0-9]+'])->name('adm_project_links_new');
			Route::post('/project/links/new/', 'Admin\Project\LinkController@create')->name('adm_project_links_create');
			Route::get('/project/links/edit/{link_id}/', 'Admin\Project\LinkController@edit')->name('adm_project_links_edit');
			Route::post('/project/links/edit/{link_id}/', 'Admin\Project\LinkController@save')->name('adm_project_links_save');
			Route::get('/project/links/delete/{link_id}/', 'Admin\Project\LinkController@delete')->name('adm_project_links_delete');
			Route::get('/project/links/hide/{link_id}/', 'Admin\Project\LinkController@hide');
			Route::get('/project/links/show/{link_id}/', 'Admin\Project\LinkController@show');

			/* End project Links */

			/* Questionnaire */
			Route::get('/questionnaire/', 'Admin\QuestionnaireController@all')->name('adm_questionnaire');
			Route::get('/questionnaire/ajax', 'Admin\QuestionnaireController@all_ajax')->name('adm_questionnaire_ajax');
			Route::get('/questionnaire/new/', 'Admin\QuestionnaireController@new')->name('adm_questionnaire_new');
			Route::post('/questionnaire/new/', 'Admin\QuestionnaireController@create')->name('adm_questionnaire_create');
			Route::get('/questionnaire/edit/{questionnaire_id}/', 'Admin\QuestionnaireController@edit')->name('adm_questionnaire_edit');
			Route::post('/questionnaire/edit/{questionnaire_id}/', 'Admin\QuestionnaireController@save')->name('adm_questionnaire_save');
			Route::get('/questionnaire/copy/{questionnaire_id}/', 'Admin\QuestionnaireController@copy')->name('adm_questionnaire_copy');
			Route::get('/questionnaire/delete/{question_id}/', 'Admin\QuestionnaireController@delete')->name('adm_questionnaire_delete');
			Route::get('/questionnaire/hide/{questionnaire_id}/', 'Admin\QuestionnaireController@hide');
			Route::get('/questionnaire/show/{questionnaire_id}/', 'Admin\QuestionnaireController@show');

			Route::get('/questionnaire/statistics/{questionnaire_id}/', 'Admin\QuestionnaireController@statistics')->name('adm_questionnaire_statistics');
			Route::get('/questionnaire/pdf/{questionnaire_id}/', 'Admin\QuestionnaireController@pdf')->name('adm_questionnaire_pdf');
			Route::get('/questionnaire/excel/{questionnaire_id}/', 'Admin\QuestionnaireController@getExcel')->name('adm_questionnaire_excel');
			Route::get('/questionnaire/excel-registration/{questionnaire_id}/', 'Admin\QuestionnaireController@getExcelWithRegistration')->name('adm_questionnaire_excel_registration');

			Route::get('/questionnaire/{project_id}', 'Admin\QuestionnaireController@project')->where(['project_id' => '[0-9]+'])->name('adm_questionnaire_project');

			Route::get('/questionnaire-question/delete/{questionnaireQuestion_id}/', 'Admin\QuestionnaireController@deleteQuestion');
			/* End Questionnaire */

			/* Question */
			Route::get('/questionnaire/questions/ajax/{questionnaire}', 'Admin\QuestionController@ajax')->name('adm_question_ajax');
			Route::get('/questionnaire/questions/ajax/{questionnaire}/copy', 'Admin\QuestionController@ajax_copy')->name('adm_question_ajax_copy');
			Route::get('/questionnaire/questions/', 'Admin\QuestionController@all')->name('adm_question');
			Route::get('/questionnaire/{questionnaire_id}/questions/new/', 'Admin\QuestionController@new')->name('adm_question_new');
			Route::post('/questionnaire/{questionnaire_id}/questions/new/', 'Admin\QuestionController@create')->name('adm_question_create');
			//Route::get('/questionnaire/questions/edit/{question_id}/', 'Admin\QuestionController@edit')->name('adm_question_edit');
			//Route::post('/questionnaire/questions/edit/{question_id}/', 'Admin\QuestionController@save')->name('adm_question_save');
			Route::get('/questionnaire/questions/delete/{question_id}/', 'Admin\QuestionController@delete')->name('adm_question_delete');
			Route::get('/questionnaire/questions/hide/{question_id}/', 'Admin\QuestionController@hide');
			Route::get('/questionnaire/questions/show/{question_id}/', 'Admin\QuestionController@show');

			Route::get('/questionnaire/questions/find/', 'Admin\QuestionController@find')->name('adm_question_find');
			Route::get('/questionnaire/questions/find/{id}', 'Admin\QuestionController@find_options')->name('adm_question_find_options');

			Route::get('/questionnaire/questions/{question_id}/', 'Admin\QuestionController@edit')->name('adm_question_edit');
			Route::post('/questionnaire/questions/{question_id}/', 'Admin\QuestionController@save')->name('adm_question_save');
			/* End Question */

			/* Pages */

			Route::get('/page/', 'Admin\PageController@all')->name('adm_page');
			Route::get('/page/new/', 'Admin\PageController@new')->name('adm_page_new');
			Route::post('/page/new/', 'Admin\PageController@create')->name('adm_page_create');
			Route::get('/page/edit/{page_id}/', 'Admin\PageController@edit')->name('adm_page_edit');
			Route::post('/page/edit/{page_id}/', 'Admin\PageController@save')->name('adm_page_save');
			Route::get('/page/delete/{page_id}/', 'Admin\PageController@delete')->name('adm_page_delete');
			Route::get('/page/hide/{page_id}/', 'Admin\PageController@hide');
			Route::get('/page/show/{page_id}/', 'Admin\PageController@show');

			Route::get('/page/valid-url/', 'Admin\PageController@validURL')->name('adm_page_url');

			/* End Pages */

			/* Brand */

			Route::get('/brand/', 'Admin\BrandController@all')->name('adm_brand');
			Route::get('/brand/new/', 'Admin\BrandController@new')->name('adm_brand_new');
			Route::post('/brand/new/', 'Admin\BrandController@create')->name('adm_brand_create');
			Route::get('/brand/edit/{brand_id}/', 'Admin\BrandController@edit')->name('adm_brand_edit');
			Route::post('/brand/edit/{brand_id}/', 'Admin\BrandController@save')->name('adm_brand_save');
			Route::get('/brand/delete/{brand_id}/', 'Admin\BrandController@delete')->name('adm_brand_delete');
			Route::get('/brand/hide/{brand_id}/', 'Admin\BrandController@hide');
			Route::get('/brand/show/{brand_id}/', 'Admin\BrandController@show');

			/* End Brand */

			/* Blog */

			Route::get('/blog/', 'Admin\Blog\BlogController@all')->name('adm_post');
			Route::get('/blog/new/', 'Admin\Blog\BlogController@new')->name('adm_post_new');
			Route::post('/blog/new/', 'Admin\Blog\BlogController@create')->name('adm_post_create');
			Route::get('/blog/edit/{page_id}/', 'Admin\Blog\BlogController@edit')->name('adm_post_edit');
			Route::post('/blog/edit/{page_id}/', 'Admin\Blog\BlogController@save')->name('adm_post_save');
			Route::get('/blog/delete/{page_id}/', 'Admin\Blog\BlogController@delete')->name('adm_post_delete');
			Route::get('/blog/hide/{page_id}/', 'Admin\Blog\BlogController@hide');
			Route::get('/blog/show/{page_id}/', 'Admin\Blog\BlogController@show');

			Route::get('/blog/valid-url/{page_id}/', 'Admin\Blog\BlogController@validURL')->name('adm_post_valid_url');

			Route::get('/blog/tag/', 'Admin\Blog\TagController@all')->name('adm_post_tag');
			Route::get('/blog/tag/ajax/', 'Admin\Blog\TagController@all_ajax')->name('adm_post_tag_ajax');
			Route::post('/blog/tag/create/', 'Admin\Blog\TagController@create')->name('adm_post_tag_create');
			Route::get('/blog/tag/delete/{tag_id}', 'Admin\Blog\TagController@delete')->name('adm_post_tag_delete');
			Route::get('/blog/tag/find/', 'Admin\Blog\TagController@find')->name('adm_post_tag_find');

			/* End Blog */


			/* Faq */

			Route::get('/faq/', 'Admin\FaqController@categories')->name('adm_faq');
			Route::get('/faq/new/', 'Admin\FaqController@new')->name('adm_faq_new');
			Route::post('/faq/new/', 'Admin\FaqController@create')->name('adm_faq_create');
			Route::get('/faq/{id}/', 'Admin\FaqController@edit')->name('adm_faq_edit');
			Route::post('/faq/{id}/', 'Admin\FaqController@save')->name('adm_faq_save');
			Route::get('/faq/delete/{id}/', 'Admin\FaqController@delete')->name('adm_faq_delete');
			Route::get('/faq/hide/{id}/', 'Admin\FaqController@hide');
			Route::get('/faq/show/{id}/', 'Admin\FaqController@show');

			/* End Faq */

			/* Faq */

			Route::get('/menu/', 'Admin\MenuController@list')->name('adm_menu');
			Route::get('/menu/{id}/', 'Admin\MenuController@edit')->name('adm_menu_edit');
			Route::post('/menu/{id}/', 'Admin\MenuController@save')->name('adm_menu_save');

			/* End Faq */


			/* Settings */
			Route::get('/settings/seo/', 'Admin\Settings\SEOSettingController@settings')->name('adm_seo_settings');
			Route::post('/settings/seo/', 'Admin\Settings\SEOSettingController@settings_save')->name('adm_seo_settings_save');



			Route::get('/settings/user_rating/', 'Admin\Settings\UserRatingController@settings')->name('adm_user_rating_settings');
			Route::post('/settings/user_rating/', 'Admin\Settings\UserRatingController@settings_save')->name('adm_user_rating_settings_save');
			Route::get('/settings/user_rating/generate/', 'Admin\Settings\UserRatingController@generator')->name('adm_user_rating_generate');
			Route::get('/settings/user_rating/recalc/', 'Admin\Settings\UserRatingController@usersRatingRecalc')->name('adm_user_rating_recalc');


			Route::get('/settings/language_settings/', 'Admin\Settings\LanguageController@settings')->name('adm_language_settings');
			Route::post('/settings/language_settings/', 'Admin\Settings\LanguageController@settings_save')->name('adm_language_settings_save');
			/* End Settings */

			/* ----------------- IMPORT DB ----------------------- */
			Route::get('/db/import/projects', 'Admin\ImportDBController@project');
			Route::get('/db/import/projectSubpage', 'Admin\ImportDBController@projectSubpage');
			Route::get('/db/import/user', 'Admin\ImportDBController@user');
			Route::get('/db/import/userAnketData', 'Admin\ImportDBController@userAnketData');
			Route::get('/db/import/userRole', 'Admin\ImportDBController@userRoles');
			Route::get('/db/import/review', 'Admin\ImportDBController@review');
			Route::get('/db/import/comment', 'Admin\ImportDBController@comment');
			Route::get('/db/import/project_request', 'Admin\ImportDBController@project_request');
			Route::get('/db/import/questionnaire_question', 'Admin\ImportDBController@questionnaire_question');
			Route::get('/db/import/answers', 'Admin\ImportDBController@answers');
			Route::get('/db/import/changeRequestIdToAnswers', 'Admin\ImportDBController@changeRequestIdToAnswers');
			Route::get('/db/import/addCompliteStatusForRequest', 'Admin\ImportDBController@addCompliteStatusForRequest');
			/* ----------------- END IMPORT DB ----------------------- */
		});
	Route::group(['middleware'=>'role:moderator'],function(){

		Route::get('/', 'Admin\DashboardController@home')->name('adm_home');
		Route::get('/redirectsGenerator/', 'Admin\DashboardController@redirectsGenerator');
		Route::get('/userNewPasswords/', 'Admin\DashboardController@userNewPasswords');

		Route::get('/project/find', 'Admin\Project\ProjectController@find')->name('adm_project_find');
		Route::get('/project/subpages/find', 'Admin\Project\SubpageController@find')->name('adm_project_subpage_find');

		/* Users pages */
		Route::get('/users/', 'Admin\UsersController@all')->name('adm_users');
		Route::get('/users/ajax/', 'Admin\UsersController@all_ajax')->name('adm_users_ajax');
		Route::get('/users/find/', 'Admin\UsersController@find')->name('adm_users_find');
		Route::get('/users/bloger/', 'Admin\UsersController@bloger')->name('adm_users_bloger');
		Route::get('/users/expert/', 'Admin\UsersController@expert')->name('adm_users_expert');
		Route::get('/users/profile/', 'Admin\UsersController@profile')->name('adm_users_profile');
		Route::post('/users/edit/{user_id}/', 'Admin\UsersController@saveUser')->name('adm_users_save');
		Route::get('/users/history/{user_id}/', 'Admin\Settings\UserRatingController@ajax_history')->name('adm_users_history');
		Route::get('/users/edit/{user_id}/', 'Admin\UsersController@edit')->name('adm_users_edit');
        Route::get('/users/delete/{user_id}/', 'Admin\UsersController@delete');

		Route::get('/users/statuses-log/', 'Admin\UsersController@statusesLog')->name('adm_users_statuses_log');
		Route::get('/users/statuses-log/ajax/', 'Admin\UsersController@statusesLog_ajax')->name('adm_users_statuses_log_ajax');

		Route::post('/users/change-status/{user_id}/', 'Admin\UsersController@change_status')->name('adm_change_status');
		Route::get('/users/end-status/{status_id}/', 'Admin\UsersController@end_status')->name('adm_end_status');


		Route::post('/users/delete-ratting/{user_id}/', 'Admin\UsersController@delete_ratting')->name('adm_delete_ratting');
		Route::post('/users/add-ratting/{user_id}/', 'Admin\UsersController@add_ratting')->name('adm_add_ratting');
		/* End User Pages */

		/* Bloggers pages */

		Route::get('/users/blogger/', 'Admin\BloggerUserController@all')->name('adm_users_bloger');
		Route::get('/users/blogger/ajax/', 'Admin\BloggerUserController@all_ajax')->name('adm_users_bloger_ajax');
		Route::get('/users/blogger/new/', 'Admin\BloggerUserController@new')->name('adm_blogger_new');
		Route::post('/users/blogger/new/', 'Admin\BloggerUserController@create')->name('adm_blogger_create');
		Route::get('/users/blogger/edit/{blogger_id}/', 'Admin\BloggerUserController@edit')->name('adm_blogger_edit');
		Route::post('/users/blogger/edit/{blogger_id}/', 'Admin\BloggerUserController@save')->name('adm_blogger_save');
		Route::get('/users/blogger/delete/{blogger_id}/', 'Admin\BloggerUserController@delete')->name('adm_blogger_delete');
		Route::get('/users/blogger/find/', 'Admin\BloggerUserController@find')->name('adm_users_blogger_find');


		Route::get('/users/blogger/city/', 'Admin\Blogger\CityController@all')->name('adm_users_blogger_city');
		Route::get('/users/blogger/city/new/', 'Admin\Blogger\CityController@new')->name('adm_blogger_city_new');
		Route::post('/users/blogger/city/new/', 'Admin\Blogger\CityController@create')->name('adm_blogger_city_create');
		Route::get('/users/blogger/city/edit/{city_id}/', 'Admin\Blogger\CityController@edit')->name('adm_blogger_city_edit');
		Route::post('/users/blogger/city/edit/{city_id}/', 'Admin\Blogger\CityController@save')->name('adm_blogger_city_save');
		Route::get('/users/blogger/city/find/', 'Admin\Blogger\CityController@find')->name('adm_users_blogger_city_find');

		Route::get('/users/blogger/category/', 'Admin\Blogger\CategoryController@all')->name('adm_users_blogger_category');
		Route::post('/users/blogger/category/new/', 'Admin\Blogger\CategoryController@create')->name('adm_blogger_category_create');
		Route::post('/users/blogger/category/edit/{city_id}/', 'Admin\Blogger\CategoryController@save')->name('adm_blogger_category_save');
		Route::get('/users/blogger/category/find/', 'Admin\Blogger\CategoryController@find')->name('adm_users_blogger_category_find');

		Route::get('/users/blogger/subject/', 'Admin\Blogger\SubjectController@all')->name('adm_users_blogger_subject');
		Route::post('/users/blogger/subject/new/', 'Admin\Blogger\SubjectController@create')->name('adm_blogger_subject_create');
		Route::post('/users/blogger/subject/edit/{city_id}/', 'Admin\Blogger\SubjectController@save')->name('adm_blogger_subject_save');
		Route::get('/users/blogger/subject/find/', 'Admin\Blogger\SubjectController@find')->name('adm_users_blogger_subject_find');

		Route::post('/users/blogger/import/', 'Admin\BloggerUserController@importExcel')->name('adm_blogger_importExcel');

		/* End Bloggers pages */

		/* Project Request Pages */

		Route::get('/project/requests', 'Admin\Project\RequestController@all')->name('adm_project_request');
		Route::get('/project/requests/{project_id}', 'Admin\Project\RequestController@project_all')->where(['project_id' => '[0-9]+'])->name('adm_select_project_request');
		Route::get('/user/requests/{user_id}', 'Admin\Project\RequestController@user_all')->where(['user_id' => '[0-9]+'])->name('adm_user_request');
		Route::get('/project/requests/ajax', 'Admin\Project\RequestController@all_ajax')->name('adm_project_request_ajax');
		Route::get('/project/requests/{project_id}/ajax', 'Admin\Project\RequestController@project_all_ajax')->where(['project_id' => '[0-9]+'])->name('adm_select_project_request_ajax');
		Route::get('/project/requests/edit/{request_id}/', 'Admin\Project\RequestController@edit')->where(['request_id' => '[0-9]+'])->name('adm_project_request_edit');
		Route::post('/project/requests/edit/{request_id}/', 'Admin\Project\RequestController@save')->where(['request_id' => '[0-9]+'])->name('adm_project_request_save');
		Route::post('/project/requests/shipping/{request_id}/', 'Admin\Project\RequestController@sendShipping')->where(['request_id' => '[0-9]+'])->name('adm_project_request_shipping');

		Route::get('/project/requests/delete/{request_id}/', 'Admin\Project\RequestController@delete')->where(['request_id' => '[0-9]+'])->name('adm_project_request_delete');
		Route::get('/project/requests/hide/{request_id}/', 'Admin\Project\RequestController@hide')->where(['request_id' => '[0-9]+'])->name('adm_project_request_hide');
		Route::get('/project/requests/show/{request_id}/', 'Admin\Project\RequestController@show')->where(['request_id' => '[0-9]+'])->name('adm_project_request_show');
		Route::get('/project/requests/status/{status_id}/{request_id}/', 'Admin\Project\RequestController@status')->name('adm_project_request_status');

		/* End Project Request Pages */

		/* Blog pages */

		Route::get('/blog/comments/', 'Admin\Blog\CommentController@all')->name('adm_post_comment');
		Route::get('/blog/comments/ajax/', 'Admin\Blog\CommentController@all_ajax')->name('adm_post_comment_ajax');
		Route::get('/blog/comments/edit/{comment_id}/', 'Admin\Blog\CommentController@edit')->name('adm_post_comment_edit');
		Route::post('/blog/comments/edit/{comment_id}/', 'Admin\Blog\CommentController@save')->name('adm_post_comment_save');
		Route::get('/blog/comments/delete/{comment_id}/', 'Admin\Blog\CommentController@delete')->name('adm_post_comment_delete');
		Route::get('/blog/comments/hide/{comment_id}/', 'Admin\Blog\CommentController@hide');
		Route::get('/blog/comments/show/{comment_id}/', 'Admin\Blog\CommentController@show');
		Route::get('/blog/comments/status/{status_id}/{comment_id}/', 'Admin\Blog\CommentController@changeStatus')->where(['comment_id' => '[0-9]+','status_id' => '[2-3]']);

		/* End Blog pages */

		/* Reviews pages */
		Route::get('/reviews', 'Admin\ReviewController@all')->name('adm_review');
		Route::get('/reviews/ajax', 'Admin\ReviewController@all_ajax')->name('adm_review_ajax');
		Route::get('/reviews/new/', 'Admin\ReviewController@new')->name('adm_review_new');
		Route::post('/reviews/new/', 'Admin\ReviewController@create')->name('adm_review_create');
		Route::get('/reviews/edit/{review_id}/', 'Admin\ReviewController@edit')->name('adm_review_edit');
		Route::post('/reviews/edit/{review_id}/', 'Admin\ReviewController@save')->name('adm_review_save');
		Route::get('/reviews/delete/{review_id}/', 'Admin\ReviewController@delete')->name('adm_review_delete');
		Route::get('/reviews/hide/{review_id}/', 'Admin\ReviewController@hide');
		Route::get('/reviews/show/{review_id}/', 'Admin\ReviewController@show');
		Route::get('/reviews/status/{status_id}/{review_id}/', 'Admin\ReviewController@changeStatus')->where(['status_id' => '[1-9]']);
		/* Reviews pages */

		/* Comments pages */
		Route::get('/reviews/comments', 'Admin\CommentController@all')->name('adm_comment');
		Route::get('/reviews/comments/ajax', 'Admin\CommentController@all_ajax')->name('adm_comment_ajax');
		Route::get('/reviews/comments/edit/{comment_id}/', 'Admin\CommentController@edit')->name('adm_comment_edit');
		Route::post('/reviews/comments/edit/{comment_id}/', 'Admin\CommentController@save')->name('adm_comment_save');
		Route::get('/reviews/comments/delete/{comment_id}/', 'Admin\CommentController@delete')->name('adm_comment_delete');
		Route::get('/reviews/comments/hide/{comment_id}/', 'Admin\CommentController@hide');
		Route::get('/reviews/comments/show/{comment_id}/', 'Admin\CommentController@show');
		Route::get('/reviews/comments/status/{status_id}/{comment_id}/', 'Admin\CommentController@changeStatus')->where(['comment_id' => '[0-9]+','status_id' => '[1-9]']);
		/* Comments pages */

		/* Messages pages */
		Route::get('/feedback/', 'Admin\Message\FeedbackController@all')->name('adm_feedback');
		Route::get('/feedback/ajax/', 'Admin\Message\FeedbackController@all_ajax')->name('adm_feedback_ajax');
		Route::get('/feedback/{id}', 'Admin\Message\FeedbackController@view')->name('adm_feedback_view');
		Route::get('/feedback/delete/{id}/', 'Admin\Message\FeedbackController@delete')->name('adm_feedback_delete');
		/* End Messages pages */

		/* Presents pages */
		Route::get('/user/present/', 'Admin\Message\PresentController@all')->name('adm_present');
		Route::get('/user/present/ajax/', 'Admin\Message\PresentController@all_ajax')->name('adm_present_ajax');
		Route::get('/user/present/delete/{id}', 'Admin\Message\PresentController@delete')->name('adm_present_delete');
		Route::get('/user/present/{id}', 'Admin\Message\PresentController@view')->name('adm_present_view');
		Route::post('/user/present/{id}/send/', 'Admin\Message\PresentController@send')->name('adm_present_send');
		/* End Presents pages */
	});
});


Route::post('/review/share/','ReviewController@share')->name('review.share');
Route::post('/projects/share/','ProjectController@share')->name('project.share');
/* Front */
/*Route::group(['middleware' => 'ban'],function(){*/
	Route::group(['middleware'=>'auth'],function(){
		Route::group(['middleware'=>'role:user'],function(){
			Route::post('/review/comment/create/{review_id}/','ReviewController@createComment')->name('review.comment.create');
			Route::post('/review/like/{review_id}/','ReviewController@like')->name('review.like');
			Route::post('/review/create/{subpage}/','ReviewController@create')->name('review.create');
			Route::post('/review/edit/','ReviewController@save')->name('review.edit');
			Route::post('/review/addimage/','ReviewController@addImage')->name('review.addimage');

			Route::post('/cabinet/present/','UserController@getPresent')->name('cabinet.present');

			Route::post('/blog/comment/create/{post_id}/','BlogController@createComment')->name('blog.comment.create');

			Route::get('/notification/get/','NotificationController@get')->name('user.notification.get');
			Route::post('/notofication/onview/','NotificationController@onView');

			Route::post('/cabinet/data-save/','UserController@dataSave')->name('user.data_save');
			Route::post('/cabinet/setting-save/','UserController@settingSave')->name('user.setting_save');
		});
	});

	Route::get('/admin/login',['as' => 'admin.login','uses' => 'Admin\Auth\LoginController@showLoginForm']);
	Route::post('/admin/login',['uses' => 'Admin\Auth\LoginController@login']);
	Route::get('/admin/logout',['as' => 'admin.logout','uses' => 'Admin\Auth\LoginController@logout']);

	Route::post('/feedback/send/', 'MainController@feedback')->name('feedback');
	Route::post('/partner/send/', 'MainController@partnerSend')->name('partner.send');
	Route::get('/livesearch/','SearchController@live');
	Route::get('/ref/{id}','UserController@ref')->name('user.ref');

	Route::post('/project/password/','ProjectController@password')->name('project.password');
	Route::post('/blog/password/','BlogController@password')->name('blog.password');
    Route::post('/project/conversionLink/{id}/','ProjectController@conversionLink')->name('project.conversion_link');

	Route::prefix(App\Http\Middleware\LocaleMiddleware::getLocale())->middleware('locale')->group(function($lang = 'ua') {
        Route::prefix(App\Http\Middleware\InternationalMiddleware::getInternational())->group(function($lang = 'ua'){
            Route::get('/', 'MainController@home')->name('home');

            Route::get('/about/', 'MainController@about')->name('about');
            Route::get('/faq/','MainController@faq')->name('faq');
            Route::get('/contact/','MainController@contact')->name('contact');
            Route::get('/partner/','MainController@partner')->name('partner');
            Route::get('/partner/brif','QuestionnaireController@brif')->name('partner.brif');
            Route::post('/partner/brif','QuestionnaireController@brifSend')->name('partner.brif_send');
            Route::get('/partner/brif/thanks','QuestionnaireController@thanksBrif')->name('partner.brif_thanks');

            Route::get('/projects/', 'ProjectController@all')->name('project');
            Route::get('/projects/{url}/','ProjectController@lavel2')->name('project.level2');
            Route::get('/projects/{project_url}/{subpage}/','ProjectController@subpage')->where(['project_url' => '^((?!questionnaire).)*'])->name('project.subpage');

            Route::get('/reviews/','ReviewController@all')->name('review');
            Route::get('/reviews/{url}/','ReviewController@lavel2')->name('review.level2');

            Route::get('/blog/', 'BlogController@all')->name('blog');
            Route::get('/blog/{url}/','BlogController@lavel2')->name('blog.level2');

            Route::get('/archive/','ArchiveController@index')->name('archive');

            Route::get('/registration/','Auth\RegisterController@showRegistrationForm')->name('registration');

            Route::get('/search/','SearchController@index')->name('search');

            Route::get('/user/{id}/','UserController@profile')->name('profile');
            Route::get('/user/{id}/comment/','UserController@profileComment')->name('profile.comment');

            Route::group(['middleware'=>'auth'],function(){
                Route::get('/projects/questionnaire/{id}/','QuestionnaireController@questionnaire')->name('project.questionnaire');

                Route::group(['middleware'=>'role:expert'],function(){

                    Route::post('/project/questionnaire/{id}/','QuestionnaireController@questionnaireSend')->name('project.questionnaire.send');
                    Route::get('/thank-you-registration/','QuestionnaireController@thank_regiter')->name('project.questionnaire.thank.regiter');
                    Route::get('/thank-you-write-report/','QuestionnaireController@thank_report')->name('project.questionnaire.thank.report');
                });
                Route::group(['middleware'=>'role:bloger'],function(){

                });
                Route::group(['middleware'=>'role:user'],function(){
                    Route::get('/cabinet/','UserController@index')->name('user.cabinet');
                    Route::get('/cabinet/project/','UserController@project')->name('user.project');
                    Route::get('/cabinet/review/','UserController@review')->name('user.review');
                    Route::get('/cabinet/rating/','UserController@rating')->name('user.rating');
                    Route::get('/cabinet/notification/','UserController@notification')->name('user.notification');
                    Route::get('/cabinet/setting/','UserController@setting')->name('user.setting');

                    Route::get('/ban/','UserController@ban')->name('user.ban');
                });
            });
            Auth::routes();
            Route::get('/ref/{id}/','UserController@ref')->name('user.ref');
            Route::get('/password/reset/','Auth\ResetPasswordController@showEmailForm')->name('password.request');
            Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


            Route::post('/register/','Auth\RegisterController@register')->name('register');
        });
	});

	/*Route::prefix('amp')->group(function($lang = 'ua') {
		Route::prefix(App\Http\Middleware\LocaleMiddleware::getLocale())->middleware('locale')->group(function($lang = 'ua') {
			Route::get('/project/', 'ProjectController@allAMP')->name('amp.project');
		});
	});*/
	/*Route::get('parse-city','UserController@parseCountry');
	Route::get('parse-region','UserController@parceRegion');
	Route::get('parse-city/{id}','UserController@parseCity');*/

		Route::get('/clear-cache', function() {
		Artisan::call('route:clear');
		Artisan::call('view:clear');
		Artisan::call('config:clear');
		return "Cache is cleared";
	});


	Route::get('/login/facebook/','Auth\FacebookController@redirectToProvider');
	Route::get('/login/facebook/callback/','Auth\FacebookController@handleProviderCallback');

	Route::get('/login/instagram/','Auth\InstagramController@redirectToProvider')->name('instagram.user');
	Route::get('/login/instagram/callback/','Auth\InstagramController@handleProviderCallback');

	Route::get('/auth/login/', 'Auth\ModalAjaxController@login');
	Route::get('/auth/register/', 'Auth\ModalAjaxController@register');
	Route::post('/register/expert/', 'Auth\ExpertRegisterController@register')->name('register.expert');


	Route::get('/check-name/','Auth\ModalAjaxController@isNameRegister');
	Route::get('/check-email/','Auth\ModalAjaxController@isEmailRegister');
	Route::get('/check-name-register/','UserController@isNameRegister');
	Route::get('/check-email-register/','UserController@isEmailRegister');

/*});*/

Route::get('setlocale/{lang}', function ($lang) {

	$referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
	$parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

	//разбиваем на массив по разделителю
	$segments = explode('/', $parse_url);

	//Если URL (где нажали на переключение языка) содержал корректную метку языка
	if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {
		unset($segments[1]); //удаляем метку
	}

	//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
	if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
		array_splice($segments, 1, 0, $lang);
	}else{
		$lang = "";
	}

	//формируем полный URL
	$url = Request::root().'/'.$lang;//implode("/", $segments);

	//если были еще GET-параметры - добавляем их
	if(parse_url($referer, PHP_URL_QUERY)){
		$url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
	}

	return redirect($url); //Перенаправляем назад на ту же страницу
	//return redirect()->route('home'); //Перенаправляем назад на ту же страницу

})->name('setlocale');

Route::prefix(App\Http\Middleware\LocaleMiddleware::getLocale())->middleware('locale')->group(function($lang = 'ua') {
	Route::get('/verify/{user_id}/{verify_code}/','Auth\EmailVerification@verify')->name('auth.verify');
	Route::group(['middleware'=>'auth'],function(){
		Route::group(['middleware'=>'role:user'],function(){
			Route::get('/ban/','UserController@ban')->name('user.ban');
		});
	});
});

Route::get('sitemap.xml', 'ArchiveController@sitemap');

Route::get('/get-region/','UserController@getRegion')->name('registration.region');
Route::get('/get-city/','UserController@getCity')->name('registration.city');

Route::prefix(App\Http\Middleware\LocaleMiddleware::getLocale())->middleware('locale')->group(function($lang = 'ua') {
	Route::get('/{url}/', 'MainController@simple')->name('simple');
});


