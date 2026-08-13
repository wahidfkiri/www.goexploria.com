<html>
<head>
    <style>
        body {
            font-family: arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            border: 1px solid #000;
            padding: 5px 10px;
        }
        th {
            background-color: #ccc;
            text-transform: uppercase;
        }
        .pricing {
            margin-bottom: 24px;
        }
        .pricing tr > th {
            width: 10%
        }
        .pricing tr > th + th {
            width: 65%;
        }
        .pricing tr > th + th + th {
            width: 25%
        }

        @media print {
            .invoice-instructions-mas {
                display: none;
            }
            .invoice-instructions {
                display: none;
            }
        }
    </style>
</head>
<body>
    <img src="{{ URL::asset('uploads/companies/' . $company->id . '/' . $company->getLogoFilename()) }}" style="float: right; max-height: 100px;">

    @if (!empty(trim($company->achats_marche_a_suivre)))
        <div class="invoice-instructions-mas">
            <div>
                <p><strong>Marche à suivre :</strong></p>
                {!! $company->achats_marche_a_suivre !!}
            </div>
        </div>
    @endif
    @if (!empty(trim($company->achats_instructions)))
        <div class="invoice-instructions">
            <div>
                <p><strong>Sauvegarder la facture en PDF :</strong></p>
                {!! $company->achats_instructions !!}
            </div>
        </div>
    @endif
    <!--<div class="invoice-instructions">
        <p>
            <strong>Instructions :</strong><br>
            1. Ouvrir la fenêtre d'impression de votre navigateur (Raccourci : Ctrl + p)<br>
            2. Choisir comme destination "Sauvegarder en PDF"<br>
            @if (!empty($company->coordinate->mail))
                3. Envoyer ce PDF à l'adresse suivante : {{ $company->coordinate->mail }}
            @endif
        </p>
    </div>-->
    <h1>FACTURE</h1>
    <div>
        <p>No de facture : <?php echo 'F-' . date('y') . str_pad($company->last_invoice_number, 3, '0', STR_PAD_LEFT); ?></p>
        <p>Date de facturation : <?php echo date('Y-m-d'); ?></p>
    </div>
    <div style="display: flex;">
        <div style="flex: 1;">
            <p><strong>Éméteur :</strong></p>
            <p>
                @if (!empty($primaryContact))
                    {{ $primaryContact->name }}<br>
                @endif
                {{ $company->name }}<br>
                {{ $company->coordinate->adresse }}<br>
                {{ $company->coordinate->location->name }}, {{ $company->coordinate->code_postal }}<br>
                @if (!empty($company->coordinate->tel))
                    {{ $company->coordinate->tel }}<br>
                @endif
                @if (!empty($company->coordinate->mail))
                    {{ $company->coordinate->mail }}<br>
                @endif
            </p>
        </div>
        <div style="flex: 1;">
            <p><strong>Facturé à :</strong></p>
            <p>
                {{ $user['name'] }}<br>
                {{ $user['company'] }}<br>
                {{ $user['address'] }}<br>
                {{ $user['city'] }}, {{ $user['postalcode'] }}<br>
                @if (isset($user['phone']) && !empty($user['phone']))
                    {{ $user['phone'] }}<br>
                @endif
                @if (isset($user['email']) && !empty($user['email']))
                    {{ $user['email'] }}<br>
                @endif
            </p>
        </div>
    </div>

    <?php
        $subtotal = 0;
    ?>
    <table class="pricing">
        <tr>
            <th>Quantité</th>
            <th>Description</th>
            <th>Coût</th>
        </tr>
        @foreach ($products as $product)
            @if ($product['qty'] > 0)
            <?php $currentPrice = 0; ?>
                <tr>
                    <td>{{ $product['qty'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td style="text-align: right;">
                    @foreach($companyProducts as $companyProduct)
                        @if ($companyProduct['name'] == $product['name'])
                            <?php
                                $currentPrice = round((float)$companyProduct['price'] * $product['qty'], 2);
                                $subtotal += $currentPrice;
                            ?>
                            {{ number_format($currentPrice, 2) }}$
                        @endif
                    @endforeach
                    </td>
                </tr>
            @endif
        @endforeach
        @if (!empty($company->achats_frais_transport))
            <?php $subtotal += $company->achats_frais_transport; ?>
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">FRAIS DE TRANSPORT</td>
                <td style="text-align: right;"><span class="product-transport">{{ number_format(round($company->achats_frais_transport, 2), 2) }}</span>$</td>
            </tr>
        @endif
        @if (!empty($company->achats_frais_admin))
            <?php $subtotal += $company->achats_frais_admin; ?>
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">FRAIS D'ADMINISTRATION</td>
                <td style="text-align: right;"><span class="product-transport">{{ number_format(round($company->achats_frais_admin, 2), 2) }}</span>$</td>
            </tr>
        @endif
        @if (!empty($company->achats_reduction))
            <?php
                $reduction = ($subtotal * $company->achats_reduction) / 100;
                $subtotal -= $reduction;
            ?>
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">RÉDUCTION ({{ $company->achats_reduction }}%)</td>
                <td style="text-align: right;"><span class="product-rebate">-{{ number_format(round($reduction, 2), 2) }}</span>$</td>
            </tr>
        @endif
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">SOUS-TOTAL</td>
            <?php $subtotal = round($subtotal, 2); ?>
            <td style="text-align: right;">{{ number_format($subtotal, 2) }}$</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TPS 5,0%</td>
            <?php $tps = round($subtotal * 0.05, 2); ?>
            <td style="text-align: right;">{{ number_format($tps, 2) }}$</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TVQ 9,975%</td>
            <?php $tvq = round($subtotal * 0.09975, 2); ?>
            <td style="text-align: right;">{{ number_format($tvq, 2) }}$</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL</td>
            <?php $total = $subtotal + $tps + $tvq; ?>
            <td style="text-align: right;">{{ number_format(round($total, 2), 2) }}$</td>
        </tr>
    </table>

    @if($company->versements)
        <?php
            $pricePerPayment = ($total*100) / $company->versements;
            $diffFirstPayment = ($total*100) % $company->versements;
        ?>
        <table id="company_versements" class="pricing" data-versements="{{ $company->versements }}">
            @for($ctr = 0; $ctr < (int)$company->versements; $ctr++)
                <tr>
                    <td style="text-align: right"><strong>Versement #{{ $ctr+1 }} : </strong></td>
                    @if($ctr == 0)
                        <td>{{ number_format((floor($pricePerPayment + $diffFirstPayment)/100), 2) }}</td>
                    @else
                        <td>{{ number_format((floor($pricePerPayment)/100), 2) }}</td>
                    @endif
                    <td style="text-align: right"><strong>Date du paiement : </strong></td>
                    <td>{{ $user['payment'][ $ctr ]['date'] }}</td>
                </tr>
            @endfor
        </table>
    @endif
    <div style="display: flex;">
        <div style="flex: 1;">No TPS : </div>
        <div style="flex: 1;">{{ $company->achats_no_tps }}</div>
        <div style="flex: 1;">No TVQ : </div>
        <div style="flex: 1;">{{ $company->achats_no_tvq }}</div>
        <div style="flex: 1;">NEQ : </div>
        <div style="flex: 1;">{{ $company->achats_neq }}</div>
    </div>
    <h2>Modes de paiement</h2>
    <p><strong>Chèque :</strong></p>
    <p>S.V.P., veuillez libeller votre chèque à l'ordre de : {{ $company->achats_cheque }}</p>
    <p><strong>Dépot direct :</strong></p>
    <div style="display: flex;">
        <div style="flex: 1;">Succursale : </div>
        <div style="flex: 1;">{{ $company->achats_succursale }}</div>
        <div style="flex: 1;">Transit : </div>
        <div style="flex: 1;">{{ $company->achats_transit }}</div>
        <div style="flex: 1;">Compte : </div>
        <div style="flex: 1;">{{ $company->achats_compte }}</div>
    </div>
    <p><strong>En ligne :</strong></p>
    <div style="text-align: center;">
        {!! $company->achats_payment_button !!}
    </div>
    <p>Conditions de paiement : Sur réception de la facture</p>
</body>
</html>
