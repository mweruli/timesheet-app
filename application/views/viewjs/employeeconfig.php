<script>
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
        highlightRow(div_id, style === "error" ? "#e5afaf"
                : style === "warning" ? "#ffcc00" : "#8dc70a");
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
                    url: '<?= base_url("company/updatebranchemployeemange") ?>',
                    type: 'POST',
                    dataType: "html",
                    data: {
                        tablename: editableGrid.name,
                        id: editableGrid.getRowId(rowIndex),
                        newvalue: editableGrid.getColumnType(columnIndex) === "boolean" ? (newValue ? 1
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
    var dems = 0;
    function DatabaseGrid(tablename, tableidcontent, pignatorid) {
//        console.log(tableidcontent);
        dems = tableidcontent;
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
                        updatePaginator(this, pignatorid);
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
                        this.editableGrid.currentFilter !== null ? this.editableGrid.currentFilter
                        : "");
        if (this.editableGrid.currentFilter !== null
                && this.editableGrid.currentFilter.length > 0)
            $("#filter").addClass('filterdefined');
        else
            $("#filter").removeClass('filterdefined');

    }
    DatabaseGrid.prototype.deleteRow = function (id) {
        var self = this;
        if (confirm('Are you sure you want to Delete This User At Entry ' + id)) {
            $.ajax({
                url: '<?= base_url() ?>company/staffdelete',
                type: 'POST',
                dataType: "html",
                data: {
                    tablename: 'employeeprofile',
                    id: id
                },
                success: function (response) {
                    console.log(response);
//                    $.notify('Record Successfully Deleted', "info");
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
    DatabaseGrid.prototype.restorRow = function (id) {
        var self = this;
        if (confirm('Are you sure you want to Restore This User At Entry ' + id)) {
            $.ajax({
                url: '<?= base_url() ?>company/staffrestore',
                type: 'POST',
                dataType: "html",
                data: {
                    tablename: 'usersjunk',
                    id: id
                },
                success: function (response) {
                    console.log(response);
//                    $.notify('Record Successfully Deleted', "info");
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
    DatabaseGrid.prototype.fetchGrid = function () {
        // call a PHP script to get the data
        var self = this;
        if (dems === "tablecontentemployeetwo") {
            this.editableGrid.loadJSON("<?= base_url() ?>company/loademployeesbybranch_junk/" + self.editableGrid.name);
        } else {
            this.editableGrid.loadJSON("<?= base_url() ?>company/loademployeesbybranch/" + self.editableGrid.name);
        }
//        console.log(self.editableGrid.name + ' what is this?');
    };

    DatabaseGrid.prototype.initializeGrid = function (grid, tableidcontent) {
        var self = this;
        // render for the action column
        grid.setCellRenderer("action", new CellRenderer({
            render: function (cell, id) {
                cell.innerHTML += "<i onclick=\"datagrid.loadProfile(" + id
                        + ");\" class='fa fa-cog fa-spin red' ></i>";
            }
        }));
        grid.setCellRenderer("delete", new CellRenderer({
            render: function (cell, id) {
                cell.innerHTML += "<i onclick=\"datagrid.deleteRow(" + id
                        + ");\" class='fa fa-times red' ></i>";
            }
        }));
        grid.setCellRenderer("restore", new CellRenderer({
            render: function (cell, id) {
                cell.innerHTML += "<i onclick=\"datagrid.restorRow(" + id
                        + ");\" class='fa fa-mail-reply red' ></i>";
            }
        }));
        grid.renderGrid(tableidcontent, "testgrid");
    };

    DatabaseGrid.prototype.loadProfile = function (id) {
//        sessionStorage.removeItem("useridprofile");
        sessionStorage.setItem("useridprofile", id);
//        var l = document.getElementById('link_tab_addclient');
//        l.click();
        postToURL("<?= base_url('humanr/go/1/') ?>" + id);
    };
    function postToURL(a) {
        document.getElementById("useridform").action = a;
//        document.getElementById("donaldduck").name = b;
//        document.getElementById("donaldduck").value = c;
        document.getElementById("useridform").submit();
    }
    DatabaseGrid.prototype.addRow = function (id) {};
// Load Users For Editing Start
// Load Users For Editing End
    function updatePaginator(grid, divId) {
        console.log(divId);
        divId = divId || "paginator";
        var paginator = $("#" + divId).empty();
        var nbPages = grid.getPageCount();

        // get interval
        var interval = grid.getSlidingPageInterval(20);
        if (interval === null)
            return;
        // get pages in interval (with links except for the current page)
        var pages = grid.getPagesInInterval(interval,
                function (pageIndex, isCurrent) {
                    if (isCurrent)
                        return "<span class='paginator currentpageindex'>" + (pageIndex + 1)
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