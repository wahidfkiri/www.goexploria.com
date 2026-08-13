<?php

/******************************************************************************/
/********************************* FRONTEND ***********************************/
/******************************************************************************/

// HOME
Breadcrumbs::for('front', function($breadcrumbs)
{
    $breadcrumbs->push('Accueil', route('index'));
});

/** LIEUX   */
Breadcrumbs::for('world', function($breadcrumbs)
{
    $breadcrumbs->parent('front');
    // Désactivé pour cacher "WORLD" de la navbar
    #$breadcrumbs->push('Monde', route('front.world'));
});

Breadcrumbs::for('front.location', function($breadcrumbs, $slugs)
{
    $breadcrumbs->parent('world');
    $route = "";
    foreach($slugs as $item) {
        $route .= $item->value .'/';
        $breadcrumbs->push($item->name, route('front.location', $route));
    }
});

// Site
Breadcrumbs::for('front.site', function($breadcrumbs, $company)
{
    $breadcrumbs->push('Accueil', route('front.site.index', [$company->slug]));
});

Breadcrumbs::for('front.site.page', function($breadcrumbs, $company, $page)
{
    $breadcrumbs->parent('front.site', $company);
    $breadcrumbs->push($page->name, route('front.site.page', [$company->slug, $page->slug]));
});

// Company
Breadcrumbs::for('front.company', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('front');
    $breadcrumbs->push($company->name, route('front.company.id', $company->id));
});

Breadcrumbs::for('front.company.newsletter', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('front.company', $company);
    $breadcrumbs->push("Abonnement", route('front.company.newsletter.subscribe', Formatter::slugWithId($company->slugify())));
});

/** ERREURS   */
Breadcrumbs::for('error.404', function($breadcrumbs)
{
    $breadcrumbs->parent('front');
    $breadcrumbs->push('Ressource introuvable', route('error'));
});

Breadcrumbs::for('error.503', function($breadcrumbs)
{
    $breadcrumbs->parent('front');
    $breadcrumbs->push('Accès refusé', route('denied'));
});


/******************************************************************************/
/********************************* BACKEND ************************************/
/******************************************************************************/

//HOME
Breadcrumbs::for('back', function($breadcrumbs)
{
    $breadcrumbs->push('Backend', route('admin'));
});


//LOCATIONS
Breadcrumbs::for('location', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Lieux', route('location.map'));
});

Breadcrumbs::for('location.search', function($breadcrumbs, $country)
{
    $breadcrumbs->parent('location');
    $breadcrumbs->push($country->name, route('location.search', [$country->code]));
});

Breadcrumbs::for('location.add', function($breadcrumbs, $country)
{
    $breadcrumbs->parent('location.search', $country);
    $breadcrumbs->push('Ajouter', route('location.add', [$country->code]));
});

Breadcrumbs::for('location.details', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.search', $country);
    $breadcrumbs->push($location->name, route('location.edit', [$country->code, $location->id]));
});

Breadcrumbs::for('location.edit.infos', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.details', $country, $location);
    $breadcrumbs->push("Informations", route('location.edit.infos', [$country->code, $location->id]));
});

Breadcrumbs::for('location.edit.contact', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.details', $country, $location);
    $breadcrumbs->push("Informations", route('location.edit.contact', [$country->code, $location->id]));
});

Breadcrumbs::for('location.edit.hierarchie', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.details', $country, $location);
    $breadcrumbs->push("Informations", route('location.edit.hierarchie', [$country->code, $location->id]));
});

Breadcrumbs::for('location.edit.slider', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.details', $country, $location);
    $breadcrumbs->push("Slider", route('location.edit.slider', [$country->code, $location->id]));
});

//LOCATIONS TYPE
Breadcrumbs::for('location.type', function($breadcrumbs)
{
    $breadcrumbs->parent('location');
    $breadcrumbs->push('Types', route('location.type.map'));
});

Breadcrumbs::for('location.type.search', function($breadcrumbs, $country)
{
    $breadcrumbs->parent('location.type');
    $breadcrumbs->push($country->name, route('location.type.search', [$country->code]));
});

Breadcrumbs::for('location.type.add', function($breadcrumbs, $country)
{
    $breadcrumbs->parent('location.type.search', $country);
    $breadcrumbs->push('Ajouter', route('location.type.add', [$country->code]));
});

Breadcrumbs::for('location.type.edit', function($breadcrumbs, $country, $type)
{
    $breadcrumbs->parent('location.type.search', $country);
    $breadcrumbs->push('Editer', route('location.type.edit', [$country->code, $type->id]));
});


// Pages
Breadcrumbs::for('location.detail', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.search', $country);
    $breadcrumbs->push($location->name, route('location.edit', [$country->code, $location->id]));
});

