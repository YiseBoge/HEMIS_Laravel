let staffChart;
$(document).ready(function () {
    updateStaffChart();
    let staffG = document.getElementById('staff-graph').getContext('2d');
    staffChart = makeChart(staffG, "bar", "Staff Type", "Staff Members");
    addDataset(staffChart, "Males");
    addDataset(staffChart, "Females", [223, 48, 129]);

    let institutionSelect = $("#staff_institutions");
    let bandSelect = $("#staff_bands");
    let collegeSelect = $("#staff_colleges");
    let departmentSelect = $("#staff_departments");

    institutionSelect.on("change", function (ev) {
        let nodes = [];
        if (institutionSelect.val() != 0) nodes = nodes.concat([bandSelect.parent()]);
        bandSelect.val(0);
        collegeSelect.val(0);
        departmentSelect.val(0);
        updateStaffChart();
        hideAllStaff();
        showNodes(nodes)
    });
    bandSelect.on("change", function (ev) {
        let nodes = [];
        nodes = nodes.concat([bandSelect.parent()]);
        if (bandSelect.val() != 0) nodes = nodes.concat([collegeSelect.parent()]);
        collegeSelect.val(0);
        departmentSelect.val(0);
        updateStaffChart("cols");
        hideAllStaff();
        showNodes(nodes)
    });
    collegeSelect.on("change", function (ev) {
        let nodes = [];
        nodes = nodes.concat([bandSelect.parent(), collegeSelect.parent()]);
        if (collegeSelect.val() != 0) nodes = nodes.concat([departmentSelect.parent()]);
        departmentSelect.val(0);
        updateStaffChart("deps");
        hideAllStaff();
        showNodes(nodes);
    });
    departmentSelect.on("change", function (ev) {
        updateStaffChart();
    });

});

function hideAllStaff() {
    $("#staff_bands").parent().addClass("d-none");
    $("#staff_colleges").parent().addClass("d-none");
    $("#staff_departments").parent().addClass("d-none");
}

function updateStaffChart(toDo = 'nothing') {
    let url = "/api/staff-chart?" + $("#staff-filter").serialize();

    let loader = $("#staff-loading");
    loader.removeClass("d-none");
    $('#staff-graph').css('opacity', 0.3);

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            let staffTypes = response.staff_types;
            let maleStaff = response.male_staffs;
            let femaleStaffs = response.female_staffs;

            let cols = response.colleges;
            let deps = response.departments;

            if (toDo === "cols") {
                $('#staff_colleges').find('option').remove().end().append('<option value="0">Any</option>');
                for (let i = 0; i < cols.length; i++) {
                    $("#staff_colleges").append('<option value=\"' + (i + 1) + '\" selected=\"selected\">' + cols[i] + '</option>')
                }
                $('#staff_colleges').val('0');
            } else if (toDo === "deps") {
                $('#staff_departments').find('option').remove().end().append('<option value="0">Any</option>');
                for (let i = 0; i < deps.length; i++) {
                    $("#staff_departments").append('<option value=\"' + (i + 1) + '\" selected=\"selected\">' + deps[i] + '</option>')
                }
                $('#staff_departments').val('0');
            }
            // console.log(cols);
            // console.log(deps);

            updateChartData(staffChart, staffTypes, "Males", maleStaff);
            updateChartData(staffChart, staffTypes, "Females", femaleStaffs);


            $('#staff-error').addClass('d-none');
            $('#staff-graph').css('opacity', 1);
            $('#staff-graph').removeClass('d-none');
            loader.addClass("d-none");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            loader.addClass("d-none");
            $('#staff-graph').addClass('d-none');
            $('#staff-error').removeClass('d-none');
        }
    });
}