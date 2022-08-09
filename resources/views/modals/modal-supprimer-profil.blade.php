<div class="modal fade" id="modal-supprimer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('website.delete-profile') }} <span id="nom-profil"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">{{ __('website.cancel') }}</button>

                <form id="supprimer-form" method="POST">
                    @csrf
                    <button class="btn btn-danger" type="submit">{{ __('website.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
