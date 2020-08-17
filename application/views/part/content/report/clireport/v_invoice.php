<?php
$project_id = $this->session->userdata('projectid_xxx');
$data_in_qn = in_array_r($project_id, $all_costed_jobs);
//print_array($data_in_qn);
?>
<div class="row" id="invoice_pdfthem">
    <div class="col-md-12" >
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4 class="panel-title">Invoice</h4>
                <div class="panel-tools">
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                            <i class="fa fa-cog"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-light pull-right" role="menu">
                            <li>
                                <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
                            </li>
                            <li>
                                <a class="panel-expand" href="#">
                                    <i class="fa fa-expand"></i> <span>Fullscreen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="invoice">
                    <div class="row invoice-logo">
                        <div class="col-sm-6">
                            <img alt="" src="<?= base_url() ?>upload/client/<?= $data_in_qn[0]['client_image_big']; ?>" width="30%" height="30%">
                        </div>
                        <div class="col-sm-6">
                            <p>
                                <?= '#' . $data_in_qn[0]['id_client'] ?> / <?= date("Y/m/d") ?> <span> <?= $data_in_qn[0]['project_name'] ?> </span>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>Client:</h4>
                            <div class="well">
                                <address>
                                    <strong><?= $data_in_qn[0]['clientname'] ?></strong>
                                    <br>
                                    Pin No:<?= ' ' . $data_in_qn[0]['pin_no'] ?>
                                    <br>
                                    <?= $data_in_qn[0]['client_location'] ?>
                                    <br>
                                    <abbr title="Phone">P:</abbr><?= $data_in_qn[0]['client_contact'] ?>
                                </address>
                                <address>
                                    <strong>E-mail</strong>
                                    <br>
                                    <a href="mailto:#">
                                        <?= $data_in_qn[0]['client_email'] ?>
                                    </a>
                                </address>
                            </div>
                            <strong>Discount:</strong><input type="text" id="discount" name="discount" class="form-control">
                            <strong>Vat:</strong><input type="text" id="vat" name="vat" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <h4>We appreciate your business.</h4>
                            <div class="padding-vertical-20">
                                Thanks for being a customer.
                                <br>
                                A detailed summary of your invoice is below.
                                <br>
                                If you have questions, we're happy to help.
                                <br>
                                Email  <a href="mailto:#">info@alfabiz.co.ke </a> or cellphone us through other support channels.
                            </div>
                        </div>
                        <div class="col-sm-4 pull-right">
                            <h4>Payment Details:</h4>
                            <ul class="list-unstyled invoice-details">
                                <li>
                                    <strong>V.A.T Reg #:</strong><input type="text" id="vat_regnumber" name="vat_regnumber" class="form-control">
                                </li>
                                <li>
                                    <strong>Account Name:</strong><input type="text" id="account_name" id="account_name" class="form-control">
                                </li>
                                <li>
                                    <strong>SWIFT code:</strong> <input type="text" id="swiftcode" name="swiftcode" class="form-control">
                                </li>
                                <li>
                                    <strong>DUE:</strong><input type="text" id="form-field-mask-1" class="form-control input-mask-date">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
