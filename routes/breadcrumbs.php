<?php

// Home
Breadcrumbs::for('home', function ($trail) {
	$trail->push('naprobu', route('home'));
});
/* Project */
Breadcrumbs::for('projects', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([['url','projects'],['lang',$lang]])->first();
	$trail->push($page->name, route('project'));
});

Breadcrumbs::for('category', function ($trail,$category) {
	$trail->parent('projects');
	$lang = \App::getLocale();
	/*if($lang == 'ua'){
		$category = $category->translate;
	}*/
	$trail->push($category->name, route('project.level2',['url'=>$category->url]));
});

Breadcrumbs::for('project_password', function ($trail,$name,$project) {
	$trail->parent('projects');
	$trail->push($name, route('project.level2',['url'=>$project->url]));
});

Breadcrumbs::for('project_single', function ($trail,$category,$project) {
	$trail->parent('category',$category);
	$trail->push($project->name, route('project.level2',['url'=>$project->url]));
});

Breadcrumbs::for('project_subpage', function ($trail,$category,$project,$subpage) {
	$trail->parent('project_single',$category,$project);
	$trail->push($subpage->name, route('project.subpage',['project_url'=>$project->url,'subpage'=>$subpage->name]));
});

Breadcrumbs::for('project_questionnaire', function ($trail,$category,$project,$questionnaire) {
	$trail->parent('project_single',$category,$project);
	$lang = \App::getLocale();
	$name = ($lang == "ru")? $questionnaire->name : $questionnaire->translate->name;
	$trail->push($name, route('project.questionnaire',['id' => $questionnaire->id]));
});
/* End Project */

/* Review */

Breadcrumbs::for('review', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([['url','reviews'],['lang',$lang]])->first();
	$trail->push($page->name, route('review'));
});

Breadcrumbs::for('review_category', function ($trail,$category) {
	$trail->parent('review');
	$trail->push($category->name, route('review.level2',['url'=>$category->url]));
});

Breadcrumbs::for('review_single', function ($trail,$name,$id) {
	$trail->parent('review');
	$trail->push($name, route('review.level2',['url'=>$id]));
});

/* End Review */



/* Blog */
Breadcrumbs::for('blog', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([['url','blog'],['lang',$lang]])->first();
	$trail->push($page->name, route('blog'));
});

Breadcrumbs::for('blog_user', function ($trail,$user) {
	$trail->parent('blog');
	$trail->push($user->name, route('blog.level2',['url'=>$user->name]));
});

Breadcrumbs::for('blog_category', function ($trail,$category) {
	$trail->parent('blog');
	$trail->push($category->name, route('blog.level2',['url'=>$category->url]));
});

Breadcrumbs::for('blog_news', function ($trail) {
	$trail->parent('blog');
	$trail->push(trans('blog.news'), route('blog.level2',['url'=>'news']));
});

Breadcrumbs::for('blog_single', function ($trail,$category,$post) {
	$trail->parent('blog_category',$category);
	$trail->push($post->name, route('blog.level2',['url'=>$post->url]));
});

Breadcrumbs::for('blog_single_news', function ($trail,$post) {
	$trail->parent('blog_news');
	$trail->push($post->name, route('blog.level2',['url'=>$post->url]));
});

Breadcrumbs::for('blog_password', function ($trail,$name,$blog) {
	$trail->parent('blog');
	$trail->push($name, route('blog.level2',['url'=>$blog->url]));
});
/* End Blog */


/* Simple page */

Breadcrumbs::for('about', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','about'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('about'));
});

Breadcrumbs::for('partner', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','partner'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('partner'));
});

Breadcrumbs::for('partner.brif', function ($trail,$questionnaire) {
	$trail->parent('partner');
	$trail->push($questionnaire->name, route('partner.brif'));
});

Breadcrumbs::for('error', function ($trail, $name) {
	$trail->parent('home');
	$trail->push($name, "/");
});

Breadcrumbs::for('contact', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','contact'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('contact'));
});

Breadcrumbs::for('registration', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','registration'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('registration'));
});

Breadcrumbs::for('password_recover', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','password/reset'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('password.request'));
});

Breadcrumbs::for('login', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','login'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('login'));
});

Breadcrumbs::for('faq', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','faq'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('faq'));
});

Breadcrumbs::for('archive', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','archive'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('archive'));
});

Breadcrumbs::for('search', function ($trail) {
	$trail->parent('home');
	$lang = \App::getLocale();
	$page = App\Model\Page::where([
		['url','search'],
		['lang',$lang]
	])->first();
	$trail->push($page->name, route('search'));
});

/* End Simple page */

/* User pages */

Breadcrumbs::for('profile', function ($trail, $user) {
	$trail->parent('home');
	$trail->push($user->name, route('profile',[$user->id]));
});

Breadcrumbs::for('profile_comment', function ($trail, $user) {
	$trail->parent('profile',$user);
	$trail->push(trans('profile.comment'), route('profile.comment',[$user->id]));
});

Breadcrumbs::for('user', function ($trail) {
	$trail->parent('home');
	$trail->push(\Illuminate\Support\Facades\Auth::user()->name, route('user.cabinet'));
});

Breadcrumbs::for('user_project', function ($trail) {
	$trail->parent('user');
	$lang = \App::getLocale();
	$trail->push(trans('user.menu_project'), route('user.project'));
});

Breadcrumbs::for('user_review', function ($trail) {
	$trail->parent('user');
	$lang = \App::getLocale();
	$trail->push(trans('user.menu_review'), route('user.review'));
});

Breadcrumbs::for('user_rating', function ($trail) {
	$trail->parent('user');
	$lang = \App::getLocale();
	$trail->push(trans('user.menu_rating'), route('user.rating'));
});

Breadcrumbs::for('user_notification', function ($trail) {
	$trail->parent('user');
	$lang = \App::getLocale();
	$trail->push(trans('user.menu_notification'), route('user.notification'));
});

Breadcrumbs::for('user_setting', function ($trail) {
	$trail->parent('user');
	$lang = \App::getLocale();
	$trail->push(trans('user.menu_setting'), route('user.setting'));
});

/* User pages */