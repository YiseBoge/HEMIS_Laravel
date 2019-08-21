let chart;
$(document).ready(function () {
    updateEnrollmentChart();
    let ctx = document.getElementById('year-enrollment').getContext('2d');
    chart = makeChart(ctx, "line", "Year Level", "Enrollments");
    addDataset(chart, "Males");
    addDataset(chart, "Females", [223,48,129]);

    let institutionSelect = $("#year_enrollment_institutions");
    let bandSelect = $("#year_enrollment_bands");
    let collegeSelect = $("#year_enrollment_colleges");
    let departmentSelect = $("#year_enrollment_departments");
    let programSelect = $("#year_enrollment_programs");
    let levelSelect = $("#year_enrollment_education_levels");

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
    $("#year_enrollment_bands").parent().addClass("d-none");
    $("#year_enrollment_colleges").parent().addClass("d-none");
    $("#year_enrollment_departments").parent().addClass("d-none");
    $("#year_enrollment_programs").parent().addClass("d-none");
    $("#year_enrollment_education_levels").parent().addClass("d-none");
}

function updateEnrollmentChart(toDo = 'nothing') {
    let url = "/api/student-enrollment-chart?" + $("#enrollments-filter").serialize();

    let loader = $("#year-enrollment-loading");
    loader.removeClass("d-none");
    $('#year-enrollment').css('opacity', 0.3);

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            let years = response.year_levels;
            let maleEnrollments = response.male_enrollments;
            let femaleEnrollments = response.female_enrollments;

            let cols = response.colleges;
            let deps = response.departments;

            if (toDo === "cols") {
                $('#year_enrollment_colleges').find('option').remove().end().append('<option value="0">Any</option>');
                for (let i = 0; i < cols.length; i++) {
                    $("#year_enrollment_colleges").append('<option value=\"' + (i + 1) + '\" selected=\"selected\">' + cols[i] + '</option>')
                }
                $('#year_enrollment_colleges').val('0');
            } else if (toDo === "deps") {
                $('#year_enrollment_departments').find('option').remove().end().append('<option value="0">Any</option>');
                for (let i = 0; i < deps.length; i++) {
                    $("#year_enrollment_departments").append('<option value=\"' + (i + 1) + '\" selected=\"selected\">' + deps[i] + '</option>')
                }
                $('#year_enrollment_departments').val('0');
            }
            // console.log(cols);
            // console.log(deps);

            updateChartData(chart, years, "Males", maleEnrollments);
            updateChartData(chart, years, "Females", femaleEnrollments);


            $('#year-enrollment-error').addClass('d-none');
            $('#year-enrollment').css('opacity', 1);
            $('#year-enrollment').removeClass('d-none');
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