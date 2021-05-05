<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 31.01.2019
 * Time: 10:52
 */

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;

// todo this interface do not need
interface iAdminController
{
	public function all();
	public function new();
	public function create(Request $request);
	public function edit(Request $request, $model_id);
	public function save(Request $request, $model_id);
	public function delete($model_id);
	public function hide($model_id);
	public function show($model_id);

}
