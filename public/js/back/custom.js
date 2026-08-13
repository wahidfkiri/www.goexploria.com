jQuery(document).ready(function($) {

    if ($('.pictos-list').length > 0) {
        if ($('.add-pictos').length > 0) {
            $('body').on('click', '.add-pictos', function(e) {
                e.preventDefault();

                var pictosCtr = $('.add-pictos').attr('data-qty');
                var printedCtr = parseInt(pictosCtr) + 1;

                var pictoHtml = '<tr class="pictos-template pictos-template' + pictosCtr + '">';
                pictoHtml += '  <td><label for="pictos[' + pictosCtr + ']">Pictogramme</label></td>';
                pictoHtml += '  <td><input class="form-control" placeholder="Nom" name="pictos[' + pictosCtr + '][name]" type="text"></td>';
                pictoHtml += '  <td><input class="form-control" placeholder="https://url.com/" name="pictos[' + pictosCtr + '][url]" type="text"></td>';
                pictoHtml += '  <td><input class="form-control" name="pictos[' + pictosCtr + '][image]" type="file"></td>';
                pictoHtml += '  <td><button class="form-control remove-pictos">X</button></td>';
                pictoHtml += '</tr>';

                $('.pictos-list').append(pictoHtml);
                var newPictosCtr = parseInt(pictosCtr) + 1;
                $('.add-pictos').attr('data-qty', newPictosCtr);
            });
            $('body').on('click', '.remove-pictos', function(e) {
                e.preventDefault();

                var $this = $(this);
                $this.parents('.pictos-template').remove();
            });
        }
    }

    if ($('.achats-list').length > 0) {
        if ($('.add-achats').length > 0) {
            $('body').on('click', '.add-achats', function(e) {
                e.preventDefault();

                var achatsCtr = $('.add-achats').attr('data-qty');
                var printedCtr = parseInt(achatsCtr) + 1;

                var achatHtml = '<tr class="achats-template achats-template' + achatsCtr + '">';
                achatHtml += '  <td><label for="achats[' + achatsCtr + ']">Achat</label></td>';
                achatHtml += '  <td><input class="form-control" placeholder="Nom" name="achats[' + achatsCtr + '][name]" type="text"></td>';
                achatHtml += '  <td><input class="form-control" placeholder="0,00" name="achats[' + achatsCtr + '][price]" type="number" min="0" step="0.01"></td>';
                achatHtml += '  <td>';
                achatHtml += '    <input class="form-control" name="achats[' + achatsCtr + '][image]" type="file"><br>';
                achatHtml += '    <input class="form-control" name="achats[' + achatsCtr + '][oldimage]" type="hidden" value=""><br>';
                achatHtml += '  </td>';
                achatHtml += '  <td><input class="form-control" placeholder="URL" name="achats[' + achatsCtr + '][url]" type="text" value=""></td>';
                achatHtml += '  <td><input class="form-control" placeholder="0" name="achats[' + achatsCtr + '][order]" type="number" value="0" step="1"></td>';
                achatHtml += '  <td><button class="form-control remove-achats">X</button></td>';
                achatHtml += '</tr>';

                $('.achats-list').append(achatHtml);
                var newAchatsCtr = parseInt(achatsCtr) + 1;
                $('.add-achats').attr('data-qty', newAchatsCtr);
            });
            $('body').on('click', '.remove-achats', function(e) {
                e.preventDefault();

                var $this = $(this);
                $this.parents('.achats-template').remove();
            });
        }
    }






});