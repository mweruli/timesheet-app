<script>
    /**
     * highlightRow and highlight are used to show a visual feedback. If the row has
     * been successfully modified, it will be highlighted in green. Otherwise, in
     * red
     */
    function highlightRow(rowId, bgColor, after) {
        var rowSelector = $("#" + rowId);
        rowSelector.css("background-color", bgColor);
        rowSelector.fadeTo("normal", 0.5, function () {
            rowSelector.fadeTo("fast", 1, function () {
                rowSelector.css("background-color", '');
            });
        });
    }

    function highlight(div_id, style) {
        highlightRow(div_id, style == "error" ? "#e5afaf"
                : style == "warning" ? "#ffcc00" : "#8dc70a");
    }

    function message(type, message) {
        $('#message').html(
                "<div class=\"notification  " + type + "\">" + message + "</div>")
                .slideDown('normal').delay(1800).slideToggle('slow');
    }

    /**
     * updateCellValue calls the PHP script that will update the database.
     */
    function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue,
            newValue, row, onResponse) {
        $
                .ajax({
                    url: '<?= base_url() ?>company/updatebranch',
                    type: 'POST',
                    dataType: "html",
                    data: {
                        tablename: editableGrid.name,
                        id: editableGrid.getRowId(rowIndex),
                        newvalue: editableGrid.getColumnType(columnIndex) == "boolean" ? (newValue ? 1
                                : 0)
                                : newValue,
                        colname: editableGrid.getColumnName(columnIndex),
                        coltype: editableGrid.getColumnType(columnIndex)
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (XMLHttpRequest, textStatus, exception) {
                        $.notify('Error When Updating Timesheet', "error");
                        // alert("Ajax failure\n" + textStatus);
                    },
                    async: true
                });

    }

    function DatabaseGrid(tablename, tableidcontent) {
        console.log(tablename);
        this.editableGrid = new EditableGrid(tablename,
                {
                    enableSort: true,
                    /* Comment this line if you set serverSide to true */
                    // define the number of row visible by page
                    /* pageSize: 50, */

                    /* This property enables the serverSide part */
                    serverSide: true,
                    // Once the table is displayed, we update the paginator state
                    tableRendered: function () {
                        updatePaginator(this);
                    },
                    tableLoaded: function () {
                        datagrid.initializeGrid(this, tableidcontent);
                    },
                    modelChanged: function (rowIndex, columnIndex, oldValue,
                            newValue, row) {
                        updateCellValue(this, rowIndex, columnIndex, oldValue,
                                newValue, row);
                    }
                });
        this.fetchGrid();
        $("#filter")
                .val(
                        this.editableGrid.currentFilter != null ? this.editableGrid.currentFilter
                        : "");
        if (this.editableGrid.currentFilter != null
                && this.editableGrid.currentFilter.length > 0)
            $("#filter").addClass('filterdefined');
        else
            $("#filter").removeClass('filterdefined');

    }

    DatabaseGrid.prototype.fetchGrid = function () {
        // call a PHP script to get the data
        var self = this;
        this.editableGrid.loadJSON("<?= base_url() ?>company/loadbranch/" + self.editableGrid.name);
    };

    DatabaseGrid.prototype.initializeGrid = function (grid, tableidcontent) {
        var self = this;
        // render for the action column
        grid.setCellRenderer("action", new CellRenderer({
            render: function (cell, id) {
                cell.innerHTML += "<i onclick=\"datagrid.deleteRow(" + id
                        + ");\" class='fa fa-trash-o red' ></i>";
            }
        }));

        grid.renderGrid(tableidcontent, "testgrid");

    };

    DatabaseGrid.prototype.deleteRow = function (id) {
        var self = this;
        if (confirm('Are you sure you want to delete this  entry at ' + id)) {
            $.ajax({
                url: '<?= base_url() ?>company/delete',
                type: 'POST',
                dataType: "html",
                data: {
                    tablename: self.editableGrid.name,
                    id: id
                },
                success: function (response) {
//                console.log(response);
                    $.notify('Record Successfully Deleted', "info");
//                    // message("success", "Row deleted");
                    self.fetchGrid();
                },
                error: function (XMLHttpRequest, textStatus, exception) {
                    alert("Ajax failure\n" + errortext);
                },
                async: true
            });
        }

    };
    DatabaseGrid.prototype.addRow = function (id) {
        var self = this;
        $.ajax({
            url: '<?= base_url() ?>ts/add',
            type: 'POST',
            dataType: "html",
            data: {
                tablename: self.editableGrid.name,
                client_id: $("#client").val(),
                user_task_id: $("#user_task").val()
            },
            success: function (response) {
                if (response == "ok") {
                    // hide form
                    showAddForm();
                    $("#client").val('');
                    $("#user_task").val('');
                    $.notify('Record Added Successfully', "success");
                    // message("success", "Row added : reload model");
                    self.fetchGrid();
                } else
                    message("error", "Error occured");
            },
            error: function (XMLHttpRequest, textStatus, exception) {
                alert("Ajax failure\n" + errortext);
            },
            async: true
        });

    };
// Load Users For Editing Start
// Load Users For Editing End
    function updatePaginator(grid, divId) {
        divId = divId || "paginator";
        var paginator = $("#" + divId).empty();
        var nbPages = grid.getPageCount();

        // get interval
        var interval = grid.getSlidingPageInterval(20);
        if (interval == null)
            return;
        // get pages in interval (with links except for the current page)
        var pages = grid.getPagesInInterval(interval,
                function (pageIndex, isCurrent) {
                    if (isCurrent)
                        return "<span id='currentpageindex'>" + (pageIndex + 1)
                                + "</span>";
                    return $("<a>").css("cursor", "pointer").html(pageIndex + 1)
                            .click(function (event) {
                                grid.setPageIndex(parseInt($(this).html()) - 1);
                            });
                });

        // "first" link
        var link = $("<a class='nobg'>")
                .html("<i class='fa fa-fast-backward'></i>");
        if (!grid.canGoBack())
            link.css({
                opacity: 0.4,
                filter: "alpha(opacity=40)"
            });
        else
            link.css("cursor", "pointer").click(function (event) {
                grid.firstPage();
            });
        paginator.append(link);

        // "prev" link
        link = $("<a class='nobg'>").html("<i class='fa fa-backward'></i>");
        if (!grid.canGoBack())
            link.css({
                opacity: 0.4,
                filter: "alpha(opacity=40)"
            });
        else
            link.css("cursor", "pointer").click(function (event) {
                grid.prevPage();
            });
        paginator.append(link);

        // pages
        for (p = 0; p < pages.length; p++)
            paginator.append(pages[p]).append(" ");

        // "next" link
        link = $("<a class='nobg'>").html("<i class='fa fa-forward'>");
        if (!grid.canGoForward())
            link.css({
                opacity: 0.4,
                filter: "alpha(opacity=40)"
            });
        else
            link.css("cursor", "pointer").click(function (event) {
                grid.nextPage();
            });
        paginator.append(link);

        // "last" link
        link = $("<a class='nobg'>").html("<i class='fa fa-fast-forward'>");
        if (!grid.canGoForward())
            link.css({
                opacity: 0.4,
                filter: "alpha(opacity=40)"
            });
        else
            link.css("cursor", "pointer").click(function (event) {
                grid.lastPage();
            });
        paginator.append(link);
    }
    ;

</script>