Breadcrumbs::for('location.page', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.detail', $country, $location);
    $breadcrumbs->push('Pages', route('location.page.search', [$country->code, $location->id]));
});

Breadcrumbs::for('location.page.add', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.page', $country, $location);
    $breadcrumbs->push('Ajouter', route('location.page.add', [$country->code, $location->id]));
});

Breadcrumbs::for('location.page.edit', function($breadcrumbs, $country, $location, $page)
{
    $breadcrumbs->parent('location.page', $country, $location);
    $breadcrumbs->push('Editer', route('location.page.edit', [$country->code, $location->id, $page->id]));
});


// Pages for country
Breadcrumbs::for('country.detail', function($breadcrumbs, $country)
{
    $breadcrumbs->parent('country', $country);
    #$breadcrumbs->push($country->name, route('location.map', $country->code));
});

Breadcrumbs::for('country.page.add', function($breadcrumbs, $country)
{
    $breadcrumbs->parent('country.page', $country);
    $breadcrumbs->push('Ajouter', route('country.page.add', $country->code));
});

Breadcrumbs::for('country.page.edit', function($breadcrumbs, $country, $page)
{
    $breadcrumbs->parent('country.page', $country);
    $breadcrumbs->push('Editer', route('country.page.edit', [$country->code, $page->id]));
});

Breadcrumbs::for('country.page', function($breadcrumbs, $country)
{
    $breadcrumbs->parent('country.detail', $country);
    $breadcrumbs->push('Pages', route('country.page.search', $country->code));
});

// contacts
Breadcrumbs::for('location.contact', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.details', $country, $location);
    $breadcrumbs->push('Contacts', route('location.contact.search', [$country->code, $location->id]));
});


Breadcrumbs::for('location.contact.add', function($breadcrumbs, $country, $location)
{
    $breadcrumbs->parent('location.contact', $country, $location);
    $breadcrumbs->push('Ajouter', route('location.contact.add', [$country->code, $location->id]));
});

Breadcrumbs::for('location.contact.edit', function($breadcrumbs, $country, $location, $contact)
{
    $breadcrumbs->parent('location.contact', $country, $location);
    $breadcrumbs->push('Editer', route('location.contact.edit', [$country->code, $location->id, $contact->id]));
});


// ACTIVITES
Breadcrumbs::for('activity', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Activités', route('activity.search'));
});

Breadcrumbs::for('activity.add', function($breadcrumbs)
{
    $breadcrumbs->parent('activity');
    $breadcrumbs->push('Ajouter', route('activity.add'));
});

Breadcrumbs::for('activity.edit', function($breadcrumbs, $activity)
{
    $breadcrumbs->parent('activity');
    $breadcrumbs->push('Editer', route('activity.edit', [$activity->id]));
});

// Catégories d'activités
Breadcrumbs::for('activity.category', function($breadcrumbs)
{
    $breadcrumbs->parent('activity');
    $breadcrumbs->push('Catégories', route('activity.category.search'));
});


Breadcrumbs::for('activity.category.add', function($breadcrumbs)
{
    $breadcrumbs->parent('activity.category');
    $breadcrumbs->push('Ajouter', route('activity.category.add'));
});

Breadcrumbs::for('activity.category.edit', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('activity.category');
    $breadcrumbs->push('Editer', route('activity.category.edit', [$category->id]));
});

// PAYS
Breadcrumbs::for('country', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Pays', route('country.search'));
});


Breadcrumbs::for('country.add', function($breadcrumbs)
{
    $breadcrumbs->parent('country');
    $breadcrumbs->push('Ajouter', route('country.add'));
});

Breadcrumbs::for('country.edit', function($breadcrumbs, $country)
{
    $breadcrumbs->parent('country');
    $breadcrumbs->push('Editer', route('country.edit', [$country->code]));
});

// GALLERY LOCATION
Breadcrumbs::for('location.gallery', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Galeries destinations', route('location.gallery.search'));
});

Breadcrumbs::for('location.gallery.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('location.gallery');
    $breadcrumbs->push('Editer', route('location.gallery.search'));
});

Breadcrumbs::for('location.gallery.add', function($breadcrumbs)
{
    $breadcrumbs->parent('location.gallery');
    $breadcrumbs->push('Ajout galerie', route('location.gallery.add'));
});

Breadcrumbs::for('location.gallery.addmedia', function($breadcrumbs, $gallery_id)
{
    $breadcrumbs->parent('location.gallery.add');
    $breadcrumbs->push('Ajout médias', route('location.gallery.addmedia', [$gallery_id]));
});

// GALLERY COUNTRY
Breadcrumbs::for('country.gallery', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Galeries pays', route('country.gallery.search'));
});

Breadcrumbs::for('country.gallery.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('country.gallery');
    $breadcrumbs->push('Editer', route('country.gallery.search'));
});

