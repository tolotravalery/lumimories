<div id="agrandir-photo" class="modal" tabindex="-1" aria-labelledby="light-candleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @for($i = 0; $i<count($mesPhotos);$i++)
                <div class="mySlides">
                    <span class="close cursor right-30"><i class="fa fa-1x fa-thumbs-up"></i></span>
                    <span class="close cursor" onclick="closeModal()"><i class="fa fa-1x fa-close"></i> </span>
                    <div class="numbertext">{{ $i+1 }} / {{ count($mesPhotos) }}</div>
                    <img src="{{ asset($mesPhotos[$i]->image) }}" alt="{{ $mesPhotos[$i]->profil->user->email }}" style="width:100%">
                </div>
            @endfor
            <div class="caption-container">
                <p class="margin-bottom-10" id="caption-container-1"></p>
                <p class="margin-bottom-10" id="caption-container-2"></p>
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
    </div>
</div>