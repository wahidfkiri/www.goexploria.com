<?php

header('Access-Control-Allow-Origin: *');

/*
* |--------------------------------------------------------------------------
* | Routes File
* |--------------------------------------------------------------------------
* |
* | Here is where you will register all of the routes in an application.
* | It's a breeze. Simply tell Laravel the URIs it should respond to
* | and give it the controller to call when that URI is requested.
* |
*/


/*
* |--------------------------------------------------------------------------
* | Application Routes
* |--------------------------------------------------------------------------
* |
* | This route group applies the "web" middleware group to every route
* | it contains. The "web" middleware group is defined in your HTTP
* | kernel and includes session state, CSRF protection, and more.
* |
*/

// DEBUG
#dd( Request()->fullUrl() );

Route::group(['middleware' => ['web']], function () {
    if (config('app.env') == "prod") {
        if (strstr(Request::server('HTTP_HOST'), preg_replace('/(www|dev)\./i', '', (string) config('app.domain')))) {
            // Homepage
            Route::get('/', 'Controller@homepage')->name('index');
        }
    } else {
        // Hors production la route est enregistrée quel que soit l'hôte.
        Route::get('/', 'Controller@homepage')->name('index');
    }

    Route::get('/generatebigsitemap', 'SitemapController@index')->name('sitemap');
    // Nom distinct de 'sitemap' : deux routes portaient le même nom, ce qui
    // rendait `route('sitemap')` ambigu et faisait échouer `route:cache`.
    Route::get('/sitemap.xml', 'SitemapController@company')->name('sitemap.company');
    Route::get('/robots.txt', 'SitemapController@robots')->name('robots');

    Route::get('/test/mail', 'Admin\MainController@test')->name('test.mail');

    Route::get('/test', function () {
        return view('front.test');
    })->name('test');

    Route::get('/mail', function () {
        return view('mail.mail');
    })->name('mail.test');

    Route::get('/404', function () {
        return view('errors.404');
    })->name('error');

    Route::get('/503', function () {
        return view('errors.503');
    })->name('denied');

    /** Barre de recherche */
    Route::group(['namespace' => 'SearchBar', 'prefix' => '/search'], function () {

        Route::get('/{name}', 'SearchBarController@find')->name('search');
        Route::get('/company/{name}', 'SearchBarController@findCompany')->name('search.company.name');

        /** Recherche sur les lieux */
        Route::group(['prefix' => '/location'], function () {
            Route::get('/location/{name}', 'SearchBarController@findLocation')->name('search.location.name');
            Route::get('/parent/{countryCode}/{name}', 'SearchBarController@findLocationByCountry')->name('search.location.parent');
            Route::get('/{location}/child/{name}', 'SearchBarController@findLocationChildrens')->name('search.location.child');
        });
    });

    /** AJAX */
    Route::group(['prefix' => '/ajax'], function () {
        Route::post('/getlocationsbysearch', 'Admin\LocationController@getlocationsbysearch')->name('ajax.getlocationsbysearch');
        Route::post('/getcountriesbysearch', 'Admin\CountryController@getcountriesbysearch')->name('ajax.getcountriesbysearch');
        Route::post('/getcompaniesbysearch', 'Admin\CompanyController@getcompaniesbysearch')->name('ajax.getcompaniesbysearch');
        Route::post('/savemediadetails', 'Admin\LocationGalleryController@saveEditMedia')->name('ajax.saveeditmedia');
    });

    /** Megamenu */
    /*
    Route::group([ 'prefix' => '/menu'], function () {
    Route::get('/continents', 'FrontTemplateController@getContinents')->name('continents.list');
    Route::get('/countries/{continent}', 'FrontTemplateController@getCountriesByContinent')->name('countries.list');
    Route::get('/tourism/{category}', 'FrontTemplateController@getTourismActivities')->name('tourism.list');
    Route::get('/tourism/', 'FrontTemplateController@getTourismActivitiesCategories')->name('tourism.categories.list');

    Route::get('/business/{category}', 'FrontTemplateController@getBusinessActivities')->name('business.list');
    Route::get('/business/', 'FrontTemplateController@getBusinessActivitiesCategories')->name('business.categories.list');
    Route::get('/activities/{activity}/country', 'FrontTemplateController@getCoutriesByActivity')->name('countries.activities.list');
    Route::get('/activities/{activity}/countries/{country}/provinces','LocationController@getLevel1ByCountryActivity')
    ->name('province.country.activities.list');});
    */

    /** Accès disponibles en visiteur uniquement */
    Route::group(['middleware' => ['guest'], 'prefix' => 'auth'], function () {

        /** Gestion du compte */
        Route::group(['prefix' => 'user'], function () {
            Route::post('register', 'MembresControlleur@store')->name('account.register.post');
            Route::get('register', 'MembresControlleur@create')->name('account.register');
            Route::get('activate/{token}', 'MembresControlleur@activate')->name('account.activate');
            Route::get('activate', 'MembresControlleur@getActivationForm')->name('account.activate.form');
            Route::post('activate', 'MembresControlleur@resend')->name('account.activate.resend');

            // Authentication routes...
            Route::post('login', 'Auth\AuthController@postLogin')->name('auth.login.post');
            Route::get('login', 'Auth\AuthController@getLogin')->name('auth.login');
        });

        /** Récupération du mot de passe */
        Route::group(['prefix' => 'password'], function () {
            // Password reset link request routes...
            Route::get('email', 'Auth\PasswordController@getResetForm')->name('auth.reset.pass');
            Route::post('email', 'Auth\PasswordController@postResetForm')->name('auth.reset.pass.post');

            // Password reset routes...
            Route::get('reset/{token}', 'Auth\PasswordController@getReset')->name('auth.validate.pass');
        });
    });

    /** Utilisateurs authentifiés seulement */
    Route::group(['middleware' => ['auth'], 'prefix' => 'account'], function () {
        /** Gestion du compte */
        Route::get('edit/password', 'AccountController@editPass')->name('account.change.pass');
        Route::post('edit/password', 'AccountController@updatePass')->name('account.change.pass.post');
        Route::post('edit', 'AccountController@update')->name('account.edit.post');
        Route::get('edit', 'AccountController@edit')->name('account.edit');
        Route::get('profil', 'AccountController@profil')->name('account.profil');
        Route::get('logout', 'Auth\AuthController@getLogout')->name('auth.logout');
        Route::get('newsletter/resign', 'MembresControlleur@getNewsletterForm')->name('account.newsletter');
        Route::post('newsletter/resign', 'MembresControlleur@newsletterResign')->name('account.newsletter.post');

        // On gère les inscriptions aux newsletters
        Route::group(['prefix' => 'subscription'], function () {
            Route::get('/index', 'AccountController@subscription')->name('account.subscription.search');
            Route::get('/delete/{company}', 'AccountController@subscriptionDelete')->name('account.subscription.delete');
            Route::post('/add', 'AccountController@subscriptionAdd')->name('account.subscription.add.post');
        });
    });

    /** Sites web */
    Route::group(['prefix' => 'site'], function () {

        /** Pour accédé au site en mode dev ? */
        Route::group(['prefix' => '/{site_slug}'], function () {
            Route::get('/', 'SiteController@dev')->name('front.site.index');
            Route::get('/page/{page_slug}', 'SiteController@dev')->name('front.site.page');
        });

        /** Slug */
        Route::group(['middleware' => 'location.slug', 'prefix' => '{slug}'], function () {
            Route::get('/', 'LocationController@getFromSlug')->name('front.location')->where('slug', '(.*)');
        });

        Route::get('/', 'LocationController@continent')->name('front.world');
    });

    /** Page des lieux */
    Route::group(['prefix' => 'location'], function () {

        // Récupération inversée via l'id
        Route::group(['prefix' => '/id/{id}'], function () {
            Route::get('/country', 'LocationController@getCountryByID')->name('front.country.id');
            Route::get('/continent', 'LocationController@getContinentByID')->name('front.continent.id');
            Route::get('/', 'LocationController@getLocationByID')->name('front.location.id');
        });

        /** Slug */
        Route::group(['middleware' => 'location.slug', 'prefix' => '{slug}'], function () {
            Route::get('/', 'LocationController@getFromSlug')->name('front.location')->where('slug', '(.*)');
        });

        Route::get('/', 'LocationController@continent')->name('front.world');
    });

    /** Page des activitées - Explorez */
    Route::group(['prefix' => 'activity'], function () {
        Route::get('/{activity}/{slug}', 'ActivityController@search')->name('front.activity.search');
        Route::get('api/{activity}/{location}/companies', 'ActivityController@ajaxSearch')->name('front.activity.ajaxSearch');
        Route::get('/{activity}/country/{country}/{location?}', 'ActivityController@getFromCountryAndActivity')->name('front.activity.country.details');
    });

    /** Page des entreprises */
    Route::group(['prefix' => '/company'], function () {

        // Via l'id
        Route::group(['prefix' => '/c/{company}'], function () {
            Route::get('/newsletter/resign/m/{email}', 'CompanyController@resign')->name('front.company.newsletter.resign');
            Route::post('/newsletter/subscribe', 'CompanyController@subscribe')->name('front.company.newsletter.subscribe.post');
            Route::get('/', 'CompanyController@getByID')->name('front.company.id');
        });

        /** Dépendant du slug */
        Route::group(['middleware' => 'company.slug', 'prefix' => '{slug}'], function () {
            Route::get('/newsletter/subscribe', 'CompanyController@subscribeForm')->name('front.company.newsletter.subscribe')->where('slug', '([0-9]+)/(.*)');
            // Form newsletter sur la page entreprise,dans sidebar
            Route::post('/newsletter/subscribe', 'CompanyController@subscribeForm')->name('front.company.newsletter.subscribe')->where('slug', '([0-9]+)/(.*)');
            Route::get('/', 'CompanyController@get')->name('front.company')->where('slug', '([0-9]+)/(.*)');
        });


        //Route::get('/print/{id}/{name}', 'CompanyController@printForm')->name('front.company.print')->where('slug', '([0-9]+)/(.*)');
        Route::post('/print/{id}/{name}', 'CompanyController@printForm')->name('front.company.print')->where('slug', '([0-9]+)/(.*)');
    });

    // Liste des RDV du jour, accès disponible en visiteur et connecté
    Route::get('company/meetings/{company}/printer/{start}/{end}', 'Admin\CompanyMeetingController@printer')->name('company.meeting.printer');


    /****************************
     * Backend
     **************************/
    Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'access'], 'prefix' => '/admin'], function () {
        Route::get('/', 'MainController@dashboard')->name('admin');

        Route::get('/test', 'MainController@testback')->name('test');

        /** Gestion des pages d'un pays  */
        Route::group(['middleware' => 'country.code', 'prefix' => 'country/page/mod/{countryCode}'], function () {

            Route::get('/search', 'CountryPageController@search')->name('country.page.search');
            Route::get('/add', 'CountryPageController@add')->name('country.page.add');
            Route::post('/add', 'CountryPageController@register')->name('country.page.add.post');

            // Pour une page
            Route::group(['prefix' => '{id}'], function () {
                Route::get('/edit', 'CountryPageController@edit')->name('country.page.edit');
                Route::post('/edit', 'CountryPageController@update')->name('country.page.edit.post');
                Route::get('/edit/visibility', 'CountryPageController@visibility')->name('country.page.visibility');
                Route::get('/delete', 'CountryPageController@delete')->name('country.page.delete');
            });
        });

        /** Gestion des pays */
        Route::group(['prefix' => '/country/mod'], function () {
            Route::get('/add', 'CountryController@add')->name('country.add');
            Route::post('/add', 'CountryController@register')->name('country.add.post');
            Route::get('/index', 'CountryController@index')->name('country.search');
            Route::post('/enable', 'CountryController@activate')->name('country.activate');

            // Pour un pays
            Route::group(['prefix' => '{id}'], function () {
                Route::get('/edit', 'CountryController@edit')->name('country.edit');
                Route::post('/edit', 'CountryController@update')->name('country.edit.post');
                Route::get('/delete', 'CountryController@delete')->name('country.delete');
                Route::get('/disable', 'CountryController@disable')->name('country.disable');
            });
        });

        /** Gestion des continents */
        Route::group(['prefix' => '/continent/mod'], function () {
            Route::get('/add', 'ContinentController@add')->name('continent.add');
            Route::post('/add', 'ContinentController@register')->name('continent.add.post');
            Route::get('/index', 'ContinentController@index')->name('continent.search');

            // Pour un continent
            Route::group(['prefix' => '{id}'], function () {
                Route::get('/edit', 'ContinentController@edit')->name('continent.edit');
                Route::post('/edit', 'ContinentController@update')->name('continent.edit.post');
                Route::get('/delete', 'ContinentController@delete')->name('continent.delete');
            });
        });

        /** Gestion des newsletters */
        Route::group(['prefix' => '/newsletter/mod'], function () {
            Route::get('/add', 'NewsletterController@add')->name('newsletter.add');
            Route::post('/add', 'NewsletterController@register')->name('newsletter.add.post');
            Route::get('/index', 'NewsletterController@index')->name('newsletter.search');
            Route::get('/history/index', 'NewsletterController@history')->name('newsletter.history');

            // Pour une newsletter
            Route::group(['prefix' => '{id}'], function () {
                Route::get('/edit', 'NewsletterController@edit')->name('newsletter.edit');
                Route::post('/edit', 'NewsletterController@update')->name('newsletter.edit.post');
                Route::get('/delete', 'NewsletterController@delete')->name('newsletter.delete');
                Route::get('/send', 'NewsletterController@send')->name('newsletter.send');
            });
        });

        /** Gestion des utilisateurs */
        Route::group(['middleware' => 'admin', 'prefix' => '/user'], function () {
            // Le module à proprement parler
            Route::group(['prefix' => '/mod'], function () {
                Route::get('/add', 'UserController@add')->name('user.add');
                Route::post('/add', 'UserController@register')->name('user.add.post');
                Route::get('/index', 'UserController@index')->name('user.search');
                Route::get('/search', 'UserController@clear')->name('user.search.clear');
                Route::post('/search', 'UserController@search')->name('user.search.post');
                Route::get('/edit/wait', 'UserController@wait')->name('user.waiting');

                // Pour un utilisateur
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit/statut', 'UserController@statut')->name('user.statut');
                    Route::get('/edit/password', 'UserController@password')->name('user.pass');
                    Route::post('/edit/passord', 'UserController@passwordUpdate')->name('user.pass.post');
                    Route::get('/edit/rang', 'UserController@rang')->name('user.rang');
                    Route::get('/details', 'UserController@details')->name('user.details');
                    Route::get('/delete', 'UserController@delete')->name('user.delete');
                });
            });

            Route::group(['prefix' => '/type/mod'], function () {
                Route::get('/add', 'UserTypeController@add')->name('user.type.add');
                Route::post('/add', 'UserTypeController@register')->name('user.type.add.post');
                Route::get('/search', 'UserTypeController@index')->name('user.type.search');

                // Pour un type d'utilisateur
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/delete', 'UserTypeController@delete')->name('user.type.delete');
                    Route::get('/edit', 'UserTypeController@edit')->name('user.type.edit');
                    Route::post('/edit', 'UserTypeController@update')->name('user.type.edit.post');
                    Route::get('/access/edit', 'UserTypeController@access')->name('user.type.access');
                    Route::post('/access/edit', 'UserTypeController@accessChange')->name('user.type.access.post');
                });
            });
        });

        // Configuration
        Route::group(['middleware' => 'admin', 'prefix' => '/config'], function () {
            // Gestion des modules
            Route::group(['prefix' => '/module/mod'], function () {
                Route::get('/add', 'ModuleController@add')->name('module.add');
                Route::post('/add', 'ModuleController@register')->name('module.add.post');
                Route::get('/index', 'ModuleController@index')->name('module.search');

                // Pour un module
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit', 'ModuleController@edit')->name('module.edit');
                    Route::post('/edit', 'ModuleController@update')->name('module.edit.post');
                    Route::get('/delete', 'ModuleController@delete')->name('module.delete');
                });
            });
            Route::group(['prefix' => '/content'], function () {
                Route::get('/index', 'ContentController@index')->name('content.index');
                Route::post('/index', 'ContentController@index')->name('content.index');
            });
        });

        /** Gestion des lieux */
        Route::group(['prefix' => '/location'], function () {


            Route::get('/mod/map', 'LocationController@map')->name('location.map');

            /** Les lieux à proprement parler en fonction du pays */
            Route::group(['middleware' => 'country.code', 'prefix' => '/mod/{countryCode}'], function () {
                Route::get('/search/clear', 'LocationController@clear')->name('location.search.clear');
                Route::post('/search', 'LocationController@search')->name('location.search.post');
                Route::get('/search', 'LocationController@index')->name('location.search');
                Route::get('/add', 'LocationController@add')->name('location.add');
                Route::post('/add', 'LocationController@register')->name('location.add.post');

                // Pour un lieu
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit/statut', 'LocationController@statut')->name('location.statut');
                    Route::get('/delete', 'LocationController@delete')->name('location.delete');

                    /** Edition d'un lieu */
                    Route::group(['prefix' => 'edit'], function () {

                        Route::get('/infos', 'LocationController@editInfos')->name('location.edit.infos');
                        Route::post('/infos', 'LocationController@updateInfos')->name('location.edit.infos.post');

                        Route::get('/contact', 'LocationController@editContact')->name('location.edit.contact');
                        Route::post('/contact', 'LocationController@updateContact')->name('location.edit.contact.post');

                        Route::get('/hierarchie', 'LocationController@editHierarchie')->name('location.edit.hierarchie');
                        Route::post('/hierarchie', 'LocationController@updateHierarchie')->name('location.edit.hierarchie.post');


                        Route::group(['prefix' => 'contacts'], function () {
                            Route::get('/add', 'LocationContactController@add')->name('location.contact.add');
                            Route::post('/add', 'LocationContactController@register')->name('location.contact.add.post');
                            Route::get('/index', 'LocationContactController@index')->name('location.contact.search');

                            // Pour un contact
                            Route::group(['prefix' => '{contact_id}'], function () {

                                Route::get('/edit', 'LocationContactController@edit')->name('location.contact.edit');
                                Route::post('/edit', 'LocationContactController@update')->name('location.contact.edit.post');
                                Route::get('/delete', 'LocationContactController@delete')->name('location.contact.delete');
                            });
                        });

                        Route::get('/slider', 'LocationController@editSlider')->name('location.edit.slider');
                        #Route::post('/hierarchie', 'LocationController@updateHierarchie')->name('location.edit.hierarchie.post');

                        Route::get('/', 'LocationController@edit')->name('location.edit');
                    });
                });
            });

            Route::group(['prefix' => '/type/mod'], function () {

                Route::get('/map', 'LocationTypeController@map')->name('location.type.map');

                /** Les types de lieux en fonction du pays */
                Route::group(['middleware' => 'country.code', 'prefix' => '{countryCode}'], function () {

                    Route::get('/search', 'LocationTypeController@index')->name('location.type.search');
                    Route::get('/add', 'LocationTypeController@add')->name('location.type.add');
                    Route::post('/add', 'LocationTypeController@register')->name('location.type.add.post');

                    // Pour un type de lieu
                    Route::group(['prefix' => '{id}'], function () {
                        Route::get('/edit', 'LocationTypeController@edit')->name('location.type.edit');
                        Route::post('/edit', 'LocationTypeController@update')->name('location.type.edit.post');
                        Route::get('/delete', 'LocationTypeController@delete')->name('location.type.delete');
                    });
                });
            });

            /** Les pages des lieux */
            Route::group(['middleware' => 'country.code', 'prefix' => 'page/mod/{countryCode}/{location}'], function () {

                Route::get('/search', 'LocationPageController@search')->name('location.page.search');
                Route::get('/add', 'LocationPageController@add')->name('location.page.add');
                Route::post('/add', 'LocationPageController@register')->name('location.page.add.post');

                // Pour une page
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit', 'LocationPageController@edit')->name('location.page.edit');
                    Route::post('/edit', 'LocationPageController@update')->name('location.page.edit.post');
                    Route::get('/edit/visibility', 'LocationPageController@visibility')->name('location.page.visibility');
                    Route::get('/delete', 'LocationPageController@delete')->name('location.page.delete');
                });
            });
        });

        /** Les activités */
        Route::group(['prefix' => '/activity'], function () {

            /** Niveau le plus bas */
            Route::group(['prefix' => '/mod'], function () {
                Route::get('/search', 'ActivityController@index')->name('activity.search');
                Route::get('/add', 'ActivityController@add')->name('activity.add');
                Route::post('/add', 'ActivityController@register')->name('activity.add.post');

                // Pour une activité
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit', 'ActivityController@edit')->name('activity.edit');
                    Route::get('/delete', 'ActivityController@delete')->name('activity.delete');
                    Route::post('/edit', 'ActivityController@update')->name('activity.edit.post');
                });
            });

            /** Les catégories d'activités */
            Route::group(['prefix' => '/category/mod'], function () {

                Route::get('/search', 'ActivityCategoryController@index')->name('activity.category.search');
                Route::get('/add', 'ActivityCategoryController@add')->name('activity.category.add');
                Route::post('/add', 'ActivityCategoryController@register')->name('activity.category.add.post');

                // Pour une catégorie d'activité
                Route::group(['prefix' => '{id}'], function () {
                    Route::post('/edit', 'ActivityCategoryController@update')->name('activity.category.edit.post');
                    Route::get('/edit', 'ActivityCategoryController@edit')->name('activity.category.edit');
                    Route::get('/delete', 'ActivityCategoryController@delete')->name('activity.category.delete');
                });
            });
        });

        /** Les galeries */
        Route::group(['prefix' => '/gallery'], function () {

            /** Destinations */
            Route::group(['prefix' => '/mod/location'], function () {
                Route::get('/search', 'LocationGalleryController@search')->name('location.gallery.search');
                Route::get('/add', 'LocationGalleryController@add')->name('location.gallery.add');
                Route::post('/add', 'LocationGalleryController@register')->name('location.gallery.add.post');
                Route::get('/addmedia/{id}', 'LocationGalleryController@addmedia')->name('location.gallery.addmedia');
                Route::post('/addmedia', 'LocationGalleryController@registermedia')->name('location.gallery.addmedia.post');
                Route::post('/addvideo', 'LocationGalleryController@addVideo')->name('location.gallery.addvideo.post');
                Route::post('/editmedia', 'LocationGalleryController@updatemedia')->name('location.gallery.editmedia.post');
                #Route::get('/search/clear', 'LocationGalleryController@clear')->name('location.gallery.search.clear');
                Route::post('/search', 'LocationGalleryController@search')->name('location.gallery.search.post');

                // Pour une galerie
                #Route::group([ 'prefix' => '{location}/{id}'], function () {
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit', 'LocationGalleryController@edit')->name('location.gallery.edit');
                    Route::post('/edit', 'LocationGalleryController@update')->name('location.gallery.edit.post');
                    Route::get('/delete', 'LocationGalleryController@delete')->name('location.gallery.delete');
                    #Route::get('/edit/visibility', 'LocationGalleryController@visibility')->name('location.gallery.visibility');

                    # Medias
                    Route::get('/deletemedia', 'LocationGalleryController@deleteMedia')->name('location.gallery.deletemedia');
                });


            });

            /** Pays */
            Route::group(['prefix' => '/mod/pays'], function () {
                Route::get('/search', 'CountryGalleryController@search')->name('country.gallery.search');
                Route::get('/add', 'CountryGalleryController@add')->name('country.gallery.add');
                Route::post('/add', 'CountryGalleryController@register')->name('country.gallery.add.post');
                Route::get('/addmedia/{id}', 'CountryGalleryController@addmedia')->name('country.gallery.addmedia');
                Route::post('/addmedia', 'CountryGalleryController@registermedia')->name('country.gallery.addmedia.post');
                Route::post('/addvideo', 'CountryGalleryController@addVideo')->name('country.gallery.addvideo.post');
                Route::post('/editmedia', 'CountryGalleryController@updatemedia')->name('country.gallery.editmedia.post');
                #Route::get('/search/clear', 'CountryGalleryController@clear')->name('country.gallery.search.clear');
                Route::post('/search', 'CountryGalleryController@search')->name('country.gallery.search.post');

                // Pour une galerie
                #Route::group([ 'prefix' => '{location}/{id}'], function () {
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit', 'CountryGalleryController@edit')->name('country.gallery.edit');
                    Route::post('/edit', 'CountryGalleryController@update')->name('country.gallery.edit.post');
                    Route::get('/delete', 'CountryGalleryController@delete')->name('country.gallery.delete');
                    #Route::get('/edit/visibility', 'CountryGalleryController@visibility')->name('country.gallery.visibility');

                    # Medias
                    Route::get('/deletemedia', 'CountryGalleryController@deleteMedia')->name('country.gallery.deletemedia');
                });
            });

            /** Galeries établissements */
            Route::group(['prefix' => '/mod/company'], function () {
                Route::get('/search', 'CompanyGalleryController@search')->name('company.gallery.search');
                Route::get('/add', 'CompanyGalleryController@add')->name('company.gallery.add');
                Route::post('/add', 'CompanyGalleryController@register')->name('company.gallery.add.post');
                Route::get('/addmedia/{id}', 'CompanyGalleryController@addmedia')->name('company.gallery.addmedia');
                Route::post('/addmedia', 'CompanyGalleryController@registermedia')->name('company.gallery.addmedia.post');
                Route::post('/addvideo', 'CompanyGalleryController@addVideo')->name('company.gallery.addvideo.post');
                Route::post('/editmedia', 'CompanyGalleryController@updatemedia')->name('company.gallery.editmedia.post');
                #Route::get('/search/clear', 'CompanyGalleryController@clear')->name('company.gallery.search.clear');
                Route::post('/search', 'CompanyGalleryController@search')->name('company.gallery.search.post');

                // Pour une galerie
                #Route::group([ 'prefix' => '{location}/{id}'], function () {
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit', 'CompanyGalleryController@edit')->name('company.gallery.edit');
                    Route::post('/edit', 'CompanyGalleryController@update')->name('company.gallery.edit.post');
                    Route::get('/delete', 'CompanyGalleryController@delete')->name('company.gallery.delete');
                    #Route::get('/edit/visibility', 'CompanyGalleryController@visibility')->name('company.gallery.visibility');

                    # Medias
                    Route::get('/deletemedia', 'CompanyGalleryController@deleteMedia')->name('company.gallery.deletemedia');
                });
            });

        });

        Route::group(['prefix' => '/users/meetings'], function () {
            Route::get('{id}/details', 'UserMeetingController@details')->name('users.meeting.details');
            Route::get('/{id}/edit', 'UserMeetingController@edit')->name('users.meeting.edit');
            Route::post('/{id}/edit', 'UserMeetingController@update')->name('users.meeting.edit.post');
            Route::get('/add', 'UserMeetingController@add')->name('users.meeting.add');
            Route::post('/add', 'UserMeetingController@register')->name('users.meeting.add.post');
            Route::get('/index', 'UserMeetingController@index')->name('users.meeting.search');
            Route::get('/print', 'UserMeetingController@printPDF')->name('users.meeting.print');
            Route::get('/{id}/delete', 'UserMeetingController@delete')->name('users.meeting.delete');
        });

        /** Les entreprises */
        Route::group(['prefix' => '/company'], function () {

            /** Les fonctions générales */
            Route::group(['prefix' => '/mod'], function () {
                Route::get('/search', 'CompanyController@index')->name('company.search');
                Route::get('/add', 'CompanyController@add')->name('company.add');
                Route::post('/add', 'CompanyController@register')->name('company.add.post');
                Route::get('/search/clear', 'CompanyController@clear')->name('company.search.clear');
                Route::post('/search', 'CompanyController@search')->name('company.search.post');
                Route::get('/import', 'CompanyController@import')->name('company.import');
                Route::post('/import', 'CompanyController@importProcess')->name('company.import');

                //TODO: dois avoir un prefix; devrait etre dans /mod/{id}/edit
                Route::post('/editlogo', 'CompanyController@updateLogo')->name('company.edit.logo.post');
                Route::get('/deletelogo', 'CompanyController@deleteLogo')->name('company.delete.logo');
                Route::post('/editlistimage', 'CompanyController@updateListImage')->name('company.edit.list_image.post');
                Route::get('/deletelistimage', 'CompanyController@deleteListImage')->name('company.delete.list_image');

                // Pour une entreprise
                Route::group(['prefix' => '{company_id}', 'middleware' => 'company.member'], function () {
                    Route::get('/delete', 'CompanyController@delete')->name('company.delete');
                    Route::get('/followers/index', 'CompanyController@followers')->name('company.follower');
                    Route::get('/followers/remove/{email}', 'CompanyController@removeFollower')->name('company.follower.remove');
                    Route::post('/followers/remove', 'CompanyController@removeFollowerSelected')->name('company.follower.remove.selected');

                    /** Tout le backend pour les informations d'une entreprise */
                    Route::group(['prefix' => '/edit'], function () {
                        Route::get('/infos', 'CompanyController@editInfos')->name('company.edit.infos');
                        Route::post('/infos', 'CompanyController@updateInfos')->name('company.edit.infos.post');
                        Route::post('/infos/activation', 'CompanyController@updateInfosActivation')->name('company.edit.infos.activation');

                        Route::get('/achats-et-services', 'CompanyController@editAchats')->name('company.edit.achats');
                        Route::post('/achats-et-services', 'CompanyController@updateAchats')->name('company.edit.achats');

                        Route::get('/configs', 'CompanyController@editSettings')->name('company.edit.settings');
                        Route::post('/configs', 'CompanyController@updateSettings')->name('company.edit.settings.post');
                        Route::get('/configs/downloadTheme', 'CompanyController@downloadTheme')->name('company.edit.settings.gettheme');
                        Route::post('/configs/uploadTheme', 'CompanyController@uploadTheme')->name('company.edit.settings.uploadtheme');
                        Route::post('/configs/uploadCssFile', 'CompanyController@uploadCssFile')->name('company.edit.settings.uploadsitecss');
                        Route::post('/configs/ajax', 'CompanyController@updateSettingsAjax')->name('company.edit.settings.post.ajax');

                        Route::get('/location', 'CompanyController@editLocation')->name('company.edit.location');
                        Route::post('/location', 'CompanyController@updateLocation')->name('company.edit.location.post');

                        Route::get('/activities', 'CompanyController@editActivities')->name('company.edit.activity');
                        Route::post('/activities', 'CompanyController@updateActivities')->name('company.edit.activity.post');

                        Route::get('/', 'CompanyController@edit')->name('company.edit');
                    });

                    /** Les pages des établissements */
                    Route::group(['prefix' => 'page'], function () {
                        Route::get('/search', 'CompanyPageController@search')->name('company.page.search');
                        Route::get('/add', 'CompanyPageController@add')->name('company.page.add');
                        Route::post('/add', 'CompanyPageController@register')->name('company.page.add.post');

                        // Pour une page donnéee
                        Route::group(['prefix' => '{page_id}'], function () {
                            Route::get('/delete', 'CompanyPageController@delete')->name('company.page.delete');
                            Route::get('/edit/visibility', 'CompanyPageController@visibility')->name('company.page.visibility');
                            Route::get('/edit', 'CompanyPageController@edit')->name('company.page.edit');
                            Route::post('/edit', 'CompanyPageController@update')->name('company.page.edit.post');
                        });
                    });

                    /** Documents d'établissements */
                    Route::group(['prefix' => 'documents'], function () {
                        Route::get('/search', 'CompanyDocumentsController@index')->name('company.documents.list');
                        Route::post('/add', 'CompanyDocumentsController@add')->name('company.documents.add');
                        Route::get('/delete/{doc_id}', 'CompanyDocumentsController@delete')->name('company.documents.delete');
                        Route::post('/edit/{doc_id}', 'CompanyDocumentsController@edit')->name('company.documents.edit');

                        Route::get('/{doc_id}/get', 'CompanyDocumentsController@getPrivateDocument')->name('company.documents.id');
                    });

                    /** Commentaires d'une entreprise */
                    Route::group(['prefix' => 'comments'], function () {
                        Route::get('/add', 'CompanyCommentController@add')->name('company.comment.add');
                        Route::post('/add', 'CompanyCommentController@register')->name('company.comment.add.post');
                        Route::get('/index', 'CompanyCommentController@index')->name('company.comment.search');

                        // Pour une comment
                        Route::group(['prefix' => '{id}'], function () {

                            Route::get('/edit', 'CompanyCommentController@edit')->name('company.comment.edit');
                            Route::post('/edit', 'CompanyCommentController@update')->name('company.comment.edit.post');
                            Route::get('/delete', 'CompanyCommentController@delete')->name('company.comment.delete');
                        });
                    });

                    /** Contacts d'une entreprise */
                    Route::group(['prefix' => 'contacts'], function () {
                        Route::get('/add', 'CompanyContactController@add')->name('company.contact.add');
                        Route::post('/add', 'CompanyContactController@register')->name('company.contact.add.post');
                        Route::get('/index', 'CompanyContactController@index')->name('company.contact.search');

                        // Pour un contact
                        Route::group(['prefix' => '{id}'], function () {

                            Route::get('/edit', 'CompanyContactController@edit')->name('company.contact.edit');
                            Route::post('/edit', 'CompanyContactController@update')->name('company.contact.edit.post');
                            Route::get('/delete', 'CompanyContactController@delete')->name('company.contact.delete');
                        });
                    });
                });


                /** Infolettre d'une entreprise */
                Route::group(['prefix' => '/newsletter/{company}'], function () {
                    Route::get('/add', 'InfolettreController@add')->name('company.newsletter.add');
                    Route::post('/add', 'InfolettreController@register')->name('company.newsletter.add.post');
                    Route::get('/index', 'InfolettreController@index')->name('company.newsletter.search');

                    // Pour une newsletter
                    Route::group(['prefix' => '{id}'], function () {

                        Route::get('/edit', 'InfolettreController@edit')->name('company.newsletter.edit');
                        Route::post('/edit', 'InfolettreController@update')->name('company.newsletter.edit.post');
                        Route::get('/delete', 'InfolettreController@delete')->name('company.newsletter.delete');
                        Route::get('/send', 'InfolettreController@send')->name('company.newsletter.send');
                    });
                });


            });
            Route::group(['prefix' => '/prime-time/mod/{company}'], function () {
                Route::get('/', 'PrimeTimeController@index')->name('company.primeTime');
                Route::post('/save', 'PrimeTimeController@save')->name('company.primeTime.save');
            });
            /** Rendez-vous d'une entreprise */
            Route::group(['prefix' => '/meetings/mod/{company}'], function () {
                Route::get('/add', 'CompanyMeetingController@add')->name('company.meeting.add');
                Route::post('/add', 'CompanyMeetingController@register')->name('company.meeting.add.post');
                Route::get('/index', 'CompanyMeetingController@index')->name('company.meeting.search');
                Route::get('/print', 'CompanyMeetingController@printPDF')->name('company.meeting.print');

                // Pour une meeting
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/details', 'CompanyMeetingController@details')->name('company.meeting.details');
                    Route::get('/edit', 'CompanyMeetingController@edit')->name('company.meeting.edit');
                    Route::post('/edit', 'CompanyMeetingController@update')->name('company.meeting.edit.post');
                    Route::get('/delete', 'CompanyMeetingController@delete')->name('company.meeting.delete');
                });
            });
            Route::group(['prefix' => '/users/mod/{company}'], function () {
                Route::get('/index', 'CompanyUserController@index')->name('company.users.index');
                Route::get('/add', 'CompanyUserController@add')->name('company.users.add');
                Route::get('/assigner', 'CompanyUserController@assigner')->name('company.users.assigner');
                Route::post('/assign', 'CompanyUserController@assign')->name('company.users.assign');
                Route::post('/store', 'CompanyUserController@store')->name('company.users.store');
                Route::get('/unassign/{user}', 'CompanyUserController@unassign')->name('company.users.unassign');
            });

        });
    });

    # Web sites des établissements
    //Route::pattern('subdomain','dev|www|devsite');
    Route::pattern('domain', '[a-z0-9-.]+');
    Route::group(['middleware' => 'domain', 'domain' => '{subdomain}.{domain}'], function () {
        Route::get('sitemap.xml', 'SitemapController@company')->name("front.sitemap.company");
        Route::get('/', 'SiteController@index')->name('front.site.index');
        Route::get('/{page_slug}', 'SiteController@index')->name('front.site.page');

        #Route::group(["prefix" => "admin", ])


    });
    Route::post('/newsletter/subscribe', 'CompanyController@subscribe')->name('front.site.newsletter.subscribe.post');
});