Breadcrumbs::for('country.gallery.add', function($breadcrumbs)
{
    $breadcrumbs->parent('country.gallery');
    $breadcrumbs->push('Ajout galerie', route('country.gallery.add'));
});

Breadcrumbs::for('country.gallery.addmedia', function($breadcrumbs, $gallery_id)
{
    $breadcrumbs->parent('country.gallery.add');
    $breadcrumbs->push('Ajout médias', route('country.gallery.addmedia', [$gallery_id]));
});

// GALLERY COMPANY
Breadcrumbs::for('company.gallery', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Galeries établissements', route('company.gallery.search'));
});

Breadcrumbs::for('company.gallery.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('company.gallery');
    $breadcrumbs->push('Editer', route('company.gallery.search'));
});

Breadcrumbs::for('company.gallery.add', function($breadcrumbs)
{
    $breadcrumbs->parent('company.gallery');
    $breadcrumbs->push('Ajout galerie', route('company.gallery.add'));
});

Breadcrumbs::for('company.gallery.addmedia', function($breadcrumbs, $gallery_id)
{
    $breadcrumbs->parent('company.gallery.add');
    $breadcrumbs->push('Ajout médias', route('company.gallery.addmedia', [$gallery_id]));
});

//MEDIAS COMPANY
Breadcrumbs::for('company.documents', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('company.edit', $id);
    $breadcrumbs->push('Documents', route('company.documents.list', [$id]));
});

// COMPANY
Breadcrumbs::for('company', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Etablissements', route('company.search'));
});

Breadcrumbs::for('company.import', function($breadcrumbs)
{
    $breadcrumbs->parent('company');
    $breadcrumbs->push('Importation', route('company.import'));
});


Breadcrumbs::for('company.add', function($breadcrumbs)
{
    $breadcrumbs->parent('company');
    $breadcrumbs->push('Ajouter', route('company.add'));
});

Breadcrumbs::for('company.edit', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company');
    $breadcrumbs->push(ucfirst($company->name), route('company.edit', [$company->id]));
});

Breadcrumbs::for('company.follower', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push("Abonnés", route('company.follower', [$company->id]));
});

Breadcrumbs::for('company.edit.infos', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push("Informations", route('company.edit.infos', [$company->id]));
});

Breadcrumbs::for('company.edit.settings', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push("Configurations", route('company.edit.settings', [$company->id]));
});


Breadcrumbs::for('company.edit.location', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push("Localisation", route('company.edit.location', [$company->id]));
});

Breadcrumbs::for('company.edit.activity', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push("Activités", route('company.edit.activity', [$company->id]));
});

// Page des entreprises
Breadcrumbs::for('company.page', function($breadcrumbs,$company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push('Pages', route('company.page.search', [$company->id]));
});


Breadcrumbs::for('company.page.add', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.page',  $company);
    $breadcrumbs->push('Ajouter', route('company.page.add', [$company->id]));
});

Breadcrumbs::for('company.page.edit', function($breadcrumbs,  $company, $page)
{
    $breadcrumbs->parent('company.page', $company);
    $breadcrumbs->push('Editer', route('company.page.edit', [$company->id, $page->id]));
});

// Infolettre
Breadcrumbs::for('company.newsletter', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push('Newsletter', route('company.newsletter.search', [$company->id]));
});


Breadcrumbs::for('company.newsletter.add', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.newsletter', $company);
    $breadcrumbs->push('Ajouter', route('company.newsletter.add', [$company->id]));
});

Breadcrumbs::for('company.newsletter.edit', function($breadcrumbs, $company, $newsletter)
{
    $breadcrumbs->parent('company.newsletter', $company);
    $breadcrumbs->push('Editer', route('company.newsletter.edit', [$company->id, $newsletter->id]));
});

// commentaires
Breadcrumbs::for('company.comment', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push('Commentaires', route('company.comment.search', [$company->id]));
});


Breadcrumbs::for('company.comment.add', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.comment', $company);
    $breadcrumbs->push('Ajouter', route('company.comment.add', [$company->id]));
});

Breadcrumbs::for('company.comment.edit', function($breadcrumbs, $company, $comment)
{
    $breadcrumbs->parent('company.comment', $company);
    $breadcrumbs->push('Editer', route('company.comment.edit', [$company->id, $comment->id]));
});

// contacts
Breadcrumbs::for('company.contact', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push('Contacts', route('company.contact.search', [$company->id]));
});


Breadcrumbs::for('company.contact.add', function($breadcrumbs, $company)
{
    $breadcrumbs->parent('company.contact', $company);
    $breadcrumbs->push('Ajouter', route('company.contact.add', [$company->id]));
});

Breadcrumbs::for('company.contact.edit', function($breadcrumbs, $company, $contact)
{
    $breadcrumbs->parent('company.contact', $company);
    $breadcrumbs->push('Editer', route('company.contact.edit', [$company->id, $contact->id]));
});

