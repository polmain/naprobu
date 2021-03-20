<div class="modal fade" id="comment_sends" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('review.comment_success_header')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    @lang('review.comment_success_text')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.close')</button>
            </div>
        </div>
    </div>
</div>