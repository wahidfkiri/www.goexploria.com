<tr>
    <td>{{ link_to_route('company.edit', "Aperçu", $company->id, ["target" => "blank"]) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('front.company.id', "Voir", $company->id, ["target" => "blank"]) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.edit.infos', "Informations", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.edit.achats', "Commande / Produits / Services", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.edit.settings', "Configurations", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.contact.search', "Contacts", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.edit.location', "Localisation", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.edit.activity', "Activités (" . $company->activities->count() . ")", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.page.search', "Pages (" . $company->pages->count() . ")", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.gallery.search', "Galeries (" . $company->galleries->count() . ")", ['cid' => $company->id]) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.documents.list', "Documents", ['cid' => $company->id]) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.newsletter.search', "Newsletter", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.follower', "Abonnés", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.comment.search', "Commentaires", $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('users.meeting.search', 'Rendez-vous', [], ['class'=>'title']) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.users.index', "Utilisateurs (".$company->users()->count().')', $company->id) }}</td>
</tr>
<tr>
    <td>{{ link_to_route('company.primeTime', "Prime Time", $company->id) }}</td>
</tr>
