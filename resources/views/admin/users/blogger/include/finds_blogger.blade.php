<div class="table-responsive">
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th width="40"></th>
			<th width="40">#</th>
			<th>Название</th>
			<th>Город</th>
			<th>Категории</th>
			<th>Тематика</th>
			<th>Соц. сети</th>
			<th>Подписчики (Всего)</th>
		</tr>
	</thead>
	<tbody>
		@foreach($bloggers as $blogger)
			<tr>
				<td class="text-center">
					<label>
						<input type="checkbox" class="minimal-red checkbox-item" id="item-{{$blogger->id}}" name="blogger_id[]" value="{{$blogger->id}}" checked="checked">
					</label>
				</td>
				<td class="text-center"><a href="{{route('adm_blogger_edit',[$blogger->id])}}" target="_blank">{{$blogger->id}}</a></td>
				<td><a href="{{route('adm_blogger_edit',[$blogger->id])}}" target="_blank">{{$blogger->name}}</a></td>
				<td>{{$blogger->city->name}}</td>
				<td>
					@php
						$categories= '';
						foreach ($blogger->categories as $category){
							$categories.= $category->name.', ';
						}
						$categories = substr($categories,0,-2);
					@endphp
					{{$categories}}
				</td>
				<td>
					@php
						$subjects = '';
						foreach ($blogger->subjects as $subject){
							$subjects.= $subject->name.', ';
						}
						$subjects = substr($subjects,0,-2);
					@endphp
					{{$subjects}}
				</td>
				<td>
					@php
						$socialnetwork = '';
						if($blogger->instagram_link){
							$socialnetwork .= 'instagram, ';
						}
						if($blogger->facebook_link){
							$socialnetwork .= 'facebook, ';
						}
						if($blogger->youtube_link){
							$socialnetwork .= 'YouTube, ';
						}
						$socialnetwork = substr($socialnetwork,0,-2);
					@endphp
					{{$socialnetwork}}
				</td>
				<td>
					@php
						$socialnetwork = 0;
						if($blogger->instagram_subscriber){
							$socialnetwork += intval($blogger->instagram_subscriber);
						}
						if($blogger->facebook_subscriber){
							$socialnetwork += intval($blogger->facebook_subscriber);
						}
						if($blogger->youtube_subscriber){
							$socialnetwork += intval($blogger->youtube_subscriber);
						}
					@endphp
					{{$socialnetwork}}
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
</div>