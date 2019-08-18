let chart;
$(document).ready(function () {
    updateEnrollmentChart();
    let ctx = document.getElementById('year-enrollment').getContext('2d');
    chart = makeChart(ctx, "line", "Enrollments", "Year Level", "Enrollments");

    let institutionSelect = $("#institution");
    let bandSelect = $("#band");
    let collegeSelect = $("#college");
    let departmentSelect = $("#department");
    let programSelect = $("#program");
    let levelSelect = $("#education_level");

    institutionSelect.on("change", function (ev) {
        let nodes = [];
        if (institutionSelect.val() != 0) nodes = nodes.concat([bandSelect.parent()]);
        bandSelect.val(0);
        collegeSelect.val(0);
        departmentSelect.val(0);
        programSelect.val(0);
        levelSelect.val(0);
        updateEnrollmentChart();
        showNodes(nodes)
    });
    bandSelect.on("change", function (ev) {
        let nodes = [];
        nodes = nodes.concat([bandSelect.parent()]);
        if (bandSelect.val() != 0) nodes = nodes.concat([collegeSelect.parent()]);
        collegeSelect.val(0);
        departmentSelect.val(0);
        programSelect.val(0);
        levelSelect.val(0);
        updateEnrollmentChart("cols");
        showNodes(nodes)
    });
    collegeSelect.on("change", function (ev) {
        let nodes = [];
        nodes = nodes.concat([bandSelect.parent(), collegeSelect.parent()]);
        if (collegeSelect.val() != 0) nodes = nodes.concat([departmentSelect.parent(), programSelect.parent(), levelSelect.parent()]);
        departmentSelect.val(0);
        programSelect.val(0);
        levelSelect.val(0);
        updateEnrollmentChart("deps");
        showNodes(nodes);
    });
    departmentSelect.on("change", function (ev) {
        updateEnrollmentChart();
    });
    programSelect.on("change", function (ev) {
        updateEnrollmentChart()
    });
    levelSelect.on("change", function (ev) {
        updateEnrollmentChart()
    })

});

function showNodes(nodes) {
    hideAll();
    for (let i = 0; i < nodes.length; i++) {
        nodes[i].removeClass("d-none")
    }
}

function hideAll() {
    $("#band").parent().addClass("d-none");
    $("#college").parent().addClass("d-none");
    $("#department").parent().addClass("d-none");
    $("#program").parent().addClass("d-none");
    $("#education_level").parent().addClass("d-none");
}

function updateEnrollmentChart(toDo = 'nothing') {
    let url = "/api/student-enrollment-chart?" + $("#enrollmentsFilter").serialize();

    let loader = $("#loading");
    loader.removeClass("d-none");
    $('#year-enrollment').css('opacity', 0.3);

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            let years = response.year_levels;
            let enrollments = response.enrollments;
            let cols = response.colleges;
            let deps = response.departments;

            if (toDo === "cols") {
                $('#college').find('option').remove().end().append('<option value="0">Any</option>');
                for (let i = 0; i < cols.length; i++) {
                    $("#college").append('<option value=\"' + (i + 1) + '\" selected=\"selected\">' + cols[i] + '</option>')
                }
                $('#college').val('0');
            } else if (toDo === "deps") {
                $('#department').find('option').remove().end().append('<option value="0">Any</option>');
                for (let i = 0; i < deps.length; i++) {
                    $("#department").append('<option value=\"' + (i + 1) + '\" selected=\"selected\">' + deps[i] + '</option>')
                }
                $('#department').val('0');
            }
            // console.log(cols);
            // console.log(deps);

            updateChartData(chart, years, enrollments);


            $('#year-enrollment-error').addClass('d-none');
            $('#year-enrollment').removeClass('d-none');
            $('#year-enrollment').css('opacity', 1);
            loader.addClass("d-none");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            loader.addClass("d-none");
            $('#year-enrollment').addClass('d-none');
            $('#year-enrollment-error').removeClass('d-none');
        }
    });
}