// meetings
Breadcrumbs::for('company.meeting', function($breadcrumbs, $company) {
    $breadcrumbs->parent('company.edit', $company);
    $breadcrumbs->push('Rendez-vous', route('company.meeting.search', [$company->id]));
});


Breadcrumbs::for('company.meeting.add', function($breadcrumbs, $company) {
    $breadcrumbs->parent('company.meeting', $company);
    $breadcrumbs->push('Ajouter', route('company.meeting.add', [$company->id]));
});

Breadcrumbs::for('company.meeting.edit', function($breadcrumbs, $company, $meeting) {
    $breadcrumbs->parent('company.meeting.details', $company, $meeting);
    $breadcrumbs->push('Editer', route('company.meeting.edit', [$company->id, $meeting->id]));
});

Breadcrumbs::for('company.meeting.details', function($breadcrumbs, $company, $meeting) {
    $breadcrumbs->parent('company.meeting', $company);
    $breadcrumbs->push($meeting->name, route('company.meeting.details', [$company->id, $meeting->id]));
});



// CONTINENT
Breadcrumbs::for('continent', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Continents', route('continent.search'));
});


Breadcrumbs::for('continent.add', function($breadcrumbs)
{
    $breadcrumbs->parent('continent');
    $breadcrumbs->push('Ajouter', route('continent.add'));
});

Breadcrumbs::for('continent.edit', function($breadcrumbs, $continent)
{
    $breadcrumbs->parent('continent');
    $breadcrumbs->push('Editer', route('continent.edit', [$continent->id]));
});

// USERS
Breadcrumbs::for('user', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Utilisateurs', route('user.search'));
});


Breadcrumbs::for('user.add', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('Ajouter', route('user.add'));
});

Breadcrumbs::for('user.details', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push($user->name, route('user.details', $user->id));
});

Breadcrumbs::for('user.pass', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('user.details', $user);
    $breadcrumbs->push("Mot de passe", route('user.pass', $user->id));
});

// USERS TYPES
Breadcrumbs::for('user.type', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('Types', route('user.type.search'));
});


Breadcrumbs::for('user.type.add', function($breadcrumbs)
{
    $breadcrumbs->parent('user.type');
    $breadcrumbs->push('Ajouter', route('user.type.add'));
});

Breadcrumbs::for('user.type.edit', function($breadcrumbs, $type)
{
    $breadcrumbs->parent('user.type');
    $breadcrumbs->push('Editer', route('user.type.edit', $type->id));
});

Breadcrumbs::for('user.type.access', function($breadcrumbs, $type)
{
    $breadcrumbs->parent('user.type');
    $breadcrumbs->push('Permissions', route('user.type.access', $type->id));
});

// NEWSLETTER
Breadcrumbs::for('newsletter', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Newsletter', route('newsletter.search'));
});


Breadcrumbs::for('newsletter.add', function($breadcrumbs)
{
    $breadcrumbs->parent('newsletter');
    $breadcrumbs->push('Ajouter', route('newsletter.add'));
});

Breadcrumbs::for('newsletter.edit', function($breadcrumbs, $newsletter)
{
    $breadcrumbs->parent('newsletter');
    $breadcrumbs->push('Editer', route('newsletter.edit', [$newsletter->id]));
});

Breadcrumbs::for('newsletter.history', function($breadcrumbs)
{
    $breadcrumbs->parent('newsletter');
    $breadcrumbs->push('Historique', route('newsletter.history'));
});

// CONFIG
Breadcrumbs::for('config', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push('Configuration', route('module.search')); // TODO changer la route
});

// MODULES
Breadcrumbs::for('module', function($breadcrumbs)
{
    $breadcrumbs->parent('config');
    $breadcrumbs->push('Modules', route('module.search'));
});


Breadcrumbs::for('module.add', function($breadcrumbs)
{
    $breadcrumbs->parent('module');
    $breadcrumbs->push('Ajouter', route('module.add'));
});

Breadcrumbs::for('module.edit', function($breadcrumbs, $module)
{
    $breadcrumbs->parent('module');
    $breadcrumbs->push('Editer', route('module.edit', [$module->id]));
});

// Content
Breadcrumbs::for('content.index', function($breadcrumbs)
{
    $breadcrumbs->parent('config');
    $breadcrumbs->push('Contenu', route('content.index'));
});

// Account
Breadcrumbs::for('account', function($breadcrumbs)
{
    $breadcrumbs->parent('back');
    $breadcrumbs->push("Mon compte", route('account.profil'));
});
Breadcrumbs::for('account.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Modification', route('account.edit'));
});
Breadcrumbs::for('account.pass', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Mot de passe', route('account.change.pass'));
});

Breadcrumbs::for('account.subscription', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Abonnements', route('account.subscription.search'));
});
