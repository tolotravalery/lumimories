<?php
Route::get('/route-clear', function() {
    $status = Artisan::call('route:clear');
    return '<h1>Route cleared</h1>';
});
Route::get('/cache-clear', function() {
    $status = Artisan::call('cache:clear');
    return '<h1>Cache cleared</h1>';
});
Route::get('/config-cache', function() {
    $status = Artisan::call('config:cache');
    return '<h1>Configurations cache cleared</h1>';
});
Route::get('/config-clear', function() {
    $status = Artisan::call('config:clear');
    return '<h1>Configuration cache cleared!</h1>';
});
Route::get('/clear-compiled', function() {
    $status = Artisan::call('clear-compiled');
    return '<h1>Configuration clear compiled!</h1>';
});
Route::get('/view-clear', function() {
    $status = Artisan::call('view:clear');
    return '<h1>Configuration view:cache!</h1>';
});
Route::get('/','FrontController@index');
Route::get('/test','FrontController@testImage');
Route::get('/test-image-text','FrontController@testImageAvecText');
Route::get('/detail/{id}','FrontController@detail');
Route::get('/detail-anecdote/{id}','FrontController@detailAnecdote');
Route::get('/ajout-profil','FrontController@ajoutProfil');
Route::get('/ok-profil/{id}', 'FrontController@okProfil');
Route::get('/ok', 'FrontController@ok');
Route::post('/ajout-profil','FrontController@soumettreProfil',['verify' => true])->name('soumettre-profil');
Route::post('/ajout-anecdote','FrontController@soumettreAnecdote')->name('soumettre-anecdote');
Route::post('/ajout-photos','FrontController@soumettrePhotos')->name('soumettre-photos');
Route::post('/ajout-monument','FrontController@soumettreMonument')->name('soumettre-monument');
Route::post('/allumer-bougie','FrontController@allumerBougie');
Route::post('/dedicace','FrontController@dedicace');
Route::post('/allumer-bougie-general','FrontController@allumerBougieGeneral');
Route::any('/rechercher','FrontController@rechercher');
Route::any('/rechercher-profil','FrontController@rechercherProfil');
Route::get('/bougie-de-memoire','FrontController@bougieDeMemoire')->name('bougie-de-memoire');
Route::get('/edit-profil/{id}','FrontController@editProfil');
Route::post('/modif-profil','FrontController@modifierProfil')->name('modifier-profil');
Route::get('/login-front/{url?}','FrontController@loginFront');
Route::get('/register-front/{url?}', 'FrontController@registerFront');
Route::post('/login-front','FrontController@loginPostFront')->name('login-front');
Route::post('/register-front','FrontController@registerPostFront')->name('register-front');
Route::post('/check-genealogie','FrontController@checkGenealogie');
Route::post('/signaler','FrontController@signaler')->name('signaler');
Route::post('/signaler-anecdote','FrontController@signalerAnecdote')->name('signaler-anecdote');
Route::get('/password-reset-front','AuthController@passWordResetFront')->name('password-reset-front');
Route::post('/send-reset-link-email','AuthController@sendResetLinkEmailFront')->name('send-reset-link-email');
Route::get('/reset-front/{token}', 'AuthController@showResetFormFront')->name('password.reset-front');
Route::get('/list-profil-decedes-aujourdhui', 'FrontController@listProfilWhoDiedNow');
Route::post('/password/reset-front', 'ResetPwdFrontController@reset')->name('password.update-front');
Route::post('/previous', 'FrontController@previous')->name('previous');
Route::post('/next', 'FrontController@next')->name('next');
Route::post('/supprimer-photo/{id}', 'FrontController@supprimerPhoto');
Route::post('/supprimer-anecdote/{id}', 'FrontController@supprimerAnectode');
Route::post('/modifier-anecdote/{id}', 'FrontController@modifierAnecdote');
Route::post('/modifier-photo/{id}', 'FrontController@modifierPhoto');
Route::post('/contact', 'FrontController@contact')->name('contact');
Route::post('/nous-contacter', 'FrontController@envoyerEmailNousContacter')->name('nous-contacter');
Route::get('/edit-biographie/{id}','FrontController@editBiographieProfil')->name('edit-biographie');
Route::post('/modifier-biographie', 'FrontController@modifierBiographie')->name('modifier-biographie');
Route::get('/edit-genealogie/{id}','FrontController@editGenealogie')->name('edit-genealogie');
Route::post('/modifier-genealogie', 'FrontController@modifierGenealogie')->name('modifier-genealogie');

//localization
Route::get('locale', 'LocalizationController@getLang')->name('getlang');
Route::get('locale/{lang}', 'LocalizationController@setLang')->name('setlang');
Route::post('/recherche-personnes','FrontController@recherchePersonnes')->name('autocomplete');
Route::post('/recherche-personnes-autre','FrontController@recherchePersonnesAutre')->name('autocompleteautre');
Route::get('/ajout-photos/{id}','FrontController@ajoutPhotos');
Route::get('/nous-contacter','FrontController@nousContacter');
Route::get('/profils-similaires','FrontController@profilsSimilaires');
Auth::routes(['verify' => true]);
Route::group(['middleware' => 'auth-front'], function () {
    Route::post('/supprimer-profil/{id}','FrontController@supprimerProfil');
    Route::post('/suivre','FrontController@suivre');
    Route::get('/mes-proches','FrontController@mesProches')->name('mes-proches');
    Route::get('/mon-compte','FrontController@monCompte')->name('mon-compte-get');
    Route::post('/mon-compte','FrontController@monComptePost')->name('mon-compte');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('profils','ProfilController');
        Route::resource('photos','PhotoController');
        Route::resource('anecdotes','AnecdoteController');
        Route::post('/check-validation','ProfilController@checkValidation');
        Route::post('/photo-check-validation','PhotoController@checkValidation');
        Route::post('/anecdote-check-validation','AnecdoteController@checkValidation');
        Route::get('/anecdotes-valides','AnecdoteController@listValides');
        Route::get('/anecdotes-invalides','AnecdoteController@listInValides');
        Route::get('/photos-valides','PhotoController@listValides');
        Route::get('/photos-invalides','PhotoController@listInValides');
        Route::post('/anecdotes-validation','AnecdoteController@validationAnecdote');
        Route::post('/photos-validation','PhotoController@validationPhoto');
        Route::post('/profil-anecdotes-validation','ProfilController@validationAnecdote');
        Route::get('/utilisateurs','UserController@list');
    });
});
Route::any('{catchall}', 'FrontController@notfound')->where('catchall', '.*');
