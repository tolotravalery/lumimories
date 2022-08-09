<div class="modal fade" id="modal-explication">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">Explication</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-12">
                        @for($i = 1; $i<4;$i++)
                            <p>pargraphe {{ $i }}</p>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-candle btn-anecdote" data-dismiss="modal">
                    {{ __('website.i-understood') }}
                </button>
            </div>
        </div>
    </div>
</div>
