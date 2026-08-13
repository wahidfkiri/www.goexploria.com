<tr>
	<td>{{ link_to_route('location.edit', "Aperçu", [$country->code, $location->id]) }}</td>
</tr>
<tr>
	<td>{{ link_to_route('front.location.id', "Voir", [$location->id]) }}</td>
</tr>
<tr>
	<td>{{ link_to_route('location.edit.hierarchie', "Hiérarchie", [$country->code, $location->id]) }}</td>
</tr>
<tr>
	<td>{{ link_to_route('location.edit.infos', "Informations", [$country->code, $location->id]) }}</td>
</tr>
<tr>
	<td>{{ link_to_route('location.contact.search', "Contacts", [$country->code, $location->id]) }}</td>
</tr>
<tr>
	<td>{{ link_to_route('location.edit.contact', "Point d'informations", [$country->code, $location->id]) }}</td>
</tr>
<tr>
	<td>{{ link_to_route('location.page.search', "Pages", [$country->code, $location->id]) }}</td>
</tr>
<tr>
	<td>{{ link_to_route('location.edit.slider', "Slider", [$country->code, $location->id]) }}</td>
</tr>
