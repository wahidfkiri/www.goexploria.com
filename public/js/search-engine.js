$(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('input[name=_token]').val()
        }
      });

(function( $ ) {
 
 	/** Fonction principale : toutes les actions disponibles */
    $.fn.searchEngine = function() {

    	/***********************************************/
    	/******************* FIELDS  *******************/
    	/***********************************************/

		/** URL à partir de laquelle on récupère des données */
		this.src = this.attr('source');

    /** Si défini, redirige lors de la selection d'un élément vers l'url configurée */
    this.redirect = this.attr('redirect');

    /** Nombre de caractèes minimal avant de lancer la requete */
    this.minChar = this.attr('minChar');

    /** Le controlleur chargé de stocker les données en mémoire */
    this.control = null;

    /***********************************************/
    /******************* PRIVATE  *******************/
    /***********************************************/
    /** Créé les valeurs en mémoire */
      var create = function(item) {

        // Création du sélecteur
        var $select = item.selectize({
            valueField: 'id',
            onItemAdd: function(value, $item) {
              var url = $item.attr('url');
              // Pas de changement si cible non définie
              if (item.redirect != null && url != null && url.length > 0)
                document.location.href = url;
            },
            render: {
              item: function(item, escape) {
                return '<span url="'+item.url+'">' + item.text + '</span>';
              }
            },
            onType: function(str) {
              // Si moins de caractère que le mini => pas de recherche
              var min = (item.minChar != null && !isNaN(item.minChar)) ? item.minChar : 3;
              if (str.length < min){
                return false;
              }

              // On lance la recherche
              return bindDataFromAjax(item, str);
            }
            
             
            // TMP pour trier correctement ex: alma en premier
            //sortField: [{field: 'groupe', direction: 'asc'}, {field: '$score'}]
            
        });

        // on stocke le controlleur
        if( $select[0] ){ 
          item.control = $select[0].selectize;
        }
        // Place l'écouteur pour la fonction
        return item;
      };

     
    	/** Récupération des résultats */
    	var bindDataFromAjax = function(item, value){
          // On edite les données à rechercher
          var requested = item.src.replace(':data', value)

          // On récupère le résultat
          $.ajax({
            url: requested, 
            type: "GET",
            timeout: 10000,
            dataType : "json",
          }).success(function(data) {
            // On vide la liste
            item.control.clear(false); 
            item.control.clearOptions();

            // Si aucun résultat
            if (data.length < 0) {
              return;
            }

            // On applique la fonction
            for (var key in data) {
              val = data[key];

              // On rentre le groupe
              item.control.addOptionGroup(val.groupe, {
                id: val.groupe,
                label: val.label
              }); 

              // On rentre la valeur
              item.control.addOption({
                id: val.value,
                url: val.url,
                text: val.nom,
                optgroup: val.groupe,
              });
            }

          });

          return item;
    	};

		return create(this);
    }; 
}( jQuery ));
});