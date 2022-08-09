<div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">{{ __('website.share-in') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <a class="btn" id="facebook-share" onclick="facebook()">Facebook <i class="fa fa-1x fa-facebook-square"></i></a>
                <div class="separation"></div>
                <a class="btn" id="whatsapp-share" onclick="whatsapp()">Whatsapp <i class="fa fa-1x fa-whatsapp"></i></a>
                <div class="separation"></div>
                <a class="btn" id="twitter-share" onclick="twitter()">Twitter <i class="fa fa-1x fa-twitter-square"></i></a>
            </div>
        </div>
    </div>
</div>
