$(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('input[name=_token]').val()
        }
      });

(function( $ ) {
 
 	/** Fonction principale : toutes les actions disponibles */
    $.fn.treeSelector = function() {

    	/***********************************************/
    	/******************* FIELDS  *******************/
    	/***********************************************/

    /* Pays depuis lequel on récupère des données */
		this.country = this.attr('country');

		/** Element actuel */
		this.current = this.attr('base');

		/** URL à partir de laquelle on récupère des données */
		this.src = this.attr('source');

    /* Icones + et - */ 
    var plus = 'entypo-plus-squared';
    var moins = 'entypo-minus-squared';

    /** Vrai si au moins un lieu retourné */
    var init = false;

		/*************************************************/
    	/******************* PUBLIC  *******************/
    	/***********************************************/

      /** Vide et réaffiche le contenu */
      this.reload = function() {
        reset(this);
        return load(this);
      };



    	/***********************************************/
    	/******************* PRIVATE  ******************/
    	/***********************************************/

      /** Charge le contenu à partir des données en mémoire */
      var load = function(item) {
        // On récupère le json
        bindDataFromAjax(item, item, bind, after);
        return item;
      };

      /** Remise à zéro du contenu et de l'état */
      var reset = function(item) {
        // Suppression du contenu
        item.next().remove();

        init = false; // pas d'initialisation

        // Remise à zéro de l'élément de départ et du pays
        item.current = item.attr('base');
        item.country = item.attr('country');
         return item;
      };


		/** Génération du contenu à partir de la clé et des valeurs */
    	var bind = function bind(key, val) {
	        return "<li data='" + val.id + "'><a href='#' class='value'>" + val.name + " (" + val.type + ")</a> <i class='more "+plus+"'></i></li>";
	    }

	    /** Génération du contenu à partir de la clé et des valeurs */
    	var after = function after(item, target) {
	        /** Clique sur le plus d'un niveau de l'arbre */
	        $('.more').unbind('click').bind('click', function(e) {
            var sub = $(this).next();
	        	// On évite les double clique
            // Si pas de contenu => on le charge
	        	if (sub.length == 0) {
              item.current = $(this).parent().attr('data');
              $(this).removeClass(plus).addClass(moins);
              bindDataFromAjax(item, $(this), bind, after);
            } else { // Si contenu déjà présent
              // On inverse le statut du contenu et du bouton
					    if (sub.css('display') == 'none') {
                sub.css('display', 'block');
                $(this).removeClass(plus).addClass(moins);
              } else {
                sub.css('display', 'none');
                $(this).removeClass(moins).addClass(plus);
              }
	        	}
            return false;
	        });

          /** Clique sur le plus d'un niveau de l'arbre */
          $('.value').unbind('click').bind('click', function(e) {
            $("#"+target.attr('id')).val($(this).parent().attr('data'));
            $("#"+target.attr('id')).next().find('.selected-color').removeClass('selected-color');
            $(this).parent().addClass('selected-color');
            return false;
          });

	    }

    	/** Affichage du résultat à l'écran */
    	var bindDataFromAjax = function(item, target, execute, after){
    		$.post(item.src, {country: item.country, parent: item.current}, function(data) {

          // On traite le cas où il y a pas de données
          if (data.length == 0) {
            target.removeClass(moins);

            // Affiche champ vide si pas de données
            if (!init) {
              $( "<ul/>", {
                "class": "sub-tree",
                html: "<li>Pas de données disponibles</li>"
              }).insertAfter(target);
            }
            return data;
          } 

  				var items = []; // Liste des éléments que l'on va remplir
  				// Récupération des liens et génération de la liste
	    		for (var key = 0; key < data.length; key++) {
	    	    	var val = data[key];
    				items.push(execute(key, data[key]));
	    		}

	    		// Remplissage dans le menu
  				$( "<ul/>", {
    				"class": "sub-tree",
    				html: items.join( "" )
  				}).insertAfter(target);
  			
  				/** On exécute la fonction finale si elle existe */
  				if (typeof after === "function") {
  			    	after(item, target);
  				}

          /** Si on a récupéré au moins des données de base*/
          if (!init) {
            init = true;
          }
  			
  				return data;
			}, "json");
    	};
		return load(this);
    }; 
}( jQuery ));
});