//                            $arryavaria = array(
//                                'task_workedone' => $data_in_qn[0]['task_workedone']
//                            );
//                            $response = Requests::post(base_url('welcome/totaltimepertaskgetclone/') . $data_in_qn[0]['id'], '', $arryavaria);
//                            $array_datamm = json_decode($response->body, true);
//                            print_array($array_datamm);
                            $array_datamm = $controller->totaltimepertaskget($data_in_qn[0]['id']);
                            ?>
                            <div class="table-content">
                                <table class="table table-borded table-responsive table-striped " id="table-list">
                                    <thead class="table-dark">
                                        <tr>
                                            <td>Description</td>
                                            <td>Unit Cost</td>
                                            <td>Number Of Employees</td>
                                            <td>Total</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($array_datamm as $value_showem) {
                                            $timingcost = $controller->totaltimepertaskgetclonexx($data_in_qn[0]['id'], $value_showem['task_workedone']);
                                            //X Soilder
                                            $total_employe_minor = $controller->totalnumberemployee($data_in_qn[0]['id']);
                                            ?>
                                            <tr>
                                                <td><?= $value_showem['task_workedone'] ?></td>
                                                <td><?= $data_in_qn[0]['project_pricing'] ?></td>
                                                <td><?= $total_employe_minor ?></td>
                                                <td><?= $timingcost * $data_in_qn[0]['project_pricing'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <button class="btn btn-info" id="add"><span class="glyphicon glyphicon-plus-sign"></span>Add More Items</button>
                                <button class="btn btn-success align-right" id="computemmmm"><span class="glyphicon "></span>Compute</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 invoice-block">
                            <ul class="list-unstyled amounts">
                                <li>
                                    <strong>Sub-Total:</strong> KSH 12876
                                </li>
                                <li>
                                    <strong>Discount:</strong> 9.9%
                                </li>
                                <li>
                                    <strong>VAT:</strong> 22%
                                </li>
                                <li>
                                    <strong>Total:</strong> $11400
                                </li>
                            </ul>
                            <br>
                            <a id="print_herehe" onclick="printInvouce('<?= $data_in_qn[0]['clientname'] . ' ' . 'Invoice' ?>')" class="btn btn-lg btn-light-blue hidden-print">
                                Print <i class="fa fa-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        var reloadppn = sessionStorage.getItem("reloadpp");
        if (reloadppn) {
            sessionStorage.removeItem("reloadpp");
            myreloadpp('hey');
        }
    }
    function reloadpp() {
        sessionStorage.setItem("reloadpp", "true");
        document.location.reload();
    }
    function myreloadpp(varia) {
        var l = document.getElementById('approveemployee_linkrr');
        l.click();
    }
//    $('total_item_prices').SetEditable();
//bootstable.js
    /*
     Bootstable
     @description  Javascript library to make HMTL tables editable, using Bootstrap
     @version 1.1
     @autor Tito Hinostroza
     */
    "use strict";
    //Global variables
    var params = null;  		//Parameters
    var colsEdi = null;
    var newColHtml = '<div class="btn-group pull-right">' +
            '<button id="bEdit" type="button" class="btn btn-sm btn-default" onclick="rowEdit(this);">' +
            '<span class="glyphicon glyphicon-pencil" > </span>' +
            '</button>' +
            '<button id="bElim" type="button" class="btn btn-sm btn-default" onclick="rowElim(this);">' +
            '<span class="glyphicon glyphicon-trash" > </span>' +
            '</button>' +
            '<button id="bAcep" type="button" class="btn btn-sm btn-default" style="display:none;" onclick="rowAcep(this);">' +
            '<span class="glyphicon glyphicon-ok" > </span>' +
            '</button>' +
            '<button id="bCanc" type="button" class="btn btn-sm btn-default" style="display:none;" onclick="rowCancel(this);">' +
            '<span class="glyphicon glyphicon-remove" > </span>' +
            '</button>' +
            '</div>';
    var colEdicHtml = '<td name="buttons">' + newColHtml + '</td>';

    $.fn.SetEditable = function (options) {
        var defaults = {
            columnsEd: null, //Index to editable columns. If null all td editables. Ex.: "1,2,3,4,5"
            $addButton: null, //Jquery object of "Add" button
            onEdit: function () {}, //Called after edition
            onBeforeDelete: function () {}, //Called before deletion
            onDelete: function () {}, //Called after deletion
            onAdd: function () {}     //Called when added a new row
        };
        params = $.extend(defaults, options);
        this.find('thead tr').append('<td name="buttons"><span class="glyphicon glyphicon-thumbs-up"></span></td>');  //encabezado vacío
        this.find('tbody tr').append(colEdicHtml);
        var $tabedi = this;   //Read reference to the current table, to resolve "this" here.
        //Process "addButton" parameter
        if (params.$addButton != null) {
            //Se proporcionó parámetro
            params.$addButton.click(function () {
                rowAddNew($tabedi.attr("id"));
            });
        }
        //Process "columnsEd" parameter
        if (params.columnsEd != null) {
            //Extract felds
            colsEdi = params.columnsEd.split(',');
        }
    };
    function IterarCamposEdit($cols, tarea) {
//Itera por los campos editables de una fila
        var n = 0;
        $cols.each(function () {
            n++;
            if ($(this).attr('name') == 'buttons')
                return;  //excluye columna de botones
            if (!EsEditable(n - 1))
                return;   //noe s campo editable
            tarea($(this));
        });

        function EsEditable(idx) {
            //Indica si la columna pasada está configurada para ser editable
            if (colsEdi == null) {  //no se definió
                return true;  //todas son editable
            } else {  //hay filtro de campos
//alert('verificando: ' + idx);
                for (var i = 0; i < colsEdi.length; i++) {
                    if (idx == colsEdi[i])
                        return true;
                }
                return false;  //no se encontró
            }
        }
    }
    function FijModoNormal(but) {
        $(but).parent().find('#bAcep').hide();
        $(but).parent().find('#bCanc').hide();
        $(but).parent().find('#bEdit').show();
        $(but).parent().find('#bElim').show();
        var $row = $(but).parents('tr');  //accede a la fila
        $row.attr('id', '');  //quita marca
    }
    function FijModoEdit(but) {
        $(but).parent().find('#bAcep').show();
        $(but).parent().find('#bCanc').show();
        $(but).parent().find('#bEdit').hide();
        $(but).parent().find('#bElim').hide();
        var $row = $(but).parents('tr');  //accede a la fila
        $row.attr('id', 'editing');  //indica que está en edición
    }
    function ModoEdicion($row) {
        if ($row.attr('id') == 'editing') {
            return true;
        } else {
            return false;
        }
    }
    function rowAcep(but) {
//Acepta los cambios de la edición
        var $row = $(but).parents('tr');  //accede a la fila
        var $cols = $row.find('td');  //lee campos
        if (!ModoEdicion($row))
            return;  //Ya está en edición
        //Está en edición. Hay que finalizar la edición
        IterarCamposEdit($cols, function ($td) {  //itera por la columnas
            var cont = $td.find('input').val(); //lee contenido del input
            $td.html(cont);  //fija contenido y elimina controles
        });
        FijModoNormal(but);
        params.onEdit($row);
    }
    function rowCancel(but) {
//Rechaza los cambios de la edición
        var $row = $(but).parents('tr');  //accede a la fila
        var $cols = $row.find('td');  //lee campos
        if (!ModoEdicion($row))
            return;  //Ya está en edición
        //Está en edición. Hay que finalizar la edición
        IterarCamposEdit($cols, function ($td) {  //itera por la columnas
            var cont = $td.find('div').html(); //lee contenido del div
            $td.html(cont);  //fija contenido y elimina controles
        });
        FijModoNormal(but);
    }
    function rowEdit(but) {  //Inicia la edición de una fila
        var $row = $(but).parents('tr');  //accede a la fila
        var $cols = $row.find('td');  //lee campos
        if (ModoEdicion($row))
            return;  //Ya está en edición
        //Pone en modo de edición
        IterarCamposEdit($cols, function ($td) {  //itera por la columnas
            var cont = $td.html(); //lee contenido
            var div = '<div style="display: none;">' + cont + '</div>';  //guarda contenido
            var input = '<input class="form-control input-sm"  value="' + cont + '">';
            $td.html(div + input);  //fija contenido
        });
        FijModoEdit(but);
    }
    function rowElim(but) {  //Elimina la fila actual
        var $row = $(but).parents('tr');  //accede a la fila
        params.onBeforeDelete($row);
        $row.remove();
        params.onDelete();
    }
    function rowAddNew(tabId) {  //Agrega fila a la tabla indicada.
        var $tab_en_edic = $("#" + tabId);  //Table to edit
        var $filas = $tab_en_edic.find('tbody tr');
        if ($filas.length == 0) {
            //No hay filas de datos. Hay que crearlas completas
            var $row = $tab_en_edic.find('thead tr');  //encabezado
            var $cols = $row.find('th');  //lee campos
            //construye html
            var htmlDat = '';
            $cols.each(function () {
                if ($(this).attr('name') == 'buttons') {
                    //Es columna de botones
                    htmlDat = htmlDat + colEdicHtml;  //agrega botones
                } else {
                    htmlDat = htmlDat + '<td></td>';
                }
            });
            $tab_en_edic.find('tbody').append('<tr>' + htmlDat + '</tr>');
        } else {
            //Hay otras filas, podemos clonar la última fila, para copiar los botones
            var $ultFila = $tab_en_edic.find('tr:last');
            $ultFila.clone().appendTo($ultFila.parent());
            $ultFila = $tab_en_edic.find('tr:last');
            var $cols = $ultFila.find('td');  //lee campos
            $cols.each(function () {
                if ($(this).attr('name') == 'buttons') {
                    //Es columna de botones
                } else {
                    $(this).html('');  //limpia contenido
                }
            });
        }
        params.onAdd();
    }
    function TableToCSV(tabId, separator) {  //Convierte tabla a CSV
        var datFil = '';
        var tmp = '';
        var $tab_en_edic = $("#" + tabId);  //Table source
        $tab_en_edic.find('tbody tr').each(function () {
            //Termina la edición si es que existe
            if (ModoEdicion($(this))) {
                $(this).find('#bAcep').click();  //acepta edición
            }
            var $cols = $(this).find('td');  //lee campos
            datFil = '';
            $cols.each(function () {
                if ($(this).attr('name') == 'buttons') {
                    //Es columna de botones
                } else {
                    datFil = datFil + $(this).html() + separator;
                }
            });
            if (datFil != '') {
                datFil = datFil.substr(0, datFil.length - separator.length);
            }
            tmp = tmp + datFil + '\n';
        });
        return tmp;
    }

//apply
    $("#table-list").SetEditable({
        $addButton: $('#add')
    });
    function printInvouce(namex) {
        $('#computemmmm').hide();
        printJS({printable: 'invoice_pdfthem', type: 'html', header: namex, maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*'], ignoreElements: ['add', 'computemmmm', 'print_herehe', 'bEdit', 'bElim', 'bAcep', 'bCanc', 'editing']})
    }
</script>