<div class="sort-block">
    <select name="review_sort" id="review_sort" onchange="top.location=this.value">
        <option value="{{Request::url()}}" {{Request::has('orderBy')?'':'selected'}}>@lang('review.sort_new')</option>
        <option value="{{Request::url()}}?orderBy=date_asc" {{Request::has('orderBy')? (Request::input('orderBy')=='date_asc'?'selected':''): ''}}>@lang('review.sort_old')</option>
        <option value="{{Request::url()}}?orderBy=popular" {{Request::has('orderBy')? (Request::input('orderBy')=='popular'?'selected':''): ''}}>@lang('review.sort_popular')</option>
        <option value="{{Request::url()}}?orderBy=user_asc" {{Request::has('orderBy')? (Request::input('orderBy')=='user'?'selected':''): ''}}>@lang('review.sort_user')</option>
    </select>
</div>