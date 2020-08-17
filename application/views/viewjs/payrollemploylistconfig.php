<script>
    var getmetable;
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
                    url: '<?= base_url("payroll/updatebranchemployeemange") ?>',
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

    function DatabaseGrid(tablename, tableidcontent, pignatorid, statecustom = null) {
//        console.log(tablename);
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
        this.fetchGrid(tablename, statecustom);
        $("#filter")
                .val(
                        this.editableGrid.currentFilter !== null ? this.editableGrid.currentFilter
                        : "");
        if (this.editableGrid.currentFilter !== null
                && this.editableGrid.currentFilter.length > 0)
            $("#filter").addClass('filterdefined');
        else
            $("#filter").removeClass('filterdefined');
        getmetable = this;
    }
    DatabaseGrid.prototype.fetchGrid = function (tablename, statecustom) {
        // call a PHP script to get the data
        var self = this;
        if (statecustom === '' || statecustom === null) {
            tablename = self.editableGrid.name;
            this.editableGrid.loadJSON("<?= base_url() ?>payroll/loademployeesbybranch/" + tablename);
        } else {
            this.editableGrid.loadJSON("<?= base_url() ?>payroll/loademployeescustome/" + tablename);
        }
//        console.log(tablename + ' @ ' + statecustom);
    };
//    DatabaseGrid.prototype.loadCustomeParams = function (tablename) {
//        getmetable.editableGrid.loadJSON('<?= base_url() ?>utilcontroller/loadtablesintable/' + tablename);
//    };
    DatabaseGrid.prototype.initializeGrid = function (grid, tableidcontent) {
        var self = this;
        // render for the action column
        grid.setCellRenderer("action", new CellRenderer({
            render: function (cell, id) {
                cell.innerHTML += "<i onclick=\"datagrid.loadProfile(" + id
                        + ");\" class='fa fa-cog fa-spin red' ></i>";
            }
        }));
        grid.setCellRenderer("proceed", new CellRenderer({
            render: function (cell, id) {
                cell.innerHTML += "<i onclick=\"datagrid.loadLoan(" + id
                        + ");\" class='fa fa-location-arrow red' ></i>";
            }
        }));
        grid.renderGrid(tableidcontent, "testgrid");
    };
    DatabaseGrid.prototype.loadProfile = function (id) {
        sessionStorage.setItem("useridpayroll", id);
        postToURL("<?= base_url('payroll/go/1/') ?>" + id);

    };
    DatabaseGrid.prototype.loadLoan = function (id) {
        sessionStorage.setItem("useridpayrollloan", id);
        postToURL("<?= base_url('payroll/go/1/') ?>" + id);
    };
    function postToURL(a) {
        document.getElementById("payrollform").action = a;
        document.getElementById("payrollform").submit();
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
        if (interval == null)
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